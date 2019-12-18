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

$designNo				= $utility->returnGetVar('designNo',0);// designNo->order id

$oid			= $designNo;

$orderDtl       = $orders->showOrders($oid);
$orderColorDtl	= $orders->ordersDtlDisplay($oid);

//echo $orderDtl[1];exit;
//$sid  = 3;
//$deyDtl         = $sample->getAllfabricDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 20))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
	
	<?php 					

	/*	$cEmbDetails         = $sample->getAllComData($orderDtl[1],'scomputer_embroidery');
		If(count($cEmbDetails) == 0)
			{
				echo "Don't created sample product for this design number";
			}
			*/
	?>	
	<p style="color: red;">	Order Details:	
			<?php
				foreach ($orderColorDtl as $row){
					$qty  	= $row['quantity'];
					echo $row['colour'];echo "->";echo $row['quantity'];
				}
			?>
			<!--<br>Assign Quantity Details:
			<?php
			/*	foreach ($orderColorDtl as $row){
					echo $row['colour'];echo "->";echo $row['comp_rquantity'];
				}
				*/
			?>-->
	</p>
						
	<h3>Comp. Design No -<?php echo $i; ?></h3>
		
		
			<label>No of colour</label>
			<input name="txtNoOfColor[]" id="txtNoOfColor" type="text" class="text-field"
			/>
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
		
			<label>Computer Design No</label>
			<input name="txtDesignNo[]" id="txtDesignNo" type="text" class="text-field"
			/>
			
			<div class="cl"></div>
			<label>Total Stitch</label>
			<input name="txtTotalStirch[]" id="txtTotalStirch" type="text" class="text-field"
			/>
			<div class="cl"></div>
			<label>Stitch Rate/Pcs</label>
			<input name="txtStitchRate[]" id="txtStitchRate" type="text" class="text-field"
			/>
			<div class="cl"></div>
							
			<div >
			<label>Unit<span class="orangeLetter">*</span></label>							
			<select name="txtUnit[]" type="text" id="txtUnit" class="text_box_large">
				<option value="Head">Head</option>
				<option value="Line">Line</option>
			</select>	
			</div>
			<div class="cl"></div>
			
			<div class="cl"></div>
			<label>No of Head OR Line/Pcs</label>
			<input name="txtNoOfHead[]" id="txtNoOfHead" type="text" class="text-field"
			/>
			<div class="cl"></div>
			<label>Additional(Head/Line)</label>
			<input name="txtAdditional[]" id="txtAdditional" type="text" class="text-field"
			/>
			<div class="cl"></div>
			<label>Quantity(Pcs)</label>
			<input name="txtFabricAmount[]" id="txtFabricAmount" type="text" value="<?php echo $qty;?>" class="text-field"
			/>
			<div class="cl"></div>
					
			<div class="cl"></div>
      
			<!--<div >
				<label>Computer Design No.<span class="orangeLetter">*</span></label>	
				<input name="txtDesignNo[]" id="txtDesignNo" type="text" class="text-field"
				value="<?php echo $orderDtl[1];?>" />
							
			</div> -->
			<div class="cl"></div>
			<!--
		
						<label> Number of stich</label>
						<input name="txtNoOfStich[]" id="txtNoOfStich" type="text" class="text-field"
							/>
						<div class="cl"></div>
						
						
						<label> Time </label>
						<input name="txtTime[]" id="txtTime" type="text" class="text-field"
							/>
						<div class="cl"></div>
						
			-->			
						
					 

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

