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
require_once("../classes/stock.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/adv_search.class.php");
require_once("../classes/photo_gallery.class.php");
require_once("../classes/product_order.class.php");
require_once("../classes/company.class.php"); 
require_once("../classes/vendor.class.php"); 
require_once("../classes/supplier.class.php"); 
require_once("../classes/party.class.php"); 

require_once("../classes/product_stock.class.php"); 
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
$company		= new Company();
$vendor			= new Vendor();
$supplier		= new Supplier();
$party			= new Party();

$search_obj		= new Search();
$pages			= new Pagination();
$photogallery	= new PhotoGAllery();
$stock			= new Stock();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$keyword		= $utility->returnGetVar('keyword','');
$type			= $utility->returnGetVar('type','');
$mode			= $utility->returnGetVar('mode','');

// Product stock all data display
$prodDtls 		= $productStock->getpStock();

$prodCount 		= $productStock->ProdDesWiseCount();

$upComingSample = $photogallery->sUpcomingData();

// all sample gallery details
$spGalleryLatest 	= $photogallery->sPhotoLatestData();

// Account Details
$cmpDtls		= $company->getCompAccData();
$partyDtls 		= $party->partyBalanceDtls();
$suppDtls 		= $supplier->getSupplierBlncData();
$vendDtls		= $vendor->getVendorBlncData();

?>


<!DOCTYPE html>
<html>
<head>
<title>Account Report</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Custom Theme files -->
<!--theme-style-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	
<link href="css/modal.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--fonts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
<!--//fonts-->
</head>
<body> 
	<!--header Start-->
		<?php require_once('header.inc.php'); ?>
	<!--header end-->
	<!--content-->
	<div class="content">
		<div class="container">
				 
		<!---->
		<div class="products_top">
     	
     		<div class="col-md-9 price-on">
			<!---->
				
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#CmpAccount">Company Account</a></li>
					<li><a data-toggle="tab" href="#PartAcc">Party Account</a></li>
					<li><a data-toggle="tab" href="#suppAcc">Supplier Account</a></li>
					<li><a data-toggle="tab" href="#vendAcc">Vendor Account</a></li>
				</ul>
				<div class="tab-content"><!--Start tab-->
					<div id="CmpAccount" class="tab-pane fade in active"><!--Start Company Account-->
						<!---->
						<div class="product_box1">  
								<!-- Display Data -->
								<div id="data-column">
									<table cellpadding="1" cellspacing="1" id="table-1" class="table table-bordered table-striped">
										<thead>
											<th align="center" width="25%">Acc Name</th>
											<th align="center" width="25%">Bank</th>
											<th align="center" width="25%">Balance</th>
											<th align="center" width="25%">Purchase GST</th>
											<th align="center" width="25%">Sales GST</th>
										</thead>  
										<?php
											foreach($cmpDtls as $eachRecord)
												{
												
												$purchGST 	= $eachRecord['in_sgst'] + $eachRecord['in_cgst'] + $eachRecord['in_igst'];
												$salesGST 	= $eachRecord['out_sgst'] + $eachRecord['out_cgst'] + $eachRecord['out_igst'];
											?>	
												<tr>
													<td align="center"><?php echo $eachRecord['account_name']; ?></td>
													<td align="center"><?php echo $eachRecord['bank']; ?></td>
													<td align="center"><?php echo $eachRecord['balance']; ?></td>
													<td align="center"><?php echo $purchGST; ?></td>	
													<td align="center"><?php echo $salesGST; ?></td>	
												</tr>
											
										<?php	
											}//end foreachloop
										?>	
									</table>
								</div>
								<!-- end Display Data -->
							<div class="clearfix"></div>
						</div>
					</div><!--end Company Account-->
					
					<div id="PartAcc" class="tab-pane fade"><!--Start Party Acc-->
						<div class="product_box1">
							<!-- Display Data -->
								<div id="data-column">
									<table cellpadding="1" cellspacing="1" id="table-1" class="table table-bordered table-striped">
										<thead>
											<th align="center" width="25%">Name</th>
											<th align="center" width="25%">Company</th>
											<th align="center" width="25%">Address</th>
											<th align="center" width="25%">Due Balance</th>
										</thead>  
										<?php
											foreach($partyDtls as $eachRecord)
												{
											
											?>	
												<tr>
													<td align="center"><?php echo $eachRecord['party_name']; ?></td>
													<td align="center"><?php echo $eachRecord['company']; ?></td>
													<td align="center"><?php echo $eachRecord['party_city']; ?></td>
													<td align="center"><?php echo $eachRecord['payment_due']; ?></td>	
												</tr>
											
										<?php	
											}//end foreachloop
										?>	
									</table>
								</div>
								<!-- end Display Data -->
						
						  <div class="clearfix"></div>
						</div>
					</div><!--end PArty Acc-->
					
					<div id="suppAcc" class="tab-pane fade"><!--Start Top Order-->
						<div class="product_box1">  
							<!-- Display Data -->
								<div id="data-column">
									<table cellpadding="1" cellspacing="1" id="table-1" class="table table-bordered table-striped">
										<thead>
											<th align="center" width="25%">Name</th>
											<th align="center" width="25%">Company</th>
											<th align="center" width="25%">Address</th>
											<th align="center" width="25%">Due Balance</th>
										</thead>  
										<?php
											foreach($suppDtls as $eachRecord)
												{
											
											?>	
												<tr>
													<td align="center"><?php echo $eachRecord['supplier_name']; ?></td>
													<td align="center"><?php echo $eachRecord['scompany']; ?></td>
													<td align="center"><?php echo $eachRecord['supplier_address']; ?></td>
													<td align="center"><?php echo $eachRecord['sbalance']; ?></td>	
												</tr>
											
										<?php	
											}//end foreachloop
										?>	
									</table>
								</div>
								<!-- end Display Data -->
						</div>
						
						<div class="clearfix"></div>
					</div>
					<div id="vendAcc" class="tab-pane fade"><!--Start Top Order-->
						<div class="product_box1">  
							<!-- Display Data -->
								<div id="data-column">
									<table cellpadding="1" cellspacing="1" id="table-1" class="table table-bordered table-striped">
										<thead>
											<th align="center" width="25%">Name</th>
											<th align="center" width="25%">Company</th>
											<th align="center" width="25%">Address</th>
											<th align="center" width="25%">Due Balance</th>
										</thead>  
										<?php
											foreach($vendDtls as $eachRecord)
												{
											
											?>	
												<tr>
													<td align="center"><?php echo $eachRecord['vendor_name']; ?></td>
													<td align="center"><?php echo $eachRecord['vcompany']; ?></td>
													<td align="center"><?php echo $eachRecord['vendor_address']; ?></td>
													<td align="center"><?php echo $eachRecord['vbalance']; ?></td>	
												</tr>
											
										<?php	
											}//end foreachloop
										?>	
									</table>
								</div>
								<!-- end Display Data -->
						</div>
						
						<div class="clearfix"></div>
					</div>
				</div><!--end Top Order-->
					
			</div><!--end tab-->
			  <!---->
			  <div class="pages">   
        	    
		  	   </div>
			   
			   <!---->
     		</div>
			
			<!---Right Div Start-->
     		<div class="col-md-3 product_right">
				<!---Up Coming Sample Div Start-->
				<h3 class="m_1">Top Selling Products</h3>
				<div class="sale_grid">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#home">All</a></li>
						<li><a data-toggle="tab" href="#menu1">MEP</a></li>
						<li><a data-toggle="tab" href="#menu2">HMDA</a></li>
						<li><a data-toggle="tab" href="#menu3">L.Month</a></li>
					</ul>
					<div class="tab-content"><!--Start tab-->
						<div id="home" class="tab-pane fade in active"><!--start home-->
						  <?php 
							if(count($prodDtls) == 0)
							{
							?>
							<tr align="left" class="orangeLetter">
							  <td height="20" colspan="5">  <?php echo "Image Not Found..."; ?> </td>
							</tr>
							<?php 
							}
							else
							{  
								
								foreach($prodDtls as $eachRecord)
									{
									$photoGallDtls 			= $photogallery->showSampleGalleryDgn($eachRecord['design_no']);
									// Pipe line status all data
									$statusData 			= $prodStatus->statusAllData($eachRecord['design_no']);
									$tOrdQuantity	= 0;
									foreach($statusData as $eachRow)
										{
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRow['order_id']);
											foreach($orderDtl as $eachRowf)
												{
													$pipeOrdQty		= $eachRowf['SUM(quantity)'];
													$tOrdQuantity	+= $pipeOrdQty;
												}
										}
									
									
							?>
										<ul class="grid_1">
											<li class="grid_1-img">
												<a href="gproducts-details.php?sgid=<?php echo $photoGallDtls[0]; ?>" >
													<img src="../images/spgallery/large/<?php echo $photoGallDtls[6];?>" class="img-responsive" alt="">
												</a>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#"><?php echo $eachRecord['design_no'];?>(<?php echo $eachRecord['net_sales'];?>)</a></h4>
											  <p><?php echo $photoGallDtls[3];?></p>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#">Due Order:(<?php $productOrder->dueOrdCount($eachRecord['design_no']); ?>)</a></h4>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#">PipeLine:(<?php echo $tOrdQuantity?>)</a></h4>
											</li>
											<div class="clearfix"> </div>
										</ul>
						  <?php 
							   
									}
							}
						  ?>
						</div><!--end home--> 
						<div id="menu1" class="tab-pane fade">
							<?php 
							$MepprodDtls 		= $productStock->getFactTopStock(1);
							if(count($MepprodDtls) == 0)
							{
							?>
							<tr align="left" class="orangeLetter">
							  <td height="20" colspan="5">  <?php echo "Image Not Found..."; ?> </td>
							</tr>
							<?php 
							}
							else
							{  
								foreach($MepprodDtls as $eachRecord)
									{
									$photoGallDtls 			= $photogallery->showSampleGalleryDgn($eachRecord['design_no']);
									
									// Pipe line status all data
									$statusData 			= $prodStatus->statusAllData($eachRecord['design_no']);
									$tOrdQuantity	= 0;
									foreach($statusData as $eachRow)
										{
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRow['order_id']);
											foreach($orderDtl as $eachRowf)
												{
													$pipeOrdQty		= $eachRowf['SUM(quantity)'];
													$tOrdQuantity	+= $pipeOrdQty;
												}
										}
									
									
							?>
										<ul class="grid_1">
											<li class="grid_1-img">
												<a href="gproducts-details.php?sgid=<?php echo $photoGallDtls[0]; ?>" >
													<img src="../images/spgallery/large/<?php echo $photoGallDtls[6];?>" class="img-responsive" alt="">
												</a>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#"><?php echo $eachRecord['design_no'];?>(<?php echo $eachRecord['net_sales'];?>)</a></h4>
											  <p><?php echo $photoGallDtls[3];?></p>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#">Due Order:(<?php $productOrder->dueOrdCount($eachRecord['design_no']); ?>)</a></h4>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#">PipeLine:(<?php echo $tOrdQuantity?>)</a></h4>
											</li>
											
											<div class="clearfix"> </div>
										</ul>
						  <?php 
							   
									}
							}
						  ?>
						</div>
						<div id="menu2" class="tab-pane fade">
							<?php 
							$HMDAprodDtls 		= $productStock->getFactTopStock(2);
							if(count($HMDAprodDtls) == 0)
							{
							?>
							<tr align="left" class="orangeLetter">
							  <td height="20" colspan="5">  <?php echo "Image Not Found..."; ?> </td>
							</tr>
							<?php 
							}
							else
							{  
								foreach($HMDAprodDtls as $eachRecord)
									{
									$photoGallDtls 			= $photogallery->showSampleGalleryDgn($eachRecord['design_no']);
									
									// Pipe line status all data
									$statusData 			= $prodStatus->statusAllData($eachRecord['design_no']);
									$tOrdQuantity	= 0;
									foreach($statusData as $eachRow)
										{
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRow['order_id']);
											foreach($orderDtl as $eachRowf)
												{
													$pipeOrdQty		= $eachRowf['SUM(quantity)'];
													$tOrdQuantity	+= $pipeOrdQty;
												}
										}
									
							?>
										<ul class="grid_1">
											<li class="grid_1-img">
												<a href="gproducts-details.php?sgid=<?php echo $photoGallDtls[0]; ?>" >
													<img src="../images/spgallery/large/<?php echo $photoGallDtls[6];?>" class="img-responsive" alt="">
												</a>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#"><?php echo $eachRecord['design_no'];?>(<?php echo $eachRecord['net_sales'];?>)</a></h4>
											  <p><?php echo $photoGallDtls[3];?></p>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#">Due Order:(<?php $productOrder->dueOrdCount($eachRecord['design_no']); ?>)</a></h4>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#">PipeLine:(<?php echo $tOrdQuantity?>)</a></h4>
											</li>
											
											<div class="clearfix"> </div>
										</ul>
						  <?php 
							   
									}
							}
						  ?>
						
						</div><!--end Menu2-->
						
						<div id="menu3" class="tab-pane fade">
							<?php 
							$lastMontTopSale 		= $productStock->getLastMtopSaleData();
							if(count($lastMontTopSale) == 0)
							{
							?>
							<tr align="left" class="orangeLetter">
							  <td height="20" colspan="5">  <?php echo "Image Not Found..."; ?> </td>
							</tr>
							<?php 
							}
							else
							{  
								foreach($lastMontTopSale as $eachRecord)
									{
									//echo $eachRecord['SUM(sales)'];exit;
									$photoGallDtls 			= $photogallery->showSampleGalleryDgn($eachRecord['design_no']);
									// Pipe line status all data
									$statusData 			= $prodStatus->statusAllData($eachRecord['design_no']);
									$tOrdQuantity	= 0;
									foreach($statusData as $eachRow)
										{
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRow['order_id']);
											foreach($orderDtl as $eachRowf)
												{
													$pipeOrdQty		= $eachRowf['SUM(quantity)'];
													$tOrdQuantity	+= $pipeOrdQty;
												}
										}
							?>
										<ul class="grid_1">
											<li class="grid_1-img">
												<a href="gproducts-details.php?sgid=<?php echo $photoGallDtls[0]; ?>" >
													<img src="../images/spgallery/large/<?php echo $photoGallDtls[6];?>" class="img-responsive" alt="">
												</a>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#"><?php echo $eachRecord['design_no'];?>(<?php echo $eachRecord['SUM(sales)']; ?>)</a></h4>
											  <p><?php echo $photoGallDtls[3];?></p>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#">Due Order:(<?php $productOrder->dueOrdCount($eachRecord['design_no']); ?>)</a></h4>
											</li>
											<li class="grid_1-desc">
											  <h4><a href="#">PipeLine:(<?php echo $tOrdQuantity?>)</a></h4>
											</li>
											<div class="clearfix"> </div>
										</ul>
						  <?php 
							   
									}
							}
						  ?>
						
						</div><!--end Menu3-->
						
						
					</div><!--end tab content-->
				</div>
				<!---Up Coming Sample Div End-->
				
				<h3 class="m_1">Latest Products</h3>
			    <div class="sale_grid">
					<?php
					if(count($spGalleryLatest) == 0)
					{
						echo "";
					}
					else{
						foreach($spGalleryLatest as $eachRecord)
                            {
                    ?>
							<ul class="grid_1">
								<li class="grid_1-img">
									<a href="gproducts-details.php?sgid=<?php echo $eachRecord['sample_gallery_id']; ?>" >
										<img src="../images/spgallery/large/<?php echo $eachRecord['image'];?>" class="img-responsive" alt="">
									</a>	
								</li>
								<li class="grid_1-desc">
									<h4><a href="#"><?php echo $eachRecord['design_no'];?></a></h4>
									<p><?php echo $eachRecord['title'];?></p>
								</li>
								<div class="clearfix"> </div>
							</ul>
                  <?php 
							}
						}	
					?>

				</div>
				  <div class="clearfix"> </div>
     		</div>
			<!---Right Div End-->
			<div class="clearfix"> </div>
      </div>
	</div>
	</div>
	<!---->
	<div class="footer">
		<div class="container">
				<div class="footer-class">
				<div class="class-footer">
					<ul>
						<li ><a href="index.html" class="scroll">HOME </a><label>|</label></li>
						<li><a href="men.html" class="scroll">MEN</a><label>|</label></li>
						<li><a href="women.html" class="scroll">WOMEN</a><label>|</label></li>
						<li><a href="collection.html" class="scroll">COLLECTION</a><label>|</label></li>
						<li><a href="collection.html" class="scroll">STORE PRODUCTS</a><label>|</label></li>
						<li><a href="collection.html" class="scroll">LATEST  PRODUCT</a></li>
					</ul>
					 <p class="footer-grid">RJ Fashion </p>
				</div>	 
				<div class="footer-left">
				
				</div> 
				<div class="clearfix"> </div>
			 	</div>
		 </div>
	</div>
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
	
	<!--Used for print-->
	<script type="text/javascript">     
        function PrintDiv() {    
           var PrintForm = document.getElementById('PrintForm');
           var popupWin = window.open('', '_blank', 'width=800,height=800');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + PrintForm.innerHTML + '</html>');
           popupWin.document.close();
                }
    </script>
	<!--end print process-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
</body>
</html>