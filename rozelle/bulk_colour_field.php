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


$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
$stockDtlDetails         = $stock->stockDtlColor($sid);

if( (isset($_GET['selNum1'])) && ($_GET['selNum1'] > 0)  && ($_GET['selNum1'] < 10))
{
	$selNum1		= $_GET['selNum1'];
	
	for($i=1; $i <= $selNum1; $i++)
	{
	?>  
    	<h3>Colour-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
       <!-- <label>Colour Name</label>
        <input name="txtColourType[]" id="txtColourType" type="text" class="text-field" />
        <div class="cl"></div>-->
		
					<!--<div class="cl"></div>
					<label>Colour<span class="orangeLetter">*</span></label>
                    <input name="txtColour[]" type="text" class="text_box_large" id="txtColour" 
					 value="" size="25" />
					<div class="cl"></div>  -->
					
					<div >
							<label>Colour<span class="orangeLetter">*</span></label>							
							
							<select name="txtColour[]" type="text" id="txtColour" class="text_box_large">
							<?php
							$stockDtlDetl         = $stock->GetstockDetlDisplay();
							foreach ($stockDtlDetl as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[colour]>$row[colour]</option>"; 

							/* Option values are added by looping through the array */ 
								
							}

							 echo "</select>";//?>
							 </div>
		
						
					<div class="cl"></div>		
					<!--================show product details end--========================-->	
		
					<label>Quantity(In pieces)<span class="orangeLetter">*</span></label>
                     <input name="txtQuantity[]" type="text" class="text_box_large" id="txtQuantity" 
					 value="" size="25" />
                    <div class="cl"></div>	

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
