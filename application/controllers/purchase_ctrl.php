<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_Ctrl extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product/product_model', 'pm');
        $this->load->model('supplier/supplier_model', 'supm');
        $this->load->model('purchase/purchase_model', 'pum');
        $this->load->model('unit/unit_model', 'um');
        $this->load->model('stocks/stocks_model', 'sm');
        $this->load->model('common/common_model', 'common_model');
        $this->load->library('cart');
        $this->is_admin_login();

    }

    public function index()
    {
        $data = array();
        $data['data'] = $this->pum->get_all();
        $data['content'] = $this->load->view('purchase/index', $data, true);
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
        // print_r($this->cart->contents());
    }

    public function show_cart()
    {
        $sub_total = 0;
        foreach ($this->cart->contents() as $row) {
            ?>
<tr>
  <td style="width:10px;"><button type="button" id=<?php echo $row['rowid'] ?>
      class="remove_cart btn btn-danger btn-sm"><i class="icon-trash"></i></button></td>
  <td><?php echo $row['name'] ?></td>
  <td><?php echo $row['unit'] ?></td>
  <td><?php echo $row['HSN'] ?></td>
  <td><?php echo $row['GST'] ?></td>
  <td><?php echo $row['qty'] ?></td>
  <td>&#x20B9;&nbsp;<?php echo $row['price'] ?></td>
  <td><?php echo $row['discount'] > 0 ? $row['discount'] : 0 ?> %</td>
  <td style="display:flex;align-items:center">&#x20B9;
    <input style="width:85px;border:none" class="form-control" readonly type="text" name="total[]" value="
            <?php
if ($row['discount'] > 0) {
                $total = $row['subtotal'] - ($row['subtotal'] * $row['discount'] / 100);
            } else {
                $total = $row['subtotal'];
            }
            echo $total;
            $sub_total = $sub_total + $total;
            ?>
            " />
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
        $id = array('Purchase_ID' => $id);

        if ($this->pum->delete($id)) {
            $this->session->set_flashdata('success', 'Record Removed successfully');
        } else {
            $this->session->set_flashdata('error', 'Record Not Removed');
        }

        redirect('purchase/index');
    }
    public function edit($id = "")
    {

        $id = array('Purchase_ID' => $id);

        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $data['suppliers'] = $this->supm->get_all();
            $data['products'] = $this->pm->get_all();
            $data['products_details'] = $this->pum->get_products_details($id);
            $data['data'] = $this->pum->get_by_id($id);
            // echo "<pre>";
            // echo print_r($data['products_details']);
            // echo "</pre>";
            // die;
            $data['content'] = $this->load->view('purchase/form', $data, true);
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
            if ($this->pum->edit($data, $id)) {
                $this->session->set_flashdata('success', 'Record Update Successfully');
            } else {
                $this->session->set_flashdata('error', 'Record Not Updated');
            }

            redirect('purchase');
        }
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['suppliers'] = $this->supm->get_all();
            $data['units'] = $this->um->get_all();
            $data['products'] = $this->pm->get_all();

            foreach ($this->cart->contents() as $items) {
                $this->cart->remove($items['rowid']);
            }

            $data['cart'] = $this->cart->contents();
            $data['content'] = $this->load->view('purchase/form', $data, true);
            $this->load->view('layout/index.php', $data);
        } else {
            $addPurchaseData = array(
                'Supplier_ID' => $this->input->post('Supplier_ID'),
                'Purchase_Invoice' => $this->input->post('Purchase_Invoice'),
                'Purchase_Date' => date('Y/m/d h:i:s', strtotime($this->input->post('Purchase_Date'))),
                // 'Purchase_Date' => date('Y/m/d h:i:s', time()),
                'Purchase_Notes' => $this->input->post('Purchase_Notes'),
                'Sub_Total' => $this->input->post('Sub_Total'),
                'Discount' => $this->input->post('Discount'),
                'Grand_Total' => $this->input->post('Grand_Total'),
                'Freight' => $this->input->post('Freight'),
                'Payment_Mode' => $this->input->post('Payment_Mode') ? $this->input->post('Payment_Mode') : "Cash",
                'Paid_Amount' => $this->input->post('Paid_Amount') ? $this->input->post('Paid_Amount') : $this->input->post('Grand_Total'),
            );

            if ($Purchase_ID = $this->pum->add($addPurchaseData)) {

                foreach ($this->cart->contents() as $row) {
                    $data = array(
                        "Purchase_Number" => $Purchase_ID,
                        "Product_ID" => $row['id'],
                        "Purchasing_Quantity" => $row['qty'],
                        "Purchasing_Price" => $row['price'],
                        "Discount" => $row['discount'],
                        "Total" => $row['subtotal'] - ($row['subtotal'] * $row['discount'] / 100),
                    );

                    $this->pum->addPurchaseDetail($data);

                    $id = array('Product_ID' => $row['id']);
                    $current_stock = 0;

                    if ($currentStockOfProduct = $this->sm->findLatestStock($id)[0]) {

                        $current_stock = $row['qty'] + $currentStockOfProduct['Stock_Qty'];

                        $productStock = array(
                            'Product_ID' => $row['id'],
                            'Stock_Qty' => $current_stock,
                            'Transaction' => ENUM_PURCHASE_STOCK,
                        );
                        $this->sm->addProductStock($productStock);

                    } else {
                        $current_stock = $row['qty'];
                        $productStock = array(
                            'Product_ID' => $row['id'],
                            'Stock_Qty' => $row['qty'],
                            'Transaction' => ENUM_OPENING_STOCK,
                        );
                        $this->sm->addProductStock($productStock);

                    }
                    $newStock = array('Available_Qty' => $current_stock);
                    $this->pm->edit($newStock, $id);
                }

                $payments = json_decode($this->input->post('Hidden_Amount_Due'), true);
                foreach ($payments as $row) {
                    $data = array(
                        "Transaction_ID" => $Purchase_ID,
                        "Payment_Amount" => $row['Add_Payment'],
                        "Payment_Mode" => $row['Payment_Mode'],
                        "Transaction" => 'PURCHASES',
                    );
                    if ($this->common_model->addPaymentDetail($data)) {
                        $this->session->set_flashdata('success', 'Record Added Successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Record Not Added ');
                    }
                }
            }
            redirect('purchase');
        }
    }
}