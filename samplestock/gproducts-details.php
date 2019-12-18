<?php
ob_start();
session_start();
?>
<?php 
//session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/customer.class.php");
require_once("../classes/product_stock.class.php"); 
require_once("../classes/product_order.class.php");
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/status_cat.class.php");
require_once("../classes/adv_search.class.php");
require_once("../classes/photo_gallery.class.php");
require_once("../classes/sample.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders		    = new Orders();
$client		    = new Customer();
$prodStatus		= new Pstatus();
$statusCat		= new StatusCat();
$advSearch		= new AdvSearch();
$productStock	= new ProductStock();
$productOrder	= new Productorders();
$search_obj		= new Search();
$pages			= new Pagination();
$photogallery	= new PhotoGAllery();
$sample			= new Sample();
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
if((isset($_POST['btnSearch'])))
{	
	$designNo				= $_POST['keyword'];
	$sGalleryDetail 		= $photogallery->showSampleGalleryDgn($designNo);
	$sgid					= $sGalleryDetail[0];
}
else{
	//Sample Gallery Data
	$sGalleryDetail 		= $photogallery->showSamplePGallery($sgid);
}

// Sample Gallery All Data Design wise
$sGalleryDtls 			= $photogallery->sPhotoAllDesiData($sGalleryDetail[2]);

$factoryDtls 			= $sample->showFactory($sGalleryDetail[1]);

//Sample Gallery Details data 
$sGDtlsData 			= $photogallery->sPhotoDtlsAllData($sgid);
$stockDtls				= $productStock->showPStockDesignwise($sGalleryDetail[2]);

$stockDtlsDetails 		= $productStock->showPStockDetailsdescolorwise($sGalleryDetail[2],$sGalleryDetail[13]);
//Stock Product details
//$stockProdDtls 			= $productStock->ProdstockDtl($sGalleryDetail[2]);
$stockProdDtls 			= $productStock->stockPDtlNetColor($stockDtls[0]);
$prodSaleskDtls 		= $productStock->stockPSaleDesShow($sGalleryDetail[2]);

// Due Order Display
$dueOrdDtls 			= $productOrder->getDueOrd($sGalleryDetail[2]);
$dueOrdColourWise 		= $productOrder->getDueOrdColourWise($sGalleryDetail[2]);
$sProductInDtls 		= $productStock->getsProdInDateWise($sGalleryDetail[2]);

// Pipe line status all data
$statusData 			= $prodStatus->statusAllData($sGalleryDetail[2]);

?>


<!DOCTYPE html>
<html>
<head>
<title><?php echo $sGalleryDetail[2];?> Details</title>
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
						<ul id="etalage">
							<li>
								<a href="optionallink.html">
									<img class="etalage_thumb_image img-responsive" src="../images/spgallery/large/<?php echo $sGalleryDetail[6];?>" alt="" >
									<img class="etalage_source_image img-responsive" src="../images/spgallery/large/<?php echo $sGalleryDetail[6];?>" alt="" >
								</a>
							</li>
						<?php 
							if(count($sGDtlsData) == 0)
								{
									echo " ";  
								}
							else
								{
									foreach($sGDtlsData as $eachRecord)
									{
						?>			
									<li>
										<img class="etalage_thumb_image img-responsive" src="../images/spgallery/large/<?php echo $eachRecord['images'];?>" alt="" >
										<img class="etalage_source_image img-responsive" src="../images/spgallery/large/<?php echo $eachRecord['images'];?>" alt="" >
									</li>
						<?php
									}
								}
						?>		
						
						</ul>
						 <div class="clearfix"> </div>		
				</div> 
				  <!-- Product image Details end-->
				  
				<!-- Product Description start-->
				<div class="span1_of_1_des">
					<div class="desc1">
						<h3>Design No:<?php echo $sGalleryDetail[2];?></h3>
						<p><?php echo $sGalleryDetail[3];?><br>
							Colour: <?php echo $sGalleryDetail[13];?>
						</p>
						<h5>RS.<?php echo $sGalleryDetail[4];?> <a href="#"></a></h5>
						<p>Factory Name:<?php echo $factoryDtls[1];?>
						<div class="available">
							<h4>Stock Details :</h4>
							
							<ul>
								<?php if(count($stockDtls) == 0){
								
								?>
								<li>Current Stock: 0
								</li>
								<li>Total Sale: 0
								</li>
								<?php
								}else{
								?>
								<li data-toggle="collapse" data-target="#cStock" style="color: blue;font-size:16px;">Current Stock:
									<?php echo $stockDtls[2];?>
								</li>
								
								<div id="cStock" class="collapse"><!--start cStock-->
									 <!-- Display Data -->
									<div id="data-column">
										<table class='blue' cellpadding="0" cellspacing="0" id="table-1">
											<thead>
											  <th align="center" width="25%">Product In(Pcs.)</th>
											  <th align="center" width="25%">Date</th>
											</thead>  
											<?php
												foreach($sProductInDtls as $eachstRecord)
													{
													$addeddate		= date_create($eachstRecord['added_on']);
												?>	
												<tr>
													<td align="center"><?php echo $eachstRecord['SUM(product_in)']; ?></td>
													<td align="center"><?php echo date_format($addeddate,"d-M-y");?></td>
												</tr>
											
											<?php	
												}//end foreachloop
											?>	
										</table>
									</div>
									<!-- end Display Data -->
								</div><!--end cStock-->
								
								<li data-toggle="collapse" data-target="#demo" style="color: blue;font-size:16px;">Total Sale:
									<?php echo $stockDtls[12];?>
								</li>
								
								<div id="demo" class="collapse"><!--start Collapse-->
									 <!-- Display Data -->
									<div id="data-column">
										<table class='blue' cellpadding="0" cellspacing="0" id="table-1">
											<thead>
											  <th align="center" width="25%">Sales(Pcs.)</th>
											  <th align="center" width="25%">Colour</th>
											  <th align="center" width="25%">Customer</th>
											  <th align="center" width="25%">Date</th>
											</thead>  
											<?php
												foreach($prodSaleskDtls as $eachRecord)
													{
												?>	
												<tr>
													<td align="center"><?php echo $eachRecord['sales']; ?></td>
													<td align="center"><?php echo $eachRecord['sale_colour']; ?></td>
													<td align="center"><?php echo $eachRecord['company']; ?></td>
													<td align="center"><?php echo $eachRecord['added_on']; ?></td>	
												</tr>
											
											<?php	
												}//end foreachloop
											?>	
										</table>
									</div>
									<!-- end Display Data -->
								</div><!--end Collapse-->
								
								<?php
								}
								?>
								
								<!--Order Due Section start-->
								<li data-toggle="collapse" data-target="#DueOrd" style="color: blue;font-size:16px;">Due Order:
									<?php $productOrder->dueOrdCount($sGalleryDetail[2]); ?>
								</li>
								<div id="DueOrd" class="collapse"><!--start Collapse-->
									 <!-- Display Data -->
									<div id="data-column">
										<table class='blue' cellpadding="0" cellspacing="0" id="table-1">
											<thead>
											  <th align="center" width="25%">Book No</th>
											  <th align="center" width="25%">Party</th>
											  <th align="center" width="25%">Due Qnty</th>
											  <th align="center" width="25%">Colour</th>
											  <th align="center" width="25%">Ord. Date</th>
											</thead>  
											<?php
												foreach($dueOrdDtls as $eachRecord)
													{
														$orddate		= date_create($eachRecord['order_date']);
												?>	
												<tr>
													<td align="center"><?php echo $eachRecord['book_no']; ?></td>
													<td align="center"><?php echo $eachRecord['party_code']; ?></td>
													<td align="center"><?php echo $eachRecord['due_quantity']; ?></td>
													<td align="center"><?php echo $eachRecord['colour']; ?></td>
													<td align="center"><?php echo date_format($orddate,"d-M-y");?></td>	
												</tr>
											
											<?php	
												}//end foreachloop
											?>	
										</table>
									</div>
									<!-- end Display Data -->
								</div><!--end Collapse-->
								<!--Order Due Section end-->
								
								<!--Order Due Section start-->
								<li data-toggle="collapse" data-target="#ordDtls" style="color: blue;font-size:16px;">Order:
									<?php $productOrder->dueOrdCount($sGalleryDetail[2]); ?>
								</li>
								<div id="ordDtls" class="collapse"><!--start Collapse-->
									<!-- Display Data -->
									<div id="data-column">
										<table class='blue' cellpadding="0" cellspacing="0" id="table-1">
											<thead>
											  <th align="center" width="25%">Qnty</th>
											  <th align="center" width="25%">Colour</th>
											</thead>  
											<?php
												foreach($dueOrdColourWise as $eachRecord)
													{
												?>	
												<tr>
													<td align="center"><?php echo $eachRecord['SUM(due_quantity)']; ?></td>
													<td align="center"><?php echo $eachRecord['colour']; ?></td>
												</tr>
											
											<?php	
												}//end foreachloop
											?>	
										</table>
									</div>
									<!-- end Display Data -->
								</div><!--end Collapse-->
								<!--Order Due Section end-->
								<!-- GR-->
								
								<!-- GR//-->
							</ul>
							
							<!--Pipeline status start-->
							<!-- Trigger/Open The Modal -->
							<button id="myBtn">Pipe Line Status()</button>
							<!-- The PipeLine Modal -->
							<div id="myModal" class="modal">
								<!-- Modal content -->
								<div class="modal-content">
									<div class="modal-header">
									  <span class="close">&times;</span>
									  <h2>Pipe Line Status</h2>
									</div>
									<div class="modal-body" style="font-size:9px;">
										<table class="single-column" cellpadding="0" cellspacing="0" border="1">
										<!-- display option -->
										<?php 
										if(count($statusData) == 0)
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
										<thead>
										  <th align="center" width="2%" >S.No</th>
										  <th align="center" width="3%" >ord.Id </th>
										  <th align="center" width="5%"  >Design</th>
										   <th align="center" width="5%"  >Order By </th>
										  <th width="10%"  >Ord.Date </th>
										  <th width="10%" >Trd.Date</th>
										  <th width="5%" >Age(Days)</th>
										  <th width="5%" data-toggle="collapse" data-target="#OrdQty">Qty</th>
										  <th width="7%"  >Dyeing</th>
										  <th width="7%" >Computer</th>
										  <th width="7%" >Ari</th>
										  <th width="7%"  >Hand </th>
										  <th width="7%" >HighLight</th>
										  <th width="7%" >Manual</th>
										  <th width="7%"  >F.Stiching</th>
										  <th width="7%"  >Iron </th>
										  <th width="7%" >Packing</th>
										  <th width="7%" >Status</th>
										</thead>
									   <?php 
											
										
										$k = 1;
										foreach($statusData as $eachRecord)
											{
											
											$bgColor 	= $utility->getRowColor($k);
											$Orddate	= date_create($eachRecord['order_date']);
											$Trddate	= date_create($eachRecord['target_date']);
											$orderDate 	= date_format($Orddate,"d/m/Y");
											$targetDate = date_format($Trddate,"d/m/Y");
											//Order Details
											$ordDtls 		= $orders->showOrders($eachRecord['order_id']);
											$orderColourDtl = $orders->ordersDtlDisplay($eachRecord['order_id']);
											$ordDtlsCnt 	= $orders->getOrderQuantitycount($eachRecord['order_id']);
											$customerDetail = $client->getCustomerData($eachRecord['employee_id']);
											foreach($ordDtlsCnt as $eachQty)
													{
														$inComp 	= $eachQty['SUM(quantity)'] - $eachQty['SUM(ready_quantity)']; 
													}
											
											$PhandstatusData = $statusCat->disHandStatOrdWorkWise($eachRecord['order_id'],'PureHand');
											$HhandstatusData = $statusCat->disHandStatOrdWorkWise($eachRecord['order_id'],'HighLight');
											if(count($PhandstatusData) == 0)
												{
													$pureHand 	= '';
												}else{
													foreach($PhandstatusData as $eachPure)
													{
														$pureHand 	= $eachPure['final_result'];
													}
												
												}
											if(count($HhandstatusData) == 0)
												{
													$HighLight 	= '';
												}else{
													foreach($HhandstatusData as $eachHlight)
													{
														$HighLight 	= $eachHlight['final_result'];
													}
												
												}	
												
									?>
										<tr align="left"<?php $utility->printRowColor($bgColor);?>>
										<td align="center"><?php echo $customerDetail[5];; ?></td>
										<td align="center"><?php echo $eachRecord['order_id']; ?></td>
										<td align="center"><?php echo $eachRecord['design_no']; ?></td>
										<td align="center"><?php echo $ordDtls[2]; ?></td>
										<td align="center"><?php echo $orderDate; ?></td>
										<td align="center"><?php echo $targetDate; ?></td>
									   <?php
										//$date1=date_create($eachRecord['target_date']);
										$date1=date_create($eachRecord['order_date']);
										$date2=date_create(date("Y-m-d"));
										$diff=date_diff($date1,$date2);
										
										if($diff->format("%R%a days") > '+3 days')
										{
									   ?>
									   <td align="center" style="color:red;"><?php echo $diff->format("%R%a days"); ?></td>
									   <?php
										}
										else{
									   ?>
									   <td align="center" style="color:blue;"><?php echo $diff->format("%R%a days"); ?></td>
									   <?php
											}
									   ?>
									   
										<td align="center">
											<b><a href="#">
											  <?php	$orders->TotalQuantitySum($eachRecord['order_id']);	?>					  
											</a> -</b>
											<?php	
												foreach($orderColourDtl as $record)
												{
													echo $record['colour'];echo '<br>';
												}
											?>	
										</td>
									   
										<td align="center"><?php echo $eachRecord['dyeing']; ?></td>
										<td align="center"><?php echo $eachRecord['computer']; ?></td>
										<td align="center"><?php echo $eachRecord['ari']; ?></td>
										<td align="center"><?php echo $pureHand; ?></td>
										<td align="center"><?php echo $HighLight; ?></td>
										<td align="center"><?php echo $eachRecord['manual']; ?></td>
										<td align="center"><?php echo $eachRecord['fstiching']; ?></td>
										<td align="center"><?php echo $eachRecord['iron']; ?></td>
										<td align="center"><?php echo $eachRecord['packing']; ?></td>
										<td align="center">
											<?php 
												if($eachRecord['packing'] == 'Incomplete' OR $eachRecord['packing'] == 'incomplete'){
													echo "Incom-:";echo $inComp;
												}else{
													echo $eachRecord['packing'];
												}
											?>
										</td>
									 </tr>
									  <?php 
											}
											$k++;
									  }
									  ?>
									</table>
									</div>
									<div class="modal-footer">
									</div>
								</div>
							</div><br><br>
							<!--Pipeline status end-->
														
							
							<!--Stock Details start-->
							<div id="myStock" class="modal1">
								<!-- Modal content -->
								<div class="modal-content">
									<div class="modal-header">
									  <span class="close">&times;</span>
									  <h2>Product Stock Details</h2>
									</div>
									<div class="modal-body" style="font-size:9px;">
										<table class="single-column" cellpadding="0" cellspacing="0">
										<!-- display option -->
										<?php 
										if(count($stockProdDtls) == 0)
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
										<thead>
										  <th width="30%">Colour</th>
										  <th width="30%">Current Stock</th>
										  <th width="30%">Net Sales</th>
										</thead>
									   <?php 
											
										
										$k = 1;
										foreach($stockProdDtls as $eachRecord)
											{
											
											$bgColor 	= $utility->getRowColor($k);
									?>
										<tr align="left"<?php $utility->printRowColor($bgColor);?>>
										<td align="center"><?php echo $eachRecord['colour']; ?></td>
										<td align="center"><?php echo $eachRecord['quantity']; ?></td>
										<td align="center"><?php echo $eachRecord['net_sales']; ?></td>
										
									 </tr>
									  <?php 
											}
											$k++;
									  }
									  ?>
									</table>
									</div>
									<div class="modal-footer">
									  
									</div>
								</div>
							</div><br><br>
							<!--Stock Details end-->
							
							
							
							
							
							
						<!--
							<div class="form-in">
								<a href="#">Add To Cart</a>
							</div>-->
							<a data-text="Moni Enterprises Design <?php echo $sGalleryDetail[2];?>" 
								data-link="http://rjfashion.in/images/spgallery/large/<?php echo $sGalleryDetail[6];?>" class="whatsapp w3_whatsapp_btn w3_whatsapp_btn_large">Share</a> 
							<div class="clearfix"></div><br>
							<a data-text="Rozelle(Moni Enterprises)<?php echo $sGalleryDetail[2];?>" 
								data-link="http://rjfashion.in/samplestock/mep-design.php?sgid=<?php echo $sgid;?>" class="whatsapp w3_whatsapp_btn w3_whatsapp_btn_large">Share all</a> 
								
						</div>
						<div class="share-desc">
							
							<div class="clearfix"></div>
						</div>
							<!--GR Calculate Section start-->
								<li data-toggle="collapse" data-target="#TotalGR" style="color: blue;font-size:16px;">Total GR:
									<?php $productStock->getGrCount($stockDtls[0]); ?>
									<?php $GRDtls 	= $productStock->showTGrProdDtls($stockDtls[0]); ?>
								</li>
								<div id="TotalGR" class="collapse"><!--start Collapse-->
									 <!-- Display Data -->
									<div id="data-column">
										<table class='blue' cellpadding="0" cellspacing="0" id="table-1">
											<thead>
											  <th align="center" width="25%">Party</th>
											  <th align="center" width="25%">Quantity</th>
											  <th align="center" width="25%">Date</th>
											</thead>  
											<?php
												foreach($GRDtls as $eachRecord)
													{
														$edate		= date_create($eachRecord['added_on']);
														$tRG 		= $eachRecord['SUM(greturn)'] + $eachRecord['SUM(ready_gd)'];
												?>	
												<tr>
													<td align="center"><?php echo $eachRecord['party_code']; ?></td>
													<td align="center"><?php echo $tRG; ?></td>
													<td align="center"><?php echo date_format($edate,"d-M-y");?></td>	
												</tr>
											
											<?php	
												}//end foreachloop
											?>	
										</table>
									</div>
									<!-- end Display Data -->
								</div><!--end Collapse-->
								<!--GR Calculate Section end-->
					</div>
			   	</div><!-- Product Description start-->
          	    <div class="clearfix"></div>
          	</div>
			  <!-- Single grid end--> 
			
			<h3>Design No:<?php echo $sGalleryDetail[2];?> Alternative Colour</h3>	<br>
			<!----- Same design product box---->
			<div class="product_box1"> 
				<?php
					foreach($sGalleryDtls as $eachRecord)
                        {
				?>
						<div class="col-md-4 grid-4" grid-in>
							<a href="gproducts-details.php?sgid=<?php echo $eachRecord['sample_gallery_id']; ?>" >
								<img src="../images/spgallery/large/<?php echo $eachRecord['image'];?>" class="img-responsive" alt="">
							</a>
						
							<div class="tab_desc1">
								<h3><a href="#"><?php echo $eachRecord['design_no'];?></a></h3>
								<p><?php echo $eachRecord['dcolor'];?></p>
								<!--<a href="#" class="to-cart"><span>Add To Cart</span><img src="images/plus.png" alt=""></a>-->
						   </div>
					   </div>
				
				<?php
				}
				?>

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
	/*	// Get the modal
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
		}*/
	</script>
	
	
</body>
</html>