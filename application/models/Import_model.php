<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Import_model extends CI_Model
{

    private $_batchImport;
    private $arr;

    public function __construct()
    {
        parent::__construct();

    }

    public function setBatchImport($batchImport)
    {
        $this->_batchImport = $batchImport;
    }

    private function original($image)
    {     
        
      
         
        $config['width'] = '300';
        $config['maintain_ratio'] = true;
        $config['source_image'] = './userupload/' . $image;
        $config['new_image'] = './uploads/original/' . $image; // encrypted name
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
       
        $this->image_lib->initialize($config);
        if ($this->image_lib->resize()) {

            $this->thumbnail($image);

        } else {
            echo $this->image_lib->display_errors();
            die;
        }
    }


    private function resize($image)
    {
        
        $config['width'] = '300';
        $config['maintain_ratio'] = true;
        $config['source_image'] = FCPATCH.'/uploads/original/' . $image;
        $config['new_image'] = FCPATCH.'/uploads/resized/resized_' . $image;// encrypted name
        $this->image_lib->initialize($config);
        if ($this->image_lib->resize()) {
            $this->thumbnail($image);
        } else {
            echo $this->image_lib->display_errors();
        }
    }

    private function thumbnail($image)
    {
        
        $config['width'] = '100';
        $config['maintain_ratio'] = true;
        $config['maintain_ratio'] = true;
        $config['create_thumb'] = true;
        $config['source_image'] = './uploads/original/' . $image;
        $config['new_image'] = './uploads/thumbs/thumb_' . $image;// encrypted name
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
        
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }

    // save data
    public function importData()
    {

        $data = $this->_batchImport;
        foreach ($data as $value) {
        
            $count = $this->db->get_where("tbl_product", ["sku" => $value["sku"]])->result();       
            if (count($count) == 0) {

                foreach ($value['images'] as $img) {
                     $this->original($img);
                     $this->resize($img);
                     $this->thumbnail($img);
                    // $this->db->insert("tbl_pro_img", ["pro_id" => $id, "pro_images" => $img]);  
                  }

             $this->db->insert("tbl_product", ["vendor_id" => $value["vendor_id"], "type" => $value["type"], "pro_name" => addslashes($value["pro_name"]), "sku" => $value["sku"], "in_stock" => $value["in_stock"], "act_price" => $value["act_price"], "dis_price" => $value["dis_price"], "pro_desc" => $value["pro_desc"], "product_attr" => $value["product_attr"], "pro_sta" => $value["pro_sta"], "gst" => $value["gst"], "hsn_code" => $value["hsn_code"],"short_desc" => $value["short_desc"], "size_chart" => $value["size_chart"], "visible_from_date" => $value["visible_from_date"]]);
             $id = $this->db->insert_id();

              
            
                foreach ($value['multiCat'] as $key => $val) {                  
                    $getCatId = $this->db->get_where("tbl_categories", ["cat_name" => $val['cat_id']])->result();    
                    $getSubId = $this->db->get_where("tbl_subcategory", ["sub_name" => $val['sub_id'],"parent_sub" => 0,"cid" => $getCatId[0]->id])->result(); 
                   
                   if(isset($val['child_id']) && ($val['child_id'] != NULL)){
                    $getChildId = $this->db->get_where("tbl_subcategory", ["cid" => $getCatId[0]->id,"sub_name" => $val['child_id'],"parent_sub" => $getSubId[0]->id])->result(); 
                    $this->db->insert("tbl_product_categories", ["cat_id" => $getCatId[0]->id, "sub_id" => $getSubId[0]->id,"child_id" => $getChildId[0]->id,"pro_id"=>$id]);  
                    
                 }else{
                   
                    $this->db->insert("tbl_product_categories", ["cat_id" => $getCatId[0]->id, "sub_id" => $getSubId[0]->id,"child_id"=>0,"pro_id"=>$id]);
                    
                   }
                   
                }

                foreach ($value["attributes"] as $key => $value1) {
                    $this->db->insert("tbl_product_property", ["pro_id" => $id, "property_id" => $value1[0]]);
                }
                // foreach ($value["images"] as $image) {
                //     $rand = mt_rand(99, 999) . time();
                //     copy($image, FCPATH . 'uploads/' . $rand . '.jpg');
                //     $this->db->insert("tbl_pro_img", array("pro_id" => $id, "pro_images" => $rand . ".jpg"));

                // }

            } else {
                $pro_id = $count[0]->id;
                $this->db->update("tbl_product", ["vendor_id" => $value["vendor_id"], "type" => $value["type"], "pro_name" => addslashes($value["pro_name"]), "sku" => $value["sku"], "in_stock" => $value["in_stock"], "act_price" => $value["act_price"], "dis_price" => $value["dis_price"], "pro_desc" => $value["pro_desc"], "product_attr" => $value["product_attr"], "pro_sta" => $value["pro_sta"], "gst" => $value["gst"], "hsn_code" => $value["hsn_code"], "short_desc" => $value["short_desc"], "size_chart" => $value["size_chart"], "visible_from_date" => $value["visible_from_date"]], ["id" => $pro_id]);
                foreach ($value["attributes"] as $key => $value1) {
                    $this->db->delete("tbl_product_property", ["pro_id" => $pro_id, "property_id" => $value1[0]]);
                    $this->db->insert("tbl_product_property", ["pro_id" => $pro_id, "property_id" => $value1[0]]);
                }

                // $this->db->delete("tbl_pro_img", ["pro_id" => $pro_id]);
                // foreach ($value["images"] as $image) {
                //     $rand = mt_rand(99, 999) . time();
                //     $content = file_get_contents($image);                  
                //     $this->db->insert("tbl_pro_img", array("pro_id" => $pro_id, "pro_images" => $rand . ".jpg"));
                // }

                $this->db->delete("tbl_product_categories", ["pro_id" => $pro_id]);
               
                foreach ($value['multiCat'] as $key => $val) {                  
                    $getCatId = $this->db->get_where("tbl_categories", ["cat_name" => $val['cat_id']])->result();    
                    $getSubId = $this->db->get_where("tbl_subcategory", ["sub_name" => $val['sub_id'],"parent_sub" => 0,"cid" => $getCatId[0]->id])->result(); 
                   
                   if(isset($val['child_id']) && ($val['child_id'] != NULL)){
                    $getChildId = $this->db->get_where("tbl_subcategory", ["cid" => $getCatId[0]->id,"sub_name" => $val['child_id'],"parent_sub" => $getSubId[0]->id])->result(); 
                    $this->db->insert("tbl_product_categories", ["cat_id" => $getCatId[0]->id, "sub_id" => $getSubId[0]->id,"child_id" => $getChildId[0]->id,"pro_id"=>$pro_id]);  
                    
                 }else{
                   
                    $this->db->insert("tbl_product_categories", ["cat_id" => $getCatId[0]->id, "sub_id" => $getSubId[0]->id,"child_id"=>0,"pro_id"=>$pro_id]);
                    
                   }
                   
                }
            }
        }

        //$this->db->insert_batch('tbl_product', $data);
        $this->db->cache_delete_all();
    }

    public function getPropName($data)
    {
        $this->db->cache_delete_all();
        return $this->db->get_where("tbl_prop_name", ["LOWER(pop_name)" => strtolower($data)])->result()[0];
    }
    public function tbl_prod_propGetId($prop_id, $attr_name, $color_code = '')
    {
        $query = $this->db->get_where("tbl_prod_prop", ["prop_id" => $prop_id, "LOWER(attr_name)" => strtolower($attr_name)])->result()[0];
        return $query;
    }
    public function tblInsertproperty($pro_id, $prop_id)
    {
        foreach ($prop_id as $key => $value) {
            $this->db->insert('tbl_product_property', array('pro_id' => $pro_id, 'property_id' => $value[0]));
        }

    }
}
