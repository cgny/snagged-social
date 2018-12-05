<?php include 'header.php'; ?>

    <main class="maincontent">
        <div id="main_container" class="tab-content">
            <div class="gray-bg tab-pane fade in active" id="home">
	            <h1 id="main_logo" style="">Snagged Social</h1>
                <div class="container">
                    <div class="space-60"></div>
                    <div class="row">
                        <!--Home Slider Item Start-->
                        <div class="col-xs-12 img-thumbnail" style="background: transparent;border:0px">
                            <div class="col-xs-12 col-sm-6">
                                    <h2>Take Photos</h2>
                                    <h2>Post Them on Instagram</h2>
                                    <h2>Sell Them Here</h2>
                            </div>
                            <div  class="col-xs-12 col-sm-6 pull-right text-right ">
                                    <h2>Free Account</h2>
                                    <h2>Setup Instantly</h2>
                                    <h2>Create Your Portfolio</h2>
                            </div>
                        </div>	
                        <div class="col-xs-12 img-thumbnail">
                            <div id="full_screen_slider" class=" full_screen_slider fix" style="height:800px;overflow-y:hidden">
                                <?php
								//$main = [];
                                  foreach($main as $m_photo)
                                  {
                                        ?>
                                        <div class="slide_item">
                                                <a href="#single" class="view-img" data-toggle="pill">
                                                  <img class="photo-select-cart" data-p_id="<?php echo $m_photo->p_id; ?>" style="max-width:99%;min-height:800px" src="<?php echo $m_photo->p_url; ?>" alt="">
                                                </a>
                                        </div>
                                        <?php
                                  }
                                ?>
                            </div>
                        </div>
                        <!--Home Slider Item Strat-->
                    </div>
                            <div class="space-80"></div>
                            <div class="row" style="background: white;padding: 10px">
                            <div class="col-md-6">
                                  <h2>Snagged Social</h2>
                                    <div class="space-10"></div>
                                    <h3>Your online portfolio</h3>
                                        <div class="space-10"></div>
                                                             <h4>Sell your beautiful photos to anyone in the world.</h4>
                                         </div>
                                         <!--About Text-->
                                         <div class="col-md-6">
                                           <p class="font-weight-bold">Do you have beautiful, amazing, breath-taking photos on Instagram?

                                         <br><br>
                                         Pictures of sunsets, friends and family, food, nature, automobiles or whatever?
                                         <br><br>
                                                                         Put them on Snagged Social to sell.
                                         Your photos are works of art and some people would love to purchase your art.
                                                                         Post as many photos as you want for free. You only pay a fee when your photos sale.

                                         <br><br>Set your own prices! Get paid right away! Use any major debit card to get paid within 3-5 business days.

                                       </p>
                                </div>
                            </div>
	                
	                <div class="space-80"></div>
		                <div class="col-xs-12 col-md-12">
			                <img src="<?php echo IMAGE_INCLUDE; ?>scuba.jpg" class="img-thumbnail" alt="">
		                </div>
                            <div class="space-80"></div>
                            <div class="row"  style="background: white;padding: 10px">
                                    <div class="col-md-6">
                                    <h2>How It Works</h2>
                         <div class="space-20"></div>
                                    <h3>Connect</h3>
                         <div class="space-10"></div>
                                    <span>
                                            Create a free account with Snagged Social.
                                            Add your bank account or debit card to get payments. You will never be charged.
                                    </span>
                                    <div class="space-20"></div>

                                    <h3>Snag it</h3>
                                    <div class="space-10"></div>
                                    <span>
                                            Pick which photos you want to offer for sell on the site.
                                            There is no cost to sell your items. You get a commission from each sale.
                                    </span>
                                     <div class="space-20"></div>

                                                <h3>Price it</h3>
                                     <div class="space-10"></div>
                                                <span>Put your own price.</span>
                                     <div class="space-20"></div>


                                                <h3>Sell it</h3>
                                     <div class="space-10"></div>
                                                <span>People will buy what they like! Only pay a 5% fee.</span>
                                     <div class="space-20"></div>


                                                <h3>Get Paid</h3>
                                     <div class="space-10"></div>
                                                <span>Get a direct payment to your bank account or debit card.</span>
                                     <div class="space-20"></div>

                             </div>

                            <div class="col-md-6">
                                    <h2>Terms</h2>
                                    <br>
                                            There are no fees to join. There is no limit to your gallery of photos. Photos must not contain any hate, insults, violence or any sexual acts.
                                    <br><br>
                                    No personal information is shared or sold to anyone. We will save your Instagram username, bio, profile photo and any photos you want to be sold.
                                    <br><br>
                                    Photos can be deleted added or removed at any time and your account can be paused or deleted at anytime as well. 
                                    <br><br>
                                    Snagged Social reserves the right to reject and terminate any inappropriate photos and users.
                            </div>
                    </div>

                </div>
                <div class="space-60"></div>
            </div>
            <!--About Area Start-->
            <section id="about" class=" tab-pane fade" >
                <div class="container">
                    <div class="row">
                        <!--About Photo-->
                        <div class="col-xs-12 col-md-6">
                            <img src="<?php echo IMAGE_INCLUDE; ?>camera_about.jpg" class="img-thumbnail" alt="">
                        </div>
                        <!--About Text-->
                        <div class="col-xs-12 col-md-6">
                            <div class="space-80"></div>
                            <h1>Snagged Social</h1>
                            <div class="space-10"></div>
							<h2>About Us</h2>
                            <div class="space-20"></div>
                            <p>We offer a unique service for photographers, professional and amateur, to sell their photos to the world. Our platform is a global system that uses Instagram to retrieve your images you can choose to showcase. There is no cost to the photographer to showcase your photos. You only pay when you sell. Join and sell in minutes. Anyone can join from anywhere in the world. Make money just taking photos!</p>
				<p>No need to make an account with us. You will click the "login" link on our page to sync your account to connect your photos to Snagged Social. From there you can pick which photos you want to showcase. You can add more photos or remove them at any time.</p>
                            <div class="space-10"></div>
                            <p>The world would love to see your work!</p>
                            <div class="space-30"></div>
                            
                            <div class="space-60"></div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="howitworks" class=" tab-pane fade" >
                <div class="container">
                    <div class="row">
                        <!--About Photo-->
                        <div class="col-xs-12 col-md-6">
                            <img src="<?php echo IMAGE_INCLUDE; ?>howitworks.png" class="img-thumbnail" alt="">
                        </div>
                        <!--About Text-->
                        <div class="col-xs-12 col-md-6">
                            <div class="space-80"></div>
                            <h1>Snagged Social</h1>
                            <div class="space-10"></div>
                            <h2>How it Works</h2>
                            <br>
                            <h3>Sellers</h3>
                            <br>
                            <ol>
                                <li>Create an Instagram account and/or connect your Instagram by clicking on the login link</li>
                                <li>Click on &quot;Authorize Payments&quot; and sign up for a Stripe account in order to receive payments by adding a bank account or debit card.</li>
                                <li>Click on &quot;My Instagram&quot; and click on the photos you want to save. the last 200 will be pulled.</li>
                                <li>Once you pick through all the images you want to use, you can set your prices.</li>
                                <li>Once you've set your pricing, your images will be displayed on the gallery.</li>
                                <li>A buyer will click on your images from the gallery and choose a size. Each size has a price. There is a $15.00 materials fee for each work.</li>
                                <li>Once the buyer checks out, they will provide their shipping address and pay with a credit card.</li>
                                <li>After the buyer pays, we will send you a 95% of your price you set. You only pay a 5% fee.</li>
                                <li>The money will be sent to your Stripe account immediately but it will be deposited on a weekly basis. You can change this in your Stripe account.</li>
                                <li>We will handle the order and mail the poster to the customer.</li>
                                <br>
                                <li>While logged in you can review your art sales and your personal purchases.</li>
                                <li>You can update your personal information, change your pricing, remove images and add new images anytime from your Instagram account. </li>
                            </ol>
                            <br>
                            <h3>Buyers</h3
                            <br>
                            <br>
                            <ol>
                                <li>Select the images you want to buy from the gallery or search what type of art you want.</li>
                                <li>Select the size of the image you want then add it to your cart.</li>
                                <li>You can change the quantity of items you want to purchase in your cart.</li>
                                <li>Add your address then click on "Calculate Shipping". (Global Shipping Available)</li>
                                <li>Finally click on "Pay with Stripe" to complete your order.</li>
                                <li>You will be mailed your order within 5-7 business days.</li>
                            </ol>
                            
                            <div class="space-60"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!--About Area End-->
            <!--Gallery Area Start-->
            <section id="gallery" class="tab-pane fade">
                <div class="container">
	                <div class="space-20"></div>
	                <h3>Shopping Gallery</h3>
	                <div class="space-60"></div>
                    <div class="row photos">

                  <?php
                    foreach($media as $photo)
                    {
                  ?>
                       		<div class="col-xs-12 col-sm-6 col-md-4 gallery_single_item">
                            <div class="gallery_item">
                                <div class="gallery_photo">
                                    <a href="#single" class="view-img" data-toggle="pill">
                                        <img class="photo-select-cart" data-p_id="<?php echo $photo->p_id; ?>" src="<?php echo $photo->p_url; ?>" alt="">
                                    </a>                                
                                </div>
                                <div class="gallery_icon">
                                    <a href="<?php echo $photo->p_url; ?>" data-lightbox="roadtrip"><i class="fa fa-search-plus"></i></a>
                                </div>
                                <div class="gallery_details">
                                    <div class="pull-left">
                                        <a href="#"><h5 class="text-uppercase gellary_heading" ><?php echo $photo->a_ig_username; ?> &nbsp;&nbsp; | &nbsp;&nbsp;  $<?php echo $photo->p_price; ?></h5></a>
                                    </div>
                                    <div class="pull-right text-right">
                                    </div>
                                </div>
                            </div>
                        </div>
                  <?php
                    }
                  ?>
                    </div>
                    <div class="row">
                        <div class="space-20"></div>
                        <div class="col-xs-12 text-center">
                            <a href="#" id="lode_more" class="rounded-bttn">Show More</a>
                        </div>
                        <div class="space-60"></div>
                    </div>
                </div>
            </section>
            <!--Gallery Area End-->
            <!-- Search results -->
            <section id="search" class="tab-pane fade">
                <div class="container">
									<!-- Search Form -->
										<div class="contact-form">
									            <div id="" class="" role="dialog">
									                <div class="modal-dialog modal-lg">
									                    <!-- Modal content-->
									                    <div class="modal-content">
									                        <div class="modal-body">
									                            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
									                            </button>
									                            <div class="space-10"></div>
									                            <div class="row">
									                                <div class="col-xs-12 text-center">
									                                    <h2 class="modal-title">Search Form</h2>
									                                </div>
									                            </div>
									                            <div class="space-40"></div>
									                            <form action="/www.snaggedsocial.com/index.php/Media/search" id="search-form" method="post">
									                                <div class="row">
									                                    <div class="col-xs-12 col-sm-6">
									                                        <div class="form-group" id="name-field">
									                                            <label for="form-name" class="sr-only">Tags</label>
									                                            <input type="text" class="form-control" id="tags" name="form-tags" placeholder="love art beaches" >
									                                        </div>
									                                        <div class="space-10"></div>
									                                    </div>
									                                    <div class="col-xs-12 col-sm-6">
									                                        <div class="form-group">
									                                            <label for="form-email" class="sr-only">Usernames</label>
									                                            <input type="text" class="form-control" id="users" name="form-usernames" placeholder="username">
									                                        </div>
									                                        <div class="space-10"></div>
									                                    </div>
									                                    <div class="space-20"></div>
									                                    <div class="col-xs-12 text-center">
									                                        <button type="submit" class="rounded-bttn gray-bttn">Search</button>
									                                    </div>
									                                </div>
									                            </form>
									                        </div>
									                    </div>
									                </div>
									            </div>
									        </div>
										<!-- End Search -->
                    <div class="space-60"></div>
                    <div class="row photos">


			</div>
			</div>
			</section>


	<section id="user-account" class="tab-pane fade">
                <div class="container">
	                <div class="space-20"></div>
	                <h3>User Account</h3>
	                <div class="space-60"></div>
                            <div id="user_account">


                                <?php
                                    if($this->account->isLogged() == true) {

                                            $user       = $this->account->getUser();
                                            $countries  = $this->data->getCountries();
                                            $currencies = $this->data->getCurrencies();

                                            $email_notice = "";
                                            if(empty($user->a_email))
                                            {
                                                $email_notice = "Please add your email address. It is required for payouts.";
                                            }

                                            $card_notice = "";
                                            if(empty($user->card))
                                            {
                                                $card_notice = "Please add your debit card. It is required for payouts.";
                                            }

                                            $country_field = "<select id='country' class='form-control'>";
                                            foreach($countries as $county)
                                            {
                                                if($user->a_country == $county->country_code)
                                                {
                                                    $co_sel = "selected";
                                                }
                                                else
                                                {
                                                    $co_sel = "";
                                                }
                                                $country_field .= '<option value="'. $county->country_code .'"  '. $co_sel .'>'. $county->country_code .' - '.  $county->country_name .'</option>';
                                            }
                                            $country_field .= '</select>';

                                            $currency_field = "<select id='currency' class='form-control'>";
                                            foreach($currencies['currency'] as $code => $currency)
                                            {
                                                if($user->a_currency == $currency)
                                                {
                                                    $cu_sel = "selected";
                                                }
                                                else
                                                {
                                                    $cu_sel = "";
                                                }

                                                if( empty( $user->a_currency ) && $currency == "USD")
                                                {
                                                    $cu_sel = "selected";
                                                }

                                                $currency_field .= '<option value="'. $code .'"  '. $cu_sel .'>'. $code .' - '.  $currency .'</option>';
                                            }
                                            $currency_field .= '</select>';

                                        ?>

                                        <div class='col-xs-12 col-lg-12'>
                                        <img src='<?php  echo $user->a_ig_profile; ?>' /><br><br>
                                        <h4><?php  echo $user->a_ig_username; ?> </h4><br>
                                        <form onsubmit="return false;" method="post" action="<?php echo site_url('/account/update'); ?>" data-id="<?php $user->a_ig_id ?>">
                                            <div class="panel-body col-lg-6">

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">First Name</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='first_name' value='<?php echo $user->a_first_name; ?>' placeholder='' />
                                                        </div>
                                                    </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Last Name</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='last_name' value='<?php echo  $user->a_last_name; ?>' placeholder='' />
                                                        </div>
                                                    </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Business Name (optional)</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='business_name' value='<?php echo  $user->a_business_name; ?>' placeholder='' />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Business Url (optional)</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='business_url' value='<?php echo  $user->a_business_url; ?>' placeholder='www.mysite.com' />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Phone Number</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='phone' value='<?php  echo $user->a_phone; ?>' placeholder='212 555 1212' />
                                                        </div>
                                                    </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Email</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='email' value='<?php  echo $user->a_email; ?>' placeholder='' />
                                                        </div>
                                                    </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Address Line 1</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='address_1' value='<?php  echo $user->a_address_1; ?>' placeholder='' />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Address Line 2 (optional)</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='address_2' value='<?php echo  $user->a_address_2; ?>' placeholder='' />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">City</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='city' value='<?php  echo $user->a_city; ?>' placeholder='' />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">State</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='state' value='<?php  echo $user->a_state; ?>' placeholder='' />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Zip/ Postal Code</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='postal_code' value='<?php echo  $user->a_postal_code; ?>' placeholder='' />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">EIN Tax ID (optional)</label>
                                                    <div class="col-lg-9">
                                                        <input class='form-control' type='text' id='ein' value='<?php echo  $user->a_ein; ?>' placeholder='' />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Date Of Birth <br> M-D-Y</label>
                                                    <div class="col-lg-9">
                                                        <select class='form-control' style="width:33%;float:left" type='text' id='dob_m'>
                                                            <?php
                                                                for($x=1;$x<13;$x++)
                                                                {
                                                                    $sel = "";
                                                                    if($x == $user->a_dob_m)
                                                                    {
                                                                        $sel = "selected";
                                                                    }
                                                                    echo "<option value='$x' $sel>$x</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                        <select class='form-control' style="width:33%;float:left" type='text' id='dob_d'>
                                                            <?php
                                                            for($x=1;$x<32;$x++)
                                                            {
                                                                $sel = "";
                                                                if($x == $user->a_dob_d)
                                                                {
                                                                    $sel = "selected";
                                                                }
                                                                echo "<option value='$x' $sel>$x</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <select class='form-control' style="width:33%;float:left" type='text' id='dob_y'>
                                                            <?php
                                                            for($x=( date("Y") - 17);$x>1910;$x--)
                                                            {
                                                                $sel = "";
                                                                if($x == $user->a_dob_y)
                                                                {
                                                                    $sel = "selected";
                                                                }
                                                                echo "<option value='$x' $sel>$x</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Country</label>
                                                    <div class="col-lg-9">
                                                        <?php echo $country_field; ?>
                                                        </div>
                                                    </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Currency</label>
                                                    <div class="col-lg-9">
                                                        <?php echo $currency_field; ?>
                                                        </div>
                                                    </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Update</label>
                                                    <div class="col-lg-9">
                                                        <button id='update_user'>Update</button> <span id='update_result'></span> <br><br>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>




                                            <div class="space-20"></div>





                                        </div>



                                        <?php

                                    }else{
                                        echo "<a href='". site_url('Auth') ."'> Login </a>";
                                    }
                                ?>

                            </div>


                        
                    <div class="space-60"></div>
		</div>
	</section>


            <section id="user-sales" class="tab-pane fade">
                <div class="container">
                    <div class="space-20"></div>
                    <h3>Items Sold</h3>
                    <div class="space-60"></div>
                    <div id="user_sales">


                        <?php
                                    if($this->account->isLogged() == true) {
                                        $sales  = $this->account->findMySales();


                        ?>

                        <div class="space-20"></div>

                        <div id='sales'>
                            <div class='col-lg-12'>
                                <div id='collapseSales' class='col-lg-12' style='border:1px grey solid;padding:2px;max-height:400px;overflow-y: scroll;margin-bottom:10px'>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Receipt #</th>
                                            <th scope="col">Photo Id</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Purchased</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Profit</th>
                                            <th scope="col">Payout</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        foreach($sales as $k => $sale)
                                        {

                                            $success = "Not Sent";
                                            if($sale->ap_success == 1)
                                            {
                                                $success = "Sent";
                                            }

                                            ?>
                                            <tr>
                                                <td scope="row" class="view_user_cart" data-cart="<?php echo $sale->uc_id; ?>"><?php echo ($k+1);  ?></td>
                                                <td> <?php echo $sale->uc_id; ?> </td>
                                                <td> <?php echo $sale->p_id; ?> </td>
                                                <td> <?php echo $sale->ps_size; ?> </td>
                                                <td> <?php echo $sale->c_qty; ?> </td>
                                                <td> <?php echo $sale->uc_payment_date; ?> </td>
                                                <td> <?php echo $sale->cs_status; ?> </td>
                                                <td> <?php echo $sale->ap_amount; ?> </td>
                                                <td> <?php echo $success; ?> </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <?php

                                    }else{
                                        echo "<a href='". site_url('Auth') ."'> Login </a>";

                                    }

                        ?>


                    </div>

                    <div class="space-60"></div>

                </div>

            </section>


            <section id="user-orders" class="tab-pane fade">
                <div class="container">
                    <div class="space-20"></div>
                    <h3>Personal Orders</h3>
                    <div class="space-60"></div>
                    <div id="user_orders">


                        <?php
                        if($this->account->isLogged() == true) {

                            $orders = $this->cart->getAllCarts(null, $user->a_id);


                        ?>

                        <div class="space-20"></div>

                        <div id='orders'>
                            <div class=' col-lg-12'>
                                <div id='collapseOrders' class='col-lg-12' style='border:1px grey solid;padding:2px;max-height:400px;overflow-y: scroll;margin-bottom:10px'>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Created</th>
                                            <th scope="col">Shipped</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Receipt</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        foreach ($orders as $order) {

                                            ?>
                                            <tr>
                                                <td scope="row" class="view_user_cart"
                                                    data-cart="<?php echo $order->uc_id; ?>"><?php echo $order->uc_id; ?></td>
                                                <td> <?php echo $order->uc_created; ?> </td>
                                                <td> <?php echo $order->uc_shipping; ?> </td>
                                                <td> <?php echo $order->cs_status; ?> </td>
                                                <td> <a href="<?php echo site_url('cart/receipt/' . $orders->uc_cart_id); ?>" target="_blank">View</a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <?php

                        }else{
                            echo "<a href='". site_url('Auth') ."'> Login </a>";

                        }

                        ?>


                    </div>

                    <div class="space-60"></div>

                </div>

            </section>



            <section id="user-gallery" class="tab-pane fade">
                <div class="container">
                    <div class="space-20"></div>
                    <h3>Your Gallery</h3>
                    <h5>Note: Images must have a price greater than $0.00 to be available for purchase and displayed in the Snagged Social gallery.</h5>
                    <div class="space-60"></div>
                    <div id="user_gallery">


                        <?php

                        if($this->account->isLogged() == true) {
                            $gallery_photos = $this->media->getSSMedia($user->a_id,false);

                        ?>

                        <div class="space-20"></div>

                        <div class="col-lg-12" id="user_images">
                            <hr>


                            <h4>Images (<?php echo count($gallery_photos); ?>)</h4>
                            <div class="clear"><br></div>
                            <div class="row photos">

                                <div id='all_photos'>
                                    <div class='col-lg-12'>
                                        <div id='collapsePhotos' class='col-lg-12' style='border:1px grey solid;padding:2px;max-height:1000px;overflow-y: scroll;margin-bottom:10px'>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Photo Id</th>
                                                    <th scope="col">Img</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">IG Resync/Update</th>
                                                    <th scope="col">Active/Inactive</th>
                                                    <th scope="col">Delete</th>
                                                    <th scope="col">Link</th>
                                                </tr>
                                                </thead>
                                                <tbody>


                                                <?php

                                                foreach($gallery_photos as $gallery_photo)
                                                {

                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $gallery_photo->p_id; ?> </td>
                                                        <td> <img style="width:250px" class="" data-p_id="<?php echo $gallery_photo->p_id; ?>" src="<?php echo $gallery_photo->p_url; ?>" alt=""> </td>
                                                        <td> <input type="text" id="photo_price_<?php echo $gallery_photo->p_id; ?>" data-p_id="<?php echo $gallery_photo->p_id; ?>" value="<?php echo $gallery_photo->p_price; ?>" /> <button data-p_id="<?php echo $gallery_photo->p_id; ?>" class="update_price">Update</button> </td>
                                                        <td> <button data-p_ig_id="<?php echo $gallery_photo->p_ig_id; ?>" class="resync_photo">Resync from Instagram</button> </td>
                                                        <td> <button data-p_ig_id="<?php echo $gallery_photo->p_ig_id; ?>" class="photo-select-save select-remove is-button">Delete From Gallery</button> </td>
                                                        <td> <button data-p_ig_id="<?php echo $gallery_photo->p_ig_id; ?>" class="photo-select-active select-<?php echo ($gallery_photo->p_active == 1) ? "inactive" : "active"; ?> is-button"><?php echo ($gallery_photo->p_active == 1) ? "Set Inactive" : "Set Active"; ?></button> </td>
                                                        <td> <a href="<?php echo $gallery_photo->p_url; ?>" data-lightbox="roadtrip"><i class="fa fa-search-plus"></i></a> </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                       <?php

                        }else{
                            echo "<a href='". site_url('Auth') ."'> Login </a>";
                        }

                        ?>


                    </div>

                    <div class="space-60"></div>

                </div>

            </section>

        <!-- PHOTOS -->
        <section id="instagram" class="tab-pane fade">
                        <div class="container">
                            <div class="space-20"></div>
                            <h3>Your Instagram Feed</h3>
                            <div class="space-60"></div>
                            <div class="space-60"></div>
                            <div class="row photos">

                                <?php

                                if(empty($this->account->isLogged()))
                                {
                                    echo "<a href='". site_url('Auth') ."'> Login </a>";
                                }

                                ?>

                    </div>
                </div>
            </section>

                    <!-- CARD -->



	        <section id="add-card" class="tab-pane fade">
		        <div class="container">
			        <div class="space-20"></div>
			        <h3>Debit Card Payouts</h3>
			        <div class="space-60"></div>
			        <div class="row cardDetails">

				        <?php
				            if($this->account->isLogged() == true){
				        ?>
                                    


				        <form action="<?php echo site_url('account/addCard'); ?>" class="form-horizontal" id="add_card" method="post">

					        <div class="panel-body">

								        <div class="form-group">
									        <label class="col-lg-2 control-label">Information</label>
									        <div class="col-lg-6">
										        We do not store your credit card information. Our CC processor Stripe.com, collects the information securely, encrypts it and stores it in a data vault. A unique ID is generated for your CC which we use to process payments. We only save the last 4 numbers.
									        </div>

								        </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Name On Card</label>
                                        <div class="col-lg-3">
                                            <input type="text" maxlength="200" size="20" class="form-control"  name="name_on_card" id="name_on_card" placeholder=""/>

                                        </div>

                                    </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Last 4 SSN (US Only)</label>
                                    <div class="col-lg-1">
                                        <input type="text" maxlength="4" size="20" class="form-control" name="ssn_last_4" id="ssn_last_4" placeholder=""/>
                                    </div>
                                </div>

								        <div class="form-group">
									        <label class="col-lg-2 control-label">Card Number</label>
									        <div class="col-lg-3">
										        <input type="text" maxlength="16" size="20" class="form-control" data-stripe="number" name="card_number" id="card_number" placeholder=""/>

									        </div>

								        </div>

								        <div class="form-group">
									        <label class="col-lg-2 control-label">CVC</label>
									        <div class="col-lg-1">
										        <input type="text" maxlength="4" size="20" class="form-control" data-stripe="cvc" name="card_cvc" id="card_cvc" placeholder=""/>
									        </div>
								        </div>


								        <div class="form-group">
									        <label class="col-lg-2 control-label">Exp. Month</label>
									        <div class="col-lg-3">
										        <select id="card_exp_month"  name="card_exp_month" data-stripe="exp-month" class="form-control">

											        <?php


											        for($x=1;$x<=12;$x++){
												        echo "<option value='$x'>$x</option>";
											        }


											        ?>

										        </select>
									        </div>
								        </div>


								        <div class="form-group">
									        <label class="col-lg-2 control-label">Exp. Year</label>
									        <div class="col-lg-3">
										        <select id="card_exp_year" name="card_exp_year" data-stripe="exp-year" class="form-control">

											        <?php

											        $y = date("Y");

											        for($x=$y;$x<=($y+10);$x++){
												        echo "<option value='$x'>$x</option>";
											        }


											        ?>

										        </select>
									        </div>
								        </div>
                                                    
                                        <div class="form-group">
									        <label class="col-lg-2 control-label">Current Card</label>
									        <div class="col-lg-3">
                                                <span id="last4"><?php echo $user->stripe_card_num; ?></span>
									        </div>
								        </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Submit</label>
                                    <div class="col-lg-6">
                                        Buy Adding your card, you agree to <a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripes agreement.</a>
                                        <br>
                                        <button class="btn btn-primary" id="do_addCard"  onClick="return false;" type="submit">Add Card</button>
                                    </div>
                                </div>



								        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="" id="add_card_form_errors">

								       </span>
                                                                        

						        </form>


				        <?php

				            } else {
                                echo "<a href='". site_url('Auth') ."'> Login </a>";
                            }

                            ?>

			        </div>
		        </div>
	        </section>


	        <section id="single" class="tab-pane fade">
                <div class="container">
	                <div class="space-20"></div>
	                <h3>Photo Details</h3>
	                <div class="space-60"></div>
                    <div class="row">
                        <!--Image Detail-->
                        <div class="col-xs-12 img-thumbnail">
                            <div id="" class="">
                                <div class="slide_item col-xs-4">
                                    <img id="detail-img" class="" data-p_id="" style="max-height:500px;width:auto !important;" src="" alt="">
                                </div>
                                <div class="slide_item col-xs-4">
                                     <p>Details</p>
                                    <p id="img_details"></p>
                                </div>

	                            <div class="col-xs-4 pull-right">
		                            <div class="col-xs-6">
			                            <h4 id="img_user"></h4>
			                            <br>
			                            <img style="width:50px" id="img_profile" src="" />
		                            </div>
	                            </div>

                                <div class="col-xs-12 pull-right">
                                        <div class="col-xs-4">
                                                <h4 id=""></h4>
                                                <br>
                                                <br>
                                                <h4 id="">Price</h4>
                                                <br>
                                                <h4 id="">Size</h4>
                                                <br>
                                                <h4 id="">Poster print</h4>
                                                <br>
                                                <h4 id="">Total</h4>
                                                <br>
                                                <br>
                                        </div>
                                        <div class="col-xs-6">
                                                <br><br>
                                                <h4 id="">$<span id="img_price"></span></h4>
                                                <br>
                                                <select id="img_size">
                                                        <?php
                                                        foreach($this->media->getPhotoSizes() as $size){
                                                        ?>
                                                                <option value="<?php echo $size->ps_id; ?>" data-price="<?php echo $size->ps_price; ?>"><?php echo $size->ps_size; ?> (inches) +$<?php echo ($size->ps_price); ?></option>
                                                        <?php } ?>
                                                </select>
                                                <br>
                                                <br>
                                                <h4 id="">$<span id="material_price"><?php echo MAT_PRICE; ?></span></h4>
                                                <br>
                                                <h4 id="">$<span id="total_price" data-material="<?php echo MAT_PRICE; ?>"><?php echo MAT_PRICE; ?></span></h4>
                                                <br>
                                                <br>
                                                <a id="add_cart" data-p_id="" class="contact_bttn add_to_cart">Add To Cart</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!--Home Slider Item Strat-->
                    </div>
                </div>
            <div class="space-60"></div>
        </section>

	<section id="cart" class="tab-pane fade">
        <div class="container">
	        <div class="space-20"></div>
	        <h3>Shopping Cart</h3>
	        <div class="col-xs-12 text-right">
		        <br>
		        <div class="space-20"></div>
		        <h4 id="cart_prompt">Cart Empty</h4>
	        </div>
					<div class="space-60"></div>
					<div class="row items">


			</div>
			<div class="col-xs-12 text-right">
				<label for="sub_total">Sub Total</label><br>
			<span id="sub_total" class="sub_total cart_total" data-cart="0">$0.00</span>
			<br>
				<div class="space-20"></div>
                <div class="space-20"></div>
<div id="shipping">
                                        <p id="ship_notice">*Shipping will be calculated once the  shipping address is entered.</p>
                                        <?php

                                              //$cart = $this->cart->getUserCart($c_id);
                                        ?>


                                        <div id="first_name_div" class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input type="text" id="first_name" class="form-control" placeholder="First Name"/>
                                        </div>

                                        <div id="last_name_div" class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" id="last_name" class="form-control" placeholder="Last Name"/>
                                        </div>

                                        <div id="zip_div" class="form-group">
                                                <label for="to_zip">Street Address</label>
                                                <input type="text" id="to_street" class="add_req form-control" placeholder="Enter Street" />
                                        </div>

                                        <div id="zip_div" class="form-group">
                                                <label for="to_zip">City</label>
                                                <input type="text" id="to_city" class="add_req form-control" placeholder="Enter City"/>
                                        </div>

                                        <div id="zip_div" class="form-group">
                                                <label for="to_zip">State/Province</label>
                                                <input type="text" id="to_state" class="add_req form-control" placeholder="Enter State/Province"/>
                                        </div>

                                <div id="country_div" class="form-group">
                                        <label for="ship_country">Ship Country</label>
                                        <select id="to_country" class="add_req form-control">
                                                <?php
                                                foreach($this->usps->getShipCountries() as $country)
                                                {
                                                        $sel = "";
                                                        if($country->country_name == "United States")
                                                        {
                                                                $sel = "selected";
                                                        }
                                                        echo "<option value='". $country->country_name ."' $sel>". $country->country_name ."</option>";
                                                }
                                                ?>
                                        </select>
                                </div>

                                        <div id="zip_div" class="form-group">
                                                <label for="to_zip">Zip/Postal Code</label>
                                                <input type="text" id="to_zip" class="add_req form-control" placeholder="Enter Zip/Postal Code"/>
                                        </div>


<div class="space-20"></div>
                                        <a id="calculate_shipping" class="btn btn-success">Calculate shipping</a>
                                        <div class="space-20"></div>
                                        <label for="ship_cost">Shipping Cost</label><br>
                                        $<span type="text" id="ship_cost" class="cart_info">0.00</span>
                                        <div class="space-20"></div>
                                        <label for="ship_info">Shipping Service</label><br>
                                        <span type="text" id="ship_info" class="cart_info"></span>
                                        <div class="space-20"></div>
                                        <label for="ship_duration">Addt. Shipping Info</label><br>
                                        <span type="text" id="ship_duration" class="cart_info"></span>
                                        <label for="cart_total">Grand Total</label><br>
                                        <span id="cart_total" class="cart_total" data-cart="0">$0.00</span>
                                                                <div class="space-20"></div>

                        <?php if(empty($this->account->isLogged())){ ?>
                                <span id="ship_notify">Enter Shipping Address</span>
                                <div id="stipe_div" class="hide">
                                        <form action="<?php echo site_url('cart/checkout'); ?>" method="POST">
                                                <script id="stripe_button"
                                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                        data-key="<?php echo STRIPE_PUB_TEST_KEY; ?>"
                                                        data-amount="0"
                                                        data-name="Snagged Social"
                                                        data-description="Artwork Posters"
                                                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                        data-locale="auto"
                                                        data-zip-code="true">
                                                </script>
                                        </form>
                                        </div>
                        <?php }else{ ?>
                                <span id="ship_notify">Enter Shipping Address</span>
                                <div id="stipe_div" class="hide" data-cart="<?php echo $this->cart->getCartId(); ?>">
                                        <form action="<?php echo site_url('cart/checkout'); ?>" method="POST">
                                                <script id="stripe_button"
                                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                        data-key="<?php echo STRIPE_PUB_TEST_KEY; ?>"
                                                        data-amount="0"
                                                        data-name="Snagged Social"
                                                        data-description="Artwork Posters"
                                                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                        data-locale="auto"
                                                        data-zip-code="true">
                                                </script>
                                        </form>
                                        </div>
                        <?php } ?>

                <div class="space-60"></div>
			</div>
		</div>
	</section>
                  
    </main>
