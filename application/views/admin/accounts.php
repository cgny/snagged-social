

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
