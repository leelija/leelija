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
require_once("../classes/interlock.class.php");
require_once("../classes/alter_particular.class.php");


require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");
require_once("../classes/fabric.class.php");

require_once("../classes/product_status.class.php");
require_once("../classes/status_cat.class.php");

require_once("../classes/rate.class.php"); 
require_once("../classes/labour.class.php"); 

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
$interlock		= new InterlockMst();
$alterParticular= new AlterParticular();

$rate			= new Rate();
$labour		    = new Labour();

$status			= new Pstatus();
$statusCat		= new StatusCat();

$customer		= new Customer();
$fabric		   = new Fabric();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$lid			= $utility->returnGetVar('lid','0');
$lbtwamount		= $utility->returnGetVar('lbtwamount','0');
$food			= $utility->returnGetVar('food','0');

$mealCharge 	= $food * 25;
$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

//echo $fsid;exit;

 $FinalStichDtlReceipt = $statusCat->showFinalStichReceipt($lid);
 
 $labourDtl = $labour->showLabour($lid);
 $bDate		= date_create($labourDtl[8]);
 //echo $lbtwamount; exit;

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Pay received</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link href="../style/admin/form.css" rel="stylesheet" type="text/css">

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
					<a href='labour.php' class="add-icon tooltip1" title="Print Payment Details">BACK</a>
                	<h1>Labour Billing</h1>
                </div>
                
                <!-- Form -->
        <div class="webform-area" id="webform-area" style="text-align:center;">	
			<div id="PrintForm"> <!--Print form start--> 
				<div style="width: 100%;">
					<p style="width: 50%; float: left;">MEP</p> 
					<p style="width: 48%;float:right; text-align: right;">Date: <?php echo date_format($bDate,"d/m/Y"); ?></p>
				</div>
				<div style="text-align:center;">
					<h1>Payment Receipt</h1>
					<?php 
					if($userData[10] == 'rabiul' OR $userData[10] =='hafijul'){
					
					?>
					<h1>WARDA ENTERPRISE</h1>
					<?php
					}else{
					?>
					<h1>Moni Enterprises</h1>
					<?php 
					}
					?>
					<p>Kadambagachi, Kol-125</p><br>
				</div>
				<p style="border-bottom: 1px dashed #999; text-align:left;">Messrs: &nbsp;<?php echo $labourDtl[1]; ?>
				(ID: <?php echo $labourDtl[0]; ?>)</p>
				<table border="1" cellpadding="0" cellspacing="0" width="100%" id="myTable" class="tblListForm">
						<tr class="listheader">
							<th class="listheader">Date</th>
							<th class="listheader">Design No</th>
							<th class="listheader">Order Id</th>
							<th class="listheader">Particulars</th>
							<th class="listheader">Quantity(pieces)</th>
							<th class="listheader">Rate(/par pieces)</th>
							<th class="listheader">Subtotal(RS)</th>
						</tr>

						<?php 

							$FinalStichDtlReceipt = $statusCat->showFinalStichReceipt($lid);?>
								
							<?php $reco_record = 0; 
							$tamount 	= 0;
							//echo "$data[2]";
							foreach( $FinalStichDtlReceipt as $eachrecord ){
	
							$stichratedtl 	= $rate->showStichRatePartiwise($eachrecord ['particular'],$eachrecord ['design_no']);
							$fStitchDtls 	= $statusCat->showProductFinalStich($eachrecord ['final_stich_id']);
							$tamount 		+= $eachrecord ['work_price'];
							//$bgColor 	= $utility->getRowColor($i);
							if($reco_record%2==0)
							$classname="evenRow";
							
								else
									$classname="oddRow";
  
						?>

						<tr class="table-row">
							<?php //echo "$reco_record";?>
							
							
							<td><?php echo $eachrecord ['added_on']; ?></td>
							<td ><?php echo $eachrecord ['design_no']; ?></td>
							<td ><?php echo $fStitchDtls[2]; ?></td>
							
							<td ><?php echo $eachrecord ['particular']; ?></td>
							<td><?php echo $eachrecord ['amount']; ?></td>
							<td><?php echo ($eachrecord ['work_price'] / $eachrecord ['amount']); ?></td>
							<td><?php echo $eachrecord ['work_price']; ?></td>
							
						</tr>

						<?php 

						$reco_record++;
						} 
						?>
					</table>
					
				<!--Start Interlock Rate Chart-->	
				<?php 
					$intlockDtlReceipt = $interlock->showInterlockReceipt($lid);
					
					if(count($intlockDtlReceipt) == 0)
						{
						}
					else{	
				?>	
					<table id="example" class="single-column" cellpadding="0" cellspacing="0">
                        <thead>
                          <th width="5%" >order Id </th>
                          <th width="10%"  >Design No</th>
						  <th width="10%"  >Labour</th>
						  <th width="10%"  >Particular Name</th>
						  <th width="10%"  >Quantity</th>
						  <th width="10%"  >rate</th>
						  <th width="10%"  >total Amount</th> 
                        </thead>
                       <?php 
							
                       //$k = $pages->getPageSerialNum($numResDisplay);
                      // $sid = array_slice($sid, $start, $limit);     
                        foreach($intlockDtlReceipt as $eachRecord)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							//$interlockDtl = $interlock->showInterlock($x);
							$labourDtl 			= $labour->showLabour($eachRecord['labour_id']);
							//$customerDetail 	= $client->getCustomerData($eachRecord['master_id']);
							$date				= date_create($eachRecord['added_on']);
							$InterlockRateDtls 	= $rate->showInterlockRate($eachRecord['interlock_rate_id']);
							
							//print_r($prodDetail);exit;
							//$bgColor 	= $utility->getRowColor($k);	
                    ?>
						<tr align="left">
						<td align="center"><?php echo $eachRecord['order_id']; ?></td>
						<td align="center"><?php echo $eachRecord['design_no']; ?></td>  
						<td align="center"><?php echo $labourDtl[1]; ?></td>
						<td align="center"><?php echo $InterlockRateDtls[1]; ?></td>
						<td align="center"><?php echo $eachRecord['inte_quantity']; ?></td>
						<td align="center"><?php echo $eachRecord['rate']; ?></td>
						<td align="center"><?php echo $eachRecord['total_cost']; ?></td>
					  
				     </tr>
                      <?php 
                            }
                      ?>
                  </table>
					
				<?php
						}
				?>	
				<!--end Interlock Rate chart-->
				
				<!--Start Alter Rate Chart-->
				<?php 
					$alterDtlReceipt = $alterParticular->showAlterReceipt($lid);
					
					if(count($alterDtlReceipt) == 0)
						{
						}
					else{	
				?>	
					<h2>Alter Rate Chart</h2>
					<table id="example" class="single-column" cellpadding="0" cellspacing="0">
                        <thead>
                          <th width="5%" >order Id </th>
                          <th width="10%"  >Design No</th>
						  <th width="10%"  >Labour</th>
						  <th width="10%"  >Particular Name</th>
						  <th width="10%"  >Quantity</th>
						  <th width="10%"  >rate</th>
						  <th width="10%"  >total Amount</th> 
                        </thead>
                       <?php 
					   
                        foreach($alterDtlReceipt as $eachRecord)
                            {
							
							$labourDtl 			= $labour->showLabour($eachRecord['labour_id']);
							//$customerDetail 	= $client->getCustomerData($eachRecord['master_id']);
							$date				= date_create($eachRecord['added_on']);
								
                    ?>
						<tr align="left">
						<td align="center"><?php echo $eachRecord['order_id']; ?></td>
						<td align="center"><?php echo $eachRecord['design_no']; ?></td>  
						<td align="center"><?php echo $labourDtl[1]; ?></td>
						<td align="center"><?php echo $eachRecord['particular']; ?></td>
						<td align="center"><?php echo $eachRecord['quantity']; ?></td>
						<td align="center"><?php echo $eachRecord['pay_per_piece']; ?></td>
						<td align="center"><?php echo $eachRecord['total_pay']; ?></td>
					  
				     </tr>
                      <?php 
                            }
                      ?>
                  </table>
					
					
				<?php
						}
				?>	
				<!--end Alter Rate Chart-->
				
				<div class="amauntcal" style="width:100%">
					<div class="amapay" style="float:left; width: 48%; text-align:left;">
						<p>Total Amount:<?php //echo $labourDtl[4] + $labourDtl[5] + $labourDtl[13] + $labourDtl[14];
						echo $lbtwamount;?></p>
						<p>Meal Charge(<?php echo $food; ?>):<?php echo $mealCharge; ?></p>
						<p>pay Amount:<?php echo $labourDtl[5]; ?></p>
						
					</div>
					
					<div class="amaadvdue" style="float:right; width: 48%; text-align: right;">
						<p>Advance Amount:<?php echo $labourDtl[10]; ?></p>
						<p>Prev Adv. Amount:<?php echo $labourDtl[13]; ?></p>
						<p>Due Amount:<?php echo $labourDtl[4]; ?></p>
					
					</div>
				
				</div><br>
				<div class="psignature" style="width:100%">
					<div class="PaidBY" style="float:left; width: 48%; text-align:left;">
						<div class="Paidline"></div>
						<p>Paid By</p>
					
					</div>
					<div class="lsig" style="float:right; width: 48%; text-align: right;">
						<p>Signature</p>
					
					</div>
				
				</div>
				
				<?php
					/*===================Labour payment update===============================================*/
					$statusCat->editFinalStichPayStatus($lid);
					//Interlock payment status update
					$interlock->updateIntlockPayStatus($lid);
					
					//Alter payment status update
					$alterParticular->updateAltPayStatus($lid);
				?>
				
				
			</div>
			<a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>
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
