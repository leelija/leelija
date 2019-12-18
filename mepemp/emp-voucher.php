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
require_once("../classes/employee.class.php"); 


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
$employee		= new Employee();

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
//admin detail
$userData =  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

// Show employee Details
if((isset($_POST['btnSubmit'])))
{
	$txtAdharNo					= $_POST['txtAdharNo'];
	$_SESSION['adharNo']		= $txtAdharNo;
}
// Submit voucher
if((isset($_POST['btnAppvButton'])))
{
	$txtEmpId					= $_POST['txtEmpId'];
	$txtDOP						= $_POST['txtDOP'];
	$txtChequeNo				= $_POST['txtChequeNo'];
	$txtMstatus					= $_POST['txtMstatus'];
	$txtTotalAmount				= $_POST['txtTotalAmount'];
	
	//register session
	$sess_arr	= array('txtEmpId', 'txtDOP', 'txtChequeNo', 'txtMstatus','txtTotalAmount');
	$utility->addPostSessArr($sess_arr);
	
	if($txtTotalAmount == '')
	{
		echo "Please fill the Amount field";
	}
	else
	{
		//echo $userData[10];exit;
		//add Employee payment status
		$employee->addPayApprved($txtEmpId,$txtDOP,$txtTotalAmount,$txtChequeNo,$txtMstatus,$userData[10],'',
	$apply_date,'NO','','','Pending');
				
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Successfully Apply for Approved ", 'SUCCESS');
	}
	
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
<link href="../style/custom-style.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
-->

<link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../style/bootstrap/js/bootstrap.min.js"></script>

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
                	<h1>Employee Voucher</h1>
                    
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
                                    <label>Adhar No.</label>
                                    <input class="form-control" name="txtAdharNo" 
									value="<?php if((isset($_POST['adharNo']))){echo $_SESSION['adharNo'];}?>">
                                </div>
							</div>
							<div class="col-lg-2">
								<label></label><br><br><br>
								<button type="submit" class="btn btn-primary" name="btnSubmit" >Generate Voucher</button>
							</div>
						</div><!---row end -->		
					</form>		
					<!--Report form end-->
					
					<?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
					
                	<?php 
					if((isset($_POST['btnSubmit'])))
						{
						
							$txtAdharNo		= $_POST['txtAdharNo'];
							$empDtls        = $employee->showEmployeeAdhar($txtAdharNo); 
							$empAddressDtl	= $employee->showEmpAddress($empDtls[0]);	
					?>
					
					<div class="voucher"><!--Voucher Start-->
						<form class="voucher-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
							<div class="vline"></div>
							<div class="vrow" id="vrow">	
								<div class="leftsubtitle">
									<p class="title"><?php echo $empDtls[15];?></p>
								</div>	
								<div class="rightsubtitle">
									<?php 
										echo $utility->imgDisplayR('../employee/images/photos/', $empDtls[12], 100, 100, 0, 'greyBorder', $empDtls[3], '');
									?>
								</div>
							</div>	
							<div class="vline"></div>
							<div class="vrow">
								<div class="row">
									<div class="col-xs-12 col-sm-2 col-md-2">
										<p>Debit/Credit Name</p>
										<input type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $empDtls[0];?>" >
									</div>
									<div class="col-xs-12 col-sm-7 col-md-7">
										<p><?php echo $empDtls[2]; ?></p>
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3">
										<p>Date:&nbsp;<?php echo date("d/m/Y"); ?> </p>
									</div>
								</div>	
							</div>	
							<div class="vrow">
								<div class="row">
									<div class="col-xs-12 col-sm-2 col-md-2">
										<p>Address:</p>
									</div>
									<div class="col-xs-12 col-sm-7 col-md-7">
										<p><?php echo $empAddressDtl[1]." ".$empAddressDtl[2]; echo ","; echo $empAddressDtl[5]; ?></p>
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3">
										<p>Mobile:&nbsp;<?php echo $empDtls[3]; ?> </p>
									</div>
								</div>	
							
							</div>
							<div class="vrow">
								<div class="row">
									<div class="col-xs-12 col-sm-2 col-md-2">
										<p>Details Of Payment</p>
									</div>
									<div class="col-xs-12 col-sm-9 col-md-9" id="vinput">
										<input type="text" name="txtDOP" class="form-control" id="txtDOP" >
									</div>
								</div>
							</div>
							
							<div class="vrow">
								<div class="row">
									<div class="col-xs-12 col-sm-2 col-md-2">
										<p>Cheque No.</p>
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3" id="vinput">
										<input type="text" name="txtChequeNo" class="form-control" id="txtChequeNo">
									</div>
									<div class="col-xs-12 col-sm-2 col-md-2">
										<select name="txtMstatus" class="col-sm-9" id="txtMstatus" required>
											<option value="Cash">Cash</option>
											<option value="Cheque">Cheque</option>
										</select>
									</div>
									<div class="col-xs-12 col-sm-2 col-md-2">
										<p>Total Rs.</p>
									</div>
									<div class="col-xs-12 col-sm-2 col-md-2" id="vinput">
										<input type="text" name="txtTotalAmount" class="form-control" id="txtTotalAmount">
									</div>
								</div>
							</div>
							
							<div class="vrow">
								<div class="row">
									<div class="col-xs-12 col-sm-2 col-md-2">
										<p>Prepared by</p>
									</div>
									<div class="col-xs-12 col-sm-8 col-md-8">
										<p><?php echo $userData[10]; ?></p>
									</div>
								</div>	
							</div>	<br>
							<button type="submit" class="btn btn-primary" name="btnAppvButton" >Apply for Approved</button>
							<?php //echo convert_number_to_words(123456789);?>
						</form>
					</div><!--Voucher end-->
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
