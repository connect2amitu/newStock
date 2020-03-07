<div class="content-group">
  <div class="page-header page-header-inverse has-cover">
    <div class="page-header-content">
      <div class="page-title">
        <h5>
          <i class="icon-circle-left2 position-left"></i>
          <span class="text-semibold">Purchase</span>
        </h5>
      </div>
    </div>
    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
        <li class="active">Purchase</li>
      </ul>
    </div>
  </div>
</div>


<div class="page-header-content">
  <a href="<?php echo base_url('purchase/add'); ?>" class="btn btn-rounded btn-success mb-20 legitRipple">Add <i
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
      <table class="table datatable-responsive-row-control">


        <thead>
          <tr>
            <th>#</th>
            <th>Supplier</th>
            <th>Invoice #</th>
            <th>Date</th>
            <th>Notes</th>

            <th>Discount</th>
            <th>Freight </th>
            <th>Sub Total</th>
            <th>Payment Mode</th>
            <th>Grand Total</th>
            <th>Paid Amount</th>
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
            <td><?php echo $row['Purchase_ID'] ?></td>
            <td><?php echo $row['Supplier_Name'] ?></td>
            <td><?php echo $row['Purchase_Invoice'] ?></td>
            <td><?php echo date_format(date_create($row['Purchase_Date']), "d-m-Y h:i:s A") ?></td>
            <td><?php echo $row['Purchase_Notes'] ?></td>

            <td><?php echo $row['Discount'] ?></td>
            <td><?php echo $row['Freight'] ?></td>
            <td><?php echo $row['Sub_Total'] ?></td>
            <td><?php echo $row['Payment_Mode'] ?></td>
            <td><?php echo $row['Grand_Total'] ?></td>
            <td><?php echo $row['Paid_Amount'] ?></td>

            <!-- <td><?php echo $row['Date_Added'] ?></td>
            <td><?php echo $row['Added_By'] ?></td>
            <td><?php echo $row['Date_Updated'] ?></td>
            <td><?php echo $row['Updated_By'] ?></td> -->

            <td style="display:flex">
              <a style="margin-right:5px;color:green"
                href="<?php echo base_url('purchase/edit/'.$row['Purchase_ID']); ?>" class="legitRipple"><i
                  class="icon-pencil4 position-left"></i></a>
              <a style="margin-right:5px;color:red"
                href="<?php echo base_url('purchase/remove/'.$row['Purchase_ID']); ?>" class="legitRipple"
                onclick="return confirm(`Are you sure you want to remove?`)"><i
                  class="icon-trash position-left"></i></a>
            </td>
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