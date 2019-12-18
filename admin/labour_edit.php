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
require_once("../classes/customer.class.php"); 


require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");

require_once("../classes/fabric.class.php");

require_once("../classes/rate.class.php"); 
require_once("../classes/labour.class.php"); 

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

$rate			= new Rate();
$labour		    = new Labour();

$customer		= new Customer();
$fabric		   = new Fabric();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM				= $utility->returnGetVar('typeM','');
$lid			= $utility->returnGetVar('lid','0');


if(isset($_POST['btnEditOrd']))
{	
	$txtLabour 	            = $_POST['txtLabour'];
	$txtAddress	 	        = $_POST['txtAddress'];
	$txtMobile				=$_POST['txtMobile'];
	$txtEmpName				=$_POST['txtEmpName'];
	$txtDueAmm				=$_POST['txtDueAmm'];
	$txtAdvAmm				=$_POST['txtAdvAmm'];
	

	 //$product->addProduct($txtParentId,$txtProdName, $txtPageTitle, $txtProdCode, $intQuant, $txtProdPrice, $txtBrief,
		//$txtProdDesc,$txtSeoUrl,$txtCanonical,$txtMetaTag,$txtMetaDesc,$txtMetaKey);
	
	//registering the post session variables
	$sess_arr	= array('txtLabour','txtAddress','txtMobile');
	$utility->addPostSessArr($sess_arr);
	

	
	//defining error variables
	$action		= 'edit_labour';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $oid_dtl_id;
	$id_var		= 'oid_dtl_id';
	$anchor		= 'editOrd';
	$typeM		= 'ERROR';
	
	
	$msg = '';



	if($txtLabour == '')
	{
		echo "Please fill the Labour Name field";
	}
	
	else
	{
		//edit orders
		 $labour->editLabouracount($lid,$txtLabour,$txtEmpName, $txtAddress,$txtMobile,$txtDueAmm,$txtAdvAmm);
				
		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], SUPROD002, 'SUCCESS');
	}
	$utility->delSessArr($sess_arr);
}





?>

<title><?php echo COMPANY_S; ?> -  - Edit Labour</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'edit_labour') )
        {
            $labourDtl		= $labour->showLabour($lid); 
            //$ordDetail = $orders->showOrders($oid);
        ?>
		
<h3><a name="editProd">Edit Labour Account</a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=edit_labour&lid=<?php echo $lid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Edit Labour Account</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                  
                             <div class="cl"></div>                      
                    		<label>Labour Name <span class="orangeLetter">*</span></label>
                            <input name="txtLabour" type="text" class="text_box_large" id="txtLabour" 
					           value="<?php echo $labourDtl[1]; ?>"
                              size="25" />
                            <div class="cl"></div>
							
							
							<div >
								<label>Under(Stich Master)<span class="orangeLetter">*</span></label>							
								<select name="txtEmpName" type="text" id="txtEmpName" class="text_box_large">
								<option value=<?php echo $labourDtl[12]; ?>><?php echo $labourDtl[12]; ?></option>
								<?php
									$customerDetails         = $customer->getAllCustomerDtlPipeline(15);
									foreach ($customerDetails as $row){//Array or records stored in $row
									//echo $row[colour_name];
									echo "<option value=$row[user_name]>$row[user_name]</option>"; 

									/* Option values are added by looping through the array */ 
													
									}

									echo "</select>";//?>
							</div>
							 <div class="cl"></div>                      
                    		<label>Due Amount<span class="orangeLetter"></span></label>
                            <input name="txtDueAmm" type="text" class="text_box_large" id="txtDueAmm" 
					           value="<?php echo $labourDtl[4]; ?>"
                              size="25" />
                            <div class="cl"></div>
							 <div class="cl"></div>                      
                    		<label>Advance Amount<span class="orangeLetter"></span></label>
                            <input name="txtAdvAmm" type="text" class="text_box_large" id="txtAdvAmm" 
					           value="<?php echo $labourDtl[10]; ?>"
                              size="25" />
                            <div class="cl"></div>
						
                           <div class="cl"></div>                      
                    		<label>Address<span class="orangeLetter"></span></label>
                            <input name="txtAddress" type="text" class="text_box_large" id="txtAddress" 
					           value="<?php echo $labourDtl[2]; ?>"
                              size="25" />
                            <div class="cl"></div>
							
							<div class="cl"></div>                      
                    		<label>Mobile No. <span class="orangeLetter"></span></label>
                            <input name="txtMobile" type="text" class="text_box_large" id="txtMobile" 
					           value="<?php echo $labourDtl[3]; ?>"
                              size="25" />
                            <div class="cl"></div>
                    
                
                <div class="cl"></div>
                
          
                <div class="cl"></div>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="edit" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
