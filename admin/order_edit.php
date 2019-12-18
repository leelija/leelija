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
require_once("../classes/customer.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/status_cat.class.php");

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
$customer		= new Customer();
$status			= new Pstatus();
$statuscat		= new StatusCat();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$oid			= $utility->returnGetVar('oid','0');
//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

if(isset($_POST['btnEditOrd']))
{	
	//$txtOrdNo 	        = $_POST['txtOrdNo'];
	$txtDesignNo	 	= $_POST['txtDesignNo'];
	$txtPartyName	 	= $_POST['txtPartyName'];
	//$txtBrokar	 		= $_POST['txtBrokar'];
	//$txtRetaHol	 	    = $_POST['txtRetaHol'];
	$txtForm	 		= $_POST['txtForm'];
	$txtEmployeeId	 	= $_POST['txtEmployeeId'];
	//$txtColour	 	= $_POST['txtColour'];
	$txtProdDesc	 	= $_POST['txtProdDesc'];
	$OrdersDate	 		= $_POST['OrdersDate'];
	$TargetDate 		= $_POST['TargetDate'];
			
	
	//registering the post session variables
	
		$sess_arr	= array('txtDesignNo', 'txtForm','OrdersDate','TargetDate');
	$utility->addPostSessArr($sess_arr);
	

	
	//defining error variables
	$action		= 'edit_ord';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $oid;
	$id_var		= 'pid';
	$anchor		= 'editOrd';
	$typeM		= 'ERROR';
	
	
	$msg = '';



	if($txtDesignNo=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Design No. is Empty", $typeM, $anchor);
	}
	/*elseif($txtPartyName=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Order by field is empty", $typeM, $anchor);
	}*/
	/*elseif($txtQuantity=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERPROD00111, $typeM, $anchor);
	}*/
	elseif($OrdersDate=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Order Date empty", $typeM, $anchor);
	}
	elseif($TargetDate=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Target Date empty", $typeM, $anchor);
	}
	else
	{
		//edit orders
		 $orders->editOrders($oid,$txtDesignNo, $txtPartyName,$txtForm,$txtProdDesc,$OrdersDate,$TargetDate,$userData[10]);
		 
		 $orders->editOrdersDetails($oid,$txtDesignNo);
		 $status->editStatusDesign($oid,$txtDesignNo,$txtEmployeeId,$OrdersDate,$TargetDate);
		//Edit status design no.
		 $statuscat->editStatusDesign($oid, $txtDesignNo,'dyeing_table');
		 $statuscat->editStatusDesign($oid, $txtDesignNo,'computer_table');
		 $statuscat->editStatusDesign($oid, $txtDesignNo,'hand_table');
		 $statuscat->editStatusDesign($oid, $txtDesignNo,'final_stich');
		 $statuscat->editStatusDesign($oid, $txtDesignNo,'packing_pending');
		 $statuscat->editStatusDesign($oid, $txtDesignNo,'packing_table');
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], SUPROD002, 'SUCCESS');
	}
	$utility->delSessArr($sess_arr);
}





?>

<title><?php echo COMPANY_S; ?> -  - Edit Orders</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'edit_ord') )
        {
             
            $ordDetail = $orders->showOrders($oid);
        ?>
		
<h3><a name="editProd">Edit Orders</a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=edit_ord&oid=<?php echo $oid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Add Orders</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                          
                      <!--      <div class="cl"></div>                      
                    		<label>Orders No <span class="orangeLetter">*</span></label>
                            <input name="txtOrdNo" type="text" class="text_box_large" id="txtOrdNo" 
					           value="<?php //echo $ordDetail[0] ?>"
                              size="25" />
                            <div class="cl"></div>
                          
                       -->     
                             <label>Design No<span class="orangeLetter">*</span></label>
                            <input name="txtDesignNo" type="text" class="text_box_large" id="txtDesignNo" 
					         value="<?php echo $ordDetail[1] ?>" size="25" />
                            <div class="cl"></div>
                            
                            <label>Order By</label>
                            <input name="txtPartyName" type="text" class="text_box_large" id="txtPartyName" 
					         value="<?php echo $ordDetail[2] ?>" size="25" />
                            <div class="cl"></div>
                            
                     <!--       <label>Brokar <span class="orangeLetter">*</span></label>
                            <input name="txtBrokar" type="text" class="text_box_large" id="txtBrokar" 
					        value="<?php //echo $ordDetail[3] ?>" size="25" />
                            <div class="cl"></div>
							
                             <label>Reta/Hol<span class="orangeLetter">*</span></label>
                            <input name="txtRetaHol" type="text" class="text_box_large" id="txtRetaHol" 
					         value="<?php //echo $ordDetail[4] ?>" size="25" />
                            <div class="cl"></div>
                         -->   


							<div >
								<label>Order to<span class="orangeLetter">*</span></label>							
								
								<select name="txtEmployeeId" type="text" id="txtEmployeeId" class="text_box_large">
								<?php
								$customerDetails         = $customer->getAllCustomerDtl();
								foreach ($customerDetails as $row){//Array or records stored in $row
								//echo $row[colour_name];
								echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

								/* Option values are added by looping through the array */ 
									
								}

								 echo "</select>";//?>
							</div>
							<div class="cl"></div>
							
							  <label>Form</label>
                            <input name="txtForm" type="text" class="text_box_large" id="txtForm" 
					         value="<?php echo $ordDetail[5]; ?>" size="25" />
                            <div class="cl"></div>
							
				<!--			 <label>Quantity<span class="orangeLetter">*</span></label>
                            <input name="txtQuantity" type="text" class="text_box_large" id="txtQuantity" 
					         value="<?php //echo $ordDetail[6] ?>" size="25" />
                            <div class="cl"></div>
							
							 <label>Colour<span class="orangeLetter">*</span></label>
                            <input name="txtColour" type="text" class="text_box_large" id="txtColour" 
					         value="<?php //echo $ordDetail[6] ?>" size="15" />
                            <div class="cl"></div>
							
                            -->	
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php echo $ordDetail[8]; ?>
                            </textarea>
						
						    <div class="cl"></div>
							
							 <label>Orders Date<span class="orangeLetter">*</span></label>
                            <input name="OrdersDate" type="date" class="text_box_large" id="OrdersDate" 
					        value="<?php echo $ordDetail[9] ?>" size="25" />
                            <div class="cl"></div>
							
							 <label>Target Date<span class="orangeLetter">*</span></label>
                            <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
					        value="<?php echo $ordDetail[10] ?>" size="25" />
                            <div class="cl"></div>
                            
		 
		 
               
                
                <div class="cl"></div>
                
             <!--   <span class="menuTxt"><a href="#AddDesc" onClick="showAdditionalDesc('divId')"> Add additional Remarks</a></span>
                <div class="cl"></div>
                
                <a name="AddDesc">
                    <div id="divId" class="hideDesc">
                        <label>Additional Remarks</label>
                        <textarea  name="txtRemarks" id="txtRemarks">
                        <?php //echo $prodDetail[4] ?>
                        </textarea>
                    </div>
                </a>-->
                <div class="cl"></div>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="edit" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
