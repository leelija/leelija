<?php 
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
require_once("../classes/sample.class.php");
require_once("../classes/customer.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/photo_gallery.class.php");

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

$customer			= new Customer();
$status			= new Pstatus();
$photogallery	= new PhotoGAllery();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$sid			= $utility->returnGetVar('sid','0');

$sampleDtl       = $sample->showSample($sid);
$sampleColorDtl  = $sample->showColour($sid);

//add a product
if(isset($_GET['orderId']))
{	
	$orderId	 	= $_GET['orderId'];
	
	$orderDetail = $orders->showOrders($orderId);
	//echo $orderId;exit;

	
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
                	<h1>Orders Sheet</h1><a href="order.php">Back |</a>
					<a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>
                </div>
                <!-- Form -->
                <div class="webform-area" id="PrintForm">
				<br><br>
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['orderId'])) 
					{	
						$orderId	 		= $_GET['orderId'];
						$orderDetail    	= $orders->showOrders($orderId);
						$orderColourDtl 	= $orders->ordersDtlDisplay($orderDetail[0]);
						
						//Photo Gallery Details
						$photoGalleryDetail = $photogallery->showSampleGalleryDgn($orderDetail[1]);
						// Date Format
						$orddate			= date_create($orderDetail[9]);
						$trddate			= date_create($orderDetail[10]);
						//Dye schedule
						$today				= date_format($orddate,"d-m-Y");
						$dTargetDt			= date('d-m-Y', strtotime($today. ' + 3 days'));
						//Computer schedule
						$cTargetDt			= date('d-m-Y', strtotime($dTargetDt. ' + 4 days'));
						//Hand schedule
						$hTargetDt			= date('d-m-Y', strtotime($cTargetDt. ' + 5 days'));
						//Stitch schedule
						$sTargetDt			= date('d-m-Y', strtotime($hTargetDt. ' + 2 days'));
						//Checking schedule
						$ckhTargetDt		= date('d-m-Y', strtotime($sTargetDt. ' + 2 days'));
						
						//date_add($orddate,date_interval_create_from_date_string("2 days"));
						//echo date_format($orddate,"d-m-Y");
						
						//echo count($photoGalleryDetail);exit;
					?>
					<!---<div class="remarks" style="text-align: center; width: 150px; height: 100px; background: #fff;
					position: absolute;top: 60px; left: 800px;">
						<h2 style="">
							<?php 
								//$date=$orderDetail[9];
								$date=date_create($orderDetail[9]);
								echo date_format($date,"d-m-Y");
							?>
						</h2>
						<h2 style="">
							<a style="color: blue;" name="addUser">D.No <?php echo $orderDetail[1];?></a><br>
							<span style="color: red;"><?php echo 'total:'; $orders->TotalQuantitySum($orderDetail[0]);echo "Pcs";?></span>
						</h2>
					</div>-->
					
					<!-- Display Data -->
					<div id="data-column">
						<div id="dvData">   	
						
						<table width="100%" class="single-column" cellpadding="0" cellspacing="0">
							<thead width="100%">
							 <th colspan="5" style="text-align:center;border: solid 1px #000;">Dyeing</th>
							 <th colspan="5" style="text-align:center;border: solid 1px #000;">Computer</th>
							 <th colspan="5" style="text-align:center;border: solid 1px #000;">Manual</th>
							</thead>
						  <tr style="border: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;">Name</td>
							<td style="text-align:center;border: solid 1px #ddd;">Ord.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Trg.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Rcv.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Status</td>
							
							<td style="text-align:center;border: solid 1px #ddd;">Name</td>
							<td style="text-align:center;border: solid 1px #ddd;">Ord.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Trg.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Rcv.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Status</td>
							
							<td style="text-align:center;border: solid 1px #ddd;">Name</td>
							<td style="text-align:center;border: solid 1px #ddd;">Ord.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Trg.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Rcv.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Status</td>
							
						  </tr>
						  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"><?php echo date_format($orddate,"d-m-Y");?> </td>
							<td style="text-align:center;border: solid 1px #ddd;color:red; font-weight: bold;"> <?php echo $dTargetDt;?></td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"><?php echo $dTargetDt;?> </td>
							<td style="text-align:center;border: solid 1px #ddd;color:red; font-weight: bold;"> <?php echo $cTargetDt;?></td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
						  </tr>
						<?php
							for ($x = 0; $x <= 2; $x++) {
						?>
						
						  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
						  </tr>
						<?php
							}
						?>	
						</table>
                       </div> 
					</div> <!-- end Display Data -->  
					
					<div class="cl"></div>
					<br>
					<!-- Display Data -->
					<div id="data-column">
						<div id="dvData">   	
						
						<table width="100%" class="single-column" cellpadding="0" cellspacing="0">
						   <thead width="100%">
							 <th colspan="5" style="text-align:center;border: solid 1px #000;">Hand</th>
							 <th colspan="5" style="text-align:center;border: solid 1px #000;">Final Stitching</th>
							 <th colspan="5" style="text-align:center;border: solid 1px #000;">Checking</th>
						  </thead>
						  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;">Name</td>
							<td style="text-align:center;border: solid 1px #ddd;">Ord.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Trg.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Rcv.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Status</td>
							
							<td style="text-align:center;border: solid 1px #ddd;">Name</td>
							<td style="text-align:center;border: solid 1px #ddd;">Ord.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Trg.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Rcv.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Status</td>
							
							<td style="text-align:center;border: solid 1px #ddd;">Name</td>
							<td style="text-align:center;border: solid 1px #ddd;">Ord.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Trg.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Rcv.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Status</td>
							
						  </tr>
						  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"><?php echo $cTargetDt;?> </td>
							<td style="text-align:center;border: solid 1px #ddd;color:red; font-weight: bold;"> <?php echo $hTargetDt;?></td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"><?php echo $hTargetDt;?> </td>
							<td style="text-align:center;border: solid 1px #ddd;color:red; font-weight: bold;"> <?php echo $sTargetDt;?></td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							
							<td style="text-align:center;border: solid 1px #ddd;"></td>
							<td style="text-align:center;border: solid 1px #ddd;"><?php echo $sTargetDt;?> </td>
							<td style="text-align:center;border: solid 1px #ddd;color:red; font-weight: bold;"> <?php echo $ckhTargetDt;?></td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
						  </tr>
						<?php
							for ($x = 0; $x <= 2; $x++) {
						?>
						
						  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
						  </tr>
						<?php
							}
						?>	
						</table>
                       </div> 
					</div> <!-- end Display Data --> 
					<br>
					
					<!-- Display Data -->
					<div id="data-column" style="width: 55%; float:left;">
						<div id="dvData">   	
						
						<table width="100%" class="single-column" cellpadding="0" cellspacing="0">
							<thead width="100%">
							 <th colspan="5" style="text-align:center;border: solid 1px #000;">Iron</th>
							 <th colspan="5" style="text-align:center;border: solid 1px #000;">Packing</th>
							</thead>
						  <tr style="border: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;">Name</td>
							<td style="text-align:center;border: solid 1px #ddd;">Ord.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Trg.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Rcv.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Status</td>
							
							<td style="text-align:center;border: solid 1px #ddd;">Name</td>
							<td style="text-align:center;border: solid 1px #ddd;">Ord.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Trg.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Rcv.Dt</td>
							<td style="text-align:center;border: solid 1px #ddd;">Status</td>
						  </tr>
						  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> <?php echo $sTargetDt;?></td>
							<td style="text-align:center;border: solid 1px #ddd;color:red; font-weight: bold;"> <?php echo $ckhTargetDt;?></td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd; color:red; font-weight: bold;"> <?php echo $ckhTargetDt;?></td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
						  </tr>
						<?php
							for ($x = 0; $x <= 2; $x++) {
						?>
						
						  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
							<td style="text-align:center;border: solid 1px #ddd;"> </td>
						  </tr>
						<?php
							}
						?>	
						</table>
                       </div> 
					</div> <!-- end Display Data -->  
					
					<!-- Display Data -->
					<div id="data-column" style="width:44%;float: right;">
						<div id="dvData">   	
						<table width="100%" class="single-column" cellpadding="0" cellspacing="0">
						  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;">Order Details</td>
							<td style="text-align:center;border: solid 1px #ddd;">Photo</td>
							<td style="text-align:center;border: solid 1px #ddd;">Colour</td>
						  </tr>
						
						  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
							<td style="text-align:center;border: solid 1px #ddd;"> 
								<span style="color:red;"><b>Design No: <?php echo $orderDetail[1];?></b></span><br>
								<span style="color:green;">Order Id: <?php echo $orderId;?></span><br>
								<p style="color:blue;">Order Dt.:<?php echo date_format($orddate,"d-m-Y");?><br>
								Trd. Dt.:<?php echo date_format($trddate,"d-m-Y");?><br>
								<?php echo 'total:'; $orders->TotalQuantitySum($orderDetail[0]);echo "Pcs";?><br>
								Order By: <?php echo $orderDetail[2];?></p>
								</b>
							</td>
							<td style="text-align:center;border: solid 1px #ddd;">
								<?php if((count($photoGalleryDetail)) == 0){ 
									echo "No IMage";
								}else{
								?>	
									<img src="../images/spgallery/large/<?php echo $photoGalleryDetail[6];?>" alt="Gallery" width="120" height="180">
								<?php
								}
								?>
							</td>
							<td style="text-align:center;border: solid 1px #ddd;"> 
								<a style="font-size: 16px;" href="#" 
								onClick="MM_openBrWindow('order_color_dtl.php?action=color_dtl&oid=<?php echo $orderDetail[0]; ?>','OrdAssign','scrollbars=yes,width=500,height=400')">
								<?php	
								 foreach($orderColourDtl as $record)
								{
								 echo $record['colour'];echo ":";echo $record['quantity'];echo '<br>';
								}
								 	?>				  </a> 
							
							</td>
							
						  </tr>
						</table>
                       </div> 
					</div> <!-- end Display Data --> 
					<div class="cl"></div>
					<br>
				
					REMARKS:
					<div class="remarks" style="width: 100%; height: 30px; border: solid 1px; #000;">
						<?php echo $orderDetail[8];?>
					</div>
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
	
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
	
<!--Used for print-->
	<script type="text/javascript">     
        function PrintDiv() {    
           var PrintForm = document.getElementById('PrintForm');
           var popupWin = window.open('', '_blank', 'width=800,height=800');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + PrintForm.innerHTML + '</html>');
           popupWin.document.close();
                }
    </script>
	<!--end print process-->
	
     
</body>
</html>
