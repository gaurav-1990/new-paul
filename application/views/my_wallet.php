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
                            <a href="<?= base_url('Myaccount/dashboard') ?>" >
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
                            <a href="<?= base_url('Checkout/myCoupon') ?>">
                                Coupons
                            </a>
                            <a href="<?= base_url('Checkout/myWallet') ?>" class="active">
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
                            <a href="<?= base_url('Checkout/myAddress') ?>">
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

                            // //echo $diff->days;
                            // // $years = floor($diff / (365*60*60*24));
                            // // $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                            // // $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                            // //echo $days;
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
                    <div class="nautinati-wallet">
                        <div class="nautinati-wallet-in">
                            <h3> YOUR PAULSONSONLINE CREDIT HERE!</h3>

                            <span><i class="fa fa-inr" aria-hidden="true"></i> <?= ($wallet > 0) ? $wallet : '0.00' ?></span>

                        </div>

                    </div>
                    <?= $this->session->flashdata('msg'); ?>
                    <?php
                    if ($wallet <= 0) {
                        ?>
                        <section class="no-itam-cart">
                            <div class="container">
                                <div class="no-itam-cart-in">
                                    <img src="<?= base_url(); ?>assets/images/empty-wallet-img.jpg" class="cart-img">
                                    <h3>Hey, it feels so light!</h3>
                                    <p>There is nothing in your Wallet. Let's add some pints.</p>

                                    <form action="<?= base_url("Checkout/myWallet") ?>" method="POST">

                                        <div class="col-md-12">


                                            <div class="form-group">
                                                <input type="text" name="wallet_amount" placeholder="Enter Amount" class="form-control"  />
                                            </div>
                                        </div>
                                        <?= validation_errors() ?>
                                        <br>
                                        <button type="submit">ADD POINTS IN WALLET</button>
                                    </form>

                                </div>
                            </div>
                        </section>
                        <?php
                    } else {
                        ?>
                        <section class="no-itam-cart">
                            <div class="container">
                                <div class="no-itam-cart-in">
                                    <img src="<?= base_url(); ?>assets/images/empty-wallet-img.jpg" class="cart-img">
                                    <h3>Let's do some shopping</h3>
                                    <p>Wanna add more</p>
                                    <form action="<?= base_url("Checkout/myWallet") ?>" method="POST">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="wallet_amount"  placeholder="Enter Amount" class="form-control"  />
                                            </div>
                                            <?= validation_errors() ?>
                                            <br>
                                        </div>
                                        <button type="submit">ADD POINTS IN WALLET</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                        <?php
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>
</div>

