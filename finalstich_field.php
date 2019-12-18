<?php 
session_start();
//include_once('checkSession.php');
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
require_once("classes/sample.class.php");

require_once("classes/status_cat.class.php");
require_once("classes/customer.class.php");
require_once("classes/product_status.class.php");
require_once("classes/rate.class.php"); 
require_once("classes/labour.class.php"); 

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

$statuscat		= new StatusCat();
$sample			= new Sample();

$customer		= new Customer();
$prodStatus		= new Pstatus();
$rate		    = new Rate();
$labour		    = new Labour();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################
//customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);


$final_stich_id				= $utility->returnGetVar('final_stich_id',0);// final_stich_id

//$oid	= $designNo;
$FinalStichDetails = $statuscat->showProductFinalStich($final_stich_id);

// Rate chart object create
//$FinalStichRateDtl 	= $rate->showStichRatePartiwise($FinalStichDetails[18],$FinalStichDetails[3]);
$FinalStichRateDtl 		= $rate->showStichRateDesNo($FinalStichDetails[3]);
$fStichSampleDtls		= $sample->getAllFinalStichDtlDisplay($FinalStichDetails[3]);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 20))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	
	?>						
	
	<!--<p style="color: red;"><?php echo "Rate:&nbsp;&nbsp;";echo $FinalStichRateDtl[3];?></p>-->
    <div class="cl"></div>
	
    <h3>Labour-<?php echo $i; ?></h3>
    <div class="cl"></div>
						
	<div >
		<label>Particular Name<span class="orangeLetter">*</span></label>							
			<select name="txtParticular[]" type="text" id="txtParticular" class="text_box_large">
			<option value="<?php echo $FinalStichDetails[19];?>"><?php echo $FinalStichDetails[19];?></option>
			<?php
			//	$stitchRateDtls        = $rate->getStitchPartRateDtls();
				foreach ($fStichSampleDtls as $row){//Array or records stored in $row
				//echo $row[colour_name];
			?>	
				<option value="<?php echo $row['sample_particular'];?>"><?php echo $row['sample_particular'];?></option> 
			<?php
			/* Option values are added by looping through the array */ 
			}

			echo "</select>";//?>
	</div>
	
	<div class="cl"></div>						
	<label>Quantity(in pieces)<span class="orangeLetter">*</span></label>
    <input name="txtAmount[]" type="text" class="text_box_large" id="txtAmount" 
	value="<?php echo $FinalStichDetails[7];?>" size="25" />
    <div class="cl"></div>
							
							
							<div class="cl"></div>
							<div >
							<label>Labour Name<span class="orangeLetter">*</span></label>							
							
							<select name="txtEmpid[]" type="text" id="txtEmpid" class="text_box_large">
							<?php
							if($userData[3] == 'sabanakazi1992@gmail.com'){	
									$labourDetails         = $labour->LabourDtlDisplayFwise(2);
								}
							else{
									$labourDetails         = $labour->LabourDtlDisplayFwise(1);
								}
							foreach ($labourDetails as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[labour_id]>$row[labour_name]</option>"; 

							/* Option values are added by looping through the array */ 
								
							}

							 echo "</select>";//?>
							 </div>
							<div class="cl"></div>
							
							<div >
							<label>Complete OR Not<span class="orangeLetter">*</span></label>
							 <select name="txtStatus[]" type="text" class="text_box_large" id="txtStatus"  />
			               				 	<option value="complete">Complete</option>
											<!--<option value="running">Running</option>
			                				 <option value="incomplete">Incomplete</option>-->
			               					
			           				  		</select>
                            <div class="cl"></div>
							</div>
						
					 

<?php
              
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
