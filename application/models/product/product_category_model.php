<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Category_Model extends CI_Model  {

	function get_all(){
		return $this->db->get('product_categories')->result_array();
	}
	
	function get_by_id($id){
		return $this->db->get_where('product_categories', $id)->result_array();
	}
	
	function delete($id){
		return $this->db->delete('product_categories',$id);
	}
	
	function add($object){
		return $this->db->insert('product_categories', $object);
	}

	function edit($object,$id){
		return $this->db->update('product_categories', $object,$id);
		
	}
}