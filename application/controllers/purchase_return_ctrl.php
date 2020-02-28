<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_Return_Ctrl extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product/product_model', 'pm');
        $this->load->model('purchase/purchase_model', 'purchase_model');
        $this->load->model('purchase/purchase_return_model', 'purchase_return');
        $this->load->model('stocks/stocks_model', 'stocks_model');
        $this->load->library('cart');
        $this->load->library('pdf');
        $this->is_admin_login();
    }

    public function index()
    {
        $data = array();
        $lol = $this->purchase_return->get_all(); 
        $returnData = array();
        foreach ($lol as $row) {
            if (!isset($returnData[$row['Purchase_ID']])) {
                $returnData[$row['Purchase_ID']]= [
                    'Purchase_ID' => $row['Purchase_ID'],
                    'Supplier_Name' => $row['Supplier_Name']?$row['Supplier_Name']:"",
                    'Purchasing_Quantity' => $row['Purchasing_Quantity'],
                    'Purchase_Invoice' => $row['Purchase_Invoice'],
                    'Purchase_Date' => $row['Purchase_Date'],
                    'purchase_return' => [
                        [
                            'Purchase_Detail_ID' => $row['Purchase_Detail_ID'],
                            'Purchases_Return_Id' => $row['Purchases_Return_Id'],
                            'Return_Qty' => $row['Return_Qty'],
                            'Created_Date' => $row['Created_Date'],
                            'Stock_Name' => $row['Stock_Name'],
                            'Sub_Total' => $row['Sub_Total'],
                        ],
                    ],
                ];
            } else {
                $returnData[$row['Purchase_ID']]['purchase_return'][] = [
                    'Purchase_Detail_ID' => $row['Purchase_Detail_ID'],
                    'Purchases_Return_Id' => $row['Purchases_Return_Id'],
                    'Return_Qty' => $row['Return_Qty'],
                    'Created_Date' => $row['Created_Date'],
                    'Stock_Name' => $row['Stock_Name'],
                    'Sub_Total' => $row['Sub_Total'],
                ];
            }
        } 
        $data['data']=$returnData;
        $data['content'] = $this->load->view('purchase/return_list', $data, true);       
        $this->load->view('layout/index.php', $data);
    }

    public function add($id = "")
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            
            $data['data'] = $this->purchase_model->get_all();
            $data['content'] = $this->load->view('purchase/return_form', $data, true);
            $this->load->view('layout/index.php', $data);
        } else {
            $totalSalesReturn = count($_POST['Purchase_Detail_ID']);
           
            for ($i=0; $i < $totalSalesReturn; $i++) { 
                if($this->input->post('Return_Quantity')[$i]>0){
                    $data=array(
                        'Purchases_Detail_Id'=>$this->input->post('Purchase_Detail_ID')[$i],
                        'Return_Qty'=>$this->input->post('Return_Quantity')[$i],
                        'Sub_Total'=>$this->input->post('Amount')[$i],
                        'Purchases_Invoice_Number'=>$this->input->post('Purchase_Invoice'),
                    );
                    $this->db->trans_begin();
                    if ($this->purchase_return->add_purchase_return($data)) {
                        
                        $id = array('Product_ID' => $this->input->post('Product_ID')[$i]);
                        if ($currentStockOfProduct = $this->stocks_model->findLatestStock($id)[0]) {
                            $current_stock = $currentStockOfProduct['Stock_Qty']-$this->input->post('Return_Quantity')[$i];
                            $productStock=array(
                                'Product_ID'=>$this->input->post('Product_ID')[$i],
                                'Stock_Qty'=>$current_stock,
                                'Transaction'=> ENUM_PURCHASE_RETRUN_STOCK
                            );
                            
                            $this->stocks_model->addProductStock($productStock);
                            $New_Available_Qty = array('Available_Qty'=> $current_stock);
                            $this->pm->edit($New_Available_Qty,$id);
                            $New_Available_Qty = array('Purchasing_Quantity'=>$this->input->post('Available_Qty')[$i]-$this->input->post('Return_Quantity')[$i]);
                            $purchase_detail_id = array('Purchase_Detail_ID' => $this->input->post('Purchase_Detail_ID')[$i]);
                            $this->purchase_return->edit_purchase_detail($New_Available_Qty,$purchase_detail_id);
                        }else{
                            
                        }
                    }
                }
            }
            if($this->db->trans_status()===false){
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Something went wrong, please try again');
                redirect('purchase-return/add');
            }else{
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Purchase Return Successful');
                redirect('purchase-return');
            }
        }
    }

    public function get_purchase_by_invoice()
    {
        $id = array('purchases.Purchase_Invoice' => $this->input->post('Purchase_Invoice'));
        $data['purchase'] = $this->purchase_model->get_by_id($id)[0];
        $id = array('Purchase_Number' => $data['purchase']['Purchase_ID']);
        $data['purchase_details'] = $this->purchase_return->get_purchase_detail_by_id($id);  
        echo json_encode($data,JSON_NUMERIC_CHECK);
		
    }
}