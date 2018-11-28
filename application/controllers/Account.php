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

		echo $this->account->addCard($stripeToken, $last4, $account_id);
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
		$first_name = $this->input->post('first_name');
		$last_name  = $this->input->post('last_name');
		$email      = $this->input->post('email');
        $phone      = $this->input->post('phone');
		$currency   = $this->input->post('currency');

		$data = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'email'      => $email,
			'currency'   => $currency
		);

		$data = $this->data->cleanData($data);

		$success = false;
		
		if(!empty($accountId = $this->account->isLogged()))
		{
		    $account = $this->account->getAccountById($accountId);
			if(!empty($account_id = $this->account->isLogged()))
			{
				$update = [];
				if(!empty($first_name))
				{
					$update['a_first_name'] = $data['first_name'];
				}
				if(!empty($last_name))
				{
					$update['a_last_name'] = $data['last_name'];
				}
				if(!empty($phone))
				{
					$update['a_phone'] = $data['phone'];
				}
                if(!empty($currency))
                {
                    $update['a_currency'] = $data['currency'];
                }
				if(!empty($email))
				{
					$update['a_email'] = $data['email'];
                    if(empty($account->stripe_id))
                    {
                        $this->stripe->createStripeAccount($data['email']);
                    }
				}
				if(empty($update))
				{
					return false;
				}
				$success = $this->account->updateAccount($account_id, $update);
			}
		}
		echo json_encode(array('success' => $success));
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
