<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model  {

	function get_all(){
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('suppliers', 'suppliers.Supplier_ID = purchases.Supplier_ID'); 
		// $this->db->join('unit_of_measurement', 'unit_of_measurement.Unit_ID = products.Unit_Of_Measurement'); 
		$query = $this->db->get();
		return $query->result_array();	
	}
	
	function get_by_id($id){
		return $this->db->get_where('purchases', $id)->result_array();
	}
	
	function delete($id){
		return $this->db->delete('purchases',$id);
	}
	
	function add($object){
		if($this->db->insert('purchases', $object)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	function addPurchaseDetail($object){
		if($this->db->insert('purchases_detail', $object)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function edit($object,$id){
		return $this->db->update('purchases', $object,$id);
	}
}