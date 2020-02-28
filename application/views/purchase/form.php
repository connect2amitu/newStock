<script>
var payment_array=[];
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
        $(e.target).closest("tr").find('[name="Purchasing_Price[]"]').val(data.Purchasing_Price);
        $(e.target).closest("tr").find('[name="GST[]"]').val(data.GST);
      },
      error: function(errorThrown) {
        console.log(errorThrown);
      }
    });

  });

  $('.addProduct').on('click', function(e) {
    var Product_ID = $(e.target).closest("tr").find('[name="Product_ID[]"]').val();
    var Product_Name = $(e.target).closest("tr").find('option:selected').text();
    var qty = $(e.target).closest("tr").find('[name="Purchasing_Quantity[]"]').val();
    var purchasing_Price = $(e.target).closest("tr").find('[name="Purchasing_Price[]"]').val();
    var HSN = $(e.target).closest("tr").find('[name="HSN[]"]').val();
    var unit = $(e.target).closest("tr").find('[name="unit[]"]').val();
    var GST = $(e.target).closest("tr").find('[name="GST[]"]').val();
    var discount = $(e.target).closest("tr").find('[name="discount[]"]').val();

    if(qty!=="" && qty>0 && Product_ID!=="" && purchasing_Price!=="" && HSN!=="" && unit!==""){
    var data = {
      "id": Product_ID,
      "qty": qty,
      "price": purchasing_Price,
      "name": Product_Name,
      "HSN": HSN,
      "unit": unit,
      "GST": GST,
      "discount": discount,
    };

    $.ajax({
      url: "<?php echo base_url('purchase/addToCart ') ?>",
      // dataType: 'text',
      type: 'POST',
      // contentType: 'text/html',
      data: data,
      success: function(data) {
        $('tbody.final_list').empty().append(data);
        calcSubTotal();

        $("#productSelect").val('-1');
        $(e.target).closest("tr").find('[name="Purchasing_Quantity[]"]').val('');
        $(e.target).closest("tr").find('[name="Purchasing_Price[]"]').val('');
        $(e.target).closest("tr").find('[name="HSN[]"]').val('');
        $(e.target).closest("tr").find('[name="unit[]"]').val('');
        $(e.target).closest("tr").find('[name="GST[]"]').val('');
        $(e.target).closest("tr").find('[name="discount[]"]').val('');
      },
      error: function(errorThrown) {
        console.log(errorThrown);
      }
    });
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
    calcSubTotal();
    }
    // console.log("payment_array",payment_array);
  });


  $(document).on('click', '.remove_cart', function() {
    var row_id = $(this).attr("id");

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
//   function calcSubTotal(){
//     var total=0;
//     var t = document.getElementById("product_list_tbl");
//     var inputs = t.getElementsByTagName("input");

//     for(i=0;i<inputs.length;i++){
//       total = total+parseInt(inputs[i].value);
//     }

//     $('#hidden_total').val(total)
//     $('#sub_total').val(total)
//     var discount = isNaN(parseInt($('#final_discount').val()))?0:parseInt($('#final_discount').val());
//     var grand_total= parseInt(total - discount);
//     var freight = isNaN(parseInt($('#freight').val()))?0:parseInt($('#freight').val());
    
//     grand_total= parseInt(grand_total + freight);
//     $('#grand_total').val(grand_total);
//     $('#Hidden_Amount_Due').val(JSON.stringify(payment_array));

// }
function calcSubTotal(){
    var total=0;
    var t = document.getElementById("product_list_tbl");
    var inputs = t.getElementsByTagName("input");

    for(i=0;i<inputs.length;i++){
      total = total+parseInt(inputs[i].value);
    }

    $('#hidden_total').val(total)
    $('#sub_total').val(total)
    var discount = isNaN(parseInt($('#final_discount').val()))?0:parseInt($('#final_discount').val());
    var grand_total= parseInt(total - discount);
    // grand_total= parseInt(grand_total - Amount_Due);
    $('#grand_total').val(grand_total);
    // $('#Amount_Due').val(grand_total);

      var amount_Due=grand_total;
      var amount_Due_total=0;
      var table="<table class='table' border=1><tr style='background-color: #f5f5f5;'><th>Payment Method</th><th>Amount</th><th>Action</th></tr>";
      for (let i = 0; i < payment_array.length; i++) {
        amount_Due-=payment_array[i].Add_Payment;
        amount_Due_total+=parseInt(payment_array[i].Add_Payment);
        table+="<tr><td>"+ payment_array[i].Payment_Mode  +"</td><td>"+ payment_array[i].Add_Payment  +"</td><td><i style='color:red;cursor:pointer' id='payment_array-"+ i +"' onclick='delete_payment("+i+")' class='icon-trash-alt'></i></td></tr>";
      }
      table+="<tr style='font-weight:600;font-size: 18px;background-color: #f5f5f5;'><td style='text-align:right;'>Total</td><td>"+ amount_Due_total  +"</td><td></td></tr></table>";
      $('#payment_type_list').empty().append(table);
      $('#Amount_Due').val(amount_Due);
      $('#Hidden_Amount_Due').val(JSON.stringify(payment_array));
      $('#Add_Payment').val(amount_Due);
      
}
function delete_payment(i){
    payment_array.splice(i,1);
    calcSubTotal();
    }
</script>
<?php

$formData = false;
$btnName = "Add";
if (isset($data)) {
    $formData = $data[0];
    $redirect = 'purchase/edit/' . $formData['Purchase_ID'];
    $btnName = "Update";
} else {
    $redirect = 'purchase/add';
}
?>
<form class="form-horizontal" method="POST" action="<?php echo base_url($redirect); ?>">
  <div class="panel panel-flat">
    <div class="panel-heading">
      <h5 class="panel-title"><?php echo $btnName ?> Purchase</h5>
    </div>

    <div class="panel-body">
      <div class="row">
        <div class="col-md-6">
          <fieldset>
            <div class="form-group">
              <label class="col-lg-3 control-label">Supplier : </label>
              <div class="col-lg-9">
                <select id="product" name="Supplier_ID" class="select-search productSelect select2-hidden-accessible"
                  tabindex="-1" aria-hidden="true">
                  <option disabled <?php echo !$formData ? "selected" : ""; ?> value="-1">Select Supplier</option>
                  <?php
foreach ($suppliers as $row) {
    ?>
                  <option <?php echo $formData && $formData['Supplier_ID'] === $row['Supplier_ID'] ? "selected" : ""; ?>
                    value="<?php echo $row['Supplier_ID'] ?>"><?php echo $row['Supplier_Name'] ?></option>
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
              <label class="col-lg-3 control-label">Purchase Invoice : </label>
              <div class="col-lg-9">
                <input name="Purchase_Invoice" value="<?php echo $formData ? $formData['Purchase_Invoice'] : "" ?>"
                  type="text" class="form-control " placeholder="Enter Purchase Invoice Number">
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label">Purchase Date : </label>
              <div class="col-lg-9">
                <input id="datepicker" autocomplete="off" type="text"
                  value="<?php echo $formData ? date_format(date_create($formData['Purchase_Date']), "d-m-Y") : date('d-m-Y', strtotime("now")) ?>"
                  name="Purchase_Date" class="form-control datepicker-menus" placeholder="Pick a date&hellip;">
              </div>
            </div>


            <div class="form-group">
              <label class="col-lg-3 control-label">Notes : </label>
              <div class="col-lg-9">
                <input name="Purchase_Notes" value="<?php echo $formData ? $formData['Purchase_Notes'] : "" ?>"
                  type="text" class="form-control " placeholder="Enter Notes">
              </div>
            </div>
          </fieldset>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="">
            <table class="table products_list product_details" id="product_details" style="margin:15px 0">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>UOM</th>
                  <th>HSN</th>
                  <th>Tax</th>
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
                        <option value="<?php echo $row['Product_ID'] ?>"><?php echo $row['Stock_Name'] ?></option>
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
                      <input type="text" autocomplete="off" name="Purchasing_Quantity[]" placeholder="0"
                        class="form-control quantity">
                    </div>
                  </td>

                  <td>
                    <div class="form-group">
                      <input type="text" readonly name="Purchasing_Price[]" placeholder="0.00" class="form-control">
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
            <div class="row">
            <div class="col-sm-12">
            <table class="table table-striped"
                style="background-color: #f5f5f5;margin:15px 0">
                <thead>
                  <tr>
                    <th>ACTION</th>
                    <th>Product</th>
                    <th>UOM</th>
                    <th>HSN</th>
                    <th>Tax</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th style="text-align: center;">Amount</th>
                  </tr>
                </thead>
                <tbody class="final_list" id="product_list_tbl">
                  <?php
                    $sub_total=0;
                    if(isset($products_details)){

                      foreach ($products_details as $row) {
                        
                        ?>
                        <tr>
                        <td><button type="button" id=<?php echo $row['Purchase_Detail_ID'] ?>
                class="remove_cart btn btn-danger btn-sm"><i class="icon-trash"></i></button></td>
                        <td><?php echo $row['Stock_Name'] ?></td>
            <td><?php echo $row['Name'] ?></td>
            <td><?php echo $row['HSN'] ?></td>
            <td><?php echo $row['GST'] ?></td>
            <td><?php echo $row['Quantity'] ?></td>
            <td>&#x20B9;&nbsp;<?php echo $row['Purchasing_Price'] ?></td>
            <td><?php echo $row['Discount']>0?$row['Discount']:0 ?> %</td>
            <td style="display:flex;align-items:center">&#x20B9;&nbsp;<input style="width:30px;border:none" class="form-control" readonly type="text" name="total[]" value="<?php if((int)$row['Discount']>0){
              $total = $row['Sub_Total'] - ($row['Sub_Total'] * $row['Discount'] / 100);
              echo $total;
              $sub_total = $sub_total+$total;
            }else{
              echo $row['Sub_Total'];
            } ?> " />
             </td>
                        </tr>
                      <?php
                    }
                  }
                    ?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-6">
              <div id="payment_type_list"></div>
            </div>
            <div class="col-sm-6">
          <table class="table ">
          <tr>
            <td>Sub Total</td>
            <td>
            <input type="hidden" id="hidden_total" class="form-control" value="<?php echo $sub_total;?>"/>
            <input type="text" readonly name="Sub_Total" id="sub_total" class="form-control" value="<?php echo $sub_total;?>"  placeholder="Sub total"/>
            </td>
          </tr>
          <tr>
            <td>Discount</td>
            <td><input type="text"name="Discount"  onkeyup="calcSubTotal()" id="final_discount" autocomplete="off" value="0" class="form-control"  placeholder="Discount"/></td>
          </tr>
          <tr>
            <td><strong>Grand Total</strong></td>
            <td><input type="text" name="Grand_Total" readonly id="grand_total" class="form-control" value="0"  placeholder="Grand Total"/></td>
          </tr>
          <tr>
            <td>Freight</td>
            <td><input type="text" name="Freight" onkeyup="calcSubTotal()" id="freight" autocomplete="off" value="0" class="form-control"  placeholder="Freight"/></td>
          </tr>
          <!-- <tr>
            <td>PAYMENT Mode</td>
            <td>
            <select id="product" name="Payment_Mode" class="select productSelect select2-hidden-accessible"
                  tabindex="-1" aria-hidden="true">
                  <option disabled selected value="-1">Select Payment mode</option>
                  <option value="Cash">Cash</option>
                  <option value="Credit">Credit</option>
                  <option value="Cheque">Cheque</option>
                  <option value="Net Banking">Net Banking</option>
                  <option value="UPI">UPI</option>
                </select>
            </td>
           
          </tr>
          <tr>
          <td>Make a PAYMENT</td>
            <td><input type="text" name="Paid_Amount" class="form-control"  placeholder="Make a PAYMENT"/></td>
          </tr> -->

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
              
              <!-- <a href="#" class="btn btn-success addNewTr pull-right mb-20"><span class="icon-plus3"></span></a> -->
          </div>
        </div>
      </div>



      <div class="text-right mt-20">
        <a href="<?php echo base_url('purchase'); ?>" class="btn btn-danger access-multiple-open legitRipple"><i
            class="icon-circle-left2 position-left"></i> Cancle </a>
        <button type="submit" class="btn bg-teal-400 access-multiple-open legitRipple"><?php echo $btnName; ?> <i
            class="icon-circle-right2 position-right"></i></button>
      </div>
    </div>
  </div>
</form>