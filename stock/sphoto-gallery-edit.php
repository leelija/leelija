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
require_once("../classes/unit.class.php"); 


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
$unit			= new Unit();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$sgid			= $utility->returnGetVar('sgid','0');
//Customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);


$sGalleryDetail = $photogallery->showSamplePGallery($sgid);

if(isset($_POST['btnEditSphoto']))
{	
	$txtFactoryId				= $_POST['txtFactoryId'];
	$txtDesignNo				= $_POST['txtDesignNo'];
	$txtTitle					= $_POST['txtTitle'];
	$txtColor					= $_POST['txtColor'];
	
	$txtPrices					= $_POST['txtPrices'];
	$txtStatus					= $_POST['txtStatus'];
			
	
	//registering the post session variables
	$sess_arr	= array('txtFactoryId', 'txtDesignNo','txtTitle','txtColor','txtPrices','txtStatus');
	$utility->addPostSessArr($sess_arr);
	

	
	//defining error variables
	$action		= 'Edit_Gallery';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $sgid;
	$id_var		= 'sgid';
	$anchor		= 'editOrd';
	$typeM		= 'ERROR';
	
	
	$msg = '';



	//add the additional images
	if($txtFactoryId	==''){
		echo "The Factory Name is empty.";
	}	
	elseif($txtDesignNo	==''){
		echo "The Design No. empty.";
	}
	else{
			//Update Sample gallery photo
			$photogallery->UpdateSampleGaqllery($sgid,$txtFactoryId,$txtDesignNo,$txtTitle,$txtColor,$txtPrices,
			$txtStatus,$userData[2]);
			
			//upload image
			if($_FILES['fileImage']['name'] != '')
			{
				//delete the image
				$utility->deleteFile($sgid,'sample_gallery_id','../images/spgallery/large/',
									 'image', 'sample_gallery');
				//delete the thumb image
				$utility->deleteFile($sgid,'sample_gallery_id','../images/spgallery/thumb/',
									 'thumb_image', 'sample_gallery');					 
				
				//rename the file
				$newName = $utility->getNewName4($_FILES['fileImage'], '',$sgid);
				
				//upload in the server
				$imgid = $uImg->imgCropResize($_FILES['fileImage'], '', $newName, 
									   '../images/spgallery/large/', 
									   2165, 3508, $sgid,'image', 'sample_gallery_id', 'sample_gallery');					   
				//echo $imgid;exit;					   
									   
				//resizing the image
				$uImg->imgCropResize($_FILES['fileImage'], '', $newName, 
									   '../images/spgallery/thumb/', 
									   120, 180, $sgid,'thumb_image', 'sample_gallery_id', 'sample_gallery');
			}
			
			//forward
			$uMesg->showSuccessT('success', $sgid, 'sgid', $_SERVER['PHP_SELF'], "Edit has been successfully Complete ", 'SUCCESS');
		}


}

?>

<title><?php echo COMPANY_S; ?> - Edit Sample photo Gallery</title>

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
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'Edit_Gallery') )
        {
             
            $sGalleryDetail 		= $photogallery->showSamplePGallery($sgid);
			$factoryDtls 			= $sample->showFactory($sGalleryDetail[1]);
        ?>
		
		<h3><a name="editProd">Edit Sample photos</a></h3>
    
			<form action="<?php $_SERVER['PHP_SELF']?>?action=Edit_Gallery&sgid=<?php echo $sgid; ?>" method="post" enctype="multipart/form-data">
        
				<h2><a name="addUser">Edit <?php echo $sGalleryDetail[2];?></a></h2>
                    <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <div class="cl"></div>
						<div >
							<label>Factory Name<span class="orangeLetter">*</span></label>							
							<select name="txtFactoryId" type="text" id="txtFactoryId" class="text_box_large">
							<option value="<?php echo $factoryDtls[0]; ?>"><?php echo $factoryDtls[1]; ?></option>
							<?php
								$factDetails         = $sample->getAllFactory();
								foreach ($factDetails as $eachrecord){//Array or records stored in $row
								//echo $row[colour_name];
								echo "<option value=$eachrecord[factory_id]>$eachrecord[factory_name]</option>"; 

								/* Option values are added by looping through the array */ 
										
							}

							echo "</select>";//?>
						</div>
						<div class="cl"></div>
						<label>Design No</label>
						<input name="txtDesignNo" id="txtDesignNo" type="text" value="<?php echo $sGalleryDetail[2]; ?>" class="text-field" />
						<div class="cl"></div>
						<div >
							<label>Categories Name<span class="orangeLetter">*</span></label>							
								<select name="txtTitle" type="text" id="txtTitle" class="text_box_large">
									<option value="<?php echo $sGalleryDetail[3] ;?>"><?php echo $sGalleryDetail[3]; ?></option>
									<?php
										$catDetails         = $unit->MstDesCatDisplay();
										foreach ($catDetails as $eachrecord){//Array or records stored in $row
										//echo $row[categories_name];
									?>
									<option value="<?php echo $eachrecord['categories_name'];?>"><?php echo $eachrecord['categories_name'];?></option>; 
								<?php
										/* Option values are added by looping through the array */ 
												
									}

								echo "</select>";//?>
						</div>
						<div class="cl"></div>
						
						<label>Prices</label>
						<input name="txtPrices" id="txtPrices" type="text" value="<?php echo $sGalleryDetail[4]; ?>" class="text-field" />
						<div class="cl"></div>
						<div >
							<label>Colour<span class="orangeLetter">*</span></label>							
								<select name="txtColor" type="text" id="txtColor" class="text_box_large">
									<option value="<?php echo $sGalleryDetail[13]; ?>"><?php echo $sGalleryDetail[13]; ?></option>
									<?php
										$colourDetails         = $unit->MstColourDisplay();
										foreach ($colourDetails as $eachrecord){//Array or records stored in $row
										//echo $row[colour_name];
										echo "<option value=$eachrecord[colour_name]>$eachrecord[colour_name]</option>"; 

										/* Option values are added by looping through the array */ 
												
									}

								echo "</select>";//?>
						</div>
						<div class="cl"></div>
						<div >
							<label>Status<span class="orangeLetter">*</span></label>							
								<select name="txtStatus" type="text" id="txtStatus" class="text_box_large">
									<option value="<?php echo $sGalleryDetail[5]; ?>"><?php echo $sGalleryDetail[5]; ?></option>
									<option value="Complete">Complete</option> 
									<option value="Up Coming">Up Coming</option> 
								</select>
						</div>
						<div class="cl"></div>  
						<label>Image</label>
						<input name="fileImage" type="file" class="text_box_large" />
						<div class="cl"></div>
                <input name="btnEditSphoto" type="submit" class="button-add"  value="edit" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
