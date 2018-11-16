<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->cart->updateCartAccountId();

	}

	function addToCart()
	{
		$id = $this->input->post('p_id');
		$size_id = $this->input->post('img_size');
		$success = $this->cart->addToCart($id,$size_id);
		$data['errors']['message'] = false;
		$data['success'] = $success;
		echo json_encode($data);	
	}

	function removeFromCart()
	{
		$id = $this->input->post('p_id');
		$success = $this->cart->removeFromCart($id);
		$data['errors']['message'] = ($success == false) ? "Not Deleted" : "";
		$data['success'] = ($success != false) ? true : false;
		echo json_encode($data);
	}

	function addSize()
	{
		$id = $this->input->post('p_id');
		$size = $this->input->post('p_size');
		$success = $this->cart->updateItem($id,"",$size);
	}

	function addQty()
	{
		$id = $this->input->post('p_id');
		$qty = $this->input->post('p_qty');
		$success = $this->cart->updateItem($id,$qty);
	}

	function updateQty()
	{
		$c_id = $this->input->post('c_id');
		$qty = $this->input->post('c_qty');

		$c_id = $this->error->scrubSQL($c_id);
		$qty = $this->error->scrubSQL($qty);

		$media = $this->cart->getCartItem($c_id);

		$success = 0;	
		if($qty > 0)
		{
			$success = $this->cart->updateItem($c_id,$media,$qty);
		}
		$data['errors']['message'] = !($success == 1) ? "Not Added" : "";
		$data['success'] = ($success == 1);
		echo json_encode($data);		
	}

	function getCartItems()
	{
		$id = $this->input->get('id');
		$items = $this->cart->getCart($id);
		$data['errors']['message'] = false;
		$data['success'] = true;
		$data['items'] = $items->result();
		echo json_encode($data);		
	}
	
	function checkout()
	{
		$this->load->model('Stripe_model', 'stripe');
		
		$token = $this->input->post('stripeToken');
		$email = $this->input->post('stripeEmail');

		$total = $this->cart->getCartTotal();
		
		$details = $this->stripe->processPayment($token,$total,$email);
		
		$this->cart->updateMasterCart(array('c_details' => json_encode($details)));
		
		$data->success = false;
		if(empty($details->failure_code))
		{
			$data->success = true;
			redirect(site_url('cart/receipt/'. $details->cart_id));
		} 
		else 
		{
			//print_r($details); 
            //exit;    
		}
			
		redirect('#cart');
	}
        
	function receipt()
	{
		$cartId = $this->uri->segment(3);
		$c_id = $this->error->scrubSQL($cartId);
		$cart = $this->cart->getUserCart($c_id);
		
		if($cart->num_rows() == 1)
		{
			$c = $cart->row();
			$data['cart'] = $c;
			$data['items'] = $this->cart->getCart($c_id)->result();
			$this->load->view('receipt',$data);
		}
		else
		{
			$data['cart'] = false;
			$data['items'] = false;
			$this->load->view('receipt',$data);
		}
	}

}
