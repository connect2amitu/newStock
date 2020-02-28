<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocks_Model extends CI_Model  {

	function findLatestStock($productId){
		$this->db->select('*');
		$this->db->from('stocks');
		$this->db->order_by("Id", "DESC");
		$this->db->limit(1); 
		$this->db->where($productId); 
        return $this->db->get()->result_array();
	}
	function addProductStock($object){
        return $this->db->insert('stocks',$object);
	}
}