<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">

                    <!-- Breadcrumb -->
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Signup</a>
                        </li>
                        <?php if ($this->session->userdata('signupSession')['role'] == 1) { ?>
                            <li>
                                <a href="<?= site_url('Admin/SadminLogin/profiles'); ?>">View</a>
                            </li>
                        <?php } ?>
                        <li class="active"><span>Edit Vendor</span></li>
                    </ol>
                    <!-- /Breadcrumb -->

                    <!-- Page header -->
                    <div class="page-header">

                        <h2 class="page-subtitle">
                            Edit Vendor Information
                        </h2>
                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>

    <?= $this->session->flashdata('msg'); ?>
    <div  class="panel panel-white">
        <?= form_open_multipart('Admin/SadminLogin/updateVendor', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'id' => 'sform2', 'method' => 'POST')); ?>
        <div  class="panel-body  pb">
            <div class="row">

                <div class="col-sm-3">
                    <label>Vendor Id</label>
                    <input type="text" id="vendor_id" value="<?= "SHP-VEN-00" . ($vendor->id) ?>" readonly="" name="vendor_id" class="form-control" placeholder="First Name">
                </div>

            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-3">
                    <label>First Name</label>
                    <input type="text" id="first_name"   value="<?= ($vendor->fname) ?>"  name="first_name" class="form-control" placeholder="First Name">
                </div>
                <div class="col-sm-3">
                    <label>Last Name</label>
                    <input type="text" id="last_name"   name="last_name" value="<?= ($vendor->lname) ?>"  class="form-control" placeholder="Last Name"   value=""  /> 
                </div>
                <?php if ($this->session->userdata('signupSession')['role'] == 1) { ?>
                    <div class="col-sm-3">
                        <label>Contact Number</label>
                        <input type="text" id="contact_no"   name="contact_no" value="<?= ($vendor->contactno) ?>"  class="form-control" placeholder="Contact Number"   value=""  /> 
                    </div>
                <?php } ?>
                <?php if ($this->session->userdata('signupSession')['role'] == 1) { ?>
                    <div class="col-sm-3">
                        <label>Email Address</label>
                        <input type="text" id="email_id"   name="email_id" value="<?= ($vendor->emailadd) ?>"  class="form-control" placeholder="Email Address"   value=""  /> 
                    </div>
                <?php } ?>
                <input type="hidden" name="hidden_id"  id="hidden_id" value="<?= encode($this->encryption->encrypt($vendor->id)) ?>" />
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">

                <div class="col-sm-3">
                    <label>Company</label>
                    <input type="text" id="company"    value="<?= ($vendor->company) ?>" name="company" class="form-control" placeholder="Company">
                </div>
                <div class="col-sm-3">
                    <label>State</label>
                    <select class="form-control" name="state" id="state">
                        <option value="">Select State</option>
                        <?= getState($vendor->state) ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>City</label>
                    <select class="form-control"   name="city" id="city">
                        <option value="<?= $vendor->city ?>"><?= $vendor->city ?></option>

                    </select>
                </div>
                <div class="col-sm-3">
                    <label>Pin Code</label>
                    <input type="text" id="zip"   name="zip" value="<?= ($vendor->zip) ?>"  class="form-control" placeholder="Pin Code"   value=""  /> 
                </div>
            </div>
        </div>
        <?php
        $vendor_read = $vendor->is_admin == 0 && $vendor->allow_product == 1 ? "readonly" : "";
        $vendor_disable = $vendor->is_admin == 0 && $vendor->allow_product == 1 ? "disabled" : "";
        ?>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-3">
                    <label>Bank Name</label>
                    <input type="text" id="bankname"  required="" <?= $vendor_read ?>  value="<?= ($vendor->bankname) ?>" name="bankname" class="form-control" placeholder="Bank Name">
                </div>
                <div class="col-sm-3">
                    <label>Bank Address</label>
                    <input type="text" id="bankadd"  required=""  <?= $vendor_read ?> value="<?= ($vendor->bankadd) ?>" name="bankadd" class="form-control" placeholder="Bank Adress">
                </div>
                <div class="col-sm-3">
                    <label>Holder Name</label>
                    <input type="text" id="holdername" required="" <?= $vendor_read ?> value="<?= ($vendor->holdername) ?>" name="holdername" class="form-control" placeholder="Holder Name">
                </div>
                <div class="col-sm-3">
                    <label>Account Number</label>
                    <input type="text" id="accountnum" required=""  <?= $vendor_read ?> value="<?= ($vendor->accountnum) ?>" name="accountnum" class="form-control" placeholder="Account Number">
                </div>


            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-3">
                    <label>IFSC</label>
                    <input type="text" id="ifsc" required=""  <?= $vendor_read ?> value="<?= ($vendor->ifsc) ?>" name="ifsc" class="form-control" placeholder="IFSC">
                </div>
                <div class="col-sm-3">
                    <label>Owner Address</label>
                    <textarea   id="address" name="address" <?= $vendor_read ?> class="form-control" placeholder="Address"><?= ($vendor->address) ?></textarea>
                </div>
                <div class="col-sm-3">
                    <label>Password</label>
                    <input type="password" class="no-display" value="<?= $vendor->passw ?>" name="dummy" id="dummy" >
                    <input type="password" id="new_password"  name="new_password"    class="form-control" placeholder="Password"   value="" autocomplete="new-password" /> 

                </div>
                <?php if ($this->session->userdata('signupSession')['role'] == 1) { ?>
                    <div class="col-sm-3">
                        <label>Pan no.</label>
                        <input type="text" readonly   id="pan_no" name="pan_no" value="<?= $vendor->pan ?>"   class="form-control" placeholder="Pan No."   value="" autocomplete="off" /> 
                    </div>
                <?php } ?>

            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-3">
                    <label>GST no.</label>
                    <input type="text" id="gst_no"   <?= $vendor_read ?> name="gst_no" value="<?= $vendor->gst ?>"  class="form-control" placeholder="GST No."   value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3">
                    <label>Nature Of Business</label>
                    <select <?= $vendor_disable ?> name="nature_business" required="" class="form-control" id="nature_business">
                        <option <?= $vendor->nature_business == "" ? "selected " : "" ?> value="">Select Type</option>
                        <option <?= $vendor->nature_business == "Distributor" ? "selected " : "" ?> value="Distributor">Distributor</option>
                        <option <?= $vendor->nature_business == "Manufacture" ? "selected " : "" ?> value="Manufacture">Manufacture</option>
                        <option <?= $vendor->nature_business == "Retailer" ? "selected " : "" ?>value="Retailer">Retailer</option>
                        <option  <?= $vendor->nature_business == "Brand Owner" ? "selected " : "" ?>value="Brand Owner">Brand Owner</option>
                    </select>
                </div>
                 <div class="col-sm-3">
                    <label>Order Pick Up  Address</label>
                    <textarea   id="ship_address" name="ship_address"  class="form-control" placeholder="Order Pick Up Address"><?= ($vendor->ship_address) ?></textarea>
                </div>


            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-2 col-md-3">
                    <label>Upload Address Proof *</label>
                    <input type="file" id="add_proof" name="add_proof" <?= $vendor_disable ?>     class="form-control"    value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-2 col-md-3">
                    <label>Upload Pan Number *</label>
                    <input type="file" id="pan_number" name="pan_number"  <?= $vendor_disable ?>  class="form-control"   value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-2 col-md-3">
                    <label>Upload Profile Pic *</label>
                    <input type="file" id="profile_pic" name="profile_pic" <?= $vendor_disable ?>     class="form-control"   value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-2 col-md-3">
                    <label>Upload GST Doc *</label>
                    <input type="file" id="gst_doc" name="gst_doc"  <?= $vendor_disable ?>   class="form-control"    value="" autocomplete="off" /> 
                </div>
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-2 col-md-3">
                    <label>Upload Signature </label>
                    <input type="file" id="signature" name="signature" <?= $vendor_disable ?>    class="form-control"    value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-2 col-md-3">
                    <label>Upload Cancel Cheque</label>
                    <input type="file" id="can_cheque" name="can_cheque"  <?= $vendor_disable ?>  class="form-control"   value="" autocomplete="off" /> 
                </div>

            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-2 col-md-3">
                    <?php if ($vendor->addProof) { ?>
                        <a href="<?= base_url('uploads/addressProof/') . $vendor->addProof ?>" target="_blank" title="Address Proof">Address Proof</a>
                    <?php } ?>
                </div>
                <div class="col-sm-2 col-md-3">
                    <?php if ($vendor->panCard) { ?>
                        <a href="<?= base_url('uploads/panCard/') . $vendor->panCard ?>"  target="_blank" title="Pan Card">Pan Card</a>
                    <?php } ?>
                </div>
                <div class="col-sm-2 col-md-3">
                    <?php if ($vendor->profilePic) { ?>
                        <a href="<?= base_url('uploads/profilePic/') . $vendor->profilePic ?>" target="_blank" title="Profile Pic">Profile Pic</a>
                    <?php } ?>
                </div>
                <div class="col-sm-2 col-md-3">
                    <?php if ($vendor->gstDoc) { ?>
                        <a href="<?= base_url('uploads/gstDoc/') . $vendor->gstDoc ?>" target="_blank" title="GST Doc">GST Doc</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-2 col-md-3">
                    <?php if ($vendor->signature) { ?>
                        <a href="<?= base_url('uploads/signature/') . $vendor->signature ?>" target="_blank" title="Signature">Signature</a>
                    <?php } ?>
                </div>
                <div class="col-sm-2 col-md-3">
                    <?php if ($vendor->cancelCheck) { ?>
                        <a href="<?= base_url('uploads/cancelCheck/') . $vendor->cancelCheck ?>"  target="_blank" title="Cancel Cheque">Cancel Cheque</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class=" col-sm-4">
                    <button type="submit" class="btn btn-default"> Save Profile </button>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</main>
