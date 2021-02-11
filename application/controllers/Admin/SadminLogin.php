<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SadminLogin extends CI_Controller
{

    public $role, $userid;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'admin');
        $this->load->model('Vendor_model', 'vendor');
        $this->load->model('User_model', 'user');
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->helper('checkout');
        if (!$this->session->userdata('signupSession')) {
            return redirect('Admin/Loginvendor');
        } else {
            $this->role = $this->session->userdata('signupSession')['role'];
            $this->userid = $this->session->userdata('signupSession')['id'];
            $this->load->helper('getinfo');
        }

        // $this->user->addinCustomergroup();
    }

    public function test()
    {
        include_once APPPATH . "vendor/autoload.php";
        $client = new \DavGothic\SmushIt\Client\Curl();
        $smushit = new \DavGothic\SmushIt\SmushIt($client);
        // Compress a local/remote image and return the result object.
        $result = $smushit->compress(APPPATH . '../uploads/original/67be3126136449bf750057d47d02b861.jpg');
        print_r($result);
    }

    public function delete_cache_site()
    {

        $path = $this->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== false) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($cache_path . '/' . $file);
            }
        }

        closedir($handle);
        $this->db->cache_delete_all();
        echo "<script>window.history.go(-1);</script>";
    }

    public function editProductImage()
    {
        $id = (int) $this->encryption->decrypt(decode($this->input->post('name')));
        //$this->encryption->decrypt(decode($this->uri->segment(3)));
        if ($id > 0) {
            $config['upload_path'] = 'uploads/original';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();

                $query = $this->admin->updateImage($id, $uploadData['file_name']);
                $this->resizePro($uploadData['file_name']);
                $this->thumbnailPro($uploadData['file_name']);
                echo $query;
            } else {
                echo $this->upload->display_errors();
            }
            $this->db->cache_delete('Admin', 'SadminLogin');
        } else {
            echo show_404();
        }
    }

    public function loadChildSub()
    {
        $id = $this->input->post("cid");
        $data = $this->admin->getSubCategory($id);

        $option = "";
        foreach ($data as $id) {
            $option .= "<option value='$id->id'>$id->sub_name</option>";
        }
        echo $option;
    }

    private function get_innerAttribute($id)
    {
        $results = $this->vendor->getAttributeJoin($id);
        $option = "";
        if (count($results) > 0) {
            foreach ($results as $result) {
                $attr = str_replace(" ", "_", $result->attr_name);
                $prop = str_replace(" ", "_", $result->pop_name);
                $option .= "<option value='" . $prop . "|" . $attr . "'>$result->attr_name </option>";
            }
        } else {
            $option .= "<option value=''>No Attribute </option>";
        }
        return $option;
    }

    public function vendoraddproperties()
    {

        $selectProp = "";

        $results = $this->vendor->getProperties($this->encryption->decrypt(decode($this->input->post('category'))), $this->encryption->decrypt(decode($this->input->post('subcategory'))));
        $count = $this->input->post("co");
        $varCo = 0;
        foreach ($results as $key => $result) {
            $prop_name = str_replace(" ", "_", $result->pop_name);
            $selectProp .= <<<EOD
                    <td>
                         <select name="property{$count}[]" id="pd_attr">
                          <option value="">Select $result->pop_name</option>
                          {$this->get_innerAttribute($result->pid)}
                         </select>
                    </td>
EOD;

            $varCo++;
        }
        echo "<tr id='qtyval'>" . $selectProp . "<td> <input type='text' id='quantity' name='quantity[]' value=''/></td><td><button class='btn btn-xs btn-danger' onclick='deleteThis(this)'>Delete</button></td></tr>";
    }

    public function deleteChildSubCategory()
    {
        $id = $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($this->admin->deleteChild($id)) {
            $this->session->set_flashdata("msg", "<div class='alert alert-success'>Child Category Deleted Successgfully</div>");
        } else {
            $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Failed</div>");
        }
        $this->db->cache_delete("Admin", "SadminLogin");
        $this->db->cache_delete_all();
        echo "<script>window.history.go(-1);</script>";
    }

    public function rejectRequest()
    {

        if ($this->role == 1) {
            $id = $this->encryption->decrypt(decode($this->input->post('ui_ig')));
            $reject_reason = $this->security->xss_clean($this->input->post('reject_reason'));
            $count = $this->admin->loadProductId($id);
            if (count($count) > 0) {
                $this->admin->rejectRequest($id, $reject_reason);
                $this->db->cache_delete('Admin', 'SadminLogin');
                $this->db->cache_delete('Dashboard', 'p_');
                $this->db->cache_delete('Admin', 'Vendor');
                $this->session->set_flashdata('msg', ' <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Product has been rejected</a>
                            </div>
                        </div>');
                $this->db->cache_delete('Admin', 'SadminLogin');
                $this->db->cache_delete('Dashboard', 'p_');
                $this->db->cache_delete('Dashboard', 'getSearchCategory');
            } else {
                $this->session->set_flashdata('msg', ' <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">No record to reject</a>
                            </div>
                        </div>');
            }
            return redirect('Admin/SadminLogin/requested_product');
        } else {
            echo show_404();
        }
    }

    public function rejectRequestJq()
    {
        $string = base_url() . "Admin/SadminLogin/rejectRequest";
        $id = $this->input->post('id');
        echo form_open($string, array('method' => 'POST'));

        echo $html = <<<EOD
        <div style="position:fixed;margin:4% auto;left: 0;right: 0;z-index:99" class = "modal-dialog" role = "document">
        <div class = "modal-content">
        <div class = "modal-header">
        <button  onclick="$('#rejectPop').html('');" type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"></button>
        <h4 class = "modal-title">Are you sure?</h4>
        </div>
        <div class = "modal-body">
              <div class="form-group">
                    <div class="custom-checkbox custom-checkbox-success">
                      <label>Reject Reason</label>
                      <textarea name="reject_reason" required="" class="form-control" id="" cols="10" rows="5"></textarea>
               </div>
            </div>
        <input type='hidden' name="ui_ig" value='$id'>
        </div>
        <div class = "modal-footer">
        <button type = "button" onclick="$('#rejectPop').html('');"  class = "btn btn-default btn-tc btn-sm btn-waves" data-dismiss = "modal">Close</button>
        <button type = "submit" class = "btn btn-sm">Save changes</button>
        </div>
        </div>
        </div>
     </form>
EOD;
    }

    public function acceptRequest()
    {
        if ($this->role == 1) {
            $id = $this->encryption->decrypt(decode($this->uri->segment('4')));
            $count = $this->admin->loadProductId($id);
            if (count($count) > 0) {
                $this->admin->acceptRequest($id);
                $this->db->cache_delete('Admin', 'SadminLogin');
                $this->db->cache_delete('Dashboard', 'p_');
                $this->db->cache_delete('Dashboard', 'getSearchCategory');
                $this->db->cache_delete('Admin', 'Vendor');
                $this->session->set_flashdata('msg', ' <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Product has been accepted</a>
                            </div>
                        </div>');
            } else {
                $this->session->set_flashdata('msg', ' <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">No record to accept</a>
                            </div>
                        </div>');
            }
            return redirect('Admin/SadminLogin/requested_product');
        } else {
            echo show_404();
        }
    }

    public function dashboard()
    {
        $get = count($this->vendor->gettotnos());
        $glt = number_format(round($this->vendor->gettotprice(), 2));
        $gtu = count($this->vendor->gettotuser());
        $gtp = count($this->vendor->gettotproducts());
        $getord = $this->vendor->getlastprod();
        $this->load->view('Admin/config/header', array('title' => 'Welcome to dashboard'));
        $this->load->view('Admin/config/sidebar', array('active' => 'dashboard', 'action' => ''));
        $this->load->view('Admin/index', ['get'=>$get,'glt'=>$glt,'gtu'=>$gtu,'gtp'=>$gtp,'getord'=>$getord]);
        $this->load->view('Admin/config/footer');
    }

    public function orderdetails()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $ord_details = $this->user->allOrdersOrderId($id);

        //$rct_details = $this->vendor->order_details($id);
        $this->load->view('Admin/config/header', array('title' => 'Welcome to dashboard'));
        $this->load->view('Admin/config/sidebar', array('active' => 'dashboard', 'action' => ''));
        $this->load->view('Admin/orderdetails', array('details' => $ord_details));
        $this->load->view('Admin/config/footer');
    }

    public function uploadDocs()
    {
        $vendor_id = $this->input->post('hd_im'); //getting vendor id

        $this->load->model('Vendor_model', 'vendor');
        switch ($this->input->post('type')) {
            case "addProof":
                if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
                    $config['upload_path'] = 'uploads/addressProof/';
                    $config['allowed_types'] = 'jpg|png|pdf';
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $query = $this->vendor->setUploadDoc("addProof", $uploadData['file_name'], $this->encryption->decrypt(decode($vendor_id)));
                        echo $query;
                    } else {
                        echo $this->upload->display_errors();
                    }
                }

                break;
            case "panCard":
                if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
                    $config['upload_path'] = 'uploads/panCard/';
                    $config['allowed_types'] = 'jpg|png|pdf';
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $query = $this->vendor->setUploadDoc("panCard", $uploadData['file_name'], $this->encryption->decrypt(decode($vendor_id)));
                        echo $query;
                    } else {
                        echo $this->upload->display_errors();
                    }
                }

                break;
            case "profilePic":
                if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
                    $config['upload_path'] = 'uploads/profilePic/';
                    $config['allowed_types'] = 'jpg|png|pdf';
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $query = $this->vendor->setUploadDoc("profilePic", $uploadData['file_name'], $this->encryption->decrypt(decode($vendor_id)));
                        echo $query;
                    } else {
                        echo $this->upload->display_errors();
                    }
                }

                break;
            case "gstDoc":
                if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
                    $config['upload_path'] = 'uploads/gstDoc/';
                    $config['allowed_types'] = 'jpg|png|pdf';
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $query = $this->vendor->setUploadDoc("gstDoc", $uploadData['file_name'], $this->encryption->decrypt(decode($vendor_id)));
                        echo $query;
                    } else {
                        echo $this->upload->display_errors();
                    }
                }

                break;
            case "signature":
                if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
                    $config['upload_path'] = 'uploads/signature/';
                    $config['allowed_types'] = 'jpg|png|pdf';
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $query = $this->vendor->setUploadDoc("signature", $uploadData['file_name'], $this->encryption->decrypt(decode($vendor_id)));
                        echo $query;
                    } else {
                        echo $this->upload->display_errors();
                    }
                }

                break;
            case "cancelCheck":
                if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
                    $config['upload_path'] = 'uploads/cancelCheck/';
                    $config['allowed_types'] = 'jpg|png|pdf';
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $query = $this->vendor->setUploadDoc("cancelCheck", $uploadData['file_name'], $this->encryption->decrypt(decode($vendor_id)));
                        echo $query;
                    } else {
                        echo $this->upload->display_errors();
                    }
                }

                break;
        }
        $this->db->cache_delete('Admin', 'SadminLogin');
    }

    public function updateVendor()
    {
        $post_data = $this->input->post();
        $post_data = $this->security->xss_clean($post_data);
        $update = $this->admin->update_profile($post_data);
        if ($update) {
            $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Data Has Been Updated</a>
                            </div>
                        </div>
EOD;
            $this->session->set_flashdata('msg', $msg);
        } else {
            $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Unable To Update</a>
                            </div>
                        </div>
EOD;
            $this->session->set_flashdata('msg', $msg);
        }
        $this->db->cache_delete('Admin', 'SadminLogin');
        if ($this->role == 1) {

            return redirect('Admin/SadminLogin/editVendor/' . $this->encryption->decrypt(decode($post_data['hidden_id'])));
        } else {

            return redirect('Admin/SadminLogin/editProfile');
        }
    }

    public function editVendor()
    {
        if ($this->role == 1) {
            $this->load->helper('destination');
            $id = (int) $this->security->xss_clean($this->uri->segment(4));
            $data = ($this->admin->getInfoUser($id));
            $this->load->view('Admin/config/header', array('title' => 'Please update vendor information'));
            $this->load->view('Admin/config/sidebar', array('active' => 'profiles', 'action' => 'profilesview'));
            $this->load->view('Admin/editVendor', array('vendor' => $data));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function addAgents()
    {
        if ($this->role == 1) {
            $this->load->helper('destination');
            $this->load->view('Admin/config/header', array('title' => 'Please update vendor information'));
            $this->load->view('Admin/config/sidebar', array('active' => 'profiles', 'action' => 'profilesview'));
            $this->load->view('Admin/addVendor');
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function vendorCreation()
    {
        if ($this->role == 1) {
            $post = $this->security->xss_clean($this->input->post());
            $data = ($this->admin->addUserInfo($post));
            $this->db->cache_delete('Admin', 'SadminLogin');
            if ($data) {
                //  $this->sendPasswordToUser($data, $post['new_password']);
                $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Vendor entered successfully</a>
                            </div>
                        </div>
EOD;
                $this->session->set_flashdata('msg', $msg);
            } else {
                $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Something went wrong</a>
                            </div>
                        </div>
EOD;
                $this->session->set_flashdata('msg', $msg);
            }
            return redirect('Admin/SadminLogin/addAgents');
        } else {
            echo show_404();
        }
    }

    public function deleteVendor()
    {
        if ($this->role == 1) {
            $id = (int) $this->security->xss_clean($this->uri->segment(4));
            if ($this->admin->deleteVendor($id)) {
                $this->db->cache_delete('Admin', 'SadminLogin');
                $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Agent deleted successfully</a>
                            </div>
                        </div>
EOD;
                $this->session->set_flashdata('msg', $msg);
                return redirect('Admin/SadminLogin/profiles');
            } else {
                echo show_404();
            }
        } else {
            echo show_404();
        }
    }

    public function profiles()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'View vendor signup details'));
            $this->load->view('Admin/config/sidebar', array('active' => 'profiles', 'action' => 'profilesview'));
            $data = $this->admin->getVendorInfo($this->userid, $this->role);
            $html = '';
            $count = 1;
            foreach ($data as $vendorData) {
                $editUrl = site_url("Admin/SadminLogin/editVendor/" . $vendorData->id);
                $deleteUrl = site_url("Admin/SadminLogin/deleteVendor/" . $vendorData->id);
                $passwordSet = $vendorData->allow_login == 0 ? " <a href='#' onclick=setFirstTime('$vendorData->id') class='btn btn-xs btn-warning'><i class='fa fa-check-circle-o'></i> Allow for login</a> " : "";
                $loginSet = ($vendorData->allow_login == 1 && $vendorData->allow_product == 0) ? " <a href='#' onclick=allowProduct('$vendorData->id') class='btn btn-xs btn-warning'><i class='fa fa-check-circle-o'></i> Allow for product</a> " : "";
                $customStyle = $vendorData->is_admin == 1 ? "style='background-color:green;color:#fff'" : '';
                $html .= <<<EOD
                                           <tr>
                                                <td>$count</td>
                                                <td><a href="$editUrl" class=" btn btn-xs btn-success"> <i class="icon fa fa-edit"></i> Edit</a> <a href="$deleteUrl" onclick="return confirm('Are you sure!! you wanna delete this vendor')" class="btn btn-xs btn-danger"><i class=" fa fa-trash"></i> Delete</a>$passwordSet  $loginSet</td>
                                                <td $customStyle> SHP-VEN-00$vendorData->id</td>
                                                <td $customStyle>$vendorData->fname $vendorData->lname</td>
                                                <td $customStyle>$vendorData->emailadd</td>
                                                <td $customStyle>$vendorData->contactno</td>
                                                <td>$vendorData->state</td>
                                                <td>$vendorData->city</td>
                                                <td>$vendorData->zip</td>
                                                <td>$vendorData->pan</td>
                                            </tr>
EOD;
                $count++;
            }

            $this->load->view('Admin/viewSignup', array('vendors' => $html));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function addProperty()
    {

        $data = $this->admin->addProperty($this->input->post());
        $this->db->cache_delete('Admin', 'SadminLogin');
        if ($data == 1) {
            $this->session->set_flashdata('msg', "<div class='alert alert-success'> Successfully entered </div>");
        } else {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>  Already in database </div>");
        }
        return redirect('Admin/SadminLogin/addProp');
    }

    public function getSubcategory()
    {
        $id = $this->input->post('cat_id');
        $result = $this->admin->load_subcategories($id);
        $html = "<option value=''>Select Sub</option>";
        foreach ($result as $rs) {
            $html .= "<option value=" . $rs->id . ">$rs->sub_name</option>";
        }
        echo $html;
    }

    public function submitFirst()
    {

        if ($this->role == 1) {
            $data = $this->admin->setFirstPassword($this->input->post(null, true));
            if ($data) {
                $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Agent password has been set</a>
                            </div>
                        </div>
EOD;

                $mail = $this->sendPasswordToUser($this->input->post('ui_ig', true), $this->input->post('vendor_pass', true));
                $this->session->set_flashdata('msg', $msg);
                return redirect('Admin/SadminLogin/profiles');
            }
            $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Error! In Allow  process</a>
                            </div>
                        </div>
EOD;

            $this->session->set_flashdata('msg', $msg);
            return redirect('Admin/SadminLogin/profiles');
        } else {
            echo show_404();
        }
        //   print_r(password_hash($this->input->post('vendor_pass'), PASSWORD_DEFAULT));
    }

    private function sendPasswordToUser($id)
    {
        if ($this->role == 1) {
            $this->db->cache_delete('Admin', 'SadminLogin');
            $query = $this->admin->getInfoUser($id);
            $to_email = $query->emailadd;
            $subject = "Login Credentials For karzanddolls.om " . date("Y-m-d H:i");
            $message = "Dear " . $query->fname . ",";
            $message .= "<br><p>Thanks again to join us,Please find your login credentials";
            $message .= "<br> Username : $query->contactno  ";
            $message .= "<br><p>You need to enter these credentials on following page :(https://www.paulsonsonline.com/Admin/Loginvendor)</p>";

            if ($query) {
                $config = array(
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->reply_to('hello@paulsonsonline.com', 'PaulsonsOnline');
                $this->email->from('hello@paulsonsonline.com', 'PaulsonsOnline');
                $this->email->to($to_email);
                $this->email->bcc(array("ronjhiya.gaurav3@gmail.com"));
                $this->email->subject($subject);
                $this->email->message($message);

                $result = $this->email->send();
                if ($result) {
                    $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Mail has been sent successfully </a>
                            </div>
                        </div>
EOD;

                    $this->session->set_flashdata('emailmsg', $msg);
                    return true;
                }
                $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Error! in mail</a>
                            </div>
                        </div>
EOD;

                $this->session->set_flashdata('emailmsg', $msg);
                return false;
                //            echo $this->email->print_debugger();
            }
        } else {
            echo show_404();
        }
    }

    public function addWidget()
    {

        $this->load->library("form_validation");
        $this->form_validation->set_rules("bt", "Title", "required");
        $this->form_validation->set_rules("products[]", "Products", "required");
        $this->form_validation->set_rules("Number", "Number", "required|numeric");
        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/config/header', array('title' => 'addWidget'));
            $product = $this->admin->loadVendorProduct($this->userid, $this->role);
            $this->load->view('Admin/config/sidebar', array('active' => 'addWidget', 'action' => ''));
            $this->load->view('Admin/addWidget', compact("product"));
            $this->load->view('Admin/config/footer');
        } else {
            print_r($this->input->post());
        }
    }
    public function editProfile()
    {

        $this->load->helper('destination');
        $id = (int) $this->security->xss_clean($this->session->userdata('signupSession')['id']);
        $data = ($this->admin->getInfoUser($id));
        $this->load->view('Admin/config/header', array('title' => 'Please update you profile'));
        $this->load->view('Admin/config/sidebar', array('active' => '', 'action' => ''));
        $this->load->view('Admin/editVendor', array('vendor' => $data));
        $this->load->view('Admin/config/footer');
    }

    public function allowForProduct()
    {
        if ($this->role == 1) {
            $post = $this->input->post('data', true);

            $data = $this->admin->allowForProductUpload($post);
            $this->db->cache_delete('Admin', 'SadminLogin');
            if ($data) {
                $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"> Vendor allowed for prouct upload Process </a></div></div>');
            } else {
                $this->session->set_flashdata('insert', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"> Something went wrong  </a></div></div>');
            }
        } else {
            echo show_404();
        }
    }

    public function setFirstTime()
    {
        if ($this->role == 1) {
            $post = $this->input->post('data', true);
            $string = base_url() . "Admin/SadminLogin/submitFirst";
            echo form_open($string, array('method' => 'POST'));
            echo $html = <<<EOD
        <div class = "modal-dialog" role = "document">
        <div class = "modal-content">
        <div class = "modal-header">
        <button  onclick="$('#setMe').html('');" type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"></button>
        <h4 class = "modal-title">Are you sure?</h4>
        </div>
        <div class = "modal-body">

              <div class="form-group">
                    <div class="custom-checkbox custom-checkbox-success">
                       <input checked type="checkbox" value="1" name="allow_ven">
                      <label>Allow this vendor to login</label>
               </div>
            </div>
        <input type='hidden' name="ui_ig" value='$post'>
        </div>
        <div class = "modal-footer">
        <button type = "button" onclick="$('#setMe').html('');"  class = "btn btn-default btn-tc btn-sm btn-waves" data-dismiss = "modal">Close</button>
        <button type = "submit" class = "btn btn-sm">Save changes</button>
        </div>
        </div>
        </div>
     </form>
EOD;
        } else {
            echo show_404();
        }
    }

    public function categories()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'Categories Detail'));
            $this->load->view('Admin/config/sidebar', array('active' => 'categories', 'action' => ''));
            $data = $this->admin->load_categories();
            $this->load->view('Admin/categories', array('data' => $data));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function viewUser()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'View Users Details'));
            $this->load->view('Admin/config/sidebar', array('active' => 'viewuser', 'action' => ''));
            $data = $this->admin->view_users();
            $this->load->view('Admin/view_user', array('data' => $data));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function gift_to_wallet()
    {
        if ($this->role == 1) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules("Amount", "Amount", "required");
            if ($this->form_validation->run() == false) {
                $this->load->view('Admin/config/header', array('title' => 'Gift to the wallet'));
                $this->load->view('Admin/config/sidebar', array('active' => 'gift_to_wallet', 'action' => ''));

                $this->load->view('Admin/gift_to_wallet', array('data' => $this->uri->segment(4)));
                $this->load->view('Admin/config/footer');
            } else {
                $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
                $res = $this->admin->addToWallet($id, $this->input->post());

                $this->db->cache_delete_all();

                if ($this->sendWalletGift($id, $res[0]->wallet_amt)) {
                    $this->session->set_flashdata("msg", "<div class='alert alert-success'> wallet amount mail successfully sent to the user </div>");
                } else {
                    $this->session->set_flashdata("msg", "<div class='alert alert-danger'> wallet mail sending failed </div>");
                }
                return redirect('Admin/SadminLogin/viewUser');
            }

        } else {
            echo show_404();
        }

    }

    public function addCategory()
    {
        if ($this->role == 1) {
            $post = $this->security->xss_clean($this->input->post());

            $config['upload_path'] = 'uploads/category/original/';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('cat_image')) {
                $uploadData = $this->upload->data();
                $uploadedFile = $uploadData['file_name'];
                $this->resize($uploadedFile);
                $this->thumbnail($uploadedFile);
            } else {
                $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
            }
            if ($this->admin->addCategory($post, $uploadedFile)) {
                $this->db->cache_delete('Admin', 'SadminLogin');
                $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Category Inserted Successfully</a>
                            </div>
                        </div>
EOD;

                $this->session->set_flashdata('msg', $msg);
            } else {
                $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Error! in insertion</a>
                            </div>
                        </div>
EOD;

                $this->session->set_flashdata('msg', $msg);
            }
            return redirect('Admin/SadminLogin/categories');
        } else {
            echo show_404();
        }
    }

    private function resize($image)
    {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['width'] = '1920';
        $config['height'] = '239';
        $config['source_image'] = './uploads/category/original/' . $image;
        $config['new_image'] = './uploads/category/resize/resized_' . $image;
        $this->image_lib->initialize($config);
        if ($this->image_lib->resize()) {
            $this->thumbnail($image);
        } else {
            echo $this->image_lib->display_errors();
        }
    }

    private function thumbnail($image)
    {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['width'] = '80';
        $config['height'] = '80';
        $config['maintain_ratio'] = true;
        $config['create_thumb'] = true;
        $config['source_image'] = './uploads/category/original/' . $image;
        $config['new_image'] = './uploads/category/thumbnail/thumb_' . $image;
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }

    private function resizePro($image)
    {
        $this->load->library('image_lib');
        $config['width'] = '300';
        $config['maintain_ratio'] = true;
        $config['source_image'] = './uploads/original/' . $image;
        $config['new_image'] = './uploads/resized/resized_' . $image;
        $this->image_lib->initialize($config);
        if ($this->image_lib->resize()) {
            // $this->thumbnail($image);
            $this->thumbnailPro($image);
        } else {
            echo $this->image_lib->display_errors();
        }
    }

    private function thumbnailPro($image)
    {
        $this->load->library('image_lib');
        $config['width'] = '100';
        $config['maintain_ratio'] = true;
        $config['maintain_ratio'] = true;
        $config['create_thumb'] = true;
        $config['source_image'] = './uploads/original/' . $image;
        $config['new_image'] = './uploads/thumbs/thumb_' . $image;
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }

    public function getChildSub()
    {
        $_child = $this->encryption->decrypt(decode($this->uri->segment("4")));
        $this->load->view('Admin/config/header', array('title' => 'Sub-Categories Detail'));
        $this->load->view('Admin/config/sidebar', array('active' => 'subcategories', 'action' => ''));
        $data = $this->admin->getSubChildCategory($_child);
        $this->load->view('Admin/childSub', array('data' => $data));
        $this->load->view('Admin/config/footer');
    }

    public function editChildSubCategory()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('cat_sub', 'Category Name', 'required');
        $this->form_validation->set_rules('sub_category', 'Sub Category Name', 'required');
        $this->form_validation->set_rules('child_sub_name', 'Sub Child Category Name', 'required');

        if ($this->form_validation->run() == false) {
            $id = $this->encryption->decrypt(decode($this->uri->segment(4)));
            $this->load->view('Admin/config/header', array('title' => 'Edit Child Sub-Categories Detail'));
            $categories = $this->admin->load_categories();
            $sub_cat = $this->admin->loadedit_subcat($id);
            $subcategory = $this->admin->loadedit_subcat($sub_cat->parent_sub);

            $this->load->view('Admin/config/sidebar', array('active' => 'addchildsubcategories', 'action' => ''));
            $this->load->view('Admin/addChildSub', array('categories' => $categories, "subcategories" => $subcategory, "sub" => $sub_cat));
            $this->load->view('Admin/config/footer');
        } else {

            $config['upload_path'] = 'uploads/childSub/';
            $config['allowed_types'] = 'jpg|png';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('childImage')) {
                $uploadData = $this->upload->data();

                $uploadedFile = $uploadData['file_name'];
                $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                     <div class="alert-body">
                         <strong>Heads up! </strong>
                         This <a href="#" class="alert-link link-underline">Image Uploaded</a></div></div>');
            } else {
                $this->session->set_flashdata('insert', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
            }
            $return = $this->admin->updateChildSub($this->input->post(), $uploadedFile);
            $this->db->cache_delete("Admin", "SadminLogin");
            if ($return) {
                $this->session->set_flashdata("msg", "<div class='alert alert-success'> Data updated successfully </div>");
            } else {
                $this->session->set_flashdata("msg", "<div class='alert alert-danger'>  Updation failed </div>");
            }
            return redirect("Admin/SadminLogin/editChildSubCategory/" . ($this->uri->segment(4)));
        }
    }

    //  public function addMultiplePhotoToCart() {
    //     $filesCount = count($_FILES['uploadFile']['name']);
    //     for ($i = 0; $i < $filesCount; $i++) {
    //         $_FILES['file']['name'] = $_FILES['uploadFile']['name'][$i];
    //         $_FILES['file']['type'] = $_FILES['uploadFile']['type'][$i];
    //         $_FILES['file']['tmp_name'] = $_FILES['uploadFile']['tmp_name'][$i];
    //         $_FILES['file']['error'] = $_FILES['uploadFile']['error'][$i];
    //         $_FILES['file']['size'] = $_FILES['uploadFile']['size'][$i];
    //         $config['upload_path'] = './uploads/';
    //         $config['encrypt_name'] = true;
    //         $config['allowed_types'] = 'gif|jpg|png|jpeg';
    //         $this->load->library('upload', $config);
    //         if (!$this->upload->do_upload("file")) {
    //             $error = array('error' => $this->upload->display_errors());
    //             $this->session->set_flashdata("msg", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
    //         } else {
    //             $data = array('upload_data' => $this->upload->data());
    //             $session = [];
    //             if ($this->session->userdata('photoAddCart') == null) {
    //                 $session[] = array("color_type" => $this->input->post('color_type'), "no_of_frame" => $this->input->post('no_of_copies'), "frame_size" => $this->input->post('frame_size'), "file_name" => $data["upload_data"]["file_name"]);
    //                 $this->session->set_userdata('photoAddCart', $session);
    //             } else {
    //                 $session = $this->session->userdata('photoAddCart');
    //                 $session[] = array("color_type" => $this->input->post('color_type'), "no_of_frame" => $this->input->post('no_of_copies'), "frame_size" => $this->input->post('frame_size'), "file_name" => $data["upload_data"]["file_name"]);
    //                 $this->session->set_userdata('photoAddCart', $session);
    //             }
    //             $this->session->set_flashdata("msg", "<div class='alert alert-success'>Product has been added to cart</div>");
    //         }
    //     }
    //     return redirect("Home/mphotoPrint");
    // }

    public function addSwatch()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("color[]", "Color", "required");

        if ($this->form_validation->run() == false) {
            $decodeId = $this->encryption->decrypt(decode($this->uri->segment(4)));
            $data = $this->vendor->getProduct($decodeId)->product_attr;
            $productData = $this->vendor->getProduct($decodeId);
            $swatchData = $this->vendor->getSwatch($decodeId);
            $this->load->library('form_validation');
            $this->load->view('Admin/config/header', array('title' => 'Set Attribute Name'));
            $this->load->view('Admin/config/sidebar', array('active' => 'attrname', 'action' => ''));
            $this->load->view('Admin/addSwatch', array('properties' => $data, "swatch" => $swatchData, 'proid' => $this->uri->segment(3), "prodata" => $productData));
            $this->load->view('Admin/config/footer');
        } else {
            $this->upload_files("uploads/swatch", $this->input->post("color"), $this->encryption->decrypt(decode($this->input->post("proid"))), $_FILES['color_pic']);
            $this->session->set_flashdata("<div class='alert alert-success'>Swatch Images Uploaded</div>");
            return redirect("SadminLogin/addSwatch/" . $this->input->post("proid"));
        }
    }

    private function upload_files($path, $color, $pro, $files)
    {
        $config = array(
            'upload_path' => $path,
            'allowed_types' => 'jpg|gif|png',
            'overwrite' => 1,
            "encrypt_name" => true,
        );

        $this->load->library('upload', $config);

        $images = array();

        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name'] = $files['name'][$key];
            $_FILES['images[]']['type'] = $files['type'][$key];
            $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['images[]']['error'] = $files['error'][$key];
            $_FILES['images[]']['size'] = $files['size'][$key];
            $fileName = $image;
            $images[] = $fileName;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('images[]')) {
                $uploadData = $this->upload->data();
                $uploadedFile = $uploadData['file_name'];
                $this->vendor->addSwatch($color[$key], $pro, $uploadedFile);
            }
        }
    }

    public function childsub()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cat_sub', 'Category Name', 'required');
        $this->form_validation->set_rules('sub_category', 'Sub Category Name', 'required');
        $this->form_validation->set_rules('child_sub_name', 'Sub Child Category Name', 'required');

        if ($this->form_validation->run() == false) {
            if ($this->role == 1) {
                $this->load->view('Admin/config/header', array('title' => 'Add Child Sub-Categories Detail'));
                $categories = $this->admin->load_categories();
                $this->load->view('Admin/config/sidebar', array('active' => 'addchildsubcategories', 'action' => ''));
                $this->load->view('Admin/addChildSub', array('categories' => $categories));
                $this->load->view('Admin/config/footer');
            } else {
                echo show_404();
            }
        } else {

            $config['upload_path'] = 'uploads/childSub/';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('childImage')) {
                $uploadData = $this->upload->data();

                $uploadedFile = $uploadData['file_name'];
                $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                     <div class="alert-body">
                         <strong>Heads up! </strong>
                         This <a href="#" class="alert-link link-underline">Image Uploaded</a></div></div>');
            } else {
                $this->session->set_flashdata('insert', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
            }

            $data = $this->admin->addChildCategory($this->input->post(), $uploadedFile);

            if ($data) {
                $this->session->set_flashdata("msg", "<div class='alert alert-success'>Child Subcategory Added Successfully</div>");
            } else {
                $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Something Went Wrong</div>");
            }
            return redirect("Admin/SadminLogin/childsub");
        }
    }

    public function addsub()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'Add Sub-Categories Detail'));
            $categories = $this->admin->load_categories();
            $subcat = $this->admin->loadAllSubCategory();

            $this->load->view('Admin/config/sidebar', array('active' => 'addsubcategories', 'action' => ''));
            $this->load->view('Admin/addSubCat', array('categories' => $categories, "subcat" => $subcat));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function addSubCategory()
    {
        $this->load->library('form_validation');
        $error = $this->form_validation->set_rules('sub_image', '', 'callback_file_check');
        // $error = $this->form_validation->set_rules('size_chart', '', 'callback_file_check');

        //upload configuration
        if ($this->form_validation->run() == true) {
            $config['upload_path'] = 'uploads/sizechart/';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $uploadedFile2 = "";
            //upload file to directory
            if ($this->upload->do_upload('size_chart')) {
                $uploadData2 = $this->upload->data();
                $uploadedFile2 = $uploadData2['file_name'];
            }

            //upload configuration
            $config2['upload_path'] = 'uploads/subcategory/';
            $config2['allowed_types'] = '*';
            $config2['encrypt_name'] = true;
            $this->load->library('upload', $config2);
            $this->upload->initialize($config2);

            //upload file to directory
            if ($this->upload->do_upload('sub_image')) {
                $uploadData = $this->upload->data();
                $uploadedFile = $uploadData['file_name'];
                $data = $this->security->xss_clean($this->input->post());
                $return = $this->admin->addSubcategory($data, $uploadedFile, $uploadedFile2);
                if ($return) {
                    $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
                } else {
                    $this->session->set_flashdata('insert', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Insertion failed</a></div></div>');
                }
                $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">File has been uploaded successfully.</a></div></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
            }
            $this->db->cache_delete('Admin', 'SadminLogin');
            return redirect('Admin/SadminLogin/addsub');
        } else {
            return redirect('Admin/SadminLogin/addsub');
        }
    }

    public function editCategory()
    {
        $catid = (int) $this->encryption->decrypt(decode($this->uri->segment(4), 'Test@123#'));

        if ($catid != 0) {
            $categories = $this->admin->load_categories_id($catid);
        } else {
            echo show_404();
        }
        if (@count($categories) > 0) {
            $this->load->view('Admin/config/header', array('title' => 'Update Categories Detail'));
            $this->load->view('Admin/config/sidebar', array('active' => 'categories', 'action' => ''));
            $this->load->view('Admin/editcategory', array('data' => $categories));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
        $this->db->cache_delete('Admin', 'SadminLogin');
    }

    public function updateCategory()
    {
        $image_name = "";
        $post = $this->security->xss_clean($this->input->post());

        if (isset($_FILES['cat_image']['name']) && $_FILES['cat_image']['name'] != "") {
            $config['upload_path'] = 'uploads/category/original/';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('cat_image')) {
                $uploadData = $this->upload->data();

                $image_name = $uploadData['file_name'];
                $this->resize($image_name);
                $this->thumbnail($image_name);
            } else {
                print_r($this->upload->display_errors());
                die;
            }
        }
        $data = $this->admin->updateCategory($post, $image_name);
        $this->db->cache_delete('Admin', 'SadminLogin');
        if ($data) {
            $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data updated successfully.</a></div></div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Something went wrong.</a></div></div>');
        }
        return redirect('Admin/SadminLogin/categories');
    }

    public function file_check($str)
    {

        $allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png', 'gif');

        $mime = explode(".", $_FILES['sub_image']['name']);
        $mime_count = count($mime);

        if (isset($_FILES['sub_image']['name']) && $_FILES['sub_image']['name'] != "") {
            if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please select only   jpg/png file.</a></div></div>');
                return false;
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please choose a file to upload.</a></div></div>');
            return false;
        }
    }

    public function subCategory()
    {
        if ($this->role == 1) {
            $uri = $this->encryption->decrypt(decode($this->uri->segment('4'), 'Test@123#'));
            if ($uri) {
                $this->load->view('Admin/config/header', array('title' => 'Sub-Categories Detail'));
                $this->load->view('Admin/config/sidebar', array('active' => 'subcategories', 'action' => ''));
                $data = $this->admin->load_subcategories($uri);
                $this->load->view('Admin/subcategories', array('data' => $data));
                $this->load->view('Admin/config/footer');
            } else {
                echo show_404();
            }
        } else {
            echo show_404();
        }
    }

    public function editSubCategory()
    {

        if ($this->role == 1) {

            $id = $this->encryption->decrypt(decode($this->uri->segment(4)));

            $categories = $this->admin->load_categories();
            $this->load->view('Admin/config/header', array('title' => 'Sub-Categories Detail'));
            $this->load->view('Admin/config/sidebar', array('active' => 'subcategories', 'action' => ''));
            $data = $this->admin->loadedit_subcat($id);

            $this->load->view('Admin/edit_sub', array('data' => $data, 'categories' => $categories, 'url' => $this->uri->segment(4)));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function update_category()
    {
        $this->load->library('form_validation');
        $error = $this->form_validation->set_rules('sub_image', '', 'callback_file_check');
        //$error = $this->form_validation->set_rules('size_chart', '', 'callback_file_check');
        if ($_FILES['sub_image']['name'] != '' && $_FILES['size_chart']['name'] == '') {

            if ($this->form_validation->run() == true) {
                $config['upload_path'] = 'uploads/subcategory/';
                $config['allowed_types'] = '*';
                $config['encrypt_name'] = true;
                // echo "<pre>";
                // print_r($config);
                // die;
                $this->load->library('upload', $config);
                //upload file to directory
                if ($this->upload->do_upload('sub_image')) {
                    $uploadData = $this->upload->data();
                    $uploadedFile = $uploadData['file_name'];
                    $this->admin->update_category($this->security->xss_clean($this->input->post()), $uploadedFile, $this->input->post('size_chart_image'));

                    $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
                } else {

                    $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
                }
            }
        } else if ($_FILES['sub_image']['name'] == '' && $_FILES['size_chart']['name'] != '') {

            $config2['upload_path'] = 'uploads/sizechart/';
            $config2['allowed_types'] = '*';
            $config2['encrypt_name'] = true;
            $this->load->library('upload', $config2);

            //upload file to directory
            if ($this->upload->do_upload('size_chart')) {
                $uploadData = $this->upload->data();
                $uploadedFile = $uploadData['file_name'];
                $this->admin->update_category($this->security->xss_clean($this->input->post()), $this->input->post('sub_image_two'), $uploadedFile);

                $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
            }
        } else if ($_FILES['sub_image']['name'] != '' && $_FILES['size_chart']['name'] != '') {

            if ($this->form_validation->run() == true) {
                $this->load->library('upload');
                $config['upload_path'] = 'uploads/sizechart/';
                $config['allowed_types'] = '*';
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);

                $sizeChart = "";
                $subCategory = "";
                if ($this->upload->do_upload('size_chart')) {
                    $uploadData = $this->upload->data();
                    $sizeChart = $uploadData['file_name'];
                }

                $config['upload_path'] = 'uploads/subcategory/';
                $config['allowed_types'] = '*';
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('sub_image')) {
                    $uploadData = $this->upload->data();
                    $subCategory = $uploadData['file_name'];
                } else {

                }

                //upload file to directory
                if ($sizeChart != '' && $subCategory != '') {

                    $this->admin->update_category($this->security->xss_clean($this->input->post()), $subCategory, $sizeChart);

                    $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
                }
            }
        } else {
            $this->admin->update_category($this->security->xss_clean($this->input->post()), $this->input->post('sub_image_two'), $this->input->post('size_chart_image'));
            $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
        }
        $this->db->cache_delete('Admin', 'SadminLogin');
        $this->db->cache_delete('Dashboard', 'pd_');
        $this->db->cache_delete('Dashboard', 'p_');
        return redirect('Admin/SadminLogin/editSubCategory/' . $this->input->post('hidden_id'));
    }

    public function deleteSubCategory()
    {
        if ($this->role == 1) {
            $id = $this->encryption->decrypt(decode($this->uri->segment(4)));

            $data = $this->admin->deletesub($id);
            if ($data) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"></a>Record deleted successfully</div></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                 <a href="#" class="alert-link link-underline"></a>Something went wrong</div></div>');
            }
            $this->db->cache_delete('Admin', 'SadminLogin');
        } else {
            echo show_404();
        }
    }

    public function view_sub()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'Sub-Categories Detail'));
            $this->load->view('Admin/config/sidebar', array('active' => 'subcategories', 'action' => ''));
            $data = $this->admin->load_subcategories($uri);
            $this->load->view('Admin/subcategories', array('data' => $data));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function deleteCategory()
    {
        if ($this->role == 1) {
            $uri = $this->encryption->decrypt(decode($this->uri->segment('4'), 'Test@123$'));

            if ($this->admin->deleteCategory($uri)) {
                $this->db->cache_delete('Admin', 'SadminLogin');
                $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Deleted</a>
                            </div>
                        </div>
EOD;

                $this->session->set_flashdata('msg', $msg);
                return redirect('Admin/SadminLogin/categories');
            } else {

                $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Error! in deletion</a>
                            </div>
                        </div>
EOD;

                $this->session->set_flashdata('msg', $msg);
                return redirect('Admin/SadminLogin/categories');
            }
        } else {
            echo show_404();
        }
    }

    public function requested_product()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'Requested Products'));
            $this->load->view('Admin/config/sidebar', array('active' => 'request_pro', 'action' => ''));
            $data = $this->admin->loadVendorProductRequest();

            $this->load->view('Admin/product_request', array('product' => $data));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function viewProductRequest()
    {
        $this->load->view('Admin/config/header', array('title' => 'Requested Products'));
        $this->load->view('Admin/config/sidebar', array('active' => 'request_pro', 'action' => ''));
        $id = $this->encryption->decrypt(decode($this->uri->segment(4)));
        $data = $this->admin->loadVendorProductRequestById($id);

        $this->load->view('Admin/viewProductRequest', array('product' => $data));
        $this->load->view('Admin/config/footer');
    }

    public function getImages()
    {
        $image = $this->encryption->decrypt(decode($this->uri->segment(4)));

        $this->load->view('Admin/config/header', array('title' => 'All Images'));
        $this->load->view('Admin/config/sidebar', array('active' => 'request_pro', 'action' => ''));
        $images = $this->admin->getImages($image);
        $this->load->view('Admin/allImage', array('images' => $images));
        $this->load->view('Admin/config/footer');
    }

    public function deletename()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($id > 0) {
            $this->admin->deletePropName($id);
            $this->db->cache_delete('Admin', 'SadminLogin');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'> Deleted Successfully</div>");
            return redirect('Admin/SadminLogin/propName');
        } else {
            echo show_404();
        }
    }

    public function del_prime()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($id > 0) {
            $this->admin->deletePrime($id);
            $this->db->cache_delete('Admin', 'SadminLogin');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'> Deleted Successfully</div>");
            return redirect('Admin/SadminLogin/prime_member');
        } else {
            echo show_404();
        }
    }

    public function offercode()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("offer_name", "Offer Name", "required");
        $this->form_validation->set_rules("offer_code", "Offer Code", "required|is_unique[tbl_offer_code.offer_code]");
        $this->form_validation->set_rules("offer_val", "Offer Value", "required|numeric");
        $this->form_validation->set_rules("min_val", "Min Value", "required|numeric");
        $this->form_validation->set_rules("priority", "priority", "required|numeric");
        $this->form_validation->set_rules("offer_per_customer", "Offer Per Customer", "required|numeric");

        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/config/header', array('title' => 'Offer Code'));
            $this->load->view('Admin/config/sidebar', array('active' => 'offercode', 'action' => ''));
            $data = $this->admin->load_offercode($this->role);
            $categories = $this->admin->load_categories();
            $group = $this->admin->getUserGroup();
            // $sub_categories = $this->admin->getAll_subcategories();
            $this->load->view('Admin/addOffer', array('group' => $group, 'offer' => $data, 'categories' => $categories));
            $this->load->view('Admin/config/footer');
        } else {
            $query = $this->admin->addOfferCode($this->input->post());

            if ($query) {
                $this->session->set_flashdata("msg", "<div class='alert alert-success'>Offer Created Succesfully</div>");
            }
            //$this->admin->addOfferCatWise($this->input->post());
            $this->db->cache_delete("Admin", "SadminLogin");
            $this->db->cache_delete("Dashboard", "pd_");
            $this->db->cache_delete("Dashboard", "p_");
            return redirect("Admin/SadminLogin/offercode");
        }
    }

    public function edit_AssignGroup()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("user_name[]", "Group Name", "required");
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));

        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/config/header', array('title' => 'Offer Code'));
            $this->load->view('Admin/config/sidebar', array('active' => 'offercode', 'action' => ''));
            $userInfo = $this->admin->getuserdata($id);
            $data = $this->admin->getAssignGroup($id);
            $groupList = $this->admin->getUserGroup();
            $this->load->view('Admin/updateUserGroup', array('userInfo' => $userInfo, 'groupList' => $groupList, 'group' => $data));
            $this->load->view('Admin/config/footer');
        } else {
            $res = $this->admin->updateAssignGroup($this->input->post(), $id);
            if ($res) {
                $this->db->cache_delete("Admin", "SadminLogin");
                $this->session->set_flashdata('msg', '<div class="alert alert-success"> Group Name Update Successfully</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger"> Group Name  not Update !</div>');
            }

            return redirect("Admin/SadminLogin/customerGroup");
        }
    }

    public function delete_createGroup()
    {
        $user_id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $res = $this->admin->delete_createGroup($user_id);
        if ($res) {
            $this->db->cache_delete("Admin", "SadminLogin");
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Delete Group .</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger"> Group not Deleted !</div>');
        }
        return redirect("Admin/SadminLogin/createGroup");
    }
    public function delete_AssignGroup()
    {
        $user_id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $res = $this->admin->delete_AssignGroup($user_id);
        if ($res) {
            $this->db->cache_delete("Admin", "SadminLogin");
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Delete Customer Assigned Group .</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger"> Customer Group not Created !</div>');
        }
        return redirect("Admin/SadminLogin/customerGroup");
    }
    public function createGroup()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("group", "Group Name", "required");
        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/config/header', array('title' => 'Create Group'));
            $this->load->view('Admin/config/sidebar', array('active' => 'createGroup', 'action' => ''));
            $data = $this->admin->getUserGroup();
            $this->load->view('Admin/createGroup', array("data" => $data));
            $this->load->view('Admin/config/footer');
        } else {
            $res = $this->admin->createUserGroup($this->input->post());
            if ($res) {
                $this->db->cache_delete("Admin", "SadminLogin");
                $this->session->set_flashdata('msg', '<div class="alert alert-success"> New Group Created Successfully</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger"> Customer Group not Created !</div>');
            }

            return redirect("Admin/SadminLogin/createGroup");
        }
    }
    public function update_createGroup()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("group", "Group Name", "required");
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));

        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/config/header', array('title' => 'Offer Code'));
            $this->load->view('Admin/config/sidebar', array('active' => 'offercode', 'action' => ''));
            $data = $this->admin->getUserGroupByID($id);
            $this->load->view('Admin/update_createGroup', array("data" => $data));
            $this->load->view('Admin/config/footer');
        } else {
            $res = $this->admin->editUserGroup($this->input->post(), $id);
            if ($res) {
                $this->db->cache_delete("Admin", "SadminLogin");
                $this->session->set_flashdata('msg', '<div class="alert alert-success"> Group Name Update Successfully</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger"> Group Name  not Update !</div>');
            }

            return redirect("Admin/SadminLogin/createGroup");
        }
    }

    public function customerGroup()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("customer_grp", "Group Name", "required");
        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/config/header', array('title' => 'Add Customer In Groups'));
            $this->load->view('Admin/config/sidebar', array('active' => 'customerGroup', 'action' => ''));
            $data = $this->admin->UnBlockUsers();
            $group = $this->admin->getUserGroup();
            $this->load->view('Admin/createCustomerGroup', array('data' => $data, 'group' => $group));
            $this->load->view('Admin/config/footer');
        } else {
            $res = $this->admin->addCustomerGroup($this->input->post());
            if ($res) {
                $this->db->cache_delete("Admin", "SadminLogin");
                $this->session->set_flashdata('msg', '<div class="alert alert-success"> Customer Group Created Successfully</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger"> Customer Group not add</div>');
            }

            return redirect("Admin/SadminLogin/customerGroup");
        }
    }

    public function prime_member()
    {

        $this->load->library("form_validation");

        $this->form_validation->set_rules("prime_val", "Prime Value", "required|numeric");
        $this->form_validation->set_rules("offer_validity_from", "From Value", "required");
        $this->form_validation->set_rules("offer_validity_to", "To Value", "required");

        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/config/header', array('title' => 'Create Prime Membership'));
            $this->load->view('Admin/config/sidebar', array('active' => 'prime_member', 'action' => ''));
            $data = $this->admin->load_primeMember($this->role);
            $this->load->view('Admin/addPrimeMember', array('offer' => $data));
            $this->load->view('Admin/config/footer');
        } else {
            $this->admin->addPrime($this->input->post());
            $this->db->cache_delete("Admin", "SadminLogin");
            $this->db->cache_delete("Dashboard", "pd_");
            $this->db->cache_delete("Dashboard", "p_");
            return redirect("Admin/SadminLogin/prime_member");
        }
    }

    public function propname()
    {
        $this->load->library('form_validation');
        $properties = $this->admin->getPropertiesName();
        $this->form_validation->set_rules('propname', 'Property Name', 'required');
        if ($this->form_validation->run() == false) {
            if ($this->role == 1) {
                $this->load->view('Admin/config/header', array('title' => 'Set Properties Name'));
                $this->load->view('Admin/config/sidebar', array('active' => 'propname', 'action' => ''));
                $this->load->view('Admin/allProp', array('properties' => $properties));
                $this->load->view('Admin/config/footer');
            } else {
                echo show_404();
            }
        } else {

            $propname = $this->security->xss_clean($this->input->post());
            $query = $this->admin->setPropertiesName($propname);
            $this->db->cache_delete('Admin', 'SadminLogin');
            $this->session->set_flashdata('msg', "<div class='alert alert-success'> Inserted Successfully</div>");
            return redirect('Admin/SadminLogin/propName');
        }
    }

    public function deleteProp()
    {

        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($id > 0) {
            $this->admin->deleteProp($id);
            $this->db->cache_delete('Admin', 'SadminLogin');
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Deleted Successfully</div>');
            return redirect('Admin/SadminLogin/addProp');
        } else {
            echo show_404();
        }
    }

    public function deleteAttr()
    {

        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($id > 0) {
            $this->admin->deleteAttr($id);
            $this->db->cache_delete('Admin', 'SadminLogin');
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Deleted Successfully</div>');
            return redirect('Admin/SadminLogin/addSubProp');
        } else {
            echo show_404();
        }
    }

    public function addProp()
    {
        $this->load->library('form_validation');
        $this->load->view('Admin/config/header', array('title' => 'Set Properties Name'));
        $this->load->view('Admin/config/sidebar', array('active' => 'addproperties', 'action' => ''));
        $properties = $this->admin->getPropertiesName();
        $category = $this->admin->load_categories();
        $allProp = $this->admin->getAllProperties();
        $this->load->view('Admin/addProperties', array('properties' => $properties, 'categories' => $category, 'allProp' => $allProp));
        $this->load->view('Admin/config/footer');
    }

    public function addSubProp()
    {
        $this->load->library('form_validation');
        $this->load->view('Admin/config/header', array('title' => 'Set Attribute Name'));
        $this->load->view('Admin/config/sidebar', array('active' => 'attrname', 'action' => ''));
        $properties = $this->admin->getPropertiesName();
        $attr = $this->admin->getAttrName();
        $this->load->view('Admin/subprop', array('properties' => $properties, 'attr' => $attr));
        $this->load->view('Admin/config/footer');
    }

    public function addAttr()
    {
        $data = ($this->input->post());

        $this->admin->addAttr($data);
        $this->db->cache_delete('Admin', 'SadminLogin');
        return redirect('Admin/SadminLogin/addSubProp');
    }

    public function getProductProperties()
    {
        $prop = $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->load->view('Admin/config/header', array('title' => 'All Images'));
        $this->load->view('Admin/config/sidebar', array('active' => 'request_pro', 'action' => ''));

        $properties = $this->admin->getProperties($prop);

        $this->load->view('Admin/allProductProp', array('properties' => $properties));
        $this->load->view('Admin/config/footer');
    }

    public function editPropAttrName()
    {
        $decodeId = $this->encryption->decrypt(decode($this->uri->segment(4)));
        $data = $this->vendor->getProduct($decodeId)->product_attr;
        $productData = $this->vendor->getProduct($decodeId);
        $this->load->library('form_validation');
        $this->load->view('Admin/config/header', array('title' => 'Set Attribute Name'));
        $this->load->view('Admin/config/sidebar', array('active' => 'attrname', 'action' => ''));
        $this->load->view('Admin/editAttribute', array('properties' => $data, 'proid' => $this->uri->segment(4), "prodata" => $productData));
        $this->load->view('Admin/config/footer');
    }

    public function updatePropAttr()
    {

        $attr = [];
        $proid = $this->encryption->decrypt(decode($this->input->post("proid")));

        foreach ($this->input->post("quantity") as $qt_key => $qty) {
            $inerr = [];
            foreach ($this->input->post("property$qt_key") as $attributes) {
                $var = explode("|", $attributes);
                $inerr[] = array("$var[0]" => $var[1]);
            }
            $attr["response"][] = array("attribute" => $inerr, "qty" => $qty, "changedPrice" => "0");
        }

        $attributejson = json_encode($attr);

        $result = $this->vendor->updateAttr($proid, $attributejson);
        if ($result) {
            $this->db->cache_delete('Admin', 'SadminLogin');
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Updated Successfully</div>');
            return redirect('Admin/SadminLogin/editPropAttrName/' . $this->input->post("proid"));
        }
    }

    public function updatePropAttrName()
    {

        $pro_id = $this->encryption->decrypt(decode($this->input->post('proid')));
        $data = $this->vendor->getProduct($pro_id)->product_attr;

        $decode = (json_decode($data));
        $quantity = 0;
        foreach ($decode->response as $key => $response) {
            $response->qty = $this->input->post('qty')[$key];
            $quantity += floatval($this->input->post('qty')[$key]);
        }

        $qtychange = json_encode($decode);
        $this->vendor->updateProAttribute($pro_id, $qtychange, $quantity);
        $this->db->cache_delete('Admin', 'SadminLogin');
        return redirect("Admin/Vendor/vendor_products");
    }

    public function deletePropAttrName()
    {

        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $index = (int) $this->encryption->decrypt(decode($this->uri->segment(5)));
        $this->admin->deletePropAttrName($id, $index);
        $this->db->cache_delete('Admin', 'SadminLogin');
        $this->session->set_flashdata('msg', '<div class="alert alert-success"> Deleted Successfully</div>');
        return redirect('Admin/SadminLogin/requested_product');
    }

    public function logout()
    {
        $this->session->unset_userdata('signupSession');
        return redirect('Admin/Loginvendor');
    }

    public function block()
    {
        $userid = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->blockuser($userid);
        $this->db->cache_delete('Admin', 'SadminLogin');
        return redirect('Admin/SadminLogin/viewUser');
    }

    public function unblock()
    {
        $userid = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->unblockuser($userid);
        $this->db->cache_delete('Admin', 'SadminLogin');
        return redirect('Admin/SadminLogin/viewUser');
    }

    public function update_user()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_email', 'Email', 'required');
        $this->form_validation->set_rules('user_name', 'First Name', 'trim|required|alpha');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|alpha');
        $this->form_validation->set_rules('user_contact', 'contact number', 'trim|required|numeric|exact_length[10]');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        if ($this->form_validation->run() == false) {

            $this->load->view('Admin/config/header', array('title' => 'Welcome to dashboard'));
            $this->load->view('Admin/config/sidebar', array('active' => 'dashboard', 'action' => ''));

            $get = $this->admin->getuserdata($id);
            $this->load->view('Admin/editUser', array('user' => $get));
            $this->load->view('Admin/config/footer');
        } else {
            $post_data = $this->security->xss_clean($this->input->post());
            $this->admin->updateuser($post_data, $id);
            $this->db->cache_delete('Admin', 'SadminLogin');
            $this->session->set_flashdata('msg', '<div class="text-danger">Updated successfully </div>');
            return redirect('Admin/SadminLogin/viewUser');
        }
        // $this->load->view('includes/footer');

        // $this->load->view('Admin/config/header',array('title' => 'Please update user information'));
        // $this->load->view('Admin/config/sidebar', array('active' => 'viewuser', 'action' => ''));

        // $id = (int) $this->encrypt->decode($this->uri->segment(4));
        // $get = $this->admin->getuserdata($id);

        // $this->load->view('Admin/editUser');

        // $post_data = $this->security->xss_clean($this->input->post());
        // $this->admin->updateuser($post_data);
        // $this->session->set_flashdata('msg', '<div class="text-danger">Updated successfully </div>');
        // return redirect('User/update_user/'.$this->uri->segment(4));

        // $this->load->view('Admin/config/footer');
    }

    public function delete_user()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->deleteuserdata($id);
        $this->db->cache_delete('Admin', 'SadminLogin');
        $this->session->set_flashdata('msg', '<div class="text-danger">Deleted successfully </div>');
        return redirect('Admin/SadminLogin/viewUser');
    }
    public function loadAllProducts()
    {
        $getProd = $this->admin->loadAllProd();
        $html = '';
        foreach ($getProd as $prod) {
            $html .= <<<EOD
        <tr>
            <td> <input type='checkbox' class='prod_name' onclick="chk('$prod->id',this);" name='prod_name[]'value='{$prod->id}'/>  </td>
            <td> $prod->pro_name </td>
        </tr>
EOD;
        }

        echo $html;
    }

    public function saving_session()
    {

        $prd = $this->input->post('pid');
        $session = [];

        if ($this->session->userdata('prd_id') == null) {
            $session[] = $prd;
            $this->session->set_userdata('prd_id', $session);

        } else {
            $session = $this->session->userdata('prd_id');
            $session[] = $prd;
            $this->session->set_userdata('prd_id', $session);
        }
        print_r($this->session->userdata('prd_id'));
    }

    public function deleting_session()
    {
        $prd = $this->input->post('pid');
        $session = $this->session->userdata('prd_id');
        $key = array_search($prd, $session);
        unset($session[$key]);
        $arr = array_values($session);
        $this->session->set_userdata('prd_id', $arr);

    }

    public function add_block()
    {

        $this->load->library('ckeditor');
        $ck = $this->ckeditor->loadCk(true, 'pro_desc');
        $this->form_validation->set_rules('editor', 'Editor', 'required');

        $this->form_validation->set_error_delimiters('<div class="text-danger bg-success">', '</div>');

        $max_id = $this->admin->getProductMaxidblock()->ID;
        $enableBlock = $this->input->post('enableBlock');
        $block_title = $this->security->xss_clean($this->input->post('bt'));

        if ($block_title == null) {
            $block_title = "BLOCK_" . ($max_id + 1);
        }

        $identifier = $this->security->xss_clean($this->input->post('identifier'));

        if ($identifier == null) {
            $identifier = "IDENTIFIER_" . ($max_id + 1);
        }

        $editor = $this->input->post('editor');
        $valid_from = $this->input->post('valid_from');
        $valid_upto = $this->input->post('valid_upto');
        $sort_order = $this->input->post('sortorder');

        if ($this->form_validation->run() == true) {

            $res = $this->admin->insert_block($enableBlock, $block_title, $identifier, $editor, $valid_from, $valid_upto, $sort_order);
            if ($res) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Block Added Successfully</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Error Occured while adding the block</div>');
            }
            return redirect('Admin/SadminLogin/add_block');
        } else {
            $this->load->view('Admin/config/header', array('title' => 'CMS Block'));
            $this->load->view('Admin/config/sidebar', array('active' => 'cmsblock', 'action' => ''));
            $this->load->view('Admin/cmsBlock', array('ckeditor' => $ck));
            //,array('unique' => $max_id)
            $this->load->view('Admin/config/footer');
        }
    }

    public function view_block()
    {
        $this->load->view('Admin/config/header', array('title' => 'View Block'));
        $this->load->view('Admin/config/sidebar', array('active' => 'cmsblock', 'action' => ''));
        $res = $this->admin->get_block();
        $this->load->view('Admin/viewblock', array('user' => $res));
        $this->load->view('Admin/config/footer');
    }

    public function delete_block()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->deleteblock($id);
        $this->session->set_flashdata('msg', '<div class="text-danger">Deleted successfully </div>');

        $this->db->cache_delete("Admin", "SadminLogin");
        return redirect('Admin/SadminLogin/view_block');
    }

    public function update_block()
    {
        $this->load->library('ckeditor');
        $ck = $this->ckeditor->loadCk(true, 'pro_desc');
        $this->form_validation->set_rules('bt', 'Block Title', 'trim|required');
        $this->form_validation->set_rules('identifier', 'Identifier', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger bg-success">', '</div>');

        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));

        if ($this->form_validation->run() == true) {

            $post_data = $this->security->xss_clean($this->input->post());

            $this->admin->update_blockmodel($post_data, $id);

            $this->session->set_flashdata('msg', '<div class="text-danger">Updated successfully </div>');
            return redirect('Admin/SadminLogin/view_block');
        } else {
            $this->db->cache_delete("Admin", "SadminLogin");
            $this->load->view('Admin/config/header', array('title' => 'Edit Block'));
            $this->load->view('Admin/config/sidebar', array('active' => 'cmsblock', 'action' => ''));
            $get = $this->admin->get_blockdata($id);
            $this->db->cache_delete("Admin", "SadminLogin");
            $this->load->view('Admin/updateBlock', array('ckeditor' => $ck, 'user' => $get));
            $this->load->view('Admin/config/footer');
        }
    }

    public function add_page()
    {

        $this->load->library('ckeditor');
        $ck = $this->ckeditor->loadCk(true, 'pro_desc');
        $this->form_validation->set_rules('page_cont', 'Page Content', 'required');
        $this->form_validation->set_rules('page_title', 'Page Title', 'required');

        $this->form_validation->set_error_delimiters('<div class="text-danger bg-success">', '</div>');

        $max_id = $this->admin->getProductMaxidpage()->ID;
        $enablepage = $this->input->post('enablePage');
        $page_title = $this->security->xss_clean($this->input->post('page_title'));
        $sort_order = $this->input->post('sortorder');
        $valid_from = $this->input->post('valid_from');
        $valid_from = date('Y-m-d', strtotime($valid_from));

        $valid_upto = $this->input->post('valid_upto');
        $valid_upto = date('Y-m-d', strtotime($valid_upto));

        $cont_heading = $this->security->xss_clean($this->input->post('cont_head'));

        if ($cont_heading == null) {
            $cont_heading = "CONTENT_" . ($max_id + 1);
        }

        $page_cont = $this->input->post('page_cont');

        $url_key = $this->security->xss_clean($this->input->post('url_key'));

        if ($url_key == null) {
            $url_key = str_replace(" ", "-", strtolower($page_title));
        }

        $meta_title = $this->security->xss_clean($this->input->post('meta_title'));
        $meta_keywords = $this->security->xss_clean($this->input->post('meta_keywords'));

        $meta_description = $this->security->xss_clean($this->input->post('meta_description'));

        if ($this->form_validation->run() == true) {

            $res = $this->admin->insert_page($enablepage, $page_title, $sort_order, $valid_from, $valid_upto, $cont_heading, $page_cont, $url_key, $meta_title, $meta_keywords, $meta_description);
            if ($res) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Page Added Successfully</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Error Occured while adding the page</div>');
            }
            return redirect('Admin/SadminLogin/add_page');
        } else {
            $this->db->cache_delete("Admin", "SadminLogin");
            $this->load->view('Admin/config/header', array('title' => 'Add Page'));
            $this->load->view('Admin/config/sidebar', array('active' => 'page', 'action' => ''));
            $this->load->view('Admin/page', array('ckeditor' => $ck));
            //,array('unique' => $max_id)
            $this->load->view('Admin/config/footer');
        }
    }

    public function view_page()
    {
        $this->load->view('Admin/config/header', array('title' => 'View Page'));
        $this->load->view('Admin/config/sidebar', array('active' => 'Page', 'action' => ''));
        $res = $this->admin->get_page();
        $this->load->view('Admin/viewpage', array('user' => $res));
        $this->load->view('Admin/config/footer');
    }

    public function delete_page()
    {
        $this->db->cache_delete("Admin", "SadminLogin");
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $this->admin->deletepage($id);
        $this->session->set_flashdata('msg', '<div class="text-danger">Deleted successfully </div>');
        return redirect('Admin/SadminLogin/view_page');
    }

    public function update_page()
    {

        $this->load->library('ckeditor');
        $ck = $this->ckeditor->loadCk(true, 'pro_desc');
        $this->form_validation->set_rules('page_cont', 'Page Content', 'required');
        $this->form_validation->set_rules('page_title', 'Page Title', 'required');

        $this->form_validation->set_error_delimiters('<div class="text-danger bg-success">', '</div>');

        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));

        if ($this->form_validation->run() == true) {

            $post_data = $this->security->xss_clean($this->input->post());

            $this->admin->update_pagemodel($post_data, $id);

            $this->session->set_flashdata('msg', '<div class="text-danger">Updated successfully </div>');
            return redirect('Admin/SadminLogin/view_page');
        } else {
            $this->db->cache_delete("Admin", "SadminLogin");
            $this->load->view('Admin/config/header', array('title' => 'Edit Page'));
            $this->load->view('Admin/config/sidebar', array('active' => 'cmsblock', 'action' => ''));
            $get = $this->admin->get_pagedata($id);
            $this->load->view('Admin/updatepage', array('user' => $get, 'ckeditor' => $ck));
            $this->load->view('Admin/config/footer');
        }
    }

    public function viewOffer()
    {
        if ($this->role == 1) {
            $this->load->view('Admin/config/header', array('title' => 'View Users Details'));
            $this->load->view('Admin/config/sidebar', array('active' => 'viewuser', 'action' => ''));
            $data = $this->admin->load_offercode($this->role);
            $group = $this->admin->getUserGroup();
            $this->load->view('Admin/view_offer', array('data' => $data, 'groups' => $group));
            $this->load->view('Admin/config/footer');
        } else {
            echo show_404();
        }
    }

    public function view_userdetails()
    {
        $id = (int) $this->encryption->decrypt(decode($this->uri->segment(4)));
        $data = $this->admin->view_usersbyid($id);
        $get = $this->vendor->get_cust_orderdetails($data->user_email);
        $this->load->view('Admin/config/header', array('title' => 'Order Details'));
        $this->load->view('Admin/config/sidebar', array('active' => 'viewuser', 'action' => ''));
        $this->load->view('Admin/view_userdetails', array('data' => $get));
        $this->load->view('Admin/config/footer');
    }

    public function delete_offerCode()
    {
        if ($this->role == 1) {
            $id = $this->encryption->decrypt(decode($this->uri->segment(4)));

            $data = $this->admin->deleteOffer($id);
            if ($data) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"></a>Record deleted successfully</div></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                 <a href="#" class="alert-link link-underline"></a>Something went wrong</div></div>');
            }
            $this->db->cache_delete_all();
            return redirect('Admin/SadminLogin/viewOffer');
        } else {
            echo show_404();
        }
    }

    private function sendWalletGift($id, $wallet_amt)
    {

        if ($this->role == 1) {
            $this->db->cache_delete('Admin', 'SadminLogin');
            $query = $this->admin->view_usersbyid($id);

            $to_email = $query->user_email;
            $subject = "Gift to the wallet For karzanddolls.om " . date("Y-m-d H:i");
            $message = "Dear " . $query->user_name . ' ' . $query->lastname . ",";
            $message .= "<br><p>Thanks again to join us,we credit gift amount on your wallet : $wallet_amt INR ";
            $message .= "<br><p>You need to see gifted amount on following page :(https://www.karzanddolls.com/Checkout/myWallet)</p>";

            if ($query) {
                $config = array(
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->reply_to('hello@paulsonsonline.com', 'Vendors');
                $this->email->from('hello@paulsonsonline.com', 'karzanddolls');
                $this->email->to($to_email);
                $this->email->bcc(array("ronjhiya.gaurav3@gmail.com"));
                $this->email->subject($subject);
                $this->email->message($message);

                $result = $this->email->send();
                if ($result) {
                    $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">wallet amount Mail has been sent successfully </a>
                            </div>
                        </div>
EOD;

                    $this->session->set_flashdata('emailmsg', $msg);
                    return true;
                }
                $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Error! in mail</a>
                            </div>
                        </div>
EOD;

                $this->session->set_flashdata('emailmsg', $msg);
                return false;
                //            echo $this->email->print_debugger();
            }
        } else {
            echo show_404();
        }
    }

}
