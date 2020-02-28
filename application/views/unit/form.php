
<?php
$formData=false;
$btnName="Add";
if(isset($data)){
    $formData=$data[0];
    $redirect='unit/edit/'.$formData['Unit_ID'];
    $btnName="Update";
}else{
    $redirect='unit/add';
}
?>

<div class="col-md-6">
    <form method="POST" action="<?php echo base_url($redirect); ?>">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Unit name:</label>
                            <input name="Name"  value="<?php echo $formData ? $formData['Name']:"" ?>" type="text" class="form-control" placeholder="Enter Unit name">
                        </div>

                        <div class="form-group">
                            <label>Unit Description:</label>
                            <input name="Description"  value="<?php echo $formData ? $formData['Description']:"" ?>" type="text" class="form-control" placeholder="Enter Unit Description">
                        </div>

                        <div class="text-right">
                            <a href="<?php echo base_url('unit'); ?>" class="btn btn-danger access-multiple-open legitRipple"><i class="icon-circle-left2 position-left"></i> Cancle </a>
                            <button type="submit" class="btn bg-teal-400 access-multiple-open legitRipple"><?php echo $btnName; ?> <i class="icon-circle-right2 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
