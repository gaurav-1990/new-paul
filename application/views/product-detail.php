<?php
// echo "<pre>";
// print_r($product);
// die;
?>
<div class="product-detail-set">
    <div class="container">
        <div class="product-detail-navi-set">
            <a href="<?= base_url(); ?>"> Home /</a>
            <?php
            $sub_url = base_url('details/') . cleanUrl($product[0]->cat_name) . "/" . cleanUrl($product[0]->sub_name) . "/" . encode($this->encryption->encrypt($product[0]->sub_id));
            $cat_url = base_url('') . cleanUrl($product[0]->cat_name) . "/" . encode($this->encryption->encrypt($product[0]->sub_id));
            ?>
            <a href="<?= $cat_url ?>"><?= ucwords($product[0]->cat_name); ?> <?= ($product[0]->cat_name != NULL) ? '/' : '' ?> </a>
            <a href="<?= isset($sub_url) ? $sub_url : "#" ?>"><?= ucwords($product[0]->sub_name); ?> <?= ($product[0]->sub_name != NULL) ? '/' : '' ?></a>
            <a href="<?= isset($sub_url) ? $sub_url : "#" ?>"><?= ucwords($product[0]->pro_name); ?> </a>

        </div>
    </div>

    <?php
    $checkPrime = 0;
    $res = getAllProductImage($product[0]->ID);
    ?>
    <!-- Product Detail -->
    <section class=" product-detail-show-main">

        <div class="container">
            <div class="row">
                <div class=" col-md-6 col-xs-12 " >
                    <div class=""  >
            
                <ul id="glasscase" class="gc-start">
                    <?php
                        foreach ($res as $val) {

                        if ($val->pro_images && $val->pro_images != "" && file_exists(FCPATH . "uploads/original/$val->pro_images")) {
                    ?>
                    <li><img src="<?= base_url() ?>uploads/original/<?= $val->pro_images ?>" alt="Text" data-gc-caption="Your caption text" /></li>
<!--                    <li><img src="<?= base_url()?>bootstrap/images/sarees/saree2.jpg" alt="Text" /></li>
                    <li><img src="<?= base_url()?>bootstrap/images/sarees/saree3.jpg" alt="Text" /></li>
                    <li><img src="<?= base_url()?>bootstrap/images/sarees/saree4.jpg" alt="Text" /></li>-->
                    
                   <?php
                        }
                    }
                    ?>
                    
                    
                </ul>
            </div>
                   <div class=" row ">
                        <?php
                        $checkPrime = 0;
                        $res = getAllProductImage($product[0]->ID);
                        ?>
                        <div class="pro-inslider">
                       <div id="inside-final " class=" gc-start " >
                                <?php
                                foreach ($res as $val) {

                                    if ($val->pro_images && $val->pro_images != "" && file_exists(FCPATH . "uploads/original/$val->pro_images")) {
                                        ?>
                                <div ><img class="lazy"
                                                  data-src="<?= base_url() ?>uploads/original/<?= $val->pro_images ?>"
                                                  alt=""/></div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="view-related">
                                <button type="button" data-prod="<?= encode($this->encryption->encrypt($product[0]->ID)) ?>"
                                        data-toggle="modal" data-target="#similar-im">    <img src="<?= base_url()?>bootstrap/images/similer.png"> View Similar
                                </button>

                            </div>
                        </div>
                        <div class="for-only-img">
                            <?php
                            foreach ($res as $val) {
                                if ($val->pro_images != "" && file_exists(FCPATH . "uploads/original/$val->pro_images")) {
                                    ?>
                                    <div class="col-md-6 col-sm-6 ">
                                        <div class="left-pro-zoom ">
                                            <img class="lazy"
                                                 data-src="<?= base_url() ?>uploads/original/<?= $val->pro_images ?>"
                                                 alt=""/>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class=" col-md-6 col-xs-12">
                    <div class="pro-detail">
                        <div class="pro-name-detail">
                            <h4><?= $product[0]->pro_name ?></h4>
                            <h5><?= $product[0]->product_sname ?></h5>
                            <?= ($product[0]->pro_stock <= 0) ? "<b>SOLD OUT</b>" : "" ?>
                        </div>
                        <div class="pro-price-detail">
                            <?php
                            $prod_price_prime = 0;
                            if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {

                                $prod_price = 0;

                                $prod_price2 = 0.0;
                                $userID = getUserIdByEmail();
                                if (@count($userID) > 0) {
                                    $userDetail = $this->user->get_profile_id($userID);
                                    if ($userDetail->is_prime == 1) {
                                        $checkPrime = 1;
                                        $getSubscription = load_subscription();
                                        $primeDiscount = floatval($product[0]->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member
                                        $prod_price = (floatval($product[0]->dis_price) - floatval($primeDiscount));
                                        $prod_price_prime = (floatval($product[0]->dis_price) - floatval($primeDiscount));
                                    } else {
                                        $getSubscription = load_subscription();
                                        $primeDiscount = floatval($product[0]->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member

                                        $prod_price_prime = (floatval($product[0]->dis_price) - floatval($primeDiscount));
                                        $prod_price = $product[0]->dis_price;

                                    }
                                } else {
                                    $prod_price = $product[0]->dis_price;
                                }
                            } else {
                                $getSubscription = load_subscription();
                                $primeDiscount = floatval($product[0]->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member

                                $prod_price_prime = (floatval($product[0]->dis_price) - floatval($primeDiscount));
                                $prod_price = $product[0]->dis_price;
                            }
                            ?>

                            <!-- <span class="real-pc"><i class="fa fa-inr" aria-hidden="true"></i> <?= round($prod_price); ?> </span> -->


                            <?php
                            // percentage
                            if (isset($userDetail)) {
                                if ($userDetail->is_prime == 1) {
                                    $decrease = floatval($product[0]->act_price) - floatval($prod_price);
                                } else {
                                    $decrease = floatval($product[0]->act_price) - floatval($prod_price);
                                }
                            } else {
                                $decrease = floatval($product[0]->act_price) - floatval($prod_price);
                            }

                            // $decrease = floatval($product[0]->act_price) - floatval($product[0]->dis_price);
                            $percentage = $decrease / floatval($product[0]->act_price) * 100;
                            ?>

                            <?php if ($checkPrime == 1) { ?>
                                <span class="real-pc primePriceDis">   <i class="fa fa-inr"
                                                                          aria-hidden="true"></i> <?= round($product[0]->dis_price); ?> </span>
                                <span class="cut-pc"> <i class="fa fa-inr"
                                                         aria-hidden="true"></i> <?= $product[0]->act_price ?></span>
                                <span class="off-pc">(<?= round($percentage) ?>% OFF)</span>
                                <!-- <span class="real-pc primePrice"><i class="fa fa-shopping-basket"
                                                                    aria-hidden="true"></i> Prime Price : <i
                                            class="fa fa-inr" aria-hidden="true"></i> <?= round($prod_price); ?> </span> -->

                            <?php } else { ?>
                                <span class="real-pc primePriceDis">   <i class="fa fa-inr"
                                                                          aria-hidden="true"></i> <?= round($product[0]->dis_price); ?> </span>
                                <span class="cut-pc"> <?= ($product[0]->act_price == $product[0]->dis_price)? "" : '<i class="fa fa-inr"
                                                         aria-hidden="true"></i>'?> <?= ($product[0]->act_price == $product[0]->dis_price)? "" : $product[0]->act_price ?></span>
                                <?= ($product[0]->act_price == $product[0]->dis_price)? "" : "<span class='off-pc'>".(round($percentage)."% OFF</span>")?>
                                <!-- <span class="real-pc primePrice"><i class="fa fa-shopping-basket"
                                                                    aria-hidden="true"></i> Prime Price : <i
                                            class="fa fa-inr" aria-hidden="true"></i> <?= round($prod_price_prime); ?> </span> -->


                            <?php } ?>

                            <p>Inclusive of All Taxes</p>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-3" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="size-table">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Size Chart
                                                : <?= ucwords($product[0]->pro_name); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            if ($product[0]->sizeChart != 0) {
                                                ?>
                                                <img src="<?= base_url() ?>uploads/sizechart/<?= $product[0]->sizeChart ?>"
                                                     alt="sizeChart">
                                            <?php } else { ?>
                                                <img src="<?= base_url() ?>sizeChart.jpg" alt="sizeChart">
                                            <?php } ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div  class="pro-size-detail" data-pro="<?= encode($this->encryption->encrypt($product[0]->ID)); ?>">
                            <h4>SELECT SIZE</h4>
                            <!-- <button data-toggle="modal" data-target="#exampleModal"> SIZE CHART</button>  -->
                            <span class="chooseOwnSize"> </span>
                            <?php
                            if (isset(json_decode($product[0]->product_attr)->response)) {
                                ?>

                                <ul>
                                    <?php
                                    foreach (json_decode($product[0]->product_attr)->response as $key => $attr) {

                                        foreach ($attr->attribute as $key2 => $a) {

                                            $k = (key((array)$a));
                                            $str = strtoupper((string)$a->$k);

                                            if ((int)$attr->qty < 1) {
                                                ?>
                                                <li data-prop="<?= strtolower((string)$k) ?>"
                                                    data-qty="<?= $attr->qty ?>"
                                                    data-attr="<?= strtoupper((string)$a->$k) ?>">
                                                    <a href="javascript:void(0)" class="off-no"><?= $str ?>
                                                        
                                                    </a>
                                                </li>
                                                <?php
                                            } else {
                                                ?>
                                                <li data-prop="<?= strtolower((string)$k) ?>"
                                                    data-qty="<?= $attr->qty ?>"
                                                    data-attr="<?= strtoupper((string)$a->$k) ?>">
                                                    <a href="javascript:void(0)"
                                                       class="<?= ((int)$attr->qty < 1) ? 'off-no' : ($key2 == 0 ? "my-active" : "") ?>"><?= $str ?></a>
                                                    <?php
                                                    if ((int)$attr->qty < 5) {
                                                        ?>
                                                        <span class="left-stock"><?= $attr->qty ?> left</span>
                                                    <?php }
                                                    ?>
                                                </li>

                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>
                                </ul>

                            <?php } ?>
 
                        </div>

                        <div class="pro-addcart-detail">
                            <button class="cart-btn"><i class="fa fa-shopping-bag" aria-hidden="true"></i> ADD TO BAG
                            </button>
                            <button class="wish-btn"><i class="fa fa-heart" aria-hidden="true"></i> </button>
                            <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&layout=button&size=small&width=67&height=20&appId" width="67" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>

                        </div>
                        <div class="show-detail-bot">
                            <h3>PRODUCT DETAILS <i class="fa fa-file-text-o" aria-hidden="true"
                                                   style="margin-left: 6px; color: #5f5d5d;"></i></h3>
                            <?= $product[0]->pro_desc ?>

                            <!-- <h4> Specifications </h4> -->
                            <!-- <div class=" row">
                                <?php
                                foreach ($specification as $spe) {
                                    ?>
                                    <div class=" col-md-6  ">
                                        <div class="left-Specific">
                                            <small><?= $spe->skey ?></small>
                                            <p><?= $spe->value ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>  
                            <div class="see-more-set">
                                <?= $product[0]->short_desc ?>
                            </div>
                            <!-- <a href="javascript:void(0)" onclick="$('.see-more-set').toggle();" class="semore">See More</a> -->
                        </div>
                        <?php if($average != NULL){?>
                        <div class="review-part">
                            <h2>Ratings <i class="fa fa-star-o" aria-hidden="true"></i></h2>
                            <div class="row">
                                <div class="col-xs-5 col-md-4 ">
                                    <h1 class="rating-num">
                                        <?php if ($average != NULL) { ?>
                                            <span><?= round($average) ?></span>
                                        <?php } else { ?>
                                            <span> 3 </span>
                                        <?php } ?>
                                        <i class="fa fa-star" aria-hidden="true"></i></h1>

                                    <div class="total-use-num">
                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                        <?php if ($user_count != NULL) { ?>
                                            <span><?= $user_count ?></span> total
                                        <?php } else { ?>
                                            <span>1001</span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-xs-7 col-md-7 rating-desc">
                                    <div class="row ">
                                        <div class="col-xs-3 col-md-2 text-right side-star">
                                            5 <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress progress-striped">
                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?= $fiveAvg ?>%">
                                                    <span class="sr-only"><?= $fiveAvg ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 5 -->
                                        <div class="col-xs-3 col-md-2 text-right side-star">
                                            4 <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?= $fourAvg ?>%">
                                                    <span class="sr-only"><?= $fourAvg ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 4 -->
                                        <div class="col-xs-3 col-md-2 text-right side-star">
                                            3 <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-info" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?= $threeAvg ?>%">
                                                    <span class="sr-only"><?= $threeAvg ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 3 -->
                                        <div class="col-xs-3 col-md-2 text-right side-star">
                                            2 <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?= $twoAvg ?>%">
                                                    <span class="sr-only"><?= $twoAvg ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 2 -->
                                        <div class="col-xs-3 col-md-2 text-right side-star">
                                            1 <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                                     aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?= $oneAvg ?>%">
                                                    <span class="sr-only"><?= $oneAvg ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 1 -->
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                        </div>
                                        <?php } ?>
                        <div class="delivery-opc" id="sibling">
                            <label for="">DELIVERY OPTIONS <i class="fa fa-truck" aria-hidden="true"></i></label>
                            <div class="delivery-opc-in">

                                <input type="text" placeholder="Zip Code" id="zip_address" maxlength="6" class="form-control" name="zip_address" />
                                <button id="checkAvail">
                                    Check
                                </button>
                            </div>
                            <p>Please enter PIN code to check delivery time & Cash/Card on Delivery Availability</p>
                        </div>
                        <div class="note-set">
                            <!-- <p>Tax: Applicable tax on the basis of exact location & discount will be charged at the time
                                of checkout</p> -->
                            <p>Genuine Products Guaranteed</p>
                            <!-- <p>Cash on delivery might be available</p> -->
                            <!-- <p>Easy 30 days returns and exchanges</p> -->
                            <!-- <p>Try & Buy might be available</p> -->
                            <!-- <p>Product Code: <strong> <?= $product[0]->sku ?></strong></p> -->
                            <p>Sold by: <?= ucfirst(strtolower($product[0]->company)) ?></p>
                        </div>
                    </div>

                    <div class="p-b-45">
                        <!-- <span class="s-text8 m-r-35">SKU:#<?= $product[0]->sku ?></span> -->
                        <br>
                        <span class="s-text8">Categories : <?= $product[0]->cat_name ?>
                            | <?= $product[0]->sub_name ?> </span>
                        <br>
                        <!-- <span class="s-text8">Tags : <?php // echo $product[0]->txt_msg ?> </span> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    $getSimilarProd = getSimilarProd($product[0]->ID);
    if ($getSimilarProd != NULL) {
        ?>
        <div class="similar-in-pro">

            <div class="wish-head">
                <h3>Similar Products: </h3>
            </div>

            <div class="wish-block-cover">
                <div class="wish-block-cover-in">

                    <?php
                    foreach ($getSimilarProd as $sim) {
                        $getSimProduct = getSimProduct($sim->relate_pro_id);
                        $product_name = cleanUrl($getSimProduct[0]->pro_name);

                        if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {

                            $prod_price = 0;
                            $userID = getUserIdByEmail();
                            if (@count($userID) > 0) {
                                $userDetail = $this->user->get_profile_id($userID);
                                if ($userDetail->is_prime == 1) {
                                    $getSubscription = load_subscription();
                                    $primeDiscount = floatval($getSimProduct[0]->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member
                                    $prod_price = (floatval($getSimProduct[0]->dis_price) - floatval($primeDiscount));
                                } else {
                                    $prod_price = $getSimProduct[0]->dis_price;
                                }
                            } else {
                                $prod_price = $getSimProduct[0]->dis_price;
                            }
                        } else {
                            $prod_price = $getSimProduct[0]->dis_price;
                        }


                        $decrease = floatval($getSimProduct[0]->act_price) - floatval($prod_price);
                        $percentage = $decrease / floatval($getSimProduct[0]->act_price) * 100;
                        $subname = cleanUrl($sim->sub_name);
                        ?>
                        <div class="wish-block"
                             onclick="window.location.href = '<?= base_url("product/$subname/$product_name/" . encode($this->encryption->encrypt($getSimProduct[0]->id))); ?>'">
                            <div class="img-set">
                                <img class="lazy"
                                     data-src="<?= base_url('uploads/resized/') ?>resized_<?= load_images($getSimProduct[0]->id) ?>"
                                     alt="<?= $getSimProduct[0]->pro_name ?>"/>
                            </div>
                            <div class="show-pro-name">
                                <h4><?= $getSimProduct[0]->pro_name ?></h4>
                                <p><?= $getSimProduct[0]->product_sname ?></p>
                                <div class="detail-price">
                                    <span class="rs"><i class="fa fa-inr" aria-hidden="true"></i><?= round($prod_price) ?></span>
                                    <span class="cut"><?= ($getSimProduct[0]->act_price == $prod_price) ? '' : '<i class="fa fa-inr" aria-hidden="true"></i>'.$getSimProduct[0]->act_price ?></span>
                                    <?= ($getSimProduct[0]->act_price == $prod_price)? "" : "<span class='show-off'>".(round($percentage)."% OFF</span>")?>
                                </div>

                            </div>
                        </div>

                    <?php } ?>


                </div>
            </div>

        </div>
        <div class="other-related">
            <div class="other-related-in">
                <?php
                $data_attr = getBrand($product[0]->pro_id);

                foreach ($data_attr as $val) {
                    if (strtolower($val->pop_name) == 'brand') {
                        $brand = $val->attr_name;
                    }
                    if (strtolower($val->pop_name) == 'color') {
                        $color = $val->attr_name;
                    }
                }


                foreach ($product as $ky=> $prod) {
                    $cat_name = cleanUrl($prod->cat_name);
                    $sub_name = cleanUrl($prod->sub_name);
                    if ($prod->child_id == 0) {
                        $PID = $prod->sub_id;
                        $url = base_url("details/" . "$cat_name/$sub_name/" . encode($this->encryption->encrypt($PID)));
                    } else {
                        $PID = $prod->child_id;
                        $url = base_url("details/" . "$cat_name/$sub_name/$product_name/" . encode($this->encryption->encrypt($PID)));
                    }
                    ?>
                    <a href="<?= $url ?>">More <?= $prod->sub_name ?></a>   <!--  <i class="fa fa-angle-right"></i> (<?=$ky+1?>) -->
                    <?php
                }

                ?>
            </div>
        </div>
    <?php } ?>
    <?php
    $getLikedProdId = getLikedProdId($product[0]->ID);
    if ($getLikedProdId != NULL) {
        ?>
        <div class="similar-in-pro">

            <div class="wish-head">
                <h3>Customer also like </h3>
            </div>
            <div class="wish-block-cover">
                <div class="wish-block-cover-in">
                    <?php
                    foreach ($getLikedProdId as $like) {
                        $product_name = cleanUrl($like->pro_name);
                        $subname = cleanUrl($like->sub_name);

                        if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {

                            $prod_price = 0;
                            $userID = getUserIdByEmail();
                            if (@count($userID) > 0) {
                                $userDetail = $this->user->get_profile_id($userID);
                                if ($userDetail->is_prime == 1) {
                                    $getSubscription = load_subscription();
                                    $primeDiscount = floatval($like->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member
                                    $prod_price = (floatval($like->dis_price) - floatval($primeDiscount));
                                } else {
                                    $prod_price = $like->dis_price;
                                }
                            } else {
                                $prod_price = $like->dis_price;
                            }
                        } else {
                            $prod_price = $like->dis_price;
                        }

                        $decrease = floatval($like->act_price) - floatval($prod_price);
                        $percentage = $decrease / floatval($like->act_price) * 100;
                        ?>
                        <div class="wish-block"
                             onclick="window.location.href = '<?= base_url("product/$subname/$product_name/" . encode($this->encryption->encrypt($like->PID))); ?>'">
                            <div class="img-set">
                                <img class="lazy"
                                     data-src="<?= base_url('uploads/resized/') ?>resized_<?= load_images($like->PID) ?>"
                                     alt="<?= $like->pro_name ?>"/>
                            </div>
                            <div class="show-pro-name">
                                <h4><?= $like->pro_name ?></h4>
                                <p><?= $like->product_sname ?></p>
                                <!-- <div class="detail-price">
                                    <span class="rs"><i class="fa fa-inr" aria-hidden="true"></i><?= round($prod_price) ?></span>
                                    <span class="cut"><i class="fa fa-inr" aria-hidden="true"></i><?= $like->act_price ?></span>
                                    <span class="show-off">(<?= round($percentage) ?>% OFF)</span>
                                </div> -->

                                <div class="detail-price">
                                    <span class="rs"><i class="fa fa-inr" aria-hidden="true"></i><?= round($prod_price) ?></span>
                                    <span class="cut"><?= ($like->act_price == $prod_price) ? '' : '<i class="fa fa-inr" aria-hidden="true"></i>'.$like->act_price ?></span>
                                    <?= ($like->act_price == $prod_price)? "" : "<span class='show-off'>".(round($percentage)."% OFF</span>")?>
                                </div>


                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    <?php } ?>

</div>

<div class="modal fade similar-pop" id="similar-im">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="similar-in-pro">

                    <div class="wish-head">
                        <h3>Similar Product</h3>
                    </div>
                    <div class="wish-block-cover">
                        <div class="wish-block-cover-in simProdMob">


                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>
<script type="text/javascript">
        $(document).ready( function () {
            //If your <ul> has the id "glasscase"
            $('#glasscase').glassCase({ 'thumbsPosition': 'bottom', 'widthDisplay' : 560});
        });
    </script>