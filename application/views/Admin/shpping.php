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
    <div class="col-md-12">
        <div class="col-md-6 center">
      
            <?= validation_errors(); ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <?= form_open('Admin/Vendor/shipping', array('method' => 'POST')); ?>
    <div  class="panel panel-white">
        <div  class="panel-body  pb">
            <div class="row">
                <div class="col-sm-3">
                    <label>State</label>
                    <select class="form-control chosen-select"    name="state" id="ship_state">
                        <option value="">Select State</option>
                        <?= getState(); ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>City</label>
                    <select class="form-control chosen-select"  name="city" id="ship_city">
                        <option value="">Select City</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <label>Max days</label>
                    <select class="form-control"  name="max_days" id="max_days">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option selected="" value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>

                <div class="col-sm-1">
                    <label>Shp Amt</label>
                    <input type="text"  class="form-control" name="ship_amt" id="ship_amt" value="0" />
                </div>
                <div class="col-sm-2">
                    <label>Same Day Ship. Amt</label>
                    <input type="text"  class="form-control" name="same_amt" id="same_amt" value="0" />
                </div>
                <div class="col-sm-1">
                    <label for="">&nbsp;</label><br>
                    <button class="btn btn-success btn-xs"> Save </button>
                </div>
            </div>
        </div>
    </div>
    <div  class="panel panel-white">
        <?= $this->session->flashdata('msg'); ?>
        <div  class="panel-body  pb">

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-nowrap no-mb">
                    <thead>

                        <tr>
                            <th># <input type="checkbox" checked=""  id="selectBox"/></th>
                            <th>Area Name</th>
                            <th>PIN Code</th>
                            <th>District</th>
                            <th>State</th>
                        </tr>
                    </thead>
                    <tbody id="pin_codes">
                    <td colspan="5">No data</td>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <?= form_close(); ?>
</main>
