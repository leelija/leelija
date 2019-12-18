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
require_once("classes/bill.class.php");

require_once("classes/status_cat.class.php");
require_once("classes/customer.class.php");
require_once("classes/product_status.class.php");
require_once("classes/product_stock.class.php"); 


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
$bill			= new Bill();
$productStock	= new ProductStock();

$statuscat		= new StatusCat();

$customer		= new Customer();
$prodStatus		= new Pstatus();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$id				= $utility->returnGetVar('id','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//Stitching Details
$FinalStichDtl 	= $statuscat->showProductFinalStich($id);



// echo $DyeingDtl[1];exit;
if(isset($_POST['btnEditOrd']))
{	
	$txtColor 	= $_POST['txtColor'];
	//registering the post session variables
	$sess_arr	= array('txtColor');
	$utility->addPostSessArr($sess_arr);
	
	//defining error variables
	$action		= 'bill_details';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $id;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	$msg = '';

if($txtColor == '')
	{
		echo "Colour Field empty";
	}
	
	else
	{
		// Stitching color change stitch id wise.
	   $statuscat->editFStitchColor($id,$txtColor);
	  
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		//forward the web page
		//header("Location: dyeing.php");
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], 'Colour has been changed', 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - EDIT Final stitching colour</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'bill_details') )
        {
            $FinalStichDtl 	= $statuscat->showProductFinalStich($id);
			$custDtls		= $customer->getCustomerData($FinalStichDtl[5]);
			$orderColorDtl	= $orders->ordersDtlDisplay($FinalStichDtl[2]);
			
        ?>
		
        <form action="<?php $_SERVER['PHP_SELF']?>?action=bill_details&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
			<h2><a name="addUser">Stitching Colour Changed</a></h2>
			<h2>->Order Id <?php echo $FinalStichDtl[2];?>&nbsp;->Design No.<?php echo $FinalStichDtl[3];?></h2>
			
			<div >
				<label>Colour<span class="orangeLetter">*</span></label>							
					<select name="txtColor" type="text" id="txtColor" class="text_box_large">
						<option value="<?php echo $FinalStichDtl[18];?>"><?php echo $FinalStichDtl[18];?></option>
						<?php
							$pColourDetails         = $productStock->ColourDisplay($FinalStichDtl[3]);
							foreach ($pColourDetails as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[pcolour]>$row[pcolour]</option>"; 

							/* Option values are added by looping through the array */ 
						}

					echo "</select>";//?> 
			</div>
			<div class="cl"></div> 
			                                        
			<input name="btnEditOrd" type="submit" class="button-add"  value="Changed" />
			<input name="btnCancel" type="submit" class="button-cancel" value="NO" onClick="self.close()" />
			
        </form>
    
        <?php 
        }
        ?>
    </div>
