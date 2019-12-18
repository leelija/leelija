<?php 
session_start();
ob_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");

require_once("../classes/fabric.class.php");
require_once("../classes/customer.class.php");
require_once("../classes/employee.class.php");


require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$stock			= new Stock();

$fabric			= new Fabric();
$customer		= new Customer();
$employee		= new Employee();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$fid			= $utility->returnGetVar('fid','0');

$userId			= $utility->returnSess('userid', 0);


//echo $Design;
//$planDetail = $plan->showPlanDtl($oid);

//echo $Design;

if( (isset($_GET['txtPurpose'])))
{
	$txtPurpose		= $_GET['txtPurpose'];
	//$Design			= $_GET['Design'];
	//echo $Design;
	if($txtPurpose=="Production") 
		{
    ?>
		
		<label>Bill No<span class="orangeLetter">*</span></label>
        <input name="txtBillNo" type="text" class="text_box_large" id="txtBillNo" size="25" />
        <div class="cl"></div>
							
		<label>Quantity<span class="orangeLetter">*</span></label>
        <input name="txtAmount" type="text" class="text_box_large" id="txtAmount"  size="25" />
		<div class="cl"></div>
		<div >
			<label>Received By<span class="orangeLetter">*</span></label>							
			<select name="txtReceiveBy" type="text" id="txtReceiveBy" class="text_box_large">
			<?php
				$empDtls         = $employee->EmployeeDis();
				foreach ($empDtls as $row){//Array or records stored in $row
				//echo $row[colour_name];
			?>	
				<option value="<?php echo $row['emp_id'];?>"><?php echo $row['emp_name'];?>(<?php echo $row['emp_id'];?>)</option> 
			<?php
				/* Option values are added by looping through the array */ 
								
				}

				echo "</select>";//?>
		</div>
		
		<div class="cl"></div>
		
	  <!--=======================Sample=================================================-->
		<?php
		}
		elseif($txtPurpose=="Sample")
			{
		?>
		
			<label>Sample Design No<span class="orangeLetter">*</span></label>
            <input name="txtDesign" type="text" class="text_box_large" id="txtDesign" size="25" />
            <div class="cl"></div>
							
			<label>Quantity<span class="orangeLetter">*</span></label>
            <input name="txtAmount" type="text" class="text_box_large" id="txtAmount"  size="25" />
            <div class="cl"></div>
			
			<div >
			<label>Received By<span class="orangeLetter">*</span></label>							
			<select name="txtReceiveBy" type="text" id="txtReceiveBy" class="text_box_large">
			<?php
				$empDtls         = $employee->EmployeeDis();
				foreach ($empDtls as $row){//Array or records stored in $row
				//echo $row[colour_name];
			?>	
				<option value="<?php echo $row['emp_id'];?>"><?php echo $row['emp_name'];?>(<?php echo $row['emp_id'];?>)</option> 
			<?php
				/* Option values are added by looping through the array */ 
								
				}

				echo "</select>";//?>
			</div>
			
<?php
}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

}
?>