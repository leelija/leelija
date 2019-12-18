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
require_once("../classes/stock.class.php");

require_once("../classes/sample.class.php");
require_once("../classes/employee.class.php"); 

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

$fabric			= new Fabric();
$customer		= new Customer();
$employee		= new Employee();

$sample			= new Sample();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$sid			= $utility->returnGetVar('sid','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

// Sample Details display
$sampleDtl		= $sample->showSampleDb($sid);
//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);


if(isset($_POST['btnEditOrd']))
{	
	$txtEmpName 	        	= $_POST['txtEmpName'];
	$txtParticular 	        	= $_POST['txtParticular'];
	$txtComDesinNo 	        	= $_POST['txtComDesinNo'];
	$txtStichAmount 	        = $_POST['txtStichAmount'];
	$txtStichRate				= $_POST['txtStichRate'];
	$txtOtherCost 	        	= $_POST['txtOtherCost'];
	$txtTime					= $_POST['txtTime'];
	
	$txtProdDesc 	        	= $_POST['txtProdDesc'];
	$selNum						= $_POST['selNum'];

	
	//registering the post session variables
	
	$sess_arr	= array('txtEmpName','txtParticular','txtComDesinNo','txtStichAmount','txtStichRate','txtOtherCost');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'add_computer';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'add_computer';
	$typeM		= 'ERROR';
	
	
	$msg = '';


if($sampleDtl[0] == '')
	{
		echo "Sample Time field empty";
	}
	
	
	else
	{
	
				$stichCost 	= ($txtStichAmount / 100000) * $txtStichRate;
				$totalCost	= $stichCost + $txtOtherCost;
				
				$total_time 			= $sampleDtl[4] + $txtTime;
				$Total_Cost 			= $sampleDtl[5] + $totalCost;
				$MaterialCost  			= 0;
				//echo $totalCost; exit;
				//add the sample computer Aari
				$computer_aari_id 	= $sample->addSamComputer($sampleDtl[0],$txtEmpName,$sampleDtl[3],$txtParticular,$txtTime,
				$txtOtherCost,$txtComDesinNo,$txtStichAmount,$txtStichRate,
				$stichCost,$MaterialCost,$totalCost,$txtProdDesc,$userData[10],'scomputer_aari');
				
				
				//Update sample DB
				$sample->UpdateSamDb($sampleDtl[0], $total_time,$Total_Cost,$userData[10]);
		
		for($i=0; $i < $selNum; $i++)
			{
				$sampleDtl				= $sample->showSampleDb($sid);
				$sampleCompAriDtl		= $sample->showSamComputerAari($computer_aari_id);
				
				//$materialCost  		= $_POST['txtMatAmount'][$i] * $_POST['txtMaterialRate'][$i];	
				//$MTotalCost 		= $sampleCompAriDtl[10] + $materialCost; // Manual Ari Total cost
				$material_cost 		= $sampleCompAriDtl[11];
				
				$total_time 		= $sampleDtl[4];
				$TotalCost 			= $sampleDtl[5];
				
				//add the scomputer_ari_material 
				$sample->addSamMaterials($computer_aari_id,$_POST['txtMaterialName'][$i],$_POST['txtMatAmount'][$i],
				$_POST['txtMUnit'][$i],'','','scomputer_ari_material','computer_aari_id');	
				
				//update scomputer_aari
				//$sample->UpdateSampleAllTable($computer_aari_id,$material_cost,$sampleCompAriDtl[12],'scomputer_aari','computer_aari_id');
				// Update sample_db
				$sample->UpdateSamDb($sampleDtl[0], $total_time,$TotalCost,$userData[10]);
			}	
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], PRODOD001, 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -Add Sample Computer Aari Material</title>

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
<script type="text/javascript" src="../js/sample_product.js"></script>
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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'add_computer') )
        {
             
            $sampleDetails = $sample->showSample($sid);
        ?>
		
<h3><a name="editStock"></a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=add_computer&sid=<?php echo $sid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Add Sample Computer Arri Material</a></h2>
                        <span>Please  <span class="required"></span>fill the following field.</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
							<div class="cl"></div>
							<label>Employee Name<span class="orangeLetter">*</span></label>
								<select name="txtEmpName" type="text" id="txtEmpName" class="text_box_large">
									<?php
										$sampleDtls         	= $sample->getAllSampleDtls();
										
										foreach ($sampleDtls as $row){//Array or records stored in $row
											$empDtls         		= $employee->AllEmployeeData($row[emp_id]);
											foreach ($empDtls as $eachrecord){
											//echo $row[colour_name];
											echo "<option value=$eachrecord[emp_id]>$eachrecord[emp_name]</option>"; 

											/* Option values are added by looping through the array */ 
											}			
										}

									 echo "</select>";//?>
													 
							<div class="cl"></div>	
							<label>Particular Name.</label>
							<input name="txtParticular" id="txtParticular" type="text" class="text-field" />
							<div class="cl"></div>
							<label>Computer Design No.</label>
							<input name="txtComDesinNo" id="txtComDesinNo" type="text" class="text-field" />
							<div class="cl"></div>
							
							<label> Number Of Stich</label>
							<input name="txtStichAmount" id="txtStichAmount" type="text" class="text-field" />
							<div class="cl"></div>
							<label> stich Rate/Lack</label>
							<input name="txtStichRate" id="txtStichRate" type="text" class="text-field" />
							<div class="cl"></div>
							
							
							<tr>
									<label>Select No. Computer Design</label>
									<!--<td align="left" class="menuText">Select No. Type </td>-->
									<td align="left" class="bodyText pad5">
									<?php 
									//gen number array
									$arr_value	= range(1,8);
									$arr_label	= range(1,8);
									?>
									  <select name="selNum" id="selNum" onchange="return getSampleComType();"
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
									  </select>				    </td>
								  </tr>
								<div class="cl"></div>
								<div id="showSampleCompType"></div>
													
								<label> Other Cost</label>
								<input name="txtOtherCost" id="txtOtherCost" type="text" class="text-field" />
								<div class="cl"></div>
								
								 <label> Time</label>
								<input name="txtTime" id="txtTime" type="text" class="text-field" />
								<div class="cl"></div>					
							
							
                            
							 <div class="cl"></div>
							 <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
                            <div class="cl"></div>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="Add" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>