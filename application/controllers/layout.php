<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('dashboard/dashboard_model','dm');
		$this->is_admin_login();
	 }

	public function index()
	{
		$data = array();

		$end = strtotime("now");
		$start = strtotime("-30 day");

		$start_date = isset($_GET['start'])?$_GET['start']:date('Y-m-d', $start);
		$end_date = isset($_GET['end'])?$_GET['end']:date('Y-m-d', $end);

		// $data['totalSales']=$this->dm->get_all_sales_total();
		// $data['totalPurchase']=$this->dm->get_all_purchase_total();
		// $data['totalExpenses']="coming soon";
		// $data['stockValue']=$this->dm->get_all_products_total();
    $data = $this->getReportsOnDashboard($start_date,$end_date);

		$stockLimit = array('Available_Qty <='=> 5 );
		$data['stockAlert']=$this->dm->get_stock_alert($stockLimit);
		$data['content'] = $this->load->view('dashboard/index', $data, TRUE);
		$this->load->view('layout/index.php',$data);
	}

	public function getReportsOnDashboard ($start_date,$end_date){
		$Sales_Date_Where = "Sales_Date >= '" . $start_date." 00:00:00" . "' AND Sales_Date <= '" . $end_date." 23:59:59" . "'";
		$Purchase_Date_Where = "Purchase_Date >= '" . $start_date." 00:00:00" . "' AND Purchase_Date <= '" . $end_date." 23:59:59" . "'";
		$Stock_Value_Where = "Date_Added >= '" . $start_date." 00:00:00" . "' AND Date_Added <= '" . $end_date." 23:59:59" . "'";
		echo `<pre>`;
		print_r($Sales_Date_Where);
		echo `</pre>`;
		// die;
		$data['totalSales']=$this->dm->get_all_sales_total($Sales_Date_Where);
		$data['totalPurchase']=$this->dm->get_all_purchase_total($Purchase_Date_Where);
		$data['totalExpenses']="coming soon";
		$data['stockValue']=$this->dm->get_all_products_total($Stock_Value_Where);
		return $data;
	}

	public function views($page="")
	{
		$data = array();
		$data['content'] = $this->load->view($page.'/index', "", TRUE);

		$this->load->view('layout/index.php',$data);
	}
}