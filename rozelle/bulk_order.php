<?php 
ob_start();
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 

require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");

require_once("../classes/rozelle_order.class.php");

require_once("../classes/plan.class.php");
require_once("../classes/party.class.php");

require_once("../classes/stock.class.php");

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

$plan			= new Plan();
$party			= new Party();


$rozelleOrder			= new Rozelleorders();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$sid			= $utility->returnGetVar('sid','0');

//echo $sid;exit;
$productDtl     = $stock->showStock($sid);
$productDetail  = $stock->showStockDetails($sid);

//add a product
if(isset($_POST['btnAddProd']))
{	
//echo "hi...";
	$txtBookNo 	        = $_POST['txtBookNo'];
	//$txtDesignNo	 	= $_POST['txtDesignNo'];
	/*$txtPartyName	 	= $_POST['txtPartyName'];
	$txtBrokar	 		= $_POST['txtBrokar'];
	$txtRetaHol	 	    = $_POST['txtRetaHol'];
	$txtForm	 		= $_POST['txtForm']; */
	$txtPriority	 	= $_POST['txtPriority'];
	$txtProdDesc	 	= $_POST['txtProdDesc'];
	$OrdersDate	 	= $_POST['OrdersDate'];
	$TargetDate 	= $_POST['TargetDate'];
	//$selNum			= $_POST['selNum'];
	//$selNum1			= $_POST['selNum1'];
	
	$PartyId			= $_POST['PartyId'];
	
	$partyDetail = $party->showParty($PartyId);
	
	$txtPartyName	 	= $PartyId;
	$txtBrokar	 		= $partyDetail[5];
	$txtRetaHol	 	    = $partyDetail[6];
	$txtForm	 		= $partyDetail[3];
	
	 //$product->addProduct($txtParentId,$txtProdName, $txtPageTitle, $txtProdCode, $intQuant, $txtProdPrice, $txtBrief,
		//$txtProdDesc,$txtSeoUrl,$txtCanonical,$txtMetaTag,$txtMetaDesc,$txtMetaKey);
	
	//registering the post session variables
	$sess_arr	= array('txtOrdNo','txtBrokar', 'txtRetaHol', 'txtForm', 'txtQuantity',
		'txtColour','txtProdDesc','OrdersDate','TargetDate');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'add_ord';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	
	
	$msg = '';


	
	if($txtBookNo=='')
	{
		echo "Fill up Book No. field";
	}
	
	elseif($TargetDate=='')
	{
		echo "Fill up Target date field";
	}
	else
	{
		
	
	 
		
		//echo count($_POST['txtDesign']);exit;
		//foreach ($_POST['txtDesign'] as $DesignNo)
		//foreach ($_POST['txtColour'] as $Colour)
		//foreach ($_POST['txtQuantity'] as $quantity)
		for($i=0; $i < count($_POST['txtDesign']); $i++)
			{
				//add the Orders
				$orders_id =  $rozelleOrder->addRozzeleOrders($_POST['txtDesign'][$i],$txtBookNo, $txtPartyName, $txtBrokar, $txtRetaHol, $txtForm, '',
				'',0,$txtPriority,'open',$txtProdDesc,$OrdersDate,$TargetDate);	
				//add the orders colour
				$rozelleOrder->addRozOrderDtl($orders_id,$_POST['txtDesign'][$i],$txtBookNo,$txtPartyName, $_POST['txtQuantity'][$i],$_POST['txtQuantity'][$i],'',$_POST['txtColour'][$i],
				$OrdersDate,$TargetDate,$txtPriority,$txtProdDesc);	
			}		
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'stock_product.php', 'order has been complete', 'SUCCESS');
	}
	
}//eof add product


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtOrdNo','txtBrokar', 'txtRetaHol', 'txtForm', 'txtQuantity',
		'txtColour','txtProdDesc','OrdersDate','TargetDate');
	
/*	//option value variables 
	$optValIds	= $prodAttr->getOptionValId(0);
	$chkOptVal 	= $uNum->createIdArr($optValIds, 'ov');
	
	//merging array
	$allArr		= 	array_merge($sess_arr, $chkOptVal);	
	$utility->delSessArr($allArr);*/
	
	//forward
	header("Location: stock_product.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Add Rozelle Orders</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link href="../style/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">

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
<script type="text/javascript" src="../js/rozelle_order.js"></script>
<script type="text/javascript" src="../js/rozelle_bulk_order.js"></script>
<script type="text/javascript" src="../js/bulk_colour.js"></script>

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

/*==========================================================================*/

</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> 
<script>
$(function(){
//alert("hi..")
    $('#addMore').on('click', function() {
              var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
              data.find("input").val('');
     });
     $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>0) {
             $(this).closest("tr").remove();
           } else {
             alert("Sorry!! Can't remove first row!");
           }
      });
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
                	<h1>Rozelle Orders</h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_ord')) 
					{	
					?>
                   
                        <h2><a name="addUser">Add Orders</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                        
							 <label>Book No<span class="orangeLetter">*</span></label>
                            <input name="txtBookNo" type="text" class="text_box_large" id="txtBookNo" 
					         size="25" />
                            <div class="cl"></div>
                            
                            
							 <div >
							<label>Party Code<span class="orangeLetter">*</span></label>							
							
							<select name="PartyId" type="text" id="PartyId" class="text_box_large">
							<?php
							$customerDetails         = $party->partyDtl();
							foreach ($customerDetails as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[party_id]>$row[party_id]</option>"; 

							/* Option values are added by looping through the array */ 
								
							}

							 echo "</select>";//?>
							 </div>	
							<div class="cl"></div>
                            
                      
					<table class="table table-hover" id="tb">
                        <thead>
                            <tr class="tr-header">
                                <th>DesignNo</th>
                                <th>Colour</th>
                                <th>Quantity</th>
								<th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More Row"><span class="glyphicon glyphicon-plus"></span></a></th>
                            </tr>
                        </thead>
						
						<tbody>
							<tr>
								<td>
									<div >
										
										<select name="txtDesign[]" type="text" id="txtDesign" class="text_box_large">
										<?php
										$stockDtlDetails         = $stock->stockAllDisplay();
										foreach ($stockDtlDetails as $row){//Array or records stored in $row
										//echo $row[colour_name];
										echo "<option value=$row[design_no]>$row[design_no]</option>"; 

										/* Option values are added by looping through the array */ 
											
										}

										 echo "</select>";//?>
									</div>
								</td>
								<td>
									<div >
										
										<select name="txtColour[]" type="text" id="txtColour" class="text_box_large">
										<?php
										$stockDtlDetl         = $stock->GetstockDetlDisplay();
										foreach ($stockDtlDetl as $row){//Array or records stored in $row
										//echo $row[colour_name];
										echo "<option value=$row[colour]>$row[colour]</option>"; 

										/* Option values are added by looping through the array */ 
											
										}

										 echo "</select>";//?>
									</div>
								
								</td>
								<td>
									<input name="txtQuantity[]" type="text" class="text_box_large" id="txtQuantity" 
									 value=""  />
								
								</td>
								<td>
									<a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a>
								</td>
								
							</tr>
						</tbody>	
					</table>				

							<div >
                                    <label>Priority <span class="orangeLetter">*</span></label>
                                    
                                    <select name="txtPriority" type="text" id="txtPriority" class="text_box_large" >
                                   <!-- <option value="0">------ Select an option ------</option> -->
                                    <option value="First" >First</option>
                                    <option value="second" >second</option>
                                    <option value="Third" >Third</option>
                                    
                                    </select>
                            </div>
                            <div class="cl"></div>
								
                            
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
							
							 <label>Orders Date<span class="orangeLetter"></span></label>
                            <input name="OrdersDate" type="date" class="text_box_large" id="OrdersDate" 
					        value="<?php echo date("Y-m-d"); ?>" size="25" />
                            <div class="cl"></div>
							
							<?php 
							$date = date("Y-m-d", strtotime("tomorrow"));
							//echo $date;
							?>
							 <label>Target Date<span class="orangeLetter">*</span></label>
                            <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
					        value="<?php echo $date; ?>" size="25" />
                           
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
