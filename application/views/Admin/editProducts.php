
<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">

                    <!-- Breadcrumb -->
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Signup</a>
                        </li>
                        <li>
                            <a href="<?= site_url('Admin/SadminLogin/profiles'); ?>">View</a>
                        </li>
                        <li class="active"><span>Add Vendor</span></li>
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
    <?= $this->session->flashdata('emailmsg'); ?>
    <div  class="panel panel-white">
	<?= form_open('Admin/SadminLogin/vendorCreation', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'id' => 'sform2', 'method' => 'POST')); ?>

        <div  class="panel-body  pb">
            <div class="row">

                <div class="col-sm-3">
                    <label>Category</label>
                    <select class="form-control" name="category" id="category">
                        <option value="">Select Category</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>Sub Category</label>
                    <select class="form-control" name="sub_category" id="sub_category">
                        <option value="">Sub Category</option>
                    </select>
                </div>

                <div class="col-sm-3">
                    <label>Product Name</label>
                    <input type="text" id="product_name"   name="product_name" class="form-control" placeholder="Product Name">
                </div>
                <div class="col-sm-3">
                    <label>Product Image</label>
                    <input type="file" name="pro_image"  />
		    <?php echo form_error('pro_image', '<p class="error">', '</p>'); ?>
                </div>
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">

                <div class="col-sm-3">
                    <label>Actual Price</label>
                    <input type="text" id="act_price"   name="act_price" class="form-control" placeholder="Actual Price">
                </div>
                <div class="col-sm-3">
                    <label>Offer Price</label>
                    <input type="text" id="dis_price" name="dis_price"     class="form-control" placeholder="Discount Price"   value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-6">
                    <label>Description</label>
                    <textarea   id="pro_desc" name="pro_desc" rows="4" class="form-control" placeholder="Description"></textarea>
                </div>

            </div>
        </div>


        <div  class="panel-body  pb">
            <div class="row">
                <div class=" col-sm-4">
                    <button type="submit" class="btn btn-default">Add Products</button>
                </div>
            </div>
        </div>

	<?= form_close(); ?>
    </div>
</main>
