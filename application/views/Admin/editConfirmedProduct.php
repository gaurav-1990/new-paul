<?php // echo "<pre>"; print_r($products);die;?>
<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Products</a>
                        </li>
                        <li class="active"><span>Edit Products</span></li>
                    </ol>
                    <div class="page-header">
                        <h2 class="page-subtitle">
                            Edit Vendor Information
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?= $this->session->flashdata('msg'); ?>
    <?= $this->session->flashdata('insert'); ?>
    <div class="panel panel-white">
        <?= form_open_multipart('Admin/Vendor/updateConfirmedVendorRequest', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'id' => 'sform3', 'method' => 'POST')); ?>
        <div class="panel-body pb">

            <div class="row">

                <div class="col-sm-3">
                    <label>Product Name</label>
                    <input type="text" id="product_name" value="<?= $products->pro_name ?>" name="product_name" class="form-control" placeholder="Product Name">
                </div>
                <div class="col-sm-3">
                    <label>Product Sub Name</label>
                    <input type="text" id="product_sname" value="<?= $products->product_sname ?>" name="product_sname" class="form-control" placeholder="Product Sub Name">
                </div>
                <div class="col-sm-3">
                    <label>SKU </label>
                    <input type="text" id="sku" value="<?= $products->sku ?>" name="sku" class="form-control" placeholder="SKU">
                </div>
                <div class="col-sm-3">
                    <label>Limit for Add to Cart</label>
                    <input type="text" id="limit" value="<?= $products->add_limit ?>" name="limit" class="form-control" placeholder="Limit for Add to Cart">
                </div>
            </div>
        </div>

        <div class="panel-body pb">

            <div class="row">
                    <div class="col-sm-2">
                         <label>
                             None <br>
                             <input type="radio" <?= ($products->type == 0) ? "checked" : "" ?> name="type" value="0">
                         </label>
                    </div>
                     <!-- <div class="col-sm-2">
                         <label>
                             Is In Sale <br>
                             <input type="radio" <?= ($products->type == 1) ? "checked" : "" ?> name="type" value="1">
                         </label>
                     </div>
                     <div class="col-sm-2">
                         <label>
                             Is Top Seller <br>
                             <input type="radio" <?= ($products->type == 2) ? "checked" : "" ?> name="type" value="2">
                         </label>
                     </div>
                     <div class="col-sm-2">
                         <label>
                             Is Trending <br>
                             <input type="radio" <?= ($products->type == 3) ? "checked" : "" ?> name="type" value="3">
                         </label>
                     </div> -->
                     <div class="col-sm-2">
                         <label>
                             Is New <br>
                             <input type="radio" <?= ($products->type == 4) ? "checked" : "" ?> name="type" value="4">
                         </label>
                     </div>
            </div>
        </div>

        <?php

        $sub_catw = [];
        $child_id = [];
        foreach ($allprocat as $value) {
            if ($value->child_id == 0) {
                $sub_catw[] = $value->cat_id . "_" . $value->sub_id;
            } else {
                $sub_catw[] = $value->cat_id . "_" . $value->sub_id . "_" . $value->child_id;
            }
        }




        ?>
        <div class="panel-body  ">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ser_cat" style="margin-left: 60%; margin-bottom: 1%;">
                        <span><b>Type to search the specific Category:</b></span>
                        <input id="myInput" type="text" placeholder="Search..">
                    </div>
                    <!-- <label>Select Category * </label> -->
                    <div style="height:250px;overflow-y:scroll" class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title">
                                    <p role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> *
                                        Select Category <i class="fa fa-angle-down" aria-hidden="true"></i> </p>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <ul class="nav">
                                        <?php foreach ($categories as $cate_key => $category) { ?>
                                            <li><a><span class="my_category" role="button" data-toggle="collapse" data-parent="#accordionMenu<?= $cate_key ?>" href="#collapseTwo<?= $cate_key ?>" aria-expanded="<?= $cate_key == 0 ? "true" : "false" ?>" aria-controls="collapseTwo"> <?= $category->cat_name ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                    </span></a>
                                                <div id="collapseTwo<?= $cate_key ?>" class="panel-collapse collapse <?= $cate_key == 0 ? "in" : "" ?>" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <?php
                                                        $sub_categories = getSubCate_Byid($category->id);

                                                        ?>
                                                        <ul class="nav">
                                                            <?php foreach ($sub_categories as $sub) {
                                                                $sub_child = getchild_Byid($sub->id);
                                                                ?>
                                                                <li><a><input type='checkbox' id="category" value="<?= $category->id ?>_<?= $sub->id ?>" <?= (in_array($category->id . "_" . $sub->id, $sub_catw)) ? "checked" : "" ?> name='sub_cat[]' /><?= $sub->sub_name ?></a>

                                                                    <ul class="nav">
                                                                        <?php foreach ($sub_child as $sub_ch) {

                                                                            ?>
                                                                            <ul class="mynav">
                                                                                <li style='list-style-type: none;'><a><input type='checkbox' id="category" <?= (in_array($category->id . "_" . $sub->id . "_" . $sub_ch->id, $sub_catw)) ? "checked" : "" ?> name='sub_cat[]' /><?= $sub_ch->sub_name ?></a>
                                                                                </li>
                                                                            </ul>
                                                                        <?php } ?>
                                                                    </ul>

                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="panel-body pb">
            <div class="row">

                <div class="col-sm-2">
                    <label>Actual Price</label>
                    <input type="text" id="act_price" name="act_price" value="<?= $products->act_price ?>" class="form-control" placeholder="Actual Price">
                </div>
                <div class="col-sm-2">
                    <label>Offer Price</label>
                    <input type="text" id="dis_price" name="dis_price" value="<?= $products->dis_price ?>" class="form-control" placeholder="Discount Price" value="" autocomplete="off" />
                </div>
                <div class="col-sm-3">
                    <label>Total Product In Stock</label>
                    <input type="text" id="pro_stock" name="pro_stock" value="<?= $products->pro_stock ?>" class="form-control" placeholder="Total Products" value="" autocomplete="off" />
                </div>
                <div class="col-sm-2">
                    <label>In Stock</label>
                    <select class="form-control" name="in_stock" id="in_stock">
                        <option value="1" <?= $products->in_stock == 1 ? "selected" : "" ?>>Yes</option>
                        <option value="0" <?= $products->in_stock == 0 ? "selected" : "" ?>>No</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" name="pro_id" value="<?= encode($this->encryption->encrypt($products->ID)) ?>" />
        <div class="panel-body pb">
            <div class="row">
                <div class="col-sm-12">
                    <label>Description</label>
                    <textarea id="pro_desc" name="pro_desc" rows="4" class="form-control" placeholder="Description"><?= $products->pro_desc ?></textarea>
                    <?= display_ckeditor($ckeditor); ?>
                </div>
            </div>
        </div>
        <div class="panel-body  ">
            <div class="row">
                <div class="col-sm-12">
                    <label>Short Description</label>
                    <textarea id="sort_pro_desc" name="sort_pro_desc" rows="4" class="form-control" placeholder="Short Description"><?= $products->short_desc ?></textarea>
                    <?= display_ckeditor($short); ?>
                </div>
            </div>
        </div>
       
        <div class="panel-body  ">
            <div class="row">
                <div class="col-sm-12">
                    <label>Meta description</label>
                    <textarea id="meta_desc" name="meta_desc" rows="4" class="form-control" placeholder=""><?= isset($products->meta_desc) ? $products->meta_desc : "" ?></textarea>
                </div>
            </div>
        </div>
        <div class="panel-body  ">
            <div class="row">
                <div class="col-sm-12">
                    <label>Meta Keyword</label>
                    <textarea id="meta_key" name="meta_key" rows="4" class="form-control" placeholder=""><?= isset($products->meta_key) ? $products->meta_key : "" ?></textarea>
                </div>
            </div>
        </div>
        <div class="panel-body  ">
            <div class="row">
                <div class="col-sm-12">
                    <label>Meta Title</label>
                    <textarea id="title" name="title" rows="4" class="form-control" placeholder=""><?= isset($products->title) ? $products->title : "" ?></textarea>
                </div>
            </div>
        </div>

        <div class="panel-body  pb">
            <div class="row">
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-plus-circle"></i> Update Products</button>
                </div>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</main>