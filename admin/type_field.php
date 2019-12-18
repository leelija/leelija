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
    	<h3>Fabric-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
		<label>Worker Type<span class="orangeLetter">*</span></label>
			<select name="txtWorker[]" id="txtWorker" class="textBoxA" >
				<option value="In House">In House</option>
				<option value="Vendor">Vendor</option>
			</select>
		<div class="cl"></div>
        <label>Fabric Name</label>
        <input name="txtProductType[]" id="txtProductType" type="text" class="text-field" />
        <div class="cl"></div>
		
	<!--	<label> Quantity/piece(in meter)</label>
        <input name="txtFabricAmount[]" id="txtFabricAmount" type="text" class="text-field" />
        <div class="cl"></div>
		-->
		<label> Fabric Rate/Meter</label>
        <input name="txtAmountPiece[]" id="txtAmountPiece" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label> Work time</label>
        <input name="txtWorktime[]" id="txtWorktime" type="text" class="text-field" />
        <div class="cl"></div>
	<!--	<label> Labour Cost/Meter</label>
        <input name="txtLabourCost[]" id="txtLabourCost" type="text" class="text-field" />
        <div class="cl"></div>
      -->  
        

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

