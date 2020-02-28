<!-- breadcrumb -->
<div class="page-header page-header-default">
  <div class="breadcrumb-line">
    <ul class="breadcrumb">
      <li><a href="<?php echo base_url()?>"><i class="icon-home2 position-left"></i> Dashboard</a></li>
      <li class="active">Company Details</li>
    </ul>
    <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
  </div>
</div>


<div class="page-header-content">
  <a href="<?php echo base_url('company-details/add'); ?>"
    class="btn btn-rounded mb-20 btn-success mb-20 legitRipple">Add <i class="icon-add-to-list"></i> </a>
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
            <th>Company Name</th>
            <th>Address</th>
            <th>Telephone #</th>
            <th>Mobile #</th>
            <th>Country</th>
            <th>State</th>
            <th>City</th>
            <th>GSTIN</th>
            <th>PAN</th>
            <th>Bank Name</th>
            <th>Branch Name</th>
            <th>Account #</th>
            <th>IFSC</th>
            <th>Email</th>
            <th>Website</th>
            <th>Company Logo</th>
            <!-- <th>Description</th> -->

            <th>Actions</th>

          </tr>
        </thead>
        <tbody>
          <?php

                foreach($data as $row)
{
?>
          <tr>
            <td><?php echo $row['ID'] ?></td>
            <td><?php echo $row['Company_Name'] ?></td>
            <td><?php echo $row['Address'] ?></td>
            <td><?php echo $row['Phone_Number'] ?></td>
            <td><?php echo $row['Mobile_No'] ?></td>
            <td><?php echo $row['Country'] ?></td>
            <td><?php echo $row['State_Name'] ?></td>
            <td><?php echo $row['City_Name'] ?></td>
            <td><?php echo $row['GSTIN'] ?></td>
            <td><?php echo $row['Pan_No'] ?></td>
            <td><?php echo $row['Bank_Name'] ?></td>
            <td><?php echo $row['Branch_Name'] ?></td>
            <td><?php echo $row['Account_Number'] ?></td>
            <td><?php echo $row['IFSC_Code'] ?></td>




            <td><?php echo $row['Email'] ?></td>
            <td><?php echo $row['Website'] ?></td>
            <td><?php echo $row['Company_Logo'] ?></td>
            <!-- <td><?php echo $row['Description'] ?></td> -->
            <td style="display:flex">
              <a style="margin-right:5px" href="<?php echo base_url('company-details/edit/'.$row['ID']); ?>"
                class="btn btn-primary legitRipple"><i class="icon-pencil6 position-left"></i></a>

              <a onclick="return confirm(`Are you sure you want to remove?`)"
                href="<?php echo base_url('company-details/remove/'.$row['ID']); ?>"
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