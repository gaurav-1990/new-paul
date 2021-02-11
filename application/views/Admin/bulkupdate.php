<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Stock Update </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </header>

    <div class="panel panel-white">
        <div class="panel-body  pb">
            <label>Download Inventory Data : </label>
            <a class="btn btn-xs btn-info" href="<?= base_url('Admin/Vendor/export_productCSV')?>">DOWNLOAD</a>
        </div>
    </div>

    <div class="panel panel-white">
        <?= $this->session->flashdata('msg'); ?>
        <?= $this->session->flashdata('attr'); ?>
        <?= $this->session->flashdata('color'); ?>
        <div class="panel-body  pb">
            <?php
            $output = '';
            $output .= form_open_multipart('Admin/Bulkupdate/save');
            $output .= '<div class="row">';

            $output .= '<div class="col-lg-3 col-sm-4"><div class="form-group">';

            $output .= form_label('Update Products Inventory & Prices', 'image');
            $data = array(
                'name' => 'userfile',
                'id' => 'userfile',
                'class' => 'form-control ',
                'value' => '',
                'required' => true
            );
            $output .= form_upload($data);
            $output .= '</div> <span style="color:red;">*Please choose an Excel file(.csv) as Input</span></div>';
            $output .= '<div class="col-lg-12 col-sm-12"><div class="form-group ">';
            $data = array(
                'name' => 'importfile',
                'id' => 'importfile-id',
                'class' => 'btn btn-primary',
                'value' => 'UPLOAD',
            );
            $output .= form_submit($data, 'Import Data');
            $output .= '</div>
                    </div>
                        </div>';
            $output .= form_close();
            echo $output;
            ?>


        </div>
    </div>
</main>