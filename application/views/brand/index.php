<div class="content-group">
  <div class="page-header page-header-inverse has-cover">
    <div class="page-header-content">
      <div class="page-title">
        <h5>
          <i class="icon-arrow-left52 position-left"></i>
          <span class="text-semibold">Brands</span>
        </h5>
      </div>
    </div>
    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
        <li class="active">Brand</li>
      </ul>
    </div>
  </div>
</div>

<div class="page-header-content">
  <a href="<?php echo base_url('brands/add'); ?>" class="btn btn-rounded mb-20 btn-success legitRipple">Add <i
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
      <!-- <table class="table datatable-responsive-row-control"> -->
      <table class="table">
        <!-- <table class="table datatable-responsive-row-control"> -->


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
            <td><?php echo $row['Brand_ID'] ?></td>
            <td><?php echo $row['Brand_Name'] ?></td>
            <td style="display:flex">
              <a style="margin-right:5px" href="<?php echo base_url('brands/edit/'.$row['Brand_ID']); ?>"
                class="btn btn-primary legitRipple"><i class="icon-pencil6 position-left"></i></a>

              <a onclick="return confirm(`Are you sure you want to remove?`)"
                href="<?php echo base_url('brands/remove/'.$row['Brand_ID']); ?>" class="btn btn-danger legitRipple"><i
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
  }else{
    echo "<h1>No Record Found</h1>";
  }

  ?>

  </div>
</div>