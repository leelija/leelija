<?php
ob_start();
session_start();
?>

<?php 
//session_start();
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
//require_once("../classes/tax.class.php");


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
//$tax			= new Tax();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$oid			= $utility->returnGetVar('oid','0');


if(isset($_POST['btnDeleteOrd']))
{	

	//delete the images
	$utility->deleteFile($oid, 'orders_id' ,'../images/products/order_img/', 'image', 'order_image');
	$utility->deleteFile($oid, 'orders_id' ,'../images/products/large/', 'thumb_image', 'order_image');
	
	//delete the orders
	$orders->delOrd($oid);
	
	//forward
	$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], SUPROD003, 'SUCCESS');
	
}
?>

<title><?php echo COMPANY_S; ?> -  - Delete Orders </title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<table class="tblBrd" align="center" width="100%">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
    
	<?php 
    //delete form
    if( (isset($_GET['action'])) && ($_GET['action'] == 'del_ord') )
    {
        $ordDetail = $orders->showOrders($oid);
    ?>
    <tr class=''>
	  <td height="25" align='left' bgcolor="#EEEEEE"><h3>Delete Orders :: <?php echo $ordDetail[0]; ?></h3></td>
    </tr>
    <tr>
      <td>
      <form action="<?php $_SERVER['PHP_SELF']?>?oid=<?php echo $oid; ?>" method="post">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="left" class=" blackLarge">
            <div class="marT25 padL10 padR10 padB20">
            Are you sure	that	you	want	to delete the order 
            <strong><?php echo $ordDetail[0]; ?></strong> from table
            
               
            </div>            </td>
          </tr>
          <tr>
            <td height="25" colspan="2" class="menuText padL10">
            
            <input style="background-color:#cae91b" name="btnDeleteOrd" type="submit" class="buttonYellow" id="btnDeleteOrd" value="delete" />
            <input style="background-color:#cae91b" name="btnCancel" type="button" class="buttonYellow" id="btnCancel" onClick="self.close()" value="cancel" /></td>
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
