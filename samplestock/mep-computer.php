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
// Product stock all data display
$prodDtls 		= $productStock->getpStock();

$prodCount 		= $productStock->ProdDesWiseCount();

$upComingSample = $photogallery->sUpcomingData();

// all sample gallery details
$spGalleryLatest 	= $photogallery->sPhotoLatestData();

//NO OF PRODUCTS
if((isset($_POST['btnSearch'])))
{

$keyword			= $_POST['keyword'];
$type			    = $_POST['type'];
//echo $type;exit;
	if($type ==""){
		$link = '';
		//$pgid = $advSearch->getCommonSearchAdmin($keyword,'design_no','sample_gallery_id','sample_gallery');
		$pgid = $search_obj->getSpGalleryKeyword($keyword);
		//echo $sid;exit;
	}
	else{
		$link = '';
		//$pgid = $advSearch->getCommonSearchAdmin($keyword,$type,'sample_gallery_id','sample_gallery');
		$pgid = $photogallery->getAllSampeGl($type,'ASC');
		
	}		
	
}
else
{
	$link = '';
	$pgid = $photogallery->getAllSampeGl('sample_gallery_id','DESC',1);
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$link			= "numResDisplay=".$numResDisplay;

/* pagination*/
$adjacents = 3;

$total_pages = count($pgid);
	
/* Setup vars for query. */
$targetpage = $_SERVER['PHP_SELF']."?".$link; 	//your file name  (the name of this file)
$limit = 300; 	
if(isset($_GET['page']))
{							//how many items to show per page
	$page = $_GET['page'];
}
else
{
	$page = 1;
}
//echo $page;exit;
if($page) 
	$start = ($page - 1) * $limit; 			//first item to display on this page
else
	$start = 0;								//if no page var is given, set start to 0
	
$prev = $page - 1;							//previous page is page - 1
$next = $page + 1;							//next page is page + 1
$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
$lpm1 = $lastpage - 1;						//last page minus 1

/* 
	Now we apply our rules and draw the pagination object. 
	We're actually saving the code to a variable in case we want to draw it more than once.
*/
$pagination = "";
//echo $total_pages;exit;
if($lastpage > 1)
{	
	$pagination .= "<div class=\"pagination\">";
	//previous button
	if ($page > 1) 
		$pagination.= "<a href=\"$targetpage&page=$prev\" id='previous-button'>< previous</a>";
	else
		$pagination.= "<span class=\"disabled\">< previous</span>";	
	
	//pages	
	if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
	{	
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
			if ($counter == $page)
				$pagination.= "<span class=\"current\">$counter</span>";
			else
				$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
		}
	}
	elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
	{
		//close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2))		
		{
			for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";				
			}
			$pagination.= "...";
			$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
			$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
		}
		//in middle; hide some front and some back
		elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
		{
			$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
			$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
			$pagination.= "...";
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
			}
			$pagination.= "...";
			$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
			$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
		}
		//close to end; only hide early pages
		else
		{
			$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
			$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
			$pagination.= "...";
			for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
			}
		}
	}
	
	//next button
	if ($page < $counter - 1) 
		$pagination.= "<a href=\"$targetpage&page=$next\" id='next-button'>next ></a>";
	else
		$pagination.= "<span class=\"disabled\" id='next-button-disabled'>next ></span>";
	$pagination.= "</div>\n";		
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
			<!--Pipeline status start-->
			<div class="modal-body" style="font-size:9px;">
				<table class="single-column" cellpadding="0" cellspacing="0" border="1">
										<!-- display option -->
										<?php 
										if(count($pgid) == 0)
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
										  <th width="5%" >Sl.No </th>
										  <th width="5%" >order Id </th>
										  <th width="20%"  >Design No</th>
										  <th width="5%" >Quantity</th>
										  <th width="5%" >Amount(Rs.)</th>
										  <th width="6%"  >Billing Name</th>
										  <th width="5%" >Bill NO</th>
										  <th width="14%" >Comp.Design No.</th>
										  <th width="5%"  >Ord.Date </th>
										  <th width="5%" >Trd.Date</th>
										  <th width="5%" >R.day</th>
										  <th width="5%" >Comp Type</th>
										  <th width="5%"  >Computer(left)</th>
										  <th width="5%"  >Status</th>
										</thead>
									   <?php 
									   
										$k = $pages->getPageSerialNum($numResDisplay);
										$pgid = array_slice($pgid, $start, $limit);  
										$sl = 1;
										$gTotal =0;
										foreach($pgid as $x)
											{
											//$x = $pageArray[$pageNumber][$j];
											$bgColor 	= $utility->getRowColor($k);
											$sphotoGalleryDetail 	= $photogallery->showSamplePGallery($x);
											//echo $sphotoGalleryDetail[2];exit;
											$statusCatDetail 		= $statusCat->GetCompDataDwise($sphotoGalleryDetail[2]);
											
											foreach($statusCatDetail as $eachRecord)
											{
											$customerDetail 		= $client->getCustomerData($eachRecord['employeeId']);
											$sGalleryDetail 		= $photogallery->showSampleGalleryDgn($eachRecord['design_no']);
											//echo $eachRecord['order_id'];exit;
											$Orddate	= date_create($eachRecord['order_date']);
											$Trddate	= date_create($eachRecord['target_date']);
											$orderDate 	= date_format($Orddate,"d/m/Y");
											$targetDate = date_format($Trddate,"d/m/Y");
											
											$amount 	= $eachRecord['quantity'] * $eachRecord['stich_rate'];
											$gTotal 	+= $amount;
									?>
										<tr align="left"<?php $utility->printRowColor($bgColor);?>>
										<td align="left"><?php echo $sl; ?></td>
										<td align="center"><?php echo $eachRecord['order_id']; ?></td>
										<td align="center">
										<img id="myImg" src="../images/spgallery/large/<?php echo $sGalleryDetail[6];?>" alt="<?php echo $sGalleryDetail[6];?>" width="100" height="120">
										<?php echo $eachRecord['design_no']; ?>
										
										</td>
										<td align="center"><?php	$orders->TotalQuantitySum($eachRecord['order_id']);	?></td>
										<td align="center"><?php echo $amount; ?></td>
										<td align="center"><?php echo $customerDetail['employeeId']; ?></td>
										<td align="center"><?php echo $eachRecord['bill_no']; ?></td>
										<td align="center" ><?php echo $eachRecord['computer_design_no']; ?></td>
										<td align="center"><?php echo $orderDate; ?></td>
										<td align="center"><?php echo $targetDate; ?></td>
									   <?php
										$datemodif	=	date_create($eachRecord['modified_on']);
										$date1		=	date_create($eachRecord['target_date']);
										$date2		=	date_create(date("Y-m-d"));
										$diff=date_diff($date2,$date1);
										
										$diffordtarget=date_diff($datemodif,$date1);
										
										if($eachRecord['quantity']>0)
											{
											if($diff->format("%R%a days")>='+3 days')
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
											} else{	
										   ?>
										   <td align="center" style="color:#34a853;"><?php echo $diffordtarget->format("%R%a days"); ?></td>
										   <?php
										   }
										   ?>
										<td align="center"><?php echo $eachRecord['comp_type']; ?></td>	   
										<td align="center"><?php echo $eachRecord['quantity']; ?></td>
										<td align="center"><?php echo $eachRecord['final_result']; ?></td>
									 </tr>
									  <?php 
											$sl++;
											}
											
												}
											$k++;
									  }
									  ?>
				</table>
			</div>
			<h3>Total Billing: <?php echo $gTotal;?>					
	</div>
	<!---->
	<div class="col-md-2">
	  <div class="w_sidebar">
		
		<a href="hmda-computer.php">HMDA Computer</a>
		<a href="comp-report.php">Show Computer Report</a>
		
		
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