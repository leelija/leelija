<?php 
session_start();
include_once('checkSession.php');
require_once("../connection/connection.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/testimonial.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/notification.class.php");  
require_once("../classes/error.class.php");  
require_once("../classes/date.class.php"); 
 

require_once("../classes/utility.class.php");
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$noti			= new Notification(); 
$dateUtil      	= new DateUtil();
$error 			= new Error();

$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$utility		= new Utility();

#####################################################################################################

//declare variables
$typeM		= $utility->returnGetVar('typeM','');
$id			= $utility->returnGetVar('id','');


if(isset($_POST['btnDelete']))
{	

	$notRecIds		= $noti->getNotRecipientIdByNotId($id);

	
	//delete notification
	$noti->deleteNotification($id);
	
	//delete all notification recipient
	foreach($notRecIds as $k)
	{
		$noti->deleteNotificationRecipient($k);
	}

	//forward
	$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], 'Notification has been successfully deleted', 'SUCCESS');
}
?> 

<title><?php echo COMPANY_S; ?>-Notfication Delete</title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">

<table class="tblBrd" align="center" width="100%">
	<?php 
	//show message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>

	<?php 
	if(isset($_GET['action']) && ($_GET['action'] == 'delete'))
	{
		$notDtl		= $noti->getNotificationData($id);
	?>
	<tr>
	  <td height="25" align='left' bgcolor="#EEEEEE"><h3>Delete Notification </h3></td>
	</tr>
	<tr>
	  <td>
	  <form action="<?php $_SERVER['PHP_SELF']?>?id=<?php echo $id; ?>" method="post">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="20" colspan="2" align="left" class="menuText padT20">
			Are you sure that you want to delete the Notification 
			<span class="orangeLetter">"<?php echo $notDtl[1]; ?>"</span><br />
			</td>
		  </tr>
		  <tr>
			<td width="105" class="menuText">&nbsp;</td>
			<td width="72%" height="25" align="left" class="padT20">
			<input name="btnDelete" type="submit" class="button-add" id="btnDelete" 
			value="delete" />
			<input name="btnCancel" type="button" class="button-cancel" id="btnCancel"
			onClick="self.close()" value="cancel" />
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