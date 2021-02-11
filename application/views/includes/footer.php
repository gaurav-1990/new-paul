<?php // print_r(count($this->session->userdata('addToCart'))); ?>
<div class="for-mob-foot">
    <p>More about Online Shopping at Paulsons <i class="fa fa-angle-down"></i></p>

</div>
<footer class="m-t-25">


    <div class="container">
        <div class="footer-in">

            <div class="row">
            <div class="col-sm-6 col-md-3 col-xs-12">
            <div class="block-set">
            <h3>About Us</h3>
            <p> Paulsons is one of the leading retailers in Haryana in ethnic apparels for women segment. We strive towards providing our patrons with the most contemporary & wide collection of Un-stitched Fabrics, Sarees, Readymades, Shawls & Stoles.</p>
            </div>
            <div class="guarntee">
                        <img src="<?= base_url() ?>bootstrap/images/orignal.png" alt=""/>
                        <p><strong>100% ORIGINAL</strong> guarantee for all products at www.paulsonsonline.com</p>
                    </div>
                
            </div>

                <div class="col-sm-6 col-md-3 col-xs-12">
                    <div class="block-set">

                        <ul>
                            <h3>ONLINE SHOPPING</h3>
                            <?php
                            $categories = getAllCategory();
                            foreach ($categories as $cat) {
                                $base_url = base_url('shop/') . cleanUrl($cat->cat_name) . "/" . encode($this->encryption->encrypt($cat->id));

                                ?>
                                <li>
                                    <a href="<?php // echo $base_url ?>"><?= $cat->cat_name ?></a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="<?=base_url()?>details/shop/best-seller/65bba8cf5cce467f5fc51a95127a79bbd9aa0977dd47e8c0637c3c4829fc54001d3a86c54b5081d693680f8bef898bdc90f931991dd611c53125a0bac86de0c7W4_FVxB4yDU3dWSY5hwwPnpBGiBBjgIkDP_TzXgINBY-">BEST SELLER</a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>details/shop/new-arrivals/22434d73df12e9caecdfa8cab532ac28a96d71d6c01ae22cb00886cc261a2c1f18abdc6ab8f8be0b701013c74144c461329e0760c7930bb652694ba4eb01990aT1mnmzGzF84ntNs_BmrNgxc280GanF1erx+REoKlX_M-">NEW ARRIVAL</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-xs-12">
                    <div class="block-set">

                        <ul>
                            <h3>USEFUL LINKS</h3>
                            <li>  
                                <a href="<?php  echo base_url('Myaccount/aboutus') ?>">About Us</a>
                            </li>
                            <li>
                                <a href="<?php // echo base_url('Myaccount/privacy') ?>">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('Myaccount/termncondition') ?>">Terms & Conditions</a>
                            </li>
                            <!--
                            <li>
                                <a href="<?php // echo base_url('Myaccount/payments') ?>">Payments</a>
                            </li>
                        -->
                            <li>
                                <a href="<?php echo base_url('Myaccount/returncancel') ?>">Return & Cancellation</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('Myaccount/shipcharges') ?>">Shipping Policy & Charges</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('Myaccount/fabric_care') ?>">Fabric Care & Wash Guidelines</a>
                            </li>
                            <!-- <li>
                                 <a href="<?php // echo base_url('Myaccount/disclaimer') ?>" target="blank">Disclaimer</a>
                             </li>
                             <li>
                                 <a href="<?php // echo base_url('Myaccount/faqscustomer') ?>" target="blank">FAQ'S for Customer</a>
                             </li>
                             <li>
                                 <a href="<?php // echo base_url('Myaccount/faqsvendor') ?>" target="blank">FAQ'S for Vendor</a>
                             </li> -->
                             <!--
                            <li>
                                <a href="<?php // echo base_url("Myaccount/storelocator") ?>">Store Locator</a>
                            </li>
                        -->
                            <!--  <li>
                                <a href="#" target="blank">Terms & Conditions</a>
                            </li>
                            <li>
                                <a href="#" target="blank">Disclaimer</a>
                            </li> -->


                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-xs-12">
                    <div class="block-set">
                        <!-- <h3>USEFUL LINKS</h3> -->
                        <!-- <div class="for-app">
                             <a href="#"> <img src="<?= base_url() ?>bootstrap/images/google.png" alt="" /> </a>
                             <a href="#"> <img src="<?= base_url() ?>bootstrap/images/ios.png" alt="" style=" width: 90%;" /></a>
                         </div> -->
                         <h3>EXCLUSIVE STORES</h3>
                         <p><strong>Rohtak</strong><br> Shop No 2, Palika Bazar Rohtak 124001</p>
                         <p><strong>Faridabad</strong><br>Crown Plaza Mall, Sector-15, Mathura Road Faridabad 121007</p>
                   
                     
                        
                    </div>
                </div>
            </div>
             <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="block-set">                   
                        <div class="social">
                            <h3>Follow Us:</h3>
                            <ul>
                                <li><a href="https://www.facebook.com/paulsonsonline/" target="_blank"> <i class="fa fa-facebook" aria-hidden="true"></i> </a></li>
                              
                                <li><a href="https://www.instagram.com/paulsonsshop/" target="_blank"> <i class="fa fa-instagram" aria-hidden="true"></i> </a></li>
                               </ul>
                                                     
                          </div>
                     <div class="phone-set">
                         <ul>
                            <li><i class="fa fa-whatsapp" aria-hidden="true"></i><a href="tel:+9174282-11662"> +91 74282-11662</a></li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:+91 74282-11662">+91 74282-11662</a></li>
                            <li><i class="fa fa-stopwatch"></i><a>Time: 11:00 AM - 07:00 PM Monday to Friday</a></li>
                         </ul>
                    
                    </div>
                     <div class="phone-set">
                         <ul>
                             <li><img class="lazy" data-src="<?= base_url()?>bootstrap/images/icons/visa.png"></li>
                             <li><img class="lazy" data-src="<?= base_url()?>bootstrap/images/icons/mastercard.png"></li>
                             <li><img class="lazy" data-src="<?= base_url()?>bootstrap/images/icons/express.png"></li>
                             <li><img class="lazy" data-src="<?= base_url()?>bootstrap/images/icons/discover.png"></li>
                    
                         </ul>
                    
                    </div>
                    </div>
                    <div class="disclame">
                        <!-- <p><strong>Disclaimer:</strong>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p> -->
                        <br><p>© 2020 www.paulsonsonline.com. All rights reserved. </p>
                    </div>
                </div>
            </div>
        </div>


        <!--         <div class="popular-search">
            <div class="heading-set">
                <h2>Popular Search</h2>
                <hr>

            </div>
            <div class="links-search">
                <a href="#">T-shirt</a>
                <a href="#">For girls</a>
                <a href="#">Hair band</a>
                <a href="#">Reebok shoes</a>
                <a href="#">Punjabi Suit</a>
                <a href="#">T-shirt</a>
                <a href="#">For girls</a>
                <a href="#">Hair band</a>
                <a href="#">Reebok shoes</a>
                <a href="#">Punjabi Suit</a>
                <a href="#">T-shirt</a>
                <a href="#">For girls</a>
                <a href="#">Hair band</a>
                <a href="#">Reebok shoes</a>
                <a href="#">Punjabi Suit</a>
                <a href="#">T-shirt</a>
                <a href="#">For girls</a>
                <a href="#">Hair band</a>
                <a href="#">Reebok shoes</a>
                <a href="#">Punjabi Suit</a>
                <a href="#">T-shirt</a>
                <a href="#">For girls</a>
                <a href="#">Hair band</a>
                <a href="#">Reebok shoes</a>
                <a href="#">Punjabi Suit</a>
                <a href="#">T-shirt</a>
                <a href="#">For girls</a>
                <a href="#">Hair band</a>
                <a href="#">Reebok shoes</a>
                <a href="#">Punjabi Suit</a>
                <a href="#">T-shirt</a>
                <a href="#">For girls</a>
                <a href="#">Hair band</a>
                <a href="#">Reebok shoes</a>
                <a href="#">Punjabi Suit</a>
                <a href="#">T-shirt</a>
                <a href="#">For girls</a>
                <a href="#">Hair band</a>
                <a href="#">Reebok shoes</a>
                <a href="#">Punjabi Suit</a>

            </div>

        </div>-->


      

      

       
        <!-- <div class="row">
            <div class="col-md-6 col-12 contact ">
                <p>© 2020 www.paulsonsonline.com. All rights reserved. </p>
            </div>
            <div class="col-md-6  contact">
                <p class="pull-right">Developed  by <a href="https://www.nibblesoftware.com/" target="_blank">NST</a>
                </p>
            </div>

        </div> -->


    </div>

    <div id="scrollDown">
        &nbsp;
    </div>

</footer>



<div class="for-whats-app">
         <a href="https://api.whatsapp.com/send?phone=9174282-11662&amp;text=Hi, I need some assistance." target="blank"></a>

     </div>


<!-- Back to top -->


<!-- Container Selection1 -->
<div id="dropDownSelect1"></div>

<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button"
     data-toggle="tooltip" data-placement="left">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
</a>

<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>allmedia/assets/js/jquery-2.2.0.min.js"></script>
<script src="<?= base_url('bootstrap/js/jquery.ui.js') ?>"></script>
<script src="<?= base_url() ?>bootstrap/js/magnifier.js" type="text/javascript"></script>

   

<script>
    var $zoom;
    $(document).ready(function () {
        $('.dropdown-menu').removeAttr("style");
        // Initiate magnification powers
        $zoom = $('.zoom').magnify({
            afterLoad: function () {
                //                console.log('Magnification powers activated!');
            }
        });
    });
    //    $('button').click(function () {
    //        $zoom.destroy();
    //    });
    $('html').on({
        magnifystart: function () {
            //            console.log('\'magnifystart\' event fired');
        },
        magnifyend: function () {
            //            console.log('\'magnifyend\' event fired');
        }
    });
    /*
     * This code will prevent unexpected menu close when using some components (like accordion, forms, etc)
     */
    $(document).on('click', '.yamm .dropdown-menu', function (e) {
        e.stopPropagation()
    })

    /*
     * jquery dependencies
     */

    /*global $ */
    $(document).ready(function () {



        //If width is less or equal to 943px dropdowns are displayed on click (thanks Aman Jain from stackoverflow)

        $(".menu-mobile").click(function (e) {
            $(".menu > ul").toggleClass('show-on-mobile');
            e.preventDefault();
        });
        //when clicked on mobile-menu, normal menu is shown as a list, classic rwd menu story (thanks mwl from stackoverflow)

    });
</script>
<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/bootstrap/js/popper.js"></script>
<script type="text/javascript" src="<?= base_url() ?>allmedia/bootstrap/js/bootstrap.min.js"></script>
 
<script src="<?= base_url() ?>allmedia/assets/js/addToCart.js" type="text/javascript"></script>

<script src="<?= base_url() ?>allmedia/assets/js/firstpageAddCart.js" type="text/javascript"></script>

<!--===============================================================================================-->

 

<!--===============================================================================================-->
 
<script src="<?= base_url() ?>bootstrap/js/owlcrousel.js" type="text/javascript"></script>
<script src="<?= base_url() ?>bootstrap/js/owlmain.js" type="text/javascript"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/lightbox2/js/lightbox.min.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/sweetalert/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.navbar .dropdown').hover(function () {
            $(this).find('.dropdown-menu').removeAttr("style");
            $(this).find('.dropdown-menu').first().stop(true, true).delay(100).fadeIn(500);
        }, function () {
            $(this).find('.dropdown-menu').removeAttr("style");
            $(this).find('.dropdown-menu').first().stop(true, true).delay(100).fadeOut(500);
        });
    });
</script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>bootstrap/js/main.js"></script>
 


<script>
    $("#latest").click(function () {
        var products = $('.mob-col-pad');
        products.sort(function (a, b) {
            return $(b).data("latest") - $(a).data("latest")
        });
        $('#myModal3').find("li>a").removeAttr("style");
        $(this).css({
            "color": "red"
        });
        products.parent().html(products);
        $('#myModal3').modal('toggle');
    });
    $("#hightoLow").click(function () {
        sortProductsPriceDescending();
        $('#myModal3').find("li>a").removeAttr("style");
        $(this).css({
            "color": "red"
        });

        $('#myModal3').modal('toggle');
    });
    $("#lowtoHigh").click(function () {
        sortProductsPriceAscending();
        $('#myModal3').find("li>a").removeAttr("style");
        $(this).css({
            "color": "red"
        });

        $('#myModal3').modal('toggle');
    });
    $("#new2old").click(function () {
        sortProductsPriceNew();
        $('#myModal3').find("li>a").removeAttr("style");
        $(this).css({
            "color": "red"
        });

        $('#myModal3').modal('toggle');
    });
    $("#old2new").click(function () {
        sortProductsPriceOld();
        $('#myModal3').find("li>a").removeAttr("style");
        $(this).css({
            "color": "red"
        });

        $('#myModal3').modal('toggle');
    });

    $(document).on("change", ".selection-2", function () {

        var sortingMethod = $(this).val();

         if (sortingMethod == 'l2h') {
            sortProductsPriceAscending();
        } else if (sortingMethod == 'h2l') {
            sortProductsPriceDescending();
        } else if (sortingMethod == 'def') {
            sortdef();
        
        } else if (sortingMethod == 'n2o') {
            sortProductsPriceNew();
        
        } else if (sortingMethod == 'o2n') {
            sortProductsPriceOld();
        }

    });

    function sortProductsPriceAscending() {
        var products = $('.mob-col-pad');

        products.sort(function (a, b) {
            return $(a).data("price") - $(b).data("price")
        });
        products.parent().html(products);

    }

    function sortProductsPriceDescending() {
        var products = $('.mob-col-pad');
        products.sort(function (a, b) {
            return $(b).data("price") - $(a).data("price")
        });
        products.parent().html(products);

    }
     function sortProductsPriceNew() {
        var products = $('.mob-col-pad');
        products.sort(function (a, b) {
            return $(b).data("latest") - $(a).data("latest")
        });
        products.parent().html(products);

    }
    function sortProductsPriceOld() {
        var products = $('.mob-col-pad');
        products.sort(function (a, b) {
            return $(a).data("latest") - $(b).data("latest")
        });
        products.parent().html(products);

    }

    function sortdef() {
        location.reload();

    }
</script>
<script type="text/javascript" src="<?= base_url("allmedia/assets/js/lazy.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/js/myalert.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/js/lazy.plugin.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("bootstrap/vendor/jquery/jquery.validate.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("allmedia/assets/js/myvalidation.js") ?>"></script>

<script>
    $(function () {
        $('.lazy').Lazy({
            combined: true,
            delay: 2000
        });
    });
</script>
<script>
    var i = 0;
    $(document).mouseup(function (e) {
        var _header = [];
        _header.push('.navi-block');

        $.each(_header, function (key, value) {
            if (!$(value).is(e.target) && $(value).has(e.target).length === 0) {
                $('.navbar-collapse').removeClass('in');
                $('.navbar-collapse').addClass('collapse');
            }
        });

    });

    $('.for-mob-foot').click(function () {
        $(this).find('i').toggleClass("fa fa-angle-down fa fa-angle-up");

        if (i == 0) {

            $('footer').fadeIn();
            window.scrollBy(0, 200);
            i = 1;
        } else if (i == 1) {
            i = 0;
            $('footer').fadeOut();
        }

    });
</script>


<script src="<?= base_url() ?>assets/js/zoomer.js" type="text/javascript"></script>
<style>
    .back-to-top {
        cursor: pointer;
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        border-radius: 0;
        padding: 8px 14px;
    }

    @media (max-width: 736px) {
        .back-to-top {

            bottom: 61px;
            right: 11px;

        }
    }

</style>
<script>
    $(document).ready(function () {

        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });

        $('#back-to-top').tooltip('show');

    });
</script>

    <script type="text/javascript">
          $('.owl-main-slide').owlCarousel({
    loop:true,
    margin:0,
    autoplay:true,
     nav:true,
dots:false,
    responsiveClass:true,
       navText: ["<img src='bootstrap/images/back-arrow-left.png'>","<img src='bootstrap/images/back-arrow-right.png'>"],
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:1,
           dots:false
          
        }
    }
})
    $('.owl-carousel45').owlCarousel({
    loop:true,
    margin:0,
    autoplay:true,
    nav:true,
dots:false,
    responsiveClass:true,
     navText: ["<img src='bootstrap/images/back-arrow-left.png'>","<img src='bootstrap/images/back-arrow-right.png'>"],
    responsive:{
        0:{
            items:1.3,
            margin:10,
            nav:false
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:3,
            nav:true,
            loop:true
        }
    }
})


      
$('.owl-carousel3').owlCarousel({
    loop:true,
    margin:10,
    autoplay:true,
     nav:true,
dots:false,
    responsiveClass:true,
      navText: ["<img src='bootstrap/images/back-arrow-left.png'>","<img src='bootstrap/images/back-arrow-right.png'>"],
    responsive:{
        0:{
            items:1.3,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:4,
           
            loop:true
        }
    }
})
$('.owl-carousel4').owlCarousel({
    loop:true,
    margin:0,
    autoplay:true,
     nav:true,
    responsiveClass:true,
     navText: ["<img src='bootstrap/images/back-arrow.png'>","<img src='bootstrap/images/forward-arrow.png'>"],
    responsive:{
        0:{
            items:2,
            margin:10,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:6,
           
            loop:true
        }
    }
})

    </script> 
         <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        
      <script>
         $(function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'dd/mm/yy',
                minDate: 0
	        });
        });
    </script>
    
 <script src="<?= base_url() ?>bootstrap/js/product-zoom.js" type="text/javascript"></script>
    
 <script type="text/javascript">
        $(document).ready( function () {
            //If your <ul> has the id "glasscase"
            $('#glasscase').glassCase({ 'thumbsPosition': 'bottom', 'widthDisplay' : 560});
        });
    </script>
    <script>
window.onscroll = function() {myFunction()};

var headerfix = document.getElementById("headerfix");
var sticky = headerfix.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    headerfix.classList.add("sticky")
  } else {
    headerfix.classList.remove("sticky");
  }
}
</script>






<script>

$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>

<script>
    $("html").bind("mouseleave", function () {
    $.ajax({
        type: "POST",
        url: "<?=base_url('Dashboard/sm')?>",
        success: function (response) {

        }
    });
});
</script>
    
</body>

</html>