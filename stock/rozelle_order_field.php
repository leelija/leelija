<?php 
ob_start();
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 

require_once("../classes/sample.class.php"); 
require_once("../classes/product_stock.class.php"); 


require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php");



/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$sample 		= new Sample();
$productStock	= new ProductStock();


$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
$stockDtlDetails        = $productStock->stockProdDtlColor($sid);
$stockDetails  			= $productStock->showProductStock($sid);
if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 21))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Colour-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
       <!-- <label>Colour Name</label>
        <input name="txtColourType[]" id="txtColourType" type="text" class="text-field" />
        <div class="cl"></div>-->
		
							<div class="cl"></div>
							<div >
								<label>Colour<span class="orangeLetter">*</span></label>							
								<select name="txtColour[]" type="text" id="txtColour" class="text_box_large">
									<?php
									$pColourDetails         = $productStock->ColourDisplay($stockDetails[1]);
									foreach ($pColourDetails as $row){//Array or records stored in $row
									//echo $row[colour_name];
									echo "<option value=$row[pcolour]>$row[pcolour]</option>"; 

									/* Option values are added by looping through the array */ 
										
									}

								echo "</select>";//?> 
							</div>
							<div class="cl"></div>
							
							<div class="cl"></div>
		
						<!--================show product details--========================-->
							<div>
								<?php 					

								$stockDtlDetails         = $productStock->stockPDtlNetColor($sid);
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
							
							<span style="color: red;"><?php echo $eachrecord['colour'];?></span><?php echo "->";echo $eachrecord['quantity'];?>
							
			
							<?php 

							$reco_record++;
							} 
							?> 
						</div>
					<div class="cl"></div>		
					<!--================show product details end--========================-->	
		
					<label>Quantity(In pieces)<span class="orangeLetter">*</span></label>
                     <input name="txtQuantity[]" type="text" class="text_box_large" id="txtQuantity" 
					 value="<?php echo $eachrecord['quantity']; ?>" size="25" />
                    <div class="cl"></div>	

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
