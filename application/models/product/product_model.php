<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model  {

	function get_all(){
		$this->db->select('*');
		$this->db->from('products');
		$this->db->join('product_categories', 'product_categories.Category_ID = products.Category','left'); 
		$this->db->join('suppliers', 'suppliers.Supplier_ID = products.Supplier_Number','left'); 
		$this->db->join('unit_of_measurement', 'unit_of_measurement.Unit_ID = products.Unit_Of_Measurement','left'); 
		$this->db->join('brands', 'brands.Brand_ID = products.Brand_Name','left'); 
		$query = $this->db->get();
		return $query->result_array();	
	}
	
	function get_by_id($id){
		$this->db->select('*');
		$this->db->from('products');
		$this->db->join('product_categories', 'product_categories.Category_ID = products.Category'); 
		$this->db->join('suppliers', 'suppliers.Supplier_ID = products.Supplier_Number'); 
		$this->db->join('unit_of_measurement', 'unit_of_measurement.Unit_ID = products.Unit_Of_Measurement'); 
		$this->db->where($id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function delete($id){
		return $this->db->delete('products',$id);
	}
	/**
	 * Remove Record
	 * @param  string $table table name
	 * @param  int $id    ID of record
	 * @return void        
	 */
	public function remove($table, $id)
	{
		return parent::delete($table, $id);		
	}
	
	function add($object){
		return $this->db->insert('products', $object);
	}

	function edit($object,$id){
		return $this->db->update('products', $object,$id);
		
	}
}