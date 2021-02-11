<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<main class="main-container">

    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Edit Customer Group</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>

                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('insert') ?>
                        <?= validation_errors(); ?>
                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="section">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">
                        <div class="panel-body">
                            <?php
                            $url = base_url()."Admin/SadminLogin/update_createGroup/".encode($this->encryption->encrypt($data[0]->id));
                           ?>
                           <?= form_open_multipart($url, array('method' => 'POST', 'id' => 'sform2', 'class' => 'sform2')) ?>
                            <div class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Group Name</label>
                                        <input type="text" name="group" class="form-control" value="<?= $data[0]->group_name ?>"  autocomplete="off" required/>
                                    </div>
                                   
                                    
                                    
                                </div>
                            </div>
                            <div class="panel-body  pb">
                                <div class="row">

                                    <div class="col-sm-3">
                                        <input type="submit" value="Update" class="btn btn-xs btn-success">
                                    </div>
                                </div>


                            </div>
                            <?= form_close(); ?>
                            

                        </div>
                    </div>



                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>


</main>