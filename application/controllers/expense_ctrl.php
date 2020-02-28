<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_Ctrl extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('expense/expense_model','em');
		$this->is_admin_login();
		

	 }

	public function index()
	{
		$data = array();
		$data['data'] = $this->em->get_all();
		$data['content'] = $this->load->view('expense/index',$data,TRUE);
		$this->load->view('layout/index.php',$data);
	}

	public function remove($id="")
	{
		$id = array('Id'=> $id);
		
		if($this->em->delete($id)){
			$this->session->set_flashdata('success', 'Record Removed Successfully');
		}else{
			$this->session->set_flashdata('error', 'Record Not Removed');
		}
		redirect('expense/index'); 
	}

	public function edit($id="")
	{

		$id = array('Id'=> $id);
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['data'] = $this->em->get_by_id($id);
			$data['content'] = $this->load->view('expense/form',$data, TRUE);
			$this->load->view('layout/index.php',$data);
		}else{
				$data = array(
					'Expense_Name'=> $this->input->post('Expense_Name'),
					'Description'=> $this->input->post('Description'),
					'Expense_Date' => date('Y/m/d h:i:s', strtotime($this->input->post('Expense_Date'))),
					'Amount'=> $this->input->post('Amount'),

			);
			if($this->em->edit($data,$id)){
				$this->session->set_flashdata('success', 'Record Updated Successfully');
			}else{
				$this->session->set_flashdata('error', 'Record Not Updated');
			}
			redirect('expense'); 
		}
	}
	
	public function add()
	{
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['content'] = $this->load->view('expense/form',null, TRUE);
			$this->load->view('layout/index.php',$data);
		}else{
				$data = array(
				'Expense_Name'=> $this->input->post('Expense_Name'),
				'Description'=> $this->input->post('Description'),
				'Expense_Date' => date('Y/m/d h:i:s', strtotime($this->input->post('Expense_Date'))),
				'Amount'=> $this->input->post('Amount'),
			);
			if($this->em->add($data)){
				$this->session->set_flashdata('success', 'Record Added Successfully');
			}else{
				$this->session->set_flashdata('error', 'Record Not Added');
			}
			$this->session->set_flashdata('msg', $notification);
			redirect('expense'); 
		}
	}
	
}
