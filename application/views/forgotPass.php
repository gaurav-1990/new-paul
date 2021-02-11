<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style type="text/css">
    .fill {
        min-height: 100%;
        height: 100%;
    }
</style>
<?php
$url = "Myaccount/forgotPassword";
$signUrl  = "Myaccount/newUser";
$loginUrl  = "Myaccount";
if ($this->input->get("Step") == "checkout") {
    $url = "Myaccount/forgotPassword?Step=checkout";
    $signUrl = "Myaccount/newUser?Step=checkout";
    $loginUrl  = "Myaccount?Step=checkout";
}

?>
<div class="trand-bg">
    <div class="loged-in-part fill">


        <div class="loged-in-part-in">
            <div class="logo-sec">

                <h3>Forgot password ?</h3>
            </div>
            <div class="form-part">
                <?= $this->session->flashdata('msg'); ?>
                <?= form_open($url, array('id' => 'sform', 'method' => 'POST', 'autocomplete' => 'off')) ?>

                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label> Email </label>
                        <input type="text" id="frm02--email" name="login[username]" class="form-control" placeholder="Email">
                        <?php echo form_error('login[username]'); ?>
                    </div>
                </div>

                <br>
                <div class="row form-group">
                    <div class="col-sm-12  col-xs-12 col-md-12 form-group">
                        <div class="row">
                            <div class="col-sm-12  col-xs-12 col-md-12 form-group">
                                <!--                                        <input type="submit" value="Send" class="center-block btn   btn-block btn-warning ">-->
                                <button>SEND</button>
                            </div>
                            <div class="col-sm-8 text-left col-xs-4 col-md-6 form-group">
                                <a class="" href="<?= site_url($loginUrl) ?>"> Back to login</a>
                            </div>
                            <div class="col-sm-12  text-right col-xs-8 col-md-6 form-group">
                                <a href="<?= site_url($signUrl) ?>">Click here for registration</a>
                            </div>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>



                <?= form_close(); ?>
            </div>
        </div>


    </div>
</div>

</body>

</html>