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
                            <a href="#"> Vendor Products</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>
                    <div class="page-header">
                        <?= $this->session->flashdata('emailmsg') ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <?= $this->session->flashdata('msg'); ?>
        <?= $this->session->flashdata('pro1_msg'); ?>
        <?= $this->session->flashdata('pro2_msg'); ?>
        <?= $this->session->flashdata('pro3_msg'); ?>
        <?= $this->session->flashdata('pro4_msg'); ?>
        <?= $this->session->flashdata('pro5_msg'); ?>
        <?= $this->session->flashdata('pro6_msg'); ?>
        <?= $this->session->flashdata('pro7_msg'); ?>
        <div class="section">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap no-mb" id="example">
                                    <thead>
                                        <tr>
                                            <th>Action </th>
                                            <th>Enable/Disable</th>
                                            <th>SKU</th>
                                            <th>Product Name</th>
                                            <th>In Stock</th>
                                            <th>Quantity</th>
                                            <th>Actual Price</th>
                                            <th>Offer Price</th>
                                            <!-- <th>Specification</th> -->
                                            <th>Images</th>
                                            <th>#</th>
                                            <th>Similar Product</th>
                                            <th>Cross sell Product</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($product as $pr) {
                                            
                                            ?>
                                            <tr>

                                                <td style="    display: inline-block;width: 240px;">
                                                    <?php

                                                    if ($pr->pro_sta == 0) {
                                                        $name = cleanUrl($pr->pro_name);
                                                        ?>
                                                        <a href="<?= site_url('Admin/Vendor/editConfirmedProduct/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs btn-success"> <i class="fa fa-edit"></i> Edit </a>
                                                        <!-- <a onclick="return confirm('Are you sure ! You want to delete this item')" href="<?= site_url('Admin/Vendor/deleteRequestedProduct/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i> Delete </a> -->
                                                        <?php
                                                        $pro_id = encode($this->encryption->encrypt($pr->ID));
                                                        ?>
                                                        <!-- <a href="<?= base_url("Dashboard/pd_/$name/$pro_id"); ?>" class="btn btn-xs ">Check On Front</a> -->
                                                    <?php } else { ?>
                                                        <a href="<?= site_url('Admin/Vendor/editRequestedProduct/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs btn-success"> <i class="fa fa-edit"></i> Edit </a>
                                                    <?php } ?>



                                                </td>
                                                <td>
                                                    <?php  if($pr->pro_sta == 0) { ?>
                                                        <a href="<?= base_url(); ?>Admin/Vendor/enable_prd/<?= $pro_id ?>" onclick="return confirm('Are You sure you want to Enable the Product')" class="button">Disable</a>
                                                    <?php  } ?>
                                                    
                                                </td>
                                                <td>
                                                    <?=$pr->sku?>
                                                </td>
                                                <td><?= $pr->pro_name ?></td>
                                                <td><?= $pr->in_stock == 1 ? "Yes" : "No" ?></td>
                                                <td><?= $pr->pro_stock ?></td>
                                                <td><?= $pr->act_price ?></td>
                                                <td><?= $pr->dis_price ?></td>
                                                <!-- <td>
                                                    <a class="btn btn-xs btn-info" href="<?= site_url("Admin/Vendor/addSpecification/") ?><?= encode($this->encryption->encrypt($pr->ID)) ?>"> Specification </a>
                                                </td> -->
                                                <td>
                                                    <?php if ((getImageCount($pr->ID)) > 0) { ?> <a target="_blank" href="<?= site_url('Admin/SadminLogin/getImages/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs">See Images </a> <?php } else { ?><a target="_blank" href="<?= site_url('Admin/Vendor/addProductImages/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs btn-success">Upload Images </a> (<?= getImageCount($pr->ID) ?>)<?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($pr->product_attr != NULL) { ?>
                                                        <a target="_blank" href="<?= site_url('Admin/SadminLogin/getProductProperties/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs">See Prop </a>
                                                    <?php   } else {
                                                        echo "No properties";
                                                    } ?> </td>

                                                <td> <a class="btn btn-success btn-xs" onclick="getSimilar(<?= $pr->ID ?>)" href="#">Add/Edit</a> </td>
                                                <td> <a class="btn btn-success btn-xs" onclick="getCrosssell(<?= $pr->ID ?>)" href="#">Add/Edit</a> </td>
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

        <div id="setMe"></div>

    </div>


</main>

<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout modal-lg" role="document">
        <form method="POST" action="<?= base_url("Admin/Vendor/addSimilarProducts") ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Similar Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>