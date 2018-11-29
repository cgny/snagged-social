<?php
/**
 * Created by PhpStorm.
 * User: cgibbs
 * Date: 12/13/17
 * Time: 7:14 PM
 */

class Cart_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
                if(!isset($this->session->userdata['cart_id']) || (isset($this->session->userdata['cart_id']) && empty($this->session->userdata['cart_id']) ))
                {
                    $this->getCartId(true);
                }
                else
                {
                    $this->checkCartId();
                }
	}
        
        function checkCartId()
        {
            $this->db->where('uc_cart_id',$this->session->userdata['cart_id']);
            $cart = $this->db->get('ss_user_cart');
            if($cart->num_rows() == 0)
            {
                $data = array(
                                'uc_cart_id' => $this->session->userdata['cart_id'],
                                'uc_false_a_id' => $this->account->isLogged(true),
                                'uc_a_id' => $this->account->isLogged()
                            );
                $this->db->insert('ss_user_cart',$data);
            }
        }

	function getCartId($force = false)
	{
		if(!isset($this->session->userdata['cart_id']) || $force === true)
		{
			$this->session->userdata['cart_id'] = md5(rand(0,5000) . rand(0,10000) . rand(10000,20000) . time());
			$data = array(
                            'uc_cart_id' => $this->session->userdata['cart_id'],
                            'uc_false_a_id' => $this->account->isLogged(true)
                        );
                        $this->db->insert('ss_user_cart',$data);
			return $this->session->userdata['cart_id'];
		}
		else
		{
			return $this->session->userdata['cart_id'];
		}
	}

	function updateCartAccountId()
	{
            if($this->account->isLogged() != false)
            {
		$this->db->where('uc_cart_id',$this->getCartId());
		$this->db->update('ss_user_cart', array(
                                                        'uc_a_id' => $this->account->isLogged(),
                                                        'uc_false_a_id' => -1
                                                        )
                                                    );

		$this->db->where('c_cart_id',$this->getCartId());
		$this->db->update('ss_cart', array(
                                                    'c_a_id' => $this->account->isLogged(),
                                                    'uc_false_a_id' => -1
                                                    )
                                                );
            }
	}

	function addToCart($p_id,$size_id)
	{
		$item = $this->checkItemInCart($p_id,$size_id);
		$media = $this->media->getMedia($p_id);
                $size = $this->media->getPhotoSizes($size_id);
		if(empty($item->num_rows()))
		{
			$data = array(
				'c_a_id' => $this->account->isLogged(true),
				'c_p_id' => $p_id,
				'c_ps_id' => $size_id,
				'c_cart_id' => $this->getCartId(),
				'c_base_price' => ($media->p_price+MAT_PRICE+$size->ps_price),
				'c_final_price' => ($media->p_price+MAT_PRICE+$size->ps_price)
			);
			return $this->db->insert('ss_cart',$data);
		}
		else
		{
			$item = $item->row();
			$item = $this->getCartItem($item->c_id);
			$this->updateItem($item->c_id,$media,($item->c_qty+1));
			return $item->c_id;
		}
	}

	function removeFromCart($id)
	{
		if(!empty($this->checkItemInCart($id)))
		{
			$this->db->where('c_id',$id);
			$this->db->where('c_cart_id',$this->getCartId());
			return $this->db->delete('ss_cart');
		}
		return false;
	}

	function updateItem($id,$media,$qty = null,$size=null)
	{
		

		$final_price = ($media->p_price + MAT_PRICE + $media->ps_price) * $qty;
		
		$data = array();
		$data['c_final_price'] = $final_price;
		if($qty)
		{
			$data['c_qty'] = $qty;
		}

		if($size)
		{
			$data['c_ps_id'] = $size;
		}

		$this->db->where('c_id',$id);
		$this->db->where('c_cart_id',$this->getCartId());
		return $this->db->update('ss_cart',$data);
	}

	function checkItemInCart($id, $size_id = '')
	{
		$this->db->join("ss_cart","ss_user_cart.uc_cart_id = ss_cart.c_cart_id");
		$this->db->where('c_p_id',$id);
		if($size_id)
		{
			$this->db->where('c_ps_id',$size_id);
		}
		$this->db->where('uc_cart_id',$this->getCartId());
		return $this->db->get('ss_user_cart');
	}

	function getCart($id = null)
	{
		if($id == "false")
		{
			$id = 0;
		}
		$id = $this->error->scrubSQL($id);
		$this->db->join("ss_cart","ss_user_cart.uc_cart_id = ss_cart.c_cart_id","left");
		$this->db->join("ss_photo_sizes","ss_photo_sizes.ps_id = ss_cart.c_ps_id","left");
		$this->db->join("ss_photos","ss_photos.p_id = ss_cart.c_p_id");
		if(empty($id))
		{
			$id = $this->getCartId();
			$this->db->where('uc_a_id',$this->account->isLogged());
		}
		$this->db->where('uc_cart_id',$id);
		return $this->db->get('ss_user_cart');
	}
        
        function getUserCart($id)
        {
		$this->db->where('uc_cart_id',$id);
		return $this->db->get('ss_user_cart');
        }

	function getCartTotal()
	{
		$cart = $this->getCart()->row();
		$cart_id = $cart->uc_cart_id;
		$c = $this->db->query("SELECT SUM(c_final_price) as total FROM ss_cart JOIN ss_user_cart ON (uc_cart_id = c_cart_id ) WHERE c_cart_id = '$cart_id' ")->row();
		return ($c->total + $cart->uc_shipping);
	}

	function getAllCarts($limit = false, $user_id = false)
	{
		$this->db->select("a_active,"
                        . "uc_cart_id,"
                        . "cs_status,"
                        . "uc_id,"
                        . "DATE_FORMAT(uc_created, '%d/ %m/ %Y') as uc_created,"
                        . "uc_updated,"
                        . "uc_status,"
                        . "DATE_FORMAT(uc_shipping, '%d/ %m/ %Y') as uc_shipping");
		$this->db->join("ss_accounts","ss_user_cart.uc_a_id = ss_accounts.a_id");
		$this->db->join("ss_cart_statuses","ss_cart_statuses.cs_id = ss_user_cart.uc_status");
		if($limit)
		{
			$this->db->limit($limit);
			$this->db->order_by('uc_created',"desc");
		}
		if($user_id)
		{
			$this->db->where('uc_a_id',$user_id);
		}
		return $this->db->get('ss_user_cart')->result();
	}

	function getCartItem($id)
	{
		$this->db->join("ss_cart","ss_user_cart.uc_cart_id = ss_cart.c_cart_id","left");
		$this->db->join("ss_photo_sizes","ss_photo_sizes.ps_id = ss_cart.c_ps_id","left");
		$this->db->join("ss_photos","ss_photos.p_id = ss_cart.c_p_id");
		$this->db->where('uc_cart_id',$this->getCartId());
		$this->db->where('c_id',$id);
		return $this->db->get('ss_user_cart')->row();
	}

	function updateShipping($cost,$service,$duration)
	{
		$update = array(
			'uc_shipping' => $cost,
			'uc_ship_notes' => $service.' | '.$duration,
		);

		$this->db->where('uc_cart_id',$this->getCartId());
		$u = $this->db->update('ss_user_cart', $update);
	}

	function updateCart($data)
	{
		$data = array_filter($data);
		if(empty($data))
		{
			return false;
		}
		foreach($data as $k => $v)
		{
			$data[$k] = $this->error->scrubSQL($v);
		}
		$this->db->where('uc_cart_id',$this->getCartId());
		$this->db->update('ss_user_cart', $data );

	}

	function updateMasterCart($data)
	{
		$data = array_filter($data);
		if(empty($data))
		{
			return false;
		}
		foreach($data as $k => $v)
		{
			$data[$k] = $this->error->scrubSQL($v);
		}
		$this->db->where('c_cart_id',$this->getCartId());
		$this->db->update('ss_cart', $data );

	}

	function updateStatus($fields)
	{
		if(empty($fields))
		{
			return false;
		}
		$this->db->where('uc_cart_id',$this->getCartId());

		$update['uc_updated'] = date("Y-m-d H:i:s");
		if(isset($fields['status']))
		{
			$update['uc_status'] = $fields['status'];
		}
		$update['uc_updated'] = date("Y-m-d H:i:s");
		if(isset($fields['uc_payment_date']))
		{
			$update['uc_payment_date'] = $fields['uc_payment_date'];
		}
		if(isset($fields['shipping']))
		{
			$update['uc_shipping'] = $fields['shipping'];
		}
		if(isset($fields['uc_ship_date']))
		{
			$update['uc_ship_date'] = date("Y-m-d");
		}
		$this->db->update('ss_user_cart', $update );
	}

	function getCartStatuses()
	{
		return $this->db->get('ss_cart_statuses')->result();
	}
        
        function showCartStatus($status)
        {
            $s = $this->getCartStatuses();
            foreach($s as $stat)
            {
                if($stat->cs_id == $status)
                {
                    return $stat->cs_status;
                }
            }
            return "Unpaid";
        }	
        
        function emailReceipt($cartId="")
        {
            if(!empty($cartId))
            {
                $c_id = $this->error->scrubSQL($cartId);
                $cart = $this->cart->getUserCart($c_id); 
                if($cart->num_rows() != 1)
                {
                    throw new Exception('Invalid Cart Id');
                }
            }
            else
            {
                $cartId = $this->getCartId();
            }
            
            
            $cart = $this->getCart( $cartId )->result();
            $to = $cart[0]->uc_email;
            $subject = "Snagged Social Receipt - Order #".$cart[0]->uc_id;
            $msg = "<h3>Snagged Social</h3>"
                    . "<br><br>Receipt"
                    . "<br>"
                    . "<b>Email</b>: ".$cart[0]->uc_email."<br>"
                    . "<b>Payment Date</b>: ".$cart[0]->uc_payment_date."<br>"
                    . "<b>Shipping Details</b>: ".$cart[0]->uc_ship_notes."<br>"
                    . "<b>Shipping Cost</b>: ".$cart[0]->uc_shipping."<br>";
            
            $items = "<hr><h3>Items</h3>";
            $total = 0;

            $items .= '<table class="table table-striped">';
            $items .= '<thead>';
            $items .= '<tr>';
            $items .= '<th scope="col">Image ID</th>';
            $items .= '<th scope="col">Image</th>';
            $items .= '<th scope="col">Price</th>';
            $items .= '<th scope="col">Qty</th>';
            $items .= '<th scope="col">Size Cost</th>';
            $items .= '<th scope="col">Base Material Cost</th>';
            $items .= '<th scope="col">Total</th>';
            $items .= '</tr>';
            $items .= '</thead>';
            $items .= '<tbody>';

            foreach($cart as $k => $item)
            {
                $items .= '<tr>';
                    $items .= '<td>'.  $item->p_id .'</td>';
                    $items .= '<td><img src="'. $item->p_url .'" style="max-height:200px;max-width:60px;width:auto" /> </td>';
                    $items .= '<td>$'. $item->p_price .'</td>';
                    $items .= '<td>'. $item->c_qty .'</td>';
                    $items .= '<td>$'. $item->ps_price .'</td>';
                    $items .= '<td>$'. number_format(MAT_PRICE,2) .'</td>';
                    $items .= '<td>$'. $item->c_final_price .'</td>';
                $items .= '</tr>';
                $total += $item->c_final_price;
            }

            $items .= '</tbody>';
            $items .= '</table>';
            
            $items .= "<b>Total Item Price</b>: $".$total."<br>";
            $items .= "<b>Final Price</b>: $". ($cart[0]->uc_shipping+$total)."<br>";
            
            $msg .= $items ."<hr><br>";
            
            $msg .= "<b>Ship to Address</b><br>"
                    . $cart[0]->uc_full_name."<br>"
                    . $cart[0]->uc_street_number."<br>"
                    . $cart[0]->uc_street."<br>"
                    . $cart[0]->uc_city .",". $cart[0]->uc_state."<br>"
                    . $cart[0]->uc_country."<br>"
                    . $cart[0]->uc_zip."<br>"
                    . "<br><br>"
                    . "Check your order status - <a targe='_blank' href='".site_url('cart/receipt/'.$this->getCartId())."'>".site_url('cart/receipt/'.$this->getCartId())."</a>";
        
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
