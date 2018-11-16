<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('display_errors', 1);
error_reporting(E_ALL);

class Auth extends CI_Controller {

	public $links,$token,$user,$user_id;
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
	}

	public function index()
	{
		$code = $this->input->get('code');
		if(empty($code))
		{
                        $cart_id = $this->session->userdata['cart_id'];
			session_destroy();
			session_start();
			redirect(IG_AUTH_URL);
                        $this->session->userdata['cart_id'] = $cart_id;
		}
		else
		{
			$data = $this->url->requestToken($code);
			if(isset($data->access_token))
			{
				$_SESSION['token'] = $data->access_token;
				$_SESSION['user'] = $data->user;
				$_SESSION['user_id'] = $this->account->saveAccount();
				$this->cart->updateCartAccountId();
			}
			redirect(site_url());
		}
	}


	
}
