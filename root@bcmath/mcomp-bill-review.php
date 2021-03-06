<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("_config/connect.php"); 

require_once("includes/constant.inc.php");
require_once("includes/product.inc.php");

require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php"); 
require_once("classes/order.class.php"); 
require_once("classes/search.class.php");
require_once("classes/pagination.class.php");
require_once("classes/product_stock.class.php"); 
require_once("classes/status_cat.class.php");
require_once("classes/sample.class.php");

require_once("classes/customer.class.php"); 
require_once("classes/ratechart.class.php");
require_once("classes/bill.class.php");


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
$productStock	= new ProductStock();

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
$bid			= $utility->returnGetVar('bid','0');
$userId			= $utility->returnSess('userid', 0);
date_default_timezone_set('Asia/Calcutta'); 
//echo date("Y-m-d H:i:s"); // time in India
	$attDate 		= date("Y-m-d");// Attendance Date
	$attDateTime 	= date("d-m-Y H:i:s");// Attendance Date time

//Customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);

$stockDtlShow  	= $productStock->getAllProdStockData();
//echo $_SESSION[USR_SESS];
//echo $userData[20];exit;
?>

<title><?php echo COMPANY_S; ?> -  Computer Bill Review</title>

<!-- Style -->
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">

<link href="style/custom-style.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
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
<script type="text/javascript" src="js/product.js"></script>
<!-- eof JS Libraries -->

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'bill-review') )
        {
            $billNo					= "C".$bid."";
			//echo $billNo;exit;
			//$dyekDetails  			= $statCat->disPlTableDtls($billNo,'dyeing_table');
			$CompDetails  			= $statCat->disCompStatBillWise($billNo);
			$billDtl 				= $bill->allRFRIBillTable($bid,'mep_comp_bbook');
			//factory details
			$facDtls 				= $sample->showFactory($billDtl[10]);
			
			$bDate					= date_create($billDtl[1]);
			
			$bUserDtls 				= $customer->getCustomerData($billDtl[5]);
        ?>

			<div id="PrintForm" style="padding-left:80px;"><!-- start Print -->
				<h2 style="text-align: center;"><a name="addUser">Job Work Chalan</a></h2>
				<div style="width: 100%;">
					<p style="width: 50%; float: left;">No.: <b>MEP-C<?php echo $bid;?></b></p> 
					<p style="width: 48%;float:right; text-align: right;">Date: <?php echo date_format($bDate,"d/m/Y"); ?></p>
				</div>
				<h1 style="text-align:center;text-decoration: underline;color:#000;"><?php echo $facDtls[1];?> </h1>
				<p style="text-align:center; font-size: 16px;color:#000;">
					<?php echo $facDtls[6];?><br>
					<?php echo $facDtls[7];?>-<?php echo $facDtls[9];?><br>
					Ph.: <?php echo $facDtls[11];?><br>
					Email: <?php echo $facDtls[10];?>
				</p>
				<p style="border-bottom: 1px dashed #999;">Messrs &nbsp;<?php echo $bUserDtls[2]; ?></p>
               
                <!-- Display Data -->
                <div id="data-column" style="position:relative; bottom: 9px; font-size:12px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						if(count($CompDetails) == 0)
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
						  <th width="5%" height="25"  align="center">QLTY</th>
						  <!-- <th width="3%" height="25"  align="center">Stock Id</th> -->
						  <th width="10%" >Order Id</th>
						  <th width="10%" >DSG No.</th>
						  <th width="10%" >Comp Des No.</th>
						  <th width="10%" >Total Stitch</th>
						  <th width="35%" >Colour</th>
						   <th width="5%" >Quantity(Pcs)</th>
						   <th width="5%" >Head Or Line</th>
						  <th width="5%" >Stitch Rate/Psc</th>
						  <th width="10%" >Total Cost(Rs.)</th>
						</tr>  
                        </thead>
						<tbody>
						   <?php 
							$sl=1;  
							$tQuantity 		= 0;
							$gTotal 		= 0;
							foreach($CompDetails as $eachRecord)
								{
								$bgColor 	 	= $utility->getRowColor($sl);
								$sCompEmbDtls	= $sample->showSamCompEmb($eachRecord['computer_design_no']);
								
								//$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
								$totalQuantity	= $eachRecord['quantity'] + $eachRecord['complete'];
								
								
								
							//	$tHeads			= $totalQuantity * $sCompEmbDtls[18];
								
								$ordDate		= date_create($eachRecord['order_date']);
								$trdDate		= date_create($eachRecord['target_date']);
								$designNo		= $eachRecord['computer_design_no'];
								$Remarks   		= $eachRecord['remarks'];
								$compType   	= $eachRecord['comp_type'];
								
								$tQuantity 		+= $totalQuantity;
								
								$totalCost 		= $totalQuantity * $eachRecord['stich_rate'];
								
								$gTotal 	   	+= $totalCost;
								
								$color 			= explode(",", $eachRecord['colour']);
								$totalHead   	= $totalQuantity * $eachRecord['no_head_or_line'];
								$perPcsHeadLine = ($totalQuantity / $eachRecord['no_of_colour']) * $eachRecord['no_head_or_line'];
						?>
							<tr align="left"<?php $utility->printRowColor($bgColor);?>>
								<td align="left"><?php echo $sl; ?></td>
								<td align="center"><?php echo $eachRecord['order_id']; ?></td>
								<td align="center"><?php echo $eachRecord['design_no']; ?></td>
								<td align="center"><?php echo $eachRecord['computer_design_no']; ?></td>
								<td align="center"><?php echo $eachRecord['total_stich']; ?></td>
								<td align="center">
									<?php			
										foreach($color as $colour)
										{
										 echo $colour;echo "-";echo $perPcsHeadLine;echo "&nbsp;"; echo $eachRecord['unit'];echo "-";echo $eachRecord['additional'];echo "<br>"; 
										}
									?>
								
								
								</td>
								
								<td align="center"><?php echo $totalQuantity; ?></td>
								<td align="center"><?php echo $totalHead; echo $eachRecord['unit'];?></td>
								<td align="center"><?php echo $eachRecord['stich_rate']; ?></td>
								<td align="center"><?php echo $totalCost; ?></td>
								
							</tr>
						  <?php 
							$sl++;
								}
								
							}
						  ?>
						</tbody>  
					</table>
			
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">Total Amount</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Rs. <?php echo $gTotal;?></b></p>
					</div>
					
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p class="ltotal" style="width:50%; float:left;">TDS 1%</p>
						<p class="rtotal" style="width: 45%; float: right;position: relative;left: 205px;"><b>Total TDS Rs. 
						<?php 
							$tds	= $gTotal * (1 / 100);
							
							echo $tds;?></b></p>
					</div>
					<h3>Computer:<?php echo $compType;?></h3>
					<b><?php echo "Remarks:";echo $Remarks;?></b>
                    <div class="first-column">
                  </div>
                  
                </div>
				
				
				<!-- Display Material Data table -->
                <div id="data-column" style="position:relative; bottom: 9px; font-size:12px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
							$billMatDtls  	= $bill->showBillMat($bid,'mcomputer_bill_material');	
							if(count($billMatDtls) == 0)
								{
						?>
								<thead>
									<tr>
									  <th width="5%" height="25"  align="center">QLTY</th>
									  <!-- <th width="3%" height="25"  align="center">Stock Id</th> -->
									  <th width="10%" >Material</th>
									  <th width="10%" >Unit</th>
									  <th width="15%" >quantity</th>
									  <th width="15%" >Rate</th>
									  <th width="10%" >Total Amount</th>
									  
									</tr>  
								</thead>
								<tbody>
									<?php
										for ($x = 0; $x <= 5; $x++) {
									?>
								
									  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
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
								
								</tbody>
                        <?php 
								}
								else
								{
                        ?>  
								<thead>
								<tr>
								  <th width="5%" height="25"  align="center">QLTY</th>
								  <!-- <th width="3%" height="25"  align="center">Stock Id</th> -->
								  <th width="10%" >Material</th>
								  <th width="10%" >Unit</th>
								  <th width="15%" >quantity</th>
								  <th width="15%" >Rate</th>
								  <th width="10%" >Total Amount</th>
								  
								</tr>  
								</thead>
						<tbody>
						   <?php 
							$sl=1;  
							$tAmount 		= 0;
							foreach($billMatDtls as $eachRecord)
								{
								$bgColor 	 	= $utility->getRowColor($sl);
								$totalAmount	= $eachRecord['total_amount'];
								//$quantity		= $eachRecord['quantity'] + $eachRecord['complete'];
								$tAmount 		+= $totalAmount;
						?>
							<tr align="left"<?php $utility->printRowColor($bgColor);?>>
								<td align="left"><?php echo $sl; ?></td>
								<td align="center"><?php echo $eachRecord['material_name']; ?></td>
								<td align="center"><?php echo $eachRecord['mat_unit']; ?></td>
								<td align="center"><?php echo $eachRecord['mamount']; ?></td>
								<td align="center"><?php echo $eachRecord['mrate']; ?></td>
								<td align="center">Rs.<?php echo $totalAmount; ?></td>
								
							</tr>
							<?php 
							$sl++;
								}
							?>	
								
							<?php
								for ($x = 0; $x <= 3; $x++) {
							?>
						
							  <tr style="border-bottom: solid 1px #ddd; height: 30px;">
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
								
								
							<?php	
								
							}
						  ?>
						</tbody>  
					</table>
					
					<div class="tBillTitle" style="background:#ddd; height: 30px;">
						<p><b>Rs.<?php echo $tAmount;?></b></p>
					</div>
					
                    <div class="first-column">
					</div>
                </div> <!-- Material table End-->
				
				
				
				
				<p>Order Date: <?php echo date_format($ordDate,"d/m/Y"); ?></p>
				<p>Target Date: <?php echo date_format($trdDate,"d/m/Y"); ?></p>
				
				<div style="width: 100%;">
					<div style="width: 50%; float: left;"> <p style="width: 48%; float: left;">Receiver Signature </p>
					<p style="width: 50%; float: right;">Signature</p> </div>
					<p style="width: 48%;float:right; text-align: right;">Bill By <b><?php echo $billDtl[2];?></b></p>
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
	