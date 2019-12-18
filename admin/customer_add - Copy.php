<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php");

require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 
require_once("../includes/customer.inc.php");
require_once("../includes/user.inc.php");
require_once("../includes/email.inc.php");
require_once("../includes/registration.inc.php");


require_once("../classes/adminLogin.class.php"); 
require_once("../classes/customer.class.php");
require_once("../classes/subscriber.class.php");


require_once("../classes/error.class.php");  
require_once("../classes/date.class.php"); 
require_once("../classes/utility.class.php");
require_once("../classes/utilityNum.class.php");
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityCurl.class.php");


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$customer		= new Customer();
$subscribe		= new EmailSubscriber();

$dateUtil      	= new DateUtil();
$error 			= new Error();
$utility		= new Utility();
$uNum			= new NumUtility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uCurl 			= new CurlUtility();


###############################################################################################

//declare vars
$typeM				= $utility->returnGetVar('typeM','');

$numOrder			= $uNum->genSortOrderNum('N', 0, 'customer_id', 1, 'customer');

$customerIds 		= $customer->getAllCustomerId();



//add new content
if(isset($_POST['btnAddCus'])) 
{
	$typeId					= $_POST['selCusType'];
	$txtUserName			= $_POST['txtUserName'];
	$txtEmail				= $_POST['txtEmail'];
	$txtPassword			= $_POST['txtPassword'];
	$txtCnfPass				= $_POST['txtCnfPass'];
	$txtfirstName			= $_POST['txtfirstName'];
	$txtLastName			= $_POST['txtLastName'];
	$txtDesc				= $_POST['txtDesc'];
	$txtCompanyName			= $_POST['txtCompanyName'];
	$txtProfession			= $_POST['txtProfession'];
	$txtDiscountOffered		= $_POST['txtDiscountOffered'];
	
	$intOrder				= $_POST['intOrder'];
	//$file  					= $_FILES['fileImg'];
	
	
	
	//organizer type 
	/*if(isset($_POST['radioRt']))
	{
		$radioRt	= 	$_POST['radioRt'];
	}
	else
	{
		$radioRt	= 	'';
	}*/
	
	//Account verified 
	if(isset($_POST['radioAcc']))
	{
		$radioAcc	= 	$_POST['radioAcc'];
	}
	else
	{
		$radioAcc	= 	'N';
	}
	
	$txtAddress1			= $_POST['txtAddress1'];
	$txtTown				= $_POST['txtTownId'];
	$txtPostalCode			= $_POST['txtPostalCode'];
	$txtCountriesId			= $_POST['txtCountriesId'];
	$txtPhone1				= $_POST['txtPhone1'];  
	$intFax					= $_POST['intFax'];
	$intMobile				= $_POST['intMobile'];
	$txtCountyId			= $_POST['txtCountyId'];
	$txtTownId				= $_POST['txtTownId'];
	$txtProvinceId			= $_POST['txtProvinceId'];

	
	//registering the post session variables
	$sess_arr	= array( 'txtUserName', 'txtMemberId', 'selCusType', 'txtEmail', 'txtPassword','txtfirstName', 'txtLastName',  'radioRt',  
						 'radioAcc', 'txtDesc','txtCompanyName','txtProfession', 'intOrder','txtDiscountOffered', 'txtAddress1', 'txtTown',  
						 'txtProvince', 'txtPostalCode', 'txtCountriesId', 'txtPhone1', 'intFax', 'intMobile' );
			
	
	$utility->addPostSessArr($sess_arr);
	
	
	//defining error variables
	$action		= 'add_client';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addClient';
	$typeM		= 'ERROR';
	
	//error check
	$duplicateId	= $error->duplicateUser($txtEmail, 'email', 'customer');
	//$dupMemId		= $error->duplicateUser($txtMemberId, 'member_id', 'customer');
	$invalidEmail 	= $error->invalidEmail($txtEmail);
	$dupUser		= $error->duplicateUser($txtUserName, 'user_name', 'customer');
	
	//CHECK FIELD VALIDATION 
	
	if($typeId == 0)
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERREG013, $typeM, $anchor);
	}
	
	elseif( ($txtUserName == '') ||(preg_match("/^ER/i", $dupUser)))
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU102, $typeM, $anchor);
	}
	elseif( ($txtEmail != '') && (preg_match("/^ER/i",$duplicateId)) )		
	{
		
		$error->showErrorTA($action, $id, $id_var, $url, ERU114, $typeM, $anchor);
	}
	elseif( ($txtEmail == '') ||(preg_match("/^ER/i",$invalidEmail)) )		
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU113, $typeM, $anchor);
	}
	else if(strlen($txtUserName) == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU104, $typeM, $anchor);
	}
	else if(strlen($txtPassword) < 6)
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU117, $typeM, $anchor);
	}
	else if($txtPassword != $txtCnfPass )
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU107, $typeM, $anchor);
	}
	else if($radioAcc == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU129, $typeM, $anchor); 
	}
	elseif($txtfirstName == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU108, $typeM, $anchor);
	}
	elseif($txtLastName == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU109, $typeM, $anchor);
	}
	elseif($txtAddress1 == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU123, $typeM, $anchor);
	}
	elseif($txtCountriesId == 0)
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU131, $typeM, $anchor);
	}
	elseif($txtProvinceId == 0)
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU125, $typeM, $anchor);
	}
	/*elseif($txtTown == 0)
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU124, $typeM, $anchor);
	}*/
	
	elseif($txtPostalCode == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU126, $typeM, $anchor);
	}

	elseif($txtPhone1 == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERU127, $typeM, $anchor); 
	}
	
	else
	{
	
		//generate town_id if new town is added
		if((isset($_POST['txtAltTown'])) && (strlen($_POST['txtAltTown']) > 0) && ($txtTownId == 0))
		{
			$duplicate = $error->duplicateChild($countyId, 'county_id', $_POST['txtAltTown'], 'town_name', 'town');
			if(ereg("^ER",$duplicate))
			{
				header("Location:".$_SERVER['PHP_SELF']."?action=add_customer&msg=Error: duplicate town");
			}
			else
			{
				//add town
				$t_id = $lc->addTown($countyId, $_POST['txtAltTown'], '');
				$txtTownId	= $t_id;
			}
		}
		elseif((isset($_POST['txtAltTown'])) && (strlen($_POST['txtAltTown']) <= 0) && ($txtTownId == 0))
		{
			header("Location:".$_SERVER['PHP_SELF']."?action=add_client&msg=Error: Town is Epmty");
		}
		elseif(($txtTownId == 0) && (!isset($_POST['txtAltTown'])))
		{
			header("Location:".$_SERVER['PHP_SELF']."?action=add_client&msg=Error: Town is Epmty");
		}
		else
		{
			$txtTownId	= 	$_POST['txtTownId'];
		}//town
		if($txtProvinceId == -1)
		{
			$txtProvinceId = 0;
		}
		if($txtCountyId == -1)
		{
			$txtCountyId = 0;
		}
		//get verification no  
		$verificationNo	= $customer->genCusVerificationNum($radioAcc);
		
		//add customer
		$customerId = $customer->addCustomer( $typeId, $typeId, $txtUserName, $txtEmail, $txtPassword,  $txtfirstName,  $txtLastName, 'na',
											 'a', '', $txtDesc, $txtCompanyName, 'Y',  $txtProfession, $intOrder, $verificationNo,
											 $radioAcc, $txtDiscountOffered); 

		//add the address
		$customer->addCusAddress( $customerId,  $txtAddress1,  '',  '', $txtTownId, $txtCountyId, $txtProvinceId, $txtCountriesId, 
								  $txtPostalCode,  $txtPhone1, '', $intFax, $intMobile);
								 
		//add to the mass email system
		$subscribe->addSubscriber($customerId, $txtEmail,$txtfirstName,$txtLastName, 1, $txtCompanyName, $txtPhone1);
		
		
	
		//uploading images
		if($_FILES['fileImg']['name'] != '')
		{
			//rename the file
			$newName = $utility->getNewName4($_FILES['fileImg'], '', $customerId);
			
			//upload and crop the file
			$uImg->imgCropResize($_FILES['fileImg'], '', $newName, 
								 '../images/user/', 200, 200, 
						         $customerId, 'image', 'customer_id','customer');
		}
	
		$utility->delSessArr($sess_arr);
		
		
		//forward
		$uMesg->showSuccessT('success', 0, '', 'customer.php', SUCUST201, 'SUCCESS');

	}
	
}//eof


//cancel button
if(isset($_POST['btnCancel']))
{
	header("Location: "."customer.php");
	
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Add Customer</title>

<!-- Style -->
<link rel="stylesheet" type="text/css" href="../style/admin/admin.css" />
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/scripts/wysiwyg-settings.js"></script> 
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/scripts/wysiwyg.js"></script> 

<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<script type="text/javascript" src="../js/static.js"></script>

<!-- TinyMCE --> 
 <script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
 <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "image,fontsizeselect,forecolor,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,bullist,numlist,|,outdent,indent",
		theme_advanced_buttons2 :
"undo,redo,|,emotions,|,pasteword,code",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		formats : {
			alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'left'},
			aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'center'},
			alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'right'},
			alignfull : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
			bold : {inline : 'span', 'classes' : 'bold'},
			italic : {inline : 'span', 'classes' : 'italic'},
			underline : {inline : 'span', 'classes' : 'underline', exact : true},
			strikethrough : {inline : 'del'}
		},

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->

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
                	<h1>Add Customer</h1>
                </div>
                	
           
            <!-- eof inner Data -->
                
            <!-- Form -->
            <div class="webform-area">
                <!-- show message -->
                <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                
                <?php 
                if(isset($_GET['action']) && ($_GET['action'] == 'add_client')) 
                {	
                ?>
               
                    <h2><a name="addClient">Add Customer</a></h2>
                    <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        
                        
                        <!-- Member Id-->
                        <!--<label>Member Id<span class="orangeLetter">*</span></label>
                        <input name="txtMemberId" type="text" class="text_box_large" id="txtMemberId"  
                        onBlur="verifyMemberId()" title="last name" value="<?php $utility->printSess('txtMemberId'); ?>" />
                        <div class="cl"></div>-->
                        
                        <!-- Customer Type-->
                        <label>Customer Type<span class="orangeLetter">*</span></label>
                        <select name="selCusType" id="selCusType" class="text_box_large">
                        <option value="">-- Select One --</option>
                        
                        <?php
                        if(isset($_SESSION['selCusType']))
                        {
                            $utility->populateDropDown($_SESSION['selCusType'], 'customer_type_id',
                                                       'cus_type', 'customer_type');
                        }
                        elseif(isset($_GET['selCusType']) && ((int)$_GET['selCusType'] > 0))
                        {
                            $utility->populateDropDown($_GET['selCusType'], 'customer_type_id',
                                                       'cus_type', 'customer_type');
                        }
                        else
                        {
                            $utility->populateDropDown(0, 'customer_type_id', 'cus_type', 'customer_type');
                        }
                        ?>
                        </select>
                        <div class="cl"></div>
                        
                        <label>User Name</label>
                        <input name="txtUserName" type="text" class="text" id="txtUserName" maxlength="32" 
                        value="<?php $utility->printSess2('txtUserName',''); ?>"  />
                        <div class="cl"></div>
                        
                        <label>Email<span class="required">*</span></label>
                        <input name="txtEmail" type="email" class="text" id="txtEmail" maxlength="32" 
                        value="<?php $utility->printSess2('txtEmail',''); ?>"  /> 
                        <div class="cl"></div>
                        
                        
                        <label>Password <span class="required">*</span></label>
                        <input name="txtPassword" type="password" class="text" id="txtPassword" 
                        maxlength="16" />(minimum 6 chars)
                        <div class="cl"></div>
                            
                        <label>Confirm Password <span class="orangeLetter">*</span></label>
                        <input name="txtCnfPass" type="password" class="text" id="txtCnfPass" size="25" />
                        <div class="cl"></div>
                        
                        <label>Verify This Account <span class="orangeLetter">*</span></label>
                        <input type="radio" name="radioAcc" id="radioAcc" class="radio" value="Y" title="Yes"
                        <?php echo $utility->checkSessStr('radioAcc','Y', '');?>/>
                        <label for="radioAcc">Y</label>
                        
                        <input type="radio" name="radioAcc" id="radioAcc" class="radio" value="N" title="No" 	
                        <?php echo $utility->checkSessStr('radioAcc','N', '');?> />
                        <label for="radioAcc">N</label>
                        <div class="cl"></div>
                                                 
                        <label>First Name <span class="orangeLetter">*</span></label>
                        <input name="txtfirstName" type="text" class="text" id="txtfirstName"
                        value="<?php $utility->printSess2('txtfirstName',''); ?>" size="25" />
                        <div class="cl"></div>
                        
                        
                        <label>Last Name<span class="orangeLetter">*</span></label>
                        <input name="txtLastName" type="text" class="text_box_large" id="txtLastName"
                        value="<?php $utility->printSess('txtLastName'); ?>" size="30" />
                        <div class="cl"></div>
                        
                        
                        <label>Image</label>
                        <input name="fileImg" type="file" class="text_box_large" id="fileImg" />
                        <span class="menuText">(Best Size 140 X 140 pixels in width by height)</span> 
                        <div class="cl"></div>
                        
                        
                        <label>Description</label>
                        
                        <textarea name="txtDesc" type="text" class="text_box_large" id="txtDesc" 
                        value="" size="25"><?php $utility->printSess('txtDesc');?> </textarea>
                        
                        <div class="cl"></div>                   
                        
                        
                        <label>Company Name</label>
                        <input name="txtCompanyName" type="text" class="text_box_large" id="txtCompanyName"
                        value="<?php $utility->printSess('txtCompanyName'); ?>" size="30" />
                        <div class="cl"></div>
                        
                        <label>Profession<span class="orangeLetter"></span></label>
                        <input name="txtProfession" type="text" class="text_box_large" id="txtProfession"
                        value="<?php $utility->printSess('txtProfession'); ?>" size="30" />
                        <div class="cl"></div>					 
                        
                        <label> Sort Order<span class="orangeLetter"></span></label>
                        <input name="intOrder" type="text" class="text_box_large" id="intOrder"
                        value="<?php $utility->printSess2('intOrder', $numOrder); ?>" maxlength="3"  
                        onKeyPress="return intOnly(this, event)" />	
                        <div class="cl"></div>				
                        
                        <label>Discount Offered<span class="orangeLetter"></span></label>
                        <input name="txtDiscountOffered" type="text" class="text_box_large" id="txtDiscountOffered"
                        value="<?php $utility->printSess2('txtDiscountOffered', 0); ?>" size="30" />
                        <div class="cl"></div>
                        
                        <h3>Address + Contact</h3> 
                        
                        <label> Address <span class="orangeLetter">*</span></label>
                        <input name="txtAddress1" type="text" class="text_box_large" id="txtAddress1"
                        value="<?php $utility->printSess('txtAddress1'); ?>" size="30" />
                        <div class="cl"></div>
                        
                        <?php 
						$arr_val		= array(10, 13, 18, 25,  30, 44, 54, 73, 81, 99, 100, 103, 107, 110, 138, 149, 153, 162, 168, 193, 
												196, 209, 222, 223);
												
						$arr_label		= array('Argentina',  'Australia', 'Bangladesh',  'Bhutan', 'Brazil', 'China', 'Cuba', 'France', 
												'Germany', 'India', 'Indonesia', 'Ireland', 'Japan', 'Kenya', 'Mexico', 'Nepal', 'New Zealand', 
												'Pakistan', 'Philippines', 'South Africa', 'Srilanka', 'Thiland',  'UK',  'USA');
												  
						?>
                        
                        <label>Country<span class="orangeLetter"> *</span></label>
                        <select name="txtCountriesId" id="txtCountriesId" class="text_box_large" onchange="getProvinceList()">
                        	<option value="0">-- Select One --</option>
                            <?php 
							$utility->genDropDown(0, $arr_val, $arr_label);
							?>
                        </select>
                        <div class="cl"></div>
                        
                                               
                        <label> Province<span class="orangeLetter"> *</span></label>
                        <select name="txtProvinceId" id="txtProvinceId" class="text_box_large" onchange="getCountyList()">
                        <option value="0">-- Not Found --</option>
                        </select>
                        <div class="cl"></div>
                        
                        
                        <label> County <span class="orangeLetter">*</span></label>
                        <select name="txtCountyId" id="txtCountyId" onChange="getTownList()" class="text_box_large">
                            <option value="0">-- Not Found --</option>
                         </select>
                        <div class="cl"></div>	
                        
                        <label> Town <span class="orangeLetter">*</span></label>
                        <select name="txtTownId" id="txtTownId" class="text_box_large"  onchange="getAltTown()">
                            <option value="0">-- Not Found --</option>
                            <?php
                             if( (isset($_SESSION['txtCountyId'])) &&  (in_array($_SESSION['txtCountyId'], $allTownIds)) )
                             { //echo "here";
                             ?>
                         
                             <?php 
                                $utility->populateDropDown($_SESSION['txtTownId'], 'town_id', 'town_name', 'town');
                             ?>
                                
                              </select>
                             <?php 
                             }
                             else
                             { //echo "here1";
                             ?>
                                 <select class="text-field">
                                 </select>
                             <?php 
                             }
                             ?>
                         </select>
                        <div class="cl"></div>	
                        
                        <!-- Alternate town-->
                        <div id="altTownName"></div>

                        
                        
                        <label>Postal Code <span class="orangeLetter">*</span></label>
                        <input name="txtPostalCode" type="text" class="text_box_large" id="txtPostalCode"
                        value="<?php $utility->printSess('txtPostalCode'); ?>" size="30" />			
                        <div class="cl"></div>

                        
                        
                        <label>Phone <span class="orangeLetter">*</span></label>
                        <input name="txtPhone1" type="text" class="text_box_large" id="txtPhone1"
                        value="<?php $utility->printSess('txtPhone1'); ?>" size="30"/>	
                        <div class="cl"></div>				 
                        
                        <label>Fax</label>
                        <input name="intFax" type="text" class="text_box_large" id="intFax"
                        value="<?php $utility->printSess('intFax'); ?>" size="30" />	
                        <div class="cl"></div>				 
                        
                        <label>Mobile</label>
                        <input name="intMobile" type="text" class="text_box_large" id="intMobile"
                        value="<?php $utility->printSess('intMobile'); ?>" size="30" />
                        <div class="cl"></div>
                       

                        
                        
                       <input name="btnAddCus"  id="btnAddCus" type="submit" class="button-add" value="create" />
                       <input name="btnCancel" type="submit" class="button-cancel" value="cancel" />
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