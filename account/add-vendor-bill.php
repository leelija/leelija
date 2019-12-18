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

$sid			= $utility->returnGetVar('sid','0');

//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[ACC_SESS]);


//add a product
if(isset($_POST['btnAddPay']))
{	
	$txtVenName 	    	= $_POST['txtVenName'];
	$txtBillNo	 			= $_POST['txtBillNo'];
	$txtBillingName	 		= $_POST['txtBillingName'];
	$txtBalance	 			= $_POST['txtBalance'];
	$txtSGSTRate	 		= $_POST['txtSGSTRate'];
	$txtCGSTRate			= $_POST['txtCGSTRate'];
	$txtNetBalance			= $_POST['txtNetBalance'];
	$txtProdDesc	 		= $_POST['txtProdDesc'];
	$txtTDSRate				= $_POST['txtTDSRate'];
	//$txtSIGST	 		= $_POST['txtSIGST'];
	//registering the post session variables
	$sess_arr	= array('txtVenName','txtBillNo', 'txtBillingName', 'txtBalance', 'txtSGSTRate', 'txtCGSTRate',
	'txtNetBalance','txtProdDesc');
	
	$utility->addPostSessArr($sess_arr);
	
	//defining error variables
	$action		= 'add_cmpAcc';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	
	
	$msg = '';

	if($txtBillNo =='')
	{
		echo "Put the Bill Number";
	}
	elseif($txtBalance == ''){
		echo "Put the Balance";
	}
	else
	{
		
		$sgst	= $txtBalance * ($txtSGSTRate / 100);	
		$cgst	= $txtBalance * ($txtCGSTRate / 100);	
		$tds	= $txtBalance * ($txtTDSRate / 100);	
		//add Vendor Bill Records
		$vendor->addVendorBillEnt($txtVenName,$txtBillNo,$txtBillingName, $txtBalance,$txtSGSTRate,$sgst, $txtCGSTRate,$cgst,
		0,0,$txtTDSRate,$tds,$txtNetBalance,$txtProdDesc,'unpaid',$userData[2]);
		
		$vendorDtls 	= $vendor->showVendor($txtVenName);
		$vBalance 		= $vendorDtls[6] + $txtNetBalance;
		$tTDS			= $vendorDtls[11] + $tds;
		//Edit Vendor Record
		$vendor->updateVendor($txtVenName,$vendorDtls[1],$vendorDtls[2], $vendorDtls[3],$vendorDtls[4],$vendorDtls[5], 
		$vBalance,$tTDS,$userData[2]);
		
		$venAccDtls 		= $vendor->showVenAccCompWise($txtVenName,$txtBillingName);
		if($txtVenName == $venAccDtls[1] && $txtBillingName == $venAccDtls[2])
			{
				$vtBalance 	= $venAccDtls[3] + $txtNetBalance;
				$vendor->UpdateVenAccBlnc($txtVenName,$txtBillingName, $vtBalance);
			}
		else{
				$vendor->addVenAcc($txtVenName,$txtBillingName, $txtNetBalance);
			}
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'vendor-bill-entry.php', "Bill Record has been successfully added", 'SUCCESS');
	}
	
}//eof add emp payment book entry


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtVenName','txtBillNo', 'txtBillingName', 'txtBalance', 'txtSGSTRate', 'txtCGSTRate',
	'txtNetBalance','txtProdDesc');
	
	//forward
	header("Location: vendor-bill-entry.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - New Vendor Bill Entry</title>

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
                	<h1>Vendor Bill Entry</h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_venBill')) 
					{	
					?>
						<br>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            <div class="cl"></div>
							<div >
								<label>Vendor Name<span class="orangeLetter">*</span></label>							
								<select name="txtVenName" type="text" id="txtVenName" class="text_box_large">
								<?php
								$venDetails         = $vendor->getVendorData();
								foreach ($venDetails as $row){//Array or records stored in $row
								?>
									<option value="<?php echo $row['vid'];?>"><?php echo $row['vcompany'];?></option> 
								<?php
								//echo $empDetail[6]." ".$empDetail[7];
								/* Option values are added by looping through the array */ 
									
								}
								 echo "</select>";//?>
							</div>
							<div class="cl"></div>
							<label>Bill No<span class="orangeLetter">*</span></label>
                            <input name="txtBillNo" type="text" class="text_box_large" id="txtBillNo" 
					        value="<?php $utility->printSess2('txtBillNo',''); ?>" size="25" />
                            <div class="cl"></div>
							<div >
								<label>Billing Name<span class="orangeLetter">*</span></label>							
								<select name="txtBillingName" type="text" id="txtBillingName" class="text_box_large">
								<?php
								$comDetails         = $company->getCompDtlsData();
								foreach ($comDetails as $row){//Array or records stored in $row
								?>
									<option value="<?php echo $row['comp_id'];?>"><?php echo $row['company_name'];?></option> 
								<?php
								//echo $empDetail[6]." ".$empDetail[7];
								/* Option values are added by looping through the array */ 
									
								}
								 echo "</select>";//?>
							</div>
							<div class="cl"></div>
							
							<label>Balance(Rs.) <span class="orangeLetter">*</span></label>
                            <input name="txtBalance" type="text" class="text_box_large" id="txtBalance" 
					        value="<?php $utility->printSess2('txtBalance',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>TDS(%)<span class="orangeLetter"></span></label>
                            <input name="txtTDSRate" type="text" class="text_box_large" id="txtTDSRate" 
					        value="1" size="25" />
                            <div class="cl"></div>
							
                            <label>SGST(%)<span class="orangeLetter"></span></label>
                            <input name="txtSGSTRate" type="text" class="text_box_large" id="txtSGSTRate" 
					        value="<?php $utility->printSess2('txtSGSTRate',''); ?>" size="25" />
                            <div class="cl"></div>
                            
							<label>CGST(%)<span class="orangeLetter"></span></label>
                            <input name="txtCGSTRate" type="text" class="text_box_large" id="txtCGSTRate" 
					        value="<?php $utility->printSess2('txtCGSTRate',''); ?>" size="25" />
                            <div class="cl"></div>
							
                            <label>Net Balance (Rs.)<span class="orangeLetter">*</span></label>
                            <input name="txtNetBalance" type="text" class="text_box_large" id="txtNetBalance" 
					         size="25" />
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

<script>	
$(document).ready(function() {
    $("#txtCGSTRate").keyup(function() {
       // var grandTotal = 0;
        $("input[name='txtBalance']").each(function (index) {
            var txtBalance  = $("input[name='txtBalance']").eq(index).val();
            var txtSGSTRate = $("input[name='txtSGSTRate']").eq(index).val();
			var txtCGSTRate = $("input[name='txtCGSTRate']").eq(index).val();
			var txtTDSRate 	= $("input[name='txtTDSRate']").eq(index).val();
			var sgst		= parseFloat(txtBalance) * parseFloat(txtSGSTRate) / 100;
			var cgst		= parseFloat(txtBalance) * parseFloat(txtCGSTRate) / 100;
			var tds			= parseFloat(txtBalance) * parseFloat(txtTDSRate) / 100;
            var txtNetBalance 		= parseFloat(txtBalance) + parseFloat(sgst) + parseFloat(cgst) - parseFloat(tds);
			//alert(txtNetBalance);
			$("#txtNetBalance").val(txtNetBalance);
            
		});
    });
});


</script>		
     
</body>
</html>