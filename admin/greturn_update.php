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

$customer		= new Customer();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$gd_id			= $utility->returnGetVar('gd_id','0');

$userId			= $utility->returnSess('userid', 0);
$custDetails=$customer->getCustomerData($userId);

$productReturnDetail = $stock->showProductReturn($gd_id);
$stockDetails = $stock->showStock($productReturnDetail[1]);

$stockDtlShow  = $stock->getAllStockData();

if(isset($_POST['btnEditOrd']))
{	
	
	$txtProductIn	 		= $_POST['txtProductIn'];
	
	
	$txtStock				= $txtProductIn + $stockDetails[2];//Current Product
	$totalProdIn			= $stockDetails[3]; //Product In
	$goodsReturn   			= $stockDetails[5] - $txtProductIn;//Goods return	
	
	//registering the post session variables
	
	
	//$showGRDtl = $stock->showProductReturnData($txtDesignNo,$txtColour);
	
	
		$sess_arr	= array('txtProductIn', '');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'update_gd';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'editStock';
	$typeM		= 'ERROR';
	
	
	$msg = '';
	
	
if($txtProductIn == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERPROD016, $typeM, $anchor);
	}
	elseif($txtProductIn > $productReturnDetail[2]) {
				$error->showErrorTA($action, $id, $id_var, $url, "Your value greater than GR", $typeM, $anchor);
	}
	elseif($productReturnDetail[2]== 0) {
		$error->showErrorTA($action, $id, $id_var, $url, "No GR Quantity available", $typeM, $anchor);
	}
	else
	{
		//edit stock
	    $stock->editStock($stockDetails[0],$stockDetails[1], $txtStock, $totalProdIn, $stockDetails[4], $stockDetails[12], $goodsReturn,
		$stockDetails[6], $stockDetails[7],'');	
		
		// add product in
		//$stock->addProductIn($txtDesignNo,$txtBillNo, $txtProductIn, $txtColour, $txtProdDesc, '', '');
		//echo $txtStock;exit;
		if($txtStock != 0){
		
			
		$stockDetailsDtl  = $stock->stockDetailsDisplay();
		//echo $stockDetailsDtl['colour'];exit;
		foreach($stockDetailsDtl as $eachrecord ){
				/*echo $eachrecord['colour'];
				echo $eachrecord['design_no'];*/
				if($productReturnDetail[3] == $eachrecord['colour'] && $stockDetails[1] == $eachrecord['design_no'])
					{
						$total_quantity = $eachrecord['quantity'] + $txtProductIn; // total current quantity
						$total_quantity_in = $eachrecord['quantity_in'];// total product in product
						
						// stock Details update
						$TotalGR = $eachrecord['quantity_return'] - $txtProductIn;
						$stock->editstockDetails($eachrecord['stock_dtl_id'],$stockDetails[0],$stockDetails[1], $productReturnDetail[3], $total_quantity,$total_quantity_in,
						$eachrecord['sales'],$eachrecord['net_sales'],$TotalGR,'', '');
						//($stock_id, $design_no, $colour,$quantity,$quantity_in,$sales,$net_sales,$quantity_return, $added_by)
					
					
					$goodsReturn = $productReturnDetail[2] - $txtProductIn;//Now current goods Return
					$ReadygoodsReturn = $showGRDtl[6] + $txtProductIn;// ready goods return
					//echo $goodsReturn;
					
					// gd return edit
					$stock->editGreturn($gd_id, $stockDetails[0],$goodsReturn,$productReturnDetail[3],$productReturnDetail[4], $productReturnDetail[5]
					, $ReadygoodsReturn,'');
					
					//echo "Product Return has been update";
					$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], RPROD001, 'SUCCESS');
					exit;
					}
					/*else {
							$stock->addstockDetails($stockDetails[0], $txtDesignNo, $txtColour, $txtProductIn, '', '');
					}*/
		
		
			}
			
							//$stock->addstockDetails($stockDetails[0], $txtDesignNo, $txtColour, $txtProductIn,$txtProductIn,'','', '', '');
							//echo "Hi I am last";exit;	
		
	}
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], RPROD001, 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - Product In</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'update_gd') )
        {
             
            $stockDetails = $stock->showStock($gd_id);
        ?>

          <form action="<?php $_SERVER['PHP_SELF']?>?action=update_gd&gd_id=<?php echo $gd_id; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Product In</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        
                            <label style="color:red;"> GR Ready(in pieces)</label>
                            <input name="txtProductIn" type="text" class="text_box_large" id="txtProductIn" 
					        value="<?php echo $productReturnDetail[2]; ?>" size="25" />
                            <div class="cl"></div>
						    <p style="color: blue;">colour:<?php echo $productReturnDetail[3]; ?> </p>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="Update" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>