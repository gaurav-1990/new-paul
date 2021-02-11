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
                        <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('insert') ?>
                        <?= validation_errors(); ?>
                         </div>
                            <?= form_open_multipart('Admin/SadminLogin/customerGroup', array('method' => 'POST', 'id' => 'sform2', 'class' => 'sform2')) ?>
                            <div class="panel-body  pb">
                                <div class="row">                               
                                    <div class="col-sm-3">
                                        <label>Group Name</label>
                                        <select class="form-control" name="customer_grp" id="which_price" required>
                                            <option value="">Select Group</option>
                                            <?php foreach ($group as $value) { ?>
                                            <option value="<?= $value->id ?>"><?= $value->group_name ?></option>
                                           <?php } ?>
                                        </select>                                 
                                     </div>
                                   
                                    
                                    
                                </div>
                            </div>
                            <div class="panel-body  pb">
                                <div class="row"> 
                                <div class="col-sm-3">
                                <input type="checkbox" name="" id="selectAll" onclick="customerGroup();"/> <label> Select All Group</label>
                                </div>
                                </div>
                            </div>                  
                        </div>
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
                                            <th>Choose</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Date of Birth</th>
                                            <th>Marriage Anniversary</th>
                                            <th>Group Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;

                                        foreach ($data as $user) {
                                            if(isset($user->bir_day) && $user->bir_day != NULL){
                                                $date1 = $user->bir_day."-".$user->bir_month."-".$user->bir_year;
                                                //echo $date1;
                                                }else{
                                                    $date1='';
                                                }
                                                 if(isset($user->ann_day) && $user->ann_day != NULL){
                                                
                                                $date2 = $user->ann_day."-".$user->ann_month."-".$user->ann_year;
                                                //echo $date2;
                                                 }else{
                                                    $date2='';
                                                 }
                                       
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td>
                                                    <?php  
                                                    $id = encode($this->encryption->encrypt(($user->id)));
                                                    
                                                    ?>
                                                    <a><input type="checkbox" id="user_name_<?=$user->id?>" value="<?=$user->id?>" name="user_name[]" onclick="singleCustomer(<?=$user->id?>);"/></a>
                                                   

                                                </td>
                                                <?php ?>
                                                <td><?= $user->user_name ?></td>
                                                <td><?= $user->lastname ?></td>
                                                <td><?= $user->user_contact ?></td>
                                                <td><?= $user->user_email ?></td>
                                                <td><?= $user->gender ?></td>
                                                <td style="display: inline-block; width: 120px;"><?= $date1 ?></td>
                                                <td><?= $date2 ?></td>
                                                <!-- <td>
                                                    <?php  if($user->block == 1) { ?>
                                                <a href="<?= base_url(); ?>Admin/SadminLogin/unblock/<?= $id ?>" onclick="return confirm('Are You sure you want to unblock')" class="button" data-toggle='tooltip' title='CLICK TO UNBLOCK'>Block</a>

                                            <?php  } else{ ?>

                                            <a href="<?= base_url(); ?>Admin/SadminLogin/block/<?= $id ?>" onclick="return confirm('Are You sure  you want to block')" class="button" data-toggle='tooltip' title='CLICK TO BLOCK'>Unblock</a> 

                                            <?php  }  ?>
                                                </td> -->
                                                <td>
                                                <?php                                     
                                                    $grp = getGroupname($id);
                                                  
                                                    foreach ($grp as $key => $groupName) {
                                                     echo $groupName->grp_name . " ". (isset($groupName->grp_name) && ($groupName->grp_name != NULL) ? ',' :'') ;                                               
                                                    } ?>
                                              </td>
                                              <td style="width:120px;display: inline-block;">
                                                <a href="<?= base_url(); ?>Admin/SadminLogin/edit_AssignGroup/<?= $id ?>" class="btn btn-xs btn-info">Edit</a>
                                                <a onclick="return confirm('Do you want to delete this User Group')" href="<?= base_url(); ?>Admin/SadminLogin/delete_AssignGroup/<?= $id ?>" class="btn btn-xs btn-danger">Delete All</a>
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

                    <div class="panel-body  pb">
                                <div class="row">

                                    <div class="col-sm-3">
                                        <input type="submit" value="Add Customer Group" class="btn btn-xs btn-success">
                                    </div>
                                </div>


                            </div>
                            <?= form_close(); ?>

                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>
                    </div>

                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>


</main>