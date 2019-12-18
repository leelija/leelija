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
require_once("../classes/stock.class.php"); 

require_once("../classes/fabric.class.php"); 
require_once("../classes/rate.class.php"); 
require_once("../classes/labour.class.php"); 
require_once("../classes/meals.class.php"); 


require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();

$orders		    = new Orders();
$fabric		    = new Fabric();
$rate		    = new Rate();
$labour		    = new Labour();

$search_obj		= new Search();
$pages			= new Pagination();

$stock			= new Stock();
$meals			= new Meals();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################



if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 20))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Labour -<?php echo $i; ?></h3>
        <div class="cl"></div>
			<div >
				<label>Labour<span class="orangeLetter">*</span></label>							
					<select name="txtEmpid[]" type="text" id="txtEmpid[]" class="text_box_large">
						<option value="">Select</option>
						<?php
							$labourDetails         = $labour->LabourDtlDisplay();
							foreach ($labourDetails as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[labour_id]>$row[labour_name]</option>"; 

							/* Option values are added by looping through the array */ 
													
							}

					echo "</select>";//?>
			</div>
		<div class="cl"></div>
       
		
		<label>NO. Of Meals<span class="orangeLetter">*</span></label>
		<input name="txtNoOfMeals[]" type="text" class="text_box_large" id="txtNoOfMeals" 
			value="" size="25" />
		<div class="cl"></div>
							
		<label>Meals Rate<span class="orangeLetter">*</span></label>
		<input name="txtMealsRate[]" type="text" class="text_box_large" id="txtMealsRate" 
			value="" size="25" />
		<div class="cl"></div>
	
		<div class="cl"></div>
		

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
