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

    <div class="panel panel-white">
        <?= $this->session->flashdata('msg'); ?>
        <div class="panel-body  pb">
            <?php
            $output = '';
            $output .= form_open_multipart('Admin/CrossUpload/save');
            $output .= '<div class="row">';
          
            $output .= '<div class="col-lg-3 col-sm-4"><div class="form-group">';

            $output .= form_label('Add Cross & Similar Product', 'image');
            $data = array(
                'name' => 'userfile',
                'id' => 'userfile',
                'class' => 'form-control ',
                'value' => '',
                'required' => true
            );
            $output .= form_upload($data);
            $output .= '</div> <span style="color:red;">*Please choose an Excel file(.csv) as Input</span></div>';
            $output .= '<div class="col-md-3"><div class="form-group">';
            $output .= "<br>";
            // $output .= anchor(base_url("assets/crossProduct31.csv"), 'Download Sample', 'class="btn btn-xs btn-success"');
            $output .= '</div></div>';
            $output .= '<div class="col-lg-12 col-sm-12"><div class="form-group ">';
            $data = array(
                'name' => 'importfile',
                'id' => 'importfile-id',
                'class' => 'btn btn-primary',
                'value' => 'Import',
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