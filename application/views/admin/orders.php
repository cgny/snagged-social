<div class="row col-lg-9 pull-right">
	<div id="nav" class="col-lg-12">
	<h3>Orders</h3>
		<table class="table table-striped">
			<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Username</th>
				<th scope="col">Created</th>
				<th scope="col">Shipped</th>
				<th scope="col">Status</th>
			</tr>
			</thead>
			<tbody>
		<?php
			foreach($carts as $cart)
			{
				echo '<tr>
			      <th scope="row">'. $cart->uc_id .'</th>
			      <td>'. $cart->a_ig_username .'</td>
			      <td>'. $cart->uc_created .'</td>
			      <td>'. $cart->uc_shipping .'</td>
			      <td>'. $cart->cs_status .'</td>
			    </tr>';
			}
		?>
			</tbody>
		</table>
	</div>
</div>
