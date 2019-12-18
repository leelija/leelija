<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php");

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/category.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/news.class.php");
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$category		= new Cat();
$search_obj		= new Search();
$page			= new Pagination();
$news 			= new News();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();
///////////////////////////////////////////////////////////////////////////////////////// 

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$keyword		= $utility->returnGetVar('keyword','');
$type			= $utility->returnGetVar('type','');
$mode			= $utility->returnGetVar('mode','');

//cerate news
if(isset($_POST['btnAddNews']))
{
	//get all teh variable
	$txtRefId 		= $_POST['txtRefId'];
	$parent_id		= $_POST['txtParentId'];
	$cat_name 		= $_POST['txtCatName'];
	
	//title + summary
	$txtTitle 		= $_POST['txtTitle'];
	$txtSumm 		= $_POST['txtSumm'];
	
	//paragraph 1
	$subTitle1 		= $_POST['subTitle1'];
	$txtDesc1 		= $_POST['txtDesc1'];
	$imgTitle1 		= $_POST['imgTitle1'];
	$imgDesc1 		= $_POST['imgDesc1'];
	$imgCredit1 	= $_POST['imgCredit1'];
	
	
	//paragraph 2
	$subTitle2 		= $_POST['subTitle2'];
	$txtDesc2 		= $_POST['txtDesc2'];
	$imgTitle2 		= $_POST['imgTitle2'];
	$imgDesc2 		= $_POST['imgDesc2'];
	$imgCredit2 	= $_POST['imgCredit2'];
	
	//paragraph 3
	$subTitle3 		= $_POST['subTitle3'];
	$txtDesc3 		= $_POST['txtDesc3'];
	$imgTitle3 		= $_POST['imgTitle3'];
	$imgDesc3 		= $_POST['imgDesc3'];
	$imgCredit3 	= $_POST['imgCredit3'];
	
	//hold in session
	$_SESSION['txtRefId'] 		= $_POST['txtRefId'];
	$_SESSION['txtParentId']  	= $_POST['txtParentId'];
	$_SESSION['txtTitle'] 		= $_POST['txtTitle'];
	$_SESSION['txtSumm']  		= $_POST['txtSumm'];
	
	//paragraph 1
	$_SESSION['subTitle1'] 		= $_POST['subTitle1'];
	$_SESSION['txtDesc1']  		= $_POST['txtDesc1'];
	$_SESSION['imgTitle1'] 		= $_POST['imgTitle1'];
	$_SESSION['imgDesc1']  		= $_POST['imgDesc1'];
	$_SESSION['imgCredit1'] 	= $_POST['imgCredit1'];
	
	//paragraph 2
	$_SESSION['subTitle2'] 		= $_POST['subTitle2'];
	$_SESSION['txtDesc2']  		= $_POST['txtDesc2'];
	$_SESSION['imgTitle2'] 		= $_POST['imgTitle2'];
	$_SESSION['imgDesc2']  		= $_POST['imgDesc2'];
	$_SESSION['imgCredit2'] 	= $_POST['imgCredit2'];
	
	//paragraph 3
	$_SESSION['subTitle3'] 		= $_POST['subTitle3'];
	$_SESSION['txtDesc3']  		= $_POST['txtDesc3'];
	$_SESSION['imgTitle3'] 		= $_POST['imgTitle3'];
	$_SESSION['imgDesc3']  		= $_POST['imgDesc3'];
	$_SESSION['imgCredit3'] 	= $_POST['imgCredit3'];
	
	if($cat_name != '')
	{
		$duplicate = $error->duplicateCat($parent_id, $cat_name,0,'news_categories');
	}
	
		
	if(((int)$parent_id == 0) && ($cat_name == ''))
	{
		header("Location:".$_SERVER['PHP_SELF']."?action=add_feed&msg=Error: Either select a category or create a new one");
	}
/*	elseif($txtRefId == 0)
	{
		header("Location:".$_SERVER['PHP_SELF']."?action=add_feed&msg=Error: news reference is empty");
	}*/
	elseif($txtTitle == '')
	{
		header("Location:".$_SERVER['PHP_SELF']."?action=add_feed&msg=Error: news title is empty");
	}
	elseif($txtSumm == '' )
	{
		header("Location:".$_SERVER['PHP_SELF']."?action=add_feed&msg=Error: news description is empty");
	}
	else
	{
		
		//Get the value of category, if category doesn't exist, create a new category, 
		//in either scenario, get the category id from the list
		if($cat_name != '')
		{
			$catId = $category->createCategory($parent_id, $cat_name, 'news_categories');
		}
		else
		{
			$catId = $parent_id;
		}//category
		
		//add news
		$news_id = $news->addNews($catId, $txtRefId, $txtTitle, $txtSumm);
		
		//add news detail 1, we will add it by default
		$descId1 = $news->addNewsDetail($news_id, $subTitle1, $txtDesc1);
		
		
		//add news detail 2
		if($txtDesc2 != '')
		{
			$descId2 = $news->addNewsDetail($news_id, $subTitle2, $txtDesc2);
		}
		
		//add news detail 3
		if($txtDesc3 != '')
		{
			$descId3 = $news->addNewsDetail($news_id, $subTitle3, $txtDesc3);
		}
		
		//add all images before upload check whether the image field is empty or not
		
		//add image detail
		$news->addNewsImage($descId1, $imgTitle1, $imgDesc1, $imgCredit1);
		//news image 1
		if($_FILES['fileImg1']['name'] != '')
		{
			//image update
			$newName  = $utility->getNewName($_FILES['fileImg1'], 'NEWSIMG');
								
			$uImg->imgUpdResize($_FILES['fileImg1'], 'NEWSIMG', $newName, '../images/news/', 
					  520, 520, $descId1, 'image', 'nd_id', 'news_detail');
		}
		
		//news image 2
		if(($_FILES['fileImg2']['name'] != '') && ($descId2 > 0))
		{
			//add image detail
			$news->addNewsImage($descId2, $imgTitle2, $imgDesc2, $imgCredit2);
			
			//image update
			$newName  = $utility->getNewName($_FILES['fileImg2'], 'NEWSIMG');
								
			$utility->imgUpdResize($_FILES['fileImg2'], 'NEWSIMG', $newName, '../images/news/', 
					  520, 520, $descId2, 'image', 'nd_id', 'news_detail');
		}
		
		//news image 3
		if(($_FILES['fileImg3']['name'] != '') && ($descId3 > 0))
		{
			//add image detail
			$news->addNewsImage($descId3, $imgTitle3, $imgDesc3, $imgCredit3);
			
			//image update
			$newName  = $utility->getNewName($_FILES['fileImg3'], 'NEWSIMG');
								
			$utility->imgUpdResize($_FILES['fileImg3'], 'NEWSIMG', $newName, '../images/news/', 
					  520, 520, $descId2, 'image', 'nd_id', 'news_detail');
		}
		
		//remove session vars
		$sess_arr = array('txtRefId','txtParentId','txtTitle','txtSumm',
						  'subTitle1','txtDesc1','imgTitle1','imgDesc1','imgCredit1',
						  'subTitle2','txtDesc2','imgTitle2','imgDesc2','imgCredit2',
						  'subTitle3','txtDesc3','imgTitle3','imgDesc3','imgCredit3');
		$utility->delSessArr($sess_arr);
		//forwarding
		$uMesg->showSuccessT('success', 0, '', 'news.php', 'Success !!! news added successfully', 'SUCCESS');
	}
	
}
/* 	ACTION ON PRESSING BUTTON CANCEL */
if(isset($_POST['btnCancel']))
{
	//remove session vars
	$sess_arr = array('txtRefId','txtParentId','txtTitle','txtSumm',
					  'subTitle1','txtDesc1','imgTitle1','imgDesc1','imgCredit1',
					  'subTitle2','txtDesc2','imgTitle2','imgDesc2','imgCredit2',
					  'subTitle3','txtDesc3','imgTitle3','imgDesc3','imgCredit3');
	$utility->delSessArr($sess_arr);
	$utility->delSessArr($sess_arr);
	
	header("Location: "."news.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?>-  -News Management</title>
<!-- Style -->
<link href="../style/style.css" rel="stylesheet" type="text/css">
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

<body>
	
	
    <!-- Header -->
	<?php require_once('header.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<div id="admin-menu">
				<?php require_once('menu.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                <div id="admin-top">
                	<h1>News</h1>
                    
                    <div id="search-page-back">
                    	<form name="formSampleSearch" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                            
                            <div class="search-option">
                            
                            </div>
                            <input name="mode" type="hidden" value="product">
                            <input name="type" type="hidden" value="name">
                            <input name="btnSearch" type="submit" class="search-button" id="btnSearch" value="search">
                        </form>
                    </div>
                   <div class="cl"></div> 
                </div>
                
			<div class="webform-area">
            <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
             <?php 
			//adding new faq
			if(isset($_GET['action']))
			{
				if($_GET['action'] == 'add_feed')
				{
					
			?>

			  <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">

				   <h4 class="padT5 padL5">Reference + Category </h4>
                   
                   <div class="cl"></div>

				    <label>Source/Reference<span class="orangeLetter">*</span></label>

					<select name="txtRefId" id="txtRefId" tabindex="1">
                    <option value="0">None</option>
                      <?php
					  if(isset($_SESSION['txtRefId']))
					  {
					  	$utility->populateDropDown($_SESSION['txtRefId'], 'ref_id', 'reference','news_reference');
					  }
					  else
					  {
					  	$utility->populateDropDown(0, 'ref_id', 'reference','news_reference');
					  }
					  ?>
                    </select>
					<div class="cl"></div>
					<label>Select Category <span class="orangeLetter">*</span></label>

					<select name="txtParentId" id="txtParentId" tabindex="2">
                      <option value="0">Top Level</option>
                      <?php
					  if(isset($_SESSION['txtParentId']))
					  {
					  	$category->categoryDropDown(0,0,$_SESSION['txtParentId'],'add',0,'news_categories');
					  }
					  elseif(isset($_GET['txtParentId']))
					  {
					  	$category->categoryDropDown(0,0,$_GET['txtParentId'],'add',0,'news_categories');
					  }
					  else
					  {
					  	$category->categoryDropDown(0,0,1,'add',0,'news_categories');
					  }
					  ?>
                    </select>
					 <div class="cl"></div> 
										
					<label>Alternate Category<span class="orangeLetter">*</span></label>
                    <input name="txtCatName" type="text" class="text_box_large" id="txtCatName" onBlur="verifyAltCat()" 
					 value="<?php if(isset($_POST['txtCatName'])){echo $_POST['txtCatName'];}?>" size="25">
					<span class="orangeLetter">(If category doesn't exist select parent from the above list) <br />
					</span>
                    <span id="resAltCat"></span>
                    <div class="cl"></div>
					

				    <h4 class="padT5 padL5">Title + Summary</h4>

					<label>Title<span class="orangeLetter">*</span></label>
                    <input name="txtTitle" type="text" id="txtTitle" 
                    value="<?php if(isset($_SESSION['txtTitle'])){echo $_SESSION['txtTitle'];}?>" size="25">
                    <div class="cl"></div>
			

					<label>Summary<span class="orangeLetter">*</span></label>
					<textarea  name="txtSumm" cols="30" rows="4" wrap="PHYSICAL" id="txtSumm">
					<?php if(isset($_POST['txtSumm'])){echo $_POST['txtSumm'];}
					if(isset($_SESSION['txtSumm'])){echo $_SESSION['txtSumm'];}?>
					</textarea>

					<h4 class="padT5 padL5">Images + Description - 1 </h4>

				    <label>Sub Title 1 </label>
				    <input name="subTitle1" type="text" id="subTitle1" 
					value="<?php if(isset($_SESSION['subTitle1'])){echo $_SESSION['subTitle1'];}?>" size="25">
				    <div class="cl"></div>
                    
				    <label>Paragraph 1 </label>
					<textarea  name="txtDesc1" id="txtDesc1">
					<?php if(isset($_POST['txtDesc1'])){echo $_POST['txtDesc1'];}?>
				    </textarea>
                    <div class="cl"></div>

				    <label>Image Title 1 </label>
				    <input name="imgTitle1" type="text" id="imgTitle1" 
					value="<?php if(isset($_SESSION['imgTitle1'])){echo $_SESSION['imgTitle1'];}?>" size="25">
                    <div class="cl"></div>  
                      
				    <label>Image Desc 1 </label>
				    <input name="imgDesc1" type="text" id="imgDesc1" 
					value="<?php if(isset($_SESSION['imgDesc1'])){echo $_SESSION['imgDesc1'];}?>" size="40" maxlength="255">
				    <div class="cl"></div> 
                    
				    <label>Image Credit 1</label>
				    <input name="imgCredit1" type="text" id="imgCredit1" 
					value="<?php if(isset($_SESSION['imgCredit1'])){echo $_SESSION['imgCredit1'];}?>" size="40" maxlength="255">
				    <div class="cl"></div> 

				    <label>Image 1</label>
				    <input name="fileImg1" type="file" id="fileImg1">
				    <div class="marT10 marL10"><span class="orangeLetter">(250 X 250 pixels) </span></div>
                    <div class="cl"></div> 


					<h4 class="padT5 padL5">Images + Description - 2 </h4>

				    <label>Sub Title 2 </label>
				    <input name="subTitle2" type="text" id="subTitle2" 
					value="<?php if(isset($_SESSION['subTitle2'])){echo $_SESSION['subTitle2'];}?>" size="25">
				    <div class="cl"></div>
                    
				    <label>Paragraph 2 </label>
					<textarea  name="txtDesc2" id="txtDesc2">
					<?php if(isset($_POST['txtDesc2'])){echo $_POST['txtDesc2'];}?>
				    </textarea>
                    <div class="cl"></div>

				    <label>Image Title 2 </label>
				    <input name="imgTitle2" type="text" id="imgTitle2" 
					value="<?php if(isset($_SESSION['imgTitle2'])){echo $_SESSION['imgTitle2'];}?>" size="25">
                    <div class="cl"></div>  
                      
				    <label>Image Desc 2 </label>
				    <input name="imgDesc2" type="text" id="imgDesc2" 
					value="<?php if(isset($_SESSION['imgDesc2'])){echo $_SESSION['imgDesc2'];}?>" size="40" maxlength="255">
				    <div class="cl"></div> 
                    
				    <label>Image Credit 2</label>
				    <input name="imgCredit2" type="text" id="imgCredit2" 
					value="<?php if(isset($_SESSION['imgCredit2'])){echo $_SESSION['imgCredit2'];}?>" size="40" maxlength="255">
				    <div class="cl"></div> 

				    <label>Image 2</label>
				    <input name="fileImg2" type="file" id="fileImg2">
				    <div class="marT10 marL10"><span class="orangeLetter">(250 X 250 pixels) </span></div>
                    <div class="cl"></div> 


					<h4 class="padT5 padL5">Images + Description - 3 </h4>

				    <label>Sub Title 3 </label>
				    <input name="subTitle3" type="text" id="subTitle3" 
					value="<?php if(isset($_SESSION['subTitle3'])){echo $_SESSION['subTitle3'];}?>" size="25">
				    <div class="cl"></div>
                    
				    <label>Paragraph 3 </label>
					<textarea  name="txtDesc3" id="txtDesc3">
					<?php if(isset($_POST['txtDesc3'])){echo $_POST['txtDesc3'];}?>
				    </textarea>
                    <div class="cl"></div>

				    <label>Image Title 3 </label>
				    <input name="imgTitle3" type="text" id="imgTitle3" 
					value="<?php if(isset($_SESSION['imgTitle3'])){echo $_SESSION['imgTitle3'];}?>" size="25">
                    <div class="cl"></div>  
                      
				    <label>Image Desc 3 </label>
				    <input name="imgDesc3" type="text" id="imgDesc3" 
					value="<?php if(isset($_SESSION['imgDesc3'])){echo $_SESSION['imgDesc3'];}?>" size="40" maxlength="255">
				    <div class="cl"></div> 
                    
				    <label>Image Credit 3</label>
				    <input name="imgCredit3" type="text" id="imgCredit3" 
					value="<?php if(isset($_SESSION['imgCredit3'])){echo $_SESSION['imgCredit3'];}?>" size="40" maxlength="255">
				    <div class="cl"></div> 

				    <label>Image 3</label>
				    <input name="fileImg3" type="file" id="fileImg3">
				    <div class="marT10 marL10"><span class="orangeLetter">(250 X 250 pixels) </span></div>
                    <div class="cl"></div> 



<?php /*?>				    <td height="20" colspan="2" align="left" class="menuText">
					<span class="bodyText">
				    </span>
					</td>
				    </tr>
				  <tr>
				    <td height="20" colspan="2" align="left" class="menuText"><span class="orangeLetter"><strong>Images + Description - 2 </strong></span></td>
				    </tr>
				  <tr>
				    <td height="20" colspan="2" align="left" class="menuText">&nbsp;</td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Sub Title 2 </td>
				    <td height="20" align="left"><span class="bodyText">
				      <input name="subTitle2" type="text" id="subTitle2" 
					  value="<?php if(isset($_SESSION['subTitle2'])){echo $_SESSION['subTitle2'];}?>" size="25">
				    </span></td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Paragraph 2</td>
				    <td height="20" align="left">
					<textarea  name="txtDesc2" id="txtDesc2">
					<?php if(isset($_POST['txtDesc2'])){echo $_POST['txtDesc2'];}?>
				    </textarea>
					<script language="JavaScript">
					  generate_wysiwyg('txtDesc2');
					</script>
					</td>
				    </tr>
				  <tr>
				    <td height="20" colspan="2" align="left" valign="top" class="menuText">&nbsp;</td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Image Title 2 </td>
				    <td height="20" align="left"><span class="bodyText">
				      <input name="imgTitle2" type="text" id="imgTitle2" 
					  value="<?php if(isset($_SESSION['imgTitle2'])){echo $_SESSION['imgTitle2'];}?>" size="25">
				    </span></td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Image Desc 2 </td>
				    <td height="20" align="left"><span class="bodyText">
				      <input name="imgDesc2" type="text" id="imgDesc2" 
					  value="<?php if(isset($_SESSION['imgDesc2'])){echo $_SESSION['imgDesc2'];}?>" size="40" maxlength="255">
				    </span></td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Image Credit 2 </td>
				    <td height="20" align="left"><span class="bodyText">
				      <input name="imgCredit2" type="text" id="imgCredit2" 
					  value="<?php if(isset($_SESSION['imgCredit2'])){echo $_SESSION['imgCredit2'];}?>" size="40" maxlength="255">
				    </span></td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Image 2 </td>
				    <td height="20" align="left"><input name="fileImg2" type="file" id="fileImg2">
				      <span class="orangeLetter">(250 X 250 pixels) </span></td>
				   </tr>
				  <tr>
				    <td height="20" colspan="2" align="left" class="menuText">&nbsp;</td>
				    </tr>
				  <tr>
				    <td height="20" colspan="2" align="left" class="menuText"><span class="orangeLetter"><strong>Images + Description - 3 </strong></span></td>
				    </tr>
				  <tr>
				    <td height="20" colspan="2" align="left" class="menuText">
					<span class="bodyText">
				    </span>
					</td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Sub Title 3 </td>
				    <td height="20" align="left"><span class="bodyText">
				      <input name="subTitle3" type="text" id="subTitle3" 
					  value="<?php if(isset($_SESSION['subTitle3'])){echo $_SESSION['subTitle3'];}?>" size="25">
				    </span></td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Paragraph 3 </td>
				    <td height="20" align="left">
					<textarea  name="txtDesc3" id="txtDesc3">
					<?php if(isset($_POST['txtDesc3'])){echo $_POST['txtDesc3'];}?>
				    </textarea>
					<script language="JavaScript">
					  generate_wysiwyg('txtDesc3');
					</script>
					</td>
				    </tr>
				  <tr>
				    <td height="20" colspan="2" align="left" valign="top" class="menuText">&nbsp;</td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Image Title 3 </td>
				    <td height="20" align="left"><span class="bodyText">
				      <input name="imgTitle3" type="text" id="imgTitle3" 
					  value="<?php if(isset($_SESSION['imgTitle3'])){echo $_SESSION['imgTitle3'];}?>" size="25">
				    </span></td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Image Desc 3 </td>
				    <td height="20" align="left"><span class="bodyText">
				      <input name="imgDesc3" type="text" id="imgDesc3" 
					  value="<?php if(isset($_SESSION['imgDesc3'])){echo $_SESSION['imgDesc3'];}?>" size="40" maxlength="255">
				    </span></td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Image Credit 3 </td>
				    <td height="20" align="left"><span class="bodyText">
				      <input name="imgCredit3" type="text" id="imgCredit3" 
					  value="<?php if(isset($_SESSION['imgCredit3'])){echo $_SESSION['imgCredit3'];}?>" size="40" maxlength="255">
				    </span></td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">Image 3 </td>
				    <td height="20" align="left"><input name="fileImg3" type="file" id="fileImg3">
				      <span class="orangeLetter">(250 X 250 pixels) </span></td>
				    </tr>
				  <tr>
				    <td align="left" valign="top" class="menuText">&nbsp;</td>
				    <td height="20" align="left">&nbsp;</td>
				    </tr>
				  <tr>
					<td colspan="2" align="left" class="menuText">&nbsp;
					</td>
					</tr>
				  <tr>
				    <td class="menuText">&nbsp;</td>
<?php */?>
						<input name="btnAddNews" type="submit" class="button-add" id="btnAddNews" value="add">					
						<input name="btnCancel" type="submit" class="button-cancel" value="cancel">


			  </form>

			<?php }
			}
			?>
            </div>
                
                

                
                <div class="cl"></div>
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
     
</body>
</html>
