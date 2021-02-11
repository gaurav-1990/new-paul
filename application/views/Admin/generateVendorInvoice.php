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
                    </ol>

                </div>
            </div>
        </div>
    </header>

    <div  class="panel panel-white">
        <?= $this->session->flashdata('msg'); ?>
        <div  class="panel-body  pb">
            <?php
            $output = '';
            $output .= form_open_multipart('Admin/Vendor/generatePdfInvoice');
            $output .= '<div class="row">';
            $output .= '<div class="col-lg-3 col-sm-4"><div class="form-group">';
            $output .= form_label('Select Vendors', 'vendors');
            $output .= '<select class="form-control" required="" name="vendor" id="vendor">
                            <option value="">Select Vendors</option>';
            foreach ($vendors as $vendor) {
                $output .= "<option value='$vendor->id'>$vendor->company</option>";
            }
            $output .= '</select>';
            $output .= '</div></div>';
            $output .= '<div class="col-lg-3 col-sm-4"><div class="form-group">';

            $output .= form_label('Year', 'Year');
            $year = array();
            for ($i = date('Y'); $i >= 2018; $i--) {
                $year[$i] = $i;
            }
            $additionl_year = "id=year class=form-control";
            $output .= form_dropdown("year", $year, date('Y'), $additionl_year);
            $output .= '</div></div>';
            $output .= '<div class="col-lg-3 col-sm-4"><div class="form-group">';
            $output .= form_label('Month', 'month');
            $month = array();
            for ($i = 12; $i >= 1; $i--) {
                $month[$i] = $i;
            }
            $additionl_year = "id=month class=form-control";
            $output .= form_dropdown("month", $month, date('m'), $additionl_year);
            $output .= '</div></div>';
            $output .= '<div class="col-lg-2 col-sm-2"><div class="form-group">';
            $output .= form_label('Invoice', 'invoice');
            $output .= '<input type="text" class="form-control" name="invoice" id="invoice" value=""></div>';
            $output .= '<div class="col-lg-12 col-sm-12"><div class="form-group text-right">';
            $data = array(
                'name' => 'generateInvoice',
                'id' => 'generateInvoice',
                'class' => 'btn btn-success',
                'value' => 'Generate Invoice',
            );

            $output .= form_submit($data);
            $output .= '</div>
                    </div>
                        </div>';
            $output .= form_close();
            echo $output;
            ?>


        </div>
    </div>
</main>
