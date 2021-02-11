<!DOCTYPE html>

<html lang="en">

<head>
    <title>Paulsons</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--===============================================================================================-->
    <!--
    <link rel="icon" type="image/png" href="<?= base_url() ?>bootstrap/images/icons/favicon.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/css/main.css">
    <link href="<?= base_url() ?>bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>allmedia/assets/css/navbar.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>allmedia/assets/css/rahCal.css" rel="stylesheet" type="text/css" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/fonts/themify/themify-icons.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/fonts/elegant-font/html-css/style.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/vendor/lightbox2/css/lightbox.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/css/util.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/css/responsive.css">

    <link href="<?= base_url() ?>assets/css/myalert.min.css" rel="stylesheet" type="text/css" />
    <!--===============================================================================================-->
    <link href="<?= base_url() ?>bootstrap/css/profile.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>bootstrap/css/owlcrousel.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>bootstrap/css/navigation.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>bootstrap/css/mob-code.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Hind+Siliguri:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="<?= base_url() ?>bootstrap/css/pro-zoom.css" rel="stylesheet" type="text/css"/>
</head>

<body class="animsition">
    <!-- data-myalert for add to cart popup -->
    <!-- Header -->
<div class="topbar">

                   
                        <div class="topbar-child2">
                            <p class="topbar-email">Flat 20% Off On Our New Arivals</p>
<!--                            <a href="#" class="topbar-email">
                                <b>Customer support</b> <i class="fa fa-envelope" aria-hidden="true"></i> care@paulsons.com
                            </a>-->
                           

                        </div>
                
                 

                </div>
<header data-myalert class="header1"  id="headerfix">

        <!-- row-offcanvas-left -->



        <!-- Header desktop -->
        <div class="container-menu-header">


            <div class="wrap_header">



                
                    <div class="row">
                        <!-- Logo -->
                        <div class="col-md-7 col-xs-4">
                        <div class=" logo">
                            <a href="<?= base_url(); ?>">
                                <img src="<?= base_url() ?>bootstrap/images/logo.png" alt="paulsons" width="100%">
                            </a>
                        </div>
                        </div>
                        
                        <div class="col-md-5 col-xs-8"><form style="display: inline;" method="GET" action="<?= base_url("Search") ?>">
                        <div class="search-part">
                            <input type="text" name="term" autocomplete="off" id="searchProduct"
                                   placeholder="Search Product" required>
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <div class="filter_prod"></div>

                        </div>
                        </form>
                        
                        <div class="header-icons">
                    <div class="top-profile topbar-child1 dropdown">
                            <!-- <button class="  dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa fa-user-o" aria-hidden="true"></i>
                                <p>Profile</p>
                                <span class="caret"></span>
                            </button> -->
                            <button class="  dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="text">My Account </span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {
                                    ?>
                                    <div class="hello-user">
                                        <h3>
                                            <b>Hello</b>
                                            <br>
                                            <?php
                                            if ($this->session->userdata('app_id') == null) {
                                                $res = getUserByEmail($this->session->userdata('myaccount'));

                                                $diff = abs(strtotime(date("Y-m-d")) - strtotime($res->prime_date));
                                                $years = floor($diff / (365 * 60 * 60 * 24));
                                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                echo $res->user_name;
                                            } else {
                                                $res = getUser($this->session->userdata('app_id'));
                                                echo $res->user_name;
                                            }
                                            ?>
                                        </h3>
                                        <hr/>
                                    </div>
                                    <li>
                                        <a href="<?= base_url('Myaccount/editProfile') ?>">Edit Profile</a>
                                        <a href="<?= base_url('Myaccount/dashboard') ?>">My Account</a>

                                    </li>

                                <?php } else { ?>
                                    <div class="hello-user">
                                        <h3>
                                            <b>Welcome</b>
                                            <br>
                                            To access account and manage orders
                                        </h3>
                                    </div>
                                    <div class="log-inset">
                                        <button onClick="window.location.href = '<?php  echo base_url('Myaccount') ?>'">Log in
                                        </button>
                                        <button onClick="window.location.href = '<?php  echo base_url('Myaccount/newUser') ?>'">
                                            Sign up
                                        </button>
                                    </div>
                                    <hr/>
                                <?php } ?>
                                <li>
                                    <!--<a href="<?php // echo base_url("Myaccount/contactus") ?>">Contact Us</a>-->
                                    <!--<a href="<?php // echo base_url("Myaccount/aboutus") ?>">About Us</a>-->
                                    <!-- <a href="<?= base_url("Myaccount/storelocator") ?>">Store Locator</a> -->
                                    <?php

                                    // if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) { ?>
                                        <!-- <a href="<?= base_url("Myaccount?Step=subscription") ?>">
                                            Subscription</a> -->
                                    <?php // } else{
                                        ?>
                                        <!-- <a href="<?= base_url("Prime") ?>"> Subscription</a> -->
                                        <?php
                                    // }
                                    ?>
                                    <?php if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) { ?>
                                        <a href="<?= base_url('Myaccount/logout') ?>">Logout</a>
                                    <?php } ?>
                                </li>

                            </ul>
                        </div>
                         <div class="wish-list">
                            <a href="<?php  echo base_url("Wishlist") ?>">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <?php
                                $user_email = $this->session->userdata('myaccount');
                                $user = $this->user->get_profile($user_email);
                                $userId = $user->id;
                                $wishlist = $this->user->getWishList($userId);
                                $wish_count = count($wishlist);
                            ?>
                            <span class="wish_count"><?=$wish_count?></span>
                                <!-- <i> <img src="<?= base_url() ?>bootstrap/images/svg-icons/bookmark.svg"
                                         class="header-icon1" alt="ICON"></i>
                                <p>Wishlist +++</p> -->
                            </a>

                        </div>

                        <div  class="header-wrapicon2  header-icon1 js-show-header-dropdown ">
                            <a href="<?php   echo base_url("Checkout") ?>">
                                <!-- <i> <img src="<?= base_url() ?>bootstrap/images/svg-icons/shopping-bag.svg"
                                        class="header-icon1" alt="ICON"></i> -->
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <span class="header-icons-noti  header-icon1 js-show-header-dropdown"><?php echo (count($this->session->userdata('addToCart')));
                                                                                                            ?></span>
                                
                                <!-- <p>Bag</p> -->
                            </a>
                            <div class="header-cart header-dropdown">
                            </div>
                        </div>

                       

                        

                        <div class="search-mob-icon">
                            <i> <img src="<?= base_url() ?>bootstrap/images/svg-icons/magnifying-glass.svg" alt="ICON"></i>
                        </div>

                        <?php
                        include_once("Search.php");
                        ?>


                    </div>
                    </div>

                    </div>
                

            </div>

        </div>

        <div class="navi-block ">
                            <nav class="navbar navbar-expand-lg navbar-dark bg-primary" aria-haspopup="true" aria-expanded="false">

                                <div class="arow-back">
                                    <img onclick='history.go(-1);' src="<?= base_url() ?>bootstrap/images/icons/ar.png" alt="Karzanddolls-LOGO">
                                </div>

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                                    <div class="mob-nav">
                                        <button class="mob-nav-close">×</button>
                                        <div class="use-pic">
                                            <img src="<?= base_url() ?>bootstrap/images/icons/download.png" alt="Karzanddolls-LOGO" width="93%">
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#">Log in</a>
                                                <a href="#" style="font-size: 31px;
                                                 line-height: 10px;">.</a>
                                                <a href="#">Sign Up</a>
                                                <i class="fa fa-angle-down"></i>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--                                    <h3 class="mob-nav-head">
                                        SHOP FOR
                                    </h3>-->
                                    <?= loadnavigation(); ?>
                                    <div class="other-links">
                                        <ul>
                                            <li>
                                                <a href="#">Account</a>
                                                <a href="#">Orders</a>
                                                <a href="#">Gift Cards</a>
                                                <a href="#">Contact Us</a>
                                                <a href="#">FAQs</a>
                                                <a href="#">Logout</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </nav>
                        </div>
    </header>
    <div class="for-whats-app">
        <a href="https://api.whatsapp.com/send?phone=9199995-65434&text=Let’s Discuss Your Plan" target="_blank"> <img src="<?= base_url() ?>bootstrap/images/svg-icons/whatsapp.svg" class="header-icon1" alt="ICON"></a>
    </div>
    