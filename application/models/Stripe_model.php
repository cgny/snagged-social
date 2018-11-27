<?php
/**
 * Created by PhpStorm.
 * User: cgibbs
 * Date: 12/13/17
 * Time: 7:14 PM
 */

include STRIPE_LIB;

class Stripe_model extends CI_Model{

    function getAccountByStripeId($stripe_id)
    {
        $this->db->where('stripe_id', $stripe_id);
        return $this->db->get('ss_accounts')->row();
    }
	
	function createStripeAccount($email, $country)
	{
		$stripe = new \Stripe\Stripe;
		$stripe->setApiKey(STRIPE_SECRET_TEST_KEY);

		$account = $this->account->getAccountById( $this->account->isLogged() );
                
                if(!empty($account))
                {
                    $description = $account->a_first_name.' '.$account->a_last_name;
                }
                else 
                {
                    $cart = $this->cart->getCart()->row();
                    $description = $cart->uc_full_name;
                }

		$acct = new \Stripe\Account;
		return $acct->create(
			array(
				'email'         => $email,
				'description'   => $description,
                'country'       => $country,
                'type'          => 'custom'
			)
		);
	}

	function processPayment($token, $amount, $country, $stripe_email = "")
	{
		$stripe = new \Stripe\Stripe;
		$stripe->setApiKey(STRIPE_SECRET_TEST_KEY);

		$account = $this->account->getAccountById( $this->account->isLogged(true) );
		
		if(!empty($account))
		{
			if(!empty($account->stripe_id))
			{
				$create_charge['customer'] = $account->stripe_id;
			}
						
		}
		else
		{
            try{
				if(!empty($stripe_email))
				{
					$this->createStripeAccount( $stripe_email, $country );
				}
			}
			catch(Exception $e)
			{
				$this->error->sendError(__FILE__,__LINE__,$e->getMessage());
				//print_r($e->getMessage());
			}
		}
                
		$create_charge = array(
			"amount" => ( $amount * 100), //remove decimal
			"currency" => "usd",
			"source" => $token, // obtained with Stripe.js
			'description' => 'Snagged Social Order'
		);
		
		try{
			$charge = new \Stripe\Charge;
			$status = $charge->create(
				$create_charge
			);
		}
		catch(Exception $e)
		{
		    $status = new stdClass();
			$status->failure_code = $e->getMessage();
		}                
                
                
		$status->cart_id = $this->cart->getCartId();
                
		if(empty($status->failure_code))
		{
                        $this->cart->updateCart(array('uc_email' => $stripe_email));
                        // update cart set paid
						$this->cart->updateStatus(array('status' => 2, 'uc_payment_date' => date("Y-m-d")));
						//send recept
						$this->cart->emailReceipt($status->cart_id);			
						//prepare payouts to artists
						$cart = $this->cart->getCart()->result();
                        //print_r($cart);
                        $payout = true;
			
			foreach($cart as $item)
			{
				$photo = $this->account->getPhotoOnAccount($item->c_p_id);
				$pay = (($item->c_qty * $photo->p_price) - (($item->c_qty * $photo->p_price) * BUSINESS_FEE ));
				if($payout)
				{
					try
					{
						if(!empty($photo->stripe_user_id))
						{
                            $payout = $this->sendPayout($pay, $photo->stripe_user_id, "PHOTO :" .$item->c_p_id, $photo->a_currency);
                            if($payout !== true)
                            {
                                $success = false;
                            }
                            else
                            {
                                $success = true;
                            }
						}
						else
						{
							$this->sendMissingStripeIdEmail($photo->stripe_user_id);
						}
					}
					catch(Exception $e)
					{
                        $success = -1;												
                        $this->sendMissingStripeIdEmail($photo->stripe_user_id);
						$status->failure_message[] = $photo->stripe_user_id . '|' . $e->getMessage();
						$this->error->sendError(__FILE__,__LINE__,$e->getMessage());
					}
					$this->logPayout($pay, $item->c_a_id, $item->c_p_id, $item->uc_id, $item->c_qty, $success, $photo->stripe_user_id);
				}
			}
			
			// make new cart id
			$this->cart->getCartId(true);
			return $status;
		}
		else
		{
			return $status->failure_code;
		}
	}
	
        function sendPayout($amount, $stripe_id, $description, $currency = "usd")
        {
            $payout = new \Stripe\Transfer;
            try{
                $payout->create(
                    [
                        "amount" => ($amount*100),
                        "currency" => $currency,
                        "destination" => $stripe_id,
                        "description" => $description
                    ]
                );
                return true;
            }catch (Exception $e)
            {
                return $e->getMessage();
            }

            return false;
        }
	
        function logPayout($amount,$account_id,$photo_id,$cart_id,$qty,$success,$ap_stripe_id="")
        {
            $insert = array(
                "ap_a_id" => $account_id,
                "ap_c_id" => $cart_id,
                "ap_p_id" => $photo_id,
                "ap_qty" => $qty,
                "ap_amount" => $amount,
                "ap_stripe_id" => $ap_stripe_id,
                "ap_success" => $success
            );
            $this->db->insert("ss_payments",$insert);
        }
        
        function sendMissingStripeIdEmail($account_id)
        {
            
            $this->load->library('email');
            
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['mailtype'] = "html";

            $this->email->initialize($config);


            $this->email->to('contact@snaggedsocial.com');
            $this->email->from('contact@snaggedsocial.com','Snagged Social');

            $this->email->subject('Payout not sent');
            $this->email->message('There was no stripe id for account - '. $account_id);
            if(!$this->email->send()){
               // print_r($this->email->print_debugger());
            }
        }
        
        function findMissingStripePayments()
        {
            return $this->db->query("SELECT * FROM ss_payments WHERE ap_stripe_id = '' ORDER BY ap_paid_date ")->result();
        }
        
        function authorizeAccount($code)
        {
            if(empty($code))
            {
                return;
            }
            $ch = curl_init("https://connect.stripe.com/oauth/token?client_secret=". STRIPE_SECRET_TEST_KEY ."&code=$code&grant_type=authorization_code");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);       
            curl_close($ch);
            
            $data = json_decode($output);
            
            if(isset($data->error_description))
            {
                echo $data->error_description;
                //exit;
            }
            
            $this->account->updateAccount($this->account->isLogged(), 
                array(
                    'stripe_user_id'        => $data->stripe_user_id,
                    'stripe_refresh_token'  => $data->refresh_token,
                    'stripe_access_token'   => $data->access_token
                )
            );
            
        }


}