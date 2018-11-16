<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

	public $links, $token, $user, $user_id;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
	}

	function index()
	{
		foreach($this->url->buildUserLinks() as $name => $link)
		{
			echo "<a href='". $link ."'>". $name ."</a><br>";
		}
	}

	function login()
	{
		redirect(site_url('/auth'));
	}

	function logout()
	{
		if(!empty(session_id()))
		{
			session_destroy();
		}
		redirect(site_url());
	}


}
