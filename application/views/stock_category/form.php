<?php
$formData=false;
$btnName="Add";
if(isset($data)){
    $formData=$data[0];
    $redirect='product-category/edit/'.$formData['Category_ID'];
    $btnName="Update";
}else{
    $redirect='product-category/add';
}
?>
<form class="form-horizontal" method="POST" action="<?php echo base_url($redirect); ?>">
  <div class="panel panel-flat">
    <div class="panel-heading">
      <h5 class="panel-title"><?php echo $btnName ?> Stock Category</h5>
    </div>

    <div class="panel-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-lg-3 control-label">Category Name:</label>
            <div class="col-lg-9">
              <input name="Category_Name" value="<?php echo $formData ? $formData['Category_Name']:"" ?>" type="text"
                class="form-control text-uppercase" placeholder="Enter Category Name">
            </div>
          </div>
        </div>
      </div>

      <div class="text-right">
        <a href="<?php echo base_url('product-category'); ?>" class="btn btn-danger access-multiple-open legitRipple"><i
            class="icon-circle-left2 position-left"></i> Cancle </a>
        <button type="submit" class="btn bg-teal-400 access-multiple-open legitRipple"><?php echo $btnName; ?> <i
            class="icon-circle-right2 position-right"></i></button>
      </div>
    </div>
  </div>
</form>
<!-- /2 columns form -->