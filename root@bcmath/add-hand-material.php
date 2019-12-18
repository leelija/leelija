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

$statuscat		= new StatusCat();

$customer		= new Customer();
$prodStatus		= new Pstatus();
$bill 			= new Bill();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$bid			= $utility->returnGetVar('bid','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//echo $customerDtl[2];exit;
//$DyeingDtl		= $statuscat->showProductStatCat($dhmckfip);
// echo $DyeingDtl[1];exit;

// product status details



if(isset($_POST['btnEditOrd']))
{	{
	
	$selNum					= $_POST['selNum'];
	
	$sess_arr	= array('txtAmount','txtProdDesc','leftAmount');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'add-material';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	
	$msg = '';

	
	for($i=0; $i < $selNum; $i++)
		{
			$material		= $_POST['txtMatName'][$i];
			$matUnit		= $_POST['txtMatUnit'][$i];	
			$matAmount		= $_POST['txtQuantity'][$i];
			$matRate		= $_POST['txtRate'][$i];
			$tAmount 		= $matRate * $matAmount;
			
			if($material == '')
				{
					echo "Material name field empty";
				}
				elseif($matAmount == '')
				{
					echo "Material Amount field empty";
				}
				elseif($matRate == '')
				{
					echo "Material Rate field empty";
				}
				else{
				
					$bill->addBillMat($bid,$material,$matUnit,$matAmount,$matRate,$tAmount, $customerDtl[2],'hand_bill_material');
				}
		
		
		}

		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		//header("Location: dyeing.php");
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], 'Material has been added Successfully', 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - Add Hand Material</title>

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
<script type="text/javascript" src="js/bill_mat.js"></script>
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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'add-material') )
        {
             
        ?>
		
	<h2><a name="editStock">Add New Record</a></h2>
		<h2><a name="addUser">Bill Id:H<?php echo $bid; ?> </a></h2>
        <form action="<?php $_SERVER['PHP_SELF']?>?action=add-material&bid=<?php echo $bid; ?>" method="post" enctype="multipart/form-data">
         
			<tr>
				<label>Select No. of Materials</label>
				<!--<td align="left" class="menuText">Select No. Type </td>-->
				<td align="left" class="bodyText pad5">
					<?php 
					//gen number array
						$arr_value	= range(1,18);
						$arr_label	= range(1,18);
					?>
					<select name="selNum" id="selNum" onchange="return getBillMAt();"class="textBoxA">
						<option value="0">--Select--</option>
						<?php 
							if(isset($_SESSION['selNum']))
								{
									$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
								}
								else if(isset($_GET['selNum']))
									{
										$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
									}
								else
									{
										$utility->genDropDown(0, $arr_value, $arr_label);
									}
						?>
					</select>				    
				</td>
			</tr>
			<div class="cl"></div>
			<div id="showBillMat"></div>
			                                                     
			<input name="btnEditOrd" type="submit" class="button-add"  value="ADD" />
			<input name="btnCancel" type="submit" class="button-cancel" value="CANCEL" onClick="self.close()" />
					
        </form>
    
        <?php 
        }
        ?>
    </div>
