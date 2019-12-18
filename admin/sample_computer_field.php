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
    	<h3>Computer Design-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
		
		<label>Particular Name.</label>
        <input name="txtParticular[]" id="txtParticular" type="text" class="text-field" />
        <div class="cl"></div>
        <label>Computer Design No.</label>
        <input name="txtComDesinNo[]" id="txtComDesinNo" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label> Number Of Stich</label>
        <input name="txtStichAmount[]" id="txtStichAmount" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label> stich Rate/100</label>
        <input name="txtStichRate[]" id="txtStichRate" type="text" class="text-field" />
        <div class="cl"></div>
        
        <label> Other Cost</label>
        <input name="txtOtherCost[]" id="txtOtherCost" type="text" class="text-field" />
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
