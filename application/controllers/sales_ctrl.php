<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_Ctrl extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product/product_model', 'pm');
        $this->load->model('common/common_model', 'common_model');
        $this->load->model('supplier/supplier_model', 'supm');
        $this->load->model('customer/customer_model', 'cm');
        $this->load->model('sales/sales_model', 'sm');
        $this->load->model('unit/unit_model', 'um');
        $this->load->model('stocks/stocks_model', 'stocks_model');
        $this->load->library('cart');
        $this->load->library('pdf');
        $this->is_admin_login();
    }

    public function index()
    {
        $data = array();
        $data['data'] = $this->sm->get_all();   
        $data['content'] = $this->load->view('sales/index', $data, true);       
        $this->load->view('layout/index.php', $data);
    }
   

    public function addToCart()
    {
        $data = array(
            'id' => $_POST['id'],
            'qty' => $_POST['qty'],
            'price' => $_POST['price'],
            'name' => $_POST['name'],
            'HSN' => $_POST['HSN'],
            'unit' => $_POST['unit'],
            'GST' => $_POST['GST'],
            'SGST' => $_POST['SGST'],
            'CGST' => $_POST['CGST'],
            'IGST' => $_POST['IGST'],
            'discount' => $_POST['discount'],
        );

        if (count($this->cart->contents()) <= 0) {
            $this->cart->insert($data);
        } else {
            foreach ($this->cart->contents() as $items) {
                if ($items['id'] === $_POST['id']) {
                    $this->cart->remove($items['rowid']);
                }
            }
            $this->cart->insert($data);
        }
        echo $this->show_cart();
    }

    public function show_cart()
    {
        $sub_total=0;
        foreach ($this->cart->contents() as $row) {
            ?>
        <tr>
            <td><button type="button" id=<?php echo $row['rowid'] ?> productId=<?php echo $row['id'] ?>
                class="remove_cart btn btn-danger btn-sm"><i class="icon-trash"></i></button></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['unit'] ?></td>
            <td><?php echo $row['HSN'] ?></td>
            <td><?php echo $row['GST'] ?></td>
            <td><?php echo $row['qty'] ?></td>
            <td>&#x20B9;&nbsp;<?php echo $row['price'] ?></td>
            <td><?php echo $row['discount']>0?$row['discount']:0 ?> %</td>
            <td style="display:flex;align-items:center">&#x20B9;&nbsp;
            <input style="width:50px;border:none" class="form-control" readonly type="text" name="total[]" value="<?php if((int)$row['discount']>0){
                $total = $row['subtotal'] - ($row['subtotal'] * $row['discount'] / 100);
                echo $total;
                $sub_total = $sub_total+$total;
                }else{
                echo $row['subtotal'];
                } ?> " />
             </td>
        </tr>
<?php
}
    }

    public function delete_cart()
    {
        $this->cart->remove($this->input->post('row_id'));
        echo $this->show_cart();
    }

    public function remove($id = "")
    {
        $id = array('Sales_ID' => $id);

        if ($this->sm->delete_undo($id,array('Is_Deleted'=>1))) {
            $this->session->set_flashdata('success', 'Record Removed');
        } else {
            $this->session->set_flashdata('error', 'Record Not Removed');
        }

        redirect('sales/index');
    }
    
    public function undo($id = "")
    {
        $id = array('Sales_ID' => $id);
        if ($this->sm->delete_undo($id,array('Is_Deleted'=>0))) {
            $this->session->set_flashdata('success', 'Record Recoverd');
        } else {
            $this->session->set_flashdata('error', 'Record Not Recoverd');
        }
        redirect('sales/index');
    }
    public function edit($id = "")
    {

        $id = array('Sales_ID' => $id);

        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $data['suppliers'] = $this->supm->get_all();
            $data['products'] = $this->pm->get_all();
            $data['data'] = $this->sm->get_by_id($id);
            $data['content'] = $this->load->view('sales/form', $data, true);
            $this->load->view('layout/index.php', $data);
        } else {
            $data = array(
                'Supplier_ID' => $this->input->post('Supplier_ID'),
                'Product_ID' => $this->input->post('Product_ID'),
                'Total_Amount' => $this->input->post('Total_Amount'),
                'Total_Payment' => $this->input->post('Total_Payment'),
                'Purchase_Invoice' => $this->input->post('Purchase_Invoice'),
                'Purchase_Date' => date("Y-m-d", strtotime($this->input->post('Purchase_Date'))),
                'Purchase_Notes' => $this->input->post('Purchase_Notes'),
                'Added_By' => "admin",
            );
            if ($this->sm->edit($data, $id)) {
                $this->session->set_flashdata('success', 'Record Update Successfully');
            } else {
                $this->session->set_flashdata('error', 'Record Not Updated');
            }

            redirect('sales');
        }
    }
    
    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            
            $saleId = $this->sm->get_last_record() ? $this->sm->get_last_record()[0]['Sales_ID']+1:"";
            $data['lastSalesId'] = "SALE00".$saleId;
            $data['customers'] = $this->cm->get_all();
            $data['units'] = $this->um->get_all();
            $data['products'] = $this->pm->get_all();

            foreach ($this->cart->contents() as $items) {
                $this->cart->remove($items['rowid']);
            }
            
            $data['cart'] = $this->cart->contents();
            $data['content'] = $this->load->view('sales/form', $data, true);
            $this->load->view('layout/index.php', $data);
        } else {
           
            $addSalesData = array(
                'Customer_ID' => $this->input->post('Customer_ID'),
                'Sales_Invoice' => $this->input->post('Sales_Invoice'),
                'Sales_Date' => date('Y/m/d h:i:s', strtotime($this->input->post('Sales_Date'))),
                'Sales_Notes' => $this->input->post('Sales_Notes'),
                'Sub_Total' => $this->input->post('Sub_Total'),                                    
                'Discount' => $this->input->post('Discount'),
                'Grand_Total' => $this->input->post('Grand_Total'),
            );
            if ($Sales_ID = $this->sm->add($addSalesData)) {
                foreach ($this->cart->contents() as $row) {
                    $data = array(
                        "Sales_Number" => $Sales_ID,
                        "Product_ID" => $row['id'],
                        "Sales_Quantity" => $row['qty'],
                        "Sales_Price" => $row['price'],
                        "Discount" => $row['discount'],
                        'CGST' => $row['CGST'],
                        'SGST' => $row['SGST'],
                        'IGST' => $row['IGST'],
                        "Total" => $row['subtotal'] - ($row['subtotal'] * $row['discount'] / 100)
                    );
                  
                    if ($this->sm->addSalesDetail($data)) {
                        $this->session->set_flashdata('success', 'Record Added Successfully');
                    }else {
                        $this->session->set_flashdata('error', 'Record Not Added ');
                    }


                    $id = array('Product_ID' => $row['id']);
                    $current_stock=0;

                    if ($currentStockOfProduct = $this->stocks_model->findLatestStock($id)[0]) {

                        $current_stock = $currentStockOfProduct['Stock_Qty']-$row['qty'];

                        $productStock=array(
                        'Product_ID'=>$row['id'],
                        'Stock_Qty'=>$current_stock,
                        'Transaction'=> ENUM_SALES_STOCK
                        );
                        $this->stocks_model->addProductStock($productStock);

                    }
                    $newStock=array('Available_Qty'=>$current_stock);
                    $this->pm->edit($newStock,$id);
                }
                
                $payments=json_decode($this->input->post('Hidden_Amount_Due'),true);
                foreach ($payments as $row) {
                    $data = array(
                        "Transaction_ID" => $Sales_ID,
                        "Payment_Amount" => $row['Add_Payment'],
                        "Payment_Mode" => $row['Payment_Mode'],
                        "Transaction" => 'SALES',
                    );
                    if ($this->common_model->addPaymentDetail($data)) {
                        $this->session->set_flashdata('success', 'Record Added Successfully');
                    }else {
                        $this->session->set_flashdata('error', 'Record Not Added ');
                    } 
                }

                if($this->input->post('save_print')!=="" && $this->input->post('save_print')==="save_print"){
                    redirect('sales/gen_pdf/'.$Sales_ID);
                }
            } else {
                $this->session->set_flashdata('error', 'Master Sale Record Could Not Added');
                
            }   
            redirect('sales');
        }
    }

    public function gen_pdf($salesId=""){
        
        $id = array('Sales_ID' => $salesId);
        $data['data'] = $this->sm->get_by_id($id); 
        $data['terms_conditions'] = $this->common_model->get_terms_conditions(); 
        $data['company_detail'] = $this->common_model->get_my_company()?$this->common_model->get_my_company()[0]:""; 
        $this->load->view('sales/pdfGen.php',$data);
        // $data['content'] = $this->load->view('sales/pdfGenTemplate.php',$data, true);

        // $this->load->view('layout/index.php', $data);
    }


    public function sales_return($id = "")
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            
            $data['data'] = $this->sm->get_all();
            // $data['products'] = $this->pm->get_all();
            // $data['data'] = $this->sm->get_by_id($id);
            $data['content'] = $this->load->view('sales/return_form', $data, true);
            $this->load->view('layout/index.php', $data);
        } else {
            $id = array('Sales_Invoice' => $id);
            $data = array(
                'Supplier_ID' => $this->input->post('Supplier_ID'),
                'Product_ID' => $this->input->post('Product_ID'),
                'Total_Amount' => $this->input->post('Total_Amount'),
                'Total_Payment' => $this->input->post('Total_Payment'),
                'Purchase_Invoice' => $this->input->post('Purchase_Invoice'),
                'Purchase_Date' => date("Y-m-d", strtotime($this->input->post('Purchase_Date'))),
                'Purchase_Notes' => $this->input->post('Purchase_Notes'),
                'Added_By' => "admin",
            );
            if ($this->sm->edit($data, $id)) {
                $this->session->set_flashdata('success', 'Record Update Successfully');
            } else {
                $this->session->set_flashdata('error', 'Record Not Updated');
            }

            redirect('sales');
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
    
    public function sale_return()
    {    
        $totalSalesReturn = count($_POST['Product_ID']); 
        for ($i=0; $i < $totalSalesReturn; $i++) { 
            $data=array(
                'Sales_Detail_Id'=>$this->input->post('Sales_Detail_ID')[$i],
                'Return_Qty'=>$this->input->post('Return_Quantity')[$i],
                'Sub_Total'=>$this->input->post('Amount')[$i],
                // 'Created_Date'=>$this->input->post('Sales_Invoice'),
                'Sale_Invoice_Number'=>$this->input->post('Sales_Invoice'),
            );
            if ($this->sm->add_sales_return($data)) {
                 
            }else{
                
            }
        }
        redirect('sales');
    }
}