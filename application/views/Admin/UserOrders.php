<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

                        <?=$this->session->flashdata('insert')?>
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
                            <div class="serch_fromto">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Search:</label>
                                            <input type="text" class="tbl-search form-control" placeholder="Search">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>

                                        </div>
                                    </div>
                                    <?=form_open('Admin/Vendor/search_bydate', array('method' => 'GET', 'target' => '_blank'))?>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Search By Date:</label>
                                            <input type="text" id="offer_validity_from" class="form-control" name="from"
                                                   placeholder="Order from"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <input type="text" id="offer_validity_to" class="form-control" name="to"
                                                   placeholder="Order to"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-success" type="submit">SEARCH</button>
                                    </div>
                                    <?=form_close()?>
                                    <div class="col-sm-3">
                                        <label>&nbsp;</label>
                                        <a  onclick="$('.export').toggle();" class="btn btn-info btn-xs pull-right"
                                           href="javascript:void(0)">Download Data</a>
                                    </div>
                                </div>
                            </div>


                            <div style="display: none;" class="export">
                                <div class="row">
                                <?=form_open('Admin/Vendor/ExportOrder', array('method' => 'POST', 'target' => '_blank'))?>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Categories:</label>
                                            <select name="cat[]" class="form-control" multiple id="">
                                            <?php foreach ($categories as $category) {?>
                                                <option selected value="<?=$category->id?>"><?=$category->cat_name?></option>
                                            <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Method</label>
                                           <select name="method" class="form-control"  id="">
                                                <option value="">All</option>
                                                <option value="0">COD</option>
                                                <option value="1">Online</option>
                                                <option value="2">Wallet</option>
                                                <option value="3">Wallet+Online</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Pay Status</label>
                                            <select name="pay_status" class="form-control"  id="">
                                                <option value="">All</option>
                                                <option value="1">Success</option>
                                                <option value="0">Failed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control"  id="">
                                                <option value="">All</option>
                                                <option value="0">Pending</option>
                                                <option value="1">Shipped</option>
                                                <option value="7">Delivered</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>  By Date:</label>
                                            <input type="text" id="fromDate" class="form-control" name="fromDate"
                                                   placeholder="Order from"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <input type="text" id="toDate" class="form-control" name="toDate"
                                                   placeholder="Order to"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-success" type="submit">Export</button>
                                    </div>
                                    <?=form_close()?>

                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class="table  ">
                                    <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Purchase Date / Method</th>
                                        <th>Invoice</th>
                                        <th>Gift Wrap</th>
                                        <!-- <th>Add to Bag Request</th> -->
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Product qty</th>
                                        <th>Order Status</th>
                                        <th>Comments</th>
                                        <th>Cancellation Request</th>
                                        <th>Coupon</th>
                                        <th>Delivery Charge</th>
                                        <th>Gift Wrap charge</th>
                                        <th>Final checkout price</th>
                                        <th>Shipping Address</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Pin code</th>
                                        <th>Payment Status</th>
                                        <!-- <th>Bag Delivery Date </th> -->
                                        <th>Order Details</th>

                                    </tr>
                                    </thead>
                                    <?=$links?>
                                    <tbody style="white-space:nowrap" id="userOrderModule">
                                    <?php
foreach ($results as $key => $res) {

    $allOrder = getAllOrder($res->OID);

    //$allOrder = getAllOrder($res->OID);
    //     echo "<pre>";
    //   $res->pro_sta ==1 == > Pending ;
    //   $res->pro_sta ==2 == > Waiting For Refund ;
    //   $res->pro_sta ==3 == > Delivered;
    ?>
                                        <tr>
                                            <td>10000<?=$res->OID?></td>
                                            <td><?=$res->pay_date?> <br>
                                            <?php if ($res->pay_method == 3 && $res->add_to_box == 1) {
        echo "<b>AddtoBox+Wallet</b>";
    } else {?>
                                                <b>Pay Method
                                                    :<?=($res->pay_method == 0 ? "COD" : ($res->pay_method == 1 ? "Online" : ($res->pay_method == 2 ? "Wallet" : ($res->pay_method == 3 ? "Wallet+Online" : ($res->pay_method == 4 ? "Paytm" : ($res->pay_method == 5 ? "Wallet+Paytm" : ($res->pay_method == 6 ? "AddtoBag+Online" : "")))))))?> </b>
                                                <?php }?>
                                            </td>
                                            <td style="white-space: nowrap">

                                                <a title="User Invoice" target="_blank" href="<?=base_url('Admin/Vendor/Invoice/')?><?=encode($this->encryption->encrypt($res->id))?>/29" class="btn btn-success btn-xs"> <i class="fa fa-list"></i></a>

                                            </td>

                                            <?php if ($res->is_gifted == 1) {?>
                                                <td style="color:green;">
                                                    <small><b>To: </b> <?=$res->recipent?> </small>
                                                    <br>
                                                    <small><b>From: </b> <?=$res->sender?> </small>
                                                    <br>
                                                    <small><b>MSG: </b> <?=$res->gift_msg?> </small>
                                                </td>
                                            <?php } else {?>
                                                <td></td>
                                            <?php }?>
                                            <!-- <td style="<?=$res->add_to_box == 1 ? "color: yellow;background: indianred;" : " "?>"><?=$res->add_to_box == 1 ? "Bag Request" : " "?> </td> -->
                                           <!-- <td>
                                           <?php
$bagControl = '';
    if ($res->add_to_box == 1) {
        $bagControl = 1;
    }
    if ($res->add_to_box == 2) {
        $bagControl = 2;
    }
    if ($res->add_to_box == 1) {
        $bagControl = 1;
    }

    if (isset($res->bag_delivery_date) && $res->bag_delivery_date != '') {
        if ($res->bag_ship_confirm == 0) {
            ?>
                                                    <select data-or="<?=$res->OID?>" name="bag_option"
                                                                id="bag_option" style="<?=$res->add_to_box == 2 ? "color:green" : "color:red"?>">


                                                            <option <?=$res->add_to_box == 1 ? "selected" : ""?>
                                                                    value="1">
                                                              User Bag Requested
                                                            </option>


                                                            <option <?=$res->add_to_box == 2 ? "selected" : ""?>
                                                                    value="2" >
                                                              Bag Request Accepted
                                                            </option>

                                                     </select>
                                           <?php } else {?>
                                            <p class="text-danger"> Shipping Amount Paid for addtobox</p>
                                        <?php }} else if ($res->add_to_box == 1) {?>
                                            <p> Not date mentioned</p>
                                           <?php }?>
                                           <div class="bag_form_<?=$res->OID?>" style="display:none;">
                                                <form method="POST" action="<?=base_url("Admin/Vendor/bagShipping")?>">
                                                <input type="hidden" name="oid" value="<?=$res->OID?>" >
                                                <input type="text" name="amt" placeholder="Shipping Amount">
                                                <button class="btn btn-xs btn-success">Send</button>
                                                </form>
                                           </div>

                                           </td> -->
                                            <td><?=$res->first_name?> <?=$res->last_name?></td>
                                            <td><?=$res->user_email?></td>
                                            <td><?=$res->user_contact?></td>
                                            <!-- <td>
                                                <?php
foreach ($allOrder as $key => $val) {
        // echo "<pre>";
        // print_r($val);
        ?>
                                                    <small><b>(<?=$key + 1?>): </b><?=$val->pro_name?><b style='color:red'><?php echo ($val->add_to_box == 1) ? "(In the Box)" : "" ?></b></small> <br>
                                                    <?php
}
    ?>

                                            </td> -->
                                            <td><?php
$totalQty = 0;
    foreach ($allOrder as $val) {
        $totalQty = floatval($totalQty) + floatval($val->pro_qty);
        ?>
                                                    <!-- <span> <?=$val->pro_qty?> </span> <br> -->
                                                    <?php
}
    ?> <span> <?=$totalQty?> </span>  </td>
                                            <!-- <td>
                                                <?php
foreach ($allOrder as $val) {
        ?>
                                                    <small><?=$val->order_attr?></small> <br>
                                                    <?php
}
    ?>

                                            </td> -->
                                            <td>
                                                <?php

    // if ($val->order_status == 0) {
    //     $ost = "PENDING";
    // } else if ($val->order_status == 1) {
    //     $ost = "SHIPPED";
    // } else if ($val->order_status == 7) {
    //     $ost = "DELIVERED";
    // }
    foreach ($allOrder as $val) {
    if ($val->order_status == 0) {
        $ost = "PENDING";
        $color = "red";
    } else if ($val->order_status == 1) {
        $ost = "SHIPPED AWD No - " . $res->shipping_awb;
        $color = "#0008ff";
    } else if ($val->order_status == 7) {
        $ost = "DELIVERED";
        $color = "green";
    } else if ($val->order_status == 6) {
        $ost = "ADMIN CANCEL";
    } else if ($val->order_status == 8) {
        $ost = "CANCELLATION REQUESTED";
    }

    if ($val->pay_sta == 1) {

        ?>
                                                        <select data-or="<?=$val->or_id?>" name="delivery_option"id="delivery_option" style="color:<?=$color?>">
                                                            <?php if($val->order_status == 10){?>
                                                            <option value="">Exchange Request</option>
                                                            <?php } if($val->order_status == 9){?>
                                                            <option value="">Return Request</option>
                                                            <?php } ?>
                                                            <option <?=$val->order_status == 0 ? "selected" : ""?>
                                                                    value="0">
                                                                Pending
                                                            </option>
                                                            <option <?=$val->order_status == 2 ? "selected" : ""?>
                                                                    value="2">
                                                                Packed
                                                            </option>
                                                            <option <?=$val->order_status == 1 ? "selected" : ""?>
                                                                    value="1">
                                                                Shipped
                                                            </option>
                                                            <option <?=$val->order_status == 7 ? "selected" : ""?>
                                                                    value="7">
                                                                Delivered
                                                            </option>
                                                            <option <?=$val->order_status == 8 ? "selected" : ""?>
                                                                    value="8">
                                                                Cancellation Requested
                                                            </option>
                                                            <option <?=$val->order_status == 6 ? "selected" : ""?>
                                                                    value="6">
                                                              Cancelled
                                                            </option>
                                                            <option <?=$val->order_status == 11 ? "selected" : ""?>
                                                                    value="11">
                                                              Return Accepted
                                                            </option>
                                                            <option <?=$val->order_status == 12 ? "selected" : ""?>
                                                                    value="12">
                                                              Exchange Accepted
                                                            </option>

                                                        </select> <br>
                                                        <?php
    }
}

    ?>
                                            </td>
                                            <td><textarea><?=$ost?></textarea></td>
                                             <td>
                                                <?php
foreach ($allOrder as $val) {

        $cancelOrder = getCancelOrder($val->or_id);
        if ($cancelOrder != '') {
            echo " <p class='text-danger'> OID-00{$val->or_id} Admin Comment :" . $cancelOrder->comment . "</p>";
        }
        ?>
                                                    <?php
if ($val->cancel_comments != '') {
            ?>
                                                        User Comments: OID-00<?=$val->or_id?> <br><?=$val->cancel_comments?>
                                                    <?php }?>
                                                <?php }?>


                                            </td>
<!--
                                            <td><?php
foreach ($allOrder as $val) {
        ?>
                                                    <span> <i class="fa fa-inr"></i> <?=$val->act_price?> </span> <br>
                                                    <?php
}
    ?> </td>
                                            <td>
                                                <?php
foreach ($allOrder as $val) {
        $decrease = floatval($val->act_price) - floatval($val->pro_price / $val->pro_qty);
        $percentage = $decrease / floatval($val->act_price) * 100;
        ?>
                                                    <span> <?=number_format($percentage, 2, '.', '')?>%</span> <br>
                                                    <?php
}
    ?>
                                            </td>
                                            <td> <?php
foreach ($allOrder as $val) {
        ?>
                                                    <span><i class="fa fa-inr"></i> <?=round($val->pro_price)?> </span>
                                                    <br>
                                                    <?php
}
    ?>
                                            </td> -->
                                            <td>
                                                <?php
if ($res->offer_id != 0) {

        echo getOfferDetails($res->offer_id) ? getOfferDetails($res->offer_id)[0]->offer_name : "";
    }
    echo "<br>";
    echo '<i class="fa fa-inr"></i> ' . number_format($res->total_offer, 2, '.', '');
    ?>

                                                <br>
                                            </td>

                                            <td><i class="fa fa-inr"></i> <?=$res->shipping?></td>
                                            <td><i class="fa fa-inr"></i> <?=$res->gift_price?> </td>
                                            <td><i class="fa fa-inr"></i> <?=$res->total_order_price?></td>


                                            <td title="<?=$res->user_address?>">
                                                <?=substr($res->user_address, 0, 10)?></td>
                                            <td><?=$res->state?></td>
                                            <td><?=$res->user_city?></td>
                                            <td><?=$res->user_pin_code?></td>
                                            <td><?=$res->pay_sta == 1 ? "Done" : "Failed"?> </td>

                                            <!-- <td style="<?=(isset($res->bag_delivery_date) && $res->bag_delivery_date != '') ? "color: yellow;background: indianred;" : " "?>"><?=(isset($res->bag_delivery_date) && $res->bag_delivery_date != '') ? date('d-m-Y', strtotime($res->bag_delivery_date)) : " "?> </td> -->
                                            <td><a class="btn btn-dark btn-xs" href=" <?=base_url('Admin/Vendor/addToBag/')?><?=encode($this->encryption->encrypt($res->id))?>/29">View Details</a> </td>
                                        </tr>
                                    <?php }?>

                                    </tbody>
                                </table>
                                <?=$links?>
                            </div>

                        </div>
                    </div>


                </div>


            </div>
        </div>


    </div>

    <div class="view-similar modal fade" id="bagModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
    <form id="cancelForm" method="POST" action="<?=base_url("Myaccount/cancelRequest")?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel26">Put on shipping amount for add to bag orders :# </h4>
                </div>
                <div class="modal-body my_cancel">


                </div>

            </div>
        </div>
    </form>
</div>

</main>