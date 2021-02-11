<?php

class GateWayResponse extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('navigation');
        $this->load->library('Paytm');
        $this->load->model('User_model', 'user');
        $this->db->cache_delete_all();
    }

    public function ccavenue()
    {
        $secretkey = '40c89bee71f13330f0430c1d2c9d307cc38703bd';    // CASHFREE_KEY
        $orderId = $_POST["orderId"];
        $orderAmount = $_POST["orderAmount"];
        $referenceId = $_POST["referenceId"];
        $txStatus = $_POST["txStatus"];

        $paymentMode = $_POST["paymentMode"];
        $txMsg = $_POST["txMsg"];
        $txTime = $_POST["txTime"];
        $signature = $_POST["signature"];
        $data = $orderId . $orderAmount . $referenceId . $txStatus . $paymentMode . $txMsg . $txTime;
        $hash_hmac = hash_hmac('sha256', $data, $secretkey, true); //false
        $computedSignature = base64_encode($hash_hmac);

        if (($signature == $computedSignature) && $txStatus=="SUCCESS") {

            $filteredOrderId = explode("_", $orderId);
            $keyCount = count($filteredOrderId) - 1;
            $karzOrderId = $filteredOrderId[$keyCount - 1];
            $userId = $filteredOrderId[$keyCount];

            if ($this->uri->segment("3") != $karzOrderId || round((float) $orderAmount) <= 0) {

                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Invalid Details Detected ,Please enter valid one</div>');

                return redirect('failed');
            }

            $id = $this->uri->segment(3);
            $decodeId = $id;

            if ($decodeId > 0) {
                
                $data = $this->user->successPayment($decodeId);
                $html = "<div style=''><table class='table table-condensed table-border'>";

                $order_id = $orderId;
                $track = $referenceId;
                $amount = $orderAmount;

                $html .= '<tr><td>Order Id</td><td>' . urldecode($order_id) . '</td></tr>';
                $html .= '<tr><td>Reference Id</td><td>' . urldecode($track) . '</td></tr>';
                $html .= '<tr><td>Amount Charged</td><td>' . urldecode($amount) . '</td></tr>';

                $html .= "</table></div>";

                if ($data) {

                    $user = $this->user->get_profile_id($userId);
                    $paul_user_email = $user->user_email;
                    $this->session->set_userdata('myaccount',$paul_user_email);

                    /** Execute Only if Wallet+Online = 3 */
                    $customerOrder = $this->db->get_where("tbl_customer_order", ["id" => $id])->row();
                    if ($customerOrder->pay_method == "3") {
                        $getCreditWallet = $this->db->select_sum('wallet_amt')->from('tbl_wallet')->where(["user_id" => $userId, 'controls' => 0])->get()->result(); // all return products
                        $getDebitWallet = $this->db->select_sum('wallet_amt')->from('tbl_wallet')->where(["user_id" => $userId, 'controls' => 1])->get()->result();
                        $total = $getCreditWallet[0]->wallet_amt - $getDebitWallet[0]->wallet_amt;
                        $query = $this->db->insert("tbl_wallet", ["is_display" => 1, "controls" => 1, "order_id" => $order_id, "wallet_amt" => $total, "pay_id" => $track, "user_id" => $userId]);
                    }

                    $userList = $this->user->get_profile_id($userId);
                    
                    $cart = $this->user->userCart($userList->user_email);

                    $order = json_decode($cart->product, true); //addtocart Session                    
                    $this->user->deductFromInventory($order);
                    $this->user->changeStatus($decodeId);
                    //previously it was -- $this->user->deductFromInventory($order, $decodeId);
                    // $this->user->addInvoice($decodeId);
                    $this->session->unset_userdata('addToCart');
                    $this->session->unset_userdata("coupon_Id");
                    $this->session->unset_userdata("coupon_code");
                    $this->session->unset_userdata("coupon_price");
                    $this->user->prodcart($userList->user_email);
                    $this->db->cache_delete_all();
                    $this->onsuccessMail($decodeId);
                    $this->smsOrder($decodeId);
                    // $this->sendCustomerConfirmation();
                    $this->session->set_flashdata('msg', '<div">
           <h3> Your credit card has been charged successfully </h3>
           <p>. We will be shipping your order to you soon.</p>
            ' . $html . '  </div></div>');
                    return redirect('successfullPayment');
                }
            } else {
                echo show_404();
            }

        } else {
            $this->db->cache_delete_all();
            return redirect('failed');
        }
        return redirect('Myaccount/dashboard');
    }

    public function WalletRecharge()
    {
        $secretkey = '40c89bee71f13330f0430c1d2c9d307cc38703bd';    // CASHFREE_KEY
        $orderId = $_POST["orderId"];
        $orderAmount = $_POST["orderAmount"];
        $referenceId = $_POST["referenceId"];
        $txStatus = $_POST["txStatus"];
        $paymentMode = $_POST["paymentMode"];
        $txMsg = $_POST["txMsg"];
        $txTime = $_POST["txTime"];
        $signature = $_POST["signature"];
        $data = $orderId . $orderAmount . $referenceId . $txStatus . $paymentMode . $txMsg . $txTime;
        $hash_hmac = hash_hmac('sha256', $data, $secretkey, true);
        $computedSignature = base64_encode($hash_hmac);

     
        if (($signature == $computedSignature) && $txStatus=="SUCCESS") {

            $filteredOrderId = explode("_", $orderId);
            $keyCount = count($filteredOrderId) - 1;

            $userId = $filteredOrderId[$keyCount];
            
            $user = $this->user->get_profile_id($userId);
            $paul_user_email = $user->user_email;
            $this->session->set_userdata('myaccount',$paul_user_email);

            $isOrderWallet= $this->db->get_where("tbl_wallet",["pay_id"=>$referenceId])->row();
			$query=null;
			$success=0;
            if($isOrderWallet==null){
			   $this->db->cache_delete_all();
               $query = $this->db->insert("tbl_wallet", ["is_display" => 1, "order_id" => $orderId, "controls" => 0, "wallet_amt" => $orderAmount, "pay_id" => $referenceId, "user_id" => $userId]);
	 	       $success=1;
				 
            }
			   $this->session->set_flashdata('msg', '<div class="alert alert-success"> Thank you for adding money to wallet. You are charged and your transaction is successful.</div>');
               
                $this->session->unset_userdata("myWallet");

                return redirect('successfull');
           
        } else {
            $this->db->cache_delete_all();
            return redirect('failed');
        }
    }

    private function smsOrder($orderID)
    {
        $data = $this->db->select('*, tbl_customer_order.id as ID')->from('tbl_customer_order')->join('tbl_user_reg', 'tbl_customer_order.registered_user=tbl_user_reg.user_email')->where('tbl_customer_order.id', $orderID)->get()->result()[0];
        $mob = $data->user_contact;
        $name = $data->user_name;
        $orderno = $data->ID;
        $msg = "Hello ".$name.", you have successfully placed the order, your order with order ID 1000".$orderno." is Confirmed."; // 
        $message = rawurlencode($msg);

        $url = "http://alerts.teamad.in/V2/http-api.php?apikey=pGIBN1N7n6Lvr03f&senderid=PALSON&number=".$mob."&message=".$message."&format=json";
        $json = file_get_contents($url);
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
        $subject = "Order Confirmation : paulsons.com";
        $message .= "<table style='border-collapse:collapse;width:80%;margin:0 auto;border:1px solid #777;padding:8px;display: inherit;'>"
        . "<tr><td colspan='4'><img src='" . $base . "bootstrap/images/logo.png' style='width:20%'></td></tr>"
        . "<tr><td colspan='4'><h3>Hello, $user->first_name</h3></td></tr>"
        . "<tr><td colspan='4'>Thank you for your order from paulsons. Once your package ships we will send an email with a link to track your order. If you have any questions about your order please contact us at support@paulsons.com or call us at +91 74282-11662 Monday - Saturday, 11am - 6pm IST.</td></tr>"
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
            . "<tr><td style='background:#e8e8e8;padding: 5px 3px;text-align:center' colspan='4'>Thank you again, paulsons</td></tr>"
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
            $this->email->bcc(array(EMAIL_BCC));
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
