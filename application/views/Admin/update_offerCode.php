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
                            <a href="#"> Update Offer</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>

                    <div class="page-header">
                        <?=$this->session->flashdata('msg')?>
                        <?=$this->session->flashdata('insert')?>
                        <?=validation_errors();?>
                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>
<?php
// echo "<pre>";
// print_r($data);
?>
    <div class="container-fluid">
        <div class="section">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">
                        <div class="panel-body">
                        <?php
                            $url = base_url()."Admin/SadminLogin/update_offerCode/".encode($this->encryption->encrypt($data->id));
                           ?>
                            <?=form_open_multipart($url, array('method' => 'POST', 'id' => 'sform2', 'class' => 'sform2'))?>
                            <div class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Offer Name</label>
                                        <input type="text" id="offer_name" name="offer_name" class="form-control"
                                            placeholder="Offer Name" value="<?= $data->offer_name ?>"  autocomplete="off" required />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Offer Code</label>
                                        <input type="text" id="offer_code" name="offer_code" class="form-control"
                                            placeholder="Offer Code" value="<?= $data->offer_code ?>" autocomplete="off" required />
                                    </div>

                                    <div class="col-sm-2">
                                        <label>Offer Type</label>
                                        <select class="form-control" name="offer_type" id="offer_type" required>
                                            <option <?= ($data->offer_type == 0)?"selected":'' ?> value="0">Price</option>
                                            <option <?= ($data->offer_type == 1)?"selected":'' ?>value="1">%</option>
                                        </select>
                                    </div>
                                    <!-- <div class="col-sm-1">
                                        <label>New User</label>
                                        <input type="checkbox" value="1" name="offer_on">
                                    </div> -->
                                    <div class="col-sm-3">
                                        <label>Offer Value</label>
                                        <input type="text" id="offer_val" name="offer_val" class="form-control"
                                            placeholder="Offer Value" value="<?= $data->offer_val ?>" autocomplete="off" required />
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Group Name</label>
                                        <select class="form-control" name="customer_grp" id="which_price" required>

                                            <?php foreach ($groups as $value) {?>
                                            <option <?= ($value->id == $data->group_name)?'selected' : '' ?> value="<?= $value->id?>"><?=$value->group_name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                   
                                    <div class="col-sm-3">
                                        <label>Offer Per Customer (0 if infinitive)</label>
                                        <input type="text" id="offer_per_customer" name="offer_per_customer"
                                            class="form-control" placeholder="Offer Customer" value="<?= $data->offer_per_customer ?>"
                                            autocomplete="off" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>From Date </label>
                                        <input type="text" id="offer_validity_from" name="offer_validity_from"
                                            class="form-control" placeholder="Offer From" value=" <?= date("d-m-Y", strtotime($data->offer_validity_from)) ?> " autocomplete="off" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>To Date</label>
                                        <input type="text" id="offer_validity_to" name="offer_validity_to"
                                            class="form-control" placeholder="Offer To" value=" <?= date("d-m-Y", strtotime($data->offer_validity_to)) ?> " autocomplete="off" />
                                    </div>

                                </div>


                            </div>
                            <div class="panel-body  pb">
                                <div class="row">
                                    
                                    <div class="col-sm-3">
                                        <label>Priority</label>
                                        <input type="text" id="priority" name="priority"
                                            class="form-control" value="<?= $data->priority ?>" placeholder="Priority" autocomplete="off" />
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Conditions </label>
                                        <select class="form-control" name="condition" id="condition" onchange=check_condition(this);>
                                            <option value="">Choose a condition to add offer</option>
                                            <option value="1">Category</option>
                                            <option value="2">Product</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 which_price">
                                        <label>Which Price</label>
                                        <select class="form-control" name="which_price" id="which_price" required>
                                            <option <?= ($data->which_price == 0)?'selected':'' ?> value="0">Subtotal</option>
                                            <option <?= ($data->which_price == 1)?'selected':'' ?> value="1">Grand-Total</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-1">
                                        <label>Min Value</label>
                                        <input type="text" id="min_val" name="min_val" class="form-control"
                                            placeholder="Min Value" value="<?= $data->min_val ?> " autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body " id="category" style="display:none;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Select Category * </label>
                                        <div style="height:250px;overflow-y:scroll" class="panel-group"
                                            id="accordionMenu" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne"
                                                    data-toggle="collapse" data-parent="#accordionMenu"
                                                    href="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    <h4 class="panel-title">
                                                        <p role="button" data-toggle="collapse"
                                                            data-parent="#accordionMenu" href="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne"> *
                                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                        </p>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                                    aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <ul class="nav">
                                                            <?php foreach ($categories as $cate_key => $category) {?>
                                                            <li><a><span class="my_category" role="button"
                                                                        data-toggle="collapse"
                                                                        data-parent="#accordionMenu<?=$cate_key?>"
                                                                        href="#collapseTwo<?=$cate_key?>"
                                                                        aria-expanded="<?=$cate_key == 0 ? "true" : "false"?>"
                                                                        aria-controls="collapseTwo">
                                                                        <?=$category->cat_name?> <i
                                                                            class="fa fa-angle-down"
                                                                            aria-hidden="true"></i> </span></a>
                                                                <div id="collapseTwo<?=$cate_key?>"
                                                                    class="panel-collapse collapse <?=$cate_key == 0 ? "in" : ""?>"
                                                                    role="tabpanel" aria-labelledby="headingOne">
                                                                    <div class="panel-body">
                                                                        <?php
                                                                            $sub_categories = getSubCate_Byid($category->id);
                                                                        ?>
                                                                        <ul class="nav">
                                                                            <?php foreach ($sub_categories as $sub) {?>
                                                                            <li><a><input type='checkbox' id="category"
                                                                                        onclick='if($(this).prop("checked") == true){$(this).val("<?=$category->id?>_<?=$sub->id?>");}else{$(this).val(""); return false;}'
                                                                                        name='sub_cat[]' /><?=$sub->sub_name?></a>
                                                                            </li>
                                                                            <?php }?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?php }?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="panel-body" id="products" style="display:none;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label id="product-table">Select Products</label>
                                        <div style="height:250px;overflow-y:scroll" class="panel-group"
                                            id="accordionMenu" role="tablist" aria-multiselectable="true">
                                            <div class="table-responsive">

                                                <table id='example'
                                                    class="table table-bordered table-striped table-nowrap no-mb">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Product Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamic_prod">
                                                    
                                                      
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="panel-body  pb">
                        <div class="row">

                            <div class="col-sm-3">
                                <input type="submit" value="Update" class="btn btn-xs btn-success">
                            </div>
                        </div>


                    </div>
                    <?=form_close();?>


                </div>
            </div>



        </div>


    </div>
    </div>

    <div id="setMe"></div>

    </div>


</main>