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
                        <li class="active"><span> All Properties</span></li>
                    </ol>
                    <div class="page-header">
                        <h2 class="page-subtitle">
                            Properties Name
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="panel panel-white">
        <?= $this->session->flashdata('msg'); ?>
        <div class="panel-body  pb">
            <div class="table-responsive">
                <a href="<?= site_url('Admin/SadminLogin/editPropAttrName/' . $this->uri->segment(4)) ?>" class="btn btn-xs btn-success"> Edit Properties</a>

                <table class="table table-bordered table-striped table-nowrap no-mb">
                    <thead>
                        <tr>
                            <th>Attr Name</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (json_decode($properties->product_attr)->response as $par => $property) { ?>
                            <tr>
                                <td>
                                    <?php
                                    foreach ($property->attribute as $key => $attribute) {
                                        $key = key((array) $attribute);
                                        echo "<b>$key</b>";
                                        echo "=>";
                                        echo $attribute->$key;
                                        echo "     ";
                                    }
                                    ?>
                                </td>
                                <td> <?= $property->qty ?> </td>
                                <td>
                                    <a href="<?= site_url('Admin/SadminLogin/deletePropAttrName/' . $this->uri->segment(4) . "/" . encode($this->encryption->encrypt($par))) ?>" class="btn btn-xs btn-danger"> Delete </a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</main>