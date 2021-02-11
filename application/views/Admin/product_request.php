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
                            <a href="#"> Vendor Requested Products</a>
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
    <!-- /Page heading -->
    <div id="rejectPop"></div>

    <!-- Content container -->
    <div class="container-fluid">
        <div class="section">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">
                        <div class="panel-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap no-mb" id="example">


                                    <thead>
                                        <tr>

                                            <th>Action</th>
                                            <th>Vendor Name</th>
                                       
                                       
                                            <th>Product Name</th>
                                            <th>In Stock</th>
                                            <th>Quantity</th>
                                            <th>Actual Price</th>
                                            <th>Offer Price</th>
                                            <th>Image</th>
                                            <th>Properties</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($product as $pr) {
                                            ?>
                                            <tr>

                                                <td style="white-space: nowrap;">
                                                    <?php if ($pr->pro_sta == 0 || $pr->pro_sta == 1) { ?>
                                                        <a href="javascript:void(0);"  onclick="rejectThisRequest('<?= encode($this->encryption->encrypt($pr->pro_id)) ?>');" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i> Reject </a>
                                                    <?php } ?>
                                                    <?php if ($pr->pro_sta == 0 || $pr->pro_sta == 2) { ?>
                                                        <a href="<?= site_url('Admin/SadminLogin/acceptRequest/') ?><?= encode($this->encryption->encrypt($pr->pro_id)) ?>" onclick="return confirm('Do you want to accept this request!')"  class="btn btn-xs btn-success"> <i class="fa fa-reply"></i> Accept </a>
                                                    <?php } ?>
                                                    <a href="<?= site_url('Admin/SadminLogin/viewProductRequest/') ?><?= encode($this->encryption->encrypt($pr->pro_id)) ?>"   class="btn btn-xs btn-info"> <i class="fa fa-list"></i> View  </a>
                                                </td>

                                                <td><?= $pr->fname ?> <?= $pr->lname ?></td>
                                              
                                            
                                                <td><?= $pr->pro_name ?></td>
                                                <td><?= $pr->in_stock == 1 ? "Yes" : "No" ?></td>
                                                <td><?= $pr->pro_stock ?></td>
                                                <td><?= $pr->act_price ?></td>
                                                <td><?= $pr->dis_price ?></td>
                                                <td><a  target="_blank"  href="<?= site_url('Admin/SadminLogin/getImages/') ?><?= encode($this->encryption->encrypt($pr->pro_id)) ?>" class="btn btn-xs">See Images</a></td>
                                                <td>
                                                    <?php if ($pr->product_attr != NULL) { ?> 
                                                        <a  target="_blank"  href="<?= site_url('Admin/SadminLogin/getProductProperties/') ?><?= encode($this->encryption->encrypt($pr->pro_id)) ?>" class="btn btn-xs">See Prop</a>
                                                        <?php } else {
                                                        ?>
                                                        <a  target="_blank"  href="<?= site_url('Admin/SadminLogin/editPropAttrName/') ?><?= encode($this->encryption->encrypt($pr->pro_id)) ?>" class="btn btn-xs">Add Prop</a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $pr->pro_sta == 0 ? "<label class='label label-warning'>Pending</label>" : ($pr->pro_sta == 1 ? "<label class='label label-success'>Confirmed</label>" : ($pr->pro_sta == 2 ? "<label class='label label-danger'>Rejected</label>" : "")); ?> </td>

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
