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
                            View Details
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div  class="panel panel-white">
        <?= $this->session->flashdata('msg'); ?>
        <div  class="panel-body  pb">
            <div class="table-responsive">


                <table class="table table-bordered table-striped table-nowrap no-mb">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <th>Category Name</th>
                            <td><?= $product->cat_name ?></td>
                        </tr>
                        <tr>
                            <th>Sub Category Name</th>
                            <td><?= $product->sub_name ?></td>
                        </tr>
                        <tr>
                            <th>Product Name</th>
                            <td><?= $product->pro_name ?></td>
                        </tr>
                        <tr>
                            <th>Total Product Stock</th>
                            <td><?= $product->pro_stock ?></td>
                        </tr>
                        <tr>
                            <th>Brand Name</th>
                            <td><?= $product->brand_name ?></td>
                        </tr>
                        <tr>
                            <th>IMEI Number</th>
                            <td><?= $product->imei ?></td>
                        </tr>
                        <tr>
                            <th>Actual Price</th>
                            <td><?= $product->act_price ?></td>
                        </tr>
                        <tr>
                            <th>Offer Price</th>
                            <td><?= $product->dis_price ?></td>
                        </tr>
                        <tr>
                            <th>GST %</th>
                            <td><?= $product->GST ?></td>
                        </tr>
                        <tr>
                            <th>Product Description</th>
                            <td><?= $product->pro_desc ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</main>
