<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_Model extends CI_Model  {

	function get_all(){
		return $this->db->get('expense')->result_array();
	}
	
	function get_by_id($id){
		return $this->db->get_where('expense', $id)->result_array();
	}
	
	function delete($id){
		return $this->db->delete('expense',$id);
	}
	
	function add($object){
		return $this->db->insert('expense', $object);
	}

	function edit($object,$id){
		return $this->db->update('expense', $object,$id);
		
	}
}