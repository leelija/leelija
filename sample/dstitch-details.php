<?php 
ob_start();
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 
require_once("../classes/unit.class.php"); 

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
$sample 		= new Sample();

$stock 			= new Stock();
$unit			= new Unit();


//$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
//$sampleDetails         = $sample->getAllcolourDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 12))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Round-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
       <!-- <label>Colour Name</label>
        <input name="txtColourType[]" id="txtColourType" type="text" class="text-field" />
        <div class="cl"></div>-->
		
		<div class="cl"></div>
		<div >
			<label>Production Type<span class="orangeLetter">*</span></label>							
				<select name="txtProdType[]" type="text" id="txtProdType" class="text_box_large">
					<option value="nor-prod">NormalProduction</option>
					<option value="sample">Sample</option>
					<option value="cod">Code</option>
					<option value="badla">Badla</option>
				</select>	
		</div>
	
        <div class="cl"></div>
		<label>Order Id</label>
        <input name="txtOrderId[]" id="txtOrderId" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label>Design No</label>
        <input name="txtDesignNo[]" id="txtDesignNo" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label>Round Stitch</label>
        <input name="txtStitch[]" id="txtStitch" type="text" class="text-field" />
        <div class="cl"></div>
		<div >
			<label>No of Head<span class="orangeLetter">*</span></label>							
				<select name="txtNoOfHead[]" type="text" id="txtNoOfHead" class="text_box_large">
					<option value="16">16</option>
					<option value="15">15</option>
					<option value="14">14</option>
					<option value="13">13</option>
					<option value="12">12</option>
					<option value="11">11</option>
					<option value="10">10</option>
					<option value="9">9</option>
					<option value="8">8</option>
					<option value="7">7</option>
					<option value="6">6</option>
					<option value="5">5</option>
					<option value="4">4</option>
					<option value="3">3</option>
					<option value="2">2</option>
					<option value="1">1</option>
				</select>	
		</div>


	   <div class="cl"></div>
	  

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
