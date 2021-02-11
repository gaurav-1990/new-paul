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
                                            <th>Order No.</th>
                                            <th>State</th>
                                            <th>Address</th>
                                            <th>Pin Code</th>
                                            <th>Order Price</th>
                                            <th>Invoice ID</th>
                                            <th>Invoice Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;

                                        foreach ($data as $user) {
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= "10000".$user->id ?></td>
                                                <td><?= $user->state ?></td>
                                                <td><?= $user->user_address?></td>
                                                <td><?= $user->user_pin_code?></td>
                                                <td><?= $user->total_order_price?></td>
                                                <td><?= $user->invoice_id?></td>
                                                <td><?= $user->invoice_date?></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>

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