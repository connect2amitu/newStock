<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model  {

	function get_all(){
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('suppliers', 'suppliers.Supplier_ID = purchases.Supplier_ID','left'); 
		// $this->db->join('unit_of_measurement', 'unit_of_measurement.Unit_ID = products.Unit_Of_Measurement'); 
		$query = $this->db->get();
		return $query->result_array();	
	}
	
	function get_products_details($id){
		$this->db->select('*');
		$this->db->from('purchases_detail');
		$this->db->join('purchases', 'purchases.Purchase_ID = purchases_detail.Purchase_Number','left'); 
		$this->db->join('products', 'products.Product_ID = purchases_detail.Product_ID','left'); 
		$this->db->join('unit_of_measurement', 'unit_of_measurement.Unit_ID = products.Unit_Of_Measurement','left'); 
		$this->db->where($id);
		$query = $this->db->get();
		return $query->result_array();	
	}
	
	
	
	function get_by_id($id){
		// 		SELECT * FROM `purchases` 
		// left join purchases_detail ON purchases.Purchase_ID = purchases_detail.Purchase_Number 
		// left join products ON products.Product_ID = purchases_detail.Product_ID
		// left join unit_of_measurement ON unit_of_measurement.Unit_ID = products.Unit_Of_Measurement
		// where purchases.Purchase_Invoice="P12"
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('suppliers', 'suppliers.Supplier_ID = purchases.Supplier_ID','left'); 
		$this->db->where($id);
		$query = $this->db->get();
		return $query->result_array();	
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
		return $this->db->insert('purchases_detail', $object);			
	}

	function edit($object,$id){
		return $this->db->update('purchases', $object,$id);
	}
}