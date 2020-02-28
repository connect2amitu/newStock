<script>
  var payment_array=[];
  var taxSummary=[];
$(document).ready(function() {
  // $("#datepicker").datepicker();
  $('#productSelect').on('change', function(e) {
    var id = e.target.value;
    $.ajax({
      url: "<?php echo base_url('products/getProductById') ?>",
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


  $('#Sales_Invoice').on('change', function(e) {
    var id = e.target.value;
    $.ajax({
      url: "<?php echo base_url('sales-return/get_sales_by_invoice') ?>",
      // dataType: 'text',
      type: 'POST',
      // contentType: 'text/html',
      data: {
        "Sales_Invoice": id
      },
      success: function(res) {
        var data = JSON.parse(res);
        $('#Customer_ID').val(data.sales.Customer_Name);
        $('#State_Name').val(data.sales.State_Name);
        $('#Sales_Date').val(moment(data.sales.Sales_Date).format("DD-MM-YYYY"));
        var tableList="";
        data.sales_details.forEach(row => {
          tableList+=`<tr class="tr_clone">
                  <td>
                    <div class="form-group">
                      <input type="text" readonly tabindex="-1" name="Product_Name[]" value="${row.Stock_Name}" class="form-control" />
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" readonly tabindex="-1" name="unit[]" value="${row.Name}" class="form-control" />
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" readonly tabindex="-1" name="HSN[]" value="${row.HSN}" class="form-control HSN">
                    </div>
                  </td>

                  <td style="padding-top: 8px;">
                    <div class="form-group">
                      <input type="text" readonly tabindex="-1" name="GST[]" placeholder="0 %" value="${row.GST}" class="form-control">
                    </div>
                  </td>

                  <td>
                    <div class="form-group">
                      <input type="text" readonly tabindex="-1" autocomplete="off" placeholder="Sales Qty" value="${row.Sales_Quantity}" name="Available_Qty[]" placeholder="0"
                        class="form-control">
                    </div>
                  </td>
                
                  <td>
                    <div class="form-group">
                      <input type="number" autocomplete="off" onkeyup="return checkAvailablQty(${row.Sales_Quantity},this)"  id="${row.Sales_Detail_ID}" value="" name="Return_Quantity[]"  placeholder="Return Quantity" 
                        class="form-control quantity">
                    </div>
                  </td>

                  <td>
                    <div class="form-group">
                      <input type="text" readonly tabindex="-1" name="Selling_Price[]" placeholder="0.00" value="${row.Sales_Price}" class="form-control">
                    </div>
                  </td>

                  <td style="padding-top:8px !important">
                    <div class="form-group">
                      <input type="text" readonly tabindex="-1" autocomplete="off" name="discount[]" value="${row.Sales_Discount} %" class="form-control discount" value=""
                        placeholder="% discount">
                    </div>
                  </td>

                  <td>
                    <div class="form-group">
                      <input type="text" readonly tabindex="-1" name="Amount[]" placeholder="0.00" value="" class="form-control">
                      <input type="hidden" readonly tabindex="-1" name="Sales_Detail_ID[]" value="${row.Sales_Detail_ID}" >
                      <input type="hidden" readonly tabindex="-1" name="Product_ID[]" value="${row.Product_ID}" >
                    </div>
                  </td>
                </tr>`;
        });
        $('#products_list tbody').html(tableList)


      },
      error: function(errorThrown) {
        console.log(errorThrown);
      }
    });

  });
  
  
});
    function calcSubTotal(){
      var total=0;
      var t = document.getElementById("product_list_tbl");
      var inputs = t.querySelectorAll("tbody > tr");
      var totalTax=0;
      var totalIGST=0;
      var totalCGST=0;
      var totalSGST=0;

      var sub_total = 0;
      $('#products_list > tbody  > tr').each(function(index, tr) { 
        var temp_total = 0;
        var Return_Quantity= parseInt($(this).find('[name="Return_Quantity[]"]').val());
        var Selling_Price= parseInt($(this).find('[name="Selling_Price[]"]').val());
        var discount= parseInt($(this).find('[name="discount[]"]').val());
        var GST= parseInt($(this).find('[name="GST[]"]').val());
        Return_Quantity=Return_Quantity?Return_Quantity:0;
        temp_total= (Return_Quantity * Selling_Price) - ((Return_Quantity * Selling_Price)*discount/100);
        if(temp_total>0){
          sub_total+=temp_total;
        }
        $(this).find('[name="Amount[]"]').val(temp_total?temp_total:0); 
        
        var totalPrice = Selling_Price*Return_Quantity;

        // if(discount>0){
        totalPrice = (totalPrice)-(totalPrice*discount/100);
        // }

        var IGST=(totalPrice*GST)/100;
        var SGST=0;
        var CGST=0;

        if($('#State_Name').val()=="Gujarat"){
          SGST=IGST/2;
          CGST=IGST/2;
          IGST=0;
        }

        totalIGST+=IGST;
        totalCGST+=CGST;
        totalSGST+=SGST;
        
        $('#CGST').val(totalCGST.toFixed(2));
        $('#SGST').val(totalSGST.toFixed(2));
        $('#IGST').val(totalIGST.toFixed(2));
      });


      
      
      $('#hidden_total').val(sub_total)
      // $('#sub_total').val(sub_total)
      $('#Grand_Total').val(sub_total)
      // var discount = isNaN(parseInt($('#final_discount').val()))?0:parseInt($('#final_discount').val());
      // var grand_total= parseInt(total - discount+parseInt(totalTaxAmount));
      // $('#grand_total').val(grand_total.toFixed(2));


    
      // var amount_Due=grand_total;
      // var amount_Due_total=0;
 
      // var totalTax=0;
      // var totalIGST=0;
      // var totalCGST=0;
      // var totalSGST=0;


      // $('#Hidden_Tax_Summart_List').val(JSON.stringify(taxSummary));


      // $('#Amount_Due').val(grand_total-amount_Due_total);
      // $('#Add_Payment').val(grand_total-amount_Due_total);
      
      
}


  function checkAvailablQty(Available_Qty,e){
    console.log("checkAvailablQty new Quantity",e.value);
    console.log("checkAvailablQty Available_Qty",Available_Qty);
    if(e.value && e.value!==""){
      if(parseInt(e.value) <= parseInt(Available_Qty)){
        calcSubTotal();
        return true;
      }else{
        swal("Opps!", "Invalid Sales return Quantity!", "error");    
        $("#"+e.id).val('').css(('border-bottom', 'solid 1px red'));
        return false;
      }
    }else{
      calcSubTotal();
    }
  }

</script>
<form class="form-horizontal" method="POST" action="<?php echo base_url('sales-return/add'); ?>" onkeydown="return event.key != 'Enter';">
  <div class="panel panel-flat">
    <div class="panel-heading">
      <h5 class="panel-title">Sales Return</h5>
    </div>

    <div class="panel-body">
      <div class="row">
        <div class="col-md-6">
          <fieldset>
            <div class="form-group">
              <label class="col-lg-3 control-label">Customer : </label>
              <div class="col-lg-9">
                <!-- <select id="Customer_ID" name="Customer_ID" class="select-search select2-hidden-accessible"
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
                </select> -->
                <input style="background: #f5f5f5;cursor:not-allowed" readonly name="Customer_ID" id="Customer_ID" value="" type="text" class="form-control">
                <input type="hidden" id="State_Name" name="State_Name"/>
              </div>
            </div>
            <!-- <div class="form-group">
              <label class="col-lg-3 control-label">Address : </label>
              <div class="col-lg-9">
                <input style="background: #f5f5f5;cursor:not-allowed" readonly name="Customer_Address" id="Customer_Address" value="<?php echo $formData ? $formData['Customer_Address'] : "" ?>"
                  type="text" class="form-control">
              </div>
            </div> -->
            <!-- <div class="form-group">
              <label class="col-lg-3 control-label">GSTIN : </label>
              <div class="col-lg-9">
                <input style="background: #f5f5f5;cursor:not-allowed" readonly name="Customer_GSTIN" id="Customer_GSTIN"  value="<?php echo $formData ? $formData['Customer_GSTIN'] : "" ?>"
                  type="text" class="form-control">
              </div>
            </div> -->
            <!-- <div class="form-group">
              <label class="col-lg-3 control-label">State : </label>
              <div class="col-lg-9">
                <input style="background: #f5f5f5;cursor:not-allowed" readonly name="State" id="State" value="<?php echo $formData ? $formData['State'] : "" ?>"
                  type="text" class="form-control">
              </div>
            </div> -->
          </fieldset>
        </div>
        <div class="col-md-6">
          <fieldset>

            <div class="form-group">
              <label class="col-lg-3 control-label">Sales Invoice : </label>
              <div class="col-lg-9">
                  <select id="Sales_Invoice" name="Sales_Invoice" class="select-search select2-hidden-accessible"
                  tabindex="-1" aria-hidden="true">
                  <option value=0 >Select Sale Invoice</option>
                  <?php
foreach ($data as $row) {
    ?>
                  <option value="<?php echo $row['Sales_Invoice'] ?>"><?php echo $row['Sales_Invoice'] ?></option>
                  <?php
}
?>
                </select>

              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label">Sales Date : </label>
              <div class="col-lg-9">
                <input readonly type="text" value="" id="Sales_Date" name="Sales_Date" class="form-control" placeholder="Sales Date">
              </div>
            </div>


            <!-- <div class="form-group">
              <label class="col-lg-3 control-label">Notes : </label>
              <div class="col-lg-9">
                <input name="Sales_Notes" autocomplete="off" value="<?php echo $formData ? $formData['Sales_Notes'] : "" ?>"
                  type="text" class="form-control " placeholder="Enter Notes">
              </div>
            </div> -->
          </fieldset>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="">
            <table class="panel panel-flat table products_list" id="products_list" style="margin:15px 0">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>UOM</th>
                  <th>HSN</th>
                  <th>Tax</th>
                  <th>Sales Qty.</th>
                  <th>Return Qty</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th>Amount</th>
                  <!-- <th style="text-align: center;">Amount</th> -->
                  <th></th>
                </tr>
              </thead>
              <tbody class="final_list" id="product_list_tbl">
                <div id="sales_return_list"></div>
              </tbody>

            </table>
            <?php
                    $sub_total=0;
                  ?>
            <div class="row" >
           
            <div class="col-sm-8">
            </div>
            <div class="col-sm-4">
          <table class="table ">
          <!-- <tr>
            <td>Sub Total</td>
            <td>
            <input type="hidden" id="hidden_total" class="form-control" value="<?php echo $sub_total;?>"/>
            <input style="width:50px"  type="text" readonly name="Sub_Total" id="sub_total" class="form-control" value="<?php echo $sub_total;?>"  placeholder="Sub total"/>
            </td>
          </tr> -->
          <!-- <tr>
            <td>GST</td>
            <td>
              <table>
                <tr><td>CGST &nbsp;: </td><td><input type="text" readonly name="CGST" id="CGST" class="form-control" value=""  placeholder="CGST"/></td></tr>
                <tr><td>SGST &nbsp;: </td><td><input type="text" readonly name="SGST" id="SGST" class="form-control" value=""  placeholder="SGST"/></td></tr>
                <tr><td>IGST &nbsp;: </td><td><input type="text" readonly name="IGST" id="IGST" class="form-control" value=""  placeholder="IGST"/></td></tr>
              </table>
            </td>
          </tr> -->
          <tr>
            <td><strong>Grand Total</strong></td>
            <td><input type="text" style="font-size: 22px;font-weight: 500;" name="Grand_Total" readonly id="Grand_Total" class="form-control" value="0"  placeholder="Grand Total"/></td>
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
        <button name="save" value="save" type="submit" class="btn bg-teal-400 access-multiple-open legitRipple">Save<i
            class="icon-circle-right2 position-right"></i></button>
      </div>
    </div>
  </div>
</form>