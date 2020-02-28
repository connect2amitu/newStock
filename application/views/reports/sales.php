<!-- breadcrumb -->
<div class="page-header page-header-default">
  <div class="breadcrumb-line">
    <ul class="breadcrumb">
      <li><a href="<?php echo base_url() ?>"><i class="icon-home2 position-left"></i> Dashboard</a></li>
      <li class="active">Purchase Report</li>
    </ul>
    <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
  </div>
</div>
<div class="content">

  <div class="col-xs-12">
    <div class="form-group">
      <div class="row">
        <div class="heading-elements">
          <form class="heading-form" action="#">
            <div class="form-group">
              <div class="daterange-custom" id="reportrange">
                <div class="daterange-custom-display"></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-12">
              <h5 class="panel-title">Sales Report</h5>
            </div>
          </div>
        </div>
        <table class="table  footable-group-row">
          <thead>
            <tr>
              <th>Sr.No</th>
              <th>Invoice No.</th>
              <th>Invoice Date</th>
              <th>Cash/Customer</th>
              <th>Discount</th>
              <th>Grand Total</th>
              <th>Received Payment</th>
              <th>Pending Payment</th>
            </tr>
          </thead>
          <tbody>
            <?php
$i = 1;
$receivedAmount = 0;
$grandTotal = 0;
$pendingAmount = 0;
foreach ($report as $row) {
    $receivedAmount += $row['Received_Amount'];
    $grandTotal += $row['Grand_Total'];
    $pendingAmount += $row['Grand_Total'] - $row['Received_Amount'];
    ?>
            <tr>
              <td><?=$i++;?></td>
              <td><?=$row['Sales_Invoice']?></td>
              <td><?=$row['Sales_Date']?></td>
              <td><?=$row['Customer_Name'] ? $row['Customer_Name'] : "Cash"?></td>
              <td>&#8377; <?=number_format($row['Discount'])?></td>
              <td>&#8377; <?=number_format($row['Grand_Total'])?> </td>
              <td>&#8377; <?=number_format($row['Received_Amount'])?></td>
              <td>&#8377; <?=number_format($row['Grand_Total'] - $row['Received_Amount'])?></td>
            </tr>
            <?php
}
?>

            <tr>
              <th colspan="5">Total</th>
              <th colspan="1"><span class="">&#8377;</span><?=number_format($grandTotal)?></th>
              <th><span class="">&#8377;</span><?=number_format($receivedAmount)?></th>
              <th><span class="">&#8377;</span><?=number_format($pendingAmount)?></th>
              <th></th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
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
        'Last 7 Days': [moment().subtract('days', 6), moment()],
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