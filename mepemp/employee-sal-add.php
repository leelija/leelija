<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php");

require_once("../includes/constant.inc.php"); 
require_once("../includes/content.inc.php"); 
require_once("../classes/employee.class.php"); 
require_once("../includes/user.inc.php");
require_once("../includes/email.inc.php");
require_once("../includes/registration.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/customer.class.php");

require_once("../classes/error.class.php");  
require_once("../classes/date.class.php"); 
require_once("../classes/utility.class.php");
require_once("../classes/utilityNum.class.php");
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityCurl.class.php");


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$employee		= new Employee();

$dateUtil      	= new DateUtil();
$error 			= new Error();
$utility		= new Utility();
$uNum			= new NumUtility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uCurl 			= new CurlUtility();


/////////////////////////////////////////////////////////////////////////////////////////////////

//declare variables
$typeM		= $utility->returnGetVar('typeM','');
$emp_id		= $utility->returnGetVar('emp_id','');

$empDetail = $employee->showEmployee($emp_id);

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);


if(isset($_POST['btnUpdateCustomer']))
{ 
	$txtSalary			= $_POST['txtSalary'];
	
	//defining error variables
	$action		= 'add_salary';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $emp_id;
	$id_var		= 'emp_id';
	$anchor		= 'editCustomer';
	$typeM		= 'ERROR';
	
	if($txtSalary ==0.00)
	{
		echo "Please Put the Salary";
	}
	else
	{
		
		// Add Employee Salary
		$employee->addEmpSalary($emp_id, $txtSalary, $userData[10]);
		
		//forward
		$uMesg->showSuccessT('success', $emp_id, 'id', $_SERVER['PHP_SELF'], 'Salary has been successfully added', 'SUCCESS');

	}
}
?> 


<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/scripts/wysiwyg-settings.js"></script> 
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/scripts/wysiwyg.js"></script> 
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<script type="text/javascript" src="../js/package.js"></script>
<!-- eof JS Libraries -->

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

<title><?php echo COMPANY_S; ?>- Add Salary</title>

<div class="popup-form">
	<?php 
    //display message
    $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
    
    //close button
    echo $utility->showCloseButton();
    ?>
		
	<?php 
	if( (isset($_GET['action'])) && ($_GET['action'] == 'add_salary') )
	{
		$empDetail 		= $employee->showEmployee($emp_id);
		$empTypeDtl		= $employee->getEmpTypeData($empDetail[1]);
	?>
		<h3>Add Salary</h3>
		Name:<?php echo $empDetail[2];?>  Dept.:<?php echo $empTypeDtl[2];?><br>
        <form action="<?php $_SERVER['PHP_SELF']?>?action=add_salary&amp;emp_id=<?php echo $emp_id; ?>" method="post" 
        enctype="multipart/form-data">
			<br>
			<div class="cl"></div>
            <label>Salary</label>
            <input name="txtSalary" type="text" class="text_box_large" id="txtSalary" 
            value="<?php echo $empDetail[29];?>" size="25" />
            <div class="cl"></div>
            
            <input name="btnUpdateCustomer" type="submit" class="button-add" id="btnUpdateCustomer" 
            value="Add" />
            <input name="btnCancel" type="button" class="button-cancel" id="btnCancel" 
            onClick="self.close()" value="cancel" />			

        </form>

	<?php 
	}//eof
	?>
</div>
