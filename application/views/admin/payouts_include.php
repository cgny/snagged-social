<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11/30/18
 * Time: 1:31 PM
 */

foreach($carts as $cart)
{
    $cart_id = $cart->uc_id;
    $payouts = $this->admin->getPayoutsByCartId( $cart_id )->result();
    $payout_transfers = "<tr data-id='1' class='payments_$cart_id payments_table' id='' style='border:2px black solid'>
                                                <th scope=\"col\">#</th>
                                                <th scope=\"col\">Username</th>
                                                <th scope=\"col\">Photo</th>
                                                <th scope=\"col\">Qty</th>
                                                <th scope=\"col\">Payout</th>
                                                <th scope=\"col\">Success</th>
                                            </tr>";
    foreach($payouts as $payout)
    {
        $success = ($payout->ap_success == 1) ? "Yes" : "No";
        $payout_transfers .= '<tr  data-id="2" id="" class="payments_'.$cart_id.' payments_table" style="border:2px black solid">
                                              <td scope="row">'. $payout->ap_id .'</td>
                                              <td>'. $payout->a_ig_username .'</td>
                                              <td>'. $payout->ap_p_id .'</td>
                                              <td>'. $payout->ap_qty .'</td>
                                              <td>'. $payout->ap_amount .'</td>		      
                                              <td>'. $success .'</td>			      
                                            </tr>';

        $payout_transfers .= "<tr  data-id='3' id='' class='payments_$cart_id payments_table' style='border:2px black solid'>
                                               <td>
                                                ". $payout->ap_error ."
                                                </td>
                                            </tr>";
    }
}
?>