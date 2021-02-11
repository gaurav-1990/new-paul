<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<main class="main-container">

    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#"> Users</a>
                        </li>
                        <li class="active"><span>Wallet</span></li>
                    </ol>

                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel  panel-white">
                    <div class="panel-body">
                    <?php 
                    
                    $urls = $data ; ?>
                        <?= form_open_multipart('Admin/SadminLogin/gift_to_wallet/'.$urls, array('method' => 'POST', 'id' => 'sform3')) ?>
                        <div class="panel-body  pb">
                            <div class="row">
                              
                                <div class="col-sm-3">
                                    <label>Amount</label>
                                    <input type="text" id="Amount" required name="Amount"  class="form-control" placeholder="Wallet Amount" value="" autocomplete="off" />
                                </div>
                                <div class="col-sm-3">
                                    <label>Comments</label>
                                    <textarea name="comments" id="comments" required  class="form-control"></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <input type="submit" style="margin-top: 4px" value="Send" class="btn btn-success">
                                </div>
                            </div>
                           
                        </div>
                        <?= form_close(); ?>


                    </div>
                </div>



            </div>


        </div>
    </div>
    <!--<div id="setMe"></div>-->

    </div>


</main>