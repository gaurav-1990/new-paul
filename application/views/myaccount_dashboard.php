<?php
// print_r($this->session->userdata('myaccount'));
// die;
?>

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
                            <a href="<?=base_url('Myaccount/dashboard')?>" class="active">
                                Overview
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Order</div>
                        <li>
                            <a href="<?=base_url("Myaccount/orderDetails");?>">
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
                            <a href="<?=base_url('Checkout/myWallet')?>">
                            Paulsons Wallet
                            </a>

                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Account</div>
                        <li>
                            <a href="<?=base_url('Myaccount/editProfile')?>">
                                Profile
                            </a>
                            <a href="<?=base_url('Checkout/myAddress')?>">
                                Address
                            </a>

                            <?php
// $res = getUserByEmail($this->session->userdata('myaccount'));

// $diff = abs(strtotime(date("Y-m-d")) - strtotime($res->prime_date));

// $date1 = date_create(date("Y-m-d"));

// $date2 = date_create($res->prime_date);

// $diff = date_diff($date1, $date2);

// $rem_days = 90 - $diff->days;
// if ($rem_days == 0) {
//     $result = getUpdatePrime($this->session->userdata('myaccount'));
// }
// $res = getUserByEmail($this->session->userdata('myaccount'));
// if ($res->is_prime == 1) {
?>
                                <!-- <a href="#">
                                    Prime Subscription Remaining : <?=$rem_days?> days
                                </a> -->
                            <?php // } else { ?>
                                <!-- <a href="<?=base_url('Prime')?>">
                                    Get Prime Membership
                                </a> -->
                            <?php // } ?>
                        </li>
                    </ul>
                </div>


                <div class="right-set">
                   
                    <?=$this->session->flashdata('msg');?>
                    <div class="profile-show">
                        <div class="col-md-3">
                            <div class="user-img">
                                <?php
if ($user->profile_pic == '') {
    ?>
                                <img src="<?=base_url()?>bootstrap/images/use.jpg" alt="paulsons-LOGO" width="93%">
                                <?php } else {?>
                                    <img src="<?=base_url()?>uploads/profilePic/<?=$user->profile_pic?>" alt="<?=$user->user_name?>" width="93%">

                                <?php }?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-name">
                                <?=$user->user_name?> <?=$user->lastname?> <br>
                                <?=isset($user->user_email) ? $user->user_email : ""?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="user-edit">
                                <a href="<?=base_url('Myaccount/editProfile')?>"><button>Edit Profile</button></a>
                            </div>
                        </div>
                    </div>


                    <div class="user-select">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="user-select-block">
                                    <a href="<?=base_url("Myaccount/orderDetails")?>">
                                        <div class="icone-set">
                                            <img src="<?=base_url()?>bootstrap/images/icons/box.png" alt="ICON">
                                        </div>
                                        <div  class="cat-select">
                                            Orders
                                        </div>
                                        <p>
                                            Check your order status
                                        </p>

                                        <i class="fa fa-angle-right" aria-hidden="true"></i>

                                    </a>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="user-select-block">
                                    <a href="<?=base_url("Wishlist")?>">
                                        <div class="icone-set">
                                            <img src="<?=base_url()?>bootstrap/images/icons/wish.png" alt="ICON">
                                        </div>
                                        <div class="cat-select">
                                            Collections & Wishlist
                                        </div>
                                        <p>
                                            All your Collections & Wishlist
                                        </p>
                                    </a>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="user-select-block">
                                    <a href="<?=base_url("Checkout/myWallet")?>">
                                        <div class="icone-set">
                                            <img src="<?=base_url()?>bootstrap/images/icons/credit.png" alt="ICON">
                                        </div>
                                        <div class="cat-select">
                                            Paulsons Wallet
                                        </div>
                                        <p>
                                            Manage all your paulsons Credit
                                        </p>
                                    </a>

                                </div>

                            </div>




                            <div class="col-md-4">
                                <div class="user-select-block">
                                    <a href="<?=base_url('Checkout/myAddress')?>">
                                        <div class="icone-set">
                                            <img src="<?=base_url()?>bootstrap/images/icons/add.png" alt="ICON">
                                        </div>
                                        <div class="cat-select">
                                            Address
                                        </div>
                                        <p>
                                            Check your Address
                                        </p>
                                    </a>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="user-select-block">
                                    <a href="<?=base_url('Checkout/myCoupon')?>">
                                        <div class="icone-set">
                                            <img src="<?=base_url()?>bootstrap/images/icons/coupon.png" alt="ICON">
                                        </div>
                                        <div class="cat-select">
                                            Coupon
                                        </div>
                                        <p>
                                            Check your Coupon status
                                        </p>
                                    </a>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="user-select-block">
                                    <a href="<?=base_url('Myaccount/editProfile')?>">
                                        <div class="icone-set">
                                            <img src="<?=base_url()?>bootstrap/images/icons/profile.png" alt="ICON">
                                        </div>
                                        <div class="cat-select">
                                            Profile details
                                        </div>
                                        <p>
                                            Check your Profile details
                                        </p>
                                    </a>
                                </div>

                            </div>
                            <!-- <div class="col-md-4">
                                <div class="user-select-block">

                                    <?php
if ($res->is_prime == 1) {
    ?>

                                        <div class="icone-set">
                                            <img src="<?=base_url()?>bootstrap/images/icons/points.png" alt="ICON">
                                        </div>
                                        <div class="cat-select">
                                            Prime Subscription
                                        </div>
                                        <a href="javascript:void">
                                            Subscription Remaining : <?=$rem_days?> days
                                        </a>
                                    <?php } else {?>
                                        <div onclick="window.location.href = '<?=base_url('Prime')?>'" class="icone-set">
                                            <img src="<?=base_url()?>bootstrap/images/icons/points.png" alt="ICON">
                                        </div>
                                        <div class="cat-select">
                                            Prime Subscription
                                        </div>
                                        <a href="<?=base_url('Prime')?>">
                                            Get Prime Membership
                                        </a>
                                    <?php }?>


                                </div>

                            </div> -->

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="logout">
                                    <button onclick="window.location.href = '<?=base_url()?>Myaccount/logout';">LOGOUT</button>
                                </div>

                            </div>
                        </div>

                    </div>


                    <!--  <div class="coupon-set">
                       <ul>
                           <li>
                               <div class="coupon-cover">
                                   <div class="row">
                                       <div class="col-md-3">
                                   <div class="green-offer">
                                       30% <br> OFF
                                   </div>
                                       </div>
                                       <div class="col-md-5">
                                   <div class="offer-cont">
                                       <p>On minimum purchase of Rs.0</p>
                                       <p>Code: STEAL30</p>
                                       <small>*Tax Extra   </small>
                                   </div>
                                   </div>
                               </div>

                               </div>
                               <div class="expiry">
                                   <span>Expiry: <b>JUL 30 2019</b> 09:00 PM</span>
                                   <a href="#">Details</a>
                               </div>

                           </li>
                         <li>
                               <div class="coupon-cover">
                                   <div class="row">
                                       <div class="col-md-3">
                                   <div class="green-offer">
                                       30% <br> OFF
                                   </div>
                                       </div>
                                       <div class="col-md-5">
                                   <div class="offer-cont">
                                       <p>On minimum purchase of Rs.0</p>
                                       <p>Code: STEAL30</p>
                                       <small>*Tax Extra   </small>
                                   </div>
                                   </div>
                               </div>

                               </div>
                               <div class="expiry">
                                   <span>Expiry: <b>JUL 30 2019</b> 09:00 PM</span>
                                   <a href="#">Details</a>
                               </div>

                           </li>
                       </ul>
                   </div>-->


                </div>


            </div>
        </div>
    </div>
</div>