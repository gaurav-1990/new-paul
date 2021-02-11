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
                        <li class="active"><span>View</span></li>
                        

                    </ol>

                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('insert') ?>

                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">

        <div class="section">

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">

                        <div class="panel-body">
                            
                            <div class="table-responsive">

                                <table id='example' class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Order Id</th>
                                            <th>Invoice Id</th>
                                            <th>Email</th>
                                            <th>Review</th>
                                            <th>Rateing</th> 
                                            <th>Date</th>                                                                                                                               
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // echo"<pre>";
                                        // print_r($reviewR);
                                        // die;
                                     
                                    
                                          $count = 1; 
                                           foreach($reviewR as $orderSS)  {
                                                                                     
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td> 
                                                 <a href="<?= base_url(); ?>Admin/Vendor/acceptid/<?= encode($this->encryption->encrypt($orderSS->orderId)) ?>" type="button"><?=($orderSS->is_accept ==0)?'Not Accepted' :'Accepted' ?></a></td> 
                                                   
                                                <td><?= "10000".$orderSS->orderId   ?></td>
                                                <td><?= $orderSS->invoice_id ?></td>
                                                <td><?= $orderSS->useremail ?></td>                                                                                       
                                                <td><?= $orderSS->review ?></td>
                                                <td><?= $orderSS->rate ?></td>
                                                <td><?= date('d-m-Y', strtotime($orderSS->dateandtime))  ?></td>
                                                                                                            
                                            </tr>
                                            <?php
                                              $count++;
                                               }   ?>                                    

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