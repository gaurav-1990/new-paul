<?php

if (!function_exists("encode")) {

    function encode($str)
    {
        return $value = str_replace('=', '-', str_replace('/', '_', ($str)));
    }
}
if (!function_exists("decode")) {

    function decode($str)
    {
        return $value = (str_replace('-', '=', str_replace('_', '/', $str)));
    }
}

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('getProductImage')) {

    function getProductImage($id)
    {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_pro_img', array('pro_id' => $id))->result()[0]->pro_images;
    }
}


if (!function_exists('getAllProductImage')) {

    function getAllProductImage($id)
    {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_pro_img', array('pro_id' => $id, 'img_sta' => 0))->result();
    }
}
if (!function_exists('getAllCategory')) {

    function getAllCategory()
    {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_categories', array('cat_sta' => 1))->result();
    }
}

if (!function_exists('getProduct')) {

    function getProduct($id)
    {
        $CI = &get_instance();
        return $CI->db->select('*,tbl_product.id as ID,tbl_product.gst as gst')->from("tbl_product_categories")->JOIN("tbl_product", "tbl_product_categories.pro_id=tbl_product.id")->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('tbl_product.id' => $id))->where(array('tbl_product.pro_sta' => 1))->get()->result()[0];

        // return $CI->db->get_where('tbl_product', array('id' => $id))->result()[0];
    }
}
if (!function_exists('getAttrName')) {

    function getAttrName($id)
    {
        $CI = &get_instance();
        $res = $CI->db->select('*')->from('tbl_set_property')->join('tbl_prod_prop', 'tbl_prod_prop.id=tbl_set_property.attr_id')->where(array('tbl_set_property.id' => $id))->get()->result();
        return $res[0]->attr_name;
    }
}



if (!function_exists("getReview")) {

    function getReview($pro, $email)
    {
        $CI = &get_instance();
        $count = $CI->db->get_where('tbl_review', array('pro_id' => $pro, "useremail" => $email))->result();
        if (count($count) > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}

if (!function_exists("getUser")) {

    function getUser($app_id)
    {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_user_reg', array('app_id' => $app_id))->result()[0];
    }
}
if (!function_exists("getUserByEmail")) {

    function getUserByEmail($email)
    {
        $CI = &get_instance();
        if($email!=null) {

            return $CI->db->get_where('tbl_user_reg', array('user_email' => $email))->result()[0];
        }else {
            return $CI->db->get_where('tbl_user_reg', array('app_id' =>$CI->session->userdata('app_id') ))->result()[0];
        }
    }
}

if (!function_exists("getAllColor")) {

    function getAllColor($sid)
    {
        $CI = &get_instance();
        $res = $CI->db->query("select count(*) as procount, color,color_label from tbl_product where sub_id = $sid group by color,color_label")->result();

        if (count($res) > 0) {
            return $res;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists("getAllOffer")) {

    function getAllOffer($id)
    {
        // print_r($id);die;
        $CI = &get_instance();
        $res = $CI->db->get_where("tbl_offer_code", array("id" => $id))->result();
        
        if (count($res) > 0) {
            return $res;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists("couponApplyOn")) {

    function couponApplyOn($id)
    {
        $CI = &get_instance();
        $res = $CI->db->select("*")->from("tbl_offer_code")->join("tbl_offer_product", "tbl_offer_product.offer_id = tbl_offer_code.id")->where("tbl_offer_code.id=", $id)->get()->result();
        if (count($res) > 0) {
            return $res;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists("getUpdatePrime")) {

    function getUpdatePrime($email)
    {
        $CI = &get_instance();
        return $CI->db->update('tbl_user_reg', array('is_prime' => 0, 'prime_date' => strtotime(date("0000-00-00"))), array('user_email' => $email));
        //$CI->db->cache_delete('Admin', 'SadminLogin');
    }
}
if (!function_exists("getAttributes")) {

    function getAttributes($id)
    {
        $CI = &get_instance();
        return $CI->db->get_where("tbl_prod_prop", array("prop_id" => $id))->result();
    }
}

if (!function_exists("dynFilter")) {
    function dynFilter($prop, $counters,$link)
    {
        $CI = &get_instance();
        $specif = $prop;
        $results = $CI->user->getProps($specif);
        $allSpe = array_unique($results);

        $count = 1;
        $html = '';
        foreach ($allSpe as $res) {  
                
            if ($res != '') {
                if($res != 'NA'){
                $name = strtolower(str_replace(" ", "", $specif));
                $value = strtolower(str_replace(" ", "", $res));
                $checked= "";
                    if(isset($link[$name]) && $link[$name]     )
                    {
                       $liva =  explode(":",$link[$name]);
                        foreach ($liva as $li) {
                            if($li==$value) {
                                $checked = "checked";
                                break;
                            }
                        }
                    }
                $html .= <<<EOD
        <div class="custom-control custom-checkbox">
             <input type="checkbox" class="custom-control-input"  name="$name" $checked value="$value" id="upperdefaultUnchecked{$counters}{$count}">
            <label class="custom-control-label"  for="upperdefaultUnchecked{$counters}{$count}">$res</label>
        </div>

EOD;
                $count++;
            }
        }
        }
        echo $html;
    }
}
if (!function_exists("getDataElement")) {

    function getDataElement($id)
    {
        $CI = &get_instance();
        $data = $CI->db->select("*")->from("tbl_product_property")->join("tbl_prod_prop", "tbl_prod_prop.id=tbl_product_property.property_id")->JOIN("tbl_prop_name", "tbl_prop_name.id=tbl_prod_prop.prop_id")->where(array("tbl_product_property.pro_id" => $id))->get()->result();
        $string = "";

        foreach ($data as $key => $value) {
            if ($value->catalog_type == 2) {
                $string .= "data-" . strtolower(str_replace(" ", "", $value->pop_name)) . "=" . $value->color_code . " ";
            } else {
                $string .= "data-" . strtolower(str_replace(" ", "", $value->pop_name)) . "=" . strtolower(str_replace(" ", "", $value->attr_name)) . " ";
            }
        }
        return $string;
    }
}
if (!function_exists("getBrand")) {

    function getBrand($id)
    {
        $CI = &get_instance();
        return $CI->db->select("*")->from("tbl_product_property")->join("tbl_prod_prop", "tbl_prod_prop.id=tbl_product_property.property_id")->JOIN("tbl_prop_name", "tbl_prop_name.id=tbl_prod_prop.prop_id")->where(array("tbl_product_property.pro_id" => $id))->get()->result();
    }
}
if (!function_exists("getSpecifications")) {

    function getSpecifications($id)
    {

        $CI = &get_instance();
        $data = $CI->db->select("*")->from("tbl_specification")->where(array("pro_id" => $id))->get()->result();

        $string = "";

        foreach ($data as $key => $spe) {
            $string .= "data-" . strtolower(str_replace(" ", "", $spe->skey)) . "=" . strtolower(str_replace(" ", "",  $spe->value)) . " ";
        }
        return $string;
    }
}

if (!function_exists("getChild")) {

    function getChild($id)
    {
        $CI = &get_instance();
        return  $CI->db->get_where("tbl_subcategory", array("id" => $id))->result()[0];
    }
}

if (!function_exists("getSimilarProd")) {

    function getSimilarProd($id)
    {
        $CI = &get_instance();
        return $query = $CI->db->select("*,tbl_related_product.relate_pro_id as PID")->from("tbl_related_product")->join("tbl_product", "tbl_product.id=tbl_related_product.relate_pro_id")->join("tbl_product_categories", "tbl_product_categories.pro_id=tbl_product.id")->join("tbl_subcategory", "tbl_subcategory.id=tbl_product_categories.sub_id")->where("tbl_related_product.pro_id", $id)->group_by("tbl_product.id")->get()->result();
    }
}
if (!function_exists("getLikedProdId")) {

    function getLikedProdId($id)
    {
        $CI = &get_instance();

        return $query = $CI->db->select("*,tbl_cross_sell.cross_pro_id as PID")->from("tbl_cross_sell")->join("tbl_product", "tbl_product.id=tbl_cross_sell.cross_pro_id")->join("tbl_product_categories", "tbl_product_categories.pro_id=tbl_product.id")->join("tbl_subcategory", "tbl_subcategory.id=tbl_product_categories.sub_id")->where("tbl_cross_sell.pro_id", $id)->group_by("tbl_product.id")->get()->result();
    }
}
if (!function_exists("getSimProduct")) {

    function getSimProduct($id)
    {
        $CI = &get_instance();
        return $CI->db->get_where("tbl_product", ["id" => $id])->result();
    }
}

if (!function_exists("getSpecification")) {

    function getSpecification($sid)
    {

        $CI = &get_instance();
        $prop = [];
        $query = $CI->db->get_where('tbl_product_categories', array("sub_id" => $CI->encryption->decrypt(decode($sid))))->result();
        //$this->encryption->decrypt(decode($this->uri->segment(3)));
        foreach ($query as $qry) {
            $CI->db->distinct();
            $CI->db->select('*');
            $result = $CI->db->get_where('tbl_specification', array('pro_id' => $qry->pro_id))->result();
            foreach ($result  as $val) {
                if($val->value != 'NA'){
                $prop[] = $val->skey;
                }
            }
        }
        return $prop;
    }
}
if (!function_exists("getChildSpecif")) {

    function getChildSpecif($sid)
    {

        $CI = &get_instance();
        $prop = [];
        $query = $CI->db->get_where('tbl_product_categories', array("child_id" => $CI->encryption->decrypt(decode(($sid)))))->result();

        foreach ($query as $qry) {
            
            $CI->db->distinct();
            $CI->db->select('*');
            $result = $CI->db->get_where('tbl_specification', array('pro_id' => $qry->pro_id))->result();
            foreach ($result  as $val) {
               
                if($val->value != 'NA'){
                $prop[] = $val->skey;
                }
            }
         
        }
        return $prop;
    }
}


// To Return
if (!function_exists("getreturnproduct")) {
    function getreturnproduct($orderid)
    {
        $CI = &get_instance();
        return $data = $CI->db->get_where('tbl_return', array('order_id' => $orderid))->result();
        // print_r($data); die;
    }
}

// To Exchange
if (!function_exists("getexchangeproduct")) {
    function getexchangeproduct($orderid)
    {
        $CI = &get_instance();
        return $data = $CI->db->get_where('tbl_exchange', array('order_id' => $orderid))->result();
        // print_r($data); die;
    }
}
// To Review
if (!function_exists("getreviewproduct")) {
    function getreviewproduct($orderid)
    {
        // print_r($orderid); die;
        $CI = &get_instance();
        $data = $CI->db->get_where('tbl_review', array('order_id' => $orderid))->result();
        // print_r($data); die;
        return $data;
    }
}
if (!function_exists("countCoupon")) {
    function countCoupon($cid)
    {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_offer_customer', array('offer_id' => $cid, 'user_email' => $CI->session->userdata('myaccount')))->result();

        // print_r($data); die;
    }
}
if (!function_exists("getWallet")) {
    function getWallet()
    {
        $CI = &get_instance();
        $CI->load->model("User_model", "user");
        $debit =  $CI->user->getDebitWalletAmt();
        $credit =  $CI->user->getCreditWalletAmt();
        $total = ($credit[0]->wallet_amt) - $debit[0]->wallet_amt;
        return $total > 0 ? $total : 0;
    }
}
if (!function_exists("getUserIdByEmail")) {
    function getUserIdByEmail()
    {
        $CI = &get_instance();
        $CI->load->model("User_model", "user");
       return $CI->user->getUserIdByEmail();
        
    }
}

if (!function_exists("load_subscription")) {
    function load_subscription()
    {
        $CI = &get_instance();
        $CI->load->model("User_model", "user");
       return $CI->user->load_subscription();
        
    }
}

if (!function_exists("getUserProfile")) {
    function getUserProfile($user)
    {
        $CI = &get_instance($user);
        $CI->load->model("User_model", "user");
       return $CI->user->get_profile($user);
        
    }
}

if (!function_exists("getwishProduct")) {
    function getwishProduct($orderid)
    {
        $CI = &get_instance();
        $data = $CI->db->get_where('tbl_product', array('id' => $orderid))->result();
        return $data;
    }
}