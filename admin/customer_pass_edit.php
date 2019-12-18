<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/customer.class.php"); 
require_once("../classes/utilityMesg.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$utility		= new Utility();
$customer		= new Customer();
$uMesg 			= new MesgUtility();

//////////////////////////////////////////////////////////////////////////////////////////

$typeM			= $utility->returnGetVar('typeM','');

if(isset($_GET['user_id']))
{
	$user_id = $_GET['user_id'];
}


if(isset($_POST['btnEditPass']))
{
	$password 	= $_POST['txtPass'];
	$cnfPass  	= $_POST['txtCnfPass'];
	
	//defining error variables
	$action		= 'edit_pass';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $cusId;
	$id_var		= 'id';
	$anchor		= 'editPass';
	$typeM		= 'ERROR';
	
	if(strlen($password) < 6)
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU117, $typeM, $anchor);
	}
	elseif($password != $cnfPass )
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Password Not Matched", $typeM, $anchor);
	}
	else
	{
		//change the password
		$customer->changeUserPassword($user_id, $password);
		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], "Password has been successfully Changed", 'SUCCESS');
	}
	/*$new_pass 	= $_POST['txtPass'];
	$cnf_pass  	= $_POST['txtCnfPass'];
	
	$customer->editPassword('', $new_pass, $cnf_pass, 'MadkjhdOGADM_session2011_00', $user_id);*/
}
?>

<title><?php echo COMPANY_S; ?> - Change Password</title>
<link href="../style/style.css" rel="stylesheet" type="text/css">
<table class="tblBrd" align="center" width="100%">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
			
	<?php 
	//CREATING NEW USER FORM
	if(isset($_GET['action']))
	{
		if($_GET['action'] == 'edit_pass')
		{
			
			$cusDetail = $customer->getCustomerData($user_id);
	?>
	<tr>
	  <td height="25" align='left' bgcolor="#EEEEEE"><h3>Change Customer Password </h3></td>
	</tr>
	<tr>
	  <td>
	  <form action="<?php echo $_SERVER['PHP_SELF'];?>?user_id=<?php echo $user_id; ?>" method="post">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td height="10" colspan="2" align="left" class="menuText">&nbsp;</td>
	      </tr>
		  <tr>
			<td width="105" align="left" class="menuText">Customer Email </td>
			<td width="72%" height="20" align="left" class="orangeLetter pad5 ">
			 <?php echo $cusDetail[3]; ?>			</td>
		  </tr>
		 
		  <tr>
			<td width="105" align="left" class="menuText">Full Name </td>
			<td height="20" align="left" class="blackLarge pad5">
			<?php echo $cusDetail[5]." ".$cusDetail[6]; ?>		</td>
		  </tr>
		 <tr>
			<td align="left" valign="top" class="menuText padT5">
				Password <span class="orangeLetter">*</span>			</td>
			<td height="20" align="left" class="bodyText pad5">
				<input name="txtPass" type="password" id="txtPass" size="25" 
				class="text_box_large h25" /> 
			  (minimum 6 chars)		    </td>
		  </tr>
		  <tr>
			<td align="left" valign="top" class="menuText padT5">
			Confirm Password <span class="orangeLetter">*</span>			</td>
			<td height="20" align="left" class=" pad5">
			<input name="txtCnfPass" type="password" id="txtCnfPass" size="25" 
			class="text_box_large h25" />			   </td>
		  </tr>
		  <tr>
			<td height="20" colspan="2" align="left" class="menuText">&nbsp;					  </td>
		  </tr>
		  <tr>
			<td width="105" class="menuText">&nbsp;</td>
			<td height="25" align="left">
			<input name="btnEditPass" type="submit" class="buttonYellow" id="btnEditUser" value="edit">
			<input name="btnCancel" type="button" class="buttonYellow" id="btnCancel" onClick="self.close()" value="cancel">			</td>
		  </tr>
		  
		</table>

	  </form>
	  </td>
	</tr>
	<?php }
	}
	?>
</table>