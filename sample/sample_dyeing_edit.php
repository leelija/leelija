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
require_once("../classes/stock.class.php");

require_once("../classes/plan.class.php");
require_once("../classes/sample.class.php");

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
$stock			= new Stock();

$plan			= new Plan();
$sample			= new Sample();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$fid			= $utility->returnGetVar('fid','0');//$fid 	= Fabric Id
//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$fabDtls 		= $sample->showSamFabric($fid);
$sampleDtl		= $sample->showSampleDb($fabDtls[1]);

if(isset($_POST['btnEditSamDye']))
{	

	$txtFabName 	        	= $_POST['txtFabName'];
	$txtFabricAmount			= $_POST['txtFabricAmount'];
	$txtFabRate 	        	= $_POST['txtFabRate'];
	$txtLabourRate				= $_POST['txtLabourRate'];
	$txtOthersCost				= $_POST['txtOthersCost'];
	
	$labourCost 				= $txtFabricAmount * $txtLabourRate;
	
	$prevFabCost 				= $fabDtls[13];
	$currTotalFabCost 			= ($txtFabricAmount * $txtFabRate) + $labourCost + $txtOthersCost;
	
	$totalCost 					= ($sampleDtl[5] - $prevFabCost) + $currTotalFabCost;
	
	//Update Sample Fabric table
	$sample->EditSamFabric($fid, $txtFabName,$txtFabricAmount,$txtFabRate,$txtLabourRate,$labourCost,$txtOthersCost,$currTotalFabCost);
	// Update Sample  table
	$sample->UpdateSamDb($fabDtls[1], $sampleDtl[4],$totalCost,$userData[2]);
	
	
	//forward
	$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Sample Dyeing has been updated successfully", 'SUCCESS');
	
}
?>

<title><?php echo COMPANY_S; ?> -  - Edit Sample Dyeing </title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
 <div class="webform-area">	
	<?php 
	//display message
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
    
	<?php 
    //delete form
    if( (isset($_GET['action'])) && ($_GET['action'] == 'del_sdye') )
    {
		//$partyDetail 	= $party->showParty($PartyId);
		
		$sampleDtls 	= $sample->showSamFabric($fid);
    ?>
	<span>Please  <span class="required"></span>fill the following field.<br></span>
    <form action="<?php $_SERVER['PHP_SELF']?>?fid=<?php echo $fid; ?>" method="post">
		<div class="cl"></div>
		<label>Fabric Name<span class="orangeLetter">*</span></label>
        <input name="txtFabName" type="text" class="text_box_large" id="txtFabName" 
		value="<?php echo $sampleDtls[3];?>" size="25" />
        <div class="cl"></div>
		
		<div class="cl"></div>
		<label>Fabric Quantity(Meters)<span class="orangeLetter">*</span></label>
        <input name="txtFabricAmount" type="text" class="text_box_large" id="txtFabricAmount" 
		value="<?php echo $sampleDtls[4];?>" size="25" />
		<div class="cl"></div>
		
		<label>Fabric Rate/Meter<span class="orangeLetter">*</span></label>
        <input name="txtFabRate" type="text" class="text_box_large" id="txtFabRate" 
		value="<?php echo $sampleDtls[10];?>" size="25" />
        <div class="cl"></div>
		<label>Labour Rate/Meter<span class="orangeLetter">*</span></label>
        <input name="txtLabourRate" type="text" class="text_box_large" id="txtLabourRate" 
		value="<?php echo $sampleDtls[12];?>" size="25" />
		<div class="cl"></div>
		
		<label>Other Cost<span class="orangeLetter">*</span></label>
        <input name="txtOthersCost" type="text" class="text_box_large" id="txtOthersCost" 
		value="<?php echo $sampleDtls[15];?>" size="25" />
        <div class="cl"></div>
		
		<input name="btnEditSamDye" type="submit" class="button-add"  value="edit" />
        <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        
    </form>
    
    <?php 
    }//if
    ?>
</div>