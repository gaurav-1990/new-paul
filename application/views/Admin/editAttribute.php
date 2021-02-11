<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
                            <a href="#"> Vendor Requested Products</a>
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
    <div id="rejectPop"></div>

    <!-- Content container -->
    <div class="container-fluid">
        <div class="section">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">
                        <div class="panel-body">

                            <div class="table-responsive">
                                <?php
                                $propertiese = json_decode($properties);
                               
                                if ($propertiese!=null && $prodata->pro_sta == 1 ) {
                                    ?>
                                    <?= form_open("Admin/SadminLogin/updatePropAttrName") ?>
                                    <table class="table table-bordered table-striped table-nowrap no-mb">
                                        <thead>
                                            <tr>
                                                <th>Attribute</th>
                                                <th>Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                            
                                            foreach ($propertiese->response as $keys => $response) { ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        foreach ($response->attribute as $attribute) {
                                                            $key = key((array) $attribute);
                                                            echo "<br><b>$key : </b>  ";
                                                            print_r($attribute->$key);
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <input type="text" class="form-control col-md-3" name="qty[]" value="<?= $response->qty ?>">
                                                        <input type="hidden" class="form-control col-md-3" name="key[]" value="<?= $keys ?>">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <input type="hidden" name="proid" value="<?= $proid ?>">
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td> <input class="btn btn-success" type="submit" name="update" value="update" /></td>
                                            </tr>
                                        </tfoot>


                                    </table>
                                    <?= form_close(); ?>
                                <?php } else { ?>
                                    <form action="<?= base_url("Admin/SadminLogin/updatePropAttr") ?>" method="POST">
                                        <table class="table table-bordered table-striped table-nowrap no-mb">



                                            <thead id='editAtt' class="pb">

                                                <?php
                                                $properties = json_decode($properties);


                                                $key_c = 0;
                                                $resp = [];
                                                if (isset($properties)) {
                                                    foreach ($properties->response as $response) {
                                                        $resp["response"][$key_c] = $response;
                                                        $key_c++;
                                                    }

                                                    foreach ($resp["response"] as $count => $att) {
                                                        ?>
                                                        <tr>
                                                            <?php
                                                            foreach ($att->attribute as $key => $attri) {
                                                                ?>
                                                                <th> <?= $key = key((array) $attri); ?></th>

                                                            <?php } ?>
                                                            <th> Qty</th>
                                                        </tr>

                                                        <tr id='qtyval'>
                                                            <?php
                                                            foreach ($att->attribute as $key2 => $attri) {
                                                                $key = key((array) $attri);
                                                                $keyval = key((array) $attri);
                                                                ?>
                                                                <td> <?php $propname = (getPropertyName(str_replace("_", " ", $key), $attri->$keyval));
                                                                        ?>
                                                                    <select name="property<?= $count ?>[]" id="pd_attr">
                                                                        <option value="<?= $key ?>|<?php print_r($attri->$keyval) ?>"><?php print_r($attri->$keyval); ?></option>
                                                                        <?php
                                                                        foreach ($propname as $prop) {
                                                                            $attr = str_replace(" ", "_", $prop->attr_name);
                                                                            $propname = str_replace(" ", "_", $prop->pop_name);
                                                                            echo "<option value='$propname|$attr'>$prop->attr_name</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            <?php }
                                                            ?>
                                                            <td> <input type="text" id='quantity' name="quantity[]" value="<?= $att->qty ?>" /></td>

                                                        </tr>

                                                    <?php
                                                    }
                                                }
                                                ?>



                                            </thead>

                                            <input type="hidden" id='pro_stock' value="<?= $prodata->pro_stock ?>" />
                                            <input type="hidden" name="proid" value="<?= $proid ?>">
                                            <input type="hidden" id='category' value="<?= encode($this->encryption->encrypt($prodata->cat_id)) ?>" />
                                            <input type="hidden" id='subcategory' value="<?= encode($this->encryption->encrypt($prodata->sub_id)) ?>" />
                                            <div class="col-md-12">
                                                <label for=""></label><br>

                                                <input class="btn btn-success pull-right" type="submit" name="update" value="update" />
                                            </div>
                                            <div class=" col-sm-3  pull-right">
                                                <label for=""></label><br>
                                                <button type="button" onclick="addEditProp()" class="btn btn-info btn-xs  pull-right">Add Properties</button>
                                            </div>

                                        </table>
                                    </form>

                                <?php } ?>



                            </div>

                        </div>
                    </div>



                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>


</main>