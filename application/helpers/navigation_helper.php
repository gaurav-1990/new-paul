<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists("loadnavigation")) {

    function loadnavigation()
    {
        $CI = &get_instance();
        $CI->load->library('encryption');
        $CI->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $categories = $CI->db->get_where('tbl_categories', array('cat_sta' => 1))->result();
        $onclick="";
        $cat_contain = '';
        $base = base_url(); //'Dashboard/index'
        $cat_contain .= <<<EOD
        <li class="nav-item dropdown"><a onclick=window.location.href="{$base}" class="nav-link dropdown-toggle"  href="$base" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">HOME </a> 
             </li>
             <li class="nav-item dropdown"><a  onclick=window.location.href="http://localhost:8080/new-paulsons/Myaccount/aboutus" class="nav-link dropdown-toggle"  href="$onclick" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ABOUT US </a> 
             </li>
EOD;

        foreach ($categories as $cokey => $cat_details) {
            $catid = encode($CI->encryption->encrypt($cat_details->id));    //, 'Shantanu@123#'
            $category_name = urlencode($cat_details->cat_name);
            $sub_cat = loadSubCat($cat_details->id, $category_name);
            $base_url = base_url('shop/') . cleanUrl($cat_details->cat_name) . "/" . encode($CI->encryption->encrypt($cat_details->id));
            $onclick = $base_url;
            if ($detect->isMobile()) {
                $onclick = $base_url;
            }
            $cat_contain .= <<<EOD
            <li class="nav-item dropdown"><a  onclick='window.location.href=$(this).attr("href")' class="nav-link dropdown-toggle color$cokey"  href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">$cat_details->cat_name <i class="fa fa-angle-down"></i></a> 
                $sub_cat
             </li>
            
EOD;
        }

        $cat_contain .= <<<EOD
        <li class="nav-item dropdown"><a  onclick=window.location.href="#" class="nav-link dropdown-toggle"  href="$onclick" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">BLOG </a> 
             </li>
             <li class="nav-item dropdown"><a  onclick=window.location.href="http://localhost:8080/new-paulsons/Myaccount/contactus" class="nav-link dropdown-toggle"  href="$onclick" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">CONTACT US </a> 
             </li>
EOD;

        $container = <<<EOD
        <ul class="navbar-nav mr-auto">$cat_contain</ul>    
EOD;

 
        return $container;
    }

}

if (!function_exists("cleanUrl")) {

    function cleanUrl($string)
    {
        $string = str_replace([' ', '&', '\'', ',', '.', ')', "|", '(', '[', ']', '{', '}'], '-', strtolower($string)); // Replaces all spaces with hyphens.
        preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.
        return preg_replace('/-+/', '-', $string);
    }

}
if (!function_exists("loadSubcription")) {

    function loadSubcription()
    {
        $CI = &get_instance();
        return $CI->db->get_where("tbl_subscription")->result()[0];
    }

}


if (!function_exists("loadSubCat")) {

    function loadSubCat($cat_id, $name)
    {
        $CI = &get_instance();
        $CI->load->library('encryption');
        $sub_categories = $CI->db->get_where('tbl_subcategory', array('cid' => $cat_id, "parent_sub" => 0))->result();

        $countSub = count($sub_categories);
        // Media for Desktop View  (START)
        $class = "";
        // switch ($countSub) {
        //     case 6:
        //         $class = "col-md-2";
        //         break;
        //     case 5:
        //         $class = "col-md-3";
        //         break;
        //     case 4:
        //         $class = "col-md-3";
        //         break;
        //     case 3:
        //         $class = "col-md-4";
        //         break;
        //     case 2:
        //         $class = "col-md-6";
        //         break;
        //     case 1:
        //         $class = "col-md-4";
        //         break;
        //     default:
        //         $class = "col-md-3";
        // }
        $child = "";


        $sub = "";
        foreach ($sub_categories as $subcategory) {
            $childCat = loadChildCategories($subcategory->id, $name, cleanUrl($subcategory->sub_name));
            $base_url = base_url("details/" . strtolower($name)) . "/" . cleanUrl($subcategory->sub_name) . "/" . encode($CI->encryption->encrypt($subcategory->id));
            $sub .= <<<EOD
             <div class="$class">
                <ul class="nav ">
                    <a href="$base_url" class="cat-head text-red">{$subcategory->sub_name} <i class='fa fa-angle-right'></i></a>
                    $childCat 
                </ul>
              </div>
EOD;
        }

        // Media for Desktop View   (END)

        $subcategory = <<<EOD
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <div class="container">
            <div class="row">
              $sub
            </div>
          </div>
        </div>
EOD;
        return $subcategory;
    }

}

if (!function_exists("loadChildCategories")) {

    function loadChildCategories($id, $cat = "", $subbcat = "")
    {
        $CI = &get_instance();
        $base_url = base_url("details/$cat/$subbcat");

        $childs = $CI->db->get_where('tbl_subcategory', array("parent_sub" => $id))->result();

        $child = "";
        foreach ($childs as $key => $childDetails) {
            $su = cleanUrl($childDetails->sub_name);
            $suid = encode($CI->encryption->encrypt($childDetails->id));
            $child .= <<<EOD
    <li class="nav-item">
       <a class="nav-link active" href="$base_url/$su/$suid">{$childDetails->sub_name}</a>
     </li>
EOD;
        }
        return $child;
    }

}

if (!function_exists("load_images")) {

    function load_images($pro_id)
    {
        $CI = &get_instance();

        $sub_cat = $CI->db->get_where('tbl_pro_img', array('pro_id' => $pro_id))->result();

        if (count($sub_cat) > 0) {
            return $sub_cat[0]->pro_images;
        } else {
            //return "no-image-404.jpg";
        }
    }

}
if (!function_exists("getOffer")) {

    function getOffer($id)
    {
        $CI = &get_instance();

        return $sub_cat = $CI->db->get_where('tbl_offer_code', array('id' => $id))->result();
    }

}


if (!function_exists("getOrderDetails")) {

    function getOrderDetails($id)
    {
        $CI = &get_instance();
        $CI->load->model('User_model', 'user');
        return $CI->user->allCustomerOrders($id);
    }

}
if (!function_exists("isMobile")) {

    function isMobile()
    {
        $CI = &get_instance();

        $CI->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        return $detect->isMobile();
    }

}
if (!function_exists("isTablet")) {

    function isTablet()
    {
        $CI = &get_instance();

        $CI->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        return $detect->isTablet();
    }

}

if (!function_exists("getFeaturedProducts")) {

    function getFeaturedProducts()
    {
        $CI = &get_instance();
        return $CI->db->select('*,tbl_product.id as ID')->from("tbl_feature_product")->join("tbl_product", 'tbl_feature_product.pro_id=tbl_product.id')->join("tbl_product_categories", "tbl_product_categories.pro_id=tbl_product.id")->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id')->group_by('tbl_product.id')->get()->result();
    }

}
if (!function_exists("load_All_images")) {

    function load_All_images($pro_id)
    {
        $CI = &get_instance();
        $CI->load->library('encryption');
        $sub_cat = $CI->db->get_where('tbl_pro_img', array('pro_id' => $pro_id, 'img_sta' => 0))->result();
        if (count($sub_cat) > 0) {
            return $sub_cat;
        } else {
            return "no-image-404.jpg";
        }
    }

}

if (!function_exists("load_all_related")) {

    function load_all_related($pro_id, $cat_name, $sub_cat)
    {
        $CI = &get_instance();
        $sub_cat = $CI->db->get_where('tbl_product', array('cat_id' => $cat_name, 'pro_sta=' => '1', "pro_stock!=" => 0, 'sub_id' => $sub_cat, 'id!=' => $pro_id))->result();


        if (count($sub_cat) > 0) {
            return $sub_cat;
        } else {
            return "no-image-404.jpg";
        }
    }

}

if (!function_exists("order_property")) {

    function order_property($pro_id, $order_id, $o_id)
    {
        $CI = &get_instance();
        $rs = $CI->db->select('*')->from('tbl_order_prop')->join('tbl_set_property', 'tbl_set_property.id=tbl_order_prop.tbl_set_prop_name')->join('tbl_prod_prop', 'tbl_set_property.attr_id=tbl_prod_prop.id')->where(array('o_id' => $o_id, 'pro_id' => $pro_id, 'order_id' => $order_id))->get();
        if (count($rs->result()) > 0) {
            return $rs->result()[0];
        }
    }

}

if (!function_exists("load_property")) {

    function load_property($pro_id)
    {
        $CI = &get_instance();
        $rs = $CI->db->select()->from('tbl_set_property')->where(array('prod_id' => $pro_id))->join('tbl_properties', 'tbl_properties.id=tbl_set_property.prop_id')->join('tbl_prop_name', 'tbl_properties.prop_name=tbl_prop_name.id')->group_by('pop_name')->get()->result();
        $inner = "";
        foreach ($rs as $re) {
            $val = $CI->encrypt->encode($re->prop_id);
            $innerHtml = load_sub_category($pro_id, $re->prop_id);

            $inner .= <<<EOD
                <div class="flex-m flex-w p-b-10">
                    <div class="s-text15 w-size15 t-center">
                       $re->pop_name
                    </div>
                     $innerHtml
                   
                </div>
EOD;
        }
        if (count($rs) > 0) {
            return $inner;
        }
    }

}

if (!function_exists("load_sub_category")) {

    function load_sub_category($pro_id, $prop_id)
    {
        $CI = &get_instance();

        $rs = $CI->db->select('*,tbl_set_property.id as ID')->from('tbl_set_property')->join('tbl_prod_prop', 'tbl_prod_prop.id=tbl_set_property.attr_id')->where(array('tbl_set_property.prod_id' => $pro_id, 'tbl_set_property.prop_id' => $prop_id))->get()->result();
        $option = "";
        foreach ($rs as $re) {
            $attr_id = $CI->encrypt->encode($re->ID);
            $option .= "<option value='{$attr_id}'>{$re->attr_name}</option>";
        }
        $html = "";
        $prop = $CI->encrypt->encode($prop_id);
        $html .= <<<EOD
         <div data-prop="$prop" class="rs2-select2 rs3-select2 bo4 of-hidden w-size16">
                        <select class="selection-2" name="size">
                            <option value="">Choose an option</option>
                            $option
                        </select>
                    </div>
EOD;
        return $html;
    }

}
if (!function_exists("getHomePage")) {

    function getHomePage($page)
    {

        $CI = &get_instance();
        $rs = $CI->db->query("select * from tbl_page where url_key='" . $page . "' and  page_status=1 ")->result();
        return $rs[0];
    }

}
if (!function_exists("getPriceCount")) {
    function getPriceCount($id,$from,$to)
    {
        $CI = &get_instance();

            $query= $CI->db->query("SELECT *, `tbl_product`.`id` as `ID` FROM `tbl_product_categories` JOIN `tbl_product` ON `tbl_product_categories`.`pro_id`=`tbl_product`.`id` JOIN `tbl_categories` ON `tbl_product_categories`.`cat_id`=`tbl_categories`.`id` JOIN `tbl_subcategory` ON `tbl_product_categories`.`sub_id`=`tbl_subcategory`.`id` WHERE `tbl_product_categories`.`sub_id` = $id AND ( `pro_stock` > '0' AND `pro_sta` = '1' AND (`tbl_product`.`dis_price` >= $from and `tbl_product`.`dis_price` < $to) ) GROUP BY `tbl_product`.`id`")->result();

         return   count($query);

    }
}if (!function_exists("getPriceCountChild")) {
    function getPriceCountChild($id,$from,$to)
    {
        $CI = &get_instance();


         $query= $CI->db->query("SELECT *, `tbl_product`.`id` as `ID` FROM `tbl_product_categories` JOIN `tbl_product` ON `tbl_product`.`id`=`tbl_product_categories`.`pro_id` JOIN `tbl_categories` ON `tbl_product_categories`.`cat_id`=`tbl_categories`.`id` JOIN `tbl_subcategory` ON `tbl_product_categories`.`sub_id`=`tbl_subcategory`.`id` JOIN `tbl_signups` ON `tbl_signups`.`id`=`tbl_product`.`vendor_id` WHERE `tbl_product_categories`.`child_id` = '$id' AND ( `tbl_product`.`pro_sta` = 1 AND `pro_stock` > 0 AND (`tbl_product`.`dis_price` >= $from and `tbl_product`.`dis_price` < $to) ) GROUP BY `tbl_product`.`id`")->result();

         return  count($query);

    }
}
if (!function_exists("getColorcount")) {
    function getColorCount($id,$color)
    {
        $CI = &get_instance();

        $query= $CI->db->query("SELECT COUNT(DISTINCT tbl_product.id) as ID FROM `tbl_product_categories` JOIN `tbl_product` ON `tbl_product_categories`.`pro_id`=`tbl_product`.`id` JOIN `tbl_categories` ON `tbl_product_categories`.`cat_id`=`tbl_categories`.`id` JOIN `tbl_subcategory` ON `tbl_product_categories`.`sub_id`=`tbl_subcategory`.`id` JOIN `tbl_product_property` ON `tbl_product_property`.`pro_id`=`tbl_product`.`id` JOIN `tbl_prod_prop` ON `tbl_prod_prop`.`id`=`tbl_product_property`.`property_id` WHERE `tbl_product_categories`.`sub_id` = $id AND ( `pro_stock` > '0' AND `pro_sta` = '1' AND (`tbl_prod_prop`.`color_code` = '$color') )")->result();

        return  $query[0]->ID;

    }
}
if (!function_exists("getColorcountChild")) {
    function getColorcountChild($id,$color)
    {
        $CI = &get_instance();

        $query= $CI->db->query("SELECT COUNT(DISTINCT tbl_product.id) as ID FROM `tbl_product_categories` JOIN `tbl_product` ON `tbl_product_categories`.`pro_id`=`tbl_product`.`id` JOIN `tbl_categories` ON `tbl_product_categories`.`cat_id`=`tbl_categories`.`id` JOIN `tbl_subcategory` ON `tbl_product_categories`.`sub_id`=`tbl_subcategory`.`id` JOIN `tbl_product_property` ON `tbl_product_property`.`pro_id`=`tbl_product`.`id` JOIN `tbl_prod_prop` ON `tbl_prod_prop`.`id`=`tbl_product_property`.`property_id` WHERE `tbl_product_categories`.`child_id` = $id AND ( `pro_stock` > '0' AND `pro_sta` = '1' AND (`tbl_prod_prop`.`color_code` = '$color') )")->result();

        return  $query[0]->ID;

    }
}

if (!function_exists('getCancelOrder')) {

    function getCancelOrder($id)
    {
        $CI = &get_instance();
        $qry = $CI->db->get_where('tbl_cancle', array('order_id' => $id))->result();
        if (count($qry) > 0) {
            return $qry[0];
        } else {
            return false;
        }
    }

}