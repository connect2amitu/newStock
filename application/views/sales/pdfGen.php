<?php

function numberTowords($num)
{ 
    $ones = array(
        0 =>"ZERO",
        1 => "ONE",
        2 => "TWO",
        3 => "THREE",
        4 => "FOUR",
        5 => "FIVE",
        6 => "SIX",
        7 => "SEVEN",
        8 => "EIGHT",
        9 => "NINE",
        10 => "TEN",
        11 => "ELEVEN",
        12 => "TWELVE",
        13 => "THIRTEEN",
        14 => "FOURTEEN",
        15 => "FIFTEEN",
        16 => "SIXTEEN",
        17 => "SEVENTEEN",
        18 => "EIGHTEEN",
        19 => "NINETEEN",
        "014" => "FOURTEEN"
        );
        $tens = array( 
        0 => "ZERO",
        1 => "TEN",
        2 => "TWENTY",
        3 => "THIRTY", 
        4 => "FORTY", 
        5 => "FIFTY", 
        6 => "SIXTY", 
        7 => "SEVENTY", 
        8 => "EIGHTY", 
        9 => "NINETY" 
        ); 
        $hundreds = array( 
        "HUNDRED", 
        "THOUSAND", 
        "MILLION", 
        "BILLION", 
        "TRILLION", 
        "QUARDRILLION" 
        ); /*limit t quadrillion */
        $num = number_format($num,2,".",","); 
        $num_arr = explode(".",$num); 
        $wholenum = $num_arr[0]; 
        $decnum = $num_arr[1]; 
        $whole_arr = array_reverse(explode(",",$wholenum)); 
        krsort($whole_arr,1); 
        $rettxt = ""; 
        foreach($whole_arr as $key => $i){
            
        while(substr($i,0,1)=="0")
                $i=substr($i,1,5);
        if($i < 20){ 
        /* echo "getting:".$i; */
        $rettxt .= $ones[$i]; 
        }elseif($i < 100){ 
        if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
        if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
        }else{ 
        if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
        if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
        if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
        } 
        if($key > 0){ 
        $rettxt .= " ".$hundreds[$key]." "; 
        }
        } 
        if($decnum > 0){
        $rettxt .= " and ";
        if($decnum < 20){
        $rettxt .= $ones[$decnum];
        }elseif($decnum < 100){
        $rettxt .= $tens[substr($decnum,0,1)];
        $rettxt .= " ".$ones[substr($decnum,1,1)];
        }
        }
        return $rettxt; 
} 
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'ISO-8859-1', false);

// set document information
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Nicola Asuni');
// $pdf->SetTitle('TCPDF Example 006');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
// $pdf->AddPage();
$pdf->AddPage('P', 'A4');



$name="Surat Ago";

$productList="";
$taxSummary="";
$netAmount=0;
$SrNo=1;
$grandTaxAmount=0;
$totalTaxableValue=0;
$totalCGSTValue=0;
$totalSGSTValue=0;
$terms_conditions_list="";
foreach($terms_conditions as $row){
    $terms_conditions_list.='<span>&nbsp;&nbsp;'.$row['Term_Condition'].'</span><br/>';
}
foreach ($data as $row) {
    $productList.='<tr>
    <td>&nbsp;'.$SrNo++.'</td>
    <td>&nbsp;'.strtoupper($row['Stock_Name']).'</td>
    <td>&nbsp;'.$row['HSN'].'</td>
    <td>&nbsp;'.$row['Name'].'</td>
    <td>&nbsp;'.$row['Sales_Quantity'].'</td>
    <td>&nbsp;'.$row['Sales_Price'].'</td>
    <td>&nbsp;'.$row['Discount'].'</td>
    <td>&nbsp;'.$row['Total'].'</td>
</tr>';
    $totalTax= $row['CGST']+$row['SGST']+$row['IGST'];
    $grandTaxAmount=$grandTaxAmount+$totalTax;
    $totalTaxableValue=$totalTaxableValue+$row['Total'];
    $totalCGSTValue=$totalCGSTValue+$row['CGST'];
    $totalSGSTValue=$totalSGSTValue+$row['SGST'];
    
    $taxSummary.= '<tr>
		<td colspan="2">&nbsp;'.$row['HSN'].'</td>
		<td>&nbsp;'.$row['Total'].'</td>
        <td colspan="2">
            <table>
                <tr>
                    <td  align="center"  style="border-right:1px solid black">&nbsp;'.$row['GST'].'%</td>
                    <td align="center"  >&nbsp;'.$row['CGST'].'</td>
                </tr>
            </table>
        </td>
        <td colspan="2">
         <table>
                <tr>
                    <td  align="center"  style="border-right:1px solid black">&nbsp;'.$row['GST'].'%</td>
                    <td align="center"  >&nbsp;'.$row['SGST'].'</td>
                </tr>
            </table>
        </td>
        <td colspan="2">
         <table>
                <tr>
                    <td  align="center"  style="border-right:1px solid black">&nbsp;</td>
                    <td align="center"  >&nbsp;</td>
                </tr>
            </table>
        </td>
		<td >&nbsp;'.$totalTax.'</td>
	</tr>';
}
// <th>&nbsp;<b>Sr.No.</b></th>
// <th>&nbsp;<b>Description of Goods</b></th>
// <th>&nbsp;<b>HSN</b></th>
// <th>&nbsp;<b>Unit</b></th>
// <th>&nbsp;<b>Qty</b></th>
// <th>&nbsp;<b>Rate</b></th>
// <th>&nbsp;<b>Dis</b></th>
// <th>&nbsp;<b>Amount</b></th>
// create some HTML content
$subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';
$html = '<table width="100%" cellspacing="0" cellpadding="1" border="1">
<tr>
<td align="center" colspan="4" ><img src="'. base_url("assets/images/logo.png") .'" /></td>
</tr>
<tr>
<td align="center" colspan="4"  >
<h4>TAX INVOICE</h4>
</td>
</tr>
<tr>
	<td colspan="2">&nbsp;Name : '.strtoupper($data[0]['Customer_Name']).'</td>
	<td colspan="2">&nbsp;Invoice No : '.strtoupper($data[0]['Sales_Invoice']).'</td>
</tr>

<tr>
	<td colspan="2">&nbsp;Address : '.ucwords($data[0]['Customer_Address']).'</td>
	<td colspan="2">&nbsp;Invoice Date : '.date("d/m/Y", strtotime($data[0]['Sales_Date'])).'</td>
</tr>

<tr>
	<td colspan="2">&nbsp;GSTIN  : '.strtoupper($data[0]['Customer_GSTIN']).'</td>
</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="1" border="1">
       <tr>
            <th style="width:5%">&nbsp;<b>Sr.<br/>&nbsp;No.</b></th>
            <th style="width:45%">&nbsp;<b>Description of Goods</b></th>
            <th style="width:10%">&nbsp;<b>HSN</b></th>
            <th style="width:5%">&nbsp;<b>Unit</b></th>
            <th style="width:5%">&nbsp;<b>Qty</b></th>
            <th style="width:8%">&nbsp;<b>Rate</b></th>
            <th style="width:7%">&nbsp;<b>Disc. %</b></th>
            <th style="width:15%">&nbsp;<b>Amount</b></th>
       </tr>
      
        '.$productList.'
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
   </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
   </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
   </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
   </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
   </tr>
   
    <tr>
        <td colspan="4" align="right">&nbsp;<b>Total Qty</b>&nbsp;</td>
        <td>&nbsp;20</td>
        <td colspan="2"><b>&nbsp;Net Amount</b></td>
        <td style="font-size:18px;font-weight:bold" >&nbsp;'.$data[0]['Grand_Total'].' /-</td>
   </tr>
   	<tr>
   		<td colspan="8"> &nbsp; Amount in Word: <b>'. ucwords(numberTowords($data[0]['Grand_Total'])) .'</b></td>
	</tr>
   	<tr>
   		<td align="center" colspan="8"> &nbsp; </td>
	</tr>
	<tr>
		<td colspan="2" style="width:15%"><b>&nbsp;HSN</b></td>
		<td style="width:12%"><b>&nbsp;Taxable Value</b></td>
		<td style="width:20%" colspan="2">
			<table>
				<tr>
					<td align="center"  colspan="2" style="border-bottom:1px solid black;font-weight:bold;">&nbsp;CGST</td>
				</tr>
				<tr>
					<td  align="center">&nbsp;Rate</td>
					<td align="center"  >&nbsp;Amount</td>
				</tr>
			</table>
		</td>
		<td style="width:20%" colspan="2">
			<table>
				<tr>
					<td align="center"  colspan="2" style="border-bottom:1px solid black;font-weight:bold;">&nbsp;SGST</td>
				</tr>
				<tr>
					<td  align="center">&nbsp;Rate</td>
					<td align="center"  >&nbsp;Amount</td>
				</tr>
			</table>
		</td>
		<td style="width:20%" colspan="2">
			<table>
				<tr>
					<td align="center"  colspan="2" style="border-bottom:1px solid black;font-weight:bold;">&nbsp;IGST</td>
				</tr>
				<tr>
					<td  align="center">&nbsp;Rate</td>
					<td align="center"  >&nbsp;Amount</td>
				</tr>
			</table>
		</td>
		<td style="width:13%"><b>&nbsp;Total</b><br><span>&nbsp;Tax Amount</span></td>
	</tr>
    '. $taxSummary .'
    <tr>
		<td colspan="2">&nbsp;</td>
		<td>&nbsp;'.$totalTaxableValue.'</td>
        <td colspan="2">
            <table>
                <tr>
                    <td  align="center"  style="border-right:1px solid black">&nbsp;</td>
                    <td align="center"  >&nbsp;'.$totalCGSTValue.'</td>
                </tr>
            </table>
        </td>
        <td colspan="2">
         <table>
                <tr>
                    <td  align="center"  style="border-right:1px solid black">&nbsp;</td>
                    <td align="center"  >&nbsp;'.$totalSGSTValue.'</td>
                </tr>
            </table>
        </td>
        <td colspan="2">
         <table>
                <tr>
                    <td  align="center"  style="border-right:1px solid black">&nbsp;</td>
                    <td align="center"  >&nbsp;</td>
                </tr>
            </table>
        </td>
		<td >&nbsp;'.$grandTaxAmount.'</td>
	    </tr>
	<tr>
	<td colspan="10"> &nbsp; Tax Amount in Word: <b>'. ucwords(numberTowords($grandTaxAmount)) .'</b></td>
    </tr>
    
<tr>
<td align="center" colspan="10"> &nbsp; </td>
</tr>
<tr>
	<td colspan="10"><b>&nbsp;Company\'s Bank Details</b></td>
</tr>
<tr>
	<td colspan="2">&nbsp;GST</td>
	<td colspan="3">&nbsp;'.$company_detail['GSTIN'].'</td>
	<td colspan="3">&nbsp;Bank Name</td>
	<td colspan="2">&nbsp;'.$company_detail['Bank_Name'].'</td>
</tr>
<tr>
	<td colspan="2">&nbsp;PAN Number</td>
	<td colspan="3">&nbsp;'.$company_detail['Pan_No'].'</td>
	<td colspan="3">&nbsp;Account Number</td>
	<td colspan="2">&nbsp;'.$company_detail['Account_Number'].'</td>
</tr>
<tr>
	<td colspan="5" rowspan="2"></td>
	<td colspan="3">&nbsp;Branch Name</td>
	<td colspan="2">&nbsp;'.$company_detail['Branch_Name'].'</td>
</tr>
<tr>
	<td colspan="3">&nbsp;IFSC Code</td>
	<td colspan="2">&nbsp;'.$company_detail['IFSC_Code'].'</td>
</tr>
<tr>
	<td colspan="10">&nbsp;</td>
</tr>
<tr>
	<td colspan="7">
		<b>&nbsp; Term & Condition:</b><br/>
		'.$terms_conditions_list.'
	</td>
	<td colspan="3" align="center">
		<b>&nbsp; For '.$company_detail['Company_Name'].'</b><br/><br/><br/>
		<p>Authorised Signature</p>	
	</td>
</tr>

 </table>

';

// output the HTML content
// $html = utf8_encode($html);

$pdf->writeHTML($html, true, false, true, false, '');

// Print some HTML Cells

// $html = '<span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span><br /><span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span>';

$pdf->SetFillColor(255,255,0);


//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
?>
