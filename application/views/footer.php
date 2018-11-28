 <!--Footer Area Start-->
    <footer class="white-bg footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 xs-center">
                    <a href="<?php echo site_url(); ?>"><img src="<?php echo IMAGE_INCLUDE; ?>snagged-social-logo.jpg" alt=""></a> 
		&nbsp;&nbsp;&nbsp; &reg; <?php echo date("Y"); ?>
                </div>
                <div class="col-xs-12 col-sm-6 text-right xs-center">
                    <div class="space-10"></div>
                    <ol class="breadcrumb text-uppercase social_menu">
                        <li><a href="http://www.instagram.com/snaggedsocial"><i class="fa fa-instagram"></i></a></li>
                    </ol>
                </div>
            </div>
        </div>
    </footer>
    <!--Footer Area End-->

    <!--All Script Hare-->


<script src="<?php echo JS_INCLUDE; ?>vendor/jquery-1.12.4.min.js"></script>
<script src="<?php echo JS_INCLUDE; ?>vendor/bootstrap.min.js"></script>
<script src="<?php echo JS_INCLUDE; ?>owl.carousel.min.js"></script>
<script src="<?php echo JS_INCLUDE; ?>jquery.scrollUp.js"></script>
<script src="<?php echo JS_INCLUDE; ?>mixitup.min.js"></script>
<script src="<?php echo JS_INCLUDE; ?>lightbox.js"></script>
<script src="<?php echo JS_INCLUDE; ?>wow.min.js"></script>
<script src="<?php echo JS_INCLUDE; ?>contact-form.js"></script>
<script src="<?php echo JS_INCLUDE; ?>plugins.js"></script>
<!-- Active Js-->
 
 <script src="https://checkout.stripe.com/checkout.js"></script>
 <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
 <script type="text/javascript">
   Stripe.setPublishableKey('<?php echo STRIPE_PUB_TEST_KEY; ?>');
 </script>
 <script>
   var stripe = Stripe('<?php echo STRIPE_PUB_TEST_KEY; ?>');
   var MAT_PRICE = <?php echo MAT_PRICE; ?>;
 </script>
<script src="<?php echo JS_INCLUDE; ?>main.js"></script>
<!-- Full Javascript code-->
<script src="<?php echo JS_INCLUDE; ?>fullscreen.js"></script>
	<?php

	//echo $this->url->generateAssets(array("js"));

	?>

 <?php

    if($this->account->isLogged() == true){

 ?>

 <script>

    var ua = navigator.userAgent,
    touchClick = (ua.match(/iPad/i)) ? "touchstart" : "click";    
    var device = (ua.match(/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini|mobile|tablet/i)) ? "mobile" : "desktop";

     function stripeResponseHandler(status, response) {
         if (response.error) {
             // show the errors on the form
             $("#add_card_form_errors").text(response.error.message);
             $('#clockBack').fadeOut();
         } else {
             $("#add_card_form_errors").text('Adding...');
             var form$ = $("#add_card");
             // token contains id, last4, and card type
             var token = response['id'];
             // insert the token into the form so it gets submitted to the server
             form$.append("<input type='hidden' name='stripeToken' id='stripeToken' value='" + token + "'/>");
             // and submit
             var stripeToken = $('#stripeToken').val();
             var last4 = $('#card_number').val().replace(/\s/g, '');
             var last4 = last4.substr(12,15);

             $.post('<?php echo site_url(); ?>/account/addCard',{stripeToken:stripeToken,last4:last4},function(data){
                 $('#stripeToken').remove();
                 console.log(data.success);
                 if (data.success == true) {
                     $("#add_card_form_errors").html('Added Successfuly!').css({'color':'green'});
                     $('do_addCard').removeClass('btn-primary').addClass('btn btn-success').text('Reload').attr('id','refresh');
                     $('#stripe_auth').show();
                 }else{
                     $("#add_card_form_errors").text('An Error Occured!').css({'color':'red'});
                 }

             });

         }
     }

     $(function(){

         $('body').delegate('#do_addCard',touchClick,function(){

             Stripe.card.createToken({
                 number: $('#card_number').val().replace(/\s/g, ''),
                 cvc: $('#card_cvc').val(),
                 exp_month: $('#card_exp_month').val(),
                 exp_year: $('#card_exp_year').val()
             }, stripeResponseHandler);

         });

     });

     $('body').delegate('#refresh',touchClick,function(){
         window.location.reload();
     });



 </script>

<?php } ?>




</body>
</html>
