<!-- breadcrumb -->
<div class="page-header page-header-default">
  <div class="breadcrumb-line">
    <ul class="breadcrumb">
      <li><a href="<?php echo base_url()?>"><i class="icon-home2 position-left"></i> Dashboard</a></li>
      <li class="active">Company</li>
    </ul>
    <a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
  </div>
</div>

<div class="page-header-content">
  <a href="<?php echo base_url('company/add'); ?>" class="btn btn-rounded mb-20 btn-success legitRipple">Add <i
      class="icon-add-to-list"></i> </a>
</div>
<?php
  if(count($data)){
?>
<div class="content">

  <div class="row">
    <div style="overflow-x:auto;">

      <!-- <table class="table table-borderd" id="dataTable" width="%" cellspacing="0"> -->
      <table class="table panel  table-bordered table-hover datatable-highlight">

        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Actions</th>

          </tr>
        </thead>
        <tbody>
          <?php

                foreach($data as $row)
{
?>
          <tr>
            <td><?php echo $row['Company_ID'] ?></td>
            <td><?php echo $row['Company_Name'] ?></td>
            <td style="display:flex">
              <a style="margin-right:5px" href="<?php echo base_url('company/edit/'.$row['Company_ID']); ?>"
                class="btn btn-primary legitRipple"><i class="icon-pencil6 position-left"></i></a>

              <a onclick="return confirm(`Are you sure you want to remove?`)"
                href="<?php echo base_url('company/remove/'.$row['Company_ID']); ?>"
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