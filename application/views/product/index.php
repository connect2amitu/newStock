<div class="content-group">
  <div class="page-header page-header-inverse has-cover">
    <div class="page-header-content">
      <div class="page-title">
        <h5>
          <i class="icon-arrow-left52 position-left"></i>
          <span class="text-semibold">Products</span>
        </h5>
      </div>
    </div>
    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
        <li class="active">Products</li>
      </ul>
    </div>
  </div>
</div>



<div class="page-header-content">
  <a href="<?php echo base_url('products/add'); ?>" class="btn btn-rounded btn-success mb-20 legitRipple">Add <i
      class="icon-add-to-list"></i> </a>

</div>
<?php
  if(count($data)){
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
            <th>Stock Code</th>
            <th>Product Name</th>
            <th>HSN</th>
            <th>Unit</th>
            <th>Category</th>
            <th>Brand_Name</th>
            <th>Purchasing Price</th>
            <th>Selling Price</th>
            <th>GST</th>
            <th>Available Qty</th>
            <!-- <th>Notes</th>
                    <th>Date_Added</th>
                    <th>Added_By</th>
                    <th>Date_Updated</th>
                    <th>Updated_By</th> -->
            <th>Actions</th>

          </tr>
        </thead>
        <tbody>
          <?php

                foreach($data as $row)
{
?>
          <tr>
            <td><?php echo $row['Product_ID'] ?></td>
            <td><?php echo $row['Supplier_Name'] ?></td>
            <td><?php echo $row['Stock_Number'] ?></td>
            <td><?php echo $row['Stock_Name'] ?></td>
            <td><?php echo $row['HSN'] ?></td>
            <td><?php echo $row['Name'] ?></td>
            <td><?php echo $row['Category_Name'] ?></td>
            <td><?php echo $row['Brand_Name'] ?></td>
            <td>&#8377; <?php echo $row['Purchasing_Price'] ?> </td>
            <td>&#8377; <?php echo $row['Selling_Price'] ?> </td>
            <td><?php echo $row['GST'] ?> % </td>
            <td><?php echo $row['Available_Qty'] ?></td>

            <!-- <td><?php echo $row['Notes'] ?></td>
                    <td><?php echo $row['Date_Added'] ?></td>
                    <td><?php echo $row['Added_By'] ?></td>
                    <td><?php echo $row['Updated_By'] ?></td> -->

            <td style="display:flex">
              <a style="margin-right:5px" href="<?php echo base_url('products/edit/'.$row['Product_ID']); ?>"
                class="btn btn-primary legitRipple"><i class="icon-pencil6 position-left"></i></a>

              <a onclick="return confirm(`Are you sure you want to remove?`)"
                href="<?php echo base_url('products/remove/'.$row['Product_ID']); ?>"
                class="btn btn-danger legitRipple"><i class="icon-trash position-left"></i></a>
            </td>
          </tr>
          <?php
}
?>

        </tbody>
      </table>
    </div>
    <?php
  }else{
    echo "<h1>No Record Found</h1>";
  }

  ?>


  </div>


</div>