<?php 
ob_start();
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
//require_once("../classes/tax.class.php");
require_once("../classes/customer.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/employee.class.php"); 

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
//$tax			= new Tax();
$customer			= new Customer();
$status			= new Pstatus();
$employee		= new Employee();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$pbid			= $utility->returnGetVar('pbid','0');

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$empPayBook		= $employee->showEmpBookData($pbid);

if(isset($_POST['btnAddPayment']))
{	
	$txtDuty 	        = $_POST['txtDuty'];
	$txtSalary	 		= $_POST['txtSalary'];
	$txtAdvWithdraw	 	= $_POST['txtAdvWithdraw'];
	$txtSampleDesc	 	= $_POST['txtSampleDesc'];
	//registering the post session variables
	$sess_arr	= array('txtDuty', 'txtSalary');
	$utility->addPostSessArr($sess_arr);
	

	
	//defining error variables
	$action		= 'Show_pid';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $pbid;
	$id_var		= 'pbid';
	$anchor		= 'AddPayment';
	$typeM		= 'ERROR';
	
	
	$msg = '';



	if($txtSalary=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Salary field is Empty", $typeM, $anchor);
	}
	elseif($txtDuty=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Duty field is empty", $typeM, $anchor);
	}
	else
	{
		
		
		
				$salary			= $txtSalary - $txtAdvWithdraw;	
				$lastPayment	= $empPayBook[9];
				$advAmount		= $empPayBook[4] - $txtAdvWithdraw;
				$dueAmount		= $empPayBook[5] + $empPayBook[3];
				$payAble 		= $salary + $dueAmount;
				
				//Update Payment book
				 $employee->UpdateEmpPayBook($pbid,$txtDuty, $dueAmount,$advAmount,$salary,$payAble,$lastPayment,$userData[10]);
				//Add Payment book details
				$employee->addDutySalary($pbid,$txtDuty,$salary,$txtAdvWithdraw,$txtSampleDesc,$userData[10]);
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], "Salary Transfer has been successfully complete", 'SUCCESS');
	}
	$utility->delSessArr($sess_arr);
}





?>

<title><?php echo COMPANY_S; ?> - - Employee Duty Salary</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
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
<script type="text/javascript" src="../js/product.js"></script>
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


</head>


	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'Show_pid') )
        {
             
            $empPayBookDtls	 = $employee->showEmpBookData($pbid);
        ?>
		
<h3><a name="editProd"></a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=Show_pid&pbid=<?php echo $pbid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Employee Duty Salary</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                       
                            <label>Total Duty<span class="orangeLetter">*</span></label>
                            <input name="txtDuty" type="text" class="text_box_large" id="txtDuty" 
					         size="25" />
                            <div class="cl"></div>
							
                            <label>Salary<span class="orangeLetter">*</span></label>
                            <input name="txtSalary" type="text" class="text_box_large" id="txtSalary" 
					         size="25" />
                            <div class="cl"></div>
							
							<label>Advance Withdraw<span class="orangeLetter"></span></label>
                            <input name="txtAdvWithdraw" type="text" class="text_box_large" id="txtAdvWithdraw" 
					         value="<?php echo $empPayBookDtls[4] ?>" size="25" />
                            <div class="cl"></div>
						
							<label>Remarks</label>
                            <textarea  name="txtSampleDesc" id="txtSampleDesc">
							<?php $utility->printSess2('txtSampleDesc',''); ?>
                            </textarea>
                                                                 
                <input name="btnAddPayment" type="submit" class="button-add"  value="Transfer" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
