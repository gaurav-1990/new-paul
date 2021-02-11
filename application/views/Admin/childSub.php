<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="main-container">

    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Child Sub Categories</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>
                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                    </div>
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

                                <table class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Name</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($data as $categories) {
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><a href="<?= base_url() ?>Admin/SadminLogin/editChildSubCategory/<?= encode($this->encryption->encrypt($categories->id)) ?>" class="btn btn-xs btn-success">Edit</a> <a href="<?= base_url() ?>Admin/SadminLogin/deleteChildSubCategory/<?= encode($this->encryption->encrypt($categories->id)) ?>" onclick="return confirm('Do you want to delete this !')" class="btn btn-xs btn-danger" >Delete</a></td>
                                                <td><?= $categories->sub_name ?></td>
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