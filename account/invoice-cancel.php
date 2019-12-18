<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../classes/customer.class.php");

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/employee.class.php"); 
require_once("../classes/stock.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/company.class.php"); 
require_once("../classes/currier.class.php");
 require_once("../classes/invoice.class.php"); 

require_once("../classes/vendor.class.php"); 
require_once("../classes/supplier.class.php"); 
require_once("../classes/buyer.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$customer		= new Customer();

$employee		= new Employee();
$search_obj		= new Search();
$pages			= new Pagination();
$company		= new Company();
$vendor			= new Vendor();
$supplier		= new Supplier();
$buyer			= new Buyer();
$currier		= new Currier();
$invoice		= new Invoice();

$stock			= new Stock();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$invoice_id		= $utility->returnGetVar('invoice_id','0');

date_default_timezone_set('Asia/Calcutta'); 
//echo date("Y-m-d H:i:s"); // time in India
$toDate 		= date("Y-m-d");// Today Date

//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[ACC_SESS]);
//admin detail
//$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$invsDtls		= $invoice->showInvoice($invoice_id);
$courierDtls 	= $currier->showCurrier($invsDtls[23]);

if(isset($_POST['btnAddPayment']))
{	
	
	$invoiceDtls 	= $invoice->showInvoice($invoice_id);
	//registering the post session variables
	//$sess_arr	= array('txtNoOfParcels', 'txtPayAmount');
	//$utility->addPostSessArr($sess_arr);

	//defining error variables
	$action		= 'invoiceCancel';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $invoice_id;
	$id_var		= 'invoice_id';
	$anchor		= 'AddPayment';
	$typeM		= 'ERROR';
	$msg = '';
	//echo $invoice_id;exit;
		
		//Invoice cancel
		$invoice->UpdateInvcStat($invoice_id,'cancel',$userData[2]);
		
		$custDtls 		= $buyer->showBuyerDtlsComp($invoiceDtls[1]);
		$cBalance 		= $custDtls[12] - $invoiceDtls[10];
		
		//Edit Customer Record
		$buyer->editBuyer($custDtls[0],$custDtls[1], $custDtls[14],$custDtls[2], $custDtls[4], $custDtls[15], $cBalance, $userData[2]);
		
		//buyer details
		$buyerPDtls 	= $buyer->showBuyerAccCompWise($custDtls[0],$invoiceDtls[16]);
		$ctBalance 		= $buyerPDtls[3] - $invoiceDtls[10];
		$buyer->UpdateBuyerAccBlnc($custDtls[0],$invoiceDtls[16], $ctBalance);
		
		//Account details
		$bAccDtls 		= $company->showCompAcc($invoiceDtls[16]);
		$otsgst			= $bAccDtls[8] - $invoiceDtls[5];//sgst
		$otcgst			= $bAccDtls[9] - $invoiceDtls[7];//cgst
		$otigst			= $bAccDtls[10] - $invoiceDtls[9];//igst
		//update company account
		$company->updateCompAcc($bAccDtls[0],$bAccDtls[1],$bAccDtls[2], $bAccDtls[3],$bAccDtls[4],$bAccDtls[5], $bAccDtls[6], 
		$bAccDtls[7], $otsgst,$otcgst, $otigst,$userData[2]);
		
		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], "Invoice has been successfully Cancel", 'SUCCESS');
		$utility->delSessArr($sess_arr);
}


?>

<title><?php echo COMPANY_S; ?> - -Cancel Invoice</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'invoiceCancel') )
        {
           // $empPayBookDtls	 = $employee->showEmpBookData($pbid);
        ?>
		
			<h3><a name="editProd"></a></h3>
			<form action="<?php $_SERVER['PHP_SELF']?>?action=invoiceCancel&invoice_id=<?php echo $invoice_id; ?>" method="post" enctype="multipart/form-data">																																																
				<!--<h2><a name="addUser">Courier Details</a></h2>-->
                <span>Are you sure You want to Cancel <span class="required"></span> Invoice No: <?php echo $invoice_id; ?></span>
				<div class="cl"></div>
                   
                <input name="btnAddPayment" type="submit" class="button-add"  value="Yes" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="No" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
