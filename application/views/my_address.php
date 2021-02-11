<?php
// echo "<pre>";
// print_r($address[0]->user_id);
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
                            <a href="<?= base_url('Myaccount/dashboard')?>">
                                Overview
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Order</div>
                        <li>
                            <a href="<?=base_url("Myaccount/orderDetails")?>">
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
                            <!-- <a href="#">
                                PhonePe Wallet
                            </a> -->
                            <a href="<?=base_url('Checkout/myWallet')?>">
                                paulsons Wallet
                            </a>
                            <!-- <a href="#">
                                paulsons Points
                            </a> -->
                        </li>
                    </ul>
                    <ul>
                        <div class="cat-hd">Account</div>
                        <li>
                            <a href="<?= base_url('Myaccount/editProfile')?>">
                                Profile
                            </a>
                            <a href="<?=base_url('Checkout/myAddress')?>"  class="active">
                                Address
                            </a>
                            <!-- <a href="#">
                                Saved Cards
                            </a> -->
                            <!-- <a href="#">
                                paulsons Insider
                            </a> -->
                            <?php
                        //     $res = getUserByEmail($this->session->userdata('myaccount'));                       
                        //     $date3 = $res->bir_year."-".$res->bir_month."-".$res->bir_day;
                        //     $date4 = $res->ann_year."-".$res->ann_month."-".$res->ann_day;   
                        //     // $diff = abs(strtotime(date("Y-m-d")) - strtotime($res->prime_date));

                        //     $date1 = date_create(date("Y-m-d"));

                        //     $date2 = date_create($res->prime_date);

                        //     $diff = date_diff($date1, $date2);

                            
                        //    $rem_days = floatval(loadSubcription()->subscription_form) - $diff->days;
                          
                        //     if ($rem_days == 0) {
                        //         $result = getUpdatePrime($this->session->userdata('myaccount'));
                        //     }
                        //     $res = getUserByEmail($this->session->userdata('myaccount'));
                        //     if ($res->is_prime == 1) {
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
                    <?php if($address != NULL){ 
                        
                    ?>
                    <div class="profile-address">
                        <div class="heading-add">
                            <h3>Saved Addresses</h3>
                            <button data-toggle="modal" data-target="#addnew-address">Add New Address</button>
                        </div>
                        <h2>DEFAULT ADDRESS</h2>
                        <div class=" edit-address">
                        <ul>
                        <?php 
                        foreach ($address as $addr) {
                        ?>
                            <li>
                                <div class="address-sh">
                           
                                    <p><b><?= ucwords($addr->fname).' '.ucwords($addr->lname)?></b></p>
                                    <p><?= ucwords($addr->address)?></p>
                                    <p><?= ucwords($addr->locality)?></p>                                   
                                                                      
                                    <p><?=$addr->pin_code?></br></p>
                                    <p><?= ucwords($addr->city)?></p> 
                                    <p>Mobile: <?=$addr->phone?></p>

                                </div>

                                <div class="add-type">
                                   <?= ucwords($addr->type) ?>
                                </div>

                                <!-- <div class="address-rmv">
                                    <button style="border-right: #d2d2d2 1px solid; ">EDIT</button>
                                    <button>REMOVE</button>
                                </div> -->
                                <div class="remove-edit address-rmv">
                                    <button data-id="<?= encode($this->encryption->encrypt($addr->id)) ?>">Remove </button>
                                    <button data-id="<?= encode($this->encryption->encrypt($addr->id)) ?>">Edit</button>

                                 </div>

                            </li>
                        <?php } ?>
                        </ul>
                        </div>
                    </div>

                </div>
                <?php }else{ ?>
                    <div class="profile-address">
                        <div class="heading-add">
                            <h3>Saved Addresses</h3>
                            <button data-toggle="modal" data-target="#addnew-address">Add New Address</button>
                        </div>
                    </div>
                    <!-- <h2>No ADDRESS</h2> -->
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1 -->
<div id="add-address" class="modal fade address-model" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ADD NEW ADDRESS</h4>
            </div>

            <form method="POST" action="<?= base_url("Checkout/myAddress") ?>">
                <div class="modal-body">
                    <div class="page-wrap">


                        <div class="styled-input">
                            <input name="fname" id="fname" value="<?= ($address != NULL) ? $address[0]->fname : '' ?>" type="text" required />
                            <label> Name</label>
                        </div>


                        <div class="styled-input">
                            <input name="phone" id="phone" value="<?= ($address != NULL) ? $address[0]->phone : ''  ?>" type="tel" required />
                            <label>Mobile</label>
                        </div>
                        <div class="styled-input2">
                            <input name="pincode" id="pincode" value="<?= ($address != NULL) ? $address[0]->pin_code : ''  ?>" type="pin" required />
                            <label>Pin Code</label>

                        </div>
                        <div class="styled-input2">
                            <input name="state" id="state" value="<?= ($address != NULL) ? $address[0]->state : ''  ?>" type="text" required />
                            <label>State</label>

                        </div>
                        <div class="styled-input">
                            <input name="address" value="<?= ($address != NULL) ? $address[0]->address : ''  ?>" id="address" type="text" required />
                            <label>Address (House No, Building, Street, Area) *</label>

                        </div>
                        <div class="styled-input">
                            <input name="locality" value="<?= ($address != NULL) ? $address[0]->locality : ''  ?>" id="locality" type="text" required />
                            <label>Locality / Town *</label>

                        </div>
                        <div class="styled-input">
                            <input name="city" id="city" value="<?= ($address != NULL) ? $address[0]->city : ''  ?>" type="text" required />
                            <label>City / District *</label>

                        </div>
                        <div class="styled-input3">
                            <h3>Type of Address *</h3>
                            <div class="styled-input3-in">
                                <label class="radio">Home
                                    <input type="radio" value="home" checked="checked" id="address_type" name="address_type">
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



<!-- Modal 2 -->
<div id="addnew-address" class="modal fade address-model" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ADD NEW ADDRESS</h4>
            </div>

            <form method="POST" action="<?= base_url("Checkout/mynew_address") ?>">
                <div class="modal-body">
                    <div class="page-wrap">


                        <div class="styled-input">
                            <input name="fname" id="fname" type="text" required />
                            <label> Name</label>
                        </div>


                        <div class="styled-input">
                            <input name="phone" id="phone" type="tel" required />
                            <label>Mobile</label>
                        </div>
                        <div class="styled-input2">
                            <input name="pincode" id="pincode" type="pin" required />
                            <label>Pin Code</label>

                        </div>
                        <div class="styled-input2">
                            <input name="state" id="state" type="text" required />
                            <label>State</label>

                        </div>
                        <div class="styled-input">
                            <input name="address" id="address" type="text" required />
                            <label>Address (House No, Building, Street, Area) *</label>

                        </div>
                        <div class="styled-input">
                            <input name="locality" id="locality" type="text" required />
                            <label>Locality / Town *</label>

                        </div>
                        <div class="styled-input">
                            <input name="city" id="city" type="text" required />
                            <label>City / District *</label>

                        </div>
                        <div class="styled-input3">
                            <h3>Type of Address *</h3>
                            <div class="styled-input3-in">
                                <label class="radio">Home
                                    <input type="radio" value="home" checked="checked" id="address_type" name="address_type">
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

                        <!-- <div class="styled-input">
                            <input type ="hidden" value=<?= encode($this->encryption->encrypt($address[0]->user_id))?> name="add_id" />
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