<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    private $_webUser = 'alotcars_webapi';
    private $_password = 'M4S5wyDXvJyr';
    private $_language = 'en-gb';
    public $detect;

    public function __construct() {
        parent::__construct();
        $this->load->helper('arriscode');
        $this->load->helper('checkout');
        $this->load->library('encryption');
        $this->load->model('Api_model', 'api');
        $this->load->library('Mobile_Detect');

        $this->detect = new Mobile_Detect();
        if ($this->session->userdata('lang') == '') {
            $this->lang->load('header', 'en');
            $this->lang->load('footer', 'en');
        } else {
            $this->lang->load('header', $this->session->userdata('lang'));
            $this->lang->load('footer', $this->session->userdata('lang'));
        }
    }

    public function setSession($post) {


        if ($post == 'vehicleResult') {
            $postData = $this->api->getRequestResponse($this->session->userdata('api_session'));
            $requst = $this->decodeJson($this->decodeJson($postData[0]->api_request));
            $requst->lang = $this->_language;
            $post_req = $this->convertInJson($requst);
            $response = $this->getAvailablityResponse($post_req);

            $this->api->updatelang($this->decodeJson($response), $this->session->userdata('api_session'));
        } elseif ($post == 'registration') {


            $data = $this->api->registrationPageData($this->session->userdata('api_session'));

            $userresponse = json_decode($data[0]->user_response)->package->rateReference;


            $params = $this->convertInJson(array('rateReference' => $userresponse, 'lang' => $this->_language));
            $url = 'https://api.carrentalgateway.com/web/rate-rules';
            $response = $this->curlPost($url, $params);
            if ($response) {
                $arr = json_decode($response);
                if ($arr->terms) {
                    unset($arr->terms);
                }
                $this->api->langReg($this->session->userdata('api_session'), $this->convertInJson($arr));
            }
        }
    }

    private function getTitle() {
        $url = 'https://api.carrentalgateway.com/web/titles';
        $result = $this->curlGet($url);
        return $response = $this->decodeJson($result);
    }

    public function Book() {
        if (!$this->session->userdata('api_session')) {
            return redirect();
        }
        $this->changeLanguage($this->session->userdata('lang'));
        $post_array = $this->input->post();
        $ref = $post_array['ref_id'];
        $lang = $this->_language;
        $params = $this->convertInJson(array('rateReference' => $ref, 'lang' => $lang));
        $url = 'https://api.carrentalgateway.com/web/rate-rules';
        $response = $this->curlPost($url, $params);

        $arr = json_decode($this->input->post('data'));
        if ($arr->terms) {
            unset($arr->terms);
        }
        $query = $this->api->resgistration($this->session->userdata('api_session'), $this->convertInJson($arr));
        if ($query) {
            return redirect($this->session->userdata('lang') . '/registration/form');
        } else {
            echo show_404();
        }
    }

    public function form() {
        if (!$this->session->userdata('api_session')) {
            return redirect();
        }


        $this->load->helper('arriscode');


        $this->changeLanguage($this->uri->segment(1));
        $ref = $this->uri->segment(4);
        $lang = $this->_language;
        $this->lang->load('result', $this->uri->segment(1));
        $params = $this->convertInJson(array('rateReference' => $ref, 'lang' => $lang));
        $url = 'https://api.carrentalgateway.com/web/rate-rules';
        $response = $this->curlPost($url, $params);
        $userresponse = json_decode($response);

        $request = $this->api->onlyRequest($this->session->userdata('api_session'));

        if (!$this->detect->isMobile() || $this->detect->isTablet()) {

            $this->load->view('includes/header', array('title' => 'Please choose one result', "lockcurrency" => json_decode($request->api_response)->paymentCurrency));
            $this->load->view('selectcar', array('response' => $userresponse, 'request' => $request, 'title' => $this->getTitle(), 'residence' => $this->getLocation()));
            $this->load->view('includes/footer');
        } else {
            $this->load->view('mobile/includes/header', array('title' => 'Please choose one result', "lockcurrency" => json_decode($request->api_response)->paymentCurrency));
            $this->load->view('mobile/selectcar', array('response' => $userresponse, 'request' => $request, 'title' => $this->getTitle(), 'residence' => $this->getLocation()));
            $this->load->view('mobile/includes/footer');
        }
        if ($userresponse->terms) {
            unset($userresponse->terms);
        }
        $query = $this->api->resgistration($this->session->userdata('api_session'), $this->convertInJson($userresponse));
    }

    private function getLocation() {
        $url = 'https://api.carrentalgateway.com/web/residence-countries';
        $result = $this->curlGet($url);
        return $response = $this->decodeJson($result);
    }

    private function changeLanguage($lang) {
        switch ($lang) {
            case "en":
                $this->session->set_userdata('lang', 'en');
                $this->_language = 'en-gb';
                break;
            case "ar":
                $this->session->set_userdata('lang', 'ar');
                $this->_language = 'ar-sa';
                break;
            case "es":
                $this->session->set_userdata('lang', 'es');
                $this->_language = 'es-es';
                break;
            case "fr":
                $this->session->set_userdata('lang', 'fr');
                $this->_language = 'fr-fr';
                break;
            case "it":
                $this->session->set_userdata('lang', 'it');
                $this->_language = 'it-it';
                break;
            case "ja":
                $this->session->set_userdata('lang', 'ja');
                $this->_language = 'ja-jp';
                break;
            case "nl":
                $this->session->set_userdata('lang', 'nl');
                $this->_language = 'nl-nl';
                break;
            case "pl":
                $this->session->set_userdata('lang', 'pl');
                $this->_language = 'pl-pl';
                break;
            case "pt":
                $this->session->set_userdata('lang', 'pt');
                $this->_language = 'pt-pt';
                break;
            case "ru":
                $this->session->set_userdata('lang', 'ru');
                $this->_language = 'ru-ru';
                break;
            case "cn":
                $this->session->set_userdata('lang', 'cn');
                $this->_language = 'zh-cn';
                break;
            case "tr":
                $this->session->set_userdata('lang', 'tr');
                $this->_language = 'tr-tr';
                break;
            default :
                $this->session->set_userdata('lang', 'en');
                $this->_language = 'en-gb';
        }
        if ($this->session->userdata('lang') == '') {
            $this->lang->load('header', 'en');
            $this->lang->load('footer', 'en');
        } else {
            $this->lang->load('header', $this->session->userdata('lang'));
            $this->lang->load('footer', $this->session->userdata('lang'));
        }

        $this->setSession($this->uri->segment(2));
    }

    private function convertInJson($response) {
        return json_encode($response);
    }

    private function decodeJson($response) {
        return json_decode($response);
    }

    private function setHeader() {
        return array('Content-Type: application/json');
    }

    public function curlGet($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->_webUser:$this->_password");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->setHeader());
        $server_output = curl_exec($ch);
        curl_close($ch);

        return $server_output;
    }

    private function curlPost($url, $parms) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->_webUser:$this->_password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->setHeader());
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parms);
        $server_output = curl_exec($ch);
        curl_close($ch);
        return $server_output;
    }

}
