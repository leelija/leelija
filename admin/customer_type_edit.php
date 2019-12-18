<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/category.inc.php"); 
require_once("../includes/customer.inc.php"); 

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../classes/error.class.php"); 
require_once("../classes/category.class.php"); 
require_once("../classes/customer.class.php"); 

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$category		= new Cat();
$customer		= new Customer();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();

###############################################################################################

//declare vars
$typeM		= $utility->returnGetVar('typeM','');
$type_id	= $utility->returnGetVar('type_id','');

if(isset($_SESSION['txtParentId']))
{
  $_SESSION['txtParentId'] = '';
}

if(isset($_POST['btnEditType']))
{
	$parent_id 		= trim($_POST['txtParentId']);
	$txtCusType 	= trim($_POST['txtCusType']);
	$txtCode 		= trim($_POST['txtCode']);
	$txtDesc 		= trim($_POST['txtDesc']);
		
	
	//defining error variables
	$action		= 'edit_type';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $type_id;
	$id_var		= 'type_id';
	$anchor		= 'editType';
	$typeM		= 'ERROR';
	
	$duplicate = $customer->duplicateCustomerType($parent_id, $txtCusType, $parent_id, 'customer_type');

	$typeDetail	= $customer->getCustomerTypeData($id);
	
	if($txtCusType == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERCUST402, $typeM, $aname);
	}
	elseif(($txtCusType != $typeDetail[1]) && (preg_match("^ER^",$duplicate)))
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERCUST403, $typeM, $aname);
	}
	else
	{
		//edit type
		$customer->editCustomerType($id, $parent_id, $txtCusType, $txtCode, $txtDesc);
		
		//update static image field			
		if($_FILES['fileCatImg']['name'] != '')
		{
			//delete the file
			$utility->deleteFile($id, 'customer_type_id' ,'../images/user/type/', 'images', 'customer_type');
			
			//rename the file
			$newName = $utility->getNewName4($_FILES['fileCatImg'], '',$id);
			
			//upload and crop the file
			$uImg->imgUpdResize($_FILES['fileCatImg'], '', $newName, 
								'../images/user/type/', 177, 180, $id,
					 			'images', 'customer_type_id', 'customer_type');	
		}
		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], SUCUST402, 'SUCCESS');
	}
	
}
?>

<title><?php echo COMPANY_S; ?> -  - Edit Type</title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<script type="text/javascript" src="../js/category.js"></script>

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

<div class="popup-form">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
			
	<?php 
    if( (isset($_GET['action'])) && ($_GET['action'] == 'edit_type')  )
    {
        $typeDetail = $customer->getCustomerTypeData($type_id);
    ?>
    	<h3>Edit Customer Type </h3>

        <form action="<?php $_SERVER['PHP_SELF']?>?type_id=<?php echo $type_id; ?>" method="post" enctype="multipart/form-data">
            <label>Parent Category</label>
            <select name="txtParentId" id="txtParentId">
              <option value="0">Top Level</option>
              <?php
			  if(isset($_GET['txtParentId']))
			  {
				$customer->customerTypeDropDown(0,0,$_GET['parent_id'],'ADD',0,'customer_type');
			  }
			  elseif(isset($_SESSION['txtParentId']))
			  {
				$customer->customerTypeDropDown(0,0,$_SESSION['parent_id'],'ADD',0,'customer_type');
			  }
			  else
			  {
				$customer->customerTypeDropDown(0,0, $typeDetail[0],'EDIT',0,'customer_type');
			  }
			  ?>
              <?php
                //$category->categoryDropDown(0,0,$catDetail[2],'edit',$cat_id);
              ?>
            </select>
            <div class="cl"></div>
    
            <label>Customer Type<span class="orangeLetter">*</span></label>
            <input name="txtCusType" type="text" class="text_box_large" id="txtCusType"
            value="<?php echo $typeDetail[1] ?>" size="25" />
            <div class="cl"></div>	
             
                            
            <label>Code</label>
            <input name="txtCode" type="text" class="text_box_large" id="txtCode"
            value="<?php echo $typeDetail[2] ?>" size="25" /> 
            <div class="cl"></div>                   
                                                            
            <label>Description </label>
            <textarea name="txtDesc" cols="70" rows="15" class="textAr" id="txtDesc">
            <?php echo $typeDetail[3] ?>
            </textarea>
            <div class="cl"></div>
            
            <label>Image </label>
            <input name="fileCatImg" type="file" id="fileCatImg" />
            
            <div class="cl"></div>
    
            <input name="btnEditType" type="submit" class="button-add" id="btnEditType" value="edit" />
            <input name="btnCancel" type="button" class="button-cancel" id="btnCancel" onClick="self.close()" 
            value="cancel" />
        
        </form>

    <?php 
    }
    ?>
</div>