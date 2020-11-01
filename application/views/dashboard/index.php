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


<script>
$(document).ready(function() {

  $('#dTable').dataTable({
  });
});

</script>

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

  <div class="row" style="display:flex;align-item:center;justify-content:flex-end">
    <div class="">
      <form class="heading-form" action="#">
        <div class="form-group">
          <div class="daterange-custom" id="reportrange">
            <div class="daterange-custom-display"></div>
          </div>
        </div>
      </form>
    </div>
  </div>
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
      <table class="table table-bordered table-hover " id="dTable">

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


  <script>
  $(document).ready(function() {
    $('#reportRange').on('change', function(e) {
      console.log("Event", e.target.value);
      if (e.target.value === "specific_rang") {
        console.log("specific_rang", e.target.value);
      } else {
        console.log("not ", e.target.value);
      }
    });
  });
  </script>



  <script>
  /* ------------------------------------------------------------------------------
   *
   *  # Page header component
   *
   *  Specific JS code additions for components_page_header.html page
   *
   *  Version: 1.1
   *  Latest update: Nov 25, 2015
   *
   * ---------------------------------------------------------------------------- */

  $(function() {


    // Date range pickers
    // ------------------------------

    //
    // Custom display
    //

    // Setup


    $('#reportrange').daterangepicker({
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month'),
        // startDate: moment().subtract('days', 29),
        // endDate: moment(),
        // minDate: '01/01/2014',
        maxDate: moment(),
        // dateLimit: {
        //   days: 60
        // },
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
          'Last 7 Days': [moment().subtract('days', 7), moment()],
          'This Month': [moment().startOf('month').subtract('days', 1), moment()],
          'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf(
            'month')]
        },
        opens: 'left',
        buttonClasses: ['btn'],
        applyClass: 'btn-small btn-info btn-block',
        cancelClass: 'btn-small btn-default btn-block',
        separator: ' to ',
        locale: {
          applyLabel: 'Submit',
          fromLabel: 'From',
          toLabel: 'To',
          customRangeLabel: 'Custom Range',
          daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
          monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'October', 'November', 'December'
          ],
          firstDay: 1
        }
      },
      function(start, end, label) {
        var url = "";
        console.info(`label => `, label);
        console.log("start.format('YYYY/MM/DD')", start.format('YYYY/MM/DD'));

        // insertParam("reportRange",start.format('L'));
        insertParam("start", start.format('YYYY/MM/DD'));
        insertParam("end", end.format('YYYY/MM/DD'));
        insertParam("range", label);
        window.location.reload();

        // Format date
        // $('#reportrange .daterange-custom-display').html(start.format('<i>D</i> <b><i>MMM</i> <i>YYYY</i></b>') +
        //   '<em>&#8211;</em>' + end.format('<i>D</i> <b><i>MMM</i> <i>YYYY</i></b>'));
      }
    );

    // Format date
    var urlParams = new URLSearchParams(window.location.search);
    var _start = urlParams.has('start') ? moment(urlParams.get('start')) : moment().subtract('days', 29);
    var _end = urlParams.has('end') ? moment(urlParams.get('end')) : moment();
    var range = urlParams.has('range') ? urlParams.get('range') : 'This Month';
    console.info(`range => `, range);
    $('#reportrange .daterange-custom-display').html(_start.format(
      '<i>D</i> <b><i>MMM</i> <i>YYYY</i></b>') + '<em>&#8211;</em>' + _end.format(
      '<i>D</i> <b><i>MMM</i> <i>YYYY</i></b>'));

    console.info(`allLi => `, allLi);
    var allLi = $(".ranges ul li");
    allLi.each(function() {
      console.info(`this.innerText => `, this.innerText);
      $(this).css('color', 'inherit');
      $(this).css('background-color', 'inherit');
      if (this.innerText === range) {
        $(this).css('color', '#fff');
        $(this).css('background-color', '#26A69A');
      }
    })
  });

  function insertParam(key, val) {
    var url = window.location.href;
    var reExp = new RegExp("[\?|\&]" + key + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");
    if (reExp.test(url)) {
      // update
      var reExp = new RegExp("[\?&]" + key + "=([^&#]*)");
      var delimiter = reExp.exec(url)[0].charAt(0);
      url = url.replace(reExp, delimiter + key + "=" + val);
    } else {
      // add
      var newParam = key + "=" + val;
      if (url.indexOf('?') < 0) {
        url += '?' + newParam;
      } else {
        if (url.indexOf('#') > -1) {
          var urlparts = url.split('#');
          url = urlparts[0] + "&" + newParam + (urlparts[1] ? "#" + urlparts[1] : '');
        } else {
          url += "&" + newParam;
        }
      }

    }
    window.history.pushState(null, document.title, url);

  }
  </script>