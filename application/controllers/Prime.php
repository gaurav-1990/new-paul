<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Prime extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('google');
        $this->load->model('User_model', 'user');
        $this->load->library('encryption');
        $this->load->helper('navigation');
        $this->load->library('facebook');
        $this->load->helper('checkout');
        $this->load->model('Signup_model', 'sign');
    }

    private function mailPrime($id) {
        $result = $this->db->get_where("tbl_user_reg", ['id' => $id])->result()[0];
        if ($result != null) {
            $html = "";
            $base = base_url();
                $html .= <<<EOD
                <table style='text-align:left;margin: 0 auto;' width="50%">
                    <tr>
                        <td><a target='_' href='{$base}shop/subscription/GhL2RNJ..6idglXJVibYvl4O3ocoHUS4ESRDEVNfmBFQdipUEXKd1xkYM3vbImKDvk9U53sR~hkqI1kro98~.g--'><small>Get to know subscription benifits</small></a></td>
                       </tr>
                         <tr>
                        <td style='text-align:center'><img style='width:20%' src='{$base}bootstrap/images/logo.png'></td>
                         </tr>
                         <tr>
                        <td>&nbsp;</td>
                         </tr>
                             <tr>
                        <td>Hello {$result->user_name},</td>
                          </tr>
                         <tr>
                        <td>
                            Congratulations, you have activated your paulsons subscription at INR 999 for 30 days .<br>
                            As a Prime member, enjoy these great benefits: 
                                <br>
                        <br>
                        <br>
                            Membership includes access to our latest season's styles at affordable prices and additional discounts.We will send you customized box of your selected merchandise every month.You have an option to keep it or return the clothes within 3 months of purchase when your child outgrows them for credits. These credits can be used for your future purchases on our website.<br>
The plan will renew every month automatically untill you cancel the subscription.The membership comes with <b> free shipping</b> and no hidden fess.
                        </td>
                    </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td >
                                    <img style='width:100%' src='{$base}assets/images/footer_mail_subscription.png'>
                            </td>
                        </tr>
                </table>
EOD;


            $to_email = $result->user_email;
            $subject = "Welcome to paulsons subscription plan" . date("Y-m-d H:i");


            $config = array(
                'mailtype' => 'html',
                'charset' => 'utf-8',
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->reply_to('support@paulsons.com', 'paulsons');
            $this->email->from('support@paulsons.com', 'paulsons');
            $this->email->to($to_email);
            $this->email->bcc(array("ronjhiya.gaurav3@gmail.com", 'support@paulsons.com'));
            $this->email->subject($subject);
            $this->email->message($html);
            $this->email->send();
        }
    }

    public function razorPaySuccess() {
        if ($this->input->post('razorpay_payment_id') != '') {
            $query = $this->db->update("tbl_user_reg", ["prime_sta" => 1, "prime_date" => date("Y-m-d H:i:s"),"is_prime" => 1, "pay_id" => $this->input->post('razorpay_payment_id')], ["id" => $this->session->userdata("razorpay_user")]);
            $this->db->insert("tbl_wallet", ["is_display" => 1, "controls" => 0, "wallet_amt" => 1500, "pay_id" => $this->input->post('razorpay_payment_id'), "user_id" => $this->session->userdata("razorpay_user")]);
            $this->mailPrime($this->session->userdata("razorpay_user"));
            $this->db->cache_delete('Prime', 'razorPaySuccess');
            $this->db->cache_delete('Prime', 'index');
            if ($query) {
                $arr = array('msg' => 'Payment successfully credited', 'status' => true);
                echo json_encode($arr);
            } else {
                $arr = array('msg' => 'Payment failed', 'status' => false);
                echo json_encode($arr);
            }
        } else {
            echo show_404();
        }
    }

    public function index() {
        $this->load->library('form_validation');
        require_once APPPATH . 'vendor/autoload.php';



        $this->form_validation->set_rules('login[fullname]', 'First Name', 'required|min_length[3]');
        $this->form_validation->set_rules('login[lastname]', 'Last Name', 'required|min_length[3]');
        $this->form_validation->set_rules('login[username]', 'email', 'required|valid_email|is_unique[tbl_user_reg.user_email]');
        $this->form_validation->set_rules('contact', 'Contact Number', 'required|numeric|max_length[10]|min_length[10]|is_unique[tbl_user_reg.user_contact]');
        $this->form_validation->set_rules('login[password]', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('login[cpassword]', 'Confirm Password', 'required|min_length[6]|matches[login[password]]');
        $this->form_validation->set_message('is_unique', 'The %s is already taken, Try to login');
        $this->db->cache_delete("Prime", "index");

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {


            $this->load->view('includes/header');
            $primeAmt = $this->user->primeAmt();
            $isPrime=0;
            if(@count($this->user->getUserIdByEmail())>0)
            {
                $isPrime=1;
            }
            $this->load->view('primeMember', array('primeAmt' => $primeAmt,'isPrime'=>$isPrime));
            $this->load->view('includes/footer');
        } else {



            $this->load->view('includes/header');
            $primeAmt = $this->user->primeAmt();
            $this->load->view('primeMember', array('primeAmt' => $primeAmt));
            $this->load->view('includes/footer');
            $keyId = RAZOR_KEY_ID;
            $keySecret = RAZOR_KEY_SECRET;
            $displayCurrency = 'INR';
            $api = new Razorpay\Api\Api($keyId, $keySecret);

            $post = [];
            $fullname = $this->security->xss_clean($this->input->post('login[fullname]'));
            $lastname = $this->security->xss_clean($this->input->post('login[lastname]'));
            $username = $this->security->xss_clean($this->input->post('login[username]'));
            $password = $this->security->xss_clean($this->input->post('login[password]'));

            $amt = (int) $this->encryption->decrypt(decode($this->input->post('prime_amt')));

            $cpassword = password_hash($this->security->xss_clean($this->input->post('login[cpassword]')), PASSWORD_BCRYPT);
            $contact = $this->security->xss_clean($this->input->post('contact'));
            $dob = $this->security->xss_clean($this->input->post('login[dob]'));
            $post["fullname"] = $fullname;
            $post["lastname"] = $lastname;
            $post["username"] = $username;
            $post["cpassword"] = $cpassword;
            $post["contact"] = $contact;
            $post["amt"] = $amt;
            $result = $this->user->prime_registration($post);
            $this->session->set_userdata("razorpay_user", $result);
            $base = base_url();
            $primeAmount = $this->db->get("prime_membership")->result()[0];

            $amount = floatval($primeAmount->amount) * 100;


            $success_id = encode($this->encryption->encrypt($this->session->userdata("razorpay_user")));

            echo $html = <<<EOD
               
                   <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>            
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

 
    var totalAmount ={$amount};
    var product_id =  {$result};
    var options = {
    "key": "$keyId",
    "amount": {$amount}, 
    "name": "paulsons Prime Membership",
    "description": "Payment",
    "image": "",
     "prefill": {
        "name": "{$fullname}",
        "email": "{$username}",
        "contact": "{$contact}"
    },
    "handler": function (response){
          $.ajax({
            url: 'Prime/razorPaySuccess',
            type: 'post',
            dataType: 'json',
            data: {
                razorpay_payment_id: response.razorpay_payment_id , totalAmount : totalAmount ,product_id : product_id,
            }, 
            success: function (msg) {
               msg= msg.status;
               if(msg==true)
               {
               window.location.href =    '{$base}payment/ThankYou/$success_id';
               }else {
                 window.location.href =    '{$base}payment/FailedPayment/$success_id';
               }
            }
        });
      
    },
 
    "theme": {
        "color": "#528FF0"
    }
  };
  var rzp1 = new Razorpay(options);
  rzp1.open();
  e.preventDefault();
  
 
</script>
          
EOD;



//            $this->db->cache_delete('Admin', 'SadminLogin');
//            if ($result) {
//                $this->sendCurl_prime($contact);
//                $this->session->set_userdata('myaccount', $username);
//                if ($this->uri->segment(3) == 'StepCheckOut') {
//                    return redirect('Checkout');
//                } else {
//                    return redirect('Myaccount/dashboard');
//                }
//            } else {
//                $this->session->set_flashdata('msg', '<div class="text-danger">Something went wrong,Please try again</div>');
//                if ($this->uri->segment(3) == 'StepCheckOut') {
//                    return redirect('Checkout');
//                } else {
//                    return redirect('Prime');
//                }
//            }
        }
    }

    public function razorPayExistingSuccess() {
        
        if ($this->input->post('razorpay_payment_id') != '') {
            $id = $this->user->get_profile($this->session->userdata("myaccount"))->id;
            $query = $this->db->update("tbl_user_reg", ["prime_sta" => 1,"prime_date" => date("Y-m-d H:i:s"), "is_prime" => 1, "pay_id" => $this->input->post('razorpay_payment_id')], ["id" => $id]);
            $query = $this->db->insert("tbl_wallet", ["is_display" => 1, "controls" => 0, "wallet_amt" => 1500, "pay_id" => $this->input->post('razorpay_payment_id'), "user_id" => $id]);
            $this->mailPrime($id);
            if ($query) {
                $arr = array('msg' => 'Payment successfully credited', 'status' => true);
                echo json_encode($arr);
            } else {
                $arr = array('msg' => 'Payment failed', 'status' => false);
                echo json_encode($arr);
            }
        } else {
            echo show_404();
        }
    }

    public function regPrime() {
        if ($this->session->userdata('myaccount') != NULL || $this->session->userdata('app_id') != NULL) {
            //   $res = $this->user->assignPrime();
            $keyId = RAZOR_KEY_ID;
            $keySecret = RAZOR_KEY_SECRET;
            $displayCurrency = 'INR';
            $api = new Razorpay\Api\Api($keyId, $keySecret);
            $primeAmt = $this->user->primeAmt();
            $this->load->view('includes/header');

            $this->load->view('primeMember', array('primeAmt' => $primeAmt));
            $this->load->view('includes/footer');
            $amount = floatval($primeAmt->amount) * 100;

            $data = $this->user->get_profile($this->session->userdata("myaccount"));

            $id = $data->id;
            $success_id = encode($this->encryption->encrypt(($id)));
            $base = base_url();
            echo $html = <<<EOD
                
                   <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>            
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

 
    var totalAmount ={$amount};
    var product_id =  "$success_id";
    var options = {
    "key": "$keyId",
    "amount": {$amount}, 
    "name": "paulsons Prime Membership",
    "description": "Payment",
    "image": "",
    "prefill": {
        "name": "{$data->user_name} {$data->lastname}",
        "email": "{$data->user_email}",
        "contact": "{$data->user_contact}"
    },
    "handler": function (response){
          $.ajax({
            url: 'razorPayExistingSuccess',
            type: 'post',
            dataType: 'json',
            data: {
                razorpay_payment_id: response.razorpay_payment_id , totalAmount : totalAmount ,product_id : product_id,
            }, 
            success: function (msg) {
               msg= msg.status;
               if(msg==true)
               {
               window.location.href =    '{$base}Prime/ThankYou/$success_id';
               }else {
                 window.location.href =    '{$base}Prime/FailedPayment/$success_id';
               }
            }
        });
      
    },
 
    "theme": {
        "color": "#528FF0"
    }
  };
  var rzp1 = new Razorpay(options);
  rzp1.open();
 
  
 
</script>
          
EOD;
        } else {
            $this->session->set_flashdata('msg', '<div class="text-danger">Something went wrong,Please try again</div>');
            return redirect('Prime');
        }
    }

    public function ThankYou() {  // razorPay
        $this->load->view('includes/header', array('navbar' => loadnavigation()));
        $this->load->view("thanks_page");
        $this->load->view('includes/footer2');
    }

    public function FailedPayment() {// razorPay
        $this->load->view('includes/header', array('navbar' => loadnavigation()));
        $this->load->view("failedPayment");
        $this->load->view('includes/footer2');
    }

}

?>
