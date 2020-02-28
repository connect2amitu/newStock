<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Ctrl extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('company/company_model','cm');
	 }

	public function index()
	{
		$data = array();
		$data['data'] = $this->cm->get_all();
		$data['content'] = $this->load->view('company/index',$data, TRUE);
		$this->load->view('layout/index.php',$data);
	}

	public function remove($id="")
	{
		$id = array('Company_ID'=> $id);
		
		if($this->cm->delete($id)){
			$this->session->set_flashdata('msg', 'Record removed');
		}else{
			$this->session->set_flashdata('msg', 'Record not removed');
		}
		redirect('company'); 
	}

	public function edit($id="")
	{

		$id = array('Company_ID'=> $id);
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['data'] = $this->cm->get_by_id($id);
			$data['content'] = $this->load->view('company/form',$data, TRUE);
			$this->load->view('layout/index.php',$data);
		}else{
				$data = array(
				'Company_Name'=> $this->input->post('Company_Name'),
			);
			if($this->cm->edit($data,$id)){
				echo "updated";
			}else{
				echo "not updated";
			}
			redirect('company'); 
		}
	}
	
	public function add()
	{
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['content'] = $this->load->view('company/form',null, TRUE);
			$this->load->view('layout/index.php',$data);
		}else{
				$data = array(
				'Company_Name'=> $this->input->post('Company_Name'),
			);
			if($this->cm->add($data)){
				echo "added";
			}else{
				echo "not added";
			}
			redirect('company'); 
		}
	}
	
}
