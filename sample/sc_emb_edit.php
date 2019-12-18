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
$scid			= $utility->returnGetVar('scid','0');//$scid 	= Computer emb id
//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$CompEmbDtls 	= $sample->showSamComputerEmb($scid);
$sampleDtl		= $sample->showSampleDb($CompEmbDtls[1]);

if(isset($_POST['btnEditSamDye']))
{	

	$txtParticular 	        	= $_POST['txtParticular'];
	$txtComDesinNo 	        	= $_POST['txtComDesinNo'];
	$txtOthersCost 	        	= $_POST['txtOthersCost'];
	$txtStichAmount				= $_POST['txtStichAmount'];
	
	$txtProdDesc 	        	= $_POST['txtProdDesc'];
	$txtNoOfHeads 	        	= $_POST['txtNoOfHeads'];
	$txtMcAreaHeads 	        = $_POST['txtMcAreaHeads'];
	
	$txtStichRate				= ((($txtStichAmount / 100) * .8) / $txtMcAreaHeads);// stitch rate per head
	$stichCost 					= $txtNoOfHeads * $txtStichRate;// one pcs stitch rate
	
	$prevTotalCost 				= $CompEmbDtls[12];
	$currTotalCost 				= $stichCost + $txtOthersCost + $CompEmbDtls[11];
	
	//$totalCost 					= ($sampleDtl[5] - $prevTotalCost) + $currTotalCost;
	
	//Update Sample Hand table
	$sample->EditSamComEmd($scid, $txtParticular,$txtComDesinNo,$txtStichAmount,$txtNoOfHeads,$txtOthersCost,
	$currTotalCost,$txtProdDesc);
	
	
	// Update Sample  table
	//$sample->UpdateSamDb($hndDtls[1], $sampleDtl[4],$totalCost,$userData[2]);
	
	
	//forward
	$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Sample Computer embroidery has been updated successfully", 'SUCCESS');
	
}
?>

<title><?php echo COMPANY_S; ?> -  - Edit Sample Hand </title>
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
		
		$CompEmbDtls 	= $sample->showSamComputerEmb($scid);
    ?>
	<span>Please  <span class="required"></span>fill the following field.<br></span>
    <form action="<?php $_SERVER['PHP_SELF']?>?scid=<?php echo $scid; ?>" method="post">
		<div class="cl"></div>
		
		<div class="cl"></div>	
		<label>Particular Name.</label>
		<input name="txtParticular" id="txtParticular" type="text" class="text-field" 
		value="<?php echo $CompEmbDtls[4];?>" />
		
		<div class="cl"></div>
		<label>Computer Design No.</label>
		<input name="txtComDesinNo" id="txtComDesinNo" type="text" class="text-field" 
		value="<?php echo $CompEmbDtls[7];?>" />
		
		<div class="cl"></div>
		<label> Number Of Stich</label>
		<input name="txtStichAmount" id="txtStichAmount" type="text" class="text-field"
		 value="<?php echo $CompEmbDtls[8];?>"/>
		<div class="cl"></div>
							
		<label>No of Heads(for 1 pcs)</label>
		<input name="txtNoOfHeads" id="txtNoOfHeads" type="text" class="text-field" 
		value="<?php echo $CompEmbDtls[18];?>"/>
		<div class="cl"></div>
		
		<label>Ms Area(Heads)</label>
		<input name="txtMcAreaHeads" id="txtMcAreaHeads" type="text" class="text-field" />
		<div class="cl"></div>
		
		<label>Others<span class="orangeLetter"></span></label>
        <input name="txtOthersCost" type="text" class="text_box_large" id="txtOthersCost" 
		value="<?php echo $CompEmbDtls[6];?>" size="25" />
        <div class="cl"></div>
		
		<label>Remarks</label>
        <textarea  name="txtProdDesc" id="txtProdDesc">
		<?php echo $CompEmbDtls[13]; ?>
        </textarea>
        <div class="cl"></div>
		
		<input name="btnEditSamDye" type="submit" class="button-add"  value="edit" />
        <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        
    </form>
    
    <?php 
    }//if
    ?>
</div>