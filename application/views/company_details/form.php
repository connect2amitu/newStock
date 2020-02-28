
<script>
$(document).ready(function() {
  $("#state").on('change', function(event) {
    var stateId = event.target.value;
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>" + "common_ctrl/getCities/" + stateId,
      dataType: 'json',
      success: function(res) {
        if (res) {}
      },
      error: function(e) {
        $("#city").html(e.responseText);
        console.info(`e => `, e);
      }
    });
  });
});


function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

</script>


<?php
$formData=false;
$btnName="Update";
$redirect='company_details/edit';
if(isset($data)){
	$formData=$data[0];
}
?>
<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url($redirect); ?>">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title"><?php echo $btnName ?> Company Details</h5>
							</div>

							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										<fieldset>

											<div class="form-group">
												<label class="col-lg-3 control-label">Company Name:</label>
												<div class="col-lg-9">
													<input name="Company_Name"  value="<?php echo $formData ? $formData['Company_Name']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Company Name">
												</div>
											</div>										

											<div class="form-group">
												<label class="col-lg-3 control-label">Address:</label>
												<div class="col-lg-9">
                        							<input name="Address" value="<?php echo $formData ? $formData['Address']:"" ?>" type="text" class="form-control" placeholder="Enter Address">
												</div>
											</div>

											<div class="form-group">
													<label class="col-lg-3 control-label">Office #:</label>
													<div class="col-lg-9">
														<input name="Phone_Number" value="<?php echo $formData ? $formData['Phone_Number']:"" ?>" type="text" placeholder="+99-99-9999-9999" class="form-control">
													</div>
											</div>

											<div class="form-group">
													<label class="col-lg-3 control-label">Mobile #:</label>
													<div class="col-lg-9">
														<input name="Mobile_No" value="<?php echo $formData ? $formData['Mobile_No']:"" ?>" type="text" placeholder="+99-99-9999-9999" class="form-control">
													</div>
											</div>

											<div class="form-group">
											<label class="col-lg-3 control-label">Email:</label>
											<div class="col-lg-9">
												<input name="Email" value="<?php echo $formData ? $formData['Email']:"" ?>" type="text" placeholder="Enter email" class="form-control">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-3 control-label">Website:</label>
											<div class="col-lg-9">
												<input name="Website" value="<?php echo $formData ? $formData['Website']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Website Name">
											</div>
										</div>

                      
											<div class="form-group">
												<label class="col-lg-3 control-label">Location :</label>
												<div class="col-lg-9">
													<div class="row">
													<div class="col-md-6">
														<div class="mb-15">
															<select name="Country" value="<?php echo $formData ? $formData['Country'] : "" ?>" class="select">
																	<option value="IN">India</option>
															</select>
														</div>
															<select id="city" name="City" class="select-search">
															<option value="-1">-Select City-</option>
															<?php
																foreach ($cities as $row) {
															?>
																<option <?php echo $formData && $formData['City']===$row['id']?"selected":""; ?>  value="<?=$row['id']?>"><?=$row['name']?></option>
															<?php
																}
													?>
															</select>

													</div>
                                          
													<div class="col-md-6">
				  <select id="state" name="State" class="select-search">
                      <option value="-1">-Select State-</option>
                      <?php
						foreach ($states as $row) {
						?>
							<option <?php echo $formData && $formData['State']===$row['id']?"selected":""; ?>  value="<?=$row['id']?>"><?=$row['name']?></option>
						<?php
						}
?>
                    </select>
                  </div>
													</div>
												</div>
											</div>

                      
										</fieldset>
									</div>

									<div class="col-md-6">
										<fieldset>
										
                      
										<div class="form-group">
											<label class="col-lg-3 control-label">PAN NO:</label>
											<div class="col-lg-9">
												<input name="Pan_No" value="<?php echo $formData ? $formData['Pan_No']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Pan Number">
											</div>
										</div>

										
										<div class="form-group">
											<label class="col-lg-3 control-label">GST Number:</label>
											<div class="col-lg-9">
											<input name="GSTIN" value="<?php echo $formData ? $formData['GSTIN']:"" ?>" type="text" placeholder="Enter GSTIN Number" class="form-control">
											</div>
										</div>

										
										<div class="form-group">
											<label class="col-lg-3 control-label">Bank Name:</label>
											<div class="col-lg-9">
												<input name="Bank_Name" value="<?php echo $formData ? $formData['Bank_Name']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Bank Name">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-3 control-label">Branch Name:</label>
											<div class="col-lg-9">
												<input name="Branch_Name" value="<?php echo $formData ? $formData['Branch_Name']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Branch Account Number">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-3 control-label">Account #:</label>
											<div class="col-lg-9">
												<input name="Account_Number" value="<?php echo $formData ? $formData['Account_Number']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Bank Account Number">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-3 control-label">IFSC Code:</label>
											<div class="col-lg-9">
												<input name="IFSC_Code" value="<?php echo $formData ? $formData['IFSC_Code']:"" ?>" type="text" class="form-control text-uppercase" placeholder="Bank IFSC Code">
											</div>
										</div>



										<div class="form-group">
											<label class="col-lg-3 control-label">Logo:</label>
											<div class="col-lg-9" style="display: flex;">
												<input style="width: 164px;" onchange="readURL(this);" name="Company_Logo" value="<?php echo $formData ? $formData['Company_Logo']:"" ?>" type="file" class="form-control text-uppercase">
												<img id="blah" src="<?php echo $formData ? base_url($formData['Company_Logo']):"https://frazerpromo.com/thumbnail_Images/no_image.png" ?>" height="140" width="250" alt="your image" />

											</div>
										</div>

									

										<div class="form-group">
											<label class="col-lg-3 control-label">Additional message:</label>
												<div class="col-lg-9">
													<textarea name="Description"  rows="5" cols="5" class="form-control"  style="resize:none"  placeholder="Enter Notes here">
													<?php echo $formData ? $formData['Description']:"" ?>
													</textarea>
												</div>
										</div>
                      
                      
										</fieldset>
									</div>
								</div>

								<div class="text-right">
									<a href="<?php echo base_url('company_details'); ?>" class="btn btn-danger access-multiple-open legitRipple"><i class="icon-circle-left2 position-left"></i> Cancle </a>
									<button type="submit" class="btn bg-teal-400 access-multiple-open legitRipple"><?php echo $btnName; ?> <i class="icon-circle-right2 position-right"></i></button>
								</div>
							</div>
						</div>
					</form>
					<!-- /2 columns form -->