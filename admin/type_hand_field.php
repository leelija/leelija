<?php 
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 
require_once("../classes/sample.class.php"); 
require_once("../classes/product_status.class.php");

require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php");

/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$sample			= new Sample();	
$prodStatus			= new Pstatus();

$designNo				= $utility->returnGetVar('designNo',0);// designNo->order id

$oid	= $designNo;

$orderDtl         = $orders->showOrders($oid);
//$sid  = 3;
//$deyDtl         = $sample->getAllfabricDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 10))
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
							
						
    	<h3>Particulars-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
       
		
							<div class="cl"></div>
							<div >
							<label>Particulars<span class="orangeLetter">*</span></label>	
							
							<input name="txtProductType[]" id="txtProductType" type="text" class="text-field"
							/>
							
							
							 </div>
							<div class="cl"></div>
		
		
						<label> Particulars Quantity</label>
						<input name="txtFabricAmount[]" id="txtFabricAmount" type="text" class="text-field"
							/>
						<div class="cl"></div>
						
						
						
						
						<div class="cl"></div>
							<div >
							<label>Material Name<span class="orangeLetter">*</span></label>		

							<input name="txtMaterialName[]" id="txtMaterialName" type="text" class="text-field"
							/>
						
							 </div>
							<div class="cl"></div>
		
		
						<label> Material Amount</label>
						<input name="txtMatamount[]" id="txtMatamount" type="text" class="text-field"
							value="<?php  $orders->TotalQuantitySum($oid);?>"/>
						<div class="cl"></div>
						
						
						
						
						
						
					 

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

