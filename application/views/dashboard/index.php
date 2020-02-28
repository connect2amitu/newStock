<script>
$(document).ready(function() {
  $('#myTable').DataTable();
});
</script>
<style>
.ibox {
  clear: both;
  margin-bottom: 25px;
  margin-top: 0;
  padding: 0;
}

.ibox-title {
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  background-color: #ffffff;
  border-color: #e7eaec;
  border-image: none;
  border-style: solid solid none;
  border-width: 4px 0px 0;
  color: inherit;
  margin-bottom: 0;
  padding: 0 10px;
  height: 48px;
}

.ibox-title h5 {
  /* font-weight: bold; */
}

.ibox-content {
  padding: 5px 10px 10px;
  background: #ffff;
}

.no-margins {
  margin: 0 !important;
}
</style>


<div class="content-group">
  <div class="page-header page-header-inverse has-cover">
    <div class="page-header-content">
      <div class="page-title">
        <h5>
          <i class="icon-circle-left2 position-left"></i>
          <span class="text-semibold">Dashboard</span>
        </h5>
      </div>
    </div>
    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ul>
    </div>
  </div>
</div>

<div class="content">


  <div class="row">
    <div class="col-lg-3">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <!-- <span class="label label-success pull-right current-tab">DAY</span> -->
          <h5>Sales</h5>
        </div>
        <div class="ibox-content">
          <h1 class="no-margins total-sales"><span class="prefix">&#8377; </span><?=number_format($totalSales)?><span
              class="suffix"></span></h1>
          <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
          <small>Total Sales</small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <!-- <span class="label label-info pull-right current-tab">DAY</span> -->
          <h5>Purchases</h5>
        </div>
        <div class="ibox-content">
          <h1 class="no-margins total-purchases"><span class="prefix">&#8377;
            </span><?=number_format($totalPurchase)?><span class="suffix"></span></h1>
          <!-- <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> -->
          <small>Total Purchases</small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <!-- <span class="label label-primary pull-right current-tab">DAY</span> -->
          <h5>Expenses</h5>
        </div>
        <div class="ibox-content">
          <h1 class="no-margins total-expenses"><span class="prefix">&#8377;
            </span><?php echo  $totalExpenses>0 ? number_format($totalExpenses):$totalExpenses?><span
              class="suffix"></span></h1>
          <!-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> -->
          <small>Total Expenses</small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <!-- <span class="label label-danger pull-right">Today </span> -->
          <h5>Stock Value</h5>
        </div>
        <div class="ibox-content">
          <h1 class="no-margins stock-value"><span class="prefix">&#8377; </span><?=number_format($stockValue)?><span
              class="suffix"></span></h1>
          <!-- <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div> -->
          <small>Total Stock Value</small>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-6 panel">
      <h1>Products Less Than Minimum Stock Level</h1>
      <!-- <table class="table table-hover dashboard_datatable"> -->
      <table class="table" id="myTable">

        <!-- <table class="table datatable-responsive-row-control"> -->

        <thead>
          <tr>
            <th>Sr.No</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Available Stock</th>
          </tr>
        </thead>
        <tbody>
          <?php
           $i=1;
        foreach ($stockAlert as $row) {
            ?>
          <tr>
            <td><?= $i++;?></td>
            <td><?= $row['Stock_Number']?></td>
            <td><?= $row['Stock_Name']?></td>
            <td><span
                class="label <?php echo $row['Available_Qty']>=5 ? "label-primary" : "label-danger"?>"><?= $row['Available_Qty']?></span>
            </td>
          </tr>
          <?php
        }

           ?>
        </tbody>
      </table>
    </div>
  </div>