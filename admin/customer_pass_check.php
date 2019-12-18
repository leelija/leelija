<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../classes/error.class.php");  
require_once("../classes/utility.class.php"); 
require_once("../classes/location.class.php"); 

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$lc		 		= new Location();
$utility		= new Utility();


if((isset($_GET['txtPassword'])) &&(strlen($_GET['txtPassword']) >= 6))
{
	echo "<label class='greenLetter'>Success !!!</label>";
}
else
{
	echo "<label class='orangeLetter'>Error: password is short</label>";
}


?>