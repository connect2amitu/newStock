<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Model extends CI_Model  {

	function get_all(){
		return $this->db->get('company')->result_array();
	}
	
	function get_by_id($id){
		return $this->db->get_where('company', $id)->result_array();
	}
	
	function delete($id){
		return $this->db->delete('company',$id);
	}
	
	function add($object){
		return $this->db->insert('company', $object);
	}

	function edit($object,$id){
		return $this->db->update('company', $object,$id);
		
	}
}