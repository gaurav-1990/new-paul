<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="trand-bg ">
    <div class="loged-in-part ">



        <div class="loged-in-part-in">
            <div class="logo-sec">

                <h3>Login to Paulsons</h3>
                <!-- <h4>Easily Using</h4>
                <div class="social-login">
                    <button class="fb-btn" onclick="window.location.href = '<?php echo $this->facebook->login_url(); ?>';"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</button>
                    <button class="gp-btn" onclick="window.location.href = '<?= $google_login_url ?>';"><i class="fa fa-google" aria-hidden="true"></i> Google</button>
                </div> -->

            </div>
            <?php
            $url = "Myaccount";
            $signUp = "Myaccount/newUser";
            $forgot = "Myaccount/forgotPassword";
            if ($this->input->get("Step") === 'checkout') {
                $url = "Myaccount?Step=checkout";
                $signUp = "Myaccount/newUser?Step=checkout";
                $forgot = "Myaccount/forgotPassword?Step=checkout";
            }
            if ($this->input->get("Step") === 'wish') {
                $url = "Myaccount?Step=wish&id={$this->input->get("id")}";
                $signUp = "Myaccount/newUser?Step=wish&id={$this->input->get("id")}";
                $forgot = "Myaccount/forgotPassword?Step=wish&id={$this->input->get("id")}";
            }
            if ($this->input->get("Step") === 'subscription') {
                $url = "Myaccount?Step=subscription";
                $signUp = "Myaccount/newUser?Step=subscription";
                $forgot = "Myaccount/forgotPassword?Step=subscription";
            }

            ?>
            <div class="form-part">
                <!-- <h4>- OR USING EMAIL -</h4> -->
                <?= $this->session->flashdata('msg'); ?>
                <?= form_open($url, array('id' => 'sform', 'method' => 'POST', 'autocomplete' => 'off')) ?>

                <div class="row">
                    <div class="col-sm-12 form-group">

                        <input type="text" id="frm02--email" name="login[username]" class="form-control" placeholder="Username">
                        <?php echo form_error('login[username]'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">

                        <input type="password" class="no-display" style="display: none" name="dummy" id="dummy">
                        <input type="password" id="login" name="login[password]" class="form-control" placeholder="Password" value="" autocomplete="new-password" />
                        <?php echo form_error('login[password]'); ?>
                    </div>
                </div>
                <br>
                <div class="row form-group">
                    <div class="col-sm-12  col-xs-12 col-md-12 form-group">
                        <div class="row">
                            <div class="col-sm-12  col-xs-12 col-md-12 form-group">

                                <button>SIGN IN</button>
                            </div>
                            <div class="col-sm-6 text-left col-xs-6 col-md-6 form-group">
                                <a class="" href="<?= site_url($forgot) ?>">Forgot Password?</a>
                            </div>

                            <div class="col-sm-6  text-right col-xs-6 col-md-6 form-group">
                                <a href="<?= site_url($signUp) ?>">Click here for registration</a>
                            </div>

                        </div>
                    </div>

                </div>
                <?= form_close(); ?>

            </div>
        </div>






    </div>
</div>