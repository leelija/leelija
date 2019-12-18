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
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");

require_once("../classes/customer.class.php"); 


require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$stock			= new Stock();

$customer		= new Customer();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$stockDtlShow  = $stock->getAllStockData();


//$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
//$sampleDetails         = $sample->getAllcolourDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 20))
{
	
	$selNum		= $_GET['selNum'];
	$sid		= $_GET['sid'];
	$stockDetails  = $stock->showStock($sid);
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Products Colours-<?php echo $i; ?></h3>
        <div class="cl"></div>
       
		<div >
			<label>Colour<span class="orangeLetter">*</span></label>							
				<select name="txtProdColour[]" type="text" id="txtProdColour" class="text_box_large">
					<?php
						$stockDtlDetails         = $stock->stockDtlColor($sid);
						foreach ($stockDtlDetails as $row){//Array or records stored in $row
							echo "<option value=$row[colour]>$row[colour]</option>"; 

							/* Option values are added by looping through the array */ 
								
							}

				echo "</select>";//?>
		</div>
		<div class="cl"></div>
							
		<label>Total Products Sales(in pieces)<span class="orangeLetter">*</span></label>
        <input name="txtProductIn[]" type="text" class="text_box_large" id="txtProductIn"size="25" />
        <div class="cl"></div>
		
		

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
