<?php 
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
require_once("../classes/stock.class.php");
require_once("../classes/purchase_company.class.php");
require_once("../classes/employee.class.php"); 

require_once("../classes/mjournal.class.php"); 

require_once("../classes/fabric.class.php");
require_once("../classes/customer.class.php");


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
$mjournal		= new mJournal();
$employee		= new Employee();

$fabric			= new Fabric();
$customer		= new Customer();
$pCompany		= new PurchaseCompany();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$userId			= $utility->returnSess('userid', 0);
//$customerDtl	= $customer->getCustomerData($userId);
//customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);

if(isset($_POST['btnAddAcc']))
{	
	$txtAssType 	    = $_POST['txtAssType'];
	$txtBalance 		= $_POST['txtBalance'];
	$txtPurpose 	    = $_POST['txtPurpose'];
	$txtAssSource 		= $_POST['txtAssSource'];
	$txtProdDesc 		= $_POST['txtProdDesc'];
	$txtAddedDate 		= $_POST['txtAddedDate'];
	
	$sess_arr	= array('txtAssType','txtBalance','txtPurpose','txtAssSource','txtProdDesc');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'journalAcc';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	
	$msg = '';


if($txtBalance == '')
	{
		echo "Balance field empty";
	}
	elseif($txtPurpose == '')
	{
		echo "Put the Purpose";
	}
	elseif($txtAssSource == '')
	{
		echo "Assets Source field Empty";
	}
	else
	{
		$assetsDtls 		= $mjournal->showMAssetsAcc($txtAssType);
		$asstBalance 		= $assetsDtls[3] + $txtBalance;
		//add the journal book Value
		$mjournal->addMAssetsHist($txtAssType,$txtBalance,$txtPurpose,$txtAssSource,$txtProdDesc,$userData[2],$txtAddedDate);	
		// Update Assets Account
		$mjournal->UpdateMAssets($txtAssType,$assetsDtls[1],$assetsDtls[2],$asstBalance,$userData[2]);
		
		// ==== Send SMS =======
		$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
		$apisender = "MoniEn";
		$msgs =" Cash ".$txtBalance." Deposit from ".$txtAssSource." to MoniPVT Cash Now Total Balance   ".$asstBalance."  ";
		$number = 9836664554;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
		//echo $num;exit;
		$mss = rawurlencode($msgs);   //This for encode your message content                 		
		$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$number.'&text='.$mss.'&route=1';
												 
		//echo $url;
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,"");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
		$data = curl_exec($ch);		
		
		// ==== Send SMS =======
		$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
		$apisender = "MoniEn";
		$msgs =" Cash ".$txtBalance." Deposit from ".$txtAssSource." to MoniPVT Cash Now Total Balance   ".$asstBalance."  ";
		$number = 9830445482;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
		//echo $num;exit;
		$mss = rawurlencode($msgs);   //This for encode your message content                 		
		$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$number.'&text='.$mss.'&route=1';
												 
		//echo $url;
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,"");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
		$data = curl_exec($ch);		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'],'Assets Add has been successfully added', 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - Assets Add</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'journalAcc') )
        {
             
        ?>
		
<h3><a name="editStock"></a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=journalAcc" method="post" enctype="multipart/form-data">
         
			<h2>Assets Add</h2>
                <span>Please  <span class="required"></span>fill the following field.</span>
                <div class="cl"></div>
							
				<div >
					<label>Assets Type<span class="orangeLetter">*</span></label>							
					<select name="txtAssType" type="text" id="txtAssType" class="text_box_large">
						<?php
							$assetsDtls         = $mjournal->getMAllAssetsAcc();
							foreach ($assetsDtls as $row){//Array or records stored in $row
							//echo $row[colour_name];
						?>	
							<option value="<?php echo $row['assets_id'];?>"><?php echo $row['assets_type'];?>(<?php echo $row['assets_name'];?>)</option> 
							<?php
							/* Option values are added by looping through the array */ 
													
							}

					echo "</select>";//?>
				</div> 
				<div class="cl"></div>
				<label>Balance(Rs.)<span class="orangeLetter">*</span></label>
                <input name="txtBalance" type="text" class="text_box_large" id="txtBalance" size="25" />
				<div class="cl"></div>
				
				<label>Purpose<span class="orangeLetter">*</span></label>
                <input name="txtPurpose" type="text" class="text_box_large" id="txtPurpose" size="25" />
                <div class="cl"></div>
							
				<label>Assets Source<span class="orangeLetter">*</span></label>
                <input name="txtAssSource" type="text" class="text_box_large" id="txtAssSource" size="25" />
                <div class="cl"></div>
				<label>Added Date<span class="orangeLetter">*</span></label>
                <input name="txtAddedDate" type="date" class="text_box_large" id="txtAddedDate" size="25" />
                <div class="cl"></div>
				 <label>Note</label>
                 <textarea  name="txtProdDesc" id="txtProdDesc">
				 <?php $utility->printSess2('txtProdDesc',''); ?>
                 </textarea>
				<div class="cl"></div>
				
				<div class="cl"></div>			                 
                <input name="btnAddAcc" type="submit" class="button-add"  value="Add" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
