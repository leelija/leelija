<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php");
 
require_once("../includes/constant.inc.php"); 
require_once("../includes/category.inc.php");
require_once("../includes/customer.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../classes/error.class.php"); 
require_once("../classes/category.class.php");
require_once("../classes/utility.class.php");   
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");

require_once("../classes/location.class.php");     
require_once("../classes/search.class.php");
require_once("../classes/employee.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$category		= new Cat();
$lc		 		= new Location();
$search_obj		= new Search();
$employee		= new Employee();


$dateUtil      	= new DateUtil();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();

#######################################################################################

$typeM		= $utility->returnGetVar('typeM','');

if(isset($_POST['btnCreateType'])) 
{
	$parent_id 		= trim($_POST['txtParentId']);
	$txtCusType 	= trim($_POST['txtCusType']);
	$txtCode 		= trim($_POST['txtCode']);
	$txtDesc 		= trim($_POST['txtDesc']);
	
	//register session
	$sess_arr	= array('txtParentId', 'txtCusType', 'txtCode', 'txtDesc');
	$utility->addPostSessArr($sess_arr);
	
	//defining error variables
	$action		= 'add_cat';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$typeM		= 'ERROR'; 
	$anchor		= 'addCat';
	
	$duplicate = $employee->duplicateEmpType($parent_id, $txtCusType, $parent_id, 'emp_type');

	
	if($txtCusType == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERCUST402, $typeM, $aname);
	}
	elseif(preg_match("^ER^",$duplicate))
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERCUST403, $typeM, $aname);
	}
	else
	{
		//add the type
		$type_id		= $employee->addEmpType($parent_id, $txtCusType, $txtCode, $txtDesc);
		
		if($_FILES['fileCatImg']['name'] != '')
		{
			$newName = $utility->getNewName2($_FILES['fileCatImg'], 'STATCAT',$catId,$cat_name);
				
			$uImg->imgCropResize($_FILES['fileCatImg'], '', $newName, 
								'../images/user/type/', 177, 180, $type_id,
					 			'images', 'emp_type_id', 'emp_type');	   
		}
		
		//delete session value
		$utility->delSessArr($sess_arr);
		
		//forward
		$uMesg->showSuccessT('success', $id, $id_var, $_SERVER['PHP_SELF'], SUCUST401, 'SUCCESS');
		
	}
	
}//eof



//cancel
if(isset($_POST['btnCancel']))
{
	$sess_arr	= array('txtParentId', 'txtCatName', 'txtURL', 'txtBrief', 'txtPageTitle', 'txtDesc');
	$utility->delSessArr($sess_arr);
	header("Location: ".$_SERVER['PHP_SELF']);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?>-Customer Type</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries --> 
<script type="text/javascript" src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/scripts/wysiwyg.js"></script> 
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/scripts/wysiwyg-settings.js"></script> 


<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<script type="text/javascript" src="../js/category.js"></script>
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
            	
                <!-- Heading -->
                <div id="admin-top">
                	<h1>Employee Type</h1>
                </div>
                
                <!-- Options -->
                <div id="options-area">
                	<div class="add-new-option">
                    	<a href="<?php echo $_SERVER['PHP_SELF']."?action=add_cat#addCat"; ?>">
                          Add Employee Type				  
                        </a>
                    </div>
                </div> 
                <?php 
				  //GENERATING BREAD CRUMB WHILE BROWSING THROUGH CATEGORY AND SUBCATEGORY
/*				  if(isset($_GET['catId']))
				  {
					 $myCatId = $_GET['catId'];	
					 $parentPath = "<a href='".$_SERVER['PHP_SELF']."'>Category Home</a> ". ">";
					 echo "<span style=\"float:left \" class=\"orangeLetter\">"
					 .$parentPath.$category->categoryPath($myCatId,'YES','categories').
					 "<span>";			 	
				  } */
				 
				  ?>
                <!-- eof Options -->
                
                
                <!-- Display Data -->
                <div id="data-column">
                    
                    <table class="single-column" cellpadding="0" cellspacing="0">
                    
                    <!-- SHOWING ALL CATEGORY AND SUB CATEGORY -->
                     <?php 
                     if(isset($_GET['typeId']))
                     {
                        $typeId = $_GET['typeId'];
                     }
                     else
                     {
                        $typeId = 0;
                     }
                    /* DETERMINE IF THE NUMBER OF SUBCATEGORY IN A PARENT CATEGORY IS ZERO OR NOT*/
                    if($typeId > 0)
					{
						$typeIds		= $employee->getChildEmpTypeId($typeId);
					}
					else
					{
						$typeIds		= $employee->getAllParentEmpTypeId();
					}
                    $allTypes			= $employee->getAllEmployeeTypeId();

                    if(count($typeIds) == 9)
                    {
                    ?>
                    <tr align="left" class="maroonError">
                      <td height="20" colspan="5"> <?php echo ERCUST401; ?> </td>
                     </tr>
                    <?php 
                    }
                    else
                    {
                    ?>  
                     
                    <thead>
                      <th width="6%">ID</th>
                      <th width="23%">Employee Type </th>
                      <th width="22%">Subcategory(ies)</th>
                      <th width="15%">No. of Employee</th>
                      <th width="13%">Added </th>
                      <th width="21%">Action</th>
                    </thead>
                    <?php 
                        $i= 1;
                        
                        foreach($typeIds as $k)
                        {
                            $typeDetail 	= $employee->getEmpTypeData($k);
							$subTypeIds		= $employee->getChildEmpTypeId($k);
                            $bgColor 		= $utility->getRowColor($i);
                    ?>
                        <tr align="left" <?php $utility->printRowColor($bgColor);?>>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $typeDetail[2]; ?></td>
                          <td>
                          <?php 
                          if(count($subTypeIds) > 0)
                          {
                            echo "<a href='".$_SERVER['PHP_SELF']."?typeId=".$k."'>Subcategories(".count($subTypeIds).")</a>";
                          }
                          else
                          {
                            echo "Subcategories(".count($subTypeIds).")";
                          }
                          ?>
                          
                          </td>
                          <td>
						  	<?php echo "Customer()";  ?>
						  </td>
                          <td><?php echo $dateUtil->printDate($typeDetail[5]); ?></td>
                          <td>
                          <?php 
                          /*if($k != 1)
                          {*/
                          ?>
                          [ 
                            <a href="#" 
                          onClick="MM_openBrWindow('customer_type_edit.php?action=edit_type&amp;type_id=<?php echo $k; ?>','CatEdit','scrollbars=yes,width=700,height=600')">
                          edit					  
                          </a> ]
                          
                          [ 
                          <a href="#" onClick="MM_openBrWindow('customer_type_delete.php?action=delete_type&type_id=<?php echo $k; ?>','CatDelete','scrollbars=yes,width=500,height=350')">
                          delete</a> 
                          ]
                          <br /><br />
                          <?php 
                        /*  }		*/			  
                          ?>
                          
                          [ 
                          <a href="<?php echo $_SERVER['PHP_SELF']."?action=add_cat&txtParentId=".$k."#addCat"; ?>" >
                          add sub cat
                          </a> ]
                          
                          
                          </td>
                        </tr>
                  <?php 
                        $i++;
                        }
                  }
                  ?>
                  </table>
                 
                <!-- Bottom Pagination-->
                <div class="pagination-bottom">
                    <div class="upper-block">Total Number of Customer Type: <?php echo count($allTypes);?></div>
                    <?php /*?><div class="lower-block"><?php $page->getPage($numPages, $link, $pageNumber, $pageArray);?></div><?php */?>
                </div>
               
                </div>
                <!-- eof Display Data -->
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                  
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_cat'))
					{
					?>
					<h2><a name="addCat">Add  Category</a></h2>
					<span>Please note that all the <span class="required">*</span> marked fileds are required</span>
					
					  <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
						
							<label>Parent Type<span class="orangeLetter">*</span></label>		
							<select name="txtParentId" class=" textBoxA" id="txtParentId">
							  <option value="0">Top Level</option>
							  
							  <?php
							  if(isset($_GET['txtParentId']))
							  {
								$employee->employeeTypeDropDown(0,0,$_GET['txtParentId'],'ADD',0,'emp_type');
							  }
							  elseif(isset($_SESSION['txtParentId']))
							  {
								$employee->employeeTypeDropDown(0,0,$_SESSION['txtParentId'],'ADD',0,'emp_type');
							  }
							  else
							  {
								$employee->employeeTypeDropDown(0,0,0,'ADD',0,'emp_type');
							  }
							  ?>
							</select>
							
                            <div class="cl"></div>
							<label>Employee Type<span class="orangeLetter">*</span></label>
							<input name="txtCusType" type="text" class="text_box_large" id="txtCusType"
							value="<?php $utility->printSess('txtCusType'); ?>" size="25" />
                            <div class="cl"></div>	
                             
                            				
							<label>Code</label>
							<input name="txtCode" type="text" class="text_box_large" id="txtCode"
							value="<?php $utility->printSess('txtCode'); ?>" size="25" /> 
                            <div class="cl"></div>                   
                                                                            
							<label>Description </label>
							<textarea name="txtDesc" cols="70" rows="15" class="textAr" id="txtDesc">
							<?php $utility->printSess('txtDesc'); ?>
							</textarea>

                            <div class="cl"></div>	
                            
                            <label>Image </label>
							<input name="fileCatImg" type="file" class="text_box_large" id="fileCatImg">
							<span class="menuText">(image size: 200 pixel &times; 200 pixel in width and height)</span>	
                            <div class="cl"></div>																					
                                
                            <label>&nbsp;</label>
							
							<input name="btnCreateType" type="submit" class="button-add" value="create" />
							<input name="btnCancel" type="submit" class="button-cancel" value="cancel" />                    
							<div class="cl"></div>
		
					  </form>
					
					<?php 
					}//if
					?>
                        
                   
                   
                    
                     
                </div>
                <div class="cl"></div>
                <!-- eof Form -->
                
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