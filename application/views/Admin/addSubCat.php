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
                            <a href="#" onclick="window.history.go(-1);"> Go Back </a>
                        </li>
                        <li class="active"><span>Add Sub Category</span></li>
                    </ol>
                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('insert') ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="section">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">
                        <?= form_open_multipart('Admin/SadminLogin/addSubCategory', array('method' => 'POST', 'id' => 'sform2')) ?>
                        <div class="panel-body">

                            <div class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Category Name</label>
                                        <select class="form-control" name="cat_sub" id="cat_sub">
                                            <option value="">Select Category</option>
                                            <?php
                                            foreach ($categories as $category) {
                                                ?>
                                                <option value="<?= $category->id ?>"><?= $category->cat_name ?></option>;
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Sub Category Name</label>
                                        <input type="text" id="sub_category" name="sub_category" class="form-control" placeholder="Sub Category Name" value="" autocomplete="off" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                        <textarea name="sub_cat_desc" id="sub_cat_desc" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Sub Category Image</label>
                                        <input type="file" name="sub_image" />
                                        <?php echo form_error('sub_image', '<p class="error">', '</p>'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Title</label>
                                        <textarea name="sub_title" id="sub_title" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Meta Description</label>
                                        <textarea name="sub_meta_desc" id="sub_meta_desc" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Meta Keyword</label>
                                        <textarea name="sub_meta_key" id="sub_meta_key" class="form-control"></textarea>
                                    </div>
                                    <!-- <div class="col-sm-3">
                                        <label>Size Chart</label>
                                        <input type="file" required name="size_chart" />
                                        <?php // echo form_error('size_chart', '<p class="error">', '</p>'); ?>
                                    </div> -->


                                </div>

                                <div class="row">
                                    <br>
                                    <div class="col-sm-3">
                                        <input type="submit" style="margin-top: 4px" value="Add Sub-Category " class="btn btn-xs btn-success">
                                    </div>
                                </div>
                            </div>



                        </div>

                        <?= form_close(); ?>
                    </div>
                    <div class="panel  panel-white">
                        <div class="panel-body">

                            <table class="table table-bordered table-striped table-nowrap no-mb" id="example">
                                <thead>

                                    <tr>
                                        <td>Category Name</td>
                                        <td>Sub Category</td>
                                        <td>Action</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php


                                    foreach ($subcat as $sub) { ?>
                                        <tr>
                                            <td> <?= $sub->cat_name ?> </td>
                                            <td> <?= $sub->sub_name ?> </td>
                                            <td>
                                                <button class="btn btn-xs btn-dark" onclick="window.location.href='<?= site_url('Admin/SadminLogin/editSubCategory/') ?><?= encode($this->encryption->encrypt($sub->sub_id)) ?>'">Edit</button>
                                                <button onclick="window.location.href='<?= site_url('Admin/SadminLogin/getChildSub/') ?><?= encode($this->encryption->encrypt($sub->sub_id)) ?>'" class="btn btn-xs btn-success">See child category
                                                    (<?= (count(getSubcount($sub->sub_id)));  ?>)
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-xs btn-danger" onclick="window.location.href='<?= site_url('Admin/SadminLogin/deleteSubCategory/') ?><?= encode($this->encryption->encrypt($sub->sub_id)) ?>'">Delete</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>


</main>