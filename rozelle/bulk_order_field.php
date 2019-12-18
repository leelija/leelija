<?php 
ob_start();
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 

require_once("../classes/sample.class.php"); 
require_once("../classes/stock.class.php"); 


require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php");



/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$sample 			= new Sample();

$stock 			= new Stock();


//$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
//$stockDtlDetails         = $stock->stockDtlColor($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 10))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Design<?php echo $i; ?></h3>
        <div class="cl"></div>
        
       <!-- <label>Colour Name</label>
        <input name="txtColourType[]" id="txtColourType" type="text" class="text-field" />
        <div class="cl"></div>-->
		
							<div class="cl"></div>
							<div >
							<label>Design<span class="orangeLetter">*</span></label>							
							
							<select name="txtDesign[]" type="text" id="txtDesign" class="text_box_large">
							<?php
							$stockDtlDetails         = $stock->stockAllDisplay();
							foreach ($stockDtlDetails as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[design_no]>$row[design_no]</option>"; 

							/* Option values are added by looping through the array */ 
								
							}

							 echo "</select>";//?>
							 </div>
							<div class="cl"></div>
							
							<div class="cl"></div>
						
								<tr>
									<label>Select No. of colour</label>
									<!--<td align="left" class="menuText">Select No. Type </td>-->
									<td align="left" class="bodyText pad5">
									<?php 
									//gen number array
									$arr_value	= range(1,8);
									$arr_label	= range(1,8);
									?>
									  <select name="selNum1" id="selNum1" onchange="return getRozBulkColour();"
									   class="textBoxA">
										<option value="0">--Select--</option>
										<?php 
										if(isset($_SESSION['selNum1']))
										{
											$utility->genDropDown($_SESSION['selNum1'], $arr_value, $arr_label);
										}
										else if(isset($_GET['selNum1']))
										{
											$utility->genDropDown($_GET['selNum1'], $arr_value, $arr_label);
										}
										else
										{
											$utility->genDropDown(0, $arr_value, $arr_label);
										}
										?>
									  </select>				    </td>
								  </tr>
								<div class="cl"></div>
								<div id="showRozelleBulkColour"></div>
						
						
					</div>
					<div class="cl"></div>		
					

<?php
                
	}

}
?>
						
<?php							
/*else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}*/
?>