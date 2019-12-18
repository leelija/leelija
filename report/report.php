<?php
ob_start();
session_start();
?>
<?php 
//session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/product_stock.class.php"); 
require_once("../classes/product_order.class.php");
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/adv_search.class.php");
require_once("../classes/photo_gallery.class.php");
require_once("../classes/sample.class.php"); 
require_once("../classes/status_cat.class.php");
require_once("../classes/bill.class.php");
require_once("../classes/journal.class.php"); 
require_once("../classes/mjournal.class.php"); 
require_once("../classes/supplier.class.php"); 
require_once("../classes/vendor.class.php"); 
require_once("../classes/invoice.class.php"); 

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders		    = new Orders();
$prodStatus		= new Pstatus();
$advSearch		= new AdvSearch();
$productStock	= new ProductStock();
$productOrder	= new Productorders();
$search_obj		= new Search();
$pages			= new Pagination();
$photogallery	= new PhotoGAllery();
$sample			= new Sample();
$statCat		= new StatusCat();
$bill 			= new Bill();
$journal		= new Journal();
$mjournal		= new mJournal();
$supplier		= new Supplier();
$vendor			= new Vendor();
$invoice		= new Invoice();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$sgid			= $utility->returnGetVar('sgid','0');
//admin detail
//$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);
//echo $sgid;exit;
if(isset($_POST['txtSubmit']))
	{	
		$txtToDate	 				= $_POST['txtToDate'];
		$txtFromDate	 			= $_POST['txtFromDate'];
		$txtFactory	 				= $_POST['txtFactory'];
		$_SESSION['txtToDate']		= $txtToDate;
		$_SESSION['txtFromDate']	= $txtFromDate;
		$_SESSION['txtFactory']		= $txtFactory;
	}

?>


<!DOCTYPE html>
<html>
<head>
<title>Report</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Custom Theme files -->
<!--theme-style-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	
<link href="css/modal.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Fashion Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--fonts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
<!--//fonts-->
<link rel="stylesheet" href="css/etalage.css">
<style type="text/css">   
 .w3_whatsapp_btn {
    background-image: url('icon.png');
    border: 1px solid rgba(0, 0, 0, 0.1);
    display: inline-block !important;
    position: relative;
    font-family: Arial,sans-serif;
    letter-spacing: .4px;
    cursor: pointer;
    font-weight: 400;
    text-transform: none;
    color: #fff;
    border-radius: 2px;
    background-color: #5cbe4a;
    background-repeat: no-repeat;
    line-height: 1.2;
    text-decoration: none;
    text-align: left;
}

.w3_whatsapp_btn_small {
    font-size: 12px;
    background-size: 16px;
    background-position: 5px 2px;
    padding: 3px 6px 3px 25px;
}

.w3_whatsapp_btn_medium {
    font-size: 16px;
    background-size: 20px;
    background-position: 4px 2px;
    padding: 4px 6px 4px 30px;
}

.w3_whatsapp_btn_large {
    font-size: 16px;
    background-size: 20px;
    background-position: 5px 5px;
    padding: 8px 6px 8px 30px;
    color: #fff;
}   

a.whatsapp { color: #fff;}
    
</style>

<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
</style>

<script src="js/jquery.etalage.min.js"></script>
<script>
			jQuery(document).ready(function($){

				$('#etalage').etalage({
					thumb_image_width: 300,
					thumb_image_height: 400,
					source_image_width: 900,
					source_image_height: 1200,
					show_hint: true,
					click_callback: function(image_anchor, instance_id){
						alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
					}
				});

			});
		</script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" id="sourcecode">
			$(function()
			{
				$('.scroll-pane').jScrollPane();
			});
		</script> 
</head>
<body> 
	<!--header-->
		<?php require_once('header.inc.php'); ?>
	<!--content-->
	<div class="content">
		<div class="container">
		<div class="single">
		<div class="col-md-9">
			<!-- Single grid start-->
			<div class="single_grid">
				<!-- Product image Details Start-->
				<div class="grid images_3_of_2">
							
				</div> 
				  <!-- Product image Details end-->
				  
				<form role="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">  
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
								<label for="txtToDate">To Date<span class="orangeLetter"></span></label>
								<input type="date" name="txtToDate" id="txtToDate" class="form-control input-lg" 
								value="<?php if(isset($_SESSION['txtToDate'])){ echo $_SESSION['txtToDate'];}else{}?>" tabindex="3" >
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
								<label for="txtFromDate">From Date<span class="orangeLetter"></span></label>
								<input type="date" name="txtFromDate" id="txtFromDate" class="form-control input-lg" 
								value="<?php if(isset($_SESSION['txtFromDate'])){ echo $_SESSION['txtFromDate'];}else{}?>" tabindex="2" >
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
									<select name="txtFactory" class="form-control input-lg" id="txtFactory" required>
										<option value="">Select Factory</option>
										<option value="1">Moni Enterprises</option>
										<option value="2">HMDA Dyeing</option>
									</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6"><input type="submit" name="txtSubmit" value="Get Report" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
					</div>
				</form>
				<hr class="colorgraph">
				
				<?php
					if(isset($_POST['txtSubmit']))
					{	
						$txtToDate	 				= $_POST['txtToDate'];
						$txtFromDate	 			= $_POST['txtFromDate'];
						$txtFactory	 				= $_POST['txtFactory'];
						$_SESSION['txtToDate']		= $txtToDate;
						$_SESSION['txtFromDate']	= $txtFromDate;
						$_SESSION['txtFactory']		= $txtFactory;
						if($txtFactory 	== 2){
							
							$purDtls 		= $supplier->getPurchBillDtls($txtToDate, $txtFromDate);
							//Dye Vendor
							$DyevenDtls 		= $vendor->getVenTypeWise(1);
							//Hand Vendor
							$HandvenDtls 		= $vendor->getVenTypeWise(2);
							$dExpenses 			= $journal->getdailyExpAccwise($txtToDate,$txtFromDate);
							
							// Sales Details
							$invoDtls 			= $invoice->getInvBillDtls($txtToDate, $txtFromDate);
							
							$dyeBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'rfri_dye_bbook');
							$compBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'rfri_comp_bbook');
							$handBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'rfri_hand_bbook');
							$manuBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'rfri_manual_bbook');
							
							//stock details
							$stockProdDtls 	= $productStock->getFacWiseStock(2);
							//Daily Expenses
							$dExpDtls 		= $mjournal->getMdailyExpAccwise($txtToDate,$txtFromDate);
							
							//###############  Dyeing bill details  ####################
							$tinvAmt				= 0;
							$tpurchAmt				= 0;
							$tdyeBillAmt			= 0;
							$thandBillAmt			= 0;
							$dyeQuantity			= 0;
							$compQuantity			= 0;
							$comBillTotal			= 0;
							$handQuantity			= 0;
							$incVenBillTotal 		= 0;
							$cmVenBillTotal 		= 0;
							$texpAmt				= 0;
							
							//Purchase Details
							foreach($purDtls as $eachRow)
								{
									$purchAmt		= $eachRow['SUM(net_balance)'];
									$tpurchAmt		+= $purchAmt;
								}
							//Daily Expenses Details
							foreach($dExpenses as $eachRow)
								{
									$dexpAmt		= $eachRow['SUM(pay_amount)'];
									$texpAmt		+= $dexpAmt;
								}
								
							//Invoice Details
							foreach($invoDtls as $eachRow)
								{
									$invAmt			= $eachRow['SUM(net_balance)'];
									$tinvAmt		+= $invAmt;
								}	
								
							// Dye Billing caculate
							foreach($DyevenDtls as $eachRow)
								{
									$vendorId			= $eachRow['vid'];
									$dyevendBillDtls 	= $vendor->getVenBillDtls($vendorId,$txtToDate, $txtFromDate);
									foreach($dyevendBillDtls as $eachdVbill)
										{
											$dyeBillAmt		= $eachdVbill['SUM(net_balance)'];
											$tdyeBillAmt	+= $dyeBillAmt;
										}
								}
								
							// Hand Billing caculate
							foreach($HandvenDtls as $eachRow)
								{
									$vendorId			= $eachRow['vid'];
									$handvendBillDtls 	= $vendor->getVenBillDtls($vendorId,$txtToDate, $txtFromDate);
									foreach($handvendBillDtls as $eachdVbill)
										{
											$handBillAmt		= $eachdVbill['SUM(net_balance)'];
											$thandBillAmt		+= $handBillAmt;
										}
									
								}
								
							//#################  Computer Bill Details  #################
							foreach($compBillDtls as $eachRecord)
								{
								
								$billNo 			= $eachRecord['bill_id'];
								$CompDetails  		= $statCat->disCompStatBillWise($billNo);
								$vendCompbill		= $statCat->getcomStatBillWorkInHouse($billNo,'Ari',547);
								$vMcompBill			= $statCat->getcomStatBillWorkInHouse($billNo,'Multi',547);
								//$empWiseCAriBill 	= $statCat->getcomStatBillEmpWise($billNo,'Ari');
								//$empWiseCMulBill 	= $statCat->getcomStatBillEmpWise($billNo,'Multi');
								//comp Status for dyeable 
								$compDtlsgrp 		= $statCat->disCompStatOrdWise($billNo);
								//computer Quantity count
									foreach($compDtlsgrp as $eachRecord)
										{
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRecord['order_id']);
											foreach($orderDtl as $eachRowff)
												{
													$pipeOrdQty		= $eachRowff['SUM(quantity)'];
													$compQuantity	+= $pipeOrdQty;
												}
										}
								
								$tQuantity 		= 0;
								foreach($CompDetails as $eachRecord)
									{
									//$bgColor 	 	= $utility->getRowColor($sl);
									$sCompEmbDtls	= $sample->showSamCompEmb($eachRecord['computer_design_no']);
									
									//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
									$totalQuantity	= $eachRecord['quantity'] + $eachRecord['complete'];
									//$tHeads			= $totalQuantity * $sCompEmbDtls[18];
									$designNo		= $eachRecord['computer_design_no'];
									$Remarks   		= $eachRecord['remarks'];
									$tQuantity 		+= $totalQuantity;
									$totalCost 		= $totalQuantity * $eachRecord['stich_rate'];
									$comBillTotal 	+= $totalCost;
										
									}//end inner foreach loop	
									
									
									//Ari Computer vendor bill Dtls	
									$tvendQuantity 		= 0;
								foreach($vendCompbill as $veachRecord)
									{
									//$bgColor 	 	= $utility->getRowColor($sl);
									$sCompEmbDtls	= $sample->showSamCompEmb($veachRecord['computer_design_no']);
									//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
									$totalaQuantity	= $veachRecord['quantity'] + $veachRecord['complete'];
									//$tHeads			= $totalQuantity * $sCompEmbDtls[18];
									$designNo		= $veachRecord['computer_design_no'];
									$Remarks   		= $veachRecord['remarks'];
									$tvendQuantity 	+= $totalaQuantity;
									$totalariCost 	= $totalaQuantity * $veachRecord['stich_rate'];
									$incVenBillTotal += $totalariCost;
									}//end inner foreach loop
									
									//Multi Computer vendor bill Dtls	
									$tmvendQuantity 		= 0;
								foreach($vMcompBill as $vmeachRecord)
									{
									//$bgColor 	 	= $utility->getRowColor($sl);
									$sCompEmbDtls	= $sample->showSamCompEmb($vmeachRecord['computer_design_no']);
									//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
									$totalaQuantity	= $vmeachRecord['quantity'] + $vmeachRecord['complete'];
									//$tHeads			= $totalQuantity * $sCompEmbDtls[18];
									$designNo		= $vmeachRecord['computer_design_no'];
									$Remarks   		= $vmeachRecord['remarks'];
									$tmvendQuantity 	+= $totalaQuantity;
									$totalariCost 	= $totalaQuantity * $vmeachRecord['stich_rate'];
									$cmVenBillTotal += $totalariCost;
									}//end inner foreach loop
									
								}//end foreach loop
							//end Computer bill Details
							
							//######################  Hand bill details  #######################
							$handTamount 		= 0;
							foreach($handBillDtls as $eachRecord)
								{
									$billNo 			= $eachRecord['bill_id'];
									//$CompDetails  		= $statCat->disCompStatBillWise($billNo);
									$handTamount 	   	+= $eachRecord['tamount'];
									
									//hand Status for dyeable 
									$handDtlsgrp 		= $statCat->disHandStatOrdWise($billNo);
									//computer Quantity count
									foreach($handDtlsgrp as $eachRecord)
										{
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRecord['order_id']);
											foreach($orderDtl as $eachRowff)
												{
													$pipeOrdQty		= $eachRowff['SUM(quantity)'];
													$handQuantity	+= $pipeOrdQty;
												}
										}
									
								}
							
							
							//##################  production Details  #######################
							$totalProd 		= 0;
							$stitchCost 	= 0;
							$totalsales		= 0;
							$tGR 			= 0;
							foreach($stockProdDtls as $eachRecord)
								{
								
								$DesignNo 			= $eachRecord['design_no'];
								//stock details
								$stockDtls			= $productStock->showPStockDesignwise($DesignNo);
								//GR details
								$GRDetails  		= $productStock->getStockGRDesignWise($stockDtls[0],$txtToDate,$txtFromDate);
								
								$prodInDetails  	= $productStock->getStockInDesignWise($DesignNo,$txtToDate,$txtFromDate);
								//sales details
								$prodSalesDtls		= $productStock->getStockSalesDesignWise($DesignNo,$txtToDate,$txtFromDate);
								//Stitch Details
								$stitchDtls 		= $statCat->getStitchDtlsDesignWise($DesignNo,$txtToDate,$txtFromDate);	
								//$tQuantity 		= 0;
								foreach($prodInDetails as $eachRecord)
									{
									$prodIn 		= $eachRecord['product_in'];
									$totalProd 	   	+= $prodIn;
										
									}//end inner foreach loop
								//Product sales report
								foreach($prodSalesDtls as $eachRecord)
									{
									$prodIn 			= $eachRecord['sales'];
									$totalsales 	   	+= $prodIn;
										
									}//end inner foreach loop
		
									
								foreach($stitchDtls as $eachRecord)
									{
									$stCost 		= $eachRecord['work_price'];
									$stitchCost 	+= $stCost;
										
									}//end inner foreach loop	
									
								foreach($GRDetails as $eachRecord)
									{
									$tGR 			+= $eachRecord['SUM(ready_gd)'];										
									}//end GR foreach loop	
									
									
								}//end foreach loop
							//end production details
							
							
						}// end if loop	
						else{
							echo "Under Construction.....";
						}//end else loop

				?>
						<h2>Purchase Billing</h2>
						Purchase 			:<?php echo $tpurchAmt;?><br>
						<hr class="colorgraph">
						<h2>Vendor Billing</h2>
						Dye Billing  : Rs.<?php echo $tdyeBillAmt;?> <br>
						Hand Billing : Rs.<?php echo $thandBillAmt;?> <br>
						<?php $tihcBilling 	= $cmVenBillTotal + $incVenBillTotal;
							$tvencBilling 	= $comBillTotal - $tihcBilling;
						?>
						Computer Billing:Rs.<?php echo $tvencBilling;?><br>
						<hr class="colorgraph">
						<div class="row">
							<div class="col-sm-4" style="background-color:lavenderblush;">
								
							</div>
						</div>	
						
						<h2>Daily Expenses</h2>
						<?php if($txtFactory 	== 1){
						?>
						Daily Expenses  :<?php $mjournal->conMDailyExp($txtToDate,$txtFromDate);?><br>
						<?php }
							else{
						?>
						Daily Expenses  :<?php $journal->conDailyExp($txtToDate,$txtFromDate);?><br>
						<?php 
							}
						?>						
						<hr class="colorgraph">
						<h2>Total Cost:</h2>
						<div class="row">
							<div class="col-sm-4" style="background-color:lavenderblush;">
								<?php $totalCost 	= $tpurchAmt + $tdyeBillAmt + $thandBillAmt + $tvencBilling + $texpAmt;
									
								?>
								<h2>Rs. <?php echo $totalCost;?></h2>
							</div>
						</div>
						<hr class="colorgraph">
						<div class="row">
							<div class="col-sm-4" style="background-color:lavender;">	
								Production      :<a href=""><?php echo $totalProd;?>Pcs	</a><br>
							</div>	
						</div>	<br>
						<div class="row">
							<div class="col-sm-4" style="background-color:lavender;">	
								Sales			:<a href=""><?php echo $totalsales;?></a>
							</div>	
						</div>	<br>
						GR				:<a href=""><?php echo $tGR;?></a>
						
						<h2> Sales Details:</h2>
						
						Sales Amount : Rs. <?php echo $tinvAmt; ?>
				
				<?php
					}//end of isset loop
					else{
				?>
				
				hi there..
				
				
				<?php
					}
				?>
          	</div>
			  <!-- Single grid end--> 
			
			<!----- Same design product box---->
			<div class="product_box1"> 
				
			</div>	<!----- end product box---->
		
	</div>
	<!---->
	<div class="col-md-3">
	  <div class="w_sidebar">
		<section  class="sky-form">
			<h4>catogories</h4>
				<div class="row1 scroll-pane">
					<div class="col col-4">
						<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>kutis</label>
					</div>
				</div>
		</section>
		
		<section class="sky-form">
			<h4>colour</h4>
			<ul class="w_nav2">
				<li><a class="color1" href="#"></a></li>
				<li><a class="color2" href="#"></a></li>
				<li><a class="color3" href="#"></a></li>
				<li><a class="color4" href="#"></a></li>
				<li><a class="color5" href="#"></a></li>
				<li><a class="color6" href="#"></a></li>
				<li><a class="color7" href="#"></a></li>
				<li><a class="color8" href="#"></a></li>
				<li><a class="color9" href="#"></a></li>
				<li><a class="color10" href="#"></a></li>
				<li><a class="color12" href="#"></a></li>
				<li><a class="color13" href="#"></a></li>
				<li><a class="color14" href="#"></a></li>
				<li><a class="color15" href="#"></a></li>
				<li><a class="color5" href="#"></a></li>
				<li><a class="color6" href="#"></a></li>
				<li><a class="color7" href="#"></a></li>
				<li><a class="color8" href="#"></a></li>
				<li><a class="color9" href="#"></a></li>
				<li><a class="color10" href="#"></a></li>
			</ul>
		</section>
		<section class="sky-form">
						<h4>discount</h4>
						<div class="row1 scroll-pane">
						<!--	<div class="col col-4">
								<label class="radio"><input type="radio" name="radio" checked=""><i></i>60 % and above</label>
								<label class="radio"><input type="radio" name="radio"><i></i>50 % and above</label>
								<label class="radio"><input type="radio" name="radio"><i></i>40 % and above</label>
							</div>
							<div class="col col-4">
								<label class="radio"><input type="radio" name="radio"><i></i>30 % and above</label>
								<label class="radio"><input type="radio" name="radio"><i></i>20 % and above</label>
								<label class="radio"><input type="radio" name="radio"><i></i>10 % and above</label>
							</div>-->
						</div>						
		</section>
	</div>
   </div>
   <div class="clearfix"> </div>
	</div>
	</div>
	</div>
	<!---->
	<div class="footer">
		<div class="container">
			<div class="footer-class">
				
			<div class="clearfix"> </div>
			</div>
		 </div>
	</div>
	
	
	<script type="text/javascript">
		$(document).ready(function() {

			$(document).on("click",'.whatsapp',function() {

		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

				var text = $(this).attr("data-text");
				var url = $(this).attr("data-link");
				var message = encodeURIComponent(text)+" - "+encodeURIComponent(url);
				var whatsapp_url = "whatsapp://send?text="+message;
				window.location.href= whatsapp_url;
		} else {
			alert("Please share this Photo in mobile device");
		}

			});
		});
	</script>
	
	<!--Pipe line status-->
	<script>
		// Get the modal
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		var btn = document.getElementById("myBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];
		// When the user clicks the button, open the modal 
		btn.onclick = function() {
			modal.style.display = "block";
		}
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	</script>
	
	<!--Stock Details-->
	<script>
		// Get the modal
		var modal1 = document.getElementById('myStock');
		// Get the button that opens the modal
		var btn = document.getElementById("curntStock");
		// Get the <span> element that closes the modal
		var span1 = document.getElementsByClassName("close")[0];
		// When the user clicks the button, open the modal 
		btn.onclick = function() {
			modal1.style.display = "block";
		}
		// When the user clicks on <span> (x), close the modal
		span1.onclick = function() {
			modal1.style.display = "none";
		}
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal1) {
				modal1.style.display = "none";
			}
		}
	</script>
	
	
</body>
</html>