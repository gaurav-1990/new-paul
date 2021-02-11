<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('getState')) {

    function getState($id = NULL)
    {
        $CI = &get_instance();
        $states = $CI->db->get('state')->result();
        $html = '';
        foreach ($states as $state) {
            $select = '';
            if ($state->StateName == $id) {
                $select = "selected";
            }
            $html .= "<option $select value='$state->StateName'>$state->StateName</option>";
        }
        return $html;
    }
}

function getCity($id = NULL)
{
    $CI = &get_instance();
    $states = $CI->db->get('cities')->result();
    $html = '';
    foreach ($states as $state) {
        $select = '';
        if ($state->city_name == $id) {
            $select = "selected";
        }
        $html .= "<option $select value='$state->city_name'>$state->city_name</option>";
    }
    return $html;
}

if (!function_exists('getSubcount')) {

    function getSubcount($id)
    {

        $CI = &get_instance();
        return $data = ($CI->db->get_where("tbl_subcategory", ["parent_sub" => $id])->result());
    }
}
function getCityWhere($id)
{
    $CI = &get_instance();
    $states = $CI->db->get_where('cities', array('city_state' => $id))->result();
    $html = '<option value="">Select City</option>';
    foreach ($states as $state) {
        $html .= "<option value='$state->city_name'>$state->city_name</option>";
    }
    return $html;
}
