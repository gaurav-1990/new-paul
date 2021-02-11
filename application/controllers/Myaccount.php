<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Myaccount extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('google');
        $this->load->model('User_model', 'user');
        $this->load->library('encryption');
        $this->load->helper('navigation');
        $this->load->library('facebook');
        $this->load->helper('checkout');
        $this->load->helper('getinfo');
        $this->load->model('Signup_model', 'sign');
    }

    private function addToWishListByURL($url)
    {
        $id = $this->user->getUserIdByEmail();
        $pid = $_GET['id'];
        // $product = $this->encryption->decrypt(decode($this->input->get("id")));
        $product = $this->encryption->decrypt(decode($pid));

        //$this->encryption->decrypt(decode($this->uri->segment(3)))
        $data = $this->user->getProduct($product);
        $total = $data->dis_price != "" ? $data->dis_price : $data->act_price;
        return $returnData = $this->user->insertIntoWish($product, null, null, $total, $id);
        // echo "<script>alert('Item added to wishlist');</script>";
    }

    private function addToWishListforSignup($pid)
    {
        $id = $this->user->getUserIdByEmail();
        // $product = $this->encryption->decrypt(decode($pid));
        // echo "<br>".$product;
        $data = $this->user->getProduct($pid);
        
        $total = $data->dis_price != "" ? $data->dis_price : $data->act_price;
        return $returnData = $this->user->insertIntoWish($pid, null, null, $total, $id);
    }

    public function index()
    {
        if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {

            return redirect('Myaccount/dashboard');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('login[username]', 'Username', 'required|valid_email');
        $this->form_validation->set_rules('login[password]', 'Password', 'required|min_length[6]');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        $fbUrl = $_SERVER['QUERY_STRING'];

        if ($this->input->get("Step") == '' && isset($fbUrl) && $fbUrl != null) {
            $data['user'] = array();
            if ($this->facebook->is_authenticated()) {
                $user = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');

                if (!isset($user['error'])) {
                    $data['user'] = $user;
                }
                $this->db->cache_delete_all();
                $getUser = $this->user->get_User($data['user']['id']);

                if (count($getUser) > 0) {

                    if ($getUser[0]->user_email == null) {
                        $app_id = $getUser[0]->app_id;
                        $this->session->set_userdata('app_id', $app_id);
                        $username = '';
                    } else {
                        $username = $getUser[0]->user_email;
                        $this->session->set_userdata('myaccount', $username);
                    }

                    if ($this->input->get("Step") === 'wish') {
                        $referred_from = $this->session->userdata('referred_from');
                        $this->addToWishListByURL($referred_from);
                        return redirect('Dashboard');
                        // return redirect($referred_from, "refresh");
                    }

                    if ($this->input->get("Step") === 'checkout') {
                        return redirect('Checkout');
                    } else if ($this->input->get("Step") === 'subscription') {
                        return redirect('Prime');
                    } else {
                        return redirect('Myaccount/dashboard'); //
                    }
                } else {
                    $userID = $this->user->facebookRegistration($data);
                    $user = $this->user->get_profile_id($userID);

                    if ($user->user_email == null) {
                        $app_id = $user->app_id;
                        $this->session->set_userdata('app_id', $app_id);
                        $username = '';
                    } else {
                        $username = $user->user_email;
                        $this->session->set_userdata('myaccount', $username);
                    }
                    if ($this->input->get("Step") === 'wish') {
                        $referred_from = $this->session->userdata('referred_from');

                        $this->addToWishListByURL($referred_from);
                        return redirect($referred_from, "refresh");
                    }

                    if ($this->input->get("Step") === 'checkout') {
                        return redirect('Checkout');
                    } else if ($this->input->get("Step") === 'subscription') {

                        return redirect('Prime');
                    } else {
                        return redirect('Myaccount/dashboard');   //
                    }
                    //return redirect('Myaccount/dashboard');
                }
            }
        } else {

            //$data['google_login_url'] = $this->google->get_login_url();
            $data['google_login_url'] = $this->googleplus->loginURL();

            if ($this->form_validation->run() == false) {
                $this->load->view('includes/header-profile');
                $this->load->view('Myaccount', $data);
                $this->load->view('includes/footer');
            } else {

                $username = $this->security->xss_clean($this->input->post('login[username]'));
                $passo = $this->security->xss_clean($this->input->post('login[password]'));
                $password = $this->user->get_profile($username);

                if ($password && $password->block != 1) {
                    if (password_verify($passo, $password->user_password)) {
                        $this->session->set_userdata('myaccount', $username);
                        $this->db->cache_delete_all();
                        $dbCart = [];
                        $getUsercart = $this->user->userCart($password->user_email);

                        $dbCart = json_decode($getUsercart->product);

                        // echo "<pre>";
                        // print_r($dbCart);
                        // echo "<br><br><br>";
                        foreach ($dbCart as $k => $se) {

                            if ($se->product == 'false') {

                                unset($dbCart[$k]);
                            }
                        }

                        $dbCart = array_values($dbCart);

                        $sessionCart = $this->session->userdata('addToCart');
                        foreach ($sessionCart as $key => $arr) {

                            $help = checkcartItem($dbCart, $arr['product'], $arr['qty']);
                            if ($help != -1) {
                                $dbCart[$help]->qty = $arr["qty"];
                            } else {
                                array_push($dbCart, json_decode(json_encode($arr)));
                            }
                        }
                        $cart = $dbCart;

                        if ($cart != null) {
                            $updatedCart = json_decode(json_encode(($cart)), true);

                            $this->session->set_userdata('addToCart', $updatedCart);
                            $user_session = $this->session->userdata('myaccount');
                            $cart_detail = json_encode($updatedCart);
                            $this->user->addTocartsession($user_session, $cart_detail);
                        }

                        if ($this->input->get("Step") === 'wish') {

                            $referred_from = $this->session->userdata('referred_from');

                            $this->addToWishListByURL($referred_from);
                            return redirect($referred_from, "refresh");
                        }
                        if ($this->input->get("Step") === 'checkout') {
                            return redirect('Checkout');
                        } else if ($this->input->get("Step") === 'subscription') {
                            return redirect('Prime');
                        } else {
                            return redirect('Dashboard'); //Myaccount/
                        }
                    } else {
                        $this->session->set_flashdata('msg', '<div class="text-danger">Wrong Credentials,Please Enter Valid One</div>');
                        return redirect('Myaccount');
                    }
                } else if ($password && $password->block != 0) {
                    $this->session->set_flashdata('msg', '<div class="text-danger">You are blocked by the Admin.</div>');
                    return redirect('Myaccount');
                } else {
                    $this->session->set_flashdata('msg', '<div class="text-danger">Wrong Credentials,Please Enter Valid One</div>');
                    return redirect('Myaccount');
                }
            }
        }
    }

    public function oauth2callback()
    {
        if (isset($_GET['code'])) {
            $this->googleplus->getAuthenticate();
            $this->session->set_userdata('login', true);
            $this->session->set_userdata('userProfile', $this->googleplus->getUserInfo());
            $session_data = $this->googleplus->getUserInfo();
            $this->db->cache_delete_all();
            $getUser = $this->user->get_UserByEmail($session_data['email']);
            if (count($getUser) > 0) {
                $this->session->set_userdata('myaccount', $session_data['email']);

                if ($this->input->get("Step") === 'wish') {
                    $referred_from = $this->session->userdata('referred_from');
                    $this->addToWishListByURL($referred_from);
                    return redirect($referred_from, "refresh");
                }
                if ($this->input->get("Step") === 'checkout') {
                    return redirect('Checkout');
                } else {
                    return redirect('Myaccount/dashboard');
                }
            } else {
                $result = $this->user->googleregistration($session_data);
                $gdata["fullname"] = $session_data['name'];
                $gdata["username"] = $session_data['email'];
                $this->newUserRegistration($gdata);
                if ($result) {
                    $this->session->set_userdata('myaccount', $session_data['email']);
                    if ($this->input->get("Step") === 'wish') {
                        $referred_from = $this->session->userdata('referred_from');
                        $this->addToWishListByURL($referred_from);
                        return redirect($referred_from, "refresh");
                    }
                    if ($this->input->get("Step") === 'checkout') {
                        return redirect('Checkout');
                    } else {
                        return redirect('Myaccount/dashboard');
                    }
                } else {
                    echo 'registration failed';
                }
            }

            // $userInfo = $this->user->get_UserForGoogle($user);
        }
    }

    // public function oauth2callback()
    // {
    //     echo "dgfdfjgdfklhjdflsghjlgh";
    //     die;
    //     require_once 'vendor/autoload.php';
    //     $this->config->load('google_config');

    //     $client = new Google_Client();
    //     $client->setClientId($this->config->item("google_client_id"));
    //     $client->setClientSecret($this->config->item("google_client_secret"));
    //     $client->setRedirectUri($this->config->item("google_redirect_url"));
    //     $client->addScope("email");
    //     $client->addScope("profile");

    //     if (isset($_GET['code'])) {
    //         try {
    //             $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    //             $client->setAccessToken($token['access_token']);
    //         } catch (Exception $g) {
    //             print_r($g->getMessage());
    //             echo "<script>window.history.go(-1);</script>";
    //         }
    //         // get profile info
    //         $google_oauth = new Google_Service_Oauth2($client);
    //         $google_account_info = $google_oauth->userinfo->get();
    //         //$this->db->cache_delete('Admin', 'SadminLogin');
    //         $session_data = array(
    //             'oauth_uid' => $google_account_info->id,
    //             'fname' => $google_account_info->name,
    //             'email' => $google_account_info->email,
    //             'oauth_provider' => 'google',
    //         );

    //         $getUser = $this->Usr_reg_model->get_UserByEmail($session_data['email']);

    //         //$this->db->cache_delete('Admin', 'SadminLogin');

    //         if (count($getUser) > 0) {
    //             $this->session->set_userdata('user_id', $getUser[0]->id);
    //         } else {
    //             $result = $this->Usr_reg_model->googleregistration($session_data);
    //             //$this->db->cache_delete('Admin', 'SadminLogin');

    //             if ($result) {
    //                 $this->session->set_userdata('user_id', $result);
    //             }
    //         }
    //         return redirect('Myaccount');
    //     } else {
    //         echo "<script>window.location.href='{$client->createAuthUrl()}'</script>";
    //     }
    // }

    public function trackOrder()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(3)));
        if ($id > 0) {
            $data = $this->user->getAwb($id);

            $this->load->view('includes/header', array('navbar' => loadnavigation()));
            $awb = $this->trackOrderCurl($data[0]->awb_no);

            $this->load->view('trackOrder', array('awb' => $awb));
            $this->load->view('includes/footer');
        } else {
            echo show_404();
        }
    }

    public function getInvoice()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(3)));
        if ($id > 0) {
            $data = $this->user->allOrdersOrderId($id);
            if (count($data) > 0) {
                $this->load->view('userInvoice', array('data' => $data[0]));
            } else {
                die("No Information");
            }
        } else {
            echo show_404();
        }
    }

    public function logout()
    {
        $user = $this->session->userdata('myaccount');
        // $this->user->updateCartTime($user);
        $this->abandoncartMail($user);
        $this->session->unset_userdata('referred_from');
        $this->session->unset_userdata('fb_access_token');
        $this->session->unset_userdata('app_id');
        $this->session->unset_userdata('myaccount');
        $this->session->unset_userdata('addToCart');
        redirect();
    }

    public function dashboard()
    {
        $this->session->unset_userdata("txnid");
        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount');
        }

        if ($this->session->userdata('myaccount') != null) {
            $email = $this->session->userdata('myaccount');
        } else {
            $email = $this->session->userdata('app_id');
        }
        $user = $this->user->get_profile($email);

        $this->db->cache_delete("Myaccount", "dashboard");
        $this->load->view('includes/header-profile', array('navbar' => loadnavigation()));
        $this->load->view('myaccount_dashboard', array('user' => $user));
        $this->load->view('includes/footer');
    }

    public function orderDetails()
    {
        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount/dashboard');
        }
        $this->db->cache_delete("Myaccount/orderDetails");
        $this->load->view('includes/header-profile', array('navbar' => loadnavigation()));
        $shipping = $this->user->getShipping();
        $order = $this->user->getCustomerOrder();
        $this->load->view('order_details', array('order' => $order, "shipping" => $shipping));
        $this->load->view('includes/footer');
    }

    public function viewSpecificOrder()
    {
        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount/dashboard');
        }
        $this->load->view('includes/header-profile', array('navbar' => loadnavigation()));
        $id = $this->encryption->decrypt(decode($this->uri->segment(3)));
        $shipping = $this->user->getShipping();
        $order = $this->user->allCustomerOrders($id);

        $this->load->view('view_SpecificOrder', array('order' => $order, "shipping" => $shipping));
        $this->load->view('includes/footer');
    }

    public function orderReturn()
    {
        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount/dashboard');
        }
        $id = $this->input->post("order_id");
        $oder = $this->user->allCustomerOrders2($this->input->post("order_id"));

        $html = '';
        $html .= <<<EOD
		<div class="order-return prod-return">
			<div class="return-head">
				<div class="row">
					<div class="col-md-6 col-xs-6">
						<div class="order-id">

							<b> ORDER NO </b> : 10000$id </div>
					</div>

				</div>

			</div>
EOD;
        foreach ($oder as $oDetails) {
            $exp_del = date("d M D,Y", strtotime($oDetails->pay_date . "+3 days"));
            $size = ucfirst($oDetails->order_prop);
            $dis = floatval($oDetails->act_price) - floatval($oDetails->pro_price);
            $img = $this->user->getProductImage($oDetails->pro_id);
            //    print_r($img); die;
            $url = base_url("uploads/resized/resized_") . $img;
            $html .= <<<EOD

			<ul>
				<li>
					<div class="row">
					<div class="col-md-2 col-xs-3 col-sm-3">
					<div class="img-set">
						<img src="$url" alt="ICON">
					</div>
				</div>
						<div class="col-md-10 col-xs-9 col-sm-9">
							<div class="product-detail">

								<div class="pro-name">$oDetails->pro_name</div>

								<span class="pro-size">$size :
								$oDetails->order_attr | </span>
                                <span class="pro-qty">Qty: $oDetails->pro_qty </span>
								<div>
								<span class="pro-price"><i class="fa fa-inr" aria-hidden="true"></i>
								$oDetails->pro_price</span>
							<span class="pro-price-cut"><i class="fa fa-inr"
									aria-hidden="true"></i> $oDetails->act_price</span>
							<span class="pro-price-save">Saved <i class="fa fa-inr"
									aria-hidden="true"></i>
									$dis </span>
								</div>

								<span class="pro-delivered">
									<b>Delivery expected</b>
									($exp_del)
								</span>

							</div>
						</div>
					</div>

				</li>


			</ul>

			<div class="note-set">
				<!-- <b>Please Note:</b> Your return has been processed successfully. Please check your email for refund details. -->

			</div>
		</div>

EOD;
        }
        $url = base_url() . "Myaccount/productReturn";
        $this->session->flashdata('msg');

        $html .= <<<EOD
		<div class="return-prs">

	<form method="POST" action="$url" enctype="multipart/form-data">
		<div class="form-group">
		<input type='hidden' value='$id' name='data'>
			<label for="">Why are you returning this?</label>
			<select class="form-control" name='condition'>
				<option value="Accidental Order">Accidental Order</option>
				<option value="Better Price Available">Better Price Available</option>
				<option value="Missing parts or accessories">Missing parts or accessories</option>
				<option value="Damaged During Delivery">Damaged During Delivery</option>
			</select>
		</div>
		<div class="form-group">
			<label for=""> Damage Product Image</label>
			<input type="file" name="image">
		</div>
		<div class="form-group">
			<label for="">Add Comment</label>
			<textarea class="form-control" name='comment' rows="3"></textarea>
		</div>

         <p>Get Refund</p>
		  <div class="form-group">
			<input type ="radio" name="account"  value="1" onclick="addAccountDetails(this)" >
			<label for="">Account</label>

			<input type ="radio" name="account" onclick="$('#account_details').remove();" style="margin-left:50px;" value="2" checked>
			<label for="">paulsons Wallet</label>

           </div>




		<div class="form-group">
		<div class="row">

		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="button" onclick='location.reload(true);' class="cancel-bt changeCancle">
					Cancel
				</button>
			</div>
		</div>
		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="submit" class="save-bt changePass">
					Return
				</button>
			</div>
		</div>




	</div>
		</div>
		</form>
	</div>

EOD;
        echo $html;
    }

    public function orderReturnPrime()
    {
        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount/dashboard');
        }
        $id = $this->input->post("order_id");
        $oder = $this->user->allCustomerOrders2($this->input->post("order_id"));

        $html = '';
        $html .= <<<EOD
		<div class="order-return prod-return">
			<div class="return-head">
				<div class="row">
					<div class="col-md-6 col-xs-6">
						<div class="order-id">

							<b> ORDER NO </b> : 10000$id </div>
					</div>

				</div>

			</div>
EOD;
        foreach ($oder as $oDetails) {
            $exp_del = date("d M D,Y", strtotime($oDetails->pay_date . "+3 days"));
            $size = ucfirst($oDetails->order_prop);
            $dis = floatval($oDetails->act_price) - floatval($oDetails->pro_price);
            $img = $this->user->getProductImage($oDetails->pro_id);
            //    print_r($img); die;
            $url = base_url("uploads/resized/resized_") . $img;
            $html .= <<<EOD

			<ul>
				<li>
					<div class="row">
					<div class="col-md-2 col-xs-3 col-sm-3">
					<div class="img-set">
						<img src="$url" alt="ICON">
					</div>
				</div>
						<div class="col-md-10 col-xs-9 col-sm-9">
							<div class="product-detail">

								<div class="pro-name">$oDetails->pro_name</div>

								<span class="pro-size">$size :
								$oDetails->order_attr | </span>
                                <span class="pro-qty">Qty: $oDetails->pro_qty </span>
								<div>
								<span class="pro-price"><i class="fa fa-inr" aria-hidden="true"></i>
								$oDetails->pro_price</span>
							<span class="pro-price-cut"><i class="fa fa-inr"
									aria-hidden="true"></i> $oDetails->act_price</span>
							<span class="pro-price-save">Saved <i class="fa fa-inr"
									aria-hidden="true"></i>
									$dis </span>
								</div>

								<span class="pro-delivered">
									<b>Delivery expected</b>
									($exp_del)
								</span>

							</div>
						</div>
					</div>

				</li>


			</ul>

			<div class="note-set">
				<!-- <b>Please Note:</b> Your return has been processed successefully. Please check your email for refund details. -->

			</div>
		</div>

EOD;
        }
        $url = base_url() . "Myaccount/productReturnPrime";
        $this->session->flashdata('msg');

        $html .= <<<EOD
		<div class="return-prs">

	<form method="POST" action="$url" enctype="multipart/form-data">
		<div class="form-group">
		<input type='hidden' value='$id' name='data'>
			<label for="">Why are you returning this?</label>
			<select class="form-control" name='condition'>
				<option value="Accidental Order">Accidental Order</option>
				<option value="Better Price Available">Better Price Available</option>
				<option value="Missing parts or accessories">Missing parts or accessories</option>
				<option value="Damaged During Delivery">Damaged During Delivery</option>
			</select>
		</div>
		<div class="form-group">
			<label for=""> Damage Product Image</label>
			<input type="file" name="image">
		</div>
		<div class="form-group">
			<label for="">Add Comment</label>
			<textarea class="form-control" name='comment' rows="3"></textarea>
		</div>

         <p>Get Refund</p>
		  <div class="form-group">
			<input type ="radio" name="account"   value="2" checked>
			<label for="">paulsons Wallet</label>
           </div>


		<div class="form-group">
		<div class="row">

		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="button" onclick='location.reload(true);' class="cancel-bt changeCancle">
					Cancel
				</button>
			</div>
		</div>
		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="submit" class="save-bt changePass">
					Return
				</button>
			</div>
		</div>




	</div>
		</div>
	</div>
	</form>
EOD;
        echo $html;
    }

    public function productReturn()
    {
        if ($this->input->post('data')) {
            $orderInfo = $this->user->OrderTable($this->input->post('data')); // GET UNIQUE ORDER DETAILS    .

            $date1 = date("Y-m-d H:i:s");
            $date2 = $orderInfo->delivery_date;
            $now = strtotime($date1);
            $your_date = strtotime($date2);
            $datediff = $now - $your_date;
            $diff = round($datediff / (60 * 60 * 24));
            $uid = $this->user->getUserIdByEmail();
            $userDetail = $this->user->get_profile_id($uid);
            /*Return policy is remaining same for both user (normal and prime) which is 30 days (discussed by paulsons team)
             *
             * */

            if ($diff <= 30) {
                $img = "";
                if ($_FILES["image"]["tmp_name"] != '') {
                    $config['upload_path'] = './return_image/';
                    $config['allowed_types'] = '*';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    // $this->upload->initialize($config);
                    if (!$this->upload->do_upload('image')) {
                        array($this->upload->display_errors());
                    } else {
                        $img = $this->upload->data('file_name');
                    }
                }
                $resp = $this->user->returnOrder($this->security->xss_clean($this->input->post()), $img);
                $this->returnOrderMailRequest($this->input->post('data'));

                $this->db->cache_delete_all();
                $string = " Credit will updated in wallet";
                if ($this->input->post('account') == 1) {
                    $string = " Credit will be reflected in your given account within some days";
                }
                if ($resp) {
                    $this->session->set_flashdata('msg', '<div class="alert alert-success "><b>Please Note:</b> Your return has been processed successfully. ' . $string . ' </div>');
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger "><b>Please Note:</b> Something went wrong </div>');
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger"><b>Please Note:</b> Your return request not processed . Please check return policy. </div>');
            }
            redirect('Myaccount/orderDetails');
        } else {
            show_404();
        }
    }

    private function returnOrderMailRequest($orderID)
    {
        $data = $this->user->allCustomerOrders2($orderID);
        $base = base_url();
        $baseurl = base_url("bootstrap/images/shipping.png");
        $subject = "Return order request: Order No:- 10000 " . $data[0]->order_id;
        $message = "";
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";

        $message .= "<tr><td  style='padding:8px;'>Return order number: 10000{$data[0]->order_id}</td></tr>";
        $message .= "<tr><td style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td><h3>A .Your Return item details</h3></td></tr>";
        $message .= "<tr><td >Order number : 10000{$data[0]->order_id}</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<table>";
        $image = getProductImage($data[0]->pro_id);
        $image = base_url("uploads/thumbs/thumb_" . $image);
        $discount = floatval($data[0]->act_price) - floatval($data[0]->pro_price);
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
        $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . "  </td></tr>";
        $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";

        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";
        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('support@paulsonsonline.com', 'paulsons.com');
        $this->email->to($data[0]->user_email);
        $this->email->bcc(array(EMAIL_BCC));
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    private function abandoncartMail($user)
    {
        $data = $this->user->get_UserByEmail($user);
        $getCart = $this->user->userCart($user);
        $base = base_url();

        if (!empty($getCart->product)) {

            $subject = "Hi, Your cart is missing you!!!!!!!";
            $message = "";
            $message .= "Dear {$data[0]->user_name} {$data[0]->lastname}<br>";
            $message .= "You have added Items in your cart, Please visit www.paulsons.com and complete the checkout process.<br><br><br><br>";
            $message .= "<b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a>";

            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('support@paulsonsonline.com', 'paulsons.com');
            $this->email->to($data[0]->user_email);
            $this->email->bcc(array(EMAIL_BCC));
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();
        }
    }

    public function productReturnPrime()
    {
        if ($this->input->post('data')) {

            $orderInfo = $this->user->OrderTable($this->input->post('data')); // GET UNIQUE ORDER DETAILS    .

            $date1 = date("Y-m-d H:i:s");
            $date2 = $orderInfo->delivery_date;
            $now = strtotime($date1);
            $your_date = strtotime($date2);
            $datediff = $now - $your_date;
            $diff = round($datediff / (60 * 60 * 24));
            $uid = $this->user->getUserIdByEmail();
            $userDetail = $this->user->get_profile_id($uid);

            /*
             * Return policy is remaining same for both user (normal and prime) which is 30 days (discussed by paulsons team)
             *
             */

            if ($userDetail->prime_sta == 1 && $diff <= 90) {

                $img = "";
                if ($_FILES["image"]["tmp_name"] != '') {
                    $config['upload_path'] = './return_image/';
                    $config['allowed_types'] = '*';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    // $this->upload->initialize($config);
                    if (!$this->upload->do_upload('image')) {
                        array($this->upload->display_errors());
                    } else {
                        $img = $this->upload->data('file_name');
                    }
                }

                $resp = $this->user->returnOrderPrime($this->security->xss_clean($this->input->post()), $img);
                $this->returnOrderMailRequest($this->input->post('data'));
                $this->db->cache_delete_all();
                $string = " Credit updated in wallet";

                if ($resp) {
                    $this->session->set_flashdata('msg', '<div class="alert alert-success"><b>Please Note:</b> Your return has been processed successfully. ' . $string . '</div>');
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger "><b>Please Note:</b> Something went wrong </div>');
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger"><b>Please Note:</b> Your return request not processed . Please check return policy. </div>');
            }
            redirect('Myaccount/orderDetails');
        } else {
            show_404();
        }
    }

    public function orderExchange()
    {
        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount/dashboard');
        }
        $id = $this->input->post("order_id");
        $oder = $this->user->allCustomerOrders2($this->input->post("order_id"));
        $html = '';
        $html .= <<<EOD
		<div class="order-return prod-return">
			<div class="return-head">
				<div class="row">
					<div class="col-md-6 col-xs-6">
						<div class="order-id">
							<b> ORDER NO </b> : 10000$id </div>
					</div>

				</div>

			</div>
EOD;
        $sizeOption = "";
        foreach ($oder as $oDetails) {
            $sizes = json_decode($oDetails->product_attr)->response;

            foreach ($sizes as $kru => $item) {

                if ($item->qty > 0) {
                    $ischecked = $item->attribute[0]->Size == $oDetails->order_attr ? "disabled" : "";
                    $sizeOption .= "<option value='{$item->attribute[0]->Size}' $ischecked>{$item->attribute[0]->Size}</option>";
                }
            }
            $exp_del = date("d M D,Y", strtotime($oDetails->pay_date . "+3 days"));
            $size = ucfirst($oDetails->order_prop);
            $dis = floatval($oDetails->act_price) - floatval($oDetails->pro_price);
            $img = $this->user->getProductImage($oDetails->pro_id);
            $url = base_url("uploads/resized/resized_") . $img;
            $html .= <<<EOD

			<ul>
				<li>
					<div class="row">
					<div class="col-md-2 col-xs-3 col-sm-3">
					<div class="img-set">
						<img src="$url" alt="ICON">
					</div>
				</div>
						<div class="col-md-10 col-xs-9 col-sm-9">
							<div class="product-detail">

								<div class="pro-name">$oDetails->pro_name</div>

								<span class="pro-size">$size :
								$oDetails->order_attr | </span>
                                <span class="pro-qty">Qty: $oDetails->pro_qty </span>
								<div>
								<span class="pro-price"><i class="fa fa-inr" aria-hidden="true"></i>
								$oDetails->pro_price</span>
							<span class="pro-price-cut"><i class="fa fa-inr"
									aria-hidden="true"></i> $oDetails->act_price</span>
							<span class="pro-price-save">Saved <i class="fa fa-inr"
									aria-hidden="true"></i>
									$dis </span>
								</div>
							</div>
						</div>
					</div>

				</li>


			</ul>

			<div class="note-set">
				<!-- <b>Please Note:</b> Your return has been processed successefully. Please check your email for refund details. -->

			</div>
		</div>

EOD;
        }
        $url = base_url() . "Myaccount/productexchange";
        $this->session->flashdata('msg');

        $html .= <<<EOD
		<div class="return-prs">
	<form method="POST" action="$url" enctype="multipart/form-data">

		<div class="form-group">
		<input type='hidden' value='$id' name='data'>
			<label for="">Choose another size</label>
			<select required class="form-control" name='selectedSize'>
			<option value="">Select Size</option>
				$sizeOption
			</select>

		</div>
		<div class="form-group">
		<div class="row">
		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="button" onclick='location.reload(true);' class="cancel-bt changeCancle">
					Cancel
				</button>
			</div>
		</div>
		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="submit" class="save-bt changePass">
					Exchange
				</button>
			</div>
		</div>




	</div>
		</div>
	</div>
	</form>
EOD;
        echo $html;
    }

    private function exchangeMail($orderID, $new)
    {
        $data = $this->user->allCustomerOrders2($orderID);
        $base = base_url();
        $baseurl = base_url("bootstrap/images/shipping.png");
        $subject = "Exchange order request: Order No:- 10000 " . $data[0]->order_id;
        $message = "";
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";

        $message .= "<tr><td  style='padding:8px;'>Exchange order number: 10000{$data[0]->order_id}</td></tr>";

        $message .= "<tr><td style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td><h3>Your  exchange item details</h3></td></tr>";
        $message .= "<tr><td >Order number : 10000{$data[0]->order_id}</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<table>";
        $image = getProductImage($data[0]->pro_id);
        $image = base_url("uploads/thumbs/thumb_" . $image);
        $discount = floatval($data[0]->act_price) - floatval($data[0]->pro_price);
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
        $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . " <br> Requested Size : " . $new . "  </td></tr>";
        $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";
        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('support@paulsonsonline.com', 'support@paulsonsonline.com');
        $this->email->to($data[0]->user_email);
        $this->email->bcc(array(EMAIL_BCC));
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function productexchange()
    {
        $orderInfo = $this->user->OrderTable($this->input->post('data'));

        $date1 = date("Y-m-d H:i:s");
        $date2 = $orderInfo->pay_date;
        $now = strtotime($date1);
        $your_date = strtotime($date2);
        $datediff = $now - $your_date;
        $diff = round($datediff / (60 * 60 * 24));

        if ($diff <= 7) {

            $res = $this->user->exchangeOrder($this->input->post(), $orderInfo->pro_id, $orderInfo->pro_qty, $orderInfo->order_attr);
            $this->exchangeMail($this->input->post('data'), $this->input->post("selectedSize"));
            $this->db->cache_delete_all();
            $this->session->set_flashdata('msg', '<div class="text-danger bg-success">Your Exchange Request Send successfully! </div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="text-danger bg-danger"><b>Please Note:</b> Your Exchange request not processed . Please check return policy. </div>');
        }

        redirect('Myaccount/orderDetails');
    }

    public function orderReview()
    {
        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount/dashboard');
        }
        $id = $this->input->post("order_id");
        $pid = $this->input->post("PID");
        $oder = $this->user->allCustomerOrders2($this->input->post("order_id"));
        $html = '';
        $html .= <<<EOD
		<div class="order-return prod-return">
			<div class="return-head">
				<div class="row">
					<div class="col-md-6 col-xs-6">
						<div class="order-id">

							<b> ORDER NO </b> : 10000$id </div>
					</div>

				</div>

			</div>
EOD;
        foreach ($oder as $oDetails) {
            $exp_del = date("d M D,Y", strtotime($oDetails->pay_date . "+3 days"));
            $size = ucfirst($oDetails->order_prop);
            $dis = floatval($oDetails->act_price) - floatval($oDetails->pro_price);
            $img = $this->user->getProductImage($oDetails->pro_id);
            $url = base_url("uploads/resized/resized_") . $img;
            $html .= <<<EOD

			<ul>
				<li>
					<div class="row">
					<div class="col-md-2 col-xs-3 col-sm-3">
					<div class="img-set">
						<img src="$url" alt="ICON">
					</div>
				</div>
						<div class="col-md-10 col-xs-9 col-sm-9">
							<div class="product-detail">

								<div class="pro-name">$oDetails->pro_name</div>

								<span class="pro-size">$size :
								$oDetails->order_attr | </span>
                                <span class="pro-qty">Qty: $oDetails->pro_qty </span>
								<div>
								<span class="pro-price"><i class="fa fa-inr" aria-hidden="true"></i>
								$oDetails->pro_price</span>
					  		<span class="pro-price-cut"><i class="fa fa-inr"
									aria-hidden="true"></i> $oDetails->act_price</span>
							<span class="pro-price-save">Saved <i class="fa fa-inr"
									aria-hidden="true"></i>
									$dis </span>
								</div>

								<span class="pro-delivered">
									<b>Delivery expected</b>
									($exp_del)
								</span>

							</div>
						</div>
					</div>

				</li>


			</ul>

			<div class="note-set">
				<!-- <b>Please Note:</b> Your return has been processed successefully. Please check your email for refund details. -->

			</div>
		</div>

EOD;
        }
        $url = base_url() . "Myaccount/productReview";
        $key = $pid;     // encode($this->encryption->encrypt(($oder[0]->pro_id))); 
        $this->session->flashdata('msg');

        $html .= <<<EOD
		<div class="return-prs">
	<form method="POST" action="$url">

	<div class="form-group">
	<input type='hidden' value='$id' name='data'>

	    <label for="">Your Rating</label>
			<select class="form-control" name=rating[]>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			</select>
		</div>

		<div class="form-group">
			<label for="">Your Review</label>
			<textarea class="form-control" name='comment' rows="3"></textarea>
		</div>
		<input type="hidden" name="hidden_id"  id="hidden_id" value="$key" />

		<div class="form-group">
		<div class="row">

		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="button" onclick='location.reload(true);' class="cancel-bt changeCancle">
					Cancel
				</button>
			</div>
		</div>
		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="submit" class="save-bt changePass">
					Submit
				</button>
			</div>
		</div>




	</div>
		</div>
	</div>
	</form>
EOD;
        echo $html;
    }

    public function productReview()
    {
        $res = $this->user->getreview($this->input->post());
        $this->db->cache_delete_all();
        $this->session->set_flashdata('msg', '<div class="text-danger bg-success">Your Review Send successfully! </div>');
        redirect('Myaccount/orderDetails');
    }

    public function getCity()
    {
        $data = $this->security->xss_clean($this->input->post('state', true));
        $state = ucfirst(strtolower($data));
        $stateArray = ($this->sign->getCity($state));
        if ($stateArray != null) {
            $city = "";
            foreach ($stateArray as $cities) {
                $city .= "<option value='$cities->city_name'>$cities->city_name</option>";
            }
            echo $city;
        } else {
            echo "<option value=''>Select City</option>";
        }
    }

    public function checkout()
    {

        if ($this->session->userdata('addToCart') == null) {
            return redirect('Myaccount/dashboard');
        }
        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount');
        }

        $userVerification = '';

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[3]');
        $this->form_validation->set_rules('user_email', 'Email', 'required|min_length[3]|valid_email');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[3]|alpha');
        $this->form_validation->set_rules('user_address', 'Address', 'required|min_length[5]');
        $this->form_validation->set_rules('user_city', 'City', 'required|min_length[3]');
        $this->form_validation->set_rules('user_pin_code', 'Pin code', 'required|min_length[6]|max_length[6]|numeric');
        $this->form_validation->set_error_delimiters('<li style="background-color: #cc1212;padding: 0 10px;color:#fff;margin-bottom: 3px;">', '</li>');
        $email = $this->session->userdata('myaccount');
        $profile = $this->user->get_profile($email);
        $userVerification = $this->user->get_checkoutUser($email, $profile->user_contact);

        if ($this->form_validation->run() == false) {
            $this->load->view('includes/header', array('navbar' => loadnavigation()));
            $this->load->view('checkout', array('state' => $this->sign->loadState(), 'profile' => $profile, 'checkoutUser' => $userVerification));
            $this->load->view('includes/footer');
        } else {
            $registered_email = $this->security->xss_clean($this->session->userdata('myaccount'));
            $post = $this->security->xss_clean($this->input->post());
            $order = $this->security->xss_clean($this->session->userdata('addToCart'));
            $query = $this->user->userorder($registered_email, $post, $order, $userVerification);
            if ($query) {
                $paySuccess = base_url("Myaccount/paysuccess/" . encode($this->encryption->encrypt(($query))));
                $payCancel = base_url("Myaccount/paycancel/" . encode($this->encryption->encrypt(($query))));
                $this->securepay($post, $query, $paySuccess, $payCancel, $userVerification);
            } else {
                $this->session->set_flashdata('msg', '<div clas="alert alert-success"> Something went wrong</div>');
                return redirect('Checkout');
            }
        }
    }

    public function securepay($post, $orderId, $successUrl, $cancelUrl, $userVerification2)
    {

        if ($post !== null) {
            $this->load->view("includes/Crypto");
            $this->load->view('payment', array('data' => $post, "orderId" => $orderId, 'successUrl' => $successUrl, "cancelUrl" => $cancelUrl, "checkoutUser" => $userVerification2));
        } else {
            echo show_404();
        }
    }

    public function paysuccess()
    {

        $this->load->view("includes/Crypto");
        $workingKey = '227CE2D3B23CF462052BC22796243B96'; //Working Key should be provided here.
        $encResponse = $_POST["encResp"]; //This is the response sent by the CCAvenue Server
        $rcvdString = decrypt($encResponse, $workingKey); //Crypto Decryption used as per the specified working key.

        $order_status = "";
        $order_id = "";
        $amount = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 0) {
                $order_id = $information[1];
            }

            if ($i == 10) {
                $amount = $information[1];
            }

            if ($i == 3) {
                $order_status = $information[1];
            }
        }

        if ($order_status === "Success") {
            $id = $this->uri->segment(3);
            $decodeId = (int) $this->encryption->decrypt(decode($id));
            if ($decodeId > 0) {
                $data = $this->user->successPayment($decodeId);
                if ($data) {
                    $order = $this->security->xss_clean($this->session->userdata('addToCart'));
                    $this->user->deductFromInventory($order, $decodeId);
                    $this->user->addInvoice($decodeId);
                    $this->session->unset_userdata('addToCart');
                    $this->onsuccessMail($decodeId);
                    //    $this->sendCustomerConfirmation();
                    $this->session->set_flashdata('msg', '<div class="alert alert-success"> Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon. </div>');
                    return redirect('Myaccount/dashboard');
                }
            } else {
                echo show_404();
            }
        } else if ($order_status === "Aborted") {
            $this->session->set_flashdata('msg', '<div clas="alert alert-danger">Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail</div>');
        } else if ($order_status === "Failure") {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Thank you for shopping with us.However,the transaction has been declined.</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Invalid Details Detected ,Please enter valid one</div>');
        }
        return redirect('Myaccount/dashboard');
    }

    public function paycancel()
    {
        $id = $this->uri->segment(3);
        $decodeId = (int) $this->encryption->decrypt(decode($id));
        if ($decodeId > 0) {
            $data = $this->user->cancelPayment($decodeId);
            if ($data) {
                $this->session->set_flashdata('msg', '<div clas="alert alert-success"> Payment has been cancelled </div>');
                $this->session->unset_userdata('addToCart');
                return redirect('Myaccount/dashboard');
            }
        } else {
            echo show_404();
        }
    }

    public function cancelThis()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(3)));
        if ($id > 0) {
            $this->load->view("includes/header");
            $this->load->view("cancelOrder");
            $this->load->view("includes/footer");
            //            $this->user->cancelThis($id);
            //            return redirect('Myaccount/dashboard');
        } else {
            echo show_404();
        }
    }
    public function bagform()
    {
        $data = $this->security->xss_clean($this->input->post());
        if ($this->input->post("bagDate") != null && $this->input->post("bagChecked") != null) {
            $res = $this->user->bagRequest($data);
            $this->db->cache_delete_all();

            $this->session->set_flashdata("msg", "<div class='alert alert-success'> Add to Bag Delivery Date Request Send Successfully. </div>");
        } else {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Something Went Wrong. </div>");
        }

        return redirect("Myaccount/orderDetails");
    }

    public function cancelPop()
    {
        if ($this->input->post("key")) {
            $order = $this->encryption->decrypt(decode($this->input->post("key")));

            $orderId = $this->input->post("key");

            if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
                return redirect('Myaccount/dashboard');
            }
            $id = $order;
            $oder = $this->user->allCustomerOrders2($order);
            $html = '';
            $html .= <<<EOD
		<div class="order-return prod-return">
			<div class="return-head">
				<div class="row">
					<div class="col-md-6 col-xs-6">
						<div class="order-id">

							<b> ORDER ID </b> : 10000$id </div>
					</div>

				</div>

			</div>
EOD;
            foreach ($oder as $oDetails) {
                $exp_del = date("d M D,Y", strtotime($oDetails->pay_date . "+3 days"));
                $size = ucfirst($oDetails->order_prop);
                $dis = floatval($oDetails->act_price) - floatval($oDetails->pro_price);
                $img = $this->user->getProductImage($oDetails->pro_id);
                $url = base_url("uploads/resized/resized_") . $img;
                $html .= <<<EOD

			<ul>
				<li>
					<div class="row">
					<div class="col-md-2 col-xs-3 col-sm-3">
					<div class="img-set">
						<img src="$url" alt="ICON">
					</div>
				</div>
						<div class="col-md-10 col-xs-9 col-sm-9">
							<div class="product-detail">

								<div class="pro-name">$oDetails->pro_name</div>

								<span class="pro-size">$size :
								$oDetails->order_attr | </span>
                                <span class="pro-qty">Qty: $oDetails->pro_qty </span>
								<div>
								<span class="pro-price"><i class="fa fa-inr" aria-hidden="true"></i>
								$oDetails->pro_price</span>
							<span class="pro-price-cut"><i class="fa fa-inr"
									aria-hidden="true"></i> $oDetails->act_price</span>
							<span class="pro-price-save">Saved <i class="fa fa-inr"
									aria-hidden="true"></i>
									$dis </span>
								</div>



							</div>
						</div>
					</div>

				</li>


			</ul>

			<div class="note-set">
				<!-- <b>Please Note:</b> Your return has been processed successefully. Please check your email for refund details. -->

			</div>
		</div>

EOD;
            }
            $url = base_url() . "Myaccount/cancelRequest";
            $this->session->flashdata('msg');

            $html .= <<<EOD
		<div class="return-prs">
	<form method="POST" action="$url" enctype="multipart/form-data">
		<div class="form-group">
		<input type='hidden' value='$orderId' name='data'>
			<label for="">Why are you cancelling this?</label>
			<select class="form-control" name='condition'>
				<option>Ordered By Mistake</option>
				<option>Incorrect Size Ordered</option>
				<option>Product Not Required Anymore</option>
				<option>Cash Issue</option>
			</select>
		</div>
		<div class="form-group">
			<label for="">Add Extra Comment </label>
			<textarea class="form-control" name='comment' rows="3"></textarea>
		</div>



		<div class="form-group">
		<div class="row">

		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="button" onclick='location.reload(true);' class="cancel-bt changeCancle">
					Close
				</button>
			</div>
		</div>
		<div class="col-md-4 col-xs-5">
			<div class="form-group ">
				<button type="submit" class="save-bt changePass">
					Request
				</button>
			</div>
		</div>




	</div>
		</div>
	</div>
	</form>
EOD;
            echo $html;
        }
    }

    private function cancelRequestMail($id)
    {
        $data = $this->user->allCustomerOrders2($id);
        $base = base_url();
        $baseurl = base_url("bootstrap/images/logo.png");
        $subject = "Cancellation Request: Order No:- 10000 " . $data[0]->order_id;
        $message = "";
        $message .= "<table style='border-collapse:collapse;border: 1px solid #7777;width:50%;padding:8px;margin:0 auto;background:#fff'><tr><td style='text-align:center'> <img style='width:20%' src='$baseurl' alt='Logo'></td> </tr>";
        $message .= "<tr><td style='border: 1px solid #cfd2d6;padding: 8px'><h2> Cancellation Request</h2> </td> </tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";

        $message .= "<tr><td  style='padding:8px;'>Cancellation request order number : <b>10000{$data[0]->order_id}</b></td></tr>";
        $message .= "<tr><td  style='padding:8px;' >Reason : <b>{$data[0]->cancel_comments}</b></td></tr>";

        $message .= "<tr><td  style='padding:8px;'><small><i>You have requested for cancellation,We look forward to serving you again</i></small></td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";

        $message .= "<tr><td   style='padding:8px;'><h3>A: Your cancellation item request </h3></td></tr>";

        $message .= "<table>";
        $image = getProductImage($data[0]->pro_id);
        $image = base_url("uploads/thumbs/thumb_" . $image);
        $message .= "<table style='border-collapse:collapse;width:50%;margin:0 auto;background:#fff;border: 1px solid #7777'>";
        $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU: {$data[0]->sku}</td></tr>";
        $message .= "<tr><td style='border-bottom:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'> Qty :<b>" . $data[0]->pro_qty . "</b> </td><td style='border-bottom:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'> Size: <b>" . $data[0]->order_attr . "</b></td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold;border-top:1px solid #777;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td style='border-top:1px solid #7a869d'><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";
        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('support@paulsonsonline.com', 'support@paulsonsonline.com');
        $this->email->to($data[0]->user_email);
        $this->email->bcc(array(EMAIL_BCC));
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function cancelRequest()
    {

        $id = (int) $this->encryption->decrypt(decode($this->input->post('data')));
        if ($id > 0) {
            $data = $this->security->xss_clean($this->input->post());

            if ($this->user->cancelThis($id, $data)) {
                $this->cancelRequestMail($id);
                $this->db->cache_delete("Myaccount", "orderDetails");
                $this->db->cache_delete("Admin", "Vendor");
                $this->session->set_flashdata("msg", "<div class='alert alert-success'> Cancellation Request Send Successfully. </div>");
            } else {
                $this->session->set_flashdata("msg", "<div class='alert alert-danger'> Something Went Wrong. </div>");
            }

            return redirect("Myaccount/orderDetails");
        } else {
            show_404();
        }
    }

    public function paymentStart()
    {
        $this->load->view('ccavRequestHandler2');
    }

    public function date_valid($date)
    {

        $d1 = new DateTime($date);
        $d2 = new DateTime(date('Y-m-d'));
        $diff = $d1->diff($d2);

        if (intval($diff->y) >= 18) {
            return true;
        }
        $this->form_validation->set_message('date_valid', 'User should be 18 years old');
        return false;
    }

    public function newUser()
    {
        if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {
            return redirect('Myaccount/dashboard');
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login[fullname]', 'First Name', 'required|min_length[3]');
        $this->form_validation->set_rules('login[lastname]', 'Last Name', 'required|min_length[3]');
        $this->form_validation->set_rules('login[username]', 'Email', 'required|valid_email|is_unique[tbl_user_reg.user_email]');
        $this->form_validation->set_rules('contact', 'Contact Number', 'required|numeric|max_length[10]|min_length[10]|is_unique[tbl_user_reg.user_contact]');
        $this->form_validation->set_rules('login[password]', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('login[cpassword]', 'Confirm Password', 'required|min_length[6]|matches[login[password]]');
        $this->form_validation->set_message('is_unique', 'The %s is already taken');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == false) {
            //$data['google_login_url'] = $this->google->get_login_url();
            $data['google_login_url'] = $this->googleplus->loginURL();

            $this->load->view('includes/header-profile');
            $this->load->view('userSignUp', $data);
            $this->load->view('includes/footer');
        } else {
            
            $post = [];
            $fullname = $this->security->xss_clean($this->input->post('login[fullname]'));
            $lastname = $this->security->xss_clean($this->input->post('login[lastname]'));
            $username = $this->security->xss_clean($this->input->post('login[username]'));
            $password = $this->security->xss_clean($this->input->post('login[password]'));
            $switchone = $this->security->xss_clean($this->input->post('switch-one'));
            $url = $this->security->xss_clean($this->input->post('url'));
            
            $x_url = explode('?',$url);
            $new_url = explode('&',$x_url[1]);
            $step = $new_url[0];
            $id = $new_url[1];
            
            $cpassword = password_hash($this->security->xss_clean($this->input->post('login[cpassword]')), PASSWORD_BCRYPT);
            $contact = $this->security->xss_clean($this->input->post('contact'));
            $dob = $this->security->xss_clean($this->input->post('login[dob]'));
            $post["fullname"] = $fullname;
            $post["lastname"] = $lastname;
            $post["username"] = $username;
            $post["cpassword"] = $cpassword;
            $post["contact"] = $contact;
            $post["switch-one"] = $switchone;

            if (@$post["prime"] != '' || @$post["prime"] != null) {
                $this->session->set_userdata('prime', $post);
                return redirect('Prime');
            } else {

                $result = $this->user->registration($post);

                $this->newUserRegistration($post);
                if ($result) {
                    
                    //$this->sendCurl($contact);
                    $this->session->set_userdata('myaccount', $username);

                    if ($step === 'Step=wish') {
                        $pid = explode('=',$id);
                        $this->addToWishListforSignup($this->encryption->decrypt(decode($pid[1])));
                        return redirect("Wishlist");
                    }

                    if ($this->input->get("Step") === 'checkout') {
                        $this->session->set_flashdata('msg', '<div class="alert alert-success">Welcome to Paulsonsonline.com</div>');
                        return redirect('Checkout');
                    } else {
                        $this->session->set_flashdata('msg', '<div class="alert alert-success">Welcome to paulsons</div>');
                        return redirect('Myaccount/dashboard');
                    }
                } else {
                    $this->session->set_flashdata('msg', '<div class="text-danger">Something went wrong,Please try again</div>');
                    if ($this->input->get("Step") === 'checkout') {
                        return redirect('Checkout');
                    } else {
                        return redirect('Myaccount/newUser');
                    }
                }
            }
        }
    }

    public function userSetPassword()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm', 'Confirm Password', 'required|min_length[6]|matches[new_password]');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $userId = $this->security->xss_clean($this->encryption->decrypt(decode($this->input->post('user'))));
        if ($userId == null) {
            $userId = $this->user->getUserIdByEmail();
        }
        $confirm = $this->security->xss_clean($this->input->post('new_password'));

        if ($this->form_validation->run() == true) {
            $getUser = $this->user->get_profile_id($userId);
            $password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
            $res = $this->user->update_password($userId, $password);
            if ($res) {
                $this->db->cache_delete_all();
                $this->session->set_flashdata('msg', "<div class='text-success'>Password has been Change Successfully.</div>");
            } else {
                $this->session->set_flashdata('msg', "<div class='text-danger'>Password Reset Failed.</div>");
            }
        } else {
            $this->session->set_flashdata('msg', "<div class='text-danger'>Password Reset Failed.Try again !</div>");
            return redirect('Myaccount/editProfile');
        }
        return redirect('Myaccount/editProfile');
    }

    public function forgotPassword()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login[username]', 'Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == false) {
            $this->load->view('includes/header-profile');
            $this->load->view('forgotPass');
            $this->load->view('includes/footer');
        } else {
            $user = $this->security->xss_clean($this->input->post('login[username]'));
            $user_data = $this->user->get_profile($user);
            if ($user_data != null || $user_data != "") {
                $this->forgotMail($this->user->get_profile($user));
                $this->session->set_flashdata('msg', '<div class="text-success">Mail Sent Succesfully</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="text-danger">No record in database</div>');
            }
            return redirect('Myaccount/forgotPassword');
        }
    }

    public function updatePassword()
    {
        $password = password_hash($this->input->post('cpass'), PASSWORD_BCRYPT);
        $id = (int) $this->encryption->decrypt(decode($this->input->post('key')));

        if ($id > 0) {
            $this->user->update_password($id, $password);
            $this->session->set_flashdata('msg', "<div class='text-success'>Password has been reset,Please login</div>");
            return redirect('Myaccount');
        } else {
            show_404();
        }
    }

    public function forgotstep()
    {

        if ($this->uri->segment(3) != '') {
            $id = (int) $this->encryption->decrypt(decode($this->uri->segment(3)));
            if ($id > 0) {
                $data = $this->user->get_profile_id($id);
                $this->load->view('includes/header');
                $this->load->view('forgotPassStep', array('id' => $data->id));
                $this->load->view('includes/footer');
            } else {
                echo show_404();
            }
        } else {
            echo show_404();
        }
    }

    private function cancellationRequest($order)
    {
        $orders = $this->user->getCancellationDetails($order);
        $orderHtml = "";
        $property = "";

        foreach ($orders as $orderDetail) {

            $orderProp = json_decode($orderDetail->order_prop);
            if ($orderProp->attribute != null) {
                foreach ($orderProp->attribute as $attribute) {
                    $prop = key((array) $attribute);
                    $property .= <<<EOD
                       <br><span>$prop :{$attribute->$prop}</span>
EOD;
                }
            }
            $orderHtml .= <<<EOD
         <p><b>Product Name:</b> {$orderDetail->pro_name} x {$orderDetail->pro_qty} $property</p>
         <p><b>Company:</b> {$orderDetail->company}</p>
         <p><b>Contact Number :</b> {$orderDetail->contactno}</p>
EOD;
        }
        $message = "";
        $base = base_url();
        $to_email = $orders[0]->user_email;
        $order = $orders[0]->or_id;
        $subject = "Order Cancellation Request : paulsons.com";
        $message .= "<br><p>Dear {$orders[0]->first_name}, we have recieved your cancellation request for Order Number (SHPTRD#00$order)</p>";
        $message .= "<br><p>Please find order cancellation details :</p>$orderHtml";
        $message .= "<p>Thanks for shopping with paulsons</p><p>For support call our customer care number: +91 966 724 5444 </p>";

        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('support@paulsonsonline.com', 'support@paulsonsonline.com');
        $this->email->to($to_email);
        $this->email->bcc(array(EMAIL_BCC, $orders[0]->emailadd));
        $this->email->subject($subject);
        $this->email->message($message);
        $result = $this->email->send();
    }

    private function newUserRegistration($data)
    {

        $base = base_url();
        $baseurl = base_url("bootstrap/images/logo.png");
        $subject = "Thanks for joining paulsons.com  ";
        $message = "";
        $message .= "<table style='border-collapse:collapse;width:50%;font-size:20px;margin:0 auto;background:#fff'> <tr><td style='text-align:center'> <img style='width:20%' src='$baseurl' alt='Logo'></td> <tr> <tr><td></td></tr><tr><td style='text-align:center;font-size:30px'><h3>Welcome to paulsons</h3></td></tr>";
        $message .= "<tr><td style='font-weight:bold'>Hi, " . $data["fullname"] . "<br>  <br>Thanks for joining us we are happy to have you</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>You are all set to start the shopping</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        // <span style='font-weight:bold'> <a href='{$base}shop/subscription/sSVH7G8efg8kR0i75NXlONVZFr0LBqeZQAlA4UpfTrQCuqfOHA3.FJceowrg98sXFTvVmcHd1uprOHkWiBofMg--'>JOIN OUR SUBSCRIPTION PROGRAM </a> FOR FREE  delivery, as fast as today </span>
        $message .= "<tr><td style=''>

Fast, free and convenient ways to get millions of items and other more features</td></tr>";

        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr></table>";
        // $message .= "  <tr><td style='text-align:center'> <img width='100%' src='" . $base . "assets/images/foot-off.png' alt=''> </td>  </tr></table>";

        if ($data != null) {
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );

            $this->load->library('email', $config);
            $this->email->reply_to('support@paulsonsonline.com', 'paulsons');
            $this->email->set_newline("\r\n");
            $this->email->from('support@paulsonsonline.com', 'paulsons');
            $this->email->to($data["username"]);
            $this->email->bcc(array(EMAIL_BCC));
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();
        }
    }

    private function onsuccessMail($order)
    {

        $msg = "";
        $user = $this->user->getsuccessPayment($order);
        $orders = $this->user->allOrdersOrderId($order);
        $this->sendCustomerConfirmation($user->user_contact);
        $orderHtml = "";
        $property = "";

        foreach ($orders as $orderDetail) {
            $this->sendVendorConfirmation($orderDetail->contactno);

            $orderProp = json_decode($orderDetail->order_prop);
            if ($orderProp->attribute != null) {
                foreach ($orderProp->attribute as $attribute) {
                    $prop = key((array) $attribute);
                    $property .= <<<EOD
                       <br><span>$prop :{$attribute->$prop}</span>
EOD;
                }
            }
            $orderHtml .= <<<EOD
         <p><b>Product Name:</b> {$orderDetail->pro_name} x {$orderDetail->pro_qty} $property</p>
EOD;
        }

        $message = "";
        $base = base_url();
        $to_email = $user->user_email;
        $subject = "Order Confirmation : paulsons.com";
        $message .= "<br><p>Dear $user->first_name, we have recieved your order (KRZ#00$order)</p>";
        $message .= "<br><p>Please find order details :</p>$orderHtml";
        $message .= "<p>Thanks for shopping with Paulsons</p><p>For support call our customer care number: +91 999-956-5434</p>";

        if ($user) {
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('support@paulsonsonline.com', 'paulsons');
            $this->email->to($to_email);
            $this->email->bcc(array(EMAIL_BCC));
            $this->email->subject($subject);
            $this->email->message($message);
            $result = $this->email->send();

            if ($result) {
                $msg = <<<EOD
                    <div class="text-success" >
                    Mail has been sent successfully
                        </div>
EOD;

                $this->session->set_flashdata('msg', $msg);
            }
            foreach ($orders as $orderDetail) {
                $this->onsuccessVendorMail($orderDetail->or_id, $orderDetail->pro_qty, $orderDetail->company, $orderDetail->emailadd, $orderDetail->pro_name, $orderDetail->order_prop, $orderDetail->first_name, $orderDetail->last_name);
            }
        }
    }

    private function onsuccessVendorMail($order, $qty, $company, $vendor_email, $pro_name, $pro_property, $fname, $lname)
    {
        $msg = "";

        $message = "";
        $property = "";
        $base = base_url();
        $to_email = $vendor_email;
        $subject = "Order Confirmation : paulsons.com";
        $message .= "<p>Dear $company, your product has been sold on paulsons.com " . date("d/m/Y H:i") . " to customer $fname $lname ";
        $message .= "<p>Please keep consignment ready for our courier partner pickup within 24 hours</p>";
        $message .= "<p>Please find the order details</p>";
        $orderProp = json_decode($pro_property);
        if ($orderProp->attribute != null) {
            foreach ($orderProp->attribute as $attribute) {
                $prop = key((array) $attribute);
                $property .= <<<EOD
                       <br><span>$prop :{$attribute->$prop}</span>
EOD;
            }
        }
        $message .= " <p><b>Order ID:</b> KRZ#00$order</p> ";
        $message .= " <p><b>Product Name:</b> {$pro_name} x {$qty}  $property</p> ";
        $message .= " <p>Thanks for be partner with paulsons</p><p>For support call our customer care number: +91 97160-90101</p>";

        if ($order) {
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('support@paulsonsonline.com', 'paulsons');
            $this->email->to($to_email);
            $this->email->bcc(array(EMAIL_BCC));
            $this->email->subject($subject);
            $this->email->message($message);
            $result = $this->email->send();
        }
    }

    private function forgotMail($user)
    {

        $id = encode($this->encryption->encrypt($user->id));
        $msg = "";
        $message = "";
        $base = base_url();
        $to_email = $user->user_email;
        $subject = "(Confidential) Reset Password For paulsons.com (Do not share)";
        $message .= "<br><p>Hi $user->user_name, Please find the details";
        $message .= "<br> Username : $user->user_email  ";
        // $message .= "<br><p>You need to enter new password on following page :({$base}Myaccount/forgotstep/{encode($this->encryption->encrypt(($user->id)))})</p>";
        $message .= "<br><p>You need to enter new password on following page :({$base}Myaccount/forgotstep/{$id})</p>";

        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('support@paulsonsonline.com', 'paulsons');
        $this->email->to($to_email);
        $this->email->bcc(array(EMAIL_BCC));
        $this->email->subject($subject);
        $this->email->message($message);

        $result = $this->email->send();

        if ($result) {
            $msg = <<<EOD
                    <div class="text-success" >
                     Mail has been sent successfully
                        </div>
EOD;

            $this->session->set_flashdata('msg', $msg);
        }
    }

    private function sendCustomerConfirmation($contact)
    {

        $apiKey = "Y42YATIo+DM-IQBU5F9rQnA2ZQaP4Nz9HxWAJui0R8";
        $test = 0;
        $sender = urlencode('SPTRDY');
        $message = rawurlencode('Dear,
Thanks for shopping with paulsonsonline.com
We have received your order for more detail check your email.

For support call our customer care number (+91 99995-65434).


paulsons Customer care team
');
        $numbers = urlencode('91' . $contact);
        // Prepare data for POST request
        $data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message . "&test=" . $test;

        // Send the GET request with cURL
        $ch = curl_init('https://api.textlocal.in/send/?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
    }

    private function sendVendorConfirmation($contact)
    {

        $apiKey = "Y42YATIo+DM-IQBU5F9rQnA2ZQaP4Nz9HxWAJui0R8";
        $test = 0;
        $sender = urlencode('SPTRDY');
        $message = rawurlencode('Dear vendor,
Your product has been booked on paulsons.com for more information check your email and your dashboard.

Thanks
paulsons Team');
        $numbers = urlencode('91' . $contact);
        // Prepare data for POST request
        $data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message . "&test=" . $test;

        // Send the GET request with cURL
        $ch = curl_init('https://api.textlocal.in/send/?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
    }

    private function sendCurl($contact)
    {

        $apiKey = "Y42YATIo+DM-IQBU5F9rQnA2ZQaP4Nz9HxWAJui0R8";
        $test = 1;
        $sender = urlencode('SPTRDY');
        $message = rawurlencode('Welcome to paulsons.com

you OTP for login is %%|OTP^{"inputtype" : "text", "maxlength" : "10"}%%');
        $numbers = urlencode('91' . $contact);
        // Prepare data for POST request
        $data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message . "&test=" . $test;

        // Send the GET request with cURL
        $ch = curl_init('https://api.textlocal.in/send/?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
    }

    private function trackOrderCurl($awb = null)
    {

        $ch = curl_init('https://plapi.ecomexpress.in/track_me/api/mawbd/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=pamasha422039_ate&password=Pmd4og2Kq9YkdG@hO&awb=$awb");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "username=pamashainternet80515_temp&password=8LEdtLzJWqfPBwm4&count=2000&type=ppd");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);

        //        $response = simplexml_load_string($response);
        $xml = new SimpleXMLElement($response);
        curl_close($ch);
        return $xml;
    }

    private function curlGet()
    {

        $ch = curl_init('https://api.ecomexpress.in/apiv2/fetch_awb/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=pamasha422039_ate&password=Pmd4og2Kq9YkdG@hO&count=10000&type=ppd");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "username=pamashainternet80515_temp&password=8LEdtLzJWqfPBwm4&count=2000&type=ppd");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        foreach ($response->awb as $awb) {
            $this->user->insertAwb($awb);
        }
    }

    private function manifestRequest($json_request)
    {
        $json_request = json_encode($json_request);
        $ch = curl_init('https://api.ecomexpress.in/apiv2/manifest_awb/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=pamasha422039_ate&password=Pmd4og2Kq9YkdG@hO&json_input=$json_request");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "username=pamashainternet80515_temp&password=8LEdtLzJWqfPBwm4&count=2000&type=ppd");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
    }

    public function editProfile()
    {

        if ($this->session->userdata('myaccount') == null && $this->session->userdata('app_id') == null) {
            return redirect('Myaccount/dashboard');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fname', 'First Name', 'required|min_length[3]');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        if ($this->session->userdata('myaccount') == null) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tbl_user_reg.user_email]');
        }
        $this->form_validation->set_rules('lname', 'Last Name', 'required|min_length[3]');
        $this->form_validation->set_rules('mobile', 'Contact Number', 'required|numeric|max_length[10]|min_length[10]');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($_FILES != null) {
            $this->form_validation->set_rules('profilePhoto', 'Document', 'trim|xss_clean|');
        }

        if ($this->form_validation->run() == false) {
            $this->load->view('includes/header-profile');

            $this->load->view('edit_profile');
            $this->load->view('includes/footer');
        } else {
            $post = $this->security->xss_clean($this->input->post());
            $uploadedFile = "";
            if ($_FILES['profilePhoto']['tmp_name'] != null) {

                if ($_FILES['profilePhoto']['type'] == 'image/jpeg' || $_FILES['profilePhoto']['type'] == 'image/png' || $_FILES['profilePhoto']['type'] == 'image/gif') {

                    $config['upload_path'] = './uploads/profilePic/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = 1024;
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('profilePhoto')) {
                        $uploadData = $this->upload->data();
                        $uploadedFile = $uploadData['file_name'];
                    } else {
                        $this->session->set_flashdata('error', '<div class="text-danger">' . $this->upload->display_errors() . '</div>');
                    }
                } else {
                    $this->session->set_flashdata('error', '<div class="text-danger">Invalid image format </div>');
                }
            }

            $res = $this->user->updateuser($post, $this->session->userdata('myaccount'), $uploadedFile);
            if ($res) {
                $this->session->set_flashdata('msg', '<div class="text-success">Information is saved successfully.</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="text-danger">Information is not saved. One</div>');
            }
            return redirect("Myaccount/editProfile");
        }
    }

    public function privacy()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('privacy');
        $this->load->view('includes/footer');
    }

    public function termncondition()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('terms');
        $this->load->view('includes/footer');
    }

    public function faqscustomer()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('faqs-customer');
        $this->load->view('includes/footer');
    }

    public function aboutus()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('aboutus');
        $this->load->view('includes/footer');
    }

    public function contactus()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'First Name', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|min_length[3]|valid_email');
        $this->form_validation->set_rules('mobile', 'Contact Number', 'required|numeric|max_length[10]|min_length[10]');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->load->view('includes/header-profile');
            $this->load->view('contactus');
            $this->load->view('includes/footer');
        } else {
            $config = array(
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $name = ucwords($this->input->post('name'));
            $message = "<html><body><br>Contact us Query for paulsons.com <br>";
            $message .= '<table rules="all" style="border-color: #666;" cellpadding="10" cellspacing="10" border="1">';
            $message .= "<tr style='background: #eee;'><td><strong>Name</strong> </td><td>" . $name . "</td></tr>";
            $message .= "<tr style='background: #eee;'><td><strong>Email</strong> </td><td>" . $this->input->post("email") . "</td></tr>";
            $message .= "<tr style='background: #eee;'><td><strong>Contact</strong> </td><td>" . $this->input->post("mobile") . "</td></tr>";
            $message .= "<tr style='background: #eee;'><td><strong>comments</strong> </td><td>" . $this->input->post("comments") . "</td></tr>";
            $message .= "</table><br><br>";
            $message .= "</body></html>";
            $this->email->from($this->input->post("email"), $name);
            $this->email->to('gaurav@nibble.co.in,' . $this->input->post("email") . '');   //support@paulsonsonline.com
            $this->email->subject('Contact us Query');
            $this->email->message($message);
            $result = $this->email->send();
            if ($result) {
                $this->session->set_flashdata("msg", "<div class='alert alert-success'>Mail has been sent successfully </div>");
            } else {
                $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Mail failed ! try again </div>");
            }
            return redirect('Myaccount/contactus');
        }
    }

    public function disclaimer()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('disclaimer');
        $this->load->view('includes/footer');
    }

    public function faqsvendor()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('faqs-vendor');
        $this->load->view('includes/footer');
    }

    public function payments()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('payments');
        $this->load->view('includes/footer');
    }

    public function returncancel()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('return_cancel');
        $this->load->view('includes/footer');
    }

    public function shipcharges()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('ship_charges');
        $this->load->view('includes/footer');
    }

    public function fabric_care()
    {
        $this->load->view('includes/header-profile');
        $this->load->view('fabric_care');
        $this->load->view('includes/footer');
    }

    public function storelocator()
    {
        $this->load->view('includes/header-profile');
        $data = $this->db->get("store_locator")->result();
        $this->load->view('store_locator', compact("data"));
        $this->load->view('includes/footer');
    }

    public function previousUrl()
    {
        if ($this->session->userdata('myaccount') == null) {

            $wishlistModel = true;
            echo $wishlistModel;
        } else {
            $wishlistModel = false;
            echo $wishlistModel;
        }

        $this->session->set_userdata('referred_from', $_SERVER['HTTP_REFERER']);
    }

    public function rahman()
    {
        if ($this->uri->segment(3) != '') {
            $id = (int) $this->encryption->decrypt(decode($this->uri->segment(3)));

            if ($id > 0) {
                $remainingamountForOnline = 0;

                $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
                $response = $this->user->allOrdersOrderId($id);
                $userVerification = $this->user->get_checkoutUser($response[0]->registered_user, $response[0]->user_contact);
                $paySuccess = base_url("Myaccount/paysuccess2/" . $response[0]->order_id);
                $payCancel = base_url("Myaccount/paycancel/" . $response[0]->order_id);
                $remainingamountForOnline = $response[0]->bag_ship_amt;

                $this->securepay2($response[0], $response[0]->order_id, $paySuccess, $payCancel, $userVerification, $remainingamountForOnline);

                // $data = $this->user->get_profile_id($id);
                // $this->load->view('includes/header');
                // $this->load->view('forgotPassStep', array('id' => $data->id));
                // $this->load->view('includes/footer');
            } else {
                echo show_404();
            }
        } else {
            echo show_404();
        }
    }
    public function securepay2($post, $orderId, $successUrl, $cancelUrl, $userVerification, $remainingamount = "")
    {
        //echo $remainingamount;die;

        if ($post !== null) {
            $this->load->view("includes/Crypto");
            $this->session->set_userdata("info", ["order_id" => $orderId, "amount" => $remainingamount]);
            $this->load->view('payment', array('data' => $post, 'amount' => $remainingamount, "orderId" => $orderId, 'successUrl' => $successUrl, "cancelUrl" => $cancelUrl, "checkoutUser" => $userVerification));

            //     $is_success = $this->user->setTxnId($orderId);

            //     if ($is_success) {
            //         $this->load->view('payment', array('data' => $post, 'amount' => $remainingamount, "orderId" => $orderId, 'successUrl' => $successUrl, "cancelUrl" => $cancelUrl, "checkoutUser" => $userVerification2));
            // //   print_r(array('data' => $post, "orderId" => $orderId, 'successUrl' => $successUrl, "cancelUrl" => $cancelUrl, "checkoutUser" => $userVerification2));
            //         // die("Invalid transaction found");
            //     }
        } else {
            echo show_404();
        }
    }
    public function paysuccess2()
    {
        $this->load->view("includes/Crypto");

        $working_key = '2278303239916A72ABB47FD268A52B94'; //Shared by CCAVENUES
        $access_code = 'AVCA86GG48AX81ACXA'; //Shared by CCAVENUES

        $encResponse = $_POST["encResp"]; //This is the response sent by the CCAvenue Server
        $rcvdString = decrypt($encResponse, $working_key); //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);

        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 3) {
                $order_status = $information[1];
            }
        }
        $order_id = explode('=', $decryptValues[0]);
        $amount = explode('=', $decryptValues[35]);

        if ($this->session->userdata("info")["order_id"] != $order_id[1] || round($this->session->userdata("info")["amount"]) != round($amount[1])) {
            $this->session->unset_userdata("info");
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Invalid Details Detected ,Please enter valid one</div>');

            return redirect('Myaccount/dashboard');
        }

        if ($order_status === "Failure") { //   Success
            $id = $this->uri->segment(3);
            $decodeId = $id;

            if ($decodeId > 0) {
                $order_id = explode('=', $decryptValues[0]);
                $track = explode('=', $decryptValues[1]);
                $amount = explode('=', $decryptValues[35]);
                $data = $this->db->update('tbl_customer_order', array('shipping' => urldecode($amount[1]), 'add_to_box' => 2, 'bag_ship_confirm' => 1), array('id' => $decodeId));
                $this->db->cache_delete_all();

                $html = "<div style='height:200px;overflow-y:scroll'><table class='table table-condensed table-border'>";

                $html .= '<tr><td>' . $order_id[0] . '</td><td>' . urldecode($order_id[1]) . '</td></tr>';
                $html .= '<tr><td>' . $track[0] . '</td><td>' . urldecode($track[1]) . '</td></tr>';
                $html .= '<tr><td>Amount Charged</td><td>' . urldecode($amount[1]) . '</td></tr>';

                $html .= "</table></div>";

                if ($data) {

                    // $user = $this->user->get_profile($this->session->userdata("myaccount"))->id;

                    // $getCreditWallet = $this->user->getCreditWalletAmt(); // all return products
                    // $getDebitWallet = $this->user->getDebitWalletAmt();

                    // $total = $getCreditWallet[0]->wallet_amt - $getDebitWallet[0]->wallet_amt;

                    // $query = $this->db->insert("tbl_wallet", ["is_display" => 1, "controls" => 1,"order_id" => $decodeId, "wallet_amt" => $total, "pay_id" => $decodeId, "user_id" => $user]);
                    // if ($query) {
                    //     $arr = array('msg' => 'Payment successfully credited', 'status' => true);
                    //     echo json_encode($arr);
                    // } else {
                    //     $arr = array('msg' => 'Payment failed', 'status' => false);
                    //     echo json_encode($arr);
                    // }

                    //$order = $this->security->xss_clean($this->session->userdata('addToCart'));
                    // $this->user->changeStatus($decodeId);
                    //  $this->user->deductFromInventory($order);    //previously it was -- $this->user->deductFromInventory($order, $decodeId);
                    // $this->user->addInvoice($decodeId);
                    // $this->session->unset_userdata('addToCart');
                    // $this->user->prodcart($user);
                    //  $this->db->cache_delete_all();
                    // $this->onsuccessMail($decodeId);
                    // $this->sendCustomerConfirmation();
                    $this->session->set_flashdata('msg', '<div id="window" style="position:fixed;left: 0;top: 0;width: 100%;z-index: 100;height:100%;background-color: #0000007a;"> <div style="width: 50%; margin: 35px auto;background-color: #fff;padding: 39px 30px;position: relative;">
           <h3>  Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon. </h3>  <button onclick=$("#window").hide(); style="position: absolute;  right: 20px;   top: 8px;" class="  btn btn-success btn-xs">Close</button>
            ' . $html . '  </div></div>');
                    return redirect('Myaccount/thanksBag');
                }
            } else {
                echo show_404();
            }
        } else if ($order_status === "Aborted") {
            $this->session->set_flashdata('msg', '<div clas="alert alert-danger"> Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail  </div>');
        } else if ($order_status === "Failure") {
            // $html = "<div style='height:200px;overflow-y:scroll;'><table  class='table table-condensed table-border'>";
            // $order_id = explode('=', $decryptValues[0]);
            // $track = explode('=', $decryptValues[1]);
            // $amount = explode('=', $decryptValues[35]);

            // $html .= '<tr><td>' . $order_id[0] . '</td><td>' . urldecode($order_id[1]) . '</td></tr>';
            // $html .= '<tr><td>' . $track[0] . '</td><td>' . urldecode($track[1]) . '</td></tr>';
            // $html .= '<tr><td>Amount Charged</td><td>' . urldecode($amount[1]) . '</td></tr>';
            // $html .= "</table></div>";

            $order = $this->security->xss_clean($this->session->userdata('addToCart'));
            $this->user->deductFromInventory($order); //previously it was -- $this->user->deductFromInventory($order, $decodeId);

            $this->db->cache_delete_all();

            $this->session->set_flashdata('msg', '<div  style="position:fixed;left: 0;top: 0;width: 100%;height:100%;z-index: 100;background-color: #0000007a;" > <div style="width: 50%; margin: 35px auto;background-color: #fff;padding: 39px 30px;position: relative;"> <h3>Thank you for shopping with us.However,the transaction has been declined. </h3> <button onclick=$("#window").hide();  style="position: absolute;  right: 20px;   top: 8px;" class="btn btn-success btn-xs">Close</button> ' . $html . ' </div></div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Invalid Payment Details Detected ,Please enter valid one</div>');
        }

        // return redirect('Myaccount/dashboard');
    }

    public function thanksBag()
    {
        $this->load->view("thankBag");
    }

    public function Returnproduct()
    {
        $orderID = $this->input->post('order_id');
        $oid = $this->input->post('o_id');
        $data = $this->user->customerOrder($orderID);
        // $this->db->update('tbl_customer_order', ['order_sta' => 9], ['id' => $orderID]);
        $this->db->update('tbl_order', ['order_status' => 9], ['id' => $oid]);
        $base = base_url();
        $baseurl = base_url("bootstrap/images/shipping.png");
        $subject = "Return order request: Order No:- 1000" . $orderID;
        $message = "";
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";

        $message .= "<tr><td  style='padding:8px;'>A request for Return order received against order number: 1000{$orderID}, visit your panel to check the order details.</td></tr>";
        // $message .= "<tr><td style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
        // $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        // $message .= "<tr><td><h3>A .Your Return item details</h3></td></tr>";
        // $message .= "<tr><td >Order number : 1000{$orderID}</td></tr>";
        // $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<table>";
        // $image = getProductImage($data[0]->pro_id);
        // $image = base_url("uploads/thumbs/thumb_" . $image);
        // $discount = floatval($data[0]->act_price) - floatval($data[0]->pro_price);
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
        // $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . "  </td></tr>";
        $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";

        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        // $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";
        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($data[0]->email, 'Return Request');
        $this->email->to('retail.paulsons@gmail.com'); //support@paulsonsonline.com
        $this->email->bcc(array('gaurav@nibble.co.in'));
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function Exchangeproduct()
    {
        $orderID = $this->input->post('order_id');
        $oid = $this->input->post('o_id');
        $data = $this->user->customerOrder($orderID);
        // $this->db->update('tbl_customer_order', ['order_sta' => 10], ['id' => $orderID]);
        $this->db->update('tbl_order', ['order_status' => 10], ['id' => $oid]);
        $base = base_url();
        $baseurl = base_url("bootstrap/images/shipping.png");
        $subject = "Exchange order request: Order No:- 1000" . $orderID;
        $message = "";
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;padding:8px;margin:0 auto;background:#fff'>";
        $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";

        $message .= "<tr><td  style='padding:8px;'>A request for Exchange order received against order number: 1000{$orderID}, visit your panel to check the order details.</td></tr>";
        // $message .= "<tr><td style='border-bottom: 1px solid #0d7fe4'> &nbsp;</td></tr>";
        // $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        // $message .= "<tr><td><h3>A .Your Return item details</h3></td></tr>";
        // $message .= "<tr><td >Order number : 1000{$orderID}</td></tr>";
        // $message .= "<tr><td style='font-weight:bold'>&nbsp;</td></tr>";
        $message .= "<table>";
        // $image = getProductImage($data[0]->pro_id);
        // $image = base_url("uploads/thumbs/thumb_" . $image);
        // $discount = floatval($data[0]->act_price) - floatval($data[0]->pro_price);
        $message .= "<table style='border-collapse:collapse;font-family:Lao UI;width:50%;margin:0 auto;background:#fff;'>";
        // $message .= "<tr><td style='border-top:1px solid #777;border-left:1px solid #777;border-right:1px solid #777;border-radius:1px'> <img src='$image' /></td><td style='border-top:1px solid #777;border-right:1px solid #777;border-radius:1px;padding:8px;'>{$data[0]->pro_name} <br> <br> SKU : {$data[0]->sku} <br>Size : " . $data[0]->order_attr . "  </td></tr>";
        $message .= "<tr><td  style='border-top:1px solid #777;border-radius:1px' colspan='2' > &nbsp;</td></tr>";

        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        $message .= "<tr><td   colspan='2' > &nbsp;</td></tr>";
        // $message .= "<tr><td style='font-weight:bold; ;padding: 8px'><img src='$base/bootstrap/images/call-icon.png'></td><td ><b>Need Help? Get in touch</b> <br/>We are happy to help. For any assistance <a href='$base/Myaccount/contactus'>contact us</a></td></tr>";
        $message .= "<table>";
        $config = array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($data[0]->email, 'Exchange Request');
        $this->email->to('retail.paulsons@gmail.com');   //support@paulsonsonline.com
        $this->email->bcc(array('gaurav@nibble.co.in'));
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }
}
