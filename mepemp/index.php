<?php
ob_start();
session_start(); 
include_once('../_config/connect.php'); 

require_once("../includes/constant.inc.php");

include_once('../classes/encrypt.inc.php'); 
include_once('../classes/adminLogin.class.php'); 

require_once("../classes/utility.class.php");
require_once("../classes/utilityMesg.class.php"); 

//instantiating classes 
$adminLogin 	= new adminLogin();

$utility		= new Utility();
$uMesg 			= new MesgUtility();

########################################################################################################################

//declare vars
$typeM		= $utility->returnGetVar('typeM','');

if(isset($_POST['btnLogin']))
{
	$login = $_POST['txtLogin']; 
	$password = $_POST['txtPass'];
	if(($login == '') || ($password == ''))
	{
		header("Location: ".$_SERVER['PHP_SELF']."?msg=invalid username or password");
	}
	else
	{
		if($login == 'safikul' OR $login == 'mahabubar'){
			$adminLogin->empvalidate($login, $password, 'username', 'password', 'admin_users');
		}
		else{
			echo "You are a not valid User";
		}
	}
	
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Administrator Control Panel -  CRM</title>
<link rel="stylesheet" type="text/css" href="../style/admin/admin-index.css">
<link rel="stylesheet" type="text/css" href="../style/admin/common.css">
</head>

<body>
	
    <!-- Header -->
   <!-- <div id="header">
        <img src="<?php //echo "../".LOGO_WITH_PATH; ?>" width="<?php //echo LOGO_WIDTH; ?>" height="<?php //echo LOGO_HEIGHT; ?>" 
        alt="<?php //echo LOGO_ALT; ?>" id="logo" />
    </div>-->
    <!-- eof Header -->
    
    <!-- Page Heading -->
    <div id="crm-login-page-heading-back">
    	<h1>Sign in to manage <?php echo COMPANY_S; ?> CRM</h1>
    </div>
    <!-- eof Page Heading -->
	
    <!-- Login -->
	<div id="adminPanelLogin">
    	
        
        
    	<div id="loginBox">
        	<h2>Employee Control Panel</h2>
            
            <div class="mesg"><?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?></div>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="frmLogin">
            	
                <input name="txtLogin" type="text" class="login" required />
                <div class="cl"></div>
                
                <input name="txtPass" type="password" class="security-key" required />
                <div class="cl"></div>
                
                <input name="btnLogin" id="btnLogin" type="submit" class="loginButton" value="Secure Login" />
            </form>
            
            
                <p align="center">
                Copyright &copy; <?php echo START_YEAR." - ".END_YEAR; ?>, 
                <a href="../index.php" title="<?php echo COMPANY_S; ?>"><?php echo URL_S; ?></a>.
				All Rights Reserved.
                </p>
        </div>
    </div>
	<!-- eof Login -->

</body>
</html>
