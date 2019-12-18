<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 

require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php");

/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();


if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 10))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Material-<?php echo $i; ?></h3>
		
		<div class="cl"></div>
        <label>Particulars Name</label>
        <input name="txtParticularName[]" id="txtParticularName" type="text" class="text-field" />
        <div class="cl"></div>
        <div class="cl"></div>
        <label>Material Name</label>
        <input name="txtProductType[]" id="txtProductType" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label> Quantity/Piece</label>
        <input name="txtFabricAmount[]" id="txtFabricAmount" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label> Material Cost</label>
        <input name="txtMaterialCost[]" id="txtMaterialCost" type="text" class="text-field" />
        <div class="cl"></div>
        <label> Labour Cost</label>
        <input name="txtLabourCost[]" id="txtLabourCost" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label> Others Cost</label>
        <input name="txtOthersCost[]" id="txtOthersCost" type="text" class="text-field" />
        <div class="cl"></div>
		
		<div class="cl"></div>
        <label> Time</label>
        <input name="txtTime[]" id="txtTime" type="text" class="text-field" />
        <div class="cl"></div>
		
        

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

