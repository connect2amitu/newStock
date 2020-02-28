<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Ctrl extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('login/login_model','lm');
	 }

	public function index()
	{
        $this->load->view('login/index.php');
	}
	
	public function checkLogin()
	{
		$data = array(
			'Username'=>$this->input->post('Username', true),
			'Password'=>$this->input->post('Password', true)
		);
		
		$data = $this->lm->login($data);
		
		if (count($data) == 1) 
		{	
			$array = array(
				'admin_id' => ucfirst($data[0]['Name'])
			);
			$adminId = array('Admin_ID'=>$data[0]['ID']);
			if($user = $this->lm->userData($adminId)[0]){
				$this->session->set_userdata('user',$user);				
			}
			$this->session->set_userdata( $array );
			$this->session->set_flashdata('success', 'Login Success');
			redirect(base_url());		
		}
		else
		{
			$this->session->set_flashdata('error', 'Login Failed');
			redirect(base_url('login'));		
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));		
	}
}