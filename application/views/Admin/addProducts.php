 <main class="main-container">


     <?= $this->session->flashdata('msg'); ?>
     <?= $this->session->flashdata('insert'); ?>


     <div class="panel panel-white">
         <?= form_open_multipart('Admin/Vendor/addVendorProducts', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'name' => 'sform2', 'id' => 'sform2', 'method' => 'POST')); ?>
         <div class="panel-body ">
             <div class="row">
                 <div class="col-md-12">
                     <ul class="heading_class">
                         <li id="product_details" onclick="callProductDetails()" class=" active col-md-3 list-group-item list-group-item-action flex-column align-items-start">
                             <a href="#">Product Details</a> <span class="badge badge-primary badge-pill">1</span></li>
                         <li id="product_price" onclick="callProductPrice()" class="col-md-3 list-group-item list-group-item-action flex-column align-items-start"><a href="#">Product Price</a> <span class="badge badge-primary badge-pill">2</span></li>
                         <li id="product_properties" onclick="callProductProperties()" class="col-md-3 list-group-item list-group-item-action flex-column align-items-start"><a href="#">Product Properties</a> <span class="badge badge-primary badge-pill">3</span>
                         </li>

                     </ul>
                 </div>
             </div>
         </div>
         <div class="product_details_class">
             <header class="page-heading">
                 <div class="container-fluid">
                     <div class="row">
                         <div class="col-md-12">
                             <div class="page-header">
                                 <h2 class="page-subtitle">
                                     Product Details
                                 </h2>
                             </div>
                         </div>
                     </div>
                 </div>
             </header>

             <div class="panel-body">
                 <div class="row">
                     <div class="col-sm-3">
                         <label>Product Id</label>
                         <input type="text" id="product_id" name="product_id" class="form-control" readonly="" value="<?= "PAUL-" . ($unique + 1) ?>">
                     </div>
                     <div class="col-sm-1">
                         <label>
                             None <br>
                             <input type="radio" checked name="type" value="0">
                         </label>
                     </div>
                     <!-- <div class="col-sm-2">
                         <label>
                             Is In Sale <br>
                             <input type="radio" name="type" value="1">
                         </label>
                     </div>
                     <div class="col-sm-2">
                         <label>
                             Is Top Seller <br>
                             <input type="radio" name="type" value="2">
                         </label>
                     </div>
                     <div class="col-sm-2">
                         <label>
                             Is Trending <br>
                             <input type="radio" name="type" value="3">
                         </label>
                     </div> -->
                     <div class="col-sm-2">
                         <label>
                             Is New <br>
                             <input type="radio" name="type" value="4">
                         </label>
                     </div>
                     <!-- <div class="col-sm-3">
                         <label>Category</label>
                         <select class="form-control" onchange="getSubcategory(this.value);" name="category" id="category">
                             <option value="">Select Category</option>
                             <?php // foreach ($categories as $category) { ?>
                                                     <option value="<?php // $this->encrypt->encode($category->id) ?>"><?= $category->cat_name ?></option>
                             <?php // } ?>
                         </select>
                     </div> -->
                     <!-- <div class="col-sm-3">
                         <label>Sub Category</label>
                         <select class="form-control" onchange="getChildCategory(this.value)" name="sub_category" id="sub_category_ven">
                             <option value="">Sub Category</option>
                         </select>
                     </div>
                     <div class="col-sm-3">
                         <label>Child Category</label>
                         <select class="form-control" name="child_category" id="child_category_ven">
                             <option value="">Child Sub Category</option>
                         </select>
                     </div> -->
                 </div>
             </div>
             <div class="panel-body  ">
                 <div class="row">
                     <div class="col-sm-3">
                         <label>Product Name</label>
                         <input type="text" id="product_name" name="product_name" minlength="10" maxlength="70" class="form-control" placeholder="Product Name">
                     </div>
                     <div class="col-sm-3">
                         <label>Product Sub Name</label>
                         <input type="text" id="product_sname" name="product_sname" minlength="5" maxlength="70" class="form-control" placeholder="Product Sub Name">
                     </div>
                     <div class="col-sm-3">
                         <label>SKU </label>
                         <input type="text" id="sku" required="" minlength="2" name="sku" class="form-control" placeholder="SKU">
                     </div>
                     <div class="col-sm-3">
                         <label>Limit for Add to Cart</label>
                         <input type="text" id="limit" required="" name="limit" class="form-control" placeholder="Limit for Add to Cart">
                     </div>
                     <!-- <div class="col-sm-1">
                         <label>COLOR </label> <br>
                         <input type="color" name="color" value="#00000">
                     </div>
                     <div class="col-sm-2">
                         <label>Color Label </label> <br>
                         <input type="text" id="color_label" value="Black" minlength="2" name="color_label"
                             class="form-control" placeholder="SKU">
                     </div> -->
                 </div>
             </div>

             <div class="panel-body  ">
                 <div class="row">
                     <div class="col-sm-12">
                         <label>Description</label>
                         <textarea id="pro_desc" name="pro_desc" rows="4" class="form-control" placeholder="Description"></textarea>
                         <?= display_ckeditor($ckeditor); ?>
                     </div>
                 </div>
             </div>
             <div class="panel-body  ">
                 <div class="row">
                     <div class="col-sm-12">
                         <label>Short Description</label>
                         <textarea id="sort_pro_desc" name="sort_pro_desc" rows="4" class="form-control" placeholder="Short Description"></textarea>
                         <?= display_ckeditor($short); ?>
                     </div>
                 </div>
             </div>
             
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
                                                 <li ><a style="background:#000;color:#fff"><span class="my_category" role="button" data-toggle="collapse" data-parent="#accordionMenu<?= $cate_key ?>" href="#collapseTwo<?= $cate_key ?>" aria-expanded="<?= $cate_key == 0 ? "true" : "false" ?>" aria-controls="collapseTwo"> <?= $category->cat_name ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                         </span></a>
                                                     <div id="collapseTwo<?= $cate_key ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                         <div class="panel-body">
                                                             <?php
                                                                $sub_categories = getSubCate_Byid($category->id);

                                                                ?>
                                                             <ul class="nav">
                                                                 <?php foreach ($sub_categories as $sub) {
                                                                        $sub_child = getchild_Byid($sub->id);
                                                                        ?>
                                                                     <li style="display:inline-block"><a><input type='checkbox' id="category" onchange='if($(this).prop("checked") == true){$(this).val("<?= $category->id ?>_<?= $sub->id ?>");}else{$(this).val(""); return false;}' name='sub_cat[]' /><?= $sub->sub_name ?></a>

                                                                         <ul class="nav">
                                                                             <?php foreach ($sub_child as $sub_ch) {

                                                                                    ?>
                                                                                 <ul class="mynav">
                                                                                     <li style='list-style-type: none;'><a><input type='checkbox' id="category" onchange='if($(this).prop("checked") == true){$(this).val("<?= $category->id ?>_<?= $sub->id ?>_<?= $sub_ch->id ?>");}else{$(this).val(""); return false;}' name='sub_cat[]' /><?= $sub_ch->sub_name ?></a>
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

             <div class="panel-body  ">
                 <div class="row">
                     <div class="col-sm-4">
                         <label for="">&nbsp;</label>
                         <button onclick="callProductPrice()" type="button" class="btn btn-warning btn-xs">Next
                             Step</button>
                     </div>
                 </div>
             </div>


         </div>
         <div class="product_price_class" style="display: none">
             <header class="page-heading">
                 <div class="container-fluid">
                     <div class="row">
                         <div class="col-md-12">
                             <div class="page-header">
                                 <h2 class="page-subtitle">
                                     Product Price
                                 </h2>
                             </div>
                         </div>
                     </div>
                 </div>
             </header>
             <div class="panel-body  ">
                 <div class="row">
                     <div class="col-sm-3">
                         <label>Actual Price</label>
                         <input type="text" id="act_price" name="act_price" class="form-control" placeholder="Actual Price">
                     </div>
                     <div class="col-sm-3">
                         <label>Offer Price</label>
                         <input type="text" id="dis_price" name="dis_price" class="form-control" placeholder="Discount Price" value="" autocomplete="off" />
                     </div>
                     <div class="col-sm-3">
                         <label>Total Product In Stock</label>
                         <input type="text" id="pro_stock" name="pro_stock" class="form-control" placeholder="Total Products" value="" autocomplete="off" />
                     </div>
                     <div class="col-sm-3">
                         <label>In Stock</label>
                         <select class="form-control" name="in_stock" id="in_stock">
                             <option value="1">Yes</option>
                             <option value="0">No</option>
                         </select>
                     </div>
                 </div>


             </div>

             <div class="panel-body  ">
                 <div class="row">
                     <div class="col-sm-3">
                         <label>GST %</label>
                         <input type="text" id="gst" name="gst" class="form-control" placeholder="GST %">
                     </div>
                     <div class="col-sm-3">
                         <label>HSN Code</label>
                         <input type="text" id="hsn_code" name="hsn_code" class="form-control" placeholder="HSN Code">
                     </div>
                     <div class="col-sm-4">
                         <label>Tags</label>
                         <textarea rows="3" cols="40" id="txt" name="txt" class="form-control" placeholder='Add Tags'></textarea>

                     </div>



                 </div>


             </div>
             

             <div class="panel-body">

                 <div class="col-sm-4">
                     <label for="">&nbsp;</label><br>
                     <button type="button" onclick="callProductProperties()" class="btn btn-warning btn-xs">Next
                         Step</button>
                 </div>
             </div>


         </div>
         <div class="product_properties_class" style="display: none">
             <header class="page-heading">
                 <div class="container-fluid">
                     <div class="row">
                         <div class="col-md-12">
                             <div class="page-header">
                                 <h2 class="page-subtitle">
                                     Product Properties (Add properties like color size etc,if you do not want to add
                                     properties just click on submit )
                                 </h2>
                             </div>
                         </div>
                     </div>
                 </div>
             </header>


             <div class="panel-body  pb">
                 <div class="row">
                     <div class="container-fluid">
                         <div class=" col-sm-3  pull-right">
                             <label for=""></label><br>

                             <button type="button" onclick="addProp()" class="btn btn-info btn-xs  pull-right">Add
                                 Size
                             </button>

                             <button type="button" data-toggle="modal" data-target="#myModal2" onclick="" class="btn btn-warning btn-xs  pull-right">Add More
                                 Attribute
                             </button>
                         </div>
                         <div class="mydiv"></div>
                     </div>
                 </div>
             </div>
             <div class="panel-body">
                 <div class="row">
                     <div class=" col-sm-4">
                         <label for="">&nbsp;</label>
                         <button type="button" onclick="submitVenForm()" class="btn btn-default">Submit</button>
                     </div>
                 </div>
             </div>
         </div>
         <div class="product_images_class" style="display: none">
             <header class="page-heading">
                 <div class="container-fluid">
                     <div class="row">
                         <div class="col-md-12">
                             <div class="page-header">
                                 <h2 class="page-subtitle">
                                     Product Images
                                 </h2>
                             </div>
                         </div>
                     </div>
                 </div>
             </header>
             <div class="panel-body ">
                 <div class="row">
                     <div class="col-sm-3">
                         <label for=""></label><br>
                         <button type="button" class="btn btn-warning btn-xs add_more">Add Properties</button>
                     </div>

                 </div>
             </div>
             <div class="panel-body ">
                 <div class="row">
                     <div class=" col-sm-4">
                         <label for="">&nbsp;</label>
                         <button type="submit" class="btn btn-default">Add Products</button>
                     </div>
                 </div>
             </div>

         </div>

         <?= form_close(); ?>
     </div>
 </main>

 <div class="view-similar modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                 <h4 class="modal-title" id="myModalLabel2">All Attribute</h4>
             </div>
             <div class="modal-body">

                 <?php foreach ($properties as $prop) {
                        if ($prop->id != 2) { ?>
                         <input type="checkbox" id="attributes" name="attributes[]" value="<?= $prop->id ?>" /> <?= $prop->pop_name ?> <br>
                     <?php }
                    } ?>

                 <button class="btn  btn-success btn-xs" onclick="get_prop();"> Add </button>

             </div>
         </div>
     </div>
 </div>