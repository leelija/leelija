<?php
ob_start();
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 

require_once("../classes/employee.class.php"); 
require_once("../classes/stock.class.php"); 
require_once("../classes/sample.class.php"); 


require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();

$employee		= new Employee();
$search_obj		= new Search();
$pages			= new Pagination();

$stock			= new Stock();
$sample			= new Sample();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$stockDtlShow  = $stock->getAllStockData();


//$sid				= $utility->returnGetVar('sid',0);
//echo $sid;
//$sampleDetails         = $sample->getAllcolourDtl($sid);

if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 20))
{
	
	$selNum		= $_GET['selNum'];
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Employee-<?php echo $i; ?></h3>
        <div class="cl"></div>
		
		<label>Employee Name<span class="orangeLetter">*</span></label>
			<select name="txtEmpName[]" type="text" id="txtEmpName" class="text_box_large">
				<?php
					$empTypeDtls         	= $employee->samEmpType();
					
					foreach ($empTypeDtls as $row){//Array or records stored in $row
						$empDtls         		= $employee->EmployeeAllData($row[emp_type_id]);
						foreach ($empDtls as $eachrecord){
						//echo $row[colour_name];
						echo "<option value=$eachrecord[emp_id]>$eachrecord[emp_name]</option>"; 

						/* Option values are added by looping through the array */ 
						}			
					}

				 echo "</select>";//?>
								 
		<div class="cl"></div>	
       
		<label>Post<span class="orangeLetter">*</span></label>
			<select name="txtPost[]" type="text" id="txtPost" class="text_box_large">
				<?php
					$empTypeDtls         = $employee->samEmpType();
					foreach ($empTypeDtls as $row){//Array or records stored in $row
					//echo $row[colour_name];
						echo "<option value=$row[emp_type_id]>$row[employee_type]</option>"; 

						/* Option values are added by looping through the array */ 
									
					}

				 echo "</select>";//?>
								 
		<div class="cl"></div>						 
		
		

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}
