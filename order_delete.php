<?php 
session_start();
include_once('checkSession.php');
include_once('../_config/connect.php');

require_once("../includes/constant.inc.php");
require_once("../includes/order.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
 
require_once("../classes/error.class.php"); 
require_once("../classes/customer.class.php");
require_once("../classes/countries.class.php");
require_once("../classes/cart.class.php");
require_once("../classes/order.class.php");
require_once("../classes/product.class.php");
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/tax.class.php");
require_once("../classes/shipping.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$client		    = new Customer();
$country		= new Countries();
$cart			= new Cart();
$order			= new Order();
$product		= new Product();
$search_obj		= new Search();
$page			= new Pagination();
$tax			= new Tax();
$shipping		= new Shipping();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

if(!isset($_GET['code']) || !isset($_GET['id']))
{
	exit;
}
else
{
	$code = $_GET['code'];
	$id   = $_GET['id'];
}
//NO OF CUSTOMER



if(isset($_POST['btnDeleteOrder']))
{	
	
	$order->deleteOrder($_GET['id']);
	header("Location:".$_SERVER['PHP_SELF']."?action=success&msg=order is deleted&code=&id=");
	
}
?>

<title><?php echo COMPANY_S; ?> -  Order Delete</title>
<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<div class="popup-form">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	<?php 
                
    //creating new user form
    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'delete_order')
        {
            
            $orderDtl  = $order->getOrderDetail($code,$id);
    ?>

      <h3>Delete Order </h3>

      <form action="<?php $_SERVER['PHP_SELF']."?code=".$_GET['code']."&id=".$_GET['id'];?>" method="post">

            Are you sure	that	you	want	to delete the Order <br /><br />
           	<strong><?php echo $orderDtl[2];?></strong>
            <p class=" orangeLetter">
            Note: It is advisible to cancel the order before deleting it and notify your customer.
            If you delete the order no longer
            the data associated with this order will be available.  
            </p>
            
            <input name="btnDeleteOrder" type="submit" class=" button-add" id="btnDeleteOrder" value="delete" />
            <input name="btnCancel" type="button" class="button-cancel" id="btnCancel" onClick="self.close()" value="cancel" />


      </form>

    <?php 
        }//END OF  IF
    }//END OF  IF
    ?>
