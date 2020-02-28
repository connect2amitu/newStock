

<!-- breadcrumb -->
<div class="page-header page-header-default">
  <div class="breadcrumb-line">
    <ul class="breadcrumb">
      <li><a href="<?php echo base_url()?>"><i class="icon-home2 position-left"></i> Dashboard</a></li>
      <li class="active">Suppliers</li>
    </ul>
    <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
  </div>
</div>      

<div class="page-header-content">
            <a href="<?php echo base_url('suppliers/add'); ?>" class="btn btn-rounded mb-20 btn-success mb-20 legitRipple">Add <i class="icon-add-to-list"></i> </a>
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
                    <th>Name</th>
                    <th>Phone #</th>
                    <th>GSTIN</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <!-- <th>Zip_Code</th> -->
                    <th>Contact Person</th>
                    <th>Mobile #</th>
                    <!-- <th>Email</th> -->
                    <!-- <th>Notes</th> -->
                    <th>Actions</th>
                    
                </tr>
            </thead>
            <tbody>
<?php

                foreach($data as $row)
{
?>
                <tr>
                    <td><?php echo $row['Supplier_ID'] ?></td>
                    <td><?php echo $row['Supplier_Name'] ?></td>
                    <td><?php echo $row['Phone_Number'] ?></td>
                    <td><?php echo $row['GSTIN'] ?></td>
                    <td><?php echo $row['Supplier_Address'] ?></td>
                    <td><?php echo $row['Country'] ?></td>
                    <td><?php echo $row['State_Name'] ?></td>
                    <td><?php echo $row['City_Name'] ?></td>
                    <!-- <td><?php echo $row['Zip_Code'] ?></td> -->
                    <td><?php echo $row['Contact_Person'] ?></td>
                    <td><?php echo $row['Mobile_Number'] ?></td>
                    <!-- <td><?php echo $row['Email'] ?></td> -->
                    <!-- <td><?php echo $row['Notes'] ?></td> -->
                    <td style="display:flex">
                      <a style="margin-right:5px" href="<?php echo base_url('suppliers/edit/'.$row['Supplier_ID']); ?>" class="btn btn-primary legitRipple"><i class="icon-pencil6 position-left"></i></a>

                    <a onclick="return confirm(`Are you sure you want to remove?`)" href="<?php echo base_url('suppliers/remove/'.$row['Supplier_ID']); ?>" class="btn btn-danger legitRipple"><i class="icon-trash position-left"></i></a>
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