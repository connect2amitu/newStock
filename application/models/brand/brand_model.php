<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_Model extends CI_Model  {
	function get_all(){
		return $this->db->get('brands')->result_array();
	}
	
	function get_by_id($id){
		return $this->db->get_where('brands', $id)->result_array();
	}
	
	function delete($id){
		return $this->db->delete('brands',$id);
	}
	
	function add($object){
		return $this->db->insert('brands', $object);
	}

	function edit($object,$id){
		return $this->db->update('brands', $object,$id);
		
	}
}