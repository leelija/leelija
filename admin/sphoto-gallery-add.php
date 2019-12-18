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
//require_once("../classes/tax.class.php");
require_once("../classes/sample.class.php"); 
require_once("../classes/photo_gallery.class.php");


require_once("../classes/customer.class.php");
require_once("../classes/product_status.class.php");

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
//$tax			= new Tax();
$customer			= new Customer();
$status			= new Pstatus();
$sample			= new Sample();
$photogallery	= new PhotoGAllery();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$sgid			= $utility->returnGetVar('sgid','0');
//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$sGalleryDetail = $photogallery->showSamplePGallery($sgid);

if(isset($_POST['btnAddSphoto']))
{	
	//hold the post vars
	$selNum			= $_POST['selNum'];
	
	//add the additional images
	for($i=0; $i < $selNum; $i++)
	{
		
		//uploading images
		if(($_FILES['fileSubImg']['name'][$i] != ''))
		{
			
			//add sample products details
			$sPhotoGalleryId 	= $photogallery->addSphotoGallery($sgid,'');

			//rename the file
			$newSubName = $utility->getNewName4Arr($i, $_FILES['fileSubImg'], '',
												   $sPhotoGalleryId);
			
			//upload in the server
			$uImg->imgCropResizeArr($i, $_FILES['fileSubImg'], '', $newSubName, 
								   '../images/spgallery/large/', 2165, 3508, 
								   $sPhotoGalleryId,'images', 'sgallery_dtl_id', 'sgallery_details');
								   
			/*$uImg->imgCropResizeArr($i, $_FILES['fileThumbImg'], '', $newSubName, 
								   '../images/category/products/', 80, 80, 
								   $prodImgId,'thumb_image', 'product_image_id', 'product_image');
				*/				   
			
		}//upload
			
		
	}//for

	//deleting the sessions
	//$product->delSubInSess($selNum);			
	
	//forward
	$uMesg->showSuccessT('success', $sgid, 'sgid', $_SERVER['PHP_SELF'], "Images successfully added", 'SUCCESS');
	

}

?>

<title><?php echo COMPANY_S; ?> - Add Sample photo Gallery</title>

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
<script type="text/javascript" src="../js/sample_employee.js"></script>
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
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'Add_Image') )
        {
             
            $sGalleryDetail 		= $photogallery->showSamplePGallery($sgid);
			$factoryDtls 			= $sample->showFactory($sGalleryDetail[1]);
        ?>
		
		<h3><a name="editProd">Add  Sample photos</a></h3>
    
			<form action="<?php $_SERVER['PHP_SELF']?>?action=Add_Image&sgid=<?php echo $sgid; ?>" method="post" enctype="multipart/form-data">
        
				<h2><a name="addUser">Add More images</a></h2>
                    <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <div class="cl"></div>
						
						<div class="cl"></div>
						<h2>Design No:<?php echo $sGalleryDetail[2]; ?></h2>
						<div class="cl"></div>
						<tr>
							<label>Select No. of Images</label>
								<!--<td align="left" class="menuText">Select No. Type </td>-->
								<td align="left" class="bodyText pad5">
								<?php 
									//gen number array
									$arr_value	= range(1,8);
									$arr_label	= range(1,8);
								?>
									<select name="selNum" id="selNum" onchange="return getAllSphotoGallery();"
									   class="textBoxA">
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
						<div id="showPhotoGallery"></div>
										
                                                                    
                <input name="btnAddSphoto" type="submit" class="button-add"  value="Add" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
