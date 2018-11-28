<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>

    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="shortcut icon" type="image/ico" href="assets/images/favicon.ico" />

    <link rel="stylesheet" href="<?php echo CSS_INCLUDE; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_INCLUDE; ?>owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo CSS_INCLUDE; ?>font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo CSS_INCLUDE; ?>animate.css">
    <link rel="stylesheet" href="<?php echo CSS_INCLUDE; ?>lightbox.css">

    <!-- Main-Stylesheets -->
    <link rel="stylesheet" href="<?php echo CSS_INCLUDE; ?>normalize.css">
    <link rel="stylesheet" href="<?php echo CSS_INCLUDE; ?>overright.css">
    <link rel="stylesheet" href="<?php echo CSS_INCLUDE; ?>style.css">
    <link rel="stylesheet" href="<?php echo CSS_INCLUDE; ?>responsive.css">
    <script src="<?php echo JS_INCLUDE; ?>vendor/modernizr-2.8.3.min.js"></script>
</head>

    <header class="white-bg header">
        <!--Main Menu Area Start-->
        <nav class="navbar navbar-default mainmenu-area">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainmenu">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
					<a class="logo navbar-brand fix" data-toggle="" href="<?php echo site_url(); ?>">
						<img src="<?php echo IMAGE_INCLUDE; ?>snagged-social-logo.jpg" alt="">
					</a>
                </div>
                <div class="collapse navbar-collapse navbar-right" id="mainmenu">
                    <ul class="nav navbar-nav text-uppercase mainmenu">
                        <li class="active" id="li_home"><a data-toggle="pill" href="#home">Home</a></li>
                        <li id="li_about"><a data-toggle="pill" href="#about">about</a></li>
                        <li id="li_gallery"><a data-toggle="pill" href="#gallery">gallery</a></li>
                        <li id="li_search"><a class=" text-uppercase" data-toggle="pill" href="#search">Search</a></li>
                        <li id="li_cart"><a class=" text-uppercase" data-toggle="pill" id="Cart-link" href="#cart">Cart <span id="cart_count"></span> </a></li>
                    <?php
                          if($this->account->isLogged()){

                              echo '<li id="li_user">';
                              echo "<a id='user' class=' text-uppercase'>User</a>";
                              echo "<ul id='userLinks' class='hide'>";

                            foreach($this->url->buildUserLinks() as $name => $link)
                            {
                            	$toggle = "pill";
                                if(in_array(strtolower($name),array("logout","admin")))
                                {
                                  $toggle = "";
                                }
                                echo "<li id='li_user'><a class=' text-uppercase' data-toggle='". $toggle ."' href='". $link ."' id='". $name ."-link'>". preg_replace('/[-]/', ' ',$name ) ."</a></li>";
                            }
                            echo "</ul>";
                            echo "</li>";
                          }else{
                          ?>
                        	<li><a class="text-uppercase" data-toggle="" href="<?php echo IG_REDIRECT; ?>">Login / Sign Up</a></li>
					<?php } ?>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li id="li_gallery"><a data-toggle="pill" href="#howitworks">How</a></li>
                        <li><a class=" text-uppercase" data-toggle="modal" href="#contact_form">Conact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--Main Menu Area End-->
        <!-- Conact Form Start-->
        <div class="contact-form">
            <div id="contact_form" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                            <div class="space-10"></div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <h2 class="modal-title">Contact Form</h2>
                                </div>
                            </div>
                            <div class="space-40"></div>
                            <form action="/www.snaggedsocial.com/index.php/Main/contact" id="contact-form" method="post">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group" id="name-field">
                                            <label for="form-name" class="sr-only">Full Name</label>
                                            <input type="text" class="form-control" id="form-name" name="form-name" placeholder="Full Name" required>
                                        </div>
                                        <div class="space-10"></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="form-email" class="sr-only">Phone</label>
                                            <input type="email" class="form-control" id="form-email" name="form-email" placeholder="Email" required>
                                        </div>
                                        <div class="space-10"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="form-subject" class="sr-only">Email</label>
                                            <input type="text" class="form-control" id="form-subject" name="form-subject" placeholder="Subject" required>
                                        </div>
                                        <div class="space-10"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="form-message" class="sr-only">Massege</label>
                                            <textarea class="form-control" rows="6" id="form-message" name="form-message" placeholder="Message" required></textarea>
                                        </div>
                                        <div class="space-10"></div>
                                    </div>
                                    <div class="space-20"></div>
                                    <div class="col-xs-12 text-center">
                                        <button type="submit" class="rounded-bttn gray-bttn">Submited</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Conact Form End-->
	
    </header>
<body>
