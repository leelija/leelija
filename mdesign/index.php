<?php 
ini_set('session.cookie_lifetime', 60 * 60 * 2400);
ini_set('session.gc_maxlifetime', 60 * 60 * 2400);
//maybe you want to precise the save path as well
session_start();
//include_once('checkSession.php');
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
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Check Design Status</title>
	
	<!-- Included Bootstrap CSS Files -->
	<link rel="stylesheet" href="./js/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="./js/bootstrap/css/bootstrap-responsive.min.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	
	<!-- Css -->	
	<link rel="stylesheet" href="css/style.css" />
	<link href="css/cust.css" rel="stylesheet" type="text/css" media="all" />
	<!--<link href="../samplestock/css/style.css" rel="stylesheet" type="text/css" media="all" />	-->
	<link href="../samplestock/css/modal.css" rel="stylesheet" type="text/css" media="all" />	
	
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
	
	
	
</head>
<body>
		<?php require_once('header.inc.php'); ?>
		<div class="container"><!--Start Container-->
			<div class="row">
				<div class="span12">
					<div id="keep-up-date">
						<h1>Check Design Status</h1>
						<br />
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form form-inline">
		  						<input placeholder="Search with your Design No.." class="input-xxlarge" id="appendedInputButton" name="txtDesign" type="text">
		 						<button class="btn-large btn btn-warning" name="txtBtn" type="submit">Search&nbsp;<i class="icon-chevron-right icon-white"></i></button>
						</form>
						
						<?php
							//add a product
							if(isset($_POST['txtBtn']))
							{	
								$txtDesign	 	= $_POST['txtDesign'];
								
								//Sample Gallery Data
								$sGalleryDetail 		= $photogallery->showSampleGalleryDgn($txtDesign);
								// Sample Gallery All Data Design wise
								$sGalleryDtls 			= $photogallery->sPhotoAllDesiData($txtDesign);
								$factoryDtls 			= $sample->showFactory($sGalleryDetail[1]);
								//Sample Gallery Details data 
								//$sGDtlsData 			= $photogallery->sPhotoDtlsAllData($sgid);
								$stockDtls				= $productStock->showPStockDesignwise($txtDesign);
								$stockDtlsDetails 		= $productStock->showPStockDetailsdescolorwise($sGalleryDetail[2],$sGalleryDetail[13]);
								//Stock Product details
								//$stockProdDtls 			= $productStock->ProdstockDtl($txtDesign);
								$stockProdDtls 			= $productStock->stockPDtlNetColor($stockDtls[0]);
								$prodSaleskDtls 		= $productStock->stockPSaleDesShow($txtDesign);
								
								// Due Order Display
								$dueOrdDtls 			= $productOrder->getDueOrd($txtDesign);
								
								$dueOrdColourWise 		= $productOrder->getDueOrdColourWise($txtDesign);

								
								// Pipe line status all data
								$statusData 			= $prodStatus->statusAllData($txtDesign);

						?>	
							<!-- Product image Details Start-->
							<div class="grid images_3_of_2">
									<ul class="stockDtl">
										<?php if(count($stockDtls) == 0){
										
										?>
										<li>Current Stock: 0
										</li>
										<li>Total Sale: 0
										</li>
										<?php
										}else{
										?>
										<li data-toggle="collapse" data-target="#currStock" style="color: blue;font-size:16px;">Current Stock:
											<span style="color: black;"><?php echo $stockDtls[2];?></span>
										
										<div id="currStock" class="collapse"><!--start Collapse-->
											 <!-- Display Data -->
											<div id="data-column">
												<table class='blue' cellpadding="0" cellspacing="0" id="table-1">
													<thead>
													  <th width="30%">Colour</th>
													  <th width="30%">Current Stock</th>
													  <th width="30%">Net Sales</th>
													</thead>  
													<?php
														foreach($stockProdDtls as $eachRecord)
															{
														?>	
														<tr>
															<td align="center"><?php echo $eachRecord['colour']; ?></td>
															<td align="center"><?php echo $eachRecord['quantity']; ?></td>
															<td align="center"><?php echo $eachRecord['net_sales']; ?></td>
														</tr>
													
													<?php	
														}//end foreachloop
													?>	
												</table>
											</div>
											<!-- end Display Data -->
										</div><!--end Collapse-->
										
										</li>
										
										<li data-toggle="collapse" data-target="#demo" style="color: blue;font-size:16px;">Total Sale:
											<span style="color: black;"><?php echo $stockDtls[12];?></span>
										</li>
										
										<!--Order Due Section start-->
										<li data-toggle="collapse" data-target="#ordDtls" style="color: blue;font-size:16px;">Due Order:
											<span style="color: black;"><?php $productOrder->dueOrdCount($txtDesign); ?></span>
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
										
										<?php
										}
										?>
										
									</ul>
									
								<!--Pipeline status start-->
								<!-- Trigger/Open The Modal -->
								<button id="myBtn">Pipe Line Status</button>
								<!-- The PipeLine Modal -->
								<div id="myModal" class="modal">
									<!-- Modal content -->
									<div class="modal-content" style="color:#000;">
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
											<thead >
											  <th align="center" width="2%" >S.No</th>
											  <th align="center" width="3%" >ord.Id </th>
											  <th align="center" width="5%">Design</th>
											   <th align="center" width="5%">Order By </th>
											  <th width="10%"  >Ord.Date </th>
											  <th width="10%" >Trd.Date</th>
											  <th width="5%" >R.day</th>
											  <th width="5%" >Qty</th>
											  <th width="7%"  >Dyeing</th>
											  <th width="7%"  >Hand </th>
											  <th width="7%" >Manual</th>
											  <th width="7%" >Computer</th>
											  <th width="7%" >K.Cutting</th>
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
												foreach($ordDtlsCnt as $eachQty)
													{
														$inComp 	= $eachQty['SUM(quantity)'] - $eachQty['SUM(ready_quantity)']; 
													}
												
										?>
											<tr align="left"<?php $utility->printRowColor($bgColor);?>>
											<td align="center"><?php echo $k; ?></td>
											<td align="center"><?php echo $eachRecord['order_id']; ?></td>
											<td align="center"><?php echo $eachRecord['design_no']; ?></td>
											<td align="center"><?php echo $ordDtls[2]; ?></td>
											<td align="center"><?php echo $orderDate; ?></td>
											<td align="center"><?php echo $targetDate; ?></td>
										   <?php
											$date1=date_create($eachRecord['target_date']);
											$date2=date_create(date("Y-m-d"));
											$diff=date_diff($date2,$date1);
											
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
											<td align="center"><?php echo $eachRecord['hand']; ?></td>
											<td align="center"><?php echo $eachRecord['manual']; ?></td>
											<td align="center"><?php echo $eachRecord['computer']; ?></td>
											<td align="center"><?php echo $eachRecord['kcutting']; ?></td>
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
										
									
									
									
									<ul id="etalage">
										<li>
											<a href="#">
												<img class="etalage_thumb_image img-responsive" src="../images/spgallery/large/<?php echo $sGalleryDetail[6];?>" alt="" >
											</a>
										</li>
									</ul>
									 <div class="clearfix"> </div>		
							</div> 
							  <!-- Product image Details end-->
							
							<a data-text="Moni Enterprises Design <?php echo $sGalleryDetail[2];?>" 
							data-link="http://rjfashion.in/images/spgallery/large/<?php echo $sGalleryDetail[6];?>" class="whatsapp w3_whatsapp_btn w3_whatsapp_btn_large">Share</a> 
							<br><br>
							
							
						<?php
								
							}//end of if isset
						?>
					</div>
				</div>
			</div>
		</div><!-- End Container--->	
		
		
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
		
	<div id="socials-bar">
	</div>
	<script src="./js/jquery-1.10.0.min.js"></script>
	<script src="./js/bootstrap/js/bootstrap.min.js"></script>
	<script src="./js/script.js"></script>
</body>
</html>