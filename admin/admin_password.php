<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php");
require_once("../includes/constant.inc.php");
require_once("../includes/user.inc.php");
 
require_once("../classes/adminLogin.class.php"); 

require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 


//instantiate classes
$adminLogin 	= new adminLogin();

$dateUtil      	= new DateUtil();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();

###############################################################################################

//declare vars
$typeM		= $utility->returnGetVar('typeM','');

if(isset($_GET['id']))
{
	$admin_user = $_GET['id'];
	
}


if(isset($_POST['btnEditPass']))
{
	$password 	= $_POST['txtPass'];
	$cnfPass  	= $_POST['txtCnfPass'];
	
	//defining error variables
	$action		= 'edit_pass';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $admin_user;
	$id_var		= 'id';
	$anchor		= 'editPass';
	$typeM		= 'ERROR';
	
	
	if(strlen($password) < 6)
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU117, $typeM, $anchor);
	}
	elseif($password != $cnfPass )
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU107, $typeM, $anchor);
	}
	else
	{
		//change the password
		$adminLogin->changePassword($admin_user, $password);
		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], SUADM004, 'SUCCESS');
	}
}
?>

<title><?php echo COMPANY_S; ?> - Change Password</title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<table class="tblBrd" align="center" width="98%">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
    
	<?php 
	if( (isset($_GET['action'])) && ($_GET['action'] == 'edit_pass') )
	{
		$userDetail = $adminLogin->getUserDetail($admin_user);
	?>
	<tr>
	  <td height="25" align='left' bgcolor="#EEEEEE"><h3>Change  User Password </h3></td>
	</tr>
	<tr>
	  <td>
	  <form action="<?php echo $_SERVER['PHP_SELF'];?>?id=<?php echo $admin_user; ?>" method="post">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="105" height="25" align="left" class="menuText">User Name </td>
			<td width="72%" height="20" align="left" class="orangeLetter">
			 <?php echo $admin_user; ?>
			</td>
		  </tr>
		 
		  <tr>
			<td width="105" height="25" align="left" class="menuText">Full Name </td>
			<td height="20" align="left" class="bodyText">
			<?php echo $userDetail[0]; ?>  <?php echo $userDetail[1]; ?>
			</td>
		  </tr>
		 <tr>
			<td height="25" align="left" valign="top" class="menuText">Password</td>
			<td height="20" align="left" class="bodyText">
			<input name="txtPass" type="password" class="text_box_large" id="txtPass" size="25"> 
			  <span class="orangeLetter">*</span> (minimum 6 chars) </td>
		  </tr>
		  <tr>
			<td height="25" align="left" valign="top" class="menuText">Confirm Password </td>
			<td height="20" align="left"><input name="txtCnfPass" type="password" class="text_box_large" id="txtCnfPass" size="25">
			  <span class="orangeLetter">*</span> </td>
		  </tr>
		  <tr>
			<td height="20" colspan="2" align="left" class="menuText">&nbsp;					  </td>
		  </tr>
		  <tr>
			<td width="105" class="menuText">&nbsp;</td>
			<td height="25" align="left">
			<input name="btnEditPass" type="submit" class="button-add" id="btnEditUser" value="edit">
			<input name="btnCancel" type="button" class="button-cancel" id="btnCancel" onClick="self.close()" value="cancel">
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
	}
	?>
</table>