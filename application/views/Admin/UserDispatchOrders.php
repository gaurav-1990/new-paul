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

                            <div class="panel panel-white">
                                <?= $this->session->flashdata('msg'); ?>
                                <div class="panel-body  pb">
                                    <?php
                                    $output = '';
                                    $output .= form_open_multipart('Admin/DataUpload/save');
                                    $output .= '<div class="row">';

                                    $output .= '<div class="col-lg-3 col-sm-4"><div class="form-group">';

                                    $output .= form_label('Upload Data For Shipping and Invoice', 'file');
                                    $data = array(
                                        'name' => 'userfile',
                                        'id' => 'userfile',
                                        'class' => 'form-control ',
                                        'value' => '',
                                        'required' => true
                                    );
                                    $output .= form_upload($data);
                                    $output .= '</div> <span style="color:red;">*Please choose an Excel file(.csv) as Input</span></div>';
                                    $output .= '<div class="col-lg-3 col-sm-6"><div class="form-group ">';

                                    $data = array(
                                        'name' => 'importfile',
                                        'id' => 'importfile-id',
                                        'class' => 'btn btn-primary',
                                        'value' => 'Import Data',
                                    );
                                    $output .= form_submit($data, 'Import Data');
                                    $output .= '</div>
                    </div>
                        </div>';
                                    $output .= form_close();
                                    echo $output;
                                    ?>


                                </div>
                            </div>


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
                                    <?= form_open('Admin/Vendor/search_bydate', array('method' => 'GET', 'target' => '_blank')) ?>

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
                                    <?= form_close() ?>
                                    <div class="col-sm-3">
                                        <label>&nbsp;</label>
                                        <a class="btn btn-info btn-xs pull-right"
                                           href=<?= base_url('Admin/Vendor/exportCSV') ?>>Download Data</a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table  ">
                                    <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Purchase Date / Method</th>
                                        <th>Gift Wrap</th>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Product Name</th>
                                        <th>Product qty</th>
                                        <th>Product size</th>
                                        <th>Order Status</th>
                                        <th>Comments</th>
                                        <th>Canceled Order</th>
                                        <th>MRP</th>
                                        <th>Dis</th>
                                        <th>Selling Price</th>
                                        <th>Coupon</th>
                                        <th>Delivery Charge</th>
                                        <th>Gift Wrap charge</th>
                                        <th>Final checkout price</th>
                                        <th>Shipping Address</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Pin code</th>
                                        <th>Payment Status</th>
                                        <th>Invoice</th>

                                    </tr>
                                    </thead>
                                    <?= $links ?>
                                    <tbody style="white-space:nowrap" id="userOrderModule">
                                    <?php
                                    foreach ($results as $key => $res) {
                                        $allOrder = getDispatchOrder($res->OID);

                                        //$allOrder = getAllOrder($res->OID);
                                        //     echo "<pre>";
                                        //   $res->pro_sta ==1 == > Pending ;
                                        //   $res->pro_sta ==2 == > Waiting For Refund ;
                                        //   $res->pro_sta ==3 == > Delivered;
                                        ?>
                                        <tr>
                                            <td>10000<?= $res->OID ?></td>
                                            <td><?= $res->pay_date ?> <br>
                                                <b>Pay Method
                                                    :<?= $res->pay_method == 0 ? "COD" : ($res->pay_method == 1 ? "Online" : $res->pay_method == 2 ? "Wallet" : ($res->pay_method == 3 ? "Wallet+Online" : ($res->pay_method == 4 ? "Wallet+COD" : ""))) ?> </b
                                            </td>

                                            <?php if ($res->is_gifted == 1) { ?>
                                                <td style="color:green;">
                                                    <small><b>To: </b> <?= $res->recipent ?> </small>
                                                    <br>
                                                    <small><b>From: </b> <?= $res->sender ?> </small>
                                                    <br>
                                                    <small><b>MSG: </b> <?= $res->gift_msg ?> </small>
                                                </td>
                                            <?php } else { ?>
                                                <td></td>
                                            <?php } ?>
                                            <td><?= $res->first_name ?> <?= $res->last_name ?></td>
                                            <td><?= $res->user_email ?></td>
                                            <td><?= $res->user_contact ?></td>
                                            <td>
                                                <?php
                                                foreach ($allOrder as $key => $val) {
                                                    // echo "<pre>";
                                                    // print_r($val);
                                                    ?>
                                                    <small><b>(<?= $key + 1 ?>): </b><?= $val->pro_name ?><b style='color:red'><?php echo ($val->add_to_box == 1)?"(In the Box)":"" ?></b></small> <br>
                                                    <?php
                                                }
                                                ?>

                                            </td>
                                            <td><?php
                                                foreach ($allOrder as $val) {
                                                    ?>
                                                    <span> <?= $val->pro_qty ?> </span> <br>
                                                    <?php
                                                }
                                                ?> </td>
                                            <td>
                                                <?php
                                                foreach ($allOrder as $val) {
                                                    ?>
                                                    <small><?= $val->order_attr ?></small> <br>
                                                    <?php
                                                }
                                                ?>

                                            </td>
                                            <td>
                                                <?php
                                                foreach ($allOrder as $val) {


                                                    $rfd = "";

                                                    if ($val->order_status == 0) {
                                                        $ost = "PENDING";
                                                    } else if ($val->order_status == 1) {
                                                        $ost = "SHIPPED";
                                                    } else if ($val->order_status == 2) {
                                                        $ost = "REFUND REQUEST";
                                                        $returnRe= getReturnTable($res->OID);

                                                        $ost.= $returnRe!=null?"\nCause : ".$returnRe[0]->return_cause."\nWant in : ".($returnRe[0]->refund==1?"Account \n Account Details: \n ".$returnRe[0]->return_account:"Wallet"):"";
                                                    } else if ($val->order_status == 3) {
                                                        $ost = "EXCHANGE REQUESTED";
                                                    } else if ($val->order_status == 4) {
                                                        $ost = "REFUND ACCEPTED";
                                                    } else if ($val->order_status == 5) {
                                                        $ost = "EXCHANGE ACCEPTED";
                                                    } else if ($val->order_status == 6) {
                                                        $ost = "ADMIN CANCEL";
                                                    } else if ($val->order_status == 7) {
                                                        $ost = "DELIVERED";
                                                    } else if ($val->order_status == 8) {
                                                        $ost = "CANCELLATION REQUESTED";
                                                    }else if ($val->order_status == 9) {
                                                        $ost = "EXCHANGE CANCELLED <br> Reason : ".getExchangeCancelled($orderSS->OID)->reject_cause;
                                                    }

                                                    $refund = getReturnTable($val->or_id);
                                                    if (count($refund) > 0) {
                                                        if ($refund[0]->refund == 1) {
                                                            $rfd = "Account";
                                                        } else if ($refund[0]->refund == 2) {
                                                            $rfd = "Wallet";
                                                        }
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($val->pay_sta == 1) {

                                                        ?>
                                                        <select data-or="<?= $val->or_id ?>" name="delivery_option"
                                                                id="delivery_option">
                                                            <option <?= $val->order_status == 0 ? "selected" : "" ?>
                                                                    value="0">
                                                                Pending
                                                            </option>
                                                            <option <?= $val->order_status == 1 ? "selected" : "" ?>
                                                                    value="1">
                                                                Shipped
                                                            </option>
                                                            <option <?= $val->order_status == 7 ? "selected" : "" ?>
                                                                    value="7">
                                                                Delivered
                                                            </option>
                                                            <option <?= $val->order_status == 2 ? "selected" : "" ?>
                                                                    value="2">
                                                                Refund Request
                                                            </option>
                                                            <option <?= $val->order_status == 3 ? "selected" : "" ?>
                                                                    value="3">
                                                                Exchange Requested
                                                            </option>
                                                            <option <?= $val->order_status == 5 ? "selected" : "" ?>
                                                                    value="5">
                                                                Exchange Accepted
                                                            </option>
                                                            <option <?= $val->order_status == 9 ? "selected" : "" ?>
                                                                    value="9">
                                                                Exchange Rejected
                                                            </option>
                                                            <option <?= $val->order_status == 4 ? "selected" : "" ?>
                                                                    value="4">
                                                                Refund Accepted
                                                            </option>

                                                            <option <?= $val->order_status == 6 ? "selected" : "" ?>
                                                                    value="6">
                                                                Admin Cancel
                                                            </option>
                                                            <option <?= $val->order_status == 8 ? "selected" : "" ?>
                                                                    value="8">
                                                               Cancellation Requested
                                                            </option>
                                                        </select> <br>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><textarea><?=$ost?></textarea> </td>
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
                                                        User Comments: OID-00<?= $val->or_id ?> <?= $val->cancel_comments ?>
                                                    <?php } ?>
                                                <?php } ?>


                                            </td>

                                            <td><?php
                                                foreach ($allOrder as $val) {
                                                    ?>
                                                    <span> <i class="fa fa-inr"></i> <?= $val->act_price ?> </span> <br>
                                                    <?php
                                                }
                                                ?> </td>
                                            <td>
                                                <?php
                                                foreach ($allOrder as $val) {
                                                    $decrease = floatval($val->act_price) - floatval($val->pro_price/$val->pro_qty);
                                                    $percentage = $decrease / floatval($val->act_price) * 100;
                                                    ?>
                                                    <span> <?= number_format($percentage, 2, '.', '') ?>%</span> <br>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td> <?php
                                                foreach ($allOrder as $val) {
                                                    ?>
                                                    <span><i class="fa fa-inr"></i> <?= round($val->pro_price) ?> </span>
                                                    <br>
                                                    <?php
                                                }
                                                ?></td>
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

                                            <td><i class="fa fa-inr"></i> <?= $res->shipping ?></td>
                                            <td><i class="fa fa-inr"></i> <?= $res->gift_price ?> </td>
                                            <td><i class="fa fa-inr"></i> <?= $res->total_order_price ?></td>


                                            <td title="<?= $res->user_address ?>">
                                                <?= substr($res->user_address, 0, 10) ?></td>
                                            <td><?= $res->state ?></td>
                                            <td><?= $res->user_city ?></td>
                                            <td><?= $res->user_pin_code ?></td>
                                            <td><?= $res->pay_sta == 1 ? "Done" : "Failed" ?> </td>
                                            <td style="white-space: nowrap">
                                                   
                                                <a title="User Invoice" target="_blank" href="<?= base_url('Admin/Vendor/Invoice/') ?><?= encode($this->encryption->encrypt($res->id)) ?>/29" class="btn btn-success btn-xs"> <i class="fa fa-list"></i></a>
                                                  
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                                <?= $links ?>
                            </div>

                        </div>
                    </div>


                </div>


            </div>
        </div>


    </div>


</main>