<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Ctrl extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('product/product_model','pm');
		$this->load->model('product/product_category_model','product_category');
		$this->load->model('supplier/supplier_model','supm');
		$this->load->model('unit/unit_model','um');
		$this->load->model('gst/gst_model','gm');
		$this->load->model('brand/brand_model','bm');
		$this->is_admin_login();

	 }

	public function index()
	{
		$data = array();
		$data['data'] = $this->pm->get_all();
		$data['content'] = $this->load->view('product/index',$data, TRUE);
		$this->load->view('layout/index.php',$data);
	}

	public function remove($id="")
	{
		$id = array('Product_ID'=> $id);
		
		if($this->pm->delete($id)){
			$this->session->set_flashdata('success', 'Record Removed Successfully');
		}else{
			$this->session->set_flashdata('error', 'Record Not removed');
		}

		redirect('products/index'); 
	}
	public function edit($id="")
	{

		$id = array('Product_ID'=> $id);

		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['suppliers'] = $this->supm->get_all();
			$data['units'] = $this->um->get_all();
			$data['brands'] = $this->bm->get_all();
			$data['categories'] = $this->product_category->get_all();			
			$data['gst'] = $this->gm->get_all();			
			$data['data'] = $this->pm->get_by_id($id);
			$data['content'] = $this->load->view('product/form',$data, TRUE);
			$this->load->view('layout/index.php',$data);
		}
		else{
			$data = array(
				'Supplier_Number'=> $this->input->post('Supplier_Number'),
				'Stock_Number'=> $this->input->post('Stock_Number'),
				'Stock_Name'=> $this->input->post('Stock_Name'),
				'Unit_Of_Measurement'=> $this->input->post('Unit_Of_Measurement'),
				'Category'=> $this->input->post('Category'),
				'Brand_Name'=> $this->input->post('Brand_Name'),
				'Purchasing_Price'=> $this->input->post('Purchasing_Price'),
				'Selling_Price'=> $this->input->post('Selling_Price'),
				'GST'=> $this->input->post('GST'),
				'HSN'=> $this->input->post('HSN'),
				// 'Available_Qty'=> $this->input->post('Available_Qty'),
				'Notes'=> $this->input->post('Notes'),
			);
			if($this->pm->edit($data,$id)){
				$this->session->set_flashdata('success', 'Record Updated Successfully');
			}else{
				$this->session->set_flashdata('error', 'Record Not Updated');
			}

			redirect('products'); 
		}
	}
	
	public function add()
	{
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['suppliers'] = $this->supm->get_all();
			$data['brands'] = $this->bm->get_all();
			$data['units'] = $this->um->get_all();
			$data['categories'] = $this->product_category->get_all();			
			$data['gst'] = $this->gm->get_all();			
			$data['content'] = $this->load->view('product/form',$data, TRUE);

			$this->load->view('layout/index.php',$data);
		}
		else{
				$data = array(
				'Supplier_Number'=> $this->input->post('Supplier_Number'),
				'Stock_Number'=> $this->input->post('Stock_Number'),
				'Stock_Name'=> $this->input->post('Stock_Name'),
				'Unit_Of_Measurement'=> $this->input->post('Unit_Of_Measurement'),
				'Category'=> $this->input->post('Category'),
				'Brand_Name'=> $this->input->post('Brand_Name'),
				'Purchasing_Price'=> $this->input->post('Purchasing_Price'),
				'Selling_Price'=> $this->input->post('Selling_Price'),
				'GST'=> $this->input->post('GST'),
				'HSN'=> $this->input->post('HSN'),
				// 'Available_Qty'=> $this->input->post('Available_Qty'),
				'Notes'=> $this->input->post('Notes'),

				'Added_By'=> "admin",
			);
			
			if($this->pm->add($data)){
				$this->session->set_flashdata('success', 'Record Added Successfully');
			}else{
				$this->session->set_flashdata('error', 'Record  Not Added');
			}

			redirect('products'); 
		}
	}

	public function getProductById(){
		$id = array('products.Product_ID'=> $_POST['id']);
		$data['data'] = $this->pm->get_by_id($id);
		$data = json_encode($data['data'][0],JSON_NUMERIC_CHECK);
		echo $data;
	}
	
}
