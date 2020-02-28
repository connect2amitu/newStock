<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_Return_Ctrl extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product/product_model', 'pm');
        $this->load->model('sales/sales_model', 'sm');
        $this->load->model('sales/sales_return_model', 'sales_return');
        $this->load->model('stocks/stocks_model', 'stocks_model');
        $this->load->library('cart');
        $this->load->library('pdf');
        $this->is_admin_login();
    }

    public function index()
    {
        $data = array();
        $lol = $this->sales_return->get_all();  
        $returnData = array();
        foreach ($lol as $row) {
            if (!isset($returnData[$row['Sales_ID']])) {
                $returnData[$row['Sales_ID']]= [
                    'Sales_ID' => $row['Sales_ID'],
                    'Customer_Name' => $row['Customer_Name'],
                    'Sales_Quantity' => $row['Sales_Quantity'],
                    'Sales_Invoice' => $row['Sales_Invoice'],
                    'Sales_Date' => $row['Sales_Date'],
                    'sale_return' => [
                        [
                            'Sales_Detail_ID' => $row['Sales_Detail_ID'],
                            'Sales_Return_Id' => $row['Sales_Return_Id'],
                            'Return_Qty' => $row['Return_Qty'],
                            'Sales_Return_Date' => $row['Sales_Return_Date'],
                            'Stock_Name' => $row['Stock_Name'],
                            'Sales_Return_Sub_Total' => $row['Sales_Return_Sub_Total'],
                        ],
                    ],
                ];
            } else {
                $returnData[$row['Sales_ID']]['sale_return'][] = [
                    'Sales_Detail_ID' => $row['Sales_Detail_ID'],
                    'Sales_Return_Id' => $row['Sales_Return_Id'],
                    'Return_Qty' => $row['Return_Qty'],
                    'Sales_Return_Date' => $row['Sales_Return_Date'],
                    'Stock_Name' => $row['Stock_Name'],
                    'Sales_Return_Sub_Total' => $row['Sales_Return_Sub_Total'],
                ];
            }
        } 
        $data['data']=$returnData;
        $data['content'] = $this->load->view('sales/return_list', $data, true);       
        $this->load->view('layout/index.php', $data);
    }

    public function add($id = "")
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            
            $data['data'] = $this->sm->get_all();
            $data['content'] = $this->load->view('sales/return_form', $data, true);
            $this->load->view('layout/index.php', $data);
        } else {
            $totalSalesReturn = count($_POST['Sales_Detail_ID']);
             for ($i=0; $i < $totalSalesReturn; $i++) { 
                $data=array(
                    'Sales_Detail_Id'=>$this->input->post('Sales_Detail_ID')[$i],
                    'Return_Qty'=>$this->input->post('Return_Quantity')[$i],
                    'Sub_Total'=>$this->input->post('Amount')[$i],
                    'Sale_Invoice_Number'=>$this->input->post('Sales_Invoice'),
                );
                if ($this->sm->add_sales_return($data)) {

                    $id = array('Product_ID' => $this->input->post('Product_ID')[$i]);
                    if ($currentStockOfProduct = $this->stocks_model->findLatestStock($id)[0]) {
                        $current_stock = $currentStockOfProduct['Stock_Qty']+$this->input->post('Return_Quantity')[$i];
                        $productStock=array(
                            'Product_ID'=>$this->input->post('Product_ID')[$i],
                            'Stock_Qty'=>$current_stock,
                            'Transaction'=> ENUM_SALES_RETRUN_STOCK
                        );
                        $this->stocks_model->addProductStock($productStock);
                        $New_Available_Qty = array('Available_Qty'=>$current_stock);
                        $this->pm->edit($New_Available_Qty,$id);
                        $New_Available_Qty = array('Sales_Quantity'=>$this->input->post('Available_Qty')[$i]-$this->input->post('Return_Quantity')[$i]);
                        $sales_detail_id = array('Sales_Detail_ID' => $this->input->post('Sales_Detail_ID')[$i]);
                        $this->sm->edit_sales_detail($New_Available_Qty,$sales_detail_id);
                    }else{

                    }
                }
            }
            redirect('sales-return');
        }
    }

    public function get_sales_by_invoice()
    {
        $id = array('Sales_Invoice' => $this->input->post('Sales_Invoice'));
        
        if($this->sm->get_by_id($id)){
            $data['sales'] = $this->sm->get_by_id($id)[0];  
        }

        $sales_detail = array('Sales_Number' => $data['sales']['Sales_ID']);
        $data['sales_details'] = $this->sm->get_sales_detail_by_id($sales_detail);  
        echo json_encode($data,JSON_NUMERIC_CHECK);
		
    }
    
    // public function add()
    // {    
    //     $totalSalesReturn = count($_POST['Product_ID']); 
    //     for ($i=0; $i < $totalSalesReturn; $i++) { 
    //         $data=array(
    //             'Sales_Detail_Id'=>$this->input->post('Sales_Detail_ID')[$i],
    //             'Return_Qty'=>$this->input->post('Return_Quantity')[$i],
    //             'Sub_Total'=>$this->input->post('Amount')[$i],
    //             // 'Created_Date'=>$this->input->post('Sales_Invoice'),
    //             'Sale_Invoice_Number'=>$this->input->post('Sales_Invoice'),
    //         );
    //         if ($this->sm->add_sales_return($data)) {
                 
    //         }else{
                
    //         }
    //     }
    //     redirect('sales');
    // }
}