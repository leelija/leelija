<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 

require_once("../classes/order.class.php"); 
require_once("../classes/stock.class.php");

require_once("../classes/report.class.php");


require_once("../classes/sample.class.php"); 

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();

$orders		    = new Orders();

$search_obj		= new Search();
$pages			= new Pagination();

$report			= new Report();

$stock			= new Stock();

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
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 10);
$userId			= $utility->returnSess('userid', 0);

//NO OF PRODUCTS
if((isset($_POST['btnSearch'])))
{

$designNo			= $_POST['keyword'];

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> -  Report Management</title>
<!-- Style -->
<link href="../style/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
-->


<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<script type="text/javascript" src="../js/static.js"></script>
<!-- eof JS Libraries -->


<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


</head>

<body>
	
	
    <!-- Header -->
	<?php require_once('header.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<div id="admin-menu">
				<?php require_once('menu.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                <div id="admin-top">
                	<h1>Last Two Months Products In & Sales Reports</h1>
                    
                    
                   <div class="cl"></div> 
                </div>
                
                
             <!-- <h2>Total Current Stock:<?php  //$stock->CurrentstockSum();?></h2>-->
                
                <!-- Display Data -->
                <div id="data-column">
				<br>
					<hr>
                    <!--Report form start-->   
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
						<div class="row"><!---row start -->
                            <div class="col-lg-3">
								<div class="form-group">
                                    <label>Design No.</label>
                                    <input class="form-control" name="txtDesignNo">
                                </div>
							</div>
						<!--	<div class="col-lg-3">
								<div class="form-group">
                                    <label>Form Date</label>
                                    <input type="date" class="form-control">
                                </div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
                                    <label>To Date</label>
                                    <input type="date" class="form-control">
                                </div>
							</div>-->
							<div class="col-lg-2">
								<label></label><br><br><br>
								<button type="submit" class="btn btn-primary" name="btnSubmit" >Show details</button>
							</div>
						</div><!---row end -->		
					</form>		
					<!--Report form end-->
					
					
					<div class="row" style="position: relative; bottom: 200px;"><!---row start -->
						<div class="col-lg-6">
							<!--Sales Chart-->
							Sales Chart
							<div id="morris-line-chart"></div>
						</div>
						
						<div class="col-lg-6">
							<!--Products In Chart-->
							Products in chart
							<div id="morris-Products-In"></div>
						</div>
						
					</div>	
                	<?php 
					if((isset($_POST['btnSubmit'])))
						{
						
							$txtDesignNo			= $_POST['txtDesignNo'];
						
							$query = "SELECT * FROM  `product_sales` where design_no ='$txtDesignNo'
							AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() ORDER BY added_on";
							$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
							// get data and store in a json array
							while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
								$rows[] = array(
								'added_on' => $row['added_on'],
								'sales' => $row['sales']
												
									);
								}
							
						
					?>
						<script>
						Morris.Line({
							// ID of the element in which to draw the chart.
							element: 'morris-line-chart',
						 
							// Chart data records -- each entry in this array corresponds to a point
							// on the chart.
							data: <?php echo json_encode($rows);?>,
						 
							// The name of the data record attribute that contains x-values.
							xkey: 'added_on',
						 
							// A list of names of data record attributes that contain y-values.
							ykeys: ['sales'],
						 
							// Labels for the ykeys -- will be displayed when you hover over the
							// chart.
							labels: ['Sales'],
						 
							lineColors: ['#0b62a4'],
							xLabels: 'sales',
						 
							// Disables line smoothing
							smooth: true,
							resize: true
						});
						</script>
					
					<?php
					}
					?>
					
					
					
					<?php 
					if((isset($_POST['btnSubmit'])))
						{
						
							$txtDesignNo			= $_POST['txtDesignNo'];
						
							$query1 = "SELECT * FROM  `product_in` where design_no ='$txtDesignNo'
							AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() ORDER BY added_on";
							$result1 = mysql_query($query1) or die("SQL Error 1: " . mysql_error());
							// get data and store in a json array
							while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {
								$rows1[] = array(
								'added_on' => $row['added_on'],
								'product_in' => $row['product_in']
												
									);
								}	
						
						
					?>
						
						<script>
						Morris.Line({
							// ID of the element in which to draw the chart.
							element: 'morris-Products-In',
						 
							// Chart data records -- each entry in this array corresponds to a point
							// on the chart.
							data: <?php echo json_encode($rows1);?>,
						 
							// The name of the data record attribute that contains x-values.
							xkey: 'added_on',
						 
							// A list of names of data record attributes that contain y-values.
							ykeys: ['product_in'],
						 
							// Labels for the ykeys -- will be displayed when you hover over the
							// chart.
							labels: ['Products In'],
						 
							lineColors: ['#0b62a4'],
							xLabels: 'product_in',
						 
							// Disables line smoothing
							smooth: true,
							resize: true
						});
						</script>
					
					
					
					<?php
					}
					?>
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
				<!---===================Rozelle Due Quantity Details display section-==============================-->	
					<?php
					if((isset($_GET['designNo'])))
						{
							$designNo	= $_GET['designNo'];
							//echo $designNo;
							$rozDueDetails	= $report->showRozDueOrd($designNo);
						
					?>
					<h2>Rozelle Due Quantity Report</h2><br>
					 <table border="1" cellpadding="0" cellspacing="0" width="100%" id="myTable" class="tblListForm">
						<tr class="listheader">
						
						<th class="listheader">Order Id </th>
						<th class="listheader">Book No </th>
						<th class="listheader">Party Code </th>
						<th class="listheader">Design No </th>
						<th class="listheader">Order Quantity </th>
						<th class="listheader">Due Quantity </th>
						<th class="listheader">Pay Quantity</th>
						<th class="listheader">Colour </th>
						<th class="listheader">Order Date </th>
						<th class="listheader">Target Date </th>
						</tr>

						<?php 

							 $reco_record = 0; 
							foreach( $rozDueDetails as $eachrecord ){
							if($reco_record%2==0)
							$classname="evenRow";
							
								else
									$classname="oddRow";
  
						?>

						<tr class="table-row" >
							<td align="center"><?php echo $eachrecord ['orders_id']; ?></td>
							<td align="center"><?php echo $eachrecord ['book_no']; ?></td>
							<td align="center"><?php echo $eachrecord ['party_code']; ?></td>
							<td align="center"><?php echo $eachrecord ['design_no']; ?></td>
							<td align="center"><?php echo $eachrecord ['quantity']; ?></td>
							<td align="center"><?php echo $eachrecord ['due_quantity']; ?></td>
							<td align="center"><?php echo $eachrecord ['pay_quantity']; ?></td>
							<td align="center"><?php echo $eachrecord ['colour']; ?></td>
							<td align="center"><?php echo $eachrecord ['order_date']; ?></td>
							<td align="center"><?php echo $eachrecord ['target_date']; ?></td>
							
						</tr>

						<?php 

						$reco_record++;
						} 
						?>
						
					</table>
					
					<?php
						}
					?>	
					
			<!---===================Current Stock Details display section-==============================-->		
					<?php
					if((isset($_GET['designNumber'])))
						{
							$designNo	= $_GET['designNumber'];
							//echo $designNo;
							$rozDueDetails	= $report->showCurrentStock($designNo);
						
					?>
					<h2>Current stock Of design No.&nbsp;&nbsp;<?php echo $designNo;?> </h2><br>
					 <table border="1" cellpadding="0" cellspacing="0" width="100%" id="myTable" class="tblListForm">
						<tr class="listheader">
						
						<th class="listheader">Design No. </th>
						<th class="listheader">Current Stock </th>
						<th class="listheader">Colour </th>
						
						</tr>

						<?php 

							 $reco_record = 0; 
							foreach( $rozDueDetails as $eachrecord ){
							if($reco_record%2==0)
							$classname="evenRow";
							
								else
									$classname="oddRow";
  
						?>

						<tr class="table-row" >
							<td align="center"><?php echo $eachrecord ['design_no']; ?></td>
							<td align="center"><?php echo $eachrecord ['quantity']; ?></td>
							<td align="center"><?php echo $eachrecord ['colour']; ?></td>
							
							
						</tr>

						<?php 

						$reco_record++;
						} 
						?>
						
					</table>
					
					<?php
						}
					?>	
					
                	
				  
                </div>
                <!-- eof Display Data -->
                
                <div class="cl"></div>
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
     
</body>
</html>
