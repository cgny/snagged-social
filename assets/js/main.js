var cart_id = false;

jQuery(document).ready(function ($) {
    "use strict";
    $(".carousel-inner .item:first-child").addClass("active");
    /* Mobile menu click then remove
    ==========================*/
    $(".mainmenu-area ul.nav.navbar-nav li a").on("click", function () {
        $(".mainmenu-area .navbar-collapse").removeClass("in");
    });
    
    var surl = window.location.href.split("#");
    if(surl.length > 1 && ( $('#'+surl[1]).length > 0 || surl[1] == "media" || surl[1] == "instagram" ))
    {
      $('#home').removeClass('in').removeClass('active');
      $('#li_home').removeClass('active');
      $('#'+surl[1]).addClass('active').removeClass('fade');
      $('#li_'+surl[1]).addClass('active');
      
      if(surl[1] == "media")
      { 
        //loadMedia();
        //getUserData();
      }
      else if(surl[1] == "instagram")
      {
          getInstagramMedia();
      }
    } 
	
    $("#getSales").on("click",function(){
            getUserSales();
    });

    $("#getOrders").on("click",function(){
            getUserOrders();
    });

    $("li a").click(function(){
        $('li').removeClass('active');
    });

    //loadMedia();
    checkWidth();
    $(window).resize(function(){
        checkWidth();
    });

    function checkWidth()
    {
        if($(window).width() < 780)
        {
            $('#userLinks').removeClass('hide');
        }
        $('body, .maincontent, #main_container').width($(window).width());
    }
    
    $('#ship_country').change(function()
    {
        
    });

    $('#calculate_shipping, .checkout').click(function()
    {

        var proceed = true;
        $.each($('.add_req'),function(x,y){
            if($(y).val() == "")
            {
                $(y).addClass('alert-danger');
            }
            else
            {
                $(y).removeClass('alert-danger');
            }
        });
        if(proceed == false)
        {
            return false;
        }

        var formData = {
                            'to_first_name' : $('#first_name').val(),
                            'to_last_name' : $('#last_name').val(),
                            'to_street' : $('#to_street').val(),
                            'to_city' : $('#to_city').val(),
                            'to_state' : $('#to_state').val(),
                            'to_zip' : $('#to_zip').val(),
                            'to_country' : $('#to_country').val()
                        };

        $('#ship_cost').html('0.00');
        $('#ship_duration, #ship_info').html('');
        var total = getTotal();

        $.ajax({
            type : 'POST',
            url  : base_url + 'usps/getShippingCost',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {

                }
                else
                {
                    $('#ship_notify').remove();
                    $('#stipe_div').removeClass('hide');
                    var g_total = parseFloat(data.rate[0]) + parseFloat(total);
                    $('#stripe_button').attr('data-amount',(g_total.toFixed(2)*100));
                    $('#ship_cost').html(data.rate[0]);
                    $('#cart_total').html( '$'+g_total );
                    $('#ship_info').html(data.service[0]);
                    var duration = false;
                    if(data.hasOwnProperty('duration'))
                    {
                        if(data.duration){
                            duration = data.duration[0];
                        }
                    }
                    $('#ship_duration').html(duration);
                }
            } else {
                // display success message

            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });
    });

    $('a').click(function()
    {
       $('.li.active').removeClass('active');
        if(this.id != 'user')
        {
            $('#userLinks').addClass('hide');
        }
    });

    $('#user').click(function(){
        $('#userLinks').removeClass('hide');
    });

    /*------------------
    Light-box
    --------------------*/
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        showImageNumberLabel: false,
    });



    /* Gallery Slider Active
    =============================*/
    $('.full_screen_slider').owlCarousel({
        loop: true,
        items: 1,
        responsiveClass: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 4000,
        smartSpeed: 2000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
    });

    $(".owl-controls").append('<button id="full_screen_btn" type="button"><i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></button>');
    $('#full_screen_btn').on("click", function () {
        $(this).toggleClass('expand');
    });
    /*
	Load more content with jQuery - May 21, 2013
	(c) 2013 @ElmahdiMahmoud
*/
    $(function () {
        $(".gallery_single_item").slice(0, 6).show();
        $("#lode_more").on('click', function (e) {
            var hidden = $('#gallery .gallery_photo').find(':hidden').length;
            if(hidden == 0)
            {
                alert('No more photos');
                return false;
            }
            e.preventDefault();
            $(".gallery_single_item:hidden").slice(0, 3).slideDown();
            if ($(".gallery_single_item:hidden").length == 0) {
                $("#lode_more").fadeOut('slow');
            }
            $('html,body').animate({
                scrollTop: $(this).offset().top
            }, 1500);
        });
    });


    var $formsearch = $('#search-form');
    $formsearch.submit(function (e) {
        // remove the error class
        $('.form-group').removeClass('has-error');
        $('.help-block').remove();

        // get the form data
        var formData = {
            'tags' : $('#tags').val().split(" "),
            'users' : $('#users').val().split(" ")
        };


        // process the form
        $.ajax({
            type : 'POST',
            url  : base_url + 'media/search',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            $('#search .row.photos').html('Loading...');
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                $('#search .row.photos').html('');
                // display success message
                for(var x in data.photos)
                {
                    var img = '<div class="col-xs-12 col-sm-6 col-md-4 gallery_single_item" style="display:block">'+
                              '<div class="gallery_item">'+
                              '<div class="gallery_photo">'+
                              '<a href="#single" class="view-img" data-toggle="pill">'+
                              '<img class="photo-select-cart" src="'+ data.photos[x].p_url +'" alt="" data-p_id="'+ data.photos[x].p_id +'">'+
                              '</a>'+
                              '</div>'+
                              '<div class="gallery_icon">'+
                              '<a href="'+ data.photos[x].p_url +'" data-lightbox="roadtrip"><i class="fa fa-search-plus"></i></a>'+
                              '</div>'+
                              '<div class="gallery_details">'+
                              '<div class="pull-left">'+
                              '<a href="#"><h5 class="text-uppercase gellary_heading" >'+ data.photos[x].a_ig_username +'</h5></a>'+
                              '</div>'+
                              '</div>'+
                              '</div>'+
                              '</div>';
                    $('#search .row.photos').append(img);
                }
            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });
        e.preventDefault();

    });


    $('#My-Account-link').click(function (e) {
        // remove the error class
        $('.form-group').removeClass('has-error');
        $('.help-block').remove();

        // process the form
        //loadMedia();
        //getUserData();
        e.preventDefault();

    });



    $('#My-Instagram-link').click(function (e) {
        // remove the error class
        $('.form-group').removeClass('has-error');
        $('.help-block').remove();

        // process the form
        getInstagramMedia();

    });

	$('#li_gallery').click(function(){
		getUpdatedGallery();
	});


    $( document ).on( "click", ".photo-select-save", function() {
        var p_ig_id = $(this).attr('data-p_ig_id');
        if($(this).hasClass('select-remove'))
        {
            var c = confirm('Do you want to remove this photo?');
            if(c)
            {
                removeSave(p_ig_id);
                $(this).removeClass('select-remove');
                $(this).parent().parent().remove();
            }
        }
        else
        {
            if(addSave(p_ig_id))
            {
                $(this).addClass('select-save');
            }
        }
	loadMedia();
    });


    $( document ).on( "click", ".photo-select-active", function() {
        var p_ig_id = $(this).attr('data-p_ig_id');
        if($(this).hasClass('select-inactive'))
        {
            var c = confirm('Do you want to set this photo inactive?');
            if(c)
            {
                setActiveInactive(p_ig_id,0);
                $(this).removeClass('select-inactive').addClass('select-active').html('Set Active');
            }
        }
        else
        {
            setActiveInactive(p_ig_id,1);
            $(this).removeClass('select-active').addClass('select-inactive').html('Set Inactive');
        }
        loadMedia();
    });






    $( document ).on( "click", ".view-img", function() {
        $('li').removeClass('active');
        var src = $(this).find('img').attr('src');
        var p_id = $(this).find('img').attr('data-p_id');
        $('#detail-img')
          .attr('data-p_id',p_id)
          .attr('src',src);
	$('#img_size').val(1);

        var formData = {
            'p_id' : p_id
        };

        $.ajax({
            type : 'POST',
            url  : base_url + 'media/imgDetails',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                // display success message
                $('#img_user').html('<a href="http://www.instagram.com/'+data.photo.a_ig_username+'" target="_blank">'+data.photo.a_ig_username+'</a>');
                $('#img_profile').attr('src',data.photo.a_ig_profile);
                $('#img_details').html(data.photo.p_caption);
                $('#img_price').html(data.photo.p_price);
                $('#total_price').html(1 * data.photo.p_price + parseFloat($('#total_price').attr('data-material')));
                $('#add_cart').attr('data-p_id',data.photo.p_id);
            }
        }).fail(function (data) {
            // for debug
            //console.log(data);
        });

    });

    $('#img_size').change(function(){
        var cost = $('option:selected', this).attr('data-price');
        $('#total_price').html( +$('#img_price').text() + +cost + +$('#total_price').attr('data-material') );
    });

    $(document).on( "click",".view_user_cart", function() {
        cart_id = $(this).attr('data-cart');
        $( "#Cart-link" ).trigger( "click" );
    });



	updateCart();
    $( document ).on( "click", "#Cart-link", function() {
        updateCart();
    });

    $( document ).on( "click", ".increase_qty, .decrease_qty", function() {

        var item_id = $(this).attr('data-id');
        var value = 1;
        if ($(this).hasClass('decrease_qty')) {
            value = -1;
        }

        var qty = $('#qty_' + item_id).text();
        qty = ( (qty*1) + value );

        var formData = {
            'c_id' : item_id,
            'c_qty' : qty
        };

        $.ajax({
            type : 'POST',
            url  : base_url + 'cart/updateQty',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                // display success message
                $('#qty_'+item_id).text(qty);
                var total = $('#price_'+item_id).attr('data-price') * qty;
                $('#total_'+item_id).text('$ '+total.toFixed(2)).attr('data-amount',total.toFixed(2));
                getTotal();
            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });

    });

    $( document ).on( "click", ".add_to_cart", function() {
        var p_id = $(this).attr('data-p_id');

        var formData = {
            'p_id' : p_id,
            'img_size' : $('#img_size').val()
        };


        $.ajax({
            type : 'POST',
            url  : base_url + 'cart/addToCart',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                // display success message
                alert('Added');
		updateCart();
            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });

    });

    //remove cart item

    $( document ).on( "click", ".remove_item", function() {

        var item_id = $(this).attr('data-id');
        var formData = {
            'p_id' : item_id
        };

        $.ajax({
            type : 'POST',
            url  : base_url + 'cart/removeFromCart',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                // display success message
                $('#item_' + item_id).slideUp(1000).remove();
		updateCart();
            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });

    });




    $( document ).on( "click", ".update_price", function() {
        var p_id = $(this).attr('data-p_id');

        var formData = {
            'p_id' : p_id,
            'p_price' : $('#photo_price_'+p_id).val()
        };

        if($('#photo_price_'+p_id).val() < 1)
        {
          $('#photo_price_'+p_id).addClass('alert-danger').attr('placeholder','Greater than 0');
          return false;
        }


        $.ajax({
            type : 'POST',
            url  : base_url + 'media/updatePrice',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                // display success message
                alert('Updated');
            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });

    });
    //resync_photo

    $( document ).on( "click", ".resync_photo", function() {
        var p_ig_id = $(this).attr('data-p_ig_id');

        var formData = {
            'p_ig_id' : p_ig_id
        };


        $.ajax({
            type : 'POST',
            url  : base_url + 'media/resyncPhoto',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                // display success message
                alert('Synced');
                loadMedia();
            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });

    });

    $(document).on("click","#update_user",function(){

        var formData = {
          'first_name' : $('#first_name').val(),
          'last_name' : $('#last_name').val(),
          'phone' : $('#phone').val(),
          'email' : $('#email').val(),
          'currency' : $('#currency').val(),
          'country' : $('#country').val(),
          'business_name' : $('#business_name').val(),
          'business_url' : $('#business_url').val(),
          'address_1' : $('#address_1').val(),
          'address_2' : $('#address_2').val(),
          'city' : $('#city').val(),
          'state' : $('#state').val(),
          'postal_code' : $('#postal_code').val(),
          'ein' : $('#ein').val(),
          'dob_m' : $('#dob_m').val(),
          'dob_d' : $('#dob_d').val(),
          'dob_y' : $('#dob_y').val()
        };
		
		if (!formData.email) {
			$('#email').addClass('alert-danger');
			return false;
		}

        if (!formData.first_name) {
            $('#first_name').addClass('alert-danger');
            return false;
        }

        if (!formData.last_name) {
            $('#last_name').addClass('alert-danger');
            return false;
        }

		$('#email').removeClass('alert-danger');
		$('#business_name').removeClass('alert-danger');
		$('#email').removeClass('alert-danger');

		var result = "Success";
		var result_class = "";

        $.ajax({
            type : 'POST',
            url  : base_url + 'account/update',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
					result = "Update Failed.";
					result_class = "alert-danger";
                }
            } else {
                // display success message
				result = "Update Successful!";
				result_class = "alert-success";
            }
			
			$('#update_result').html(result).addClass(result_class);
            window.load( base_url+'/#user-account' );
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });

    });

    $('.checkout').click(function(){
        //chargeCard(stripe);
    });
    
    $('#card_number').keyup(function(){
       
       if($(this).val().length == 16)
       {
           var formatted = "";
           var chars = $(this).val().split('');
           $.each(chars,function(x,y){
               
               formatted += y;
               if(parseFloat(x+1) % 4 == 0 && x < 15)
               {
                   formatted += " ";
               }              
           });
           $(this).attr('maxlength',19).val(formatted);
       }
       else
       {
           $(this).attr('maxlength',16).val($(this).val().replace(/\s/g, ''));
       }
        
    });



    $('.view_payouts').click(function(){
        var id = $(this).attr('data-id');
        $('.payments_'+id).toggle();
    });

    $('.set_as_shipped').click(function(){
        var cart_id = $(this).attr('data-cart_id');
        var c_id = $(this).attr('data-id');

        if( $('#carrier_'+cart_id).val() == "")
        {
            alert('Select Carrier');
            return false;
        }

        var btn = $(this);

        var tracking = prompt("Tracking number");
        if(tracking == "")
        {
            alert("Add Tracking Number");
            return false;
        }

        var formData = {
            "cart_id"   : cart_id,
            "c_id"      : c_id,
            "carrier"   : $('#carrier_'+c_id).val(),
            "tracking"  : tracking,
            "status"    : 3
        };

        var result = "";
        var result_class = "";

        $.ajax({
            type : 'POST',
            url  : base_url + 'admin/updateCart',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data)
        {
            // handle errors
            if (!data.success)
            {
                if (data.error.message)
                {
                    alert(data.error.message);
                }
            }
            else
            {
                // display success message
                btn.parent().next().html('Shipped');
                btn.parent().html('');
            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });
    });

    /*
    *
    *

    FUNCTIONS

    *
    *
     */
    
    function getInstagramMedia()
    {
        $.ajax({
            type : 'POST',
            url  : base_url + 'media/recentMedia',
            data : null,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            $('#instagram .row.photos').html('Loading...');
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                $('#instagram .row.photos').html('');
                // display success message
                for(var x in data.photos)
                {
                    var img = '<div class="col-xs-12 col-sm-6 col-md-4 gallery_single_item" style="display:block">'+
                              '<div class="gallery_item">'+
                              '<div class="gallery_photo">'+
                              '<a href="#" class="" data-toggle="pill">'+
                              '<img class="photo-select-save" data-p_ig_id="'+ data.photos[x].p_ig_id +'" data-p_id="'+ data.photos[x].p_id +'" src="'+ data.photos[x].p_url +'" alt="">'+
                              '</a>'+
                              '</div>'+
                              '<div class="gallery_icon">'+
                              '<a href="'+ data.photos[x].p_url +'" data-lightbox="roadtrip"><i class="fa fa-search-plus"></i></a>'+
                              '</div>'+
                              '</div>'+
                              '</div>';
                    $('#instagram .row.photos').append(img);
                }
                loadMedia();
            }
        }).fail(function (data) {
            // for debug
            //////console.log(data);
        });
        //e.preventDefault();
    }

    function chargeCard(stripe)
    {
        var total = getTotal();
        var paymentRequest = stripe.paymentRequest({
            country: 'US',
            currency: 'usd',
            total: {
                label: 'Demo total',
                amount: (total*100),
            },
        });

        var success = false;
        var formData = {'token' : token};
        $.ajax({
            type : 'POST',
            url  : base_url + 'cart/checkout',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {

                }
            } else {
                success = true;
            }
        }).fail(function (data) {
            // for debug
            //console.log(data);
        });
    }

    function updateCart() {
        var row = '<div class="col-xs-12">'+
                  '<div class="col-xs-2">'+
                  'Item'+
                  '</div>'+
                  '<div class="col-xs-2">'+
                  'Image Details'+
                  '</div>'+
                  '<div class="col-xs-2 text-right">'+
                  'Qty'+
                  '</div>'+
                  '<div class="col-xs-3 text-right">'+
                  'Price'+
                  '</div>'+
                  '<div class="col-xs-2 text-right">'+
                  'Total'+
                  '</div>'+
                  '<div style="border-top:1px solid lightGrey" class="space-20"></div>';
        $('#cart .row.items').html(row);

        var id = cart_id;

        $.ajax({
            type : 'POST',
            url  : base_url + 'cart/getCartItems?id='+id,
            data : null,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            cart_id = false;
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                // display success message

                var item = "";
                var total = 0.00;
                for(var x in data.items)
                {
                    total.toFixed(2);
                    var item_total = ( (MAT_PRICE + parseInt(data.items[x].p_price) + parseInt(data.items[x].ps_price)) * data.items[x].c_qty );
                    item = '<div class="col-xs-12" id="item_'+ data.items[x].c_id +'" >'+
                           '<div class="col-xs-2">'+
                           (x*1+1) +
                           '</div>'+
                           '<div class="col-xs-2">'+
                           '<img class="cart_photo" src="'+ data.items[x].p_url +'" alt="">'+
                           '<br><br>'+data.items[x].ps_size +' - Inches <br> Vinyl poster print'+
                           '</div>'+
                           '<div class="col-xs-2 text-right">'+
                           '<button class="btn-xs decrease_qty" data-id="'+ data.items[x].c_id +'"> - </button> &nbsp; '+
                           '<span id="qty_'+data.items[x].c_id+'">'+ data.items[x].c_qty +'</span>'+
                           ' &nbsp; <button class="btn-xs increase_qty" data-id="'+ data.items[x].c_id +'"> + </button>'+
                           '</div>'+
                           '<div class="col-xs-3 text-right">'+
                           '<h4 class="item_prices" id="price_'+data.items[x].c_id+'" data-price="'+ (MAT_PRICE + parseInt(data.items[x].p_price) + parseInt(data.items[x].ps_price)).toFixed(2) +'">'+ 
                             '$ '+ parseFloat(MAT_PRICE + parseFloat(data.items[x].p_price) + parseFloat(data.items[x].ps_price)).toFixed(2) 
                           +'<br> size +($'+data.items[x].ps_price+')</h4>'+
                           '</div>'+
                           '<div class="col-xs-2 text-right">'+
                           '<b>'+
                           '<h4 class="item_totals" id="total_'+data.items[x].c_id+'" data-amount="'+item_total.toFixed(2)+'">$ '+ item_total.toFixed(2) +'</h4>'+
                           '<br><button id="rmv_'+data.items[x].c_id+'" class="btn btn-default remove_item glyphicon glyphicon-remove" data-id="'+ data.items[x].c_id +'">Remove</button>'+
                           '</b>'+
                           '</div>'+
                           '</div>'+
                           '<div class="space-20"></div>';
                    $('#cart .row.items').append(item);

                }
                getTotal();
            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });
    }

    function updateMedia() {
        //code
    }

    function addSave(id)
    {
        var success = false;
        var c = confirm("Save to your media to showcase?");
        if(c)
        {

            var formData = {
                'p_ig_id' : id
            };
            $.ajax({
                type : 'POST',
                url  : base_url + 'media/saveMedia',
                data : formData,
                dataType : 'json',
                encode : true
            }).done(function (data) {
                // handle errors
                if (!data.success) {
                    if (data.errors.message) {
                        $('#message-field').addClass('has-error');
                        $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                        alert(data.errors.message);
                    }
                } else {
                    success = true;
                    alert('Saved');
                    loadMedia();
                    getUpdatedGallery();
                }
            }).fail(function (data) {
                // for debug
                //console.log(data);
            });

        }
        return success;
    }

    function removeSave(id)
    {
        var success = false;

            var formData = {
                'p_ig_id' : id
            };
            $.ajax({
                type : 'POST',
                url  : base_url + 'media/removeMedia',
                data : formData,
                dataType : 'json',
                encode : true
            }).done(function (data) {
                // handle errors
                if (!data.success) {
                    if (data.errors.message) {
                        $('#message-field').addClass('has-error');
                        $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                    }
                } else {
                    success = true;
                    alert('Removed');
                    loadMedia();
                    getUpdatedGallery();
                }
            }).fail(function (data) {
                // for debug
                //console.log(data);
            });
        return success;
    }

    function setActiveInactive(id,active)
    {
        var success = false;

            var formData = {
                'p_ig_id'   : id,
                'active'    : active
            };
            $.ajax({
                type : 'POST',
                url  : base_url + 'media/setActiveInactive',
                data : formData,
                dataType : 'json',
                encode : true
            }).done(function (data) {
                // handle errors
                if (!data.success) {
                    if (data.errors.message) {
                        $('#message-field').addClass('has-error');
                        $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                    }
                } else {
                    success = true;
                    alert('Removed');
                    loadMedia();
                    getUpdatedGallery();
                }
            }).fail(function (data) {
                // for debug
                //console.log(data);
            });
        return success;
    }


    function getTotal() {
        var items = $('.item_totals');
        var total = 0.00;
        $.each(items,function(x,y){
            total = ( total + $(y).attr('data-amount') * 1 );
            //console.log(total);
        });
        
        //subtotal
        $('#sub_total').text('$'+ total.toFixed(2) );
        
        //grand total
        total = total + parseFloat($('#ship_cost').html());        
        $('#cart_total').text('$'+ total.toFixed(2) );
        
        if(items.length > 0){
            $('#shipping').show();
            $('#cart_prompt').html('Please review your order<br>Each poster has a $15.00 materials fee.');
            $('#cart_count').text("("+items.length+")");
        }
        else
        {
            $('#shipping').hide();
            $('#cart_prompt').text('Cart Empty');
            $('#cart_count').text('');
        }
        return total;
    }

	

    function getUserData()
    {
        return false;
    }
	
	function getUserOrders(args) {
		
		 var success = false;
        var formData = [];
        $.ajax({
            type : 'POST',
            url  : base_url + 'account/getUserOrders',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                success = true;
             
		var html2 = "<div class='col-xs-12 col-md-6'>"+               
                            "<div id='collapseOrders' class='collapse col-lg-12' style='border:1px grey solid;padding:2px;max-height:400px;overflow-y: scroll;'>"+
							"<h4>Orders</h4>"+           
                            '<table class="table table-striped">'+
                            '<thead>'+
                            '<tr>'+
                            '<th scope="col">#</th>'+
                            '<th scope="col">Created</th>'+
                            '<th scope="col">Shipped</th>'+
                            '<th scope="col">Status</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody>';
                for(var x in data.orders)
                {
                    html2 += '<tr>'+
                             '<td scope="row" class="view_user_cart" data-cart="'+ data.orders[x].uc_id+ '">'+ data.orders[x].uc_id+ '</td>'+
                             '<td>'+ data.orders[x].uc_created+ '</td>'+
                             '<td>'+ data.orders[x].uc_shipping+ '</td>'+
                             '<td>'+ data.orders[x].cs_status+ '</td>'+
                             '</tr>';
                }

                html2 += "</tbody>"+
                         "</table>"+
                         "</div>"+
                         "</div>";
			}
			$('#orders').html(html2);
		}).fail(function (data) {
            // for debug
            ////console.log(data);
        });
	}
	
	function getUserSales(args) {
		
		var success = false;
        var formData = [];
        $.ajax({
            type : 'POST',
            url  : base_url + 'account/getUserSales',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
				
		var html3 = "<div class='col-xs-12 col-md-6'>"+                                
                            "<div id='collapseSales' class='collapse col-lg-12'  style='border:1px grey solid;padding:2px;max-height:400px;overflow-y: scroll;'>"+
							"<h4>Sales</h4>"+                      
                            '<table class="table table-striped">'+
                            '<thead>'+
                            '<tr>'+
                            '<th scope="col">#</th>'+
                            '<th scope="col">Id</th>'+
                            '<th scope="col">Size</th>'+
                            '<th scope="col">Date</th>'+
                            '<th scope="col">Payment</th>'+
                            '<th scope="col">Paid</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody>';
                for(var x in data.sales)
                {
                    var success = "Not Paid";
                    if(data.sales[x].ap_success == 1)
                    {
                        success = "Paid";
                    }
                    
                    html3 += '<tr>'+
                             '<td scope="row" class="view_user_cart" data-cart="'+ data.sales[x].uc_id+ '">'+ data.sales[x].uc_id+ '</td>'+
                             '<td>'+ data.sales[x].p_id+ '</td>'+
                             '<td>'+ data.sales[x].ps_size+ '</td>'+
                             '<td>'+ data.sales[x].uc_payment_date+ '</td>'+
                             '<td>'+ data.sales[x].ap_payment+ '</td>'+
                             '<td>'+ success + '</td>'+
                             '</tr>';
                }

                html3 += "</tbody>"+
                         "</table>"+
                         "</div>"+
                         "</div>";

			}
			$('#sales').html(html3);
		}).fail(function (data) {
            // for debug
            ////console.log(data);
        });
		
	}

    function addCart(id)
    {
        var c = confirm("Add to cart?")
        if(c)
        {
            return true;
        }
        return false;
    }

    function removeCart(id)
    {



    }

    function loadMedia()
    {
        
        $.ajax({
            type : 'POST',
            url  : base_url + 'media/',
            data : null,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            $('#media .row.photos').html('Loading...');
            if (!data.success) {
                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                $('#user_images .row.photos').html('');
                // display success message

                var table = "<div id='all_photos'>" +
                            "<div class='col-lg-12'>" +
                            "<div id='collapsePhotos' class='col-lg-12' style='border:1px grey solid;padding:2px;max-height:1000px;overflow-y: scroll;margin-bottom:10px'>" +
                            '<table class="table table-striped">' +
                            "<thead>"+
                                '<tr>'+
                                '<th scope="col">Photo Id</th>'+
                                '<th scope="col">Img</th>'+
                                '<th scope="col">Price</th>'+
                                '<th scope="col">IG Resync/Update</th>'+
                                '<th scope="col">Remove</th>'+
                                '<th scope="col">Link</th>'+
                            '  </tr>' +
                            '</thead>' +
                            '<tbody>';


                for(var x in data.photos)
                {
                    table += '<tr>'+
                                '<td> '+ data.photos[x].p_id +'</td>'+
                                '<td> <img style="width:250px" class="" data-p_id="'+ data.photos[x].p_id +'" src="'+ data.photos[x].p_url +'" alt=""> </td>'+
                                '<td> <input type="text" id="photo_price_'+ data.photos[x].p_id +'" data-p_id="'+ data.photos[x].p_id +'" value="'+ data.photos[x].p_price +'" /> <button data-p_id="'+ data.photos[x].p_id +'" class="update_price">Update</button> </td>'+
                                '<td> <button data-p_ig_id="'+ data.photos[x].p_id +'" class="resync_photo">Resync from Instagram</button> </td>'+
                                '<td> <button data-p_ig_id="'+ data.photos[x].p_id +'" class="photo-select-save select-remove is-button">Remove From Media</button> </td>'+
                                '<td> <a href=""'+ data.photos[x].p_url +'" data-lightbox="roadtrip"><i class="fa fa-search-plus"></i></a> </td>'+
                                '</tr>';
                        }

                    table += '</tbody>' +
                            '</table>'+
                        '</div>'+
                    '</div>'+
                    '</div>';

                $('#user_images .row.photos').append(table);

            }
        }).fail(function (data) {
            // for debug
            ////console.log(data);
        });

    }
	
	function getUpdatedGallery() {
		//getGallery
		 $.ajax({
                type : 'POST',
                url  : base_url + 'media/getGallery',
                data : null,
                dataType : 'json',
                encode : true
            }).done(function (data) {
                // handle errors
                if (!data.success) {
                    if (data.errors.message) {
                        $('#message-field').addClass('has-error');
                        $('#message-field').find('.col-lg-10').append('<span class="help-block">' + data.errors.message + '</span>');
                    }
                } else {
					
					var html = "";
					
					for (var x in data.photos) {
						html += '<div class="col-xs-12 col-sm-6 col-md-4 gallery_single_item">'+
                            '<div class="gallery_item">'+
                                '<div class="gallery_photo">'+
                                    '<a href="#single" class="view-img" data-toggle="pill">'+
										'<img class="photo-select-cart" data-p_id="'+ data.photos[x].p_id +'" src="'+ data.photos[x].p_url +'" alt="">'+
									'</div>'+
                                '<div class="gallery_icon">'+
                                    '<a href="'+ data.photos[x].p_url +'" data-lightbox="roadtrip"><i class="fa fa-search-plus"></i></a>'+
                                '</div>'+
                                '<div class="gallery_details">'+
                                    '<div class="pull-left">'+
                                        '<a href="#"><h5 class="text-uppercase gellary_heading" > '+ data.photos[x].a_ig_username +' &nbsp;&nbsp; | &nbsp;&nbsp;  $'+ data.photos[x].p_price +'</h5></a>'+
                                    '</div>'+
                                    '<div class="pull-right text-right">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
					}
                    $('#gallery .row.photos').html(html);
					$('#gallery .row.photos .gallery_single_item').css({'display':'block'});
					
                }
            }).fail(function (data) {
                // for debug
                //console.log(data);
            });
	}
	
	function userNotLoged() {
		alert('You have been logged out.');
		window.location.assign(base_url);
	}

}(jQuery, window, document));


/* Preloader Js
===================*/
jQuery(window).on("load", function () {
    $('.preeloader').fadeOut(500);

});
