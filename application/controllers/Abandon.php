<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Abandon extends CI_Controller
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
    }

    public function index()
    {
        $user = $this->user->getLogoutUsers();
        // echo "<pre>";
        // print_r($user);
        // die;
    }
}
?>