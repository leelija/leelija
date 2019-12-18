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

require_once("../classes/employee.class.php"); 
require_once("../classes/stock.class.php"); 
require_once("../classes/sample.class.php"); 


require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");

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

$stock			= new Stock();
$sample			= new Sample();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$keyword		= $utility->returnGetVar('keyword','');
$type			= $utility->returnGetVar('type','');
$mode			= $utility->returnGetVar('mode','');
$sid			= $utility->returnGetVar('sid','0');

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$sampleData		= $sample->getAllSampleDb();

$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 20);
$userId			= $utility->returnSess('userid', 0);

$sampleDtls 	= $sample->showSampleDb($sid);
$empDtls        = $employee->showEmployee($sampleDtls[1]);
$factDtls    	= $sample->showFactory($sampleDtls[2]);

if(isset($_POST['btnAddRecord']))
{	
	
	$txtDesignerId			= $_POST['txtDesignerId'];	
	$txtFactoryId			= $_POST['txtFactoryId'];	
	
	if($txtDesignerId=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url,"Select Designer", $typeM, $anchor);
	}
	else
	{
		// edit Sample Data
		$sample->editSamDb($sid,$txtDesignerId,$txtFactoryId,$userData[10]);
		
		//forward
		$uMesg->showSuccessT('success', $sid, 'id', $_SERVER['PHP_SELF'], "Sample has been successfully edited", 'SUCCESS');
	}	
}

?>

<title><?php echo COMPANY_S; ?> -  Add Employee</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'Add_emp') )
        {
             
            //$ordDetail = $orders->showOrders($oid);
        ?>
		
<h3></h3>
    
        <form action="<?php $_SERVER['PHP_SELF']?>?action=Add_emp&sid=<?php echo $sid; ?>" method="post" enctype="multipart/form-data">
		 <h2><a name="addUser">Add Employee</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                           <div class="cl"></div>
							
							<div >
								<label>Designer<span class="orangeLetter">*</span></label>							
								
								<select name="txtDesignerId" type="text" id="txtDesignerId" class="text_box_large">
								
								<option value="<?php echo $empDtls[0];?>"><?php echo $empDtls[2];?></option>
								<?php
								$empDetails         = $employee->designerName();
								foreach ($empDetails as $row){//Array or records stored in $row
								//echo $row[colour_name];
								echo "<option value=$row[emp_id]>$row[emp_name]</option>"; 

								/* Option values are added by looping through the array */ 
									
								}
								 echo "</select>";//?>
							</div>
							<div class="cl"></div>
							<div >
								<label>Factory Name<span class="orangeLetter">*</span></label>							
								<option value="<?php echo $factDtls[1];?>"><?php echo $factDtls[1];?></option>
								<select name="txtFactoryId" type="text" id="txtFactoryId" class="text_box_large">
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
                                                                    
					<input name="btnAddRecord" type="submit" class="button-add"  value="Edit" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
