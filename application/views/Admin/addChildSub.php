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
                        <?= $this->session->flashdata('insert') ?>
                        <?= $this->session->flashdata("msg") ?>
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
                            <?= validation_errors(); ?>


                            <?php
                            if ($this->uri->segment(4) != '') {
                                ?>
                                <?= form_open_multipart('Admin/SadminLogin/editChildSubCategory/' . $this->uri->segment(4) . '', array('method' => 'POST', 'id' => 'sform2')) ?>
                            <?php } else { ?>
                                <?= form_open_multipart('Admin/SadminLogin/childsub/', array('method' => 'POST', 'id' => 'sform2')) ?>

                            <?php } ?>
                            <div class="panel-body  pb">

                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Category Name</label>
                                        <select class="form-control" required="" name="cat_sub" id="cat_sub">
                                            <option value="">Select Category</option>
                                            <?php
                                            foreach ($categories as $category) {
                                                ?>
                                                <option value="<?= $category->id ?>" <?= isset($sub->cid) ? ($category->id == $sub->cid ? "selected" : "") : "" ?>><?= $category->cat_name ?></option>;
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Sub Category Name</label>
                                        <select id="c_sub_category" required="" name="sub_category" class="form-control" value="" autocomplete="off">
                                            <?php
                                            if (isset($subcategories)) {
                                                ?>
                                                <option value="<?= $subcategories->id ?>"><?= $subcategories->sub_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Child Name</label>
                                        <input type="text" id="child_sub_name" required="" name="child_sub_name" class="form-control" placeholder="Sub Category Name" value="<?= isset($sub->sub_name) ? $sub->sub_name : "" ?>" autocomplete="off" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Title</label>
                                        <textarea name="sub_title" id="sub_title" class="form-control"><?= isset($sub->sub_title) ? $sub->sub_title : "" ?></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="panel-body  pb">
                                <div class="row">

                                    <div class="col-sm-3">

                                        <input type="hidden" name="hiddenId" value='<?= $this->encryption->decrypt(decode($this->uri->segment(4))); ?>'>
                                        <label>Meta Description</label>
                                        <textarea name="sub_meta_desc" id="sub_meta_desc" class="form-control"><?= isset($sub->sub_meta_desc) ? $sub->sub_meta_desc : "" ?></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Meta Keyword</label>
                                        <textarea name="sub_meta_key" id="sub_meta_key" class="form-control"><?= isset($sub->sub_meta_key) ? $sub->sub_meta_key : "" ?></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Subcategory Image (700x547)</label>
                                        <input type="file" required class="btn btn-xs " name="childImage" id="childImage">
                                        <br> <?php
                                                if (isset($sub->sub_img) && $sub->sub_img != '') {
                                                    ?> <a target="__blank" href="<?= base_url("uploads/childSub/") ?><?= $sub->sub_img ?>">Check Image</a>
                                        <?php } ?>
                                    </div>

                                    <br>
                                    <div class="col-sm-3">
                                        <input type="submit" style="margin-top: 4px" value="Add Child Sub-Category" class="btn btn-xs btn-success">
                                    </div>
                                </div>
                            </div>
                            <?= form_close(); ?>


                        </div>
                    </div>



                </div>


            </div>
        </div>



    </div>


</main>