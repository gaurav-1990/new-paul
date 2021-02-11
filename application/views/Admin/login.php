<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<main class="main-container">

    <?= $this->session->flashdata('msg'); ?>
    <div  class="panel panel-white demo-panel col-md-8">
        <h4 style="text-align: center;padding: 0;margin: 0;">Login into your account</h4>
        <div  class="panel-body pt-2x pb">

            <?= form_open('Admin/Loginvendor/submitLogin', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'method' => 'POST')); ?>

            <div class="form-group">
                <label for="frm02--email" class="col-sm-2 control-label">UserName</label>
                <?= $key ?>
                <div class="col-sm-10">
                    <input type="text" id="frm02--email" name="login[username]" class="form-control" placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <label for="frm02--password" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="no-display" name="dummy" id="dummy" >
                    <input type="password" id="login" name="login[password]"   class="form-control" placeholder="Password"   value="" autocomplete="new-password" /></div>
            </div>

            <div class="form-group">

                <div class="pull-right col-sm-4 text-right">
                    <button type="submit" class="btn btn-default">Sign in</button>
                </div>

            </div>
            <?= form_close(); ?>
            <center>
                <a href="<?= site_url('Admin/Loginvendor/forgot')?>">Forgot Password ?</a>
            </center>
            <!-- /Form -->

        </div>
    </div>
    <div class="col-md-4">  
    <center> <img style="margin: 0 auto; margin-bottom: 20px;width:70%" src="<?= base_url('bootstrap/images/logo.png') ?>"/></center>
    </div>
</main>