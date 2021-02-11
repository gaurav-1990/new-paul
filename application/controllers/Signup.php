<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Signup_model', 'sign');
        $this->load->library('encryption');
        $this->load->helper('checkout');
        $this->load->helper('navigation');
    }

    public function index() {
        $state = $this->sign->loadState();
        $this->load->view('includes/header-profile');
        $this->load->view('signup', array('state' => $state));
    }

    public function checkContact() {
        echo $this->sign->checkContact($this->input->get('contact_no', TRUE));
    }

    public function checkEmail() {
        echo $this->sign->emailCheck($this->input->get('email', TRUE));
    }

    public function checkPan() {
        echo $this->sign->panCheck($this->input->get('pan', TRUE));
    }

    public function otpVerifyStep() {

        $this->load->view('includes/head-sign');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email_otp', 'Email OTP', 'required|numeric|min_length[3]');
        $this->form_validation->set_rules('mobile_otp', 'Mobile OTP', 'required|numeric|min_length[3]');
        if ($this->form_validation->run() == false) {
            $this->load->view('two_stepverify');
        } else {
            $count = 1;
            $this->session->set_userdata('otpcount', $count);
            $id = encode($this->encryption->encrypt(($this->uri->segment(3))));
            $verify_state = $this->sign->verifyOtps($this->input->post('email_otp'), $this->input->post('mobile_otp'), $id);
            if (!$verify_state) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Invalid OTP</div>');
                return redirect('Signup/otpVerifyStep/' . $this->uri->segment(3));
            } else {
                return redirect('Signup/thanks');
            }
        }
    }

    public function registrationStep() {

        if ($this->input->post()) {
            
            $data = $this->security->xss_clean($this->input->post(NULL, TRUE));

            $email_otp = rand(1000, 99999);
            $sms_otp = rand(999, 99999);

            $data['email_otp'] = $email_otp;
            $data['sms_otp'] = $sms_otp;

            $query = $this->sign->registration($data);
            $to_email = $this->input->post('email', TRUE);


            $subject = "Confidential: Registration " . $to_email;
            $message = "Hi " . $this->input->post('fname');
            $message .= "
<h2>Your Email Verification Code Is:$email_otp </h2>
<p>Enter this otp in Email otp field</p>
<br/>
<p>Thanks & Regards,</p>
<p>Team Paulsons</p>
<br>
<img src='http://paulsonsonline.com/bootstrap/images/logo.png'/>
";


            if ($query) {
                $config = array(
                  
                    'mailtype' => 'html',
                    'charset' => 'utf-8'
                );

                $this->load->library('email', $config);
                $this->email->reply_to('hello@paulsonsonline.com', 'Vendors');
                $this->email->set_newline("\r\n");
                $this->email->from('hello@paulsonsonline.com', 'Vendor Verification');
                $this->email->to($to_email);
                $this->email->bcc(array('hello@paulsonsonline.com'));
                $this->email->subject($subject);
                $this->email->message($message);
                $smsapi = $this->sendCurl($this->security->xss_clean($this->input->post('contact_no')), $sms_otp);
                $mailapi = $this->email->send();
 
                if ($smsapi && $mailapi) {
                    return redirect('Signup/otpVerifyStep/' . encode($this->encryption->encrypt(($query))));
                } else {
                    $mess = "";
                    if (!$smsapi && !$mailapi) {
                        $mess .= "Email and SMS Failed ! please enter valid email and mobile";
                    } elseif (!$smsapi) {
                        $mess .= "SMS Failed ! please enter valid mobile";
                    } elseif (!$mailapi) {
                        $mess .= "Email Failed ! please enter valid email id";
                    }

                    $this->session->set_flashdata('msg', $mess);
                    return redirect('Signup');
                }
            }
        } else {
            echo show_404();
        }
    }

    private function sendCurl($contact, $sms_otp) {

        $apiKey = "Y42YATIo+DM-IQBU5F9rQnA2ZQaP4Nz9HxWAJui0R8";
        $test = 0;
        $sender = urlencode('SPTRDY');


        $message = rawurlencode("Welcome to paulsonsonline.com

you OTP for login is $sms_otp");
        $numbers = urlencode('91' . $contact);
// Prepare data for POST request
        $data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message . "&test=" . $test;

// Send the GET request with cURL
        $ch = curl_init('https://api.textlocal.in/send/?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response);
        return $res->status == "success" ? true : false;
// Process your response here
    }

    public function thanks() {
        $this->load->view('includes/head-sign');
        $this->load->view('thanks');
    }

    public function getCity() {
        $data = $this->security->xss_clean($this->input->post('state', TRUE));
        $state = ucfirst(strtolower($data));
        $stateArray = ($this->sign->getCity($state));
        if ($stateArray != NULL) {
            $city = "";
            foreach ($stateArray as $cities) {
                $city .= "<option value='$cities->city_name'>$cities->city_name</option>";
            }
            echo $city;
        } else {
            echo "<option value=''>Select City</option>";
        }
    }

}
