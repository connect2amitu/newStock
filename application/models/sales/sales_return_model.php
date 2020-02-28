<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_Return_Model extends CI_Model  {

	function get_all(){
		$this->db->select('*,sales_return.Created_Date as Sales_Return_Date,sales_return.Sub_Total as Sales_Return_Sub_Total');
		$this->db->from('sales');
		$this->db->join('sales_detail', 'sales.Sales_ID = sales_detail.Sales_Number','left'); 
		$this->db->join('sales_return', 'sales_return.Sales_Detail_Id = sales_detail.Sales_Detail_ID','left'); 
		$this->db->join('products', 'products.product_ID = sales_detail.Product_ID','left'); 
		$this->db->join('customers', 'customers.Customer_ID = sales.Customer_ID','left'); 
		$this->db->where('sales_return.Sales_Return_Id is not null');
		return $this->db->get()->result_array();
				
	}
}