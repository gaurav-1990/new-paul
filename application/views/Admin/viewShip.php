<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="main-container">


    <!-- Page heading -->
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#"> Vendor Shipping Area</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>
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
                            <?= $this->session->flashdata('msg'); ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap no-mb" id="example">


                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Ship. Max Days</th>
                                            <th>Ship. Char</th>
                                            <th>Same Day Delivery Amt</th>
                                            <th>Pin code</th>

                                        </tr>
                                    </thead>
                                    <tbody style="white-space: nowrap; overflow-x: scroll;">

                                        <?php
                                        foreach ($ship as $details) {
                                            ?>
                                            <tr>
                                                <td><a onclick="return confirm('Want to delete this city')" href="<?= base_url('Admin/Vendor/deleteShip/') ?><?= encode($this->encryption->encrypt($details->id)) ?>" class="btn btn-xs btn-danger"> Delete</a></td>
                                                <td><?= $details->state ?></td>
                                                <td><?= $details->city ?></td>
                                                <td><?= $details->max_days ?></td>
                                                <td><?= $details->ship_amt ?></td>
                                                <td><?= $details->same_amt ?></td>
                                                <td><a href="<?= base_url('Admin/Vendor/checkPin/') ?><?= encode($this->encryption->encrypt($details->id)) ?>" class="btn btn-xs btn-success"> Check</a></td>
                                            </tr>
                                            <?php
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



    </div>


</main>
