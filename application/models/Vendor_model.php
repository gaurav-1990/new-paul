<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vendor_model extends CI_Model
{

    public $role, $userid;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
        $this->role = $this->session->userdata('signupSession')['role'];
        $this->userid = $this->session->userdata('signupSession')['id'];
        $this->load->helper('getinfo');
        $this->load->helper('checkout');
        // if (!$this->session->userdata('signupSession')) {
        //     return redirect('Admin/Loginvendor');
        // } else {
        //     $this->role = $this->session->userdata('signupSession')['role'];
        //     $this->userid = $this->session->userdata('signupSession')['id'];
        //     $this->load->helper('getinfo');
        // }
    }

    public function is_chart($sub)
    {
        return $this->db->get_where("tbl_subcategory", ["id" => $sub])->result()[0];
    }

    public function addSpecification($post)
    {

        $this->db->delete("tbl_specification", array("pro_id" => $this->encryption->decrypt(decode($post["pro_id"]))));
        foreach ($post["key"] as $key => $value) {
            $query = $this->db->insert("tbl_specification", ["pro_id" => $this->encryption->decrypt(decode($post["pro_id"])), "skey" => $value, "value" => $post["value"][$key]]);
        }
        return $query;
    }

    public function vendorInvoice($data)
    {
        $vendor = $data["vendor"];
        $year = $data["year"];
        $month = sprintf("%02d", $data["month"]);
        $fromdate = $year . "-" . $month . "-" . "01";
        $todate = $year . "-" . $month . "-" . "31";

        $this->db->where('inv_date >=', $fromdate);
        $this->db->where('inv_date <=', $todate);
        $this->db->where('vendor_id =', $vendor);
        $this->db->join('tbl_signups', 'tbl_signups.id=vendor_invoice.vendor_id');
        return $data = $this->db->select('*,tbl_signups.state as ven_state')->from('vendor_invoice')->get()->result();
    }

    public function addVendorShipping($post, $pins, $vendor_id)
    {

        $this->db->delete('tbl_ven_ship', array('ven_id' => $vendor_id, 'state' => $post['state'], 'city' => $post['city']));
        $this->db->insert('tbl_ven_ship', array('ven_id' => $vendor_id, 'state' => $post['state'], 'city' => $post['city'], 'max_days' => $post['max_days'], 'ship_amt' => $post['ship_amt'], 'same_amt' => $post['same_amt']));
        $id = $this->db->insert_id();

        foreach ($pins as $pin) {
            $query = $this->db->insert('tbl_ven_ship_pin', array('ship_id' => $id, 'pin_code' => $pin));
        }
        if ($query) {
            return true;
        }

        return false;
    }

    public function addAwb($orderId, $awb, $deliverSta)
    {
        if ($deliverSta != 7) {
            return $this->db->update('tbl_order', array('awb_no' => $awb, 'order_status' => $deliverSta), array('id' => $orderId));
        } else {
            return $this->db->update('tbl_order', array('awb_no' => $awb, "delivery_date" => date("Y-m-d H:i"), 'order_status' => $deliverSta), array('id' => $orderId));
        }
    }

    public function addAwbOthershiped($orderId, $awb, $deliverSta)
    {
        $res = $this->db->get_where('tbl_order',['id' => $orderId])->result()[0];
        
        $qry = $this->db->update('tbl_order', array('awb_no' => $awb, 'order_status' => $deliverSta), array('id' => $orderId));
        return $this->db->update('tbl_customer_order', array('order_sta' => $deliverSta, 'shipping_awb' => $awb), array('id' => $res->order_id));
    }

    public function addAwbOther($orderId, $deliverSta, $where)
    {
        $res = $this->db->get_where('tbl_order',['id' => $orderId])->result()[0];
        if($deliverSta == 2 || $deliverSta == 1 || $deliverSta == 7){
            $this->db->update('tbl_customer_order', array('order_sta' => $deliverSta), array('id' => $res->order_id));
        }
        if ($deliverSta != 7) {
            $query = $this->db->update('tbl_order', array('order_status' => $deliverSta), array('id' => $orderId));
        } else if ($deliverSta == 2) {
            $query = $this->db->update('tbl_order', array('order_status' => $deliverSta, "shipping_date" => date("Y-m-d H:i")), array('id' => $orderId));
        } else {
            $query = $this->db->update('tbl_order', array('order_status' => $deliverSta, "delivery_date" => date("Y-m-d H:i")), array('id' => $orderId));
        }
        // if ($where != 0) {
        //     $query = $this->db->update('tbl_return', array('admin_date' => date("Y-m-d H:i:s")), array('order_id' => $orderId));
        // }
        // if ($where == 2) {
        //     $query = $this->db->update('tbl_wallet', array('admin_date' => date("Y-m-d H:i:s"), 'is_display' => 1), array('order_id' => $orderId));
        // }
            
        return $query;
    }

    public function addAwbOther2($orderId, $deliverSta)
    {
        return $this->db->update('tbl_customer_order', array('order_sta' => $deliverSta), array('id' => $orderId));
    }
    public function insBagShipAmt($post)
    {
        return $this->db->update('tbl_customer_order', array('bag_ship_amt' => $post['amt']), array('id' => $post['oid']));
    }

    public function loadShip($vend)
    {
        return $this->db->get_where('tbl_ven_ship', array('ven_id' => $vend))->result();
    }

    public function deletePin($vend)
    {
        return $this->db->delete('tbl_ven_ship_pin', array('id' => $vend));
    }

    public function deleteCity($vend)
    {
        $this->db->delete('tbl_ven_ship', array('id' => $vend));
        $this->db->delete('tbl_ven_ship_pin', array('ship_id' => $vend));
        return true;
    }

    public function deleteRequestedProduct($id)
    {
        return $this->db->delete('tbl_product', array('id' => $id));
    }

    public function loadZip($id)
    {
        return $this->db->get_where('tbl_ven_ship_pin', array('ship_id' => $id))->result();
    }

    public function userOrderByVendor($offset = 0, $total)
    {
        $start = ($offset + $total - 1) < $total ? 0 : ($offset + $total - 1);
        $query = $this->db->query("select *,tbl_customer_order.id as OID from  tbl_customer_order where pay_sta=1 order by tbl_customer_order.id desc  limit $start,$total")->result();
        //  $query =  $this->db->select('*,tbl_customer_order.id as OID')->from('tbl_customer_order')->where(["pay_sta" => 1])->limit($limit, $start)->get()->result();
        // echo $this->db->last_query();die;
        return $query;
    }
    public function userdispatchOrder($offset = 0, $total)
    {
        $start = ($offset + $total - 1) < $total ? 0 : ($offset + $total - 1);
        $query = $this->db->query("select *,tbl_customer_order.id as OID from  tbl_customer_order where order_sta=1 order by tbl_customer_order.id desc  limit $start,$total")->result();
        //  $query =  $this->db->select('*,tbl_customer_order.id as OID')->from('tbl_customer_order')->where(["pay_sta" => 1])->limit($limit, $start)->get()->result();
        return $query;
    }
    public function userfaildOrder($offset = 0, $total)
    {
        $start = ($offset + $total - 1) < $total ? 0 : ($offset + $total - 1);
        $query = $this->db->query("select *,tbl_customer_order.id as OID from  tbl_customer_order where pay_sta=0 order by tbl_customer_order.id desc  limit $start,$total")->result();
        //  $query =  $this->db->select('*,tbl_customer_order.id as OID')->from('tbl_customer_order')->where(["pay_sta" => 1])->limit($limit, $start)->get()->result();
        return $query;
    }

    public function gavAllOrder($offset = 0, $total)
    {
        $start = ($offset + $total - 1) < $total ? 0 : ($offset + $total - 1);
        //$this->db->limit($limit,$start);
        return $this->db->select('*,tbl_order.id as OID')->from('tbl_order')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->get()->result();
    }

    public function userOrderVendorCSV()
    {
        $query = $this->db->select('*')->from('tbl_customer_order')->where(["pay_sta" => 1])->get()->result();
        return $query;
    }

    public function productCSV()
    {
        $query = $this->db->select('*')->from('tbl_product')->get()->result();
        return $query;
    }

    public function userOrderByVendorCount()
    {
        return count($this->db->select('*,tbl_customer_order.id as OID')->from('tbl_customer_order')->where(["pay_sta" => 1])->get()->result());
    }
    public function userFailOrderByVendorCount()
    {
        return count($this->db->select('*,tbl_customer_order.id as OID')->from('tbl_customer_order')->where(["pay_sta" => 0])->get()->result());
    }
    public function dispatchOrderCount()
    {
        return count($this->db->select('*,tbl_customer_order.id as OID')->from('tbl_customer_order')->where(["order_sta" => 1])->get()->result());
    }

    // public function userOrderByVendor($id)
    // {
    //     if ($this->role == 1) {
    //         return $this->db->select('*,tbl_order.id as OID')->from('tbl_order')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array("tbl_customer_order.pay_sta" => 1))->get();
    //     } else {
    //         return $this->db->select('*,tbl_order.id as OID')->from('tbl_order')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->where(array('tbl_product.vendor_id' => $id, "tbl_customer_order.pay_sta" => 1))->get();
    //     }
    // }

    public function acceptReview($id)
    {
        $this->db->update("tbl_review", array("is_accept" => 1), array("id" => $id));
    }

    public function userReviews()
    {
        return $this->db->select('*,tbl_review.id as RID')->from('tbl_review')->join('tbl_product', 'tbl_product.id=tbl_review.pro_id')->get()->result();
    }

    public function getProductCategories($cat, $subcat)
    {
        return $this->db->get_where('tbl_properties', array('prop_cat' => $cat, 'sub_cat' => $subcat, "is_man" => 1))->result();
    }

    public function getAttribute($cat)
    {
        return $this->db->get_where('tbl_prod_prop', array('prop_id' => $cat))->result();
    }

    public function getAttributeJoin($cat)
    {
        return $this->db->select('*')->from('tbl_prod_prop')->join('tbl_prop_name', 'tbl_prop_name.id=tbl_prod_prop.prop_id')->where("prop_id = $cat")->get()->result();
    }

    public function getProperties($cat, $subcat)
    {
        $query = $this->db->select('*,tbl_properties.id as ID,tbl_prop_name.id as pid')->from('tbl_properties')->join('tbl_prop_name', 'tbl_prop_name.id=tbl_properties.prop_name')->where(array('prop_cat' => $cat, 'sub_cat' => $subcat))->get()->result();
        return $query;
    }

    public function updateAttr($pro, $attr)
    {
        return $this->db->update("tbl_product", array("product_attr" => $attr), array("id" => $pro));
    }

    public function setUploadDoc($docType, $docName, $vendor)
    {

        switch ($docType) {
            case "addProof":
                $q = $this->db->update('tbl_signups', array('addProof' => $docName), array('id' => $vendor));
                if ($q) {
                    return 1;
                } else {
                    return 0;
                }

                break;
            case "panCard":
                $q = $this->db->update('tbl_signups', array('panCard' => $docName), array('id' => $vendor));
                if ($q) {
                    return 1;
                } else {
                    return 0;
                }

                break;
            case "profilePic":
                $q = $this->db->update('tbl_signups', array('profilePic' => $docName), array('id' => $vendor));
                if ($q) {
                    return 1;
                } else {
                    return 0;
                }

                break;
            case "gstDoc":
                $q = $this->db->update('tbl_signups', array('gstDoc' => $docName), array('id' => $vendor));
                if ($q) {
                    return 1;
                } else {
                    return 0;
                }

                break;
            case "signature":
                $q = $this->db->update('tbl_signups', array('signature' => $docName), array('id' => $vendor));
                if ($q) {
                    return 1;
                } else {
                    return 0;
                }

                break;
            case "cancelCheck":
                $q = $this->db->update('tbl_signups', array('cancelCheck' => $docName), array('id' => $vendor));
                if ($q) {
                    return 1;
                } else {
                    return 0;
                }

                break;
        }
        //    $this->db->update('tbl_signups','')
    }

    public function properties()
    {
        return $this->db->get('tbl_property')->result();
    }

    public function getSubProp($prop)
    {
        return $this->db->get_where('tbl_subprop', array('prop_id' => $prop))->result();
    }

    public function checkisvalid($id)
    {
        $this->db->get_where('tbl_signups', array('id' => $id));
    }

    public function addMoreImages($filename, $produt_id, $sta = 0)
    {
        $this->db->insert('tbl_pro_img', array('pro_id' => $produt_id, "img_sta" => $sta, 'pro_images' => $filename, 'insertTime' => date('Y-m-d H:i:s')));
        $this->db->cache_delete('Admin', 'Vendor');
    }

    public function addSwatch($color, $pro, $uploadedFile)
    {

        $this->db->insert("tbl_swatch", array("pro_id" => $pro, "color_id" => str_replace(" ", "", $color), "color_pic" => $uploadedFile));
    }

    public function removeProImage($produt_id)
    {
        $this->db->delete('tbl_pro_img', array('pro_id' => $produt_id));
    }

    public function updateProducts($post, $id)
    {

        return $this->db->update('tbl_product', array('cat_id' => $this->encryption->decrypt(decode($post['category'])), "sku" => $post["sku"], "sub_id" => $this->encryption->decrypt(decode($post['sub_category'])), 'pro_name' => $post['product_name'], 'update_time' => date('Y-m-d H:i:s'), 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'pro_desc' => $post['pro_desc'], 'pro_sta' => 0), array('id' => $id));
    }

    public function getSwatch($id)
    {
        return $this->db->get_where("tbl_swatch", array("pro_id" => $id))->result();
    }

    public function getProductsCategoryByProduct($id)
    {

        return $this->db->get_where("tbl_product_categories", ["pro_id" => $id])->result();
    }

    public function updateConfirmedProducts($post, $id)
    {
        $this->db->delete("tbl_product_categories", ["pro_id" => $id]);

        foreach ($post["sub_cat"] as $value) {
            $sub = explode("_", $value);

            if (count($sub) == 2) {
                $this->db->insert("tbl_product_categories", ["cat_id" => $sub[0], "sub_id" => $sub[1], "child_id" => 0, "pro_id" => $id]);
            } else if (count($sub) == 3) {
                $this->db->insert("tbl_product_categories", ["cat_id" => $sub[0], "sub_id" => $sub[1], "child_id" => $sub[2], "pro_id" => $id]);
            }
        }

        return $this->db->update('tbl_product', array('pro_name' => $post['product_name'], "product_sname" => $post["product_sname"], "sku" => $post["sku"], "add_limit" => $post["limit"], "type" => $post["type"], "short_desc" => $post["sort_pro_desc"], 'update_time' => date('Y-m-d H:i:s'), 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'pro_desc' => $post['pro_desc'], "meta_desc" => $post["meta_desc"], "meta_key" => $post["meta_key"], "title" => $post["title"]), array('id' => $id));
    }

    public function getProduct($id)
    {
        return $this->db->get_where('tbl_product', array('id' => $id))->result()[0];
    }

    public function isSimilar($id, $relate)
    { //tbl_related_product
        $count = $this->db->get_where("tbl_related_product", ["pro_id" => $id, "relate_pro_id" => $relate])->result();
        return count($count);
    }

    public function loadProducts($id)
    {
        return $this->db->get_where('tbl_product', array('id!=' => $id))->result();
    }

    public function updateProAttribute($id, $pro_attr, $qty)
    {
        return $this->db->update('tbl_product', array('product_attr' => $pro_attr, "pro_stock" => $qty), array('id' => $id));
    }

    public function deleteMoreImage($produt_id)
    {
        $this->db->delete('tbl_pro_img', array('pro_id' => $produt_id));
    }

    public function addSimilar($post, $pro)
    {
        foreach ($post as $si) {
            $this->db->insert("tbl_related_product", ["relate_pro_id" => $si, "pro_id" => $pro]);
        }
    }

    public function checkProductValid($id)
    {
        return $this->db->select('*,tbl_product.id as ID')->from('tbl_product')->where(array('tbl_product.id' => $id))->get()->result();
    }

    public function loadMoreImages($id)
    {
        return $this->db->get_where('tbl_pro_img', array('pro_id' => $id))->result();
    }

    public function loadSpecification($id)
    {
        return $this->db->get_where("tbl_specification", ['pro_id' => $id])->result();
    }

    public function addProduct($post, $desc, $sizeChart, $shortdesc, $vendor, $attr)
    {
        $product_id = [];
        
        $query = $this->db->insert('tbl_product', array('vendor_id' => $vendor, "product_sname" => $post["product_sname"], "short_desc" => $shortdesc, "size_chart" => $sizeChart, "sku" => $post["sku"], 'add_limit' => $post["limit"], 'hsn_code' => $post["hsn_code"], "product_attr" => $attr, 'pro_name' => $post['product_name'], 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'txt_msg' => $post['txt'], 'pro_desc' => $desc, 'pro_sta' => 1, 'gst' => $post['gst'], "type" => $post["type"], "visible_from_date" => date("Y-m-d")));
        $last = $this->db->insert_id();

        foreach ($post['sub_cat'] as $value) {
            $arr = explode('_', $value);
            if (count($arr) == 2) {
                $cat_id = $arr[0];
                $sub_cat_id = $arr[1];
                $product_id[] = $last;
                $this->db->insert("tbl_product_categories", ["cat_id" => $cat_id, "sub_id" => $sub_cat_id, "child_id" => 0, "pro_id" => $last]);
            } else if (count($arr == 3)) {
                $cat_id = $arr[0];
                $sub_cat_id = $arr[1];
                $child_sub_cat_id = $arr[2];
                $this->db->insert("tbl_product_categories", ["cat_id" => $cat_id, "sub_id" => $sub_cat_id, "child_id" => $child_sub_cat_id, "pro_id" => $last]);
            }
        }

        if ($query) {
            return $last;
        }
        $this->db->cache_delete("Admin", "Vendor");
        return 0;
    }

    public function insertIntoTblProProp($proId, $props)
    {
        foreach ($props as $val) {
            $this->db->insert("tbl_product_property", ["pro_id" => $proId, "property_id" => $val]);
        }
    }

    public function addProductProp($post, $product)
    {
        foreach ($post['pd_prop[]'] as $key => $value) {
            $query = $this->db->insert('tbl_set_property', array('prod_id' => $product, 'prop_id' => $value, 'attr_id' => $post['pd_attr[]'][$key], 'change_price' => $post['changePrice[]'][$key], 'qty' => $post['quantity[]'][$key]));
        }
        if ($query) {
            return 1;
        }
        return 0;
    }

    public function getCoupon($code, $email)
    {
        $query = $this->db->get_where('tbl_offer_code', array('offer_code' => $code))->result();

        if (count($query) > 0) {
            $qry = $this->db->get_where('tbl_offer_customer', array('offer_id' => $query[0]->id, 'user_email' => $email))->result();
            $remainingCoupon = count($qry);
            if ($query[0]->offer_per_customer > $remainingCoupon) {
                return $query[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function userCoupon($id, $email)
    {
        $query = $this->db->get_where('tbl_offer_customer', array('offer_id' => $id, 'user_email' => $email))->result();

        return $query;
    }

    public function getCoupon_Via_Id($id)
    {
        return $this->db->get_where('tbl_offer_code', array('id' => $id))->result()[0];
    }

    public function getCouponVia_groupName($groupName)
    {
        $query = $this->db->select("*")->from("tbl_offer_code")->where("group_name =", $groupName)->order_by("priority", "ASC")->get()->result();
        // $query = $this->db->get_where('tbl_offer_code', array('group_name' => $groupName))->result();

        if (count($query) > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function get_cust_orderdetails($id)
    {
        return $this->db->get_where('tbl_customer_order', array('registered_user' => $id))->result();
    }

    public function gettotnos()
    {
        return $this->db->get_where('tbl_customer_order', ['pay_sta' => 1])->result();
    }

    public function gettotuser()
    {
        return $this->db->get('tbl_user_reg')->result();
    }

    public function order_details($id)
    {
        return $this->db->select('*')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->where("tbl_order.id", $id)->get()->result();
    }

    public function gettotprd()
    {
        return $this->db->where('pro_stock <=', 5)->get('tbl_product')->result();
    }

    public function gettotproducts()
    {
        return $this->db->get('tbl_product')->result();
    }

    public function gettotprice()
    {
        $this->db->select_sum('total_order_price');
        return $query = $this->db->get_where('tbl_customer_order', ['pay_sta' => 1])->result()[0]->total_order_price;
    }

    public function getlastprod()
    {
        // return $this->db->order_by('id', 'DESC')->limit(5)->get('tbl_order')->result();
        return $this->db->order_by('id', 'DESC')->limit(5)->get_where('tbl_customer_order', ['pay_sta' => 1])->result();
        // return $this->db->select('*, tbl_customer_order.id as ID')->from('tbl_customer_order')->join('tbl_order', 'tbl_customer_order.id=tbl_order.order_id')->where("tbl_customer_order.pay_sta", 1)->order_by('tbl_customer_order.id', 'DESC')->limit(5)->get()->result();
    }

}
