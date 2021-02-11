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
                            $url = base_url()."Admin/SadminLogin/edit_AssignGroup/".encode($this->encryption->encrypt($userInfo->id));
                            ?>
                           <?= form_open_multipart( $url, array('method' => 'POST', 'id' => 'sform2', 'class' => 'sform2')) ?>
                            <div class="panel-body  pb">
                            <h5>Customer Name : <?= ucfirst($userInfo->user_name) ." ". ucfirst($userInfo->lastname)?></h5>     
                            <input type="checkbox" name="" id="selectAll" onclick="customerGroup();"/> <label> Select All Group</label> 
                                <div class="row">
                                    <div class="col-sm-3">    
                                    <?php
                                    $arr = [];
                                    foreach ($group as $user_grp) {                                      
                                      $arr[] = $user_grp->ID;
                                    }
                                    
                                    foreach ($groupList as $grp) { ?>                                                                              
                                        <input type="checkbox"  id="user_name_<?=$grp->id?>" name="user_name[]" onclick="singleCustomer(<?=$grp->id?>);"  value="<?=$grp->id?>"  <?= (in_array($grp->id,$arr)) ? "checked" : "" ?> /> <label><?= $grp->group_name ?></label><br>
                                    <?php } ?>
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