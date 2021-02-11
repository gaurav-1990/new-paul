<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller
{

    public $role, $userid;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
        $this->load->helper('checkout');
        if (!$this->session->userdata('signupSession')) {
            return redirect('Admin/Loginvendor');
        } else {
            $this->role = $this->session->userdata('signupSession')['role'];
            $this->userid = $this->session->userdata('signupSession')['id'];
            $this->load->model('Admin_model', 'admin');
            $this->load->model('Vendor_model', 'vendor');
            $this->load->model('User_model', 'user');
            $this->load->helper('getinfo');
            $this->load->helper('navigation');
            $this->load->library('encryption');
        }
    }

    public function dispatchOrder()
    {
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->view('Admin/config/header', array('title' => 'Please add products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'dispatch', 'action' => ''));
        $this->load->library("pagination");
        // Initialize empty array.
        $config = array();

        // Set base_url for every links
        $config["base_url"] = base_url("Admin/Vendor/dispatchOrder");
        // Set total rows in the result set you are creating pagination for.
        $config["total_rows"] = ($this->vendor->dispatchOrderCount());
        // Number of items you intend to show per page.
        $config["per_page"] = 100;
        // Use pagination number for anchor URL.
        $config['use_page_numbers'] = true;
        //Set that how many number of pages you want to view.

        $config['num_links'] = 4;
        // Open tag for CURRENT link.
        $config['full_tag_open'] = "<ul class='pagination'>";

        $config['full_tag_close'] = "</ul>";

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        // Close tag for CURRENT link.
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $this->pagination->initialize($config);
        $results = $this->vendor->userdispatchOrder($page, $config["per_page"]);
        $categories = $this->admin->load_categories();
        $this->load->view('Admin/UserDispatchOrders', array('results' => $results, "categories" => $categories, "links" => $this->pagination->create_links()));
        $this->load->view('Admin/config/footer');
    }

    public function faildOrder()
    {
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->view('Admin/config/header', array('title' => 'Please add products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'failed', 'action' => ''));
        $this->load->library("pagination");
        // Initialize empty array.
        $config = array();

        // Set base_url for every links
        $config["base_url"] = base_url("Admin/Vendor/faildOrder");
        // Set total rows in the result set you are creating pagination for.
        $config["total_rows"] = ($this->vendor->userFailOrderByVendorCount());
        // Number of items you intend to show per page.
        $config["per_page"] = 100;
        // Use pagination number for anchor URL.
        $config['use_page_numbers'] = true;
        //Set that how many number of pages you want to view.

        $config['num_links'] = 4;
        // Open tag for CURRENT link.
        $config['full_tag_open'] = "<ul class='pagination'>";

        $config['full_tag_close'] = "</ul>";

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        // Close tag for CURRENT link.
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        // By clicking on performing NEXT pagination.
        //$config['next_link'] = 'Next';
        // By clicking on performing PREVIOUS pagination.
        //$config['prev_link'] = 'Previous';
        // To initialize "$config" array and set to pagination library.
        $this->pagination->initialize($config);

        $results = $this->vendor->userfaildOrder($page, $config["per_page"]);
        $categories = $this->admin->load_categories();
        $this->load->view('Admin/UserFaildOrders', array('results' => $results, "categories" => $categories, "links" => $this->pagination->create_links()));
        $this->load->view('Admin/config/footer');
    }

    public function userOrder()
    {
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->view('Admin/config/header', array('title' => 'Please add products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'orders', 'action' => ''));
        $this->load->library("pagination");
        // Initialize empty array.
        $config = array();

        // Set base_url for every links
        $config["base_url"] = base_url("Admin/Vendor/userOrder");
        // Set total rows in the result set you are creating pagination for.
        $config["total_rows"] = ($this->vendor->userOrderByVendorCount());
        // Number of items you intend to show per page.
        $config["per_page"] = 50;
        // Use pagination number for anchor URL.
        $config['use_page_numbers'] = true;
        //Set that how many number of pages you want to view.

        $config['num_links'] = 4;
        // Open tag for CURRENT link.
        $config['full_tag_open'] = "<ul class='pagination'>";

        $config['full_tag_close'] = "</ul>";

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        // Close tag for CURRENT link.
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        //$config['page_query_string']=true;

        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        // By clicking on performing NEXT pagination.
        //$config['next_link'] = 'Next';
        // By clicking on performing PREVIOUS pagination.
        //$config['prev_link'] = 'Previous';
        // To initialize "$config" array and set to pagination library.
        $this->pagination->initialize($config);
        $categories = $this->admin->load_categories();
        $results = $this->vendor->userOrderByVendor($page, $config["per_page"]);
        // echo "<pre>";
        // print_r($results);
        // die;

        $this->load->view('Admin/UserOrders', array('results' => $results, "categories" => $categories, "links" => $this->pagination->create_links()));
        $this->load->view('Admin/config/footer');
    }

    public function allUserCSV()
    {
        // file name
        $filename = 'users_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // get data
        $usersData = $this->vendor->gettotuser();

        // file creation
        $file = fopen('php://output', 'w');
        //$data[]='';
        $header = array('first_name', 'last_name', 'user_email', 'user_contact', 'gender', 'location');
        fputcsv($file, $header);
        foreach ($usersData as $line) {
            $arr = [$line->user_name, $line->lastname, $line->user_email, $line->user_contact, $line->gender, $line->location];
            fputcsv($file, $arr);
        }

        fclose($file);
        exit;
    }

    public function exportCSV()
    {
        // file name
        $filename = 'users_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // get data
        $usersData = $this->vendor->userOrderVendorCSV();

        // file creation
        $file = fopen('php://output', 'w');
        //$data[]='';
        $header = array('registered_user', 'user_email', 'first_name', 'last_name', 'state', 'user_address', 'user_city', 'user_pin_code', 'pay_date', 'user_contact', 'order_sta', 'pay_sta', 'pay_method', 'address_id', 'offer_id', 'total_offer', 'total_order_price', 'shipping', 'transcation_id', 'invoice_id', 'shipping_awb', 'invoice_date');
        fputcsv($file, $header);
        foreach ($usersData as $line) {
            $arr = [$line->registered_user, $line->user_email, $line->first_name, $line->last_name, $line->country, $line->state, $line->user_address, $line->user_city, $line->user_pin_code, $line->pay_date, $line->user_contact, $line->order_sta, $line->pay_sta, $line->pay_method, $line->address_id, $line->offer_id, $line->total_offer, $line->total_order_price, $line->shipping, $line->transcation_id, $line->invoice_id, $line->shipping_awb, $line->invoice_date];
            fputcsv($file, $arr);
        }

        fclose($file);
        exit;
    }

    public function ExportOrder()
    {
        ini_set('memory_limit', '-1');
        $filename = 'users_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // get data
        $catfilter = "(";
        foreach ($this->input->post("cat[]") as $key => $cat) {
            if ($key == 0) {
                $catfilter .= "tbl_product_categories.cat_id='$cat'";
            } else {
                $catfilter .= " Or  tbl_product_categories.cat_id='$cat'";
            }
        }

        $catfilter = $catfilter . ")";
        if ($this->input->post("fromDate") != "" && $this->input->post("toDate") != "") {
            $fromDate = date("Y-m-d 00:00:00", strtotime($this->input->post("fromDate")));
            $toDate = date("Y-m-d 23:59:59", strtotime($this->input->post("toDate")));

            $catfilter .= " and (tbl_customer_order.pay_date>='$fromDate' and tbl_customer_order.pay_date<='$toDate')";
        }
        if ($this->input->post("method") != "") {
            if ($this->input->post("method") != 7) {
                $pay_method = $this->input->post("method");
                $catfilter .= " and tbl_customer_order.pay_method='$pay_method'";
            } else {

                $catfilter .= " and tbl_customer_order.pay_method=3 and add_to_box=1";
            }
        }
        if ($this->input->post("pay_status") != "") {
            $pay_status = $this->input->post("pay_status");
            $catfilter .= " and tbl_customer_order.pay_sta='$pay_status'";
        }
        if ($this->input->post("status") != "") {
            $status = $this->input->post("status");
            $catfilter .= " and order_sta='$status'";
        }

        $usersData = $this->db->select("*,tbl_order.id as OID,tbl_customer_order.id as ID")->from("tbl_order")->join("tbl_customer_order", "tbl_customer_order.id=tbl_order.order_id")->join("tbl_product", "tbl_product.id=tbl_order.pro_id")->join('tbl_product_categories', 'tbl_product_categories.pro_id=tbl_product.id')->join('tbl_categories', 'tbl_categories.id=tbl_product_categories.cat_id')
            ->where($catfilter)

            ->get()->result();

        // file creation
        $file = fopen('php://output', 'w');
        //$data[]='';
        $header = array('order_id', 'sub_order_id', 'category', 'product', 'sku', 'sale_qty', 'remaining_qty', 'registered_user', 'user_email', 'first_name', 'last_name', 'state', 'user_address', 'user_city', 'user_pin_code', 'pay_date', 'user_contact', 'order_sta', 'pay_sta', 'pay_method', 'address_id', 'offer_id', 'total_offer', 'total_order_price', 'shipping', 'transcation_id', 'invoice_id', 'shipping_awb', 'invoice_date');
        fputcsv($file, $header);
        foreach ($usersData as $line) {
            $paymethod = "";
            $order_sta = "";

            if ($line->order_sta == 0) {
                $order_sta = "PENDING";

            } else if ($line->order_sta == 1) {
                $order_sta = "SHIPPED AWD No - " . $line->shipping_awb;

            } else if ($line->order_sta == 7) {
                $order_sta = "DELIVERED";

            }
            $paySta = "Success";
            if ($line->pay_sta == 0) {
                $paySta = "Failed";
            }
            if ($line->pay_method == 3 && $line->add_to_box == 1) {
                $paymethod = "AddtoBox+Wallet";
            } else {
                $paymethod = ($line->pay_method == 0 ? "COD" : ($line->pay_method == 1 ? "Online" : ($line->pay_method == 2 ? "Wallet" : ($line->pay_method == 3 ? "Wallet+Online" : ($line->pay_method == 4 ? "Paytm" : ($line->pay_method == 5 ? "Wallet+Paytm" : ($line->pay_method == 6 ? "AddtoBag+Online" : "")))))));
            }
            $arr = [$line->ID, $line->OID, $line->cat_name, $line->pro_name, $line->sku, $line->pro_qty, $line->pro_stock, $line->user_email, $line->first_name, $line->last_name, $line->country, $line->state, $line->user_address, $line->user_city, $line->user_pin_code, $line->pay_date, $line->user_contact, $order_sta, $paySta, $paymethod, $line->address_id, $line->offer_id, $line->total_offer, $line->total_order_price, $line->shipping, $line->transcation_id, $line->invoice_id, $line->shipping_awb, $line->invoice_date];
            fputcsv($file, $arr);
        }

        fclose($file);
        exit;
    }

    public function export_productCSV()
    {
        // file name
        $filename = 'product_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // get data
        $prdData = $this->vendor->productCSV();

        // file creation
        $file = fopen('php://output', 'w');
        $header = array('pro_name', 'act_price', 'dis_price', 'product_attr');
        fputcsv($file, $header);
        foreach ($prdData as $line) {
            $respose = json_decode($line->product_attr);
            foreach ($respose as $key => $res) {
                $stockSize = "";
                foreach ($res as $key2 => $attr) {
                    $stockSize .= key($attr->attribute[0]) . ":" . $attr->attribute[0]->{key($attr->attribute[0])} . "|qty:" . $attr->qty . ";";
                }
            }
            $stockQty = rtrim($stockSize, ";");
            $arr = [$line->pro_name, $line->act_price, $line->dis_price, $stockQty];
            fputcsv($file, $arr);
        }
        fclose($file);
        exit;
    }

    public function userReviews()
    {
        $this->load->view('Admin/config/header', array('title' => 'Products reviews'));
        $this->load->view('Admin/config/sidebar', array('active' => 'review', 'action' => ''));
        $results = $this->vendor->userReviews();
        $this->load->view('Admin/UserReviews', array('results' => $results));
        $this->load->view('Admin/config/footer');
    }

    public function acceptReview()
    {
        $id = $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ((int) $id > 0) {
            $this->vendor->acceptReview($id);
            $this->session->set_flashdata("msg", "<div class='alert alert-success'> Review accepted </div>");
            return redirect("Admin/Vendor/userReviews");
        } else {
            echo show_404();
        }
    }

    public function rejectReview()
    {
        $id = $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ((int) $id > 0) {
            $this->vendor->rejectReview($id);
            $this->db->cache_delete_all();
            $this->session->set_flashdata("msg", "<div class='alert alert-success'> Review Rejected </div>");
            return redirect("Admin/Vendor/userReviews");
        } else {
            echo show_404();
        }
    }

    public function addAWB()
    {
        $orderID = $this->security->xss_clean($this->input->post('orid'));
        $awb = $this->security->xss_clean($this->input->post('awb'));

        $deliverStatus = $this->security->xss_clean($this->input->post('delsta'));

        $return = $this->vendor->addAwb($orderID, $awb, $deliverStatus);
        $this->db->cache_delete_all();
    }
    public function abandon()
    {
        $this->load->view('Admin/config/header', array('title' => 'Abandon Cart'));
        $this->load->view('Admin/config/sidebar', array('active' => 'abandon', 'action' => ''));
        $abandon = $this->db->get("tbl_productcart")->result();
        $this->load->view('Admin/abandon', compact("abandon"));
        $this->load->view('Admin/config/footer');
    }

    public function BulkUpload()
    {
        $this->load->view('Admin/config/header', array('title' => 'Please add products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'BulkUpload', 'action' => ''));
        $this->load->view('Admin/getVendorInvoice');
        $this->load->view('Admin/config/footer');
    }

    public function BulkUpdate()
    {
        $this->load->view('Admin/config/header', array('title' => 'Update products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'BulkUpdate', 'action' => ''));
        $this->load->view('Admin/bulkupdate');
        $this->load->view('Admin/config/footer');
    }

    public function CrossUpload()
    {
        $this->load->view('Admin/config/header', array('title' => 'Cross & Similar Product Upload'));
        $this->load->view('Admin/config/sidebar', array('active' => 'CrossUpload', 'action' => ''));
        $this->load->view('Admin/crossProductUpload');
        $this->load->view('Admin/config/footer');
    }

    public function ColorUpload()
    {
        $this->load->view('Admin/config/header', array('title' => 'Color Upload'));
        $this->load->view('Admin/config/sidebar', array('active' => 'ColorUpload', 'action' => ''));
        $this->load->view('Admin/colorUpload');
        $this->load->view('Admin/config/footer');
    }

    public function generateVendorInvoice()
    {
        $this->load->view('Admin/config/header', array('title' => 'Please add products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'orders', 'action' => ''));
        $data = $this->admin->getVendorInfo($this->userid, $this->role);
        $this->load->view('Admin/generateVendorInvoice', array("vendors" => $data));
        $this->load->view('Admin/config/footer');
    }

    public function generatePdfInvoice()
    {

        $data = $this->vendor->vendorInvoice($this->input->post());
        $post = $this->input->post();
        if (count($data) > 0) {
            $this->load->view('Admin/vendor_invoice', array("products" => $data, "post" => $post));
        } else {
            die("No Information");
        }
    }

    public function generatedInvoice()
    {
        $fromdate = $this->input->post('year') . "-" . sprintf("%02d", $this->input->post('month')) . "-" . "01";
        $todate = $this->input->post('year') . "-" . sprintf("%02d", $this->input->post('month')) . "-" . "31";
        $data = $this->user->vendorInvoice($this->session->userdata('signupSession')['id'], $fromdate, $todate);
        $this->load->view('Admin/vendor_invoice', array('data' => $data[0], "products" => $data));
    }

    // public function Invoice()
    // {
    //     $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
    //     if ($id > 0) {
    //         $data = $this->user->allOrdersOrderId($id);

    //         $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();

    //         if (count($data) > 0) {
    //             $this->load->view('Admin/getUserInvoice', array('data' => $data, "invoice" => $data[0]->invoice_id != '' ? (string)$data[0]->invoice_id : "0000000", "invoiceBar" => $generator->getBarcode($data[0]->invoice_id != '' ? (string)$data[0]->invoice_id : "0000000", $generator::TYPE_CODE_128)));
    //         } else {
    //             die("No Information");
    //         }
    //     } else {
    //         echo show_404();
    //     }
    // }
    public function bagShipping()
    {

        $res = $this->vendor->insBagShipAmt($this->input->post());
        if ($res) {
            $this->db->cache_delete_all();
            $id = encode($this->encryption->encrypt($this->input->post('oid')));

            $data = $this->user->allCustomerOrders($this->input->post('oid'));
            $shippingAmt = $data[0]->bag_ship_amt;

            $base = base_url();
            $baseurl = base_url("bootstrap/images/shipping.png");
            $subject = "Order Shipped : Order No:- 10000 " . $data[0]->order_id;
            $message = "";
            $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'><tr><td style='text-align:center'> <img style='display:block;margin-left:auto;margin-right:auto;width:50%;'   src='$baseurl' alt='Logo'></td> </tr>";
            $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
            $message .= "<tr><td style='font-weight:bold;'><img width='50%' style='display:block;margin-left:auto;margin-right:auto;' src='{$base}bootstrap/images/shipping_status.png'></td></tr>";
            $message .= "<tr><td  style='padding:8px;'>Hi!</td></tr>";
            $message .= "<tr><td  style='padding:8px;' >Hurray! We're happy to inform that your bag of joy has been wrapped with lots of love & ready for shipping.</td></tr>";
            $message .= "<tr><td  style='padding:8px;'>Please pay shipping Amount :<b>  $shippingAmt </b> and get order in your hands .</td></tr>";
            $message .= "<tr><td ><b> Do You want to Pay Bag Shipping Amount ? Then Click below link </b> <br/><a href='{$base}Myaccount/rahman/$id'> Click here to Pay Shipping Amount </a></td></tr>";
            $message .= "<tr><td   style='padding:8px;'>Team PaulsonsOnline !</td></tr>";
            $message .= "<tr><td   style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
            $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
            $message .= "<tr><td  > <h3>Your order details</h3></td></tr>";
            $message .= "<tr><td   >Order number : 10000{$data[0]->order_id}</td></tr>";
            $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
            $message .= "<table>";
            $image = getProductImage($data[0]->pro_id);
            $image = base_url("uploads/thumbs/thumb_" . $image);
            $discount = floatval($data[0]->act_price) - floatval($data[0]->pro_price);
            $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
            $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . " <br> Qty : " . $data[0]->pro_qty . " <br> Price  : Rs {$data[0]->act_price}   <br> Discount : Rs {$discount} <br> <b>Total :  </b> Rs {$data[0]->pro_price} </td></tr>";
            $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";
            $message .= "<tr><td colspan='2'  style='border-bottom: 2px solid #0d7fe4'> &nbsp;</td></tr>";
            $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
            $mode = $data[0]->pay_method == 0 ? "COD" : ($data[0]->pay_method == 1 ? "Online" : ($data[0]->pay_method == 2 ? "Wallet" : ($data[0]->pay_method == 3 ? "Wallet+Online" : ($data[0]->pay_method == 4 ? "Paytm" : ($data[0]->pay_method == 5 ? "Wallet+Paytm" : ($data[0]->pay_method == 6 ? "AddtoBag+Online" : ""))))));
            // $message .= "<tr><td rowspan='2' style='border-right:1px solid #7a869d;'><h3>Delivery Address</h3> {$data[0]->user_address}, {$data[0]->user_city}, {$data[0]->state}, {$data[0]->user_pin_code} </td><td style='padding-left: 8px'><h3>Billing Details</h3> Package value : <b>Rs {$data[0]->pro_price}</b> <br> Shipping Charges: <b>Rs {$data[0]->shipping}</b> <br> Mode of payment : <b>{$mode}</b> </td></tr>";
            // $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
            // $message .= "<tr><td colspan='2'  style='border-bottom: 2px solid #0d7fe4'> &nbsp;</td></tr>";
            // $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
            $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
            $message .= "<table>";
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('hello@paulsonsonline.com', 'PaulsonsOnline');
            $this->email->to($data[0]->user_email);
            $this->email->bcc(array("gaurav@nibble.co.in", "hello@paulsonsonline.com"));
            $this->email->subject($subject);
            $this->email->message($message);

            $this->db->cache_delete_all();
            if ($this->email->send()) {

                $this->session->set_flashdata("msg", "<div class='alert alert-success'> Add to bag Shipping Amount sent Successfully. </div>");
            } else {
                $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Add to bag Shipping Amount mail failed. </div>");
            }
        } else {
            echo "false";
        }
        return redirect('Admin/Vendor/userOrder');

    }

    public function paymentAccept()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($id != null) {
            $res = $this->admin->changeStatus($id);
            $this->db->cache_delete_all();

            if ($res) {

                $this->onsuccessMail($id);
            }
            $this->session->set_flashdata("msg", "<div class='alert alert-success'> Payment Accepted successfully . </div>");
        } else {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'> operation failed. </div>");
        }
        return redirect('Admin/Vendor/faildOrder');

    }
    public function addToBag()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($id > 0) {
            $data = $this->user->allOrdersOrderId($id);

            $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();

            if (count($data) > 0) {
                $this->load->view('Admin/orderedList', array('data' => $data, "invoice" => $data[0]->invoice_id != '' ? (string) $data[0]->invoice_id : "0000000", "invoiceBar" => $generator->getBarcode($data[0]->invoice_id != '' ? (string) $data[0]->invoice_id : "0000000", $generator::TYPE_CODE_128)));
            } else {
                die("No Information");
            }
        } else {
            echo show_404();
        }

    }

    public function Invoice()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));

        if ($id > 0) {
            $data = $this->user->allOrdersOrderId($id);

            $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();

            if (count($data) > 0) {
                $this->load->view('Admin/getkrzinvoice', array('data' => $data, "invoice" => $data[0]->invoice_id != '' ? (string) $data[0]->invoice_id : "0000000", "invoiceBar" => $generator->getBarcode($data[0]->invoice_id != '' ? (string) $data[0]->invoice_id : "0000000", $generator::TYPE_CODE_128)));
            } else {
                die("No Information");
            }
        } else {
            echo show_404();
        }
    }

    public function setAwbOtherShiped()
    {
        $orderID = $this->security->xss_clean($this->input->post('orid'));
        $status = $this->security->xss_clean($this->input->post('status'));
        $awb = $this->security->xss_clean($this->input->post('awb'));
        // echo $orderID."---".$status."---".$awb;
        // die;
        $this->generateMails($orderID, $status); // deliverStatus
        $return = $this->vendor->addAwbOthershiped($orderID, $awb, $status);
        $this->db->cache_delete_all();
        if ($return) {

            $this->session->set_flashdata("msg", "<div class='alert alert-success'> AWB NO Status Updated </div>");
        } else {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'>  AWB NO Status Not Updated. </div>");
        }
    }

    public function addAWBOther()
    {
        $orderID = $this->security->xss_clean($this->input->post('orid'));
        $where = 0;
        $deliverStatus = $this->security->xss_clean($this->input->post('delsta'));
        
        //$this->vendor->addAwbOther2($orderID, $deliverStatus);

        $this->generateMails($orderID, $deliverStatus);
        $return = $this->vendor->addAwbOther($orderID, $deliverStatus, $where); // 1 account  , 2  for wallet

        $this->db->cache_delete_all();
        if ($return) {

            $this->session->set_flashdata("msg", "<div class='alert alert-success'> Status Updated </div>");
        } else {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Status Not Updated. </div>");
        }
    }

    private function generateMails($orderID, $deliverStatus)
    {
        $res = $this->db->get_where('tbl_order',['id' => $orderID])->result()[0];

        if ($deliverStatus == 1) {  // shipped
            $this->shippingMail($res->order_id);
            $this->smsshipped($res->order_id);
        } elseif ($deliverStatus == 7) { // delivered
            $this->delivredMail($res->order_id);
            $this->smsdelivered($res->order_id);
        } elseif ($deliverStatus == 5) { // exchange Accepted
            $this->exchangeAccepted($res->order_id);
        } elseif ($deliverStatus == 4) { // Return Accepted
            $this->returnAccepted($res->order_id);
        
        } elseif ($deliverStatus == 2) { // Packed
            $this->packed($res->order_id);
            $this->smspacked($res->order_id);
        } else{}
    }

    private function smspacked($orderID)
    {
        $data = $this->db->select('*, tbl_customer_order.id as ID')->from('tbl_customer_order')->join('tbl_user_reg', 'tbl_customer_order.registered_user=tbl_user_reg.user_email')->where('tbl_customer_order.id', $orderID)->get()->result()[0];
        $mob = $data->user_contact;
        $name = $data->user_name;
        $orderno = $data->ID;
        $msg = "Hello ".$name.", Your Order with order ID 1000".$orderno." is Packed, you will notified once the order is shipped."; // 
        $message = rawurlencode($msg);
        $url = "http://alerts.teamad.in/V2/http-api.php?apikey=pGIBN1N7n6Lvr03f&senderid=PALSON&number=".$mob."&message=".$message."&format=json";
        $json = file_get_contents($url);
        print_r($json);
    }

    private function smsshipped($orderID)
    {
        $data = $this->db->select('*, tbl_customer_order.id as ID')->from('tbl_customer_order')->join('tbl_user_reg', 'tbl_customer_order.registered_user=tbl_user_reg.user_email')->where('tbl_customer_order.id', $orderID)->get()->result()[0];
        $mob = $data->user_contact;
        $name = $data->user_name;
        $orderno = $data->ID;
        $msg = "Hello ".$name.", Your Order with order ID 1000".$orderno." is Shipped, you will be notified once the order is Delivered."; // 
        $message = rawurlencode($msg);

        $url = "http://alerts.teamad.in/V2/http-api.php?apikey=pGIBN1N7n6Lvr03f&senderid=PALSON&number=".$mob."&message=".$message."&format=json";
        $json = file_get_contents($url);
        // print_r($json);
    }

    private function smsdelivered($orderID)
    {
        $data = $this->db->select('*, tbl_customer_order.id as ID')->from('tbl_customer_order')->join('tbl_user_reg', 'tbl_customer_order.registered_user=tbl_user_reg.user_email')->where('tbl_customer_order.id', $orderID)->get()->result()[0];
        $mob = $data->user_contact;
        $name = $data->user_name;
        $orderno = $data->ID;
        $msg = "Hello ".$name.", Your Order with order ID 1000".$orderno." is delivered, Thanks for choosing us."; // 
        $message = rawurlencode($msg);

        $url = "http://alerts.teamad.in/V2/http-api.php?apikey=pGIBN1N7n6Lvr03f&senderid=PALSON&number=".$mob."&message=".$message."&format=json";
        $json = file_get_contents($url);
        // print_r($json);
    }

    private function shippingMail($orderID)
    {
        $data = $this->user->allCustomerOrders2($orderID);

        $base = base_url();
        $baseurl = base_url("bootstrap/images/shipping.png");
        $subject = "Order Shipped : Order No:- 10000 " . $data[0]->order_id;
        $message = "";
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'><tr><td style='text-align:center'> <img style='display:block;margin-left:auto;margin-right:auto;width:50%;'   src='$baseurl' alt='Logo'></td> </tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold;'><img width='50%' style='display:block;margin-left:auto;margin-right:auto;' src='{$base}bootstrap/images/shipping_status.png'></td></tr>";
        $message .= "<tr><td  style='padding:8px;'>Hi!</td></tr>";
        $message .= "<tr><td  style='padding:8px;' >Hurray! We're happy to inform that your bag of joy has been wrapped with lots of love & shipped to you.</td></tr>";
        $message .= "<tr><td  style='padding:8px;'>We know you are excited to get your hands on them.</td></tr>";
        $message .= "<tr><td   style='padding:8px;'>Team PaulsonsOnline !</td></tr>";
        $message .= "<tr><td   style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td  > <h3>Your order details</h3></td></tr>";
        $message .= "<tr><td   >Order number : 10000{$data[0]->order_id}</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<table>";
        $image = getProductImage($data[0]->pro_id);
        $image = base_url("uploads/thumbs/thumb_" . $image);
        $discount = floatval($data[0]->act_price) - floatval($data[0]->pro_price);
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
        $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . " <br> Qty : " . $data[0]->pro_qty . " <br> Price  : Rs {$data[0]->act_price}   <br> Discount : Rs {$discount} <br> <b>Total :  </b> Rs {$data[0]->pro_price} </td></tr>";
        $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'  style='border-bottom: 2px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
        $mode = $data[0]->pay_method == 0 ? "COD" : ($data[0]->pay_method == 1 ? "Online" : ($data[0]->pay_method == 2 ? "Wallet" : ($data[0]->pay_method == 3 ? "Wallet+Online" : ($data[0]->pay_method == 4 ? "Paytm" : ($data[0]->pay_method == 5 ? "Wallet+Paytm" : ($data[0]->pay_method == 6 ? "AddtoBag+Online" : ""))))));
        $message .= "<tr><td rowspan='2' style='border-right:1px solid #7a869d;'><h3>Delivery Address</h3> {$data[0]->user_address}, {$data[0]->user_city}, {$data[0]->state}, {$data[0]->user_pin_code} </td><td style='padding-left: 8px'><h3>Billing Details</h3> Package value : <b>Rs {$data[0]->pro_price}</b> <br> Shipping Charges: <b>Rs {$data[0]->shipping}</b> <br> Mode of payment : <b>{$mode}</b> </td></tr>";
        $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'  style='border-bottom: 2px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";
        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('retail.paulsons@gmail.com', 'PaulsonsOnline');
        $this->email->to($data[0]->user_email);
        $this->email->bcc(array("gaurav@nibble.co.in"));
        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
    }

    private function packed($orderID)
    {
        $data = $this->user->allCustomerOrders2($orderID);
        
        $base = base_url();
        $baseurl = base_url("bootstrap/images/shipping.png");
        $subject = "Order Packed : Order No:- 10000 " . $data[0]->order_id;
        $message = "";
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'><tr><td style='text-align:center'> <img style='display:block;margin-left:auto;margin-right:auto;width:50%;'   src='$baseurl' alt='Logo'></td> </tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold;'><img width='50%' style='display:block;margin-left:auto;margin-right:auto;' src='{$base}bootstrap/images/shipping_status.png'></td></tr>";
        $message .= "<tr><td  style='padding:8px;'>Hi!</td></tr>";
        $message .= "<tr><td  style='padding:8px;' >Hurray! We're happy to inform that your bag of joy has been wrapped with lots of love &  shipped to you soon. </td></tr>";
        $message .= "<tr><td  style='padding:8px;'>We know you are excited to get your hands on them.</td></tr>";
        $message .= "<tr><td   style='padding:8px;'>Team Paulsonsonline !</td></tr>";
        $message .= "<tr><td   style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td  > <h3>Your order details</h3></td></tr>";
        $message .= "<tr><td   >Order number : 10000{$data[0]->order_id}</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<table>";
        $image = getProductImage($data[0]->pro_id);
        $image = base_url("uploads/thumbs/thumb_" . $image);
        $discount = floatval($data[0]->act_price) - floatval($data[0]->pro_price);
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
        $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . " <br> Qty : " . $data[0]->pro_qty . " <br> Price  : Rs {$data[0]->act_price}   <br> Discount : Rs {$discount} <br> <b>Total :  </b> Rs {$data[0]->pro_price} </td></tr>";
        $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'  style='border-bottom: 2px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
        $mode = $data[0]->pay_method == 0 ? "COD" : ($data[0]->pay_method == 1 ? "Online" : ($data[0]->pay_method == 2 ? "Wallet" : ($data[0]->pay_method == 3 ? "Wallet+Online" : ($data[0]->pay_method == 4 ? "Paytm" : ($data[0]->pay_method == 5 ? "Wallet+Paytm" : ($data[0]->pay_method == 6 ? "AddtoBag+Online" : ""))))));
        $message .= "<tr><td rowspan='2' style='border-right:1px solid #7a869d;'><h3>Delivery Address</h3> {$data[0]->user_address}, {$data[0]->user_city}, {$data[0]->state}, {$data[0]->user_pin_code} </td><td style='padding-left: 8px'><h3>Billing Details</h3> Package value : <b>Rs {$data[0]->pro_price}</b> <br> Shipping Charges: <b>Rs {$data[0]->shipping}</b> <br> Mode of payment : <b>{$mode}</b> </td></tr>";
        $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'  style='border-bottom: 2px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";
        
        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );
        
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('retail.paulsons@gmail.com', 'paulsonsonline ');
        $this->email->to($data[0]->user_email);
        $this->email->bcc(array("gaurav@nibble.co.in"));
        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
    }

    private function delivredMail($orderID)
    {
        $data = $this->user->allCustomerOrders2($orderID);

        $base = base_url();
        $baseurl = base_url("bootstrap/images/nauti-delivery.png");
        $subject = "Order Delivered : Order No:- 10000 " . $data[0]->order_id;
        $message = "";
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'><tr><td style='text-align:center'> <img style='display:block;margin-left:auto;margin-right:auto;width:50%;'   src='$baseurl' alt='Logo'></td> </tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold;'><img width='50%' style='display:block;margin-left:auto;margin-right:auto;' src='{$base}bootstrap/images/order_delivered.png'></td></tr>";
        $message .= "<tr><td  style='padding:8px;'>Hi {$data[0]->first_name}!</td></tr>";
        $message .= "<tr><td  style='padding:8px;' >Hope your bag of joy brought a smile to your face!</td></tr>";
        $message .= "<tr><td  style='padding:8px;'>Tell us about your experience by giving us the review.</td></tr>";
        $message .= "<tr><td   style='padding:8px;'>Team PaulsonsOnline !</td></tr>";
        $message .= "<tr><td   style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td  > <h3>Your order details</h3></td></tr>";
        $message .= "<tr><td   >Order number : 10000{$data[0]->order_id}</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<table>";
        $image = getProductImage($data[0]->pro_id);
        $image = base_url("uploads/thumbs/thumb_" . $image);
        $discount = floatval($data[0]->act_price) - floatval($data[0]->pro_price);
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
        $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . " <br> Qty : " . $data[0]->pro_qty . " <br> Price  : Rs {$data[0]->act_price}   <br> Discount : Rs {$discount} <br> <b>Total :  </b> Rs {$data[0]->pro_price} </td></tr>";
        $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'  style='border-bottom: 2px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
        $mode = $data[0]->pay_method == 0 ? "COD" : ($data[0]->pay_method == 1 ? "Online" : ($data[0]->pay_method == 2 ? "Wallet" : ($data[0]->pay_method == 3 ? "Wallet+Online" : ($data[0]->pay_method == 4 ? "Paytm" : ($data[0]->pay_method == 5 ? "Wallet+Paytm" : ($data[0]->pay_method == 6 ? "AddtoBag+Online" : ""))))));
        $message .= "<tr><td rowspan='2' style='border-right:1px solid #7a869d;'><h3>Delivery Address</h3> {$data[0]->user_address}, {$data[0]->user_city}, {$data[0]->state}, {$data[0]->user_pin_code} </td><td style='padding-left: 8px'><h3>Billing Details</h3> Package value : <b>Rs {$data[0]->pro_price}</b> <br> Shipping Charges: <b>Rs {$data[0]->shipping}</b> <br> Mode of payment : <b>{$mode}</b> </td></tr>";
        $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'  style='border-bottom: 2px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td colspan='2'> &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";
        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('retail.paulsons@gmail.com', 'PaulsonsOnline');
        $this->email->to($data[0]->user_email);
        $this->email->bcc(array("gaurav@nibble.co.in"));
        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
    }

    public function empty_cart()
    {
        $id = $this->uri->segment(4);
        $this->db->update("tbl_productcart", ["product" => null], ["id" => $id]);
        $this->session->set_flashdata("msg", "<div class='alert alert-success'> Cart emptied . </div>");
        $this->db->cache_delete_all();
        return redirect("Admin/Vendor/abandon");
    }
    private function returnAccepted($orderID)
    {

        $data = $this->user->allCustomerOrders2($orderID);
        $returnData = getReturnTable($orderID);

        $base = base_url();
        if ($returnData[0]->refund == 2) {
            if ($data[0]->total_offer != 0) {
                $orders = $this->db->get_where('tbl_order', ['order_id' => $data[0]->order_id])->result();
                $avg = $data[0]->total_offer / count($orders); // coupon divided equally for all order
                $total = round($data[0]->pro_price + $avg);
            } else {
                $total = round($data[0]->pro_price);
            }
            $this->db->insert('tbl_wallet', array('user_id' => $data[0]->user_id, 'order_id' => $data[0]->order_id, 'wallet_amt' => $total, "is_display" => 1, 'controls' => 0));
        }

        $subject = "Return Order Accepted: Order No:- 10000 " . $data[0]->order_id;
        $message = "";
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td  style='padding:8px;'>Return order number: 10000{$data[0]->order_id}</td></tr>";
        $message .= "<tr><td style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td><h3>A .Your Return item details</h3></td></tr>";
        $message .= "<tr><td >Order number : 10000{$data[0]->order_id}</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<table>";
        $image = getProductImage($data[0]->pro_id);
        $image = base_url("uploads/thumbs/thumb_" . $image);
        $discount = floatval($data[0]->act_price) - floatval($data[0]->pro_price);
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
        $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . "  </td></tr>";
        $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td    colspan='2' ><h3>B .Prepare item for pickup</h3></td></tr>";
        $message .= "<tr><td    colspan='2' ><b> Step 1:</b> Place the item in an unsealed packet.<br>
<b>Step 2(a): </b> Ensure the item is unused, unwashed and has all original tags intact including the MRP tag<br>
<b>Step 2(b):</b> If the MRP tag is not attached to the item then you may find it as a sticker on the transparent polythene cover in which your item was wrapped.  </td></tr>";
        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td    colspan='2' ><h3>C .Your Pick up address details</h3></td></tr>";
        $message .= "<tr><td   colspan='2' > {$data[0]->user_address}, {$data[0]->user_city}, {$data[0]->state}, {$data[0]->user_pin_code}  </td></tr>";
        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold; padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";

        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('retail.paulsons@gmail.com', 'PaulsonsOnline');
        $this->email->to($data[0]->user_email);
        $this->email->bcc(array("gaurav@nibble.co.in"));
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function getAttribute()
    {

        //passing property id
        $results = $this->vendor->getAttribute($this->input->post('category'));
        $option = "";
        if (count($results) > 0) {
            foreach ($results as $result) {
                $option .= "<option value='$result->id'>$result->attr_name </option>";
            }
        } else {
            $option .= "<option value=''>No Attribute </option>";
        }
        echo $option;
    }

    private function get_innerAttribute($id)
    {
        $results = $this->vendor->getAttributeJoin($id);
        $option = "";
        if (count($results) > 0) {
            foreach ($results as $result) {
                $attr = str_replace(" ", "_", $result->attr_name);
                $prop = str_replace(" ", "_", $result->pop_name);
                $option .= "<option value='" . $prop . "|" . $attr . "'>$result->attr_name </option>";
            }
        } else {
            $option .= "<option value=''>No Attribute </option>";
        }
        return $option;
    }

    public function addProperties()
    {
        $count = $this->input->post('count');
        $qty = $this->input->post("qty2");
        $selectProp = "";
        $results = $this->vendor->getProperties($this->input->post('category'), $this->input->post('subcategory'));

        $varCo = 0;
        foreach ($results as $key => $result) {
            $prop_name = str_replace(" ", "_", $result->pop_name);
            $selectProp .= <<<EOD
                 <div class="col-sm-2">
                        <label>$result->pop_name</label>
                         <select class="form-control"   name="propName{$count}[]" id="pd_prop">

                          {$this->get_innerAttribute($result->pid)}
                        </select>
                    </div>
EOD;

            $varCo++;
        }
        $htm = <<<EOD
       <div  class="panel-body ">
        <div class="row">
                    $selectProp


                     <div class="col-sm-2">
                         <label> Price Difference</label>
                          <input class="form-control" id="changePrice"  type="text" name="changePrice[]" />
                     </div>
                     <div class="col-sm-2">
                         <label>Quantity</label>
                          <input class="form-control" required id="quantity" type="text" value="$qty" name="quantity[]" />
                     </div>
                <input type="hidden" name="total[]" value="{$varCo}">
                    <div class="col-sm-2">
                         <label>&nbsp;</label><br>
                         <button onclick="deleteMe(this)" class="btn btn-xs btn-danger">delete </button>
                     </div>
            </div>
          </div>
EOD;
        echo $htm;
    }

    public function editRequestedProduct()
    {
        $actualId = $this->encryption->decrypt(decode($this->uri->segment(4)));
        if (count($this->vendor->checkProductValid($actualId))) {
            $this->load->view('Admin/config/header', array('title' => 'Edit your products'));
            $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
            $products = $this->vendor->checkProductValid($actualId);
            $images = $this->vendor->loadMoreImages($actualId);
            $this->load->library('ckeditor');
            $ck = $this->ckeditor->loadCk(true, 'pro_desc');
            $categories = $this->admin->load_categories();
            $this->load->view('Admin/editProducs_request', array('products' => $products[0], 'categories' => $categories, 'ckeditor' => $ck, 'images' => $images));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function editConfirmedProduct()
    {
        $actualId = $this->encryption->decrypt(decode($this->uri->segment(4)));

        if (count($this->vendor->checkProductValid($actualId))) {
            $this->load->view('Admin/config/header', array('title' => 'Edit your products'));
            $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
            $products = $this->vendor->checkProductValid($actualId);
            $images = $this->vendor->loadMoreImages($actualId);
            $this->load->library('ckeditor');
            $ck = $this->ckeditor->loadCk(true, 'pro_desc');
            $size = $this->ckeditor->loadCk(true, 'size_chart');
            $ck_short = $this->ckeditor->loadCk(true, 'sort_pro_desc');
            $categories = $this->admin->load_categories();
            $cate = $this->vendor->getProductsCategoryByProduct($actualId);

            $this->load->view('Admin/editConfirmedProduct', array('products' => $products[0], "size" => $size, "short" => $ck_short, 'categories' => $categories, 'ckeditor' => $ck, "allprocat" => $cate, 'images' => $images));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function updateVendorRequest()
    {
        $daa = $this->vendor->updateProducts($this->security->xss_clean($this->input->post()), $this->encryption->decrypt(decode($this->input->post('pro_id'))));
        if ($daa) {
            $this->session->set_flashdata('emailmsg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Record Updated Successfully, Product has been submitted for review</a></div></div>');
        } else {
            $this->session->set_flashdata('emailmsg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"> Something went wrong</a></div></div>');
        }
        return redirect('Admin/Vendor/vendor_products');
    }

    public function updateConfirmedVendorRequest()
    {

        $daa = $this->vendor->updateConfirmedProducts($this->security->xss_clean($this->input->post()), $this->encryption->decrypt(decode($this->input->post('pro_id'))));
        if ($daa) {
            $this->db->cache_delete_all();
            $this->session->set_flashdata('emailmsg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Record Updated Successfully</a></div></div>');
        } else {
            $this->session->set_flashdata('emailmsg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"> Something went wrong</a></div></div>');
        }
        // echo "<script>window.history.go(-1)</script>";
        return redirect('Admin/Vendor/vendor_products');
    }

    public function loadProperties()
    {
        $properties = $this->vendor->properties();

        echo "<option value=''>Select</option>";

        foreach ($properties as $prop) {
            echo "<option value='$prop->id'>$prop->prop_name</option>";
        }
    }

    public function loadsubProp()
    {
        $id = (int) $this->input->post('prop_id');
        $sub = $this->vendor->getSubProp($id);
        echo "<option value=''> Select</option>";
        foreach ($sub as $subpr) {
            echo "<option value=$subpr->subprop_name" . '_' . "$subpr->id>$subpr->subprop_name</option>";
        }
    }

    public function addProducts()
    {
        $this->load->view('Admin/config/header', array('title' => 'Please add products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
        $this->load->library('ckeditor');
        $ck = $this->ckeditor->loadCk(true, 'pro_desc');
        $size = $this->ckeditor->loadCk(true, 'size_chart');
        $categories = $this->admin->load_categories();
        $max_id = $this->admin->getProductMaxid()->ID;
        $ck_short = $this->ckeditor->loadCk(true, 'sort_pro_desc');
        $load_all_size = $this->admin->load_AllSize();
        $properties = $this->admin->getPropertiesName();
        $this->load->view('Admin/addProducts', array('properties' => $properties, 'load_all_size' => $load_all_size, 'categories' => $categories, "size" => $size, "short" => $ck_short, 'ckeditor' => $ck, 'unique' => $max_id));
        $this->load->view('Admin/config/footer');
    }

    public function getSizeChart()
    {
        $sub = $this->encryption->decrypt(decode($this->input->post("sub")));
        $is_chart = $this->vendor->is_chart($sub);
        echo $is_chart->is_sizeChart;
    }

    public function getSubChildCategory()
    {
        $_child = $this->encryption->decrypt(decode($this->input->post("_child")));
        $dv = $this->admin->getSubChildCategory($_child);

        $data = '';
        if ($dv != null) {
            foreach ($dv as $a) {
                $data .= "<option value='{encode($this->encryption->encrypt($a->id))}'> $a->sub_name</option>";
            }
        } else {
            $data .= "<option value=''>No Child</option>";
        }
        print_r($data);
    }

    public function addProductImages()
    {
        $prod_id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($prod_id > 0) {
            $this->load->view('Admin/config/header', array('title' => 'Please add product images'));
            $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts', 'prod_id' => $prod_id));
            $detail = $this->vendor->getProduct($prod_id);
            $this->load->view('Admin/addProductImage', array('hidden' => $this->uri->segment(4), 'isBrand' => $detail));
            $this->load->view('Admin/config/footer');
            $this->db->cache_delete('Admin', 'SadminLogin');
            $this->db->cache_delete('Admin', 'Vendor');
        } else {
            echo show_404();
        }
    }

    public function getShippingCity()
    {
        $this->load->helper('destination');
        echo getCityWhere($this->input->post('name'));
    }

    public function getCityPin()
    {
        $city = $this->input->post('name');
        $url = "http://postalpincode.in/api/postoffice/$city";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $server_output = curl_exec($ch);

        curl_close($ch);
        $response = json_decode($server_output);
        $html = "";
        if (isset($response->PostOffice)) {
            foreach ($response->PostOffice as $post) {
                $html .= <<<EOD
        <tr>
          <td><input type="checkbox" checked name="pin[]" value="{$post->PINCode}"> </td>
          <td>{$post->Name}</td>
          <td>{$post->PINCode}</td>
          <td>{$post->District}</td>
          <td>{$post->State}</td>
        <tr>
EOD;
            }
        } else {
            $html .= <<<EOD
        <tr>
          <td colspan="5"> No-records found </td>
        <tr>
EOD;
        }

        echo $html;
    }

    public function shipping()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<li class="list-error">', '</li>');

        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('ship_amt', 'Shipping Amount', 'required|numeric');
        $this->form_validation->set_rules('same_amt', 'Same Day Delivery Shipping Amount', 'required|numeric');
        $this->form_validation->set_rules('pin[]', 'Pin', 'required');

        if ($this->form_validation->run()) {
            if (is_array($this->input->post('pin'))) {
                $pin = array_unique($this->input->post('pin'));
            } else {
                $pin = $this->input->post('pin');
            }
            $post = $this->input->post();
            unset($post['pin']);
            $set = $this->vendor->addVendorShipping($post, $pin, $this->userid);
            if ($set) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Vendor Shipping Detail Entered Successfully</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Something Went Wrong</div>');
            }
            return redirect('Admin/Vendor/shipping');
        } else {

            $this->load->helper('destination');
            $this->load->view('Admin/config/header', array('title' => 'Add delivery area'));
            $this->load->view('Admin/config/sidebar', array('active' => 'shipping', 'action' => ''));
            $this->load->view('Admin/shpping', array('hidden' => $this->uri->segment(4)));
            $this->load->view('Admin/config/footer');
        }
    }

    public function checkPin()
    {

        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($id > 0) {
            $data = $this->vendor->loadZip($id);
            $this->load->view('Admin/config/header', array('title' => 'All Pin Codes'));
            $this->load->view('Admin/config/sidebar', array('active' => 'shipping', 'action' => ''));
            $this->load->view('Admin/AllPin', array('pin' => $data));

            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function deleteShip()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($id > 0) {
            $data = $this->vendor->deleteCity($id);
            return redirect('Admin/Vendor/ViewShipping');
        } else {
            echo show_404();
        }
    }

    public function deletePin()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($id > 0) {
            $data = $this->vendor->deletePin($id);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Deleted Succesfully</div>');
            return redirect('Admin/Vendor/ViewShipping');
        } else {
            echo show_404();
        }
    }

    public function ViewShipping()
    {
        $this->load->helper('destination');
        $this->load->view('Admin/config/header', array('title' => 'View delivery area'));
        $this->load->view('Admin/config/sidebar', array('active' => 'shipping', 'action' => ''));
        $vendor = $this->vendor->loadShip($this->userid);

        $this->load->view('Admin/viewShip', array('ship' => $vendor));

        $this->load->view('Admin/config/footer');
    }

    public function file_check_one($str)
    {
        $allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png', 'JPG', 'JPEG', 'PNG');

        $mime = explode(".", $_FILES['pro_image1']['name']);
        $mime_count = count($mime);

        if (isset($_FILES['pro_image1']['name']) && $_FILES['pro_image1']['name'] != "") {
            if (in_array($mime[$mime_count - 1], $allowed_mime_type_arr)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function file_check_two($str)
    {
        $allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

        $mime = explode(".", $_FILES['pro_image2']['name']);
        $mime_count = count($mime);

        if (isset($_FILES['pro_image2']['name']) && $_FILES['pro_image2']['name'] != "") {
            if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function file_check_three($str)
    {
        $allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

        $mime = explode(".", $_FILES['pro_image3']['name']);
        $mime_count = count($mime);

        if (isset($_FILES['pro_image3']['name']) && $_FILES['pro_image3']['name'] != "") {
            if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function file_check_four($str)
    {
        $allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

        $mime = explode(".", $_FILES['pro_image4']['name']);
        $mime_count = count($mime);

        if (isset($_FILES['pro_image4']['name']) && $_FILES['pro_image4']['name'] != "") {
            if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function file_check_five($str)
    {
        $allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

        $mime = explode(".", $_FILES['pro_image5']['name']);
        $mime_count = count($mime);

        if (isset($_FILES['pro_image5']['name']) && $_FILES['pro_image5']['name'] != "") {
            if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function file_check_six($str)
    {

        $allowed_mime_type_arr = array('jpg', 'png', 'pdf', 'jpeg');
        $mime = explode(".", $_FILES['pro_image6']['name']);

        $mime_count = count($mime);
        if (isset($_FILES['pro_image6']['name']) && $_FILES['pro_image6']['name'] != "") {
            if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function file_check_seven($str)
    {

        $allowed_mime_type_arr = array('jpg', 'png', 'pdf', 'jpeg');
        $mime = explode(".", $_FILES['pro_image7']['name']);
        $mime_count = count($mime);

        if (isset($_FILES['pro_image7']['name']) && $_FILES['pro_image7']['name'] != "") {
            if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadImages()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('pro_image1', '', 'callback_file_check_one');
        $this->form_validation->set_rules('pro_image2', '', 'callback_file_check_two');
        $config['upload_path'] = 'uploads/original/';
        $config['allowed_types'] = '*'; //'jpg|png|pdf|jpeg|JPG|JPEG|gif';
        $config['encrypt_name'] = true;
        $productId = $this->encryption->decrypt(decode($this->security->xss_clean($this->input->post('pro'))));
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == true) {

            $this->vendor->removeProImage($productId);
            if ($this->upload->do_upload('pro_image1')) {
                $uploadData = $this->upload->data();
                $uploadedFile = $uploadData['file_name'];

                $this->resize($uploadedFile);
                $this->thumbnail($uploadedFile);

                $this->vendor->addMoreImages($uploadedFile, $productId);

                $this->session->set_flashdata('pro1_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image One Uploaded Succesfully</a></div></div>');
            } else {
                $this->session->set_flashdata('pro1_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Product Image One Can not be uploaded </strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
                return redirect('Admin/Vendor/addProductImages/' . $this->input->post('pro'));
            }
            if ($this->upload->do_upload('pro_image2')) {
                $uploadData = $this->upload->data();
                $uploadedFile = $uploadData['file_name'];
                $this->resize($uploadedFile);
                $this->thumbnail($uploadedFile);

                $this->vendor->addMoreImages($uploadedFile, $productId);

                $this->session->set_flashdata('pro2_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image two Uploaded Succesfully</a></div></div>');
            } else {
                $this->session->set_flashdata('pro2_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! Product Image Two Can not be uploaded  </strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
                return redirect('Admin/Vendor/addProductImages/' . $this->input->post('pro'));
            }

            if ($_FILES['pro_image3']['tmp_name'] != null) {
                if ($this->upload->do_upload('pro_image3')) {
                    $uploadData = $this->upload->data();
                    $uploadedFile = $uploadData['file_name'];
                    $this->resize($uploadedFile);
                    $this->thumbnail($uploadedFile);

                    $this->vendor->addMoreImages($uploadedFile, $productId);

                    $this->session->set_flashdata('pro3_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image three Uploaded Succesfully</a></div></div>');
                } else {
                    $this->session->set_flashdata('pro3_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!  Product Image Two Can not be uploaded</strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
                    return redirect('Admin/Vendor/addProductImages/' . $this->input->post('pro'));
                }
            } else {
                $this->vendor->addMoreImages("", $productId);
            }
            if ($_FILES['pro_image4']['tmp_name'] != null) {
                if ($this->upload->do_upload('pro_image4')) {
                    $uploadData = $this->upload->data();
                    $uploadedFile = $uploadData['file_name'];
                    $this->resize($uploadedFile);
                    $this->thumbnail($uploadedFile);

                    $this->vendor->addMoreImages($uploadedFile, $productId);

                    $this->session->set_flashdata('pro4_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image four Uploaded Succesfully</a></div></div>');
                } else {
                    $this->session->set_flashdata('pro4_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! Product Image four Can not be uploaded</strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
                    return redirect('Admin/Vendor/addProductImages/' . $this->input->post('pro'));
                }
            } else {
                $this->vendor->addMoreImages("", $productId);
            }
            if ($_FILES['pro_image5']['tmp_name'] != null) {
                if ($this->upload->do_upload('pro_image5')) {
                    $uploadData = $this->upload->data();
                    $uploadedFile = $uploadData['file_name'];
                    $this->resize($uploadedFile);
                    $this->thumbnail($uploadedFile);

                    $this->vendor->addMoreImages($uploadedFile, $productId);

                    $this->session->set_flashdata('pro5_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image five Uploaded Succesfully</a></div></div>');
                } else {
                    $this->session->set_flashdata('pro5_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! Product Image five Can not be uploaded </strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
                    return redirect('Admin/Vendor/addProductImages/' . $this->input->post('pro'));
                }
            } else {
                $this->vendor->addMoreImages("", $productId);
            }
            $this->db->cache_delete("Admin", "Vendor");
            $this->db->cache_delete("Dashboard", "getSearchCategory");
            $this->db->cache_delete("Dashboard", "p_");
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! Please upload valid extension file</strong>
                                 </div></div>');
            return redirect('Admin/Vendor/addProductImages/' . $this->input->post('pro'));
        }

        return redirect('Admin/Vendor/vendor_products');
    }

    public function getVendorData()
    {
        $post = [];
        $multi = [];
        $data = json_decode($this->input->post('vendor'));

        foreach ($data as $val) {
            if ($val->name == "sub_cat[]") {

                $post["sub_cat"][] = $this->security->xss_clean($val->value);
            } elseif (strpos($val->name, '[]')) {
                $multi[$val->name][] = $this->security->xss_clean($val->value);
            } else {
                $post[$val->name] = $this->security->xss_clean($val->value);
            }

            if ($val->name == 'pd_prop[]') {
                $post["pd_prop"][] = $this->security->xss_clean($val->value);
            }
        }

        $attr = [];

        if ($multi != null) {
            foreach ($multi["quantity[]"] as $qt_key => $qty) {
                $inerr = [];
                for ($i = 0; $i < $multi["total[]"][$qt_key]; $i++) {

                    $var = explode("|", $multi["propName{$qt_key}[]"][$i]);
                    $inerr[] = array("$var[0]" => $var[1]);
                }
                $attr["response"][] = array("attribute" => $inerr, "qty" => $qty, "changedPrice" => $multi["changePrice[]"][$qt_key]);
            }
        }

        $desc = $this->security->xss_clean($this->input->post('pro_desc'));
        $sizeChart = $this->input->post('sizeChart') ? $this->security->xss_clean($this->input->post('sizeChart')) : "";
        $shortdesc = $this->security->xss_clean($this->input->post('shortDes'));

        $config['upload_path'] = 'uploads/brand_doc/';
        $config['allowed_types'] = 'jpg|png';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);

        if ($attr != null) {

            $id = $this->vendor->addProduct($post, $desc, $sizeChart, $shortdesc, $this->userid, json_encode($attr));
        } else {

            $id = $this->vendor->addProduct($post, $desc, $sizeChart, $shortdesc, $this->userid, null);
        }
        $base = base_url() . 'Admin/Vendor/addProductImages/';

        if (isset($post["pd_prop"]) || $post["pd_prop"] != null) {
            $this->vendor->insertIntoTblProProp($id, $post["pd_prop"]);
        }

        $pro_id = $base . encode($this->encryption->encrypt($id));

        echo <<<EOD

	 <div class="modal_back">
		<div class="modalbox success col-sm-8 col-md-6 col-lg-5 center animate">
			<div class="icon">
				<span class="glyphicon glyphicon-ok"></span>
			</div>
			<!--/.icon-->
			<h1>Success!</h1>
			<p>Your product has been listed in our database
				<br>for verification.</p>
                        <button type="button" onclick="window.location.href='$pro_id'" class="redo btn">Upload Images</button>



	</div>
</div>
EOD;
    }

    public function getAllProp()
    {

        $category = $this->encryption->decrypt(decode($this->input->post('category')));
        $sub_category = $this->encryption->decrypt(decode($this->input->post('sub_category')));
        $rs = $this->vendor->getProductCategories($category, $sub_category);
        echo json_encode($rs);
    }

    //    public function addVendorProducts() {
    //        $this->load->library('form_validation');
    //        $this->form_validation->set_rules('pro_image', '', 'callback_file_check');
    //
    //        if ($this->form_validation->run() == true) {
    //            $config['upload_path'] = 'uploads/original/';
    //            $config['allowed_types'] = 'jpg|png';
    //            $config['encrypt_name'] = TRUE;
    //            $this->load->library('upload', $config);
    //
    //            if ($this->upload->do_upload('pro_image')) {
    //                $uploadData = $this->upload->data();
    //                $uploadedFile = $uploadData['file_name'];
    //                $this->resize($uploadedFile);
    //                $this->thumbnail($uploadedFile);
    //
    //
    //                $data = $this->security->xss_clean($this->input->post());
    //
    //                $return = $this->admin->addVendorProducts($data, $uploadedFile, $this->userid);
    //                if ($return) {
    //                    $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
    //                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    //                            <div class="alert-body">
    //                                <strong>Heads up! </strong>
    //                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
    //                } else {
    //                    $this->session->set_flashdata('insert', '<div class="alert alert-danger mb" role="alert">
    //                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    //                            <div class="alert-body">
    //                                <strong>Heads up! </strong>
    //                                This <a href="#" class="alert-link link-underline">Insertion failed</a></div></div>');
    //                }
    //                $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
    //                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    //                            <div class="alert-body">
    //                                <strong>Heads up! </strong>
    //                                This <a href="#" class="alert-link link-underline">Image has been uploaded successfully.</a></div></div>');
    //            } else {
    //                $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
    //                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    //                            <div class="alert-body">
    //                                <strong>Heads up! </strong>
    //                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
    //            }
    //
    //
    //            return redirect('Admin/Vendor/addProducts');
    //        } else {
    //            return redirect('Admin/Vendor/addProducts');
    //        }
    //    }

    private function resize($image)
    {
        $this->load->library('image_lib');
        $config['width'] = '300';
        $config['maintain_ratio'] = true;
        $config['source_image'] = './uploads/original/' . $image;
        $config['new_image'] = './uploads/resized/resized_' . $image;
        $this->image_lib->initialize($config);
        if ($this->image_lib->resize()) {
            $this->thumbnail($image);
        } else {
            echo $this->image_lib->display_errors();
        }
    }

    private function thumbnail($image)
    {
        $this->load->library('image_lib');
        $config['width'] = '100';

        $config['maintain_ratio'] = true;
        $config['maintain_ratio'] = true;
        $config['create_thumb'] = true;
        $config['source_image'] = './uploads/original/' . $image;
        $config['new_image'] = './uploads/thumbs/thumb_' . $image;
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }

    public function file_check($str)
    {
        $allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

        $mime = explode(".", $_FILES['pro_image']['name']);
        $mime_count = count($mime);

        if (isset($_FILES['pro_image']['name']) && $_FILES['pro_image']['name'] != "") {
            if (in_array($mime[$mime_count - 1], $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please select only   jpg/png file.</a></div></div>');
                return false;
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please choose a file to upload.</a></div></div>');
            return false;
        }
    }

    public function addSimilarProducts()
    {
        $this->vendor->addSimilar($this->input->post("similar"), $this->input->post("pro_id"));
        $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
             <div class="alert-body">
                 <strong>Heads up!</strong>
                   <a href="#" class="alert-link link-underline">Similar product added !</a></div></div>');
        $this->db->cache_delete("Admin", "Vendor");
        $this->db->cache_delete("Dashboard", "getSearchCategory");

        $this->db->cache_delete("Dashboard", "p_");
        return redirect("Admin/Vendor/vendor_products");
    }

    public function loadSimilarProducts()
    {

        $id = $this->input->post("id");
        $data = $this->vendor->loadProducts($id);

        $base = base_url();
        $inner = "";
        foreach ($data as $pro) {
            $count = $this->vendor->isSimilar($id, $pro->id);

            $ischecked = $count > 0 ? "checked" : "";
            $inner .= <<<EOD
            <tr>
                <td>
                <input value="$pro->id" type="checkbox" $ischecked name="similar[]">
                </td>
                <td>
                    {$pro->sku}
                </td>
                <td>{$pro->pro_name}</td>
                <td>{$pro->pro_stock}</td>
                <td>{$pro->act_price}</td>
                <td>{$pro->dis_price}</td>

            </tr>
EOD;
        }

        echo <<<EOD
            <input type="hidden" name="pro_id" value="$id">
            <table class="table table-bordered table-striped table-nowrap no-mb" id="example2">
                                    <thead>
                                        <tr>
                                            <th>Action </th>
                                            <th>SKU</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Actual Price</th>
                                            <th>Offer Price</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    $inner
                                    </tbody>
                                    </table>

                                    <script src="{$base}bootstrap/vendor/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{$base}bootstrap/vendor/datatables/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script>
$('#example2').DataTable();
</script>
EOD;
    }

    public function files_check($str)
    {
        $allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');
        $mime = explode(".", $_FILES['file']['name']);
        $mime_count = count($mime);

        if (isset($_FILES['pro_image']['name']) && $_FILES['pro_image']['name'] != "") {
            if (in_array($mime[$mime_count - 1], $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please select only jpg/png file.</a></div></div>');
                return false;
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please choose a file to upload.</a></div></div>');
            return false;
        }
    }

    public function getSub()
    {
        $id = $this->encryption->decrypt(decode($this->input->post('category')));
        $sub = $this->admin->load_subcategories($id);
        $this->db->cache_delete("Admin", "Vendor");
        $subcategories = '<option value="">Select</option>';
        if (count($sub) > 0) {
            foreach ($sub as $subc) {
                $subcategories .= '<option value="' . encode($this->encryption->encrypt($subc->id)) . '">' . $subc->sub_name . '</option>';
            }
        } else {
            $subcategories = "<option value=''>No sub-category</option>";
        }
        echo $subcategories;
    }

    public function addSpecification()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<li class="list-error">', '</li>');
        $this->form_validation->set_rules('key[]', 'Key', 'required');
        $this->form_validation->set_rules('value[]', 'Value', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/config/header', array('title' => 'Specification of products'));
            $id = $this->encryption->decrypt(decode($this->uri->segment(4)));
            $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'viewproducts'));
            $specifations = $this->vendor->loadSpecification($id);
            $this->load->view('Admin/specifications', array('data' => $specifations));
            $this->load->view('Admin/config/footer');
        } else {
            $post = $this->security->xss_clean($this->input->post());
            $this->vendor->addSpecification($post);
            $this->db->cache_delete('Admin', 'Vendor');
            $this->db->cache_delete('Admin', 'SadminLogin');
            $this->db->cache_delete('Dashboard', 'pd_');
            return redirect("Admin/Vendor/addSpecification/" . $this->uri->segment(4));
        }
    }

    public function vendor_products()
    {
        // $this->session->unset_userdata('prod_id');
        $this->load->view('Admin/config/header', array('title' => 'Your products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'viewproducts'));
        $getProduct = $this->admin->loadVendorProduct($this->userid, $this->role);
        $this->load->view('Admin/requested_pro', array('product' => $getProduct));
        $this->load->view('Admin/config/footer');
    }

    public function BundleView()
    {
        $this->load->view('Admin/config/header', array('title' => 'Your products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'viewproducts'));
        $getProduct = $this->admin->loadVendorProduct($this->userid, $this->role);
        $this->load->view('Admin/view_bundle', array('product' => $getProduct));
        $this->load->view('Admin/config/footer');
    }

    public function addBundles()
    {
        $this->load->view('Admin/config/header', array('title' => 'Please add products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
        $this->load->library('ckeditor');
        $ck = $this->ckeditor->loadCk(true, 'pro_desc');
        $categories = $this->admin->load_categories();
        $max_id = $this->admin->getProductMaxid()->ID;
        $this->load->view('Admin/addBundles', array('categories' => $categories, 'ckeditor' => $ck, 'unique' => $max_id));
        $this->load->view('Admin/config/footer');
    }

    public function deleteRequestedProduct()
    {
        $data = $this->encryption->decrypt(decode($this->uri->segment(4)));
        $dt = $this->vendor->deleteRequestedProduct($data);
        if ($dt) {
            $this->session->set_flashdata("msg", "<div class='alert alert-success'>Deleted Successfully</div>");
        } else {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Something Went Wrong</div>");
        }
        $this->db->cache_delete_all();
        return redirect("Admin/Vendor/vendor_products");
    }

    public function get_selected_prop()
    {
        $data = $this->input->post('pid');
        $msg = '';
        if ($data != null) {
            foreach ($data as $id) {
                $res = $this->admin->getSelected_attr($id);

                if ($res != null) {
                    $propertyName = ucfirst(strtolower($res[0]->pop_name));
                    $msg .= <<<EOD
                    <div class="col-sm-2">
                               <label>{$propertyName}</label>
                                <select class="form-control" name="pd_prop[]"  id="">
EOD;
                    foreach ($res as $value) {

                        $msg .= <<<EOD
                                 <option value="$value->AID">$value->attr_name</option>
EOD;
                    }
                    $msg .= <<<EOD
</select>
</div>
EOD;
                }
            }
            echo $msg;
        }
    }

    public function return_view()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'View Product View'));
            $this->load->view('Admin/config/sidebar', array('active' => '', 'action' => 'Productreview'));
            $return = $this->admin->getreturndata($this->role);
            $ordid = $this->admin->order_ids();
            $this->load->view('Admin/return_review', array('data' => $return, 'returnodr' => $ordid));
            $this->load->view('Admin/config/footer');
        }
    }

    public function exchange_view()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'View Exchange Report'));
            $this->load->view('Admin/config/sidebar', array('active' => '', 'action' => 'Product Report'));
            $exchange = $this->admin->getexchangedata($this->role);
            $exodr = $this->admin->exorder_ids();
            $this->load->view('Admin/exchange_view', array('data' => $exchange, 'exordR' => $exodr));
            $this->load->view('Admin/config/footer');
        }
    }

    public function review()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'review'));
            $this->load->view('Admin/config/sidebar', array('active' => '', 'action' => 'Product Report'));
            //$review = $this->admin->getreviewedata($this->role);
            $reviewr = $this->admin->review_ids();
            // echo "<pre>";
            // print_r($reviewr);
            // die;
            $this->load->view('Admin/review', array('reviewR' => $reviewr));
            $this->load->view('Admin/config/footer');
        }
    }

    public function acceptid()
    {
        if ($this->role == 1) {
            $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
            $c1 = $this->admin->accepteview($id);
            //  $c2 = $this->admin->not_acceptereview($id);
            if ($c1) {
                $this->db->cache_delete_all();
            }

            return redirect('Admin/vendor/review');
        }
    }

    public function search_bydate()
    {
        $dt_from = $this->security->xss_clean($this->input->get('from'));
        $dt_to = $this->security->xss_clean($this->input->get('to'));

        $date1 = date('Y-m-d', strtotime($dt_from));
        $date2 = date('Y-m-d', strtotime($dt_to));

        $res = $this->admin->getorderbyDate($date1, $date2);

        $this->load->view('Admin/config/header', array('title' => 'Reports by Date'));
        $this->load->view('Admin/config/sidebar', array('active' => '', 'action' => 'Productre Report'));
        $this->load->view('Admin/view_result', array('res' => $res));
    }

    public function cancelOrder()
    {

        $res = $this->admin->cancelOrder($this->input->post('id'), $this->input->post('msg'));
        $this->cancelOrderMail($this->input->post('id'));
        if ($res) {
            $this->session->set_flashdata("msg", "<div class='alert alert-succcess'>Order cancelled successfully .</div>");
        } else {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Something Went Wrong</div>");
        }
    }

    private function cancelOrderMail($id)
    {
        $data = $this->user->allCustomerOrders2($id);
        $cancelCo = $this->db->get_where("tbl_cancle", ['order_id' => $id])->result();
        $cancelCo = count($cancelCo) > 0 ? $cancelCo[0]->comment : "NA";
        $base = base_url();
        $baseurl = base_url("bootstrap/images/logo.png");
        $subject = "Cancellation Confirmed: Order No:- 10000 " . $data[0]->order_id;
        $message = "";
        $message .= "<table style='border-collapse:collapse;border: 1px solid #7777;width:50%;padding:8px;margin:0 auto;background:#fff'><tr><td style='text-align:center'> <img style='width:20%' src='$baseurl' alt='Logo'></td> </tr>";
        $message .= "<tr><td style='border: 1px solid #cfd2d6;padding: 8px'><h2> Cancellation Confirmed</h2> </td> </tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td  style='padding:8px;'>Cancellation confirmed for order number : <b>10000{$data[0]->order_id}</b></td></tr>";
        $message .= "<tr><td  style='padding:8px;' >Reason : <b>{$cancelCo}</b></td></tr>";
        $message .= "<tr><td  style='padding:8px;'><small><i>You cancellation request accepted, Money will be credited to your account soon,We look forward to serving you again</i></small></td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td   style='padding:8px;'><h3>A: Your cancelled item  </h3></td></tr>";
        $message .= "<table>";
        $image = getProductImage($data[0]->pro_id);
        $image = base_url("uploads/thumbs/thumb_" . $image);
        $message .= "<table style='border-collapse:collapse;width:50%;margin:0 auto;background:#fff;border: 1px solid #7777'>";
        $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU: {$data[0]->sku}</td></tr>";
        $message .= "<tr><td style='border-bottom:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'> Qty :<b>" . $data[0]->pro_qty . "</b> </td><td style='border-bottom:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'> Size: <b>" . $data[0]->order_attr . "</b></td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold;border-top:1px solid #777;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td style='border-top:1px solid #7a869d'><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";
        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('retail.paulsons@gmail.com', 'PaulsonsOnline Order');
        $this->email->to($data[0]->user_email);
        $this->email->bcc(array("gaurav@nibble.co.in"));
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function exchangeAccepted($orderID)
    {
        $data = $this->user->allCustomerOrders2($orderID);
        $exchange = $this->db->get_where("tbl_exchange", ["order_id" => $orderID])->result();

        if ($exchange[0]->exchange_cause) {
            $base = base_url();
            $isSe = $this->admin->exchnageAccepted($data[0]->order_attr, $data[0]->pro_id, $data[0]->pro_qty, $exchange[0]->exchange_cause, $orderID);

            $subject = "Exchange order request: Order No:- 10000 " . $data[0]->order_id;
            $message = "";
            $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'>";
            $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";

            $message .= "<tr><td  style='padding:8px;'>Exchange order number: 10000{$data[0]->order_id}</td></tr>";

            $message .= "<tr><td style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
            $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
            $message .= "<tr><td><h3>Your exchange item details</h3></td></tr>";
            $message .= "<tr><td >Order number : 10000{$data[0]->order_id}</td></tr>";
            $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
            $message .= "<table>";
            $image = getProductImage($data[0]->pro_id);
            $image = base_url("uploads/thumbs/thumb_" . $image);

            $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
            $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . " <br> Requested Size : " . $exchange[0]->exchange_cause . "  </td></tr>";
            $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";
            $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
            $message .= "<table>";
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('retail.paulsons@gmail.com', 'PaulsonsOnline');
            $this->email->to($data[0]->user_email);
            $this->email->bcc(array("gaurav@nibble.co.in"));
            $this->email->subject($subject);
            $this->email->message($message);
            if ($isSe) {
                $this->email->send();
            }
        }

    }

    public function exchangeCancelOrderMail($orderID, $messageEx)
    {
        $data = $this->user->allCustomerOrders2($orderID);
        $exchange = $this->db->get_where("tbl_exchange", ["order_id" => $orderID])->result();
        if ($exchange[0]->exchange_cause) {
            $base = base_url();

            $subject = "Exchange order request cancelled: Order No:- 10000 " . $data[0]->order_id;
            $message = "";
            $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'>";
            $message .= "<tr><td style='font-weight:bold'>Reason : $messageEx</td></tr>";

            $message .= "<tr><td  style='padding:8px;'>Exchange order number: 10000{$data[0]->order_id}</td></tr>";

            $message .= "<tr><td style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
            $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
            $message .= "<tr><td><h3>Your exchange item details</h3></td></tr>";
            $message .= "<tr><td >Order number : 10000{$data[0]->order_id}</td></tr>";
            $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
            $message .= "<table>";
            $image = getProductImage($data[0]->pro_id);
            $image = base_url("uploads/thumbs/thumb_" . $image);

            $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
            $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . " <br> Requested Size : " . $exchange[0]->exchange_cause . "  </td></tr>";
            $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";
            $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
            $message .= "<table>";
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('retail.paulsons@gmail.com', 'PaulsonsOnline');
            $this->email->to($data[0]->user_email);
            $this->email->bcc(array("gaurav@nibble.co.in"));
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();

        }

    }

    public function exchangeRejected()
    {

        $this->exchangeCancelOrderMail($this->input->post('id'), $this->input->post('msg'));
        $exchangeRejected = $this->admin->exchangeRejected($this->input->post('id'), $this->input->post('msg'));

        if ($exchangeRejected) {
            $this->session->set_flashdata("msg", "<div class='alert alert-succcess'>Order exchange rejected .</div>");
        } else {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Something Went Wrong</div>");
        }
        $this->db->cache_delete_all();
    }

    public function nil_products()
    {
        // $this->session->unset_userdata('prod_id');
        $this->load->view('Admin/config/header', array('title' => 'Your products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'viewproducts'));
        $getProduct = $this->admin->loadnilProducts($this->userid, $this->role);
        $this->load->view('Admin/nil_pro', array('product' => $getProduct));
        $this->load->view('Admin/config/footer');
    }

    public function disabled_products()
    {
        // $this->session->unset_userdata('prod_id');
        $this->load->view('Admin/config/header', array('title' => 'Your products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'addproducts', 'action' => 'viewproducts'));
        $getProduct = $this->admin->load_disabled($this->userid, $this->role);
        $this->load->view('Admin/disable_products', array('product' => $getProduct));
        $this->load->view('Admin/config/footer');
    }

    public function disable_prd()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->disable_prd($id);
        return redirect('Admin/Vendor/nil_products');
    }

    public function enable_prd()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->enable_prd($id);
        return redirect('Admin/Vendor/disabled_products');
    }

    public function enable_pfs()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->enable_pfs($id);
        return redirect('Admin/SadminLogin/viewUser');
    }

    public function disable_pfs()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->disable_pfs($id);
        return redirect('Admin/SadminLogin/viewUser');
    }

    public function enable_offer()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->enable_offer($id);
        return redirect('Admin/SadminLogin/viewOffer');
    }

    public function disable_offer()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->disable_offer($id);
        return redirect('Admin/SadminLogin/viewOffer');
    }

    private function createProductCart($order)
    {
        $cart = [];
        foreach ($order as $or) {
            $cart[] = ["product" => $or->pro_id, "qty" => $or->pro_qty, "attr" => $or->order_attr, "prop" => $or->order_prop];
        }
        return $cart;
    }
    public function onsuccessMail($order)
    {

        $msg = "";

        $user = $this->admin->getsuccessPayment_live($order);

        $orders = $this->user->allOrdersOrderId($order);
 
        $orderHtml = "";

 

        $orderCart = $this->createProductCart($orders); //addtocart Session

        $this->user->deductFromInventory($orderCart);

        foreach ($orders as $orderDetail) {
            $orderProp = json_decode($orderDetail->order_prop);
            $property = "";
            $property .= <<<EOD
            <br><span>$orderDetail->order_prop :{$orderDetail->order_attr}</span>
EOD;
            $orderPrice = round($orderDetail->pro_price);
            $orderHtml .= <<<EOD
            <tr>
                <td style='border:1px solid #c3baba;padding: 0px 3px;'>{$orderDetail->pro_name} $property </td>
                <td style='border:1px solid #c3baba;padding: 0px 3px;'>$orderDetail->sku</td>
                <td style='border:1px solid #c3baba;padding: 0px 3px;'>$orderDetail->pro_qty</td>
                <td style='border:1px solid #c3baba;padding: 0px 3px;'>INR $orderPrice</td>
            </tr>

EOD;
        }

        $offer = "";
        $shipping = "";
        $gifted = "";

        if ($user->total_offer != '0') {

            $od = round($user->total_offer);
            $offer = "<tr><td style='padding: 5px 3px;' colspan='2'> </td><td   style='padding: 5px 3px;''> Offer Price</td><td   style='padding: 5px 3px;''> INR $od </td></tr>";
        }

        if ($user->shipping != '0') {

            $sh = round($user->shipping);
            $shipping = "<tr><td style='padding: 5px 3px;' colspan='2'> </td><td   style='padding: 5px 3px;''> Shipping Charges</td><td   style='padding: 5px 3px;''> INR $sh </td></tr>";
        }
        if ($user->is_gifted != '0') {

            $sh = round($user->gift_price);
            $gifted = "<tr><td style='padding: 5px 3px;' colspan='2'> </td><td   style='padding: 5px 3px;''> Gift Charge</td><td   style='padding: 5px 3px;''> INR $sh </td></tr>";
        }

        $message = "";
        $base = base_url();
        $to_email = $user->user_email;
        $subject = "Order Confirmation : PaulsonsOnline.com";
        $message .= "<table style='border-collapse:collapse;width:80%;margin:0 auto;border:1px solid #777;padding:8px;display: inherit;'>"
        . "<tr><td colspan='4'><img src='" . $base . "bootstrap/images/logo.png' style='width:20%'></td></tr>"
        . "<tr><td colspan='4'><h3>Hello, $user->first_name</h3></td></tr>"
        . "<tr><td colspan='4'>Thank you for your order from PaulsonsOnline. Once your package ships we will send an email with a link to track your order. If you have any questions about your order please contact us at hello@paulsonsonline.com or call us at +91 97160-90101 Monday - Saturday, 11am - 6pm IST.</td></tr>"
        . "<tr><td colspan='4'>&nbsp;</td></tr>"
        . "<tr><td colspan='4'>Your order confirmation is below. Thank you again for your business.</td></tr>"
        . "<tr><td colspan='4'>&nbsp;</td></tr>"
        . "<tr><td colspan='4'><h3>Your Order <small>(KRZ#00$order) (placed on " . date('M d, Y H:i') . ")</small></h3></td></tr>"
        . "<tr><td colspan='4'>&nbsp;</td></tr>"
        . "<tr><td colspan='2' style='background:#e8e8e8;border-right:1px solid #c3baba;border-top:1px solid #c3baba;border-left:1px solid #c3baba;width:50%;padding: 5px 3px;'><b>Address Information</b></td><td style='background:#e8e8e8;border-right:1px solid #c3baba;padding: 5px 3px;border-top:1px solid #c3baba;border-left:1px solid #c3baba' colspan='2'><b>Payment Method</b></td></tr>"
        . "<tr><td colspan='2' style='border-left:1px solid #c3baba;border-right:1px solid #c3baba;padding: 0px 3px;'>" . ucfirst(strtolower($user->fname)) . "" . strtolower($user->lname) . "</td><td colspan='2' style='border-right:1px solid #c3baba;border-left:1px solid #c3baba;padding: 0px 3px;''> " . ($user->pay_method == 0 ? "Cash on delivery" : ($user->pay_method == 1 ? "Online Pay" : ($user->pay_method == 2 ? "Wallet" : $user->pay_method == 3 ? "Wallet+Online" : ($user->pay_method == 4 ? "Paytm" : ($user->pay_method == 5 ? "Wallet+Paytm" : ($user->pay_method == 6 ? "AddtoBag+Online" : "")))))) . " </td></tr>"
        . "<tr><td colspan='2' style='border-left:1px solid #c3baba;border-right:1px solid #c3baba;padding: 0px 3px;''>$user->address</td><td colspan='2' style='border-right:1px solid #c3baba;border-left:1px solid #c3baba;padding: 0px 3px;''>&nbsp;</td></tr>"
        . "<tr><td colspan='2' style='border-left:1px solid #c3baba;border-right:1px solid #c3baba;padding: 0px 3px;''>$user->locality, $user->city, $user->state, $user->pin_code</td><td colspan='2' style='border-right:1px solid #c3baba;border-left:1px solid #c3baba;padding: 0px 3px;''>&nbsp;</td></tr>"
        . "<tr><td colspan='2' style='border-left:1px solid #c3baba;border-right:1px solid #c3baba;border-bottom:1px solid #c3baba;padding: 0px 3px;''>T: $user->phone</td><td colspan='2' style='border-right:1px solid #c3baba;border-left:1px solid #c3baba;border-bottom:1px solid #c3baba;padding: 0px 3px;''>&nbsp;</td></tr>"
        . "<tr><td colspan='4'>&nbsp;</td></tr>"
        . "<tr><td colspan='2' style='background:#e8e8e8;border-right:1px solid #c3baba;border-top:1px solid #c3baba;border-left:1px solid #c3baba;width:50%;padding: 5px 3px;'><b>Shipping Information</b></td><td style='background:#e8e8e8;border-right:1px solid #c3baba;padding: 5px 3px;border-top:1px solid #c3baba;border-left:1px solid #c3baba' colspan='2'><b>Shipping Method</b></td></tr>"
        . "<tr><td colspan='2' style='border-left:1px solid #c3baba;border-right:1px solid #c3baba;padding: 0px 3px;'>" . ucfirst(strtolower($user->fname)) . "" . strtolower($user->lname) . "</td><td colspan='2' style='border-right:1px solid #c3baba;border-left:1px solid #c3baba;padding: 0px 3px;''> " . $user->type . " </td></tr>"
            . "<tr><td colspan='2' style='border-left:1px solid #c3baba;border-right:1px solid #c3baba;padding: 0px 3px;''>$user->address</td><td colspan='2' style='border-right:1px solid #c3baba;border-left:1px solid #c3baba;padding: 0px 3px;''>&nbsp;</td></tr>"
            . "<tr><td colspan='2' style='border-left:1px solid #c3baba;border-right:1px solid #c3baba;padding: 0px 3px;''>$user->locality, $user->city, $user->state, $user->pin_code</td><td colspan='2' style='border-right:1px solid #c3baba;border-left:1px solid #c3baba;padding: 0px 3px;''>&nbsp;</td></tr>"
            . "<tr><td colspan='2' style='border-left:1px solid #c3baba;border-right:1px solid #c3baba;border-bottom:1px solid #c3baba;padding: 0px 3px;''>T: $user->phone</td><td colspan='2' style='border-right:1px solid #c3baba;border-left:1px solid #c3baba;border-bottom:1px solid #c3baba;padding: 0px 3px;''>&nbsp;</td></tr>"
            . "<tr><td colspan='4'>&nbsp;</td></tr>"
            . "<tr><td   style='background:#e8e8e8;padding: 5px 3px;'><b>Item</b></td><td   style='background:#e8e8e8;padding: 5px 3px;''><b>SKU</b></td><td   style='background:#e8e8e8;padding: 5px 3px;''><b>Qty</b></td><td   style='background:#e8e8e8;padding: 5px 3px;''><b>Subtotal</b></td></tr>"
            . $orderHtml
            . $offer
            . $shipping
            . $gifted
            . "<tr><td style='padding: 5px 3px;' colspan='2'> </td><td   style='padding: 5px 3px;''> Grand Total</td><td   style='padding: 5px 3px;''> INR $user->total_order_price </td></tr>"
            . "<tr><td colspan='4'>&nbsp;</td></tr>"
            . "<tr><td colspan='4'>&nbsp;</td></tr>"
            . "<tr><td style='background:#e8e8e8;padding: 5px 3px;text-align:center' colspan='4'>Thank you again, PaulsonsOnline</td></tr>"
            . "</table>";

        if ($user) {
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('retail.paulsons@gmail.com', 'support@PaulsonsOnline');
            $this->email->to($to_email);
            $this->email->bcc(array('gaurav@nibble.co.in'));
            $this->email->subject($subject);
            $this->email->message($message);
            $result = $this->email->send();

            if ($result) {
                $msg = <<<EOD
                        <div class="text-success" >
                        Mail has been sent successfully
                            </div>
EOD;

                $this->session->set_flashdata('msg', $msg);
            }
        }
    }

}
