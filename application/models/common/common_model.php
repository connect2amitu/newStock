<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_Model extends CI_Model  {

	function get_all_cities($condition=array()){
		return $this->db->get_where('cities', $condition)->result_array();
	}
    
    function get_all_states(){
		return $this->db->get('states')->result_array();
	}
   
	function get_terms_conditions(){
		return $this->db->get('term_condition')->result_array();
	}
	
	function get_my_company(){
		$this->db->limit(1);
		return $this->db->get('company_details')->result_array();
	}
	
	function addPaymentDetail($object){
		return $this->db->insert('payments', $object);
	}
}