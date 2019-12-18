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
require_once("../classes/customer.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/sample.class.php"); 
require_once("../classes/pagination.class.php");
require_once("../classes/product_stock.class.php"); 
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
$productStock	= new ProductStock();
$customer		= new Customer();
$sample			= new Sample();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$AddDate		= $utility->returnSess('userid', 0);

date_default_timezone_set('Asia/Calcutta'); 
//echo date("Y-m-d H:i:s"); // time in India
//Customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);
$stockDetail 	= $productStock->showProdStockDtl();

//add a product Stock
if(isset($_POST['btnAddProd']))
{	
	$txtDesignNo	 	= $_POST['txtDesignNo'];
	$txtFactoryId 	    = $_POST['txtFactoryId'];
	$txtProdDesc	 	= $_POST['txtProdDesc'];
	
	$AddDate 			= date("Y-m-d");// Added Date
	//registering the post session variables
	$sess_arr	= array('txtFactoryId','txtDesignNo', 'txtStock', 'txtProductIn', 'txtSales', 'txtGdReturn', 'AddDate',
		'txtProdDesc');
	$utility->addPostSessArr($sess_arr);

	//defining error variables
	$action		= 'sid_ord';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addStock';
	$typeM		= 'ERROR';
	$msg = '';
	
	//field validation
	$duplicateId	= $error->duplicateUser($txtDesignNo, 'design_no', 'stock_products');

	if($txtDesignNo=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERPROD00111, $typeM, $anchor);
	}
	elseif( ($txtDesignNo != '') && (preg_match("/^ER/i",$duplicateId)) )		
	{
		
		$error->showErrorTA($action, $id, $id_var, $url, "Design No. already in use", $typeM, $anchor);
	}
	
	else
	{
		//add the product stock table
	    $productStock->addStockProduct($txtDesignNo, '', '', '', '','',
		$txtProdDesc,$txtFactoryId, $AddDate,$userData[2]);

	// Add the stock details
	/*foreach( $data as $row ) {
		$stock->addstockDetails($stockDetail[0], );
	}*/	
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'stock.php', SUPROD001, 'SUCCESS');
	}
	
}//eof add product


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtStockId','txtDesignNo', 'txtStock', 'txtProductIn', 'txtSales','txtGdReturn', 'AddDate',
		'txtProdDesc');
	
	//option value variables 
	/*$optValIds	= $prodAttr->getOptionValId(0);
	$chkOptVal 	= $uNum->createIdArr($optValIds, 'ov');
	
	//merging array
	$allArr		= 	array_merge($sess_arr, $chkOptVal);	
	$utility->delSessArr($allArr);*/
	
	//forward
	header("Location: stock.php");
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

<!--/*-------Add Remove Text field--------*/-->
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" name="colourtext[]" placeholder="colour" style="width:100px;" /><input type="text" name="piecestext[]" placeholder="pieces" style="width:100px;"/><br><a href="#" class="remove_field">Remove</a></div><br>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

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
                	<h1>   </h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_stock')) 
					{	
					?>
                   
                        <h2><a name="addUser">Add New Design</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            <label>Design No<span class="orangeLetter">*</span></label>
                            <input name="txtDesignNo" type="text" class="text_box_large" id="txtDesignNo" 
					        value="<?php $utility->printSess2('txtDesignNo',''); ?>" size="25" />
                            <div class="cl"></div>
							 <div >
								<label>Factory Name<span class="orangeLetter">*</span></label>							
									<select name="txtFactoryId" type="text" id="txtFactoryId" class="text_box_large">
										<?php
											$factDetails         = $sample->getAllFactory();
											foreach ($factDetails as $eachrecord){//Array or records stored in $row
											//echo $row[colour_name];
											echo "<option value=$eachrecord[factory_id]>$eachrecord[factory_name]</option>"; 

											/* Option values are added by looping through the array */ 
										}

									echo "</select>";//?>
							</div>  
							<div class="cl"></div>
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
							
							 <label>Add Date<span class="orangeLetter">*</span></label>
                            <input name="AddDate" type="date" class="text_box_large" id="AddDate" 
					        value="<?php $utility->printSess2('AddDate',''); ?>" size="25" />
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
