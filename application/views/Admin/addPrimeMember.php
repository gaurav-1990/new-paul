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
                            <a href="#"> Add Prime Offers</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>

                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('insert') ?>
                        <?= validation_errors(); ?>
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
                            <?= form_open_multipart('Admin/SadminLogin/prime_member', array('method' => 'POST', 'id' => 'sform2')) ?>
                            
                            <div class="panel-body  pb">
                                <div class="row">
                                <div class="col-sm-3">
                                        <label>Prime Amount</label>
                                        <input type="text" id="prime_val" name="prime_val" class="form-control" placeholder="Prime Amount" value="" autocomplete="off" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>From Date </label>
                                        <input type="text" id="offer_validity_from" name="offer_validity_from" class="form-control" placeholder="Valid From" value="" autocomplete="off" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>To Date</label>
                                        <input type="text" id="offer_validity_to" name="offer_validity_to" class="form-control" placeholder="Valid To" value="" autocomplete="off" />
                                    </div>

                                </div>


                            </div>
                            <div class="panel-body  pb">
                                <div class="row">

                                    <div class="col-sm-3">
                                        <input type="submit" value="Add Prime" class="btn btn-xs btn-success">
                                    </div>
                                </div>


                            </div>
                            <?= form_close(); ?>
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Prime Amount</th>                                            
                                            <th>From</th>
                                            <th>To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        if(isset($offer) && $offer != NULL){
                                        foreach ($offer as $of) {
                                            ?>
                                            <tr>
                                                <td> <a href="<?=base_url()?>Admin/SadminLogin/del_prime/<?= encode($this->encryption->encrypt($of->id)) ?>" class='btn btn-xs btn-danger'>Delete</a> </td>
                                                <td> <?= $of->amount ?>
                                                </td>
                                                                                             
                                                <td><?= $of->valid_from_date != '' ? date("d/m/Y", strtotime($of->valid_from_date)) : "" ?></td>
                                                <td><?= $of->valid_to_date != '' ? date("d/m/Y", strtotime($of->valid_to_date)) : "" ?></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }}else{?>
                                        <tr>
                                          <td>No Date</td>
                                        </tr>

                                     <?php   }
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