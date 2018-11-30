<div class="row col-lg-9 pull-right">
    <div id="nav" class="col-lg-12">
        <h3>Payouts</h3>

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

            foreach($payouts->result() as $payout)
            {
                $payout_success = ($payout->ap_success == 1) ? "Yes" : "No";
                echo '<tr>
			      <th scope="row">'. $payout->ap_id .'</th>
			      <td>'. $payout->a_ig_username .'</td>
			      <td>'. $payout->ap_p_id .'</td>
			      <td>'. $payout->ap_qty .'</td>
			      <td>'. $payout->ap_amount .'</td>
			     <td>'. $payout_success .'</td>
			    </tr>';
            }

            ?>
            </tbody>
        </table>

    </div>
</div>