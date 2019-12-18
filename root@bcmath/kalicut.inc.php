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
require_once("classes/kalicut_mst.class.php");

require_once("classes/alter_rate.class.php"); 
require_once("classes/rate.class.php"); 

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
$labour		    	= new Labour();
$altrate	    	= new AlterRate();
$kalicutmst			= new KaliCutMst();
$rate				= new Rate();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();


//$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
//$sampleDetails         = $sample->getAllcolourDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 20))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>kali record-<?php echo $i; ?></h3>
        <div class="cl"></div>
       
		
		<label>Order Id<span class="orangeLetter">*</span></label>
		<input name="txtOrderId[]" type="text" class="text_box_large" id="txtOrderId" 
			value="" size="25" />
		<div class="cl"></div>
							
		<label>Design No<span class="orangeLetter">*</span></label>
		<input name="txtDesignNo[]" type="text" class="text_box_large" id="txtDesignNo" 
			value="" size="25" />
		<div class="cl"></div>
		
		
		
		
		
		
		<div >
				<label>Kali Name<span class="orangeLetter">*</span></label>							
				<select name="txtKaliRateId[]" type="text" id="txtKaliRateId" class="text_box_large">
					<?php
						$kaliDetails         = $rate->getKaliRateDisp();
						foreach ($kaliDetails as $row){//Array or records stored in $row
						//echo $row['kali_type'];exit;
						?>
						<option value=<?php echo $row['kali_rate_id'];?>><?php echo $row['kali_name'];?></option>
					<?php
								
						}

					echo "</select>";//?>
		</div>
		<div class="cl"></div>
		
		<!--<label>Rate</label>
        <input name="txtrate[]" id="txtrate" type="text" class="text-field" />
        <div class="cl"></div>  -->
		<div class="cl"></div>
		
		<label>Kali Quantity</label>
        <input name="txtKaliQuantity[]" id="txtKaliQuantity" type="text" class="text-field" />
        <div class="cl"></div>
		
		
		

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
