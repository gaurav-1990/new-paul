<div class="profile-container">
    <div class="container">
        <div class="profile-container-in">
            <div class="header-user">
                <div class="hd-name">
                    Account
                </div>
                <span> <?php
                    ?> </span>

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
                            <a href="<?= base_url('Checkout/myCoupon') ?>">
                                Coupons
                            </a>
                            <!-- <a href="#">
                                PhonePe Wallet
                            </a> -->
                            <a href="<?= base_url('Checkout/myWallet') ?>">
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
                            <a href="<?= base_url('Myaccount/editProfile') ?>" class="active">
                                Profile
                            </a>
                            <a href="<?= base_url('Checkout/myAddress') ?>">
                                Address
                            </a>
                            <!-- <a href="#">
                                Saved Cards
                            </a> -->
                            <!-- <a href="#">
                                paulsons Insider
                            </a> -->
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
                <?php   
                     $res = getUserByEmail($this->session->userdata('myaccount'));
                     $date3 = $res->bir_year . "-" . $res->bir_month . "-" . $res->bir_day;
                     $date4 = $res->ann_year . "-" . $res->ann_month . "-" . $res->ann_day;
                
                ?>
                    <div class="edit-profile">
                        <?= validation_errors(); ?>
                        <div class="edit-profile-in">
                            <?= form_open_multipart('Myaccount/editProfile', array('id' => 'editProfileForm', 'method' => 'POST', 'autocomplete' => 'off')) ?>
                            <form id="editProfileForm" action="">
                                <div class="row">
                                    <h3>Account Details </h3>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group required">
                                            <label for="" class="control-label">
                                                Email Id
                                            </label>
                                            <input readonly type="email" name="email" class="form-control" required
                                                   value="<?= $res->user_email ?>"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group required">
                                            <label for="" class="control-label">
                                                Password
                                            </label>
                                            <a href="#" class="edit-pass" data-toggle="modal" data-target="#myModal22"
                                               onclick="" class="btn btn-warning btn-xs  ">Change Password</a>
                                            <input type="password" class="form-control" disabled value="*******"/>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <h3>General Information</h3>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group required">
                                            <label for="" class="control-label">
                                                First Name
                                            </label>
                                            <input type="text" required name="fname" class="form-control"
                                                   value="<?= $res->user_name ?>"/>
                                            <?php echo form_error('fname'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group ">
                                            <label for="">
                                                Last Name
                                            </label>
                                            <input type="text" required name="lname" class="form-control"
                                                   value="<?= $res->lastname ?>"/>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-4 col-xs-4">
                                        <div class="form-group ">
                                            <label for="">
                                                Date of birth
                                            </label>
                                            <select class="form-control" name="Bday" required>
                                                <option
                                                        value="<?= (isset($res->bir_day) && $res->bir_day != NULL) ? $res->bir_day : "" ?>">
                                                    <?= (isset($res->bir_day) && $res->bir_day != NULL) ? $res->bir_day : "Enter Day" ?>
                                                </option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    echo "<option value='$i'>$i</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-4">
                                        <div class="form-group ">
                                            <label for="">
                                                &nbsp
                                            </label>
                                            <select class="form-control" name="Bmonth">
                                                <option
                                                        value="<?= (isset($res->bir_month) && $res->bir_month != NULL) ? $res->bir_month : "" ?>">
                                                    <?= (isset($res->bir_month) && $res->bir_month != NULL) ? date("F", strtotime($date3)) : "Enter Month" ?>
                                                </option>
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-4">
                                        <div class="form-group ">
                                            <label for="">
                                                &nbsp
                                            </label>
                                            <select class="form-control" name="Byear">
                                                <option
                                                        value="<?= (isset($res->bir_year) && $res->bir_year != NULL) ? $res->bir_year : "" ?>">
                                                    <?= (isset($res->bir_year) && $res->bir_year != NULL) ? $res->bir_year : "Enter Year" ?>
                                                </option>
                                                <?php
                                                for ($i = 2019; $i >= 1901; $i--) {
                                                    echo "<option value='$i'>$i</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-4 col-xs-4">
                                        <div class="form-group ">
                                            <label for="">
                                                Anniversary Date
                                            </label>
                                            <select class="form-control" name="Aday">
                                                <option
                                                        value="<?= (isset($res->ann_day) && $res->ann_day != NULL) ? $res->ann_day : "" ?>">
                                                    <?= (isset($res->ann_day) && $res->ann_day != NULL) ? $res->ann_day : "Enter Day" ?>
                                                </option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    echo "<option value='$i'>$i</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-4">
                                        <div class="form-group ">
                                            <label for="">
                                                &nbsp
                                            </label>
                                            <select class="form-control" name="Amonth">
                                                <option
                                                        value="<?= (isset($res->ann_month) && $res->ann_month != NULL) ? $res->ann_month : "" ?>">
                                                    <?= (isset($res->ann_month) && $res->ann_month != NULL) ? date("F", strtotime($date4)) : "Enter Month" ?>
                                                </option>
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-4">
                                        <div class="form-group ">
                                            <label for="">
                                                &nbsp
                                            </label>
                                            <select class="form-control" name="Ayear">
                                                <option
                                                        value="<?= (isset($res->ann_year) && $res->ann_year != NULL) ? $res->ann_year : "" ?>">
                                                    <?= (isset($res->ann_year) && $res->ann_year != NULL) ? $res->ann_year : "Enter Year" ?>
                                                </option>
                                                <?php
                                                for ($i = 2019; $i >= 1901; $i--) {
                                                    echo "<option value='$i'>$i</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group required">
                                            <label for="" class="control-label">
                                                Mobile Number
                                            </label>
                                            <input type="text" name="mobile" class="form-control"
                                                   value="<?= (isset($res->user_contact) && $res->user_contact != NULL) ? $res->user_contact : "" ?>"
                                                   placeholder="<?= (isset($res->user_contact) && $res->user_contact != NULL) ? $res->user_contact : "Enter Mobile" ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group ">
                                            <label for="" class="control-label">Your bio</label>
                                            <textarea class="form-control" name="bio" rows="5"
                                                      id="comment"><?= (isset($res->bio) && $res->bio != NULL) ? $res->bio : "" ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group ">
                                            <label for="">
                                                Location
                                            </label>
                                            <input type="text" name="location" class="form-control"
                                                   value="<?= (isset($res->location) && $res->location != NULL) ? $res->location : "" ?>"
                                                   placeholder="<?= (isset($res->location) && $res->location != NULL) ? $res->location : "Enter Location" ?>"/>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Gender</label>
                                    </div>

                                    <div class="col-md-2 col-xs-4">
                                        <div class="form-group required">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" required class="custom-control-input" value="Male"
                                                    <?= (isset($res->gender) && $res->gender == 'Male') ? 'checked' : '' ?>
                                                       id="defaultChecked28" name="gender">
                                                <label class="custom-control-label" for="defaultChecked28">Male</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-4">
                                        <div class="form-group ">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" required class="custom-control-input" value="Female"
                                                    <?= (isset($res->gender) && $res->gender == 'Female') ? 'checked' : '' ?>
                                                       id="defaultChecked29" name="gender">
                                                <label class="custom-control-label"
                                                       for="defaultChecked29">Female</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-xs-6">
                                        <div class="form-group ">
                                            <div>
                                                <input type="file" name="profilePhoto">
                                                <label class="label">Upload Profile Pic</label>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">

                                    <div class="col-md-4 col-xs-5">
                                        <div class="form-group ">
                                            <button class="cancel-bt">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-5">
                                        <div class="form-group ">
                                            <button class="save-bt">
                                                Save
                                            </button>
                                        </div>
                                    </div>


                                </div>

                            </form>

                            <div class="profile-detail-show">
                                <?= $this->session->flashdata('msg'); ?>
                                <?= $this->session->flashdata('error'); ?>
                                <div class="tb-hd">Primary Information</div>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="title">First Name</td>
                                        <td><?= $res->user_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="title">Last Name</td>
                                        <td><?= $res->lastname ?></td>
                                    </tr>
                                    <tr>
                                        <td class="title">Gender</td>
                                        <td><?= $res->gender ?></td>
                                    </tr>
                                    <tr>
                                        <td class="title">Date of birth </td>
                                        <td><?= ($res->bir_day != '') ? date("jS F, Y", strtotime($res->bir_day . "-" . $res->bir_month . "-" . $res->bir_year)) : '' ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="title">Mobile Number</td>
                                        <td><?= $res->user_contact ?></td>
                                    </tr>
                                    <tr>
                                        <td class="title">location</td>
                                        <td><?= $res->location ?></td>
                                    </tr>
                                    <tr>
                                        <td class="title">E-mail id</td>
                                        <td><?= $res->user_email ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <button
                                        onclick="$('#editProfileForm').show();$('.profile-detail-show').hide();">EDIT
                                </button>
                            </div>


                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="view-similar modal right fade" id="myModal22" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h4 class="modal-title" id="myModalLabel2">CHANGE PASSWORD</h4>
            </div>
            <div class="modal-body">
                <div class="loged-in-part-in">
                    <div class="form-part">
                        <?= $this->session->flashdata('msg'); ?>
                        <?= form_open("Myaccount/userSetPassword", array('id' => 'sform', 'method' => 'POST', 'autocomplete' => 'off')) ?>

                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="" class="control-label"> New Password </label>
                                <input type="password" id="login" required name="new_password" class="form-control"
                                       placeholder="New Password" value="" autocomplete="new"/>
                                <?php echo form_error('new_password'); ?>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="" class="control-label"> Confirm Password </label>
                                <input type="password" id="login" required name="confirm" class="form-control"
                                       placeholder="Confirm Password" value="" autocomplete="confirm"/>
                                <?php echo form_error('confirm'); ?>
                            </div>
                        </div>
                        <br>
                        <div class="row ">
                            <div class="col-sm-12  col-xs-12 col-md-12 ">
                                <div class="row ">
                                    <div class="col-md-4 col-xs-6 p-1">
                                        <a  style="background: #e2d5d5; padding: 13px 0px;  height: inherit;" onclick="$('#myModal22').modal('hide')"
                                           class="btn btn-sm cancel-bt changeCancle">
                                            Cancel
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <button class="save-bt changePass">
                                            Save
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <?= form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>