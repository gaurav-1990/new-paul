<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Products</a>
                        </li>
                        <li class="active"><span>Edit Products</span></li>
                    </ol>
                    <div class="page-header">
                        <h2 class="page-subtitle">
                            Edit Vendor Information
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?= $this->session->flashdata('msg'); ?>
    <?= $this->session->flashdata('insert'); ?>
    <div  class="panel panel-white">
        <?= form_open_multipart('Admin/Vendor/updateVendorRequest/', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'id' => 'sform3', 'method' => 'POST')); ?>
        <div  class="panel-body pb">

            <div class="row">
                <div class="col-sm-3">
                    <label>Category</label>
                    <select class="form-control" onchange="getSubcategory(this.value)" name="category" id="category">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?= encode($this->encryption->encrypt($category->id)) ?>" <?= $category->id == $products->cat_id ? "selected" : "" ?>><?= $category->cat_name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>Sub Category</label>
                    <select class="form-control" name="sub_category" id="sub_category_ven">
                        <option selected="" value="<?= encode($this->encryption->encrypt($products->sub_id)) ?>"><?= $products->sub_name ?></option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>Product Name</label>
                    <input type="text" id="product_name" value="<?= $products->pro_name ?>" name="product_name" class="form-control" placeholder="Product Name">
                </div>
                <div class="col-sm-3">
                    <label>SKU</label>
                    <input type="text" id="sku" value="<?= $products->sku ?>" minlength="2" name="sku" required="" class="form-control" placeholder="SKU">
                </div>
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-3">
                    <label>Actual Price</label>
                    <input type="text" id="act_price" name="act_price" value="<?= $products->act_price ?>" class="form-control" placeholder="Actual Price">
                </div>
                <div class="col-sm-3">
                    <label>Offer Price</label>
                    <input type="text" id="dis_price" name="dis_price"  value="<?= $products->dis_price ?>"    class="form-control" placeholder="Discount Price"   value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3">
                    <label>Total Product In Stock</label>
                    <input type="text" id="pro_stock" name="pro_stock" value="<?= $products->pro_stock ?>"  class="form-control" placeholder="Total Products"   value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3">
                    <label>In Stock</label>
                    <select class="form-control" name="in_stock" id="in_stock">
                        <option value="1"<?= $products->in_stock == 1 ? "selected" : "" ?>>Yes</option>
                        <option value="0"<?= $products->in_stock == 0 ? "selected" : "" ?>>No</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" name="pro_id" value="<?= encode($this->encryption->encrypt($products->ID)) ?>" />
        <div  class="panel-body pb">
            <div class="row">
                <div class="col-sm-12">
                    <label>Description</label>
                    <textarea   id="pro_desc" name="pro_desc" rows="4" class="form-control" placeholder="Description"><?= $products->pro_desc ?></textarea>
                    <?= display_ckeditor($ckeditor); ?>
                </div>
            </div>
        </div>

        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-4">
                    <button type="submit"  class="btn btn-success"> <i class="fa fa-plus-circle"></i> Add Products</button>
                </div>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</main>
