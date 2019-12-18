<?php
ob_start();
session_start();
?>
<?php 
//session_start();
require_once("_config/connect.php"); 

require_once("includes/constant.inc.php");
require_once("includes/product.inc.php");

require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php"); 
require_once("classes/order.class.php"); 
require_once("classes/search.class.php");
require_once("classes/pagination.class.php");
require_once("classes/stock.class.php");

require_once("classes/status_cat.class.php");
require_once("classes/customer.class.php");
require_once("classes/product_status.class.php");


require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php"); 
require_once("classes/utilityImage.class.php");
require_once("classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$stock			= new Stock();

$statuscat			= new StatusCat();

$customer			= new Customer();
$prodStatus			= new Pstatus();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$dhmckfip			= $utility->returnGetVar('dhmckfip','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//echo $customerDtl[2];exit;
$IronDtl=$statuscat->showProductIron($dhmckfip);
// echo $DyeingDtl[1];exit;

// product status details

//$quantity  = $IronDtl[7] + $IronDtl[15];

if(isset($_POST['btnEditOrd']))
{	
	$txtAmount 	        = $_POST['txtAmount'];
	$txtStatus			= $_POST['txtStatus'];
	$txtProdDesc 	        = $_POST['txtProdDesc'];
	//echo $txtStatus;exit;
	$leftAmount			= $IronDtl[7]-$txtAmount;
	$completeTotal		= $IronDtl[15]+$txtAmount;	
	
	//$quantity  =  $leftAmount + $completeTotal;
// Calculate current stock
//$current_stock= $txtAmount+$fabricDtl[2];
	
	//registering the post session variables
	
		$sess_arr	= array('txtAmount','txtProdDesc','leftAmount');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'update_iron';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	
	$msg = '';


if($txtAmount == '')
	{
		echo "Amount field empty";
	}
	elseif($txtStatus == '')
	{
		echo "Chose one option";
	}
	elseif($IronDtl[7] < $txtAmount)
	{
		echo "Please put the valid quantity";
		//$error->showErrorTA($action, $id, $id_var, $url, "Please put the valid quantity", $typeM, $aname);
	}
	
	
	else
	{
		//Edit Final Stich table
	   $statuscat->editIron($dhmckfip,$IronDtl[1],$IronDtl[2],$IronDtl[3],$IronDtl[4],$IronDtl[5],$IronDtl[6],
	   $leftAmount,$IronDtl[8],$IronDtl[9],$IronDtl[10],$customerDtl[16],$completeTotal,$txtStatus);	
	   
	   $prodStatusDtl	=$prodStatus->showProductStat($IronDtl[1]);
	   
	   $prodStatus->editStatus($IronDtl[1],$prodStatusDtl[1],$prodStatusDtl[2], $prodStatusDtl[19],$prodStatusDtl[3],
	   $prodStatusDtl[4], $prodStatusDtl[5],$prodStatusDtl[6],$prodStatusDtl[7],$prodStatusDtl[8],$prodStatusDtl[18],
	   $prodStatusDtl[9],$prodStatusDtl[10],$txtStatus,$prodStatusDtl[12],$prodStatusDtl[13],$prodStatusDtl[20]);
	 
	 
	  // $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], SUPROD001, 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - EDIT Iron status</title>

<!-- Style -->
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/utility.js"></script>
<script type="text/javascript" src="js/advertiser.js"></script>
<script type="text/javascript" src="js/location.js"></script>
<script type="text/javascript" src="js/checkEmpty.js"></script>
<script type="text/javascript" src="js/email.js"></script>
<script type="text/javascript" src="js/static.js"></script>
<script type="text/javascript" src="js/product.js"></script>
<!-- eof JS Libraries -->

<!-- TinyMCE --> 
 <script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'update_iron') )
        {
             
            $IronDetails = $statuscat->showProductIron($dhmckfip);
        ?>
		
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=update_iron&dhmckfip=<?php echo $dhmckfip; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Edit Iron status</a></h2>
		 <h2>->Order Id <?php echo $IronDetails[2];?>&nbsp;->Design No. <?php echo $IronDetails[3];?></h2>
                        <span>Please  <span class="required"></span>fill the amount field.</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
							
							
                            <div class="cl"></div>
							
							<label>Iron Amount(in pieces)<span class="orangeLetter">*</span></label>
                            <input name="txtAmount" type="text" class="text_box_large" id="txtAmount" 
					        value="<?php echo $IronDetails[7];?>" size="25" />
                            <div class="cl"></div>
							<div >
							<label>Complete OR Not<span class="orangeLetter">*</span></label>
							 <select name="txtStatus" type="text" class="text_box_large" id="txtStatus"  />
			               				 	<option value="complete">Complete</option>
											<option value="running">Running</option>
			                				 <option value="incomplete">Incomplete</option>
			               					
			           				  		</select>
                            <div class="cl"></div>
							</div>		
                            <div class="cl"></div>
							
							
							 <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
                            <div class="cl"></div>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="update" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>