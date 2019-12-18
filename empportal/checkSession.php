<?php 
require_once("../includes/constant.inc.php");

if(!$_SESSION[STAFF_SESS])
{
	header("Location: index.php");
} 
?>