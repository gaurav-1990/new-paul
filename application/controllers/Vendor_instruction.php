<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_instruction extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('navigation');
        $this->load->library('encryption');
        $this->load->helper('checkout');
        $this->load->model('User_model', 'user');
    }

    public function index() {
       
        
        $this->load->view('includes/header', array('navbar' => loadnavigation()));
        $this->load->view('vendor-instruction');
        $this->load->view('includes/footer');
    }

}

?>