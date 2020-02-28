<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_Ctrl extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('customer/customer_model','cm');
		$this->load->model('common/common_model','common_model');
		$this->is_admin_login();

	 }
	public function index()
	{
		$data = array();
		$data['data'] = $this->cm->get_all();
		$data['content'] = $this->load->view('customer/index',$data, TRUE);
		$this->load->view('layout/index.php',$data);
	}

	public function remove($id="")
	{
		$id = array('Customer_ID'=> $id);
		
		if($this->cm->delete($id)){
			$this->session->set_flashdata('success', 'Record Removed');
		}else{
			$this->session->set_flashdata('error', 'Record Not Removed');
		}
		redirect('customer/index'); 
	}
	public function edit($id="")
	{

		$id = array('Customer_ID'=> $id);
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['data'] = $this->cm->get_by_id($id);
			$data['states'] = $this->common_model->get_all_states();
			$data['cities'] = $this->common_model->get_all_cities(array('state_id'=>$data['data'][0]['State']));
			$data['content'] = $this->load->view('customer/form',$data, TRUE);
			$this->load->view('layout/index.php',$data);

		}else{
				$data = array(
					'Customer_Name'=> $this->input->post('Customer_Name'),
					'Customer_Address'=> $this->input->post('Customer_Address'),
					'Customer_GSTIN'=> $this->input->post('Customer_GSTIN'),
					'Mobile_No'=> $this->input->post('Mobile_No'),
					'Email'=> $this->input->post('Email'),
					'City'=> $this->input->post('City'),
					'State'=> $this->input->post('State'),
					'Notes'=> $this->input->post('Notes'),
			);
			if($this->cm->edit($data,$id)){
				$this->session->set_flashdata('success', 'Record Update Successfully');
			}else{
				$this->session->set_flashdata('error', 'Record Not Updated');
			}
			redirect('customer'); 
		}


	
	}
	
	public function add()
	{
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['states'] = $this->common_model->get_all_states();
			$data['content'] = $this->load->view('customer/form',$data, TRUE);
			$this->load->view('layout/index.php',$data);
		}else{
				$data = array(
				'Customer_Name'=> $this->input->post('Customer_Name'),
				'Customer_Address'=> $this->input->post('Customer_Address'),
				'Customer_GSTIN'=> $this->input->post('Customer_GSTIN'),
				'Mobile_No'=> $this->input->post('Mobile_No'),
				'Email'=> $this->input->post('Email'),
				'City'=> $this->input->post('City'),
				'State'=> $this->input->post('State'),
				'Notes'=> $this->input->post('Notes'),
			);
			if($this->cm->add($data)){
				$this->session->set_flashdata('success', 'Record Added Successfully');
			}else{
				$this->session->set_flashdata('error', 'Record Not Added');
			}
			redirect('customer'); 
		}
	}
	
	public function get_customer_id($id){
		$id = array('customers.Customer_ID'=> $id);
		$data['data'] = $this->cm->get_by_id($id);
		$data = json_encode($data['data'][0],JSON_NUMERIC_CHECK);
		echo $data;
	}
}
