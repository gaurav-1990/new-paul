<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Signup</a>
                        </li>
                        <li>
                            <a href="<?= site_url('Admin/SadminLogin/profiles'); ?>">View</a>
                        </li>
                        <li class="active"><span> Add/Edit/Delete Specifications</span></li>
                    </ol>
                    <div class="page-header">

                        <h2 class="page-subtitle">
                            Specifications
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?= $this->session->flashdata('msg'); ?>
    <?= $this->session->flashdata('emailmsg'); ?>
    <?= validation_errors() ?>
    <div class="panel panel-white">
        <?= form_open('Admin/Vendor/addSpecification/' . $this->uri->segment(4), array('class' => 'form-horizontal', 'autocomplete' => 'off', 'id' => 'sform2', 'method' => 'POST')); ?>
        <div class="panel-body pb">
            <?php

            foreach ($data as $key => $value) {

                ?>
                <div class="row">
                    <div class="col-sm-3">
                        <label>Key</label>
                        <input type="text" id="key" required="" name="key[]" value="<?= $value->skey ?>" class="form-control" placeholder="Key">
                    </div>
                    <div class="col-sm-3">
                        <label>Value</label>
                        <input type="text" id="value" required="" name="value[]" class="form-control" placeholder="Value" value="<?= $value->value ?>" />
                    </div>
                    <div class="col-sm-3">
                        <label>&nbsp;</label>
                        <br>
                        <a href="javascript:void(0)" id="delete" onclick="deleteSpe(this)" class="btn btn-xs btn-danger">Delete</a>
                    </div>

                </div>
            <?php
        } ?>
            <input type="hidden" name="pro_id" value="<?= $this->uri->segment("4"); ?>">
            <div class="row">
                <div class="col-sm-3">
                    <label>Key</label>
                    <input type="text" id="key" required="" name="key[]" class="form-control" placeholder="Key">
                </div>
                <div class="col-sm-3">
                    <label>Value</label>
                    <input type="text" id="value" required="" name="value[]" class="form-control" placeholder="Value" value="" />
                </div>
                <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <br>
                    <a href="javascript:void(0)" id="add_more" onclick="addMoreSpecification(this)" class="btn btn-xs btn-warning">Add More</a>
                </div>
            </div>
        </div>
        <div class="panel-body  pb">
            <div class="row">
                <div class=" col-sm-4">
                    <button type="submit" class="btn btn-default"> Submit </button>
                </div>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</main>