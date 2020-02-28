<div class="content-group">
  <div class="page-header page-header-inverse has-cover">
    <div class="page-header-content">
      <div class="page-title">
        <h5>
          <i class="icon-arrow-left52 position-left"></i>
          <span class="text-semibold">Product Category</span>
        </h5>
      </div>
    </div>
    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
        <li class="active">Product Category</li>
      </ul>
    </div>
  </div>
</div>


<div class="page-header-content">
  <a href="<?php echo base_url('product-category/add'); ?>" class="btn btn-rounded mb-20 btn-success legitRipple">Add <i
      class="icon-add-to-list"></i> </a>
</div>
<?php
  if(count($data)){
?>
<div class="content">


  <div class="row">
    <!-- <div class="alert alert-success no-border">
  <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
  <span class="text-semibold"></span> Record Added <a href="#" class="alert-link"></a>.
</div> -->

    <?php
  if($this->session->userdata('msg')!==null){

?>
    <div class="alert <?= $this->session->userdata('msg')['type'] ?> no-border">
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
          class="sr-only">Close</span></button>
      <?=$this->session->userdata('msg')['msg']?>
    </div>
    <?php
  }
?>


  </div>
  <div class="row">
    <div style="overflow-x:auto;" class="panel panel-flat">

      <!-- <table class="table table-borderd" id="dataTable" width="%" cellspacing="0"> -->
      <!-- <table class="table panel  table-bordered table-hover datatable-highlight"> -->
      <table class="table">
        <!-- <table class="table datatable-responsive-row-control"> -->


        <thead>
          <tr>
            <th style="width:10%">#</th>
            <th>Name</th>
            <th style="width:10%">Actions</th>

          </tr>
        </thead>
        <tbody>
          <?php

                foreach($data as $row)
{
?>
          <tr>
            <td><?php echo $row['Category_ID'] ?></td>
            <td><?php echo $row['Category_Name'] ?></td>
            <td style="display:flex">
              <a style="margin-right:5px" href="<?php echo base_url('product-category/edit/'.$row['Category_ID']); ?>"
                class="btn btn-primary legitRipple"><i class="icon-pencil6 position-left"></i></a>

              <a onclick="return confirm(`Are you sure you want to remove?`)"
                href="<?php echo base_url('product-category/remove/'.$row['Category_ID']); ?>"
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