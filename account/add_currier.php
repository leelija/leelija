<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/sample.class.php");
require_once("../classes/employee.class.php");
require_once("../classes/company.class.php"); 
require_once("../classes/customer.class.php");
require_once("../classes/currier.class.php"); 

require_once("../classes/buyer.class.php"); 
require_once("../classes/product_status.class.php");
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$sample			= new Sample();
$company		= new Company();
$buyer			= new Buyer();
$currier		= new Currier();

$customer		= new Customer();
$status			= new Pstatus();
$employee		= new Employee();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$party_id		= $utility->returnGetVar('party_id','0');

//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[ACC_SESS]);


//add a party
if(isset($_POST['btnAddProd']))
{	
	
	$txtCurrierName	 	= $_POST['txtCurrierName'];
	$txtEmail	 		= $_POST['txtEmail'];
	$txtPhone 	        = $_POST['txtPhone'];
	$txtGSTINNO	 		= $_POST['txtGSTINNO'];
	$txtPanNo			= $_POST['txtPanNo'];
	$txtAddress	 		= $_POST['txtAddress'];
	$txtCity	 	    = $_POST['txtCity'];
	
	$txtBalance	 		= $_POST['txtBalance'];
	
	//registering the post session variables
	$sess_arr	= array('txtCurrierName','txtEmail', 'txtPhone', 'txtGSTINNO', 'txtPanNo', 'txtAddress','txtCity');
	$utility->addPostSessArr($sess_arr);
	//defining error variables
	$action		= 'add_customer';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	$msg = '';

	if($txtCurrierName=='')
	{
		echo "Fill the Courier name field";
	}
	else
	{
		
		//add the Currier
		$currier->addCurrier($txtCurrierName,$txtEmail, $txtPhone, $txtGSTINNO, $txtPanNo,$txtAddress,$txtCity,$txtBalance,$userData[2]);	
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'currier.php', 'Courier has been successfully added', 'SUCCESS');
	}
	
}//eof add party


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtCurrierName','txtEmail', 'txtPhone', 'txtGSTINNO', 'txtPanNo', 'txtAddress','txtCity');
	
/*	//option value variables 
	$optValIds	= $prodAttr->getOptionValId(0);
	$chkOptVal 	= $uNum->createIdArr($optValIds, 'ov');
	
	//merging array
	$allArr		= 	array_merge($sess_arr, $chkOptVal);	
	$utility->delSessArr($allArr);*/
	
	//forward
	header("Location: currier.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Add Courier</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>

<!--CSS Jquery Calender-->
<link rel="stylesheet" href="../style/jQuery/jquery-ui.css" type="text/css" media="all" />
<!--CSS Jquery Calender-->

<!-- eof Style -->
 
<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<script type="text/javascript" src="../js/static.js"></script>
<script type="text/javascript" src="../js/category.js"></script>
<script type="text/javascript" src="../js/product.js"></script>
<script type="text/javascript" src="../js/rozelle_order.js"></script>
<!-- eof JS Libraries -->

<!--Jquery Calender-->
<script src="../js/jQuery/jquery.min.js" type="text/javascript"></script>
<script src="../js/jQuery/jquery-ui.min.js" type="text/javascript"></script>
<!--Jquery Calender-->  

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
<script type="text/javascript">
function contentTitleCopy()
{

	var x=document.getElementById("txtProdName").value;
	document.getElementById("txtPageTitle").value=x;
}
</script>

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
                	<h1>Add Courier</h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_customer')) 
					{	
					?>
                   
                        <h2><a name="addUser">Add Courier</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                            <div class="cl"></div>      
                            <label> Courier Name<span class="orangeLetter">*</span></label>
                            <input name="txtCurrierName" type="text" class="text_box_large" id="txtCurrierName" 
					        value="<?php $utility->printSess2('txtCurrierName',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>Email<span class="orangeLetter"></span></label>
                            <input name="txtEmail" type="text" class="text_box_large" id="txtEmail" 
					        value="<?php $utility->printSess2('txtEmail',''); ?>" size="25" />
                            <div class="cl"></div>
							
							 <label>Phone<span class="orangeLetter"></span></label>
                            <input name="txtPhone" type="text" class="text_box_large" id="txtPhone" 
					        value="<?php $utility->printSess2('txtPhone',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>GSTIN No<span class="orangeLetter"></span></label>
                            <input name="txtGSTINNO" type="text" class="text_box_large" id="txtGSTINNO" 
					        value="<?php $utility->printSess2('txtGSTINNO',''); ?>" size="25" />
                            <div class="cl"></div>
							
							
							<label>PAN No<span class="orangeLetter"></span></label>
                            <input name="txtPanNo" type="text" class="text_box_large" id="txtPanNo" 
					        value="<?php $utility->printSess2('txtPanNo',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>Address<span class="orangeLetter"></span></label>
                            <input name="txtAddress" type="text" class="text_box_large" id="txtAddress" 
					        value="<?php $utility->printSess2('txtAddress',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>State<span class="orangeLetter"></span></label>
                            <input name="txtCity" type="text" class="text_box_large" id="txtCity" 
					        value="<?php $utility->printSess2('txtCity',''); ?>" size="25" />
                            <div class="cl"></div>
                            
							<label>Balance <span class="orangeLetter"></span></label>
                            <input name="txtBalance" type="text" class="text_box_large" id="txtBalance" 
					        value="<?php $utility->printSess2('txtBalance',''); ?>" size="25" />
                            <div class="cl"></div>
							                                                
                            <input name="btnAddProd" type="submit" class="button-add"  value="add" />
                           
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
	<?php// require_once('footer.inc.php'); ?>
     
</body>
</html>
