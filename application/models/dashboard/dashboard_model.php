<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Model extends CI_Model  {

	function get_all_sales_total($where=""){
		$this->db->select("SUM(Grand_Total) AS sales_total");
				$this->db->from("sales");
			$this->db->where($where);

		$query1=$this->db->get();
		if($query1->num_rows() > 0)
        {
         $res = $query1->row_array();
         return $res['sales_total'];
        }
       return 0.00;
	}

	function get_all_purchase_total($where=""){
		$this->db->select("SUM(Grand_Total) AS purchase_total");
				$this->db->from("purchases");
			$this->db->where($where);

		$query1=$this->db->get();
		if($query1->num_rows() > 0)
        {
         $res = $query1->row_array();
         return $res['purchase_total'];
        }
       return 0.00;
	}

	function get_all_products_total($where=""){
		$this->db->select("SUM(Purchasing_Price*Available_Qty) AS Purchasing_Price");
				$this->db->from("products");
			$this->db->where($where);

		$query1=$this->db->get();
		if($query1->num_rows() > 0)
        {
         $res = $query1->row_array();
         return $res['Purchasing_Price'];
        }
       return 0.00;
	}

	function get_stock_alert($limit){
		$this->db->where($limit);
		return $this->db->get('products')->result_array();

	}

}