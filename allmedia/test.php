<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Signup_model', 'sign');
    }

    public function index() {
        $state = $this->sign->loadState();

        $this->load->view('includes/head-sign');
        $this->load->view('signup', array('state' => $state));
        $this->output->cache(2);
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

    public function registrationStep() {

        if ($this->input->post()) {
            $data = $this->security->xss_clean($this->input->post(NULL, TRUE));
            $query = $this->sign->registration($data);
            $to_email = $this->input->post('email', TRUE);
            $subject = "Registration " . date("Y-m-d H:i");
            $message = "Dear " . $this->input->post('fname');
            $message .= "<br><p>Welcome to  emiclub.in, We are happy to have you as a member of our community.<br>
Your email address and intrest preferences have been recorded in our database</p>
<p>We will send you the login credentials on this email within some days.</p>";


            if ($query) {
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtpout.secureserver.net',
                    'smtp_port' => 465,
                    'smtp_user' => 'info@emiclub.in',
                    'smtp_pass' => 'Kanak@123',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('info@emiclub.in', 'EMI Club');
                $this->email->to($to_email);
                $this->email->bcc(array("shantanumaurya6@gmail.com", "kk381989@gmail.com"));

                $this->email->subject($subject);
                $this->email->message($message);
                $result = $this->email->send();
                if ($this->input->post()) {
                    return redirect('Signup/thanks');
                } else {
                    return redirect('Signup');
                }
//            echo $this->email->print_debugger();
            }
        } else {
            echo show_404();
        }
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
