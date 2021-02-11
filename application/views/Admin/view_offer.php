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
                                            <th>Enable/Disable</th>
                                            <th>Offer Name</th>
                                            <th>Offer Code</th>                                           
                                            <th>Offer Type</th>
                                            <th>Offer Value</th>                                           
                                            <th>Price Type</th>
                                            <th>Minimum Value</th>                                           
                                            <th>Offer Per Customer</th>
                                            <th>Offer valid From</th>                                           
                                            <th>Offer valid To</th>                                           
                                            <th>Customer Group</th>
                                            <th>Priority</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        $count = 1;
                                        foreach ($data as $user) {
                                            foreach ($groups as $grp) {
                                                if($grp->id === $user->group_name){
                                               $group_name = $grp->group_name;
                                                }
                                            }

                                            // echo "<pre>";
                                            // print_r($user);
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td>
                                                    <?php  $id = encode($this->encryption->encrypt(($user->id)));  ?>
                                                    <a href="<?= base_url(); ?>Admin/SadminLogin/delete_offerCode/<?= $id ?>" class="btn btn-xs btn-danger">Delete</a>
                                                </td>
                                                <td>
                                                    <?php  if($user->block == 0) { ?>
                                                        <a href="<?= base_url(); ?>Admin/Vendor/disable_offer/<?= $id ?>" onclick="return confirm('Are You sure you want to Disable the Offer')" class="button">Enabled</a>
                                                    <?php  } else { ?>
                                                        <a href="<?= base_url(); ?>Admin/Vendor/enable_offer/<?= $id ?>" onclick="return confirm('Are You sure you want to Enable the Offer')" class="button">Disabled</a>
                                                    <?php } ?>
                                                </td>
                                                <?php ?>
                                                <td><?= $user->offer_name ?></td>
                                                <td><?= $user->offer_code ?></td>
                                                <td><?= ($user->offer_type == 0)?'Price':'Percentage' ?></td>
                                                <td><?= $user->offer_val ?></td>
                                                <td><?= ($user->which_price == 0)?'Sub Total':'Grand Total' ?></td>
                                                <td><?= $user->min_val ?></td>
                                                <td><?= $user->offer_per_customer ?></td>
                                                <td><?= date("d-m-Y", strtotime($user->offer_validity_from))  ?></td>
                                                <td><?= date("d-m-Y", strtotime($user->offer_validity_to) ) ?></td>
                                                <td><?= $group_name ?></td>
                                                <td><?= $user->priority ?></td>
                                                
                
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