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
require_once("../classes/employee.class.php"); 
require_once("../classes/stock.class.php"); 
require_once("../classes/sample.class.php"); 
require_once("../classes/ratechart.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$employee		= new Employee();
$search_obj		= new Search();
$pages			= new Pagination();
$stock			= new Stock();
$sample			= new Sample();
$rateChart		= new Ratechart();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$keyword		= $utility->returnGetVar('keyword','');
$type			= $utility->returnGetVar('type','');
$mode			= $utility->returnGetVar('mode','');

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);


//add a product
if(isset($_POST['btnAddPay']))
{	
	$txtDesignNo 	    	= $_POST['txtDesignNo'];
	$txtFactory	 			= $_POST['txtFactory'];
	$txtDyeCost	 			= $_POST['txtDyeCost'];
	$txtCompSCost	 		= $_POST['txtCompSCost'];
	$txtHighLightCost	 	= $_POST['txtHighLightCost'];
	
	$txtHandPerc	 		= $_POST['txtHandPerc'];
	$txtTotalHandCost		= $_POST['txtTotalHandCost'];
	
	$txtPureHandCost		= $_POST['txtPureHandCost'];
	$txtManualCost			= $_POST['txtManualCost'];
	$txtCuttingCost	 		= $_POST['txtCuttingCost'];
	$txtFinalSCost			= $_POST['txtFinalSCost'];
	$txtIronCost			= $_POST['txtIronCost'];
	$txtPackingCost			= $_POST['txtPackingCost'];
	$txtPhotoCost			= $_POST['txtPhotoCost'];
	$txtDesignCost			= $_POST['txtDesignCost'];
	$txtAddiCost			= $_POST['txtAddiCost'];
	$txtTotalCost			= $_POST['txtTotalCost'];
	$txtPercentage			= $_POST['txtPercentage'];
	$txtNetCost				= $_POST['txtNetCost'];
	$txtProdDesc			= $_POST['txtProdDesc'];
	
	$selNum					= $_POST['selNum'];
	
	//$txtSIGST	 		= $_POST['txtSIGST'];
	//registering the post session variables
	$sess_arr	= array('txtDesignNo','txtFactory', 'txtDyeCost', 'txtCompSCost', 'txtHighLightCost', 'txtPureHandCost',
	'txtManualCost','txtCuttingCost','txtFinalSCost','txtIronCost','txtPackingCost','txtPhotoCost','txtDesignCost','txtAddiCost'
	,'txtTotalCost','txtPercentage','txtNetCost');
	
	$utility->addPostSessArr($sess_arr);
	
	//defining error variables
	$action		= 'addProdRate';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	
	
	$msg = '';

	if($txtDesignNo =='')
	{
		echo "Put the Design Number";
	}
	elseif($txtTotalCost == ''){
		echo "Put the Total Balance";
	}
	else
	{
		//Add product Rate
		$prId = $rateChart->addProductionRate($txtDesignNo,$txtFactory,$fab_cost,$txtDyeCost,$txtCompSCost,$txtHighLightCost, $txtPureHandCost,
		$txtHandPerc,$txtTotalHandCost,$txtManualCost,$txtCuttingCost,$txtFinalSCost,$txtIronCost,$txtPackingCost,$txtPhotoCost,$txtDesignCost,$txtAddiCost,$txtTotalCost,
		$txtPercentage,$txtNetCost,$txtProdDesc,$userData[10]);
		
		for($i=0; $i < $selNum; $i++)
			{	
				$prodRateDtls 	= $rateChart->showProductionRate($prId);
				
				$fabCost 		= $_POST['txtFabRate'][$i] * $_POST['txtFabAmount'][$i];
				//add the Fabrics Prod rate
				$rateChart->addProdFabRate($prId,$_POST['txtFabName'][$i],$_POST['txtFabRate'][$i],
				$_POST['txtFabAmount'][$i], $fabCost);	
				
				$fabCosting 	= $fabCost + $prodRateDtls[3];
				//Update Fab Costing
				$rateChart->editProdRateFabAmount($prId,$fabCosting);
			}	
			
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'production-rate.php', "New Record has been successfully added", 'SUCCESS');
	}
	
}//eof add emp payment book entry


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtDesignNo','txtFactory', 'txtDyeCost', 'txtCompSCost', 'txtHighLightCost', 'txtPureHandCost',
	'txtManualCost','txtCuttingCost','txtFinalSCost','txtIronCost','txtPackingCost','txtPhotoCost','txtDesignCost','txtAddiCost'
	,'txtTotalCost','txtPercentage','txtNetCost');
	
	//forward
	header("Location: production-rate.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> -Add New Design Rate Record</title>
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
<script type="text/javascript" src="../js/fabric-rate.js"></script>

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
                	<h1>Add New Design Rate Record</h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'addProdRate')) 
					{	
					?>
						<br>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
							<div class="cl"></div>
							<label>Design No<span class="orangeLetter">*</span></label>
                            <input name="txtDesignNo" type="text" class="text_box_large" id="txtDesignNo" 
					        value="<?php $utility->printSess2('txtDesignNo',''); ?>" size="25" />
							<div class="cl"></div>
							<div >
								<label>Factory Name<span class="orangeLetter">*</span></label>							
								<select name="txtFactory" type="text" id="txtFactory" class="text_box_large">
									<option value="2">HMDA Dyeing</option> 
									<option value="1">MOni Enterprises</option> 
								</select>
							</div>
							<div class="cl"></div>
							<tr>
								<label>Select No. of Fabrics</label>
								<!--<td align="left" class="menuText">Select No. Type </td>-->
								<td align="left" class="bodyText pad5">
								<?php 
									//gen number array
									$arr_value	= range(1,10);
									$arr_label	= range(1,10);
								?>
									<select name="selNum" id="selNum" onchange="return getFabricRate();"
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
									</select>				   
								</td>
							</tr>
								<div class="cl"></div>
								<div id="showFabricRate"></div>
							
							<div class="cl"></div>
							<label>Total Fabric Cost<span class="orangeLetter"></span></label>
                            <input name="txttFabCost" type="text" class="text_box_large" id="txttFabCost" 
					        value="<?php $utility->printSess2('txttFabCost',''); ?>" size="25" />
							<div class="cl"></div>
							
							<label>Dyeing Cost<span class="orangeLetter"></span></label>
                            <input name="txtDyeCost" type="text" class="text_box_large" id="txtDyeCost" 
					        value="<?php $utility->printSess2('txtDyeCost',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>Computer Stitch Cost <span class="orangeLetter"></span></label>
                            <input name="txtCompSCost" type="text" class="text_box_large" id="txtCompSCost" 
					        value="<?php $utility->printSess2('txtCompSCost',''); ?>" size="25" />
                            <div class="cl"></div>
							
                            <label>HighLight Cost<span class="orangeLetter"></span></label>
                            <input name="txtHighLightCost" type="text" class="text_box_large" id="txtHighLightCost" 
					        value="<?php $utility->printSess2('txtHighLightCost',''); ?>" size="25" />
                            <div class="cl"></div>
                            
							<label>PureHand Cost<span class="orangeLetter"></span></label>
                            <input name="txtPureHandCost" type="text" class="text_box_large" id="txtPureHandCost" 
					        value="<?php $utility->printSess2('txtPureHandCost',''); ?>" size="25" />
                            <div class="cl"></div>
							<label>Hand Percentage<span class="orangeLetter"></span></label>
                            <input name="txtHandPerc" type="text" class="text_box_large" id="txtHandPerc" 
					        value="<?php $utility->printSess2('txtHandPerc',''); ?>" size="25" />
                            <div class="cl"></div>
							<label>Total Hand Cost<span class="orangeLetter"></span></label>
                            <input name="txtTotalHandCost" type="text" class="text_box_large" id="txtTotalHandCost" 
					        value="<?php $utility->printSess2('txtTotalHandCost',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<label>Manual Cost<span class="orangeLetter"></span></label>
                            <input name="txtManualCost" type="text" class="text_box_large" id="txtManualCost" 
					        value="0" size="25" />
                            <div class="cl"></div>
							
							
                            <label>Cutting Cost<span class="orangeLetter">*</span></label>
                            <input name="txtCuttingCost" type="text" class="text_box_large" id="txtCuttingCost" 
					         value="15" size="25" />
                            <div class="cl"></div>
                             
							<label>Final Stitch Cost <span class="orangeLetter">*</span></label>
                            <input name="txtFinalSCost" type="text" class="text_box_large" id="txtFinalSCost" 
					        value="<?php $utility->printSess2('txtFinalSCost',''); ?>" size="25" />
                            <div class="cl"></div>
							
                            <label>Iron Cost<span class="orangeLetter">*</span></label>
                            <input name="txtIronCost" type="text" class="text_box_large" id="txtIronCost" 
					        value="10" size="25" />
                            <div class="cl"></div>
                            
							<label>Packing Cost<span class="orangeLetter">*</span></label>
                            <input name="txtPackingCost" type="text" class="text_box_large" id="txtPackingCost" 
					        value="10" size="25" />
                            <div class="cl"></div>
							
							<label>Photo Cost<span class="orangeLetter">*</span></label>
                            <input name="txtPhotoCost" type="text" class="text_box_large" id="txtPhotoCost" 
					        value="25" size="25" />
                            <div class="cl"></div>
							
                            <label>Design Cost<span class="orangeLetter">*</span></label>
                            <input name="txtDesignCost" type="text" class="text_box_large" id="txtDesignCost" 
					         value="50" size="25" />
                            <div class="cl"></div>
							
							<div class="cl"></div>
                             <label>Additional Cost <span class="orangeLetter"></span></label>
                            <input name="txtAddiCost" type="text" class="text_box_large" id="txtAddiCost" 
					        value="0" size="25" />
                            <div class="cl"></div>
							
                            <label>Total Cost<span class="orangeLetter"></span></label>
                            <input name="txtTotalCost" type="text" class="text_box_large" id="txtTotalCost" 
					        value="<?php $utility->printSess2('txtTotalCost',''); ?>" size="25" />
                            <div class="cl"></div>
                            
							<label>Percentage(%)<span class="orangeLetter"></span></label>
                            <input name="txtPercentage" type="text" class="text_box_large" id="txtPercentage" 
					        value="10" size="25" />
                            <div class="cl"></div>
							
							<label>Net Cost<span class="orangeLetter"></span></label>
                            <input name="txtNetCost" type="text" class="text_box_large" id="txtNetCost" 
					        value="<?php $utility->printSess2('txtNetCost',''); ?>" size="25" />
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
    $("#txttFabCost").keyup(function() {
	//alert('hi');
        var grandTotal = 0;
        $("input[name='txtFabAmount[]']").each(function (index) {
            var txtFabAmount 	= $("input[name='txtFabAmount[]']").eq(index).val();
			var txtFabRate 		= $("input[name='txtFabRate[]']").eq(index).val();
            var TotalFabCost 	= parseFloat(txtFabAmount) * parseFloat(txtFabRate);
            
            if (!isNaN(TotalFabCost)) {
				$("input[name='TotalFabCost[]']").eq(index).val(TotalFabCost);
				grandTotal = parseInt(grandTotal) + parseInt(TotalFabCost);    
            	$('#txttFabCost').val(grandTotal);
            }
        });
    });
});
</script>

<script>	
$(document).ready(function() {
    $("#txttFabCost,#txtFinalSCost,#txtDyeCost,#txtCompSCost,#txtTotalHandCost,#txtManualCost,#txtCuttingCost,#txtIronCost,#txtPackingCost,#txtPhotoCost,#txtDesignCost,#txtAddiCost").keyup(function() {
       // var grandTotal = 0;
        $("input[name='txtDyeCost']").each(function (index) {
			var txttFabCost  		= $("input[name='txttFabCost']").eq(index).val();
            var txtDyeCost  		= $("input[name='txtDyeCost']").eq(index).val();
            var txtCompSCost 		= $("input[name='txtCompSCost']").eq(index).val();
			var txtTotalHandCost 	= $("input[name='txtTotalHandCost']").eq(index).val();
            var txtManualCost 		= $("input[name='txtManualCost']").eq(index).val();
			var txtFinalSCost 		= $("input[name='txtFinalSCost']").eq(index).val();
			var txtCuttingCost  	= $("input[name='txtCuttingCost']").eq(index).val();
            var txtIronCost 		= $("input[name='txtIronCost']").eq(index).val();
			var txtPackingCost 		= $("input[name='txtPackingCost']").eq(index).val();
			var txtPhotoCost  		= $("input[name='txtPhotoCost']").eq(index).val();
            var txtDesignCost 		= $("input[name='txtDesignCost']").eq(index).val();
			var txtAddiCost 		= $("input[name='txtAddiCost']").eq(index).val();
            var txtTotalCost 		= parseFloat(txttFabCost) + parseFloat(txtDyeCost) + parseFloat(txtCompSCost) + parseFloat(txtTotalHandCost) + 
			parseFloat(txtManualCost) + parseFloat(txtFinalSCost) + parseFloat(txtCuttingCost)
			 + parseFloat(txtIronCost) + parseFloat(txtPackingCost) + parseFloat(txtPhotoCost) + parseFloat(txtDesignCost)
			 + parseFloat(txtAddiCost);
			///alert(txtTotalCost);
			$("#txtTotalCost").val(txtTotalCost);
            
		});
    });
});


$(document).ready(function() {
	//alert('hi..1');
	$("#txtHighLightCost,#txtPureHandCost,#txtHandPerc").keyup(function() {
     //alert('hi..2');
		$("input[name='txtHighLightCost']").each(function (index) {
			var txtHighLightCost  		= $("input[name='txtHighLightCost']").eq(index).val();
			var txtPureHandCost  		= $("input[name='txtPureHandCost']").eq(index).val();
			var txtHandPerc  			= $("input[name='txtHandPerc']").eq(index).val();
            var htotal					= parseFloat(txtHighLightCost) + parseFloat(txtPureHandCost);
			
			var txtNethCost 			= parseFloat(htotal) + ( parseFloat(htotal) * parseFloat(txtHandPerc) ) / 100;
			$("#txtTotalHandCost").val(txtNethCost);
			//alert(htotal);
		});
    });
});

</script>		
     
<script>	
$(document).ready(function() {
//alert('Hi..12');
    $("#txtPercentage").keyup(function() {
       // var grandTotal = 0;
        $("input[name='txtTotalCost']").each(function (index) {
            var txtTotalCost  		= $("input[name='txtTotalCost']").eq(index).val();
            var txtPercentage 		= $("input[name='txtPercentage']").eq(index).val();
			
            var txtNetCost 		= parseFloat(txtTotalCost) + ( parseFloat(txtTotalCost) * parseFloat(txtPercentage) ) / 100;
			///alert(txtTotalCost);
			$("#txtNetCost").val(txtNetCost);
            
		});
    });
});

</script>

<script>	


</script>	
			 
</body>
</html>
