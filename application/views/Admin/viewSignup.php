<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="main-container">


    <!-- Page heading -->
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">

                    <!-- Breadcrumbs -->
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#"> Vendor Siginup</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>
                    <!-- /Breadcrumbs -->

                    <!-- Page header -->
                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('emailmsg') ?>
                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>
    <!-- /Page heading -->


    <!-- Content container -->
    <div class="container-fluid">
        <div class="section">
            <div class="row">


                <div class="col-xs-12 col-sm-12 col-md-12">


                    <div class="panel  panel-white">
                        <div class="panel-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap no-mb">


                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Vendor Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact No</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Zip</th>
                                            <th>Pan no</th>
                                        </tr>
                                    </thead>
                                    <tbody style="white-space: nowrap; overflow-x: scroll;">

                                        <?= $vendors ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>



                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>


</main>
