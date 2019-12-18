<?php 
ob_start();
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 

require_once("../classes/order.class.php"); 

require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php");

/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();


if( (isset($_GET['selNum'])) && ($_GET['selNum'] > 0)  && ($_GET['selNum'] < 10))
{
	$selNum		= $_GET['selNum'];
	
	for($i=1; $i <= $selNum; $i++)
	{
	?>  
    	<h3>Image-<?php echo $i; ?></h3>
        <div class="cl"></div>
        
        <label>Name</label>
        <input name="txtSubImgTitle[]" id="txtSubImgTitle" type="text" class="text-field" />
        <div class="cl"></div>
        
        <label>Image</label>
        <input name="fileSubImg[]" id="fileSubImg" type="file" class="text-field" />
        <span class="orangeLetter">Best size (800 X 800)</span>
        <div class="cl"></div>
        
        <label>Thumb Image</label>
        <input name="fileThumbImg[]" id="fileThumbImg" type="file" class="text-field" />
        <span class="orangeLetter">Best size (80 X 80)</span>
        <div class="cl"></div>

<?php
                
	}

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', '../images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}


