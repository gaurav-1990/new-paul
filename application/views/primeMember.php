<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="trand-bg  ">
    <div class="loged-in-part">
        <div class="top-sign-hd">
            <div class="container"> 
                <a href="<?= base_url("Myaccount") ?>"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Sign in</a>
            </div>
        </div>
        <div class="container"> 
            <div class="col-md-12">
                <div class="loged-in-part-in">                
                    <div class="logo-sec">
                        <?= $this->session->flashdata('msg'); ?>
                        <h3>Be A Prime Member </h3> <span>INR <?= isset($primeAmt->amount) ? $primeAmt->amount : '999' ?> per month</span>
                    </div>

                    <div class="form-part">
                        <?php
                        if ($this->session->userdata('myaccount') == NULL && $this->session->userdata('app_id') == NULL) {
                            ?>
                            <?php
                            $url = "Prime";
                            if ($this->uri->segment(3) == 'StepCheckOut') {
                                $url = "Myaccount/newUser/StepCheckOut#Step1";
                            }
                            ?>
                            <?= form_open($url, array('id' => 'sform', 'method' => 'POST', 'autocomplete' => 'off')) ?>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <input type="text" id="full_name" name="login[fullname]" value="<?= set_value("login[fullname]") ?>" class="form-control" placeholder="First Name">
                                    <?php echo form_error('login[fullname]'); ?>
                                </div>
                                <div class="col-sm-12 form-group">

                                    <input type="text" id="last_name" name="login[lastname]"   value="<?= set_value("login[lastname]") ?>"  class="form-control" placeholder="Last Name">
                                    <?php echo form_error('login[lastname]'); ?>
                                </div>
                                <div class="col-sm-12 form-group">

                                    <input type="text" id="email" name="login[username]" value="<?= set_value("login[username]") ?>" class="form-control" placeholder="Email">
                                    <?php echo form_error('login[username]'); ?>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12 form-group">

                                    <input type="text" id="" name="contact" value="<?= set_value("contact") ?>" class="form-control" placeholder="Contact Number">
                                    <?php echo form_error('contact'); ?>
                                </div>	
                            </div>
                            <div class="row">
                                <div class="col-sm-12 form-group">

                                    <input type="password" class="no-display" style="display: none" name="dummy" id="dummy" >
                                    <input type="password" id="pass" name="login[password]"    class="form-control" placeholder="Password (At least 6 characters)"   value="" autocomplete="new-password" />
                                    <?php echo form_error('login[password]'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <input type="password" id="cpass" name="login[cpassword]"   class="form-control" placeholder="Confirm Password"   value="" autocomplete="new-password" />
                                    <?php echo form_error('login[cpassword]'); ?>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-sm-12  col-xs-12 col-md-12 form-group">
                                    <div class="row">
                                        <div class="col-sm-12  col-xs-12 col-md-12 form-group">

                                            <button id="create_account">Create prime membership account</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <?= form_close(); ?>

                        <?php } else { ?>

                            <div class="col-sm-12  col-xs-12 col-md-12 form-group">
                                <div class="row">
                                    <div class="col-sm-12  col-xs-12 col-md-12 form-group">
                                        <?php
                                            if($isPrime==0){
                                        ?>
                                        <a  href="<?= base_url('Prime/regPrime') ?>" class="primeConti"> Continue >>> </a>
                                        <?php }else{
                                                ?>
                                                <a  href="#" class="primeConti disabled">Already prime member </a>
                                        <?php
                                            } ?>
                                    </div>

                                </div>
                            </div>


                        <?php } ?>
                    </div>
                </div>  
            </div>

        </div>
    </div>    
</div>

</body>
</html>


