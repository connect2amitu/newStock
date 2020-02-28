<div class="content-group">
  <div class="page-header page-header-inverse has-cover">
    <div class="page-header-content">
      <div class="page-title">
        <h5>
          <i class="icon-circle-left2 position-left"></i>
          <span class="text-semibold">Sales Return</span>
        </h5>
      </div>
    </div>
    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
        <li class="active">Sales Return</li>
      </ul>
    </div>
  </div>
</div>

<div class="page-header-content">
  <a href="<?php echo base_url('sales-return/add'); ?>" class="btn btn-rounded btn-success mb-20 legitRipple">Return <i
      class="icon-add-to-list"></i> </a>
</div>
<?php
if (count($data)) {
    ?>
<div class="content">
  <div class="row">

    <div style="overflow-x:auto;" class="panel panel-flat">

      <!-- <table class="table table-borderd" id="dataTable" width="%" cellspacing="0"> -->
      <!-- <table class="table panel  table-bordered table-hover datatable-highlight"> -->
      <table class="table">


        <thead>
          <tr>
            <th>Invoice #</th>
            <th>Customer</th>
            <th>Date</th>
            <!-- <th>Notes</th>
            <th>Discount</th>
            <th>Sub Total</th>
            <th>Grand Total</th> -->
            <!-- <th>Date Added</th>
            <th>Added By</th>
            <th>Date Updated</th>
            <th>Updated By</th> -->
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php

    foreach ($data as $row) {
        ?>
          <tr>
            <td><?php echo $row['Sales_Invoice'] ?></td>
            <td><?php echo isset($row['Customer_Name'])?$row['Customer_Name']:"Cash" ?></td>
            <td><?php echo date_format(date_create($row['Sales_Date']), "d-m-Y") ?></td>
            <!-- <td><?php echo $row['Sales_Invoice'] ?></td> -->
            <!-- <td><?php echo date_format(date_create($row['Sales_Date']), "d-m-Y h:i:s A") ?></td>
              <td><?php echo $row['Sales_Notes'] ?></td>
              <td><?php echo $row['Discount'] ?></td>
              <td><?php echo $row['Sub_Total'] ?></td>
              <td><?php echo $row['Grand_Total'] ?></td> -->

            <!-- <td><?php echo $row['Date_Added'] ?></td>
            <td><?php echo $row['Added_By'] ?></td>
            <td><?php echo $row['Date_Updated'] ?></td>
            <td><?php echo $row['Updated_By'] ?></td> -->

            <td style="display:flex">
              <!-- <a style="margin-right:5px;color:green" href="<?php echo base_url('sales/edit/'.$row['Sales_ID']); ?>" class="legitRipple"><i class="icon-pencil4 position-left"></i></a>
              <a style="margin-right:5px;color:red" href="<?php echo base_url('sales/remove/'.$row['Sales_ID']); ?>" class="legitRipple" onclick="return confirm(`Are you sure you want to remove?`)" ><i class="icon-trash position-left"></i></a>
              <a style="margin-right:5px;color:black" href="<?php echo base_url('sales/gen_pdf/'.$row['Sales_ID']); ?>" class="legitRipple"> <i class="icon-printer2 position-left"></i></a> -->
              <ul class="icons-list">
                <!-- <li class="text-primary-600"><a href="<?php echo base_url('sales/edit/'.$row['Sales_ID']); ?>" data-popup="tooltip" title="Edit" ><i class="icon-pencil7"></i></a></li> -->
                <!-- <li class="text-danger-600"><a href="<?php echo base_url('sales/remove/'.$row['Sales_ID']); ?>" data-popup="tooltip" title="Remove" ><i class="icon-trash"></i></a></li> -->
                <li class="text-success-600"><a href="#" data-popup="tooltip" title="View More" data-toggle="modal"
                    data-target="<?php echo "#".$row['Sales_ID'] ?>"><i class="icon-more"></i></a></li>
              </ul>
            </td>
            <div class="modal fade" id="<?php echo $row['Sales_ID'] ?>" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Sales Return detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <?php
          foreach ($row['sale_return'] as $returnRow) {
?>
                    <div class="row">
                      <div class="col-xs-4"><strong>Id</strong></div>
                      <div class="col-xs-8"><?= $returnRow['Sales_Return_Id']?></div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4"><strong>Return_Qty</strong></div>
                      <div class="col-xs-8"><?= $returnRow['Return_Qty']?></div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4"><strong>Sales_Return_Date</strong></div>
                      <div class="col-xs-8"><?= $returnRow['Sales_Return_Date']?></div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4"><strong>Stock_Name</strong></div>
                      <div class="col-xs-8"><?= $returnRow['Stock_Name']?></div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4"><strong>Sales_Return_Sub_Total</strong></div>
                      <div class="col-xs-8"><?= $returnRow['Sales_Return_Sub_Total']?></div>
                    </div>
                    <hr />
                    <?php
            }

?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                  </div>
                </div>
              </div>
            </div>
          </tr>
          <?php
}
    ?>

        </tbody>
      </table>
    </div>
    <?php
} else {
    echo "<h1>No Record Found</h1>";
}

?>
  </div>
</div>