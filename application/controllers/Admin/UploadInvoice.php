<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class uploadInvoice extends CI_Controller
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

    private function original($image)
    {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = true;
        $config['source_image'] = FCPATH . 'userupload/' . $image;
        $config['new_image'] = FCPATH . 'uploads/original/' . $image; // encrypted name
        $config['remove_spaces'] = true;
        $config['encrypt_name'] = true;

        $this->image_lib->initialize($config);

        if ($this->image_lib->resize()) {
            $this->resize($image);
        } else {
            $this->session->set_flashdata("img", "<div class='alert alert-danger'> $image . </div>");

            // echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear();
    }

    private function resize($image)
    {
        $this->load->library('image_lib');

        // Do your manipulation
        $config['image_library'] = 'gd2';
        $config['width'] = '300';
        $config['maintain_ratio'] = true;
        $config['source_image'] = FCPATH . 'userupload/' . $image;
        $config['new_image'] = FCPATH . 'uploads/resized/resized_' . $image; // encrypted name
        $this->image_lib->initialize($config);
        if ($this->image_lib->resize()) {
            $this->thumbnail($image);
        } else {

            //echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear();
    }

    private function thumbnail($image)
    {
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['width'] = '100';
        $config['maintain_ratio'] = true;
        $config['maintain_ratio'] = true;
        $config['create_thumb'] = true;
        $config['source_image'] = FCPATH . 'userupload/' . $image;
        $config['new_image'] = FCPATH . 'uploads/thumbs/thumb_' . $image; // encrypted name
        $config['remove_spaces'] = true;
        $config['encrypt_name'] = true;

        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            // echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear();
    }

    // save data
    public function importData()
    {
        $data = $this->_batchImport;
        foreach ($data as $key => $value) {
            $line = $key + 2;
            if ($value['act_price'] >= $value['dis_price']) {
                $count = $this->db->get_where("tbl_product", ["sku" => $value["sku"]])->result();
                if (count($count) == 0) {

                    $this->db->insert("tbl_product", ["vendor_id" => $value["vendor_id"], "txt_msg" => $value["txt_msg"], "product_sname" => $value["product_sname"], "meta_desc" => $value["meta_description"], "pro_stock" => $value["pro_stock"], "meta_key" => $value["meta_keyword"], "title" => $value["title"], "type" => $value["type"], "pro_name" => addslashes($value["pro_name"]), "sku" => $value["sku"], "in_stock" => $value["in_stock"], "act_price" => $value["act_price"], "dis_price" => $value["dis_price"], "pro_desc" => $value["pro_desc"], "product_attr" => $value["product_attr"], "pro_sta" => $value["pro_sta"], "gst" => $value["gst"], "hsn_code" => $value["hsn_code"], "short_desc" => $value["short_desc"],  "visible_from_date" => $value["visible_from_date"]]);
                    $id = $this->db->insert_id();
                    foreach ($value["specification"] as $keys => $spe) {     
                        $skey = "";
                        if ($keys == 0) {
                            $skey = "Sleeve Length";
                        } else if ($keys == 1) {
                            $skey = "Neck";
                        } else if ($keys == 2) {
                            $skey = "Pattern";
                        } else if ($keys == 3) {
                            $skey = "Occasion";
                        } else if ($keys == 4) {
                            $skey = "Fabric";
                        }

                        $this->db->insert("tbl_specification", ["pro_id" => $id, "skey" => $skey, "value" => $spe]);
                    }

                    $this->db->cache_delete("Admin", "SadminLogin");
                    foreach ($value['images'] as $img) {
                        $img = $img;
                        $this->db->insert("tbl_pro_img", ["pro_id" => $id, "pro_images" => $img, "insertTime" => date('Y-m-d H:i:s')]);
                        if ($img != '') {
                            $this->original($img);
                        }
                    }

                    foreach ($value['multiCat'] as $key => $val) {

                        $getCatId = $this->db->get_where("tbl_categories", ["LOWER(cat_name)" => trim(strtolower($val['cat_id']))])->result();
                        
                        if ($getCatId != NUll) {
                            $getSubId = $this->db->get_where("tbl_subcategory", ["LOWER(sub_name)" => trim(strtolower($val['sub_id'])), "parent_sub" => 0, "cid" => $getCatId[0]->id])->result();

                            if ($getSubId != NULL) {
                                if (isset($val['child_id'])) {
                                    $getChildId = $this->db->get_where("tbl_subcategory", ["cid" => $getCatId[0]->id, "LOWER(sub_name)" => trim(strtolower($val['child_id'])), "parent_sub" => $getSubId[0]->id])->result();
                                    //    echo $this->db->last_query(); 
                                    //    print_r($getSubId);
                                    //    die;
                                    if ($getChildId != NULL) {
                                        $this->db->insert("tbl_product_categories", ["cat_id" => $getCatId[0]->id, "sub_id" => $getSubId[0]->id, "child_id" => $getChildId[0]->id, "pro_id" => $id]);
                                    } else {
                                        $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Child category Name not define : $line </div>");
                                        return redirect("Admin/Vendor/BulkUpload");
                                    }
                                } else {

                                    $this->db->insert("tbl_product_categories", ["cat_id" => $getCatId[0]->id, "sub_id" => $getSubId[0]->id, "child_id" => 0, "pro_id" => $id]);
                                }
                            } else {
                                $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Sub Category Name not define in line no. : $line </div>");
                                return redirect("Admin/Vendor/BulkUpload");
                            }
                        } else {
                            $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Uploading Failed Due to Invailed category Name : $line </div>");
                            $this->db->delete("tbl_product", ["id" => $id]);
                            $this->db->cache_delete('Admin', 'SadminLogin');
                            return redirect("Admin/Vendor/BulkUpload");
                        }
                    }

                    foreach ($value["attributes"] as $key => $value1) {

                        $this->db->insert("tbl_product_property", ["pro_id" => $id, "property_id" => $value1[0]]);
                    }

                 

                } else {
                    $pro_id = $count[0]->id;
                    $this->db->update("tbl_product", ["vendor_id" => $value["vendor_id"], "pro_stock" => $value["pro_stock"], "product_sname" => $value["product_sname"], "txt_msg" => $value["txt_msg"], "meta_desc" => $value["meta_description"], "meta_key" => $value["meta_keyword"], "title" => $value["title"], "type" => $value["type"], "pro_name" => addslashes($value["pro_name"]), "sku" => $value["sku"], "in_stock" => $value["in_stock"], "act_price" => $value["act_price"], "dis_price" => $value["dis_price"], "pro_desc" => $value["pro_desc"], "product_attr" => $value["product_attr"], "pro_sta" => $value["pro_sta"], "gst" => $value["gst"], "hsn_code" => $value["hsn_code"], "short_desc" => $value["short_desc"], "visible_from_date" => $value["visible_from_date"]], ["id" => $pro_id]);
                    $this->db->delete("tbl_specification", ["pro_id" => $pro_id]);

                    foreach ($value["specification"] as $keys => $spe) {
                        $skey = "";
                        if ($keys == 0) {
                            $skey = "Sleeve Length";
                        } else if ($keys == 1) {
                            $skey = "Neck";
                        } else if ($keys == 2) {
                            $skey = "Pattern";
                        } else if ($keys == 3) {
                            $skey = "Occasion";
                        } else if ($keys == 4) {
                            $skey = "Fabric";
                        }

                        $this->db->insert("tbl_specification", ["pro_id" => $pro_id, "skey" => $skey, "value" => $spe]);
                    }


                    /*Already commented */
                    // foreach ($value["attributes"] as $key => $value1) {
                    //     $this->db->delete("tbl_product_property", ["pro_id" => $pro_id, "property_id" => $value1[0]]);
                    //     $this->db->insert("tbl_product_property", ["pro_id" => $pro_id, "property_id" => $value1[0]]);
                    // }

                    $this->db->delete("tbl_pro_img", ["pro_id" => $pro_id]);
                    foreach ($value['images'] as $img) {
                        $img = $img;
                        $this->db->insert("tbl_pro_img", ["pro_id" => $pro_id, "pro_images" => $img, "insertTime" => date('Y-m-d H:i:s')]);
                        if ($img != '') {
                            $this->original($img);
                        }
                    }

                    // $this->db->delete("tbl_pro_img", ["pro_id" => $pro_id]);
                    // foreach ($value["images"] as $image) {
                    //     $rand = mt_rand(99, 999) . time();
                    //     $content = file_get_contents($image);
                    //     $this->db->insert("tbl_pro_img", array("pro_id" => $pro_id, "pro_images" => $rand . ".jpg"));
                    // }

                    $this->db->delete("tbl_product_categories", ["pro_id" => $pro_id]);

                    foreach ($value['multiCat'] as $key => $val) {
                        $getCatId = $this->db->get_where("tbl_categories", ["LOWER(cat_name)" => trim(strtolower($val['cat_id']))])->result();
                        //$getCatId = $this->db->get_where("tbl_categories", ["cat_name" => $val['cat_id']])->result();
                        if ($getCatId != NULL) {
                            $getSubId = $this->db->get_where("tbl_subcategory", ["LOWER(sub_name)" => trim(strtolower($val['sub_id'])), "parent_sub" => 0, "cid" => $getCatId[0]->id])->result();

                            // $getSubId = $this->db->get_where("tbl_subcategory", ["sub_name" => $val['sub_id'], "parent_sub" => 0, "cid" => $getCatId[0]->id])->result();
                            if ($getSubId) {
                                if (isset($val['child_id']) && ($val['child_id'] != null)) {
                                    $getChildId = $this->db->get_where("tbl_subcategory", ["cid" => $getCatId[0]->id, "LOWER(sub_name)" => trim(strtolower($val['child_id'])), "parent_sub" => $getSubId[0]->id])->result();

                                    // $getChildId = $this->db->get_where("tbl_subcategory", ["cid" => $getCatId[0]->id, "sub_name" => $val['child_id'], "parent_sub" => $getSubId[0]->id])->result();
                                    $this->db->insert("tbl_product_categories", ["cat_id" => $getCatId[0]->id, "sub_id" => $getSubId[0]->id, "child_id" => $getChildId[0]->id, "pro_id" => $pro_id]);
                                } else {

                                    $this->db->insert("tbl_product_categories", ["cat_id" => $getCatId[0]->id, "sub_id" => $getSubId[0]->id, "child_id" => 0, "pro_id" => $pro_id]);
                                }
                            } else {
                                $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Sub Category Name is not define </div>");
                                return redirect("Admin/Vendor/BulkUpload");
                            }
                        } else {
                            $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Uploading Failed Due to Invailed category Name, Sub Category Name and Child Category Name etc. </div>");
                            $this->db->cache_delete('Admin', 'SadminLogin');
                            return redirect("Admin/Vendor/BulkUpload");
                        }
                    }
                }
            } else {
                $price_line = $key + 2;
                $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Discount price greater than Actual price on line no : $price_line </div>");
                $this->db->cache_delete('Admin', 'SadminLogin');
                return redirect("Admin/Vendor/BulkUpload");
            }
        }

        //$this->db->insert_batch('tbl_product', $data);
        $this->db->cache_delete_all();
    }


    public function getPropName($data)
    {
        $this->db->cache_delete_all();
        $query = $this->db->get_where("tbl_prop_name", ["LOWER(pop_name)" => strtolower($data)])->result();
        // $query = $this->db->get_where("tbl_prod_prop", ["LOWER(attr_name)" => strtolower($data)])->result();
        if (count($query) > 0) {
            return $query[0];
        } else {
            return NULL;
        }
    }
    public function tbl_prod_propGetId($prop_id, $attr_name, $color_code = '')
    {
        $query = $this->db->get_where("tbl_prod_prop", ["prop_id" => $prop_id, "LOWER(attr_name)" => strtolower($attr_name)])->result();
        if (count($query) > 0) {
            return $query[0];
        } else {
            return NULL;
        }
    }
    public function tblInsertproperty($pro_id, $prop_id)
    {
        foreach ($prop_id as $key => $value) {
            $this->db->insert('tbl_product_property', array('pro_id' => $pro_id, 'property_id' => $value[0]));
        }
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
                // print_r($data);
                // die;
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
            $createArray = array('cat_id', 'pro_name', 'product_sname', 'sku', 'act_price', 'dis_price', 'pro_desc', 'product_attr', 'gst', 'hsn_code', 'tags', 'Sleeve_Length', "neck", "pattern", "occasion", "fabric", 'short_desc', 'type', "property", 'image1', 'image2', 'image3', 'image4', 'image5', 'meta_keyword', 'meta_description', 'title');   //'Sleeve_Length', "neck", "pattern", "occasion", "fabric",
            $makeArray = array('cat_id' => 'cat_id', 'pro_name' => 'pro_name', 'product_sname' => 'product_sname', 'sku' => 'sku', 'act_price' => 'act_price', 'dis_price' => 'dis_price', 'pro_desc' => 'pro_desc', 'product_attr' => 'product_attr', 'gst' => 'gst', 'hsn_code' => 'hsn_code', 'tags' => 'tags', 'Sleeve_Length' => 'Sleeve_Length', "neck" => "neck", "occasion" => "occasion", "fabric" => "fabric", 'short_desc' => 'short_desc', 'type' => 'type', 'meta_keyword' => 'meta_keyword', 'meta_description' => 'meta_description', 'title' => 'title', 'property' => "property", 'image1' => 'image1', 'image2' => 'image2', 'image3' => 'image3', 'image4' => 'image4', 'image5' => 'image5'); //'Sleeve_Length' => 'Sleeve_Length', "neck" => "neck", "occasion" => "occasion", "fabric" => "fabric",
            
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    } else { }
                }
            }
            $data = array_diff_key($makeArray, $SheetDataKey);
            
            if (empty($data)) {
                $flag = 1;
            } else {
                $this->session->set_flashdata("error", "<div class='alert alert-danger'>Column missing ! please upload updated sheet</div>");
            }

            if ($flag == 1) {

                for ($i = 2; $i <= $arrayCount; $i++) {
                    $images = array();
                    $sleevekey = array();
                    $cat_id = $SheetDataKey['cat_id'];
                    $pro_name = $SheetDataKey['pro_name'];
                    $product_sname = $SheetDataKey['product_sname'];

                    $Sleeve_Length = $SheetDataKey['Sleeve_Length'];
                    $neck = $SheetDataKey['neck'];
                    $pattern = $SheetDataKey['pattern'];
                    $occasion = $SheetDataKey['occasion'];
                    $fabric = $SheetDataKey['fabric'];

                    $sku = $SheetDataKey['sku'];
                    // $pro_stock = $SheetDataKey['pro_stock'];
                    $act_price = $SheetDataKey['act_price'];
                    $dis_price = $SheetDataKey['dis_price'];
                    $pro_desc = $SheetDataKey['pro_desc'];
                    $product_attr = $SheetDataKey['product_attr'];
                    $gst = $SheetDataKey['gst'];
                    $hsn_code = $SheetDataKey['hsn_code'];
                    $tags = $SheetDataKey['tags'];
                    $short_desc = $SheetDataKey['short_desc'];

                    $type = $SheetDataKey['type'];
                    $property = $SheetDataKey['property'];
                    $meta_keyword = $SheetDataKey['meta_keyword'];
                    $meta_description = $SheetDataKey['meta_description'];
                    $title = $SheetDataKey['title'];

                    $image1 = $SheetDataKey['image1'];
                    $image2 = $SheetDataKey['image2'];
                    $image3 = $SheetDataKey['image3'];
                    $image4 = $SheetDataKey['image4'];
                    $image5 = $SheetDataKey['image5'];

                    $cat_id = $allDataInSheet[$i][$cat_id] != '' ? $allDataInSheet[$i][$cat_id] : "";
                    $product_sname = $allDataInSheet[$i][$product_sname] != '' ? $allDataInSheet[$i][$product_sname] : "";
                    $meta_keyword = $allDataInSheet[$i][$meta_keyword] != '' ? $allDataInSheet[$i][$meta_keyword] : "";
                    $meta_description = $allDataInSheet[$i][$meta_description] != '' ? $allDataInSheet[$i][$meta_description] : "";
                    $title = $allDataInSheet[$i][$title] != '' ? $allDataInSheet[$i][$title] : "";
                    $Sleeve_Length = $allDataInSheet[$i][$Sleeve_Length] != '' ? $allDataInSheet[$i][$Sleeve_Length] : "";
                    $neck = $allDataInSheet[$i][$neck] != '' ? $allDataInSheet[$i][$neck] : "";
                    $pattern = $allDataInSheet[$i][$pattern] != '' ? $allDataInSheet[$i][$pattern] : "";
                    $occasion = $allDataInSheet[$i][$occasion] != '' ? $allDataInSheet[$i][$occasion] : "";
                    $fabric = $allDataInSheet[$i][$fabric] != '' ? $allDataInSheet[$i][$fabric] : "";
                    $sku = $allDataInSheet[$i][$sku] != '' ? $allDataInSheet[$i][$sku] : 0;
                    // $pro_stock = $allDataInSheet[$i][$pro_stock] != '' ? $allDataInSheet[$i][$pro_stock] : 0;
                    $act_price = $allDataInSheet[$i][$act_price] != '' ? $allDataInSheet[$i][$act_price] : 0.0;
                    $dis_price = $allDataInSheet[$i][$dis_price] != '' ? $allDataInSheet[$i][$dis_price] : 0.0;
                    $pro_desc = $allDataInSheet[$i][$pro_desc] != '' ? addslashes($allDataInSheet[$i][$pro_desc]) : "";
                    $product_attr = $allDataInSheet[$i][$product_attr] != '' ? $allDataInSheet[$i][$product_attr] : null;
                    $property = $allDataInSheet[$i][$property] != '' ? $allDataInSheet[$i][$property] : "";

                    $images[] = $allDataInSheet[$i][$image1] != '' ? $allDataInSheet[$i][$image1] : "";
                    $images[] = $allDataInSheet[$i][$image2] != '' ? $allDataInSheet[$i][$image2] : "";
                    $images[] = $allDataInSheet[$i][$image3] != '' ? $allDataInSheet[$i][$image3] : "";
                    $images[] = $allDataInSheet[$i][$image4] != '' ? $allDataInSheet[$i][$image4] : "";
                    $images[] = $allDataInSheet[$i][$image5] != '' ? $allDataInSheet[$i][$image5] : "";
                    $specification = [];

                    $specification[] = $Sleeve_Length;
                    $specification[] = $neck;
                    $specification[] = $pattern;
                    $specification[] = $occasion;
                    $specification[] = $fabric;

                    $categories = explode(";", $cat_id);
                    
                    $arr2 = [];
                    foreach ($categories as $key => $val) {
                        //$innerSide2 = [];
                        $multiCat = explode("|", $val);

                        if (count($multiCat) <= 2) {
                            $arr2[] = ['cat_id' => $multiCat[0], 'sub_id' => $multiCat[1]];
                        } else {
                            $arr2[] = ['cat_id' => $multiCat[0], 'sub_id' => $multiCat[1], 'child_id' => $multiCat[2]];
                        }
                    }


                        $response = explode(";", $product_attr);
                        
                        $arr = [];
                        $total_qty = 0;
                        foreach ($response as $key => $value) {
                            $innerSide = [];
                            $inner = explode("|", $value);
                            $size = explode(":", $inner[0]);
                            @$innerSide["attribute"][] = [$size[0] => $size[1]];
                            $innerSide["qty"] = isset($inner[1]) ? intval(explode(":", (isset($inner[1]) ? $inner[1] : 0))[1]) : "";
                            $total_qty += floatval($innerSide["qty"]);
                            $innerSide["changedPrice"] = "";
                            $arr["response"][] = $innerSide;
                        }
                    

                    $new_product_attr = json_encode($arr);


                    $gst = $allDataInSheet[$i][$gst] != '' ? $allDataInSheet[$i][$gst] : "";
                    $hsn_code = $allDataInSheet[$i][$hsn_code] != '' ? $allDataInSheet[$i][$hsn_code] : "";
                    $tags = $allDataInSheet[$i][$tags] != '' ? $allDataInSheet[$i][$tags] : "";
                    $short_desc = $allDataInSheet[$i][$short_desc] != '' ? addslashes($allDataInSheet[$i][$short_desc]) : "";


                    $pro_name = $allDataInSheet[$i][$pro_name] != '' ? ucfirst(strtolower(addslashes($allDataInSheet[$i][$pro_name]))) : '';
                    $arrayOfPropTable = [];
                    $propery_arr = explode(";", $property);

                    $dat = [];
                    
                    foreach ($propery_arr as $key => $value) 
                    {
                        $names = explode(":", $value);
                        $propname = $names[0]; // COLOR
                        @$attr_name = $names[1]; // color code   

                        $prop_id = $this->getPropName($propname);

                        if ($prop_id != '' && $prop_id != NULL) {
                            $dat = (array) $this->tbl_prod_propGetId($prop_id->id, $attr_name);
                        } else {
                            $this->session->set_flashdata("msg", '<div class="alert  alert-danger">
                            Colors are not define : ' . $i . '.
                            </div>');
                            //return redirect('Admin/Vendor/BulkUpload');
                        }

                        if ($dat != '' && $dat != NULL) {
                            $arrayOfPropTable[] = [$dat['id'], $sku];
                        } else {
                            $this->session->set_flashdata("msg", '<div class="alert  alert-danger">
                            Attributes are not define : ' . $i . '
                       </div>');
                            // return redirect('Admin/Vendor/BulkUpload');
                        }
                    }


                    $fetchData[] = array("vendor_id" => 29, "specification" => $specification, "product_sname" => $product_sname, "meta_keyword" => $meta_keyword, "pro_stock" => $total_qty, "meta_description" => $meta_description, "title" => $title, "type" => $type, "images" => $images, 'multiCat' => $arr2, 'pro_name' => $pro_name, 'sku' => $sku, 'isBranded' => 0, 'in_stock' => 1, 'act_price' => $act_price, 'dis_price' => $dis_price, 'pro_desc' => $pro_desc, 'product_attr' => $new_product_attr, "pro_sta" => 1, "gst" => $gst, "hsn_code" => $hsn_code, "txt_msg" => $tags, "short_desc" => $short_desc, "visible_from_date" => date("Y-m-d"), "attributes" => $arrayOfPropTable);
                    // echo "<pre>";
                    // print_r($fetchData);
                    // die;
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
            return redirect('Admin/Vendor/BulkUpload');
        }
    }
}
