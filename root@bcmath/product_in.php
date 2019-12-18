<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("_config/connect.php"); 
require_once("includes/constant.inc.php");
require_once("includes/product.inc.php");
require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php"); 
require_once("classes/order.class.php"); 
require_once("classes/search.class.php");
require_once("classes/pagination.class.php");
require_once("classes/product_stock.class.php"); 
require_once("classes/customer.class.php"); 
require_once("classes/status_cat.class.php");
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
$productStock	= new ProductStock();
$customer		= new Customer();
$statusCat		= new StatusCat();
$prodStatus		= new Pstatus();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################
date_default_timezone_set('Asia/Calcutta'); 
$AddDate 			= date("Y-m-d");// Added Date
//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$sid			= $utility->returnGetVar('sid','0');

$userId			= $utility->returnSess('userid', 0);
$custDetails	= $customer->getCustomerData($userId);

//Customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);

//$stockDetails = $stock->showStock($sid);
$packingDetail 	= $statusCat->showProductPaking($sid);
//$PackingDtl		= $statuscat->showProductPaking($dhmckfip);
// stock details
$stockDetails 	= $productStock->showPStockDesignwise($packingDetail[3]);
$orderDetail 	= $orders->showOrders($packingDetail[2]);

	if(count($stockDetails)	== 0)
		{
		//add the product stock table
	    $productStock->addStockProduct($packingDetail[3], '', '', '', '','',
		'',$orderDetail[14], $AddDate,$userData[2]);
	}
		//echo $stockDetails[2];exit;

//$stockDtlShow  = $stock->getAllStockData();

if(isset($_POST['btnEditOrd']))
{	
	$txtEmpId 	        	= $_POST['txtEmpId'];
	$txtDesignNo	 		= $_POST['txtDesignNo'];
	$txtProductIn	 		= $_POST['txtProductIn'];
	$txtBillNo				= $_POST['txtBillNo'];//Bill No
	$txtProdDesc	 		= $_POST['txtProdDesc'];
	$txtColour				= $_POST['txtColour'];//colour
	//echo "Waiting for your permission ";exit;
	$stockDetails 			= $productStock->showPStockDesignwise($packingDetail[3]);
	$txtStock				= $txtProductIn + $stockDetails[2];//Current Product
	$totalProdIn			= $txtProductIn + $stockDetails[3]; //Product In
	$completeTotal			= $packingDetail[15] + $txtProductIn;
	$ordDtls 				= $orders->ordDtlsShow($packingDetail[2],$txtColour);
	$readyQty				= $ordDtls[5] + $txtProductIn;	
	$leftQty				= $ordDtls[2] - $readyQty;
	
	if($readyQty  == $ordDtls[2])
	{
		$txtStatus				= 'complete';
	}
	else{
		$txtStatus				= 'incomplete';
	}
	
	//echo $txtStock;exit;
	//registering the post session variables
	$sess_arr	= array('txtDesignNo', 'txtProductIn', 'txtProdDesc');
	$utility->addPostSessArr($sess_arr);
	
	//defining error variables
	$action		= 'edit_sid';
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
	elseif($txtDesignNo=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ERPROD017, $typeM, $anchor);
	}
	elseif($readyQty > $ordDtls[2])
		{
			echo "Please Put the correct value";
		}
	
	else
	{
		//edit Product stock
	    $productStock->editStockProduct($stockDetails[0],$txtDesignNo, $txtStock, $totalProdIn, $stockDetails[4], $stockDetails[12], $stockDetails[5],
		$stockDetails[6], $stockDetails[7],$userData[2]);	
		
		// add stock product in
		$productStock->addStockProductIn($txtDesignNo,$txtBillNo, $txtProductIn, $txtColour, $txtProdDesc, '', $userData[2]);
		
		// update Order Details
		$orders->updateOrdDtls($packingDetail[2],$txtColour,$readyQty,'ready_quantity');
		
		
		//Edit Final Stich table
	   $statusCat->editPacking($sid,$packingDetail[1],$packingDetail[2],$packingDetail[3],$packingDetail[4],$txtEmp,$packingDetail[6],
	   $leftAmount,$packingDetail[8],$packingDetail[9],$packingDetail[10],$userData[2],$completeTotal,$txtStatus);	
	   
	   $prodStatusDtl	=$prodStatus->showProductStat($packingDetail[1]);
	   
	   $prodStatus->editStatus($packingDetail[1],$prodStatusDtl[1],$prodStatusDtl[2], $prodStatusDtl[19],$prodStatusDtl[3],
	   $prodStatusDtl[4], $prodStatusDtl[5],$prodStatusDtl[6],$prodStatusDtl[7],$prodStatusDtl[8],$prodStatusDtl[18],
	   $prodStatusDtl[9],$prodStatusDtl[10],$prodStatusDtl[11],$txtStatus,$prodStatusDtl[13],$prodStatusDtl[20]);
	 
		//update order submit date
		$orders->editOrderSubmit($packingDetail[2]);
		
		
		
		
		
		//echo $txtStock;exit;
		if($txtStock == 0){
			// Add Stock Product Details
			$productStock->addstockProdDetails($stockDetails[0], $txtDesignNo, $txtColour, $txtProductIn,$txtProductIn,'','', '', $userData[2]);
			
			echo "first..";exit;
			}
			else{
			//echo "Hii";
		$stockDetailsDtl  = $productStock->stockProdDetailsDisplay();
		//echo $stockDetailsDtl['colour'];exit;
		foreach($stockDetailsDtl as $eachrecord ){
				/*echo $eachrecord['colour'];
				echo $eachrecord['design_no'];*/
				if($txtColour == $eachrecord['colour'] && $txtDesignNo == $eachrecord['design_no'])
					{
						$total_quantity = $eachrecord['quantity'] + $txtProductIn; // total current quantity
						$total_quantity_in = $eachrecord['quantity_in'] + $txtProductIn;// total product in product
						// stock Details edit
						$productStock->editstockProdDetails($eachrecord['stock_dtl_id'],$stockDetails[0],$txtDesignNo, $txtColour, $total_quantity,$total_quantity_in,
						$eachrecord['sales'],$eachrecord['net_sales'],$eachrecord['quantity_return'],'', $userData[2]);
						
						//($stock_id, $design_no, $colour,$quantity,$quantity_in,$sales,$net_sales,$quantity_return, $added_by)
					//echo"Product has been added";
					$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], PRODOD001, 'SUCCESS');
					exit;
					}
					/*else {
							$stock->addstockDetails($stockDetails[0], $txtDesignNo, $txtColour, $txtProductIn, '', '');
					}*/
			}
					//echo "Hi I am last";exit;	
					// Add Stock Product Details
					$productStock->addstockProdDetails($stockDetails[0], $txtDesignNo, $txtColour, $txtProductIn,$txtProductIn,'','', '', $userData[2]);
			
	}
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], PRODOD001, 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - Product In</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'edit_sid') )
        {
             
            $packingDetail = $statusCat->showProductPaking($sid);
        ?>
		
			<h3><a name="editStock">Product in</a></h3>
    
			<form action="<?php $_SERVER['PHP_SELF']?>?action=edit_sid&sid=<?php echo $sid; ?>" method="post" enctype="multipart/form-data">
			<h2><a name="addUser">Product In</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            <div class="cl"></div>
							
							<div >
								<label>Packer Name<span class="orangeLetter">*</span></label>							
								<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
								<?php
									$customerDetails         = $customer->getAllCustomerDtlPipeline(17);
									foreach ($customerDetails as $row){//Array or records stored in $row
									//echo $row[colour_name];
									echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

									/* Option values are added by looping through the array */ 
													
									}

									echo "</select>";//?>
							</div>
							<div class="cl"></div>
                            <label>Design No<span class="orangeLetter">*</span></label>
                            <input name="txtDesignNo" type="text" class="text_box_large" id="txtDesignNo" 
					        value="<?php echo $packingDetail[3] ?>" size="25" />
                            <div class="cl"></div>
							 <label>Bill No<span class="orangeLetter">*</span></label>
                            <input name="txtBillNo" type="text" class="text_box_large" id="txtBillNo" 
					         value="<?php echo $packingDetail[17] ?>" size="25" />
                            <div class="cl"></div>
							
							<!-- <label>Product Colour<span class="orangeLetter">*</span></label>
                            <input name="txtColour" type="text" class="text_box_large" id="txtColour" 
					         size="25" />
                            <div class="cl"></div>
							-->
							<div >
								<label>Product Colour<span class="orangeLetter">*</span></label>							
								
								<select name="txtColour" type="text" id="txtColour" class="text_box_large">
								<?php
								//$pColourDetails         = $stock->ColourDisplay($stockDetails[1]);
								$pColourDetails		    = $orders->ordersDtlDisplay($packingDetail[2]);
								foreach ($pColourDetails as $row){//Array or records stored in $row
								//echo $row[colour_name];
								echo "<option value=$row[colour]>$row[colour]</option>"; 

								/* Option values are added by looping through the array */ 
									
								}

								 echo "</select>";//?>
							</div>
							<div class="cl"></div>
							
                            <label style="color:red;"> Products In(in pieces colour wise)</label>
                            <input name="txtProductIn" type="text" class="text_box_large" id="txtProductIn" 
					        size="25" />
                            <div class="cl"></div>
							
                            <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
                            
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
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="Add" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>