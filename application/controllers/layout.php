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

		$data['totalSales']=$this->dm->get_all_sales_total();
		$data['totalPurchase']=$this->dm->get_all_purchase_total();
		$data['totalExpenses']="coming soon";
		$data['stockValue']=$this->dm->get_all_products_total();

		$stockLimit = array('Available_Qty <='=> 5 );
		$data['stockAlert']=$this->dm->get_stock_alert($stockLimit);		
		$data['content'] = $this->load->view('dashboard/index', $data, TRUE);
		$this->load->view('layout/index.php',$data);
	}
	public function views($page="")
	{
		$data = array();
		$data['content'] = $this->load->view($page.'/index', "", TRUE);
		
		$this->load->view('layout/index.php',$data);
	}
}
