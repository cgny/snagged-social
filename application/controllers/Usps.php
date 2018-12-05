<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usps extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
	}

	function getShippingCost()
	{
		$to_zip = $this->input->post('to_zip');
		$to_country = $this->input->post('to_country');

		$update = array(
			'uc_full_name' => $this->input->post('to_first_name').' '.$this->input->post('to_last_name'),
			'uc_street' => $this->input->post('to_street'),
			'uc_city' => $this->input->post('to_city'),
			'uc_state' => $this->input->post('to_state'),
			'uc_country' => $this->input->post('to_country'),
			'uc_zip' => $this->input->post('to_zip'),
		);
		
		$this->cart->updateMasterCart($update);
		
		$data['errors']['message'] = false;
		$this->usps->calculateRate($to_country, $to_zip);

		$data['rate'] = $this->usps->rate;
		$data['service'] = $this->usps->service;
		$data['duration'] = $this->usps->duration;
		echo json_encode($data);
	}
}
