<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteChild($id)
    {
        return $this->db->delete("tbl_subcategory", array('id' => $id));
    }

    public function exchnageAccepted($post, $pro_id, $qty, $updateAttr, $orderID)
    {

        $pro = $this->db->get_where("tbl_product", array("id" => $pro_id))->result()[0];
        $property2 = json_decode($pro->product_attr);
        foreach (json_decode($pro->product_attr) as $as => $response) {
            foreach ($response as $key => $attribute) {
                if ($attribute->attribute[0]->{"Size"} == ucfirst($post)) {
                    $attr["attribute"] = $attribute->attribute;
                    $attr["qty"] = (string)(intval($attribute->qty) + $qty);
                    $attr["changedPrice"] = $attribute->changedPrice != '' ? $attribute->changedPrice : 0;
                    unset($property2->response[$key]);
                    $property2->response[$key] = (object)$attr;
                    $res["response"] = array_values($property2->response);
                    $update = json_encode($res);

                    $this->db->set('pro_stock', 'pro_stock-' . $qty . '', false)
                        ->where('id', $pro_id)
                        ->update('tbl_product');


                } elseif ($attribute->attribute[0]->{"Size"} == ucfirst($updateAttr)) {
                    $attr["attribute"] = $attribute->attribute;
                    $attr["qty"] = (string)(intval($attribute->qty) - $qty);
                    $attr["changedPrice"] = $attribute->changedPrice != '' ? $attribute->changedPrice : 0;
                    unset($property2->response[$key]);
                    $property2->response[$key] = (object)$attr;
                    $res["response"] = array_values($property2->response);
                    $update = json_encode($res);

                    $this->db->set('pro_stock', 'pro_stock+' . $qty . '', false)
                        ->where('id', $pro_id)
                        ->update('tbl_product');
                }
            }

        }

        $this->db->set("product_attr", $update)->where('id', $pro_id)->update('tbl_product');
        return $this->db->update("tbl_order", ["order_attr" => $updateAttr], ["id" => $orderID]);
    }

    public function exchangeRejected($id, $cause)
    {
        $this->db->insert("tbl_exchangerejected", ["order_id" => $id, "reject_cause" => $cause, "datentime" => date("Y-m-d H:i")]);
        return $this->db->update("tbl_order", ["order_status" => 9], ["id" => $id]);

    }

    public function getVendorInfo($id, $role)
    {
        if ($role == 1) {
            return $this->db->get_where('tbl_signups', array('otp_verify' => 3))->result();
        }
    }

    public function allowForProductUpload($id)
    {
        return $this->db->update('tbl_signups', array('allow_product' => 1), array('id' => $id));
    }

    public function checkEmail($str)
    {
        $count = $this->db->get_where('tbl_signups', array('emailadd' => $str))->result();

        if (count($count) > 0) {
            return true;
        }
        return false;
    }

    public function getByEmail($str)
    {
        $rs = $this->db->get_where('tbl_signups', array('emailadd' => $str))->result();

        return $rs;
    }

    public function deletePropName($id)
    {
        $this->db->delete('tbl_prop_name', array('id' => $id));
    }

    public function deletePrime($id)
    {
        $this->db->delete('prime_membership', array('id' => $id));
    }

    public function getSelected_attr($id)
    {

        return $this->db->select('*,tbl_prod_prop.id as AID')->from('tbl_prop_name')->join('tbl_prod_prop', 'tbl_prod_prop.prop_id = tbl_prop_name.id')->where("tbl_prod_prop.prop_id", $id)->where("tbl_prod_prop.prop_id!=", 2)->get()->result();
    }

    public function getPropertiesName()
    {
        return $this->db->get('tbl_prop_name')->result();
    }

    public function setPropertiesName($propname)
    {
        return $this->db->insert('tbl_prop_name', array('pop_name' => $propname['propname'], 'type' => $propname['display_mode'], 'catalog_type' => $propname['swatch_name']));
    }

    public function updateImage($id, $image)
    {
        $query = $this->db->update('tbl_pro_img', array('pro_images' => $image, 'insertTime' => date('Y-m-d H:i:s')), array('id' => $id));
        if ($query) {
            return 1;
        }
        return 0;
    }

    public function deletePropAttrName($id, $index)
    {
        $pro = $this->db->get_where('tbl_product', array('id' => $id))->result()[0];
        $attr = json_decode($pro->product_attr);
        unset($attr->response[$index]);
        $al = json_encode($attr);
        $this->db->update("tbl_product", array("product_attr" => $al), array("id" => $id));
    }

    public function getProperties($prod_id)
    {
        return $this->db->get_where('tbl_product', array('id' => $prod_id))->result()[0];
    }

    public function getProductMaxid()
    {
        return $this->db->query("select Max(id) as ID from tbl_product")->result()[0];
    }

    public function deleteProp($id)
    {
        $this->db->delete('tbl_properties', array('id' => $id));
    }

    public function deleteAttr($id)
    {
        $this->db->delete('tbl_prod_prop', array('id' => $id));
    }

    public function getAttrName()
    {
        return $this->db->select('*,tbl_prod_prop.id as attr_id')->from('tbl_prod_prop')->join('tbl_prop_name', 'tbl_prop_name.id=tbl_prod_prop.prop_id')->get()->result();
    }

    public function getAllProperties()
    {
        return $this->db->select('*,tbl_properties.id as propId')->from('tbl_properties')->join('tbl_prop_name', 'tbl_prop_name.id=tbl_properties.prop_name')->join('tbl_categories', 'tbl_categories.id=tbl_properties.prop_cat')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_properties.sub_cat')->get()->result();
    }

    public function addAttr($data)
    {
        $this->db->insert('tbl_prod_prop', array('prop_id' => $data['prop_id'], 'attr_name' => $data['attr_name'], 'color_code' => $data['color']));
    }

    public function addProperty($data)
    {
        $res = $this->db->get_where('tbl_properties', array('prop_name' => $data['prop_name'], 'prop_cat' => $data['prop_cat'], 'sub_cat' => $data['sub_cat']))->result();
        if (count($res) == 0) {
            $this->db->insert('tbl_properties', array('prop_name' => $data['prop_name'], 'prop_cat' => $data['prop_cat'], 'is_man' => isset($data['is_man']) ? 1 : 0, 'sub_cat' => $data['sub_cat']));
            return 1;
        }
        return 0;
    }

    public function addSubcategory($data, $image, $size_chart)
    {
        return $this->db->insert('tbl_subcategory', array('cid' => $data['cat_sub'], 'sub_name' => $data['sub_category'], 'sub_desc' => $data['sub_cat_desc'], 'sub_img' => $image, 'sub_title' => $data['sub_title'], 'sub_meta_desc' => $data['sub_meta_desc'], 'sub_meta_key' => $data['sub_meta_key'], 'sizeChart' => $size_chart));
    }

    public function load_subcategories($id)
    {
        return $this->db->get_where('tbl_subcategory', array('cid' => $id, "parent_sub" => 0))->result();
    }

    public function getSubChildCategory($_child)
    {
        return $this->db->get_where("tbl_subcategory", ["parent_sub" => $_child])->result();
    }

    public function updateChildSub($post, $sub_img)
    {
        return $this->db->update("tbl_subcategory", ["cid" => $post["cat_sub"], "sub_img" => $sub_img, "sub_name" => $post["child_sub_name"], "parent_sub" => $post["sub_category"], "sub_title" => $post["sub_title"], "sub_meta_desc" => $post["sub_meta_desc"], "sub_meta_key" => $post["sub_meta_key"]], ["id" => $post["hiddenId"]]);
    }

    public function loadedit_subcat($id)
    {
        return $this->db->get_where('tbl_subcategory', array('id' => $id))->result()[0];
    }

    public function loadAllSubCategory()
    {
        return $this->db->select("*,tbl_subcategory.id as sub_id")->from("tbl_subcategory")->join("tbl_categories", "tbl_subcategory.cid=tbl_categories.id")->where(["parent_sub" => 0])->get()->result();
    }

    public function update_profile($data)
    {

        $password = trim($data['new_password']);
        if ($password != null) {
            $query = $this->db->update('tbl_signups', array('fname' => $data['first_name'], 'lname' => $data['last_name'], "company" => $data['company'], "state" => $data['state'], "city" => $data['city'], "zip" => $data['zip'], "address" => $data['address'], "ship_address" => $data['ship_address'], "nature_business" => $data['nature_business'], "bankadd" => $data['bankadd'], "passw" => password_hash($data['new_password'], PASSWORD_DEFAULT), "gst" => $data['gst_no'], "nature_business" => $data['nature_business'], "bankname" => $data['bankname'], "holdername" => $data['holdername'], "accountnum" => $data['accountnum'], 'ifsc' => $data['ifsc']), array('id' => $this->encryption->decrypt(decode($data['hidden_id']))));
        } else {
            $query = $this->db->update('tbl_signups', array('fname' => $data['first_name'], 'lname' => $data['last_name'], "company" => $data['company'], "state" => $data['state'], "city" => $data['city'], "zip" => $data['zip'], "address" => $data['address'], "ship_address" => $data['ship_address'], "nature_business" => $data['nature_business'], "bankadd" => $data['bankadd'], "passw" => $data['dummy'], "gst" => $data['gst_no'], "bankname" => $data['bankname'], "nature_business" => $data['nature_business'], "holdername" => $data['holdername'], "accountnum" => $data['accountnum'], 'ifsc' => $data['ifsc']), array('id' => $this->encryption->decrypt(decode($data['hidden_id']))));
        }

        if ($query) {
            return true;
        }
        return false;
    }

    public function deletesub($id)
    {
        return $this->db->delete('tbl_subcategory', array('id' => $id));
    }

    public function loadVendorProductRequest()
    {
        return $this->db->select('*,tbl_product.id as pro_id')->from('tbl_product')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->order_by("tbl_product.id", "desc")->get()->result();
    }
    
    public function deleteOffer($id)
    {
        return $this->db->delete('tbl_offer_code', array('id' => $id));
    }

    public function loadVendorProductRequestById($id)
    {
        $this->db->cache_on();
        $data = $this->db->select('*,tbl_product.id as pro_id,tbl_product.gst as GST')->from('tbl_product')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->join('tbl_categories', 'tbl_categories.id=tbl_product.cat_id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->where('tbl_product.id', $id)->get()->result()[0];
        $this->db->cache_off();
        return $data;
    }

    public function load_offercode($role)
    {
        if ($role == 1) {
            return $this->db->get('tbl_offer_code')->result();
        }
    }

    public function get_offercode($id)
    {
        return $this->db->get_where('tbl_offer_code', array('id' => $id))->result()[0];
    }

    public function load_primeMember($role)
    {
        if ($role == 1) {
            return $this->db->get('prime_membership')->result();
        }
    }

    public function update_coupon($id, $post)
    {

        return $this->db->update('tbl_offer_code', array("offer_name" => $post["offer_name"], "offer_code" => strtoupper($post["offer_code"]), "offer_type" => $post["offer_type"], "offer_val" => $post["offer_val"], "which_price" => $post["which_price"], "offer_per_customer" => $post["offer_per_customer"], "offer_validity_from" => $post["offer_validity_from"] != '' ? date("Y-m-d", strtotime($post["offer_validity_from"])) : "", "offer_validity_to" => $post["offer_validity_to"] != "" ? date("Y-m-d", strtotime($post["offer_validity_to"])) : "", "min_val" => $post["min_val"], "group_name" => $post['customer_grp'], "priority" => $post['priority']), array('id' => $id));

    }

    public function addOfferCode($post)
    {
        
        if (isset($post["per_val"])) {
            $per_val = 1;
        } else {
            $per_val = 0;
        }

        if (isset($post["offer_on"])) {
            $offer_on = 1;
        } else {
            $offer_on = 0;
        }

        $query = $this->db->insert("tbl_offer_code", array("offer_name" => $post["offer_name"], "offer_on" => $offer_on, "offer_code" => strtoupper($post["offer_code"]), "offer_type" => $post["offer_type"], "offer_val" => $post["offer_val"], "which_price" => $post["which_price"], "offer_per_customer" => $post["offer_per_customer"], "offer_validity_from" => $post["offer_validity_from"] != '' ? date("Y-m-d", strtotime($post["offer_validity_from"])) : "", "offer_validity_to" => $post["offer_validity_to"] != "" ? date("Y-m-d", strtotime($post["offer_validity_to"])) : "", "min_val" => $post["min_val"], "group_name" => $post['customer_grp'], "priority" => $post['priority'], "off_condition" => $post["condition"], "per_value" => $per_val));
        $insert_id = $this->db->insert_id();

        if ($post["condition"] == "1") {

            foreach ($post['sub_cat'] as $val) {
                $this->db->insert("tbl_offer_cat", array("offer_id" => $insert_id, "sub_id" => $val));

            }
        } else if ($post["condition"] == "2") {

            foreach ($this->session->userdata('prd_id') as $val) {
                $this->db->insert("tbl_offer_product", array("offer_id" => $insert_id, "product_id" => $val));
            }
            $this->session->unset_userdata('prd_id');


        }
        if ($query) {
            return true;
        }
        return false;
    }

    public function addPrime($post)
    {
        $this->db->insert("prime_membership", array("amount" => $post["prime_val"], "valid_from_date" => date("Y-m-d", strtotime($post["offer_validity_from"])), "valid_to_date" => date("Y-m-d", strtotime($post["offer_validity_to"]))));
    }

    public function getImages($image)
    {
        return $this->db->get_where('tbl_pro_img', array('pro_id' => $image))->result();
    }

    public function rejectRequest($id, $rejectReason)
    {
        $this->db->update('tbl_product', array('pro_sta' => 2, 'reject_reason' => $rejectReason, 'reject_time' => date('Y-m-d H:i')), array('id' => $id));
    }

    public function acceptRequest($id)
    {
        $this->db->update('tbl_product', array('pro_sta' => 1), array('id' => $id));
    }

    public function loadProductId($id)
    {
        return $this->db->get_where('tbl_product', array('id' => $id))->result();
    }

    public function update_category($data, $image = "", $sizechart = "")
    {
        $id = $this->encryption->decrypt(decode($data['hidden_id']));

        return $this->db->update('tbl_subcategory', array('cid' => $data['cat_sub'], 'sub_name' => $data['sub_category'], 'sub_desc' => $data['sub_cat_desc'], 'sub_img' => $image, 'sub_title' => $data['sub_title'], 'sub_meta_desc' => $data['sub_meta_desc'], "sizeChart" => $sizechart, 'sub_meta_key' => $data['sub_meta_key']), array('id' => $id));
    }

    public function getSubCategory($Id)
    {
        $this->db->cache_on();
        $data = $this->db->get_where("tbl_subcategory", array('cid' => $Id, "parent_sub" => 0))->result();
        $this->db->cache_off();
        return $data;
    }

    public function addChildCategory($data, $sub_img)
    {
        return $this->db->insert("tbl_subcategory", array("cid" => $data["cat_sub"], "parent_sub" => $data["sub_category"], "sub_name" => $data["child_sub_name"], "sub_img" => $sub_img, "sub_title" => $data["sub_title"], "sub_meta_desc" => $data["sub_meta_desc"], "sub_meta_key" => $data["sub_meta_key"]));
    }

    public function loadVendorProduct($id, $role)
    {
        if ($role == 1) {
            $query = $this->db->select('*,tbl_product.id as ID')->from("tbl_product")->where("pro_stock !=", 0)->order_by('tbl_product.id', 'DESC')->get()->result();
        } else {
            $query = $this->db->select('*,tbl_product.id as ID')->from("tbl_product")->where('vendor_id', $id)->get()->result();
        }

        return $query;
    }

    public function loadnilProducts($id, $role)
    {
        if ($role == 1) {
            $query = $this->db->select('*,tbl_product.id as ID')->from("tbl_product")->where(array("pro_stock" => 0, "pro_sta" => 1))->get()->result();
        } else {
            $query = $this->db->select('*,tbl_product.id as ID')->from("tbl_product")->where('vendor_id', $id)->get()->result();
        }

        return $query;
    }

    public function load_disabled($id, $role)
    {
        if ($role == 1) {
            $query = $this->db->select('*,tbl_product.id as ID')->from("tbl_product")->where(array("pro_stock" => 0, "pro_sta" => 0))->get()->result();
        } else {
            $query = $this->db->select('*,tbl_product.id as ID')->from("tbl_product")->where('vendor_id', $id)->get()->result();
        }

        return $query;
    }

    public function addVendorProducts($post, $image, $vendor)
    {
        $category = $this->encryption->decrypt(decode($post['category']));
        $sub_category = $this->encryption->decrypt(decode($post['sub_category']));
        $query = $this->db->insert('tbl_product', array('cat_id' => $category, 'gst' => $post['gst'], 'pro_date' => date('Y-m-d H:i:s'), 'vendor_id' => $vendor, 'sub_id' => $sub_category, 'pro_img' => $image, 'pro_name' => $post['product_name'], 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'pro_desc' => $post['pro_desc'], 'pro_sta' => 0));
        $last_id = $this->db->insert_id();
        if ($post['pro_prop']) {
            foreach ($post['pro_prop'] as $key => $pro_prop) {
                $subid = explode("_", $post['sub_prop'][$key]);
                $is_price = isset($post['is_price'][$key]) ? 1 : 0;
                $change_price = (isset($post['is_price'][$key]) && $post['is_price'][$key] == 1) ? (($post['prop_price'][$key] != '') ? $post['prop_price'][$key] : $post['act_price']) : $post['act_price'];
                $this->db->insert('tbl_product_prop', array('prop_id' => $pro_prop, 'sub_id' => $subid[1], 'pro_id' => $last_id, 'is_price_change' => $is_price, 'change_price' => $change_price));
            }
        }
        return $query;
    }

    public function addUserInfo($data)
    {

        // $query = $this->db->insert('tbl_signups', array('fname' => $data['first_name'], 'lname' => $data['last_name'], "contactno" => $data['contact_no'], "emailadd" => $data['email_id'], "company" => $data['company'], "state" => $data['state'], "city" => $data['city'], "zip" => $data['zip'], "address" => $data['address'], "passw" => password_hash($data['new_password'], PASSWORD_DEFAULT), "pan" => $data['pan_no'], "tin" => $data['tin'], "gst" => $data['gst_no']));
        $query = $this->db->insert('tbl_signups', array('fname' => $data['first_name'], 'lname' => $data['last_name'], "contactno" => $data['contact_no'], "emailadd" => $data['email_id'], "company" => $data['company'], "state" => $data['state'], "city" => $data['city'], "zip" => $data['zip'], "address" => $data['address'], "pan" => $data['pan_no'], "tin" => $data['tin'], "gst" => $data['gst_no']));
        if ($query) {
            return true;
        }
        // return $this->db->insert_id();
        return false;
    }

    public function setFirstPassword($data)
    {

        $iss_allow = $data['allow_ven'] ? $data['allow_ven'] : 0;
        $data = $this->db->update('tbl_signups', array('allow_login' => $iss_allow), array('id' => $data['ui_ig']));
        if ($data) {
            return true;
        }

        return false;
    }

    public function updatePassword($password, $id)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $data = $this->db->update('tbl_signups', array('passw' => $password), array('id' => $id));
        if ($data) {
            return true;
        }

        return false;
    }

    public function getInfoUser($id)
    {
        return $data = $this->db->get_where('tbl_signups', array('id' => $id))->result()[0];
    }

    public function deleteVendor($id)
    {
        $data = $this->db->delete('tbl_signups', array('id' => $id));
        if ($data) {
            return true;
        }

        return false;
    }

    public function checkLogin($posted)
    {
        $username = ($posted['login']['username']);
        $password = ($posted['login']['password']);

        $query = $this->db->get_where('tbl_signups', array('contactno' => $username, 'allow_login' => '1'));
        if ($query->num_rows() > 0) {
            $data = $query->result()[0];
            if (password_verify($password, $data->passw)) {

                return array('id' => $data->id, 'email' => $data->emailadd, 'role' => $data->is_admin);
            }
            return false;
        }
        return false;
    }

    public function view_users()
    {
        return $this->db->get('tbl_user_reg')->result();
    }

    public function view_usersbyid($id)
    {
        return $this->db->get_where('tbl_user_reg', array('id' => $id))->result()[0];
    }

    public function UnBlockUsers()
    {
        return $this->db->get_where('tbl_user_reg', ['block' => 0])->result();
    }

    public function load_categories()
    {
        return $this->db->get('tbl_categories')->result();
    }

    public function getAll_subcategories()
    {

        return $this->db->get('tbl_subcategory')->result();
    }

    public function load_categories_id($id)
    {
        return $this->db->get_where('tbl_categories', array('id' => $id))->result()[0];
    }

    public function updateCategory($post, $image)
    {

        if ($image != '') {
            return $this->db->update('tbl_categories', array('cat_name' => $post['category'], 'cat_desc' => $post['cat_desc'], 'cat_image' => $image, 'cat_sta' => $post['cat_sta']), array('id' => $post['hid_id']));
        } else {
            return $this->db->update('tbl_categories', array('cat_name' => $post['category'], 'cat_desc' => $post['cat_desc'], 'cat_sta' => $post['cat_sta']), array('id' => $post['hid_id']));
        }
    }

    public function deleteCategory($id)
    {
        return $this->db->delete('tbl_categories', array('id' => $id));
    }

    public function addCategory($data, $image)
    {

        return $this->db->insert('tbl_categories', array('cat_name' => $data['category'], 'cat_desc' => $data['cat_desc'], 'cat_sta' => $data['cat_sta'], 'cat_image' => $image));
        $this->db->cache_delete('blog', 'comments');
    }

    public function load_AllSize()
    {
        return $this->db->get('tbl_prod_prop')->result();
    }

    public function blockuser($userid)
    {
        $this->db->update('tbl_user_reg', array('block' => 1), array('id' => $userid));
    }

    public function unblockuser($userid)
    {
        $this->db->update('tbl_user_reg', array('block' => 0), array('id' => $userid));
    }

    public function getuserdata($id)
    {
        return $this->db->get_where('tbl_user_reg', array('id' => $id))->result()[0];
    }

    public function deleteuserdata($id)
    {
        $this->db->delete('tbl_user_reg', array('id' => $id));
    }

    public function updateuser($user, $id)
    {
        if (isset($user['new_pass']) && $user['new_pass'] != null) {
            $password = password_hash($user['new_pass'], PASSWORD_BCRYPT);
            $query = $this->db->update('tbl_user_reg', array('user_name' => $user['user_name'], 'lastname' => $user['lastname'], 'user_password' => $password, 'user_contact' => $user['user_contact'], 'bir_day' => $user['bir_day'], 'bir_month' => $user['bir_month'], 'bir_year' => $user['bir_year'], 'ann_day' => $user['ann_day'], 'ann_month' => $user['ann_month'], 'ann_year' => $user['ann_year'], 'location' => $user['location'], 'bio' => $user['bio'], 'gender' => $user['gender']), array('id' => $id));
        } else {
            $query = $this->db->update('tbl_user_reg', array('user_name' => $user['user_name'], 'lastname' => $user['lastname'], 'user_contact' => $user['user_contact'], 'bir_day' => $user['bir_day'], 'bir_month' => $user['bir_month'], 'bir_year' => $user['bir_year'], 'ann_day' => $user['ann_day'], 'ann_month' => $user['ann_month'], 'ann_year' => $user['ann_year'], 'location' => $user['location'], 'bio' => $user['bio'], 'gender' => $user['gender']), array('id' => $id));
        }
        if (count($query) > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function addCustomerGroup($post)
    {
        foreach ($post['user_name'] as $user_id) {
            $query = $this->db->insert('customer_group', array('group_name' => $post['customer_grp'], 'user_id' => $user_id));
        }
        if (count($query) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function createUserGroup($post)
    {
        return $this->db->insert('tbl_group_list', array('group_name' => $post['group']));
    }

    public function getUserGroup()
    {
        return $this->db->get("tbl_group_list")->result();
    }

    public function getUserGroupByID($id)
    {
        return $this->db->get_where("tbl_group_list", ["id" => $id])->result();
    }

    public function editUserGroup($post, $id)
    {
        return $this->db->update('tbl_group_list', array('group_name' => $post['group']), array('id' => $id));
    }

    public function delete_AssignGroup($userid)
    {

        return $this->db->delete('customer_group', array('user_id' => $userid));
    }

    public function delete_createGroup($userid)
    {

        return $this->db->delete('tbl_group_list', array('id' => $userid));
    }

    public function getAssignGroup($id)
    {

        return $this->db->select("*,tbl_group_list.group_name as grp_name,tbl_group_list.id as ID")->from("tbl_group_list")->join("customer_group", "tbl_group_list.id=customer_group.group_name")->join("tbl_user_reg", "tbl_user_reg.id=customer_group.user_id")->where("customer_group.user_id=", $id)->get()->result();
    }

    public function updateAssignGroup($post, $id)
    {
        $this->db->delete('customer_group', array('user_id' => $id));
        foreach ($post['user_name'] as $value) {
            $query = $this->db->insert('customer_group', array('group_name' => $value, 'user_id' => $id));
        }
        if (count($query) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function loadAllProd()
    {
        return $this->db->get("tbl_product")->result();
    }

    public function insert_block($enable_cat, $block_title, $identifier, $editor, $valid_from, $valid_upto, $sort_order)
    {
        // if(isset($enable_cat)){
        //     $status = 1;
        // }else{
        //     $status = 0;
        // }

        $data = array(
            'block_status' => $enable_cat,
            'block_title' => $block_title,
            'block_identifier' => $identifier,
            'block_data' => $editor,
            'valid_from' => $valid_from,
            'valid_upto' => $valid_upto,
            'sort_order' => $sort_order,
        );

        return $this->db->insert('tbl_block', $data);
    }

    public function getProductMaxidblock()
    {
        return $this->db->query("select Max(id) as ID from tbl_block")->result()[0];
    }

    public function get_block()
    {
        return $this->db->get('tbl_block')->result();
    }

    public function deleteblock($id)
    {
        return $this->db->delete('tbl_block', array('id' => $id));

    }

    public function update_blockmodel($block, $id)
    {
        if (isset($block['enableBlock'])) {
            $status = 1;
        } else {
            $status = 0;
        }

        $query = $this->db->update('tbl_block', array('block_title' => $block['bt'], 'block_identifier' => $block['identifier'], 'block_status' => $status, 'block_data' => $block['editor'], 'sort_order' => $block['sortorder'], 'valid_from' => $block['valid_from'], 'valid_upto' => $block['valid_upto']), array('id' => $id));

        if (count($query) > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function get_blockdata($id)
    {
        return $this->db->get_where('tbl_block', array('id' => $id))->result()[0];
    }

    public function get_page()
    {
        return $this->db->get('tbl_page')->result();
    }

    public function insert_page($enablepage, $page_title, $sort_order, $valid_from, $valid_upto, $cont_heading, $page_cont, $url_key, $meta_title, $meta_keywords, $meta_description)
    {
        if (isset($enablepage)) {
            $status = 1;
        } else {
            $status = 0;
        }

        $data = array(
            'page_status' => $status,
            'page_title' => $page_title,
            'cont_head' => $cont_heading,
            'page_cont' => $page_cont,
            'valid_from' => $valid_from,
            'valid_upto' => $valid_upto,
            'sort_order' => $sort_order,
            'url_key' => $url_key,
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keywords,
            'meta_desc' => $meta_description,
        );

        return $this->db->insert('tbl_page', $data);
    }

    public function getProductMaxidpage()
    {
        return $this->db->query("select Max(id) as ID from tbl_page")->result()[0];
    }

    public function deletepage($id)
    {
        return $this->db->delete('tbl_page', array('id' => $id));
    }

    public function get_pagedata($id)
    {
        return $this->db->get_where('tbl_page', array('id' => $id))->result()[0];
    }

    public function update_pagemodel($block, $id)
    {
        if (isset($block['enablePage'])) {
            $status = 1;
        } else {
            $status = 0;
        }

        $valid_from = date('Y-m-d', strtotime($block['valid_from']));
        $valid_upto = date('Y-m-d', strtotime($block['valid_upto']));

        $query = $this->db->update('tbl_page', array('page_title' => $block['enablePage'], 'page_title' => $block['page_title'], 'page_status' => $status, 'sort_order' => $block['sortorder'], 'valid_from' => $valid_from, 'valid_upto' => $valid_upto, 'cont_head' => $block['cont_head'], 'page_cont' => $block['page_cont'], 'url_key' => $block['url_key'], 'meta_title' => $block['meta_title'], 'meta_keyword' => $block['meta_keyword'], 'meta_desc' => $block['meta_desc']), array('id' => $id));

        if (count($query) > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function getreturndata($role)
    {
        if ($role == 1) {
            return $this->db->get('tbl_return')->result();
        }
    }

    public function getexchangedata($role)
    {
        if ($role == 1) {
            return $this->db->get('tbl_exchange')->result();
        }
    }

    public function getreviewedata($role)
    {
        if ($role == 1) {
            return $this->db->get('tbl_review')->result();
        }
    }

    public function order_ids()
    {
        return $this->db->select('*,tbl_customer_order.id as orderId,tbl_return.order_id as return_order_id')->from('tbl_return')->join('tbl_order', 'tbl_order.id=tbl_return.order_id')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->get()->result();
    }

    public function exorder_ids()
    {
        return $this->db->select('*,tbl_order.id as OID')->from('tbl_exchange')->join('tbl_order', 'tbl_order.id=tbl_exchange.order_id')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->get()->result();
    }

    public function review_ids()
    {
        $query = $this->db->select('*,tbl_customer_order.id as orderId')->from('tbl_customer_order')->join('tbl_review', 'tbl_review.order_id=tbl_customer_order.id')->get()->result();
        return $query;
    }

    public function getreviewdata($role)
    {
        if ($role == 1) {
            return $this->db->get('tbl_review')->result();
        }
    }

    public function accepteview($oid)
    {
        $res = $this->db->get_where('tbl_review', array('order_id' => $oid))->result()[0];
        if ($res->is_accept == 0) {
            return $this->db->update('tbl_review', array('is_accept' => 1), array('order_id' => $oid));
        } else {
            return $this->db->update('tbl_review', array('is_accept' => 0), array('order_id' => $oid));

        }
    }

    public function getorderbyDate($date1, $date2)
    {
        return $this->db->select('*')->from('tbl_customer_order')->where('pay_date BETWEEN "' . $date1 . '" AND "' . $date2 . '"')->get()->result();
    }

    public function cancelOrder($id, $msg)
    {

        $res = $this->db->insert('tbl_cancle', array('order_id' => $id, 'comment' => $msg));
        // if ($res) {

        //     $orderDetails = $this->db->select('*,tbl_order.id as or_id')->from('tbl_customer_order')->join('tbl_order', 'tbl_customer_order.id=tbl_order.order_id')->where('tbl_customer_order.id ', $id)->get()->result();
        //     $userDetail = $this->admin->get_profile_email($orderDetails[0]->registered_user);

        //     $date1 = date("Y-m-d H:i:s");
        //     $date2 = $orderDetails[0]->pay_date;
        //     $now = strtotime($date1);
        //     $your_date = strtotime($date2);
        //     $datediff = $now - $your_date;
        //     $diff = round($datediff / (60 * 60 * 24));

        //     if ($orderDetails[0]->total_offer != 0) {
        //         $orders = $this->db->get_where('tbl_order', ['order_id' => $orderDetails[0]->order_id])->result();
        //         $avg = $orderDetails[0]->total_offer / count($orders); // coupon equaly divided by all cart products
        //         $total = round($orderDetails[0]->pro_price + $avg);
        //     } else {
        //         $total = round($orderDetails[0]->pro_price);
        //     }


        //     if ($orderDetails[0]->pay_method != 0) {
        //         if ($orderDetails[0]->pay_method == 4) {
        //             $wa = $this->db->get_where("tbl_wallet", ["order_id" => $orderDetails[0]->order_id])->result();

        //             $deduction =0;
        //              foreach ($wa as $wal)
        //              {
        //                if($wal->controls==0)
        //                {
        //                    $deduction+=  floatval($wal->wallet_amt);
        //                }else{
        //                    $deduction-=  floatval($wal->wallet_amt);
        //                }
        //              }
        //              $deduction= abs($deduction);

        //             if(floatval($deduction)>=$total)
        //             {
        //                 $deduction= $total;
        //             }else{
        //                 $deduction =$deduction;
        //             }

        //             if (count($wa) > 0) {
        //                 $this->db->insert('tbl_wallet', array('user_id' => $userDetail->id, 'order_id' => $orderDetails[0]->order_id, 'wallet_amt' => $deduction, 'is_display' => 1, 'controls' => 0));
        //             }
        //         } else {
        //             $this->db->insert('tbl_wallet', array('user_id' => $userDetail->id, 'order_id' => $orderDetails[0]->order_id, 'wallet_amt' => $total, 'is_display' => 1, 'controls' => 0));
        //           //  $this->db->update('tbl_customer_order', array('order_sta' => 6), array('id' => $orderDetails[0]->order_id));



        //         }

        //     }
       

        // }
        $query = $this->db->update('tbl_customer_order', array('order_sta' => 6,"admin_cancel_date"=>date("Y-m-d H:i:s")), array('id' => $id));
        $this->db->cache_delete_all();
        if ($query) {
            return true;
        }

    }

    public function get_profile_email($user)
    {
        $qry = $this->db->get_where('tbl_user_reg', array('user_email' => $user))->result();
        if (count($qry) > 0) {
            return $qry[0];
        } else {
            return false;
        }
    }

    public function disable_prd($id) 
    {
        $this->db->update('tbl_product', array('pro_sta' => 0), array('id' => $id));
        $this->db->cache_delete_all();
    }

    public function enable_prd($id) 
    {
        $this->db->update('tbl_product', array('pro_sta' => 1), array('id' => $id));
        $this->db->cache_delete_all();
    }

    public function enable_pfs($id) 
    {
        $this->db->update('tbl_user_reg', array('pick_from_shop' => 1), array('id' => $id));
        $this->db->cache_delete_all();
    }

    public function disable_pfs($id) 
    {
        $this->db->update('tbl_user_reg', array('pick_from_shop' => 0), array('id' => $id));
        $this->db->cache_delete_all();
    }
    
    public function enable_offer($id) 
    {
        $this->db->update('tbl_offer_code', array('block' => 0), array('id' => $id));
        $this->db->cache_delete_all();
    }

    public function disable_offer($id) 
    {
        $this->db->update('tbl_offer_code', array('block' => 1), array('id' => $id));
        $this->db->cache_delete_all();
    }
    public function addToWallet($id,$post)
    {
        return $this->db->insert('tbl_wallet', array('user_id' => $id, 'wallet_amt' => $post['Amount'], "is_display" => 1, 'controls' => 0, 'admin_comments' =>$post['comments'] ));
    }

}
