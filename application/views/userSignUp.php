<?php
$actual_link = current_url();
$params   = $_SERVER['QUERY_STRING']; //my_id=1,3
$fullURL = $actual_link . '?' . $params;
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="trand-bg  ">
    <div class="loged-in-part">
        <?php
$url = "Myaccount/newUser";
$login = "Myaccount";
if ($this->input->get("Step") == 'checkout') {
    $url = "Myaccount/newUser?Step=checkout";
    $login = "Myaccount?Step=checkout";
}
?>


        <div class="loged-in-part-in">


            <div class="logo-sec">
                <h3>Create Account</h3>
                <!-- <h4>Easily Using</h4> -->
                <div class="social-login">
                    <!--<button class="fb-btn" onclick="window.location.href = '<?php echo $this->facebook->login_url(); ?>';"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</button>-->
                    <!-- <button class="gp-btn" onclick="window.location.href = '<?php echo $google_login_url ?>';"><i class="fa fa-google" aria-hidden="true"></i> Google</button> -->
                </div>
            </div>
            <div class="form-part">


                <?=form_open($url, array('id' => 'sform', 'method' => 'POST', 'autocomplete' => 'off'))?>
                <div class="row">
                    <div class="col-sm-12 form-group">

                        <input type="text" id="email" name="login[username]" value="<?=set_value("login[username]")?>" class="form-control" placeholder="Email">
                        <?php echo form_error('login[username]'); ?>
                    </div>
                    <div class="col-sm-12 form-group">

                        <input type="password" class="no-display" style="display: none" name="dummy" id="dummy">
                        <input type="password" id="pass" name="login[password]" class="form-control" placeholder="Password (At least 6 characters)" value="" autocomplete="new-password" />
                        <?php echo form_error('login[password]'); ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type="password" id="cpass" name="login[cpassword]" class="form-control" placeholder="Confirm Password" value="" autocomplete="new-password" />
                        <?php echo form_error('login[cpassword]'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">

                        <input type="text" id="full_name" name="login[fullname]" value="<?=set_value("login[fullname]")?>" class="form-control" placeholder="First Name">
                        <?php echo form_error('login[fullname]'); ?>
                    </div>
                    <div class="col-sm-12 form-group">

                        <input type="text" id="last_name" name="login[lastname]" value="<?=set_value("login[lastname]")?>" class="form-control" placeholder="Last Name">
                        <?php echo form_error('login[lastname]'); ?>
                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-12 form-group">

                        <input type="text" id="" name="contact" value="<?=set_value("contact")?>" class="form-control" placeholder="Contact Number">
                        <?php echo form_error('contact'); ?>
                    </div>
                </div>



                <div class="switch-field">
                      <input type="radio" id="radio-one" name="switch-one" checked value="Female" />
                    <label for="radio-one">Female</label>
                    <input type="radio" id="radio-two" name="switch-one"  value="Male" />
                    <label for="radio-two">Male</label>


                </div>

                <input type="hidden" name="url" value="<?= $fullURL ?>">

                <br>
                <div class="row form-group">
                    <div class="col-sm-12  col-xs-12 col-md-12 form-group">
                        <div class="row">
                            <div class="col-sm-12  col-xs-12 col-md-12 form-group">

                                <button id="create_account">Create your paulsons account</button>
                            </div>

                        </div>

                    </div>
                    <div class="col-sm-6 text-left col-xs-6 col-md-6 form-group">
                                <a class="" href="<?=base_url("Myaccount")?>">Already a member?</a>
                            </div>

                </div>
                <?=form_close();?>
            </div>

        </div>



    </div>
</div>

</body>

</html>