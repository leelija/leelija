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
require_once("../classes/employee.class.php"); 
require_once("../classes/stock.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/company.class.php"); 
require_once("../classes/vendor.class.php"); 
require_once("../classes/customer.class.php");
require_once("../classes/sample.class.php");

require_once("../classes/supplier.class.php"); 
require_once("../classes/party.class.php"); 
require_once("../classes/invoice.class.php"); 

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
$company		= new Company();
$vendor			= new Vendor();
$customer		= new Customer();
$sample			= new Sample();

$supplier		= new Supplier();
$party			= new Party();
$invoice		= new Invoice();

$stock			= new Stock();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################
//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$bid			= $utility->returnGetVar('bid','0');

$invoiceDtls 	= $invoice->showInvoice($bid);
 //echo $bid;exit;
//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[ACC_SESS]);


?>

<title><?php echo COMPANY_S; ?> -  Sales Bill Preview</title>

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

<style>
iv.title {
    text-align: center;
    font-size: 24pt;
    font-weight: bold
}
hr {
    border-top: 1px solid #000
}
div.summary {
    font-size: 11pt;
    font-weight: bold;
    margin-top: 20px
}
table.lineItems {
    width: 100%;
    margin-top: 20px
}
table.lineItems th {
    border: 1px solid #000;
    padding: 5px 10px
}
table.lineItems td {
    border-left: 1px solid #000;
    border-right: 1px solid #000;
    padding: 5px 10px
}
table.lineItems td.total-label {
    text-align: right;
    border-left: none;
}
table.lineItems td.total-amount {
    border: 1px solid #000;
    text-align: right
}
table.lineItems td.total-important {
    font-weight: bold;
}
table.lineItems tr.lastLineItem td {
    border-bottom: 1px solid #000
}
</style>
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
            $compDetail 			= $company->showCompAcc($invoiceDtls[16]);
			$invoiceDtldtls 		= $invoice->getInvoiceDtlsData($bid);
			
			//factory details
			$facDtls 				= $sample->showFactoryNamewiseDtls($compDetail[1]);
			
			//$CompDetails  			= $statCat->disCompStatBillWise($bid);
			//$billDtl 				= $bill->allRFRIBillTable($bid,'rfri_comp_bbook');
			//factory details
			//$facDtls 				= $sample->showFactory($billDtl[10]);
			//$bDate					= date_create($billDtl[1]);
			
			//$bUserDtls 				= $customer->getCustomerData($billDtl[5]);
        ?>

			<div id="PrintForm" style="padding-left:80px; "><!-- start Print -->
				<div style="padding: 30px;">
					<!-- HEADER -->
					<div class="title">TAX INVOICE</div>
					<hr />
					<!-- CUSTOMER & BUSINESS DETAILS -->
					<div style="margin-top: 20px">
						<div class="pull-right" style="padding-left: 20px">
							<div data-bind="text: Seller" style="font-weight: bold"></div>
							<div data-bind="foreach: SellerContactDetails">
								<div data-bind="text: $data"></div>
							</div>
						</div>
						<div class="pull-right" style="padding-right: 20px; border-right: 1px solid #000">
							<div style="font-weight: bold; text-align: right">Issue Date</div>
							<div data-bind="text: IssueDate" style="text-align: right; margin-bottom: 10px"></div>
							<div style="font-weight: bold; text-align: right">Due Date</div>
							<div data-bind="text: DueDate" style="text-align: right; margin-bottom: 10px"></div>
							<div style="font-weight: bold; text-align: right">Invoice No.</div>
							<div data-bind="text: Number" style="text-align: right"></div>
						</div>
						<table>
							<tr>
								<td style="text-align: right; font-weight: bold; padding-right: 20px">To</td>
								<td data-bind="text: Customer">
								
								<b><?php echo $facDtls[1];?></b><br>
						<?php echo $facDtls[6];?><br>
						<?php echo $facDtls[7];?>-<?php echo $facDtls[9];?><br>
						Ph.: <?php echo $facDtls[11];?><br>
						Email: <?php echo $facDtls[10];?>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<div data-bind="foreach: CustomerAddressLines">Billing To
										<div data-bind="text: $data">
										bnsbjn
										</div>
									</div>
								</td>
							</tr>
						</table>
						<div style="clear: both"></div>
					</div>
					<!-- LINE ITEMS -->
					<div class="summary" data-bind="text: Summary"></div>
					<table class="lineItems">
						<thead>
							<tr>
								<th>Services</th>
								<th style="text-align: right; width: 100px">Hourly rate</th>
								<th style="text-align: center; width: 60px">Hours</th>
								<th style="text-align: center; width: 100px">Discount</th>
								<th style="text-align: center; width: 100px">Tax</th>
								<th style="text-align: center; width: 100px">Total</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: LineItems">
							<tr>
								<td data-bind="text: Description"></td>
								<td data-bind="text: UnitPrice" style="text-align: right"></td>
								<td data-bind="text: Qty" style="text-align: center"></td>
								<td data-bind="text: Discount" style="text-align: center"></td>
								<td data-bind="text: Tax" style="text-align: center"></td>
								<td data-bind="text: LineTotal" style="text-align: right"></td>
							</tr>
						</tbody>
						<tbody>
							<tr class="lastLineItem">
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr data-bind="visible: Total != Subtotal">
								<td colspan="5" class="total-label">Subtotal</td>
								<td class="total-amount" data-bind="text: Subtotal"></td>
							</tr>
						</tbody>
						<tbody data-bind="visible: TaxComponents.length > 0, foreach: TaxComponents">
							<tr>
								<td colspan="5" class="total-label"><span data-bind="visible: $parent.LineItemsIncludeTax">Includes </span><span data-bind="text: Name"></span></td>
								<td class="total-amount" data-bind="text: Amount"></td>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<td colspan="5" class="total-label total-important">Total</td>
								<td class="total-amount total-important" data-bind="text: Total"></td>
							</tr>
						</tbody>
					</table>
					<!-- NOTES -->
					<div data-bind="foreach: Notes">
						<div data-bind="text: $data"></div>
					</div>
				</div>
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
	
	