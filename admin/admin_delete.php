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
$id			= $utility->returnGetVar('id','');



if(isset($_POST['btnDeleteUser']))
{
	//delete the user
	$adminLogin->deleteUser($id, 'username', 'admin_users');
	
	//forward
	$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], SUADM003, 'SUCCESS');
	
}
?>

<title><?php echo COMPANY_S; ?> - Delete Admin User</title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">

<div class="popup-form">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
			
	<?php 
    if( (isset($_GET['action'])) && ($_GET['action'] == 'delete_user') )
    {
        $userDetail = $adminLogin->getUserDetail($id);
    ?>

      <h3>Delete  User <?php echo $id; ?></h3>

      <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
            Are you sure	that	you	want	to delete the user named :  
            <strong><?php echo $userDetail[0]; ?> <?php echo $userDetail[1]; ?></strong>

            <input name="btnDeleteUser" type="submit" class="button-add" id="btnDeleteUser" value="delete" />
            <input name="btnCancel" type="button" class="button-cancel" id="btnCancel" onClick="self.close()" value="cancel" />


      </form>

    <?php 
    }
    ?>

</div>