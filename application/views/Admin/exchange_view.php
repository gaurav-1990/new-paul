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
                            <a href="#"> Users</a>
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

                            <div class="table-responsive">

                                <table id='example' class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Id</th>
                                        <th>Invoice Id</th>
                                        <th>Order Date & Time</th>
                                        <th>Order Status</th>

                                        <th>Size Required</th>
                                        <th>Size ordered</th>

                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Payment Mode</th>

                                        <th>Customer Name</th>
                                        <th>Product code</th>
                                        <th>Product qty</th>

                                        <th>Dis</th>
                                        <th>Selling Price</th>

                                        <th>Shipping Address</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Pin code</th>
                                        <th>Payment Status</th>


                                        <th>Image</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                    $count = 1;
                                    foreach ($exordR as $orderSS) {

                                        //    echo "<pre>";
                                        //    print_r($orderSS);
                                        //    echo "</pre>";

                                        if ($exordR != '') {
                                            $speceficOrder = getOrder($orderSS->OID);

                                            if ($speceficOrder->order_status == 0) {
                                                $ost = "PENDING";
                                            } else if ($speceficOrder->order_status == 1) {
                                                $ost = "DISPATCHED";
                                            } else if ($speceficOrder->order_status == 2) {
                                                $ost = "REFUND";
                                            } else if ($speceficOrder->order_status == 3) {
                                                $ost = "EXCHANGE REQUESTED";
                                            } else if ($speceficOrder->order_status == 4) {
                                                $ost = "REFUND ACCEPTED";
                                            } else if ($speceficOrder->order_status == 5) {
                                                $ost = "EXCHANGE ACCEPTED";
                                            } else if ($speceficOrder->order_status == 6) {
                                                $ost = "ADMIN CANCEL";
                                            } else if ($speceficOrder->order_status == 7) {
                                                $ost = "DELIVERED";
                                            } else if ($speceficOrder->order_status == 8) {
                                                $ost = "CANCELLATION REQUESTED";
                                            }else if ($speceficOrder->order_status == 9) {
                                                $ost = "EXCHANGE CANCELLED <br> Reason : ".getExchangeCancelled($orderSS->OID)->reject_cause;
                                            }


                                            if ($speceficOrder->pay_method == 0) {
                                                $pay_method = "COD";
                                            } else if ($speceficOrder->pay_method == 1) {
                                                $pay_method = "Online";
                                            } else if ($speceficOrder->pay_method == 2) {
                                                $pay_method = "Wallet";
                                            } else if ($speceficOrder->pay_method == 3) {
                                                $pay_method = "Wallet + online";
                                            }
                                            else if ($speceficOrder->pay_method == 4) {
                                                $pay_method = "Wallet + COD";
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= "10000" . $orderSS->OID ?></td>
                                                <td><?= $orderSS->invoice_id ?></td>
                                                <td><?= date('d-m-Y h:i:sa', strtotime($orderSS->date)) ?></td>
                                                <td><?= $ost ?></td>

                                                <td><?= $orderSS->exchange_cause ?></td>
                                                <td><?= $speceficOrder->order_attr ?></td>
                                                <td><?= $orderSS->user_email ?></td>

                                                <td><?= $orderSS->user_contact ?></td>
                                                <td><?= $pay_method ?></td>

                                                <td><?= $orderSS->first_name . " " . $orderSS->last_name ?></td>
                                                <td><?= $speceficOrder->sku ?></td>
                                                <td><?= $speceficOrder->pro_qty ?></td>


                                                <td><?= $speceficOrder->act_price ?></td>
                                                <td><?= $speceficOrder->dis_price ?></td>


                                                <td title="<?= $orderSS->user_address ?>"><?= substr($orderSS->user_address, 0, 10) ?></td>
                                                <td><?= $orderSS->state ?></td>
                                                <td><?= $orderSS->user_city ?></td>
                                                <td><?= $orderSS->user_pin_code ?></td>
                                                <td><?= $orderSS->pay_sta == 1 ? "Done" : "Failed" ?> </td>

                                                <td>
                                                    <img src=<?= base_url('return_image/' . $orderSS->images); ?> width='60px'
                                                         height='60px'></td>



                                            </tr>
                                            <?php
                                            $count++;
                                        } else { ?>

                                        <?php }
                                    } ?>

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