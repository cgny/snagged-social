<?php include 'header_receipt.php'; ?>

    <main class="maincontent">
        <div id="main_container" class="tab-content">
            <div class="gray-bg tab-pane fade in active" id="home">
	            <h1 id="main_logo" style="">Snagged Social</h1>
                <div class="container">
                    <div class="space-60"></div>
                        <div class="row" style="background: white;padding: 10px">
                            <?php if(empty($cart)){ ?>
                                <h4>Receipt Not Found! </h4>
                            <?php }else{ ?>
                            <div class="col-md-12">
                                <h3>Receipt</h3>
                                <div class="space-40"></div>
                                <div class="col-lg-12 ">
                                        <div class="col-xs-4">
                                                <h5 id="">ID</h5>
                                                <br>
                                                <h5 id="">Name</h5>
                                                <br>
                                                <h5 id="">Email</h5>
                                                <br>
                                                <h5 id="">Ship To</h5>
                                                <br>
                                                <br>
                                                <h5 id="">Paid</h5>
                                                <br>
                                                <h5 id="">Status</h5>
                                                <br>
                                                <h5 id="">Ship Cost</h5>
                                                <br>
                                                <h5 id="">Ship Date</h5>
                                                <br>
                                                <h5 id="">Tracking</h5>
                                                <br>
                                                <h5 id="">Notes</h5>
                                                <br>
                                                <br>
                                                <h5>Items</h5>
                                        </div>
                                    <div class="col-xs-8">
                                                <h5 id=""><?php echo $cart->uc_id; ?></h5>
                                                <br>
                                                <h5 id=""><?php echo $cart->uc_full_name; ?></h5>
                                                <br>
                                                <h5 id=""><?php echo $cart->uc_email; ?></h5>
                                                <br>
                                                <h5 id=""><?php echo $cart->uc_street_number.' '.$cart->uc_street; ?></h5>
                                                <h5><?php echo $cart->uc_city.', '.$cart->uc_state.' '.$cart->uc_zip; ?></h5>
                                                <br>
                                                <h5 id=""><?php echo !empty($cart->uc_payment_date) ? $cart->uc_payment_date : "-"; ?></h5>
                                                <br>
                                                <h5 id=""><?php echo $this->cart->showCartStatus($cart->uc_status); ?></h5>
                                                <br>
                                                <h5 id=""><?php echo !empty($cart->uc_shipping) ? $cart->uc_shipping : "-"; ?></h5>
                                                <br>
                                                <h5 id=""><?php echo !empty($cart->uc_ship_date) ? $cart->uc_ship_date : "Processing - Ships within 3 days." ?></h5>
                                                <br>
                                                <h5 id=""><?php echo !empty($cart->uc_tracking_code) ? $cart->uc_tracking_code : "-"; ?></h5>
                                                <br>
                                                <h5 id=""><?php echo !empty($cart->uc_ship_notes) ? $cart->uc_ship_notes : "-"; ?></h5>
                                                <br>
                                                <br>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">Image ID</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Size Cost</th>
                                                <th scope="col">Base Material Cost</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                    $total = 0;
                                                    foreach($items as $k => $item)
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td> <?php echo $item->p_id; ?> </td>
                                                            <td> <?php echo "<img src='". $item->p_url."' style='max-height:200px;max-width:60px;width:auto' />"; ?> </td>
                                                            <td> $<?php echo $item->p_price; ?> </td>
                                                            <td> <?php echo $item->c_qty; ?> </td>
                                                            <td> (<?php echo $item->ps_size; ?>)  $<?php echo $item->ps_price; ?> </td>
                                                            <td> $<?php echo number_format(MAT_PRICE,2); ?> </td>
                                                            <td> $<?php echo $item->c_final_price; ?> </td>
                                                        </tr>
                                                    <?php
                                                        $total += $item->c_final_price;
                                                    }
                                                    ?>

                                            </tbody>
                                        </table>

                                                <br>
                                                <h5>Total Price: $<?php echo number_format($total,2); ?></h5>
                                                <br>
                                                <h5>Shipping: $<?php echo !empty($cart->uc_shipping) ? number_format($cart->uc_shipping,2) : "-"; ?></h5>
                                                <br>
                                                <h5>Final Price: $<?php echo !empty($cart->uc_shipping) ? number_format(($total+$cart->uc_shipping),2) : "-"; ?>
                                                <br>
                                                <br>
                                        </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </main>