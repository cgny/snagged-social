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

    function createStripeCustomer( $email = "", $stripe = "")
    {
        if(empty($stripe))
        {
            $stripe = new \Stripe\Stripe;
            $stripe->setApiKey(STRIPE_SECRET_TEST_KEY);
        }

        $account = $this->account->getAccountById( $this->account->isLogged() );
        if(empty($account))
        {
            return false;
        }

        if(empty($email))
        {
            $email = $account->a_email;
        }

        if(!empty($account) && !empty($account->a_first_name) && !empty($account->a_last_name))
        {
            $description = $account->a_first_name.' '.$account->a_last_name;
        }
        else
        {
            $cart = $this->cart->getCart()->row();
            if(!empty( $cart->uc_full_name ))
            {
                $description = $cart->uc_full_name;
            }
            else
            {
                $description = $account->a_ig_username;
            }
        }

        $cust = new \Stripe\Customer();

        try{
            if(!empty($account->stripe_id))
            {
                //update customer
                $cu = \Stripe\Customer::retrieve( $account->stripe_id );
                $cu->description = $description;
                $cu->email = $email;
                $cu->save();
            }
            else
            {
                //create customer
                $customer = $cust->create(
                    array(
                        'email'         => $email,
                        'description'   => $description,
                    )
                );

                $this->account->updateAccount($account->a_id,
                    array(
                        'stripe_id' => $customer->id
                    )
                );
            }
            $success = true;
            $error = false;
        }
        catch (Exception $e)
        {
            $success = $customer = false;
            $error = $e->getMessage();
        }
        return array(
            "customer"  => $customer,
            "success"  => $success,
            "error"     => $error
        );
    }
	
	function createStripeAccount( $email, $name_on_card, $ssn_last_4 = "", $stripe = "" )
	{
	    if(empty($stripe))
        {
            $stripe = new \Stripe\Stripe;
            $stripe->setApiKey(STRIPE_SECRET_TEST_KEY);
        }

		$account = $this->account->getAccountById( $this->account->isLogged() );

        $exp_name = explode(" ",$name_on_card);
        $first_name = $exp_name[0];
        unset($exp_name[0]);
        $last_name = implode(" ",$exp_name);

        $ssn_last_4 = (empty($ssn_last_4)) ? null : $ssn_last_4;

		$acct = new \Stripe\Account;
		$acct_array = array(
            'email' => $email,
            'country' => $account->a_country,
            'type' => 'custom',
            'business_name' => $account->a_business_name,
            'business_url' => $account->business_url,
            'legal_entity' => array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'ssn_last_4' => $ssn_last_4,
                'phone_number' => $account->a_phone,
                'address' => array(
                    'line1' => $account->a_address_1,
                    'line2' => $account->a_address_2,
                    'city' => $account->a_city,
                    'state' => $account->a_state,
                    'postal_code' => $account->a_postal_code,
                ),
                'type' => "individual",
                'dob' => array(
                    'month' => $account->a_dob_m,
                    'day' => $account->a_dob_d,
                    'year' => $account->a_dob_y,
                ),
                'business_tax_id' => $account->a_tax_id,
                'business_vat_id' => $account->a_vat_id,

            ),
            'default_currency' => $account->a_currency,
        );

		try {
            $new_account = $acct->create(
                $acct_array
            );

            $acct = \Stripe\Account::retrieve( $new_account->id );
            $acct->tos_acceptance->date = time();
            $acct->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];
            $acct->save();

            $this->account->updateAccount($account->a_id,
                array(
                    'stripe_user_id' => $new_account->id
                )
            );
            $success = true;
            $error = false;
        }
        catch (Exception $e)
        {
            $success = $account = false;
            $error = $e->getMessage();
        }

        return array(
            "account"   => $account,
            "success"   => $success,
            "error"     => $error,
            "acct"      => $acct_array
        );
	}

    function updateStripeAccount( $stripe = "" )
    {
        if(empty($stripe))
        {
            $stripe = new \Stripe\Stripe;
            $stripe->setApiKey(STRIPE_SECRET_TEST_KEY);
        }

        $account = $this->account->getAccountById( $this->account->isLogged() );

        try {
            $acct = \Stripe\Account::retrieve($account->stripe_user_id);
        }
        catch (Exception $e)
        {
            throw new Exception("Account Not Found");
        }

        try{
            if(!empty($account->a_email))
            {
                $acct->email = $account->a_email;
            }

            if(!empty($account->business_name))
            {
                $acct->business_name = $account->business_name;
            }

            if(!empty($account->business_url))
            {
                $acct->business_url = $account->business_url;
            }

            if(!empty($account->a_phone))
            {
                $acct->legal_entity->phone_number = $account->a_phone;
            }

            if(!empty($account->a_tax_id))
            {
                $acct->legal_entity->business_tax_id = $account->a_tax_id;
            }

            if(!empty($account->a_address_1))
            {
                $acct->legal_entity->address->line1 = $account->a_address_1;
            }

            if(!empty($account->a_address_2))
            {
                $acct->legal_entity->address->line2 = $account->a_address_2;
            }

            if(!empty($account->a_city))
            {
                $acct->legal_entity->address->city = $account->a_city;
            }

            if(!empty($account->a_state))
            {
                $acct->legal_entity->address->state = $account->a_state;
            }

            if(!empty($account->a_postal_code))
            {
                $acct->legal_entity->address->postal_code = $account->a_postal_code;
            }

            if(!empty($account->a_country))
            {
                $acct->legal_entity->address->country = $account->a_country;
            }

            $acct->save();

            $account = true;
            $success = true;
            $error = false;
        }
        catch (Exception $e)
        {
            $error = $e->getMessage();
            $this->error->logError( __FILE__, __LINE__, __FUNCTION__, $error);
            $success = $account = false;
        }

        return array(
            "account"   => $account,
            "success"   => $success,
            "error"     => $error
        );
    }

	function processPayment($token, $amount, $stripe_email = "")
    {
        $stripe = new \Stripe\Stripe;
        $stripe->setApiKey(STRIPE_SECRET_TEST_KEY);

        $account = $this->account->getAccountById($this->account->isLogged(true));

        if (!empty($account)) {
            if (!empty($account->stripe_id)) {
                $create_charge['customer'] = $account->stripe_id;
            }

        } else {
            try {
                if (!empty($stripe_email)) {
                    $this->createStripeCustomer($stripe_email);
                }
            } catch (Exception $e) {
                $this->error->logError( __FILE__, __LINE__, __FUNCTION__, $e->getMessage());
                //print_r($e->getMessage());
            }
        }

        $create_charge = array(
            "amount" => ($amount * 100), //remove decimal
            "currency" => "usd",
            "source" => $token, // obtained with Stripe.js
            'description' => 'Snagged Social Order'
        );

        try {
            $charge = new \Stripe\Charge;
            $status = $charge->create(
                $create_charge
            );
            $code = false;
        } catch (Exception $e) {
            $status = new stdClass();
            $code = $status->failure_code = $e->getMessage();
        }


        $status->cart_id = $this->cart->getCartId();

        if (empty($status->failure_code)) {
            $this->cart->updateMasterCart(array('uc_email' => $stripe_email, 'uc_status' => 2));
            // update user cart set paid
            $this->cart->updateStatus(array('status' => 2, 'payment_date' => date("Y-m-d H:i:s")));
            // update cart set paid
            $this->cart->updateCart(array('c_status' => 2, 'c_payment_date' => date("Y-m-d H:i:s")));
            //send recept
            $this->cart->emailReceipt($status->cart_id);
            //prepare payouts to artists
            $cart = $this->cart->getCart()->result();
            //print_r($cart);
            $payout = true;

            foreach ($cart as $item) {
                $photo = $this->account->getPhotoOnAccount($item->c_p_id);
                $pay = (($item->c_qty * $photo->p_price) - (($item->c_qty * $photo->p_price) * BUSINESS_FEE));
                if ($payout) {
                    $transfer_err = "";
                    try {
                        if (!empty($photo->stripe_user_id)) {
                            $payout = $this->sendPayout($pay, $photo->stripe_user_id, $photo->p_price . " x " . $item->c_qty . " ID " . $item->c_p_id, $photo->a_currency);
                            if (empty($payout)) {
                                $success = false;
                            } else {
                                $success = true;
                            }
                        } else {
                            $this->sendMissingStripeIdEmail($photo->stripe_user_id);
                        }
                    } catch (Exception $e) {
                        $transfer_err = $e->getMessage();
                        $success = -1;
                        $status->failure_message[] = $photo->stripe_user_id . '|' . $e->getMessage();
                        $this->error->sendError(__FILE__, __LINE__, $e->getMessage());
                    }
                    $this->logPayout($item->uc_id, $pay, $item->p_a_id, $item->c_p_id, $item->c_id, $item->c_qty, $success, $transfer_err, $photo->stripe_user_id);
                }
            }

            // make new cart id
            $this->cart->getCartId(true);

        }
        else
        {
            $this->cart->updateMasterCart(array('uc_notes' => $code));
        }
        return $status;
	}
	
        function sendPayout($amount, $stripe_id, $description, $currency = "usd")
        {
            $payout = new \Stripe\Transfer;
            $payout->create(
                [
                    "amount" => ($amount*100),
                    "currency" => $currency,
                    "destination" => $stripe_id,
                    "description" => $description
                ]
            );

            if(empty($payout))
            {
                $this->error->logError( __FILE__, __LINE__, __FUNCTION__, "Unsuccessul Transfer", $stripe_id);
                throw new Exception("Unsuccessul Transfer");
            }

            return $payout;
        }
	
        function logPayout($cart_id, $amount, $account_id, $photo_id, $item_cart_id, $qty, $success, $transfer_err, $ap_stripe_id="")
        {
            $insert = array(
                "ap_a_id"       => $account_id,
                "ap_uc_id"      => $cart_id,
                "ap_c_id"       => $item_cart_id,
                "ap_p_id"       => $photo_id,
                "ap_qty"        => $qty,
                "ap_amount"     => $amount,
                "ap_stripe_id"  => $ap_stripe_id,
                "ap_success"    => $success,
                "ap_error"      => $transfer_err
            );
            $this->db->insert("ss_payments",$insert);
            $this->error->dbError(false, __FILE__, __LINE__, __FUNCTION__, $insert);
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