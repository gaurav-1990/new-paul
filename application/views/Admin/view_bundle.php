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
                            <a href="#"> Products</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>
                    <!-- /Breadcrumbs -->

                    <!-- Page header -->
                    <div class="page-header">
                         
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
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Product Name</th>
                                            <th>In Stock</th>
                                            <th>Quantity</th>
                                            <th>Actual Price</th>
                                            <th>Offer Price</th>
                                            <th>Images</th>
                                            <th>Category</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($product as $pr) {
                                            ?>
                                            <tr>

                                                <td style="white-space: nowrap">
                                                    <?php
                                                    if ($pr->pro_sta == 1) {
                                                        ?>
                                                        <a href="<?= site_url('Admin/Vendor/editConfirmedProduct/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs btn-success"> <i class="fa fa-edit"></i> Edit </a>

                                                    <?php } else { ?>
                                                        <a href="<?= site_url('Admin/Vendor/editRequestedProduct/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs btn-success"> <i class="fa fa-edit"></i> Edit </a>
                                                        <a onclick="return confirm('Are you sure ! You want to delete this item')" href="<?= site_url('Admin/Vendor/deleteRequestedProduct/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i> Delete </a>
                                                    <?php } ?>



                                                </td>
                                                <td><?= $pr->cat_name ?></td>
                                                <td><?= $pr->sub_name ?></td>
                                                <td><?= $pr->pro_name ?></td>
                                                <td><?= $pr->in_stock == 1 ? "Yes" : "No" ?></td>
                                                <td><?= $pr->pro_stock ?></td>
                                                <td><?= $pr->act_price ?></td>
                                                <td><?= $pr->dis_price ?></td>
                                                <td><?php if ((getImageCount($pr->ID)) > 0) { ?> <a  target="_blank"  href="<?= site_url('Admin/SadminLogin/getImages/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs">See Images  </a> <?php } else { ?><a  target="_blank"  href="<?= site_url('Admin/Vendor/addProductImages/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs btn-success">Upload Images  </a> (<?= getImageCount($pr->ID) ?>)<?php } ?></td>
                                                <td><?php if ($pr->product_attr != NULL) { ?>
                                                        <a  target="_blank"  href="<?= site_url('Admin/SadminLogin/getProductProperties/') ?><?= encode($this->encryption->encrypt($pr->ID)) ?>" class="btn btn-xs">See Prop </a><?php
                                                    } else {
                                                        echo "No properties";
                                                    }
                                                    ?>   </td>
                                                <td> <?= $pr->pro_sta == 0 ? "<label class='label label-warning'>Pending</label>" : ($pr->pro_sta == 1 ? "<label class='label label-success'>Confirmed</label>" : "<label  title='$pr->reject_reason' class='label label-danger'>Rejected</label>") ?></td>
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
