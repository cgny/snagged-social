<?php

class Account_model extends CI_Model{
	
	function isLogged($allow = false)
	{
		if(isset($this->session->userdata['user_id']))
		{
			return $this->session->userdata['user_id'];
		}
		if($allow)
		{
			if(!isset($this->session->userdata['false_id']))
			{
				$this->session->userdata['false_id'] = substr(preg_replace('/\D/', '', md5( time() )),0,7);
			}
			return $this->session->userdata['false_id'];
		}
		return false;
	}

	function checkUri()
	{
		$uri = uri_string();
		if(stristr($uri,'auth') || stristr($uri,'login') || stristr($uri,'logout'))
		{
			return true;
		}
		return false;
	}

	function getUser($user_id = false)
	{
		$data = $this->session->userdata;

		if(empty($user_id))
		{
			$user_id = $data['user']->id;
		}

        $user_id = $this->data->cleanData( $user_id );

		$this->db->where('a_ig_id',$user_id);
		return $this->db->get('ss_accounts')->row();
	}

	function getAllAccounts($limit = false)
	{
		if($limit)
		{
            $limit = $this->data->cleanData( $limit );
			$this->db->limit($limit);
			$this->db->order_by('a_id',"desc");
		}
		return $this->db->get('ss_accounts')->result();
	}

	function saveAccount()
	{
		$this->session->userdata['user']->admin = 0;
		$data = $this->session->userdata;
		$this->db->where('a_ig_id',$data['user']->id);
		$user = $this->db->get('ss_accounts');
		if($user->num_rows() == 1)
		{
			$this->db->where('a_ig_id',$data['user']->id);
			$account = array(
				"a_ig_username" => $data['user']->username,
				"a_ig_profile" => $data['user']->profile_picture,
				"a_ig_bio" => $data['user']->bio,
				"a_token" => $data['token']
			);
			$this->db->update('ss_accounts',$account);
			$this->error->dbError();
			$this->session->userdata['user']->admin = $user->row()->a_admin;
			return $user->row()->a_id;
		}
		$account = array(
			"a_ig_id" => $data['user']->id,
			"a_ig_username" => $data['user']->username,
			"a_password" => $this->genPassword(),
			"a_ig_profile" => $data['user']->profile_picture,
			// "a_email" => "$data['user']->email",
			"a_ig_bio" => $data['user']->bio,
			"a_token" => $data['token'],
			"a_last_login" => gmdate("Y-m-d H:i:s"),
			"a_created" => gmdate("Y-m-d H:i:s")
		);
		$this->db->insert('ss_accounts',$account);
		$ins =  $this->db->insert_id();
        $this->error->dbError();
        return $ins;
	}

	function addCard($stripeToken,$last4,$account_id)
	{
        $stripe = new \Stripe\Stripe;
        $stripe->setApiKey(STRIPE_SECRET_TEST_KEY);
		$acct_info = $this->getAccountById($account_id);

        $result['success'] = false;
        $result['error']['message'] = true;
        $result['error']['code'] = -1;

		if(empty($acct_info->stripe_id)){

			try{
                $result['error']['message'] = "No email";
				if( !empty($acct_info->a_email) )
				{
                    $customer = $this->stripe->createStripeAccount( $acct_info->a_email, $stripe );

                    $cu = \Stripe\Customer::retrieve($acct_info->stripe_id);
                    $var = $cu->sources->create(array("card" => $stripeToken));
                    $card = $var['id'];
                    $type = $var['brand'];

                    $cu->default_card = $card;
                    $cu->save();

                    $this->db->where('a_id',$account_id);
                    $this->db->update('ss_accounts', array(
                            'stripe_card_num' 	=> $last4,
                            'stripe_card_id' 	=> $card,
                            'stripe_card_type' 	=> $type
                        )
                    );

                    $result['success'] = true;
                    $result['error']['message'] = false;
                    $result['error']['code'] = false;
				}

			} catch( \Error $e) {
				$result['error']['message'] = $e->getMessage();
				$result['error']['code'] = $e->getCode();
				$this->Error->getException(__FUNCTION__,__LINE__,__FILE__,$e,true);
			}

		}else{

			try{

				$cu = \Stripe\Customer::retrieve($acct_info->stripe_id);
				$var = $cu->sources->create(array("card" => $stripeToken));
				$card = $var['id'];
				$type = $var['brand'];

				$cu->default_card = $card;
				$cu->save();

				$this->db->where('a_id',$account_id);
				$this->db->update('ss_accounts', array(
						'stripe_card_num' 	=> $last4,
						'stripe_card_id' 	=> $card,
						'stripe_card_type' 	=> $type
					)
				);
                $result['success'] = true;
                $result['error']['message'] = false;
                $result['error']['code'] = false;

			} catch (\Stripe\InvalidRequestError $e) {
				// Invalid parameters were supplied to Stripe's API
                $result['error']['message'] = $e->getMessage();
                $result['error']['code'] = $e->getCode();

			} catch (\Stripe\AuthenticationError $e) {
				// Authentication with Stripe's API failed
				// (maybe you changed API keys recently)
                $result['error']['message'] = $e->getMessage();
                $result['error']['code'] = $e->getCode();

			} catch (\Stripe\ApiConnectionError $e) {
				// Network communication with Stripe failed
                $result['error']['message'] = $e->getMessage();
                $result['error']['code'] = $e->getCode();

			} catch (\Error $e) {
				// Display a very generic error to the user, and maybe send
				// yourself an email
                $result['error']['message'] = $e->getMessage();
                $result['error']['code'] = $e->getCode();
				
			} catch (Exception $e) {
				// Something else happened, completely unrelated to Stripe
                $result['error']['message'] = $e->getMessage();
                $result['error']['code'] = $e->getCode();
			}

		}
		return $result;
	}


	function genPassword($pass = null)
	{
		$salt1 = "ABCD";
		$salt2 = "EDFG";
		$rand = rand(100000,5000000);
		if($pass)
		{
			$rand = $pass;
		}
		$pass = md5($salt1 . $rand . $salt2 . now());
		return  $pass;
	}

	function sendData($data)
	{

	}	

	function updateToken($id, $token)
	{

        $id 	= $this->data->cleanData( $id );
        $token 	= $this->data->cleanData( $token );

		$this->db->where('a_id', $id);
        $upd = $this->db->update('ss_accounts', array('s_token' => $token));
        $this->error->dbError();
        return $upd;
	}

	function getDayDifference($to, $from)
	{
		$date1 = new DateTime($to);
		$date2 = new DateTime($from);
		$interval = $date1->diff($date2);
		return number_format($interval->days, 0, '', '');
	}

	function getAccountById($account_id)
	{
        $account_id 	= $this->data->cleanData( $account_id );

		$this->db->where('a_id', $account_id);
		return $this->db->get('ss_accounts')->row();
	}

	function updateAccount($a_id, $data)
	{
        $a_id 	= $this->data->cleanData( $a_id );
        $data 	= $this->data->cleanData( $data );

		$this->db->where('a_id', $a_id);
		$upd = $this->db->update('ss_accounts', $data);
		$this->error->dbError();
		return $upd;
	}

	function findMySales()
	{
		$account_id = $this->isLogged();
		$sales = $this->db->query("SELECT p_id,p_high_url,ps_size,p_price,ap_amount,ap_success,
                    DATE_FORMAT(uc_payment_date, '%d/ %m/ %Y') as uc_payment_date,
                    DATE_FORMAT(uc_shipping, '%d/ %m/ %Y') as uc_shipping,
                    uc_id,c_qty,uc_status,cs_status,uc_cart_id
                    FROM ss_photos
                    JOIN ss_cart ON ( p_id = c_p_id ) 
                    JOIN ss_photo_sizes ON ( c_ps_id = ps_id )
                    JOIN ss_user_cart ON ( uc_cart_id = c_cart_id )
                    JOIN ss_cart_statuses ON ( ss_cart_statuses.cs_id = ss_user_cart.uc_status )
                    LEFT JOIN ss_payments ON (ap_c_id = ss_user_cart.uc_id)
                    WHERE p_id
                    IN 
                    (SELECT p_id 
                    FROM ss_photos 
                    JOIN ss_accounts ON (a_id = p_a_id ) WHERE p_a_id = $account_id) 
                    AND uc_status > 1 
                    AND p_a_id = $account_id ORDER BY uc_created DESC")->result();
		return $sales;
	}
        
        function sendPayment()
        {
            //$this->stripe->sendPayout();
        }
        
        function getPhotoOnAccount($photo_id)
        {
            $this->db->where('p_id',$photo_id);
            $this->db->join("ss_accounts","ss_photos.p_a_id = ss_accounts.a_id");
            return $this->db->get('ss_photos')->row();
        }
        
        function checkForCard()
        {
            return $this->getAccountById($this->isLogged())->stripe_card_id;
        }

}

?>
