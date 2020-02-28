<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suppliers_Ctrl extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier/supplier_model', 'sm');
        $this->load->model('common/common_model', 'common_model');
        $this->is_admin_login();

    }
    public function index()
    {
        $data = array();
        $data['data'] = $this->sm->get_all();
        $data['content'] = $this->load->view('supplier/index', $data, true);
        $this->load->view('layout/index.php', $data);
    }

    public function remove($id = "")
    {
        $id = array('Supplier_ID' => $id);

        if ($this->sm->delete($id)) {
            $this->session->set_flashdata('success', 'Record Removed');
        } else {
            $this->session->set_flashdata('error', 'Record Not Removed');
        }
        redirect('suppliers/index');
    }
    public function edit($id = "")
    {

        $id = array('Supplier_ID' => $id);
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['data'] = $this->sm->get_by_id($id);
            $data['states'] = $this->common_model->get_all_states();
            $data['cities'] = $this->common_model->get_all_cities(array('state_id' => $data['data'][0]['State']));
            $data['content'] = $this->load->view('supplier/form', $data, true);
            $this->load->view('layout/index.php', $data);

        } else {
            $data = array(
                'Supplier_Name' => $this->input->post('Supplier_Name'),
                'Phone_Number' => $this->input->post('Phone_Number'),
                'GSTIN' => $this->input->post('GSTIN'),
                'Supplier_Address' => $this->input->post('Supplier_Address'),
                'Country' => $this->input->post('Country'),
                'State' => $this->input->post('State'),
                'City' => $this->input->post('City'),
                // 'Zip_Code'=> $this->input->post('Zip_Code'),
                'Contact_Person' => $this->input->post('Contact_Person'),
                'Mobile_Number' => $this->input->post('Mobile_Number'),
                'Email' => $this->input->post('Email'),
                'Notes' => $this->input->post('Notes'),
            );
            if ($this->sm->edit($data, $id)) {
                $this->session->set_flashdata('success', 'Record Updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Record Not Updated');
            }
            redirect('suppliers');
        }

    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['states'] = $this->common_model->get_all_states();
            $data['content'] = $this->load->view('supplier/form', $data, true);
            $this->load->view('layout/index.php', $data);
        } else {
            $data = array(
                'Supplier_Name' => $this->input->post('Supplier_Name'),
                'Phone_Number' => $this->input->post('Phone_Number'),
                'GSTIN' => $this->input->post('GSTIN'),
                'Supplier_Address' => $this->input->post('Supplier_Address'),
                'Country' => $this->input->post('Country'),
                'State' => $this->input->post('State'),
                'City' => $this->input->post('City'),
                // 'Zip_Code'=> $this->input->post('Zip_Code'),
                'Contact_Person' => $this->input->post('Contact_Person'),
                'Mobile_Number' => $this->input->post('Mobile_Number'),
                'Email' => $this->input->post('Email'),
                'Notes' => $this->input->post('Notes'),
            );
            if ($this->sm->add($data)) {
                $this->session->set_flashdata('success', 'Record Added Successfully');
            } else {
                $this->session->set_flashdata('error', 'Record Not Added');
            }
            redirect('suppliers');
        }
    }

}