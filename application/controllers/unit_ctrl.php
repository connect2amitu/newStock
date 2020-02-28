<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_Ctrl extends My_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('unit/unit_model','um');
        $this->is_admin_login();
     }

    public function index()
    {
        $data = array();
        $data['data'] = $this->um->get_all();
        $data['content'] = $this->load->view('unit/index',$data, TRUE);
        $this->load->view('layout/index.php',$data);
    }

    public function remove($id="")
    {
        $id = array('Unit_ID'=> $id);
        
        if($this->um->delete($id)){
            $this->session->set_flashdata('success', 'Record Removed');
        }else{
            $this->session->set_flashdata('error', 'Record Not Removed');
        }
        redirect('unit'); 
    }

    public function edit($id="")
    {

        $id = array('Unit_ID'=> $id);
        if ($this->input->server('REQUEST_METHOD') == 'GET')
        {
            $data['data'] = $this->um->get_by_id($id);
            $data['content'] = $this->load->view('unit/form',$data, TRUE);
            $this->load->view('layout/index.php',$data);
        }else{
                $data = array(
                'Name'=> $this->input->post('Name'),
                'Description'=> $this->input->post('Description'),
            );
            if($this->um->edit($data,$id)){
                $this->session->set_flashdata('success', 'Record Update Successfully');
            }else{
                $this->session->set_flashdata('error', 'Record Not Updated');
            }
            redirect('unit'); 
        }
    }
    
    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET')
        {
            $data['content'] = $this->load->view('unit/form',null, TRUE);
            $this->load->view('layout/index.php',$data);
        }else{
                $data = array(
                    'Name'=> $this->input->post('Name'),
                    'Description'=> $this->input->post('Description'),
            );
            if($this->um->add($data)){
                $this->session->set_flashdata('success', 'Record Added Successfully');
            }else{
                $this->session->set_flashdata('error', 'Record Not Added ');
            }
            redirect('unit'); 
        }
    }
    
}
