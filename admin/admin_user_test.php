<?php 
session_start();
//include_once('checkSession.php');
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

if(isset($_POST['btnCreateUser']))
{
	//post vars
	$txtUser 	= $_POST['txtUser'];
	$password 	= $_POST['txtPass'];
	$cnfPass  	= $_POST['txtCnfPass'];
	$txtFName	= $_POST['txtFName'];
	$txtSurname	= $_POST['txtSurname'];
	$txtAddress	= $_POST['txtAddress'];
	$txtEmail  	= $_POST['txtEmail'];
	//$selUType  	= $_POST['selUType'];
	

	//registering the post session variables
	$sess_arr	= array('txtUser','txtFName','txtSurname','txtAddress','txtEmail');
	$utility->addPostSessArr($sess_arr);
	
	//defining error variables
	$action		= 'add_user';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addUser';
	$typeM		= 'ERROR';
	
	
	//check for errors
	$duplicate = $error->duplicateUser($txtUser, 'username', 'admin_users'); 
	$email_id  = $error->invalidEmail($txtEmail);
	
	
	if((eregi(" ",$txtUser)) || ($txtUser == '') || (strlen($txtUser) < 2))
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERADM002, $typeM, $anchor);
	}
	elseif($txtFName == '' )
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU108, $typeM, $anchor);
	}
	elseif($txtAddress == '' )
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERREG004, $typeM, $anchor);
	}
	elseif(strlen($password) < 6)
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU117, $typeM, $anchor);
	}
	elseif($password != $cnfPass )
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU107, $typeM, $anchor);
	}
	elseif(ereg("^ER",$duplicate))
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU102, $typeM, $anchor);
	}
	elseif(ereg("^ER",$email_id))
	{
		$error->showErrorTA($action, $id, $id_var, $url, ER002, $typeM, $anchor);
	}
	else
	{
		//create admin user
		$adminLogin->createUser($txtUser, $password, $txtFName, $txtSurname,
						        $txtAddress, $txtEmail);//, $selUType
		
		//uploading images
		if($_FILES['fileImg']['name'] != '')
		{
			//rename the file
			$newName = $utility->getNewName4($_FILES['fileImg'], '',$txtUser);
			
			//upload and crop the file
			$uImg->imgCropResize($_FILES['fileImg'], '', $newName, 
								 '../images/admin/user/', 140, 140, 
						         $txtUser,'image', 'username', 'admin_users');
		}
		
		//delete the session
		$utility->delSessArr($sess_arr);
		
		
		
		//forward
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], SUADM001, 'SUCCESS');
	}
	
}//admin add


//cancel
if(isset($_POST['btnCancel']))
{
	//registering the post session variables
	$sess_arr	= array('user_name','fname','lname','address','email');
	
	//delete the session
	$utility->delSessArr($sess_arr);
	
	//forward
	header("Location: ".$_SERVER['PHP_SELF']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Harati Wear- Admin Users</title>

<!-- Style -->
<link href="../style/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<!-- eof JS Libraries -->


</head>

<body>

	
    <!-- Header -->
	<?php require_once('header.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<div id="admin-menu">
				<?php require_once('menu.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                <div id="admin-top">
                	<h1>Admin Users</h1>
                </div>
                
                <!-- Options -->
                <div id="options-area">
                	<div class="add-new-option">
                    	<a href="<?php echo $_SERVER['PHP_SELF']."?action=add_user#addAdmin"; ?>">
                          Add New User
                        </a>	
                    </div>
                </div>
                <!-- eof Options -->
                
                
                <!-- Display Data -->
                <div id="data-column">
                
                
                <table width="100%"  cellspacing="0" cellpadding="0" class="single-column">
                
				<?php 
				$userId = $adminLogin->getAllUserId();
				if(count($userId) == 0)
				{
				?>
				<tr align="left" class="orangeLetter">
                  <td height="20" colspan="5"> <?php echo ERADM001; ?> </td>
                 </tr>
				<?php 
				}
				else
				{
				?>  
				 
                <thead>
                  <th width="24%">Name </th>
                  <th width="18%">Login Id </th>
                  <th width="14%">Added On</th>
                  <th width="16%">Last Login </th>
                  <th width="28%" align="center">Action</th>
                  </thead>
				<?php 
					$i = 1;
					foreach($userId as $k)
					{
						$userDetail = $adminLogin->getUserDetail($k);
						$bgColor 	= $utility->getRowColor($i);
				?>
					<tr align="left" <?php $utility->printRowColor($bgColor);  ?>>
					  <td><?php echo $userDetail[0]." ".$userDetail[1]; ?></td>
					  <td><?php echo $k; ?></td>
					  <td><?php echo $dateUtil->printDate($userDetail[8]); ?></td>
					  <td>
					  <?php if($userDetail[6] == '0000-00-00 00:00:00') {echo 'no login';} 
					  else {echo $userDetail[6];} ?>
					  </td>
					  <td align="center">
					  [ 
					  <a href="#" 
					  onClick="MM_openBrWindow('admin_edit.php?action=edit_user&id=<?php echo $k; ?>','AdminEdit','scrollbars=yes,width=500,height=350')">
					  edit					  </a> ]
					 [ 
					  <a href="#" 
					  onClick="MM_openBrWindow('admin_password.php?action=edit_pass&id=<?php echo $k; ?>','AdminChangePass','scrollbars=yes,width=350,height=300')">
					  password					  </a> ]
					  <?php 
					  if($_SESSION['HARATI_admin2010_For'] != $k)
					  {
					  ?>
					  [ 
					  <a href="#" onClick="MM_openBrWindow('admin_delete.php?action=delete_user&id=<?php echo $k; ?>','AdminDelete','scrollbars=yes,width=400,height=350')">
					  delete					  </a> ]
					  <?php }?>					  </td>
				   </tr>
			  <?php 
			  		$i++;
					}
			  }
			  ?>
			  
              </table>
               
                  <div class="first-column">
                 
                    	<!-- Bottom Pagination-->
                        <div class="pagination-bottom">
                            <div class="upper-block">Total Admin User: <?php echo count($userId);?></div>
                           <?php /*?> <div class="lower-block"><?php $page->getPage($numPages, $link, $pageNumber, $pageArray);?></div><?php */?>
                        </div>
                   
                  </div>
                </div>
                <!-- eof Display Data -->
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_user')) 
					{	
					?>
                   
                        <h2><a name="addUser">Add Admin User</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        
                        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
			  			<label>User Name <span class="orangeLetter">*</span> </label>
                        <input name="txtUser" type="text" class="text_box_large" id="txtUser" 
                        value="<?php $utility->printSess2('txtUser',''); ?>" size="25" />
                        
                        <div class="cl"></div>
                    
						<label>Password<span class="orangeLetter">*</span></label>
                		<input name="txtPass" type="password" class="text_box_large" id="txtPass" 
                		size="25" />
						<div class="cl"></div>
                        
				       <label>Confirm Password 
                      <span class="orangeLetter">*</span></label>
					  <input name="txtCnfPass" type="password" class="text_box_large" 
					  id="txtCnfPass" size="25" />
				  	  <div class="cl"></div>
                      
                      
				 <label>First Name   
					  <span class="orangeLetter">*</span></label>
					<input name="txtFName" type="text" class="text_box_large" id="txtFName"
					value="<?php $utility->printSess2('txtFName',''); ?>" size="25" />
					<div class="cl"></div>
                    
				  <label>Surname <span class="orangeLetter">*</span></label>
					<input name="txtSurname" type="text" class="text_box_large" id="txtSurname"
					value="<?php $utility->printSess2('txtSurname','');?>" size="25" />
					<div class="cl"></div>
                    
				 <label>Address <span class="orangeLetter">*</span></label>
					<input name="txtAddress" type="text" class="text_box_large" id="txtAddress"
					value="<?php $utility->printSess2('txtAddress',''); ?>" size="25" />
					<div class="cl"></div>
				 <label>Email <span class="orangeLetter">*</span></label>
					<input name="txtEmail" type="text" class="text_box_large" id="txtEmail"
					value="<?php $utility->printSess2('txtEmail',''); ?>" size="25" />
					<div class="cl"></div>
                    
                    
				  <label>Image</label>
					<input name="fileImg" type="file" class="text_box_large" id="fileImg" />
					<span class="menuText">(Best Size 140 X 140 pixels in width by height)</span> 
					<div class="cl"></div>
                    
				  
					<input name="btnCreateUser" type="submit" class="buttonYellow" 
					value="create" />
					<input name="btnCancel" type="submit" class="buttonYellow" value="cancel" />
				
			  </form>
                    <?php 
					}
					?>
                    
                     
                </div>
                <div class="cl"></div>
                <!-- eof Form -->
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php require_once('footer.inc.php'); ?>

</body>
</html>
