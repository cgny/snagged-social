<div class="row col-lg-9 pull-right">
	<div id="nav" class="col-lg-12">

<h3>Last 10 Orders</h3>
		<table class="table table-striped">
			<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Username</th>
				<th scope="col">Created</th>
				<th scope="col">Shipping $</th>
				<th scope="col">Shipping Date</th>
				<th scope="col">Status</th>
				<th scope="col">Last Update</th>
				<th scope="col">Payment Date</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($carts as $cart)
			{
				$shipping = $cart->uc_ship_date;
				if(empty($cart->uc_ship_date) && $cart->cs_status != "Unpaid")
				{
					$shipping = "<button>Set as Shipped</button>";
				}
				echo '<tr>
			      <th scope="row">'. $cart->uc_id .'</th>
			      <td>'. $cart->a_ig_username .'</td>
			      <td>'. $cart->uc_created .'</td>
			      <td>'. $cart->uc_shipping .'</td>
			      <td>'. $shipping .'</td>
			      <td>'. $cart->cs_status .'</td>
			      <td>'. $cart->uc_updated .'</td>
			      <td>'. $cart->uc_payment_date .'</td>
			    </tr>';
			}
			?>
			</tbody>
		</table>

		<h3>Last 10 Users</h3>
		<table class="table table-striped">
			<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">First</th>
				<th scope="col">Last</th>
				<th scope="col">Username</th>
				<th scope="col">Phone</th>
				<th scope="col">Email</th>
				<th scope="col">Last 4</th>
			</tr>
			</thead>
			<tbody>
			<?php

			foreach($accounts as $account)
			{
				echo '<tr>
			      <th scope="row">'. $account->a_id .'</th>
			      <td>'. $account->a_first_name .'</td>
			      <td>'. $account->a_last_name .'</td>
			      <td>'. $account->a_ig_username .'</td>
			      <td>'. $account->a_phone .'</td>
			      <td>'. $account->a_email .'</td>
			      <td>'. $account->stripe_card_num .'</td>
			    </tr>';
			}

			?>
			</tbody>
		</table>



		</div>
	</div>
