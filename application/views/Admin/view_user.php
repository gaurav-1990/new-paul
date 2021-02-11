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
                            <a href="#"> Users</a>
                        </li>
                        <li class="active"><span>View</span></li>


                    </ol>

                    <div class="page-header">
                        <div class="col-sm-3" style="float: right;">
                        <label>&nbsp;</label>
                            <a class="btn btn-info btn-xs pull-right" href=<?= base_url('Admin/Vendor/allUserCSV') ?>>Download Data</a>
                    </div>
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('insert') ?>

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

                            <div class="table-responsive">

                                <table id='example' class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action</th>
                                            
                                            
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Date of Birth</th>
                                            <th>Marriage Anniversary</th>
                                            <th>Block/Unblock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;

                                        foreach ($data as $user) {
                                            if (isset($user->bir_day) && $user->bir_day != NULL) {
                                                $date1 = $user->bir_day . "-" . $user->bir_month . "-" . $user->bir_year;
                                                //echo $date1;
                                            } else {
                                                $date1 = '';
                                            }
                                            if (isset($user->ann_day) && $user->ann_day != NULL) {

                                                $date2 = $user->ann_day . "-" . $user->ann_month . "-" . $user->ann_year;
                                                //echo $date2;
                                            } else {
                                                $date2 = '';
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td style='width:120px; display: inline-block;'>
                                                    <?php $id = encode($this->encryption->encrypt(($user->id))); ?>
                                                    <a href="<?= base_url(); ?>Admin/SadminLogin/update_user/<?= $id ?>" class="btn btn-xs btn-info">Edit</a>
                                                    <!-- <a onclick="return confirm('Do you want to delete this User')" href="<?= base_url(); ?>Admin/SadminLogin/delete_user/<?= $id ?>" class="btn btn-xs btn-danger">Delete</a> -->
                                                    <a href="<?= base_url() ?>Admin/SadminLogin/view_userdetails/<?= $id ?>" class="btn btn-xs btn-success">Order Details</a>
                                                </td>
 
                                                <?php ?>
                                                
                                               
                                                <td><?= $user->user_name ?></td>
                                                <td><?= $user->lastname ?></td>
                                                <td><?= $user->user_contact ?></td>
                                                <td><?= $user->user_email ?></td>
                                                <td><?= $user->gender ?></td>
                                                <td><?= $date1 ?></td>
                                                <td><?= $date2 ?></td>
                                                <td>
                                                    <?php if ($user->block == 1) { ?>
                                                        <a href="<?= base_url(); ?>Admin/SadminLogin/unblock/<?= $id ?>" onclick="return confirm('Are You sure you want to unblock')" class="button" data-toggle='tooltip' title='CLICK TO UNBLOCK'>Block</a>

                                                    <?php } else { ?>

                                                        <a href="<?= base_url(); ?>Admin/SadminLogin/block/<?= $id ?>" onclick="return confirm('Are You sure  you want to block')" class="button" data-toggle='tooltip' title='CLICK TO BLOCK'>UnBlock</a> 

                                                    <?php } ?>
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

        <div id="setMe"></div>

    </div>


</main>