<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{

	private $admin_user = false;

	function __construct()
	{
		parent::__construct();
		if(empty($account_id = $this->account->isLogged()))
		{
            $data['errors']['message'] = "Not loged in";
            echo json_encode($data);
			exit;
		}
		$account = $this->account->getAccountById( $account_id );
		if($account->a_admin == 1)
		{
			$this->admin_user = $account;
		}
		else
		{
            $data['errors']['message'] = "No access";
            echo json_encode($data);
			exit;
		}
	}
	
	function index()
	{
		$data['payouts'] = $this->admin->getAllPayouts(10);
		$data['carts'] = $this->admin->getAllCarts(10);
		$data['accounts'] = $this->admin->getAllAccounts(10);
		$data['statuses'] = $this->cart->getCartStatuses();
        $data['carriers'] = $this->cart->getShippingCarriers();

		$this->load->view('admin/header');
		$this->load->view('admin/index', $data);
		$this->load->view('admin/footer');
	}

	function showPayouts()
    {
        $data['payouts'] = $this->admin->getAllPayouts();

        $this->load->view('admin/header');
        $this->load->view('admin/payouts', $data);
        $this->load->view('admin/footer');
    }

	function showAccounts()
	{
		$data['accounts'] = $this->admin->getAllAccounts();

		$this->load->view('admin/header');
		$this->load->view('admin/accounts', $data);
		$this->load->view('admin/footer');
	}

	function showAccount()
	{
		$account_id = $this->input->get('account_id');
		$data['accounts'] = $this->admin->getAccountBy($account_id);

		$this->load->view('admin/header');
		$this->load->view('admin/account', $data);
		$this->load->view('admin/footer');
	}

	function showOrders()
	{
		$data['carts'] = $this->admin->getAllCarts();
		$data['statuses'] = $this->cart->getCartStatuses();
        $data['carriers'] = $this->cart->getShippingCarriers();

		$this->load->view('admin/header');
		$this->load->view('admin/orders', $data);
		$this->load->view('admin/footer');
	}

	function showOrder()
	{
		$cart_id = $this->input->get('cart_id');
		$data['order'] = $this->cart->getCart($cart_id);
		$data['statuses'] = $this->cart->getCartStatuses();
		$data['carriers'] = $this->cart->getShippingCarriers();

		$this->load->view('admin/header');
		$this->load->view('admin/order', $data);
		$this->load->view('admin/footer');
	}

	function updateCart()
	{

		$status = $this->input->post('status');
		$tracking = $this->input->post('tracking');
		$carrier = $this->input->post('carrier');

		$fields = [];
		$fields['status'] = ($status) ? $status : null;
		$fields['ship_date'] = ($tracking) ? date("Y-m-d") : null;
		if($tracking)
        {
            $fields['tracking'] = $tracking;
        }
		if($carrier)
        {
            $fields['carrier'] = $carrier;
        }

		$upd = $this->cart->updateStatus($fields);

		echo json_encode( array("data" => array('success' => $upd)));

	}

	function doUpdateItem()
	{
		$item_id = $this->input->post('item_id');
		$price = $this->input->post('item_price');
		$qty = $this->input->post('item_qty');
		$size = $this->input->post('item_size');

		$data = array(
			'first_name' => $item_id,
			'last_name'  => $price,
			'email'      => $qty,
			'active'     => $size
		);

		$upd = $this->admin->updateItem($item_id, $data);
		echo json_encode( array("data" => array('success' => $upd)));
	}

	function doUpdateAccount()
	{
		$a_id = $this->input->post('a_id');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$active = $this->input->post('active');

		$data = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'email'      => $email,
			'active'     => $active
		);

		$upd = $this->account->updateAccount($a_id, $data);
		echo json_encode( array("data" => array('success' => $upd)));
	}

}