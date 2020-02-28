<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Details_Ctrl extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('company_details/company_details_model','cd');
		$this->load->model('common/common_model','common_model');
		$this->load->helper(array('form', 'url')); 
		$this->is_admin_login();

	 }
	public function index()
	{
		$data['data'] = $this->cd->get_by_id();
		$data['states'] = $this->common_model->get_all_states();
		$data['cities'] = $this->common_model->get_all_cities(array('state_id'=>$data['data'][0]['State']));
		$data['content'] = $this->load->view('company_details/form',$data, TRUE);
		$this->load->view('layout/index.php',$data);
	}

	public function edit()
	{

		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$data['data'] = $this->cd->get_by_id();
			$data['states'] = $this->common_model->get_all_states();
			$data['cities'] = $this->common_model->get_all_cities(array('state_id'=>$data['data'][0]['State']));
			$data['content'] = $this->load->view('company_details/form',$data, TRUE);
			$this->load->view('layout/index.php',$data);

		}else{
				$data = array(
				'Company_Name'=> $this->input->post('Company_Name'),
				'Address'=> $this->input->post('Address'),
				'Phone_Number'=> $this->input->post('Phone_Number'),
				'Mobile_No'=> $this->input->post('Mobile_No'),
				'Email'=> $this->input->post('Email'),
				'Website'=> $this->input->post('Website'),
				'Country'=> $this->input->post('Country'),
				'City'=> $this->input->post('City'),
				'State'=> $this->input->post('State'),
				'Pan_No'=> $this->input->post('Pan_No'),
				'GSTIN'=> $this->input->post('GSTIN'),
				'Bank_Name'=> $this->input->post('Bank_Name'),
				'Branch_Name'=> $this->input->post('Branch_Name'),
				'Account_Number'=> $this->input->post('Account_Number'),
				'IFSC_Code'=> $this->input->post('IFSC_Code'),
				'Description'=> $this->input->post('Description'),
			);
			if($this->cd->edit($data,$id)){
				$config['upload_path']   = './uploads/'; 
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite'] = 'false';
				$config['max_size']      = 10000; 
				$config['max_width']     = 10000; 
				$config['max_height']    = 10000;  
				$this->load->library('upload', $config);
				   
				if ( ! $this->upload->do_upload('Company_Logo')) {
				   $error = array('error' => $this->upload->display_errors()); 
				}
				   
				else { 
				   $data = array('upload_data' => $this->upload->data()); 
					$logoData=array('Company_Logo'=>'uploads/'.$data['upload_data']['file_name']);
				   $this->cd->edit($logoData,$condition);
				} 

				$this->session->set_flashdata('success', 'Record Updated');
			}else{
				$this->session->set_flashdata('error', 'Record Not Updated');
			}
			redirect(); 
		}


	
	}
	
	// public function edit()
	// {
	// 	if ($this->input->server('REQUEST_METHOD') == 'GET')
	// 	{
	// 		$data['states'] = $this->common_model->get_all_states();
	// 		$data['content'] = $this->load->view('company_details/form',$data, TRUE);
	// 		$this->load->view('layout/index.php',$data);
	// 	}else{
	// 			$data = array(	
	// 			'Company_Name'=> $this->input->post('Company_Name'),
	// 			'Address'=> $this->input->post('Address'),
	// 			'Phone_Number'=> $this->input->post('Phone_Number'),
	// 			'Mobile_No'=> $this->input->post('Mobile_No'),
	// 			'Email'=> $this->input->post('Email'),
	// 			'Website'=> $this->input->post('Website'),
	// 			'Country'=> $this->input->post('Country'),
	// 			'City'=> $this->input->post('City'),
	// 			'State'=> $this->input->post('State'),
	// 			'Pan_No'=> $this->input->post('Pan_No'),
	// 			'GSTIN'=> $this->input->post('GSTIN'),
	// 			'Bank_Name'=> $this->input->post('Bank_Name'),
	// 			'Branch_Name'=> $this->input->post('Branch_Name'),
	// 			'Account_Number'=> $this->input->post('Account_Number'),
	// 			'IFSC_Code'=> $this->input->post('IFSC_Code'),
	// 			'Description'=> $this->input->post('Description'),
	// 		);
	// 		if($company_detail_id=$this->cd->add($data)){
	// 			echo "added";

	// 			$config['upload_path']   = './uploads/'; 
	// 			$config['allowed_types'] = 'gif|jpg|png';
	// 			$config['overwrite'] = 'false';
	// 			$config['max_size']      = 10000; 
	// 			$config['max_width']     = 10000; 
	// 			$config['max_height']    = 10000;  
	// 			$this->load->library('upload', $config);
				   
	// 			if ( ! $this->upload->do_upload('Company_Logo')) {
	// 			   $error = array('error' => $this->upload->display_errors()); 
	// 			   echo "<pre>";
	// 			   echo print_r($error);
	// 			   echo "</pre>";
	// 			   die;
	// 			//    $this->load->view('upload_form', $error); 
	// 			}
				   
	// 			else { 
	// 			   $data = array('upload_data' => $this->upload->data()); 
	// 			//    echo "<pre>";
	// 			//    echo print_r($data);
	// 			//    echo "</pre>";
	// 			//    die;
	// 				$logoData=array('Company_Logo'=>'uploads/'.$data['upload_data']['file_name']);
	// 				$condition=array('ID'=>$company_detail_id);
	// 			   $this->cd->edit($logoData,$condition);
	// 			//    $this->load->view('upload_success', $data); 
	// 			} 


	// 		}else{
	// 			echo "not added";
	// 		}
	// 		redirect('company_details'); 
	// 	}
	// }
	
}
