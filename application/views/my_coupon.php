
<div class="profile-container">
    <div class="container">
        <div class="profile-container-in">
            <div class="header-user">
                <div class="hd-name">
                    Account
                </div>


            </div>
            <div class="user-used">
                <div class="left-set">
                    <ul>

                        <li>
                            <a href="<?= base_url('Myaccount/dashboard') ?>">
                                Overview
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Order</div>
                        <li>
                            <a href="<?= base_url("Myaccount/orderDetails") ?>">
                                Orders
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Credits</div>
                        <li>
                            <a href="<?= base_url('Checkout/myCoupon') ?>" class="active">
                                Coupons
                            </a>
                            <a href="<?= base_url('Checkout/myWallet') ?>">
                                Paulsons Wallet
                            </a>

                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Account</div>
                        <li>
                            <a href="<?= base_url('Myaccount/editProfile') ?>">
                                Profile
                            </a>
                            <a href="<?= base_url('Checkout/myAddress') ?>" >
                                Address
                            </a>

                            <?php
                            // $res = getUserByEmail($this->session->userdata('myaccount'));
                            // $date3 = $res->bir_year . "-" . $res->bir_month . "-" . $res->bir_day;
                            // $date4 = $res->ann_year . "-" . $res->ann_month . "-" . $res->ann_day;
                            // // $diff = abs(strtotime(date("Y-m-d")) - strtotime($res->prime_date));

                            // $date1 = date_create(date("Y-m-d"));

                            // $date2 = date_create($res->prime_date);

                            // $diff = date_diff($date1, $date2);

                            // $rem_days = floatval(loadSubcription()->subscription_form) - $diff->days;
                            // if ($rem_days == 0) {
                            //     $result = getUpdatePrime($this->session->userdata('myaccount'));
                            // }
                            // $res = getUserByEmail($this->session->userdata('myaccount'));
                            // if ($res->is_prime == 1) {
                                ?>
                                <!-- <a href="#">
                                    Prime Subscription Remaining : <?= $rem_days ?> days
                                </a> -->
                            <?php // } else { ?>
                                <!-- <a href="<?= base_url('Prime') ?>">
                                    Get Prime Membership
                                </a> -->
                            <?php // } ?>
                        </li>
                    </ul>
                </div>


                <div class="right-set">


                    <?php if ($coupons != NULL) {
$nocoupon=0;
                        foreach ($coupons as $cou) {
                            $sys = date_create(date("Y-m-d"));
                            $cou_date = date_create($cou->offer_validity_to);
                            $diff = abs(strtotime(date("Y-m-d")) < strtotime($cou->offer_validity_to));
                            $totalCou = countCoupon($cou->id);
                            $countCoupon = $cou->offer_per_customer - count($totalCou);

                            if ($diff > 0 && $countCoupon > 0) {
                                $nocoupon=0;
                                if($cou->block != 1){
                                ?>

                                <div class="my-coupon">
                                    <div class="my-coupon-in">
                                        <div class="left-offer">

                                            <?php if ($cou->offer_type == 0) { ?>                                          
                                                <span> <i class="fa fa-inr" aria-hidden="true"></i> <?= $cou->offer_val ?>     </br> OFF</span> 

                                            <?php } else { ?>
                                                <?= $cou->offer_val ?> % </br>  OFF                           
                                            <?php } ?>

                                        </div>
                                        <div class="right-offer">
                                            <p>On minimum purchase of Rs. <?= $cou->min_val ?></p>
                                            <p>Code: <?= $cou->offer_code ?></p>
                                            <small>*Tax Extra</small>
                                        </div>
                                    </div>
                                    <div class="coupon-dtl">
                                        <div class="date-sh">
                                            <span>Expiry:  </span>
                                            <span><b><?= date("jS F, Y", strtotime($cou->offer_validity_to)) ?></b> </span>
                                            <!-- <span>11:30:00 P.M</span> -->
                                        </div>
                                        <a href="#" class="dtl-show" onclick="$('.min-purch').toggle('slow');
                                                            if ($(this).text() == 'Hide' ? $(this).text('Details') : $(this).text('Hide'))
                                                                ;">
                                            Details
                                        </a>

                                        <ul class="min-purch" style="display:none;">
                                            <li><?= $cou->offer_val ?> <?= ($cou->offer_type == 0) ? '<i class="fa fa-inr" aria-hidden="true"></i> ' : '% ' ?>off on minimum purchase of Rs. <?= $cou->min_val ?></li>
                                        </ul>
                                    </div>

                                </div>
                                <?php
                                }
                            }else {
                                $nocoupon=1;
                                ?>


                    <?php

                            }
                        }

                        if($nocoupon==1)
                        {
                            ?>
                            <h2 style="text-align: center"> No Coupon Available Here </h2>
                    <?php
                        }
                        ?>

                    </div>
                <?php } else { ?>
                    <h2 style="text-align: center"> No Coupon Available Here </h2>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
