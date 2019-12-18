<?php
ob_start();
session_start(); 
include_once('_config/connect.php'); 

require_once("includes/constant.inc.php");

include_once('classes/encrypt.inc.php'); 
include_once('classes/adminLogin.class.php'); 
include_once('classes/employee.class.php'); 

require_once("classes/utility.class.php");
require_once("classes/utilityMesg.class.php"); 

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
/*	
if(isset($_POST['btnEntry']))
{
	$txtAdhar 	= $_POST['txtAdhar']; 
	
	if(($txtAdhar == ''))
	{
		header("Location: ".$_SERVER['PHP_SELF']."?msg=invalid Aadhaar Card No.");
	}
	else
	{
		//echo $txtAdhar;exit;
		$employee->empAttendance($txtAdhar,'adhar_no',$attDate,$attDateTime,'employee');
	}
}

*/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Employee Status check</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
<link rel="stylesheet" type="text/css" href="style/admin/admin-index.css">
<link rel="stylesheet" type="text/css" href="style/admin/common.css">
<link rel="stylesheet" type="text/css" href="style/admin/custom.css">
<link rel="stylesheet" type="text/css" href="style/admin/responsive.css">

<script type="text/javascript" src="js/employee-status.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>

</head>

<body>
	
    <!-- Page Heading -->
    <div id="crm-login-page-heading-back">
    	<h1><?php echo COMPANY_S; ?> Employee Status</h1>
    </div>
    <!-- eof Page Heading -->
	
	<!--<h2 style="text-align: center;color: blue;"><?php echo date('d-m-Y'); echo '&nbsp;';echo date("H:i:s", $time);?></h2>-->
	<div id="time">
		<h2 style="text-align: center;color: blue;"><span id="hour">hh</span>:<span id="min">mm</span>:<span id="sec">ss</span></h2>
	</div>
    
   <!-- Login -->
	<div id="adminPanelLogin">
    	<div id="loginBox">
			<div class="mesg" id="aMesg"><?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?></div>
        	<h2>Check Your Status</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" name="frmLogin">
            	
                <input name="txtAdhar" id="txtAdhar" type="text" class="login" placeholder="Aadhaar Card No(আধার কার্ড নম্বর)" required />
                <div class="cl"></div>
                
				<input type="button" class="loginButton"  value="Submit" onClick="empStatus()"/>
               <!-- <input name="btnEntry" id="btnEntry" type="submit" class="loginButton" value="Submit" />-->
            </form>
        </div>
    </div>
	<!-- eof Login -->
	
	<div id="empStatusRpt"></div>
	
</body>

<script>
setInterval(update, 1000);
function update() {
  var date = new Date()

  var hours = date.getHours()
  if (hours < 10) hours = '0'+hours
  document.getElementById('hour').innerHTML = hours

  var minutes = date.getMinutes()
  if (minutes < 10) minutes = '0'+minutes
  document.getElementById('min').innerHTML = minutes

  var seconds = date.getSeconds()
  if (seconds < 10) seconds = '0'+seconds
  document.getElementById('sec').innerHTML = seconds
}
</script>
</html>
