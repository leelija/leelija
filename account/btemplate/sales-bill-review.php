<?php 
session_start();
//include_once('checkSession.php');
require_once("../../_config/connect.php"); 
require_once("../../includes/constant.inc.php");
require_once("../../includes/product.inc.php");
require_once("../../classes/adminLogin.class.php"); 
require_once("../../classes/date.class.php");  
require_once("../../classes/error.class.php"); 
require_once("../../classes/order.class.php"); 
require_once("../../classes/search.class.php");
require_once("../../classes/pagination.class.php");
require_once("../../classes/sample.class.php");
require_once("../../classes/employee.class.php");
require_once("../../classes/company.class.php");
 require_once("../../classes/vendor.class.php"); 
require_once("../../classes/customer.class.php");
require_once("../../classes/supplier.class.php"); 
require_once("../../classes/buyer.class.php"); 
require_once("../../classes/invoice.class.php"); 
require_once("../../classes/currier.class.php");
require_once("../../classes/rate.class.php");

require_once("../../classes/product_status.class.php");
require_once("../../classes/utility.class.php"); 
require_once("../../classes/utilityMesg.class.php"); 
require_once("../../classes/utilityImage.class.php");
require_once("../../classes/utilityNum.class.php");
require_once("../../mepemp/rupee-convert.php");
/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$sample			= new Sample();
$company		= new Company();
$vendor			= new Vendor();
$customer		= new Customer();
$status			= new Pstatus();
$employee		= new Employee();
$supplier		= new Supplier();
$buyer			= new Buyer();
$invoice		= new Invoice();
$currier		= new Currier();
$rate			= new Rate();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$bid			= $utility->returnGetVar('bid','0');

$invoiceDtls 	= $invoice->showInvoice($bid);
$compDetail 	= $company->showCompDtls($invoiceDtls[16]);
$invoiceDtldtls = $invoice->getInvoiceDtlsData($bid);
$buyerDtls		= $buyer->showBuyerDtlsComp($invoiceDtls[1]);
$gstamt			= $invoiceDtls[9] + $invoiceDtls[7] + $invoiceDtls[5];
//Courier details
$courierDtls 	= $currier->showCurrier($invoiceDtls[23]);

$taxableValue	= $invoiceDtls[3] - $invoiceDtls[18];


 //echo $bid;exit;
//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[ACC_SESS]);

?>

<!DOCTYPE html>
<!--
  Invoice template by invoicebus.com
  To customize this template consider following this guide https://invoicebus.com/how-to-create-invoice-template/
  This template is under Invoicebus Template License, see https://invoicebus.com/templates/license/
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bill Preview..</title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="Invoicebus Invoice Template">

   <!--<link rel="stylesheet" href="css/template.css">-->
  
  </head>
  <body>
	 <link href="css/template.css" rel="stylesheet" type="text/css" />
    <div id="container">
		<!--<a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>-->
		<input type="button" id="btnPrint" value="Print" /> <a href="../view-selling.php">Back</a>
		<div id="dvContents" ><!-- start Print -->
			<p style="text-align: center;"><b></b></p>
			<div class="header">
				<b>TAX INVOICE</b><br><br>
				<div class="addrs-sec">
					<b><?php echo $compDetail[1];?></b><br>
					<span>Vill: Islampur</span> <span>P.O: Kadambagachi</span>
					<div>P.S Duttapukur(Barasat)</div>
					<div>Dist: 24 Pgs (N)</div>
				</div>
				<div class="cont-sec">
					Original for Recipients<div style="height:10px;"></div>
					<div>Ph-9836664554</div>
					<div>E-Mail: monisadia@gmail.com</div>
				</div>
			</div>
			<div style="border: 1px solid black;">
				<div class="inv-report">
					<div id="invleft">
						GSTIN NO:<?php echo $compDetail[15];?> <br>
						PAN NO  :<?php echo $compDetail[16];?>
					</div>
					<div id="invright">
						<span style="width: 50%; float:left;">Invoice No:<?php echo $invoiceDtls[0];?> </span><span style="width: 50%; float:right;">Date:<?php echo $invoiceDtls[21];?> </span><br>
						Packing Slip No:<?php echo $invoiceDtls[0];?>
					</div>
					
				</div>
				<div class="currier-report">
					<div id="invleft">
						
					</div>
					<div id="invright">
						Carrier Name: <b><?php if($courierDtls[1] ==""){echo "";}else{echo $courierDtls[1];}?></b> <br>
						LR No:  <br>
						No of Parcels: <b><?php if($invoiceDtls[22] == 0){ echo "";} else{echo $invoiceDtls[22];}?></b>
					</div>
					
				</div>
				<div class="comp-info"><!--Start comp info sec-->
					<div id="memo">
						Buyer's Name & Address<br>
						<b><?php echo $buyerDtls[14];?></b><br>
						<?php echo $buyerDtls[2];?><br>
						<?php echo $buyerDtls[3];?><br>
						ph:<?php echo $buyerDtls[4];?><br>
						GSTIN NO:<?php echo $buyerDtls[15];?>  
						 
					</div>
			  
					<div id="invoice-rept">
						
					</div>
				</div><!--end comp info sec-->  
			  
				<section id="items">
					<?php 
						if(count($invoiceDtldtls) == 0)
							{
					?>
							<tr align="left" class="orangeLetter">
								<td height="20" colspan="5"> <?php echo "Table is empty"; ?></td>
							</tr>
					<?php 
						}
						else
							{
					?>
					<table cellpadding="0" cellspacing="0" >
						<tr >
							<th >No</th> <!-- Dummy cell for the row number and row commands -->
							<th>Description of Goods</th>
							<th>Quantity</th>
							<th>Rate</th>
							<th>Per</th>
							<th>Discount(%)</th>
							<th>Total</th>
						</tr>
					<?php
						$sl=1;
						$tQuantity 		= 0;
						foreach($invoiceDtldtls as $eachRecord)
							{
								$tQuantity 			+= $eachRecord['quantity'];
								$designPart 		= $eachRecord['item'];
								$dsgn 				= explode("-", $designPart);
								$design 			= $dsgn[0];
								$part  				= $dsgn[1];
								$sRateDtls 			= $rate->showSRate($design,$part);
					?>	
						<tr data-iterate="item" class="table-row" >
							<td><?php echo $sl;?></td> <!-- Don't remove this column as it's needed for the row commands -->
							<td><?php echo $eachRecord['item'];?></td>
							<td><?php echo $eachRecord['quantity'];?></td>
							<td><?php echo $eachRecord['rate'];?></td>
							<td><?php echo $sRateDtls[4];?></td>
							<td><?php if($invoiceDtls[17]==0){}else{echo $invoiceDtls[17];}?></td>
							<td><?php echo $eachRecord['tamount'];?></td>
						</tr>
					<?php
						$sl++;
							}
						}
					?>
					</table>
				<!--	<section class="gtotal">-->
					<table>
						<tr style="width:100%; height:15px; font-weight: bold;">
							<td ></td>
							<td style="width:34%;">Total</td>
							<td style="width:15%;"><?php echo $tQuantity;?></td>
							<td style="width:15%;"></td>
							<td style="width:15%;">Pcs</td>
							<td style="width:15%;"><?php if($invoiceDtls[18]==0){}else{echo $invoiceDtls[18];}?></td>
							<td style="width:15%;"><?php echo $invoiceDtls[3];?></td>
						</tr>
					</table>
					<!--</section>-->
					<?php if($invoiceDtls[6] != 0.00){?>
					<section class="gst-sec">
						<b><p class="gstsec-left">CGST(<?php echo $invoiceDtls[6];?>%)</p></b>
						<p class="gstsec-right">
							<?php echo $invoiceDtls[7];?>
						</p>
					</section>
					<section class="gst-sec">
						<b><p class="gstsec-left">SGST(<?php echo $invoiceDtls[4];?>%)</p></b>
						<p class="gstsec-right">
							<?php echo $invoiceDtls[5];?>
						</p>
					</section>
					<?php } ?>
					<?php if($invoiceDtls[8] != 0.00){?>
					<section class="gst-sec">
						<b><p class="gstsec-left">IGST(<?php echo $invoiceDtls[8];?>%)</p></b>
						<p class="gstsec-right">
							<?php echo $invoiceDtls[9];?>
						</p>
					</section>
					<?php } ?>
				</section>
				<section class="gtotal">
					
					<b><p class="gtotal-left">Grand Total</p></b>
					<b><p class="gtotak-right">
						<?php echo $invoiceDtls[10];?>
					</p></b>
				</section>
				<section class="gtotal">
					Invoice Amount (in words) : <b>INR <?php echo convert_number_to_words($invoiceDtls[10]); ?></b>
				</section>
				
				<div class="vtax-sec" ><!--Start vtax-sec-->
					<table style="width: 100%;">
					  <tr>
						<th>HSN/SAC</th>
						<th>Taxable Value</th>
						<th><span style="width: 50%;text-align:left; float:left;">IGST%</span><span style="width: 50%;;text-align:right;float:right;">IGST Amt</span></th>
						<th><span style="width: 50%;text-align:left; float:left;">CGST%</span><span style="width: 50%;;text-align:right;float:right;">CGST Amt</span></th>
						<th><span style="width: 50%;text-align:left; float:left;">SGST%</span><span style="width: 50%;;text-align:right;float:right;">SGST Amt</span></th>
					  </tr>
					  <tr style="width: 100%;">
						<td style="width: 20%;"></td>
						<td style="width: 20%;"><?php echo $taxableValue;?> </td>
						<td style="width: 20%;"><span style=" width: 50%; text-align:left;">
							<?php if($invoiceDtls[8] == 0){}else{ echo $invoiceDtls[8];}?></span>
							<span style="width: 50%; float:right; text-align:right">
							<?php if($invoiceDtls[9] ==0){}else{echo $invoiceDtls[9];}?></span>
						</td>
						<td style="width: 20%;"><span style="width: 50%; text-align:left">
							<?php if($invoiceDtls[6] == 0){}else{echo $invoiceDtls[6];}?>
							</span><span style="width: 50%; float:right;text-align:right;">
							<?php if($invoiceDtls[6]==0){}else{echo $invoiceDtls[7];}?></span>
						</td>
						<td style="width: 20%;"><span style="width: 50%; text-align:left">
							<?php if($invoiceDtls[4]==0){}else{echo $invoiceDtls[4];}?></span>
							<span style="width: 50%; float:right;text-align:right;">
							<?php if($invoiceDtls[4]==0){}else{echo $invoiceDtls[5];}?></span>
						</td>
					  </tr>
					  <tr>
						<td>Total</td>
						<td><?php echo $taxableValue;?></td>
						<td><span style="width: 50%;;text-align:right;float:right;">
							<?php if($invoiceDtls[9]==0){}else{echo $invoiceDtls[9];}?></span>
						</td>
						<td><span style="width: 50%;;text-align:right;float:right;">
							<?php if($invoiceDtls[7]==0){}else{echo $invoiceDtls[7];}?></span>
						</td>
						<td><span style="width: 50%;;text-align:right;float:right;">
							<?php if($invoiceDtls[5]==0){}else{echo $invoiceDtls[5];}?></span>
						</td>
					  </tr>
					</table>
				
				</div><!--end vtax-sec-->
				<section class="gtotal">
					GST Amount (in words) : <b>INR <?php echo convert_number_to_words($gstamt); ?></b>
				</section>
				<!--
				<div class="currency">
					<span>All prices are in</span> <span>Rupees</span>
				</div>
				-->
			</div>
			<div class="clearfix" style="height:50px;"></div>
			<div class="footer-sec">
				<section id="terms">
				
					<span>Declaration</span>
					<div>We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct</div>
				</section>
				<div class="signature" style="text-align:right;">
					for <?php echo $compDetail[1];?><br><br><br><br>
					Authorised Signature
				
				</div>
			</div>
			
			
		</div>  <!--end print sec-->
   </div>

	<!--<script src="template.js"></script>-->
    <!--<script src="http://cdn.invoicebus.com/generator/generator.min.js?data=data.js"></script>-->
	
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnPrint").click(function () {
                var contents = $("#dvContents").html();
                var frame1 = $('<iframe />');
                frame1[0].name = "frame1";
                frame1.css({ "position": "absolute", "top": "-1000000px" });
                $("body").append(frame1);
                var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                frameDoc.document.open();
                //Create a new HTML document.
                frameDoc.document.write('<html><head><title>DIV Contents</title>');
                frameDoc.document.write('</head><body>');
                //Append the external CSS file.
                frameDoc.document.write('<link href="css/template.css" rel="stylesheet" type="text/css" />');
                //Append the DIV contents.
                frameDoc.document.write(contents);
                frameDoc.document.write('</body></html>');
                frameDoc.document.close();
                setTimeout(function () {
                    window.frames["frame1"].focus();
                    window.frames["frame1"].print();
                    frame1.remove();
                }, 500);
            });
        });
    </script>
  </body>
</html>
