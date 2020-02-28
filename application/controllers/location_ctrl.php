<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location_Ctrl extends My_Controller
{
    public function index()
    {
        $data['states'] = $this->db->get('tbl_states')->result_array();
        $this->load->view('location/index', $data);
    }
    public function getCities($stateId)
    {
        $cities = $this->db->get_where('tbl_cities', array('state_id' => $stateId))->result_array();
        $citiesOptions = "";
        foreach ($cities as $row) {
            $citiesOptions .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
        echo $citiesOptions;
    }
}