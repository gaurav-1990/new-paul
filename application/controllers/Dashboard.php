<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
       

        parent::__construct();
        $this->load->helper('navigation');
        //$this->load->library('encryption');
        $this->load->helper('checkout');
        $this->load->library('encryption');
        $this->load->model('User_model', 'user');
        $this->load->library("pagination");
    }

    public function getAddressList()
    {

        $data = $this->user->selectAddress($this->input->post("data"));

        echo json_encode(["form_id" => encode($this->encryption->encrypt(($data->id))), "firstname" => $data->fname, "lastname" => $data->lname, "phone" => $data->phone, "pin_code" => $data->pin_code, "address" => $data->address, "locality" => $data->locality, "city" => $data->city, "type" => $data->type, "is_default" => $data->is_default]);
    }
    //encode($this->encryption->encrypt(($data->id)))

    private function arrayExclude($array, array $excludeKeys)
    {
        foreach ($excludeKeys as $key) {
            unset($array[$key]);
        }
        return $array;
    }

    public function createUrl()
    {
        if ($this->input->post()) {
            $data = $this->input->post("selectedFilter");
            $page = $this->input->post("page");
            $term = "";
            if ($this->input->post("term") != '') {
                $term = "term=" . $this->input->post("term") . "&";
            }
            $url = explode("?", $this->input->post("url"));
            $allData = json_decode($data);

            $urlM = "";
            foreach ($allData as $key => $all) {
                $urlM .= "&$key=" . implode(":", str_replace("#", "", $all));
            }
            echo "$url[0]?{$term}page=1" . $urlM;
        } else {
            show_404();
        }
    }

    public function checkAvailability()
    {
        return $this->user->getZip($this->input->post('zipAddress'));
    }

    public function getProductList()
    {
        if ($this->input->post() != null) {
            $value = $this->security->xss_clean($this->input->post('char'));
            // $data = $this->user->getProList($value);
            $data = $this->user->getSearchProd($value);
            $inner = "";

            $base = base_url('Dashboard/pd_/');
            if (count($data) > 0) {
                foreach ($data as $pro) {
                    if ($pro->parent_sub != 0) {
                        $subName = $this->user->getSubName($pro->parent_sub);
                        $sub_url = base_url("details/" . urlencode(strtolower($pro->cat_name))) . "/" . cleanUrl($subName->sub_name) . "/" . cleanUrl($pro->sub_name) . "/" . $this->encrypt->encode($pro->ID);
                    } else {
                        $sub_url = base_url("details/" . urlencode(strtolower($pro->cat_name))) . "/" . cleanUrl($pro->sub_name) . "/" . encode($this->encryption->encrypt(($pro->ID)));  //encode($this->encryption->encrypt(($data->id)))
                    }
                    // $image = base_url('uploads/original/') . $this->user->getProductImage($pro->id);
                    // $proname = str_replace("'", "", $pro->pro_name);
                    $proname = str_replace("'", "", $pro->cat_name);

                    $inner .= <<<EOD
                 <li><a href="{$sub_url}">{$pro->cat_name}  {$pro->sub_name}</a></li>
EOD;
                }
            } else {
                //$inner .= "<li>No Product Available<li>";
            }

            echo $html = "<ul class='searchedList'>$inner</ul>";
        } else {
            show_404();
        }
    }

    public function getOtherProperty()
    {
        $key = $this->input->post("first");
        $obj = $this->input->post("value");
        $productId = $this->encryption->decrypt(decode($this->input->post("element")));
        //$this->encryption->decrypt(decode($this->uri->segment(3)));
        $result = $this->user->getProduct($productId);
        $data = json_decode($result->product_attr);
        foreach ($data->response as $response) {
        }
    }

    public function compare_objects($obj_a, $obj_b)
    {
        return $obj_a->id - $obj_b->id;
    }

    public function addToCart()
    {
        $product = $this->input->post("product");
        $product = $this->encryption->decrypt(decode($product));     //$this->encrypt->decode($product);
        $attr = $this->input->post("attr");
        $prop = $this->input->post("prop");
        $data = $this->user->getProduct($product);
        $total = $data->dis_price != "" ? $data->dis_price : $data->act_price;
        $session = [];

        // echo $product."-----".$attr."-----".$prop."<br>";
        // die;

        if ($product != 'false') {
            if ($this->session->userdata('addToCart') == null) {
                $session[] = array('product' => $product, 'qty' => 1, 'attr' => $attr, 'prop' => $prop);
                $this->session->set_userdata('addToCart', $session);
            } else {
                $session = $this->session->userdata('addToCart');
                $session[] = array('product' => $product, 'qty' => 1, 'attr' => $attr, 'prop' => $prop);
                $this->session->set_userdata('addToCart', $session);
            }
        }

        if ($this->session->userdata('myaccount')) {
            $user_session = $this->session->userdata('myaccount');
            $cart_detail = json_encode($this->session->userdata('addToCart'));
            $this->user->addTocartsession($user_session, $cart_detail);
        }

        if ($this->session->userdata('app_id')) {
            $user_session = $this->session->userdata('app_id');
            $cart_detail = json_encode($this->session->userdata('addToCart'));
            $this->user->addTocartsession($user_session, $cart_detail);
        }

        $this->session->set_userdata('cartCount', count($this->session->userdata('addToCart')));
        echo count($this->session->userdata('addToCart'));
    }

    public function Clear()
    {
        // $this->session->unset_userdata("addToCart");
        session_destroy();
    }

    public function wishlist()
    {
        $url = base_url() . "Myaccount?Step=wish&id={$this->input->post("product")}";
        
        if ($this->session->userdata("myaccount") == NULL) {
           
            // echo "<script>window.location.href='$url'</script>";
            echo json_encode(["status"=>0,"url"=>$url ]);

        } else {
            $product = $this->input->post("product");
            $product = $this->encryption->decrypt(decode($product));
            //$this->encryption->decrypt(decode($product));
            $attr = $this->input->post("attr");
            $prop = $this->input->post("prop");
            $data = $this->user->getProduct($product);
            $id = $this->user->getUserIdByEmail();

            $total = $data->dis_price != "" ? $data->dis_price : $data->act_price;
            $returnData = $this->user->insertIntoWish($product, $prop, $attr, $total, $id);
            
            // echo $returnData;
            echo json_encode(["status"=>1,"url"=>"" ]);
        }
    }

    public function Wish_list()
    {
        $url = base_url() . "Myaccount?Step=wish&id={$this->input->post("product")}";
        
        if ($this->session->userdata("myaccount") == NULL) {
           
           echo json_encode(["status"=>0,"url"=>$url ]);

        } else {
            $product = $this->input->post("product");
            $product = $this->encryption->decrypt(decode($product));
            //$this->encryption->decrypt(decode($product));
            $attr = $this->input->post("attr");
            $prop = $this->input->post("prop");
            $data = $this->user->getProduct($product);
            $id = $this->user->getUserIdByEmail();

            $total = $data->dis_price != "" ? $data->dis_price : $data->act_price;
            $returnData = $this->user->insertIntoWish($product, $prop, $attr, $total, $id);
            echo json_encode(["status"=>1,"url"=>"" ]);
           
        }
    }

    public function cartCount()
    {
        echo ($this->session->userdata('addToCart') != null) ?  $this->session->set_userdata('cartCount', count($this->session->userdata('addToCart'))) : 0;
    }

    public function searchbox()
    {
        $List = [];
        $allproducts = $this->user->load_products();
        foreach ($allproducts as $key => $prod) {

            $List[] = $prod->pro_name;
        }
        echo json_encode($List);
        //print_r($prodList);
    }

    public function successTransaction()
    {
        $this->load->view('includes/header-order', array('navbar' => loadnavigation()));
        $this->load->view('success_trans');
        $this->load->view('includes/footer2');
    }

    public function successfullCcavenue()
    {
        $this->load->view('includes/header-order', array('navbar' => loadnavigation()));
        $this->load->view('ccavenue_success');
        $this->load->view('includes/footer2');
    }
    public function failed()
    {
        $this->load->view('includes/header-order', array('navbar' => loadnavigation()));
        $this->load->view('failedPayment');
        $this->load->view('includes/footer2');
    }
    public function index()
    {
        // echo "<pre>";
        // print_r($this->session->userdata('myaccount'));
        // die;
        //  if($_SERVER['REMOTE_ADDR']=="106.212.147.33" || $_SERVER['REMOTE_ADDR']=="182.77.43.61")
        // {
           
        $content = getHomePage("home-page");
            
        $this->load->view('includes/header', array('navbar' => loadnavigation(), "title" => $content->meta_title, "keyword" => $content->meta_keyword, "desc" => $content->meta_desc));
        // $featured = $this->user->getfeaturedProdduct();
        // $newProducts = $this->user->getnewProdduct();
        // $topSeller = $this->user->getTopSeller();
        // $categories =$this->user->load_Category();

        $contentPa = str_replace("<?= base_url() ?>", base_url(), $content->page_cont);
        $newcars = $this->user->load_newcars();
        // $newdolls = $this->user->load_newdolls();
        $trending = $this->user->trending_prod();
        
        $this->load->view('home', array("cars" => $newcars, "trending" => $trending));  //, array("content" => $contentPa)
        $this->load->view('includes/footer');
        // }else{
        //     echo "<h1 style='text-align:center; color:red'>WORK IN PROGRESS</h1>";
        //     echo "<h1 style='text-align:center'>Getting ready to give you new wholesome shopping experience.</h1>";
        //     echo "<h1 style='text-align:center; color:red'>Stay Tuned</h1>";
        //     die;
        // }
    }

    public function getAttr()
    {
        $id = (int) $this->encryption->decrypt(decode($this->input->post('red')));
        //$this->encryption->decrypt(decode($product));
        $data = $this->user->getChangePrice($id);
        echo $data;
    }

    public function getProPrice()
    {
        $product = $this->encryption->decrypt(decode($this->input->post('product')));
        $price = $this->user->productPrice($product);
        echo $price;
    }

    public function getCategoryBan()
    {

        $this->load->view('includes/header', array('navbar' => loadnavigation()));  //header-profile
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(3)));
        $subcategories = $this->user->load_catDescription($id);

        if ($id === 8) {

            $this->load->view('subscriptionTamp');
        } else {
            if (count($subcategories) > 0) {
                $this->load->view('discription', array('subcat' => $subcategories));
            } else {
                $this->load->view('discription', array('subcat' => null));
            }
        }


        $this->load->view('includes/footer');
    }

    public function getPriceFilter($sub_id)
    {
        return ($this->user->getPriceFilter($sub_id));
    }

    public function getColorFilter($id)
    {

        return    $this->user->getColorFilter($id);
    }

    public function getSearchCategory()
    {
        $subscription = ''; // start subscription code below
        if ($this->session->userdata('myaccount') != NULL || $this->session->userdata('app_id') != NULL) {
            $userID = $this->user->getUserIdByEmail();
            if (@count($userID) > 0) {
                $verifySubs = $this->user->verifySubscription($userID);
                if (count($verifySubs) > 0) {
                    $subscription = $this->user->load_subscription();
                }
            } else {
                $subscription = '';
            }
        }


        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));

        $property = $this->user->load_property();

        $config = array();
        $config["base_url"] = current_url();
        //allsubcatProducts
        //$total_row = count($this->user->allsubcatProducts($id, $this->input->get()));
        $total_row = count($this->user->loadAllProductBySubCategory($id, $this->input->get()));
        // echo "<pre>";
        // print_r($total_row);
        // die;

        $config["total_rows"] = $total_row;
        $config["per_page"] = 32;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        $config['reuse_query_string'] = TRUE;
        $config["enable_query_strings"] = TRUE;
        $config["page_query_string"] = TRUE;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = '<i class="fa fa-chevron-right"></i>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        if ($this->input->get("page") && $this->input->get("page") > 1) {
            $page = ((int) $this->security->xss_clean($this->input->get("page")) - 1) * $config["per_page"];
        } else {
            $page = 0;
        }

        $str_links = $this->pagination->create_links();

        $getProducts = $this->user->loadProductBySubCategory($id, $page, $config["per_page"], $this->input->get());
        // $getProducts = $this->user->loadBySubCat($id, $page, $config["per_page"], $this->input->get());
        
        $this->load->view('includes/header', array('navbar' => loadnavigation(), 'title' => $getProducts[0]->sub_title, 'meta_desc' => $getProducts[0]->sub_meta_desc, 'keyword' => $getProducts[0]->sub_meta_key));  //header-profile
        if (count($getProducts) > 0) {
            $this->load->view('product', array('products' => $getProducts, "link" => $str_links, 'subscription' => $subscription, 'propertyName' => $property, "totalPro" => $total_row));
        } else {
            $this->load->view('discription', array('subcat' => null));
        }

        $this->load->view('includes/footer');
    }

    public function p_()
    { //   Products List

        $this->load->view('includes/header', array('navbar' => loadnavigation()));  //header-profile
        $child_sub_id = $this->encryption->decrypt(decode($this->uri->segment(5)));

        $config = array();
        $config["base_url"] = current_url();
        $total_row = count($this->user->allproducts($child_sub_id, $this->input->get()));
        $config["total_rows"] = $total_row;
        $config["per_page"] = 32;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        $config['reuse_query_string'] = TRUE;
        $config["enable_query_strings"] = TRUE;
        $config["page_query_string"] = TRUE;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = '<i class="fa fa-chevron-right"></i>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        if ($this->input->get("page") && $this->input->get("page") > 1) {
            $page = ((int) $this->security->xss_clean($this->input->get("page")) - 1) * $config["per_page"];
        } else {
            $page = 0;
        }

        $str_links = $this->pagination->create_links();

        $data = $this->user->products($child_sub_id, $page, $config["per_page"], $this->input->get());

        $subscription = ''; // start subscription code below
        if ($this->session->userdata('myaccount') != NULL || $this->session->userdata('app_id') != NULL) {
            $userID = $this->user->getUserIdByEmail();

            if (@count($userID) > 0) {
                $verifySubs = $this->user->verifySubscription($userID);

                if (count($verifySubs) > 0) {
                    $subscription = $this->user->load_subscription();
                }
            } else {
                $subscription = '';
            }
        } // end subscription code here

        $property = $this->user->load_property();

        if (count($data) > 0) {

            $this->load->view('product', array('products' => $data, "totalPro" => $total_row, "link" => $str_links, 'subscription' => $subscription, 'propertyName' => $property));
        } else {

            $this->load->view('product', array('products' => null, "totalPro" => $total_row, "link" => $str_links, 'subscription' => $subscription, 'propertyName' => $property));
        }
        $this->load->view('includes/footer');
    }

    public function isInCart()
    {
        $product = $this->encryption->decrypt(decode($this->input->post('product')));
        $attr = $this->security->xss_clean($this->input->post('attr'));
        $prop = $this->security->xss_clean($this->input->post('prop'));
        $session = $this->session->userdata('addToCart');
 
        // echo "<pre>";
        // print_r($product);echo "----";
        // print_r($attr);echo "----";
        // print_r($prop);echo "----";
        // print_r($session);echo "----";
        // die;
        $status = 2;
        if ($session != null) {
            foreach ($session as $pro) {
                if ($pro['product'] == $product && strtolower($pro['attr']) == strtolower($attr) && $pro['prop'] == $prop) {
                    echo $status = 1;
                    break;
                }
            }
        }

        echo $status;
    }

    public function pd_()
    { //   Products Details
        $review = $this->user->acceptedReviews2($this->encryption->decrypt(decode($this->uri->segment(4))));
        //  $review = NULL;

        $total = "";
        $count = 0;
        $five = 0;
        $four = 0;
        $three = 0;
        $two = 0;
        $one = 0;
        $fiveAvg = 0;
        $fourAvg = 0;
        $threeAvg = 0;
        $twoAvg = 0;
        $oneAvg = 0;
        $avg = 0;
        $user = 0;

        if ($review != null) {
            foreach ($review as $key => $rate) {
                $total = $total + $rate->rate;
                $ct = $count + count($rate->pro_id);
                $ratet = count($rate->rate);
                $count++;

                if ($rate->rate == 5) {
                    ++$five;
                }
                if ($rate->rate == 4) {
                    ++$four;
                }

                if ($rate->rate == 3) {
                    ++$three;
                }

                if ($rate->rate == 2) {
                    ++$two;
                }

                if ($rate->rate == 1) {
                    ++$one;
                }
            }
            // $totalRate = $five+$four+$three+$two+$one;
            $fiveAvg = $five * 100 / count($review);
            $fourAvg = $four * 100 / count($review);
            $threeAvg = $three * 100 / count($review);
            $twoAvg = $two * 100 / count($review);
            $oneAvg = $one * 100 / count($review);

            if ($count != 0) {
                $avg = $total / $count;
                $user = $ct;
            } else {
                $avg = 0;
                $user = 0;
            }
        }
        $data = $this->user->getOneProducts($this->encryption->decrypt(decode($this->uri->segment(4))));
        // echo "<pre>";
        // print_r($data);
        // die;
        $specification = $this->user->loadSpecification($this->encryption->decrypt(decode($this->uri->segment(4))));
        $this->load->view('includes/header', array('navbar' => loadnavigation(), 'title' => $data[0]->title,'meta_desc' => $data[0]->meta_desc, 'keyword' => $data[0]->meta_key));  //header-profile
        $this->load->view('product-detail', array('product' => $data, "review" => $review, "specification" => $specification, 'average' => $avg, 'fiveAvg' => $fiveAvg, 'fourAvg' => $fourAvg, 'threeAvg' => $threeAvg, 'twoAvg' => $twoAvg, 'oneAvg' => $oneAvg, 'user_count' => $user));
        $this->load->view('includes/footer');
    }

    public function reviewSubmit()
    {
        $pro = $this->encryption->decrypt(decode($this->input->post("pro")));

        $post = $this->security->xss_clean($this->input->post());
        $review = $this->user->submitReview($pro, $post);

        if ($review) {
            $this->session->set_flashdata("msg", "<div class='alert alert-success'> Your review has been submitted </div>");
        } else {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'> You already reviewed this product</div>");
        }
        echo "<script>window.history.go(-1);</script>";
    }

    public function similarProduct()
    {
        if ($this->input->post("id")) {
            $html = '';
            $id = $this->encryption->decrypt(decode($this->input->post("id")));
            
            $results = $this->user->getSimilarProducts($id);
            // echo "<pre>";
            // print_r($results);
            // die;
            if ($results != null) {
                foreach ($results as $simProd) {

                    $product_name = cleanUrl($simProd->pro_name);

                    if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {

                        $prod_price = 0;
                        $userID = getUserIdByEmail();
                        if (count($userID) > 0) {
                            $userDetail = $this->user->get_profile_id($userID);
                            if ($userDetail->is_prime == 1) {
                                $getSubscription = load_subscription();
                                $primeDiscount = floatval($simProd->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member
                                $prod_price = round(floatval($simProd->dis_price) - floatval($primeDiscount));
                            } else {
                                $prod_price = round($simProd->dis_price);
                            }
                        } else {
                            $prod_price = round($simProd->dis_price);
                        }
                    } else {
                        $prod_price = round($simProd->dis_price);
                    }

                    $decrease = floatval($simProd->act_price) - floatval($prod_price);
                    $percentage = round($decrease / floatval($simProd->act_price) * 100);
                    $subname = cleanUrl($simProd->sub_name);

                    $url = base_url() . "product/$subname/" . $product_name . "/" . encode($this->encryption->encrypt(($simProd->PID)));  //encode($this->encryption->encrypt(($simProd->PID)))
                    $imgUrl = base_url() . "uploads/resized/resized_" . getProductImage($simProd->PID);
                    // <span class="price-ct">Rs. $simProd->act_price</span>
                    // <span class="price-off"> ($percentage % off)</span>
                    $html .= <<<EOD
             <div class="row">
                        <div class="col-md-8" onclick="window.location.href='$url'">
                            <div class="similar-side">
                            <div class="img-set" >
                            <img src="$imgUrl" alt="$simProd->pro_name" />
                            </div>
                                <div class="cont-set">
                                    <div class="sm-hd">
                                    $simProd->pro_name
                                    </div>
                                   

                                    <span class="price-st">Rs. $prod_price </span>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
EOD;
                }

                echo $html;
            } else {
                $getCatnSubcat = $this->user->getCatnSubcat($id);
                $res = $this->user->loadProductsforviewSimilar($getCatnSubcat->cat_id, $getCatnSubcat->sub_id, $id);

                foreach ($res as $Prod) {

                    $product_name = cleanUrl($Prod->pro_name);

                    if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {

                        $prod_price = 0;
                        $userID = getUserIdByEmail();
                        if (count($userID) > 0) {
                            $userDetail = $this->user->get_profile_id($userID);
                            if ($userDetail->is_prime == 1) {
                                $getSubscription = load_subscription();
                                $primeDiscount = floatval($Prod->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member
                                $prod_price = round(floatval($Prod->dis_price) - floatval($primeDiscount));
                            } else {
                                $prod_price = round($Prod->dis_price);
                            }
                        } else {
                            $prod_price = round($Prod->dis_price);
                        }
                    } else {
                        $prod_price = round($Prod->dis_price);
                    }

                    $decrease = floatval($Prod->act_price) - floatval($prod_price);
                    $percentage = round($decrease / floatval($Prod->act_price) * 100);
                    $subname = cleanUrl($Prod->sub_name);

                    $url = base_url() . "product/$subname/" . $product_name . "/" . encode($this->encryption->encrypt(($Prod->PID)));  //encode($this->encryption->encrypt(($simProd->PID)))
                    $imgUrl = base_url() . "uploads/resized/resized_" . getProductImage($Prod->PID);

                    $html .= <<<EOD
             <div class="row">
                        <div class="col-md-8" onclick="window.location.href='$url'">
                            <div class="similar-side">
                            <div class="img-set" >
                            <img src="$imgUrl" alt="$Prod->pro_name" />
                            </div>
                                <div class="cont-set">
                                    <div class="sm-hd">
                                    $Prod->pro_name
                                    </div>
                                   

                                    <span class="price-st">Rs. $prod_price </span>
                                </div>
                            </div>

                        </div>
                    </div>
EOD;
                }
                echo $html;
            }
        }
    }


    public function similarProductMob()
    {
        if ($this->input->post("id")) {
            $html = '';
            $id = $this->encryption->decrypt(decode($this->input->post("id")));
            //$this->encryption->decrypt(decode($this->uri->segment(3)))
            $results = $this->user->getSimilarProducts($id);
            // echo "<pre>";
            // echo "vbojfdgkldfgjdfklgjdklfgj";
            // print_r($results);
            // die;
            if ($results != null) {
                foreach ($results as $simProd) {

                    $product_name = cleanUrl($simProd->pro_name);
                    $decrease = floatval($simProd->act_price) - floatval($simProd->dis_price);
                    $percentage = round($decrease / floatval($simProd->act_price) * 100);
                    $subname = cleanUrl($simProd->sub_name);
                    $actual = $simProd->act_price == $simProd->dis_price ? "" : '<span class="cut"><i class="fa fa-inr" aria-hidden="true"></i>'.$simProd->act_price.'</span>' ;
                    $percent = $simProd->act_price == $simProd->dis_price ? "" : '<span class="show-off"> ('. $percentage .' % off) </span>' ;

                    $url = base_url() . "product/$subname/" . $product_name . "/" . encode($this->encryption->encrypt(($simProd->PID)));  //encode($this->encryption->encrypt(($simProd->PID)))
                    $imgUrl = base_url() . "uploads/resized/resized_" . getProductImage($simProd->PID);

                    $html .= <<<EOD
                      
                       
                    <div class="wish-block" onclick="window.location.href='$url'">

                             <div class="img-set">
                             <img src="$imgUrl" alt="$simProd->pro_name" />
                             </div>

                        <div class="show-pro-name">
                            <h4> $simProd->pro_name </h4>
                            
                            <div class="detail-price">
                                <span class="rs"><i class="fa fa-inr" aria-hidden="true"></i> $simProd->dis_price</span>
                                $actual
                                $percent
                            </div>

                        </div>
                    </div>
                   

                        
                  
EOD;
                }

                echo $html;
            } else {
                $getCatnSubcat = $this->user->getCatnSubcat($id);
                $res = $this->user->loadProductsforviewSimilar($getCatnSubcat->cat_id, $getCatnSubcat->sub_id, $id);

                foreach ($res as $Prod) {

                    $product_name = cleanUrl($Prod->pro_name);

                    if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {

                        $prod_price = 0;
                        $userID = getUserIdByEmail();
                        if (count($userID) > 0) {
                            $userDetail = $this->user->get_profile_id($userID);
                            if ($userDetail->is_prime == 1) {
                                $getSubscription = load_subscription();
                                $primeDiscount = floatval($Prod->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member
                                $prod_price = round(floatval($Prod->dis_price) - floatval($primeDiscount));
                            } else {
                                $prod_price = round($Prod->dis_price);
                            }
                        } else {
                            $prod_price = round($Prod->dis_price);
                        }
                    } else {
                        $prod_price = round($Prod->dis_price);
                    }

                    $decrease = floatval($Prod->act_price) - floatval($prod_price);
                    $percentage = round($decrease / floatval($Prod->act_price) * 100);
                    $subname = cleanUrl($Prod->sub_name);

                    $url = base_url() . "product/$subname/" . $product_name . "/" . encode($this->encryption->encrypt(($Prod->PID)));  //encode($this->encryption->encrypt(($simProd->PID)))
                    $imgUrl = base_url() . "uploads/resized/resized_" . getProductImage($Prod->PID);

                    $html .= <<<EOD
             <div class="row">
                        <div class="col-md-8" onclick="window.location.href='$url'">
                            <div class="similar-side">
                            <div class="img-set" >
                            <img src="$imgUrl" alt="$Prod->pro_name" />
                            </div>
                                <div class="cont-set">
                                    <div class="sm-hd">
                                    $Prod->pro_name
                                    </div>
                                   

                                    <span class="price-st">Rs. $prod_price </span>
                                </div>
                            </div>

                        </div>
                    </div>
EOD;
                }
                echo $html;
            }
        }
    }

    public function getAlltrending()
    {
        $trending = $this->user->allTrending();
        foreach($trending as $trend)
        {
            $img[] = getProductImage($trend->PID);
        }
        echo json_encode(['prod' => $trending, 'img' => $img]);
    }

    public function sm() //abandon mail
    {

        if ($this->session->userdata("myaccount")) {

            $ifany = $this->db->get_where("tbl_productcart", ["user_id" => $this->session->userdata("myaccount")])->row();
            $this->db->cache_delete_all();
            if ($ifany && ($ifany->mail_sent == 0 || $ifany->mail_sent == null)) {

                $base = base_url();
                $id = $this->uri->segment(4);
                $abandon = $ifany;
                $message = $this->load->view('Admin/abandonmail', compact("abandon"), true);

                $config = array(
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1',
                );
                $subject = "Thanks for visiting Paulsons";
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('support@paulsonsonline.com', 'Paulsons');
                $this->email->to($abandon->user_id);
                $this->email->bcc(array(EMAIL_BCC));
                $this->email->subject($subject);
                $this->email->message($message);
                $this->db->cache_delete_all();
                $this->db->set("mail_sent", "1")->set("mail_time", date("Y-m-d H:i:s"))->where("user_id", $this->session->userdata("myaccount"))->update("tbl_productcart");

                $this->email->send();

            }
        }

    }

}
