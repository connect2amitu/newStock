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
</script>


<?php
$formData = false;
$btnName = "Add";
if (isset($data)) {
    $formData = $data[0];
    $redirect = 'suppliers/edit/' . $formData['Supplier_ID'];
    $btnName = "Update";
} else {
    $redirect = 'suppliers/add';
}
?>
<form class="form-horizontal" method="POST" action="<?php echo base_url($redirect); ?>">
  <div class="panel panel-flat">
    <div class="panel-heading">
      <h5 class="panel-title"><?php echo $btnName ?> Supplier</h5>
    </div>

    <div class="panel-body">
      <div class="row">
        <div class="col-md-6">
          <fieldset>

            <div class="form-group">
              <label class="col-lg-3 control-label">Supplier Name:</label>
              <div class="col-lg-9">
                <input name="Supplier_Name" value="<?php echo $formData ? $formData['Supplier_Name'] : "" ?>"
                  type="text" class="form-control text-uppercase" placeholder="Supplier Name">
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label">Office Number #:</label>
              <div class="col-lg-9">
                <input name="Phone_Number" value="<?php echo $formData ? $formData['Phone_Number'] : "" ?>" type="text"
                  placeholder="+99-99-9999-9999" class="form-control">
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label">Address:</label>
              <div class="col-lg-9">
                <input name="Supplier_Address" value="<?php echo $formData ? $formData['Supplier_Address'] : "" ?>"
                  type="text" class="form-control" placeholder="Enter Address">
              </div>
            </div>


            <div class="form-group">
              <label class="col-lg-3 control-label">Location:</label>
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
              <label class="col-lg-3 control-label">Contact person:</label>
              <div class="col-lg-9">
                <input name="Contact_Person" value="<?php echo $formData ? $formData['Contact_Person'] : "" ?>"
                  type="text" class="form-control text-uppercase" placeholder="Supplier contact name">
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label">Contact phone #:</label>
              <div class="col-lg-9">
                <input name="Mobile_Number" value="<?php echo $formData ? $formData['Mobile_Number'] : "" ?>"
                  type="text" placeholder="+99-99-9999-9999" class="form-control">
              </div>
            </div>


            <div class="form-group">
              <label class="col-lg-3 control-label">GST Number:</label>
              <div class="col-lg-9">
                <input name="GSTIN" value="<?php echo $formData ? $formData['GSTIN'] : "" ?>" type="text"
                  placeholder="Enter GSTIN Number" class="form-control">
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label">Email:</label>
              <div class="col-lg-9">
                <input name="Email" value="<?php echo $formData ? $formData['Email'] : "" ?>" type="text"
                  placeholder="Enter email" class="form-control">
              </div>
            </div>



            <div class="form-group">
              <label class="col-lg-3 control-label">Additional message:</label>
              <div class="col-lg-9">
                <textarea name="Notes" rows="5" cols="5" class="form-control" style="resize:none"
                  placeholder="Enter Notes here">
				<?php 
				echo $formData ? $formData['Notes'] : ""
				?>
				</textarea>
              </div>
            </div>


          </fieldset>
        </div>
      </div>

      <div class="text-right">
        <a href="<?php echo base_url('suppliers'); ?>" class="btn btn-danger access-multiple-open legitRipple"><i
            class="icon-circle-left2 position-left"></i> Cancle </a>
        <button type="submit" class="btn bg-teal-400 access-multiple-open legitRipple"><?php echo $btnName; ?> <i
            class="icon-circle-right2 position-right"></i></button>
      </div>
    </div>
  </div>
</form>
<!-- /2 columns form -->