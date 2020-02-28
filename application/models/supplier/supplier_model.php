<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_Model extends CI_Model  {

	function get_all(){	
		$this->db->select('suppliers.*,states.name as State_Name,cities.name as City_Name');
		$this->db->from('suppliers');
		$this->db->join('states', 'suppliers.State = states.id'); 
		$this->db->join('cities', 'suppliers.City = cities.id'); 
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_by_id($id){
		$this->db->select('suppliers.*,states.name as State_Name,cities.name as City_Name');
		$this->db->join('states', 'suppliers.State = states.id'); 
		$this->db->join('cities', 'suppliers.City = cities.id'); 
		return $this->db->get_where('suppliers', $id)->result_array();
	}
	
	function delete($id){
		return $this->db->delete('suppliers',$id);
	}
	
	function add($object){
		return $this->db->insert('suppliers', $object);
	}

	function edit($object,$id){
		return $this->db->update('suppliers', $object,$id);
		
	}
}