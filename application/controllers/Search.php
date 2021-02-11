<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->library('encryption');
        $this->load->helper('navigation');
        $this->load->helper('checkout');
        $this->load->model('Signup_model', 'sign');
        $this->load->library("pagination");
    }

    
    public function index()
    {


        if ($this->input->get("term") != NULL) {
            $value = $this->security->xss_clean($this->input->get('term'),$start = 0, $rangeq = 20);

            $this->load->view("includes/header");

            $property = $this->user->load_property();

            $config = array();
            $config["base_url"] = current_url();
            $total_row = count($this->user->getProListCount($value,$this->input->get()));
            $config["total_rows"] = $total_row;
            $config["per_page"] = 32;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 2;
            $config['reuse_query_string'] = TRUE;
            $config["enable_query_strings"] = TRUE;
            $config["page_query_string"] = TRUE;
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
            $config['next_link'] = '<i class="fa fa-chevron-right"></i>';
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['query_string_segment'] = 'page';
            $this->pagination->initialize($config);

            if ($this->input->get("page") && $this->input->get("page") > 1) {
                $page = ((int)$this->security->xss_clean($this->input->get("page")) - 1) * $config["per_page"];
            } else {
                $page = 0;
            }

            $str_links = $this->pagination->create_links();

            $data =  $this->user->getProList($value, $page, $config["per_page"], $this->input->get());

            if (count($data) > 0) {
            $this->load->view("searchProduct", ["products" =>  $data,'totalC'=>$total_row,'propertyName' => $property,"link"=>$str_links]);
            }else{
                $this->load->view('searchProduct', array('products' => NULL,'totalC'=>$total_row,"link"=>$str_links));
            }
            $this->load->view("includes/footer");
        } else {
            show_404();
        }
    }
}
