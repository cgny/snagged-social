<div class="row col-lg-9 pull-right">
	<div id="nav" class="col-lg-12">
	<h3>Orders</h3>

        <?php

        $delayed = $unpaid = $shipped = $paid = 0;
        foreach($carts as $cart)
        {
            if($cart->uc_status == 1)
            {
                $unpaid++;
            }
            elseif($cart->uc_status == 2)
            {
                $paid++;
            }
            elseif($cart->uc_status == 3)
            {
                $shipped++;
            }
            elseif($cart->uc_status == 4)
            {
                $delayed++;
            }
        }

        ?>
        <div class="row">
            <div class="col-lg-3">
                <h4>Unpaid (<?php echo $unpaid; ?>)</h4>
            </div>
            <div class="col-lg-3">
                <h4>Paid (<?php echo $paid; ?>)</h4>
            </div>
            <div class="col-lg-3">
                <h4>Shipped (<?php echo $shipped; ?>)</h4>
            </div>
            <div class="col-lg-3">
                <h4>Delayed (<?php echo $delayed; ?>)</h4>
            </div>
        </div>

        <table class="table table-striped ">
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
                <th scope="col">View Payouts</th>
            </tr>
            </thead>
            <tbody>
            <?php

                include "payouts_include.php";
                include "admin_shipping.php";

                echo '<tr>
                      <th scope="row">'. $cart->uc_id .'</th>
                      <td>'. $cart->a_ig_username .'</td>
                      <td>'. $cart->uc_created .'</td>
                      <td>'. $cart->uc_shipping .'</td>
                      <td>'. $shipping .'</td>
                      <td>'. $cart->cs_status .'</td>
                      <td>'. $cart->uc_updated .'</td>
                      <td>'. $cart->uc_payment_date .'</td>			      
                      <td> <button id="open_payouts_'.$cart_id.'" data-id="'.$cart_id.'" class="view_payouts">Toggle</button> </td>			      
                    </tr>';
                echo $payout_transfers;
            ?>

            </tbody>
        </table>


	</div>
</div>
