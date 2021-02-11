<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">

                    <!-- Breadcrumb -->
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Products </a>
                        </li>

                        <li class="active"><span>Add Images</span></li>
                    </ol>
                    <!-- /Breadcrumb -->

                    <!-- Page header -->
                    <div class="page-header">

                        <h2 class="page-subtitle">
                            Add Vendor Information
                        </h2>
                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>

    <?= $this->session->flashdata('msg'); ?>
    <?= $this->session->flashdata('pro1_msg'); ?>
    <?= $this->session->flashdata('pro2_msg'); ?>
    <?= $this->session->flashdata('pro3_msg'); ?>
    <?= $this->session->flashdata('pro4_msg'); ?>
    <?= $this->session->flashdata('pro5_msg'); ?>
   


    <div  class="panel panel-white">
        <?= form_open_multipart('Admin/Vendor/uploadImages', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'id' => 'sform2', 'method' => 'POST')); ?>

        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-3">
                    <label>Base Image (420x560 px)</label>
                    <input type="file" id="pro_image1" required="" value="<?= set_value('pro_image1') ?>" name="pro_image1"  />

                </div>
                <div class="col-sm-3">
                    <label>Product Image (420x560 px)</label>
                    <input type="file" id="pro_image2"  required="" value="<?= set_value('pro_image2') ?>" name="pro_image2"  />

                </div>
                <div class="col-sm-3">
                    <label>Product Image (420x560 px)</label>
                    <input type="file"  id="pro_image3"    value="<?= set_value('pro_image3') ?>" name="pro_image3"  />

                </div>
                <div class="col-sm-3">
                    <label>Product Image (420x560 px)</label>
                    <input type="file" id="pro_image4"     value="<?= set_value('pro_image4') ?>" name="pro_image4"  />

                </div>

            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-3">
                    <label>Product Image (420x560 px)</label>
                    <input type="file" id="pro_image5"   value="<?= set_value('pro_image5') ?>"  name="pro_image5"  />
                    <input type="hidden" name="pro"  value="<?= encode($this->encryption->encrypt($prod_id)) ?>" />
                </div>
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class=" col-sm-4">
                    <button type="submit" class="btn btn-default">Add Images</button>
                </div>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</main>
