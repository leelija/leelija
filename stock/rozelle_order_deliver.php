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
require_once("../classes/product_stock.class.php"); 
require_once("../classes/sample.class.php");
require_once("../classes/product_order.class.php");
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
$productStock	= new ProductStock();
$productOrder	= new Productorders();
$fabric			= new Fabric();
$customer		= new Customer();
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

$orderDetail 	= $productOrder->showProdOrders($oid);
//echo $orderDetail[1];exit;
$designNo		= $orderDetail[1];
$stockDetails 	= $productStock->showPStockDesignwise($designNo);

if((isset($_POST['btnCancel'])))
{

	//registering the post session variables
	$sess_arr	= array('oid');
	
	//defining error variables
	$action		= 'deliver_ord';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $oid;
	$id_var		= '';
	$anchor		= 'OrdDeliver';
	$typeM		= 'ERROR';
	$msg = '';
	
	//deleting the sessions
	$utility->delSessArr($sess_arr);
	
	$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Are You sure want to cancel?", 'SUCCESS');
	//header("Location: rozelle_order.php#");
}
//echo $stockDetails[0];exit;
//$totalQty		= $rozelleOrder->RozTotalQuantitySum($orderDetail[0]);

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
             
            $orderDetail 	= $productOrder->showProdOrders($oid);
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
							$RozOrderDetails         = $productOrder->ProdordersDtlDisp($oid);
							
							foreach ($RozOrderDetails as $row){//Array or records stored in $row
							//echo $row[colour_name];
							?>
							<option value="<?php echo $row['colour'];?>"><?php echo $row['colour'];?></option>

							<?php	
							}

							 echo "</select>";//    ?>    
					</div>                  
							<div class="cl"></div>
							<div class="cl"></div>
		
						<!--================show orders details--========================-->
							<div>
							<?php 					
							echo "Order Details:";
							$RozOrderDetails         = $productOrder->ProdordersDtlDisp($oid);
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
						
					<span style="color: red;"><?php echo $eachrecord['colour']; ?></span>
					 
					 <span style="color: black;"><?php echo $eachrecord['due_quantity']; ?></span>
					 
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
						
							<div>
							<?php 					
							echo "Stock Details:";
							$StockDetails         = $productStock->ProdstockDtlDes($eachrecord['design_no']);
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
						
						<span style="color: red;"><?php  echo $eachrecord['colour'];?></span> <span style="color: black;"><?php echo "->";echo $eachrecord['quantity'];?></span>
				
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
				
				<div style="color:blue;" id="showProdOrd"></div>
				
				
			  <input type="button" class="button-add"  value="deliver" onClick="prodOrdDeli(<?php echo $oid;?>)"/>
			  <!--<input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />-->
			  <input name="btnCancel" type="submit" class="button-cancel" value="cancel"/>
        	</form>
    
        <?php 
        }
        ?>
    </div>

<script>
function prodOrdDeli(oid)
{
  // alert("1 Hi..");
	var oid	= oid
	var txtColour   = document.getElementById("txtColour").value;
	var txtQuantity = document.getElementById("txtQuantity").value;
	//alert(txtColour);
	var url= "roz_ord_deli.php?oid=" + escape(oid)+ "&txtColour=" + escape(txtColour) + "&txtQuantity=" + escape(txtQuantity);
	//alert(url);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDeliProdOrder;
	
	//writing response while verifying
/*	document.getElementById('showRozelleDeliver').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	*/
	//send the request
	request.send(null);
}

function getDeliProdOrder()
{
//	alert("here..");
	if(request.readyState == 4)
	{
		//alert("2 hi");
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			document.getElementById("showProdOrd").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		else
		{
			alert("Error: Status Code is " + request.statusText);
		}
	}
}//eof

</script>