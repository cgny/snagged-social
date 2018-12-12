<div class="row col-lg-9 pull-right">
    <div id="nav" class="col-lg-12">
        <h3>Payouts</h3>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Photo</th>
                <th scope="col">Qty</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th>
                <th scope="col">Payout</th>
                <th scope="col">Success</th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach($payouts->result() as $payout)
            {
                $payout_success = ($payout->ap_success == 1) ? "Yes" : "No";
                $total = ($payout->ap_qty * $payout->c_photo_price);
                echo '<tr>
			      <th scope="row">'. $payout->ap_id .'</th>
			      <td>'. $payout->a_ig_username .'</td>
			      <td>'. $payout->ap_p_id .'</td>
			      <td>'. $payout->ap_qty .'</td>
			      <td>$'. $payout->c_photo_price .'</td>
			      <td>$'. number_format($total,2) .'</td>
			      <td>$'. $payout->ap_amount .'</td>
			     <td>'. $payout_success .'</td>
			    </tr>';
            }

            ?>
            </tbody>
        </table>

    </div>
</div>