<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('getUserProfile')) {

    function getUserProfile($id)
    {
        $CI = &get_instance();
        if ($CI->session->userdata('signupSession')) {
            return $CI->db->get_where('tbl_signups', array('id' => $id))->result()[0];
        } else {
            return "No direct access";
        }
    }
}

if (!function_exists('checkcartItem')) {

    function checkcartItem($dbCart,$sessionProd,$qty)
    {
        $CI = &get_instance();
        foreach ($dbCart as $key => $value) {
            if($value->product == $sessionProd){
               return $key;
            }
        }
    return -1 ;
    }

}


if (!function_exists('getOfferDetails')) {

    function getOfferDetails($id)
    {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_offer_code', array('id' => $id))->result();
    }
}


if (!function_exists('getReturnTable')) {

    function getReturnTable($id)
    {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_return', array('order_id' => $id))->result();
    }
}





if (!function_exists('getSubCate_Byid')) {

    function getSubCate_Byid($id)
    {
        $CI = &get_instance();
        if ($CI->session->userdata('signupSession')) {
            return $CI->db->get_where('tbl_subcategory', array('cid' => $id, "parent_sub" => 0))->result();
        } else {
            return "No direct access";
        }
    }
}
if (!function_exists('getchild_Byid')) {

    function getchild_Byid($id)
    {
        $CI = &get_instance();
        if ($CI->session->userdata('signupSession')) {
            return $CI->db->get_where('tbl_subcategory', array('parent_sub' => $id))->result();
        } else {
            return "No direct access";
        }
    }
}

if (!function_exists('getSubcount')) {

    function getSubcount($id)
    {
        $CI = &get_instance();
        return $CI->db->get_where("tbl_subcategory", ["parent_sub" => $id])->result();
    }
}

if (!function_exists('getChildCategory')) {

    function getChildCategory($id)
    {
        $CI = &get_instance();
        $dat = $CI->db->get_where('tbl_subcategory', array('id' => $id))->result()[0];
        return $dat;
    }
}


if (!function_exists("getImageCount")) {

    function getImageCount($product)
    {
        $CI = &get_instance();
        $CI->load->model('Admin_model');
        if ($CI->Admin_model->getImages($product)) {
            return count($CI->Admin_model->getImages($product));
        } else {
            return 0;
        }
    }
}
if (!function_exists("getPropertyName")) {

    function getPropertyName($pop_name, $attr)
    {
        $CI = &get_instance();
        return  $CI->db->select("*")->from("tbl_prop_name")->join("tbl_prod_prop", "tbl_prop_name.id=tbl_prod_prop.prop_id")->where(array("tbl_prop_name.pop_name" => $pop_name, "tbl_prod_prop.attr_name!=" => $attr))->get()->result();
    }
}
if (!function_exists("getBrandCount")) {

    function getBrandCount($vendor_id, $isBranded, $brand_name)
    {
        $CI = &get_instance();
        $count = $CI->db->get_where('tbl_product', array('vendor_id' => $vendor_id, "isBranded" => 1, "brand_name" => $brand_name))->result();
        if (count($count) > 1) {
            return 1;
        } else {
            return 0;
        }
    }
}

if (!function_exists("getGroupname")) {

    function getGroupname($id)
    {
        $CI = &get_instance();
        $id = $CI->encryption->decrypt(decode(($id)));
        return $CI->db->select("*,tbl_group_list.group_name as grp_name")->from("tbl_group_list")->join("customer_group", "tbl_group_list.id=customer_group.group_name")->where("customer_group.user_id=", $id)->get()->result();
    }
}
if (!function_exists('getProductImage')) {

    function getProductImage($id)
    {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_pro_img', array('pro_id' => $id))->result()[0]->pro_images;
    }
}

if (!function_exists('getAllOrder')) {

    function getAllOrder($id)
    {
        $CI = &get_instance();
        $CI->load->model('user_model');
        return $CI->user->allOrdersOrderId($id);
    }
}

if (!function_exists('getDispatchOrder')) {

    function getDispatchOrder($id)
    {
        $CI = &get_instance();
        $CI->load->model('user_model');
        return $CI->user->allDispatchOrderId($id);
    }
}

if (!function_exists('getFaildOrder')) {

    function getFaildOrder($id)
    {
        $CI = &get_instance();
        $CI->load->model('user_model');
        return $CI->user->allFaildOrderId($id);
    }
}

if (!function_exists('getOrder')) {

    function getOrder($id)
    {
        $CI = &get_instance();
       $qry = $CI->db->select('*,tbl_order.id as OID')->from('tbl_order')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where('tbl_order.id',$id)->get()->result();
        if(count($qry) > 0){
            return $qry[0];
        }else{
            return false;
        }
    }
}

if (!function_exists('getCancelOrder')) {

    function getCancelOrder($id)
    {
        $CI = &get_instance();
       $qry = $CI->db->get_where('tbl_cancle',array('order_id' => $id))->result();
        if(count($qry) > 0){
            return $qry[0];
        }else{
            return false;
        }
    }
}


if (!function_exists('getExchangeCancelled')) {

    function getExchangeCancelled($id)
    {
        $CI = &get_instance();
        $qry = $CI->db->get_where('tbl_exchangerejected',array('order_id' => $id))->result();
        if(count($qry) > 0){
            return $qry[0];
        }else{
            return false;
        }
    }
}


if (!function_exists('getQuantity')) {

    function getQuantity($id)
    {
        $CI = &get_instance();
        // $qry = $CI->db->get_where('tbl_order',array('pro_id' => $id))->result();
        $qry = $CI->db->join("tbl_customer_order", "tbl_customer_order.id = tbl_order.order_id")->get_where('tbl_order',array('pro_id' => $id, 'pay_sta' => 1))->result();
        if(count($qry) > 0){
            return $qry;
        }else{
            return false;
        }
    }
}