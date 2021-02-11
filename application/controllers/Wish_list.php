<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wish_list extends MY_Controller
{
    public $cat = [];
    public $produ = [];
    public $offer = [];
    public $offerCat = [];
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('navigation');
        $this->load->helper('checkout');
        $this->load->library('encryption');
        $this->load->model('User_model', 'user');
        $this->load->model('Vendor_model', 'vendor');
    }

    public function index()
    {
        $this->load->view('includes/header', array('navbar' => loadnavigation()));
        if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {

            $id = $this->user->getUserIdByEmail();

            $wishProduct = $this->user->getWishList($id);

            if (count($wishProduct) > 0) {
                $this->load->view('wish', ["wish" => $wishProduct]);
            } else {
                $this->load->view('empty-wish', ["data" => $wishProduct]);
            }
        } else {
            return redirect('Myaccount');
            //$this->load->view('empty-wish');
        }
        $this->load->view('includes/footer');
    }

    public function getCoupon()
    {

        if ($this->session->userdata('myaccount') != null) {
            $userId = $this->user->getUserIdByEmail();
            $getCoupons = [];

            $userOffer = $this->user->getAllOffer($userId); // get all user groups

            foreach ($userOffer as $value) {
                $groupCoupon = $this->vendor->getCouponVia_groupName($value);   //get all coupon by group name
                if ($groupCoupon != null) {
                    $getCoupons[] = $groupCoupon;
                }
            }
            
            // getting single array of object for group coupon
            $unique = array();
            foreach ($getCoupons as $piece) {
                foreach ($piece as $pie) {
                    $unique[] = $pie;
                }
            }
            
            foreach ($unique as $coupons) {    // How many times user used this coupon
                $customer[$coupons->id] = count($this->vendor->userCoupon($coupons->id, $this->session->userdata('myaccount')));
            }
            
            $minfilterOffers = [];  // checking  min value of coupon used in offer table
            foreach ($customer as  $offerId => $od) {
                
                $min = $this->db->get_where("tbl_offer_code", ["id" => $offerId])->result();
                
                if ($min != null) {
                    if ($min[0]->offer_per_customer == 0) {  //for infinitive
                        $minfilterOffers[] = $min[0];
                    } else {
                        if ($min[0]->offer_per_customer > $od) {   //$min[0]->offer_per_customer >= $od
                            $minfilterOffers[] = $min[0];
                        }
                    }
                }
            }
            
            
            $minfilterOffers = array_filter($minfilterOffers);
           
            //step 2 : check the conditions (Product /Category/None)

            $showOffers = [];
            $today = date('Y-m-d');
            $innerhtml = "";
            $subtotal = 0;

            foreach ($this->session->userdata("addToCart") as $key => $cartItem) {
                $productdetails = getProduct($cartItem["product"]);
                $subtotal += floatval($productdetails->dis_price) * intval($cartItem["qty"]);
            }
            
            foreach ($minfilterOffers as $minof) {
                $offer_date = date('Y-m-d', strtotime($minof->offer_validity_to));
                $diff = strtotime($offer_date) - strtotime($today);
                $totalDiff = $diff / (60 * 60 * 24);  //days-count
                $dis_date = date("jS F , Y", strtotime($offer_date));
                $which_price = $minof->which_price == 1 ? "grand total" : "sub-total";

                // echo $offer_date."--".$diff."--".$totalDiff."--".$dis_date."--".$which_price."--".$minof->min_val."--".$subtotal;

                if (floatval($minof->min_val) <= floatval($subtotal)) {
                    if ($totalDiff >= 0) {  //if days i greater than 0



                        if ($minof->off_condition == 1) {
                            $category = $this->checkCondition("tbl_offer_cat", $minof->id);  // if cart category is available for offer
                            
                            foreach ($category as $o => $oc) {
                                if ($oc["offerid"][0] == $minof->id) {
                                    $min = "";
                                    if ($minof->min_val != 0) {
                                        $min = "on minimum purchase of Rs. {$minof->min_val}";
                                    }
                                    $keyval = encode($this->encryption->encrypt(($minof->id)));
                                    $type = '<i class="fa fa-inr" aria-hidden="true"></i>';

                                    if ($minof->offer_type == 1) {
                                        $type = '%';
                                    }
                                    $innerhtml .= <<<EOD
                        <a href="#">
                        <span class="code-check"> {$minof->offer_code} </span>
                        <span class="apply-check" data-offer="$keyval"> Apply Code </span>
                    </a>
                    <div class="save-upto">
                        <h4>Save   {$minof->offer_val} $type </h4>
                        <p> {$minof->offer_val} $type off $min . Expires on <strong> $dis_date (applicable only on :  $which_price)</strong></p>
                    </div>
EOD;
                                }
                            }
                            
                            // echo "<pre>";
                            // print_r($category);
                            // die;
                            
                        } elseif ($minof->off_condition == 2) {

                            $products =   $this->checkCondition("tbl_offer_product", $minof->id);  //if cart product is available for offer


                            foreach ($products as $o => $op) {
                                if ($op["offerid"][0] == $minof->id) {
                                    $min = "";
                                    if ($minof->min_val != 0) {
                                        $min = "on minimum purchase of Rs. {$minof->min_val}";
                                    }
                                    $type = '<i class="fa fa-inr" aria-hidden="true"></i>';

                                    if ($minof->offer_type == 1) {
                                        $type = '%';
                                    }
                                    $keyval = encode($this->encryption->encrypt(($minof->id)));
                                    $innerhtml .= <<<EOD
                        <a href="#">
                        <span class="code-check"> {$minof->offer_code} </span>
                        <span class="apply-check" data-offer="$keyval">Apply Code</span>
                    </a>
                    <div class="save-upto">
                        <h4>Save  {$minof->offer_val}  $type </h4>
                        <p>  {$minof->offer_val} $type off $min . Expires on <strong> $dis_date (applicable only on :  $which_price)</strong></p>
                    </div>
EOD;
                                }
                            }
                        } else {

                            $min = "";
                            $type = '<i class="fa fa-inr" aria-hidden="true"></i>';

                            if ($minof->offer_type == 1) {
                                $type = '%';
                            }
                            if ($minof->min_val != 0) {
                                $min = "on minimum purchase of Rs. {$minof->min_val}";
                            }
                            $keyval = encode($this->encryption->encrypt(($minof->id)));
                            $innerhtml .= <<<EOD
                    <a href="#">
                    <span class="code-check"> {$minof->offer_code} </span>
                    <span class="apply-check" data-offer="$keyval">Apply Code</span>
                </a>
                <div class="save-upto">
                    <h4>Save {$minof->offer_val} $type </h4>
                    <p>   {$minof->offer_val} $type off $min . Expires on <strong> $dis_date (applicable only on :  $which_price)</strong></p>
                </div>
EOD;
                        }
                    }
                }
            }



            if ($userOffer != null) {
                $html = '';
                $innerArray = 0;
                $priceView = '';
                $html .= <<<EOD
                <div class="best-coupon">
                <h3>BEST COUPON FOR YOU</h3>
                $innerhtml
                </div>

EOD;
                echo $html;
            }
        }
    }

    public function checkCondition($tbl, $id)
    {

        $catArr = [];
        $proArr = [];
        if ($tbl == "tbl_offer_cat") {
            $addToCart = $this->session->userdata("addToCart");
            foreach ($addToCart as $key => $cartItem1) {

                $proid =  $cartItem1["product"];
                $of = $this->getProductSubCategory($proid, $id);
                if ($of != null) {
                    $catArr[] = $of;
                }
            }

            $catArr = array_map("unserialize", array_unique(array_map("serialize", $catArr)));
            return $catArr;
        }

        if ($tbl == "tbl_offer_product") {
            foreach ($this->session->userdata("addToCart") as $key => $cartItem) {
                $proid =  $cartItem["product"];
                $od =  $this->getProductOffer($proid, $id);
                if ($od != null) {
                    $proArr[] = $od;
                }
            }
            $proArr = array_map("unserialize", array_unique(array_map("serialize", $proArr)));
            return $proArr;
        }
    }
    private function getProductOffer($proid, $id)
    {


        $pro = [];


        $this->produ = null;
        $allPro = $this->db->get_where("tbl_offer_product", ["offer_id" => $id, "product_id" => $proid])->result();

        foreach ($allPro as $key => $value) {
            if (in_array($value->offer_id, $this->offer) == false) {
                $this->produ["pro_id"][] =  $value->product_id;
                $this->produ["offerid"][] = $value->offer_id;
                $this->offer[] = $value->offer_id;
            }
        }
        $this->session->set_userdata("pro_offer", $this->produ);

        return $this->produ;
    }

    private function getProductSubCategory($pro, $id)
    {
        $this->cat = null;
        $allCat = $this->db->get_where("tbl_product_categories", ["pro_id" => $pro])->result();

        foreach ($allCat as $key => $value) {
            $this->cat[] = $value->sub_id;
            $this->cat[] = $value->child_id;
        }

        $data = array_values(array_filter(array_unique($this->cat)));

        $cat = [];
        $this->cat = null;
        foreach ($data as $cate) {
            $qa =  $this->db->get_where("tbl_offer_cat", ["offer_id" => $id, "sub_id" => $cate])->result();
            if (count($qa) > 0 && (in_array($id, $this->offerCat) == false)) {
                $cat["sub_id"][] = $cate;
                $cat["offerid"][] = $id;
                $this->offerCat[] = $id;
            }
            $this->cat["offers"] = $cat;
        }
        $this->session->set_userdata("cat_offer", $this->cat);

        return $this->cat["offers"];
    }

    public function couponSession()
    {
        $id = $this->encryption->decrypt(decode($this->input->post('id')));
        
        $total_price = str_replace(",", "", $this->input->post('total'));
        
        $couponId = $id;

        $getCoupon = $this->vendor->getCoupon_Via_Id($couponId);
        
        if ($getCoupon->off_condition == 1)  //category
        {
            $categories = [];
            $allOfferCategories = $this->db->get_where("tbl_offer_cat", ["offer_id" => $couponId])->result();
            
            // getting all categories
            foreach ($allOfferCategories as $category) {
                $categories[] = $category->sub_id;
            }
            
            $proCat = [];
            $qty = 0;
            foreach ($this->session->userdata("addToCart") as $cartPro) {
                $allCat = $this->db->join("tbl_product", "tbl_product.id=tbl_product_categories.pro_id")->get_where("tbl_product_categories", ["pro_id" => $cartPro["product"]])->result();//->group_by("tbl_product_categories.pro_id")
                
                foreach ($allCat as $key => $value) {
                    $proCat[] = ["subid" => $value->sub_id, "proid" => $cartPro["product"], "qty" => $cartPro["qty"], "price" => $value->dis_price];
                }
                $qty += (int) $cartPro["qty"];
            }

            $subtotal = 0.0;
            $proqty = 0;
            foreach ($proCat as $key => $cate) {
                
                if (in_array($cate["subid"], $categories)) {
                    if ($getCoupon->per_value == 1)  // it is applicable by per value
                    {
                        $subtotal += round((float) $cate["price"] * (float) $cate["qty"]);
                    } else {
                        $subtotal += round((float) $cate["price"]);
                    }
                    $proqty += (float) $cate["qty"];
                }
            }

            // die;
            
            $shipping_charge = $this->user->getShipping();

            $shippingVal = 0;

            if ($shipping_charge[0]->ship_min >= $subtotal) {
                $shippingVal = round(floatval($shipping_charge[0]->value));
            }


            if ($getCoupon->which_price == 1)  // if grandtotal
            {
                $subtotal =  $subtotal + $shippingVal;
            }
            $offerPrice = 0.0;

            if ($getCoupon->offer_type == 0)  // if fixed
            {
                if ($getCoupon->per_value == 1) {
                    $offerPrice =   (float) $getCoupon->offer_val * $proqty;
                } else {
                    $offerPrice =   (float) $getCoupon->offer_val;
                }
            } else {  //percentage
                $offerPrice =   round(($subtotal * (float) $getCoupon->offer_val / 100));
            }
            $this->session->set_userdata('coupon_Id', $id);
            $this->session->set_userdata('coupon_code', $getCoupon->offer_code);
            $this->session->set_userdata('coupon_price', $offerPrice);
        } 
        elseif ($getCoupon->off_condition == 2)  //product
        {
            $products = [];
            $allOfferCategories = $this->db->get_where("tbl_offer_product", ["offer_id" => $couponId])->result();
            // getting all categories
            foreach ($allOfferCategories as $category) {
                $products[] = $category->product_id;
            }
            $proCat = [];
            $qty = 0;
            foreach ($this->session->userdata("addToCart") as $cartPro) {
                $allCat = $this->db->get_where("tbl_product", ["id" => $cartPro["product"]])->result();
                foreach ($allCat as $key => $value) {
                    $proCat[] = ["pro_id" => $value->id, "qty" => $cartPro["qty"], "price" => $value->dis_price];
                }
                $qty += (int) $cartPro["qty"];
            }
            $subtotal = 0.0;
            $proqty = 0;
            foreach ($proCat as $key => $cate) {
                if (in_array($cate["pro_id"], $products)) {
                    if ($getCoupon->per_value == 1)  // it is applicable by per value
                    {
                        $subtotal += round((float) $cate["price"] * (float) $cate["qty"]);
                    } else {
                        $subtotal += round((float) $cate["price"]);
                    }
                    $proqty += (int)$cate["qty"];
                }
            }
            $shipping_charge = ($qty >= 1 && $qty <= 10) ? 150 : (($qty >= 11 && $qty <= 25) ? 300 : ($qty > 25 ? 450 : 0));

            if ($getCoupon->which_price == 1)  // if grandtotal
            {
                $subtotal =  $subtotal + $shipping_charge;
            }
            $offerPrice = 0.0;
            if ($getCoupon->offer_type == 0)  // if fixed
            {
                if ($getCoupon->per_value == 1) {
                    $offerPrice =   (float) $getCoupon->offer_val * $proqty;
                } else {
                    $offerPrice =   (float) $getCoupon->offer_val;
                }
            } else {  //percentage
                $offerPrice =   round(($subtotal * (float) $getCoupon->offer_val / 100));
            }
            $this->session->set_userdata('coupon_Id', $id);
            $this->session->set_userdata('coupon_code', $getCoupon->offer_code);
            $this->session->set_userdata('coupon_price', $offerPrice);
        } else {  //universal




            $proCat = [];
            $qty = 0;
            $subtotal = 0.0;

            foreach ($this->session->userdata("addToCart") as $cartPro) {
                $allCat = $this->db->get_where("tbl_product", ["id" => $cartPro["product"]])->result();
                foreach ($allCat as $key => $value) {
                    $proCat[] = ["pro_id" => $value->id, "qty" => $cartPro["qty"], "price" => $value->dis_price];
                }
                $qty += (int) $cartPro["qty"];
                if ($getCoupon->per_value == 1)  // it is applicable by per value
                {
                    $subtotal += round((float) $value->dis_price * (float) $cartPro["qty"]);
                } else {
                    $subtotal += round((float) $value->dis_price);
                }
            }

            $shipping_charge = ($qty >= 1 && $qty <= 10) ? 150 : (($qty >= 11 && $qty <= 25) ? 300 : ($qty > 25 ? 450 : 0));

            if ($getCoupon->which_price == 1)  // if grandtotal
            {
                $subtotal =  $subtotal + $shipping_charge;
            }
            $offerPrice = 0.0;
            if ($getCoupon->offer_type == 0)  // if fixed
            {
                if ($getCoupon->per_value == 1) {
                    $offerPrice =   (float) $getCoupon->offer_val * $qty;
                } else {
                    $offerPrice =   (float) $getCoupon->offer_val;
                }
            } else {  //percentage
                $offerPrice =   round(($subtotal * (float) $getCoupon->offer_val / 100));
            }
            $this->session->set_userdata('coupon_Id', $id);
            $this->session->set_userdata('coupon_code', $getCoupon->offer_code);
            $this->session->set_userdata('coupon_price', $offerPrice);
        }

        if (floatval($getCoupon->min_val) < floatval($subtotal)) { // bag total price > minimum value in offer table
            $this->session->set_userdata('coupon_Id', $id);
        } else {
            echo "0";
        }
    }

    public function removeCoupon()
    {
        $this->session->unset_userdata('coupon_Id');
        $this->session->unset_userdata("coupon_code");
        $this->session->unset_userdata("coupon_price");
    }


    public function remove()
    {
        // $id = $this->encryption->decrypt(decode($this->input->post("id")));
        // echo $id;
        // die;
        if ($this->input->post("id")) {
            $id = $this->encryption->decrypt(decode($this->input->post("id")));
            $prop = $this->encryption->decrypt(decode($this->input->post("prop")));
            $attr = $this->encryption->decrypt(decode($this->input->post("attr")));
            $this->user->removeFromWishList($id);
        }
    }
}
