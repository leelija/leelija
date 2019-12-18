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
require_once("../classes/fabric.class.php");


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
$fabric			= new Fabric();


//$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
//$sampleDetails         = $sample->getAllcolourDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 10))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
		<div class="cl"></div>
    	<h3>Fabric-<?php echo $i; ?></h3>
        <div class="cl"></div>
		
		<div >
			<label>Fabric<span class="orangeLetter">*</span></label>							
				<select name="txtFabricId[]" type="text" id="txtFabricId" class="text_box_large">
					<?php
						$fabricDetails         = $fabric->fabricDtls();
						foreach ($fabricDetails as $row){//Array or records stored in $row
						//echo $row[colour_name];
						echo "<option value=$row[fabric_id]>$row[fabric_name]</option>"; 
									
						/* Option values are added by looping through the array */ 
									
						}

				echo "</select>";//?>
		</div>
		
		
		
         <div class="cl"></div>
		<label>Fabric Amount(In Unit)<span class="orangeLetter">*</span></label>
        <input name="txtAmount[]" type="text" class="text_box_large" id="txtAmount" 
					         size="25" />
        <div class="cl"></div>
							
		<label>Company Name<span class="orangeLetter"></span></label>
        <input name="txtCompany[]" type="text" class="text_box_large" id="txtCompany" 
					         size="25" />
        <div class="cl"></div>
		<label>From<span class="orangeLetter"></span></label>
        <input name="txtFrom[]" type="text" class="text_box_large" id="txtFrom" 
					         size="25" />
        <div class="cl"></div>
		<label>Price/unit<span class="orangeLetter">*</span></label>
        <input name="txtPrice[]" type="text" class="text_box_large" id="txtPrice" 
					         size="25" />
        <div class="cl"></div>
		
	  

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
