<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		if(empty($this->account->isLogged()))
		{
            $data['errors']['message'] = "Not loged in";
            echo json_encode($data);
            exit;
		}
	}

	function getUserData()
	{
		$data['errors']['message'] = "No User";
		$data['success'] = false;
		if(!empty($a_id = $this->account->isLogged()))
		{
			$user = $this->account->getUser();
			
			$user->card = false;
			if($user->stripe_id)
			{
				$user->card = true;
			}
			
			unset($user->a_ig_id);
			unset($user->a_last_login);
			unset($user->a_password);
			unset($user->a_last_login);
			unset($user->a_token);
			unset($user->stripe_card_id);
			unset($user->stripe_card_num);
			unset($user->stripe_card_type);
			unset($user->stripe_id);
			unset($user->stripe_user_id);
			unset($user->stripe_access_token);
			unset($user->stripe_refresh_token);
			
			$data['user']               = $user;
			$data['orders']             = $this->cart->getAllCarts(null,$a_id);
			$data['sales']              = $this->account->findMySales();
			$data['countries']          = $this->data->getCountries();
			$data['currencies']         = $this->data->getCurrencies();
			$data['errors']['message']  = false;
			$data['success']            = true;
		}
		echo json_encode($data);
	}

	/**
	 *
	 * add and updates card
	 *
	 */

	function addCard()
	{

		if(empty($account_id = $this->account->isLogged()))
		{
			exit;
		}

		require(STRIPE_LIB);

		$stripeToken    = $this->data->cleanData( $this->input->post('stripeToken') );
		$last4          = $this->data->cleanData( $this->input->post('last4') );

		$result = $this->account->addCard($stripeToken, $last4, $account_id);
		echo json_encode( $result );
	}
        
	function addBank()
	{

		if(empty($account_id = $this->account->isLogged()))
		{
			exit;
		}

		require(STRIPE_LIB);

        $stripeToken    = $this->data->cleanData( $this->input->post('stripeToken') );
        $last4          = $this->data->cleanData( $this->input->post('last4') );

		echo $this->account->addCard($stripeToken, $last4, $account_id);
	}

	function update()
	{
		$first_name     = $this->input->post('first_name');
		$last_name      = $this->input->post('last_name');
		$email          = $this->input->post('email');
        $phone          = $this->input->post('phone');
		$currency       = $this->input->post('currency');
		$country        = $this->input->post('country');
		$business_name  = $this->input->post('business_name');
		$address_1      = $this->input->post('address_1');
		$address_2      = $this->input->post('address_2');
		$city           = $this->input->post('city');
		$state          = $this->input->post('state');
		$postal_code    = $this->input->post('postal_code');
		$ein            = $this->input->post('ein');
        $dob_m          = $this->input->post('dob_m');
        $dob_d          = $this->input->post('dob_d');
        $dob_y          = $this->input->post('dob_y');

		$data = array(
			'a_first_name'    => $first_name,
			'a_last_name'     => $last_name,
			'a_email'         => $email,
			'a_phone'         => $phone,
			'a_currency'      => $currency,
			'a_country'       => $country,
			'a_business_name' => $business_name,
			'a_address_1'     => $address_1,
			'a_address_2'     => $address_2,
			'a_city'          => $city,
			'a_state'         => $state,
			'a_postal_code'   => $postal_code,
			'a_ein'           => $ein,
			'a_dob_m'         => $dob_m,
			'a_dob_d'         => $dob_d,
			'a_dob_y'         => $dob_y,
		);

        $update = $this->data->cleanData($data);
		$success = false;
        $account_id = "";
		if(!empty($account_id = $this->account->isLogged()))
		{
            $success = $this->account->updateAccount($account_id, $update);
            $account = $this->account->getAccountById ( $account_id );
            if(empty($account->stripe_id))
            {
                $this->stripe->createStripeAccount( $account->a_email );
            }
		}
		echo json_encode(array('success' => $success, "account_id" => $account_id));
	}

	function getMySales()
	{



	}
        
    function authorizeStripe()
    {

        $code = $this->data->cleanData( $this->input->get('code') );
        $auth = $this->data->cleanData( $this->stripe->authorizeAccount($code) );

        redirect(site_url());

    }

    function getCountries()
    {
        if(!empty($accountId = $this->account->isLogged()))
        {
            //$data = $this->data->getCountries();
            //echo json_encode( $data );
        }
    }

    function getCurrencies()
    {
        if(!empty($accountId = $this->account->isLogged()))
        {
            //$data = $this->data->getCurrencies();
            //echo json_encode( $data );
        }
    }

}
