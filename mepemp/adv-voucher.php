<?php 
ob_start();
session_start();
include_once('checkSession.php');
include_once('../_config/connect.php');

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/employee.class.php"); 

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");

require_once("../classes/status_cat.class.php");
require_once("../classes/customer.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/rate.class.php"); 
require_once("../classes/labour.class.php"); 
//require_once("../classes/sample.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");
require_once("rupee-convert.php");


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$employee		= new Employee();
$search_obj		= new Search();
$page			= new Pagination();
$stock			= new Stock();

$customer		= new Customer();

$status			= new Pstatus();
$statusCat		= new StatusCat();

//$sample			= new Sample();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$adv_id			= $utility->returnGetVar('adv_id','0');

$userId				= $utility->returnSess('userid', 0);

//admin detail
$userData =  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

?>

<title><?php echo COMPANY_S; ?>Voucher Details</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../style/bootstrap/js/bootstrap.min.js"></script>
<link href="../style/custom-style.css" rel="stylesheet" type="text/css">


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
    /*    if( (isset($_GET['action'])) && ($_GET['action'] == 'view_colour') )
        {
             
            $sampleDetails = $sample->showSample($sid);*/
        ?>
		
	<h3><a name="editStock" >Payment Slip</a></h3>
		<hr>
		<!-- Display Data -->
                <div id="data-column">

					
					<?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
					
                	<?php 
						$empAdvDtls		= $employee->getEmpAdvance($adv_id);
						$PayBookDtls 	= $employee->showEmpBookData($empAdvDtls[1]);
						$empDtls        = $employee->showEmployee($PayBookDtls[1]); 
						$empTypeDtls	= $employee->getEmpTypeData($empDtls[1]);
						$empAddressDtl	= $employee->showEmpAddress($empDtls[0]);
						$pre_date 		= date('d-m-Y', strtotime($empAdvDtls[4]));
					?>
					
					<div class="voucher" id="PrintForm" style="border-style: solid;"><!--Voucher Start-->
						<form class="voucher-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
							<div style="width: 100%; height:50px; " >
								<div style="width: 65%;float:left; background: #fff;">
									<p class="title" style="text-transform: uppercase;font-size: 30px;">MONI Enterprises Voucher</p>
								</div>
								<div style="width: 30%; float:right; background: #fff;" style="text-align: center;">
								<!--	Tran No:&nbsp;<span class="vtext">HMD-ADV<?php //echo $empAdvDtls[0]; ?></span>-->
								</div>
							</div>
							<div style="width: 100%; height:120px;">
								<div style="float:left; width:60%;">
									Debit/Credit Name:&nbsp;<span class="vtext"><?php echo $empDtls[2]; ?></span><br>
									Mobile:&nbsp;<span class="vtext"><?php echo $empDtls[3]; ?></span><br>
									Adhar No.:&nbsp;<span class="vtext"><?php echo $empDtls[28]; ?></span>
								</div>
								<div style="float:right; width:35%;">	
									<div class="rightsubtitle">
										<?php 
											echo $utility->imgDisplayR('../employee/images/photos/', $empDtls[12], 100, 100, 0, 'greyBorder', $empDtls[3], '');
										?>
									</div>
								</div>	
							</div>	
							<br>
							<div style="width: 100%; height:40px;">
								<div style="float:left; width:25%;">
									Details Of Payment:
								</div>
								<div style="float:right; width:70%;">
									<?php echo $empAdvDtls[3]; ?>
								</div>
							</div>
							<div style="width: 100%; height:40px;">
								<div style="float:left; width:45%;">
									Payment Type:<span class="vtext">Cash</span>
								</div>
								<div style="float:right; width:45%;">
									Total Rs.:&nbsp;<span class="vtext"><?php echo $empAdvDtls[2];?></span>
								</div>
							</div>
							
							<div style="width: 100%; height:40px;">
								Rupee:&nbsp;<span class="vtext"><?php echo convert_number_to_words($empAdvDtls[2]); ?></span>
							</div>
							<div style="width: 100%; height:40px;">
								<div style="float:left; width:45%;">
									Prepared by:<span class="vtext">...................</span>
								</div>
								<div style="float:right; width:45%;">
									Prepared Date:&nbsp;<span class="vtext">.../.../20..</span>
								</div>
							</div>
							
							<div style="width: 100%; height:40px;">
								<div style="float:left; width:45%;">
									Checked by:<span class="vtext">.........................</span>
								</div>
								<div style="float:right; width:45%;">
									Checked Date:&nbsp;<span class="vtext">...../..../20....</span>
								</div>
							</div>
							<div style="width: 100%; height:40px;">
								<div style="float:left; width:45%;">
									Payment by:<span class="vtext"><?php echo $empAdvDtls[5];?></span>
								</div>
								<div style="float:right; width:45%;">
									Payment Date:&nbsp;<span class="vtext"><?php 
									$cheched_date = date('d-m-Y', strtotime($empAdvDtls[4]));
									echo $cheched_date; ?></span>
								</div>
							</div>
							<div style="width: 100%; height:40px;">
								<div class="vouRowLeft">
									Signature of Payee:<span class="vtext">......................</span>
								</div>
							</div>
							
							<?php //echo convert_number_to_words(123456789);?>
						</form>
					</div><!--Voucher end-->
					
                </div>
                <!-- eof Display Data -->
		
				<a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>	
		
		
		
	<div style="float: right;">		
	  <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
	</div>	
	
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
	
