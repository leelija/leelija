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

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$sid			= $utility->returnGetVar('sid','0');



//echo $sid;exit;
if(isset($_POST['btnEditOrd']))
{	
/*	$txtStockId 	        = $_POST['txtStockId'];
	$txtDesignNo	 	= $_POST['txtDesignNo'];
	$txtStock	 		= $_POST['txtStock'];
	$txtProductIn	 		= $_POST['txtProductIn'];
	$txtSales	 	        = $_POST['txtSales'];
	$txtNetSales	 	    = $_POST['txtNetSales'];
	$txtGdReturn	 		= $_POST['txtGdReturn'];
	$AddDate	 	= $_POST['AddDate'];
	
	
	$txtUser			="$custDetails[5]";
	*/
	
	$txtDesignNo	 	= $_POST['txtDesignNo'];		
	$txtProdDesc	 	= $_POST['txtProdDesc'];
	
	//registering the post session variables
	
		$sess_arr	= array('txtDesignNo','txtProdDesc');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'edit_sid';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'editStock';
	$typeM		= 'ERROR';
	
	
	$msg = '';


if($txtDesignNo == '')
	{
		echo "Design number field is empty";
	}
	
	
	else
	{
		//update stock table
	    $stock->editStockDesignNo($sid,$txtDesignNo,$txtProdDesc,$userData[10]);	
		// update stock details table
		$stock->editStockDtlsDsnNo($sid,$txtDesignNo,$userData[10]);
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], 'Design No has been successfully updated', 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - Edit Stock</title>

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
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'edit_sid') )
        {
             
            $stockDetails = $stock->showStock($sid);
        ?>
		
<h3><a name="editStock">Edit Stock</a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=edit_sid&sid=<?php echo $sid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Edit Stock</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
							
							
                            <div class="cl"></div>
							
						<!--	<label>Stock Id<span class="orangeLetter">*</span></label>
                            <input name="txtStockId" type="text" class="text_box_large" id="txtStockId" 
					        value="<?php echo $stockDetails[0] ?>" size="25" />
                            <div class="cl"></div>
						-->	
							
                            <label>Design No<span class="orangeLetter">*</span></label>
                            <input name="txtDesignNo" type="text" class="text_box_large" id="txtDesignNo" 
					        value="<?php echo $stockDetails[1] ?>" size="25" />
                            <div class="cl"></div>
							
							 <label>Change Reason</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php echo $stockDetails[6]; ?>
                            </textarea>
							
                          <!--  
                            <label>Stock</label>
                            <input name="txtStock" type="text" class="text_box_large" id="txtStock" 
					        value="<?php echo $stockDetails[2] ?>" size="25" />
                            <div class="cl"></div>
                            
                            <label>Product In</label>
                            <input name="txtProductIn" type="text" class="text_box_large" id="txtProductIn" 
					        value="<?php echo $stockDetails[3] ?>" size="25" />
                            <div class="cl"></div>
							
                             <label>Sales</label>
                            <input name="txtSales" type="text" class="text_box_large" id="txtSales" 
					        value="<?php echo $stockDetails[4] ?>" size="25" />
                            <div class="cl"></div>
							
							<label>Net Sales</label>
                            <input name="txtNetSales" type="text" class="text_box_large" id="txtNetSales" 
					        value="<?php echo $stockDetails[12] ?>" size="25" />
                            <div class="cl"></div>
                             
							  <label>Goods Return</label>
                            <input name="txtGdReturn" type="text" class="text_box_large" id="txtGdReturn" 
					        value="<?php echo $stockDetails[5] ?>" size="25" />
                            <div class="cl"></div>
							
							 <label>Add Date<span class="orangeLetter">*</span></label>
                            <input name="AddDate" type="date" class="text_box_large" id="AddDate" 
					        value="<?php echo $stockDetails[7] ?>" size="25" />
                            <div class="cl"></div>
							-->
							
							
                            
                            
<?php /*?>                            <label>Tax</label>
                            <select name="txtTaxId" id="txtTaxId" class="textBoxA">
							  <?php
                              if(isset($_SESSION['txtTaxId']))
                              {
                                $tax->taxDropDown($_SESSION['txtTaxId']);
                              }
                              else
                              {
                                $tax->taxDropDown(0);
                              } 
                              ?>
                            </select>	
                            <div class="cl"></div><?php */?>
                            
                           
                            <div class="cl"></div>
                            
                           <!-- <span class="menuTxt"><a href="#AddDesc" onClick="showAdditionalDesc('divId')"> Add additional Remarks</a></span>
                            <div class="cl"></div>
                            
                            <a name="AddDesc">
                                <div id="divId" class="hideDesc">
                                    <label>Additional Remarks</label>
                                    <textarea  name="txtRemarks" id="txtRemarks">
                                    <?php //$utility->printSess2('txtRemarks',''); ?>
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
