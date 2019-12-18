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

require_once("../classes/rozelle_order.class.php");

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
$rozelleOrder			= new Rozelleorders();

$sample			= new Sample();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$oid			= $utility->returnGetVar('oid','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

$orderDetail = $rozelleOrder->showRozelleOrders($oid);
//echo $orderDetail[1];exit;
$designNo		= $orderDetail[1];
$stockDetails = $stock->showStockDesignwise($designNo);
//echo $stockDetails[0];exit;
//$totalQty		= $rozelleOrder->RozTotalQuantitySum($orderDetail[0]);

if(isset($_POST['btnEditOrd']))
{	
	$txtColour 	            = $_POST['txtColour'];
	$txtQuantity 	        = $_POST['txtQuantity'];
	$txtProdDesc 	        = $_POST['txtProdDesc'];
	//$selNum			= $_POST['selNum'];
    
	//$leftQuantity       =  $totalQty-$txtQuantity;//Due quantity
	//$payQuantity       = $orderDetail[13]+$txtQuantity;//Payment quantity
	
	$txtOrders 	        = $_POST['txtOrders'];
	
	
	//echo "hi..";exit;
	
	//echo $txtOrders;exit;
	//$orderDetail = $rozelleOrder->showRozelleOrders($txtOrders);
	//registering the post session variables
	
		$sess_arr	= array('txtColours','txtProdDesc');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'deliver_ord';
	$url		= $_SERVER['PHP_SELF'];
	//$oid			= 0;
	$id_var		= '';
	$anchor		= 'OrdDeliver';
	$typeM		= 'ERROR';
	
	
	$msg = '';


if($oid == '')
	{
		echo "";
	}
	
	
	else
	{
	
		
					
				
		
			  $stockDetailsDtl  = $stock->stockDetailsDisplay();
			foreach($stockDetailsDtl as $eachrecord ){
				//echo $eachrecord['colour'];
				//echo $eachrecord['design_no'];
				
				if($txtColour == $eachrecord['colour'] && $orderDetail[1] == $eachrecord['design_no'])
					{
						$total_quantity = $eachrecord['quantity'] - $txtQuantity; 
						$sales = $eachrecord['sales'] + $txtQuantity;
						$netSales = $sales - $eachrecord['quantity_return'];
						if($total_quantity >= 0){
						// stock Details edit
						//echo "hi";exit;
						
						//($stock_id, $design_no, $colour,$quantity,$quantity_in,$sales,$net_sales,$quantity_return, $added_by)
					
						$txtStock			= $stockDetails[2] - $txtQuantity;  //current stock
						$totalSales		= $txtQuantity + $stockDetails[4];// Total sales
						$net_sales		= $totalSales - $stockDetails[5];// Net Sales	
					
						
						
						// Rozelle order update
						
						$RozorderDtl  = $rozelleOrder->RozDeliverDtl();
						foreach($RozorderDtl as $eachrecordDeli ){
						//echo $eachrecord['colour'];
						//echo $eachrecord['design_no'];
						
						if($txtColour == $eachrecordDeli['colour'] && $orderDetail[0] == $eachrecordDeli['orders_id'])
							{
							$leftQuantity  = $eachrecordDeli['due_quantity']- $txtQuantity;
							$payQuantity	= $eachrecordDeli['pay_quantity']+$txtQuantity;
							
								if($leftQuantity >= 0){
														// update status of rozelle orders tables
														if($leftQuantity == 0)
														{
															$rozelleOrder->UpdateRozOrders($orderDetail[0],'closed');
														}
														
														
														
								$stock->editstockDetails($eachrecord['stock_dtl_id'],$stockDetails[0],$orderDetail[1], $eachrecord['colour'], $total_quantity,$eachrecord['quantity_in'],
						$sales,$netSales ,$eachrecord['quantity_return'],'', '');
						
									//edit stock
								$stock->editStock($stockDetails[0],$stockDetails[1], $txtStock, $stockDetails[3], $totalSales, $net_sales, $stockDetails[5],
								$stockDetails[6], $stockDetails[7],'');	
								
								// Rozelle orders update
								//$rozelleOrder->UpdateRozelleOrders($oid,$leftQuantity,$payQuantity);
								
								//product deliver
								$rozelleOrder->addRozOrderDeliver($oid,$orderDetail[14],$orderDetail[1],$orderDetail[2],$orderDetail[5],$txtQuantity,$txtColour,$txtProdDesc,'');
								echo "hi...1";
								
								// add sales
								$stock->addSales($orderDetail[1], $txtQuantity,$txtColour, $orderDetail[2], $orderDetail[5] ,'' , $txtProdDesc, '');
													
								echo "hi...2";						
														
								// update rozelle orders details
								$rozelleOrder->UpdateRozelleOrders($eachrecordDeli['rorder_dtl_id'],$leftQuantity,$payQuantity);
								}
								else{
									echo "Delivery Quantity greater than order quantity";exit;
								}
							}
						
						
						
						
						}
						
						
						
						
						
						
						
						
						
						$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], PRSALODOD001, 'SUCCESS');
						exit;
					
						}else { echo "Current Stock product less than your input values"; exit;}
					}
					/*else {
							$stock->addstockDetails($stockDetails[0], $txtDesignNo, $txtColour, $txtProductIn, '', '');
					}*/
						
		
			}
		
				
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Product has been successfully deliver", 'SUCCESS');
	}
}

if(isset($_POST['btnCancel']))
{
	$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Deliver page has been successfully close", 'SUCCESS');

}
?>

<title><?php echo COMPANY_S; ?> -  - Deliver Rozelle Order</title>

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
<script type="text/javascript" src="../js/rozelle_order.js"></script>
<script type="text/javascript" src="../js/roz_ord_deli.js"></script>


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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'deliver_ord') )
        {
             
            $orderDetail = $rozelleOrder->showRozelleOrders($oid);
        ?>
		
<!--<h3><a name="editStock">Rozelle order Deliver</a></h3>-->
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=deliver_ord&oid=<?php echo $orderDetail[0]; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2 style="padding-left:100px;"><a name="addUser">Rozelle order Deliver</a></h2>
					
                        <span style="padding-left:100px; color:blue;">Order Id:<?php echo $orderDetail[0];?> <span class="required"></span>Design No.:<?php echo $orderDetail[1];?></p></span>
                       <p style="padding-left:100px; color:blue;">Party Name:<?php echo $orderDetail[2];?></p>
					   <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
							
							
                            <div class="cl"></div>
							
						
							
							
						<div class="cl"></div>
					 <div >
							<label>Colour<span class="orangeLetter">*</span></label>							
							
							<select name="txtColour" type="text" id="txtColour" class="text_box_large">
							<?php
							$RozOrderDetails         = $rozelleOrder->RozordersDtlDisp($oid);
							
							foreach ($RozOrderDetails as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[colour]>$row[colour]</option>"; 

								
							}

							 echo "</select>";//    ?>    
							 </div>                  
							<div class="cl"></div>
        <div class="cl"></div>
		
						<!--================show orders details--========================-->
						<!--	<p>Order Details</p>  -->
							<div style="color: red;">
							<?php 					
							echo "Order Details:";
							$RozOrderDetails         = $rozelleOrder->RozordersDtlDisp($oid);
							If(count($RozOrderDetails) == 0)
								{
								 echo "product not available";
								}
							?>	
							<?php $reco_record = 0; 
							//echo "$data[2]";
							foreach( $RozOrderDetails as $eachrecord ){
	
	
							//$bgColor 	= $utility->getRowColor($i);
							if($reco_record%2==0)
							$classname="evenRow";
							
								else
									$classname="oddRow";
  
						?>
						
						<?php  //echo $eachrecord['colour'];echo "->";echo $eachrecord['due_quantity'];?>
						
					<?php echo $eachrecord['colour']; ?>
					 
					 <?php echo $eachrecord['due_quantity']; ?>
					 
				<!--	<input name="btnEditOrd" type="button"  value="deliver" style="width:60px;" onClick="rozelleOrder(<?php echo $eachrecord['rorder_dtl_id'];?>)" />
					-->	
        
						<?php 

						$reco_record++;
						} 
						?> 
					</div>
					<div class="cl"></div>		
					<!--================show orders details end--========================-->

					
					<input style="display:none;" name="txtOrders" type="text" class="text_box_large" id="txtOrders" 
					 value="<?php echo $eachrecord['orders_id']; ?>" size="25" />
                    <div class="cl"></div>	

					<!--================show product details--========================-->
						
							<div style="color: red;">
							<?php 					
							echo "Stock Details:";
							$StockDetails         = $stock->stockDtl($eachrecord['design_no']);
							If(count($StockDetails) == 0)
								{
								 echo "product not available";
								}
							?>	
							<?php $reco_record = 0; 
							//echo "$data[2]";
							foreach( $StockDetails as $eachrecord ){
	
	
							//$bgColor 	= $utility->getRowColor($i);
							if($reco_record%2==0)
							$classname="evenRow";
							
								else
									$classname="oddRow";
  
						?>
						
						<?php  echo $eachrecord['colour'];echo "->";echo $eachrecord['quantity'];?>
				
						<?php 

						$reco_record++;
						} 
						?> 
					</div>
					<div class="cl"></div>		
					<!--================show product details end--========================-->		
		
				<label>Quantity(In pieces)<span class="orangeLetter">*</span></label>
                     <input name="txtQuantity" type="text" class="text_box_large" id="txtQuantity" 
					 value="<?php echo $eachrecord['quantity']; ?>" size="25" />
                    <div class="cl"></div>	
					
				
				
				
				
				<div style="color:blue;" id="showRozOrd"></div>
				
				
				
				
				
				
				
				
				<!--			<tr>
									<label>Select No. of Colour</label>
									
									<td align="left" class="bodyText pad5">
									<?php 
						/*	       //gen number array
									$arr_value	= range(1,8);
									$arr_label	= range(1,8);
									?>
									  <select name="selNum" id="selNum" onchange="return getRozelleDeliver(<?php echo $orderDetail[0]; ?>);"
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
										}																	*/
										?>
									  </select>				    </td>
								  </tr>
								<div class="cl"></div>
								<div id="showRozelleDeliver"></div>
													
								-->					
							
							
                        <!--    
							 <div class="cl"></div>
							 <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php //$utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
                            <div class="cl"></div>
                                            
                            -->                                        
          <!--    <input name="btnEditOrd" type="button" class="button-add"  value="deliver" onClick="rozelleOrder(<?php echo $oid;?>)"/>  -->
				<input name="btnEditOrd" type="submit" class="button-add"  value="deliver" />
               
              <!--  <input name="btnCancel" type="submit" class="button-cancel" id="ref_butn" value="cancel" onClick="self.close()" />  -->
			 <!-- <input name="btnCancel" type="submit" class="button-cancel" id="ref_butn" value="cancel" />-->
			  <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
