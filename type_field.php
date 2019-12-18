<?php 
session_start();
//include_once('checkSession.php');
require_once("_config/connect.php"); 
require_once("includes/constant.inc.php"); 
require_once("includes/content.inc.php"); 
require_once("classes/order.class.php"); 
require_once("classes/sample.class.php"); 
require_once("classes/product_status.class.php");
require_once("classes/ratechart.class.php");
require_once("classes/product_stock.class.php"); 
require_once("classes/unit.class.php"); 
require_once("classes/stock.class.php"); 
require_once("classes/error.class.php"); 
require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php");

/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$sample			= new Sample();	
$prodStatus		= new Pstatus();
$ratechart		= new Ratechart();
$productStock	= new ProductStock();
$unit			= new Unit();
$stock			= new Stock();

$designNo		= $utility->returnGetVar('designNo',0);// designNo->order id

$oid			= $designNo;

$orderDtl       = $orders->showOrders($oid);
$ordDtlDetls    = $orders->ordersDtlDisplay($oid);

$dyeRateDtls 	= $ratechart->dyeRateData();

//$sid  = 3;
//$deyDtl         = $sample->getAllfabricDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 30))
{
	$selNum		= $_GET['selNum'];
	
	$colourDetails         = $stock->ColourDisplay($orderDtl[1]);
	
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Type/Particulars-<?php echo $i; ?></h3>
        <div class="cl"></div>
			<div >
				<label>Fabric Type/Particulars Name<span class="orangeLetter">*</span></label>							
				<select name="txtProductType[]" type="text" id="txtProductType" class="text_box_large">
				<?php
					//$customerDetails         = $customer->getAllCustomerDtlPipeline(8);
					foreach ($dyeRateDtls as $row){//Array or records stored in $row
					//echo $row[colour_name];
				?>	
					<option value="<?php echo $row['fabric_name'];?>"><?php echo $row['fabric_name'];?></option> 
				<?php
					/* Option values are added by looping through the array */ 
									
					}

					echo "</select>";//?>
			</div>
			<div class="cl"></div>
			<!--<div >
				<label>Colour<span class="orangeLetter">*</span></label>							
					<select name="txtColour[]" type="text" id="txtColour" class="text_box_large">
						<?php
					/*		$colourDetails         = $unit->MstColourDisplay();
							foreach ($colourDetails as $eachrecord){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$eachrecord[colour_name]>$eachrecord[colour_name]</option>"; 

							//* Option values are added by looping through the array 
									
						}

					echo "</select>";*/
					//?>
			</div>
			-->
			<label>No Of Colour</label>
			<input name="txtNoOfColor[]" id="txtNoOfColor" type="text" class="text-field"/>
			<div class="cl"></div>
		  
			<div class="cl"></div>
			<label>Colour</label>
			<input name="txtColour[]" id="txtColour" type="text" class="text-field" style="text-align: centre;"
			value="<?php
					foreach ($ordDtlDetls as $row){//Array or records stored in $row
						$colour[] = $row['colour'];
						
				}
				echo implode(",",$colour);
				$colour = null;

				?> "
			/>
			<div class="cl"></div>
			
			<div class="cl"></div>
			<label>Fabric/Colour(Meters)</label>
			<input name="txtFabricAmount[]" id="txtFabricAmount" type="text" class="text-field"/>
			<div class="cl"></div>
			
<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

?>
