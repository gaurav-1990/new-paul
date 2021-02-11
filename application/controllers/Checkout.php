<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('navigation');
        $this->load->helper('checkout');
        $this->load->library('encryption');
        $this->load->model('User_model', 'user');
        $this->load->library('Paytm');
        // $this->session->unset_userdata('addToCart');
        // require_once APPPATH.'payU/lib/openpayu.php';
        // require_once APPPATH. 'payU/examples/config.php';
        // require_once realpath(dirname(__FILE__)) . '/../../config.php';

        if ($this->session->userdata('myaccount') == null) {
            if ($this->input->get("Step") != '') {
                return redirect('Myaccount?Step=checkout');
            } else {
                return redirect('Myaccount');
            }
        }
    }

    public function setStepAddress()
    {
        if ($this->session->userdata('addToCart') == null) {
            return redirect('Checkout');
        }

        $this->session->set_userdata("step", 1);
        return redirect("Checkout/Address");
    }

    public function myAddress()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("fname", "First Name", "required|min_length[2]");
        if ($this->form_validation->run() == false) {
            $this->load->view('includes/header-profile');
            $data = $this->user->getAddresses($this->session->userdata("myaccount"));
            $this->load->view('my_address', ["address" => $data]);
            $this->load->view('includes/footer');
        } else {
            $id = $this->user->getUserIdByEmail();
            $is = $this->user->insertIntoCustomerAddress($this->security->xss_clean($this->input->post()), $id);
            $this->db->cache_delete_all();
            return redirect("Checkout/myAddress");
        }
    }

    public function mynew_address()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("fname", "First Name", "required|min_length[2]");
        if ($this->form_validation->run() == true) {
            $fname = $this->security->xss_clean($this->input->post('fname'));
            $phone = $this->security->xss_clean($this->input->post('phone'));
            $pincode = $this->security->xss_clean($this->input->post('pincode'));
            $state = $this->security->xss_clean($this->input->post('state'));
            $address = $this->security->xss_clean($this->input->post('address'));
            $locality = $this->security->xss_clean($this->input->post('locality'));

            $city = $this->security->xss_clean($this->input->post('city'));

            $address_type = $this->security->xss_clean($this->input->post('address_type'));

            $add_id = $this->user->getUserIdByEmail();

            $this->user->insertin_address($fname, $phone, $pincode, $state, $address, $locality, $city, $address_type, $add_id);
            $this->db->cache_delete_all();
            return redirect('Checkout/myAddress');
        } else {
            $this->load->view('includes/header-profile');
            $this->load->view('my_address');
            $this->load->view('includes/footer');
        }
    }

    public function razorPaySuccess()
    {
        if ($this->input->post('razorpay_payment_id') != '') {

            $id = $this->user->get_profile($this->session->userdata("myaccount"))->id;

            $query = $this->db->insert("tbl_wallet", ["is_display" => 1, "controls" => 0, "wallet_amt" => round(floatval($this->input->post("totalAmount")) / 100), "pay_id" => $this->input->post('razorpay_payment_id'), "user_id" => $id]);
            if ($query) {
                $arr = array('msg' => 'Payment successfully credited', 'status' => true);
                echo json_encode($arr);
            } else {
                $arr = array('msg' => 'Payment failed', 'status' => false);
                echo json_encode($arr);
            }
            $this->db->cache_delete("Checkout", "myWallet");
            $this->db->cache_delete("Checkout", "razorPaySuccess");
        } else {
            echo show_404();
        }
    }

    public function myWallet()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("wallet_amount", "Wallet Amount", "required|numeric");
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        $this->load->view('includes/header-profile');
        if ($this->form_validation->run() == false) {
            $getCreditWallet = $this->user->getCreditWalletAmt(); // all return products

            $getDebitWallet = $this->user->getDebitWalletAmt();

            $total = $getCreditWallet[0]->wallet_amt - $getDebitWallet[0]->wallet_amt;

            if ($total > 0) {

                $this->load->view('my_wallet', ['wallet' => $total]);
            } else {
                $this->load->view('my_wallet', ['wallet' => null]);
            }
        } else {

            if ($this->session->userdata("myaccount")) {
                $getCreditWallet = $this->user->getCreditWalletAmt(); // all return products
                $getDebitWallet = $this->user->getDebitWalletAmt();

                $total = $getCreditWallet[0]->wallet_amt - $getDebitWallet[0]->wallet_amt;

                if ($total > 0) {

                    $this->load->view('my_wallet', ['wallet' => $total]);
                } else {
                    $this->load->view('my_wallet', ['wallet' => null]);
                }

                $data = $this->user->get_profile($this->session->userdata("myaccount"));
                
                $id = rand(100000, 999999);
                $email = $data->user_email;
                $amount = floatval($this->input->post("wallet_amount"));
                $this->session->set_userdata("myWallet", $amount);
                $orderId= "PAUL_".$id."_".$data->id;
                $successUrl = base_url("GateWayResponse/WalletRecharge/".$data->id);
                $cancelUrl = base_url("GateWayResponse/WalletRecharge/".$data->id);
                
 
                $this->load->view('cashFreeWallet', array('data' => $data, 'amount' => $amount, "orderId" => $orderId, 'successUrl' => $successUrl, "cancelUrl" => $cancelUrl));

            } else {
                echo show_404();
            }
        }
        $this->load->view('includes/footer');
    }

    public function refresh()
    {
        $this->load->helper('captcha');
        $config = array(
            'word' => rand(1, 999999),
            'img_url' => base_url('assets') . '/captcha/',
            'img_path' => './assets/captcha/',
            'img_height' => 30,
            'word_length' => 5,
            'img_width' => '130',
            'font_path' => FCPATH . 'system/fonts/texb.ttf',
            'font_size' => 18,
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 75, 100),
            ),
        );
        $captcha = create_captcha($config);
        $this->session->unset_userdata('valuecaptchaCode');
        $this->session->set_userdata('valuecaptchaCode', $captcha['word']);
        echo $captcha['image'];
    }

    public function Address()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("fname", "First Name", "required|min_length[2]");
        $this->form_validation->set_rules("phone", "Contact Number", "required|numeric|min_length[10]|max_length[10]");
        $this->form_validation->set_rules("pincode", "Pin Code", "required|numeric|min_length[6]|max_length[6]");
        $this->form_validation->set_rules("address", "Address", "required|min_length[3]");
        $this->form_validation->set_rules("locality", "Locality", "required");
        $this->form_validation->set_rules("city", "City", "required");
        $this->form_validation->set_rules("state", "State", "required");

        $this->form_validation->set_rules("address_type", "Address Type", "required");
        $this->form_validation->set_error_delimiters('<li class="text-danger text-center">', '</li>');
        $this->checkInInventory();
        if ($this->session->userdata("addToCart") == null) {
            $this->load->view("empty-cart");
        }

        $user = $this->session->userdata("myaccount");
        $cart = $this->session->userdata('addToCart');
        $cart_details = json_encode($cart);
        $this->user->addTocartsession($user, $cart_details);

        if ($this->form_validation->run() == false) {
            $this->db->cache_delete("Checkout", "myWallet");
            $this->db->cache_delete("Checkout", "Address");
            $this->db->cache_delete("Checkout", "index");
            if ($this->session->userdata("step") == "1") {
                $data = $this->user->getAddresses($this->session->userdata("myaccount"));
                $shipping = $this->user->getShipping();
                $this->load->helper('captcha');

                $config = array(
                    'word' => rand(1, 999999),
                    'img_url' => base_url('assets') . '/captcha/',
                    'img_path' => './assets/captcha/',
                    'img_height' => 30,
                    'word_length' => 5,
                    'img_width' => '130',
                    'font_path' => FCPATH . 'system/fonts/texb.ttf',
                    'font_size' => 18,
                    'colors' => array(
                        'background' => array(255, 255, 255),
                        'border' => array(255, 255, 255),
                        'text' => array(0, 0, 0),
                        'grid' => array(255, 75, 100),
                    ),
                );
                $captcha = create_captcha($config);

                $this->session->set_userdata('valuecaptchaCode', $captcha['word']);
                $this->load->view('includes/header-order', array('navbar' => loadnavigation()));
                if ($this->session->userdata("addToCart")) {
                    $this->load->view('cart_address', ["address" => $data, "shipping" => $shipping, "captcha" => $captcha["image"]]);
                } else {
                    $this->load->view("empty-cart");
                }
                $this->load->view('includes/footer2');
            } else {
                echo "<script>window.history.go(-1);</script>";
            }
        } else {

            $id = $this->user->getUserIdByEmail();
            $is = $this->user->insertIntoCustomerAddress($this->security->xss_clean($this->input->post()), $id);
            $this->db->cache_delete("Checkout", "Address");

            $this->db->cache_delete("Checkout", "index");
            return redirect("Checkout/Address");
        }
    }

    public function validate_captcha()
    {
        if ($this->input->post('captcha') != $this->session->userdata['captcha']) {
            $this->form_validation->set_message('validate_captcha', 'Captcha Code is wrong');
            return false;
        } else {
            return true;
        }
    }
    public function successPay()
    {
        $status = $this->input->post("status");
        $firstname = $this->input->post("firstname");
        $amount = $this->input->post("amount");
        $txnid = $this->input->post("txnid");
        $posted_hash = $this->input->post("hash");
        $key = $this->input->post("key");
        $productinfo = $this->input->post("productinfo");
        $email = $this->input->post("email");
        $salt = $this->config->item("merchant_salt");

        // $salt="";
        // Salt should be same Post Request
        if ($this->input->post("status") != 'failure') {
            if (isset($_POST["additionalCharges"])) {
                $additionalCharges = $_POST["additionalCharges"];
                $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
            } else {
                $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
            }
            $hash = hash("sha512", $retHashSeq);
            if ($hash != $posted_hash) {
                echo "Invalid Transaction. Please try again";
            } else {

                $this->user->changeStatus($this->input->post("txnid")); // tbl_customer_order change status
                $order = $this->user->getOrderByTran($this->input->post("txnid"));

                if ($order[0]->pay_method == 2 || $order[0]->pay_method == 3) {

                    $total = 0.0;
                    $getCreditWalletAmt = $this->user->getCreditWalletAmt()[0]->wallet_amt;
                    $getDebitWalletAmt = $this->user->getDebitWalletAmt()[0]->wallet_amt;
                    $total = $getCreditWalletAmt - $getDebitWalletAmt;

                    if (floatval($total) < floatval(round($order[0]->total_order_price))) { // online + wallet
                        $amount = $total;
                    } else { // wallet
                        $amount = 0;
                    }

                    $this->user->changeWalletStatus($amount, $order[0]->id);
                }

                $this->user->deductFromInventory($this->session->userdata("addToCart"));
                //$this->user->addInvoice($order[0]->id);
                $mail = $this->onsuccessMail($order[0]->id);

                // $this->sendCustomerConfirmation();
                $this->db->cache_delete_all();
                $this->session->unset_userdata('addToCart');
                $this->user->prodcart($user);
                $this->session->unset_userdata('coupon_Id');
                $this->session->unset_userdata('gift');
                $this->session->set_flashdata('msg', '<div class="alert alert-success"> Thank you for shopping with us. Your order status is ' . $status . '  Your transaction id for this transaction is ' . $txnid . ' ,We have received a payment Your order will  be shipped soon </div>');
                return redirect('Myaccount/orderDetails');
            }
        } else {

            // failure condition below

            if (isset($_POST["additionalCharges"])) {
                $additionalCharges = $_POST["additionalCharges"];
                $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
            } else {
                $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
            }
            $hash = hash("sha512", $retHashSeq);

            if ($hash != $posted_hash) {
                echo "Invalid Transaction. Please try again";
            } else {
                // $this->user->changeStatus($this->input->post("txnid"));
                // $this->user->deductFromInventory($this->session->userdata("addToCart"));
                // $this->user->addInvoice($query);
                $this->session->unset_userdata('coupon_Id');
                $this->session->set_flashdata('msg', '<div class="alert alert-danger"> Your order status is ' . $status . '  Your transaction id for this transaction is ' . $txnid . '. If you are charged please contact to support</div>');
                return redirect('Myaccount/dashboard');
            }
        }
    }

    public function Payment()
    {

        if ($this->session->userdata("valuecaptchaCode") != $this->security->xss_clean($this->input->post("captcha"))) {
            return redirect('Checkout/Address?validate=failed');
        }
        $qtyval = 0;
        foreach ($this->session->userdata("addToCart") as $qty) {
            $qtyval += ($qty["qty"]);
        }        

        $wallet_amt = 0.0;
        $tax = 0.0;
        $remainingamount = 0.0;
        $hashSequence = "";

        $remainingamountForOnline = 0.0;
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

        if ($this->session->userdata("txnid")) {
            $this->session->unset_userdata("txnid");
        } else {
            $this->session->set_userdata("txnid", $txnid);
        }
        $order_id = $this->user->userorder($this->input->post(), $txnid, $qtyval);

        $response = $this->user->getPendingOrder($order_id);

        $user = $this->session->userdata('myaccount');

        $userVerification = $this->user->get_checkoutUser($response->registered_user, $response->user_contact);
        $userdata = $this->user->get_UserByEmail($user);

        $MERCHANT_KEY = $this->config->item("merchant_key");
        $SALT = $this->config->item("merchant_salt");
        $PAYU_BASE_URL = $this->config->item("merchant_url"); // For Sandbox Mode
        //$PAYU_BASE_URL = "https://secure.payu.in";            // For Production Mode
        $action = $PAYU_BASE_URL . '/_payment';
        $surl = $this->config->item("merchat_success");
        $furl = $this->config->item("merchat_failed");
        $deductAmount = 0.0;
        
        if ($this->input->post("pay_method_wallet") && $this->input->post("pay_method") != "cod") {
            
            $getDebitWalletAmt = $this->user->getDebitWalletAmt(); // all wallet amount
            $getCreditWalletAmt = $this->user->getCreditWalletAmt(); // all wallet amount
            $wallet_amt = $getCreditWalletAmt[0]->wallet_amt - $getDebitWalletAmt[0]->wallet_amt; // wallet price
            
            // $txnid = $order_id;
            if (floatval($wallet_amt) < floatval(round($response->total_order_price))) {
                ///Pay through wallet + online
                $remainingamount = round(floatval($wallet_amt) - floatval(round($response->total_order_price)));
                $remainingamountForOnline = round(floatval($response->total_order_price) - floatval($wallet_amt));

                $deductAmount = $wallet_amt;

                $hashSequence = hash("sha512", "$MERCHANT_KEY|" . $txnid . "|" . $remainingamountForOnline . "|" . $response->first_name . $order_id . "|" . $response->first_name . "|" . $response->registered_user . "|||||||||||$SALT");
            } else {
                $remainingamount = round(floatval($wallet_amt) - floatval(round($response->total_order_price)));
                $deductAmount = round(floatval(round($response->total_order_price)));
            }

            /* if remaining amount > 0 means wallet amount is greater or equal then payment */

            if ($remainingamount < 0) { // full pay through wallet+online

                if ($this->input->post("pay_method") == "cod") { // full pay through wallet+cod

                    $this->user->changeStatus($txnid);

                    $this->user->deductFromInventory($this->session->userdata("addToCart"));
                    $is_prime = count($this->user->isPrime()) > 0 ? 1 : 0;
                    $this->db->update("tbl_customer_order", ["pay_method" => 4, "prime_book" => $is_prime], ["id" => $order_id]);
                    $this->user->changeWalletStatus($deductAmount, $order_id);
                    $mail = $this->onsuccessMail($order_id);
                    $this->session->unset_userdata('addToCart');
                    $this->user->prodcart($user);
                    $this->session->unset_userdata('coupon_Id');
                    $this->session->unset_userdata("coupon_code");
                    $this->session->unset_userdata("coupon_price");
                    $this->session->set_flashdata('msg', '<div class="alert alert-success"> Thank you for shopping with us. We will be shipping your order  soon. </div>');
                    $this->db->cache_delete_all();
                    return redirect('Myaccount/dashboard');
                } elseif ($this->input->post("pay_method") == "online") {
                    // full pay through wallet+online
                    $is_prime = count($this->user->isPrime()) > 0 ? 1 : 0;
                    $this->db->update("tbl_customer_order", ["pay_method" => 3, "prime_book" => $is_prime], ["id" => $order_id]);
                    $paySuccess = base_url("GateWayResponse/ccavenue/" . $response->id);
                    $payCancel = base_url("GateWayResponse/ccavenue/" . $response->id);

                    $this->securepayCashFree($response, "PAUL_".mt_rand(100,999)."_". $response->id . "_" . $userdata[0]->id, $paySuccess, $payCancel, $userVerification, $remainingamountForOnline);

                    // ccavenuem
                    // $this->securepay($response, $response->id, $paySuccess, $payCancel, $userVerification, $remainingamountForOnline);
                    // $this->load->view('payUform', array('action' => $action, 'firstname' => $response->first_name, 'email' => $response->registered_user, 'phone' => $response->user_contact, 'productinfo' => $response->first_name . $order_id, 'MERCHANT_KEY' => $MERCHANT_KEY, 'hash' => $hashSequence, 'txnid' => $txnid, 'amount' => $remainingamountForOnline, 'surl' => $surl, 'furl' => $furl));
                } elseif ($this->input->post("pay_method") == "paytm") { // full pay through wallet+paytm
                    $is_prime = count($this->user->isPrime()) > 0 ? 1 : 0;
                    $this->db->update("tbl_customer_order", ["pay_method" => 5, "prime_book" => $is_prime], ["id" => $order_id]);

                    $paytmParams = array();
                    $paytmParams['ORDER_ID'] = $response->id; //$posted['ORDER_ID']
                    $paytmParams['TXN_AMOUNT'] = $remainingamountForOnline; //$posted['TXN_AMOUNT']
                    $paytmParams["CUST_ID"] = "CUST001"; //$posted['CUST_ID']
                    $paytmParams["EMAIL"] = $response->registered_user;
                    $paytmParams["MID"] = PAYTM_MERCHANT_MID;
                    $paytmParams["CHANNEL_ID"] = PAYTM_CHANNEL_ID;
                    $paytmParams["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
                    $paytmParams["CALLBACK_URL"] = PAYTM_CALLBACK_URL;
                    $paytmParams["INDUSTRY_TYPE_ID"] = PAYTM_INDUSTRY_TYPE_ID;

                    $paytmChecksum = $this->paytm->getChecksumFromArray($paytmParams, PAYTM_MERCHANT_KEY);

                    $paytmParams["CHECKSUMHASH"] = $paytmChecksum;

                    $transactionURL = PAYTM_TXN_URL;

                    $data = array();
                    $data['paytmParams'] = $paytmParams;
                    $data['transactionURL'] = $transactionURL;
                    $this->load->view('payby_paytm', $data);
                } elseif ($this->input->post("pay_method") == "bag") { // wallet + add to bag
                    $is_prime = count($this->user->isPrime()) > 0 ? 1 : 0;
                    $this->db->update("tbl_customer_order", ["pay_method" => 3, "prime_book" => $is_prime], ["id" => $order_id]);
                    $paySuccess = base_url("GateWayResponse/ccavenue/" . $response->id);
                    $payCancel = base_url("GateWayResponse/ccavenue/" . $response->id);
                    $remainingamountForOnline = round(floatval($response->total_order_price) - floatval($wallet_amt));

                    $this->securepayCashFree($response, "PAUL_".mt_rand(100,999)."_". $response->id . "_" . $userdata[0]->id, $paySuccess, $payCancel, $userVerification, $remainingamountForOnline);
                }
            } else { // wallet amount greater than cart amount   //only 
                
                $is_prime = count($this->user->isPrime()) > 0 ? 1 : 0;
                if ($this->input->post("pay_method") == "cod") { // full pay through wallet+cod
                    $this->db->update("tbl_customer_order", ["pay_method" => 4, "prime_book" => $is_prime], ["id" => $order_id]);
                } else {
                    $this->db->update("tbl_customer_order", ["pay_method" => 2, "prime_book" => $is_prime], ["id" => $order_id]);
                }
                $this->user->changeWalletStatus($deductAmount, $order_id);
                $this->user->changeStatus($txnid);

                $this->user->deductFromInventory($this->session->userdata("addToCart"));
                
                $mail = $this->onsuccessMail($order_id);
                $this->session->unset_userdata('addToCart');
                $this->user->prodcart($user);
                $this->session->unset_userdata('coupon_Id');
                $this->session->unset_userdata("coupon_code");
                $this->session->unset_userdata("coupon_price");
                $this->session->set_flashdata('msg', '<div class="alert alert-success"> Thank you for shopping with us. We will be shipping your order  soon. </div>');
                $this->db->cache_delete_all();
                return redirect('Myaccount/dashboard');
            }
        } elseif ($this->input->post("pay_method") == "cod") {
            $this->user->changeStatus($txnid);
            $this->user->deductFromInventory($this->session->userdata("addToCart"));
            $mail = $this->onsuccessMail($order_id);
            $this->session->unset_userdata('addToCart');
            $this->user->prodcart($user);
            $this->session->unset_userdata('coupon_Id');
            $this->session->unset_userdata("coupon_code");
            $this->session->unset_userdata("coupon_price");
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Thank you for shopping with us. We will be shipping your order  soon. </div>');
            $this->db->cache_delete_all();
            return redirect('Myaccount/dashboard');
        } elseif ($this->input->post("pay_method") == "online") {

            // echo $qtyval;
            $paySuccess = base_url("GateWayResponse/ccavenue/" . $response->id);
            $payCancel = base_url("GateWayResponse/ccavenue/" . $response->id);
            $remainingAmount = $response->total_order_price;
            $this->securepayCashFree($response, "PAUL_".mt_rand(100,999)."_". $response->id . "_" . $userdata[0]->id, $paySuccess, $payCancel, $userVerification, $remainingAmount);
            // $hashSequence = hash("sha512", "$MERCHANT_KEY|" . $txnid . "|" . round($response->total_order_price) . "|" . $response->first_name . $order_id . "|" . $response->first_name . "|" . $response->registered_user . "|||||||||||$SALT");
            // $this->load->view('payUform', array('action' => $action, 'firstname' => $response->first_name, 'email' => $response->registered_user, 'phone' => $response->user_contact, 'productinfo' => $response->first_name . $order_id, 'MERCHANT_KEY' => $MERCHANT_KEY, 'hash' => $hashSequence, 'txnid' => $txnid, 'amount' => round($response->total_order_price), 'surl' => $surl, 'furl' => $furl));
        } elseif ($this->input->post("pay_method") == "paytm") {
            $paytmParams = array();
            $paytmParams['ORDER_ID'] = $response->id; //$posted['ORDER_ID']
            $paytmParams['TXN_AMOUNT'] = $response->total_order_price; //$posted['TXN_AMOUNT']
            $paytmParams["CUST_ID"] = "CUST001"; //$posted['CUST_ID']
            $paytmParams["EMAIL"] = $response->registered_user;
            $paytmParams["MID"] = PAYTM_MERCHANT_MID;
            $paytmParams["CHANNEL_ID"] = PAYTM_CHANNEL_ID;
            $paytmParams["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
            $paytmParams["CALLBACK_URL"] = PAYTM_CALLBACK_URL;
            $paytmParams["INDUSTRY_TYPE_ID"] = PAYTM_INDUSTRY_TYPE_ID;

            $paytmChecksum = $this->paytm->getChecksumFromArray($paytmParams, PAYTM_MERCHANT_KEY);

            $paytmParams["CHECKSUMHASH"] = $paytmChecksum;

            $transactionURL = PAYTM_TXN_URL;

            $data = array();
            $data['paytmParams'] = $paytmParams;
            $data['transactionURL'] = $transactionURL;
            $this->load->view('payby_paytm', $data);
        } elseif ($this->input->post("pay_method") == "bag") {

            $paySuccess = base_url("GateWayResponse/ccavenue/" . $response->id);
            $payCancel = base_url("GateWayResponse/ccavenue/" . $response->id);
            $remainingAmount = $response->total_order_price;

            $this->securepayCashFree($response, "PAUL_".mt_rand(100,999)."_". $response->id . "_" . $userdata[0]->id, $paySuccess, $payCancel, $userVerification, $remainingAmount);
        }
    }

   

    public function securepayCashFree($post, $orderId, $successUrl, $cancelUrl, $userVerification2, $remainingamount = "")
    {
        // echo $remainingamount;die;

        if ($post !== null) {

            $tot = 0.0;
            $ss = $this->session->userdata('addToCart');
            $qty = 0;
            if ($remainingamount == "") {
                foreach ($ss as $key => $cart) {
                    $productdetails = getProduct($cart["product"]);

                    $tot = $tot + ((floatval($productdetails->dis_price) * intval($cart["qty"])));
                    $qty += (int) $cart['qty'];
                }
            } else {
                foreach ($ss as $key => $cart) {
                    $productdetails = getProduct($cart["product"]);

                    $qty += (int) $cart['qty'];
                }
            }


            $orderLastId= explode("_",$orderId);
            $lastKey= count($orderLastId)-1;
            $orderIdValue= $orderLastId[$lastKey-1];
            //"PAUL_".mt_rand(100,999)."_". $response->id . "_" . $userdata[0]->id

            if ($remainingamount == "") {
                $shipping_charge = ($qty >= 1 && $qty <= 10) ? 150 : (($qty >= 11 && $qty <= 25) ? 300 : ($qty > 25 ? 450 : 0));
                $amount = $tot + $shipping_charge;
                if ($this->session->userdata("coupon_price")) {
                    $amount = $amount - floatval($this->session->userdata("coupon_price"));
                }
            } else {
                $amount = $remainingamount;
            }

            if ($post->add_to_box == 1) {
                $amount = floatval($amount) - floatval($shipping_charge);
            }

           

            $is_success = $this->user->setTxnId($orderId);
            // print_r($is_success);
            if ($is_success) {
                $this->load->view('cashfreepayment', array('data' => $post, 'amount' => $amount, "orderId" => $orderId, 'successUrl' => $successUrl, "cancelUrl" => $cancelUrl, "checkoutUser" => $userVerification2));
                //   print_r(array('data' => $post, "orderId" => $orderId, 'successUrl' => $successUrl, "cancelUrl" => $cancelUrl, "checkoutUser" => $userVerification2));
                // die("Invalid transaction found");
            }
        } else {
            echo show_404();
        }
    }
    public function securepay($post, $orderId, $successUrl, $cancelUrl, $userVerification2, $remainingamount = "")
    {
        // echo $remainingamount;die;

        if ($post !== null) {

            // $this->load->view("includes/Crypto");

            $tot = 0.0;
            $ss = $this->session->userdata('addToCart');
            $qty = 0;
            if ($remainingamount == "") {
                foreach ($ss as $key => $cart) {
                    $productdetails = getProduct($cart["product"]);

                    $tot = $tot + ((floatval($productdetails->dis_price) * intval($cart["qty"])));
                    $qty += (int) $cart['qty'];
                }
            } else {
                foreach ($ss as $key => $cart) {
                    $productdetails = getProduct($cart["product"]);

                    $qty += (int) $cart['qty'];
                }
            }

            if ($remainingamount == "") {
                $shipping_charge = ($qty >= 1 && $qty <= 10) ? 150 : (($qty >= 11 && $qty <= 25) ? 300 : ($qty > 25 ? 450 : 0));
                $amount = $tot + $shipping_charge;
                if ($this->session->userdata("coupon_price")) {
                    $amount = $amount - floatval($this->session->userdata("coupon_price"));
                }
            } else {
                $amount = $remainingamount;
            }

            if ($post->add_to_box == 1) {
                $amount = floatval($amount) - floatval($shipping_charge);
            }

            $this->session->set_userdata("info", ["order_id" => $orderId, "amount" => $amount]);

            $is_success = $this->user->setTxnId($orderId);
            // print_r($is_success);
            if ($is_success) {
                $this->load->view('payment', array('data' => $post, 'amount' => $amount, "orderId" => $orderId, 'successUrl' => $successUrl, "cancelUrl" => $cancelUrl, "checkoutUser" => $userVerification2));
                //   print_r(array('data' => $post, "orderId" => $orderId, 'successUrl' => $successUrl, "cancelUrl" => $cancelUrl, "checkoutUser" => $userVerification2));
                // die("Invalid transaction found");
            }
        } else {
            echo show_404();
        }
    }

    private function onsuccessVendorMail($order, $qty, $company, $vendor_email, $pro_name, $pro_property, $fname, $lname)
    {
        $msg = "";

        $message = "";
        $property = "";
        $base = base_url();
        $to_email = $vendor_email;
        $subject = "Order Confirmation : Paulsons.com";
        $message .= "<p>Dear $company, your product has been sold on Paulsons.com " . date("d/m/Y H:i") . " to customer $fname $lname ";
        $message .= "<p>Please keep consignment ready for our courier partner pickup within 24 hours</p>";
        $message .= "<p>Please find the order details</p>";
        $orderProp = json_decode($pro_property);

        if ($orderProp->attribute != null) {
            foreach ($orderProp->attribute as $attribute) {
                $prop = key((array) $attribute);
                $property .= <<<EOD
                       <br><span>$prop :{$attribute->$prop}</span>
EOD;
            }
        }
        $message .= " <p><b>Order ID:</b> PAUL#00$order</p> ";
        $message .= " <p><b>Product Name:</b> {$pro_name} x {$qty}  $property</p> ";
        $message .= " <p>Thanks for be partner with Paulsons</p><p>For support call our customer care number : +91 97160-90101</p>";

        if ($order) {
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('hello@paulsonsonline.com', 'paulsonsonline.com');
            $this->email->to($to_email);
            $this->email->bcc(array('hello@paulsonsonline.com'));
            $this->email->subject($subject);
            $this->email->message($message);
            $result = $this->email->send();
        }
    }

    private function onsuccessMail($order)
    {

        $msg = "";

        $user = $this->user->getsuccessPayment($order);

        $orders = $this->user->allOrdersOrderId($order);

        // $this->sendCustomerConfirmation($user->user_contact);
        $orderHtml = "";

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

        if ($user->offer_code != '') {

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
        $subject = "Order Confirmation : paulsonsonline.com";
        $message .= "<table style='border-collapse:collapse;width:80%;margin:0 auto;border:1px solid #777;padding:8px;display: inherit;'>"
        . "<tr><td colspan='4'><img src='" . $base . "bootstrap/images/logo.png' style='width:20%'></td></tr>"
        . "<tr><td colspan='4'><h3>Hello, $user->first_name</h3></td></tr>"
        . "<tr><td colspan='4'>Thank you for your order from paulsonsonline.com Once your package ships we will send an email with a link to track your order. If you have any questions about your order please contact us at retail.paulsons@gmail.com or call us at +91 74282-11662 Monday - Saturday, 11am - 7pm IST.</td></tr>"
        . "<tr><td colspan='4'>&nbsp;</td></tr>"
        . "<tr><td colspan='4'>Your order confirmation is below. Thank you again for your business.</td></tr>"
        . "<tr><td colspan='4'>&nbsp;</td></tr>"
        . "<tr><td colspan='4'><h3>Your Order <small>(PAUL#00$order) (placed on " . date('M d, Y H:i') . ")</small></h3></td></tr>"
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
            . "<tr><td style='background:#e8e8e8;padding: 5px 3px;text-align:center' colspan='4'>Thank you again, paulsonsonline.com</td></tr>"
            . "</table>";

        if ($user) {
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('retail.paulsons@gmail.com', 'paulsonsonline.com');
            $this->email->to($to_email);
            $this->email->bcc(array( 'gaurav@nibble.co.in'));
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

    // public function Payment()
    // {
    //     $this->load->view('includes/header-order', array('navbar' => loadnavigation()));
    //     $this->load->view('paymentFinal');
    //     $this->load->view('includes/footer-order');
    // }

    public function dUA()
    {

        $data = $this->user->deleteAddress($this->input->post("data"));
        $this->db->cache_delete("Checkout", "Address");
    }

    public function getAddress()
    {
        $data = $this->user->selectAddress($this->input->post("data"));
    }

    public function index()
    {
        $this->session->unset_userdata("myWallet");
        $this->session->set_userdata("step", 0);
        $this->load->view('includes/header-order', array('navbar' => loadnavigation()));

        if ($this->session->userdata("addToCart")) {
            $data["shipping"] = $this->user->getShipping();
            $this->checkInInventory();
            if ($this->session->userdata("addToCart")) {
                $this->load->view('cart', $data);
            } else {
                $this->load->view("empty-cart");
            }
        } else {
            $this->load->view("empty-cart");
        }
        $this->load->view('includes/footer2');
    }

    public function checkInInventory()
    {
        $sessionCart = $this->session->userdata("addToCart");
        $index = 0;
        foreach ($sessionCart as $key => $value) {
            $qty = (int) $value['qty'];
            $data = $this->db->get_where("tbl_product", ["id" => $value["product"]])->result();

            if ($data != null) {
                $databaseQty = (int) $data[0]->pro_stock;
                if ($databaseQty < $qty) {
                    $index = 1;
                    unset($sessionCart[$key]);
                }
            }
        }
        array_values($sessionCart);
        $this->session->set_userdata("addToCart", $sessionCart);

        if ($index == 1) {
            echo "<script>alert('Some of your cart products has been out of stock !');</script>";
        }
    }

    public function getSize()
    {
        $pro_id = $this->encryption->decrypt(decode($this->input->post("pro"))); //$this->encrypt->decode($this->input->post("pro"));
        $prop_id = $this->input->post("prop");
        $pro = $this->user->getProduct($pro_id);
        // echo $pro != null ? $pro->product_attr : null;
        echo $pro != null ? json_encode(["response" => $pro->product_attr, "add_limit" => $pro->add_limit]) : null;
    }

    public function updateCartAjax()
    {
        $this->input->post("attr");
        $this->input->post("qty");
        $this->input->post("key");
        $pro = $this->encryption->decrypt(decode($this->input->post("pro")));
        $act_price = 0;
        $dis_price = 0;
        $session = $this->session->userdata('addToCart');
        if ($this->input->post("action") == "size") {
            foreach ($session as $k => $se) {
                if ($se["product"] == $pro && $se["attr"] == $this->input->post("attr")) {
                    unset($session[$k]);

                    break;
                }
            }
        }

        $price = [];
        if ($this->session->userdata("step")) {
            $this->session->set_userdata("step", 0);
        }

        //update attruibutes and size

        foreach ($session as $key => $value) {
            $session[$this->input->post("key")]["attr"] = $this->input->post("attr");
            $session[$this->input->post("key")]["qty"] = $this->input->post("qty");
        }
        //reset array
        $session = array_values($session);
        $qty = 0;
        $tax = 0.0;
        $userDetail = null;
        $shippingVal = 0.0;
        $shippinga = $this->user->getShipping();
        $userID = $this->user->getUserIdByEmail();

        foreach ($session as $ke => $qtyl) {
            $qty += (int) $qtyl["qty"];
            $pro = $this->user->getProduct($value["product"]);
            $act_price += floatval($pro->act_price) * (int) $qtyl["qty"];
            if (($userID) != 0) {
                $userDetail = $this->user->get_profile_id($userID);
                if (($userDetail) != null && $userDetail->is_prime == 1) {
                    $getSubscription = $this->user->load_subscription();

                    $primeDiscount = floatval($pro->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member
                    $dis_price += floatval($pro->dis_price) - floatval($primeDiscount) * (int) $qtyl["qty"];
                } else {
                    $dis_price += floatval($pro->dis_price) * (int) $qtyl["qty"]; // normal user
                }
            } else {
                $dis_price += floatval($pro->dis_price) * (int) $qtyl["qty"];
            }

            if ($userDetail != null && $userDetail->is_prime == 1) {
                $tax += (floatval($pro->dis_price) - floatval($primeDiscount) * intval($qtyl["qty"]) * floatval($pro->gst)) / 100;
                $price[] = array("act_price" => floatval($pro->act_price), "dis_price" => (floatval($pro->dis_price) - floatval($primeDiscount)), "qty" => (int) $qtyl["qty"]);
            } else {
                $tax += (floatval($pro->dis_price) * intval($qtyl["qty"]) * floatval($pro->gst)) / 100;
                $price[] = array("act_price" => floatval($pro->act_price), "dis_price" => floatval($pro->dis_price), "qty" => (int) $qtyl["qty"]);
            }
            // $tax += (floatval($pro->dis_price) * intval($qtyl["qty"]) * floatval($pro->gst)) / 100;
            // $price[] = array("act_price" => floatval($pro->act_price), "dis_price" => floatval($pro->dis_price), "qty" => (int) $qtyl["qty"]);
        }
        if ($userDetail != null && $userDetail->is_prime == 1) {
            if ($shippinga[0]->ship_min >= (floatval($pro->dis_price) - floatval($primeDiscount))) {
                $shippingVal = floatval($shippinga[0]->value);
            }
        } else {
            if ($shippinga[0]->ship_min >= $dis_price) {
                $shippingVal = floatval($shippinga[0]->value);
            }
        }

        $this->session->set_userdata("addToCart", $session);
        $this->session->unset_userdata("coupon_Id");
        $this->session->unset_userdata("coupon_code");
        $this->session->unset_userdata("coupon_price");
        echo json_encode(["qty" => $qty, "tax" => round($tax), "act_price" => $act_price, "dis_price" => $dis_price, "prices" => ($price), "shipping" => $shippingVal]);
    }

    public function removeProduct()
    {
        $is = $this->input->post("key");
        $session = $this->session->userdata('addToCart');
        unset($session[$is]);
        $arr = array_values($session);
        $this->session->set_userdata('addToCart', $arr);
        $this->session->unset_userdata("coupon_Id");
        $this->session->unset_userdata("coupon_code");
        $this->session->unset_userdata("coupon_price");
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
    }

    public function updateCart()
    {
        $session = $this->session->userdata('addToCart');

        foreach ($this->input->post('product_val') as $key => $addCart) {
            $session[$this->encryption->decrypt(decode($addCart))]['qty'] = abs($this->input->post('product_qty')[$key]);
        } //$this->encryption->decrypt(decode($this->input->post("pro")));
        $this->session->set_userdata('addToCart', $session);
        return redirect('Checkout');
    }

    public function myCoupon()
    {
        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount/dashboard');
        }
        $this->load->view('includes/header-profile');
        $uid = $this->user->getUserIdByEmail();
        $groups = $this->user->getAllOffer($uid);
        $coupons = null;
        foreach ($groups as $grp) {
            $res = $this->user->getCouponByGroup($grp);
            if (count($res) > 0) {
                $coupons = $res;
            }
        }

        if (count($coupons) > 0) {
            $this->load->view('my_coupon', ["coupons" => $coupons]);
        } else {
            $this->load->view('my_coupon', ["coupons" => null]);
        }
        $this->load->view('includes/footer');
    }

    public function myGift()
    {
        $data = $this->security->xss_clean($this->input->post());

        $this->session->set_userdata("gift", $data);
    }

    public function removeGift()
    {
        $this->session->unset_userdata("gift");
    }

    public function addtobox()
    {
        $key = $this->input->post('key');
        $val = $this->input->post('val');
        $data = $this->user->add_to_box($key, $val);
    }

    public function Removefrombox()
    {
        $key = $this->input->post('key');
        $val = $this->input->post('val');
        $data = $this->user->rmv_frm_box($key, $val);
    }

    public function emptyFullcart()
    {
        $user = $this->input->post('user');
        $this->session->unset_userdata('addToCart');
        $this->session->unset_userdata("coupon_Id");
        $this->session->unset_userdata("coupon_code");
        $this->session->unset_userdata("coupon_price");
        $this->user->emptyDbcart($user);
    }
}
