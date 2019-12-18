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

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

//add a product
if(isset($_POST['txtSubmit']))
{	

	$selEmpType 	        = $_POST['selEmpType'];
	$txtEmpName 	        = $_POST['txtEmpName'];
	$txtMobile	 			= $_POST['txtMobile'];
	$txtEmail	 			= $_POST['txtEmail'];
	$txtAdharNo	 			= $_POST['txtAdharNo'];
	$txtSecurityNo	 		= $_POST['txtSecurityNo'];
	
	$txtFname	 			= $_POST['txtFname'];
	$txtLname	 			= $_POST['txtLname'];
	$txtGuardian	 	    = $_POST['txtGuardian'];
	$txtMstatus	 			= $_POST['txtMstatus'];
	$txtGender	 			= $_POST['txtGender'];
	$txtDOB	 				= $_POST['txtDOB'];
	
	$txtPhotoImg	 		= $_POST['txtPhotoImg'];
	$txtAdhar	 			= $_POST['txtAdhar'];
	$txtVoter 				= $_POST['txtVoter'];
	
	$txtFActory				= $_POST['txtFActory'];
	$txtWorkUnder	 		= $_POST['txtWorkUnder'];
	$txtWorkedType	 		= $_POST['txtWorkedType'];
	
	// address
	$txtAddress1	 		= $_POST['txtAddress1'];
	$txtAddress2	 		= $_POST['txtAddress2'];
	$txtAddress3 			= $_POST['txtAddress3'];
	$txtTown				= $_POST['txtTown'];
	$txtPostal	 			= $_POST['txtPostal'];
	$txtCountry	 			= "India";
	
	//registering the post session variables
	$sess_arr	= array('txtEmpName','txtMobile', 'txtEmail','txtAdharNo', 'txtFname', 'txtGuardian', 'txtMstatus', 'txtGender',
		'txtDOB','txtPhotoImg','txtAdhar','txtVoter','txtFActory','txtWorkUnder','txtWorkedType');
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
	$dupMobile		= $error->duplicateUser($txtMobile, 'emp_mobile', 'employee');
	$duplicateId	= $error->duplicateUser($txtEmail, 'email', 'employee');
	$dupAdharNo 	= $error->duplicateUser($txtAdharNo, 'adhar_no', 'employee');
	
	if( ($txtEmail != '') && (preg_match("/^ER/i",$duplicateId)) )		
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU114, $typeM, $anchor);
	}
	elseif( ($txtMobile != '') && (preg_match("/^ER/i",$dupMobile)) )		
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Mobile No. Already Used", $typeM, $anchor);
	}
	elseif( ($txtAdharNo != '') && (preg_match("/^ER/i",$dupAdharNo)) )		
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Adhar No. Already Used", $typeM, $anchor);
	}
	
	elseif($txtEmpName=='')
	{
		echo "Fill Up Your Name Field";
	}
	
	elseif($txtMobile=='')
	{
		echo "Fill Up Your Mobile Field";
	}
	elseif($txtEmail=='')
	{
		echo "Fill Up Your Email Field";
	}
	else
	{
		
	//add the Employee 
	  $emp_id =  $employee->addEmployee($selEmpType,$txtEmpName, $txtMobile, $txtEmail,$txtAdharNo,$txtSecurityNo, $txtFname,$txtLname, $txtGuardian,
	  $txtMstatus,$txtGender,$txtDOB,$txtPhotoImg,$txtAdhar,$txtVoter,$txtFActory,$txtWorkUnder,$txtWorkedType,'',
	  'N','','','a','',$txtEmpName);
		
		//add emp address
		$employee->addEmpAddress($emp_id, $txtAddress1, $txtAddress2, $txtAddress3, $txtTown, $txtPostal,
		$txtCountry);
		
		//uploading photo
		if($_FILES['txtPhotoImg']['name'] != '')
		{
			//rename the file
			$newName = $utility->getNewName4($_FILES['txtPhotoImg'], '', $emp_id);
			
			//upload and crop the file
			$uImg->imgCropResize($_FILES['txtPhotoImg'], '', $newName, 
								 'images/photos/', 800, 800, 
						         $emp_id, 'photo_img', 'emp_id','employee');
		}
		
		//uploading Adhar
		if($_FILES['txtAdhar']['name'] != '')
		{
			//rename the file
			$newName = $utility->getNewName4($_FILES['txtAdhar'], '', $emp_id);
			
			//upload and crop the file
			$uImg->imgCropResize($_FILES['txtAdhar'], '', $newName, 
								 'images/adhar/', 1800, 1800, 
						         $emp_id, 'adhar_img', 'emp_id','employee');
		}
		//uploading Voter
		if($_FILES['txtVoter']['name'] != '')
		{
			//rename the file
			$newName = $utility->getNewName4($_FILES['txtVoter'], '', $emp_id);
			
			//upload and crop the file
			$uImg->imgCropResize($_FILES['txtVoter'], '', $newName, 
								 'images/voter/', 800, 800, 
						         $emp_id, 'votar_img', 'emp_id','employee');
		}
		
		
		
		
		
		
		
		
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'index.php', "Thanks! Your Registration has been successfully Complete  ", 'SUCCESS');
	}
	
}//eof add product


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtEmpName','txtMobile', 'txtEmail', 'txtFname', 'txtGuardian', 'txtMstatus', 'txtGender',
		'txtDOB','txtPhotoImg','txtAdhar','txtVoter','txtFActory','txtWorkUnder','txtWorkedType');
	
	//forward
	header("Location: index.php");
}
?>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Employee Registration form</title>

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
			<h2>Please Register Your Name<small></small></h2>
			<hr class="colorgraph">
			 <h2><small style="color:#eb9812;">Your Personal Information</small></h2>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label>Your Name<span class="orangeLetter">*</span></label>
						<input type="text" name="txtEmpName" id="txtEmpName" class="form-control input-lg" tabindex="3" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
					<label>Your Designation<span class="0">*</span></label>
                       <!-- <select name="selEmpType" id="selEmpType" class="form-control input-lg" required>-->
                        <select name="selEmpType" class=" form-control input-lg" id="selEmpType">
							  <option value="0">Select Any One</option>
							  <?php
							  if(isset($_GET['selEmpType']))
							  {
								$employee->employeeTypeDropDown(0,0,$_GET['selEmpType'],'ADD',0,'emp_type');
							  }
							  elseif(isset($_SESSION['selEmpType']))
							  {
								$employee->employeeTypeDropDown(0,0,$_SESSION['selEmpType'],'ADD',0,'emp_type');
							  }
							  else
							  {
								$employee->employeeTypeDropDown(0,0,0,'ADD',0,'emp_type');
							  }
							  ?>
						</select>
					</div>	
				</div>		
			</div>
			
			
			
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtMobile">Your Mobile No.<span class="orangeLetter">*</span></label>
                        <input type="text" name="txtMobile" id="txtMobile" class="form-control input-lg" tabindex="1" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtEmail">Your Email Address<span class="orangeLetter">*</span></label>
						<input type="email" name="txtEmail" id="txtEmail" class="form-control input-lg" tabindex="2" required>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtAdharNo">Adhar No.<span class="orangeLetter">*</span></label>
                        <input type="text" name="txtAdharNo" id="txtAdharNo" class="form-control input-lg" tabindex="1" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtSecurityNo">Enter Your Security No.<span class="orangeLetter">*</span></label>
						<input type="password" name="txtSecurityNo" id="txtSecurityNo" class="form-control input-lg" tabindex="2" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtFname">First Name<span class="orangeLetter">*</span></label>
                        <input type="text" name="txtFname" id="txtFname" class="form-control input-lg" tabindex="1" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtLname">Last Name<span class="orangeLetter">*</span></label>
						<input type="text" name="txtLname" id="txtLname" class="form-control input-lg" tabindex="2">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="txtGuardian">Your Guardian Name<span class="orangeLetter">*</span></label>
				<input type="text" name="txtGuardian" id="txtGuardian" class="form-control input-lg" tabindex="3" required>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					
				<div class="form-group">
					<label for="txtMstatus">Marital Status<span class="orangeLetter">*</span></label>
					  <select name="txtMstatus" class="form-control input-lg" id="txtMstatus" required>
						<option value="">Select any one</option>
						<option value="married">Married</option>
						<option value="unmarried">Un Married</option>
					</select>
				</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtGender">Gender<span class="orangeLetter">*</span></label>
						<select name="txtGender" class="form-control input-lg" id="txtGender" required>
							<option value="">Select any one</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Date Of Birth<span class="orangeLetter">*</span></label>
				<input type="date" name="txtDOB" id="txtDOB" class="form-control input-lg" tabindex="4" required>
			</div>
			
			
			<hr class="colorgraph">
			<h2><small style="color:#eb9812;">Your Permanent Address</small></h2>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label>Address1<span class="orangeLetter">*</span></label>
						<input type="text" name="txtAddress1" id="txtAddress1" class="form-control input-lg" tabindex="5" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label>Address 2 </label>
						<input type="text" name="txtAddress2" id="txtAddress2" class="form-control input-lg" tabindex="6">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label>Address3</label>
						<input type="text" name="txtAddress3" id="txtAddress3" class="form-control input-lg" tabindex="5">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label>Town<span class="orangeLetter">*</span></label>
						<input type="text" name="txtTown" id="txtTown" class="form-control input-lg" tabindex="5" required>
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label>Postal Code<span class="orangeLetter">*</span></label>
						<input type="text" name="txtPostal" id="txtPostal" class="form-control input-lg" tabindex="5" required>
					</div>
				</div>
			</div>
			
			
			
			
			<hr class="colorgraph">
			<h2><small style="color:#eb9812;">Upload Your Documents</small></h2>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label>Upload Your Photo<span class="orangeLetter">*</span></label>
						<input type="file" name="txtPhotoImg" id="txtPhotoImg" class="form-control input-lg" tabindex="5" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label>Upload Your Adhar Card <span class="orangeLetter">*</span></label>
						<input type="file" name="txtAdhar" id="txtAdhar" class="form-control input-lg" tabindex="6" required>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label>Upload Your Voter Card<span class="orangeLetter">*</span></label>
						<input type="file" name="txtVoter" id="txtVoter" class="form-control input-lg" tabindex="5" required>
					</div>
				</div>
			</div>
			<hr class="colorgraph">
			<h2><small style="color:#eb9812;">Factory Information</small></h2>
			
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtFActory">Factory/Office Name<span class="orangeLetter">*</span></label>
						  <select name="txtFActory" class="form-control input-lg" id="txtFActory" required>
							<option value="">Select any one</option>
							<option value="monienterprises">Monienterprises</option>
							<option value="hmdad">HMDA. Dyeing</option>
							<option value="rozelle">Rozelle</option>
							<option value="sadia">Sadia</option>
						</select>
					</div>
				</div>
			</div>	
			
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtWorkUnder">Worked Under</label>
                        <input type="text" name="txtWorkUnder" id="txtWorkUnder" class="form-control input-lg" tabindex="1">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<label for="txtWorkedType">Worker Type<span class="orangeLetter">*</span></label>
						<select name="txtWorkedType" class="form-control input-lg" id="txtWorkedType" required>
							<option value="">Select any one</option>
							<option value="inhouse">In House</option>
							<option value="vendor">Vendor</option>
						</select>
					</div>
				</div>
			</div>
			
			
			<hr class="colorgraph">
			<div class="row">
				<div class="col-xs-12 col-md-6"><input type="submit" name="txtSubmit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
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