<?php
ob_start();
session_start();
?>
<?php 
//session_start();
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

require_once("../classes/status_cat.class.php");
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
$stock			= new Stock();
$statuscat			= new StatusCat();

$customer			= new Customer();
$prodStatus			= new Pstatus();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

//admin detail
$userData =  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$dhmckfip			= $utility->returnGetVar('dhmckfip','0');
$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);



//echo $customerDtl[2];exit;
$DyeingDtl		=$statuscat->showProductStatCat($dhmckfip);
$customerDetail = $customer->getCustomerData($DyeingDtl[5]);// dyer name display

//echo $customerDetail[5];exit;

// echo $DyeingDtl[1];exit;

// product status details



if(isset($_POST['btnEditOrd']))
{	
	$txtEmpId 	        	= $_POST['txtEmpId'];
	$txtBillNo				= $_POST['txtBillNo'];
	$txtFabType 	        = $_POST['txtFabType'];
	$txtFabAmountlft 	    = $_POST['txtFabAmountlft'];
	$txtFabAmountcomp 	    = $_POST['txtFabAmountcomp'];
	
	$OrderDate				= $_POST['OrderDate'];
	$TargetDate				= $_POST['TargetDate'];
	
	$txtProdDesc 	        = $_POST['txtProdDesc'];
	
	
// Calculate current stock
//$current_stock= $txtAmount+$fabricDtl[2];
	
	//registering the post session variables
	
	$sess_arr	= array('txtEmpId','txtBillNo','txtFabType','txtFabAmount','OrderDate','TargetDate');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'in_fid';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	
	$msg = '';


if($OrderDate == '')
	{
		echo "Order date field empty";
	}
	
	else
	{
		//Edit Dyeing table
	   $statuscat->editDyeing($dhmckfip,$DyeingDtl[1],$DyeingDtl[2],$DyeingDtl[3],$DyeingDtl[4],$txtEmpId,$DyeingDtl[6],
	   $txtFabAmountlft,$txtProdDesc,$OrderDate,$TargetDate,$userData[10],$txtFabAmountcomp,$DyeingDtl[16],$txtBillNo,$txtFabType);	
	   
	   
	   
	 /*  $prodStatusDtl	=$prodStatus->showProductStat($DyeingDtl[1]);
	   
	   $prodStatus->editStatus($DyeingDtl[1],$prodStatusDtl[1],$prodStatusDtl[2], $prodStatusDtl[19],$prodStatusDtl[3],
	   $prodStatusDtl[4], $prodStatusDtl[5],$txtStatus,$prodStatusDtl[7],$prodStatusDtl[8],$prodStatusDtl[18],$prodStatusDtl[9],
	   $prodStatusDtl[10],$prodStatusDtl[11],$prodStatusDtl[12],$prodStatusDtl[13],$prodStatusDtl[20]);
	 */
	 
	  // $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], 'Dyeing has been update', 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - EDIT Dyeing status</title>

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
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'update_dyeing') )
        {
             
            $DyeingDetails = $statuscat->showProductStatCat($dhmckfip);
        ?>
		
<h3><a name="editStock">Edit Dyeing status</a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=update_dyeing&dhmckfip=<?php echo $dhmckfip; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Edit dyeing status</a></h2>
                        <span>Please  <span class="required"></span>fill the amount field.</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
							
							
							<div >
								<label>Dyer Name<span class="orangeLetter">*</span></label>							
								<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
								<option value=<?php echo $customerDetail[38];?> ><?php echo $customerDetail[2];?></option>
								<?php
									$customerDetails         = $customer->getAllCustomerDtlPipeline(8);
									foreach ($customerDetails as $row){//Array or records stored in $row
									//echo $row[colour_name];
									echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

									/* Option values are added by looping through the array */ 
													
									}

									echo "</select>";//?>
							</div>
		
							
                            <div class="cl"></div>
							
							<label>Bill No</label>
							<input name="txtBillNo" id="txtBillNo" type="text" class="text-field" value="<?php echo $DyeingDtl[17]; ?>" />
							<div class="cl"></div>
							
							<label>Fabric Type</label>
							<input name="txtFabType" id="txtFabType" type="text" class="text-field" value="<?php echo $DyeingDtl[18]; ?>" />
							<div class="cl"></div>
							
							<label>Left Fabric(meter)</label>
							<input name="txtFabAmountlft" id="txtFabAmountlft" type="text" class="text-field" value="<?php echo $DyeingDtl[7]; ?>" />
							<div class="cl"></div>
							<label>Complete Fabric(meter)</label>
							<input name="txtFabAmountcomp" id="txtFabAmountcomp" type="text" class="text-field" value="<?php echo $DyeingDtl[15]; ?>" />
							<div class="cl"></div>
							
							<label>Order Date<span class="orangeLetter">*</span></label>
							  <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" 
								value="<?php echo $DyeingDtl[9]; ?>" size="25"  />
							  <div class="cl"></div>
												
							  <label>Target Date<span class="orangeLetter">*</span></label>
							  <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
							  value="<?php echo $DyeingDtl[10]; ?>" size="25"  />
							  <div class="cl"></div>
							
							 <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
								<?php echo $DyeingDtl[8]; ?>
                            </textarea>
                            <div class="cl"></div>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="update" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
