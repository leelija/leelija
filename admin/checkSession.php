<?php 
require_once("../includes/constant.inc.php");

if(!$_SESSION[ADM_SESS])
{
	header("Location: index.php");
} 
?>