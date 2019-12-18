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
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_stock.class.php"); 
require_once("../classes/status_cat.class.php");
require_once("../classes/sample.class.php");
require_once("../classes/employee.class.php"); 

require_once("../classes/customer.class.php"); 
require_once("../classes/ratechart.class.php");
require_once("../classes/bill.class.php");


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
$employee		= new Employee();

$customer		= new Customer();
$statCat		= new StatusCat();
$ratechart		= new Ratechart();
$bill 			= new Bill();
$sample 		= new Sample();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$sid			= $utility->returnGetVar('sid','0');
$userId			= $utility->returnSess('userid', 0);
date_default_timezone_set('Asia/Calcutta'); 
//echo date("Y-m-d H:i:s"); // time in India
$attDate 		= date("Y-m-d");// Attendance Date
$attDateTime 	= date("d-m-Y H:i:s");// Attendance Date time

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

//Sample Db Details
$sampleDtls  	= $sample->showSampleDb($sid);

//Sample Fabric Details
$SamDyeingDtl 	= $sample->getAllfabricDtl($sid);
//Sample Hand details
$SamHandDtl 	= $sample->getAllHandDtl($sid);
//Sample Manual Details
$SamManualDtl 	= $sample->getAllManualEmbDtl($sid);
//Sample Computer Details
$SamComputerDtl = $sample->getAllComputerEmbDtl($sid);
//Final Stitch Details
$SamFstichlDtl  = $sample->getAllFstichDtl($sid);

?>

<title><?php echo COMPANY_S; ?> -  <?php echo $sampleDtls[3];?> Rate Review</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">

<link href="../style/custom-style.css" rel="stylesheet" type="text/css">

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'Rate-preview') )
        {
           
        ?>
			<div id="PrintForm" style="padding-left:80px;"><!-- start Print -->
				<h2 style="text-align: center;"><a name="addUser">Design No:<?php echo $sampleDtls[3];?></a></h2>
				<h2>Fabric Rate Chart</h2>
                <!-- Display Fabric and dye rate Data -->
                <div id="data-column" style="position:relative; bottom: 9px; font-size:12px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						if(count($SamDyeingDtl) == 0)
						{
						?>
                        <tr align="left" class="orangeLetter">
                          <td height="20" colspan="5"> <?php echo "Table is empty"; ?></td>
                         </tr>
                        <?php 
                        }
                        else
                        {
                        ?>  
                        <thead>
						<tr>
						  <th width="10%">Fabric</th>
						  <th width="10%">F.Amount(meter)</th>
						  <th width="10%">F.Rate/Meter </th>
						  <th width="10%">Total F. cost</th>
						  <th width="10%">Labour Rate/meter</th>
						  <th width="10%">Total Labour Cost</th>
						  <th width="10%">Total Cost</th>
						  <th width="10%">Time</th>
						  <th width="10%">Remarks</th>
						</tr>  
                        </thead>
						<tbody>
						   <?php 
							$sl=1;  
							$gTotalCost 		= 0;
							foreach($SamDyeingDtl as $eachrecord)
								{
								$bgColor 	 	= $utility->getRowColor($sl);
								
								$gTotalCost 	+= $eachrecord ['total_cost'];
							
						?>
							<tr align="left"<?php $utility->printRowColor($bgColor);?>>
								<td align="center"><?php echo $eachrecord ['fabric_name']; ?></td>
								<td align="center"><?php echo $eachrecord ['fab_amount']; ?></td>
								<td align="center"><?php echo $eachrecord ['rate_per_meter']; ?></td>
								<td align="center"><?php echo $eachrecord ['fab_amount'] * $eachrecord ['rate_per_meter']; ?></td>
								<td align="center"><?php echo $eachrecord ['labour_rate']; ?></td>
								<td align="center"><?php echo $eachrecord ['labour_cost'];?></td>
								<td align="center"><?php echo $eachrecord ['total_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['total_time'];?></td>
								<td align="center"><?php echo $eachrecord ['remarks'];?></td>
								
							</tr>
						  <?php 
							$sl++;
								}
								
							}
						  ?>
						</tbody>  
					</table>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Fabric Total Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. <?php echo $gTotalCost;?></b></p>
					</div>
					
                    <div class="first-column">
                  </div>
                  
                </div>
				
				
				<!-- Display Hand Rate -->
				<h2>Hand Rate Chart</h2>
				<div id="data-column" style="position:relative; bottom: 9px; font-size:12px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						if(count($SamHandDtl) == 0)
						{
						?>
                        <tr align="left" class="orangeLetter">
                          <td height="20" colspan="5"> <?php echo "Table is empty"; ?></td>
                         </tr>
                        <?php 
                        }
                        else
                        {
                        ?>  
                        <thead>
						<tr>
						 
						  <th width="10%">Employee</th>
						  <th width="10%">Work</th>
						  <th width="10%">Particulars </th>
						  <th width="10%">Time </th>
						  <th width="10%">Labour Cost </th>
						  <th width="10%">Material Cost</th>
						  <th width="10%">Others Cost</th>
						  <th width="10%">Total Cost</th>
						  <th width="20%">Remarks</th>
						</tr>  
                        </thead>
						<tbody>
						   <?php 
							$sl=1;  
							$gHTotalCost 		= 0;
							foreach($SamHandDtl as $eachrecord)
								{
								$bgColor 	 	= $utility->getRowColor($sl);
								$empdata 		= $employee->showEmployee($eachrecord['emp_id']);
								
								$gHTotalCost 	+= $eachrecord ['total_cost'];
							
						?>
							<tr align="left"<?php $utility->printRowColor($bgColor);?>>
								<td align="center"><?php echo $empdata[2]; ?></td>
								<td align="center"><?php echo $eachrecord ['work_type']; ?></td>
								<td align="center"><?php echo $eachrecord ['sample_particular']; ?></td>
								<td align="center"><?php echo $eachrecord ['sample_time']; ?></td>
								<td align="center"><?php echo $eachrecord ['labour_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['material_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['other_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['total_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['remarks']; ?></td>
								
							</tr>
						  <?php 
							$sl++;
								}
								
							}
						  ?>
						</tbody>  
					</table>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Hand Total Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. <?php echo $gHTotalCost;?></b></p>
					</div>
					
                    <div class="first-column">
                  </div>
                  
                </div>
				
                 <!-- Hand rate End-->
				
				<!-- Display Manual Rate -->
				<h2>Manual Rate Chart</h2>
				<div id="data-column" style="position:relative; bottom: 9px; font-size:12px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						
						if(count($SamManualDtl) == 0)
						{
						?>
                        <tr align="left" class="orangeLetter">
                          <td height="20" colspan="5"> <?php echo "No Value fount"; ?></td>
                         </tr>
                        <?php 
                        }
                        else
                        {
                        ?>  
                        <thead>
						<tr>
						  
						  <th width="10%">Employee</th>
						  <th width="10%">Particulars </th>
						  <th width="10%">Time </th>
						  <th width="10%">Labour Cost </th>
						  <th width="20%">Material Cost</th>
						  <th width="20%">Others Cost</th>
						  <th width="20%">Total Cost</th>
						  
						</tr>  
                        </thead>
						<tbody>
						   <?php 
							$sl=1;  
							$gMTotalCost 		= 0;
							foreach($SamManualDtl as $eachrecord)
								{
								$bgColor 	 	= $utility->getRowColor($sl);
								$empdata 		= $employee->showEmployee($eachrecord['emp_id']);
								
								$gMTotalCost 	+= $eachrecord ['total_cost'];
							
						?>
							<tr align="left"<?php $utility->printRowColor($bgColor);?>>
								<td align="center"><?php echo $empdata[2]; ?></td>
								<td align="center"><?php echo $eachrecord ['sample_particular']; ?></td>
								<td align="center"><?php echo $eachrecord ['sample_time']; ?></td>
								<td align="center"><?php echo $eachrecord ['labour_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['material_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['other_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['total_cost']; ?></td>
								
							</tr>
						  <?php 
							$sl++;
								}
								
							}
						  ?>
						</tbody>  
					</table>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Manual Total Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. <?php echo $gMTotalCost;?></b></p>
					</div>
					
                    <div class="first-column">
                  </div>
                  
                </div>
                 <!-- Manual rate End-->
				
				<!-- Display Computer Rate -->
				<h2>Computer Rate Chart</h2>
				<div id="data-column" style="position:relative; bottom: 9px; font-size:12px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						
						if(count($SamComputerDtl) == 0)
						{
						?>
                        <tr align="left" class="orangeLetter">
                          <td height="20" colspan="5"> <?php echo "No Value fount"; ?></td>
                         </tr>
                        <?php 
                        }
                        else
                        {
                        ?>  
                        <thead>
						<tr>
						 
						  <th class="listheader">Employee</th>
						  <th class="listheader">Particular</th>
						  <th class="listheader">C.Design No. </th>
						  <th class="listheader">Total Stitch</th>
						  <th class="listheader">No Of Heads</th>
						  <th class="listheader">Rate/Heads</th>
						  <th class="listheader">Stitch Cost</th>
						  <th class="listheader">Material Cost</th>
						  <th class="listheader">others Cost </th>
						  <th class="listheader">Total Cost </th>
						  <th class="listheader">Remarks </th>
						  
						</tr>  
                        </thead>
						<tbody>
						   <?php 
							$sl=1;  
							$gCTotalCost 		= 0;
							foreach($SamComputerDtl as $eachrecord)
								{
								$bgColor 	 	= $utility->getRowColor($sl);
								$empdata 		= $employee->showEmployee($eachrecord['emp_id']);
								
								$gCTotalCost 	+= $eachrecord ['total_cost'];
							
						?>
							<tr align="left"<?php $utility->printRowColor($bgColor);?>>
								<td align="center"><?php echo $empdata [2]; ?></td>
								<td align="center"><?php echo $eachrecord ['sample_particular']; ?></td>
								<td align="center"><?php echo $eachrecord ['com_design_no']; ?></td>
								<td align="center"><?php echo $eachrecord ['stich_amount']; ?></td>
								<td align="center"><?php echo $eachrecord ['no_of_heads']; ?></td>
								<td align="center"><?php echo $eachrecord ['stich_rate']; ?></td>
								<td align="center"><?php echo $eachrecord ['stich_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['material_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['other_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['total_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['remarks']; ?></td>
								
							</tr>
						  <?php 
							$sl++;
								}
								
							}
						  ?>
						</tbody>  
					</table>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Computer Total Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. <?php echo $gCTotalCost;?></b></p>
					</div>
					
                    <div class="first-column">
                  </div>
                  
                </div>
                 <!-- Computer rate End-->
				
				
				<!-- Display Final Stitch Rate -->
				<h2>Final Stitch Rate Chart</h2>
				<div id="data-column" style="position:relative; bottom: 9px; font-size:12px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						
						if(count($SamFstichlDtl) == 0)
						{
						?>
                        <tr align="left" class="orangeLetter">
                          <td height="20" colspan="5"> <?php echo "No Value fount"; ?></td>
                         </tr>
                        <?php 
                        }
                        else
                        {
                        ?>  
                        <thead>
						<tr>
						 
						    <th class="listheader">Employee</th>
							<th class="listheader">Particulars </th>
							<th class="listheader">Time </th>
							<th class="listheader">Material Cost</th>
							<th class="listheader">Particulars Cost</th>
							<th class="listheader">Other Cost</th>
							<th class="listheader">Total Cost </th>
							<th class="listheader">Remarks</th>
						  
						</tr>  
                        </thead>
						<tbody>
						   <?php 
							$sl=1;  
							$gFTotalCost 		= 0;
							foreach($SamFstichlDtl as $eachrecord)
								{
								$bgColor 	 	= $utility->getRowColor($sl);
								$empdata 		= $employee->showEmployee($eachrecord['emp_id']);
								
								$gFTotalCost 	+= $eachrecord ['total_cost'];
							
						?>
							<tr align="left"<?php $utility->printRowColor($bgColor);?>>
								<td align="center"><?php echo $empdata [2]; ?></td>
								<td align="center"><?php echo $eachrecord ['sample_particular']; ?></td>
								<td align="center"><?php echo $eachrecord ['sample_time']; ?></td>
								<td align="center"><?php echo $eachrecord ['material_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['labour_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['others_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['total_cost']; ?></td>
								<td align="center"><?php echo $eachrecord ['remarks']; ?></td>
								
							</tr>
						  <?php 
							$sl++;
								}
								
							}
						  ?>
						</tbody>  
					</table>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Final Stitch Total Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. <?php echo $gFTotalCost;?></b></p>
					</div>
                </div>
                 <!-- Final Stitch rate End-->
				 
				 <div class="first-column"></div>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Cutting Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. 15</b></p>
					</div>
					<br>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Iron Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. 10</b></p>
					</div>
					<br>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Packing Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. 10</b></p>
					</div>
					<br>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Photo Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. 25</b></p>
					</div>
					<br>
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Design Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. 50</b></p>
					</div>
                  
				 
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Total Cost</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;">
						<?php $total = 110 + $gTotalCost + $gHTotalCost + $gMTotalCost + $gCTotalCost + $gFTotalCost; ?>
						<b><?php echo $total;?></b></p>
					</div>
				 
				
                <!-- eof Display Data -->
            </div> <!-- eof Print -->
			<a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>
        <?php 
        }
        ?>
    </div>
	
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
	