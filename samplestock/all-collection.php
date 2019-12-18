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
require_once("../classes/stock.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/adv_search.class.php");
require_once("../classes/photo_gallery.class.php");
require_once("../classes/product_order.class.php");
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

?>


<!DOCTYPE html>
<html>
<head>
<title>RJ Fashion Sample Collection</title>
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
				<?php
					// Pipe line status all data
					$mOrdData 			= $orders->getOrdFactWise(1);
					$MpvtData 			= $orders->getOrdFactWise(8);
					$hOrdData 			= $orders->getOrdFactWise(2);
					$mPipeQuantity	= 0;
					foreach($mOrdData as $eachRow)
						{
							//Order Details
							$orderDtl 		= $orders->getOrderQuantitycount($eachRow['orders_id']);
							foreach($orderDtl as $eachRowf)
								{
									$pipeOrdQty		= $eachRowf['SUM(quantity)'];
									$mPipeQuantity	+= $pipeOrdQty;
								}
						}
					foreach($MpvtData as $eachRow)
						{
							//Order Details
							$orderDtl 		= $orders->getOrderQuantitycount($eachRow['orders_id']);
							foreach($orderDtl as $eachRowf)
								{
									$pipeOrdQty		= $eachRowf['SUM(quantity)'];
									$mpvtPipeQuantity	+= $pipeOrdQty;
								}
						}	
					$hPipeQuantity	= 0;	
					foreach($hOrdData as $heachRow)
						{
							//Order Details
							$orderDtl 		= $orders->getOrderQuantitycount($heachRow['orders_id']);
							foreach($orderDtl as $eachRowh)
								{
									$pipeOrdQty		= $eachRowh['SUM(quantity)'];
									$hPipeQuantity	+= $pipeOrdQty;
								}
						}	
				?>						
				
				<h2 id="myBtn">Total stock:<span style="color:blue;"><?php  $productStock->CurrentProdstockSum();?></span></h2>
				<div class="available">
					<ul>
						<li>
							MDW Pvt stock:<span style="color:blue;"><?php  $productStock->factoryWiseStock(1,8);?></span>
						</li>
						<li>
							HMDA stock:<span style="color:blue;"><?php  $productStock->factoryWiseStock(2,'');?></span>
						</li>
						<li>
							MEP Due Order:<span style="color:blue;">
								<?php  
									$MOrdDtls 	= $productOrder->getFacWiseOrdDtls(1);
									$MdueQuantity 	= 0;
									foreach($MOrdDtls as $eachRecord)
									{
										$ordId 			= $eachRecord['orders_id'];
										$ordDtls 		= $productOrder->ProdordersDtlDisp($ordId);
										foreach($ordDtls as $eachRow)
										{
											$MdueQuantity 		+= $eachRow['due_quantity'];
										}
									}
									echo $MdueQuantity;
								?>
							</span>
						</li>
						<li>
							MDW Pvt Due Order:<span style="color:blue;">
								<?php  
									$MOrdDtls 	= $productOrder->getFacWiseOrdDtls(8);
									$MpvtdueQuantity 	= 0;
									foreach($MOrdDtls as $eachRecord)
									{
										$ordId 			= $eachRecord['orders_id'];
										$ordDtls 		= $productOrder->ProdordersDtlDisp($ordId);
										foreach($ordDtls as $eachRow)
										{
											$MpvtdueQuantity 		+= $eachRow['due_quantity'];
										}
									}
									echo $MpvtdueQuantity;
								?>
							</span>
						</li>
						<li>
							HMDA Due Order:<span style="color:blue;">
								<?php  
									$fOrdDtls 	= $productOrder->getFacWiseOrdDtls(2);
									$dueQuantity 	= 0;
									foreach($fOrdDtls as $eachRecord)
									{
										$ordId 			= $eachRecord['orders_id'];
										//echo $ordId;echo '-';
										$HordDtls 		= $productOrder->ProdordersDtlDisp($eachRecord['orders_id']);
										
										foreach($HordDtls as $eachRow)
										{
											$dueQuantity 		+= $eachRow['due_quantity'];
											//echo $eachRow['due_quantity'];echo '-';
										}
									}
									echo $dueQuantity;
								?>
							</span>
						</li>
						<li>
							MDW Pvt PipeLine:<span style="color:blue;"><?php $tmdata = $mPipeQuantity + $mpvtPipeQuantity; echo $tmdata;?></span>
						</li>
						<li>
							HMDA PipeLine:<span style="color:blue;"><?php  echo $hPipeQuantity;?></span>
						</li>
					</ul>
				</div>		
				<!-- The Modal -->
				<div id="myModal" class="modal">
				  <!-- Modal content -->
					<div class="modal-content" id="PrintForm">
					<span class="close">&times;</span>
					
						<div id="boardsTable">
						  <table id="examplew" class="table table-bordered table-striped">
							<thead>
								<tr >
								  <th >Sl No</th>
								  <th >Design No</th>
								  <th>Current Quantity</th>
								</tr>
							</thead>
							
							<tbody>
								<?php
									if(count($prodCount) !=0){
									$sl = 1;
									foreach($prodCount as $eachRecord)
									{
								?>
								<tr align="left">
								  <td><?php echo $sl;?></td>
								  <td><?php echo $eachRecord['design_no'];?></td>
								  <td><?php echo $eachRecord['stock'];?></td>
								</tr>
								<?php
									$sl++;	
								}
								}
								else{
						
								}
								?>	
							</tbody>		
							</table>	
						</div>
						<a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a> 
					</div><!-- end Modal content -->
					
				</div>
				<!-- end The Modal -->
				
     			<div class="mens-toolbar">
                <div class="sort">
					<form name="formAdvSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="sort-by">
						<label>Sort by</label>
							<select name="type" id="type">
								<option value="design_no">Design No.</option>
								<option value="pprices">Price</option>
								<option value="factory_id">Factory</option>
								<option value="added_on">Date</option>
							</select>
							<input name="keyword" type="hidden" value="" />
							<input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="sort" />
							<!--<input type="submit" src="images/arrow2.gif" alt="Submit" name="btnSearch" >
							<a href=""><img src="images/arrow2.gif" alt="" class="v-middle"></a>-->
						</div>
					</form>	
    		    </div>
    		    <div class="pages">   
        	      <div class="limiter visible-desktop">
	               <label>Total Images<?php //echo count($pgid);?></label>
	              </div>
					<ul class="dc_pagination dc_paginationA dc_paginationA06">
					  <?php //echo $pagination ?>
		       		</ul>
		  	      <div class="clearfix"></div>
		  	    </div>
                <div class="clearfix"></div>		
		        </div>
				
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#MDesign">Moni Design</a></li>
					<li><a data-toggle="tab" href="#HMDADESIGN">HMDA Design</a></li>
					<li><a data-toggle="tab" href="#HOrder">Top Order</a></li>
					<li><a data-toggle="tab" href="#Hstock">Highest Stock </a></li>
				</ul>
				<div class="tab-content"><!--Start tab-->
					<div id="MDesign" class="tab-pane fade in active"><!--end MoniDesign-->
						<!---->
						<div class="product_box1">   
						<?php 
							$mDesDtls	= $photogallery->sPhotoAllDataFwise(1);
							if(count($mDesDtls) == 0)
							{
							?>
							<tr align="left" class="orangeLetter">
							  <td height="20" colspan="5">  <?php echo "Image Not Found..."; ?> </td>
							</tr>
							<?php 
							}
							else
							{
							  // $k = $pages->getPageSerialNum($numResDisplay);
							  // $pgid = array_slice($pgid, $start, $limit);     
								foreach($mDesDtls as $mrecord)
									{
									//$x = $pageArray[$pageNumber][$j];
									
									//$sphotoGalleryDetail 	= $photogallery->showSamplePGallery($x);
									$stockDtls				= $productStock->showPStockDesignwise($mrecord['design_no']);
									//$stockDtlsDetails 		= $productStock->showStockDetailsdescolorwise($sphotoGalleryDetail[2],$sphotoGalleryDetail[13]);
							?>
								<div class="col-md-4 grid-4" grid-in>
									<a target="null" href="gproducts-details.php?sgid=<?php echo $mrecord['sample_gallery_id']; ?>" >
										<img src="../images/spgallery/large/<?php echo $mrecord['image'];?>" class="img-responsive" alt="">
									</a>
								
									<div class="tab_desc1">
										<h3><a href="#"><?php echo $mrecord['design_no'];?></a>(<?php if(count($stockDtls) == 0){ echo "0";}
										else {echo $stockDtls[2];}?>)</h3>
										<p><?php echo $mrecord['title'];?></p>
										<p><?php echo $mrecord['pprices'];?></p>
										<!--<a href="#" class="to-cart"><span>Add To Cart</span><img src="images/plus.png" alt=""></a>-->
								   </div>
							   </div>
						  <?php 
							   
								}
						  }
						  ?>
						
						  <div class="clearfix"></div>
						</div>
					</div><!--end MoniDesign-->
					
					<div id="HMDADESIGN" class="tab-pane fade"><!--Start HMDADesign-->
											<!---->
						<div class="product_box1">   
						<?php 
							$mDesDtls	= $photogallery->sPhotoAllDataFwise(2);
							if(count($mDesDtls) == 0)
							{
							?>
							<tr align="left" class="orangeLetter">
							  <td height="20" colspan="5">  <?php echo "Image Not Found..."; ?> </td>
							</tr>
							<?php 
							}
							else
							{
							  // $k = $pages->getPageSerialNum($numResDisplay);
							  // $pgid = array_slice($pgid, $start, $limit);     
								foreach($mDesDtls as $mrecord)
									{
									//$x = $pageArray[$pageNumber][$j];
									
									//$sphotoGalleryDetail 	= $photogallery->showSamplePGallery($x);
									$stockDtls				= $productStock->showPStockDesignwise($mrecord['design_no']);
									//$stockDtlsDetails 		= $productStock->showStockDetailsdescolorwise($sphotoGalleryDetail[2],$sphotoGalleryDetail[13]);
							?>
								<div class="col-md-4 grid-4" grid-in>
									<a target="null" href="gproducts-details.php?sgid=<?php echo $mrecord['sample_gallery_id']; ?>" >
										<img src="../images/spgallery/large/<?php echo $mrecord['image'];?>" class="img-responsive" alt="">
									</a>
								
									<div class="tab_desc1">
										<h3><a href="#"><?php echo $mrecord['design_no'];?></a>(<?php if(count($stockDtls) == 0){ echo "0";}
										else {echo $stockDtls[2];}?>)</h3>
										<p><?php echo $mrecord['title'];?></p>
										<p><?php echo $mrecord['pprices'];?></p>
										<!--<a href="#" class="to-cart"><span>Add To Cart</span><img src="images/plus.png" alt=""></a>-->
								   </div>
							   </div>
						  <?php 
							   
								}
						  }
						  ?>
						
						  <div class="clearfix"></div>
						</div>
					</div><!--end HMDA-->
					<div id="HOrder" class="tab-pane fade"><!--Start Top Order-->
					<?php	$tOrderDtls = $productOrder->getTwoMOnthOrder();?>
						<!---->
						<div class="product_box1">   
						<?php 
							if(count($tOrderDtls) == 0)
							{
							?>
							<tr align="left" class="orangeLetter">
							  <td height="20" colspan="5">  <?php echo "Image Not Found..."; ?> </td>
							</tr>
							<?php 
							}
							else
							{
							  // $k = $pages->getPageSerialNum($numResDisplay);
							  // $pgid = array_slice($pgid, $start, $limit);     
								foreach($tOrderDtls as $eachRow)
									{
									//$x = $pageArray[$pageNumber][$j];
									//$stockDtls				= $productStock->showPStockDesignwise($sGalleryDetail[2]);
									$sphotoGalleryDetail 	= $photogallery->showSampleGalleryDgn($eachRow['design_no']);
									$stockDtls				= $productStock->showPStockDesignwise($sphotoGalleryDetail[2]);
									//$stockDtlsDetails 		= $productStock->showStockDetailsdescolorwise($sphotoGalleryDetail[2],$sphotoGalleryDetail[13]);
									
									// Pipe line status all data
									$statusData 			= $prodStatus->statusAllData($eachRow['design_no']);
									$tOrdQuantity	= 0;
									foreach($statusData as $eachRowp)
										{
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRowp['order_id']);
											foreach($orderDtl as $eachRowff)
												{
													$pipeOrdQty		= $eachRowff['SUM(quantity)'];
													$tOrdQuantity	+= $pipeOrdQty;
												}
										}
							
							?>
								<div class="col-md-4 grid-4" grid-in>
									<a target="null" href="gproducts-details.php?sgid=<?php echo $sphotoGalleryDetail[0]; ?>" >
										<img src="../images/spgallery/large/<?php echo $sphotoGalleryDetail[6];?>" class="img-responsive" alt="">
									</a>
								
									<div class="tab_desc1">
										<h3><a href="#"><?php echo $sphotoGalleryDetail[2];?></a>(<?php if(count($stockDtls) == 0){ echo "0";}
										else {echo $stockDtls[2];}?>)</h3>
										<p>Due Order-><?php echo $eachRow['SUM(due_quantity)'];?><br>
										Net Sales-><?php echo $stockDtls[12];?><br>
										Total GR-><?php $productStock->getGrCount($stockDtls[0]); ?>
										
										</p>
										<p>PipeLine-><?php echo $tOrdQuantity;?></p>
										<p><?php echo $sphotoGalleryDetail[3];?></p>
										<p><?php echo $sphotoGalleryDetail[4];?></p>
										<!--<a href="#" class="to-cart"><span>Add To Cart</span><img src="images/plus.png" alt=""></a>-->
								   </div>
							   </div>
						  <?php 
							   
								}
						  }
						  ?>
						
						  <div class="clearfix"></div>
						</div>
					</div><!--end Top Order-->
					
					<div id="Hstock" class="tab-pane fade"><!--Start Highest Stock-->
					<?php	//$tOrderDtls = $productOrder->getTwoMOnthOrder();?>
						<!---->
						<div class="product_box1">   
						<?php 
							if(count($prodCount) == 0)
							{
							?>
							<tr align="left" class="orangeLetter">
							  <td height="20" colspan="5">  <?php echo "Image Not Found..."; ?> </td>
							</tr>
							<?php 
							}
							else
							{
							  // $k = $pages->getPageSerialNum($numResDisplay);
							  // $pgid = array_slice($pgid, $start, $limit);     
								foreach($prodCount as $eachRow)
									{
									//$x = $pageArray[$pageNumber][$j];
									//$stockDtls				= $productStock->showPStockDesignwise($sGalleryDetail[2]);
									$sphotoGalleryDetail 	= $photogallery->showSampleGalleryDgn($eachRow['design_no']);
									$stockDtls				= $productStock->showPStockDesignwise($sphotoGalleryDetail[2]);
									//$stockDtlsDetails 		= $productStock->showStockDetailsdescolorwise($sphotoGalleryDetail[2],$sphotoGalleryDetail[13]);
									
									// Pipe line status all data
									$statusData 			= $prodStatus->statusAllData($eachRow['design_no']);
									$tOrdQuantity	= 0;
									foreach($statusData as $eachRowp)
										{
											//Order Details
											$orderDtl 		= $orders->getOrderQuantitycount($eachRowp['order_id']);
											foreach($orderDtl as $eachRowff)
												{
													$pipeOrdQty		= $eachRowff['SUM(quantity)'];
													$tOrdQuantity	+= $pipeOrdQty;
												}
										}
							
							?>
								<div class="col-md-4 grid-4" grid-in>
									<a target="null" href="gproducts-details.php?sgid=<?php echo $sphotoGalleryDetail[0]; ?>" >
										<img src="../images/spgallery/large/<?php echo $sphotoGalleryDetail[6];?>" class="img-responsive" alt="">
									</a>
								
									<div class="tab_desc1">
										<h3><a href="#"><?php echo $sphotoGalleryDetail[2];?></a>(<?php if(count($stockDtls) == 0){ echo "0";}
										else {echo $stockDtls[2];}?>)</h3>
										<p>Due Order-><?php $productOrder->dueOrdCount($sphotoGalleryDetail[2]);?><br>
										Net Sales-><?php echo $stockDtls[12];?><br>
										Total GR-><?php $productStock->getGrCount($stockDtls[0]); ?>
										
										</p>
										<p>PipeLine-><?php echo $tOrdQuantity;?></p>
										<p><?php echo $sphotoGalleryDetail[3];?></p>
										<p><?php echo $sphotoGalleryDetail[4];?></p>
										<!--<a href="#" class="to-cart"><span>Add To Cart</span><img src="images/plus.png" alt=""></a>-->
								   </div>
							   </div>
						  <?php 
							   
								}
						  }
						  ?>
						
						  <div class="clearfix"></div>
						</div>
					</div><!--end Highest Stock-->
					
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