
<?php
$formData=false;
$btnName="Add";
if(isset($data)){
    $formData=$data[0];
    $redirect='expense/edit/'.$formData['Id'];
    $btnName="Update";
}else{
    $redirect='expense/add';
}
?>
<form class="form-horizontal" method="POST" action="<?php echo base_url($redirect); ?>">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title"><?php echo $btnName ?> Expense</h5>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">                                        
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Expense Name:</label>
                                                <div class="col-lg-9">
                                                    <input name="Expense_Name"  value="<?php echo $formData ? $formData['Expense_Name']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Enter Category Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Description:</label>
                                                <div class="col-lg-9">
                                                    <input name="Description"  value="<?php echo $formData ? $formData['Description']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Enter Description">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Expense Date : </label>
                                                    <div class="col-lg-9">
                                                        <input id="datepicker" autocomplete="off" type="text"
                                                        value="<?php echo $formData ? date_format(date_create($formData['Expense_Date']), "d-m-Y") : "" ?>"
                                                            name="Expense_Date" class="form-control datepicker-menus" placeholder="Pick a date&hellip;">
                                                    </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Amount:</label>
                                                <div class="col-lg-9">
                                                    <input name="Amount"  value="<?php echo $formData ? $formData['Amount']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Enter Amount">
                                                </div>
                                            </div>

                    					    </div>
                                		</div>

                                <div class="text-right">
                                    <a href="<?php echo base_url('expense'); ?>" class="btn btn-danger access-multiple-open legitRipple"><i class="icon-circle-left2 position-left"></i> Cancel </a>
                                    <button type="submit" class="btn bg-teal-400 access-multiple-open legitRipple"><?php echo $btnName; ?> <i class="icon-circle-right2 position-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /2 columns form -->