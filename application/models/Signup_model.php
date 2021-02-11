<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Signup_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function checkContact($data) {

        $query = $this->db->get_where("tbl_signups", array("contactno" => $data));
        if ($query->num_rows() > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

    

    public function loadState() {
        return $this->db->from("state")->order_by('StateName', 'asc')->get()->result();
    }

    // 2 for not verified // 3 means verified // 0 means rejected
    public function verifyOtps($email, $phone, $id) {
        $coi = $this->db->get_where('tbl_signups', array('otp_verify' => 2, 'mobile_otp' => $phone, 'email_otp' => $email, 'id' => $id))->result();
        if (count($coi) > 0) {
            $query = $this->db->update('tbl_signups', array('otp_verify' => 3), array('id' => $id));
            return true;
        } else {
            return false;
        }
    }

    public function getCity($state) {
        return $this->db->select('*')->from('cities')->where('city_state LIKE "%' . $state . '%" ')->order_by('city_name', 'asc')->get()->result();
    }

    public function emailCheck($data) {

        $query = $this->db->get_where("tbl_signups", array("emailadd" => $data));
        if ($query->num_rows() > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function panCheck($data) {

        $query = $this->db->get_where("tbl_signups", array("pan" => $data));
        if ($query->num_rows() > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

//otp_verify = 0 not initiated ,2 => initiated but not accepted, 3=>accepted 
    public function registration($data) {
        $password = $data['signup']['password'];
        $query = $this->db->insert('tbl_signups', array("fname" => $data['fname']
            , "lname" => $data["lname"], "contactno" => $data['contact_no']
            , "emailadd" => $data['email'], "company" => $data['compname'], "state" => $data['state'], "city" => $data["city"],
            "zip" => $data['zip'], 'mobile_otp' => $data['sms_otp'], 'passw' => password_hash($password, PASSWORD_BCRYPT), 'email_otp' => $data['email_otp'], "address" => $data['address'], "pan" => $data["pan"], "gst" => $data["gst"], 'otp_verify' => 2, 'ip_address' => $this->input->ip_address()));
        if ($query) {
            return $this->db->insert_id();
        }return false;
    }

}
