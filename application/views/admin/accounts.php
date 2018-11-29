

<div class="row col-lg-9 pull-right">
	<div id="nav" class="col-lg-12">
<h3>Accounts</h3>
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
				<th scope="col">Stripe Active</th>
				<th scope="col">Address</th>
				<th scope="col">Currency</th>
			</tr>
			</thead>
			<tbody>
		<?php

		foreach($accounts as $account)
		{
		    $stripe_active = (!empty($account->stripe_id)) ? "Yes" : "No";
			echo '<tr>
			      <th scope="row">'. $account->a_id .'</th>
			      <td>'. $account->a_first_name .'</td>
			      <td>'. $account->a_last_name .'</td>
			      <td>'. $account->a_ig_username .'</td>
			      <td>'. $account->a_phone .'</td>
			      <td>'. $account->a_email .'</td>
			      <td>'. $account->stripe_card_num .'</td>
			      <td>'. $stripe_active .'</td>
			      <td>'. $account->a_address_1 .' '. $account->a_address_2 .',<br>
			      '. $account->a_city .','. $account->a_state .',<br>
			      '. $account->a_postal_code  .' '. $account->a_country .'
			      </td>
			      <td>'. $account->a_currency .'</td>
			    </tr>';
		}

		?>
			</tbody>
		</table>

	</div>
</div>
