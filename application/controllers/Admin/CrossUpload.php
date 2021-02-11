<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class CrossUpload extends CI_Controller
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
            
            $count = $this->db->get_where("tbl_product", ["LOWER(sku)" => strtolower($value["sku"])])->result();
           
            if (count($count) > 0) {
                $this->db->delete("tbl_cross_sell", ["pro_id" => $count[0]->id]);
                foreach ($value['crossProd'] as $cross) {
           
                    $getproductId = $this->db->get_where("tbl_product", ["LOWER(sku)" => strtolower($cross)])->result();
                   
                    if (count($getproductId) > 0) {
                       
                        $this->db->insert("tbl_cross_sell", ["pro_id" => $count[0]->id, "cross_pro_id" => $getproductId[0]->id]);
                    }
                }
                $this->db->delete("tbl_related_product", ["pro_id" => $count[0]->id]);
                foreach ($value['similar_products'] as $same) {
                    $getproductId = $this->db->get_where("tbl_product", ["LOWER(sku)" => strtolower($same)])->result();
                    if (count($getproductId) > 0) {
                       
                        $this->db->insert("tbl_related_product", ["pro_id" => $count[0]->id, "relate_pro_id" => $getproductId[0]->id]);
                    }
                }
            }
            
        }
        
        $this->db->cache_delete_all();
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
            $createArray = array('sku','similar_products','cross_selling');
            $makeArray = array( 'sku' =>'sku', 'similar_products' => 'similar_products', 'cross_selling' => 'cross_selling');
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
                  
                    $crossProduct = $SheetDataKey['cross_selling'];
                    $similar_products = $SheetDataKey['similar_products'];
                    
                    $sku = $SheetDataKey['sku'];

                    $crossProduct = $allDataInSheet[$i][$crossProduct] != '' ? $allDataInSheet[$i][$crossProduct] : "";
                    $similar_products = $allDataInSheet[$i][$similar_products] != '' ? $allDataInSheet[$i][$similar_products] : "";                  
                    $sku = $allDataInSheet[$i][$sku] != '' ? $allDataInSheet[$i][$sku] : 0;
                    

                    $crossProd = explode(";", $crossProduct);
                    $similarProd = explode(";", $similar_products);
                   
                    //"images" => [$image1, $image2, $image3, $image4, $image5]
                    $fetchData[] = array("vendor_id" => 29,  "sku" => $sku, "similar_products" => $similarProd, "crossProd" => $crossProd);
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
            return redirect('Admin/Vendor/CrossUpload');
        }
    }
}