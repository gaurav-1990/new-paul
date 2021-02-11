<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function load_products()
    {
        return $this->db->select('*,tbl_product.id as ID')->from("tbl_product")->where(array('tbl_product.pro_sta' => 1))->get()->result();
    }

    public function load_subcategories($id)
    {
        $this->db->cache_on();
        return $this->db->select('*,tbl_subcategory.id as subid')->from('tbl_subcategory')->join('tbl_categories', 'tbl_categories.id=tbl_subcategory.cid')->where('tbl_subcategory.parent_sub', $id)->get()->result();
        $this->db->cache_off();
    }

    public function load_catDescription($id)
    {
        $this->db->cache_on();
        return $this->db->select('*,tbl_subcategory.id as subid')->from('tbl_subcategory')->join('tbl_categories', 'tbl_categories.id=tbl_subcategory.cid')->where(['tbl_subcategory.cid' => $id, 'tbl_subcategory.parent_sub' => 0])->get()->result();
        $this->db->cache_off();
    }

    public function loadSpecification($id)
    {
        return $this->db->get_where("tbl_specification", ['pro_id' => $id])->result();
    }

    public function getCategory($id)
    {

        return $this->db->query("select id FROM tbl_categories WHERE MATCH(cat_name) against('$id' IN BOOLEAN MODE)")->result();
    }

    public function getSubCategory($id, $cat)
    {

        return $this->db->query("select id FROM tbl_subcategory   WHERE cid=$cat and  sub_name LIKE '%$id%' ")->result();
    }

    public function getChildCategory($id, $sub, $cat)
    {
        return $this->db->query("select id FROM tbl_subcategory  WHERE cid=$cat and parent_sub=$sub and  sub_name LIKE '%$id%' ")->result();
    }

    public function getProList($pr, $page, $perpage, $link)
    {

        $this->db->cache_on();

        $this->db->select('*,tbl_product.id as ID');
        $this->db->from("tbl_product_categories");
        $this->db->join('tbl_product', 'tbl_product.id=tbl_product_categories.pro_id');
        $this->db->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');
        $this->db->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id');

        if (isset($link["color"]) && $link["color"] != null) {
            $this->db->join("tbl_product_property", "tbl_product_property.pro_id=tbl_product.id")->join("tbl_prod_prop", "tbl_prod_prop.id=tbl_product_property.property_id");
        }
        if ((isset($link["sleevelength"]) && $link["sleevelength"] != null) || (isset($link["pattern"]) && $link["pattern"] != null) || (isset($link["neck"]) && $link["neck"] != null) || (isset($link["occasion"]) && $link["occasion"] != null) || (isset($link["fabric"]) && $link["fabric"] != null)) {
            $this->db->join("tbl_specification", "tbl_specification.pro_id=tbl_product.id");
        }
        $this->db->group_start();
        $this->db->like('pro_name', $pr);
        $this->db->or_like('cat_name', $pr);
        $this->db->or_like('sub_name', $pr);
        $this->db->group_end();
        $this->db->group_start();
        $this->db->where(array('tbl_product.pro_sta' => 1, 'pro_stock>' => 0));

        $stringPrice = "";
        $colorString = "";
        if (isset($link["color"]) && $link["color"] != null) {

            $colors = explode(":", $link["color"]);
            foreach ($colors as $cKey => $color) {
                if ($cKey == 0) {
                    $colorString .= "(tbl_prod_prop.color_code='#$color')";
                } else {
                    $colorString .= " or (tbl_prod_prop.color_code='#$color')";
                }
            }
            $this->db->where($colorString);

        }
        if (isset($link["price"]) && $link["price"] != null) {
            $prices = explode(":", $link["price"]);

            foreach ($prices as $prKey => $price) {
                $range = explode("|", $price);
                $less = $range[0];
                $large = $range[1];
                if ($prKey == 0) {
                    $stringPrice .= "(tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                } else {
                    $stringPrice .= " or (tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                }
            }
            $this->db->where($stringPrice);
        }

        if (isset($link["sleevelength"]) && $link["sleevelength"] != null) {
            $sleeves = explode(":", $link['sleevelength']);
            foreach ($sleeves as $sleeve) {
                $this->db->like(["value" => "$sleeve"]);
            }
        }
        if (isset($link["pattern"]) && $link["pattern"] != null) {
            $patterns = explode(":", $link['pattern']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["neck"]) && $link["neck"] != null) {
            $patterns = explode(":", $link['neck']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["occasion"]) && $link["occasion"] != null) {
            $occasions = explode(":", $link['occasion']);
            foreach ($occasions as $occasion) {
                $this->db->like(["value" => "$occasion"]);
            }
        }
        if (isset($link["fabric"]) && $link["fabric"] != null) {
            $fabrics = explode(":", $link['fabric']);
            foreach ($fabrics as $fabric) {
                $this->db->like(["value" => "$fabric"]);
            }
        }
        $this->db->group_end();
        $this->db->limit($perpage, $page);
        $this->db->group_by('tbl_product.id');
        $query = $this->db->get()->result();
        return $query;
        $this->db->cache_off();
    }

    public function getProListCount($pr, $link)
    {

        $this->db->cache_on();
        $this->db->select('*,tbl_product.id as ID');
        $this->db->from("tbl_product_categories");
        $this->db->join('tbl_product', 'tbl_product.id=tbl_product_categories.pro_id');
        $this->db->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');
        $this->db->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id');

        if (isset($link["color"]) && $link["color"] != null) {
            $this->db->join("tbl_product_property", "tbl_product_property.pro_id=tbl_product.id")->join("tbl_prod_prop", "tbl_prod_prop.id=tbl_product_property.property_id");
        }
        if ((isset($link["sleevelength"]) && $link["sleevelength"] != null) || (isset($link["pattern"]) && $link["pattern"] != null) || (isset($link["neck"]) && $link["neck"] != null) || (isset($link["occasion"]) && $link["occasion"] != null) || (isset($link["fabric"]) && $link["fabric"] != null)) {
            $this->db->join("tbl_specification", "tbl_specification.pro_id=tbl_product.id");
        }
        $this->db->like('pro_name', $pr);
        $this->db->or_like('cat_name', $pr);
        $this->db->or_like('sub_name', $pr);
        $this->db->group_start();
        $this->db->where(array('tbl_product.pro_sta' => 1, 'pro_stock>' => 0));

        $stringPrice = "";

        if (isset($link["price"]) && $link["price"] != null) {
            $prices = explode(":", $link["price"]);

            foreach ($prices as $prKey => $price) {
                $range = explode("|", $price);
                $less = $range[0];
                $large = $range[1];
                if ($prKey == 0) {
                    $stringPrice .= "(tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                } else {
                    $stringPrice .= " or (tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                }
            }
            $this->db->where($stringPrice);
        }
        $colorString = "";
        if (isset($link["color"]) && $link["color"] != null) {

            $colors = explode(":", $link["color"]);
            foreach ($colors as $cKey => $color) {
                if ($cKey == 0) {
                    $colorString .= "(tbl_prod_prop.color_code='#$color')";
                } else {
                    $colorString .= " or (tbl_prod_prop.color_code='#$color')";
                }
            }
            $this->db->where($colorString);

        }

        if (isset($link["sleevelength"]) && $link["sleevelength"] != null) {
            $sleeves = explode(":", $link['sleevelength']);
            foreach ($sleeves as $sleeve) {
                $this->db->like(["value" => "$sleeve"]);
            }
        }
        if (isset($link["pattern"]) && $link["pattern"] != null) {
            $patterns = explode(":", $link['pattern']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["neck"]) && $link["neck"] != null) {
            $patterns = explode(":", $link['neck']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["occasion"]) && $link["occasion"] != null) {
            $occasions = explode(":", $link['occasion']);
            foreach ($occasions as $occasion) {
                $this->db->like(["value" => "$occasion"]);
            }
        }
        if (isset($link["fabric"]) && $link["fabric"] != null) {
            $fabrics = explode(":", $link['fabric']);
            foreach ($fabrics as $fabric) {
                $this->db->like(["value" => "$fabric"]);
            }
        }
        $this->db->group_end();

        $this->db->group_by('tbl_product.id');
        $query = $this->db->get()->result();

        return $query;
        $this->db->cache_off();
    }

    public function getSubName($pid)
    {
        return $this->db->get_where('tbl_subcategory', array('id' => $pid))->result()[0];
    }

    public function getSearchProd($pr)
    {
        $this->db->cache_on();

        return $this->db->query("select *,tbl_subcategory.id as ID from tbl_subcategory JOIN tbl_categories on tbl_categories.id=tbl_subcategory.cid where (cat_sta=1 ) and (sub_name like '%$pr%' or cat_name like '%$pr%' or sub_desc like '%$pr%' or sub_title like '%$pr%' or cat_desc like '%$pr%') GROUP BY tbl_subcategory.sub_name ")->result();
        $this->db->cache_off();
    }

    public function loadBySubCat($sub_id, $start = 0, $range1 = 20, $link)
    {

        // $this->db->cache_on();

        $this->db->limit($range1, $start);
        $this->db->select('*,tbl_product.id as ID');
        $this->db->from("tbl_product_categories");
        $this->db->join("tbl_product", "tbl_product_categories.pro_id=tbl_product.id");
        $this->db->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');

        $query = $this->db->get()->result();

        return $query;
        // $this->db->cache_off();

    }

    public function loadProductBySubCategory($sub_id, $start = 0, $range1 = 20, $link)
    {

        $this->db->cache_on();
        $this->db->limit($range1, $start);
        $this->db->select('*,tbl_product.id as ID');
        $this->db->from("tbl_product_categories");
        $this->db->join("tbl_product", "tbl_product_categories.pro_id=tbl_product.id");
        $this->db->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');
        $this->db->order_by('tbl_product.id', 'desc');

        if (isset($link["color"]) && $link["color"] != null) {

            $this->db->join("tbl_product_property", "tbl_product_property.pro_id=tbl_product.id")->join("tbl_prod_prop", "tbl_prod_prop.id=tbl_product_property.property_id");
        }

        if ((isset($link["sleevelength"]) && $link["sleevelength"] != null) || (isset($link["pattern"]) && $link["pattern"] != null) || (isset($link["neck"]) && $link["neck"] != null) || (isset($link["occasion"]) && $link["occasion"] != null) || (isset($link["fabric"]) && $link["fabric"] != null)) {
            $this->db->join("tbl_specification", "tbl_specification.pro_id=tbl_product.id");
        }

        $stringPrice = "";
        $this->db->where('tbl_product_categories.sub_id', $sub_id);
        $this->db->group_start();
        $this->db->where('pro_stock>', '0')->where('pro_sta', '1');
        if (isset($link["price"]) && $link["price"] != null) {
            $prices = explode(":", $link["price"]);
            foreach ($prices as $prKey => $price) {
                $range = explode("|", $price);
                $less = $range[0];
                $large = $range[1];
                if ($prKey == 0) {
                    $stringPrice .= "(tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                } else {
                    $stringPrice .= " or (tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                }
            }
            $this->db->where($stringPrice);
        }
        $colorString = "";
        if (isset($link["color"]) && $link["color"] != null) {

            $colors = explode(":", $link["color"]);
            foreach ($colors as $cKey => $color) {
                if ($cKey == 0) {
                    $colorString .= "(tbl_prod_prop.color_code='#$color')";
                } else {
                    $colorString .= " or (tbl_prod_prop.color_code='#$color')";
                }
            }
            $this->db->where($colorString);

        }

        if (isset($link["sleevelength"]) && $link["sleevelength"] != null) {
            $sleeves = explode(":", $link['sleevelength']);
            foreach ($sleeves as $sleeve) {
                $this->db->like(["value" => "$sleeve"]);
            }
        }
        if (isset($link["pattern"]) && $link["pattern"] != null) {
            $patterns = explode(":", $link['pattern']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["neck"]) && $link["neck"] != null) {
            $patterns = explode(":", $link['neck']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["occasion"]) && $link["occasion"] != null) {
            $occasions = explode(":", $link['occasion']);
            foreach ($occasions as $occasion) {
                $this->db->like(["value" => "$occasion"]);
            }
        }
        if (isset($link["fabric"]) && $link["fabric"] != null) {
            $fabrics = explode(":", $link['fabric']);
            foreach ($fabrics as $fabric) {
                $this->db->like(["value" => "$fabric"]);
            }
        }

        $this->db->group_end();

        $this->db->group_by('tbl_product.id');

        $query = $this->db->get()->result();

        return $query;
        $this->db->cache_off();

    }

    public function allsubcatProducts($sub_id, $link)
    {

        $this->db->cache_on();
        $stringPrice = "";
        $this->db->select('*,tbl_product.id as ID');
        $this->db->from("tbl_product_categories");
        $this->db->join("tbl_product", "tbl_product_categories.pro_id=tbl_product.id");
        $this->db->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');

        if (isset($link["color"]) && $link["color"] != null) {

            $this->db->join("tbl_product_property", "tbl_product_property.pro_id=tbl_product.id")->join("tbl_prod_prop", "tbl_prod_prop.id=tbl_product_property.property_id");
        }

        if ((isset($link["sleevelength"]) && $link["sleevelength"] != null) || (isset($link["pattern"]) && $link["pattern"] != null) || (isset($link["neck"]) && $link["neck"] != null) || (isset($link["occasion"]) && $link["occasion"] != null) || (isset($link["fabric"]) && $link["fabric"] != null)) {
            $this->db->join("tbl_specification", "tbl_specification.pro_id=tbl_product.id");
        }
        $this->db->where('tbl_product_categories.sub_id', $sub_id);
        $this->db->group_start();
        $this->db->where('pro_stock>', '0')->where('pro_sta', '1');

        if (isset($link["price"]) && $link["price"] != null) {
            $prices = explode(":", $link["price"]);

            foreach ($prices as $prKey => $price) {
                $range = explode("|", $price);
                $less = $range[0];
                $large = $range[1];
                if ($prKey == 0) {
                    $stringPrice .= "(tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                } else {
                    $stringPrice .= " or (tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                }
            }
            $this->db->where($stringPrice);
        }
        $colorString = "";
        if (isset($link["color"]) && $link["color"] != null) {

            $colors = explode(":", $link["color"]);
            foreach ($colors as $cKey => $color) {
                if ($cKey == 0) {
                    $colorString .= "(tbl_prod_prop.color_code='#$color')";
                } else {
                    $colorString .= " or (tbl_prod_prop.color_code='#$color')";
                }
            }
            $this->db->where($colorString);

        }

        if (isset($link["sleevelength"]) && $link["sleevelength"] != null) {
            $sleeves = explode(":", $link['sleevelength']);
            foreach ($sleeves as $sleeve) {
                $this->db->like(["value" => "$sleeve"]);
            }
        }
        if (isset($link["pattern"]) && $link["pattern"] != null) {
            $patterns = explode(":", $link['pattern']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["neck"]) && $link["neck"] != null) {
            $patterns = explode(":", $link['neck']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["occasion"]) && $link["occasion"] != null) {
            $occasions = explode(":", $link['occasion']);
            foreach ($occasions as $occasion) {
                $this->db->like(["value" => "$occasion"]);
            }
        }
        if (isset($link["fabric"]) && $link["fabric"] != null) {
            $fabrics = explode(":", $link['fabric']);
            foreach ($fabrics as $fabric) {
                $this->db->like(["value" => "$fabric"]);
            }
        }

        $this->db->group_end();
        $this->db->order_by('tbl_product.pro_stock', 'desc');
        $this->db->group_by('tbl_product.id');

        $query = $this->db->get()->result();

        return $query;
        $this->db->cache_off();
    }

    public function loadAllProductBySubCategory($sub_id, $link)
    {
        $this->db->cache_on();
        $stringPrice = "";
        $this->db->select('*,tbl_product.id as ID');
        $this->db->from("tbl_product_categories");
        $this->db->join("tbl_product", "tbl_product_categories.pro_id=tbl_product.id");
        $this->db->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');

        if (isset($link["color"]) && $link["color"] != null) {

            $this->db->join("tbl_product_property", "tbl_product_property.pro_id=tbl_product.id")->join("tbl_prod_prop", "tbl_prod_prop.id=tbl_product_property.property_id");
        }

        if ((isset($link["sleevelength"]) && $link["sleevelength"] != null) || (isset($link["pattern"]) && $link["pattern"] != null) || (isset($link["neck"]) && $link["neck"] != null) || (isset($link["occasion"]) && $link["occasion"] != null) || (isset($link["fabric"]) && $link["fabric"] != null)) {
            $this->db->join("tbl_specification", "tbl_specification.pro_id=tbl_product.id");
        }
        $this->db->where('tbl_product_categories.sub_id', $sub_id);
        $this->db->group_start();
        $this->db->where('pro_stock>', '0')->where('pro_sta', '1');

        if (isset($link["price"]) && $link["price"] != null) {
            $prices = explode(":", $link["price"]);

            foreach ($prices as $prKey => $price) {
                $range = explode("|", $price);
                $less = $range[0];
                $large = $range[1];
                if ($prKey == 0) {
                    $stringPrice .= "(tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                } else {
                    $stringPrice .= " or (tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                }
            }
            $this->db->where($stringPrice);
        }
        $colorString = "";
        if (isset($link["color"]) && $link["color"] != null) {

            $colors = explode(":", $link["color"]);
            foreach ($colors as $cKey => $color) {
                if ($cKey == 0) {
                    $colorString .= "(tbl_prod_prop.color_code='#$color')";
                } else {
                    $colorString .= " or (tbl_prod_prop.color_code='#$color')";
                }
            }
            $this->db->where($colorString);

        }

        if (isset($link["sleevelength"]) && $link["sleevelength"] != null) {
            $sleeves = explode(":", $link['sleevelength']);
            foreach ($sleeves as $sleeve) {
                $this->db->like(["value" => "$sleeve"]);
            }
        }
        if (isset($link["pattern"]) && $link["pattern"] != null) {
            $patterns = explode(":", $link['pattern']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["neck"]) && $link["neck"] != null) {
            $patterns = explode(":", $link['neck']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["occasion"]) && $link["occasion"] != null) {
            $occasions = explode(":", $link['occasion']);
            foreach ($occasions as $occasion) {
                $this->db->like(["value" => "$occasion"]);
            }
        }
        if (isset($link["fabric"]) && $link["fabric"] != null) {
            $fabrics = explode(":", $link['fabric']);
            foreach ($fabrics as $fabric) {
                $this->db->like(["value" => "$fabric"]);
            }
        }

        $this->db->group_end();
        $this->db->order_by('tbl_product.pro_stock', 'desc');
        $this->db->group_by('tbl_product.id');

        $query = $this->db->get()->result();
        // echo $this->db->last_query();
        // die;
        return $query;
        $this->db->cache_off();
    }

    public function getAwb($id)
    {
        return $this->db->get_where('tbl_order', array('id' => $id))->result();
    }

    public function getZip($zip)
    {
        $data = $this->db->get_where('tbl_ecom_zip', array('zip_address' => $zip))->result();
        echo count($data);
    }

    public function products($child_sub_id, $start = 0, $rangeq = 20, $link)
    {

        $this->db->select('*,tbl_product.id as ID');
        $this->db->from("tbl_product_categories");
        $this->db->join('tbl_product', 'tbl_product.id=tbl_product_categories.pro_id');
        $this->db->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');
        $this->db->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id');
        $this->db->order_by('tbl_product.id', 'desc');

        if (isset($link["color"]) && $link["color"] != null) {
            $this->db->join("tbl_product_property", "tbl_product_property.pro_id=tbl_product.id")->join("tbl_prod_prop", "tbl_prod_prop.id=tbl_product_property.property_id");
        }
        if ((isset($link["sleevelength"]) && $link["sleevelength"] != null) || (isset($link["pattern"]) && $link["pattern"] != null) || (isset($link["neck"]) && $link["neck"] != null) || (isset($link["occasion"]) && $link["occasion"] != null) || (isset($link["fabric"]) && $link["fabric"] != null)) {
            $this->db->join("tbl_specification", "tbl_specification.pro_id=tbl_product.id");
        }
        $this->db->where(array('tbl_product_categories.child_id' => $child_sub_id));
        $this->db->group_start();
        $this->db->where(array('tbl_product.pro_sta' => 1, 'pro_stock>' => 0));

        $stringPrice = "";

        if (isset($link["price"]) && $link["price"] != null) {
            $prices = explode(":", $link["price"]);

            foreach ($prices as $prKey => $price) {
                $range = explode("|", $price);
                $less = $range[0];
                $large = $range[1];
                if ($prKey == 0) {
                    $stringPrice .= "(tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                } else {
                    $stringPrice .= " or (tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                }
            }
            $this->db->where($stringPrice);
        }
        $colorString = "";
        if (isset($link["color"]) && $link["color"] != null) {

            $colors = explode(":", $link["color"]);
            foreach ($colors as $cKey => $color) {
                if ($cKey == 0) {
                    $colorString .= "(tbl_prod_prop.color_code='#$color')";
                } else {
                    $colorString .= " or (tbl_prod_prop.color_code='#$color')";
                }
            }
            $this->db->where($colorString);

        }

        if (isset($link["sleevelength"]) && $link["sleevelength"] != null) {
            $sleeves = explode(":", $link['sleevelength']);
            foreach ($sleeves as $sleeve) {
                $this->db->like(["value" => "$sleeve"]);
            }
        }
        if (isset($link["pattern"]) && $link["pattern"] != null) {
            $patterns = explode(":", $link['pattern']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["neck"]) && $link["neck"] != null) {
            $patterns = explode(":", $link['neck']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["occasion"]) && $link["occasion"] != null) {
            $occasions = explode(":", $link['occasion']);
            foreach ($occasions as $occasion) {
                $this->db->like(["value" => "$occasion"]);
            }
        }
        if (isset($link["fabric"]) && $link["fabric"] != null) {
            $fabrics = explode(":", $link['fabric']);
            foreach ($fabrics as $fabric) {
                $this->db->like(["value" => "$fabric"]);
            }
        }
        $this->db->group_end();

        $this->db->limit($rangeq, $start);
        $this->db->group_by('tbl_product.id');

        $query = $this->db->get()->result();

        return $query;
    }

    public function allproducts($child_sub_id, $link)
    {

        $this->db->select('*,tbl_product.id as ID');
        $this->db->from("tbl_product_categories");
        $this->db->join('tbl_product', 'tbl_product.id=tbl_product_categories.pro_id');
        $this->db->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');
        $this->db->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id');
        if (isset($link["color"]) && $link["color"] != null) {

            $this->db->join("tbl_product_property", "tbl_product_property.pro_id=tbl_product.id")->join("tbl_prod_prop", "tbl_prod_prop.id=tbl_product_property.property_id");
        }
        if ((isset($link["sleevelength"]) && $link["sleevelength"] != null) || (isset($link["pattern"]) && $link["pattern"] != null) || (isset($link["neck"]) && $link["neck"] != null) || (isset($link["occasion"]) && $link["occasion"] != null) || (isset($link["fabric"]) && $link["fabric"] != null)) {
            $this->db->join("tbl_specification", "tbl_specification.pro_id=tbl_product.id");
        }
        $this->db->where(array('tbl_product_categories.child_id' => $child_sub_id));
        $this->db->group_start();
        $this->db->where(array('tbl_product.pro_sta' => 1, 'pro_stock>' => 0));
        $stringPrice = "";

        if (isset($link["price"]) && $link["price"] != null) {
            $prices = explode(":", $link["price"]);

            foreach ($prices as $prKey => $price) {
                $range = explode("|", $price);
                $less = $range[0];
                $large = $range[1];
                if ($prKey == 0) {
                    $stringPrice .= "(tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                } else {
                    $stringPrice .= " or (tbl_product.dis_price>=$less and tbl_product.dis_price<$large)";
                }
            }
            $this->db->where($stringPrice);
        }
        $colorString = "";
        if (isset($link["color"]) && $link["color"] != null) {

            $colors = explode(":", $link["color"]);
            foreach ($colors as $cKey => $color) {
                if ($cKey == 0) {
                    $colorString .= "(tbl_prod_prop.color_code='#$color')";
                } else {
                    $colorString .= " or (tbl_prod_prop.color_code='#$color')";
                }
            }
            $this->db->where($colorString);

        }

        if (isset($link["sleevelength"]) && $link["sleevelength"] != null) {
            $sleeves = explode(":", $link['sleevelength']);
            foreach ($sleeves as $sleeve) {
                $this->db->like(["value" => "$sleeve"]);
            }
        }
        if (isset($link["pattern"]) && $link["pattern"] != null) {
            $patterns = explode(":", $link['pattern']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["neck"]) && $link["neck"] != null) {
            $patterns = explode(":", $link['neck']);
            foreach ($patterns as $pattern) {
                $this->db->like(["value" => "$pattern"]);
            }
        }
        if (isset($link["occasion"]) && $link["occasion"] != null) {
            $occasions = explode(":", $link['occasion']);
            foreach ($occasions as $occasion) {
                $this->db->like(["value" => "$occasion"]);
            }
        }
        if (isset($link["fabric"]) && $link["fabric"] != null) {
            $fabrics = explode(":", $link['fabric']);
            foreach ($fabrics as $fabric) {
                $this->db->like(["value" => "$fabric"]);
            }
        }
        $this->db->group_end();

        $this->db->group_by('tbl_product.id');
        $query = $this->db->get()->result();

        return $query;
    }

    public function getOneProducts($id)
    {

        $this->db->cache_on();
        return $this->db->select('*,tbl_product.id as ID')->from("tbl_product_categories")->JOIN("tbl_product", "tbl_product_categories.pro_id=tbl_product.id")->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('tbl_product.id' => $id))->where(array('tbl_product.pro_sta' => 1, 'pro_stock>' => 0))->get()->result();
        $this->db->cache_off();
    }

    public function insertAwb($awb)
    {
        $this->db->insert("tbl_awb", array("awb_no" => $awb, "datentime" => date('Y-m-d H:i:s')));
    }

    public function getProduct($id)
    {
        return $this->db->get_where('tbl_product', array('id' => $id))->result() ? $this->db->get_where('tbl_product', array('id' => $id))->result()[0] : null;
    }

    public function getfeaturedProdduct()
    {
//return $this->db->select('*')->from("tbl_feature_product")->join("tbl_product", 'tbl_feature_product.pro_id=tbl_product.id')->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product.sub_id=tbl_subcategory.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->get()->result();
    }

    public function getnewProdduct()
    {
//   return $this->db->select('*')->from("tbl_new_products")->join("tbl_product", 'tbl_new_products.pro_id=tbl_product.id')->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product.sub_id=tbl_subcategory.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->get()->result();
    }

    public function getTopSeller()
    {
//  return $this->db->select('*')->from("tbl_top_seller")->join("tbl_product", 'tbl_top_seller.pro_id=tbl_product.id')->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product.sub_id=tbl_subcategory.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->get()->result();
    }

    public function getProductImage($id)
    {
        $images = $this->db->get_where('tbl_pro_img', array('pro_id' => $id))->result();
        if (count($images) > 0) {
            return $images[0]->pro_images;
        } else {
            return "no-image.png";
        }
    }

    public function productPrice($id)
    {
        $result = $this->db->get_where('tbl_product', array('id' => $id))->result()[0];
        $price = ($result->dis_price != '' || $result->dis_price != 0) ? floatval($result->dis_price) : floatval($result->act_price);
        return $price;
    }

    public function getChangePrice($id)
    {
        $res = $this->db->get_where('tbl_set_property', array('id' => $id))->result();
        if (count($res) > 0) {
            return $res[0]->change_price != '' ? $res[0]->change_price : 0;
        } else {
            return 0;
        }
    }

    public function registration($post)
    {
        $this->db->insert('tbl_user_reg', array('user_name' => $post['fullname'], "lastname" => $post["lastname"], 'user_email' => $post['username'], 'user_contact' => $post['contact'], 'user_password' => $post['cpassword'], 'gender' => $post['switch-one']));
        $id = $this->db->insert_id();

        return $this->db->insert('customer_group', array('group_name' => 1, 'user_id' => $id));
    }

    public function prime_registration($post)
    {
        $is_prime = $this->db->get_where("tbl_user_reg", ["user_email" => $post['username'], "user_contact" => $post['contact'], "is_prime" => 1])->result();
        if (count($is_prime) > 0) {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'>User Already Exist Please Login</div>");
            return redirect('Myaccount');
        } else {
            $this->db->insert('tbl_user_reg', array('user_name' => $post['fullname'], "lastname" => $post["lastname"], 'user_email' => $post['username'], 'user_contact' => $post['contact'], 'user_password' => $post['cpassword'], 'is_prime' => 0, 'prime_amt' => $post['amt'], 'prime_date' => date("Y-m-d")));
            return $this->db->insert_id();
        }
    }

    public function primeAmt()
    {
        return $this->db->get('prime_membership')->result()[0];
    }

    public function googleregistration($post)
    {

        if (isset($post["app_id"]) && $post["app_id"] != '') {
            $this->db->insert('tbl_user_reg', array("app_id" => $post["app_id"], 'user_name' => $post['name'], 'user_email' => $post['email']));
        } else {
            $this->db->insert('tbl_user_reg', array('user_name' => $post['name'], 'user_email' => $post['email']));
        }
        $id = $this->db->insert_id();
        return $this->db->insert('customer_group', array('group_name' => 1, 'user_id' => $id));
    }

    public function facebookRegistration($post)
    {
        $fullname = $post['user']['first_name'] . ' ' . $post['user']['last_name'];
        if (!isset($post['user']['email'])) {
            $this->db->insert('tbl_user_reg', array('user_name' => $fullname, 'app_id' => $post['user']['id']));
            $id = $this->db->insert_id();
            $this->db->insert('customer_group', array('group_name' => 1, 'user_id' => $id));
            return $id;
        } else {
            $this->db->insert('tbl_user_reg', array('user_name' => $fullname, 'app_id' => $post['user']['id'], 'user_email' => $post['user']['email']));
            $id = $this->db->insert_id();
            $this->db->insert('customer_group', array('group_name' => 1, 'user_id' => $id));
            return $id;
        }
    }

    public function insertIntoWish($product, $prop = null, $attr = null, $total, $id)
    {

        $this->db->cache_delete_all();

        $dataPrid = $this->db->query("select * from tbl_wish where pro_id= '$product' and user = '$id'")->result();

        if (count($dataPrid) == 0) {
            $this->db->insert("tbl_wish", ["pro_id" => $product, "user" => $id, "total_price" => $total]);
            return "Item Added To Wishlist";
        } else {
            return "Already in wishlist";
        }
    }

    public function removeFromWishList($id)
    {
        $this->db->delete("tbl_wish", ["id" => $id]);
        $this->db->cache_delete_all();
    }

    public function getWishList($id)
    {
        return $this->db->get_where("tbl_wish", ["user" => $id])->result();
    }

    public function getUserIdByEmail()
    {
        if ($this->session->userdata("myaccount") != null) {
            return @$data = $this->get_profile($this->session->userdata("myaccount"))->id;
        } else {
            return @$data = $this->get_profile($this->session->userdata("app_id"))->id;
        }
    }

    public function isPrime()
    {
        $id = $this->getUserIdByEmail();
        return $this->db->get_where("tbl_user_reg", ["is_prime" => 1, "id" => $id, "prime_sta" => 1])->result();
    }

    public function assignPrime()
    {
        $userID = $this->getUserIdByEmail();
        $qry = $this->db->update('tbl_user_reg', ['is_prime' => 1, 'prime_date' => date('Y-m-d')], ['id' => $userID]);
        if ($qry) {
            $this->db->cache_delete_all();
            return true;
        } else {
            return false;
        }
    }

    public function insertIntoCustomerAddress($post, $id)
    {

        if (!isset($post["form_id"])) {
            $this->db->insert("tbl_user_address", ["user_id" => $id, "fname" => $post["fname"], "address" => $post["address"], "phone" => $post["phone"], "pin_code" => $post["pincode"], "state" => $post["state"], "locality" => $post["locality"], "city" => $post["city"], "type" => $post["address_type"], "is_default" => isset($post["default_add"]) ? $post["default_add"] : ""]);
        } else {
            $this->db->update("tbl_user_address", ["fname" => $post["fname"], "address" => $post["address"], "phone" => $post["phone"], "pin_code" => $post["pincode"], "state" => $post["state"], "locality" => $post["locality"], "city" => $post["city"], "type" => $post["address_type"], "is_default" => isset($post["default_add"]) ? $post["default_add"] : ""], ["id" => $this->encryption->decrypt(decode($post["form_id"]))]);
        }

        return $this->db->cache_delete("Checkout", "Address");
    }

    public function insertin_address($fname, $phone, $pincode, $state, $address, $locality, $city, $address_type, $id)
    {
        return $this->db->insert('tbl_user_address', array('user_id' => $id, 'fname' => $fname, 'phone' => $phone, 'pin_code' => $pincode, 'state' => $state, 'address' => $address, 'locality' => $locality, 'city' => $city, 'type' => $address_type));
    }

    public function getShipping()
    {
        return $this->db->get("tbl_ship")->result();
    }

    public function deleteAddress($id)
    {

        $query = $this->db->delete("tbl_user_address", ["id" => $this->encryption->decrypt(decode($id))]);

        if ($query) {
            echo "1";
        } else {
            echo "0";
        }
        return $this->db->cache_delete_all();
    }

    public function selectAddress($id)
    {
        $this->db->cache_delete_all();
        return $query = $this->db->get_where("tbl_user_address", ["id" => $this->encryption->decrypt(decode($id))])->result()[0];
    }

    public function getAddresses()
    {
        $this->db->cache_delete_all();
        $id = $this->getUserIdByEmail();
        return $this->db->get_where("tbl_user_address", ["user_id" => $id])->result();
    }

    public function get_profile($user)
    {
        if ($this->session->userdata("myaccount") != null) {
            return @$this->db->get_where('tbl_user_reg', array('user_email' => $user))->result()[0];
        }
        if ($this->session->userdata("app_id") != null) {
            return $this->db->get_where('tbl_user_reg', array('app_id' => $user))->result()[0];
        }
        $qry = $this->db->get_where('tbl_user_reg', array('user_email' => $user))->result();
        if (count($qry) > 0) {
            return $qry[0];
        } else {
            return false;
        }
    }

    public function get_User($app)
    {

        return $this->db->get_where('tbl_user_reg', array('app_id' => $app))->result();
    }

    public function get_UserByEmail($mail)
    {

        return $this->db->get_where('tbl_user_reg', array('user_email' => $mail))->result();
    }

    public function get_profile_id($id)
    {
        return $this->db->get_where('tbl_user_reg', array('id' => $id))->result()[0];
    }

    public function update_password($id, $password)
    {

        return $this->db->update('tbl_user_reg', array('user_password' => $password), array('id' => $id));
    }

    public function getCustomerOrder()
    {
        if ($this->session->userdata("myaccount") != null) {
            return $this->db->order_by("tbl_customer_order.id", "desc")->get_where("tbl_customer_order", ["registered_user" => $this->session->userdata("myaccount"), "pay_sta" => "1"])->result();
        } else {
            return $this->db->order_by("tbl_customer_order.id", "desc")->get_where("tbl_customer_order", ["registered_user" => $this->session->userdata("app_id"), "pay_sta" => "1"])->result();
        }
//return $this->db->get_where("tbl_customer_order", ["registered_user" => $this->session->userdata("myaccount"), "pay_sta" => "1"])->result();
    }

    public function allCustomerOrders($customer_order)
    {

        return $this->db->select('*,tbl_order.id as or_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->where(array('tbl_order.order_id' => $customer_order, "tbl_customer_order.pay_sta" => 1))->get()->result();
    }

    public function allCustomerOrders2($orderID)
    {
        return $this->db->select('*,tbl_order.id as or_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join("tbl_user_address", "tbl_user_address.id=tbl_customer_order.address_id")->where(array('tbl_order.order_id' => $orderID, "tbl_customer_order.pay_sta" => 1))->get()->result();
    }

    public function allOrders($email)
    {

        return $this->db->select('*,tbl_order.id as or_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('registered_user' => $email, 'order_sta' => 0, "tbl_customer_order.pay_sta" => 1))->order_by("tbl_order.id ", "desc")->get()->result();
    }

    public function allOrdersByFB($app_id)
    {
        return $this->db->select('*,tbl_order.id as or_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('app_id' => $app_id, 'order_sta' => 0, "tbl_customer_order.pay_sta" => 1))->order_by("tbl_order.id ", "desc")->get()->result();
    }

    public function allOrdersOrderId($orderId)
    {
        return $this->db->select('*,tbl_order.id as or_id,tbl_product.gst as gst_per,tbl_signups.state as ven_state,tbl_customer_order.state as cus_state')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('tbl_customer_order.id' => $orderId, 'tbl_customer_order.pay_sta' => 1))->get()->result();
    }

    public function allFaildOrderId($orderId)
    {
        return $this->db->select('*,tbl_order.id as or_id,tbl_product.gst as gst_per,tbl_signups.state as ven_state,tbl_customer_order.state as cus_state')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('tbl_customer_order.id' => $orderId, 'tbl_customer_order.pay_sta' => 0))->get()->result();
    }
    public function allDispatchOrderId($orderId)
    {
        return $this->db->select('*,tbl_order.id as or_id,tbl_product.gst as gst_per,tbl_signups.state as ven_state,tbl_customer_order.state as cus_state')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('tbl_customer_order.id' => $orderId, 'tbl_customer_order.pay_sta' => 0))->get()->result();
    }

    public function vendorInvoice($id, $from, $to)
    {
        return $this->db->select('*,tbl_order.id as or_id,tbl_product.gst as gst_per,tbl_signups.state as ven_state,,tbl_customer_order.state as cus_state')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->where('tbl_signups.id', $id)->where('tbl_customer_order.pay_sta', 1)->where('tbl_customer_order.pay_date >= ', $from)->where('is_invoiced', 0)->where('tbl_customer_order.pay_date <= ', $to)->get()->result();
    }

    public function getCancellationDetails($orderId)
    {
        return $this->db->select('*,tbl_order.id as or_id,tbl_product.gst as gst_per,tbl_signups.state as ven_state,,tbl_customer_order.state as cus_state')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->where(array('tbl_order.id' => $orderId))->get()->result();
    }

    public function cancelPayment($id)
    {
        return $this->db->update('tbl_customer_order', array('pay_sta' => 2), array('id' => $id));
    }

    public function getPendingOrder($id)
    {
        return $this->db->get_where("tbl_customer_order", ["pay_sta" => 0, "id" => $id])->result()[0];
    }

    public function changeStatus($tran_id)
    {
        $is_prime = count($this->isPrime()) > 0 ? 1 : 0;
        return $this->db->update("tbl_customer_order", array('pay_sta' => 1, 'prime_book' => $is_prime), array('transcation_id' => $tran_id));
    }

    public function getOrderByTran($tran_id)
    {
        return $this->db->get_where("tbl_customer_order", array('transcation_id' => $tran_id))->result();
    }

    public function changeWalletStatus($amt, $or = null)
    {
        if ($amt >= 0) {
            $wallet_amt = $amt;
        } else {
            $wallet_amt = 0;
        }
        $uid = $this->getUserIdByEmail();
//$this->db->update("tbl_wallet", array('wallet_amt' => $wallet_amt), array('user_id' => $uid));
        $this->db->insert('tbl_wallet', array('user_id' => $uid, 'wallet_amt' => $wallet_amt, "order_id" => $or, "is_display" => 1, 'controls' => 1));

        $this->db->cache_delete_all();
    }

    public function getAllInnerOrder($id)
    {
        return $this->db->get_where('tbl_order', array('order_id' => $id))->result();
    }

    public function OrderTable($id)
    {
        return $this->db->get_where('tbl_order', array('id' => $id))->result()[0];
    }

    public function successPayment($id)
    {
        return $this->db->update('tbl_customer_order', array('pay_sta' => 1), array('id' => $id));
    }

    public function addInvoice($id)
    {
        return $this->db->insert('tbl_user_invoice', array('order_id' => $id, "invoice_date" => date("Y-m-d H:i:s")));
    }

    public function getsuccessPayment($id)
    {

        return $this->db->query("select *,tbl_customer_order.id as ID from tbl_customer_order join tbl_user_address on tbl_user_address.id=tbl_customer_order.address_id where tbl_customer_order.id='$id'")->result()[0];
    }

    public function prodcart($user)
    {
        $this->db->delete('tbl_productcart', array('user_id' => $user));
    }

    public function userorder($post, $trn_id, $qtyval)
    {
        $address = $this->selectAddress($post["is_company"]);

        //$pay_sta = $post["pay_method"] == "wallet" ? 0 : 1;

        $shipping = $this->getShipping();
        // echo $shipping;
        // die;
        $shippingVal = 0;
        $is_gifted = 0;
        $gift_price = 0;
        $total = 0;
        $recipent = '';
        $sender = '';
        $gift_msg = '';
        $uid = $this->getUserIdByEmail();
        $userDetail = $this->get_profile_id($uid);

        foreach ($this->session->userdata("addToCart") as $key => $cartItem) {
            $productdetails = getProduct($cartItem["product"]);

            if ($userDetail->is_prime == 1) {
                $getSubscription = $this->load_subscription();
                $primeDiscount = round(floatval($productdetails->dis_price) * floatval($getSubscription->subscription_cal) / 100); // prime member
                $total += round(floatval($productdetails->dis_price) - floatval($primeDiscount)) * intval($cartItem["qty"]);
            } else {
                $total += round(floatval($productdetails->dis_price) * intval($cartItem["qty"]));
            }

            // $total += floatval($productdetails->dis_price) * intval($cartItem["qty"]);
        }
        if ($shipping[0]->ship_min >= $total) {
            $shippingVal = round(floatval($shipping[0]->value));
        }
        if ($post["pay_method"] == "bag") {
            $shippingVal = 0;
        } elseif (($post["pay_method"] == "cod")) {
            $shippingVal = 0;
        } else {
            // $shippingVal = ($qtyval >= 1 && $qtyval <= 10) ? 150 : (($qtyval >= 11 && $qtyval <= 25) ? 300 : ($qtyval > 25 ? 450 : 0));
        }
        // if ($userDetail->is_prime == 1) {
        //     $shippingVal = 0;
        // }
        /* Calculating offer and Gtotal */
        $final_amt = 0.0;
        $offerAmt = 0;

        $grand = round($total + floatval($shippingVal));
        $final_amt = $grand;
        $offer = getAllOffer($this->session->userdata('coupon_Id'));

        if ($this->session->userdata("coupon_Id") != null && $this->session->userdata("coupon_code") != null) {
            $final_amt = (floatval($grand) - floatval($this->session->userdata("coupon_price")));
        }
        if ($this->session->userdata("gift") != null) {
            $final_amt = $final_amt + 99;
            $is_gifted = 1;
            $gift_price = 99;
            $recipent = $this->session->userdata("gift")['recp'];
            $sender = $this->session->userdata("gift")['sender_name'];
            $gift_msg = $this->session->userdata("gift")['msg'];
        }
        /**/
        if ($post["pay_method"] == "cod") {
            $pay_sta = 0;
            $final_amt = floatval($final_amt) - floatval($shippingVal);
        }
        if ($post["pay_method"] == "online") {
            $pay_sta = 1;
        }
        if ($post["pay_method"] == "paytm") {
            $pay_sta = 4;
        }
        if ($post["pay_method"] == "bag") {
            $pay_sta = 6;
            $final_amt = floatval($final_amt) - floatval($shippingVal);
        }
        if (isset($post["pay_method_wallet"]) && $post["pay_method_wallet"] == "wallet") {
            $getWallet = $this->user->getWalletAmt();
            if (floatval($getWallet[0]->wallet_amt) <= floatval(round($final_amt))) {
                $pay_sta = 3;
            } else {
                $pay_sta = 2;
            }
        }

        if ($this->session->userdata('app_id') != null) {
            $reg_user = $this->session->userdata('app_id');
        } else {
            $reg_user = $this->session->userdata('myaccount');
        }
        $addToBag = 0;
        if ($post['pay_method'] == 'bag') {
            $addToBag = 1;
        }

        $this->db->insert('tbl_customer_order', array('registered_user' => $reg_user, "address_id" => $this->encryption->decrypt(decode($post["is_company"])), 'user_email' => $reg_user, 'first_name' => $address->fname, 'last_name' => $address->lname, 'user_address' => $this->security->xss_clean($address->address), "pay_sta" => 0, "state" => $address->state, 'user_city' => $this->security->xss_clean($address->city), 'user_pin_code' => $this->security->xss_clean($address->pin_code), 'pay_date' => date('Y-m-d H:i:s'), 'user_contact' => $this->security->xss_clean($address->phone), "pay_method" => $pay_sta, "total_offer" => $this->session->userdata("coupon_price"), 'offer_code' => $this->session->userdata("coupon_code"), "total_order_price" => round($final_amt), "shipping" => $shippingVal, "is_gifted" => $is_gifted, " recipent" => $recipent, "sender" => $sender, "gift_msg" => $gift_msg, "gift_price" => $gift_price, "transcation_id" => $trn_id, "add_to_box" => $addToBag, "offer_id" => $this->session->userdata("coupon_Id")));
        $order_id = $this->db->insert_id();
        if ($this->session->userdata("coupon_Id") != null) {
            $this->db->insert("tbl_offer_customer", ["ord_id" => $order_id, "user_email" => $reg_user, "offer_id" => $this->session->userdata("coupon_Id")]);
        }
        $order = $this->session->userdata("addToCart");

        foreach ($order as $or) {
            $product = $this->getProduct($or["product"]);
            if ($userDetail->is_prime == 1) {
                $getSubscription = $this->load_subscription();
                $primeDiscount = round(floatval($product->dis_price) * floatval($getSubscription->subscription_cal) / 100); // prime member
                $discountPrice = round(floatval($product->dis_price) - floatval($primeDiscount));
            } else {
                $discountPrice = round(floatval($product->dis_price));
            }
            $query = $this->db->insert('tbl_order', array('order_id' => $order_id, 'pro_id' => $or["product"], "pro_act_p" => $discountPrice, 'pro_qty' => intval($or['qty']), 'pro_price' => $discountPrice * intval($or['qty']), "order_prop" => $or['prop'], "order_attr" => $or['attr'], 'pay_date' => date('Y-m-d H:i:s')));
        }
        if ($query) {
            $this->db->cache_delete_all();
            return $order_id;
        } else {
            return false;
        }
    }

    public function cancelThis($id, $data)
    {
        return $this->db->update('tbl_customer_order', array('order_sta' => 8, "cancel_exta" => $data["comment"], 'cancel_comments' => $data["condition"], "cancel_request_date" => date("Y-m-d H:i:s")), array('id' => $id));
    }

    public function updateCartTime($user)
    {
        return $this->db->update('tbl_productcart', array('date' => date("Y-m-d H:i:s")), array('user_id' => $user));
    }

    // public function deductFromInventory($order)
    // {
    //     foreach ($order as $or) {

    //         $product = $or["product"];
    //         $pro = $this->db->get_where("tbl_product", array("id" => $product))->result()[0];

    //         $property = $or["prop"];
    //         $property2 = json_decode($pro->product_attr);
    //         $assa = $or["attr"];

    //         $subtract = intval($or["qty"]);
            
    //         if ($assa != null) {

    //             foreach (json_decode($pro->product_attr) as $as => $response) {
                    
    //                 foreach ($response as $key => $attribute) {
                        
    //                     if (key((array)$attribute->attribute[0]) == ucfirst($property) && $attribute->attribute[0]->{ucfirst($property)} == ucfirst($assa)) { // if (key((array) $attribute->attribute[0]) == ucfirst($property)) {

    //                         $attr["attribute"] = $attribute->attribute;
    //                         $attr["qty"] = (string) (intval($attribute->qty) - $subtract);
                            
    //                         $attr["changedPrice"] = $attribute->changedPrice != '' ? $attribute->changedPrice : 0;
    //                         unset($property2->response[$key]);
    //                         $property2->response[$key] = (object) $attr;
    //                         $res["response"] = array_values($property2->response);
    //                         $update = json_encode($res);

    //                         $this->db->set('pro_stock', 'pro_stock-' . $subtract . '', false)
    //                             ->set("product_attr", $update)
    //                             ->where('id', $product)
    //                             ->update('tbl_product');
                                
    //                         break;
    //                     }
    //                 }
    //             }
    //         } else {
    //             $this->db->set('pro_stock', 'pro_stock-' . $subtract . '', false)
    //                 ->where('id', $product)
    //                 ->update('tbl_product');

    //         }

    //     }
    // }

    public function deductFromInventory($order)
    {
        // echo "<pre>";
        // print_r($order);
        // die;

        foreach ($order as $or) {
            $product = $or["product"];
            $pro = $this->db->get_where("tbl_product", array("id" => $product))->result()[0];

            $property = $or["prop"];
            $property2 = json_decode($pro->product_attr);
            $assa = $or["attr"];

            $subtract = intval($or["qty"]);
            if ($assa != null) {

                foreach (json_decode($pro->product_attr) as $as => $response) {

                    foreach ($response as $key => $attribute) {

                        if (key((array)$attribute->attribute[0]) == ucfirst($property) && $attribute->attribute[0]->{ucfirst($property)} == ucfirst($assa)) {
                            $attr["attribute"] = $attribute->attribute;
                            $attr["qty"] = (string)(intval($attribute->qty) - $subtract);
                            $attr["changedPrice"] = $attribute->changedPrice != '' ? $attribute->changedPrice : 0;
                            unset($property2->response[$key]);
                            $property2->response[$key] = (object)$attr;
                            $res["response"] = array_values($property2->response);
                            $update = json_encode($res);

                            $this->db->set('pro_stock', 'pro_stock-' . $subtract . '', false)
                                ->set("product_attr", $update)
                                ->where('id', $product)
                                ->update('tbl_product');

                            break;
                        }
                    }
                }
            } else {
                $this->db->set('pro_stock', 'pro_stock-' . $subtract . '', false)
                    ->where('id', $product)
                    ->update('tbl_product');
            }
        }
    }



    public function submitReview($pro, $post)
    {

        $result = $this->db->get_where("tbl_review", array("pro_id" => $pro, "useremail" => $post["email"]))->result();

        if (count($result) == 0) {
            $this->db->insert("tbl_review", array("pro_id" => $pro, "username" => $post["name"], "useremail" => $post["email"], "review" => $post["message"], "rate" => $post["rating"], "dateandtime" => date("Y-m-d H:i:s")));
            return true;
        } else {
            return false;
        }
    }

    public function setTxnId($id)
    {
        $data = $this->db->get_where("tbl_customer_order", ["transcation_id" => $id])->result();

        if (count($data) < 1) {
            $this->db->update('tbl_customer_order', array("transcation_id" => $id), array('id' => $id));
            return true;
        } else {
            return false;
        }
    }

    public function get_checkoutUser($email, $mob)
    {
        $result = $this->db->get_where("tbl_customer_order", array("registered_user" => $email, "user_contact" => $mob, "pay_sta" => 1))->result();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function acceptedReviews($proid)
    {
        return $result = $this->db->get_where("tbl_review", array("pro_id" => $proid, "is_accept" => 1))->result();
    }

    public function acceptedReviews2($proid)
    {
        //  print_r($proid); die;
        $result = $this->db->get_where("tbl_review", array("pro_id" => $proid, "is_accept" => 1))->result();
        //  echo $this->db->last_query(); die;
        return $result;
    }

    public function getAllOffer($userId)
    {
        $is_prime = $this->db->get_where("tbl_user_reg", ["id" => $userId])->result()[0]->is_prime;

        if ($is_prime == 1) {
            $group_name[] = 2;
            return $group_name;
        } else {
            $result = $this->db->get_where("customer_group", ["user_id" => $userId])->result();
            $group_name = [];
            foreach ($result as $gr) {
                $group_name[] = $gr->group_name;
            }
            return $unique = array_unique($group_name);
        }
    }

    public function load_property()
    {
        return $this->db->get('tbl_prop_name')->result();
    }

    public function updateuser($user, $email, $image)
    {
        if ($email != null) {
            if ($image == '') {
                $query = $this->db->update('tbl_user_reg', array('user_name' => $user['fname'], 'lastname' => $user['lname'], 'user_contact' => $user['mobile'], 'bir_day' => $user['Bday'], 'bir_month' => $user['Bmonth'], 'bir_year' => $user['Byear'], 'ann_day' => $user['Aday'], 'ann_month' => $user['Amonth'], 'ann_year' => $user['Ayear'], 'location' => $user['location'], 'bio' => $user['bio'], 'gender' => $user['gender']), array('user_email' => $email));
            } else {
                $query = $this->db->update('tbl_user_reg', array('user_name' => $user['fname'], 'lastname' => $user['lname'], 'user_contact' => $user['mobile'], 'bir_day' => $user['Bday'], 'bir_month' => $user['Bmonth'], 'bir_year' => $user['Byear'], 'ann_day' => $user['Aday'], 'ann_month' => $user['Amonth'], 'ann_year' => $user['Ayear'], 'profile_pic' => $image, 'location' => $user['location'], 'bio' => $user['bio'], 'gender' => $user['gender']), array('user_email' => $email));

            }
        } elseif ($this->session->userdata('app_id')) {
            if ($image == '') {
                $query = $this->db->update('tbl_user_reg', array('user_name' => $user['fname'], 'lastname' => $user['lname'], 'user_contact' => $user['mobile'], 'user_email' => $user['email'], 'bir_day' => $user['Bday'], 'bir_month' => $user['Bmonth'], 'bir_year' => $user['Byear'], 'ann_day' => $user['Aday'], 'ann_month' => $user['Amonth'], 'ann_year' => $user['Ayear'], 'location' => $user['location'], 'bio' => $user['bio'], 'gender' => $user['gender']), array('app_id' => $this->session->userdata('app_id')));
            } else {
                $query = $this->db->update('tbl_user_reg', array('user_name' => $user['fname'], 'lastname' => $user['lname'], 'user_contact' => $user['mobile'], 'user_email' => $user['email'], 'bir_day' => $user['Bday'], 'bir_month' => $user['Bmonth'], 'bir_year' => $user['Byear'], 'ann_day' => $user['Aday'], 'ann_month' => $user['Amonth'], 'profile_pic' => $image, 'ann_year' => $user['Ayear'], 'location' => $user['location'], 'bio' => $user['bio'], 'gender' => $user['gender']), array('app_id' => $this->session->userdata('app_id')));
            }
        }
        if (count($query) > 0) {
            $this->db->cache_delete("Myaccount", "editProfile");
            return $query;
        } else {
            return false;
        }
    }

    public function getSimilarProducts($id)
    {

        $query = $this->db->select("*, tbl_related_product.relate_pro_id as PID")->from("tbl_related_product")->join("tbl_product", "tbl_product.id = tbl_related_product.relate_pro_id")->join("tbl_product_categories", "tbl_product_categories.pro_id = tbl_product.id")->join("tbl_subcategory", "tbl_subcategory.id = tbl_product_categories.sub_id")->where("tbl_related_product.pro_id", $id)->group_by("tbl_product.id")->get()->result();

        if (count($query) > 0) {

            return $query;
        } else {
            return false;
        }
    }

    public function getProps($specif)
    {
        $spe = [];
        $query = $this->db->get_where('tbl_specification', array("skey" => $specif))->result();
        if (count($query) > 0) {
            foreach ($query as $val) {
                $spe[] = $val->value;
            }
            return $spe;
        } else {
            return false;
        }
    }

    public function get_count()
    {
        return $this->db->count_all($this->table);
    }

    // public function get_product($limit, $start, $sub_id)
    // {
    //     $this->db->limit($limit, $start);
    //    // $query = $this->db->select('*,tbl_product.id as ID')->from("tbl_product_categories")->join("tbl_product", "tbl_product_categories.pro_id = tbl_product.id")->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id')->where('pro_sta', '1')->where('tbl_product_categories.sub_id', $sub_id)->group_by('tbl_product.id')->get();
    //     $this->db->select('*,tbl_product.id as ID')->from("tbl_product_categories")->join("tbl_product", "tbl_product_categories.pro_id = tbl_product.id")->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id')->where('pro_sta', '1')->where('tbl_product_categories.sub_id', $sub_id)->group_by('tbl_product.id')->get()->result();
    //     echo $this->db->last_query();
    //     die;
    //   //  return $query->result();
    // }

    public function returnOrder($post, $img)
    {
        $orderInfo = $this->user->OrderTable($this->input->post('data')); // GET UNIQUE ORDER DETAILS    .
        $date1 = date("Y-m-d H:i:s");
        $date2 = $orderInfo->pay_date;
        $now = strtotime($date1);
        $your_date = strtotime($date2);
        $datediff = $now - $your_date;
        $diff = round($datediff / (60 * 60 * 24));
        $uid = $this->user->getUserIdByEmail();
        $userDetail = $this->user->get_profile_id($uid);
        if ($diff <= 30) {

            $this->db->insert('tbl_return', array('order_id' => $post['data'], 'return_cause' => $post['condition'], 'comment' => $post['comment'], 'images' => $img, "return_account" => isset($post["account_details"]) ? $post["account_details"] : "", 'refund' => $post['account']));

            $this->db->update('tbl_customer_order', array('order_sta' => 2), array('id' => $post['data']));
            $res = $this->db->update('tbl_order', array('order_status' => 2), array('id' => $post['data']));
        }

        if ($res) {
            // $uid = $this->getUserIdByEmail();
            if ($post['account'] == 2) {

                $orderDetails = $this->db->select('*,tbl_order.id as or_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->where('tbl_order.id ', $post['data'])->get()->result();

                if ($orderDetails[0]->total_offer != 0) {
                    $orders = $this->db->get_where('tbl_order', ['order_id' => $orderDetails[0]->order_id])->result();
                    $avg = $orderDetails[0]->total_offer / count($orders); // coupon divided equally for all order
                    $total = round($orderDetails[0]->pro_price + $avg);
                } else {
                    $total = round($orderDetails[0]->pro_price);
                }

                // 2 means wallet, will be applicable for 30 days
                //  $this->db->insert('tbl_wallet', array('user_id' => $uid, 'order_id' => $post['data'], 'wallet_amt' => $total,"is_display"=>1, 'controls' => 0));

            }
            $this->db->cache_delete_all();
            return true;
        }
        $this->db->cache_delete_all();
        return false;

    }

    public function returnOrderPrime($post, $img)
    {
        $orderInfo = $this->user->OrderTable($this->input->post('data')); // GET UNIQUE ORDER DETAILS    .
        $date1 = date("Y-m-d H:i:s");
        $date2 = $orderInfo->pay_date;
        $now = strtotime($date1);
        $your_date = strtotime($date2);
        $datediff = $now - $your_date;
        $diff = round($datediff / (60 * 60 * 24));
        $uid = $this->user->getUserIdByEmail();
        $userDetail = $this->user->get_profile_id($uid);
        if ($diff <= 90) {
            $this->db->insert('tbl_return', array('order_id' => $post['data'], 'return_cause' => $post['condition'], 'comment' => $post['comment'], 'images' => $img, 'refund' => $post['account'], "return_account" => $post["account_details"]));
            $this->db->update('tbl_customer_order', array('order_sta' => 2), array('id' => $post['data']));
            $res = $this->db->update('tbl_order', array('order_status' => 2), array('id' => $post['data']));
        }

        if ($res) {
            // $uid = $this->getUserIdByEmail();
            if ($post['account'] == 2) {
                $orderDetails = $this->db->select('*,tbl_order.id as or_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->where('tbl_order.id ', $post['data'])->get()->result();

                if ($orderDetails[0]->total_offer != 0) {
                    $orders = $this->db->get_where('tbl_order', ['order_id' => $orderDetails[0]->order_id])->result();
                    $avg = $orderDetails[0]->total_offer / count($orders); // coupon divided equally for all order
                    $total = round($orderDetails[0]->pro_price + $avg);
                    $total = round(floatval($total) - floatval($total * 20 / 100));
                } else {
                    $total = round($orderDetails[0]->pro_price);
                    $total = round(floatval($total) - floatval($total * 20 / 100));
                }
                // 2 means wallet, will be applicable for 90 days
                $this->db->insert('tbl_wallet', array('user_id' => $uid, 'order_id' => $post['data'], "is_display" => 1, 'wallet_amt' => $total, 'controls' => 0));
            }
            $this->db->cache_delete_all();
            return true;
        }
        $this->db->cache_delete_all();
        return false;

    }

    public function exchangeOrder($post, $pro_id, $qty, $updateAttr)
    {

        $this->db->insert('tbl_exchange', array('order_id' => $post['data'], 'exchange_cause' => $post['selectedSize']));
        $this->db->update('tbl_customer_order', array('order_sta' => 3), array('id' => $post['data']));
        $this->db->update('tbl_order', array('order_status' => 3), array('id' => $post['data']));

    }

    public function getreview($post)
    {
        $res = $this->get_profile($this->session->userdata("myaccount"));
        foreach ($post['rating'] as $rate) {
            $q = $this->db->insert('tbl_review', array(
                'order_id' => $post['data'], 'pro_id' => $post["hidden_id"], 'username' => $res->user_name,
                'useremail' => $res->user_email, 'review' => $post['comment'], 'rate' => $rate, 'is_accept' => 0,
            ));

        }
    }

    public function getUserCoupons()
    {
        return $this->db->get_where('tbl_offer_customer', array('user_email' => $this->session->userdata('myaccount')))->result();
    }

    public function getCouponByGroup($grp)
    {
        $qry = $this->db->get_where('tbl_offer_code', array('group_name' => $grp))->result();
        if (count($qry) > 0) {
            return $qry;
        }
    }

    public function getWalletAmt()
    {
        $uid = $this->getUserIdByEmail();
        return $this->db->order_by('id', 'DESC')->limit(1)->get_where('tbl_wallet', ['user_id' => $uid])->result();
    }

    public function getCreditWalletAmt()
    {

        $uid = $this->getUserIdByEmail();
        return $wallet = $this->db->select_sum('wallet_amt')->from('tbl_wallet')->where(["user_id" => $uid, 'controls' => 0, "is_display" => 1])->get()->result();
    }

    public function getDebitWalletAmt()
    {
        $uid = $this->getUserIdByEmail();
        return $wallet = $this->db->select_sum('wallet_amt')->from('tbl_wallet')->where(["user_id" => $uid, 'controls' => 1, "is_display" => 1])->get()->result();
    }

    public function getcouponVal($cus_id)
    {
        return $this->db->select('*,tbl_order.id as or_id,tbl_customer_order.id as cus_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_offer_code', 'tbl_customer_order.offer_id=tbl_offer_code.id')->where(array('registered_user' => $this->session->userdata('myaccount'), 'tbl_customer_order.id' => $cus_id))->get()->result();
    }

    public function load_subscription()
    {
        return $this->db->get("tbl_subscription")->result()[0];
    }

    public function verifySubscription($uid)
    {
        return $this->db->get_where('customer_group', array('user_id' => $uid, "group_name" => 2))->result(); // 2 for subscribed users.
    }

    public function userCart($id)
    {
        //return $this->db->get_where('tbl_productcart', array('user_id' => $id))->result()[0]; // 2 for subscribed users.
        return $this->db->select('*')->from("tbl_productcart")->where(array('tbl_productcart.user_id' => $id))->get()->result()[0];

    }

    public function addTocartsession($user_id, $cart_detail)
    {
        // Replace cart
        $this->db->delete('tbl_productcart', array('user_id' => $user_id));
        $this->db->insert('tbl_productcart', array('user_id' => $user_id, 'product' => $cart_detail));
    }

    public function load_newcars()
    {
        // return $this->db->select('*,tbl_product.id as ID')->from("tbl_product")->where(array('tbl_product.pro_sta' => 1))->get()->result();

        $this->db->limit(10);
        $this->db->select('*,tbl_product.id as PID');
        $this->db->from('tbl_product')->join('tbl_product_categories', 'tbl_product.id=tbl_product_categories.pro_id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id')->group_by("tbl_product.id");
        $this->db->where(["tbl_product.pro_stock >" => 0]);
        $data = $this->db->order_by("tbl_product.id", "DESC")->get()->result();
        if ($data) {
            return $data;
        }
    }

    public function trending_prod()
    {
        $this->db->limit(4);
        $this->db->select('*,tbl_product.id as PID');
        $this->db->from('tbl_product')->join('tbl_product_categories', 'tbl_product.id=tbl_product_categories.pro_id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id')->group_by("tbl_product.id");
        $this->db->where(["tbl_product.type" => 2, "tbl_product.pro_stock >" => 0]);    //
        $data = $this->db->get()->result();
        // return $this->db->limit(8)->get_where('tbl_product', array('type' => 3))->result(); // 2 for subscribed users.
        if ($data) {
            return $data;
        }
    }

    public function load_newdolls()
    {
        // return $this->db->select('*,tbl_product.id as ID')->from("tbl_product")->where(array('tbl_product.pro_sta' => 1))->get()->result();

        $this->db->limit(20);
        $this->db->select('*,tbl_product.id as PID');
        $this->db->from('tbl_product')->join('tbl_product_categories', 'tbl_product.id=tbl_product_categories.pro_id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');
        $this->db->where(["tbl_product_categories.cat_id =" => 4]);
        $data = $this->db->order_by("tbl_product.id", "DESC")->get()->result();

        if ($data) {
            return $data;
        }
    }

    public function add_to_box($key, $val)
    {
        $data = $this->db->update("tbl_order", ["add_to_box" => 1], ["id" => $key, "pro_id" => $val]);
        $this->db->cache_delete_all();
        return $data;
    }

    public function rmv_frm_box($key, $val)
    {
        $data = $this->db->update("tbl_order", ["add_to_box" => 0], ["id" => $key, "pro_id" => $val]);
        $this->db->cache_delete_all();
        return $data;
    }

    public function getLogoutUsers()
    {
        return $this->db->get_where('tbl_productcart', array('logout_time <=' => date("Y-m-d H:i:s")))->result();
        // echo $this->db->last_query();
        // die;
    }

    public function loadProductsforviewSimilar($cid, $sub_id, $id)
    {
        $this->db->limit(5);
        $this->db->select('*,tbl_product.id as PID');
        $this->db->from("tbl_product_categories");
        $this->db->join("tbl_product", "tbl_product_categories.pro_id=tbl_product.id");
        $this->db->join('tbl_categories', 'tbl_product_categories.cat_id=tbl_categories.id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id');

        $this->db->where('pro_stock>', '0')->where('pro_sta', '1')->where('tbl_product.id !=', $id)->where('tbl_product_categories.sub_id', $sub_id);

        $this->db->group_by('tbl_product.id');
        $this->db->order_by('tbl_product.id', 'desc');
        $query = $this->db->get()->result();

        return $query;

    }

    public function getCatnSubcat($id)
    {
        return $this->db->get_where('tbl_product_categories', array('pro_id' => $id))->result()[0];
    }

    public function bagRequest($data)
    {
        foreach ($data['bagChecked'] as $key => $ordId) {

            $qry = $this->db->update('tbl_customer_order', ['bag_delivery_date' => date('Y-m-d', strtotime($data['bagDate']))], ['id' => $ordId]);

        }
        if ($qry) {
            $this->db->cache_delete_all();
            return true;
        } else {
            return false;
        }

    }

    public function emptyDbcart($user)
    {
        $this->db->delete('tbl_productcart', array('user_id' => $user));
    }

    public function addinCustomergroup()
    {
        $allUsers = $this->db->get('tbl_user_reg')->result();
        foreach ($allUsers as $user) {
            $this->db->insert('customer_group', ['group_name' => 1, 'user_id' => $user->id]);
        }
    }

    public function allTrending()
    {
        $this->db->select('*,tbl_product.id as PID');
        $this->db->from('tbl_product')->join('tbl_product_categories', 'tbl_product.id=tbl_product_categories.pro_id');
        $this->db->join('tbl_subcategory', 'tbl_product_categories.sub_id=tbl_subcategory.id'); //->group_by("tbl_product.id")
        $this->db->where(["tbl_product.type" => 2]);
        $data = $this->db->get()->result();
        // return $this->db->limit(8)->get_where('tbl_product', array('type' => 3))->result(); // 2 for subscribed users.
        if ($data) {
            return $data;
        }
    }

    public function customerOrder($OID)
    {
        return $this->db->select('tbl_customer_order.registered_user as email')->from('tbl_customer_order')->join('tbl_user_reg', 'tbl_user_reg.user_email=tbl_customer_order.user_email')->where(['tbl_customer_order.id' => $OID])->get()->result();
    }

}
