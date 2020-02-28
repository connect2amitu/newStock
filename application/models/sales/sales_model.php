<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model  {

	function get_all(){
		$this->db->select('*');
		$this->db->from('sales');
		$this->db->join('customers', 'customers.Customer_ID = sales.Customer_ID','left'); 
		// $this->db->where('Is_Deleted',0);
		// $this->db->join('unit_of_measurement', 'unit_of_measurement.Unit_ID = products.Unit_Of_Measurement'); 
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die;
		return $query->result_array();			
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
	
	function get_sales_detail_by_id($id){
		$this->db->select('*,sales_detail.Discount as Sales_Discount');
		$this->db->join('sales', 'sales_detail.Sales_Number = sales.Sales_ID','left'); 
		$this->db->join('products', 'products.Product_ID = sales_detail.Product_ID','left'); 
		$this->db->join('unit_of_measurement', 'unit_of_measurement.Unit_ID = products.Unit_Of_Measurement','left'); 
		return $this->db->get_where('sales_detail', $id)->result_array();
	}
	
	function delete_undo($id,$data){
		$this->db->where($id);
		return $this->db->update('sales',$data);
	}
	
	function get_last_record(){
		$this->db->order_by("Sales_ID", "desc");
		$this->db->limit(1);
		return $this->db->get('sales')->result_array();
	}
	
	function add($object){
		if($this->db->insert('sales', $object)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	
	function add_sales_return($object){
		if($this->db->insert('sales_return', $object)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function addSalesDetail($object){
		return $this->db->insert('sales_detail', $object);
	}

	function edit($object,$id){
		return $this->db->update('sales', $object,$id);
	}
	function edit_sales_detail($object,$id){
		return $this->db->update('sales_detail', $object,$id);
	}

}