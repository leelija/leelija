<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 

require_once("../classes/purchase.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/sample.class.php");

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
$purchase		= new Purchase();

$search_obj		= new Search();
$page			= new Pagination();
$sample			= new Sample();

$customer		= new Customer();
$status			= new Pstatus();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$userId			= $utility->returnSess('userid', 0);
$custDetails	= $customer->getCustomerData($userId);

$sid			= $utility->returnGetVar('sid','0');

$sampleDtl       = $sample->showSample($sid);
$sampleColorDtl  = $sample->showColour($sid);

//add a product
if(isset($_POST['btnAddPurchase']))
{	
	$txtSlipName 	    = $_POST['txtSlipName'];
	$txtSlipNo	 		= $_POST['txtSlipNo'];
	$txtPurchsName	 	= $_POST['txtPurchsName'];
	$txtAddress	 		= $_POST['txtAddress'];
	$txtMobile	 	    = $_POST['txtMobile'];
	$txtPurchaseDate	= $_POST['txtPurchaseDate'];
	$txtBillBy	 		= $_POST['txtBillBy'];
	$txtPurchaseBy	 	= $_POST['txtPurchaseBy'];
	$filePhoto			=  $_FILES['filePhoto']['name'];
	$txtTotalAmount	 	= $_POST['txtTotalAmount'];
	$fileSubImg			=  $_FILES['fileSubImg']['name'];
	$fileSubImg2		=  $_FILES['fileSubImg2']['name'];
	
	$txtProdDesc 		= $_POST['txtProdDesc'];
	$selNum				= $_POST['selNum'];
	
	
	//registering the post session variables
	$sess_arr	= array('txtSlipName','txtSlipNo', 'txtPurchsName', 'txtAddress', 'txtMobile', 'txtPurchaseDate', 'txtBillBy',
		'txtPurchaseBy','txtTotalAmount');
	$utility->addPostSessArr($sess_arr);
	//defining error variables
	$action		= 'add_precord';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	
	$msg = '';
	if($txtSlipName=='')
	{
		echo "Slip Name empty";
	}
	
	elseif($txtPurchsName=='')
	{
		echo "From Purchase(company) field empty";
	}
	elseif($txtPurchaseDate=='')
	{
		echo "Purchase date field empty";
	}
	else
	{
		
	//add the Purchase
	  $purchase_id =  $purchase->addPurchase($txtSlipName, $txtSlipNo, $txtPurchsName, $txtAddress, $txtMobile, $txtPurchaseDate,
	  $txtBillBy,$txtPurchaseBy,$filePhoto,$txtTotalAmount,$txtSlipName,$fileSubImg2,$txtProdDesc,$custDetails[2]);
	  
	  //rename the slip1 name
		$newName = $utility->getNewName4($_FILES['fileSubImg'], '',$purchase_id);
			
			//upload in the server
			$imgid = $uImg->imgCropResize($_FILES['fileSubImg'], '', $newName, 
								   'images/bill-received/', 
								   3000, 4800, $purchase_id,'image', 'purchase_id', 'hmdad_purchase_book');	
		 //rename the slip2 name
		$newNameslip2 = $utility->getNewName4($_FILES['fileSubImg2'], '',$purchase_id);
			
			//upload in the server
			$imgid = $uImg->imgCropResize($_FILES['fileSubImg2'], '', $newNameslip2, 
								   'images/bill-received/', 
								   3000, 4800, $purchase_id,'image2', 'purchase_id', 'hmdad_purchase_book');	
	
		//rename the receive photo
		$newNamereceiver = $utility->getNewName4($_FILES['filePhoto'], '',$purchase_id);
			
			//upload in the server
			$imgid = $uImg->imgCropResize($_FILES['filePhoto'], '', $newNamereceiver, 
								   'images/receiver/', 
								   500, 680, $purchase_id,'rphoto', 'purchase_id', 'hmdad_purchase_book');		
	
	
	
		for($i=0; $i < $selNum; $i++)
			{
				$totalAmount = $_POST['txtNoOfParticulars'][$i] * $_POST['txtRate'][$i];
				//add the Purchase Details
				$purchase->addPurchaseDtls($purchase_id, $_POST['txtParticulars'][$i],$_POST['txtNoOfParticulars'][$i],$_POST['txtRate'][$i],$totalAmount);	
			}
		
			
			
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'purchase.php', "Purchase Records has been successfully Added ", 'SUCCESS');
	}
	
}//eof add product


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtSlipName','txtSlipNo', 'txtPurchsName', 'txtAddress', 'txtMobile', 'txtPurchaseDate', 'txtBillBy',
		'txtPurchaseBy','txtTotalAmount');
	

	//forward
	header("Location: purchase.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Add Product</title>

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
<script type="text/javascript" src="../js/purchase-record-add.js"></script>
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
                	<h1>Purchase Records</h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_precord')) 
					{	
					?>
                   
                        <h2><a name="addUser">Add Purchase Records</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                          
							<div class="cl"></div>                      
                    		<label>Slip Name<span class="orangeLetter">*</span></label>
                            <input name="txtSlipName" type="text" class="text_box_large" id="txtSlipName" 
					           value=""
                              size="25" />
                            <div class="cl"></div>
                          
                            
                             <label>Slip No<span class="orangeLetter">*</span></label>
                            <input name="txtSlipNo" type="text" class="text_box_large" id="txtSlipNo" 
					        value="<?php $utility->printSess2('txtSlipNo',''); ?>" size="25" />
                            <div class="cl"></div>
                            
                            <label>From Purchase (Company Name)</label>
                            <input name="txtPurchsName" type="text" class="text_box_large" id="txtPurchsName" 
					        value="<?php $utility->printSess2('txtPurchsName',''); ?>" size="25" />
                            <div class="cl"></div>
                            
							<label>Form Purchase(Address)<span class="orangeLetter">*</span></label>
                            <input name="txtAddress" type="text" class="text_box_large" id="txtAddress" 
					        value="<?php $utility->printSess2('txtAddress',''); ?>" size="25" />
                            <div class="cl"></div>
							
                             <label>Mobile No.<span class="orangeLetter">*</span></label>
                            <input name="txtMobile" type="text" class="text_box_large" id="txtMobile" 
					        value="<?php $utility->printSess2('txtMobile',''); ?>" size="25" />
                            <div class="cl"></div>
                             
							<label>Purchase Date<span class="orangeLetter"></span></label>
                            <input name="txtPurchaseDate" type="date" class="text_box_large" id="txtPurchaseDate" 
					        value="<?php $utility->printSess2('txtPurchaseDate',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>Bill By(M/S)<span class="orangeLetter">*</span></label>
                            <input name="txtBillBy" type="text" class="text_box_large" id="txtBillBy" 
					        value="<?php $utility->printSess2('txtBillBy',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>Purchase By(Receive by)<span class="orangeLetter">*</span></label>
                            <input name="txtPurchaseBy" type="text" class="text_box_large" id="txtPurchaseBy" 
					        value="<?php $utility->printSess2('txtPurchaseBy',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>Photo(Receiver)</label>
							<input name="filePhoto" id="filePhoto" type="file" class="text-field" />
							<span class="orangeLetter"></span>
							<div class="cl"></div>
							
							<label>Total Amount<span class="orangeLetter">*</span></label>
                            <input name="txtTotalAmount" type="text" class="text_box_large" id="txtTotalAmount" 
					        value="<?php $utility->printSess2('txtTotalAmount',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<tr>
									<label>Select No. of Particulars Type</label>
									<!--<td align="left" class="menuText">Select No. Type </td>-->
									<td align="left" class="bodyText pad5">
									<?php 
									//gen number array
									$arr_value	= range(1,8);
									$arr_label	= range(1,8);
									?>
									  <select name="selNum" id="selNum" onchange="return getPurchaseRecord();"
									   class="textBoxA">
										<option value="0">--Select--</option>
										<?php 
										if(isset($_SESSION['selNum']))
										{
											$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
										}
										else if(isset($_GET['selNum']))
										{
											$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
										}
										else
										{
											$utility->genDropDown(0, $arr_value, $arr_label);
										}
										?>
									  </select>				    </td>
								  </tr>
								<div class="cl"></div>
								<div id="showPurchaseDtls"></div>
													
							<label>Image(Slip Upload)</label>
							<input name="fileSubImg" id="fileSubImg" type="file" class="text-field" />
							<span class="orangeLetter"></span>
							<div class="cl"></div>
							
							<label>Image2(Slip2 Upload)</label>
							<input name="fileSubImg2" id="fileSubImg2" type="file" class="text-field" />
							<span class="orangeLetter"></span>
							<div class="cl"></div>
							
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
                            <div class="cl"></div>
                            <div class="cl"></div>
                                                        
                                                                                
                            <input name="btnAddPurchase" type="submit" class="button-add"  value="add" />
                           
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
