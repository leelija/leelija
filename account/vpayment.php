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
require_once("../classes/vendor.class.php"); 
require_once("../classes/customer.class.php");
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
$vendor			= new Vendor();

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

$vbe_id			= $utility->returnGetVar('vbe_id','0');

//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[ACC_SESS]);

$vBillDtls		=  $vendor->showVendorBillEnt($vbe_id);
$venDtls		=  $vendor->showVendor($vBillDtls[1]);
$bAccDtls 		= $company->showCompAcc($vBillDtls[16]);

if(isset($_POST['btnAddPay']))
{	
	$txtTranFrom 	    = $_POST['txtTranFrom'];
	$txtPayType	 		= $_POST['txtPayType'];
	$txtCheqeNo	 		= $_POST['txtCheqeNo'];
	$txtBalance	 		= $_POST['txtBalance'];
	$txtProdDesc	 	= $_POST['txtProdDesc'];
	
	$vBillDtls		=  $vendor->showVendorBillEnt($vbe_id);
	$venDtls		=  $vendor->showVendor($vBillDtls[1]);
	//$bAccDtls 		= $company->showCompAcc($vBillDtls[16]);
	$bAccDtls 		= $company->showCompAcc($txtTranFrom);
	$compDtls 		= $company->showCompDtls($bAccDtls[1]);
	
	//registering the post session variables
	$sess_arr	= array('txtTranFrom','txtPayType', 'txtCheqeNo', 'txtBalance', 'txtProdDesc');
	
	$utility->addPostSessArr($sess_arr);
	
	//defining error variables
	$action		= 'create_Tran';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 'vbe_id';
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	$msg = '';

	//echo $bAccDtls[4];exit;
	if($txtTranFrom=='')
	{
		echo "Put the account Name";
	}
	elseif($txtPayType == ''){
		echo "Put the Payment Name";
	}
	elseif($txtBalance =='' ){
		echo "Put the Valid Balance";
	}
	/*elseif($txtBalance > $bAccDtls[4]){
		echo "Put the Valid Balance";
	}*/
	else
	{
		//Company current balance
		$currCompBalance = $compDtls[4] - $txtBalance;
		//comp bank wise current balance
		$currBalance 	= $bAccDtls[4] - $txtBalance;
		//supplier current balance
		$vbalance		= $venDtls[6] - $txtBalance;
		
		//update company account
		$company->updateCompAcc($bAccDtls[0],$bAccDtls[1],$bAccDtls[2], $bAccDtls[3],$currBalance,$bAccDtls[5], $bAccDtls[6], 
		$bAccDtls[7], $bAccDtls[8],$bAccDtls[9], $bAccDtls[10],$userData[2]);
		
		//update company
		$company->updateCompDtls($bAccDtls[1],$compDtls[1],$compDtls[2], $compDtls[17],$compDtls[3],$currCompBalance,$compDtls[5],
		$compDtls[6], $compDtls[7], $compDtls[8],$compDtls[9], $compDtls[10],$userData[2]);
		
		
		//add the vendor Transaction Records
		$vendor->addVendorTran($venDtls[0], $txtPayType, $txtCheqeNo,$bAccDtls[0],$txtBalance,$txtProdDesc,$userData[2]);
		//Update vendor bill
		$vendor->editVendBill($vbe_id,'paid',$userData[2]);
		
		//Update Vendor Account
		$vendor->updateVendor($venDtls[0],$venDtls[1],$venDtls[2], $venDtls[3],$venDtls[4],$venDtls[5], $vbalance,$venDtls[11],$userData[2]);
		//Vendor Acc Details
		$vendAcctls 	= $vendor->showVenAccCompWise($venDtls[0],$bAccDtls[1]);
		$vtBalance 		= $vendAcctls[3] - $txtBalance;
		$vendor->UpdateVenAccBlnc($venDtls[0],$bAccDtls[1], $vtBalance);
		
		
		//add the Company Transaction Records
		$company->addCompTran('payment', $txtPayType, $txtCheqeNo,$bAccDtls[0],$venDtls[1],$txtBalance,'dr',
		$currBalance,$txtProdDesc,$userData[2]);
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'vendor-bill-entry.php', "Transaction has been successfully completed", 'SUCCESS');
	}
	
}//eof add emp payment book entry


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtTranType','txtPayType', 'txtCheqeNo', 'txtBalance', 'txtProdDesc');
	
	//forward
	header("Location: vendor-bill-entry.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Vendor Payment</title>

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

<script type="text/javascript" src="../js/sample_product.js"></script>
<script type="text/javascript" src="../js/order_colour.js"></script>
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
                	<h1>Payment For Vendor: <?php echo $venDtls[1];?>&nbsp;&nbsp;Bill No:<?php echo $vBillDtls[2];?> </h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
						
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'create_Tran')) 
					{	
					?>
						<br>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php $_SERVER['PHP_SELF']?>?action=create_Tran&vbe_id=<?php echo $vbe_id; ?>" method="post" enctype="multipart/form-data">
                            <div class="cl"></div>
							
							<div >
								<label>Payment From<span class="orangeLetter">*</span></label>							
								<select name="txtTranFrom" type="text" id="txtTranFrom" class="text_box_large">
								<?php
								$comDetails         = $company->getCompAccData();
								foreach ($comDetails as $row){//Array or records stored in $row
								$compDtls 			= $company->showCompDtls($row['account_name']);
								?>
									<option value="<?php echo $row['ca_id'];?>"><?php echo $compDtls[1];?>(<?php echo $row['bank'];?>)</option> 
								<?php
								//echo $empDetail[6]." ".$empDetail[7];
								/* Option values are added by looping through the array */ 
									
								}
								 echo "</select>";//?>
							</div>
							
                            <div class="cl"></div>
							<div >
								<label>Payment Type<span class="orangeLetter">*</span></label>							
								<select name="txtPayType" type="text" id="txtPayType" class="text_box_large">
									<option value="cash">Cash</option> 
									<option value="cheque">Cheque</option> 
									<option value="Online">Online</option> 
								</select>
							</div> 
                            <div class="cl"></div>
                            <label>Cheque No</label>
                            <input name="txtCheqeNo" type="text" class="text_box_large" id="txtCheqeNo" 
					        value="<?php $utility->printSess2('txtCheqeNo',''); ?>" size="25" />
                            <div class="cl"></div>
                            
							<label>Payment Amount(Rs.) <span class="orangeLetter">*</span></label>
                            <input name="txtBalance" type="text" class="text_box_large" id="txtBalance" 
					        value="<?php echo $vBillDtls[10]; ?>" size="25" />
                            <div class="cl"></div>
							
                            <label>Notes</label>
							 <textarea  name="txtProdDesc" id="txtProdDesc">
							 <?php $utility->printSess2('txtProdDesc',''); ?>
							</textarea> 
							
                            <div class="cl"></div>
                                                         
                            <input name="btnAddPay" type="submit" class="button-add"  value="add" />
                           
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
