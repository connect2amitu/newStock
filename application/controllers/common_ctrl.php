<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common_Ctrl extends My_Controller
{
    public function __construct(){
		parent::__construct();
        $this->load->model('common/common_model','cm');
        $this->is_admin_login();

	 }

    public function getCities($stateId)
    {
        $id = array('state_id' => $stateId);
        $data['cities'] = $this->cm->get_all_cities($id);
        $citiesOptions = "";
        foreach ($data['cities'] as $row) {
            $citiesOptions .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
        echo $citiesOptions;
    }
}