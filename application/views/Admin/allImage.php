<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Products </a>
                        </li>
                        <li class="active"><span>All Images</span></li>
                    </ol>
                    <div class="page-header">
                        <h2 class="page-subtitle">
                            Vendor Images
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div  class="panel panel-white">
        <div  class="panel-body  pb">
            <?= form_open_multipart() ?>
            <div class="row">
                <?php
                foreach ($images as $key => $image) {
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title mb-3">  Image <?= $key + 1 ?></strong>
                            </div>
                            <div class="card-body">
                                <?php if ($image->img_sta == 0) { ?>
                                    <div class="mx-auto d-block">
                                        <img width="50%" class="rounded-circle mx-auto d-block" src="<?= base_url('uploads/original/') ?><?= $image->pro_images ?>" alt="Product Image">
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <a   href="<?= base_url('uploads/original/') ?><?= $image->pro_images ?>">  Document</a>
                                <?php }
                                ?>
                                <br/>
                                <input data-name="<?= encode($this->encryption->encrypt($image->id)); ?>"   type="file" class="fileEdit" id="fileEdit_<?= $key ?>"     name="changedImage[]" >
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</main>
