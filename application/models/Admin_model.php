<?php

class Admin_model extends CI_Model
{

	function updateItem($item_id, $data)
	{
		$this->db->where('c_id', $item_id);
		return $this->db->update('ss_cart',$data);
	}

	function getAllCarts($limit = false, $user_id = false)
	{
		$this->db->select("a_active,a_admin,a_email,a_first_name,a_last_name,a_ig_username,a_ig_id,cs_status,uc_id,uc_created,uc_updated,uc_status,uc_shipping,uc_payment_date,uc_ship_date");
		$this->db->join("ss_accounts","ss_user_cart.uc_a_id = ss_accounts.a_id");
		$this->db->join("ss_cart_statuses","ss_cart_statuses.cs_id = ss_user_cart.uc_status");
		if($limit)
		{
			$this->db->limit($limit);
			$this->db->order_by('uc_id',"desc");
		}
		if($user_id)
		{
			$this->db->where('uc_a_id',$user_id);
		}
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

}