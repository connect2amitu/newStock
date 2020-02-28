<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_Model extends CI_Model  {

    function getPurchaseReport($where){
			$this->db->select('*');
			$this->db->from('purchases');
			$this->db->join('suppliers', 'suppliers.Supplier_ID = purchases.Supplier_ID','left');
			$this->db->where($where);
			$q=$this->db->get()->result_array();
			$sql = $this->db->last_query();
			return $q;
		}

    function getSalesReport($where){
			$this->db->select('*');
			$this->db->from('sales');
			$this->db->join('customers', 'sales.Customer_ID = customers.Customer_ID','left');
			$this->db->where($where);
			$q=$this->db->get()->result_array();
			$sql = $this->db->last_query();
			return $q;
	}

}