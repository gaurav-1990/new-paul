<div class="order-check-set">
    <div class="container">
        <div class="order-check-set-in">
            <?php
            use Google\Auth\Subscriber\AuthTokenSubscriber;

            if ($this->session->userdata("addToCart") != null) {
            ?>
            <div class="col-md-9 col-xs-12 col-sm-12 ">
                <?php
                $qtyval = 0;

                foreach ($this->session->userdata("addToCart") as $qty) {
                $qtyval += ($qty["qty"]);
                
                }
                ?>
                <div class="load">
                    <img src="<?= base_url() ?>bootstrap/images/svg-icons/generator.svg" style="display: block"
                         class="header-icon1" alt="ICON">
                </div>
                <div class="order-left ">
<!--                    <div class="order-offer">-->
<!--                        <h3>Offer</h3>-->
<!--                        <ul class="show_More2">-->
<!--                            <li><span>10% Cashback on first ever transaction via FreeCharge. TCA</span></li>-->
<!--                        </ul>-->
<!--                        <ul class="show_More2" style="display:none">-->
<!--                            <li><span>10% Cashback on first ever transaction via FreeCharge. TCA</span></li>-->
<!--                            <li><span>10% Cashback on first ever transaction via FreeCharge. TCA</span></li>-->
<!--                            <li><span>10% Cashback on first ever transaction via FreeCharge. TCA</span></li>-->
<!--                        </ul>-->
<!--                        <a href="#" class="show_More">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>-->
<!--                    </div>-->
                   <!-- <div class="order-deliverd">
                        <img src="<?/*= base_url() */?>bootstrap/images/deliver.png">
                        <h3>Yay! Free Delivery on this order.</h3>
                    </div>-->
                    <?php
                        $user = $this->session->userdata('myaccount');
                    ?>
                    <div class="btn empty-cart" data-user="<?= $user ?>"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Empty the Cart</div>

                    <div class="item-head">
                        <h3> My Shopping Bag (<?= $qtyval ?> Item<?= ((int) $qtyval > 0 ? "s" : ""); ?>)</h3>
                        <span>Total : <i class="fa fa-inr" aria-hidden="true"></i> <span id="total"> --- </span> </span>
                    </div>
                    <?php
                    $total = 0;
                    $MRPtotal = 0;
                    $tax = 0.0;

                    foreach ($this->session->userdata("addToCart") as $key => $cartItem) {
                    if ($cartItem["product"] != '') {
                    $productdetails = getProduct($cartItem["product"]);
                    $proImage = getProductImage($cartItem["product"]);
                    // subscribed user 
                    $userID = getUserIdByEmail();
                    if (@count($userID) > 0) {
                    $userDetail = $this->user->get_profile_id($userID);

                    if ($userDetail->is_prime == 1) {
                    $getSubscription = load_subscription();
                    $primeDiscount = round(floatval($productdetails->dis_price) * floatval($getSubscription->subscription_cal) / 100); // prime member

                    $total += round((floatval($productdetails->dis_price) - floatval($primeDiscount)) * intval($cartItem["qty"]));
                    } else {
                    $total += round(floatval($productdetails->dis_price) * intval($cartItem["qty"]));
                    }
                    } else {
                    $total += round(floatval($productdetails->dis_price) * intval($cartItem["qty"]));
                    }




                    // $total += floatval($productdetails->dis_price) * intval($cartItem["qty"]);

                    $MRPtotal += floatval($productdetails->act_price) * intval($cartItem["qty"]);
                    if ($userDetail->is_prime == 1) {
                    $tax += ((floatval($productdetails->dis_price) - floatval($primeDiscount)) * intval($cartItem["qty"]) * floatval($productdetails->gst)) / 100;
                    } else {
                    $tax += (floatval($productdetails->dis_price) * intval($cartItem["qty"]) * floatval($productdetails->gst)) / 100;
                    }
                    ?>

                    <div class="item-check-show">
                        <div class="img-check">
                            <img data-src="<?= base_url('uploads/resized/') ?>resized_<?= $proImage ?>" class="lazy" alt="<?=$productdetails->pro_name?>" title="<?=$productdetails->pro_name?>">
                        </div>

                        <div data-key="<?= $key ?>" class="order-details">
                            <div class="detail-set">
                                <?php
                                $subcategory = cleanUrl($productdetails->sub_name);
                                $pro_name = cleanUrl($productdetails->pro_name);
                                $prod = encode($this->encryption->encrypt($cartItem['product']));
                                ?>
                                <!-- <a href="<?php // base_url("product/$subcategory/$pro_name/{$this->encrypt->encode($cartItem["product"])}") ?>" class="text-head">
                                    <?php // echo $productdetails->pro_name ?><br>
                                </a> -->
                                <!-- <a href="<?php // echo base_url(); ?>product/<?= $subcategory/$pro_name/$prod?>" class="text-head">
                                    <?php // echo $productdetails->pro_name ?><br>
                                </a> -->
                                <a href="<?= base_url()?>product/<?=$subcategory?>/<?=$pro_name?>/<?=$prod?>" class="text-head"> <?= $productdetails->pro_name ?><br></a>
                                <span><?= $productdetails->title ?></span>
                                <span>Sold by: Paulsons</span>
                                <a  data-pro="<?= encode($this->encryption->encrypt($cartItem["product"])) ?>" data-key="<?= $key ?>"
                                   data-prop="<?= $cartItem["prop"] ?>" data-attr="<?= $cartItem["attr"] ?>"
                                   href="javascript:void(0);" class="change-size"> <?= $cartItem["prop"] ?> :
                                    <?= $cartItem["attr"] ?> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <a data-pro="<?= encode($this->encryption->encrypt($cartItem["product"])) ?>" data-key="<?= $key ?>"
                                   data-prop="<?= $cartItem["prop"] ?>" data-attr="<?= $cartItem["attr"] ?>"
                                   href="javascript:void(0);" class="change-qty">Qty: <?= $cartItem["qty"] ?> <i
                                        class="fa fa-angle-down" aria-hidden="true"></i></a>
                            </div>

                            <div class="price-set">
                                <?php
                                if ($userDetail->is_prime == 1) {
                                $decrease = floatval($productdetails->act_price) - (floatval($productdetails->dis_price) - floatval($primeDiscount));
                                } else {
                                $decrease = floatval($productdetails->act_price) - floatval($productdetails->dis_price);
                                }

                                $percentage = round($decrease / floatval($productdetails->act_price) * 100);
                                ?>
                                <span class="real-price"><i class="fa fa-inr" aria-hidden="true"></i>

                                    <?php
                                    if ($userDetail->is_prime == 1) {
                                    echo round((floatval($productdetails->dis_price) - floatval($primeDiscount)) * intval($cartItem["qty"]));
                                    } else {
                                    echo round(floatval($productdetails->dis_price) * intval($cartItem["qty"]));
                                    }
                                    ?></span>
                                <?php if($productdetails->act_price != $productdetails->dis_price){?>
                                <span class="cut-price"> <i class="fa fa-inr" aria-hidden="true"></i>
                                    <?= round(floatval($productdetails->act_price) * intval($cartItem["qty"])) ?> </span>
                                <span class="off-price"> <i class="fa fa-inr" aria-hidden="true"></i>
                                    <?= $percentage ?>% OFF</span>
                                    <?php } ?>
                            </div>

                            <div class="remove-set">
                                <button data-key="<?= $key ?>" class="rmv-btn">Remove</button>
                                <button class="wsh-btn" data-pro="<?= encode($this->encryption->encrypt($cartItem["product"])) ?>"
                                        data-key="<?= $key ?>" data-prop="<?= $cartItem["prop"] ?>"
                                        data-attr="<?= $cartItem["attr"] ?>">ADD ALSO TO WISHLIST</button>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    }
                    ?>
                    <div onclick="window.location.href = '<?= base_url('Wishlist') ?>'" data-total="<?= $total ?>"
                         class="add-wish-set">
                        <img src="<?= base_url() ?>bootstrap/images/svg-icons/bookmark.svg">
                        <h3>Add More From Wishlist</h3>
                        <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-12">
                <div class="order-right" id="total2">
                    <div class="first-coupen">
                        <h3>OPTIONS</h3>
                        <?php if ($this->session->userdata("coupon_Id") == null) { ?>
                        <h4>Coupons <a href="#" data-toggle="modal" data-target="#apply-coupon">APPLY</a></h4>
                        <?php } else { ?>
                        <h4>Coupons <a href="#" class="remove_coupon">Remove</a></h4>
                        <?php } ?>
                    </div>

                    <!-- <div class="gift-wrap">
                        <p>
                            <span>Gift Wrap For <i class="fa fa-inr" aria-hidden="true"></i>  99</span></br>
                            Cash/Card On Delivery not available
                        </p>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"   value="1" name="gift" <?= $this->session->userdata("gift") == "" ? "" : "checked" ?> id="giftCheck"
                                   class="custom-control-input" id="giftCheck">
                            <label class="custom-control-label" for="giftCheck"></label>
                        </div>
                    </div> -->

                    <div class="price-detail">
                        <h2>Payment Details</h2>
                        <ul>
                            <li>
                                <h3>Total MRP</h3>
                                <span><i class="fa fa-inr" aria-hidden="true"></i>
                                    <?= number_format($MRPtotal) ?></span>
                            </li>
                            <li>
                                <h3>Bag Discount </h3>
                                <span style="color: #50c792;"><i class="fa fa-inr" aria-hidden="true"></i>
                                    <?= number_format($MRPtotal - $total) ?></span>
                            </li>
                            <!--                                <li>
                            
                                                                <h3>Tax (inclusive)</h3>
                                                                <span><i class="fa fa-inr" aria-hidden="true"></i> <?= number_format($tax) ?></span>
                                                            </li>-->
                            <?php
                            // print_r($this->session->userdata("gift"));
                            if ($this->session->userdata("gift") != NULL) {
                            ?>
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
                                $couponApplyOn = couponApplyOn($this->session->userdata('coupon_Id'));
                                // echo "<pre>";
                                // print_r( $couponApplyOn );
                                ?>
                                
                                <a
                                    href="#"><?= $offer[0]->offer_code . "(" . $offer[0]->offer_val . "" . ($offer[0]->offer_type == "0" ? '' : "%") . ") " ?></a>
                                    <?php } ?>
                            </li>
                            <li class="del_ship">
                                <h3>Delivery</h3>
                                <span>
                                    <?php
                                    $shippingVal = 0;
                                    // $shippingVal = ($qtyval >= 1 && $qtyval <= 10) ? 150 : (($qtyval >= 11 && $qtyval <= 25) ? 300 : ($qtyval > 25 ? 450 : 0));
                                    // echo "quantity ------------".$qtyval;
                                    
                                    if ($shipping[0]->ship_min >= $total) 
                                    {
                                        $shippingVal = floatval($shipping[0]->value);
                                    }
                                    
                                    $userDetail = $this->user->get_profile_id($userID);

                                    // if ($userDetail->is_prime == 1) {
                                    //    $shippingVal=0; 
                                    // }
                                    echo "<i class='fa fa-inr'></i>" . $shippingVal;
                                    ?>
                                </span>
                            </li>
                        </ul>

                    </div>

                    <div class="total-prc">
                    
                        <h3>Total <span><i class="fa fa-inr" aria-hidden="true"></i>
                                <?php
                                // echo $this->session->userdata("coupon_price"); echo "<br>";
                                $final_amt = 0.0;
                                $grand = ($total + floatval($shippingVal));
                                $final_amt = $grand;
                                // if (isset($offer) && $offer != null) {
                                // $offer = $offer[0];
                                // $offerType = $offer->offer_type; // 1 for % or 0 for price
                                // $which_price = $offer->which_price; // Grand Or Sub 0 : sub  1: grand
                                // // Subtotal and percentage
                                // if ($which_price == 0 && $offerType == 1) {
                                // $final_amt = $total - (floatval($total) * floatval($offer->offer_val) / 100);
                                // } elseif ($which_price == 1 && $offerType == 1) {
                                // $final_amt = floatval($grand) - (floatval($grand) * floatval($offer->offer_val) / 100);
                                // } elseif ($which_price == 0 && $offerType == 0) {
                                // $final_amt = (floatval($total) - floatval($offer->offer_val)) + floatval($shippingVal);
                                // } else {

                                // $final_amt = (floatval($grand) - floatval($offer->offer_val));
                                // }
                                // }

                                if($this->session->userdata("coupon_Id")!=null && $this->session->userdata("coupon_code")!=null){
                                    $final_amt = (floatval($grand) - floatval($this->session->userdata("coupon_price")));
                                }
                                if ($this->session->userdata("gift") != NULL) {
                                $final_amt = $final_amt + 99;
                                }
                                echo number_format($final_amt);
                                ?>

                            </span></h3>
                    </div>

                    <!-- <div class="payment-mth">
                        <h4>CHECKOUT OPTIONS:</h4>
                        <label class="radio pull-left">
                            <input type="radio" name="pay_type" onclick="addinBox(this)"  checked id="purchase_type"
                                    value="continue">
                            <span class="checkround"></span>
                            Continue to
                        </label>

                        <label class="radio pull-right">
                            <input type="radio" name="pay_type" onclick="addinBox(this)" id="purchase_type" value="adb">
                            <span class="checkround"></span>
                            Add to Box
                        </label>
                    </div> -->

                    <div class="palce-ord">
                        <span class="price-mob"><i class="fa fa-inr" aria-hidden="true"></i>
                            <?php echo number_format($final_amt); ?></br>
                            <a href="#total2">View Detail</a>
                        </span>
                        <button>PLACE ORDER</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>



    </div>
</div>

<section class="wish-page">
    <div class="container">
        <div class="wish-page-in">
            <?php
            $getLikedProdId = getLikedProdId($productdetails->id);
            if (count($getLikedProdId) > 0) {
            ?>

            <div class="wish-head">
                <h3>You may also like: </h3>
            </div>
            <?php } ?>
            <div class="wish-show">
                <div class="row">
                    <?php
                    foreach ($getLikedProdId as $like) {
                    $subname = cleanUrl($like->sub_name);
                    $product_name = cleanUrl($like->pro_name);
                    $decrease = floatval($like->act_price) - floatval($like->dis_price);
                    $percentage = $decrease / floatval($like->act_price) * 100;
                    ?>
                    <div class="col-md-3 col-xs-6 col-sm-6">
                        <div class="wish-block">
                            <div class="img-set"
                                 onclick="window.location.href = '<?= base_url("product/$subname/$product_name/" . encode($this->encryption->encrypt($like->PID))); ?>'">
                                <img class="lazy"
                                     data-src="<?= base_url('uploads/resized/') ?>resized_<?= load_images($like->PID) ?>"
                                     alt="<?= $like->pro_name ?>" />
                            </div>
                            <div class="show-pro-name">
                                <h4><?= $like->pro_name ?></h4>

                                <div class="detail-price">
                                    <span class="rs"><i class="fa fa-inr"
                                                        aria-hidden="true"></i><?= round($like->dis_price) ?></span>
                                    <span class="cut"><i class="fa fa-inr"
                                                         aria-hidden="true"></i><?= $like->act_price ?></span>
                                    <span class="show-off">(<?= round($percentage) ?>% OFF)</span>
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

<!-- Modal -->
<div id="add-address" class="modal fade address-model" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ADD NEW ADDRESS</h4>
            </div>
            <div class="modal-body">
                <div class="page-wrap">

                    <form>
                        <div class="styled-input">
                            <input type="text" required />
                            <label>Name</label>

                        </div>

                        <div class="styled-input">
                            <input type="tel" required />
                            <label>Phone</label>

                        </div>
                        <div class="styled-input2">
                            <input type="pin" required />
                            <label>Pin Code</label>

                        </div>
                        <div class="styled-input">
                            <input type="text" required />
                            <label>Address (House No, Building, Street, Area) *</label>

                        </div>
                        <div class="styled-input">
                            <input type="text" required />
                            <label>Locality / Town *</label>

                        </div>
                        <div class="styled-input">
                            <input type="text" required />
                            <label>City / District *</label>

                        </div>
                        <div class="styled-input3">
                            <h3>Type of Address *</h3>
                            <div class="styled-input3-in">
                                <label class="radio">Home
                                    <input type="radio" checked="checked" name="is_company">
                                    <span class="checkround"></span>
                                </label>
                            </div>


                            <div class="styled-input3-in">
                                <label class="radio">Office/Commercial
                                    <input type="radio" name="is_company">
                                    <span class="checkround"></span>
                                </label>

                            </div>
                        </div>
                        <div class="styled-input3">
                            <h3>Type of Address *</h3>


                            <label class="check ">Make this my default address
                                <input type="checkbox" name="is_name">
                                <span class="checkmark"></span>
                            </label>

                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="cancel-tb" data-dismiss="modal">Cancel</button>
                <button class="save-tb">SAVE</button>
            </div>
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
                    <input type="text" name="coupon_code" placeholder="Enter Coupon Code" readonly>
                    <span>APPLY</span>
                    <div class="coupon_error"></div>
                </div>

                <div class="bindCoupon">
                </div>
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
                    <div class="col-md-3 col-xs-3">
                        <img src="<?= base_url() ?>bootstrap/images/reg-girl.jpg" alt="" />
                    </div>
                    <div class="col-md-9 col-xs-9">
                        <h3>Remove item</h3>
                        <p>Are you sure you want to remove this item?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="rmove-btn" data-dismiss="modal">Remove</button>
            </div>
        </div>

    </div>
</div>

<div id="giftwrap" class="modal fade gift-wrap-pop" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form action="#" method="post" id="giftWrapForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">GIFT WRAP </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">

                    <div class="hed-set">
                        <h2>Your personalized message will be printed on a card & sent with your gift.</h2>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-wrap">



                                <div class="styled-input">
                                    <input type="text" name="recipient" id="recipient" required />
                                    <label>Recipient Name (Max. 60 characters)</label>
                                    <span id="error1" style="color:red;"> </span>    
                                </div>

                                <div class="styled-input">
                                    <input type="text" name="msg" id="msg" required />
                                    <label>Message (Max. 200 characters)</label>
                                    <span id="error2" style="color:red;"> </span> 
                                </div>

                                <div class="styled-input">
                                    <input type="text" name="sender_name" id="sender_name"  required />
                                    <label>Sender Name (Max. 60 characters)</label>
                                    <span id="error3" style="color:red;"> </span> 
                                </div>




                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="right-gift">
                                <h3>Gift Wrap Details</h3>

                                <ul class="giftWrapDetails-base-infoList">
                                    <li>This card will be sent along with your gift
                                    </li>
                                    <li>Gift packaging/invoice will not include any pricing, discount or payment information
                                    </li>
                                    <li>All original product tags with MRP will be intact</li>
                                    <li>Gift wrapping is not available for Cash/Card on Delivery orders.</li>
                                </ul>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="cancel-st " data-dismiss="modal">Remove</button>
                    <button type="button" id="submitGiftForm" class="add-st" >Apply</button>
                </div>
        </form>
    </div>

</div>
</div>