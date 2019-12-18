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
<title><?php echo COMPANY_S; ?> -  sample Management</title>
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
<link href="../style/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">


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

<script type="text/javascript" src="../js/product_report.js"></script>
<!-- eof JS Libraries -->

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
                	<br><h1>Last Two Month's Product Report</h1>
                    
                 <!--   <div id="search-page-back">
                    	<form name="formAdvSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                           
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="search" />
                        </form>
                    </div> -->
                   <div class="cl"></div> 
                </div>
                
                <div class="row"><!---row start -->
					<div class="col-lg-12">
					<!--Report form start-->   
                    <form action="" method="post" enctype="multipart/form-data">
						<div class="row"><!---row start -->
								<div class="col-lg-3">
									<div class="form-group">
										<label>Design No.</label>
										<input type="text" id="txtDesignNo" name="txtDesignNo" class="form-control">
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label>Form Date</label>
										<input type="date" name="txtFromDate" id="txtFromDate" class="form-control">
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label>To Date</label>
										<input type="date" name="txtToDate" id="txtToDate" class="form-control">
									</div>
								</div>
								<div class="col-lg-2">
									<label></label><br><br><br>
									<input  class="btn btn-primary" type='button'  onclick="productReport()" value="Show details"  />
								</div>
								
							<div class="row"><!---row start -->	
								<div class="col-lg-12">
									<div class="col-lg-12">
										<!--Product report div-->
										<div id="showProductReport"></div>
									</div>
								</div>
							</div>	
						</div><!---row end -->	
						
					</form>		
					<!--Report form end-->
					
					</div>
                </div><!---row end -->
				<div class="row"><!---row start -->
					<!-- Display Data -->
					<div id="data-column">
				
						
						
                
				  
					</div>
					<!-- eof Display Data -->
                </div><!---row end -->
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
