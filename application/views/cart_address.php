<div class="order-check-set">

    <?php
    if (count($address) == 0) {
        ?>

        <div class="order-check-set-in order-addres">

            <div class="row">
                <div class="col-md-9">

                    <?= validation_errors(); ?>

                    <div class="order-left ">
                        <div class="outset ">
                            <div class="page-wrap">
                                <h1>ADD NEW ADDRESS</h1>
                                <form method="POST" action="<?= base_url("Checkout/Address") ?>">
                                    <div class="form-cov">
                                        <div class="mob-sap">
                                            <div class="styled-input">
                                                <input name="fname" id="fname" value="<?= set_value("fname") ?>"
                                                       type="text" required/>
                                                <label> Name</label>
                                            </div>
                                            <div class="styled-input">
                                                <input name="phone" id="phone" value="<?= set_value("phone") ?>"
                                                       type="tel" required/>
                                                <label>Mobile</label>
                                            </div>
                                        </div>
                                        <div class="mob-sap">
                                            <div class="styled-input2">
                                                <input name="pincode" id="pincode" value="<?= set_value("pincode") ?>"
                                                       type="pin" required/>
                                                <label>Pin Code</label>

                                            </div>
                                            <div class="styled-input2">
                                                <input name="state" id="state" value="<?= set_value("state") ?>"
                                                       type="text" required/>
                                                <label>State</label>

                                            </div>
                                            <div class="styled-input">
                                                <input name="address" value="<?= set_value("address") ?>" id="address"
                                                       type="text" required/>
                                                <label>Address (House No, Building, Street, Area) *</label>

                                            </div>
                                            <div class="styled-input">
                                                <input name="locality" value="<?= set_value("locality") ?>"
                                                       id="locality" type="text" required/>
                                                <label>Locality / Town *</label>

                                            </div>
                                            <div class="styled-input">
                                                <input name="city" id="city" value="<?= set_value("city") ?>"
                                                       type="text" required/>
                                                <label>City / District *</label>

                                            </div>
                                        </div>
                                        <div class="styled-input3">
                                            <h3>Type of Address *</h3>
                                            <div class="styled-input3-in">
                                                <label class="radio">Home
                                                    <input type="radio" value="home" checked="checked" id="address_type"
                                                           name="address_type">
                                                    <span class="checkround"></span>
                                                </label>
                                            </div>


                                            <div class="styled-input3-in">
                                                <label class="radio">Office/Commercial
                                                    <input id="address_type" value="office" type="radio"
                                                           name="address_type">
                                                    <span class="checkround"></span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="mob-sap">
                                            <div class="styled-input3">
                                                <h3>Type of Address *</h3>
                                                <label class="check ">Make this my default address
                                                    <input checked type="checkbox" value="1" id="default_add"
                                                           name="default_add">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="styled-input3">
                                        <button type="submit"> SAVE</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
                <?php
                $total = 0;
                $MRPtotal = 0;
                $tax = 0.0;
                foreach ($this->session->userdata("addToCart") as $key => $cartItem) {
                    $qtyvalue += ($cartItem["qty"]);
                    $productdetails = getProduct($cartItem["product"]);
                    $proImage = getProductImage($cartItem["product"]);
                    $userID = getUserIdByEmail();

                    $userDetail = $this->user->get_profile_id($userID);
                    
                    if ($userDetail->is_prime == 1) {
                        $getSubscription = load_subscription();
                        $primeDiscount = round(floatval($productdetails->dis_price) * floatval($getSubscription->subscription_cal) / 100); // prime member
                        $total += round((floatval($productdetails->dis_price) - floatval($primeDiscount)) * intval($cartItem["qty"]));
                    } else {
                        $total += round(floatval($productdetails->dis_price) * intval($cartItem["qty"]));
                    }
                    $MRPtotal += round(floatval($productdetails->act_price) * intval($cartItem["qty"]));
                    $tax = round(floatval($productdetails->dis_price) * intval($cartItem["qty"]) * floatval($productdetails->gst)) / 100;
                    $decrease = round(floatval($productdetails->act_price) - floatval($productdetails->dis_price));
                    $percentage = round($decrease / floatval($productdetails->act_price) * 100);
                }
                ?>
                <div class="col-md-3">
                    <div class="order-right">
                        <div class="first-coupen">
                            <h3>OPTIONS</h3>
                            <?php if ($this->session->userdata("coupon_Id") == NULL) { ?>
                                <h4>Coupons <a href="#" data-toggle="modal" data-target="#apply-coupon">APPLY</a></h4>
                            <?php } else { ?>
                                <h4>Coupons <a href="#" class="remove_coupon">Remove</a></h4>
                            <?php } ?>
                        </div>

                        <div class="price-detail">
                            <h2>Payment Details</h2>
                            <ul>
                                <li>
                                    <h3>Total MRP</h3>
                                    <span><i class="fa fa-inr" aria-hidden="true"></i> <?= round($MRPtotal) ?></span>
                                </li>
                                <li>
                                    <h3>Bag Discount</h3>
                                    <span style="color: #50c792;"><i class="fa fa-inr"
                                                                     aria-hidden="true"></i> <?= round($MRPtotal - $total) ?></span>
                                </li>


                                <?php if ($this->session->userdata("gift") != NULL) { ?>
                                    <li>
                                        <h3> Gift Wrap Charges </h3>
                                        <span><i class="fa fa-inr" aria-hidden="true"></i> 99</span>
                                    </li>
                                <?php } ?>
                                <li>
                                    <h3>Coupon Discount</h3>
                                    <?php if ($this->session->userdata('coupon_Id') == null) { ?>
                                        <a href="#" data-toggle="modal" data-target="#apply-coupon">Apply Coupon </a>
                                        <?php
                                    } else {

                                        $offer = getAllOffer($this->session->userdata('coupon_Id'));
                                        ?>
                                        <a href="#"
                                           onclick="return false;"><?= $offer[0]->offer_code . "(" . $offer[0]->offer_val . "" . ($offer[0]->offer_type == "0" ? '' : "%") . ") " ?></a>
                                    <?php } ?>

                                </li>
                                <li>
                                    <h3>Delivery</h3>
                                    <span>
                                        <?php
                                        $shippingVal = 0;
                                        // $shippingVal = ($qtyvalue >= 1 && $qtyvalue <= 10) ? 150 : (($qtyvalue >= 11 && $qtyvalue <= 25) ? 300 : ($qtyvalue > 25 ? 450 : 0));
                                        
                                        if ($shipping[0]->ship_min >= $total) {
                                            $shippingVal = floatval($shipping[0]->value);
                                        }
                                        echo "<i class='fa fa-inr'></i>" . $shippingVal;
                                        ?>
                                    </span>
                                </li>
                            </ul>

                        </div>

                        <div class="total-prc">
                            <h3>Total <span><i class="fa fa-inr" aria-hidden="true"></i>
                                    <?php
                                    $final_amt = 0.0;
                                    $grand = ($total + floatval($shippingVal));
                                    $final_amt = $grand;
                                            // echo "final-------".$final_amt;
                                            // die;
                                    if (isset($offer) && $offer != null) {
                                        $offer = $offer[0];
                                        $offerType = $offer->offer_type; // 1 % or 0 price  
                                        $which_price = $offer->which_price; // Grand Or Sub 0 : sub  1: grand
                                        // Subtotal and percentage
                                        if ($which_price == 0 && $offerType == 1) {
                                            $final_amt = $total - (floatval($total) * floatval($offer->offer_val) / 100);
                                        } elseif ($which_price == 1 && $offerType == 1) {
                                            $final_amt = floatval($grand) - (floatval($grand) * floatval($offer->offer_val) / 100);
                                        } elseif ($which_price == 0 && $offerType == 0) {
                                            $final_amt = (floatval($total) - floatval($offer->offer_val)) + floatval($shippingVal);
                                        } else {
                                            $final_amt = (floatval($grand) - floatval($offer->offer_val));
                                        }
                                    }

                                    if ($this->session->userdata("gift") != NULL) {
                                        $final_amt = $final_amt + 99;
                                    }

                                    echo number_format($final_amt);
                                    ?>
                                </span></h3>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    <?php } else { ?>


        <form method="POST" action="<?= base_url("Checkout/Payment") ?>" id="sform">
            <div class="order-check-set-in edit_address">

                <div class="add-new-mob">
                    <a data-toggle="modal" data-target="#add-address" href="#"> <i class="fa fa-plus"
                                                                                   aria-hidden="true"></i> ADD NEW
                        ADDRESS</a>
                </div>
                <div class="row">
                    <div class="col-md-9 col-xs-12 col-sm-12">

                        <div class="order-left edit-address">
                            <?php
                            if($this->input->get("validate")=='failed')
                            {
                            ?>
                            <li  style="background: red;color:#ffffff;text-align: center">Invalid captcha ! kindly enter the valid one</li>
                            <?php }?>
                            <h3 class="ad-hd">Select Delivery Address</h3>
                            <div class=" edit-address">
                                <div class="row">
                                    <?php
                                    $adressCount = count($address);
                                    foreach ($address as $key => $add) {
                                        ?>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="edit-address-in color-back">
                                                <div class="name-radio">
                                                    <label class="radio"><?= ucfirst(strtolower($add->fname)) ?> <?= $add->lname ?> <?= ($key == $adressCount - 1) ? "(Default)" : "" ?>
                                                        <input type="radio"
                                                               value="<?= encode($this->encryption->encrypt($add->id)) ?>"
                                                               checked="checked" name="is_company">
                                                        <span class="checkround"></span>
                                                    </label>
                                                </div>
                                                <div class="add-show">
                                                    <p><?= $add->address ?></p>
                                                    <p><?= $add->locality ?></p>
                                                    <p><?= $add->pin_code ?> </p>

                                                    <p><?= $add->city ?> </p>
                                                    <p>Mobile: <strong><?= $add->phone ?></strong></p>
                                                    <ul>
                                                        <!-- <li>
                                                            Try and Buy available
                                                        </li> -->
                                                        <!--<li>-->
                                                        <!--    Cash/Card on Delivery available-->
                                                        <!--</li>-->
                                                    </ul>
                                                </div>

                                                <?php
                                                // Add Remove and edit functionality in addToCart.js
                                                ?>
                                                <div class="remove-edit">
                                                    <button data-id="<?= encode($this->encryption->encrypt($add->id)) ?>">Remove
                                                    </button>
                                                    <button data-id="<?= encode($this->encryption->encrypt($add->id)) ?>">Edit
                                                    </button>
                                                </div>
                                                <div class="type-show">
                                                    <?= ucwords($add->type) ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="edit-address-in color-back2" data-toggle="modal"
                                             data-target="#add-address">
                                            <div class="add-block">
                                                <span>+</span>
                                                <h3>Add New Address</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $total = 0;
                    $MRPtotal = 0;
                    $tax = 0.0;
                    $qtyval = 0;
                    foreach ($this->session->userdata("addToCart") as $key => $cartItem) {
                            // echo "<pre>";
                            // print_r($cartItem);
                            // die; 

                            $qtyval += ($cartItem["qty"]);

                        $productdetails = getProduct($cartItem["product"]);
                        $proImage = getProductImage($cartItem["product"]);
                        // subscribed user 
                        $userID = getUserIdByEmail();
                        if (@count($userID) > 0) {
                            $userDetail = $this->user->get_profile_id($userID);
                            // echo "<pre>";
                            // print_r($userDetail);
                            // die;
                            if ($userDetail->is_prime == 1) {
                                $getSubscription = load_subscription();

                                $primeDiscount = round(floatval($productdetails->dis_price) * floatval($getSubscription->subscription_cal) / 100); // prime member
                                $total += round(floatval($productdetails->dis_price) - floatval($primeDiscount)) * intval($cartItem["qty"]);
                            } else {
                                $total += round(floatval($productdetails->dis_price) * intval($cartItem["qty"])); // normal user
                            }
                        } else {
                            $total += round(floatval($productdetails->dis_price) * intval($cartItem["qty"]));
                        }

                        // $total += floatval($productdetails->dis_price) * intval($cartItem["qty"]);


                        $MRPtotal += round(floatval($productdetails->act_price) * intval($cartItem["qty"]));
                        $tax = round(floatval($productdetails->dis_price) * intval($cartItem["qty"]) * floatval($productdetails->gst)) / 100;
                        if ($userDetail->is_prime == 1) {
                            $decrease = round(floatval($productdetails->act_price) - (floatval($productdetails->dis_price) - floatval($primeDiscount)));
                        } else {
                            $decrease = round(floatval($productdetails->act_price) - floatval($productdetails->dis_price));
                        }
                        // $decrease = floatval($productdetails->act_price) - floatval($productdetails->dis_price);
                        $percentage = round($decrease / floatval($productdetails->act_price) * 100);
                    }
                    ?>
                    <div class="col-md-3 col-xs-12">

                        <div class="order-right">


                            <div class="price-detail">
                                <h2>Payment Details </h2>
                                <ul>
                                    <li>
                                        <h3>Total MRP</h3>
                                        <span><i class="fa fa-inr"
                                                 aria-hidden="true"></i> <?= number_format($MRPtotal) ?></span>
                                    </li>
                                    <li>
                                        <h3>Bag Discount </h3>
                                        <span style="color: #50c792;"><i class="fa fa-inr"
                                                                         aria-hidden="true"></i> <?= number_format($MRPtotal - $total) ?></span>
                                    </li>

                                    <?php
                                    $gift=0;
                                    if ($this->session->userdata("gift") != NULL) {
                                        $gift=99;
                                        ?>
                                        <li>
                                            <h3> Gift Wrap Charges </h3>
                                            <span><i class="fa fa-inr" aria-hidden="true"></i> 99</span>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <h3>Coupon Discount</h3>
                                        <?php if ($this->session->userdata('coupon_Id') == null) { ?>
                                            <a href="" data-toggle="modal" data-target="#apply-coupon">Apply Coupon </a>
                                            <?php
                                        } else {
                                            $offer = getAllOffer($this->session->userdata('coupon_Id'));
                                            ?>
                                            <a href="#"><?= $offer[0]->offer_code . "(" . $offer[0]->offer_val . "" . ($offer[0]->offer_type == "0" ? '' : "%") . ") " ?></a>
                                        <?php } ?>
                                        <?php
                                        $getWallet = getWallet();
                                        $shippingVal = 0;
                                        // $shippingVal = ($qtyval >= 1 && $qtyval <= 10) ? 150 : (($qtyval >= 11 && $qtyval <= 25) ? 300 : ($qtyval > 25 ? 450 : 0));
                                        if ($shipping[0]->ship_min >= $total) {
                                            $shippingVal = floatval($shipping[0]->value);
                                        }
                                        $userDetail = $this->user->get_profile_id($userID);

                                        // if ($userDetail->is_prime == 1) {
                                        //     $shippingVal = 0;
                                        // }

                                        $offerPrice = 0.0;
                                        $final_amt = 0.0;
                                        $grand = ($total + floatval($shippingVal));
                                        $final_amt = $grand;
                                        // if (isset($offer) && $offer != null) {
                                        //     $offer = $offer[0];

                                        //     $offerType = $offer->offer_type; // 1 % or 0 price  
                                        //     $which_price = $offer->which_price; // Grand Or Sub 0 : sub  1: grand
                                        //     // Subtotal and percentage
                                        //     if ($which_price == 0 && $offerType == 1) {
                                        //         $final_amt = $total - (floatval($total) * floatval($offer->offer_val) / 100) + floatval($shippingVal);
                                        //         $offerPrice = (floatval($total) * floatval($offer->offer_val) / 100);
                                        //     } elseif ($which_price == 1 && $offerType == 1) {
                                        //         $final_amt = floatval($grand) - (floatval($grand) * floatval($offer->offer_val) / 100) + floatval($shippingVal);
                                        //         $offerPrice = (floatval($grand) * floatval($offer->offer_val) / 100);
                                        //     } elseif ($which_price == 0 && $offerType == 0) {
                                        //         $offerPrice = floatval($offer->offer_val);
                                        //         $final_amt = (floatval($total) - floatval($offer->offer_val)) + floatval($shippingVal);
                                        //     } else {
                                        //         $offerPrice = floatval($offer->offer_val);
                                        //         $final_amt = (floatval($grand) - floatval($offer->offer_val)) + floatval($shippingVal);
                                        //     }
                                        // }

                                        if($this->session->userdata("coupon_Id")!=null && $this->session->userdata("coupon_code")!=null){
                                            $final_amt = (floatval($grand) - floatval($this->session->userdata("coupon_price")));
                                        }
                                        if ($this->session->userdata("gift") != NULL) {
                                            $final_amt = $final_amt + 99;
                                        }
                                        ?>

                                    </li>
                                    <li>
                                        <h3>Coupon Price</h3>
                                        <a href="#"> - <i class='fa fa-inr'></i> <?= floatval($this->session->userdata("coupon_price")) ?></a></li>

                                    <li>
                                        <?php
                                        if (floatval($getWallet) > 0) {
                                            ?>
                                            <div class="custom-control custom-checkbox">

                                                <input type="checkbox" name="pay_method_wallet" id="wallet_checkbox"
                                                       class="custom-control-input" checked id="pay_method_wallet"
                                                       value="wallet">
                                                <span class="-check-square"></span>
                                                <label class="custom-control-label" for="wallet_checkbox"> Wallet(<i
                                                            class='fa fa-inr'></i> <?= $getWallet ?>) </label>
                                            </div>
                                        <?php }?>

                                        <div class="payment-mth">
                                            <h3>Payment Method</h3>
                                            
                                            <label class="radio pull-left">
                                                <input type="radio" name="pay_method" checked onclick="selectCOD(this)"  checked id="pay_method"
                                                       value="online">
                                                <span class="checkround"></span>
                                                Online
                                            </label>
                                           

                                          <!--   <label style="margin-left: 3%;" class="radio pull-left">
                                                <input type="radio" name="pay_method" onclick="selectCOD(this)" id="pay_method"
                                                       value="paytm">
                                                <span class="checkround"></span>
                                                Paytm
                                            </label> -->
                                            <!-- <label class="radio pull-right">
                                                <input type="radio"  name="pay_method" onclick="selectCOD(this)" id="pay_method" value="cod">
                                                <span class="checkround"></span>
                                               COD
                                            </label> -->
                                           <?php if($userDetail->pick_from_shop == 1){?>
                                            <!-- <label class="radio pull-right">
                                                <input type="radio" name="pay_method" onclick="selectCOD(this)" id="pay_method" value="cod">
                                                <span class="checkround"></span>
                                                Pick from Shop
                                            </label> -->
                                           
                                           <?php } ?>
                                            <!-- <label class="radio pull-left">
                                                <input type="radio" name="pay_method" onclick="selectCOD(this)"  id="pay_method"
                                                       value="bag">
                                                <span class="checkround"></span>
                                                COD
                                            </label> -->
                                        </div>

                                    </li>
                                    <li id="delivery-price" data-ship='<?=$shippingVal?>'>
                                        <h3>Delivery</h3>
                                        <span>
                                            <?php
                                            echo "<i class='fa fa-inr'></i>" . $shippingVal;
                                            ?>
                                        </span>
                                    </li>
                                     

                                    <?php
                                    if (floatval($getWallet) >= floatval($final_amt)) {
                                        $getWallet = $final_amt;
                                    }
                                    if (floatval($getWallet) > 0) {

                                        ?>
                                        <li data-wallet="<?= $getWallet ?>" data-total="<?= $final_amt ?>" id="wallet">
                                            <h3>Wallet Amount</h3>
                                            <span>
                                            <?php
                                            echo "- <i class='fa fa-inr'></i>" . $getWallet;
                                            ?>
                                        </span>
                                        </li>
                                    <?php }else{
                                        ?>
                                        <li data-wallet="<?= $getWallet ?>" data-total="<?= $final_amt ?>" id="wallet">
                                        </li>
                                    <?php
                                    } ?>
                                </ul>

                            </div>
                            <div class="captcha-set">

                                <input class="form-control" required placeholder="Fill Given Text" type="text"
                                       name="captcha">
                                <div id="image_captcha">
                                    <?= $captcha ?>
                                </div>

                                <i class="fa fa-refresh captcha-refresh"></i>

                            </div>

                            <div class="total-prc">
                                <h3>Total <span><i class="fa fa-inr" aria-hidden="true"></i>
                                        <?= number_format($final_amt - floatval($getWallet)); ?>
                                    </span></h3>
                            </div>
                            <div class="final-ord">
                                <button>PLACE ORDER</button>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </form>
    <?php } ?>
    <!--   -----     ADDRESS edit  section End  -----    -->


</div>
<?php
$featured = getFeaturedProducts();
if (count($featured) > 0) {
    ?>
    <section class="wish-page">
        <div class="container">
            <div class="wish-page-in">
                <div class="wish-head">
                    <h3>You may also like: </h3>
                </div>

                <div class="wish-show">

                    <div class="row">
                        <?php

                        foreach ($featured as $feature) {
                            $pro_name = cleanUrl($feature->pro_name);
                            ?>
                            <div class="col-md-3 col-xs-6 col-sm-6">
                                <div class="wish-block">

                                    <div class="img-set">
                                        <img onclick="window.location.href = '<?= base_url("Dashboard/pd_/$pro_name/" . encode($this->encryption->encrypt($feature->ID))); ?>'"
                                             class="lazy"
                                             data-src="<?= base_url('uploads/resized/') ?>resized_<?= load_images($feature->ID) ?>"
                                             alt=""/>
                                    </div>
                                    <div class="show-pro-name">
                                        <h4><?= $feature->pro_name ?></h4>
                                        <?php
                                        $decrease = floatval($feature->act_price) - floatval($feature->dis_price);
                                        $percentage = $decrease / floatval($feature->act_price) * 100;
                                        ?>
                                        <div class="detail-price">
                                            <span class="rs">Rs. <?= $feature->dis_price ?></span>
                                            <span class="cut">Rs. <?= $feature->act_price ?></span>
                                            <span class="show-off">(<?= round($percentage) ?>% off)</span>
                                        </div>
                                        <div class="move-bag">
                                            <a href="<?= base_url("Dashboard/pd_/$pro_name/" . encode($this->encryption->encrypt($feature->ID))); ?>">MOVE
                                                TO BAG</a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                    </div>
                </div>

            </div>


        </div>

    </section>
<?php } ?>

<!-- Modal -->
<div id="add-address" class="modal fade address-model" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ADD NEW ADDRESS</h4>
            </div>

            <form method="POST" action="<?= base_url("Checkout/Address") ?>">
                <div class="modal-body">
                    <div class="page-wrap">


                        <div class="styled-input">
                            <input name="fname" id="fname" value="<?= ($address != NULL) ? $address[0]->fname : '' ?>"
                                   type="text" required/>
                            <label> Name</label>
                        </div>


                        <div class="styled-input">
                            <input name="phone" id="phone" value="<?= ($address != NULL) ? $address[0]->phone : '' ?>"
                                   type="tel" required/>
                            <label>Mobile</label>
                        </div>
                        <div class="styled-input2">
                            <input name="pincode" id="pincode"
                                   value="<?= ($address != NULL) ? $address[0]->pin_code : '' ?>" type="pin" required/>
                            <label>Pin Code</label>

                        </div>
                        <div class="styled-input2">
                            <input name="state" id="state" value="<?= ($address != NULL) ? $address[0]->state : '' ?>"
                                   type="text" required/>
                            <label>State</label>

                        </div>
                        <div class="styled-input">
                            <input name="address" value="<?= ($address != NULL) ? $address[0]->address : '' ?>"
                                   id="address" type="text" required/>
                            <label>Address (House No, Building, Street, Area) *</label>

                        </div>
                        <div class="styled-input">
                            <input name="locality" value="<?= ($address != NULL) ? $address[0]->locality : '' ?>"
                                   id="locality" type="text" required/>
                            <label>Locality / Town *</label>

                        </div>
                        <div class="styled-input">
                            <input name="city" id="city" value="<?= ($address != NULL) ? $address[0]->city : '' ?>"
                                   type="text" required/>
                            <label>City / District *</label>

                        </div>
                        <div class="styled-input3">
                            <h3>Type of Address *</h3>
                            <div class="styled-input3-in">
                                <label class="radio">Home
                                    <input type="radio" value="home" checked="checked" id="address_type"
                                           name="address_type">
                                    <span class="checkround"></span>
                                </label>
                            </div>


                            <div class="styled-input3-in">
                                <label class="radio">Office/Commercial
                                    <input id="address_type" value="office" type="radio" name="address_type">
                                    <span class="checkround"></span>
                                </label>

                            </div>
                        </div>
                        <!-- <div class="styled-input3">
                            <h3>Is your office open on weekend?</h3>
                            <label class="check ">Open on Satuarday
                                <input checked type="checkbox" value="1" id="default_add" name="default_add">
                                <span class="checkmark"></span>
                            </label>
                            <label class="check ">Open on Sunday
                                <input checked type="checkbox" value="1" id="default_add" name="default_add">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="styled-input3">

                            <label class="check ">Make this my default address
                                <input checked type="checkbox" value="1" id="default_add" name="default_add">
                                <span class="checkmark"></span>
                            </label>
                        </div> -->


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel-tb" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="save-tb">SAVE</button>
                </div>
            </form>
        </div>

    </div>

</div>


<div id="apply-coupon" class="modal fade apply-code" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">APPLY COUPON</h4>
            </div>
            <div class="modal-body">
                <div class="apply-set">
                    <input type="text" placeholder="Enter Coupon Code">
                    <span>APPLY</span>
                </div>
                <div class="bindCoupon">

                </div>
                <!-- <div class="best-coupon">

                    <h3>BEST COUPON FOR YOU</h3>
                    <a href="#">
                        <span class="code-check">MYNTRA-00</span>
                        <span class="apply-check">Apply Code</span>
                    </a>

                    <div class="save-upto">
                        <h4>Save <i class="fa fa-inr" aria-hidden="true"></i>315</h4>
                        <p> Rs. 500 off on minimum purchase of Rs. 1499.0 . Expires on <strong>31st December 2019</strong></p>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">

                <button type="button" class="cancel-tb" data-dismiss="modal">Cancel</button>

            </div>
        </div>

    </div>
</div>

<div id="qty-set" class="modal fade change-qty" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Quantity</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">

                <button type="button" class="cancel-tb" data-dismiss="modal">Cancel</button>

            </div>
        </div>

    </div>
</div>
<div id="size-set" class="modal fade change-qty" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Size </h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">

                <button type="button" class="cancel-tb" data-dismiss="modal">Cancel</button>

            </div>
        </div>

    </div>
</div>

<div id="rmv-bag" class="modal fade remove-bag" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <img src="<?= base_url() ?>bootstrap/images/reg-girl.jpg" alt=""/>
                    </div>
                    <div class="col-md-9">
                        <h3>Remove item</h3>
                        <p>Are you sure you want to remove this item?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="move-btn " data-dismiss="modal">Move to wishlist</button>
                <button type="button" class="rmove-btn" data-dismiss="modal">Remove</button>
            </div>
        </div>

    </div>
</div>