<?php 
session_start();
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/product.class.php"); 
require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php");

/* INSTANTIATING CLASSES */
$product		= new Product();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();


if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] <= 3))
{
	$selNum		= $_GET['selNum'];

	//display subsection fields
	echo $product->genDesc($selNum);

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', '../images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}


?>