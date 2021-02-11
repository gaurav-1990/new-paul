<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>allmedia/assets/js/jquery-2.2.0.min.js"></script>
<script src="<?= base_url() ?>bootstrap/js/magnifier.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/js/firstpageAddCart.js" type="text/javascript"></script>
<script>



    var $zoom;
    $(document).ready(function () {
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

        "use strict";

        $('.menu > ul > li:has( > ul)').addClass('menu-dropdown-icon');
        //Checks if li has sub (ul) and adds class for toggle icon - just an UI


        $('.menu > ul > li > ul:not(:has(ul))').addClass('normal-sub');
        //Checks if drodown menu's li elements have anothere level (ul), if not the dropdown is shown as regular dropdown, not a mega menu (thanks Luka Kladaric)

        $(".menu > ul").before("<a href=\"#\" class=\"menu-mobile\">Menu</a>");

        //Adds menu-mobile class (for mobile toggle menu) before the normal menu
        //Mobile menu is hidden if width is more then 959px, but normal menu is displayed
        //Normal menu is hidden if width is below 959px, and jquery adds mobile menu
        //Done this way so it can be used with wordpress without any trouble

        $(".menu > ul > li").hover(function (e) {
            if ($(window).width() > 943) {
                $(this).children("ul").stop(true, false).fadeToggle(150);
                e.preventDefault();
            }
        });
        //If width is more than 943px dropdowns are displayed on hover

        $(".menu > ul > li").click(function () {
            if ($(window).width() <= 943) {
                $(this).children("ul").fadeToggle(150);
            }
        });
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
<script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/addToCart.js" type="text/javascript"></script>
<!--===============================================================================================-->


<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/select2/select2.min.js"></script>
<script type="text/javascript">
    $(".selection-1").select2( );
    $(".selection-2").select2();
</script>
<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/slick/slick.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>bootstrap/js/slick-custom.js"></script>
<script src="<?= base_url() ?>bootstrap/js/owlcrousel.js" type="text/javascript"></script>
<script src="<?= base_url() ?>bootstrap/js/owlmain.js" type="text/javascript"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/lightbox2/js/lightbox.min.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/sweetalert/sweetalert.min.js"></script>


<!--===============================================================================================-->
<script src="<?= base_url() ?>bootstrap/js/main.js"></script>
 

<script type="text/javascript">
$(document).ready(function() {
 // executes when HTML-Document is loaded and DOM is ready

// breakpoint and up  
$(window).resize(function(){
	if ($(window).width() >= 980){	

      // when you hover a toggle show its dropdown menu
      $(".navbar .dropdown-toggle").hover(function () {
         $(this).parent().toggleClass("show");
         $(this).parent().find(".dropdown-menu").toggleClass("show"); 
       });

        // hide the menu when the mouse leaves the dropdown
      $( ".navbar .dropdown-menu" ).mouseleave(function() {
        $(this).removeClass("show");  
      });
  
		// do something here
	}	
});  
  
  

// document ready  
});
</script>

<script>

    $(document).on("change", ".selection-2", function () {

        var sortingMethod = $(this).val();

        if (sortingMethod == 'l2h')
        {
            sortProductsPriceAscending();
        } else if (sortingMethod == 'h2l')
        {
            sortProductsPriceDescending();
        } else if (sortingMethod == 'def')
        {
            sortdef();
        }

    });

    function sortProductsPriceAscending()
    {
        var products = $('.m-b-25');
        products.sort(function (a, b) {
            return $(a).data("price") - $(b).data("price")
        });
        $("#mysel").html(products);

    }

    function sortProductsPriceDescending()
    {
        var products = $('.m-b-25');
        products.sort(function (a, b) {
            return $(b).data("price") - $(a).data("price")
        });
        $("#mysel").html(products);

    }
    function sortdef()
    {
        location.reload();

    }

</script>
    <script type="text/javascript" src="<?=base_url("allmedia/assets/js/lazy.min.js")?>"></script>
    <script type="text/javascript" src="<?=base_url("allmedia/assets/js/lazy.plugin.min.js")?>"></script>
         <script>
    $(function() {
        $('.lazy').Lazy({
            combined: true,
            delay: 2000
        } );
    });
    </script>   
<script>
     var i=0;
  $(document).mouseup(function (e) {
        var _header = [];
        _header.push('.navi-block');
        
        $.each(_header, function (key, value) {
            if (!$(value).is(e.target) && $(value).has(e.target).length === 0)
            {
                 $('.navbar-collapse').removeClass('in');
                 $('.navbar-collapse').addClass('collapse'); 
            }
        });
      
    });
     
    $('.for-mob-foot').click(function(){
            $(this).find('i').toggleClass("fa fa-angle-down fa fa-angle-up");

            if(i==0)
            {
              
            $('footer').fadeIn();
            i=1;
            }else if(i==1)
            {
                i=0;
                $('footer').fadeOut();
               
            }
             
        });

// document.addEventListener('DOMContentLoaded', function() {
//     var elems = document.querySelectorAll('.sidenav');
//     var instances = M.Sidenav.init(elems, options);
//   });

  // Initialize collapsible (uncomment the lines below if you use the dropdown variation)
  // var collapsibleElem = document.querySelector('.collapsible');
  // var collapsibleInstance = M.Collapsible.init(collapsibleElem, options);

  // Or with jQuery

//   $(document).ready(function(){
//     $('.sidenav').sidenav();
//   });
</script>





</body>
</html>
