<?php 
session_start();
//include_once('checkSession.php');
require_once("_config/connect.php"); 
require_once("includes/constant.inc.php"); 
require_once("includes/content.inc.php"); 

require_once("classes/order.class.php"); 
require_once("classes/sample.class.php"); 
require_once("classes/product_status.class.php");
require_once("classes/product_stock.class.php"); 
require_once("classes/status_cat.class.php");

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
$productStock	= new ProductStock();
$statusCat		= new StatusCat();

$designNo		= $utility->returnGetVar('designNo',0);// designNo->order id

$oid			= $designNo;// $oid -> order id
$orderDtl       = $orders->showOrders($oid);
$orderColorDtl	= $orders->ordersDtlDisplay($oid);
$handDtls 		= $statusCat->handDtlDisplay($oid);
//hand sample details
$shandDtls 		= $sample->getAllHandDtlDisplay($orderDtl[1]);

//$sid  = 3;
//$deyDtl         = $sample->getAllfabricDtl($sid);
//echo $oid;exit;
if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 30))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
	
	<?php 					

		$deyDtl         = $sample->getAllHandDtlDisplay($orderDtl[1]);
			If(count($deyDtl) == 0)
				{
					echo "Don't created sample product for this design number";
				}
		?>
		
	<p style="color: red;">	Order Details:	
		<?php
			foreach ($orderColorDtl as $row){
				echo $row['colour'];echo "->";echo $row['quantity'];
			}
		?>
		<br>Left Assign Quantity Details:
		<?php
			foreach ($orderColorDtl as $row){
				$leftQty	=	$row['quantity'] - $row['hand_rquantity'];
				echo $row['colour'];echo "->";echo $leftQty;
			}
		?>
	</p>	
    	<h3>Colour-<?php echo $i; ?></h3>
			<div class="cl"></div>
			<div >
				<label>Particular<span class="orangeLetter">*</span></label>							
					<select name="txtParticular[]" type="text" id="txtParticular" class="text_box_large">
						<?php
						//	$pColourDetails         = $productStock->ColourDisplay($orderDtl[1]);
							foreach ($shandDtls as $row){//Array or records stored in $row
						?>		
							
							<option value="<?php echo $row['sample_particular'];?>">
								<?php echo $row['sample_particular'];?>(<?php echo $row['work_type'];?>)
							</option>
						<?php
							/* Option values are added by looping through the array */ 
									
							}

					echo "</select>";//?> 
			</div>
							 
			<div class="cl"></div>
			
			<div >
				<label>Colour<span class="orangeLetter">*</span></label>							
					<select name="txtColor[]" type="text" id="txtColor" class="text_box_large">
						<?php
						//	$pColourDetails         = $productStock->ColourDisplay($orderDtl[1]);
							foreach ($orderColorDtl as $row){//Array or records stored in $row
							//echo $row[colour_name];
						?>	
							<option value="<?php echo $row['colour'];?>"><?php echo $row['colour'];?></option> 
						
						<?php
							/* Option values are added by looping through the array */ 
									
							}

					echo "</select>";//?> 
			</div>
							 
			<div class="cl"></div>
		
			<label>Quantity(Pieces)</label>
			<input name="txtFabricAmount[]" id="txtFabricAmount" type="text" class="text-field"
				value="<?php $orders->TotalQuantitySum($oid);?>" />
			<div class="cl"></div>
		<!--				
			<div class="cl"></div>
			<div >
				<label>Material Name<span class="orangeLetter">*</span></label>		
				<input name="txtMaterialName[]" id="txtMaterialName" type="text" class="text-field"/>
						
			</div>
			<div class="cl"></div>
			<label> Material Amount</label>
			<input name="txtMatamount[]" id="txtMatamount" type="text" class="text-field"value=""/>
			<div class="cl"></div>
						
		-->				
	
<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

