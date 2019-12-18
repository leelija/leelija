<?php 
ob_start();
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 
require_once("../classes/unit.class.php"); 

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
$sample 		= new Sample();

$stock 			= new Stock();
$unit			= new Unit();


//$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
//$sampleDetails         = $sample->getAllcolourDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 19))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Colour-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
		<label>Design No<span class="orangeLetter">*</span></label>
        <input name="txtDesignNo[]" type="text" class="text_box_large" id="txtDesignNo" 
		value="<?php $utility->printSess2('txtDesignNo',''); ?>" size="25" />
        <div class="cl"></div>
		<div >
			<label>Product colour<span class="orangeLetter">*</span></label>							
			<select name="txtProductColour[]" type="text" id="txtProductColour" class="text_box_large">
			<?php
				$colourDetails         = $unit->MstColourDisplay();
				foreach ($colourDetails as $eachrecord){//Array or records stored in $row
				//echo $row[colour_name];
			?>	
			<option value="<?php echo $eachrecord['colour_name'];?>"><?php echo $eachrecord['colour_name'];?></option>
			<?php
				/* Option values are added by looping through the array */ 
													
			}

			echo "</select>";//?>
		</div>
		<div class="cl"></div>	
							
		
	  

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
