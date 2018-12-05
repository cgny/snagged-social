<?php

class Admin_model extends CI_Model
{

	function updateItem($item_id, $data)
	{
		$this->db->where('c_id', $item_id);
		return $this->db->update('ss_cart',$data);
	}

	function getAllCarts($limit = false, $status = false,$user_id = false)
	{
		$this->db->select("a_active,a_admin,a_email,a_first_name,a_last_name,a_ig_username,uc_cart_id,a_ig_id,cs_status,uc_id,uc_created,uc_updated,uc_status,uc_shipping,uc_payment_date,uc_ship_date");
		$this->db->join("ss_accounts","ss_user_cart.uc_a_id = ss_accounts.a_id","left");
		$this->db->join("ss_cart_statuses","ss_cart_statuses.cs_id = ss_user_cart.uc_status");
		if($limit)
		{
			$this->db->limit($limit);
		}
		if($user_id)
		{
			$this->db->where('uc_a_id',$user_id);
		}

		if($status)
        {
            $this->db->where('uc_status >',$status);
        }

        $this->db->order_by('uc_id',"desc");
		return $this->db->get('ss_user_cart')->result();
	}

	function getAllAccounts($limit = false)
	{
		if($limit)
		{
			$this->db->limit($limit);
		}
		$this->db->order_by('a_id',"desc");
		return $this->db->get('ss_accounts')->result();
	}

	function getAllPayouts($limit = false)
    {
        if(!empty($limit))
        {
            $this->db->limit($limit);
        }
        $this->db->order_by("ap_id","desc");
        $this->db->join('ss_accounts','ss_accounts.a_id = ss_payments.ap_a_id');
        return $this->db->get("ss_payments");
    }

    function getPayoutsByCartId($uc_id)
    {
        if(empty($uc_id))
        {
            return false;
        }
        $this->db->where('ap_uc_id',$uc_id);
        $this->db->join('ss_accounts','ss_accounts.a_id = ss_payments.ap_a_id');
        return $this->db->get("ss_payments");
    }

    function getShippingCarriers($sc_name = false)
    {
        if(!empty($Sc_name))
        {
            $this->db->where('sc_name',$sc_name);
        }
        return $this->db->get('ss_shipping_carriers')->result();
    }

    function sendShippingNotification( $cart_id )
    {
        $cart = $this->cart->getCart( $cart_id )->result();
        $this->error->dbError();
        $to = $cart[0]->uc_email;
        $subject = "Snagged Social Shipment - Order #".$cart[0]->uc_id. " Order Has Shipped";
        $msg = "<h2>Snagged Social</h2>"
            . "<h3>Shipment Update</h3>"
            . "<br>"
            . "<b>Your order is on the way!</b>"
            . "<br>"
            . "<b>Shipping Date</b>: ".$cart[0]->uc_ship_date."<br>"
            . "<b>Shipping Details</b>: ".$cart[0]->uc_ship_notes."<br>"
            . "<b>Carrier</b>: ".$cart[0]->sc_name."<br>"
            . "<b>Tracking</b>: ".$cart[0]->uc_tracking_code ."<br>"
            . "<b>Tracking URL</b>: <a href='". $cart[0]->sc_url . $cart[0]->uc_tracking_code ."' target='_blank'>". $cart[0]->sc_url . $cart[0]->uc_tracking_code ."</a><br>";

        $this->load->library('email');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = "html";

        $this->email->initialize($config);


        $this->email->to($to);
        $this->email->from('contact@snaggedsocial.com','Snagged Social');
        $this->email->bcc('contact@snaggedsocial.com,christian@cgnewyork.com');

        $this->email->subject($subject);
        $this->email->message($msg);
        if(!$this->email->send()){
            // print_r($this->email->print_debugger());
        }
    }

}