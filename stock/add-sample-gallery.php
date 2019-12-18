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
require_once("../classes/customer.class.php"); 

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
$customer		= new Customer();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare variables
$typeM		= $utility->returnGetVar('typeM','');
//$oid		= $utility->returnGetVar('oid','');

//Customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);


if(isset($_POST['btnAddSamplePhoto']))
{
	//hold the post vars
	$txtFactoryId				= $_POST['txtFactoryId'];
	$txtDesignNo				= $_POST['txtDesignNo'];
	$txtTitle					= $_POST['txtTitle'];
	$txtColor					= $_POST['txtColor'];
	//echo $txtTitle;exit;
	$txtPrices					= $_POST['txtPrices'];
	$txtStatus					= $_POST['txtStatus'];
	
	$fileSubImg				=  $_FILES['fileSubImg']['name'];
	
	$fileThumbImg			= $fileSubImg;
	
	//defining error variables
	$action		= 'id';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addStock';
	$typeM		= 'ERROR';
	$msg = '';
	//field validation
	$duplicateId	= $error->duplicateUser($txtDesignNo, 'design_no', 'sample_gallery');
	
	//add the additional images
	if($txtFactoryId	==''){
		echo "The Factory Name is empty.";
	}	
	elseif($txtDesignNo	==''){
		echo "The Design No. empty.";
	}
	elseif( ($txtDesignNo != '') && (preg_match("/^ER/i",$duplicateId)) )		
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Design No. already in use", $typeM, $anchor);
	}
		elseif($_FILES['fileSubImg']['name'] == '')
		{
			echo " The Photos Empty.";
		}	
		else{
		//echo 'test';exit;
		$isDefault		= 'Y';
		$i		= 0;
	
		
			//add orders image
			$sampleImgId	= $photogallery->addSampleGallery($txtFactoryId,$txtDesignNo,$txtTitle,$txtColor,$txtPrices,$txtStatus,'', $isDefault,$userData[2]);
			
		/*	//rename the file
			$newSubName = $utility->getNewName4Arr($i, $_FILES['fileSubImg'], '',
												   $ordImgId);
			
			//upload in the server
			$uImg->imgCropResizeArr($i, $fileSubImg, '', $newSubName, 
								   '../images/products/large/', 800, 800, 
								   $ordImgId,'image', 'order_image_id', 'order_image');
		*/						   
			//rename the file
			$newName = $utility->getNewName4($_FILES['fileSubImg'], '',$sampleImgId);
			
			//upload in the server
			$imgid = $uImg->imgCropResize($_FILES['fileSubImg'], '', $newName, 
								   '../images/spgallery/large/', 
								   2165, 3508, $sampleImgId,'image', 'sample_gallery_id', 'sample_gallery');					   
			//echo $imgid;exit;					   
								   
			//resizing the image
			$uImg->imgCropResize($_FILES['fileSubImg'], '', $newName, 
								   '../images/spgallery/thumb/', 
								   120, 180, $sampleImgId,'thumb_image', 'sample_gallery_id', 'sample_gallery');
								   
		/*	$uImg->imgCropResizeArr($i, $_FILES['fileSubImg'], '', $newName, 
								   '../images/products/order_img/', 80, 80, 
								   $ordImgId,'thumb_image', 'order_image_id', 'order_image');
			*/					   
			
			//forward
			$uMesg->showSuccessT('success', $oid, 'oid', $_SERVER['PHP_SELF'], SUPROD201, 'SUCCESS');
	
			
		}//upload
		
	
	
}
?>

<title><?php echo COMPANY_S; ?> -Add Image</title>
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
	  	<h3><a name="addSub">Add More Image </a> </h3>
	</td>
    </tr>
	<tr>
	<?php //display message
	 $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
	  <td>
	  <form action="<?php echo $_SERVER['PHP_SELF']."?action=add_img";?>"
	  method="post"  enctype="multipart/form-data" />
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<div class="cl"></div>
			<div >
				<label>Factory Name<span class="orangeLetter">*</span></label>							
					<select name="txtFactoryId" type="text" id="txtFactoryId" class="text_box_large">
						<?php
							$factDetails         = $sample->getAllFactory();
							foreach ($factDetails as $eachrecord){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$eachrecord[factory_id]>$eachrecord[factory_name]</option>"; 

							/* Option values are added by looping through the array */ 
									
						}

					echo "</select>";//?>
			</div>
			<div class="cl"></div>
			<label>Design No</label>
			<input name="txtDesignNo" id="txtDesignNo" type="text" class="text-field" />
			<div class="cl"></div>
			
			<div >
				<label>Categories Name<span class="orangeLetter">*</span></label>							
					<select name="txtTitle" type="text" id="txtTitle" class="text_box_large">
						<?php
							$catDetails         = $unit->MstDesCatDisplay();
							foreach ($catDetails as $eachrecord){//Array or records stored in $row
							//echo $row[categories_name];
						?>	
							<option value="<?php echo $eachrecord['categories_name'];?>"><?php echo $eachrecord['categories_name'];?></option>
				<?php
							/* Option values are added by looping through the array */ 
									
						}

					echo "</select>";//?>
			</div>
			
			
			<div class="cl"></div>
			
			<label>Prices</label>
			<input name="txtPrices" id="txtPrices" type="text" class="text-field" />
			<div class="cl"></div>
			<div >
				<label>Colour<span class="orangeLetter">*</span></label>							
					<select name="txtColor" type="text" id="txtColor" class="text_box_large">
						<?php
							$colourDetails         = $unit->MstColourDisplay();
							foreach ($colourDetails as $eachrecord){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$eachrecord[colour_name]>$eachrecord[colour_name]</option>"; 

							/* Option values are added by looping through the array */ 
									
						}

					echo "</select>";//?>
			</div>
			<div class="cl"></div>
			<div >
				<label>Status<span class="orangeLetter">*</span></label>							
					<select name="txtStatus" type="text" id="txtStatus" class="text_box_large">
						<option value="Complete">Complete</option> 
						<option value="Up Coming">Up Coming</option> 
					</select>
			</div>
			<div class="cl"></div>
			
			<label>Image</label>
			<input name="fileSubImg" id="fileSubImg" type="file" class="text-field" />
			<span class="orangeLetter">Best size (2165 X 3508)</span>
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