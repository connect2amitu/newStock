<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_Model extends CI_Model  {

	function get_all(){
		return $this->db->get('unit_of_measurement')->result_array();
	}
	
	function get_by_id($id){
		return $this->db->get_where('unit_of_measurement', $id)->result_array();
	}
	
	function delete($id){
		return $this->db->delete('unit_of_measurement',$id);
	}
	
	function add($object){
		return $this->db->insert('unit_of_measurement', $object);
	}

	function edit($object,$id){
		return $this->db->update('unit_of_measurement', $object,$id);
	}
}