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


if(isset($_POST['btnEdit']))
{
	$txtTitle		=  $_POST['txtTitle'];
	$txtDesc		=  $_POST['txtDesc'];
	
	
	//defining error variables
	$action		= 'edit';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $id;
	$id_var		= 'id';
	$anchor		= 'editNotification';
	$typeM		= 'ERROR';

	if($txtTitle == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, 'Title is empty', $typeM, $anchor);
	}
	else if( ($txtDesc == '')  || (strlen($txtDesc) < 8) )
	{
		$error->showErrorTA($action, $id, $id_var, $url, 'Messege is too short', $typeM, $anchor);
	}
	else
	{
		//update the notification
		$noti->updateNotification($id, $txtTitle, $txtDesc);



		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], 'Notification edited successfully', 'SUCCESS');
	}

}
?>

<title><?php echo COMPANY_S; ?>- Notification Edit</title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/scripts/wysiwyg.js"></script> 
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/scripts/wysiwyg-settings.js"></script> 

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


<table class="tblBrd" align="center" width="600">
	<?php 
	//show message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
			

	<?php 
	if(isset($_GET['action']) && ($_GET['action'] == 'edit'))
	{
		$notDtl		= $noti->getNotificationData($id);
	?>
	<tr><td height="25" align='left' bgcolor="#EEEEEE"><h3>Edit Notification </h3></td></tr>
	<tr>
	  <td>
	  
	  <form action="<?php $_SERVER['PHP_SELF']?>?id=<?php echo $id; ?>" method="post" 
	  enctype="multipart/form-data">

		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="96" align="left" class="menuText">Notification Title <span class="orangeLetter">*</span></td>
			<td width="396" height="20" colspan="2" align="left" class="pad5">
			  <input name="txtTitle" type="text" class="text_box_large" id="txtTitle" 
				value="<?php echo $notDtl[1]; ?>" />			</td>
		  </tr>

		  <tr>
			<td width="96" align="left" class="menuText">Notification Message<span class="orangeLetter">*</span></td>
			<td height="20" colspan="2" align="left" class="pad5">
			<textarea name="txtDesc" cols="35" rows="5" id="txtDesc">
			<?php echo stripslashes($notDtl[2]); ?>
			</textarea>				 
			</td>
		  </tr>


		  <tr>
			<td align="left" class="menuText">&nbsp;</td>
			<td height="20" align="left" class="menuText"></td>
		  </tr>

		  <tr>
			<td width="96" class="menuText">&nbsp;</td>
			<td height="25" align="left">
			<input name="btnEdit" type="submit" class="button-add" id="btnEdit" value="edit" />
			<input name="btnCancel" type="button" class="button-cancel" id="btnCancel" 
			onClick="self.close()" value="cancel" />			</td>
		  </tr>

		  <tr>
			<td width="96">&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		
	  </form>
	  <!-- End Form -->
	  
	  </td>
	</tr>

	<?php 
	}//eof
	?>
</table>