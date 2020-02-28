  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
$(document).ready(function() {
  $("#state").on('change', function(event) {
    var stateId = event.target.value;
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>" + "location_ctrl/getCities/" + stateId,
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

  <select id="state" name="state">
    <option value="-1">-Select State-</option>
    <?php
foreach ($states as $row) {
    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
}
?>
  </select>
  <select id="city" name="city">
    <option value="-1">-Select City-</option>
  </select>