<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_Model extends CI_Model  {

	function get_all(){
		// return $this->db->get('customers')->result_array();
		$this->db->select('customers.*,states.name as State_Name,cities.name as City_Name');
		$this->db->from('customers');
		$this->db->join('states', 'customers.State = states.id','left'); 
		$this->db->join('cities', 'customers.City = cities.id','left'); 
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_by_id($id){
		// return $this->db->get_where('customers', $id)->result_array();
		$this->db->select('customers.*,states.name as State_Name,cities.name as City_Name');
		$this->db->from('customers');
		$this->db->join('states', 'customers.State = states.id','left'); 
		$this->db->join('cities', 'customers.City = cities.id','left'); 
		$this->db->where($id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function delete($id){
		return $this->db->delete('customers',$id);
	}
	
	function add($object){
		return $this->db->insert('customers', $object);
	}

	function edit($object,$id){
		return $this->db->update('customers', $object,$id);
		
	}
}