<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<main class="main-container">
    <?= $this->session->flashdata('msg'); ?>
    <div  class="panel panel-white demo-panel col-md-8">
        
        <h4 style="text-align: center;padding: 0;margin: 0;"> Reset Password</h4>

        <div  class="panel-body pt-2x pb">

            <?= form_open('Admin/Loginvendor/forgotstep/'.$this->uri->segment(4), array('class' => 'form-horizontal', 'autocomplete' => 'off', 'method' => 'POST')); ?>
            <?= validation_errors();?>
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="col-sm-10">
                        <label for="">User Name</label>
                        <input type="text" readonly="" id="username" name="login[username]"  class="form-control" value="<?= $user->contactno ?>" placeholder="UserName">
                    </div>
                </div>
                <input type="hidden" value="<?= encode($this->encryption->encrypt($user->id));?>" name="hid" />
                <div class="form-group">
                    <div class="col-sm-10">
                        <label for="">Password</label>
                        <input type="password" id="password" name="login[password]" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <label for="">Re-enter Password</label>
                        <input type="password" id="rpassword" name="login[password2]" class="form-control" placeholder="Re-enter Password">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="pull-right col-sm-4 text-right">
                    <button type="submit" class="btn btn-default"> Send </button>
                </div>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</div>
<div class="col-md-4"> <center> <img style="margin: 0 auto; margin-bottom: 20px;" src="<?= base_url('bootstrap/images/logo.png') ?>"/></center></div>
</main>