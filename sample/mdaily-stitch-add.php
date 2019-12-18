<?php 
session_start();
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/registration.inc.php");
require_once("../includes/email.inc.php");
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/employee.class.php");
require_once("../classes/mdaily_comp_stitch.class.php");
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$search_obj		= new Search();
$page			= new Pagination();

$employee		= new Employee();
$dStitch		= new MDailyStitch();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

if(isset($_POST['btnAddRecord']))
{	
	$txtOperator 	        = $_POST['txtOperator'];
	$txtCompNo 	        	= $_POST['txtCompNo'];
	$txtShift	 			= $_POST['txtShift'];
	$txtStitchNo	 		= $_POST['txtStitchNo'];
	$txtNote	 			= $_POST['txtNote'];
	$txtOrderId 	        = $_POST['txtOrderId'];
	$txtDesignNo 	        = $_POST['txtDesignNo'];
	$txtWorkedDate 	        = $_POST['txtWorkedDate'];
	$txtCompType 	        = $_POST['txtCompType'];
	$txtOffer 	        	= $_POST['txtOffer'];
	
	if($txtCompType == 'Ari' ){
		$amount 				= ($txtStitchNo / 100) * 1.4;
	}
	elseif($txtCompType == 'AriThread'){
		$amount 				= ($txtStitchNo / 100) * 1.7;
	}
	elseif($txtCompType == 'Multi10h'){
		$amount 				= ($txtStitchNo / 100) * .4;
	}
	elseif($txtCompType == 'Ari10h'){
		$amount 				= ($txtStitchNo / 100) * .8;
	}
	elseif($txtCompType == 'jari40heads'){
		$amount 				= 2* ($txtStitchNo / 100) * 1.4;
	}
	elseif($txtCompType == 'threads40heads'){
		$amount 				= 2 * ($txtStitchNo / 100) * 1.70;
	}
	elseif($txtCompType == 'MultiThread'){
		$amount 				= ($txtStitchNo / 100) * .9;
	}
	elseif($txtCompType == 'Multi'){
		$amount 				= ($txtStitchNo / 100) * .7;
	}
	
	elseif($txtCompType == 'Multi40Heads'){
		$amount 				= 2 * ($txtStitchNo / 100) * 1.40;
	}
	elseif($txtCompType == 'Multi10Heads'){
		$amount 				= ($txtStitchNo / 100) * .35;
	}
	elseif($txtCompType == 'Thread10Heads'){
		$amount 				= ($txtStitchNo / 100) * .45;
	}
	else{
		$amount 				= ($txtStitchNo / 100) * .8;
	}
	
	$empDtls 				= $employee->showEmployee($txtOperator);
	
	//registering the post session variables
	$sess_arr	= array('txtOperator','txtCompNo', 'txtShift','txtStitchNo', 'txtNote');
	$utility->addPostSessArr($sess_arr);
	
	
	//defining error variables
	$action		= 'add_emp';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addEmp';
	$typeM		= 'ERROR';
	
	$msg = '';

	//field validation
	if($txtOperator=='')
	{
		echo "Fill The Operator Name Field";
	}
	
	elseif($txtCompNo=='')
	{
		echo "Fill Up The Computer no. Field";
	}
	elseif($txtShift=='')
	{
		echo "Select Shift Any One";
	}
	else
	{
		
	//add the Daily Stitch
	$dStitch->addmDailyStitch($txtOperator,$empDtls[2],$txtCompNo,$txtCompType, $txtShift, $txtStitchNo,$amount,$txtOffer,'',
	$txtOrderId,$txtDesignNo,$txtNote,$txtWorkedDate,$userData[10],'No');
		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], "Stitch Records has been successfully added", 'SUCCESS');
	}
	
	//deleting the sessions
	$utility->delSessArr($sess_arr);
		
}//eof add product





?>

<title><?php echo COMPANY_S; ?> -  Add Computer Stitch Records</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'sample_add') )
        {
             
            //$ordDetail = $orders->showOrders($oid);
        ?>
		
<h3></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=sample_add" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Add Sample Products Details</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                            <div class="cl"></div>
							<div >
								<label>Operator Name<span class="orangeLetter">*</span></label>							
								<select name="txtOperator" type="text" id="txtOperator" class="text_box_large">
								<?php
									$empDetails         = $employee->getComopName('monienterprises');
									foreach ($empDetails as $row){//Array or records stored in $row
									//echo $row[colour_name];
									echo "<option value=$row[emp_id]>$row[emp_name]</option>"; 

									/* Option values are added by looping through the array */ 
													
									}

									echo "</select>";//?>
							</div>
							
							<div class="cl"></div>
                            <label>Computer No.<span class="orangeLetter">*</span></label>
                            <input name="txtCompNo" type="text" class="text_box_large" id="txtCompNo" size="25" />
                            <div class="cl"></div>
							<div >
								<label>Computer Type<span class="orangeLetter">*</span></label>							
								<select name="txtCompType" type="text" id="txtCompType" class="text_box_large">
									<option value="Embroidery">Embroidery</option>
									<option value="Ari">Ari</option>
									<option value="Ari10h">Ari(10 Head)</option>
									<option value="AriThread">Ari(Thread)</option>
									<option value="Multi">Multi</option>
									<option value="Multi10Heads">Multi(10 Heads)</option>
									<option value="Thread10Heads">Thread(10 Heads)</option>
									<option value="MultiThread">Multi Thread</option>
									<option value="Multi10h">Multi(10 Head)</option>
									<option value="jari40heads">Jari 40 Heads</option>
									<option value="threads40heads">Threads 40 Heads</option>
									<option value="Multi40Heads">Multi 40 Heads</option>
								</select>	
							</div>
							<div class="cl"></div>
							
							<div >
								<label>Shift<span class="orangeLetter">*</span></label>							
								<select name="txtShift" class="form-control input-lg" id="txtShift" required>
									<option value="">Select any one</option>
									<option value="Day">Day</option>
									<option value="Night">Night</option>
								</select>
							</div>
							<div class="cl"></div>
							
							<div class="cl"></div>
                            <label>No Of Stitch<span class="orangeLetter">*</span></label>
                            <input name="txtStitchNo" type="text" class="text_box_large" id="txtStitchNo" size="25" />
                            <div class="cl"></div>
							<div class="cl"></div>
                            <label>Offer Amount<span class="orangeLetter">*</span></label>
                            <input name="txtOffer" type="text" class="text_box_large" id="txtOffer" size="25" />
                            <div class="cl"></div>
							<div class="cl"></div>
                            <label>Order Id<span class="orangeLetter"></span></label>
                            <input name="txtOrderId" type="text" class="text_box_large" id="txtOrderId" size="25" />
                            <div class="cl"></div>
							
							
						    <div class="cl"></div>
                            <label>Design No<span class="orangeLetter"></span></label>
                            <input name="txtDesignNo" type="text" class="text_box_large" id="txtDesignNo" size="25" />
                            <div class="cl"></div>
							
							<div class="cl"></div>
                            <label>Worked Date<span class="orangeLetter"></span>*</label>
                            <input name="txtWorkedDate" type="date" class="text_box_large" id="txtWorkedDate" 
							value="<?php echo date("Y-m-d"); ?>" size="25" />
                            <div class="cl"></div>
							
							 <label>Note</label>
                            <textarea  name="txtNote" id="txtNote">
							<?php $utility->printSess2('txtNote',''); ?>
                            </textarea>
                                                                    
					<input name="btnAddRecord" type="submit" class="button-add"  value="Add" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
