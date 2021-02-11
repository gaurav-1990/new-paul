<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="trand-bg">
    <div class="loged-in-part ">
        <div class="container"> 
            <?php $this->session->flashdata('msg'); ?>
            <div class="col-md-5">
                <div class="loged-in-part-in">
                   <div class="logo-sec">

                        <h3>Create Your Seller Account</h3>
                        <h4>Easily Using</h4>
                        <div class="social-login">
                            <button class="fb-btn"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</button>
                            <button class="gp-btn"><i class="fa fa-google" aria-hidden="true"></i> Google</button>
                        </div>
                        
                    </div>

                    <div class="col-lg-12 form-part">
                        <div class="row">
                            <?= form_open('Signup/registrationStep', array('id' => 'sform', 'method' => 'POST', 'autocomplete' => 'off')) ?>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>First Name*</label>
                                        <input type="text" autocomplete="off" name="fname" placeholder="First Name Here.." class="form-control">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Last Name*</label>
                                        <input type="text" autocomplete="off" name="lname" placeholder="Last Name Here.." class="form-control">
                                    </div>
                                </div>					

                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Phone No*</label>
                                        <input type="text" autocomplete="off" name="contact_no" placeholder="Contact Number" class="form-control">
                                    </div>		
                                    <div class="col-sm-6 form-group">
                                        <label>Email Address* </label>
                                        <input type="text" autocomplete="off" name="email"  placeholder="Your Email Address" class="form-control">
                                    </div>	
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Password*</label>
                                        <input type="password" class="no-display" style="display: none" name="dummy" id="dummy" >
                                        <input type="password" autocomplete="off"  name="signup[password]" id="password"   placeholder="Password" class="form-control">
                                    </div>		
                                    <div class="col-sm-6 form-group">
                                        <label>Confirm Password* </label>
                                        <input type="password" autocomplete="off" name="signup[re_password]" id="rpassword"   placeholder="Re-enter Password" class="form-control">
                                    </div>	
                                </div>	
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text"  autocomplete="off" name="compname" placeholder="Company Name Here.." class="form-control">
                                </div>		
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label for="country">State*</label>
                                        <select autocomplete="off" class="form-control" name="state" id="state">
                                            <?php
                                            foreach ($state as $key => $value) {
                                                echo "<option value='$value->StateName'>$value->StateName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>	
                                    <div class="col-sm-4 form-group">
                                        <label for="country">City*</label>
                                        <select autocomplete="off" class="form-control" name="city" id="city">
                                            <option value=""> Select City</option>
                                        </select>
                                    </div>		
                                    <div class="col-sm-4 form-group">
                                        <label for="country">Zip Code*</label>
                                        <input autocomplete="off" type="text" name="zip" placeholder="Zip Code" class="form-control">
                                    </div>			
                                </div>
                                <div class="form-group">
                                    <label>Address*</label>
                                    <textarea autocomplete="off" name="address" placeholder="Address Here.." rows="3" class="form-control"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label>PAN No*</label>
                                        <input type="text" placeholder="PAN No." name="pan" autocomplete="off" class="form-control">
                                    </div>	

                                    <div class="col-sm-4 form-group">
                                        <label>GST No.*</label>
                                        <input type="text" autocomplete="off" required="" name="gst"  placeholder="GST No." class="form-control">
                                    </div>		

                                </div>

                                <div class="row">

                                    <div class="col-md-12">
                                        <input class="form-check-input" required="" type="checkbox" name="term" id="term">
                                        <label class="form-check-label" for="gridCheck">
                                            I accept all the 
                                        </label>
                                        <a target="_blank" href="<?= base_url('Vendor_policy') ?>">Terms and Conditions</a>
                                        <label>
                                            Already have an account? <a class="text-danger" href="<?= base_url('Admin/Loginvendor') ?>">Sign in</a>
                                        </label>
                                    </div>

                                </div>
                                <div class="row ">
                                    <div class=" col-md-8  col-sm-offset-2">
                                        <input type="submit" value="Become A Seller" class="center-block btn   btn-block btn-warning ">
                                    </div>
                                </div>
                            </div>
                            </form> 
                        </div>
                    </div>

                </div>  
            </div>

            <div class="col-md-7">
                <div class="sign-up-side">
<!--                    <img src="<?= base_url() ?>assets/images/coming.png" style="margin-top: -63px;     width: 76%;" alt=""/>-->
                    <div class="logo-tg">
                        <img src="<?= base_url() ?>bootstrap/images/shp.png" alt=""/>

                    </div>
                    <div class="cont-set">
                        <h3>For Vendors Support</h3>
                        <a href="tel:+91 97160-90101"> <b>Call Us:</b>  +91 97160-90101</a>
                        <a href="mailto:hello@paulsonsonline.com"> <b>Mail Us:</b>  hello@paulsonsonline.com </a> <br>

                        <a href="https://www.kaezanddolls.com/FAQ_vendor" target="blank" style="
                           color: #000;
                           font-size: 13px;
                           text-decoration: underline;
                           ">FAQ'S Vendor</a>
                        <a href="https://www.kaezanddolls.com/index.php?/Annexure" target="blank" style="
                           color: #000;
                           font-size: 13px;
                           text-decoration: underline;
                           ">Annexure I</a>
                    </div>


                </div>
            </div>

        </div>
    </div>    
</div>

</body>
</html>

<script src="<?= base_url() ?>bootstrap/vendor/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>bootstrap/vendor/bootstrap/js/popper.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>bootstrap/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>bootstrap/vendor/jquery/jquery.validate.js" type="text/javascript"></script>
<script src="<?= base_url() ?>bootstrap/vendor/customs/custom.js" type="text/javascript"></script>

<script type="text/javascript">
    $('#sform').validate({
        rules: {
            fname: {
                minlength: 3,
                required: true
            },
            lname: {
                minlength: 3,
                required: true
            },
            term: {

                required: true
            },
            contact_no: {
                minlength: 10,
                maxlength: 10,
                number: true,
                required: true,
                remote: "<?= site_url("Signup/checkContact"); ?>"
            },
            'signup[password]':
                    {
                        minlength: 5,
                        required: true,
                    },
            'signup[re_password]':
                    {
                        minlength: 5,
                        required: true,
                        equalTo: "#password"
                    },
            email: {
                required: true,
                email: true,
                remote: "<?= site_url("Signup/checkEmail"); ?>"
            },
            compname: {
                minlength: 3
            },
            zip: {
                required: true,
                number: true,
                maxlength: 6,
                minlength: 5
            },
            address: {
                required: true,
                minlength: 5
            },
            pan: {
                required: true,
                pancard: true,
                remote: "<?= site_url("Signup/checkPan"); ?>"
            }, term: {
                required: true
            }

        },
        messages: {
            contact_no: {
                remote: "Already in use"
            },
            email: {
                remote: "Already in use"
            },
            pan: {
                remote: "Already in use"
            }
        },
        highlight: function (element) {
            $(element).parent().addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'validation-error-message help-block form-helper bold',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
</script>
