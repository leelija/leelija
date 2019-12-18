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

require_once("classes/status_cat.class.php");
require_once("classes/customer.class.php");
require_once("classes/product_status.class.php");
require_once("classes/pipe_status.class.php");


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

$customer			= new Customer();
$prodStatus			= new Pstatus();
$pipestatus			= new Pipestatus();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$dhmckfip			= $utility->returnGetVar('dhmckfip','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//echo $dhmckfip;exit;
$statusCatDetail=$statuscat->showPackingPending($dhmckfip);

$PackingDtl		=$statuscat->showProductPakingbyord($statusCatDetail[2]);

// echo $DyeingDtl[1];exit;

$packingpendrecord 	=	$statuscat->showPckpndbyCondition($statusCatDetail[2],$statusCatDetail[5],$statusCatDetail[13]);

if(isset($_POST['btnDeleteOrd']))
{	
	
	$txtAmount 	        = $_POST['txtAmount'];
	
	$pendingqnt	= $packingpendrecord[7] - $txtAmount;// $pendingqnt = pending quantity
	$compqnt	= $packingpendrecord[16] + $txtAmount; // $compqnt	= complete quantity
	
	$total_particular = $txtAmount + $PackingDtl[18];
	
	if($statusCatDetail[7] >= $txtAmount){
	
		$statuscat->updatePackingQuan($statusCatDetail[2],$total_particular);
		
		// update pending status
		$pipestatus->Updatependintbl($statusCatDetail[2],$statusCatDetail[5],$statusCatDetail[13],$pendingqnt,$compqnt);
		//delete the stock
		//$statuscat->delPendingPacking($dhmckfip);
	
		//forward
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Pending Packing has been successfully Update", 'SUCCESS');
		}
		else{
			echo "Put the Valid Quantity";
		}
}
?>

<title><?php echo COMPANY_S; ?>- Pending Packing Update </title>
<!-- Style -->
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
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







<table class="tblBrd" align="center" width="100%">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
    
	<?php 
    //delete form
    if( (isset($_GET['action'])) && ($_GET['action'] == 'update_packing') )
    {
	
		$statusCatDetail = $statuscat->showPackingPending($dhmckfip);
		//echo $statusCatDetail[2];exit;
    ?>
    <tr class=''>
	  <td height="25" align='left' bgcolor="#EEEEEE"><h3>Update Packing Pending Order id:: <?php echo $statusCatDetail[2]; ?></h3></td>
    </tr>
    <tr>
      <td>
      <form action="<?php $_SERVER['PHP_SELF']?>?dhmckfip=<?php echo $dhmckfip; ?>" method="post">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
						
			<label>Packing(in pieces)<span class="orangeLetter">*</span></label>
            <input name="txtAmount" type="text" class="text_box_large" id="txtAmount" 
			value="<?php echo $statusCatDetail[7];?>" size="25" />
            <div class="cl"></div>
										
            <div class="cl"></div>
			
			
			
			
			
				<td height="25" colspan="2" class="menuText padL10">
            
				<input style="background:#fc7c03; color: #fff;" name="btnDeleteOrd" type="submit" class="buttonYellow" id="btnDeleteOrd" value="Update" />
				<input style="background:#ddd; color: #fff;" name="btnCancel" type="button" class="buttonYellow" id="btnCancel" onClick="self.close()" value="cancel" /></td>
            
          <tr>
            <td width="105">&nbsp;</td>
            <td width="72%">&nbsp;</td>
          </tr>
        </table>

      </form>
      </td>
    </tr>
    
    <?php 
    }//if
    ?>
</table>