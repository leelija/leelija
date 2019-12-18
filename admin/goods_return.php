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
require_once("../classes/party.class.php");


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
$party			= new Party();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$sid			= $utility->returnGetVar('sid','0');

$userId			= $utility->returnSess('userid', 0);
$custDetails=$customer->getCustomerData($userId);
//echo $custDetails[5];
$stockDetails = $stock->showStock($sid);


if(isset($_POST['btnEditOrd']))
{	
	//$txtStockId 	        = $_POST['txtStockId'];
	$txtProductIn	 		= $_POST['txtProductIn'];//goods return
	$txtColour			    =$_POST['txtColour'];
	$txtProdDesc	 		= $_POST['txtProdDesc'];
	
	$PartyId				=$_POST['PartyId'];
	
	
	
	$txtStock			= $stockDetails[2];  //current stock
	
	$Sales				= $stockDetails[4];//  sales
	$net_sales			= $stockDetails[12] - $txtProductIn ;// Net Sales
	$totalGd			= $stockDetails[5] + $txtProductIn; // Total goods return
	
	
	
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
		$error->showErrorTA($action, $id, $id_var, $url, ERPROD018, $typeM, $anchor);
	}
	elseif($txtColour=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Choose the colour", $typeM, $anchor);
	}
	elseif($PartyId=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Choose the Party code", $typeM, $anchor);
	}
	
	else
	{
		//edit stock
		//	$stock->editStock($stockDetails[0],$stockDetails[1], $txtStock, $stockDetails[3], $Sales, $net_sales, $totalGd,
		//	$stockDetails[6], $stockDetails[7],'');
		//($stock_id,$design_no, $stock,$product_in, $sales, $net_sales, $goods_return,$remarks,$add_date, $modified_by)
	
		
		if($Sales != 0){
		//echo "hi";exit;
			$stockDetailsDtl  = $stock->stockDetailsDisplay();
			foreach($stockDetailsDtl as $eachrecord ){
				//echo $eachrecord['colour'];exit;
				//echo $eachrecord['design_no'];
				if($txtColour == $eachrecord['colour'] && $stockDetails[1] == $eachrecord['design_no'])
					{
					//echo "hi..99";exit;
						//$total_quantuty = $eachrecord['quantity'] - $txtProductIn; 
						$sales = $eachrecord['sales'] ;
						$netSales = $eachrecord['net_sales'] - $txtProductIn;//net sales
						$total_gdreturn = $eachrecord['quantity_return'] + $txtProductIn;
						if($netSales >= 0)
							{
								// add Gd Return
								$stock->addGreturn($stockDetails[0], $txtProductIn,$txtColour, $PartyId, $txtProdDesc,'', '');
		
								$stock->editStock($stockDetails[0],$stockDetails[1], $txtStock, $stockDetails[3], $Sales, $net_sales, $totalGd,
								$stockDetails[6], $stockDetails[7],'');
						
								// stock Details edit
								$stock->editstockDetails($eachrecord['stock_dtl_id'],$stockDetails[0],$stockDetails[1], $eachrecord['colour'], $eachrecord['quantity'],$eachrecord['quantity_in'],
								$sales,$netSales ,$total_gdreturn,'', '');
								//($stock_id, $design_no, $colour,$quantity,$quantity_in,$sales,$net_sales,$quantity_return, $added_by)
								//echo"Product Return table update";
					 
							}else { echo "Net Sales product less than your input values";exit;}
					 $uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], RPROD002, 'SUCCESS');
					 exit;
					}
					/*else {
							$stock->addstockDetails($stockDetails[0], $txtDesignNo, $txtColour, $txtProductIn, '', '');
					}*/
						
		
			}
		
		//echo "Product not Available in the current stock";exit;
		
		}
		else{
			echo "ERROR! (After sales you can try to GR) ";exit;
		}
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], RPROD002, 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  Goods return</title>

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
		
		
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=edit_sid&sid=<?php echo $sid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h1><a name="addUser">Goods Return</a></h1>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
							
							<h3>Design No:<?php echo $stockDetails[1] ?></h3>
                            <div class="cl"></div>
							
							
							
                            <label>Products Return(in pieces)<span class="orangeLetter">*</span></label>
                            <input name="txtProductIn" type="text" class="text_box_large" id="txtProductIn" 
					        size="25" />
                            <div class="cl"></div>
							
							<!--================show product details--========================-->
							<div style="color: red;"> Net Sales:
							<?php 					

							$stockDtlDetails         = $stock->stockDtlColor($sid);
							If(count($stockDtlDetails) == 0)
								{
								 echo "product not available";
								}
							?>	
							<?php $reco_record = 0; 
							//echo "$data[2]";
							foreach( $stockDtlDetails as $eachrecord ){
	
	
							//$bgColor 	= $utility->getRowColor($i);
							if($reco_record%2==0)
							$classname="evenRow";
							
								else
									$classname="oddRow";
  
								?>
								
								<?php echo $eachrecord['colour'];echo "->";echo $eachrecord['net_sales'];?>
								
				
								<?php 

								$reco_record++;
								} 
								?> 
							</div>
							<div class="cl"></div>		
					<!--================show product details end--========================-->	
								
							<div >
								<label>Product Colour<span class="orangeLetter">*</span></label>							
								
								<select name="txtColour" type="text" id="txtColour" class="text_box_large">
								<?php
								$pColourDetails         = $stock->ColourDisplay($stockDetails[1]);
								foreach ($pColourDetails as $row){//Array or records stored in $row
								//echo $row[colour_name];
								echo "<option value=$row[pcolour]>$row[pcolour]</option>"; 

								/* Option values are added by looping through the array */ 
									
								}

								 echo "</select>";//?>
							</div>
							<div class="cl"></div>
							<div >
								<label>Party Code<span class="orangeLetter">*</span></label>							
								
								<select name="PartyId" type="text" id="PartyId" class="text_box_large">
								<?php
								$customerDetails         = $party->partyDtl();
								foreach ($customerDetails as $row){//Array or records stored in $row
								//echo $row[colour_name];
								echo "<option value=$row[party_id]>$row[party_id]</option>"; 

								/* Option values are added by looping through the array */ 
									
								}

								 echo "</select>";//?>
							 </div>
                           
                            <div class="cl"></div>
							
                            
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
							
					
                            <div class="cl"></div>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="Goods Return" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>