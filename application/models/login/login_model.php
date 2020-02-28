<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Model extends CI_Model  {

	function login($object){
		return $this->db->get_where('admin', $object)->result_array();
	}
    
    function get_all_states(){
		return $this->db->get('states')->result_array();
	}
	
}