<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="main-container">

    <!-- Page heading -->
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Add Swatch</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>
                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>

                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>
    <!-- /Page heading -->


    <!-- Content container -->
    <div class="container-fluid">
        <div class="section">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?= validation_errors() ?>
                    <div class="panel  panel-white">
                        <div class="panel-body">
                            <h4><?= $prodata->pro_name ?></h4>
                            <div class="table-responsive">
                                <?php
                                $propertiese = json_decode($properties);
                                $arr_color = [];
                                foreach ($propertiese->response as $keys2 => $response) {
                                    foreach ($response->attribute as $attribute) {
                                        $key2 = key((array) $attribute);
                                        if (strtolower($key2) == "color") {
                                            $arr_color[] = (string) $attribute->$key2;
                                        }
                                    }
                                }

                                $a = array_unique($arr_color);
                                 
                                ?>
                                <?= form_open_multipart("SadminLogin/addSwatch/{$this->uri->segment(3)}"); ?>
                                <table class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>Color</th>
                                            <th>Images</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ( $a  as $keys => $response) { ?>
                                            <tr>

                                                <td>
                                                    <?= $response ?>
                                                </td>

                                                <td>
                                                    <input type="hidden" name="color[]" value=" <?= $response ?>" />
                                                    <input type="file" required="" name="color_pic[]" />
                                                    <img onclick="window.location.href = '<?= isset($swatch[$keys]->color_pic) ? base_url("uploads/swatch/") . "" . $swatch[$keys]->color_pic : "" ?>'" style="width:80px" src="<?= isset($swatch[$keys]->color_pic) ? base_url("uploads/swatch/") . "" . $swatch[$keys]->color_pic : "" ?>" alt="" />

                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <input  type="hidden"  name="proid" value="<?= $proid ?>"> 
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td> <input class="btn btn-success" type="submit" name="update"  value="update" /></td>
                                        </tr>
                                    </tfoot>


                                </table>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
