<?php
ob_start();
session_start();
?>
<?php 
//session_start();
require_once("_config/connect.php"); 

require_once("includes/constant.inc.php");
require_once("includes/product.inc.php");

require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php"); 
require_once("classes/order.class.php"); 
require_once("classes/search.class.php");
require_once("classes/pagination.class.php");
require_once("classes/stock.class.php");
require_once("classes/rate.class.php");

require_once("classes/status_cat.class.php");
require_once("classes/customer.class.php");
require_once("classes/product_status.class.php");
require_once("classes/pipe_status.class.php");
require_once("classes/alter_particular.class.php");
require_once("classes/labour.class.php"); 
require_once("classes/kalicut_mst.class.php");

require_once("classes/alter_rate.class.php"); 

require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php"); 
require_once("classes/utilityImage.class.php");
require_once("classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$stock			= new Stock();

$statuscat			= new StatusCat();
$rate				= new Rate();

$customer			= new Customer();
$prodStatus			= new Pstatus();
$pipestatus			= new Pipestatus();
$alterParticular	= new AlterParticular();
$labour		    = new Labour();
$altrate	    = new AlterRate();
$kalicutmst			= new KaliCutMst();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$dhmckfip			= $utility->returnGetVar('dhmckfip','0');// $dhmckfip	= alter id

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//$userData =  $customer->getCustomerData($_SESSION[USR_SESS]);

//echo $dhmckfip;exit;
$altPartDetail	=$alterParticular->showAlterParticular($dhmckfip);
/*
$packingpendDtl	=	$statuscat->showPackingPending($altPartDetail[8]);
$PackingDtl		=   $statuscat->showProductPakingbyord($altPartDetail[1]);
// alter rate
$alterrateDtl	=	$altrate->showAlterRatePartiwise($altPartDetail[4],$altPartDetail[2]);

$FinalStichDtl = $statuscat->showPStatusPrStatusId($packingpendDtl[1]);
*/
if(isset($_POST['btnAddAltPart']))
{	
	//$txtOrderId 	        = $_POST['txtOrderId'];
	//$txtDesignNo 	        = $_POST['txtDesignNo'];
	$txtMasterId	 		= $_POST['txtMasterId'];
	$txtEmpid	 			= $_POST['txtEmpid'];
/*	$txtQuantity	 		= $_POST['txtQuantity'];
	$txtCost	 			= $_POST['txtCost'];
	$txtEmpid	 			= $_POST['txtEmpid'];
	$txtProdDesc	 		= $_POST['txtProdDesc'];*/
	$selNum			= $_POST['selNum'];
	
	
	
	for($i=0; $i < $selNum; $i++)
			{
				// labour details
				$labourDtl = $labour->showLabour($txtEmpid);
				
				$txtKaliRateId	= $_POST['txtKaliRateId'][$i];
				$rateDtls 		= $rate->showKaliRate($txtKaliRateId);
				
				//$total_cost	= $_POST['txtKaliQuantity'][$i] * $_POST['txtrate'][$i];
				
				$total_cost		= $rateDtls[3] * $_POST['txtKaliQuantity'][$i];
				
				//add Kali work details
				$kalicutmst->addKaliCutMst($_POST['txtOrderId'][$i],$_POST['txtDesignNo'][$i],$txtMasterId,$txtEmpid,
				$rateDtls[1],$rateDtls[2],$_POST['txtKaliQuantity'][$i],$rateDtls[3],$total_cost);
				
				
				$totalearn = $labourDtl[4] + $total_cost;
				// labour account update
				$labour->editLabour($txtEmpid,'',$labourDtl[1],$labourDtl[12],$labourDtl[2],$labourDtl[3],$totalearn,$labourDtl[5],$labourDtl[10]);
						
				
			
				
			}
	
	
	//delete the stock
	//$statuscat->delPendingPacking($dhmckfip);
	
	//forward
	$uMesg->showSuccessT('success', 0, '', 'kalicut_mst.php', "kalicut_mst record has been successfully Added", 'SUCCESS');
	
}
if(isset($_POST['btnCancel']))
{
	//forward
	header("Location: kalicut_mst.php");
}



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Add Kali record</title>

<!-- Style -->
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>

<!--CSS Jquery Calender-->
<link rel="stylesheet" href="style/jQuery/jquery-ui.css" type="text/css" media="all" />
<!--CSS Jquery Calender-->

<!-- eof Style -->
 
<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/utility.js"></script>
<script type="text/javascript" src="js/advertiser.js"></script>
<script type="text/javascript" src="js/location.js"></script>
<script type="text/javascript" src="js/checkEmpty.js"></script>
<script type="text/javascript" src="js/email.js"></script>
<script type="text/javascript" src="js/static.js"></script>
<script type="text/javascript" src="js/category.js"></script>
<script type="text/javascript" src="js/product.js"></script>

<script type="text/javascript" src="js/sample_product.js"></script>
<script type="text/javascript" src="js/kalicut_mst.js"></script>
<!-- eof JS Libraries -->

<!--Jquery Calender-->
<script src="js/jQuery/jquery.min.js" type="text/javascript"></script>
<script src="js/jQuery/jquery-ui.min.js" type="text/javascript"></script>
<!--Jquery Calender-->  

<!-- TinyMCE --> 
 <script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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
                	<h1>Add Kali record</h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_altpart')) 
					{	
					?>
                   
                        <h2><a name="addUser"></a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
							
							<!--<label>Bill No.<span class="orangeLetter">*</span></label>
							<input name="txtBillNo" type="text" class="text_box_large" id="txtBillNo" 
								value="" size="25" />
							<div class="cl"></div>
							-->
							<div >
							<label>Master Name<span class="orangeLetter">*</span></label>							
							<select name="txtMasterId" type="text" id="txtMasterId" class="text_box_large">
							<?php
								$customerDetails         = $customer->getAllCustomerDtlPipeline(14);
								foreach ($customerDetails as $row){//Array or records stored in $row
								//echo $row[colour_name];
								echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

								/* Option values are added by looping through the array */ 
												
								}

								echo "</select>";//?>
							</div>
							<div class="cl"></div>
							
							<div >
									<label>Labour<span class="orangeLetter">*</span></label>							
									<select name="txtEmpid" type="text" id="txtEmpid" class="text_box_large">
										<?php
											$labourDetails         = $labour->LabourDtlDisplay();
											foreach ($labourDetails as $row){//Array or records stored in $row
											//echo $row[colour_name];
											echo "<option value=$row[labour_id]>$row[labour_name]</option>"; 

											/* Option values are added by looping through the array */ 
													
											}

										echo "</select>";//?>
							</div>
							<div class="cl"></div>
							
                            <div class="cl"></div>
							<tr>
								<label>Select No. of Kali</label>
									<!--<td align="left" class="menuText">Select No. Type </td>-->
									<td align="left" class="bodyText pad5">
									<?php 
									//gen number array
									$arr_value	= range(1,18);
									$arr_label	= range(1,18);
									?>
									  <select name="selNum" id="selNum" onchange="return getAlterParticular();"
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
								<div id="showKalicutRecord"></div>
                            <div class="cl"></div>
                                                        
                                                                                
                            <input name="btnAddAltPart" type="submit" class="button-add"  value="add" />
                           
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
