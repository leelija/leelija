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
require_once("../classes/stock.class.php");
require_once("../classes/purchase_company.class.php");
require_once("../classes/mmaterials.class.php"); 
require_once("../classes/customer.class.php");
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
$stock			= new Stock();
$mmats		    = new Mmaterials();
$customer		= new Customer();
$pCompany		= new PurchaseCompany();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$fid			= $utility->returnGetVar('fid','0');

$userId			= $utility->returnSess('userid', 0);
//$customerDtl	= $customer->getCustomerData($userId);
//customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);


//echo $customerDtl[2];exit;
$matsDtl		=  $mmats->showMmaterials($fid);


if(isset($_POST['btnEditOrd']))
{	
	$txtAmount 	        = $_POST['txtAmount'];
	$txtPrice 	        = $_POST['txtPrice'];
	$txtGST				= $_POST['txtGST'];
	$txtTamount			= $_POST['txtTamount'];
	$txtBillNo 	        = $_POST['txtBillNo'];
	$txtCompany 	    = $_POST['txtCompany'];
	$txtCheckBy 	    = $_POST['txtCheckBy'];
	$txtPayStatus 	    = $_POST['txtPayStatus'];
	
	$txtProdDesc 	    = $_POST['txtProdDesc'];
	
	// Calculate current stock
	$current_stock		= $txtAmount + $matsDtl[5];
	//echo $current_stock;exit;
	//registering the post session variables
	
		$sess_arr	= array('txtAmount','txtCompany','txtPrice','txtTamount','txtProdDesc');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'in_fid';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	
	$msg = '';


if($txtAmount == '')
	{
		echo "Materials Amount field empty";
	}
	elseif($txtPrice == ''){
		echo "Price/unit field empty"; 
	}
	
	else
	{
		//add the fabric
		$matId 		= $mmats->addMmaterialsIn($fid,$txtAmount,$txtPrice,$txtGST,$txtTamount,$txtCompany,$txtBillNo,
		$txtProdDesc,$txtCheckBy,$userData[2],$txtPayStatus);	
		
		// update total fabric amount
		$mmats->editMmaterials($fid,$current_stock,$userData[2]);
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Materials/Fabrics Has been successfully added", 'SUCCESS');
		
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - Add Materials</title>

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

<!--Jquery Calender-->
<script src="../js/jQuery/jquery.min.js" type="text/javascript"></script>
<script src="../js/jQuery/jquery-ui.min.js" type="text/javascript"></script>
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
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'in_fid') )
        {
             
            $matsDtl		=  $mmats->showMmaterials($fid);
        ?>
		
<h3><a name="editStock"></a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=in_fid&fid=<?php echo $fid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Materials <?php echo $matsDtl[1];?>, Colour: <?php echo $matsDtl[2];?> In</a></h2>
                        <span>Please  <span class="required"></span>fill the amount field.</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            <div class="cl"></div>
							<label>Materials/Fabric Quantity(in <?php echo $matsDtl[4];?>)<span class="orangeLetter">*</span></label>
                            <input name="txtAmount" type="text" class="text_box_large" id="txtAmount" 
					         size="25" />
                            <div class="cl"></div>
							
							<label>Rate/<?php echo $matsDtl[4];?><span class="orangeLetter">*</span></label>
                            <input name="txtPrice" type="text" class="text_box_large" id="txtPrice" 
					         size="25" />
							<div class="cl"></div> 
							<label>GST<span class="orangeLetter">*</span></label>
                            <input name="txtGST" type="text" class="text_box_large" id="txtGST" 
					         size="25" />
							<div class="cl"></div> 
							
							<div class="cl"></div> 
							<label>Total Amount<span class="orangeLetter">*</span></label>
                            <input name="txtTamount" type="text" class="text_box_large" id="txtTamount" 
					         size="25" />
							<div class="cl"></div>
							
							<label>Bill No<span class="orangeLetter"></span></label>
                            <input name="txtBillNo" type="text" class="text_box_large" id="txtBillNo" 
					         size="25" />
							<div class="cl"></div> 
							
							<div >
								<label>Company Name<span class="orangeLetter">*</span></label>							
								<select name="txtCompany" type="text" id="txtCompany" class="text_box_large">
								<?php
									$pCompanyDtls         = $pCompany->showPcompanyDtls();
									foreach ($pCompanyDtls as $row){//Array or records stored in $row
									//echo $row[colour_name];
								?>	
									<option value="<?php echo $row['company_id'];?>"><?php echo $row['company_name'];?>(<?php echo $row['city'];?>)</option> 
								<?php
									/* Option values are added by looping through the array */ 
													
									}

									echo "</select>";//?>
							</div> 
							 
                            <div class="cl"></div> 
							<label>Checked By<span class="orangeLetter"></span></label>
                            <input name="txtCheckBy" type="text" class="text_box_large" id="txtCheckBy" 
					         size="25" />
							<div class="cl"></div>
							
							<div >
								<label>Payment Status<span class="orangeLetter">*</span></label>							
								<select name="txtPayStatus" type="text" id="txtPayStatus" class="text_box_large">
									<option value="Unpaid">Unpaid</option>
									<option value="Paid">Paid</option>
									
								</select>
							</div>	
							<div class="cl"></div>
							 <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
                            <div class="cl"></div>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="Add" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
	
<script>	
$(document).ready(function() {
    $("#txtGST").keyup(function() {
       // var grandTotal = 0;
        $("input[name='txtAmount']").each(function (index) {
            var txtAmount  	= $("input[name='txtAmount']").eq(index).val();
            var txtPrice 	= $("input[name='txtPrice']").eq(index).val();
			var txtGST 		= $("input[name='txtGST']").eq(index).val();
			var gst			= parseFloat(txtAmount) * parseFloat(txtPrice) * parseFloat(txtGST) / 100;
            var txtTamount 	= parseFloat(txtAmount) * parseFloat(txtPrice) + parseFloat(gst);
			//alert(txtNetBalance);
			$("#txtTamount").val(txtTamount);
            
		});
    });
});

</script>			
