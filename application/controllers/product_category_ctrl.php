<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Category_Ctrl extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('product/product_category_model','pc');
        $this->is_admin_login();

	 }

	public function index()
	{
		$data = array();
		$data['data'] = $this->pc->get_all();
		$data['content'] = $this->load->view('stock_category/index',$data, TRUE);
		$this->load->view('layout/index.php',$data);
	}

	public function remove($id="")
	{
		$id = array('Category_ID'=> $id);
		
		if($this->pc->delete($id)){
			$this->session->set_flashdata('success', 'Record Removed Successfully');
		}else{
			$this->session->set_flashdata('error', 'Record Not Removed');
		}
		redirect('product-category'); 
	}

	public function edit($id="")
	{

		$id = array('Category_ID'=> $id);
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['data'] = $this->pc->get_by_id($id);
			$data['content'] = $this->load->view('stock_category/form',$data, TRUE);
			$this->load->view('layout/index.php',$data);
		}else{
				$data = array(
				'Category_Name'=> $this->input->post('Category_Name'),
			);
			if($this->pc->edit($data,$id)){
				$this->session->set_flashdata('success', 'Record Update Successfully');
			}else{
				$this->session->set_flashdata('error', 'Record Not Updated');
			}
			redirect('product-category'); 
		}
	}
	
	public function add()
	{
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['content'] = $this->load->view('stock_category/form',null, TRUE);
			$this->load->view('layout/index.php',$data);
		}else{
				$data = array(
				'Category_Name'=> $this->input->post('Category_Name'),
			);
			if($this->pc->add($data)){
				$this->session->set_flashdata('success', 'Record Added Successfully');
			}else{
				$this->session->set_flashdata('error', 'Record Not Added');
			}
			$this->session->set_flashdata('msg', $notification);
			redirect('product-category'); 
		}
	}
	
}
