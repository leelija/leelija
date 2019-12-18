<?php 
ob_start();
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 

require_once("../classes/sample.class.php"); 
require_once("../classes/stock.class.php"); 


require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php");



/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$sample 			= new Sample();

$stock 			= new Stock();


//$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
//$sampleDetails         = $sample->getAllcolourDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 10))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Particulars-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
       <!-- <label>Colour Name</label>
        <input name="txtColourType[]" id="txtColourType" type="text" class="text-field" />
        <div class="cl"></div>-->
		
		<div class="cl"></div>
		<label>Particulars<span class="orangeLetter">*</span></label>							
		<input name="txtParticulars[]" id="txtParticulars" type="text" class="text-field" />								 
		<div class="cl"></div>
		
		<div class="cl"></div>
		<label>No Of Particulars<span class="orangeLetter">*</span></label>							
		<input name="txtNoOfParticulars[]" id="txtNoOfParticulars" type="text" class="text-field" />	
		
        <div class="cl"></div>
		
		<label>Rate</label>
        <input name="txtRate[]" id="txtRate" type="text" class="text-field" />
        <div class="cl"></div>
		
	  

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
