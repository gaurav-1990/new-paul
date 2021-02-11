<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
        if (!$this->detect->isMobile() || $this->detect->isTablet()) {
            $base_url = base_url() . "assets/images/logo.png";
            $html = <<<EOD
                    <div id="page-loader">
            <div class="page-loader__logo">
                <img src="$base_url" alt="Alotcars">
            </div> 

            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
            </div> 
        </div>
EOD;
        }
    }

    public function getLanguage() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="my"');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        } else {
            if ($_SERVER['PHP_AUTH_USER'] === "pawan" && $_SERVER['PHP_AUTH_PW'] === 'appMe') {
                if ($this->session->userdata('lang') !== NULL) {
                    echo json_encode(array("lang" => $this->session->userdata('lang')));
                } else {
                    echo json_encode(array("lang" => "en"));
                }
            } else {
                header('WWW-Authenticate: Basic realm="my"');
                header('HTTP/1.0 401 Unauthorized');
                exit;
            }
        }
    }

    public function loadingText() {
        $this->lang->load('result', $this->session->userdata('lang'));
        $text = array("loading" => $this->lang->line('loadingTxt'), "selectCity" => $this->lang->line('selectCity'), "selectLoc" => $this->lang->line('selectLoc'), "searchingTxt" => $this->lang->line('searchingTxt'), "bookNow" => $this->lang->line('bookNow'), "save_later" => $this->lang->line('save_later'), "rental" => $this->lang->line('rental'), "sending_email" => $this->lang->line('sending_email'), "doors" => $this->lang->line('doors'), "filter" => $this->lang->line('filter'), "close" => $this->lang->line('close'));
        echo json_encode($text);
    }

    public function setCountry() {
        $this->session->set_userdata('country', $this->input->post('country'));

        if ($this->session->userdata('setC') == NULL) {
            $all_cur = file_get_contents(base_url() . "assets/source/currency.json");
            $all_cur = json_decode($all_cur);
            foreach ($all_cur as $key => $val) {
                if ($key == $this->input->post('country')) {
                    $this->session->set_userdata('currency', $val);
                    $this->session->set_userdata('setC', "1");
                    echo $val;
                }
            }
        } else {
            $all_cur = file_get_contents(base_url() . "assets/source/currency.json");
            $all_cur = json_decode($all_cur);

            foreach ($all_cur as $key => $val) {
                if ($val == $this->session->userdata('currency')) {
                    echo $val;
                    break;
                }
            }
        }
    }

    public function getQuote() {
        $ref_id = $this->input->post('ref_id');
        $this->lang->load('result', $this->session->userdata('lang'));
        $params = $this->convertInJson(array('rateReference' => $ref_id, 'lang' => $this->_language));
        $url = 'https://api.carrentalgateway.com/web/rate-rules';
        $response = $this->decodeJson($this->curlPost($url, $params));
        $car_url = base_url('assets/images/no-car.png');
        if (isset($response->vehicle->images[0]->url)) {
            $car_url = str_replace("small", "large", $response->vehicle->images[0]->url);
        }
        $small = isset($response->vehicle->smallSuitcases) ? $response->vehicle->smallSuitcases : 0;
        $big = isset($response->vehicle->bigSuitcases) ? $response->vehicle->bigSuitcases : 0;
        $doors = isset($response->vehicle->doors) ? $response->vehicle->doors : $this->lang->line('noin');
        $airco = isset($response->vehicle->airco) ? ( $response->vehicle->airco == 0 ? $this->lang->line('no') : $this->lang->line('yes')) : $this->lang->line('no');
        $manual = isset($response->vehicle->transmission) ? $response->vehicle->transmission : $this->lang->line('manual');
        $supplier_logo = str_replace("small", "large", $response->branches->{$response->pickUpBranchId}->supplier->images[0]->url);
        $supplier = $response->branches->{$response->pickUpBranchId}->supplier->name;
        $paynow = round(($this->session->userdata('rate') != '' ? floatval($response->package->payments->payNow->vehicle->payment->amount) * floatval($this->session->userdata('rate')) : $response->package->payments->payNow->vehicle->payment->amount), 2);
        $currency = $this->session->userdata('rate') != '' ? $this->session->userdata('to') : $response->package->payments->payNow->total->payment->currency;
        $logo_url = base_url() . "assets/images/logo.png";
        $estimatedTotal = round(($this->session->userdata('rate') != '' ? floatval($response->package->payments->estimatedTotal->total->payment->amount) * floatval($this->session->userdata('rate')) : $response->package->payments->estimatedTotal->total->payment->amount), 2);
        echo $html = <<<EOD
                <div class="car-pop">
                <div class="row">
                <div class="col-sm-12 col-md-6 car-pop-name">
		<div class="box-title"> <h2><b>{$response->vehicle->name}</b></h2>  </div>
                <img src="{$car_url}" alt="Alotcars">
                        
                        
                </div>
                <div class="col-sm-12 col-md-6 car-pop-side">
                    <div class="feture-part">
						    <ul>
							<li title="seats">
							    <span class="men">

							    </span>
							    {$response->vehicle->seats}x
							</li>
							<li title="small bags">
							    <span class="small-bag">

							    </span>
							    {$small}x
							</li>
							<li title="big bags">
							    <span class="bag">

							    </span>
							    {$big}x
							</li>
							<li title="doors">
							    <span class="door">

							    </span>
							    {$doors}
							</li>
							<li title="aircondition">
							    <span class="ac">

							    </span>
							    {$airco}
								</li>
							<li title="transmission">
							    <span class="trns">

							    </span>
							    {$manual}
							   </li>
						    </ul>
						</div>
						<div class="car-pc">
						<span><i class="far fa-credit-card"></i> {$this->lang->line('deposit')}: <strong> {$currency}  {$paynow} </strong></span>  
						<span><i class="fas fa-wallet"></i> {$this->lang->line('total_pay')}: <strong>{$currency}  {$estimatedTotal} </strong> </span>  
						</div>
						<div class="rental-cost">
						<img src="{$supplier_logo}" alt="$supplier">
						 <p>{$this->lang->line('totalRental')}
						<span> <br/> {$currency}  {$estimatedTotal} <span>                     
						</p>
						</div>
						</div>
						</div>
					    </div>
					    <div class="email-form">
					    <div class="row">
					    <div class="col-sm-8   col-xs-8 form-group">
					    <label>{$this->lang->line('email_me')}</label>
					    <input type="email" id="email_quote" class="form-control" required  autocomplete="off" placeholder="{$this->lang->line('email')}" >
					    </div>   
	    					    <div class="col-sm-4   col-xs-4 form-group">
		    				         <button data-ref="$ref_id" class="quote_button"> {$this->lang->line('sendQuote')} </button> 
					            </div>
					           </div>
					    </div>
                
                
                
                    
              
                
		
		
		
EOD;
    }

    public function sendQuote() {
        $ref_id = $this->input->post('ref_id');
        $this->lang->load('result', $this->session->userdata('lang'));
        $params = $this->convertInJson(array('rateReference' => $ref_id, 'lang' => $this->_language));
        $url = 'https://api.carrentalgateway.com/web/rate-rules';
        $response = $this->decodeJson($this->curlPost($url, $params));
        if ($response) {
            $base = base_url();
            $small = isset($response->vehicle->smallSuitcases) ? $response->vehicle->smallSuitcases : 0;
            $big = isset($response->vehicle->bigSuitcases) ? $response->vehicle->bigSuitcases : 0;
            $doors = isset($response->vehicle->doors) ? $response->vehicle->doors : $this->lang->line('noin');
            $airco = isset($response->vehicle->airco) ? ( $response->vehicle->airco == 0 ? $this->lang->line('no') : $this->lang->line('yes')) : $this->lang->line('no');
            $manual = isset($response->vehicle->transmission) ? $response->vehicle->transmission : $this->lang->line('manual');
            $supplier_logo = str_replace("small", "large", $response->branches->{$response->pickUpBranchId}->supplier->images[0]->url);
            $supplier = $response->branches->{$response->pickUpBranchId}->supplier->name;
            $paynow = round(($this->session->userdata('rate') != '' ? floatval($response->package->payments->payNow->vehicle->payment->amount) * floatval($this->session->userdata('rate')) : $response->package->payments->payNow->vehicle->payment->amount), 2);
            $car_url = base_url('assets/images/no-car.png');
            $currency = $this->session->userdata('rate') != '' ? $this->session->userdata('to') : $response->package->payments->payNow->total->payment->currency;
            $estimatedTotal = round(($this->session->userdata('rate') != '' ? floatval($response->package->payments->estimatedTotal->total->payment->amount) * floatval($this->session->userdata('rate')) : $response->package->payments->estimatedTotal->total->payment->amount), 2);

            if (isset($response->vehicle->images[0]->url)) {
                $car_url = str_replace("small", "large", $response->vehicle->images[0]->url);
            }

            $message = <<<EOD
		<html>
    <head>
        <title>Alotcars : Quote</title>
        <meta charset="UTF-8">
        
    </head>  <body style=" padding: 0;  height: auto;  width: 100%;  margin: 0; font-family: sans-serif;">
		      <div style="  width: 648px; margin: 0 auto; background-color: #e1fafd;  ">
		      <div style="  padding: 21px 31px;  background-color: #0077a4; text-align: center; color: #fff; ">
		      <h2 style="padding: 0;margin: 0;font-size: 33px;">Quote for your trip to Downtown</h2>
                      <p>Prices can <strong>RISE.</strong> Book now to secure your quote price.</p>
		    </div>
		     <div style=" overflow: hidden;">
		     <div style="text-align: center;float: left;width: 294px;">
                <h2 style=" margin: 0; padding-top: 35px;">{$response->vehicle->name}</h2>
                   <img src="$car_url" alt="" style="width: 72%;">
            </div>
		<div style=" float: left; width: 291px;">
		    <ul style="  width: 100%;  padding: 11px 7px; overflow:  hidden; margin-right: auto;  margin-left: auto;  float: left;">
		 <li style="list-style-type: none;text-align: center;float: left;line-height: 23px;">
                 <i style="background: url(https://www.alotcars.com/assets/images/person.png) no-repeat;padding: 5px 12px;"></i><br> {$response->vehicle->seats}x 
		 </li>
		  <li  style="list-style-type: none;text-align: center;float: left;line-height: 23px;">
                        <i style="background: url(https://www.alotcars.com/assets/images/small-bag.png) no-repeat;padding: 1px 16px;"></i><br>
                         {$small}x
                   </li>
		 <li style="list-style-type: none;text-align: center;float: left;line-height: 23px;">
                        <i style="background: url(https://www.alotcars.com/assets/images/bag.png) no-repeat;padding: 5px 16px;"></i><br>
                       {$big}x
                  </li>
		  <li style="list-style-type: none;text-align: center;float: left;line-height: 23px;">
                        <i style="background: url(https://www.alotcars.com/assets/images/door.png) no-repeat;padding: 5px 16px;"></i><br>
                         {$doors}x
                   </li>
			 <li style="list-style-type: none;text-align: center;float: left;line-height: 23px;">
                        <i style="background: url(https://www.alotcars.com/assets/images/ac.png) no-repeat;padding: 5px 16px;"></i><br>
                         {$airco}
                    </li>
                    <li style="list-style-type: none;text-align: center;float: left;line-height: 23px;">
                        <i style="background: url(https://www.alotcars.com/assets/images/menu.png) no-repeat;padding: 5px 16px;"></i><br>
                         {$manual}
                    </li>
		 </ul>
		<div style="  width: 270px;  margin: 0 auto;  overflow: hidden; text-align: center;">
		    <ul style="  margin: 0;  overflow: hidden;padding:0 ">
        <li style="  float: left; list-style-type: none; margin-left: 20px;  "> <img src="https://www.alotcars.com/assets/images/card.png" alt="">  </li>
		     <li style="  float: left;  padding: 8px 0px; list-style-type: none;  "> Deposit: <strong>{$currency}  {$paynow}</strong>  </li>
		      </ul>
		      <ul style="  margin: 0;  padding: 0;  ">
                        <li style=" float: left;  list-style-type: none;  ">
                            <img src="https://www.alotcars.com/assets/images/wall.png" alt=""> 
                        </li>
                        <li style=" float: left;  padding: 8px 0px; list-style-type: none;  overflow: hidden;   ">
                            Total payment: <strong>{$currency}  {$estimatedTotal}</strong>
                        </li>
                    </ul>
                 </div>
			      </div>
                
                
                
            </div>
	          <div >
			     <ul style="  margin: 0;  padding: 0;  overflow: hidden; border-top: #000 1px solid; margin-top: 18px;">
			       <li style="  list-style-type: none;  float: left;  text-align: center;  width: 300px;">
                             <img src="{$supplier_logo}" alt="{$supplier}" style="width: 49%; padding: 16px 0px;">
			       </li>
			 <li style="  list-style-type: none;   text-align: center;  float: left;  padding: 12px 0px;  width:312px; ">
                            <p style=" margin:0;padding: 7px 0px;">Total rental cost </p>
                            <span style="  font-size: 28px;  ">{$currency}  {$estimatedTotal}</span>
                        </li>
			 <li style="  text-align: center;list-style: none;    width: 100%;clear: both; padding: 23px 0px;">
			    <a style="border: none; font-size: 20px; padding: 10px 46px; background-color: #0494fb; color: #fff;" href="{$base}{$this->session->userdata('lang')}/Home/getBook?req_id={$this->session->userdata('api_session')}&ref_id={$ref_id}">Book Now</a>
                        </li>
			        </ul> 
				    </div>
					</div>   
			    
EOD;
            $email = $this->input->post('email');
            //$query = $this->api->getDetail($data);
            $subject = "Alotcars: Qoute " . date("Y-m-d H:i");

//	    if ($query) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'dev@nibblesoftware.com',
                'smtp_pass' => 'dev@nibble',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('dev@nibblesoftware.com', 'Alotcars');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message);

            //print_debugger();
            if ($this->email->send()) {
                echo "Mail sent successfully";
            } else {
                print_r($this->email->print_debugger(), true);
            }
        }
    }

    public function setCancellation() {
        if ($this->input->post('confirmation')) {
            $confirmation = $this->input->post('confirmation');
            //$query = $this->api->getDetail($data);
            $subject = "Cancellation Request " . date("Y-m-d H:i");
            $message = "Dear Team,";
            $message .= "<br><p>Request you to cancel following request the Confirmation no is: $confirmation</p>";
//	    if ($query) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://alotcars.com',
                'smtp_port' => 465,
                'smtp_user' => 'dev@alotcars.com',
                'smtp_pass' => 'Hello@123#',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('dev@alotcars.com', 'Alotcars');
            $this->email->to("dev@alotcars.com");
            $this->email->subject($subject);
            $this->email->message($message);
            $result = $this->email->send();
            echo "Mail sent successfully";
        } else {
            show_404();
        }
    }

    public function myBooking() {
        $this->changeLanguage($this->uri->segment(1));
        $this->lang->load('registration', $this->uri->segment(1));
        $this->load->view('includes/header');
        $this->load->view('myBooking');
        $this->load->view('includes/footer');
    }

    public function join() {

        if ($this->input->post('company_name') && $this->input->post('fname') && $this->input->post('email') && $this->input->post('contact')) {

            //$query = $this->api->getDetail($data);
            $subject = "Join Us Query " . date("Y-m-d H:i");
            $message = "Hi Alotcars,";
            $message .= "<br><p> <b>" . $this->input->post('fname') . " " . $this->input->post('lname') . "</b>: Wants to join Alotcars.com</p>";

            $message .= "Here are the details  <br>";

            $message .= "<b>Company Name : </b>" . $this->input->post('company_name') . "<br>";
            $message .= "<b>First Name : </b>" . $this->input->post('fname') . "<br>";
            $message .= "<b>Last Name : </b>" . $this->input->post('lname') . "<br>";
            $message .= "<b>Email : </b>" . $this->input->post('email') . "<br>";
            $message .= "<b>Contact Number : </b>" . $this->input->post('contact') . "<br>";
            $message .= "<b>Website : </b>" . $this->input->post('website') . "<br>";
            $message .= "<b>Country : </b>" . $this->input->post('country') . "<br>";
            $message .= "<b>Vehicle Type : </b>" . $this->input->post('vehicle_type') . "<br>";
            $message .= "<b>No of Vehicle   : </b>" . $this->input->post('vehicle_count') . "<br>";
            $message .= "<b>Ages  : </b>" . $this->input->post('ages') . "<br>";
            $message .= "<b>5 main locations you operate in  : </b>" . $this->input->post('location_five') . "<br>";
            $message .= "<b>Address: </b>" . $this->input->post('address') . "<br>";


//	    if ($query) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://alotcars.com',
                'smtp_port' => 465,
                'smtp_user' => 'dev@alotcars.com',
                'smtp_pass' => 'Hello@123#',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('dev@alotcars.com', 'Alotcars');
            $this->email->to("dev@alotcars.com");
            $this->email->subject($subject);
            $this->email->message($message);
            if ($this->email->send()) {
                echo "<script>alert('Your query has been recieved successfully');</script>";
                echo "<script>window.location.href='" . base_url() . $this->session->userdata('lang') . "/Join-us'</script>";
            } else {
                echo "<script>alert('Mailed Failed');</script>";
                echo "<script>window.location.href='" . base_url() . $this->session->userdata('lang') . "/Join-us'</script>";
            }
        } else {
            show_404();
        }
    }

    public function contact_us_mail() {

        if ($this->input->post('name') && $this->input->post('email') && $this->input->post('contact_no') && $this->input->post('reservation')) {
            $confirmation = $this->input->post('confirmation');
            //$query = $this->api->getDetail($data);
            $subject = "Contact Us Query " . date("Y-m-d H:i");
            $message = "Hi Alotcars,";
            $message .= "<br><p> <b>Reservation number</b>: " . $this->input->post('reservation') . "</p>";
            $contact_for = "";
            switch ($this->input->post('optradio')) {
                case "general_info":
                    $contact_for = "General Information";
                    break;
                case "cancellation":
                    $contact_for = "Cancellation";
                    break;
                case "changes":
                    $contact_for = "Modification";
                    break;
                case "other":
                    $contact_for = "Other Reason";
                    break;
            }
            $message .= "Wants  to contact you for " . $contact_for . "<br>";
            $message .= "Please find the information and his/her query" . "<br>";
            $message .= "<b>Name : </b>" . $this->input->post('name') . "<br>";
            $message .= "<b>Email : </b>" . $this->input->post('email') . "<br>";
            $message .= "<b>Contact Number : </b>" . $this->input->post('contact_no') . "<br>";
            $message .= "<b>Reservation Number : </b>" . $this->input->post('reservation') . "<br>";
            $message .= "<b>Message: </b>" . $this->input->post('message') . "<br>";
            $to = array();
            if ($this->input->post('send_copy')) {
                $to[] = $this->input->post('email');
            }
//	    if ($query) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://alotcars.com',
                'smtp_port' => 465,
                'smtp_user' => 'dev@alotcars.com',
                'smtp_pass' => 'Hello@123#',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('dev@alotcars.com', 'Alotcars');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            if ($this->email->send()) {
                echo "<script>alert('Mailed Successfully');</script>";
                echo "<script>window.location.href='" . base_url() . $this->session->userdata('lang') . "/Contact'</script>";
            } else {
                echo "<script>alert('Mailed Failed');</script>";
                echo "<script>window.location.href='" . base_url() . $this->session->userdata('lang') . "/Contact'</script>";
            }
        } else {
            show_404();
        }
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
        $this->setSession($this->uri->segment(3));
    }

    public function manageBooking() {
        $this->changeLanguage($this->uri->segment(1));
        if ($this->input->post('reg_no') && (strlen($this->input->post('reg_no')) == 8) && $this->input->post('email_alot') != '') {
            $reg_no = $this->input->post('reg_no');
            $email_alot = $this->input->post('email_alot');
            $response = $this->api->locateBooking($reg_no, $email_alot);
            if ($response) {
                $url = 'https://api.carrentalgateway.com/web/bookings/' . $reg_no . '?accessToken=' . $this->decodeJson($response[0]->response)->accessToken . "&vehicleImageSizes=Large&lang=" . $this->_language . "";
                $curl_response = $this->curlGet($url);
                $this->lang->load('home', $this->session->userdata('lang'));
                $this->lang->load('result', $this->session->userdata('lang'));
                if ($curl_response) {
                    if (!$this->detect->isMobile() || $this->detect->isTablet()) {
                        $this->load->view('includes/header');
                        $this->load->view('manage', array('all_response' => $this->decodeJson($curl_response), 'response' => $this->decodeJson($response[0]->response)));
                        $this->load->view('includes/footer');
                    } else {
                        $this->load->view('mobile/includes/header');
                        $this->load->view('mobile/manage', array('all_response' => $this->decodeJson($curl_response), 'response' => $this->decodeJson($response[0]->response)));
                        $this->load->view('mobile/includes/footer');
                    }
                }
            } else {
                echo "<script>alert('No record found')</script>";
                echo "<script>window.location.href='" . base_url() . "'</script>";
            }
        } else {
            echo "<script>alert('Please enter valid registration number')</script>";
            echo "<script>window.location.href='" . base_url() . "'</script>";
        }
    }

    public function index() {

        if (!$this->detect->isMobile() || $this->detect->isTablet()) {
            $this->changeLanguage($this->uri->segment(1));
            $this->lang->load('home', $this->session->userdata('lang'));
            $this->load->view('includes/header');
            $this->load->view('Home', array('age' => $this->allDriverAge(), 'location' => $this->getLocation(), 'allCountry' => $this->getAllCountry()));
            $this->load->view('includes/footer');
        } else {
            $this->changeLanguage($this->uri->segment(1));
            $this->load->view('mobile/includes/header');
            $this->lang->load('home', $this->session->userdata('lang'));
            $this->load->view('mobile/Home', array('age' => $this->allDriverAge(), 'location' => $this->getLocation(), 'allCountry' => $this->getAllCountry()));
            $this->load->view('mobile/includes/footer');
        }
    }

    public function changeInValidTimeStamp($date, $time) {
        $date = DateTime::createFromFormat('d-M-Y', $date)->format('Y-m-d') . "T" . $time . ":00";
        return $date;
    }

    public function deleteSession() {
        session_destroy();
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

    public function setCurrencyInner() {
        if ($this->input->post()) {
            print_r($this->input->post());
            $page = $this->input->post('page');
            $from = $this->input->post('changefrom');
            $to = $this->input->post('changeto');
            $currency = $this->input->post('currency');
            $this->session->set_userdata('currency', $currency);
            $this->session->set_userdata('setC', '1');
            $result = $this->curlGet("https://api.carrentalgateway.com/web/exchange-rates?query=$from:$to");
            $result = json_decode($result);
            $this->session->set_userdata('from', $result->rates[0]->from);
            $this->session->set_userdata('to', $result->rates[0]->to);
            $this->session->set_userdata('rate', $result->rates[0]->rate);
            echo $this->session->userdata('from');
            echo $this->session->userdata('to');
            echo $this->session->userdata('rate');
        } else {
            echo show_404();
        }
    }

    public function getLoadedCurrency() {
        if ($this->session->userdata('to') != '') {
            echo json_encode(array("to" => $this->session->userdata('to'), "rate" => $this->session->userdata('rate')));
        } else {
            echo FALSE;
        }
    }

    public function getAllResults() {
        if ($this->input->post()) {
            $this->lang->load('result', $this->session->userdata('lang'));
            $driver_age = $this->encryption->decrypt(decode($this->input->post('_driverage_')));
            $pickup = $this->input->post('pickup');
            $drop = $this->input->post('drop');
            $post_search = $this->convertInJson($this->input->post());
            $_first_ = $this->encryption->decrypt(decode($this->input->post('_first_')));
            $_residence_ = "GB";


            $_second_ = $this->encryption->decrypt(decode($this->input->post('_second_')));
            if ($this->session->userdata('currency') != '') {
                $_residence_ = $this->input->post('_residence_');
            }
            $pickUp = $this->changeInValidTimeStamp($this->input->post('pikupdate'), $this->input->post('pikuptime'));
            $dropOff = $this->changeInValidTimeStamp($this->input->post('dropdate'), $this->input->post('droptime'));

            if (!$this->input->post('_return_')) {
                $post = array('driverAge' => $driver_age, 'pickBranch' => $_first_, 'dropBranch' => $_second_, "pickDate" => $pickUp, 'dropDate' => $dropOff, 'recidence' => $_residence_);
            } else {
                $post = array('driverAge' => $driver_age, 'pickBranch' => $_first_, 'dropBranch' => $_first_, "pickDate" => $pickUp, 'dropDate' => $dropOff, 'recidence' => $_residence_);
            }
            $params = $this->createRequest($post);

            $response = $this->getAvailablityResponse($params);
            $response2 = $this->decodeJson($response);

            if (!$this->session->userdata('api_session')) {
                $this->createSession();

                $this->api->saveRequestResponse($this->session->userdata('api_session'), $params, $response2, $post_search);
            } else {
                $this->api->uploadRequestResponse($this->session->userdata('api_session'), $params, $response2, $post_search);
            }

            $id = encode($this->encryption->encrypt(($this->api->getRequestResponse($this->session->userdata('api_session')[0]->id))));
            //encode($this->encryption->encrypt(($data->id)))
            return redirect($this->session->userdata('lang') . '/Vehicle/result/' . $id);
        } else {
            return redirect();
        }
    }

    public function demo() {
        $this->load->view('demo');
    }

    public function getCountriesData() {
        $pickCountry = $this->input->post('PickCountry');
        $PickCity = $this->input->post('PickCity');
        $PickLocation = $this->input->post('PickLocation');
        echo getOneCountries($pickCountry);
    }

    public function getCities() {
        $pickCountry = $this->input->post('PickCountry');
        $PickCity = $this->input->post('PickCity');
        $PickLocation = $this->input->post('PickLocation');
        echo getOneCity($PickCity, $pickCountry);
    }

    public function getLocations() {
        $pickCountry = $this->input->post('PickCountry');
        $PickCity = $this->input->post('PickCity');
        $PickLocation = $this->input->post('PickLocation');
        echo getOneLocation($PickLocation, $PickCity);
    }

    public function getDCountriesData() {
        $pickCountry = $this->input->post('DropCountry');
        $PickCity = $this->input->post('DropCity');
        $PickLocation = $this->input->post('DropLocation');
        echo getOneCountries($pickCountry);
    }

    public function getDCities() {
        $pickCountry = $this->input->post('DropCountry');
        $PickCity = $this->input->post('DropCity');
        $PickLocation = $this->input->post('DropLocation');
        echo getOneCity($PickCity, $pickCountry);
    }

    public function getDLocations() {
        $pickCountry = $this->input->post('DropCountry');
        $PickCity = $this->input->post('DropCity');
        $PickLocation = $this->input->post('DropLocation');
        echo getOneLocation($PickLocation, $PickCity);
    }

    public function vehicleResult() {
        $this->changeLanguage($this->uri->segment(1));
        $this->lang->load('result', $this->session->userdata('lang'));
        if (!$this->session->userdata('api_session')) {
            return redirect();
        }
        $this->load->helper('arriscode');
        if (!$this->detect->isMobile() || $this->detect->isTablet()) {
            $this->load->view('includes/header', array('title' => 'Please choose one result'));
            $response = $this->api->getRequestResponse($this->session->userdata('api_session'));
            $this->load->view('result', array('result' => $this->decodeJson($response[0]->api_response), "request" => $this->decodeJson($this->decodeJson($response[0]->api_request)), "postrequest" => $this->decodeJson($response[0]->post_request), 'age' => $this->allDriverAge(), 'location' => $this->getLocation()));
            $this->load->view('includes/footer');
        } else {
            $this->load->view('mobile/includes/header', array('title' => 'Please choose one result'));
            $response = $this->api->getRequestResponse($this->session->userdata('api_session'));
            $this->load->view('mobile/result', array('result' => $this->decodeJson($response[0]->api_response), "request" => $this->decodeJson($this->decodeJson($response[0]->api_request)), "postrequest" => $this->decodeJson($response[0]->post_request), 'age' => $this->allDriverAge(), 'location' => $this->getLocation()));
            $this->load->view('mobile/includes/footer');
        }
    }

    private function createSession() {
        $rand = encode($this->encryption->encrypt((mt_rand(0, 99999999))));   //encode($this->encryption->encrypt(($data->id)))
        $this->session->set_userdata('api_session', $rand);
    }

    private function getAvailablityResponse($post) {

        return $response = $this->curlPost('https://api.carrentalgateway.com/web/availability', $post);
    }

    public function makeBooking() {


        if (!$this->session->userdata('api_session')) {
            return redirect();
        }
        $rateReference = addslashes($this->input->post('rateReference'));
        $titleId = addslashes($this->input->post('title'));
        $firstName = addslashes($this->input->post('fname'));
        $lastName = addslashes($this->input->post('lname'));
        $userEmail = addslashes($this->input->post('userEmail'));
        $contactNumberCode = addslashes($this->input->post('contactNumberCode'));
        $comments = !empty($this->input->post('comments')) ? addslashes($this->input->post('comments')) : "No_comments";
        $contactNumber = addslashes($this->input->post('contactNumber'));
//	$dob_day = sprintf('%02d', $this->input->post('dob_day'));
//	$dob_month = sprintf('%02d', $this->input->post('dob_month'));
//	$dob_year = $this->input->post('dob_year');
        $flightNumber = $this->input->post('flightNumber') ? addslashes($this->input->post('flightNumber')) : "";
        $cardnumber = addslashes($this->input->post('cardnumber'));
        $cardholder = addslashes($this->input->post('cardholder'));
        $cvv2 = addslashes($this->input->post('cvv2'));
        $exp_month = sprintf('%02d', $this->input->post('exp_month'));
        $exp_year = addslashes($this->input->post('exp_year'));
        $extras = array();
        if ($this->input->post('extras')) {
            foreach ($this->input->post('extras') as $ex) {
                $dr = explode('_', $ex);
                if ((int) $dr[1] > 0) {
                    $code = str_replace("-", ".", $dr[2]);
                    $extras[] = array('code' => "$code", 'quantity' => (int) $dr[1]);
                }
            }
        }

        if ($flightNumber != '') {
            $bookingRequest = array('rateReference' => $rateReference, 'lang' => $this->_language, "comments" => $comments, 'type' => 'Booking', 'customer' => array('titleId' => (int) $titleId, 'firstName' => $firstName, 'lastName' => $lastName, 'email' => $userEmail, 'phone' => $contactNumberCode . $contactNumber), 'flightNumber' => $flightNumber, 'payment' => array('method' => 'CreditCard', 'creditCard' => array('number' => $cardnumber, 'cvv' => $cvv2, 'holder' => $cardholder, 'expiration' => $exp_year . "-" . $exp_month)), 'extras' => $extras);
//	    $bookingRequest = array('rateReference' => $rateReference, 'lang' => $this->_language, 'type' => 'Booking', 'customer' => array('titleId' => (int) $titleId, 'firstName' => $firstName, 'lastName' => $lastName, 'email' => $userEmail, 'phone' => $contactNumberCode . $contactNumber, 'birthDate' => $dob_year . '-' . $dob_month . '-' . $dob_day), 'flightNumber' => $flightNumber, 'payment' => array('method' => 'CreditCard', 'creditCard' => array('number' => $cardnumber, 'cvv' => $cvv2, 'holder' => $cardholder, 'expiration' => $exp_year . "-" . $exp_month)), 'extras' => $extras);
        } else {
            $bookingRequest = array('rateReference' => $rateReference, 'lang' => $this->_language, "comments" => $comments, 'type' => 'Booking', 'customer' => array('titleId' => (int) $titleId, 'firstName' => $firstName, 'lastName' => $lastName, 'email' => $userEmail, 'phone' => $contactNumberCode . $contactNumber), 'payment' => array('method' => 'CreditCard', 'creditCard' => array('number' => $cardnumber, 'cvv' => $cvv2, 'holder' => $cardholder, 'expiration' => $exp_year . "-" . $exp_month)), 'extras' => $extras);
//	    $bookingRequest = array('rateReference' => $rateReference, 'lang' => $this->_language, 'type' => 'Booking', 'customer' => array('titleId' => (int) $titleId, 'firstName' => $firstName, 'lastName' => $lastName, 'email' => $userEmail, 'phone' => $contactNumberCode . $contactNumber, 'birthDate' => $dob_year . '-' . $dob_month . '-' . $dob_day), 'payment' => array('method' => 'CreditCard', 'creditCard' => array('number' => $cardnumber, 'cvv' => $cvv2, 'holder' => $cardholder, 'expiration' => $exp_year . "-" . $exp_month)), 'extras' => $extras);
        }
        $parms = $this->convertInJson($bookingRequest);
        $url = 'https://api.carrentalgateway.com/web/bookings';
        $response = $this->curlPost($url, $parms);
        $decodeResponse = $this->decodeJson($response);

        if (isset($decodeResponse->reservNum)) {
            $user_id = "";
            if ($this->session->userdata('user_profile')) {
                $user_id = $this->session->userdata('user_profile')->user_id;
            }
            $query = $this->api->saveBooking($response, $this->session->userdata('api_session'), $userEmail, $user_id);
            if ($query != 0) {
                $this->session->sess_destroy();
                return redirect($this->session->userdata('lang') . '/Home/bookingAccepted/' . encode($this->encryption->encrypt(($query))));
            } else {
                return redirect($this->session->userdata('lang') . '/Home/bookingRejected');
            }
        } else {
            $errorResponse = $decodeResponse->details[0]->property ? "Please enter valid " . $decodeResponse->details[0]->property : "Please enter valid details Ex: <b>Flight Number</b>";
            $html = <<<EOD
             <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong> Error ! </strong> 
	            $errorResponse
             </div>
EOD;
            $this->session->set_flashdata('error', $html);
            return redirect($this->session->userdata('lang') . '/SecurePay/makePayment');
        }
    }

    public function bookingAccepted() {
        $query = $this->uri->segment('4');
        if ($query != NULL) {
            $this->lang->load('result', $this->uri->segment('1'));
            $this->load->view('thanksPage');
        } else {
            echo show_404();
        }
    }

    public function bookingRejected() {
        
    }

    private function createRequest($data) {

        $request = [];
        if ($data['dropBranch'] != '') {
            $request = array('lang' => $this->_language, 'source' => $this->_webUser, 'pickUp' => array('dateTime' => $data['pickDate'], 'location' => array("id" => (int) $data['pickBranch'])), 'dropOff' => array('dateTime' => $data['dropDate'], 'location' => array("id" => (int) $data['dropBranch'])), 'driverAge' => (int) $data['driverAge'], 'residenceCountry' => array('code' => $data['recidence']));
        } else {
            $request = array('lang' => $this->_language, 'source' => $this->_webUser, 'pickUp' => array('dateTime' => $data['pickDate'], 'location' => array("id" => (int) $data['pickBranch'])), 'dropOff' => array('dateTime' => $data['dropDate'], 'location' => array("id" => (int) $data['pickBranch'])), 'driverAge' => (int) $data['driverAge'], 'residenceCountry' => array('code' => $data['recidence']));
        }
        $request_json = json_encode($request);

        return $request_json;
    }

    public function allDriverAge() {
        $age = '';
        $i = 18;
        while ($i <= 80) {
            $encode = encode($this->encryption->encrypt(($i)));
            if ($i != 65) {
                $age .= "<li data-value='$encode'>$i</li>";
            } else {
                $age .= "<li data-value='$encode'>25-65</li>";
            }
            $i++;
        }
        return $age;
    }

    public function getTermsConditions() {
        if ($this->input->post()) {
            $this->changeLanguage($this->session->userdata('lang'));
            $this->lang->load('result', $this->session->userdata('lang'));
            $post_array = $this->input->post();
            $ref = $post_array['ref_id'];

            $params = $this->convertInJson(array('rateReference' => $ref, 'lang' => $this->_language));

            $url = 'https://api.carrentalgateway.com/web/rate-rules';
            $response = $this->decodeJson($this->curlPost($url, $params));

            $html = '';


            if (isset($response->terms->full->gateway->sections)) {
                foreach ($response->terms->full->gateway->sections as $ht) {
                    $html .= "<h3>" . $ht->title . "</h3> " . $ht->content;
                }
            } elseif (isset($response->terms->full->custom->sections)) {
                foreach ($response->terms->full->custom->sections as $ht) {
                    $html .= "<h3>" . $ht->title . "</h3> " . $ht->content;
                }
            } else {
                $html = "<h3>" . $this->lang->line('no_re') . "</h3>";
            }
            echo $html;
        } else {
            return redirect();
        }
    }

    public function getIncludeOptions() {
        $this->lang->load('result', $this->session->userdata('lang'));
        $post_array = $this->input->post();
        $ref = $post_array['ref_id'];
        $lang = $post_array['lang'];
        $params = $this->convertInJson(array('rateReference' => $ref, 'lang' => $lang));

        $url = 'https://api.carrentalgateway.com/web/rate-rules';
        $response = $this->decodeJson($this->curlPost($url, $params));

        $html = '';
        if ($response) {

            $html .= '<h2>' . $this->lang->line('we_give') . '</h2>  <ul>';

            foreach ($response->package->inclusions as $inclusions) {
                $description = addslashes($inclusions->description);
                $html .= <<<EOD
                  <div class="more-feture"> <li  title="{$description}">  $inclusions->name   </li>
EOD;
            }
            $html .= '</ul></div>';
        } else {
            $html = "<h3>" . $this->lang->line('no_re') . "</h3>";
        }
        echo $html;
    }

    public function getPackages() {
        
    }

    public function getQuotePackages() {
        $this->changeLanguage($this->session->userdata('lang'));
        $post_array = $this->input->post();

        $ref = $post_array['ref_id'];
        $lang = $this->_language;
        $params = $this->convertInJson(array('rateReference' => $ref, 'lang' => $lang));
        $url = 'https://api.carrentalgateway.com/web/rate-rules';
        $response = $this->curlPost($url, $params);
        echo $response;
    }

    public function getCity() {
            
        $this->changeLanguage($this->session->userdata('lang'));
        $country = $this->input->post('country_id');
        $url = "https://api.carrentalgateway.com/web/cities?lang=" . $this->_language;
        $this->lang->load('result', $this->session->userdata('lang'));
        $cities[] = $this->decodeJson($this->curlGet($url));
        if ($cities[0]->nextPointer) {
            $url = 'https://api.carrentalgateway.com/web/cities?lang=' . $this->_language . '&pointer=' . $cities[0]->nextPointer;
            $cities[] = $this->decodeJson($this->curlGet($url));
        }

        $ci = "";
        $cit = array();
        foreach ($cities as $cityDa) {
            foreach ($cityDa->cities as $city) {
                if ($city->country->id == $country) {
                    $cit[] = array("id" => $city->city->id, "name" => $city->city->name);
                }
            }
        }
        $ci .= "<option value=''>" . $this->lang->line('selectCity') . "</option>";
        foreach ($cit as $c) {
            $ci .= "<option value='$c[id]'>$c[name]</option>";
        }
        echo $ci;
    }

    public function searchCity() {

        $this->changeLanguage($this->session->userdata('lang'));
        $this->lang->load('result', $this->session->userdata('lang'));
        $sttr = ($this->input->post('term'));
        $url = 'https://api.carrentalgateway.com/web/locations?lang=' . $this->_language;
        $result[] = $this->decodeJson($this->curlGet($url));
        if ($result[0]->nextPointer) {
            $url = 'https://api.carrentalgateway.com/web/locations?lang=' . $this->_language . '&pointer=' . $result[0]->nextPointer;
            $result[] = $this->decodeJson($this->curlGet($url));
        }
        if ($result[1]->nextPointer) {
            $url = 'https://api.carrentalgateway.com/web/locations?lang=' . $this->_language . '&pointer=' . $result[1]->nextPointer;
            $result[] = $this->decodeJson($this->curlGet($url));
        }

        $loca = array();
        foreach ($result as $rs) {
            foreach ($rs->locations as $locations) {
                if ($locations->city->id == $sttr) {
                    $class = "image-build-class";
                    if ($locations->location->isAirport == "yes") {
                        $class = "image-air-class";
                    } elseif ($locations->location->isRailway == "yes") {
                        $class = "image-train-class";
                    } elseif ($locations->location->isPort == "yes") {
                        $class = "image-ship-class";
                    }
                    $loca[] = array('id' => encode($this->encryption->encrypt(($locations->location->id))), 'name' => $locations->location->name, 'class' => $class);
                }
            }
        }


        $htm = "";
        if (count($loca) != 1) {
            $htm .= "<option value=''>" . $this->lang->line('selectLoc') . "</option>";
        }
        foreach ($loca as $cityInfo) {
            if (count($loca) == 1) {
                $htm .= "<option  class='$cityInfo[class]' selected value='$cityInfo[id]'>{$cityInfo["name"] } </option>";
            } else {
                $htm .= "<option  class='$cityInfo[class]'   value='$cityInfo[id]'>{$cityInfo["name"] } </option>";
            }
        }
        echo $htm;
    }

    public function getBook() {

        $params = $this->convertInJson(array('rateReference' => $this->input->get('ref_id'), 'lang' => $this->_language));
        $url = 'https://api.carrentalgateway.com/web/rate-rules';
        $rs = $this->api->is_session($this->input->get('req_id'));
        if ($rs == true) {
            $this->session->set_userdata('api_session', $this->input->get('req_id'));
            return redirect($this->session->userdata('lang') . '/Registration/form/' . $this->input->get('ref_id'));
        } else {
            return redirect();
        }
    }

    private function getTitle() {
        $url = 'https://api.carrentalgateway.com/web/titles';
        $result = $this->curlGet($url);
        return $response = $this->decodeJson($result);
    }

    public function registration() {
        $this->changeLanguage($this->uri->segment(1));
        $this->lang->load('result', $this->session->userdata('lang'));
        if (!$this->session->userdata('api_session')) {
            return redirect();
        }
        $this->load->helper('arriscode');
        $data = $this->api->registrationPageData($this->session->userdata('api_session'));
        $userresponse = json_decode($data[0]->user_response);
        $request = $this->api->onlyRequest($this->session->userdata('api_session'));

        if (!$this->detect->isMobile() || $this->detect->isTablet()) {

            $this->load->view('includes/header', array('title' => 'Please choose one result'));
            $this->load->view('selectcar', array('response' => $userresponse, 'request' => $request, 'title' => $this->getTitle(), 'residence' => $this->getLocation()));
            $this->load->view('includes/footer');
        } else {
            $this->load->view('mobile/includes/header', array('title' => 'Please choose one result'));
            $this->load->view('mobile/selectcar', array('response' => $userresponse, 'request' => $request, 'title' => $this->getTitle(), 'residence' => $this->getLocation()));
            $this->load->view('mobile/includes/footer');
        }
    }

    private function getAllCountry() {
        $this->changeLanguage($this->uri->segment(1));
        $url = "https://api.carrentalgateway.com/web/countries?lang=" . $this->_language;
        $country = $this->decodeJson($this->curlGet($url));
        $country = $country->countries;
        $countries = "";
        foreach ($country as $co) {
            $countries .= <<<EOD
      <option value=$co->id>$co->name</option>
EOD;
        }
        return $countries;
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

    private function getLocation() {
        $url = 'https://api.carrentalgateway.com/web/residence-countries?lang=' . $this->_language;
        $result = $this->curlGet($url);
        return $response = $this->decodeJson($result);
    }

    private function getRemoteIp() {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strlen($_SERVER['HTTP_X_FORWARDED_FOR']) > 0) {
            $ip = array_map('trim', explode(',', (string) $_SERVER['HTTP_X_FORWARDED_FOR']));
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = array_map('trim', explode(',', (string) $_SERVER['REMOTE_ADDR']));
            }
        }
        return isset($ip[0]) ? $ip[0] : $ip;
    }

    private function getTrackingData() {
        return array(
            'browser' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'ip' => getRemoteIp(),
            'source' => isset($_COOKIE['tf_source']) ? $_COOKIE['tf_source'] : '',
            'session_id' => ''
        );
    }

}
