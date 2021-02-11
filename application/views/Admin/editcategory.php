<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="main-container">

    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#"> Categories</a>
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
                            <?= form_open_multipart('Admin/SadminLogin/updateCategory', array('method' => 'POST', 'id' => 'sform3')) ?>
                            <div  class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Category Name</label>
                                        <input type="text" id="category" name="category" value="<?= $data->cat_name ?>" class="form-control" placeholder="Category Name"   value="" autocomplete="off" /> 
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                        <textarea name="cat_desc" id="cat_desc" class="form-control"><?= $data->cat_desc ?></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Category Image (1920x239)</label>
                                        <input type="file" name="cat_image" value="" />
                                        <input type="hidden" name="hid_id" value="<?= $data->id ?>" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Status</label>
                                        <select class="form-control" name="cat_sta" id="cat_sta">
                                            <option <?= $data->cat_sta == 1 ? "selected" : "" ?> value="1">Enable</option>
                                            <option  <?= $data->cat_sta == 0 ? "selected" : "" ?> value="0">Disable</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="submit"  value="Update Category" class="btn btn-xs btn-success" >
                                    </div>
                                </div>
                                <div  class="panel-body  pb">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <img src="<?= base_url('uploads/category/resize/resized_') ?><?= $data->cat_image ?>" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= form_close(); ?>


                        </div>
                    </div>



                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>


</main>