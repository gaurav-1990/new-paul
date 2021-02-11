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
                            <a href="#"> Block</a>
                        </li>
                        <li class="active"><span>View</span></li>

                    </ol>

                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('insert') ?>

                    </div>
                    <!-- /Page header -->

                </div>
                <a href="<?= base_url();?>Admin/SadminLogin/add_block"><button type="button" class="pull-right btn-info">Add Block</button></a>
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

                                <table id="example" class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Title</th>
                                            <th>Identifier</th>
                                            <th>Status</th>
                                            <th>Sort Order</th>
                                             
                                            <th>From</th>
                                            <th>To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($user as $data) {
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td>
                                                    <a href="<?= site_url('Admin/SadminLogin/update_block/' . encode($this->encryption->encrypt($data->id))) ?>" class="btn btn-xs btn-warning">Edit</a>
                                                    <a onclick="return confirm('Do you want to delete this block')" href="<?= site_url('Admin/SadminLogin/delete_block/' . encode($this->encryption->encrypt($data->id))) ?>" class="btn btn-xs btn-danger">Delete</a>

                                                </td>
                                                <td><?= $data->block_title ?></td>
                                                <td><?= $data->block_identifier ?></td>
                                                <td><?= $data->block_status == 0 ? 'Disable' : "enable"?></td>
                                                <td><?= $data->sort_order?></td>
                                                 
                                                <td><?= $data->valid_from ?></td>
                                                <td><?= $data->valid_upto ?></td>
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