<?php 
ob_start();
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");

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


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare variables
$typeM		= $utility->returnGetVar('typeM','');
$oid		= $utility->returnGetVar('oid','');



if(isset($_POST['btnAddOrd']))
{
	//hold the post vars
	$selNum			= $_POST['selNum'];
	
	//add the additional images
	for($i=0; $i < $selNum; $i++)
	{
		if(isset($_POST['radioIsDefault']))
		{
			$isDefault		= $_POST['radioIsDefault'];
		}
		else
		{
			$isDefault		= 'Y';
		}
		
		//uploading images
		if(($_FILES['fileSubImg']['name'][$i] != '') && ($_FILES['fileThumbImg']['name'][$i] != ''))
		{
			
			//add orders image
			$ordImgId	= $orders->addOrdImage($oid, $_POST['txtSubImgTitle'][$i], $isDefault);
			
			//rename the file
			$newSubName = $utility->getNewName4Arr($i, $_FILES['fileSubImg'], '',
												   $ordImgId);
			
			//upload in the server
			$uImg->imgCropResizeArr($i, $_FILES['fileSubImg'], '', $newSubName, 
								   '../images/products/large/', 800, 800, 
								   $ordImgId,'image', 'order_image_id', 'order_image');
								   
			$uImg->imgCropResizeArr($i, $_FILES['fileThumbImg'], '', $newSubName, 
								   '../images/products/order_img/', 80, 80, 
								   $ordImgId,'thumb_image', 'order_image_id', 'order_image');
								   
			
		}//upload
			
		
	}//for

	//deleting the sessions
	//$product->delSubInSess($selNum);			
	
	//forward
	$uMesg->showSuccessT('success', $pid, 'pid', $_SERVER['PHP_SELF'], SUPROD201, 'SUCCESS');
	
	
}
?>

<title><?php echo COMPANY_S; ?> - Orders - Add Image</title>
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
		$ordDetail = $orders->showOrders($oid);
			
	?>
	<tr>
	  <td height="25" align='left' bgcolor="#EEEEEE">
	  	<h3><a name="addSub">Add More Image </a> </h3>
	</td>
    </tr>
	<tr>
	  <td>
	  <form action="<?php echo $_SERVER['PHP_SELF']."?action=add_img&oid=".$_GET['oid'];?>"
	  method="post"  enctype="multipart/form-data" />
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td colspan="2" align="left" class="menuText pad5">
				<h4 class="padL5">Additional Images</h4>			</td>
	      </tr>
		  <tr>
			<td align="left" class="menuText">Select No. Image </td>
			<td align="left" class="bodyText pad5">
			<?php 
			//gen number array
			$arr_value	= range(1,5);
			$arr_label	= range(1,5);
			?>
			  <select name="selNum" id="selNum" onchange="return getNumDesc(); "
			   class="textBoxA">
				<option value="0">--Select--</option>
				<?php 
				if(isset($_SESSION['selNum']))
				{
					$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
				}
				else if(isset($_GET['selNum']))
				{
					$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
				}
				else
				{
					$utility->genDropDown(0, $arr_value, $arr_label);
				}
				?>
			  </select>				    </td>
		  </tr>
		  
		  <tr>
			<td colspan="2" align="left" class="menuText" id="showDescMsg">
			<?php 
			/*if(isset($_SESSION['selNum']))
			{
				echo $product->genDesc($_SESSION['selNum']);
			}*/
			?>		
			</td>
		  </tr>
		  <tr>
			<td align="left" class="menuText">&nbsp;</td>
			<td height="20" align="left" class="bodyText">&nbsp;</td>
		  </tr>
		  
		  <tr>
			<td class="menuText">&nbsp;</td>
			<td height="25" align="left">
                <input name="btnAddOrd" type="submit" class="button-add" value="add" />
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