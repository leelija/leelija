<?php 
ini_set('session.cookie_lifetime', 60 * 60 * 2400);
ini_set('session.gc_maxlifetime', 60 * 60 * 2400);
//maybe you want to precise the save path as well
session_start();
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
require_once("../classes/status_cat.class.php");

require_once("../classes/sample.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$order		    = new Orders();
$prodStatus		= new Pstatus();
$advSearch		= new AdvSearch();
$productStock	= new ProductStock();
$productOrder	= new Productorders();
$search_obj		= new Search();
$pages			= new Pagination();
$photogallery	= new PhotoGAllery();
$sample			= new Sample();
$statusCat		= new StatusCat();
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
	<title>Incomplete Prodction</title>
	
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
						<h1>Check Up Incomplete Product Factory Wise</h1>
						<br />
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form form-inline">
		  					<div class="row">
								<div class="col-xs-12 col-sm-8 col-md-8">
									<div class="form-group">
											<select name="txtFactory" class="input-xxlarge" id="txtFactory" required>
												<option value="">Select Factory</option>
												<option value="2">HMDA Dyeing</option>
												<option value="1">Moni Enterprises</option>
												<option value="8">MDW Pvt. Ltd.</option>
											</select>
									</div>
								</div>
								<button class="btn-large btn btn-warning" name="txtBtn" type="submit">Search&nbsp;<i class="icon-chevron-right icon-white"></i></button>
							</div>
										 						
						</form>
						
						<?php
							//add a product
							if(isset($_POST['txtBtn']))
							{	
								$txtFactory	 				= $_POST['txtFactory'];
								$packingStat 				= $statusCat->getPackProdDtls($txtFactory);
								

						?>	
						<!--<div class="row">
							<div class="col-sm-4">HMDA: <?php $productOrder->countPartyDueOrd($txtPartyCode,2);?></div>
							<div class="col-sm-4">MEP: <?php $productOrder->countPartyDueOrd($txtPartyCode,1);?></div>
							<div class="col-sm-4">MDW PVT: <?php $productOrder->countPartyDueOrd($txtPartyCode,8);?></div>
						</div>		
						-->
							<!-- Product image Details Start-->
							<!--<div class="grid images_3_of_2">-->
								<div class="table-responsive"> 
								<!-- Party Due Details -->
								<div id="example" class="table">
									<table class="single-column" cellpadding="0" cellspacing="0" border="1">
											<!-- display option -->
										<?php 
											if(count($packingStat) == 0)
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
											   <th align="center" width="1%" >S.No</th>
											   <th align="center" width="3%" >Order Id</th>
											   <th align="center" width="5%"  >Design No</th>
											   <th align="center" width="5%"  >Quantity</th>
											   <th align="center" width="5%"  >Due Quantity</th>
											</thead>
										   <?php 
											$k = 1;
											foreach($packingStat as $eachRecord)
												{
												
													$stitchDetails  			= $statusCat->disPlTableDtls($eachRecord['bill_no'],'final_stich');
													$ordDtlDtls					= $order->getOrderQuantitycount($eachRecord['order_id']);
													foreach($ordDtlDtls as $eachRecordc)
														{
															$ordQty 			= $eachRecordc['SUM(quantity)']; 
														}					
													// Due quantity
													$prodDueQty 				= $ordQty - $eachRecord['complete'];
													
													foreach($stitchDetails as $eachRecords)
														{
															$custDtls 			= $customer->getCustomerData($eachRecords['employeeId']);
															$mstName			= $custDtls[2];
														}
											?>
										<?php if($prodDueQty !=0){ ?>	
										<tr align="left">
											<td align="center"><?php echo $k; ?></td>
											<td align="center"><?php echo $eachRecord['order_id']; ?></td>
											<td align="center"><?php echo $eachRecord['design_no']; ?></td>
											<td align="center"><?php $order->TotalQuantitySum($eachRecord['order_id']);	?></td>
											<td align="center"><?php echo $prodDueQty;?></td>
										 </tr>
										<?php }?>
										  <?php 
												}
												$k++;
										  }
										  ?>
									</table>
								</div><br><br>
								<!--Party due status end-->
								
									 <div class="clearfix"> </div>		
							</div><!--Responsive-->
							<!--</div> -->
							  <!-- Product image Details end-->
							
							
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