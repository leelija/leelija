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
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");

require_once("../classes/sample.class.php");
require_once("../classes/plan.class.php");

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

$sample			= new Sample();
$plan			= new Plan();

$customer		= new Customer();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$userId			= $utility->returnSess('userid', 0);

$oid			= $utility->returnGetVar('oid','0');
//echo $DesignNo;exit;
$orderDetail = $orders->showOrders($oid);

$custDetails=$customer->getCustomerData($userId);

$stockDetail = $stock->showStockDtl();

//add a product
if(isset($_POST['btnAddProd']))
{	
	$txtOrderId 	        = $_POST['txtOrderId'];
	$txtDesignNo	 	= $_POST['txtDesignNo'];
	
	$txtQuantity	 	= $_POST['txtQuantity'];
	$txtStatus			= $_POST['txtStatus'];
	$txtEmpId	 	    = $_POST['txtEmpId'];
	$txtStartDate	 	= $_POST['txtStartDate'];
	$txtEndDate	 	    = $_POST['txtEndDate'];
	
	$txtProdDesc	 	= $_POST['txtProdDesc'];
	//registering the post session variables
	$sess_arr	= array('txtOrderId','txtDesignNo','txtQuantity','txtStatus','txtEmpId','txtStartDate','txtEndDate');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'add_plan';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addPlan';
	$typeM		= 'ERROR';
	
	
	$msg = '';


	if($txtOrderId == '')
	{
		echo "Please Fill Up Order Id field";
	}
	elseif($txtDesignNo=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERPROD00111, $typeM, $anchor);
	}
	elseif($txtQuantity=='')
	{
		echo "Please Fill Up Quantity field";
	}
	elseif($txtStatus=='')
	{
		echo "Select Status ";
	}
	elseif($txtEmpId=='')
	{
		echo "Please Fill Up Employee Id field";
	}
	elseif($txtStartDate=='')
	{
		echo "Please Fill Up Start Date field";
	}
	elseif($txtEndDate=='')
	{
		echo "Please Fill Up End Date field";
	}
	
	else
	{
		
	//add the stock table
	    $plan->addPlan($txtOrderId,$txtDesignNo,$txtQuantity,$txtStatus,$txtEmpId,$txtStartDate,$txtEndDate,0,$txtProdDesc,"");
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'plan.php', PLODOD001, 'SUCCESS');
	}
	
}//eof add product


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtOrderId','txtDesignNo','txtQuantity','txtStatus','txtEmpId','txtStartDate','txtEndDate');
	
	//forward
	header("Location: plan.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Add Sample Product</title>

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
                	<h1>Add Plan</h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_plan')) 
					{	
					?>
                   
                        <h2><a name="addUser">Add Plan</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                          
                           
                             <label>Order Id<span class="orangeLetter">*</span></label>
                            <input name="txtOrderId" type="text" class="text_box_large" id="txtOrderId" 
					        value="<?php echo $orderDetail[0]; ?>" size="25" />
                            <div class="cl"></div>
                             <label>Design No<span class="orangeLetter">*</span></label>
                            <input name="txtDesignNo" type="text" class="text_box_large" id="txtDesignNo" 
					        value="<?php echo $orderDetail[1]; ?>" size="25" />
                            <div class="cl"></div>
							
							<label>Quantity<span class="orangeLetter">*</span></label>
                            <input name="txtQuantity" type="text" class="text_box_large" id="txtQuantity" 
					        value="<?php  $orders->TotalQuantitySum($oid);?>" size="25" />
                            <div class="cl"></div>
							
							<div >
                                    <label>Status<span class="orangeLetter">*</span></label>
                                    
                                    <select name="txtStatus" type="text" id="txtStatus" class="text_box_large">
                                    <option value="0">------ Select an option ------</option>
                                    <option value="Dyeing" >Dyeing</option>
                                    <option value="Hand" >Hand</option>
                                    <option value="Manual" >Manual</option>
                                    <option value="Computer" >Computer</option>
                                    <option value="Kali Cutting" >Kali Cutting</option>
                                    <option value="Final Stiching" >Final Stiching</option>
                                    <option value="Iron" >Iron</option>
                                    <option value="Packing" >Packing</option>
                                    
                                    
                                    </select>
                            </div>
                            <div class="cl"></div>
							                        
                         <!--   <label>employee Id<span class="orangeLetter">*</span></label>
                            <input name="txtEmpId" type="text" class="text_box_large" id="txtEmpId" 
					        value="<?php //$utility->printSess2('txtEmpId',''); ?>" size="25" />
                            <div class="cl"></div>-->
							
							
							 <div >
							<label>Employee Name<span class="orangeLetter">*</span></label>							
							
							<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
							<?php
							$customerDetails         = $customer->getAllCustomerDetails();
							foreach ($customerDetails as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

							/* Option values are added by looping through the array */ 
								
							}

							 echo "</select>";//?>
							 </div>
							
							
							
							<div class="cl"></div>
							
                             <label>Start Date<span class="orangeLetter">*</span></label>
                            <input name="txtStartDate" type="date" class="text_box_large" id="txtStartDate" 
					        value="<?php echo $orderDetail[9]; ?>" size="25" />
                            <div class="cl"></div>
							
							<label>End Date<span class="orangeLetter">*</span></label>
                            <input name="txtEndDate" type="date" class="text_box_large" id="txtEndDate" 
					        value="<?php $utility->printSess2('txtEndDate',''); ?>" size="25" />
                            <div class="cl"></div>
							
							
							
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
                            <div class="cl"></div>
							
							
                            
                            
<?php /*?>                            <label>Tax</label>
                            <select name="txtTaxId" id="txtTaxId" class="textBoxA">
							  <?php
                              if(isset($_SESSION['txtTaxId']))
                              {
                                $tax->taxDropDown($_SESSION['txtTaxId']);
                              }
                              else
                              {
                                $tax->taxDropDown(0);
                              } 
                              ?>
                            </select>	
                            <div class="cl"></div><?php */?>
                            
                           
                            <div class="cl"></div>
                            
                           <!-- <span class="menuTxt"><a href="#AddDesc" onClick="showAdditionalDesc('divId')"> Add additional Remarks</a></span>
                            <div class="cl"></div>
                            
                            <a name="AddDesc">
                                <div id="divId" class="hideDesc">
                                    <label>Additional Remarks</label>
                                    <textarea  name="txtRemarks" id="txtRemarks">
                                    <?php //$utility->printSess2('txtRemarks',''); ?>
                                    </textarea>
                                </div>
                            </a>-->
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
