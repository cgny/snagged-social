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
                                <div class="col-xs-12 pull-right">
                                        <div class="col-xs-3">
                                                <h4 id="">ID</h4>
                                                <br>
                                                <h4 id="">Name</h4>
                                                <br>
                                                <h4 id="">Email</h4>
                                                <br>
                                                <h4 id="">Ship To</h4>
                                                <br>
                                                <br>
                                                <h4 id="">Payment date</h4>
                                                <br>
                                                <h4 id="">Status</h4>
                                                <br>
                                                <h4 id="">Ship Cost</h4>
                                                <br>
                                                <h4 id="">Ship Date</h4>
                                                <br>
                                                <h4 id="">Ship Tracking ID</h4>
                                                <br>
                                                <h4 id="">Ship notes</h4>
                                                <br>
                                                <br>
                                                <h4>Items</h4>
                                        </div>
                                    <div class="col-xs-6">
                                                <h4 id=""><?php echo $cart->uc_id; ?></h4>
                                                <br>
                                                <h4 id=""><?php echo $cart->uc_full_name; ?></h4>
                                                <br>
                                                <h4 id=""><?php echo $cart->uc_email; ?></h4>
                                                <br>
                                                <h4 id=""><?php echo $cart->uc_street_number.' '.$cart->uc_street; ?></h4>
                                                <h4><?php echo $cart->uc_city.', '.$cart->uc_state.' '.$cart->uc_zip; ?></h4>
                                                <br>
                                                <br>
                                                <h4 id=""><?php echo !empty($cart->uc_payment_date) ? $cart->uc_payment_date : "-"; ?></h4>
                                                <br>
                                                <h4 id=""><?php echo $this->cart->showCartStatus($cart->uc_status); ?></h4>
                                                <br>
                                                <h4 id=""><?php echo !empty($cart->uc_shipping) ? $cart->uc_shipping : "-"; ?></h4>
                                                <br>
                                                <h4 id=""><?php echo !empty($cart->uc_ship_date) ? $cart->uc_ship_date : "Processing - Usually takes 2-3 days business before shipping." ?></h4>
                                                <br>
                                                <h4 id=""><?php echo !empty($cart->uc_tracking_code) ? $cart->uc_tracking_code : "-"; ?></h4>
                                                <br>
                                                <h4 id=""><?php echo !empty($cart->uc_ship_notes) ? $cart->uc_ship_notes : "-"; ?></h4>
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
                                                            <td> <?php echo $item->p_price; ?> </td>
                                                            <td> <?php echo $item->c_qty; ?> </td>
                                                            <td> <?php echo $item->ps_price; ?> </td>
                                                            <td> <?php echo number_format(MAT_PRICE,2); ?> </td>
                                                            <td> <?php echo $item->c_final_price; ?> </td>
                                                        </tr>
                                                    <?php
                                                        $total += $item->c_final_price;
                                                    }
                                                    ?>

                                            </tbody>
                                        </table>

                                                <br>
                                                <h4>Total Price: <?php echo number_format($total,2); ?></h4>
                                                <br>
                                                <h4>Shipping: <?php echo !empty($cart->uc_shipping) ? number_format($cart->uc_shipping,2) : "-"; ?></h4>
                                                <br>
                                                <h4>Final Price: <?php echo !empty($cart->uc_shipping) ? number_format(($total+$cart->uc_shipping),2) : "-"; ?>
                                                <br>
                                                <br>
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