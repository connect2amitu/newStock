<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gst_Model extends CI_Model  {

	function get_all(){
		return $this->db->get('gst_slab')->result_array();
	}
	
	function get_by_id($id){
		return $this->db->get_where('gst_slab', $id)->result_array();
	}
	
	function delete($id){
		return $this->db->delete('gst_slab',$id);
	}
	
	function add($object){
		return $this->db->insert('gst_slab', $object);
	}

	function edit($object,$id){
		return $this->db->update('gst_slab', $object,$id);
	}
}