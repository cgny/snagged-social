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
                                                <th scope=\"col\">Price</th>
                                                <th scope=\"col\">Total</th>
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
                                              <td>$'. $payout->p_price .'</td>		      
                                              <td>$'. ($payout->p_price * $payout->ap_qty) .'</td>		      
                                              <td>$'. $payout->ap_amount .'</td>		      
                                              <td>'. $success .'</td>			      
                                            </tr>';

        $payout_transfers .= "<tr  data-id='3' id='' class='payments_$cart_id payments_table' style='border:2px black solid'>
                                               <td>
                                                ". $payout->ap_error ."
                                                </td>
                                            </tr>";
    }

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
}
?>