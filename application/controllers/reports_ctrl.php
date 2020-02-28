<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_Ctrl extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reports/reports_model', 'reports');
        $this->is_admin_login();
    }

    public function purchases()
    {
        $end = strtotime("now");
        $start = strtotime("-30 day");
        $start_date = date('Y-m-d', $start);
        $end_date = date('Y-m-d', $end);
        if (isset($_GET['reportRange'])) {
            $range = $_GET['reportRange'];
            // $data['select'] = $_GET['reportRange'] ? $_GET['reportRange'] : "last30Days";
        } else {
            $start_date = isset($_GET['start'])?$_GET['start']:$start_date;
            $end_date = isset($_GET['end'])?$_GET['end']:$end_date;
            // redirect('reports/purchases?reportrange=last30Days&start='.$to_date.'&end='.$from_date.'');
        }

        $data['report']= $this->getReportOfPurchase($start_date,$end_date);
        $data['content'] = $this->load->view('reports/purchases', $data, true);
        $this->load->view('layout/index.php', $data);
    }

    public function getReportOfPurchase ($start_date,$end_date){
        $where = "Purchase_Date >= '" . $start_date." 00:00:00" . "' AND Purchase_Date <= '" . $end_date." 23:59:59" . "'";
            // echo $where;
            // die;
        return $this->reports->getPurchaseReport($where);
    }

    public function sales()
    {
        $data = array();
        $data['content'] = $this->load->view('reports/sales', $data, true);
        $this->load->view('layout/index.php', $data);
    }
}