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
							
							$dyeBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'rfri_dye_bbook');
							$compBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'rfri_comp_bbook');
							$handBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'rfri_hand_bbook');
							$manuBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'rfri_manual_bbook');
							//stock details
							$stockProdDtls 	= $productStock->getFacWiseStock(2);
							//Daily Expenses
							$dExpDtls 		= $mjournal->getMdailyExpAccwise($txtToDate,$txtFromDate);
							
							//###############  Dyeing bill details  ####################
							$dyeTamount 			= 0;
							$tGeorgette 			= 0;
							$tTafetaInner 			= 0;
							$tChiffonDupatta 		= 0;
							$tArtGeorgette 			= 0;
							$tArtGeorgetteDupatta 	= 0;
							$tTafetaPant			= 0;
							$tGeorgetteDupatta		= 0;
							$dyeQuantity			= 0;
							$compQuantity			= 0;
							$comBillTotal			= 0;
							$handQuantity			= 0;
							$incVenBillTotal 		= 0;
							$cmVenBillTotal 		= 0;
							foreach($dyeBillDtls as $eachRecord)
								{
									$billNo 			= $eachRecord['bill_id'];
									//Dye Status for dyeable 
									$dyeDtls 			= $statCat->getAllDyAmount($billNo,'Dyeable');
									
									$georgDetails  		= $statCat->getAllFabricAmount($billNo, 'Georgette');
									$tafInDetails  		= $statCat->getAllFabricAmount($billNo, 'TafetaInner');
									$ChiDupDetails  	= $statCat->getAllFabricAmount($billNo, 'ChiffonDupatta');
									$artGrgDetails  	= $statCat->getAllFabricAmount($billNo, 'Art Georgette');
									$ardDetails  		= $statCat->getAllFabricAmount($billNo, 'Art GeorgetteDupatta');
									$tpDetails  		= $statCat->getAllFabricAmount($billNo, 'Tafeta.Pant');
									$gdDetails  		= $statCat->getAllFabricAmount($billNo, 'Georgette.Dupatta');
									
									$dyeTamount 	   	+= $eachRecord['tamount'];
									
									//Dye Quantity count
									foreach($dyeDtls as $eachRecord)
										{
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRecord['order_id']);
											foreach($orderDtl as $eachRowff)
												{
													$pipeOrdQty		= $eachRowff['SUM(quantity)'];
													$dyeQuantity	+= $pipeOrdQty;
												}
										}
									
									//Georgette count
									foreach($georgDetails as $eachRecord)
										{
											$tGeorgette 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//TafetaInner count
									foreach($tafInDetails as $eachRecord)
										{
											$tTafetaInner 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//ChifonDupata count
									foreach($ChiDupDetails as $eachRecord)
										{
											$tChiffonDupatta 	  += $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//Art Georgette count
									foreach($artGrgDetails as $eachRecord)
										{
											$tArtGeorgette 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//Art Georgette dupatta count
									foreach($ardDetails as $eachRecord)
										{
											$tArtGeorgetteDupatta 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//taffeta pant count
									foreach($tpDetails as $eachRecord)
										{
											$tTafetaPant 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//Georgette Dupatta count
									foreach($gdDetails as $eachRecord)
										{
											$tGeorgetteDupatta 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}	
								}
							//#################  Computer Bill Details  #################
							foreach($compBillDtls as $eachRecord)
								{
								
								$billNo 			= $eachRecord['bill_id'];
								$CompDetails  		= $statCat->disCompStatBillWise($billNo);
								$vendCompbill		= $statCat->getcomStatBillWorkInHouse($billNo,'Ari',678);
								$vMcompBill			= $statCat->getcomStatBillWorkInHouse($billNo,'Multi',678);
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
							$dyeBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'mep_dye_bbook');
							$compBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'mep_comp_bbook');
							$handBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'mep_hand_bbook');
							$manuBillDtls 	= $bill->getAllBill($txtToDate,$txtFromDate,'mep_manual_bbook');
							
							//stock details
							$stockProdDtls 	= $productStock->getFacWiseStock(1);
							//Daily Expenses
							$dExpDtls 		= $journal->getdailyExpAccwise($txtToDate,$txtFromDate);
							
							//#########################  Dyeing bill details  #######################
							$dyeTamount 			= 0;
							$tGeorgette 			= 0;
							$tTafetaInner 			= 0;
							$tChiffonDupatta 		= 0;
							$tArtGeorgette 			= 0;
							$tArtGeorgetteDupatta 	= 0;
							$tTafetaPant			= 0;
							$tGeorgetteDupatta		= 0;
							$dyeQuantity			= 0;
							$compQuantity			= 0;
							$mixcomBillTotal		= 0;
							$ariBillTotal			= 0;
							$embBillTotal			= 0;
							$mulBillTotal			= 0;
							$handQuantity			= 0;
							$inAriBillTotal			= 0;
							$inMultiQuantity		= 0;
							foreach($dyeBillDtls as $eachRecord)
								{
									$bid 				= $eachRecord['bill_id'];
									$billNo				= "D".$bid."";
									//$CompDetails  		= $statCat->disCompStatBillWise($billNo);
									$dyeTamount 	   	+= $eachRecord['tamount'];
									//Dye Status for dyeable 
									$dyeDtls 			= $statCat->getAllDyAmount($billNo,'Dyeable');
									$georgDetails  		= $statCat->getAllFabricAmount($billNo, 'Georgette');
									$tafInDetails  		= $statCat->getAllFabricAmount($billNo, 'TafetaInner');
									$ChiDupDetails  	= $statCat->getAllFabricAmount($billNo, 'ChiffonDupatta');
									$artGrgDetails  	= $statCat->getAllFabricAmount($billNo, 'Art Georgette');
									$ardDetails  		= $statCat->getAllFabricAmount($billNo, 'Art GeorgetteDupatta');
									$tpDetails  		= $statCat->getAllFabricAmount($billNo, 'Tafeta.Pant');
									$gdDetails  		= $statCat->getAllFabricAmount($billNo, 'Georgette.Dupatta');
									
									//Dye Quantity count
									foreach($dyeDtls as $eachRecord)
										{
											
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRecord['order_id']);
											foreach($orderDtl as $eachRowff)
												{
													$pipeOrdQty		= $eachRowff['SUM(quantity)'];
													$dyeQuantity	+= $pipeOrdQty;
												}
										}
									//Georgette count
									foreach($georgDetails as $eachRecord)
										{
											$tGeorgette 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//TafetaInner count
									foreach($tafInDetails as $eachRecord)
										{
											$tTafetaInner 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//ChifonDupata count
									foreach($ChiDupDetails as $eachRecord)
										{
											$tChiffonDupatta 	  += $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//Art Georgette count
									foreach($artGrgDetails as $eachRecord)
										{
											$tArtGeorgette 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//Art Georgette dupatta count
									foreach($ardDetails as $eachRecord)
										{
											$tArtGeorgetteDupatta 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//taffeta pant count
									foreach($tpDetails as $eachRecord)
										{
											$tTafetaPant 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}
									//Georgette Dupatta count
									foreach($gdDetails as $eachRecord)
										{
											$tGeorgetteDupatta 	   	+= $eachRecord['quantity'] + $eachRecord['complete'];
										}	
								}
							//#########################  computer billing  ################################
							foreach($compBillDtls as $eachRecord)
								{
								
								$bid 				= $eachRecord['bill_id'];
								$billNo				= "C".$bid."";
								//$CompDetails  		= $statCat->disCompStatBillWise($billNo);
								$embDtls			= $statCat->getcomStatBillWorkType($billNo,'Embroidery');
								$ariDtls			= $statCat->getcomStatBillWorkType($billNo,'Ari');
								$mulDtls			= $statCat->getcomStatBillWorkType($billNo,'Multi');
								$mixDtls			= $statCat->getcomStatBillWorkType($billNo,'');
								
								//inhouse
								$ariDtlsIn			= $statCat->getcomStatBillWorkInHouse($billNo,'Ari',365);
								$mulDtlsIn			= $statCat->getcomStatBillWorkInHouse($billNo,'Multi',365);
								
								//comp Status for dyeable 
								$compDtlsgrp 		= $statCat->disCompStatOrdWise($billNo);
								
								//ari- 750000   3+2  1.6 -60000  
								//mul- 800000  11+18  .8  -185600
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
								foreach($mixDtls as $mixRecord)
									{
									//$bgColor 	 	= $utility->getRowColor($sl);
									$sCompEmbDtls	= $sample->showSamCompEmb($mixRecord['computer_design_no']);
									//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
									$totalQuantity	= $mixRecord['quantity'] + $mixRecord['complete'];
									//$tHeads			= $totalQuantity * $sCompEmbDtls[18];
									$designNo		= $mixRecord['computer_design_no'];
									$Remarks   		= $mixRecord['remarks'];
									$tQuantity 		+= $totalQuantity;
									$totalCost 		= $totalQuantity * $mixRecord['stich_rate'];
									$mixcomBillTotal 	+= $totalCost;
									}//end inner foreach loop	
									
									$taQuantity 		= 0;
								foreach($ariDtls as $ariRecord)
									{
									//$bgColor 	 	= $utility->getRowColor($sl);
									$sCompEmbDtls	= $sample->showSamCompEmb($ariRecord['computer_design_no']);
									//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
									$totalaQuantity	= $ariRecord['quantity'] + $ariRecord['complete'];
									//$tHeads			= $totalQuantity * $sCompEmbDtls[18];
									$designNo		= $ariRecord['computer_design_no'];
									$Remarks   		= $ariRecord['remarks'];
									$taQuantity 		+= $totalaQuantity;
									$totalariCost 		= $totalaQuantity * $ariRecord['stich_rate'];
									$ariBillTotal 	+= $totalariCost;
									}//end inner foreach loop
									
									$tmQuantity 		= 0;
								foreach($mulDtls as $mulRecord)
									{
									//$bgColor 	 	= $utility->getRowColor($sl);
									$sCompEmbDtls	= $sample->showSamCompEmb($mulRecord['computer_design_no']);
									//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
									$totalmQuantity	= $mulRecord['quantity'] + $mulRecord['complete'];
									//$tHeads			= $totalQuantity * $sCompEmbDtls[18];
									$designNo		= $mulRecord['computer_design_no'];
									$Remarks   		= $mulRecord['remarks'];
									$tmQuantity 	+= $totalQuantity;
									$totalmulCost 	= $totalmQuantity * $mulRecord['stich_rate'];
									$mulBillTotal 	+= $totalmulCost;
									}//end inner foreach loop

									$teQuantity 		= 0;
								foreach($embDtls as $rowEmb)
									{
									//$bgColor 	 	= $utility->getRowColor($sl);
									$sCompEmbDtls	= $sample->showSamCompEmb($rowEmb['computer_design_no']);
									//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
									$totaleQuantity	= $rowEmb['quantity'] + $rowEmb['complete'];
									//$tHeads			= $totalQuantity * $sCompEmbDtls[18];
									$designNo		= $rowEmb['computer_design_no'];
									$Remarks   		= $rowEmb['remarks'];
									$teQuantity 	+= $totaleQuantity;
									$totalembCost 	= $totaleQuantity * $rowEmb['stich_rate'];
									$embBillTotal 	+= $totalembCost;
									}//end inner foreach loop	
									
								//Ari inhouse	
									$tariQuantity 		= 0;
								foreach($ariDtlsIn as $ariInRecord)
									{
									//$bgColor 	 	= $utility->getRowColor($sl);
									$sCompEmbDtls	= $sample->showSamCompEmb($ariInRecord['computer_design_no']);
									//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
									$totalaQuantity	= $ariInRecord['quantity'] + $ariInRecord['complete'];
									//$tHeads			= $totalQuantity * $sCompEmbDtls[18];
									$designNo		= $ariInRecord['computer_design_no'];
									$Remarks   		= $ariInRecord['remarks'];
									$tariQuantity 	+= $totalaQuantity;
									$totalariCost 	= $totalaQuantity * $ariInRecord['stich_rate'];
									$inAriBillTotal += $totalariCost;
									}//end inner foreach loop
									
									$tmulQuantity 		= 0;
								foreach($mulDtlsIn as $mulInRecord)
									{
									//$bgColor 	 	= $utility->getRowColor($sl);
									$sCompEmbDtls	= $sample->showSamCompEmb($mulInRecord['computer_design_no']);
									//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
									$totalaQuantity	= $mulInRecord['quantity'] + $mulInRecord['complete'];
									//$tHeads			= $totalQuantity * $sCompEmbDtls[18];
									$designNo		= $mulInRecord['computer_design_no'];
									$Remarks   		= $mulInRecord['remarks'];
									$tmulQuantity 	+= $totalaQuantity;
									$totalariCost 	= $totalaQuantity * $mulInRecord['stich_rate'];
									$inMultiQuantity += $totalariCost;
									}//end inner foreach loop
									
								}//end foreach loop
							//end computer billing

							//#############################  Hand bill details  #######################
							$handTamount 		= 0;
							foreach($handBillDtls as $eachRecord)
								{
									$bid 				= $eachRecord['bill_id'];
									$billNo				= "H".$bid."";
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
								
							//#######################  production Details  ######################
							$totalProd 		= 0;
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
								
								//Product in report
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
								

						}//end else loop

				?>
						<h2>Fabric Details</h2>
						Georgette 			:<?php echo $tGeorgette;?><br>
						TafetaInner 		:<?php echo $tTafetaInner;?><br>
						ChiffonDupatta 		:<?php echo $tChiffonDupatta;?><br>
						Art Georgette 		:<?php echo $tArtGeorgette;?><br>
						ArtGeorgetteDupatta :<?php echo $tArtGeorgetteDupatta;?><br>
						TafetaPant			:<?php echo $tTafetaPant;?><br>
						Georgette Dupatta	:<?php echo $tGeorgetteDupatta;?><br><br>
						Dye Billing     :<a href="">Rs.<?php echo $dyeTamount;?></a> Dye Quantity: <?php echo $dyeQuantity;?>Pcs<br>
						<?php
						if($txtFactory 	== 1){
						?>	
						<div class="row">
							<div class="col-sm-4" style="background-color:lavender;">	
								Embroidery Machine Billing:<a href="">Rs.<?php echo $embBillTotal;?></a><br>
							</div>	
						</div><br>
							
						<div class="row">
							<div class="col-sm-4" style="background-color:lavender;">
								Ari Machine InHouse Billing:<a href="">Rs.<?php echo $inAriBillTotal;?></a><br>
							</div>	
							<div class="col-sm-4" style="background-color:lavenderblush;">
								Ari Machine Vendor Billing:<a href="">Rs.<?php $vmcBilling = $ariBillTotal - $inAriBillTotal;
								echo $vmcBilling;?></a><br>
							</div>
							<div class="col-sm-4" style="background-color:lavender;">
								Ari Machine Total Billing:<a href="">Rs.<?php echo $ariBillTotal;?></a><br>
							</div>
						</div>	
						<div class="row">
							<div class="col-sm-4" style="background-color:lavender;">
								Multi Machine InHouse Billing:<a href="">Rs.<?php echo $inMultiQuantity;?></a><br>
							</div>	
							<div class="col-sm-4" style="background-color:lavenderblush;">
								Multi Machine Vendor Billing:<a href="">Rs.<?php $vcBilling = $mulBillTotal - $inMultiQuantity;
							echo $vcBilling;?></a><br>
							</div>
							<div class="col-sm-4" style="background-color:lavender;">
								Multi Machine Total Billing:<a href="">Rs.<?php echo $mulBillTotal;?></a><br>
							</div>
						</div>	<br>	
						<div class="row">
							<div class="col-sm-4" style="background-color:lavender;">	
								Mix Machine Billing:<a href="">Rs.<?php echo $mixcomBillTotal;?></a><br>
							</div>	
						</div>	<br>
						<div class="row">
							<div class="col-sm-4" style="background-color:lavender;">	
								Computer Quantity:<?php echo $compQuantity;?>Pcs<br>
							</div>	
						</div>	<br>
							
						<?php
						}
						else{
						?>
							Computer Billing:<a href="">Rs.<?php echo $comBillTotal;?></a>Computer Quantity:<?php echo $compQuantity;?>Pcs<br>
						
						<div class="row">
							<div class="col-sm-4" style="background-color:lavender;">
								Ari Machine Vendor Billing:<a href="">Rs.<?php echo $incVenBillTotal;?></a><br>
							</div>	
							<div class="col-sm-4" style="background-color:lavenderblush;">
								Multi Machine Vendor Billing:<a href="">Rs.<?php $tvcBilling = $cmVenBillTotal + $incVenBillTotal;
								echo $cmVenBillTotal;?></a><br>
							</div>
							<div class="col-sm-4" style="background-color:lavender;">
								Total Vendor Billing:<a href="">Rs.<?php echo $tvcBilling;?></a><br>
							</div>
						</div>	
						<div class="row">
							<div class="col-sm-4" style="background-color:lavenderblush;">
								Inhouse Computer Billing:<a href="">Rs.<?php $tincBilling = $comBillTotal - $tvcBilling;
								echo $tincBilling;?></a><br>
							</div>
						</div>	
						
						<?php
						
						}
						?>
						<div class="row">
							<div class="col-sm-4" style="background-color:lavender;">	
								Hand Billing    :<a href=""><?php echo $handTamount;?></a>Hand Quantity:<?php echo $handQuantity;?>Pcs<br>
							</div>	
						</div>	<br>
						
						Stitch Cost   	:<a href=""><?php echo $stitchCost;?></a><br>
						
						Total Billing   :<a href=""><?php $Total = $dyeTamount + $comBillTotal + $handTamount + $stitchCost;
											echo $Total;?></a><br>
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