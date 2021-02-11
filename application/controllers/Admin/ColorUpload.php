<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ColorUpload extends CI_Controller
{
    private $_batchImport;
    private $arr;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', "user");
        //$this->load->model('Import_model', "import");
    }

    public function setBatchImport($batchImport)
    {
        $this->_batchImport = $batchImport;
    }

    // save data
    public function importData()
    {

        $data = $this->_batchImport;
        foreach ($data as $value) {
            $count = $this->db->get_where("tbl_prod_prop", ["LOWER(attr_name)" => strtolower($value["attr_name"])])->result();       
            if (count($count) <= 0) {
               $qry = $this->db->insert("tbl_prod_prop", ["prop_id" => 3, "attr_name" => $value["attr_name"], "color_code" => $value["color_code"]]);
            }  
        }
        if($qry){
            $this->session->set_flashdata("msg", "<div class='alert alert-success'> Color attributs uploaded successfully  </div>");                             
        }else{
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Color code already exist . </div>");                                
        }
        $this->db->cache_delete_all();
        return redirect("Admin/Vendor/ColorUpload");
    }


    // upload xlsx|xls file
    // import excel data
    public function save()
    {
      
        $this->load->library('excel');

        if ($this->input->post('importfile')) {
            $path = './Vendor_Invoice/';

            $config['upload_path'] = $path;
            $config['allowed_types'] = '*';
            $config['remove_spaces'] = true;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('userfile')) {
                $data = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }

            $fetchData = array();

            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;

            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $vendorid = $this->input->post('vendor');
            $arrayCount = count($allDataInSheet);
            $createArray = array('attr_name','color_code');
            $makeArray = array( 'attr_name' =>'attr_name', 'color_code' => 'color_code');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    } else {}
                }
            }
            $data = array_diff_key($makeArray, $SheetDataKey);

            if (empty($data)) {
                $flag = 1;
            }

            if ($flag == 1) {

                for ($i = 2; $i <= $arrayCount; $i++) {
                  
                    $attr_name = $SheetDataKey['attr_name'];
                    $color_code = $SheetDataKey['color_code'];

                    $attr_name = $allDataInSheet[$i][$attr_name] != '' ? $allDataInSheet[$i][$attr_name] : "";
                    $color_code = $allDataInSheet[$i][$color_code] != '' ? $allDataInSheet[$i][$color_code] : "";                  
                
                    // $crossProd = explode(";", $crossProduct);
                    // $similarProd = explode(";", $similar_products);
                   
                    //"images" => [$image1, $image2, $image3, $image4, $image5]
                    $fetchData[] = array("attr_name" => $attr_name, "color_code" => $color_code);
                }

                $data['vendorInfo'] = $fetchData;
                $this->setBatchImport($fetchData);
                $last_id = $this->importData();

                // $this->import->tblInsertproperty($arrayOfPropTable);
                $this->session->set_flashdata("msg", '<div class="alert  alert-success">
                                             Imported Successfully
                                        </div>');
            } else {

                $this->session->set_flashdata("msg", '<div class="alert  alert-danger    "> ' . $this->upload->display_errors() . '</div>');
            }
            return redirect('Admin/Vendor/ColorUpload');
        }
    }
}