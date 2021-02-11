<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><style type="text/css">
    .fill { 
        min-height: 100%;
        height: 100%;
    } 
</style>
<div class="trand-bg fill">
    <div class="loged-in-part ">

        <div class="container align-center"> 

            <div class="col-md-5">

                <div class="loged-in-part-in">
                    <div class="logo-sec">
                        <?= $this->session->flashdata('msg'); ?>
                        <h3>Please enter both OTP to verify your account</h3>
                    </div>

                    <div class="col-lg-12 form-part">
                        <div class="row">
                            <?= form_open('Signup/otpVerifyStep/' . $this->uri->segment(3), array('id' => 'sform', 'method' => 'POST', 'autocomplete' => 'off')) ?>

                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Email OTP*</label>
                                    <input type="text" autocomplete="off" name="email_otp" placeholder="Email OTP Here" class="form-control">
                                </div>
                            </div>					
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Mobile OTP*</label>
                                    <input type="text" autocomplete="off" name="mobile_otp" placeholder="Mobile OTP Here" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="otp" value="<?= $this->uri->segment(3); ?>" />
                            <br>
                            <div class="row ">
                                <div class=" col-md-4 ">
                                    <input type="submit" value="Verify" class="center-block btn   btn-block btn-danger ">
                                </div>
                            </div>
                            </form> 
                        </div>
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
            email_otp: {
                minlength: 3,
                required: true,
                number: true
            },
            mobile_otp: {
                minlength: 3,
                required: true,
                number: true
            },
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
