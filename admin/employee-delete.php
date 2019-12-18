<?php
ob_start();
session_start();
?>
<?php 
//session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php");
require_once("../includes/user.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../classes/error.class.php");
require_once("../classes/customer.class.php"); 
require_once("../classes/order.class.php"); 

require_once("../classes/utility.class.php");
require_once("../classes/utilityMesg.class.php"); 

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$customer		= new Customer();
//$order			= new Order();
$utility		= new Utility();

$uMesg 			= new MesgUtility();


/////////////////////////////////////////////////////////////////////////////////////////////////

//declare variables
$typeM		= $utility->returnGetVar('typeM','');
$cus_id		= $utility->returnGetVar('cus_id','');


if(isset($_POST['btnDeleteCustomer']))
{	
	
	//defining error variables
	$action		= 'delete_client';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $cus_id;
	$id_var		= 'cus_id';
	$typeM		= 'ERROR'; 
	$aname		= '';
	
	//get all id from order table
	//$allOrderIds = $order->getOrdersIdsByCusId($cus_id);
	//print_r($allOrderIds);exit;

	//delete the main image
	$utility->deleteFile($cus_id, 'customer_id' ,'../images/users/', 'image', 'customer');
	foreach($allOrderIds as $k=>$p)
	{
		//echo $p;exit;
		//delete from order table
		$order->deleteOrder($p);	
	}
	//delete from table
	$customer->deleteCustomerAllTab($cus_id, '../images/users/');
	

	
	//forward
	header("Location:".$_SERVER['PHP_SELF']."?action=success&msg=Customer is deleted");


}
?> 

<title><?php echo COMPANY_S; ?>- Customer Delete</title>
<link href="../style/style.css" rel="stylesheet" type="text/css">
<table class="tblBrd" align="center" width="100%">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
		
	<?php 
	if( (isset($_GET['action'])) && ($_GET['action'] == 'delete_client') )
	{
		$cusDetail = $customer->getCustomerData($cus_id);
	?>
	<tr>
	  <td height="25" align='left' bgcolor="#EEEEEE"><h3>Delete Customer</h3></td>
	</tr>
	<tr>
	  <td>
	  <form action="<?php $_SERVER['PHP_SELF']?>?cus_id=<?php echo $cus_id; ?>" method="post">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="20" colspan="2" align="left" class="menuText padT20 padB20">
				Are you sure that you want to delete <span class="bld"><?php echo $cusDetail[5]." ".$cusDetail[6]; ?></span>
			</td>
		  </tr>
		  <tr>
			<td width="105" class="menuText">&nbsp;</td>
			<td width="72%" height="25" align="left">
			<input name="" type="hidden" value="">
			<input name="btnDeleteCustomer" type="submit" class="buttonYellow" 
			id="btnDeleteCustomer" value="delete" />
			<input name="btnCancel" type="button" class="buttonYellow" 
			id="btnCancel" onClick="self.close()" value="cancel" />
</td>
			</tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>

	  </form>
	  </td>
	</tr>
	<?php 
	}//eof
	?>
</table>
