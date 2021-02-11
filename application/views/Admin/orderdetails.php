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
                            <a href="#"> Block</a>
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
                            <h3>Details:</h3>
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>SKU</th>
                                            <th>User Name</th>
                                            <th>Address</th>
                                            <th>Contact No.</th>
                                            <th>Total Order Price</th>
                                            <th>Refund In</th>
                                            <th>Order Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userOrderModule">
                                        <?php
 
                                        foreach ($details as $val) {
                                            $rfd = "";

                                            if ($val->order_sta == 0) {
                                                $ost = "PENDING";
                                            } else if ($val->order_sta == 1) {
                                                $ost = "DISPATCHED";
                                            } else if ($val->order_sta == 2) {
                                                $ost = "REFUND";
                                            } else if ($val->order_sta == 3) {
                                                $ost = "EXCHANGE";
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
                                            <tr>
                                                <td><?= $val->pro_name ?></td>
                                                <td><?= $val->sku ?></td>
                                                <td><?= $val->first_name ?></td>
                                                <td><?= $val->user_address ?></td>
                                                <td><?= $val->user_contact ?></td>
                                                <td><?= $val->total_order_price ?></td>
                                                <td><?= $rfd ?></td>
                                                <td>
                                                    <?php
                                                        if ($val->pay_sta == 1) {
                                                            ?>
                                                        <select data-or="<?= $val->or_id ?>" name="delivery_option" id="delivery_option">
                                                            <option <?= $val->order_status == 0 ? "selected" : "" ?> value="0">Pending</option>
                                                            <option <?= $val->order_status == 1 ? "selected" : "" ?> value="1">Dispatch</option>
                                                            <option <?= $val->order_status == 2 ? "selected" : "" ?> value="2">Refund Request</option>
                                                            <option <?= $val->order_status == 3 ? "selected" : "" ?> value="3">Exchange</option>
                                                            <option <?= $val->order_status == 4 ? "selected" : "" ?> value="4">Refund Accepted</option>
                                                            <option <?= $val->order_status == 5 ? "selected" : "" ?> value="5">Exchange Accepted</option>
                                                        </select>
                                                    <?php } ?>
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
        </div>

        <div id="setMe"></div>

    </div>


</main>