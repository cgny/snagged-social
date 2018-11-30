<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11/30/18
 * Time: 8:15 PM
 */

$shipping = "";
if($cart->uc_status < 3)
{;
    $shipping  = "<select id='carrier_$cart_id' class=''>";
    $shipping .= "<option value=''>Select Carrier</option>";

    foreach($carriers as $carrier)
    {
        $shipping .= "<option value='". $carrier->sc_id ."'>". $carrier->sc_name ."</option>";
    }

    $shipping .= "</select>";
    $shipping .= "<br>";
    $shipping .= "<button data-id='$cart_id' data-cart_id='". $cart->uc_cart_id ."' class='set_as_shipped' id='shipping_$cart_id'>Set as Shipped</button>";
}