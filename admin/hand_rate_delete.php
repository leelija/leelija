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

require_once("../classes/ratechart.class.php");

require_once("../classes/rate.class.php"); 

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
$rate		    = new Rate();

$ratechart			= new Ratechart();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$drid			= $utility->returnGetVar('drid','0');


if(isset($_POST['btnDeleteOrd']))
{	

	//delete the stock return
	$ratechart->delHandrate($drid);
	
	//forward
	$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], 'Hand rate has been successfully delete ', 'SUCCESS');
	
}
?>

<title><?php echo COMPANY_S; ?> -  - Delete Hand rate </title>
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
    if( (isset($_GET['action'])) && ($_GET['action'] == 'del_HandRate') )
    {
        //$stockDetails = $stock->showStock($sid);
    ?>
    <tr class=''>
	  <td height="25" align='left' bgcolor="#EEEEEE"><h3>Delete Hand rate. :: <?php echo $drid; ?></h3></td>
    </tr>
    <tr>
      <td>
      <form action="<?php $_SERVER['PHP_SELF']?>?drid=<?php echo $drid; ?>" method="post">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="left" class=" blackLarge">
            <div class="marT25 padL10 padR10 padB20" style="color: red;">
            Are you sure	that	you	want	to delete the Hand rate
            <strong><?php echo $drid;; ?></strong> from Hand rate  Table
            
               
            </div>            </td>
          </tr>
          <tr>
            <td height="25" colspan="2" class="menuText padL10">
            
            <input style="background-color:#cae91b; border:none;" name="btnDeleteOrd" type="submit" class="buttonYellow" id="btnDeleteOrd" value="delete" />
            <input style="background-color:#eee; border:none;" name="btnCancel" type="button" class="buttonYellow" id="btnCancel" onClick="self.close()" value="cancel" /></td>
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