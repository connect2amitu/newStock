
<?php
$formData=false;
$btnName="Add";
if(isset($data)){
	$formData=$data[0];
	$redirect='products/edit/'.$formData['Product_ID'];
	$btnName="Update";
}else{
	$redirect='products/add';
}
?>
<form class="form-horizontal" method="POST" action="<?php echo base_url($redirect); ?>">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title"><?php echo $btnName ?> Products</h5>
		</div>

			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<fieldset>
							<div class="form-group">
								<label class="col-lg-3 control-label">Supplier Name : </label>
								<div class="col-lg-9">
									<select name="Supplier_Number" class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true">
									<?php
										foreach($suppliers as $row){
											?>
												<option  <?php echo $formData && $formData['Supplier_Number']===$row['Supplier_ID']?"selected":""; ?> value="<?php echo $row['Supplier_ID'] ?>"><?php echo $row['Supplier_Name'] ?></option> 
											<?php
										}
									?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-lg-3 control-label">Stock Code : </label>
								<div class="col-lg-9">
									<input name="Stock_Number"  value="<?php echo $formData ? $formData['Stock_Number']:"" ?>" type="text" class="form-control " placeholder="Enter Stock Code">
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 control-label">Stock Name : </label>
								<div class="col-lg-9">
									<input name="Stock_Name"  value="<?php echo $formData ? $formData['Stock_Name']:"" ?>" type="text" class="form-control " placeholder="Enter Stock Name">
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-xs-6">
										<label class="col-xs-6 control-label">Unit Of Measurement : </label>
											<div class="col-xs-6">
												<select name="Unit_Of_Measurement" class="select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
												<?php
													foreach($units as $row){
														?>
															<option <?php echo $formData && $formData['Unit_Of_Measurement']===$row['Unit_ID']?"selected":"" ?> value="<?php echo $row['Unit_ID'] ?>"><?php echo $row['Name'] ?></option> 
														<?php
													}
												?>
												</select>
											</div>
										</div>	
										<div class="col-xs-6">
											<label class="col-xs-3 control-label">Brand : </label>
												<div class="col-xs-9">
												<select name="Brand_Name" class="select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
												<?php
													foreach($brands as $row){
														?>
															<option <?php echo $formData && $formData['Brand_Name']===$row['Brand_ID']?"selected":"" ?> value="<?php echo $row['Brand_ID'] ?>"><?php echo $row['Brand_Name'] ?></option> 
														<?php
													}
												?>
												</select>
												</div>
										</div>
										
								</div>	
							</div>
							
							<div class="form-group">
								<label class="col-lg-3 control-label">Category : </label>
								<div class="col-lg-9">
									<select name="Category" class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true">
									<?php
										foreach($categories as $row){
											?>
												<option <?php echo $formData && $formData['Category']===$row['Category_ID']?"selected":"" ?> value="<?php echo $row['Category_ID'] ?>"><?php echo $row['Category_Name'] ?></option> 
											<?php
										}
									?>
									</select>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-md-6">
						<fieldset>
							<div class="form-group">
								<label class="col-lg-3 control-label">Purchasing Price : </label>
								<div class="col-lg-9">
									<input name="Purchasing_Price"  value="<?php echo $formData ? $formData['Purchasing_Price']:"" ?>" type="text" class="form-control " placeholder="Enter Purchasing Price">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-lg-3 control-label">Selling Price : </label>
								<div class="col-lg-9">
									<input name="Selling_Price"  value="<?php echo $formData ? $formData['Selling_Price']:"" ?>" type="text" class="form-control " placeholder="Enter Selling Name">
								</div>
							</div>
							

							<div class="form-group">
								<label class="col-lg-3 control-label">GST % : </label>
								<div class="col-lg-3">
									<select name="GST"  data-placeholder="Select GST %..." class="select select2-hidden-accessible select2-selection--single" tabindex="-1" aria-hidden="true">
									<?php
										foreach($gst as $row){
											?>
												<option <?php echo $formData && $formData['GST']===$row['Rate']?"selected":"" ?> value="<?php echo $row['Rate'] ?>"><?php echo $row['Rate'] ?></option> 
											<?php
										}
									?>
									</select>
								</div>
									<div class="col-xs-6">
											<label class="col-xs-3 control-label">HSN : </label>
												<div class="col-xs-9">
													<input name="HSN"  value="<?php echo $formData ? $formData['HSN']:"" ?>" type="text" class="form-control " placeholder="Enter HSN Number">
												</div>
										</div>
							</div>
							<!-- <div class="form-group">
								<label class="col-lg-3 control-label">Quantity : </label>
								<div class="col-lg-9">
									<input name="Available_Qty"  value="<?php echo $formData ? $formData['Available_Qty']:"" ?>" type="text" class="form-control " placeholder="Enter Available_Qty">
								</div>
							</div> -->

							<div class="form-group">
								<label class="col-lg-3 control-label">Notes : </label>
								<div class="col-lg-9">
									<input name="Notes"  value="<?php echo $formData ? $formData['Notes']:"" ?>" type="text" class="form-control " placeholder="Enter Notes">
								</div>
							</div>
						</fieldset>
					</div>
				</div>

				<div class="text-right">
					<a href="<?php echo base_url('products'); ?>" class="btn btn-danger access-multiple-open legitRipple"><i class="icon-circle-left2 position-left"></i> Cancle </a>
					<button type="submit" class="btn bg-teal-400 access-multiple-open legitRipple"><?php echo $btnName; ?> <i class="icon-circle-right2 position-right"></i></button>
				</div>
		</div>
	</div>
</form>
					<!-- /2 columns form -->