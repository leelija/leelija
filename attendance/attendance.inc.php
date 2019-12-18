<?php
ob_start();
session_start(); 
include_once('../_config/connect.php'); 

require_once("../includes/constant.inc.php");

include_once('../classes/encrypt.inc.php'); 
include_once('../classes/adminLogin.class.php'); 
include_once('../classes/employee.class.php'); 

require_once("../classes/utility.class.php");
require_once("../classes/utilityMesg.class.php"); 

//instantiating classes 
$adminLogin 	= new adminLogin();
$employee 		= new Employee();

$utility		= new Utility();
$uMesg 			= new MesgUtility();

########################################################################################################################

//declare vars
$typeM		= $utility->returnGetVar('typeM','');
date_default_timezone_set('Asia/Calcutta'); 
//echo date("Y-m-d H:i:s"); // time in India
	$attDate 		= date("Y-m-d");// Attendance Date
	$attDateTime 	= date("Y-m-d H:i:s");// Attendance Date time
	$entrTime 		= date_create($attDateTime);
	$currTime 		= date_format($entrTime,"H:i:s");
	
	$time2 = '00:07:00';
	$time = strtotime($currTime) - strtotime($time2) + strtotime('00:00:00');
	

	//$txtAdhar 	= $_POST['txtAdhar']; 
	$txtAdhar 	= $_GET['txtAdhar'];
	//echo $txtAdhar;
	if(($txtAdhar == ''))
	{
		//header("Location: ".$_SERVER['PHP_SELF']."?msg=invalid Aadhaar Card No.");
		echo "invalid Aadhaar Card No..";
	}
	else
	{
		//echo $txtAdhar;exit;
		$employee->empAttendance($txtAdhar,'adhar_no',$attDate,$attDateTime,'employee');
		//echo "Suu";
	}



?>