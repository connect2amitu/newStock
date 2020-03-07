<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brand_Ctrl extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('brand/brand_model', 'bm');
        $this->is_admin_login();
    }

    public function index()
    {
        $data = array();
        $data['data'] = $this->bm->get_all();
        $data['content'] = $this->load->view('brand/index', $data, true);
        $this->load->view('layout/index.php', $data);
    }

    public function remove($id="")
    {
        $id = array('Brand_ID'=> $id);

        if ($this->bm->delete($id)) {
            $this->session->set_flashdata('success', 'Record Removed');
        } else {
            $this->session->set_flashdata('error', 'Record Not Removed');
        }
        redirect('brands');
    }

    public function edit($id="")
    {
        $id = array('Brand_ID'=> $id);
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['data'] = $this->bm->get_by_id($id);
            $data['content'] = $this->load->view('brand/form', $data, true);
            $this->load->view('layout/index.php', $data);
        } else {
            $data = array(
                'Brand_Name'=> $this->input->post('Brand_Name'),
            );
            if ($this->bm->edit($data, $id)) {
                $this->session->set_flashdata('success', 'Record Updated');
            } else {
                $this->session->set_flashdata('error', 'Record Not Updated');
            }
            redirect('brands');
        }
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['content'] = $this->load->view('brand/form', null, true);
            $this->load->view('layout/index.php', $data);
        } else {
            $data = array(
                'Brand_Name'=> $this->input->post('Brand_Name'),
            );
            if ($this->bm->add($data)) {
                $this->session->set_flashdata('success', 'Record Added Successfully');
            } else {
                $this->session->set_flashdata('error', 'Record Not Added Successfully');
            }
            redirect('brands');
        }
    }
}
