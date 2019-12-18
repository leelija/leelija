<?php 
session_start();
ob_start();
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
$customer			= new Customer();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$fid			= $utility->returnGetVar('fid','0');

$userId			= $utility->returnSess('userid', 0);
//customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);


//echo $customerDtl[2];exit;
$fabricDtl		= $fabric->showFabric($fid);


if(isset($_POST['btnEditOrd']))
{	
	$txtPurpose 	        = $_POST['txtPurpose'];
	$txtAmount 	       	    = $_POST['txtAmount'];
	$txtReceiveBy 	       	= $_POST['txtReceiveBy'];
	
	$txtProdDesc 	        = $_POST['txtProdDesc'];
	
	// Calculate current stock
	$current_stock			= $fabricDtl[2]-$txtAmount;
	
	//registering the post session variables
	
		$sess_arr	= array('txtAmount','txtPurpose');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'out_fid';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	
	$msg = '';


	if($txtPurpose == '')
	{
		echo "Select At least One Option";
	}
	elseif($txtAmount == '')
	{
		echo "Amount field empty";
	}
	elseif($txtReceiveBy == '')
	{
		echo "Receiver Name Empty";
	}
	
	
	else
	{
	
		if($txtPurpose =='Production')
			{
				$txtBillNo 	       	= $_POST['txtBillNo'];
				//add the fabric out
				$fabric->addfabricOut($fid,$txtBillNo,'',$txtAmount,$txtPurpose,$txtReceiveBy,$txtProdDesc,$userData[2]);	
				//Update fabric table
				$fabric->editFabric($fid,$current_stock,$userData[2]);
			}
			else{
				
				$txtDesign 	       	= $_POST['txtDesign'];
				//add the fabric out
				$fabric->addfabricOut($fid,'',$txtDesign,$txtAmount,$txtPurpose,$txtReceiveBy,$txtProdDesc,$userData[2]);	
				//Update fabric table
				$fabric->editFabric($fid,$current_stock,$userData[2]);
			}
		
			//deleting the sessions
			$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], ERPROD015, 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - Out Material</title>

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
<script type="text/javascript" src="../js/raw-mat-out.js"></script>
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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'out_fid') )
        {
             
            $fabricDtl		= $fabric->showFabric($fid);
        ?>
		
<h3><a name="editStock"></a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=out_fid&fid=<?php echo $fid; ?>" method="post" enctype="multipart/form-data">
         
		 
			<h2><a name="addUser"><?php echo $fabricDtl[1];?> Out(Quantity unit in <?php echo $fabricDtl[9];?>)</a></h2>
                <span>Please  <span class="required"></span>fill the amount field.</span>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
					<div class="cl"></div>
					<div >
                        <label>Purpose<span class="orangeLetter">*</span></label>
                        <!----- After select one option call package_product_status.php file ----->
                        <select name="txtPurpose" type="text" id="txtPurpose" class="text_box_large" onchange="return getRmatOut(); ">
							<option value="" >---Select One Option---</option>
							<option value="Production" >Production</option>
                            <option value="Sample" >Sample</option>
                                    
                        </select>
                    </div>
                    <div class="cl"></div>
                    <div id="showRmaterialOut"></div>
					<div class="cl"></div>
							
					<label>Remarks</label>
                    <textarea  name="txtProdDesc" id="txtProdDesc">
					<?php $utility->printSess2('txtProdDesc',''); ?>
                    </textarea>
                    <div class="cl"></div>
							                                      
                <input name="btnEditOrd" type="submit" class="button-add"  value="Out" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
