<div class="profile-container">
    <div class="container">
        <div class="profile-container-in">
            <div class="header-user">
                <div class="hd-name">
                    Order Details
                </div>
                <span> </span>
            </div>
            <div class="user-used">

                <div class="left-set">
                    <ul>
                        <li>
                            <a href="<?=base_url('Myaccount/dashboard')?>">
                                Overview
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Order</div>
                        <li>
                            <a href="<?=base_url('Myaccount/orderDetails')?>" class="active">
                                Orders
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Credits</div>
                        <li>
                            <a href="<?=base_url('Checkout/myCoupon')?>">
                                Coupons
                            </a>
                            <a href="<?=base_url("Checkout/myWallet")?>">
                                Paulsons Wallet
                            </a>

                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Account</div>
                        <li>
                            <a href="<?=base_url("Myaccount/editProfile");?>">
                                Profile
                            </a>
                            <a href="<?=base_url('Checkout/myAddress')?>">
                                Address
                            </a>


                        </li>
                    </ul>
                </div>


                <?php if ($order != null) {?>


                    <div class="right-set">
                        <div class="delivery-set">
                    <div class="row">


                </div>
                        <?=$this->session->flashdata('msg');?>
                        <?php
foreach ($order as $orderS) {

    ?>
                            <div class="order-return">
                                <div class="return-head">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6">
                                            <div class="order-id">

                                                <b> ORDER NO </b> : 10000<?=$orderS->id?>

                                                <?php
$offers = getOffer($orderS->offer_id);
    if (isset($offers[0])) {
        $offerVal = $offers[0]->offer_val;
        echo "<br>";
        echo "<b>Offer Applied :</b> " . $offers[0]->offer_code . " (" . $offers[0]->offer_val . ($offers[0]->offer_type == "0" ? " Rs" : " %") . ") On " . ($offers[0]->offer_on == 0 ? " subtotal" : "grandtotal");
    }
    ?>
                                                <?=($orderS->is_gifted == 1) ? '<div style="font-size: 12px; color: #14cda8;"> Gift wrap applied  <i class="fa fa-inr" aria-hidden="true"></i> 99 </div>' : ''?>
                                                <?=($orderS->shipping != 0) ? '<div style="font-size: 10px; color: #14cda8;"> Delivery Charge applied  <i class="fa fa-inr" aria-hidden="true"></i> ' . $orderS->shipping . ' </div>' : ''?>

                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <a href='<?=base_url("Myaccount/viewSpecificOrder/" . encode($this->encryption->encrypt($orderS->id)));?>'
                                               class="detail-return">Order detail </a>
                                        </div>
                                    </div>

                                </div>

                                <ul>
                                    <?php
$orders = getOrderDetails($orderS->id);
    foreach ($orders as $oDetails) {
        // echo "<pre>";
        // print_r($oDetails);

        ?>
                                        <?php// echo ($oDetails->order_status == 2) ? '<div style="font-size: 18px; color: red;">Return Request Send successfully ! </div>' : ''?>
                                        <?php// echo ($oDetails->order_status == 3) ? '<div style="font-size: 18px; color: red;">Exchange Request Send successfully ! </div>' : ''?>
                                        <?=($oDetails->order_status == 4) ? '<div style="font-size: 18px; color: #14cda8;">Return Request Accepted credit will updated soon .</div>' : ''?>
                                        <?=($oDetails->order_status == 5) ? '<div style="font-size: 18px; color: #14cda8;">Exchange Accepted.</div>' : ''?>


                                        <li style="<?=($oDetails->order_status == 2 || $oDetails->order_status == 4 || $oDetails->order_status == 3 || $oDetails->order_status == 5 || $oDetails->order_status == 6) ? '' : ' '?>"> <!--opacity: 0.2-->
                                            <div class="row">
                                                <div class="col-md-2 col-xs-3 col-sm-3">
                                                    <div class="img-set">
                                                        <img src="<?=base_url("uploads/resized/resized_")?><?=load_images($oDetails->pro_id)?>"
                                                             title="<?=$oDetails->pro_name?>" alt="<?=$oDetails->pro_name?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-10 col-xs-9 col-sm-9">
                                                    <div class="product-detail">
                                                        <?php
if ($orderS->order_sta == 8) {
            ?>
                                                            <b data-toggle="tooltip" data-placement="right"
                                                               title="<?=$orderS->cancel_comments?>"
                                                               class='text-danger'>Cancellation Requested (<?=date("d,M Y", strtotime($orderS->cancel_request_date))?>) </b>
                                                            <?php
}
        if ($orderS->order_sta == 6) {
            ?>
                                                            <b data-toggle="tooltip" data-placement="right"
                                                               title="<?=$orderS->cancel_comments?>"
                                                               class='text-danger'>Cancellation Accepted (<?=date("d,M Y", strtotime($orderS->admin_cancel_date))?>) </b>
                                                            <?php
} if (($orderS->order_sta == 7) && ($oDetails->order_status == 9)) {
    
        ?>
<b data-toggle="tooltip" data-placement="right" class='text-danger'>Return Requested</b>
<?php }  if (($orderS->order_sta == 7) && ($oDetails->order_status == 10)) { 
    
    ?>
    <b data-toggle="tooltip" data-placement="right" class='text-danger'>Exchange Requested</b>
<?php } if (($orderS->order_sta == 7) && ($oDetails->order_status == 11)) {    // $orderS->order_sta == 12 ?>
    <b data-toggle="tooltip" data-placement="right" class='text-success'>Return Accepted</b>
<?php } if (($orderS->order_sta == 7) && ($oDetails->order_status == 12)) {    // $orderS->order_sta == 11 ?>
    <b data-toggle="tooltip" data-placement="right" class='text-success'>Exchange Accepted</b>
<?php } ?>

                                                        <div class="pro-name"><?=$oDetails->pro_name?>
                                                            (SKU:<?=($oDetails->sku)?>)
                                                        </div>

                                                        <span class="pro-size"><?=ucfirst($oDetails->order_prop)?>:
                                                            <?=$oDetails->order_attr?> | </span>
                                                        <span class="pro-qty"> Qty: <?=$oDetails->pro_qty?></span>
                                                        <div>

                                                            <span class="pro-price"><i class="fa fa-inr"
                                                                                       aria-hidden="true"></i>
                                                                <?=round($oDetails->pro_price)?></span>
                                                            <span class="pro-price-cut"><?=($oDetails->pro_price == round(floatval(($oDetails->act_price * floatval($oDetails->pro_qty))))) ? "" : '<i class="fa fa-inr" aria-hidden="true"></i>' . round(floatval(($oDetails->act_price * floatval($oDetails->pro_qty))))?></span>
                                                            <span class="pro-price-save"><?=(round(floatval($oDetails->act_price * floatval($oDetails->pro_qty)) - floatval($oDetails->pro_price)) == 0) ? "" : 'Saved <i class="fa fa-inr" aria-hidden="true"></i>' . round(floatval($oDetails->act_price * floatval($oDetails->pro_qty)) - floatval($oDetails->pro_price))?></span>

                                                        </div>

                                                        <span class="pro-delivered">
                                                            <?php
                                                            if ($oDetails->deliver == 0) {
                                                                        ?>
                                                                <!-- <b>Delivery expected</b> -->

                                                                
                                                                    <!-- <?=($oDetails->delivery_date == '' || $oDetails->order_status != 7) ? date("d M D,Y", strtotime($oDetails->pay_date . "+5 days")) : date("d M D,Y", strtotime($oDetails->delivery_date));?> -->
                                                                    
                                                            <?php } else if ($oDetails->deliver == 1) {
                                                                ?>
                                                                <b> Dispatched</b>

                                                            <?php } elseif ($oDetails->deliver == 2) {
            ?>
                                                                <b> Delivered</b>
                                                            <?php } elseif ($orderS->order_sta == 8) {
            ?>
                                                                <b> Cancellation Requested</b>
                                                            <?php } elseif ($oDetails->deliver == 4) {?>
                                                                <b> Re dispatched</b>
                                                            <?php } elseif ($orderS->order_sta == 6) {?>
                                                                <b> Cancel Request Accepted </b>
                                                            <?php }?>
                                                        </span>

                                                        <div class="pro-arrow">
                                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </li>

                                        <div class="process-btn">
                                        <?php
$exchange = getexchangeproduct($oDetails->or_id);
        $getdata = getreturnproduct($oDetails->or_id);

        if ($oDetails->order_status == 7 || $oDetails->order_status == 5) {
            $deliveryDate = strtotime($oDetails->delivery_date);
            $todayDate = strtotime(date("Y-m-d"));
            $diff = $todayDate - $deliveryDate;
            $exchange_limit = abs(round($diff / 86400));
            // echo $deliveryDate."---".$todayDate."---".$diff."----".$exchange_limit;
            
            if (intval($exchange_limit) <= 7) {
                if ($oDetails->order_status != 5 && $oDetails->order_status != 6) {
                    if ($getdata == null && $exchange == null) {
                        ?>
                                                        <!-- <button data-toggle="modal" data-target="#myModal25"
                                                                onclick="exchangeProducts(<?=$oDetails->or_id?>)">
                                                            Exchange
                                                        </button> -->
                                                        <?php
}
                }

            }
            if ($oDetails->order_status != 6) {
                $getdata = getreviewproduct($oDetails->or_id);
                if ($getdata == null) {
                    ?>
                <button data-toggle="modal" data-target="#myModal26"
                        onclick="reviewProducts(<?=$oDetails->or_id?>,<?= $oDetails->pro_id ?>)">
                    Review
                </button>
                <?php
                }
            }

            if (intval($exchange_limit) <= 2) {
                if ($oDetails->order_sta != 9 || $oDetails->order_sta != 10 && ($oDetails->order_status != 9)) {
                    ?>
                <button onclick="return_Product(<?=$oDetails->order_id?>,<?=$oDetails->or_id?>)">Return</button>
            <?php } if($oDetails->order_sta != 9 || $oDetails->order_sta != 10  && ($oDetails->order_status != 10)){?>
                <button onclick="exchange_Product(<?=$oDetails->order_id?>,<?=$oDetails->or_id?>)">Exchange</button>
                <?php
                    }
                }
                ?>

                                            </div>

                                            <?php
} else if ($oDetails->order_status == 0) {

            ?>

                                            <?php
}
    }
    ?>

                                </ul>

                            <?php if ($orderS->bag_delivery_date == '' && $oDetails->add_to_box == 1) {?>
                                <div class="bagChecked">
                                    <input type="checkbox" name="bagChecked[]" value="<?=$orderS->id?>">  Add to Bag delivery Request
                                </div>
                            <?php } elseif ($orderS->bag_delivery_date != '' && $oDetails->bag_ship_confirm == 0) {?>
                                <span class="right-del" style="color:red">
                                    <b> Add to Bag delivery Date already sent. </b>
                                </span>

                            <?php }?>

                            <?php if ($orderS->order_sta == 0 || $orderS->order_sta != 6 ||$orderS->order_sta != 8 ) {?>


                                            <?php if (($oDetails->bag_ship_confirm == 1 && $oDetails->add_to_box == 2)) {?>
                                            <span class="right-del" style="color:red">
                                            <b>New Delivered expacted date : <?=date("d M D,Y", strtotime($oDetails->bag_delivery_date . "+3 days"))?></b>
                                            </span>
                                            <?php }
                                            if($orderS->order_sta== 0){
                                                    ?>

                                            <button class="btn btn-success" data-key="<?=encode($this->encryption->encrypt($orderS->id))?>"

                                                    data-toggle="modal" onclick="cancelRequest(this)"
                                                    data-target="#myModal29">
                                                Cancel Request
                                            </button>
                                        <?php } else if($orderS->order_sta == 2){?>
                                            <span style="color:red">Cancellation can't be processed as Orders can only be cancelled till 24hrs after placing of order.</span>
                                        <?php } ?>
                                <div class="process">
                                    <span class="left-del">
                                        <b>Ordered </b> <br/>
                                        <?=date("d M D,Y", strtotime($oDetails->pay_date))?>
                                    </span>

                                    <ol>
                                        <li class="green">
                                            <span>Ordered</span>
                                            <i class="ic"></i>
                                        </li>
                                        <li class="<?=$oDetails->order_status == 7 || $oDetails->order_status == "1" || $oDetails->order_status == "2" || $oDetails->order_status == "9" || $oDetails->order_status == "10" || $oDetails->order_status == "11" || $oDetails->order_status == "12" || $orderS->order_status == 2 ? "green" : "off-black"?>">
                                            <span> Packed </span>
                                            <i class="ic"></i>
                                        </li>

                                        <li class="<?=$oDetails->order_status == "1" || $oDetails->order_status == "9" || $oDetails->order_status == "10" || $oDetails->order_status == "11" || $oDetails->order_status == "12" || $oDetails->order_status == 7 ? "green" : "off-black"?>">
                                            <span> Shipped</span>
                                            <i class="ic"></i>
                                        </li>
                                        <li class="<?=$oDetails->order_status == 7 || $oDetails->order_status == "9" || $oDetails->order_status == "10" || $oDetails->order_status == "11" || $oDetails->order_status == "12" ? "green" : "off-black"?>">
                                            <span>Delivered</span>
                                            <i class="ic"></i>
                                        </li>
                                    </ol>


                                    <!-- <span class="right-del">
                                        <b>Delivered</b> <br/>
                                        <?=($oDetails->delivery_date == '' || $oDetails->order_status != 7) ? date("d M D,Y", strtotime($oDetails->pay_date . "+3 days")) . "<br>" . "(Expected Date)" : date("d M D,Y", strtotime($oDetails->delivery_date));?>
                                    </span> -->

                                </div>
                                <?php }?>

                            </div>
                        <?php }?>

                    </div>
                <?php } else {?>
                    <section class="no-itam-cart">
                        <div class="container">
                            <div class="no-itam-cart-in">
                                <img src="<?=base_url();?>assets/images/empty-cart-img.png" class="cart-img">
                                <h3>Hey, it feels so light!</h3>
                                <p>There is nothing in your history. Let's order some items.</p>
                                <button onclick="window.location.href = '<?=base_url()?>'">ADD ITEMS IN HISTORY
                                </button>
                            </div>
                        </div>
                    </section>
                <?php }?>
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
<div class="view-similar modal fade" id="myModalPrime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h4 class="modal-title" id="myModalLabel23">SELL BACK THIS PRODUCT</h4>
            </div>
            <div class="modal-body my_return">

            </div>
        </div>
    </div>
</div>

<!------- exchange ------------->
<div class="view-similar modal fade" id="myModal25" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h4 class="modal-title" id="myModalLabel25">EXCHANGE THIS PRODUCT</h4>
            </div>
            <div class="modal-body my_return">

            </div>
        </div>
    </div>
</div>

<!-------Review ------------->
<div class="view-similar modal fade" id="myModal26" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h4 class="modal-title" id="myModalLabel26">REVIEW OF THIS PRODUCT</h4>
            </div>
            <div class="modal-body my_return">

            </div>
        </div>
    </div>
</div>

<div class="view-similar modal fade" id="myModal29" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
    <form id="cancelForm" method="POST" action="<?=base_url("Myaccount/cancelRequest")?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel26">CANCELLATION: ARE YOU SURE ? </h4>
                </div>
                <div class="modal-body my_cancel">

                </div>

            </div>
        </div>
    </form>
</div>


<div class="view-similar modal fade" id="myModal30" tabindex="-1" role="dialog" aria-labelledby="myModalLabel10">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                <h4 class="modal-title" id="myModalLabel26">RETURN</h4>
            </div>
            <div class="modal-body prod_return">
            <!-- Return window is open till 48 hrs after delivery of the order. 
            For more information, please refer to our return and exchange policy*. -->
            Return Request is sent, concerned person will contact you soon.
            </div>
        </div>
    </div>
</div>

<div class="view-similar modal fade" id="myModal31" tabindex="-1" role="dialog" aria-labelledby="myModalLabel10">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                <h4 class="modal-title" id="myModalLabel26">EXCHANGE</h4>
            </div>
            <div class="modal-body prod_exch">
            <!-- Exchange window is open till 48 hrs after delivery of the order. 
            For more information, please refer to our return and exchange policy*. -->
            Exchange Request is sent, concerned person will contact you soon.
            </div>
        </div>
    </div>
</div>