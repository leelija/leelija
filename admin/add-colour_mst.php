<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/photo_gallery.class.php");
require_once("../classes/sample.class.php"); 
require_once("../classes/unit.class.php"); 

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$photogallery	= new PhotoGAllery();
$sample			= new Sample();
$unit			= new Unit();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare variables
$typeM		= $utility->returnGetVar('typeM','');
//$oid		= $utility->returnGetVar('oid','');

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);


if(isset($_POST['btnAddSamplePhoto']))
{
	//hold the post vars
	$txtColourName				= $_POST['txtColourName'];
	
	$duplicateId	= $error->duplicateUser($txtColourName, 'colour_name', 'colour_mst');
	
	//add the additional images
	if($txtColourName	==''){
		echo "The Colour Name is empty.";
	}
	elseif( ($txtColourName != '') && (preg_match("/^ER/i",$duplicateId)) )		
	{
		
		$error->showErrorTA($action, $id, $id_var, $_SERVER['PHP_SELF'], "Colour is already in use", $typeM, $anchor);
	}	
	else{
		
			//add orders image
			$unit->addMColour($txtColourName,$userData[10]);
			
			//forward
			$uMesg->showSuccessT('success', $cid, 'cid', $_SERVER['PHP_SELF'],"Colour has been successfully added", 'SUCCESS');
	
			
		}//upload
		
	
	
}
?>

<title><?php echo COMPANY_S; ?> -Add Colour</title>
<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<script type="text/javascript" src="../js/product.js"></script>
<!-- eof JS Libraries -->

<table class="tblBrd" align="center" width="650">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
	<?php 
	//CREATING NEW USER FORM
	if( (isset($_GET['action'])) && ($_GET['action'] == 'add_img') )
	{
		//static detail
		//$ordDetail = $orders->showOrders($oid);
			
	?>
	<tr>
	  <td height="25" align='left' bgcolor="#EEEEEE">
	  	<h3><a name="addSub">Add Colour </a> </h3>
	</td>
    </tr>
	<tr>
	  <td>
	  
	  <form action="<?php echo $_SERVER['PHP_SELF']."?action=add_img";?>"
	  method="post"  enctype="multipart/form-data" />
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<div class="cl"></div>
			<label>Colour Name</label>
			<input name="txtColourName" id="txtColourName" type="text" class="text-field" />
			<div class="cl"></div>
			
			
			<tr>
				<td align="left" class="menuText">&nbsp;</td>
				<td height="20" align="left" class="bodyText">&nbsp;</td>
			</tr>
			  
			<tr>
				<td class="menuText">&nbsp;</td>
				<td height="25" align="left">
					<input name="btnAddSamplePhoto" type="submit" class="button-add" value="add" />
					<input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />		
					
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>

	  </form>
	  </td>
	</tr>
	<?php 
	}//eof
	?>
</table>