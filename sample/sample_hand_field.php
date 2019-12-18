<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 
require_once("../classes/fabric.class.php"); 

require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php");
require_once("../classes/sample.class.php"); 
require_once("../classes/employee.class.php"); 


/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$sample			= new Sample();
$employee		= new Employee();
$fabric		    = new Fabric();


if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 30))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Material-<?php echo $i; ?></h3>
		
		
		
		<div >
			<label>Material Name<span class="orangeLetter"></span></label>							
			<select name="txtMaterialName[]" type="text" id="txtMaterialName" class="text_box_large">
				<?php
					$matDtls         = $fabric->fabricDtls();
					foreach ($matDtls as $row){//Array or records stored in $row
					//echo $row[colour_name];
				?>	
					<option value="<?php echo $row['fabric_name'];?>"><?php echo $row['fabric_name'];?></option>
				<?php
				/* Option values are added by looping through the array */ 
									
					}

					echo "</select>";//?>
		</div>
        <div class="cl"></div>

		<label>Material Amount</label>
        <input name="txtMatAmount[]" id="txtMatAmount" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label>Material Unit</label>
        <input name="txtMUnit[]" id="txtMUnit" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label> Material Rate/Unit</label>
        <input name="txtMaterialRate[]" id="txtMaterialRate" type="text" class="text-field" />
        <div class="cl"></div>
        
		
        

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

