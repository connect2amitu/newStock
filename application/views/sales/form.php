<script>
  var payment_array=[];
  var taxSummary=[];
$(document).ready(function() {
  // $("#datepicker").datepicker();
  $('#productSelect').on('change', function(e) {
    var id = e.target.value;
    $.ajax({
      url: "<?php echo base_url('products/getProductById ') ?>",
      // dataType: 'text',
      type: 'POST',
      // contentType: 'text/html',
      data: {
        "id": id
      },
      success: function(res) {
        var data = JSON.parse(res);

        $(e.target).closest("tr").find('[name="HSN[]"]').val(data.HSN);
        $(e.target).closest("tr").find('[name="unit[]"]').val(data.Name);
        $(e.target).closest("tr").find('[name="Selling_Price[]"]').val(data.Selling_Price);
        $(e.target).closest("tr").find('[name="Available_Qty[]"]').val(data.Available_Qty);
        $(e.target).closest("tr").find('[name="Purchasing_Quantity[]"]').val('');
        $(e.target).closest("tr").find('[name="GST[]"]').val(data.GST);
      },
      error: function(errorThrown) {
        console.log(errorThrown);
      }
    });

  });
  
  $('#Customer_ID').on('change', function(e) {
    if(e.target.value>0){
    $.ajax({
      url: "<?php echo base_url('customer_ctrl/get_customer_id') ?>/"+e.target.value,
      type: 'GET',
      success: function(res) {
        var data = JSON.parse(res);
        console.log('data => ',data);
        $('#State').val(data.State_Name);
        $('#Customer_GSTIN').val(data.Customer_GSTIN);
        $('#Customer_Address').val(data.Customer_Address);
      },
      error: function(errorThrown) {
        console.log(errorThrown);
      }
    });
  }else{
        $('#State').val('');
        $('#Customer_GSTIN').val('');
        $('#Customer_Address').val('');
  }
    });
          
  
  $('.addProduct').on('click', function(e) {
    var Product_ID = $(e.target).closest("tr").find('[name="Product_ID[]"]').val();
    var Product_Name = $(e.target).closest("tr").find('option:selected').text();
    var qty = $(e.target).closest("tr").find('[name="Purchasing_Quantity[]"]').val();
    var Available_Qty = $(e.target).closest("tr").find('[name="Available_Qty[]"]').val();
    var Selling_Price = $(e.target).closest("tr").find('[name="Selling_Price[]"]').val();
    var HSN = $(e.target).closest("tr").find('[name="HSN[]"]').val();
    var unit = $(e.target).closest("tr").find('[name="unit[]"]').val();
    var GST = $(e.target).closest("tr").find('[name="GST[]"]').val();
    var discount = $(e.target).closest("tr").find('[name="discount[]"]').val();
    if(checkAvailablQty({value:qty})){
      if(qty!=="" && qty>0 && Product_ID!=="" && Selling_Price!=="" && HSN!=="" && unit!==""){
      

      var totalPrice = Selling_Price*qty;

      // if(discount>0){
        totalPrice = (totalPrice)-(totalPrice*discount/100);
      // }
    
     var IGST=(totalPrice*GST)/100;
     var SGST=0;
     var CGST=0;

      if($('#State').val()=="Gujarat"){
        SGST=IGST/2;
        CGST=IGST/2;
        IGST=0;
      }
      
      taxSummary.push({
        Product_ID,
        subTotal:totalPrice,
        GST,
        SGST,
        CGST,
        IGST,
      });

      var data = {
        "id": Product_ID,
        "qty": qty,
        "price": Selling_Price,
        "name": Product_Name,
        "HSN": HSN,
        "unit": unit,
        "GST": GST,
        "SGST":SGST,
        "CGST":CGST,
        "IGST":IGST,
        "discount": discount,
      };
console.log("addToCart",data);

      $.ajax({
        url: "<?php echo base_url('sales/addToCart ') ?>",
        // dataType: 'text',
        type: 'POST',
        // contentType: 'text/html',
        data: data,
        success: function(data) {
          $('tbody.final_list').empty().append(data);
          calcSubTotal();

          $("#productSelect").val('-1');
          $(e.target).closest("tr").find('[name="Purchasing_Quantity[]"]').val('');
          $(e.target).closest("tr").find('[name="Selling_Price[]"]').val('');
          $(e.target).closest("tr").find('[name="Available_Qty[]"]').val('');
          $(e.target).closest("tr").find('[name="HSN[]"]').val('');
          $(e.target).closest("tr").find('[name="unit[]"]').val('');
          $(e.target).closest("tr").find('[name="GST[]"]').val('');
          $(e.target).closest("tr").find('[name="discount[]"]').val('');
          calcSubTotal();
        },
        error: function(errorThrown) {
          console.log(errorThrown);
        }
      });
      }else{

      $(e.target).closest("tr").find('[name="Purchasing_Quantity[]"]').css({"color":"red","border":"1px solid red"});
      }
    }else{
      $(e.target).closest("tr").find('[name="Purchasing_Quantity[]"]').css({"color":"red","border":"1px solid red"});
    }
  });
  
  $('#Add_Payment_btn').on('click', function(e) {
    var Payment_Mode=$('#Payment_Mode').val()
    var Add_Payment=$('#Add_Payment').val()
    if(Payment_Mode && Payment_Mode!=="" && Add_Payment && Add_Payment!==0 && Add_Payment!=""){
    payment_array.push({
      Payment_Mode,
      Add_Payment
    })
    $('#Add_Payment').val('')
    calcSubTotal();
    }
    // console.log("payment_array",payment_array);
  });

  $(document).on('click', '.remove_cart', function(e) {
    var row_id = $(this).attr("id");
    var product = $(e).attr("productId");
console.log('product => ',product);

    taxSummary = taxSummary.filter(function(item) {
    return item.Product_ID !== product
    })
    swal({
        title: "Are you sure?",
        text: "You want to delete this Product Item!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete it!",
        closeOnConfirm: false
      },
      function() {
        $.ajax({
          url: "<?php echo site_url('purchase/delete_cart'); ?>",
          method: "POST",
          data: {
            row_id: row_id
          },
          success: function(data) {
            $('tbody.final_list').empty().append(data);

            calcSubTotal();
          }
        });
        swal("", "Product deleted Successfully", "success");
      }
    );
  });


  
});
    function calcSubTotal(){
      var total=0;
      var t = document.getElementById("product_list_tbl");
      var inputs = t.getElementsByTagName("input");

      for(i=0;i<inputs.length;i++){
        total = total+parseInt(inputs[i].value);
      }

      $('#hidden_total').val(total)
      $('#sub_total').val(total)
    
      var amount_Due=grand_total;
      var amount_Due_total=0;
      $('#payment_type_list').empty();
      if(payment_array.length)
      {
          var table="<table class='table' border=1><tr style='background-color: #f5f5f5;'><th>Payment Method</th><th>Amount</th><th>Action</th></tr>";
        for (let i = 0; i < payment_array.length; i++) {
          amount_Due-=payment_array[i].Add_Payment;
          amount_Due_total+=parseInt(payment_array[i].Add_Payment);
          table+="<tr><td>"+ payment_array[i].Payment_Mode  +"</td><td>"+ payment_array[i].Add_Payment  +"</td><td><i style='color:red;cursor:pointer' id='payment_array-"+ i +"' onclick='delete_payment("+i+")' class='icon-trash-alt'></i></td></tr>";
        }
        table+="<tr style='font-weight:600;font-size: 18px;background-color: #f5f5f5;'><td style='text-align:right;'>Total</td><td>"+ amount_Due_total  +"</td><td></td></tr></table>";
        $('#payment_type_list').append(table);
      }
      $('#Hidden_Amount_Due').val(JSON.stringify(payment_array));
 
      var totalTax=0;
      var totalIGST=0;
      var totalCGST=0;
      var totalSGST=0;

      $('#tax_summart_list').empty();
      if(taxSummary.length){
        var taxSummarytable="<table class='table' border=1><tr style='background:#f5f5f5'><th>GST</th><th>Price</th><th>IGST</th><th>CGST</th><th>SGST</th></tr>";
      
      for (let i = 0; i < taxSummary.length; i++) {
        totalIGST+=taxSummary[i].IGST;
        totalCGST+=taxSummary[i].CGST;
        totalSGST+=taxSummary[i].SGST;
        taxSummarytable+="<tr><td>"+ taxSummary[i].GST  +"%</td><td>"+ taxSummary[i].subTotal  +"</td><td>"+ taxSummary[i].IGST  +"</td><td>"+ taxSummary[i].CGST  +"</td><td>"+ taxSummary[i].SGST  +"</td></tr>";
      }

      var totalTaxAmount=eval(totalIGST+totalCGST+totalSGST).toFixed(2);
      
      taxSummarytable+="<tr style='font-weight:600;font-size: 18px;background-color: #f5f5f5;'><td style='text-align:right;' colspan=2>Total</td><td colspan=3>"+ totalTaxAmount  +"</td></tr></table>";
      $('#tax_summart_list').append(taxSummarytable);
      }
      $('#CGST').val(totalCGST.toFixed(2));
      $('#SGST').val(totalSGST.toFixed(2));
      $('#IGST').val(totalIGST.toFixed(2));

      $('#Hidden_Tax_Summart_List').val(JSON.stringify(taxSummary));


      var discount = isNaN(parseInt($('#final_discount').val()))?0:parseInt($('#final_discount').val());
      var grand_total= parseInt(total - discount+parseInt(totalTaxAmount));
      $('#grand_total').val(grand_total.toFixed(2));
      $('#Amount_Due').val(grand_total-amount_Due_total);
      $('#Add_Payment').val(grand_total-amount_Due_total);
      
      
}


  function checkAvailablQty(e){
    var Available_Qty= $(document).find('[name="Available_Qty[]"]').val();

    if(parseInt(e.value) <= parseInt(Available_Qty)){
      return true;
    }else{
      swal("Opps!", "No product available!", "error");    
      return false;
    }
  }

  function delete_payment(i){
    
    payment_array.splice(i,1);
    console.log("payment_array",payment_array);
    
    calcSubTotal();
    }

</script>
<?php

$formData = false;
$btnName = "Save";
if (isset($data)) {
    $formData = $data[0];
    $redirect = 'sales/edit/' . $formData['Sales_ID'];
    $btnName = "Update";
} else {
    $redirect = 'sales/add';
}
?>
<form class="form-horizontal" method="POST" action="<?php echo base_url($redirect); ?>" onkeydown="return event.key != 'Enter';">
  <div class="panel panel-flat">
    <div class="panel-heading">
      <h5 class="panel-title"><?php echo $btnName==="Save"?"Add":"Update" ?> Sales</h5>
    </div>

    <div class="panel-body">
      <div class="row">
        <div class="col-md-6">
          <fieldset>
            <div class="form-group">
              <label class="col-lg-3 control-label">Customer : </label>
              <div class="col-lg-9">
                <select id="Customer_ID" name="Customer_ID" class="select-search select2-hidden-accessible"
                  tabindex="-1" aria-hidden="true">
                  <option disabled <?php echo !$formData ? "selected" : ""; ?> value="-1">Select Customer</option>
                  <option selected value="0">Cash</option>
                  <?php
foreach ($customers as $row) {
    ?>
                  <option <?php echo $formData && $formData['Customer_ID'] === $row['Customer_ID'] ? "selected" : ""; ?>
                    value="<?php echo $row['Customer_ID'] ?>"><?php echo $row['Customer_Name'] ?></option>
                  <?php
}
?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Address : </label>
              <div class="col-lg-9">
                <input style="background: #f5f5f5;cursor:not-allowed" readonly name="Customer_Address" id="Customer_Address" value="<?php echo $formData ? $formData['Customer_Address'] : "" ?>"
                  type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">GSTIN : </label>
              <div class="col-lg-9">
                <input style="background: #f5f5f5;cursor:not-allowed" readonly name="Customer_GSTIN" id="Customer_GSTIN"  value="<?php echo $formData ? $formData['Customer_GSTIN'] : "" ?>"
                  type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">State : </label>
              <div class="col-lg-9">
                <input style="background: #f5f5f5;cursor:not-allowed" readonly name="State" id="State" value="<?php echo $formData ? $formData['State'] : "" ?>"
                  type="text" class="form-control">
              </div>
            </div>
          </fieldset>
        </div>
        <div class="col-md-6">
          <fieldset>

            <div class="form-group">
              <label class="col-lg-3 control-label">Sales Invoice : </label>
              <div class="col-lg-9">
                <input  style="background: #f5f5f5;cursor:not-allowed" name="Sales_Invoice" readonly value="<?php echo $formData ? $formData['Sales_Invoice'] : $lastSalesId ?>"
                  type="text" class="form-control " placeholder="Enter Sales Invoice Number">
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label">Sales Date : </label>
              <div class="col-lg-9">
                <input id="datepicker" autocomplete="off" type="text"
                  value="<?php echo $formData ? date_format(date_create($formData['Sales_Date']), "d-m-Y") : date('d-m-Y', time()) ?>"
                  name="Sales_Date" class="form-control datepicker-menus" placeholder="Pick a date&hellip;">
              </div>
            </div>


            <div class="form-group">
              <label class="col-lg-3 control-label">Notes : </label>
              <div class="col-lg-9">
                <input name="Sales_Notes" autocomplete="off" value="<?php echo $formData ? $formData['Sales_Notes'] : "" ?>"
                  type="text" class="form-control " placeholder="Enter Notes">
              </div>
            </div>
          </fieldset>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="">
            <table class="panel panel-flat table products_list product_details" id="product_details" style="margin:15px 0">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>UOM</th>
                  <th>HSN</th>
                  <th>Tax</th>
                  <th>Avaliable Qty.</th>
                  <th>Qty</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <!-- <th style="text-align: center;">Amount</th> -->
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr class="tr_clone">
                  <td>
                    <div class="form-group">
                      <select id="productSelect"  name="Product_ID[]" class="form-control" tabindex="-1"
                        aria-hidden="true">
                        <option selected value="0" disabled>-Select Product-</option>
                        <?php
foreach ($products as $row) {
    ?>
                        <option
                          <?php echo $formData && $formData['Product_ID'] === $row['Product_ID'] ? "selected" : ""; ?>
                          value="<?php echo $row['Product_ID'] ?>"><?php echo $row['Stock_Name'] ?></option>
                        <?php
}
?>
                      </select>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" readonly name="unit[]" value="" class="form-control" />
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" readonly name="HSN[]" value="" class="form-control HSN">
                    </div>
                  </td>

                  <td style="padding-top: 8px;">
                    <div class="form-group">
                      <input type="text" readonly name="GST[]" placeholder="0 %" class="form-control">
                    </div>
                  </td>

                  <td>
                    <div class="form-group">
                      <input type="text" readonly autocomplete="off" name="Available_Qty[]" placeholder="0"
                        class="form-control">
                    </div>
                  </td>
                
                  <td>
                    <div class="form-group">
                      <input type="number" autocomplete="off" onchange="return checkAvailablQty(this)" name="Purchasing_Quantity[]" placeholder="0"
                        class="form-control quantity">
                    </div>
                  </td>

                  <td>
                    <div class="form-group">
                      <input type="text" readonly name="Selling_Price[]" placeholder="0.00" class="form-control">
                    </div>
                  </td>

                  <td style="padding-top:8px !important">
                    <div class="form-group">
                      <input type="text" autocomplete="off" name="discount[]" class="form-control discount" value=""
                        placeholder="% discount">
                    </div>
                  </td>

                  <td style="text-align: center;">
                    <div class="form-group">
                      <a href="#" class="btn btn-success addProduct pull-right mb-20"><span
                          class="icon-plus3"></span> Add Product</a>
                    </div>
                  </td>
                </tr>
              </tbody>

            </table>
            <h1>Product Detail</h1>
            <div class="row" >
            <div class="col-sm-12 ">
            <table class="table table-striped" style="background-color: #f5f5f5;margin:15px 0">
            
                <thead>
                  <tr>
                    <th>ACTION</th>
                    <th>Product</th>
                    <th>UOM</th>
                    <th>HSN</th>
                    <th>Tax</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Dis.</th>
                    <th style="text-align: center;">Amount</th>
                  </tr>
                </thead>
                <tbody class="final_list" id="product_list_tbl">
                  <?php
                    $sub_total=0;
                  ?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-4">
              <div id="payment_type_list"></div>
            </div>
            <div class="col-sm-4">
              <div id="tax_summart_list"> </div>
              <input type="hidden" readonly name="Hidden_Tax_Summart_List" id="Hidden_Tax_Summart_List"/>
            </div>
            <div class="col-sm-4">
          <table class="table ">
          <tr>
            <td>Sub Total</td>
            <td>
            <input type="hidden" id="hidden_total" class="form-control" value="<?php echo $sub_total;?>"/>
            <input style="width:50px"  type="text" readonly name="Sub_Total" id="sub_total" class="form-control" value="<?php echo $sub_total;?>"  placeholder="Sub total"/>
            </td>
          </tr>
          <tr>
            <td>GST</td>
            <td>
              <table>
                <tr><td>CGST &nbsp;: </td><td><input type="text" readonly name="CGST" id="CGST" class="form-control" value=""  placeholder="CGST"/></td></tr>
                <tr><td>SGST &nbsp;: </td><td><input type="text" readonly name="SGST" id="SGST" class="form-control" value=""  placeholder="SGST"/></td></tr>
                <tr><td>IGST &nbsp;: </td><td><input type="text" readonly name="IGST" id="IGST" class="form-control" value=""  placeholder="IGST"/></td></tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>Discount</td>
            <td><input type="text"name="Discount"  onkeyup="calcSubTotal()" id="final_discount" autocomplete="off" value="0" class="form-control"  placeholder="Discount"/></td>
          </tr>
          <tr>
            <td><strong>Grand Total</strong></td>
            <td><input type="text" style="font-size: 22px;font-weight: 500;" name="Grand_Total" readonly id="grand_total" class="form-control" value="0"  placeholder="Grand Total"/></td>
          </tr>
          <tr>
            <td>Amount Due</td>
            <td><input type="text" readonly name="Amount_Due" id="Amount_Due" autocomplete="off" value="0" class="form-control"  placeholder="Amount_Due"/>
            <input type="hidden" readonly name="Hidden_Amount_Due" id="Hidden_Amount_Due"/>
            </td>
          </tr>
          <tr>
            <td>Add Payment</td>
            <td>
            <select id="Payment_Mode" name="Payment_Mode" class="select  select2-hidden-accessible"
                  tabindex="-1" aria-hidden="true">
                  <option disabled selected value="-1">Select Payment mode</option>
                  <option value="Cash" selected>Cash</option>
                  <option value="Credit">Credit</option>
                  <option value="Cheque">Cheque</option>
                  <option value="Net Banking">Net Banking</option>
                  <option value="UPI">UPI</option>
                </select>
                <input type="text" id="Add_Payment" autocomplete="off"  class="form-control" placeholder="Enter Payments"  />
                <button type="button" id="Add_Payment_btn" class=" btn bg-teal-400  access-multiple-open">Add Payment
                <!-- <i class="icon-plus"></i> -->
            </button>
            </td>
          </tr>
          </table>
            </div>
            </div>
          </div>
        </div>
      </div>


      <div class="text-right mt-20">
        <a href="<?php echo base_url('sales'); ?>" class="btn btn-danger access-multiple-open legitRipple"><i
            class="icon-circle-left2 position-left"></i> Cancel </a>
        <button name="save" value="save" type="submit" class="btn bg-teal-400 access-multiple-open legitRipple"><?php echo $btnName; ?> <i
            class="icon-circle-right2 position-right"></i></button>
        <button name="save_print" value="save_print" type="submit" class="btn btn-success legitRipple legitRipple">Save & Print <i
            class="icon-printer2 position-right"></i></button>
      </div>
    </div>
  </div>
</form>