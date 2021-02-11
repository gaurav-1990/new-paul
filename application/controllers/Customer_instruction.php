<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_instruction extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('navigation');
        $this->load->helper('checkout');
        $this->load->library('encryption');
        $this->load->model('User_model', 'user');
    }

    public function index() {
       
        
        $this->load->view('includes/header', array('navbar' => loadnavigation()));
           $this->load->view('customer-instruction');
        $this->load->view('includes/footer');
    }

}

?>