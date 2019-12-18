
<?php 
ob_start();
session_start();
//include_once('checkSession.php');
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
    	<h3>Colour-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
		<label>Fabric</label>
        <input name="txtFabricName[]" id="txtFabricName" type="text" class="text-field" />
        <div class="cl"></div>
		
        <label>Colour</label>
        <input name="txtColourType[]" id="txtColourType" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label>Component Ratio</label>
        <input name="txtColourRatio[]" id="txtColourRatio" type="text" placeholder="red:blue:black" class="text-field" />
        <div class="cl"></div>
        <label>Component Ratio Value</label>
        <input name="txtColourRatioValue[]" id="txtColourRatioValue" type="text" class="text-field" placeholder="2:5:8" />
        <div class="cl"></div>
		
		<label>Audio/Video</label>
        <input name="uploadvideo[]" type="file" class="text_box_large" id="uploadvideo" />
        <div class="cl"></div>
        

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
