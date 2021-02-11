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
            <div class="panel  panel-white">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <label for="">
                            Subcategory Image <br>
                            <a target="_blank" href="<?= base_url() ?>uploads/subcategory/<?= $data->sub_img ?>"> <img style="height: 50px;width: 50px" src="<?= base_url() ?>uploads/subcategory/<?= $data->sub_img ?>" alt="" /></a>
                        </label>
                        <?php
                        if (($data->sizeChart) != 0) {
                            ?>
                        <label for="">
                            Size Chart Image <br>
                            <a target="_blank" href="<?= base_url() ?>uploads/sizechart/<?= $data->sizeChart ?>"> <img style="height: 50px;width: 50px" src="<?= base_url() ?>uploads/sizechart/<?= $data->sizeChart ?>" alt="" /></a>
                        </label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel  panel-white">
                    <div class="panel-body">
                        <?= form_open_multipart('Admin/SadminLogin/update_category', array('method' => 'POST', 'id' => 'sform3')) ?>
                        <div class="panel-body  pb">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Category Name</label>
                                    <select class="form-control" name="cat_sub" id="cat_sub">
                                        <option value="">Select Category</option>
                                        <?php
                                        foreach ($categories as $category) {
                                            ?>
                                        <option value="<?= $category->id ?>" <?= $category->id == $data->cid ? "selected" : "" ?>><?= $category->cat_name ?></option>;
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Sub Category Name</label>
                                    <input type="text" id="sub_category" name="sub_category" value="<?= $data->sub_name ?>" class="form-control" placeholder="Sub Category Name" value="" autocomplete="off" />
                                    <input type="hidden" name="hidden_id" value="<?= $url ?>" />
                                </div>
                                <div class="col-sm-3">
                                    <label>Description</label>
                                    <textarea name="sub_cat_desc" id="sub_cat_desc" class="form-control"><?= $data->sub_desc ?></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label>Sub Category Image</label>
                                    <input type="file" name="sub_image" />
                                    <?php echo form_error('sub_image', '<p class="error">', '</p>'); ?>
                                    <input type="hidden" name="sub_image_two" value="<?= $data->sub_img ?>" />

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Title</label>
                                    <textarea name="sub_title" id="sub_title" class="form-control"><?= $data->sub_title ?></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label>Meta Description</label>
                                    <textarea name="sub_meta_desc" id="sub_meta_desc" class="form-control"><?= $data->sub_meta_desc ?></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label>Meta Keyword</label>
                                    <textarea name="sub_meta_key" id="sub_meta_key" class="form-control"><?= $data->sub_meta_key ?></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label>Size Chart Image</label>
                                    <input type="file" name="size_chart" />
                                    <?php echo form_error('size_chart', '<p class="error">', '</p>'); ?>
                                    <input type="hidden" name="size_chart_image" value="<?= $data->sizeChart ?>" />

                                </div>
                                <br>

                                <div class="col-sm-12">
                                    <input type="submit" style="margin-top: 4px" value="Edit Sub-Category " class="btn btn-xs btn-success">
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