<!DOCTYPE html>

<html lang="en">

<head>
    <title>Paulsons</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="icon" type="image/png" href="<?= base_url() ?>bootstrap/images/icons/favicon.png" /> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/css/main.css">
    <link href="<?= base_url() ?>bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/fonts/themify/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link href="<?= base_url() ?>bootstrap/css/mob-code.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Hind+Siliguri:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

</head>

<body class="animsition">

    <!-- Header -->
<div class="topbar">

                   
                        <div class="topbar-child2">
                            <p class="topbar-email">Flat 20% Off On Our New Arivals</p>
<!--                            <a href="#" class="topbar-email">
                                <b>Customer support</b> <i class="fa fa-envelope" aria-hidden="true"></i> care@paulsons.com
                            </a>-->
                           

                        </div>
                
                 

                </div>
<header  class="header1"  id="headerfix">

        <!-- row-offcanvas-left -->



        <!-- Header desktop -->
        <div class="container-menu-header">


            <div class="wrap_header">



                <div class="container">
                    <div class="row">
                        <!-- Logo -->
                        <div class="col-md-3 col-xs-3 col-sm-2 logo-2">
                            <a href="<?= base_url(); ?>">
                                <img src="<?= base_url() ?>bootstrap/images/logo.png" alt="paulsons" width="100%">

                            </a>
                        </div>

                        <div class="col-md-6 col-xs-9 col-sm-7 second-header">
                            <ul>
                                <li class="select-text">
                                    <a <?= $this->session->userdata("step") == 0 ? "class='active'" : "" ?> href="<?= base_url("Checkout") ?>">BAG</a>
                                </li>
                                <li class="select-dot">
                                    <a href="javascript:void(0);"></a>
                                </li>
                                <li class="select-text">
                                    <a <?= $this->session->userdata("step") == 1 ? "class='active'" : "" ?> href="javascript:void(0);">ADDRESS</a>
                                </li>
                                <li class="select-dot">
                                    <a href="javascript:void(0);"></a>
                                </li>
                                <li class="select-text">
                                    <a <?= $this->session->userdata("step") == 2 ? "class='active'" : "" ?> href="javascript:void(0);">PAYMENT</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-3 col-xs-3 col-sm-3 ">
                            <div class="third-secure-set">
                                <img src="<?= base_url() ?>/bootstrap/images/secure.png" alt="" />
                                <h3>100% SECURE</h3>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

       



    </header>