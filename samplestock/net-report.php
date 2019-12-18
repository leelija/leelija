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
require_once("../classes/product_stock.class.php"); 
require_once("../classes/product_order.class.php");
require_once("../classes/customer.class.php");

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/adv_search.class.php");
require_once("../classes/photo_gallery.class.php");
require_once("../classes/sample.class.php"); 
require_once("../classes/status_cat.class.php");
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
$client		    = new Customer();

$search_obj		= new Search();
$pages			= new Pagination();
$statusCat		= new StatusCat();
$photogallery	= new PhotoGAllery();
$sample			= new Sample();
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
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 300);

if(isset($_POST['txtSubmit']))
	{	
		$txtTime	 				= $_POST['txtTime'];
		$txtFactory	 				= $_POST['txtFactory'];
		$_SESSION['txtTime']		= $txtTime;
		$_SESSION['txtFactory']		= $txtFactory;
	}	

?>


<!DOCTYPE html>
<html>
<head>
<title>Computer Pipeline</title>
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
		<div class="col-md-10">
		
			<form role="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">  
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
									<select name="txtTime" class="form-control input-lg" id="txtTime" required>
										<option value="<?php if(isset($_SESSION['txtTime'])){ echo $_SESSION['txtTime'];}else{}?>"><?php if(isset($_SESSION['txtTime'])){ echo $_SESSION['txtTime'];}else{echo "Select Time";}?></option>
										<option value="1">1 Month</option>
										<option value="2">2 Month</option>
										<option value="3">3 Month</option>
										<option value="4">4 Month</option>
										<option value="5">5 Month</option>
										<option value="6">6 Month</option>
										<option value="7">7 Month</option>
										<option value="8">8 Month</option>
										<option value="9">9 Month</option>
										<option value="10">10 Month</option>
										<option value="11">11 Month</option>
										<option value="12">12 Month</option>
									</select>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
									<select name="txtFactory" class="form-control input-lg" id="txtFactory" required>
										<option value="">Select Factory</option>
										<option value="1">Moni Enterprises</option>
										<option value="8">MDW Pvt Ltd</option>
										<option value="2">HMDA Dyeing</option>
									</select>
							</div>
						</div>
					</div>
					
					<div class="row">
						
						<div class="col-xs-12 col-md-6"><input type="submit" name="txtSubmit" value="Get Report" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
					</div>
				</form>
				<hr class="colorgraph">
			<?php
			if(isset($_POST['txtSubmit']))
					{	
						$txtTime	 				= $_POST['txtTime'];
						$txtFactory	 				= $_POST['txtFactory'];
						$_SESSION['txtTime']		= $txtTime;
						$_SESSION['txtFactory']		= $txtFactory;
			?>
			<!--Pipeline status start-->
			<a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>
			<div id="PrintForm" class="modal-body" style="font-size:9px;">
				<table class="single-column" cellpadding="0" cellspacing="0" border="1">
										<!-- display option -->
										<?php 
											
										$tOrderDtls = $productOrder->getDMonthOrderFact($txtFactory,$txtTime);
										
										if(count($tOrderDtls) == 0)
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
										  <th width="5%" >Sl.No</th>
										  <th width="20%">Design No</th>
										  <th width="5%">Age(Days)</th>
										  <th width="5%">Production</th>
										  <th width="14%">Total Order</th>
										  <th width="6%">Sales</th>
										  <th width="5%">GR</th>
										  <th width="5%">L<?php echo $txtTime;?>M.Production</th>
										  <th width="5%">L<?php echo $txtTime;?>M.Ord</th>
										  <th width="5%">L<?php echo $txtTime;?>M.Sales</th>
										  <th width="5%">L<?php echo $txtTime;?>M.Due.ord</th>
										  <th width="5%">PipeLine</th>
										  <th width="5%">Stock</th>
										  <th width="5%">Rating</th>
										</thead>
									   <?php 

											$sl = 1;
											foreach($tOrderDtls as $eachRecord)
											{
											
											$sphotoGalleryDetail 	= $photogallery->showSampleGalleryDgn($eachRecord['design_no']);
											$stockDtls				= $productStock->showPStockDesignwise($sphotoGalleryDetail[2]);
											$grDtls 				= $productStock->showTGrProd($stockDtls[0]);
											foreach($grDtls as $eachGr)
												{
													$tGr		= $eachGr['SUM(ready_gd)'];
												}	
											$netSales 	= $stockDtls[3] - $tGr;
											
											$date1					=	date_create($sphotoGalleryDetail[9]);
											$date2					=	date_create(date("Y-m-d"));
											$diff					=   date_diff($date1,$date2);
											//$Desage					=   date_diff($datemodif,$date1);
											
											// Pipe line status all data
												$statusData 			= $prodStatus->statusAllData($eachRecord['design_no']);
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
										<tr align="left"<?php //$utility->printRowColor($bgColor);?>>
										<td align="left"><?php echo $sl; ?></td>
										<td align="center"><?php echo $eachRecord['design_no']; ?></td>
										<td align="center"><?php echo $diff->format("%R%a days");  ?></td>
										<td align="center"><?php echo $stockDtls[3]; ?></td>
										<td align="center"><?php $productOrder->tltMothOrd($eachRecord['design_no']);?></td>
										<td align="center"><?php echo $netSales; ?></td>
										<td align="center"><?php $productStock->getGrCount($stockDtls[0]); ?></td>
										
										<td align="center"><?php $productStock->dMonthsProdIn($eachRecord['design_no'],$txtTime); ?></td>
										<td align="center"><?php $productOrder->dMothsOrd($eachRecord['design_no'],$txtTime);?></td>
										<td align="center"><?php $productStock->getsdMSales($eachRecord['design_no'],$txtTime); ?></td>
										<td align="center"><?php $productOrder->dMonthsDueOrd($eachRecord['design_no'],$txtTime);?></td>
										<td align="center"><?php echo $tOrdQuantity;?></td>
										<td align="center"><?php echo $stockDtls[2];?></td>
										<td align="center" ></td>
										
									 </tr>
									  <?php 
											$sl++;
											}
											
									  }
									  ?>
				</table>
			</div>
			
			<?php
					}//end of isset loop
					else{
				?>
				
				hi there..
				
				
				<?php
					}
				?>
	</div>
	<!---->
	<div class="col-md-2">
	  <div class="w_sidebar">
		
		<a href="hmda-computer.php">HMDA Computer</a>
		
		
		
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
</body>
</html>