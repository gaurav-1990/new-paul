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
                            <a href="#"> User Reviews</a>
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

                                <table class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Product Name</th>
                                            <th>User name</th>
                                            <th>Email</th>
                                            <th>Review</th>
                                            <th>Stars</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userOrderModule">
                                        <?php
                                        foreach ($results as $res) {
                                            ?>
                                            <tr>

                                                <td title="" >
                                                    <?php
                                                    if ($res->is_accept == 0) {
                                                        ?>
                                                        <a  href="<?= base_url('Admin/Vendor/acceptReview/') ?><?= encode($this->encryption->encrypt($res->RID)) ?>" class="btn btn-success btn-xs"> <i class="fa fa-list"></i> Accept</a>
                                                    <?php } ?>
                                                </td>
                                                <td title="<?= $res->pro_name ?>"> <?= substr($res->pro_name, 0, 10) ?></td>
                                                <td><?= ($res->username) ?></td>
                                                <td><?= ($res->useremail) ?></td>
                                                <td title="<?= $res->review ?>"><?= substr($res->review, 0, 10) ?></td>
                                                <td><?= $res->rate ?></td>
                                                <td><?= $res->dateandtime ?></td>
                                            </tr>
                                        <?php } ?>
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
