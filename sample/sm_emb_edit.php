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
$mbid			= $utility->returnGetVar('mbid','0');//$hid 	= Hand Id
//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$manualDtls 	= $sample->showSamManualEmb($mbid);
$sampleDtl		= $sample->showSampleDb($manualDtls[1]);

if(isset($_POST['btnEditSamManual']))
{	

	$txtParticularName 	        = $_POST['txtParticularName'];
	$txtLabourRate 	        	= $_POST['txtLabourRate'];
	$txtTime					= $_POST['txtTime'];
	$txtProdDesc 	        	= $_POST['txtProdDesc'];
	
	$labourCost 				= $txtTime * $txtLabourRate;
	
	$prevTotalCost 				= $manualDtls[10];
	$currTotalCost 				= $labourCost + $manualDtls[9] + $manualDtls[8];
	
	$totalCost 					= ($sampleDtl[5] - $prevTotalCost) + $currTotalCost;
	
	//Update Sample Manual Embroidery table
	$sample->EditSamManual($mbid, $txtParticularName,$txtTime,$txtLabourRate,$labourCost,$currTotalCost,$txtProdDesc);
	
	// Update Sample  table
	$sample->UpdateSamDb($manualDtls[1], $sampleDtl[4],$totalCost,$userData[2]);
	
	
	//forward
	$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Sample Manual Data has been updated successfully", 'SUCCESS');
	
}
?>

<title><?php echo COMPANY_S; ?> -  - Edit Sample Manual Data </title>
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
    if( (isset($_GET['action'])) && ($_GET['action'] == 'edit_manual') )
    {
		
		$manualDtls 	= $sample->showSamManualEmb($mbid);
    ?>
	<span>Please  <span class="required"></span>fill the following field.<br></span>
    <form action="<?php $_SERVER['PHP_SELF']?>?mbid=<?php echo $mbid; ?>" method="post">
		
		<div class="cl"></div>
		<label>Particular Name<span class="orangeLetter">*</span></label>
        <input name="txtParticularName" type="text" class="text_box_large" id="txtParticularName" 
		value="<?php echo $manualDtls[4];?>" size="25" />
        <div class="cl"></div>
		
		<div class="cl"></div>
		<label>Labour Rate/Hours<span class="orangeLetter"></span></label>
        <input name="txtLabourRate" type="text" class="text_box_large" id="txtLabourRate" 
		value="<?php echo $manualDtls[6];?>" size="25" />
		<div class="cl"></div>
		
		<label>Total Work Time<span class="orangeLetter"></span></label>
        <input name="txtTime" type="text" class="text_box_large" id="txtTime" 
		value="<?php echo $manualDtls[5];?>" size="25" />
		<div class="cl"></div>
		
		<label>Remarks</label>
        <textarea  name="txtProdDesc" id="txtProdDesc">
		<?php echo $manualDtls[11]; ?>
        </textarea>
        <div class="cl"></div>
		
		<input name="btnEditSamManual" type="submit" class="button-add"  value="edit" />
        <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        
    </form>
    
    <?php 
    }//if
    ?>
</div>