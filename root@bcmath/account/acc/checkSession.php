<?php 
require_once("../../includes/constant.inc.php");

if(!$_SESSION[ACC_SESS])
{
	header("Location: index.php");
} 
?>