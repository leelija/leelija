<?php 
session_start();
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/registration.inc.php");
require_once("../includes/email.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");

require_once("../classes/employee.class.php");
require_once("../classes/daily_comp_stitch.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$search_obj		= new Search();
$page			= new Pagination();

$employee		= new Employee();
$dStitch		= new DailyStitch();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

date_default_timezone_set('Asia/Calcutta'); 
//echo date("Y-m-d H:i:s"); // time in India
//$addDate 		= date("Y-m-d");// Today Date

//add a product
if(isset($_POST['txtSubmit']))
{	

	$txtOperator 	        = $_POST['txtOperator'];
	$txtCompNo 	        	= $_POST['txtCompNo'];
	$txtShift	 			= $_POST['txtShift'];
	$txtStitchNo	 		= $_POST['txtStitchNo'];
	$txtNote	 			= $_POST['txtNote'];
	$txtOrderId 	        = $_POST['txtOrderId'];
	$txtDesignNo 	        = $_POST['txtDesignNo'];
	$addDate 				 = $_POST['txtWorkedDate'];
	$amount 				= ($txtStitchNo / 100) * .8;
	$txtOfferAmount 	    = $_POST['txtOfferAmount'];
	
	//registering the post session variables
	$sess_arr	= array('txtOperator','txtCompNo', 'txtShift','txtStitchNo', 'txtNote');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'add_emp';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addEmp';
	$typeM		= 'ERROR';
	
	$msg = '';

	//field validation
	if($txtOperator=='')
	{
		echo "Fill The Operator Name Field";
	}
	
	elseif($txtCompNo=='')
	{
		echo "Fill Up The Computer no. Field";
	}
	elseif($txtShift=='')
	{
		echo "Fill Up Shift Field";
	}
	else
	{
		
	//add the Daily Stitch
	$dStitch->addDailyStitch('',$txtOperator,$txtCompNo, $txtShift, $txtStitchNo,$amount,$txtOfferAmount,'',$txtOrderId,$txtDesignNo,$txtNote,$addDate,$txtOperator,'No');
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'daily-stitch.php', "Thanks! Your Stitch has been successfully Added  ", 'SUCCESS');
	}
	
}//eof add product


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtOperator','txtCompNo', 'txtShift','txtStitchNo', 'txtNote');
	//forward
	header("Location: daily-stitch.php");
}
?>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Daily Stitch Data</title>

	<link rel="stylesheet" href="css/style.css">
	<script src="js/form.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	

</head>

<body>
<div class="container">
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<div class="MessageDiv" style="background-color: #ddd; height: 40px;width: 100%; text-align: center;margin-top: 20px;">
		<?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?></div>
		<form role="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
			<h2>Your Daily Stitch<small></small></h2>
			<hr class="colorgraph">
			 <h2><small style="color:#eb9812;">Please Fill the following field</small></h2>
			
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtOperator">Operator Name<span class="orangeLetter">*</span></label>
                        <input type="text" name="txtOperator" id="txtOperator" class="form-control input-lg" tabindex="1" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtCompNo">Computer No.<span class="orangeLetter">*</span></label>
						<input type="text" name="txtCompNo" id="txtCompNo" class="form-control input-lg" tabindex="2" required>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtShift">Shift<span class="orangeLetter">*</span></label>
							<select name="txtShift" class="form-control input-lg" id="txtShift" required>
								<option value="">Select any one</option>
								<option value="Day">Day</option>
								<option value="Night">Night</option>
							</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtStitchNo">No Of Stitch<span class="orangeLetter">*</span></label>
						<input type="text" name="txtStitchNo" id="txtStitchNo" class="form-control input-lg" tabindex="2" required>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="txtOfferAmount">Offer Amount<span class="orangeLetter"></span></label>
				<input type="text" name="txtOfferAmount" id="txtOfferAmount" class="form-control input-lg" tabindex="3" >
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtOrderId">Order Id<span class="orangeLetter">*</span></label>
                        <input type="text" name="txtOrderId" id="txtOrderId" class="form-control input-lg" tabindex="1" >
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtDesignNo">Design No.<span class="orangeLetter">*</span></label>
						<input type="text" name="txtDesignNo" id="txtDesignNo" class="form-control input-lg" tabindex="2" >
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="txtWorkedDate">Worked Date<span class="orangeLetter"></span></label>
				<input type="date" name="txtWorkedDate" id="txtWorkedDate" class="form-control input-lg" tabindex="3" >
			</div>
			
			<div class="form-group">
				<label for="txtNote">Note<span class="orangeLetter"></span></label>
				<input type="text" name="txtNote" id="txtNote" class="form-control input-lg" tabindex="3" >
			</div>
			
			<hr class="colorgraph">
			<div class="row">
				<div class="col-xs-12 col-md-6"><input type="submit" name="txtSubmit" value="Add" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
				<div class="col-xs-12 col-md-6"><a href="#" class="btn btn-success btn-block btn-lg">Cancel</a></div>
			</div>
		</form>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
			</div>
			<div class="modal-body">
			
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

</body>
</html>