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
                            <a href="#">Create Customer Group</a>
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
                            <?= form_open_multipart('Admin/SadminLogin/createGroup', array('method' => 'POST', 'id' => 'sform2', 'class' => 'sform2')) ?>
                            <div class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Group Name</label>
                                        <input type="text" name="group" class="form-control" placeholder="Group Name"  autocomplete="off" required/>
                                    </div>
                                   
                                    
                                    
                                </div>
                            </div>
                            <div class="panel-body  pb">
                                <div class="row">

                                    <div class="col-sm-3">
                                        <input type="submit" value="Add Group Name" class="btn btn-xs btn-success">
                                    </div>
                                </div>


                            </div>
                            <?= form_close(); ?>
                    
                        </div>
                        <div class="panel-body  pb">
                                <div class="row">
                                     <div class="table-responsive">

                                <table class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>#</th>                                          
                                            <th>Group Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $count = 1;
                                        
                                        foreach ($data as $of) {
                                            ?>
                                            <tr>
                                                <td><?=$count?></td>                                               
                                                <td> <?= $of->group_name ?> </td> 
                                                <td> 
                                                    <a href="<?=base_url()?>Admin/SadminLogin/update_createGroup/<?= encode($this->encryption->encrypt($of->id))?>" class='btn btn-xs btn-warning'>Edit</a>
                                                    <!-- <a onclick="return confirm('Do you want to delete this User Group')" href="<?=base_url()?>Admin/SadminLogin/delete_createGroup/<?= encode($this->encryption->encrypt($of->id)) ?>" class='btn btn-xs btn-danger'>Delete</a> -->
                                                 </td>                                             
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                                   
                                </div>


                            </div>
                    </div>

                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>


</main>