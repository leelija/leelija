<?php
ob_start();
session_start();
?>
<?php 
//session_start();
require_once("_config/connect.php"); 

require_once("includes/constant.inc.php");
require_once("includes/product.inc.php");

require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php"); 
require_once("classes/order.class.php"); 
require_once("classes/search.class.php");
require_once("classes/pagination.class.php");
require_once("classes/stock.class.php");

require_once("classes/status_cat.class.php");
require_once("classes/customer.class.php");
require_once("classes/product_status.class.php");
require_once("classes/pipe_status.class.php");
require_once("classes/alter_particular.class.php");
require_once("classes/labour.class.php"); 

require_once("classes/alter_rate.class.php"); 

require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php"); 
require_once("classes/utilityImage.class.php");
require_once("classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$stock			= new Stock();

$statuscat			= new StatusCat();

$customer			= new Customer();
$prodStatus			= new Pstatus();
$pipestatus			= new Pipestatus();
$alterParticular	= new AlterParticular();
$labour		    = new Labour();
$altrate	    = new AlterRate();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();


//$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
//$sampleDetails         = $sample->getAllcolourDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 10))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Particular-<?php echo $i; ?></h3>
        <div class="cl"></div>
       
		<label>Order Id<span class="orangeLetter">*</span></label>
        <input name="txtOrderId[]" type="text" class="text_box_large" id="txtOrderId" 
			value="" size="25" />
        <div class="cl"></div>
		
		<label>Design No<span class="orangeLetter">*</span></label>
        <input name="txtDesignNo[]" type="text" class="text_box_large" id="txtDesignNo" 
			value="" size="25" />
        <div class="cl"></div>
		
		<label>Particular<span class="orangeLetter">*</span></label>
        <input name="txtParticular[]" type="text" class="text_box_large" id="txtParticular" 
			value="" size="25" />
        <div class="cl"></div>
		
		<label>Quantity(In pieces)</label>
        <input name="txtQuantity[]" id="txtQuantity" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label>Cost/Pieces</label>
        <input name="txtCost[]" id="txtCost" type="text" class="text-field" />
        <div class="cl"></div>
		
		<div >
				<label>Repair by<span class="orangeLetter">*</span></label>							
				<select name="txtEmpid[]" type="text" id="txtEmpid" class="text_box_large">
					<?php
						$labourDetails         = $labour->LabourDtlDisplay();
						foreach ($labourDetails as $row){//Array or records stored in $row
						//echo $row[colour_name];
						echo "<option value=$row[labour_id]>$row[labour_name]</option>"; 

						/* Option values are added by looping through the array */ 
								
						}

					echo "</select>";//?>
		</div>
		<div class="cl"></div>
		<label>Alter Reason</label>
            <textarea  name="txtProdDesc[]" id="txtProdDesc">
				<?php $utility->printSess2('txtProdDesc',''); ?>
            </textarea>

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
