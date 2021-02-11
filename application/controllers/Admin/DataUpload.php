<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class DataUpload extends CI_Controller
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
            
            $count = $this->db->get_where("tbl_customer_order", ["transcation_id" => $value["transcation_id"]])->result()[0];       
            //print_r($count->id);
            if (count($count) > 0) {

               $qry = $this->db->update('tbl_customer_order', array('registered_user'=> $value['registered_user'], 'user_email'=>$value['user_email'],'first_name'=>$value['first_name'],'last_name'=>$value['last_name'],'country'=>$value['country'],'state'=>$value['state'],'user_address'=>$value['user_address'],'user_city'=>$value['user_city'],'user_pin_code'=>$value['user_pin_code'],'pay_date'=>$value['pay_date'],'user_contact'=>$value['user_contact'],'order_sta'=>1,'pay_sta'=>$value['pay_sta'],'pay_method'=>$value['pay_method'],'address_id'=>$value['address_id'],'offer_id'=>$value['offer_id'],'total_offer'=>$value['total_offer'],'total_order_price'=>$value['total_order_price'],'shipping'=>$value['shipping'],'transcation_id'=>$value['transcation_id'],'invoice_id'=>$value['invoice_id'],'shipping_awb'=>$value['shipping_awb'],'invoice_date'=>$value['invoice_date']), array('id' =>$count->id));

               //$qry = $this->db->insert("tbl_customer_order", ["prop_id" => 3, "attr_name" => $value["attr_name"], "color_code" => $value["color_code"]]);
            }  
        }
        if($qry){
            $this->session->set_flashdata("msg", "<div class='alert alert-success'> Impported successfully  </div>");                             
        }else{
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Color code already exist . </div>");                                
        }
        $this->db->cache_delete_all();
        return redirect("Admin/Vendor/userOrder");
    }


    // upload xlsx|xls file
    // import excel data
    public function save()
    {
      
        $this->load->library('excel');

        if ($this->input->post('importfile')) {
            $path = './user_data/';

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
            $createArray = array('registered_user','user_email','first_name','last_name','country','state','user_address','user_city','user_pin_code','pay_date','user_contact','order_sta','pay_sta','pay_method','address_id','offer_id','total_offer','total_order_price','shipping','transcation_id','invoice_id','shipping_awb','invoice_date');
            $makeArray = array( 'registered_user'=>'registered_user', 'user_email'=>'user_email','first_name'=>'first_name','last_name'=>'last_name','country'=>'country','state'=>'state','user_address'=>'user_address','user_city'=>'user_city','user_pin_code'=>'user_pin_code','pay_date'=>'pay_date','user_contact'=>'user_contact','order_sta'=>'order_sta','pay_sta'=>'pay_sta','pay_method'=>'pay_method','address_id'=>'address_id','offer_id'=>'offer_id','total_offer'=>'total_offer','total_order_price'=>'total_order_price','shipping'=>'shipping','transcation_id'=>'transcation_id','invoice_id'=>'invoice_id','shipping_awb'=>'shipping_awb','invoice_date'=>'invoice_date');
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
                  
                    $registered_user = $SheetDataKey['registered_user'];
                    $user_email = $SheetDataKey['user_email'];
                    $first_name = $SheetDataKey['first_name'];
                    $last_name = $SheetDataKey['last_name'];
                    $country = $SheetDataKey['country'];
                    $state = $SheetDataKey['state'];
                    $user_address = $SheetDataKey['user_address'];
                    $user_city = $SheetDataKey['user_city'];
                    $user_pin_code = $SheetDataKey['user_pin_code'];
                    $pay_date = $SheetDataKey['pay_date'];
                    $user_contact = $SheetDataKey['user_contact'];
                    $order_sta = $SheetDataKey['order_sta'];
                    $pay_sta = $SheetDataKey['pay_sta'];
                    $pay_method = $SheetDataKey['pay_method'];
                    $address_id = $SheetDataKey['address_id'];
                    $offer_id = $SheetDataKey['offer_id'];
                    $total_offer = $SheetDataKey['total_offer'];
                    $total_order_price = $SheetDataKey['total_order_price'];
                    $shipping = $SheetDataKey['shipping'];
                    $transcation_id = $SheetDataKey['transcation_id'];
                    $invoice_id = $SheetDataKey['invoice_id'];
                    $shipping_awb = $SheetDataKey['shipping_awb'];
                    $invoice_date = $SheetDataKey['invoice_date'];

                    $registered_user = $allDataInSheet[$i][$registered_user] != '' ? $allDataInSheet[$i][$registered_user] : "";
                    $user_email = $allDataInSheet[$i][$user_email] != '' ? $allDataInSheet[$i][$user_email] : "";
                    $first_name = $allDataInSheet[$i][$first_name] != '' ? $allDataInSheet[$i][$first_name] : "";
                    $last_name = $allDataInSheet[$i][$last_name] != '' ? $allDataInSheet[$i][$last_name] : "";
                    $country = $allDataInSheet[$i][$country] != '' ? $allDataInSheet[$i][$country] : "";
                    $state = $allDataInSheet[$i][$state] != '' ? $allDataInSheet[$i][$state] : "";
                    $user_address = $allDataInSheet[$i][$user_address] != '' ? $allDataInSheet[$i][$user_address] : "";
                    $user_city = $allDataInSheet[$i][$user_city] != '' ? $allDataInSheet[$i][$user_city] : "";
                    $user_pin_code = $allDataInSheet[$i][$user_pin_code] != '' ? $allDataInSheet[$i][$user_pin_code] : "";
                    $pay_date = $allDataInSheet[$i][$pay_date] != '' ? $allDataInSheet[$i][$pay_date] : "";
                    $user_contact = $allDataInSheet[$i][$user_contact] != '' ? $allDataInSheet[$i][$user_contact] : "";
                    $order_sta = $allDataInSheet[$i][$order_sta] != '' ? $allDataInSheet[$i][$order_sta] : "";
                    $pay_sta = $allDataInSheet[$i][$pay_sta] != '' ? $allDataInSheet[$i][$pay_sta] : "";
                    $pay_method = $allDataInSheet[$i][$pay_method] != '' ? $allDataInSheet[$i][$pay_method] : "";
                    $address_id = $allDataInSheet[$i][$address_id] != '' ? $allDataInSheet[$i][$address_id] : "";
                    $offer_id = $allDataInSheet[$i][$offer_id] != '' ? $allDataInSheet[$i][$offer_id] : "";
                    $total_offer = $allDataInSheet[$i][$total_offer] != '' ? $allDataInSheet[$i][$total_offer] : "";
                    $total_order_price = $allDataInSheet[$i][$total_order_price] != '' ? $allDataInSheet[$i][$total_order_price] : "";
                    $shipping = $allDataInSheet[$i][$shipping] != '' ? $allDataInSheet[$i][$shipping] : "";
                    $transcation_id = $allDataInSheet[$i][$transcation_id] != '' ? $allDataInSheet[$i][$transcation_id] : "";
                    $invoice_id = $allDataInSheet[$i][$invoice_id] != '' ? $allDataInSheet[$i][$invoice_id] : "";
                    $shipping_awb = $allDataInSheet[$i][$shipping_awb] != '' ? $allDataInSheet[$i][$shipping_awb] : "";
                    $invoice_date = $allDataInSheet[$i][$invoice_date] != '' ? $allDataInSheet[$i][$invoice_date] : "";

                              
                
                    // $crossProd = explode(";", $crossProduct);
                    // $similarProd = explode(";", $similar_products);
                   
                    //"images" => [$image1, $image2, $image3, $image4, $image5]
                    $fetchData[] = array( 'registered_user'=> $registered_user, 'user_email'=>$user_email,'first_name'=>$first_name,'last_name'=>$last_name,'country'=>$country,'state'=>$state,'user_address'=>$user_address,'user_city'=>$user_city,'user_pin_code'=>$user_pin_code,'pay_date'=>$pay_date,'user_contact'=>$user_contact,'order_sta'=>$order_sta,'pay_sta'=>$pay_sta,'pay_method'=>$pay_method,'address_id'=>$address_id,'offer_id'=>$offer_id,'total_offer'=>$total_offer,'total_order_price'=>$total_order_price,'shipping'=>$shipping,'transcation_id'=>$transcation_id,'invoice_id'=>$invoice_id,'shipping_awb'=>$shipping_awb,'invoice_date'=>$invoice_date);
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
            return redirect('Admin/Vendor/userOrder');
        }
    }
}