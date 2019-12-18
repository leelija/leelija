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
		$txtDesignNo	 			= $_POST['txtDesignNo'];
		
		$_SESSION['txtToDate']		= $txtToDate;
		$_SESSION['txtFromDate']	= $txtFromDate;
		$_SESSION['txtFactory']		= $txtFactory;
		$_SESSION['txtDesignNo']	= $txtDesignNo;
	}

?>


<!DOCTYPE html>
<html>
<head>
<title>Sales Report</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../js/ajax.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

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
								<label for="txtDesignNo">Design No<span class="orangeLetter"></span></label>
								<input type="text" name="txtDesignNo" id="txtDesignNo" class="form-control input-lg" 
								value="<?php if(isset($_SESSION['txtDesignNo'])){ echo $_SESSION['txtDesignNo'];}else{}?>" tabindex="2" >
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
									<label for="txtFactory">Factory<span class="orangeLetter"></span></label>
									<select name="txtFactory" class="form-control input-lg" id="txtFactory">
										<option value="">Select Factory</option>
										<option value="1">Moni Enterprises</option>
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
						$txtToDate	 				= $_POST['txtToDate'];
						$txtFromDate	 			= $_POST['txtFromDate'];
						$txtFactory	 				= $_POST['txtFactory'];
						$txtDesignNo	 			= $_POST['txtDesignNo'];
						
						
						if($txtFactory 	== 2){
							$allSampPhtData 	= $photogallery->sampPhotoAllData(2);
							
							$query = "SELECT YEAR(order_date) as `OrdYear`,MONTH(order_date) as `OrdMonth`,SUM(quantity) AS `count_ord`
							,SUM(pay_quantity) AS `count_saleQty`,order_date FROM  `product_order_dtl` where factory_id ='$txtFactory'
							AND status != 'cancel' AND order_date BETWEEN '$txtToDate' AND '$txtFromDate' GROUP BY YEAR(order_date), MONTH(order_date)";
							$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
							//echo $query.mysql_error();exit;
							// get data and store in a json array
							while ($rowOrd = mysql_fetch_array($result, MYSQL_ASSOC)) {
								$rows1[] = array(
								'order_date' => $rowOrd['order_date'],
								'quantity' => $rowOrd['count_ord'],
								'saleqty' => $rowOrd['count_saleQty']
								);
							}
							
							foreach($allSampPhtData as $eachRecord)
								{	
									$ds = $eachRecord['design_no'];
									//echo $ds;exit;
									//Production status
									$query = "SELECT YEAR(added_on) as `SalesYear`,MONTH(added_on) as `SalesMonth`,SUM(product_in) AS `count_prod`,
								    added_on FROM  `stock_product_in` where design_no = '$ds'
									AND added_on BETWEEN '$txtToDate' AND '$txtFromDate' GROUP BY YEAR(added_on), MONTH(added_on)";
									$result1 = mysql_query($query) or die("SQL Error 1: " . mysql_error());
									//echo $query.mysql_error();exit;
									// get data and store in a json array
									while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {
										$rows[] = array(
										'added_on' => $row['added_on'],
										'product_in' => $row['count_prod']
											);
										}
								}
							
							//Sales status
							foreach($allSampPhtData as $eachRecord)
								{	
									$txtDesignNo = $eachRecord['design_no'];	
									$query = "SELECT YEAR(added_on) as `SalesYear`,MONTH(added_on) as `SalesMonth`,SUM(sales) AS `count_prod`,
									added_on FROM  `stock_product_sales` where design_no ='$txtDesignNo'
									AND added_on BETWEEN '$txtToDate' AND '$txtFromDate' GROUP BY YEAR(added_on), MONTH(added_on)";
									$results = mysql_query($query) or die("SQL Error 1: " . mysql_error());
									//echo $query.mysql_error();exit;
									// get data and store in a json array
									while ($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
									$rowssl[] = array(
									'added_on' => $row['added_on'],
									'sales' => $row['count_prod']
									);
									}	
								}	
							
						}// end if loop	
						elseif($txtFactory 	== 1){
							$allSampPhtData 	= $photogallery->sampPhotoAllData(1);
							
							$query = "SELECT YEAR(order_date) as `OrdYear`,MONTH(order_date) as `OrdMonth`,SUM(quantity) AS `count_ord`
							,SUM(pay_quantity) AS `count_saleQty`,order_date FROM  `product_order_dtl` where factory_id ='$txtFactory'
							AND status != 'cancel' AND order_date BETWEEN '$txtToDate' AND '$txtFromDate' GROUP BY YEAR(order_date), MONTH(order_date)";
							$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
							//echo $query.mysql_error();exit;
							// get data and store in a json array
							while ($rowOrd = mysql_fetch_array($result, MYSQL_ASSOC)) {
							$rows1[] = array(
							'order_date' => $rowOrd['order_date'],
							'quantity' => $rowOrd['count_ord'],
							'saleqty' => $rowOrd['count_saleQty']
								);
							}	
							
							foreach($allSampPhtData as $eachRecord)
								{	
									$ds = $eachRecord['design_no'];
									//echo $ds;exit;
									//Production status
									$query = "SELECT YEAR(added_on) as `SalesYear`,MONTH(added_on) as `SalesMonth`,SUM(product_in) AS `count_prod`,
									added_on FROM  `stock_product_in` where design_no = '$ds'
									AND added_on BETWEEN '$txtToDate' AND '$txtFromDate' GROUP BY YEAR(added_on), MONTH(added_on)";
									$result1 = mysql_query($query) or die("SQL Error 1: " . mysql_error());
									//echo $query.mysql_error();exit;
									// get data and store in a json array
									while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {
										$rows[] = array(
										'added_on' => $row['added_on'],
										'product_in' => $row['count_prod']
											);
										}
								}
							
							//Sales status
							foreach($allSampPhtData as $eachRecord)
								{	
									$txtDesignNo = $eachRecord['design_no'];	
									$query = "SELECT YEAR(added_on) as `SalesYear`,MONTH(added_on) as `SalesMonth`,SUM(sales) AS `count_prod`,
									added_on FROM  `stock_product_sales` where design_no ='$txtDesignNo'
									AND added_on BETWEEN '$txtToDate' AND '$txtFromDate' GROUP BY YEAR(added_on), MONTH(added_on)";
									$results = mysql_query($query) or die("SQL Error 1: " . mysql_error());
									//echo $query.mysql_error();exit;
									// get data and store in a json array
									while ($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
									$rowssl[] = array(
									'added_on' => $row['added_on'],
									'sales' => $row['count_prod']
									);
									}	
								}			
								

						}//end else loop
						else{
							
							$query = "SELECT YEAR(order_date) as `OrdYear`,MONTH(order_date) as `OrdMonth`,SUM(quantity) AS `count_ord`
							,SUM(pay_quantity) AS `count_saleQty`,order_date FROM  `product_order_dtl` where design_no ='$txtDesignNo'
							AND status != 'cancel' AND order_date BETWEEN '$txtToDate' AND '$txtFromDate' GROUP BY YEAR(order_date), MONTH(order_date)";
							$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
							//echo $query.mysql_error();exit;
							// get data and store in a json array
							while ($rowOrd = mysql_fetch_array($result, MYSQL_ASSOC)) {
								$rows1[] = array(
								'order_date' => $rowOrd['order_date'],
								'quantity' => $rowOrd['count_ord'],
								'saleqty' => $rowOrd['count_saleQty']
												
									);
								}	
								
							//Production status
							$query = "SELECT YEAR(added_on) as `SalesYear`,MONTH(added_on) as `SalesMonth`,SUM(product_in) AS `count_prod`,
						 added_on FROM  `stock_product_in` where design_no ='$txtDesignNo'
							AND added_on BETWEEN '$txtToDate' AND '$txtFromDate' GROUP BY YEAR(added_on), MONTH(added_on)";
							$result1 = mysql_query($query) or die("SQL Error 1: " . mysql_error());
							//echo $query.mysql_error();exit;
							// get data and store in a json array
							while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {
								$rows[] = array(
								'added_on' => $row['added_on'],
								'product_in' => $row['count_prod']
									);
								}	
								
							//Sales status
							$query = "SELECT YEAR(added_on) as `SalesYear`,MONTH(added_on) as `SalesMonth`,SUM(sales) AS `count_prod`,
						 added_on FROM  `stock_product_sales` where design_no ='$txtDesignNo'
							AND added_on BETWEEN '$txtToDate' AND '$txtFromDate' GROUP BY YEAR(added_on), MONTH(added_on)";
							$results = mysql_query($query) or die("SQL Error 1: " . mysql_error());
							//echo $query.mysql_error();exit;
							// get data and store in a json array
							while ($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
								$rowssl[] = array(
								'added_on' => $row['added_on'],
								'sales' => $row['count_prod']
									);
								}	
						
						}

				?>
				<div class="col-lg-12">
					<!--Sales Chart-->
					<h2>Order VS Sales</h2><br>
					<span>Order:<p style="height: 8px;width: 8px; background:#ff7f00;"></p></span>
					<span>Sales:<p style="height: 8px;width: 8px; background:#0aa5e2;"></p></span>
					<div id="morris-bar-chart"></div>
					<div id="morris-line-chart"></div>
					<div id="barchart"></div>
				</div>
				
				<div class="col-lg-12">
					<!--Sales Chart-->
					<h2>Production Chart</h2><br>
					<div id="prodchart"></div>
				</div>
				
				<div class="col-lg-12">
					<!--Sales Chart-->
					<h2>Sales Chart</h2><br>
					<div id="saleschart"></div>
				</div>
				
				<script>
						//Bar chart
					   Morris.Bar({
							element: 'barchart',
							axes: true,
							data: <?php echo json_encode($rows1);?>,
							xkey: 'order_date',
							ykeys: ['quantity', 'saleqty'],
							labels: ['Order', 'Sales'],
							barColors: ['#ff7f00', '#0aa5e2']
						});
				</script>
				
				<script>
						//Production chart
					   Morris.Bar({
							element: 'prodchart',
							axes: true,
							data: <?php echo json_encode($rows);?>,
							xkey: 'added_on',
							ykeys: ['product_in'],
							labels: ['Production'],
							barColors: ['#ff7f00']
						});
				</script>
				
				<script>
						//Sales chart
					   Morris.Bar({
							element: 'saleschart',
							axes: true,
							data: <?php echo json_encode($rowssl);?>,
							xkey: 'added_on',
							ykeys: ['sales'],
							labels: ['Sales'],
							barColors: ['#ff7f00']
						});
				</script>
				
				<script>
					/*	Morris.Line({
							// ID of the element in which to draw the chart.
							element: 'morris-line-chart',
							// Chart data records -- each entry in this array corresponds to a point
							// on the chart.
							data: <?php echo json_encode($rows1);?>,
							// The name of the data record attribute that contains x-values.
							xkey: 'order_date',
							// A list of names of data record attributes that contain y-values.
							ykeys: ['quantity','saleqty'],
							
							// Labels for the ykeys -- will be displayed when you hover over the
							// chart.
							labels: ['Order','sales'],
							
							lineColors: ['#3fe8cf','#ff7f00'],
							pointFillColors:['red'],
							pointStrokeColors: ['black'],
							xLabels: 'Order',
							// Disables line smoothing
							smooth: true,
							resize: true
						});*/
				</script>
				
				
						
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