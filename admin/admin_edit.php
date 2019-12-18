<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php");
require_once("../includes/constant.inc.php");
require_once("../includes/registration.inc.php");
require_once("../includes/user.inc.php");
 
require_once("../classes/adminLogin.class.php"); 

require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");

//instantiate classes
$adminLogin 	= new adminLogin();

$dateUtil      	= new DateUtil();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();

###############################################################################################

//declare vars
$typeM		= $utility->returnGetVar('typeM','');
$id			= $utility->returnGetVar('id','');


if(isset($_POST['btnEditUser']))
{
	$fname = $_POST['txtFName'];
	$lname = $_POST['txtSurname'];
	$address = $_POST['txtAddress'];
	$email = $_POST['txtEmail'];
	
	
	//defining error variables
	$action		= 'edit_user';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $id;
	$id_var		= 'id';
	$anchor		= 'editUser';
	$typeM		= 'ERROR';
	
	//check for errors
	$email_id  = $error->invalidEmail($email);
	
	if($fname == '' )
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU108, $typeM, $anchor);
	}
	elseif($address == '' )
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERREG004, $typeM, $anchor);
	}
	elseif(ereg("^ER",$email_id))
	{
		$error->showErrorTA($action, $id, $id_var, $url, ER002, $typeM, $anchor);
	}
	else
	{
		//update information
		$adminLogin->updateAdmin($id, $fname, $lname, $address, $email);
		
		//update admin image field		
		if(isset($_POST['delImg']) && ($_POST['delImg'] == 1))
		{
			$utility->deleteFile($id, 'username' ,'../images/admin/user/', 'image', 'admin_users');
		}
		
		//uploading images
		if($_FILES['fileImg']['name'] != '')
		{
			//delete the image before uploading
			$utility->deleteFile($id, 'username' ,'../images/admin/user/', 'image', 'admin_users');
			
			//rename the file
			$newName = $utility->getNewName4($_FILES['fileImg'], '',$id);
			
			//upload and crop the file
			$uImg->imgCropResize($_FILES['fileImg'], '', $newName, 
								 '../images/admin/user/', 140, 140, 
						         $id,'image', 'username', 'admin_users');
		}
		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], SUADM002, 'SUCCESS');
	}
}
?>

<title><?php echo COMPANY_S; ?> - Edit Admin Users</title>

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
    if( (isset($_GET['action'])) && ($_GET['action'] == 'edit_user') )
    {
        $userDetail = $adminLogin->getUserDetail($id);
		
    ?>
	<h3>Edit User</h3>

      <form action="<?php $_SERVER['PHP_SELF']."?action=edit_user&id=".$id; ?>" method="post" enctype="multipart/form-data">

            <label>User Name</label>
            <label class="orangeLetter"><?php echo $id; ?></label>
            <?php 
			if(($userDetail[5] != '') && ( file_exists("../images/admin/user/".$userDetail[5])) )
			{
				echo $utility->imageDisplay2('../images/admin/user/', 
							   $userDetail[5], 75, 75, 0, 'greyBorder', $userDetail[0]);
			}
			?> 
            <div class="cl"></div>
         
          	<label>First Name</label>

            <input name="txtFName" type="text" class="text_box_large" id="txtFName"
            value="<?php echo $userDetail[0]; ?>" size="25" />
            <div class="cl"></div>

            <label>Surname</label>
            <input name="txtSurname" type="text" class="text_box_large" id="txtSurname"
            value="<?php echo $userDetail[1]; ?>" size="25" />
            <div class="cl"></div>
            
            
            <label>Address</label>
            <input name="txtAddress" type="text" class="text_box_large" id="txtAddress"
            value="<?php echo $userDetail[2]; ?>" size="25" />
            <div class="cl"></div>
            
            <label>Email</label>
            <input name="txtEmail" type="text" class="text_box_large" id="txtEmail"
            value="<?php echo $userDetail[4]; ?>" size="25" /> 
            <div class="cl"></div>
            
          	<label>Image</label>
            <input name="fileImg" type="file" class="text_box_large" id="fileImg" />
			<span class="menuText">(Best Size 140 X 140 pixels in width by height)</span>
            <div class="cl"></div>

            <?php 
			if( ($userDetail[5] != '' ) && (file_exists("../images/admin/user/".$userDetail[5])) )
			{
				echo "<input name=\"delImg\" type=\"checkbox\" value=\"1\"> 
				<span class='blackLarge'>Delete this image</span>"; 
			}
			?>
            <div class="cl"></div>

            <input name="btnEditUser" type="submit" class="button-add" id="btnEditUser" value="edit" />
            <input name="btnCancel" type="button" class="button-cancel" id="btnCancel" onClick="self.close()" 
            value="cancel" />

      </form>

    <?php 
    }
    ?>
</div>
