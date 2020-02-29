<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Details_Model extends CI_Model  {

	function get_all(){
		$this->db->select('company_details.*,states.name as State_Name,cities.name as City_Name');
		$this->db->from('company_details');
		$this->db->join('states', 'company_details.State = states.id','left');
		$this->db->join('cities', 'company_details.City = cities.id','left');
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_by_id($id){
		return $this->db->get_where('company_details',$id)->result_array();
	}

	function delete($id){
		return $this->db->delete('company_details',$id);
	}

	function add($object){
		$this->db->insert('company_details', $object);
		return $this->db->insert_id();
	}

	function edit($object,$condition){
		$this->db->where($condition);
		if($this->db->update('company_details', $object)){
			return $this->db->get_where('company_details',$condition)->result_array();
		}else{
			return false;
		}
	}
}