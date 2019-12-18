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
require_once("../classes/product_stock.class.php"); 

require_once("../classes/customer.class.php"); 
require_once("../classes/party.class.php");


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
$productStock	= new ProductStock();

$customer		= new Customer();
$party			= new Party();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//Customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 20))
{
	
	$selNum			= $_GET['selNum'];
	$sid			= $_GET['sid'];
	$stockDetails  	= $productStock->showProductStock($sid);
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Products Colours-<?php echo $i; ?></h3>
        <div class="cl"></div>
		
		<!--================show product details--========================-->
				<div style="color: red;"> Net Sales:
					<?php 					
						$stockDtlDetails         = $productStock->stockProdDtlColor($sid);
						If(count($stockDtlDetails) == 0)
							{
								 echo "product not available";
							}
					?>	
					<?php $reco_record = 0; 
						//echo "$data[2]";
						foreach( $stockDtlDetails as $eachrecord ){
						//$bgColor 	= $utility->getRowColor($i);
						if($reco_record%2==0)
							$classname="evenRow";
								else
									$classname="oddRow";
					?>
					<?php echo $eachrecord['colour'];echo "->";echo $eachrecord['net_sales'];?>
					<?php 
						$reco_record++;
						} 
					?> 
				</div>
				<div class="cl"></div>		
				<!--================show product details end--========================-->
       
		<label>Products Return(in pieces)<span class="orangeLetter">*</span></label>
        <input name="txtProductIn[]" type="text" class="text_box_large" id="txtProductIn" size="25" />
        <div class="cl"></div>
		<div >
			<label>Product Colour<span class="orangeLetter">*</span></label>							
			<select name="txtColour[]" type="text" id="txtColour" class="text_box_large">
				<?php
					//$pColourDetails         = $productStock->ColourDisplay($stockDetails[1]);
					$pColourDetails         = $productStock->stockProdDtlColor($sid);
								
					foreach ($pColourDetails as $row){//Array or records stored in $row
					//echo $row[colour_name];
				?>	
					<option value="<?php echo $row['colour'];?>"><?php echo $row['colour'];?></option>
				<?php
					/* Option values are added by looping through the array */ 
									
				}

				echo "</select>";//?>
		</div>
		<div class="cl"></div>
		
		<div class="cl"></div>
		

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
