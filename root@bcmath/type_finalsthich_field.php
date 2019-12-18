<?php 
session_start();
//include_once('checkSession.php');
require_once("_config/connect.php"); 
require_once("includes/constant.inc.php"); 
require_once("includes/content.inc.php"); 
require_once("classes/order.class.php"); 
require_once("classes/sample.class.php"); 
require_once("classes/product_status.class.php");
require_once("classes/rate.class.php"); 
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
$rate		    = new Rate();
$productStock	= new ProductStock();
$statusCat		= new StatusCat();

$designNo		= $utility->returnGetVar('designNo',0);// designNo->order id

$oid			= $designNo;

$orderDtl       = $orders->showOrders($oid);
$orderColorDtl	= $orders->ordersDtlDisplay($oid);
$countSamedQuty = $orders->getSameDes($oid);
	foreach($countSamedQuty as $eachRow)
		{
			$tsameQty = $eachRow['SUM(quantity)'];
		}
//$sid  = 3;
//$deyDtl         = $sample->getAllfabricDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 30))
{
	$selNum		= $_GET['selNum'];
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
	
	<?php 					

		$sFsdeyDtl         = $sample->getAllFinalStichDtlDisplay($orderDtl[1]);
			If(count($sFsdeyDtl) == 0)
			{
				echo "Sample Data Not Found..";
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
					$leftQty	=	$row['quantity'] - $row['fs_rquantity'];
					echo $row['colour'];echo "->";echo $leftQty;
				}
			?>
		</p>					
						
    	<h3>Particular-<?php echo $i; ?></h3>
        <div class="cl"></div>
			<!--<div >
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
			-->
			<div >
				<label>Particulars<span class="orangeLetter">*</span></label>							
					<select name="txtParticular[]" type="text" id="txtParticular" class="text_box_large">
					<option value="All">All Set</option>
						<?php
						//	$pColourDetails         = $productStock->ColourDisplay($orderDtl[1]);
							foreach ($sFsdeyDtl as $row){//Array or records stored in $row
							//echo $row[colour_name];
						?>		
						<option value="<?php echo $row['sample_particular'];?>"><?php echo $row['sample_particular'];?></option> 
						<?php	
							/* Option values are added by looping through the array */ 
									
							}

					echo "</select>";//?> 
			</div>
			<div class="cl"></div>
			<div class="cl"></div>
			<label>Colour</label>
			<input name="txtColor[]" id="txtColor" type="text" class="text-field" style="text-align: centre;"
			value="<?php
					foreach ($orderColorDtl as $row){//Array or records stored in $row
						echo $row['colour'];echo ',';						
				}
				
				?> "
			/>
			<div class="cl"></div>
			<label> Particulars Quantity</label>
			<input name="txtFabricAmount[]" id="txtFabricAmount" type="text" value="<?php echo $tsameQty;?>" class="text-field"/>
			<div class="cl"></div>
			<!--		
						<div class="cl"></div>
							<div >
							<label>Material Name<span class="orangeLetter">*</span></label>		
								
							<input name="txtMaterialName[]" id="txtMaterialName" type="text" class="text-field"
							/>
							
							 </div>
							<div class="cl"></div>
		
		
						<label> Material Amount</label>
						<input name="txtMatamount[]" id="txtMatamount" type="text" class="text-field"
							value=""/>
						<div class="cl"></div>
						
			-->			
						
						
						
						
					 

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

