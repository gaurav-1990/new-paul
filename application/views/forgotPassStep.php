<?php
defined('BASEPATH') or exit('No direct script access allowed');
$id = $this->uri->segment('3');
?>
<style type="text/css">
    .fill {
        min-height: 100%;
        height: 100%;
    }
</style>
<div class="trand-bg">
    <div class="loged-in-part fill">

        <div class="container">
            <div class="col-md-12">
                <div class="loged-in-part-in">
                    <div class="logo-sec">

                        <h3>Forgot password ?</h3>
                    </div>
                    <div class="form-part">
                        <?= $this->session->flashdata('msg'); ?>
                        <?= form_open('Myaccount/updatePassword', array('id' => 'reset_pass', 'method' => 'POST', 'autocomplete' => 'off')) ?>

                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label> Password </label>
                                <input type="password" required="" name="password" id="password" class="form-control" placeholder="Password">  <!-- id="password" -->
                                <input type="hidden" name="key" value="<?= $id ?>" />  <?php // echo encode($this->encryption->encrypt($id)); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label> Password </label>
                                <input type="password" required="" name="cpass" id="cpass" class="form-control" placeholder="Re-enter Password">    <!-- id="frm02--password" -->

                            </div>
                        </div>

                        <br>


                        
                        <div class="row form-group">
                            <div class="col-sm-12  col-xs-12 col-md-12 form-group">
                                <div class="row">
                                <div class="col-sm-12  col-xs-12 col-md-12 form-group">
                                <button>SEND</button>
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

            "login[password]": {
                minlength: 6,
                required: true
            },
            "login[cpassword]": {

                required: true,
                equalTo: "#password"
            },

        },

        highlight: function(element) {
            $(element).parent().addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent().removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'validation-error-message help-block form-helper bold',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
</script>