<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Bulkupdate extends CI_Controller
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
            
            $count = $this->db->get_where("tbl_product", ["pro_name" => $value["pro_name"]])->result()[0];       
            
            if(((is_object($count) && count(get_object_vars($count)) > 0) || count($count) > 0)){

               $qry = $this->db->update('tbl_product', array('pro_name' => $value['pro_name'], 'pro_stock' => $value['pro_stock'], 'act_price' => $value['act_price'], 'dis_price' => $value['dis_price'],'product_attr' => $value['product_attr']), array('id' =>$count->id));

               //$qry = $this->db->insert("tbl_customer_order", ["prop_id" => 3, "attr_name" => $value["attr_name"], "color_code" => $value["color_code"]]);
            }  
        }//die;
        if($qry){
            $this->session->set_flashdata("msg", "<div class='alert alert-success'> Imported successfully  </div>");                             
        }else{
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Color code already exist . </div>");                                
        }
        $this->db->cache_delete_all();
        return redirect("Admin/Vendor/BulkUpdate");
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
            $createArray = array('pro_name', 'act_price','dis_price','product_attr');
            $makeArray = array('pro_name' => 'pro_name', 'act_price' => 'act_price', 'dis_price' => 'dis_price', 'product_attr' => 'product_attr');
            
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
                    $images = array();
                    $sleevekey = array();
                    
                    $pro_name = $SheetDataKey['pro_name'];
                    $act_price = $SheetDataKey['act_price'];
                    $dis_price = $SheetDataKey['dis_price'];
                    $product_attr = $SheetDataKey['product_attr'];

                    $pro_name = $allDataInSheet[$i][$pro_name] != '' ? $allDataInSheet[$i][$pro_name] : 0;
                    $act_price = $allDataInSheet[$i][$act_price] != '' ? $allDataInSheet[$i][$act_price] : 0.0;
                    $dis_price = $allDataInSheet[$i][$dis_price] != '' ? $allDataInSheet[$i][$dis_price] : 0.0;
                    $product_attr = $allDataInSheet[$i][$product_attr] != '' ? $allDataInSheet[$i][$product_attr] : null;
                    
                    $response = explode(";", $product_attr);
                    $arr = [];
                    $total_qty = 0;
                    foreach ($response as $key => $value) {
                        $innerSide = [];
                        $inner = explode("|", $value);
                        $size = explode(":", $inner[0]);
                        $innerSide["attribute"][] = [$size[0] => $size[1]];
                        $innerSide["qty"] = isset($inner[1]) ? intval(explode(":", (isset($inner[1]) ? $inner[1] : 0))[1]) : "";
                        $total_qty += floatval($innerSide["qty"]);
                        $innerSide["changedPrice"] = "";
                        $arr["response"][] = $innerSide;
                    }
                    $new_product_attr = json_encode($arr);

                    // $gst = $allDataInSheet[$i][$gst] != '' ? $allDataInSheet[$i][$gst] : "";
                    // $hsn_code = $allDataInSheet[$i][$hsn_code] != '' ? $allDataInSheet[$i][$hsn_code] : "";
                    // $tags = $allDataInSheet[$i][$tags] != '' ? $allDataInSheet[$i][$tags] : "";
                    // $short_desc = $allDataInSheet[$i][$short_desc] != '' ? addslashes($allDataInSheet[$i][$short_desc]) : "";
                   

                    // $pro_name = $allDataInSheet[$i][$pro_name] != '' ? ucfirst(strtolower(addslashes($allDataInSheet[$i][$pro_name]))) : '';
                    // $arrayOfPropTable = [];
                    // $propery_arr = explode(";", $property);
                   
                    // $dat = [];
                    // foreach ($propery_arr as $key => $value) {

                    //     $names = explode(":", $value);
                    //     $propname = $names[0]; // COLOR
                    //     $attr_name = $names[1]; // color code   
                    
                    //    // $prop_id = $this->getPropName($propname);
                    //     $prop_id = $this->getPropName($attr_name);
                    //     if($prop_id != '' && $prop_id != NULL){
                    //         //$dat = (array) $this->tbl_prod_propGetId($prop_id->id, $attr_name);
                    //          $dat[] =  $prop_id->id;
                           
                    //     }else{
                    //         $this->session->set_flashdata("msg", '<div class="alert  alert-danger">
                    //         Colors are not define .
                    //         </div>'); 
                    //         return redirect('Admin/Vendor/BulkUpload');
                    //     }
                                  
                    // }
                    // foreach ($propery_arr as $key => $value) {

                    //     $names = explode(":", $value);
                    //     $propname = $names[0]; // COLOR
                    //     $attr_name = $names[1]; // color code   

                    //     $prop_id = $this->getPropName($propname);
                     
                    //     if($prop_id != '' && $prop_id != NULL){
                    //         $dat = (array) $this->tbl_prod_propGetId($prop_id->id, $attr_name);
                                            
                    //     }else{
                    //         $this->session->set_flashdata("msg", '<div class="alert  alert-danger">
                    //         Colors are not define : '.$i.'.
                    //         </div>'); 
                    //         //return redirect('Admin/Vendor/BulkUpload');
                    //     }
                                  
                    //     if($dat != '' && $dat != NULL){                         
                    //     $arrayOfPropTable[] = [$dat['id'], $sku];
                    //     }else{
                    //     $this->session->set_flashdata("msg", '<div class="alert  alert-danger">
                    //         Attributes are not define : '.$i.'
                    //    </div>'); 
                    //   // return redirect('Admin/Vendor/BulkUpload');
                    //     }
                    // }
            
                    $fetchData[] = array('pro_name' => $pro_name, 'pro_stock' => $total_qty, 'act_price' => $act_price, 'dis_price' => $dis_price,'product_attr' => $new_product_attr);
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
            return redirect('Admin/Vendor/BulkUpdate');
        }
    }
}