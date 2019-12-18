<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 

require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php");
require_once("../classes/sample.class.php"); 
require_once("../classes/employee.class.php"); 

/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$sample			= new Sample();
$employee		= new Employee();


if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 10))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Materials-<?php echo $i; ?></h3>
		
        <div class="cl"></div>
        <label>Material Name</label>
        <input name="txtMaterialName[]" id="txtMaterialName" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label> Material Amount</label>
        <input name="txtMaterialAmount[]" id="txtMaterialAmount" type="text" class="text-field" />
        <div class="cl"></div>
		<label> Material Unit</label>
        <input name="txtMunit[]" id="txtMunit" type="text" class="text-field" />
        <div class="cl"></div>
		
		<label> Material Rate</label>
        <input name="txtMaterialRate[]" id="txtMaterialRate" type="text" class="text-field" />
        <div class="cl"></div>
       
		
		
        

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

