<div class="profile-container">
    <div class="container">
        <div class="profile-container-in">
            <div class="header-user">
                <div class="hd-name">
                    Order Detail
                </div>
                <span> </span>
            </div>
            <div class="user-used">

                <div class="left-set">
                    <ul>

                        <li>
                            <a href="#">
                                Overview
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Order</div>
                        <li>
                            <a href="<?= base_url('Myaccount/orderDetails') ?>" class="active">
                                Order & Returns
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Credits</div>
                        <li>
                            <a href="<?= base_url('Checkout/myCoupon') ?>">
                                Coupons
                            </a>
                            <!-- <a href="#">
                                PhonePe Wallet
                            </a> -->
                            <a href="<?= base_url('Checkout/myWallet') ?>">
                            paulsonsonline.com Credit
                            </a>
                            <!-- <a href="#">
                                paulsonsonline.com Points
                            </a> -->
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Account</div>
                        <li>
                            <a href="<?= base_url("Myaccount/editProfile"); ?>">
                                Profile
                            </a>
                            <a href="<?= base_url('Checkout/myAddress') ?>">
                                Address
                            </a>
                            <!-- <a href="#">
                                Saved Cards
                            </a> -->
                            <!-- <a href="#">
                                karzanddolls Insider
                            </a> -->
                            <?php
                            $res = getUserByEmail($this->session->userdata('myaccount'));

                            // $diff = abs(strtotime(date("Y-m-d")) - strtotime($res->prime_date));

                            $date1 = date_create(date("Y-m-d"));

                            $date2 = date_create($res->prime_date);

                            $diff = date_diff($date1, $date2);

                            //echo $diff->days;
                            // $years = floor($diff / (365*60*60*24));
                            // $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                            // $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                            //echo $days;
                            $rem_days = floatval(loadSubcription()->subscription_form) - $diff->days;
                            if ($rem_days == 0) {
                                $result = getUpdatePrime($this->session->userdata('myaccount'));
                            }
                            $res = getUserByEmail($this->session->userdata('myaccount'));
                            if ($res->is_prime == 1) {
                                ?>
                                <a href="#">
                                    Prime Subscription Remaining : <?= $rem_days ?> days
                                </a>
                            <?php } else { ?>
                                <a href="<?= base_url('Prime') ?>">
                                    Get Prime Membership
                                </a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>

                <div class="right-set">
                    <div class="order-return col-md-8 ">
                        <div class="return-head">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="order-id">
                                        <b> ORDER NO </b> : 10000<?= $order[0]->order_id ?>
                                        <?php
                                        // $offers = getOffer($order[0]->offer_id);
                                        if ($order[0]->offer_code !='') {
                                            echo "<br>";
                                            echo "<b>Offer Applied :</b> " . $order[0]->offer_code . ", Value - " . $order[0]->total_offer;
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>

                        </div>




                        <?php
                        $total = 0.0;
                        $qtyval = 0;
                        foreach ($order as $orderS) {
                            
                            $qtyval += ($orderS->pro_qty);
                            
                            $cancelOrder = getCancelOrder($orderS->or_id);

                            $total = floatval($total) + floatval($orderS->pro_price);
                            ?>
                            <ul>
                                <?php // echo ($orderS->order_status == 2) ? '<div style="font-size: 18px; color: red;">Return Request Send successfully ! </div>' : '' ?>
                                <?php // echo ($orderS->order_status == 4) ? '<div style="font-size: 18px; color: #14cda8;">Return Request Accepted credit will updated soon .</div>' : '' ?>
                                <?= ($cancelOrder != null && $cancelOrder->comment != '') ? '<div style="font-size: 18px; color: red;">Order is cancelled through the Admin credit will updated. <br> <p style="color : black"> Reason : ' . $cancelOrder->comment . ' </p></div>' : '' ?>

                                <li style="<?= ($orderS->order_status == 2 || $orderS->order_status == 4 || $orderS->order_status == 3 || $orderS->order_status == 5 || $orderS->order_status == 6) ? '' : '' ?>">  <!--opacity: 0.2-->
                                    <div class="row">
                                        <div class="col-md-2 col-xs-3 col-sm-3">
                                            <div class="img-set">
                                                <img src="<?= base_url("uploads/resized/resized_") ?><?= load_images($orderS->pro_id) ?>"
                                                     alt="ICON">
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-xs-9 col-sm-9">
                                            <div class="product-detail">

                                                <div class="pro-name"><?= $orderS->pro_name ?></div>

                                                <span class="pro-size"><?= ucfirst($orderS->order_prop) ?>:
                                                    <?= $orderS->order_attr ?> | </span>
                                                <span class="pro-qty">Qty: <?= $orderS->pro_qty ?></span>
                                                <div>
                                                    <span class="pro-price"><i class="fa fa-inr" aria-hidden="true"></i>
                                                        <?= round($orderS->pro_price) ?></span>
                                                    <span class="pro-price-cut"><?= ($orderS->pro_price == round(floatval(($orderS->act_price * floatval($orderS->pro_qty)))))?"":'<i class="fa fa-inr" aria-hidden="true"></i>'.round(floatval(($orderS->act_price * floatval($orderS->pro_qty)))) ?></span>
                                                    <span class="pro-price-save">
                                                        <?= (round((floatval($orderS->act_price) * floatval($orderS->pro_qty)) - floatval($orderS->pro_price)) == 0) ? "" : 'Saved <i class="fa fa-inr" aria-hidden="true"></i>'.round(floatval($orderS->act_price * floatval($orderS->pro_qty)) - floatval($orderS->pro_price)) ?></span>
                                                </div>

                                                <span class="pro-delivered">
                                                    <?php
                                                    if ($orderS->deliver == 0) {
                                                        ?>
                                                        <!-- <b>Delivery expected</b>
                                                        (<?= date("d M D,Y", strtotime($orderS->pay_date . "+3 days")) ?>) -->
                                                    <?php } else if ($orderS->deliver == 1) {
                                                        ?>
                                                        <b> Dispatched</b>

                                                    <?php } elseif ($orderS->deliver == 2) {
                                                        ?>
                                                        <b> Delivered</b>
                                                    <?php } elseif ($orderS->deliver == 3) {
                                                        ?>
                                                        <b> Cancellation Requested</b>
                                                    <?php } elseif ($orderS->deliver == 4) { ?>
                                                        <b> Re-disptached</b>
                                                    <?php } elseif ($orderS->deliver == 5) { ?>
                                                        <b> Cancelled</b>
                                                    <?php } ?>
                                                </span>
                                                <div class="pro-arrow">
                                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </li>



                            </ul>

                        <?php } ?>

                        <?php
                        $shippingVal = 0;
                        // $shippingVal = ($qtyval >= 1 && $qtyval <= 10) ? 150 : (($qtyval >= 11 && $qtyval <= 25) ? 300 : ($qtyval > 25 ? 450 : 0));
                        if ($shipping[0]->ship_min > $total) {
                            $shippingVal = floatval($shipping[0]->value);
                        }
                        
                        $grand = ($total + floatval($shippingVal));
                        if (isset($offers[0])) {
                            $grandTot = floatval($grand) - floatval($offers[0]->offer_val);
                        } else {
                            $grandTot = floatval($grand);
                        }
                        ?>

                        <span>
                            <?php
                            $shippingVal = 0;
                            // $shippingVal = ($qtyval >= 1 && $qtyval <= 10) ? 150 : (($qtyval >= 11 && $qtyval <= 25) ? 300 : ($qtyval > 25 ? 450 : 0));
                            if ($shipping[0]->ship_min > $total) {
                                $shippingVal = floatval($shipping[0]->value);
                                echo "Delivery Charge : <i class='fa fa-inr'></i>  " . $shippingVal;
                            }
                            ?>
                        </span>
                        
                        <?= ($orderS->is_gifted == 1) ? '<div style="font-size: 14px; color: #14cda8;"> Gift wrap applied  <i class="fa fa-inr" aria-hidden="true"></i>  99 </div>' : '' ?>


                        <div class="order-last-not">
                            <p>Total Amount :  <span class="pro-price"><i class="fa fa-inr" aria-hidden="true"></i>
                                    <?php //($orderS->is_gifted == 1)? round(floatval($grandTot) + floatval($orderS->gift_price)) : round($grandTot) ?>
                                    <?= round($orderS->total_order_price) ?>
                                </span></p>

                        </div> 
                    </div>
                    <div class="col-md-4">

                        <div class="order-last-detail">
                            <h3> Delivery Address </h3>
                            <span> Name : <?= $order[0]->first_name . " " . $order[0]->last_name ?> </span>
                            <span> Street : <?= $order[0]->user_address ?> </span>
                            <span> City : <?= $order[0]->user_city ?> </span>
                            <span> State : <?= $order[0]->state ?> </span>
                            <span> Pin : <?= $order[0]->user_pin_code ?></span>
                            <span> Mobile : <?= $order[0]->user_contact ?></span>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>
</div>

<div class="view-similar modal fade" id="myModal23" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h4 class="modal-title" id="myModalLabel23">RETURN THIS PRODUCT</h4>
            </div>
            <div class="modal-body my_return">

            </div>
        </div>
    </div>
</div>