<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_Return_Model extends CI_Model  {

	function get_all(){
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('purchases_detail', 'purchases.Purchase_ID  = purchases_detail.Purchase_Number','left'); 
		$this->db->join('purchases_return', 'purchases_return.Purchases_Detail_Id = purchases_detail.Purchase_Detail_ID','left'); 
		$this->db->join('products', 'products.product_ID = purchases_detail.Product_ID','left'); 
		$this->db->join('suppliers', 'suppliers.Supplier_ID = purchases.Supplier_ID','left'); 
		// $this->db->where('purchases_return.Purchases_Return_Id is not null');

		// $this->db->get()->result_array();
		return $this->db->get()->result_array();
		
		
	}
	
	function get_by_id($id){
		
		$this->db->select('*,states.name as State_Name,cities.name as City_Name');
		$this->db->join('customers', 'customers.Customer_ID = sales.Customer_ID','left'); 
		$this->db->join('sales_detail', 'sales_detail.Sales_Number = sales.Sales_ID','left'); 
		$this->db->join('products', 'products.Product_ID = sales_detail.Product_ID','left'); 
		$this->db->join('states', 'customers.State = states.id','left'); 
		$this->db->join('cities', 'customers.City = cities.id','left'); 
		$this->db->join('unit_of_measurement', 'unit_of_measurement.Unit_ID = products.Unit_Of_Measurement','left'); 
		return $this->db->get_where('sales', $id)->result_array();
	}
	
	function get_purchase_detail_by_id($id){
		$this->db->select('*');
		$this->db->from('purchases_detail');
		$this->db->join('products', 'products.product_ID = purchases_detail.Product_ID','left'); 
		$this->db->join('unit_of_measurement', 'unit_of_measurement.Unit_ID = products.Unit_Of_Measurement','left'); 
		$this->db->where($id);
		return $this->db->get()->result_array();
	}

	function add_purchase_return($object){
		if($this->db->insert('purchases_return', $object)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	
	function edit_purchase_detail($object,$cond){
		if($this->db->update('purchases_detail', $object,$cond)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
}