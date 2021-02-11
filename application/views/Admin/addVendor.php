
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
                    <label>First Name</label>
                    <input type="text" id="first_name"  name="first_name" class="form-control" placeholder="First Name">
                </div>
                <div class="col-sm-3">
                    <label>Last Name</label>
                    <input type="text" id="last_name" name="last_name"    class="form-control" placeholder="Last Name"   value=""  /> 
                </div>
                <div class="col-sm-3">
                    <label>Contact Number</label>
                    <input type="text" id="contact_no" name="contact_no"   class="form-control" placeholder="Contact Number"   value=""  /> 
                </div>
                <div class="col-sm-3">
                    <label>Email Address</label>
                    <input type="text" id="email_id" name="email_id"    class="form-control" placeholder="Email Address"   value=""  /> 
                </div>
                <input type="hidden" name="hidden_id"   />
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">

                <div class="col-sm-3">
                    <label>Company</label>
                    <input type="text" id="company"   name="company" class="form-control" placeholder="Company">
                </div>
                <div class="col-sm-3">
                    <label>State</label>
                    <select class="form-control" name="state" id="state">
                        <option value="">Select State</option>
			<?= getState() ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>City</label>
                    <select class="form-control" name="city" id="city">
                        <option value="">Select City</option>

                    </select>
                </div>
                <div class="col-sm-3">
                    <label>Pin Code</label>
                    <input type="text" id="zip" name="zip"  class="form-control" placeholder="Pin Code"   value=""  /> 
                </div>
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">

                <div class="col-sm-3">
                    <label>Address</label>
                    <textarea   id="address" name="address" class="form-control" placeholder="Address"></textarea>
                </div>

                <div class="col-sm-3">
                    <label>Pan no.</label>
                    <input type="text" id="pan_no" name="pan_no"     class="form-control" placeholder="Pan No."   value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3">
                    <label>TIN</label>
                    <input type="text" id="tin" name="tin"    class="form-control" placeholder="TIN"   value=""  /> 
                </div>
		<div class="col-sm-3">
                    <label>GST no.</label>
                    <input type="text" id="gst_no" name="gst_no"    class="form-control" placeholder="GST No."   value="" autocomplete="off" /> 
                </div>
            </div>
        </div>

	<div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-2 col-md-3">
                    <label>Upload Address Proof *</label>
                    <input type="file" id="add_proof" name="add_proof"    class="form-control"    value="" autocomplete="off" /> 
                </div>
		<div class="col-sm-3 col-md-3">
                    <label>Upload Pan Number *</label>
                    <input type="file" id="pan_number" name="pan_number"  class="form-control"   value="" autocomplete="off" /> 
                </div>
		<div class="col-sm-3 col-md-3">
                    <label>Upload Profile Pic *</label>
                    <input type="file" id="profile_pic" name="profile_pic"    class="form-control"   value="" autocomplete="off" /> 
                </div>
		<div class="col-sm-3 col-md-3">
                    <label>Upload GST Doc *</label>
                    <input type="file" id="gst_doc" name="gst_doc"   class="form-control"    value="" autocomplete="off" /> 
                </div>
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">
                <div class=" col-sm-4">
                    <button type="submit" class="btn btn-default"> Submit </button>
                </div>
            </div>
        </div>

	<?= form_close(); ?>
    </div>
</main>
