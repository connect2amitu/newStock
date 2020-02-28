<!-- breadcrumb -->
<div class="page-header page-header-default">
  <div class="breadcrumb-line">
    <ul class="breadcrumb">
      <li><a href="<?php echo base_url()?>"><i class="icon-home2 position-left"></i> Dashboard</a></li>
      <li class="active">Customer</li>
    </ul>
    <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
  </div>
</div>      


<div class="page-header-content">
            <a href="<?php echo base_url('customer/add'); ?>" class="btn btn-rounded mb-20 btn-success mb-20 legitRipple">Add <i class="icon-add-to-list"></i> </a>
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
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>GSTIN</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>State</th>
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
                    <td><?php echo $row['Customer_ID'] ?></td>
                    <td><?php echo $row['Customer_Name'] ?></td>
                    <td><?php echo $row['Customer_Address'] ?></td>
                    <td><?php echo $row['Customer_GSTIN'] ?></td>
                    <td><?php echo $row['Mobile_No'] ?></td>
                    <td><?php echo $row['Email'] ?></td>
                    <td><?php echo $row['City_Name'] ?></td>
                    <td><?php echo $row['State_Name'] ?></td>
                    <!-- <td><?php echo $row['Notes'] ?></td> -->

                   

                    <td style="display:flex">
                      <a style="margin-right:5px" href="<?php echo base_url('customer/edit/'.$row['Customer_ID']); ?>" class="btn btn-primary legitRipple"><i class="icon-pencil6 position-left"></i></a>

                    <a onclick="return confirm(`Are you sure you want to remove?`)" href="<?php echo base_url('customer/remove/'.$row['Customer_ID']); ?>" class="btn btn-danger legitRipple"><i class="icon-trash position-left"></i></a>
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