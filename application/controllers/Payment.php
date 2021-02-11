<?php

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('navigation');
    }

    public function index() {

        require APPPATH . 'vendor/autoload.php';

        $payubiz = new V3labs\PayUbiz\PayUbiz(array(
            'merchantId' => 'YOUR_MERCHANT_ID',
            'secretKey' => 'YOUR_SECRET_KEY',
            'testMode' => true
        ));

        // All of these parameters are required!
        $params = [
            'txnid' => 'A_UNIQUE_TRANSACTION_ID',
            'amount' => 10.50,
            'productinfo' => 'A book',
            'firstname' => 'Peter',
            'email' => 'abc@example.com',
            'phone' => '1234567890',
            'surl' => 'http://localhost/payubiz-php/return.php',
            'furl' => 'http://localhost/payubiz-php/return.php',
        ];

        // Redirects to PayUbiz
        $client->initializePurchase($params)->send();
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
