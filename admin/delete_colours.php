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
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");

require_once("../classes/plan.class.php");
require_once("../classes/sample.class.php");

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

$plan			= new Plan();
$sample			= new Sample();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$cid			= $utility->returnGetVar('cid','0');


if(isset($_POST['btnDeleteOrd']))
{	

	
	//delete the stock
	$sample->delSampleColour($cid);
	
	//forward
	$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Sample colour has been delete successfully", 'SUCCESS');
	
}
?>

<title><?php echo COMPANY_S; ?> -  - Delete Colour </title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<table class="tblBrd" align="center" width="100%">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
    
	<?php 
    //delete form
    if( (isset($_GET['action'])) && ($_GET['action'] == 'del_colour') )
    {
        $samDetails = $sample->showColour($cid);
    ?>
    <tr class=''>
	  <td height="25" align='left' bgcolor="#EEEEEE"><h3>Delete Sample colour :: <?php echo $samDetails[3]; ?></h3></td>
    </tr>
    <tr>
      <td>
      <form action="<?php $_SERVER['PHP_SELF']?>?cid=<?php echo $cid; ?>" method="post">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="left" class=" blackLarge">
            <div class="marT25 padL10 padR10 padB20">
            Are you sure	that	you	want	to delete the Sample colour
            <strong><?php echo $samDetails[3]; ?></strong> from table
            
               
            </div>            </td>
          </tr>
          <tr>
            <td height="25" colspan="2" class="menuText padL10" style="color:#444;">
            
            <input style="color:#444;" name="btnDeleteOrd" type="submit" class="buttonYellow" id="btnDeleteOrd" value="delete" />
            <input style="color:#444;" name="btnCancel" type="button" class="buttonYellow" id="btnCancel" onClick="self.close()" value="cancel" /></td>
            </tr>
          <tr>
            <td width="105">&nbsp;</td>
            <td width="72%">&nbsp;</td>
          </tr>
        </table>

      </form>
      </td>
    </tr>
    
    <?php 
    }//if
    ?>
</table>