<!DOCTYPE html>
<html lang="en">

<head>
    <title> <?php echo isset($title) ? $title : "Paulsons" ?></title>
    <meta name="description" content="<?= isset($meta_desc) ? $meta_desc : "Paulsons" ?>">
    <meta name="keyword" content="<?= isset($keyword) ? $keyword : "Paulsons" ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--===============================================================================================-->
    <!--  <link rel="icon" type="image/png" href="<?= base_url() ?>bootstrap/images/icons/favicon.png"/>-->
    <!--===============================================================================================-->

    <link href="<?= base_url() ?>bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/css/main.css">
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
    <link href="<?= base_url() ?>bootstrap/css/pro-zoom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>

<body class="animsition">
    <!-- data-myalert for add to cart popup -->
    <!-- Header -->
    <div class="topbar">


        <div class="topbar-child2">
            <p class="topbar-email"> <a href="#"> Flat 20% Off On Our New Arivals </a> </p>
            <!--                            <a href="#" class="topbar-email">
                                <b>Customer support</b> <i class="fa fa-envelope" aria-hidden="true"></i> care@paulsons.com
                            </a>-->


        </div>



    </div>
    <header data-myalert class="header1" id="headerfix">

        <!-- row-offcanvas-left -->
        <!-- Header desktop -->
        <div class="container-menu-header">


            <div class="wrap_header">
                <div class="row">
                    <!-- Logo -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="col-md-7 col-xs-4">
                        <div class=" logo">
                            <a href="<?= base_url(); ?>">
                                <img src="<?= base_url() ?>bootstrap/images/logo.png" alt="paulsons-LOGO" width="100%">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-8">
                        <form style="display: inline;" method="GET" action="<?= base_url("Search") ?>">
                            <div class="search-part">
                                <input type="text" name="term" autocomplete="off" id="searchProduct" placeholder="Search Product" required>
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
                                            <hr />
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
                                            <button onClick="window.location.href = '<?php echo base_url('Myaccount') ?>'">Log in
                                            </button>
                                            <button onClick="window.location.href = '<?php echo base_url('Myaccount/newUser') ?>'">
                                                Sign up
                                            </button>
                                        </div>
                                        <hr />
                                    <?php } ?>
                                    <li>
                                        <!--<a href="<?php // echo base_url("Myaccount/contactus") 
                                                        ?>">Contact Us</a>-->
                                        <!--<a href="<?php // echo base_url("Myaccount/aboutus") 
                                                        ?>">About Us</a>-->
                                        <!-- <a href="<?= base_url("Myaccount/storelocator") ?>">Store Locator</a> -->
                                        <?php

                                        // if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) { 
                                        ?>
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
                                <a href="<?php echo base_url("Wishlist") ?>">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    <?php
                                    $user_email = $this->session->userdata('myaccount');
                                    $user = $this->user->get_profile($user_email);
                                    $userId = $user->id;
                                    $wishlist = $this->user->getWishList($userId);
                                    $wish_count = count($wishlist);
                                    ?>
                                    <span class="wish_count"><?= $wish_count ?></span>
                                    <!-- <i> <img src="<?= base_url() ?>bootstrap/images/svg-icons/bookmark.svg"
                                         class="header-icon1" alt="ICON"></i>
                                <p>Wishlist +++</p> -->
                                </a>
                            </div>

                            <div class="header-wrapicon2  header-icon1 js-show-header-dropdown ">
                                <a href="<?php echo base_url("Checkout") ?>">
                                    <!-- <i> <img src="<?= base_url() ?>bootstrap/images/svg-icons/shopping-bag.svg"
                                        class="header-icon1" alt="ICON"></i> -->
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span class="header-icons-noti  header-icon1 js-show-header-dropdown"><?php echo (count($this->session->userdata('addToCart')));?></span>

                                    <!-- <p>Bag</p> -->
                                </a>
                                <div class="header-cart header-dropdown">
                                </div>
                            </div>





                            <div class="search-mob-icon">
                                <i> <img src="<?= base_url() ?>bootstrap/images/svg-icons/magnifying-glass.svg" alt="ICON"></i>
                            </div>




                        </div>
                    </div>
                    <?php
                    include_once("Search.php");
                    ?>




                </div>


            </div>

        </div>
        <div class="navi-block ">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary" aria-haspopup="true" aria-expanded="false">

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <div class="mob-nav">
                        <button class="mob-nav-close">×</button>
                        <div class="use-pic">
                            <img src="<?= base_url() ?>bootstrap/images/icons/download.png" alt="paulsons logo" width="93%">
                        </div>

                        <ul>

                            <li>
                                <?php if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) { ?>
                                    <a href="<?php // echo base_url("Myaccount") 
                                                ?>">Log in </a>

                                    <a href="#" style="font-size: 31px;line-height: 10px;">.</a>
                                    <a href="<?php // echo base_url("Myaccount/newUser") 
                                                ?>">Sign Up</a>
                                <?php
                                } else {
                                    if ($this->session->userdata('myaccount') != null) {
                                        $user = getUserProfile($this->session->userdata('myaccount'));
                                    } else {
                                        $user = getUserProfile($this->session->userdata('app_id'));
                                    }
                                ?>

                                    <a href="<?= base_url('Myaccount/dashboard') ?>">
                                        <p style="color: white;"><?= ($user != null) ? ucwords($user->user_name) : '' ?></p>
                                    </a>
                                <?php } ?>
                                <i class="fa fa-angle-down"></i>
                            </li>
                        </ul>
                    </div>


                    <?= loadnavigation(); ?>

                    <?php if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {  ?>

                        <div class="other-links">
                            <ul>

                                <li>

                                    <a href="<?= base_url('Myaccount/dashboard') ?>">Account </a>
                                    <a href="<?= base_url("Myaccount/orderDetails"); ?>">Orders</a>
                                    <a href="<?= base_url('Checkout/myCoupon') ?>">Gift Cards</a>
                                    <a href="<?= base_url("Myaccount/contactus") ?>">Contact Us</a>
                                    <a href="#">FAQs</a>
                                    <a href="<?= base_url('Myaccount/logout') ?>">Logout</a>

                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </nav>
        </div>
    </header>
    <div class="for-whats-app">
        <a href="https://api.whatsapp.com/send?phone=9174282-11662&text=Hi, I need some assistance." target="_blank"> <img src="<?= base_url() ?>bootstrap/images/svg-icons/whatsapp.svg" class="header-icon1" alt="ICON"></a>
    </div>
    <div class="top-view-block">
        <div class="container">
            <div class="top-view-block-in">

                <ul>
                    <!--                <li>
                    <a>
                        <div onclick="window.location = '<?= base_url() ?>shop/hotwheels/10322c750764624a58a81f3e3183f5e23f7b91c0271ab2194514eabb503fa5ae11990b12d61d97687a7a4c4af83c0853d17948cdd6850a077f9f4a5b33376941BxgadBprXHtcQTe3Y6LmSIsoGj7L1kTNNCz49oft2UQ-'"
                             class="img-bock">
                            <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/hotwheel.jpg"
                                 alt="Girls"/>
                        </div>
                        <h3>Hotwheel </h3>
                    </a>
                </li>
                <li>
                    <a>
                        <div onclick="window.location = '<?= base_url() ?>shop/greenlight/846dc4b14c29c8d21c40e0520fbc3d06e0222078b2cd64b1878f1118a610d5d66fc3dd4148b5f2dcae74295a68a96f9013b548c1f65bd0329583bac65c4ccdf7oVm2g6C+UngCm4cvDn+QfrGmRGwpHKBnvK8JUMsOPbA-'"
                             class="img-bock">
                            <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/greenlight.jpg" alt="Boy"/>
                        </div>
                        <h3>Greenlight </h3>
                    </a>
                </li>
              
                <li>
                    <a>
                        <div onclick="window.location = '<?= base_url() ?>shop/johnny-lightning/ad5291695f6c6c976fcf0338d0407aaf061ac1005178a3e16d5b56f30a9b75b23bf8f97b6bd250ee609706b91a2f0a63b11a05d8056d71a628f3c68116515e27Wn_1As3XS0eUqOT72+LefzWFRgHeBDA0gUBPXiq1Jyc-'"
                             class="img-bock">
                            <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/johnny-lightning.jpg" alt=""/>
                        </div>
                        <h3>johnny-lightning</h3>
                    </a>
                </li>
                <li>
                    <a>
                        <div onclick="window.location = '<?= base_url() ?>shop/jada/ee8e3930b9e18ba2f5a48f6ac30ddb8603573e4ee83d4e8f876e3fd1a828858cebfe87006f7e7e1871f856322a37ae9940c1bfffd2a4117d38c77c9aabcff32e7Lv19YNwfRALA0JeCFkxnUo8Y+lpoeIEGsXcCuntgxA-'"
                             class="img-bock">
                            <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/jada.jpg" alt=""/>
                        </div>
                        <h3>Jada</h3>
                    </a>
                </li>
                <li>
                    <a>
                        <div onclick="window.location = '<?= base_url() ?>shop/matchbox/95b602b5646ef1514d7f1f7dfdc30679f510b4e41753c6e55a43830f2c9c7586e25eb4c336ed0f133d63abce75920052a073cb8a1e09ecc7b0041f0c6dd19036R7gmAPprVaP+ZLhSHU7r6ZVrokCbXpo2TyWRSf54gms-'"
                             class="img-bock">
                            <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/matchbox.jpg" alt="Girls"/>
                        </div>
                        <h3>Matchbox </h3>
                    </a>
                </li>
                <li>
                    <a>
                        <div onclick="window.location = '<?= base_url() ?>shop/autoworld/0826c11bd7d23f35ccbb6a87be728f9d77fb9d270c01b9d54ebe7b0224ea5c34495d72015491310a722e3e45a763d31a210dfd23de9ad05e8821bf8511a179eeEj0RkNbpmIGvXt9qUlHK+GrWiM_tiRrKjz72DWYoFr0-'"
                             class="img-bock">
                            <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/autoworld.jpg" alt=""/>
                        </div>
                        <h3>Autoworld</h3>
                    </a>
                </li>
                <li>
                    <a>
                        <div onclick="window.location = '<?= base_url() ?>shop/specials/359117369c3fbcfce3d6dd9f55f66bc6fa5999fad1a7d615b4cca507009994c89e1efacee904a27d2c8928766ce346d535462c267df32dc5214d698a9c3d917ccQ8bDycrZYVvcKCN7sS2nbBs4LtTPVpcid4Wnx52jH4-'"
                             class="img-bock">
                            <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/specials.jpg" alt=""/>
                        </div>
                        <h3>Specials</h3>
                    </a>
                </li>

                <li>
                    <a>
                        <div onclick="window.location = '<?= base_url() ?>shop/majorette/8186809bfe5907756437e8431b9f7590f794af72288ed91c05dd5bd39eb8c7808c52e34d6468618cd10d588b5edcdde0768f50b7d7e8a8ea2f1a40bf0fd079abrJD6qPoK49yTyrT0DjNIQ4RekoZu8gM5NaQTgdKH+ko-'"
                             class="img-bock">
                            <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/majarette.jpg" alt=""/>
                        </div>
                        <h3>Majorette</h3>
                    </a>
                </li>

                <li>
                    <a>
                        <div onclick="window.location = '<?= base_url() ?>shop/barbie/dd84cb82d1402c79a81be7785c01c3eceaae8c4b7702ff815ecb0788728b0e6b63cb9d000ba12a627a9fcc2c32916631de76f180c8019e34f1697ffab804ff6bQTpSrIuLqHCO_7sEJ1aVjXf4I361uJ2zX11rzvzrhVw-'"
                             class="img-bock">
                            <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/doll.jpg" alt="doll"/>
                        </div>
                        <h3>Barbie</h3>
                    </a>
                </li>-->
                    <li>
                        <a>
                            <div onclick="window.location = '#'" class="img-bock">
                                <img class="lazy" data-src="<?= base_url() ?>bootstrap/images/top-nav/bb-cat.jpg" alt="doll" />
                            </div>
                            <h3>Collection</h3>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>