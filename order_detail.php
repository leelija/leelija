<?php 
session_start();
include_once('checkSession.php');
include_once('../_config/connect.php');

require_once("../includes/constant.inc.php");
require_once("../includes/order.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../classes/email.class.php"); 
 
require_once("../classes/error.class.php"); 
require_once("../classes/customer.class.php");
require_once("../classes/countries.class.php");
require_once("../classes/cart.class.php");
require_once("../classes/order.class.php");
require_once("../classes/product.class.php");
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/tax.class.php");
require_once("../classes/shipping.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$client		    = new Customer();
$country		= new Countries();
$cart			= new Cart();
$order			= new Order();
$product		= new Product();
$search_obj		= new Search();
$page			= new Pagination();
$tax			= new Tax();
$shipping		= new Shipping();
$emailObj		= new Email();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

if(!isset($_GET['code']) || !isset($_GET['id']))
{
	header("Location: order.php");
}
else
{
	$code = $_GET['code'];
	$id   = $_GET['id'];
}

//ODER DETAIL
$orderDtl  = $order->getOrderDetail($code,$id);

//post and update notification data
if(isset($_POST['btnNotify']))
{
	$orders_id				= $_POST['orders_id']; 
	$customer_notify		= $_POST['customer_notify'];
	$orders_status_id		= $_POST['orders_status_id'];
	$comments				= $_POST['comments'];
	
	if(($orders_id == '') || ($orders_status_id == ''))
	{
		header("Location: ".$_SERVER['PHP_SELF']."?action=view&code=".$_GET['code']."&id=".$_GET['id']."&msg=You have missed some important fields");
	}
	else
	{
		
		$order->insertNotify($orders_id,  $customer_notify,  $orders_status_id,  $comments);
		
		if($customer_notify == 1)
		{
			$toName  = $_POST['toName'];
			$toEmail = $_POST['toEmail'];
            $subject	= $utility->getValueByKey($orders_status_id, 'orders_status_id', 'orders_status_name','orders_status');
                         
			#Sending mail
			$emailObj->cusNotifyOrdStat($toEmail,$toName,$subject,$comments); 
			#end of sending mail
		}
		header("Location: ".$_SERVER['PHP_SELF']."?action=view&code=".$_GET['code']."&id=".$_GET['id']);
	}
}




$shipDtl=$shipping->showShipDisplay();

$ordDtl=$order->getOrderDisplay($id);
$ordDetails=$order->getOrdProductDetail($id);
$ordDetailsDtl=$order->getOrdProductDisplay($id);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Order Detail</title>
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
<!-- eof JS Libraries -->

</head>

<body> 

	
    <!-- Header -->
	<?php require_once('header.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<div id="admin-menu">
				<?php require_once('menu.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                <div id="admin-top">
                	<h1>Order Detail</h1>
                </div>
                
                <!-- Options -->
                <div id="options-area">
                	 <h3>Order Code: <?php echo $_GET['code']; ?></h3>
                </div>
                <!-- eof Options -->
               
                <!-- Display Data -->
                <!--<div id="data-column">-->
                	
                 <div id="data-column">
                    <table class="second-column-order" cellpadding="0" cellspacing="0">
                    <?php 
					   if( (isset($_GET['action'])) && ($_GET['action'] == 'view') )
					   {
						 
					?> 
                    
                  <!--  <div class="shipping-detail-block">-->
                   <tr>
                   	<td>
                       
                        This order was placed on: <?php echo $dateUtil->printDate2($orderDtl[16])." at ".substr($orderDtl[16],10); ?>
                        
                    </td>
                   </tr>
                 <tr>
				  <td align="left" class="blackLarge padT10" colspan="2">
				  <?php //$regDtl = $client->getCustomerData($orderDtl[1]); ?>
					<div style="height:15px; ">Customer Name : <?php echo $orderDtl[4]; ?>	</div>
					<div style="height:15px; ">Telephone No : &nbsp;&nbsp;&nbsp;<?php echo  $orderDtl[8];?>	</div>
					<div style="height:15px; ">E-Mail Address : &nbsp;&nbsp;<?php echo "<a href='mailto:".$orderDtl[25]."'>".$orderDtl[25]."</a>"; ?>	</div>
                   <!-- <div style="height:auto; "><strong>Additional Remarks</strong> :<br /><br /><?php //echo stripslashes($orderDtl[29]); ?></div>-->
				  </td>
                 </tr>
                  <tr align="left">
                  <td width="50%" height="20" class="menuText padT15"><h4>Shipping Detail ::</h4></td>
                  <td width="50%" height="20" class="menuText padT15"><h4>Billing Detail ::</h4></td>
                  <!-- <td width="25%" height="20"><strong>Last Login </strong></td> -->
                  </tr>     
                  <!--</div>-->
                  
                  <tr align="left" class="bodyText">
					  <td height="20" valign="top" class="bodyText padL10">
					  <!-- CUSTOMER SHIPPING DETAIL -->
					  <div style="height:15px; " class="padT10"><?php echo $orderDtl[4]; ?></div>
					  <div style="height:15px; "><?php echo $orderDtl[12]; ?></div>
					  <?php if($orderDtl[5] != ''){?><div style="height:15px; "><?php echo $orderDtl[5]; ?></div><?php }?>
					  <div style="height:15px; "><?php echo $orderDtl[6]; ?></div>
					  <?php if($orderDtl[9] != ''){?> <div style="height:15px; "><?php echo $orderDtl[9]; ?></div><?php }?>
					  <?php if($orderDtl[10] != ''){?> 
					  	<div style="height:15px; ">
					  	<?php
							echo $orderDtl[8]; ?>
						 </div>
					  <?php }?>
					  <?php if($orderDtl[10] != ''){?> <div style="height:15px; "><?php echo "Post Code: ".$orderDtl[10]; ?></div><?php }?>
					  <?php if($orderDtl[11] != ''){?> <div style="height:15px; "><?php echo "Phone: ".$orderDtl[11]; ?></div><?php }?>
					  
					  </td>
					  <!-- END OF CUSTOMER SHIPPING DETAIL -->
					  <!-- CUSTOMER BILLING DETAIL -->
					  <td valign="top" class="bodyText padL10">
					   <div style="height:15px; " class="padT10"><?php echo $orderDtl[12]; ?></div>
					  <div style="height:15px; "><?php echo $orderDtl[4]; ?></div>
					  <?php if($orderDtl[5] != ''){?><div style="height:15px; "><?php echo $orderDtl[5]; ?></div><?php }?>
					  <div style="height:15px; "><?php echo $orderDtl[6]; ?></div>
					  <?php if($orderDtl[9] != ''){?> <div style="height:15px; "><?php echo $orderDtl[9]; ?></div><?php }?>
					  <?php if($orderDtl[10] != ''){?> 
					  	<div style="height:15px; ">
					  	<?php
							echo $orderDtl[8]; ?>
						 </div>
					  <?php }?>
					  <?php if($orderDtl[10] != ''){?> <div style="height:15px; "><?php echo "Post Code: ".$orderDtl[10]; ?></div><?php }?>
					  <?php if($orderDtl[11] != ''){?> <div style="height:15px; "><?php echo "Phone: ".$orderDtl[11]; ?></div><?php }?>
					   </td>
					   <!-- END OF CUSTOMER BILLING DETAIL -->
					  </tr>
                 
                  </table>
                  
                  
                 
                 <table class="single-column" cellpadding="0" cellspacing="0">
                
                    <thead>
                      <th width="28%">Product</th>
					  <th width="12%">Quantity</th>
					  <th width="12%" align="center">Price</th>
					  <th width="29%">Subtotal</th>
                    </thead>
					<?php 
						$orderDtl  = $order->getOrderDetail($code,$id);
						//print_r($ordProdId);exit;
                        $subtotal		= 0;
                       /* $taxDetail		= $tax->showTax(1);
                        $shippingDetail = $shipping->showShipping(1);*/
                        $ordDetailsDtl=$order->getOrdProductDisplay($orderDtl[0]);

                        $rc	= 1;
                        
                        
                        foreach($ordDetailsDtl as $record)
                        {
							$product_id = $record['orders_products_id'];
							$productDtl=$product->showProduct($product_id);
							
							
                            //print_r($ordProdDtl);exit;
                            //get row color
                            $bgColor 	= $utility->getRowColor($rc);
							
							//$option	= $order->getOption($record);
							//print_r($option);
                       ?>
                        <tr align="left" <?php $utility->printRowColor($bgColor);?>>
                         <td>
                         <a href='#' onClick="MM_openBrWindow('product_detail.php?action=view_prod&id=<?php echo $productDtl[13]; ?>','ProductDetail','scrollbars=yes,width=600,height=550')">
                         <?php echo "".$productDtl[1]."<br />Product Id #".$productDtl[13].""; ?></a>
                         </td>
                         
						<td align="center"><?php echo "1"; ?></td>						
                         
                         <td><?php echo $productDtl[14]; ?></td>
                         <td><?php echo $productDtl[14]; ?></td>
                        </tr>
					  <?php 
                          $subtotal	+= 1*$productDtl[14];
                            $rc++;
                      }
                      ?>
                  
                  </table>
                 
                 
                    
                  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
				 
                    <tr>
                      <td align="right" style="padding-right:10px; "><span class="blackSmall">Sub Total</span></td>
                      <td width="29%" align="left" style="padding-left:5px; "><span class="blackSmall"><?php echo $subtotal ?></span></td>
                    </tr>
                    <tr>
                      <!--<td align="right" style="padding-right:10px; "><span class="blackSmall">Shipping @ <?php //echo $shipDtl[0]."%"; ?></span></td>-->
                      <td align="left" style="padding-left:5px; "><span class="blackSmall"><?php echo $shipDtl[0] ;?></span></td>
                    </tr>
                    <tr>
                      <td align="right" style="padding-right:10px; "><span class="blackSmall">Postage and Handling</span></td>
                      <td align="left" style="padding-left:5px; "><span class="blackSmall"><?php echo $shipDtl[0] ;?></span></td>
                    </tr>
                    <tr>
                      <td align="right" style="padding-right:10px; "><span class="blackSmall"><strong>Total</strong></span></td>
                      <td align="left" style="padding-left:5px; "><span class="blackSmall"><strong><?php echo $subtotal+$shipDtl[0] ;?></strong></span></td>
                    </tr>
                  </table>
                  
                  <div id="admin-top">
                	<h2>Customer Notification</h2>
                  </div>
                  
                  <table class="single-column" cellpadding="0" cellspacing="0">
                
					<?php 
					$notifyId = $order->getNotifyId($orderDtl[0]);
					if(count($notifyId) == 0)
					{
						echo "<tr>
					    <td height='25' colspan='4' class='orangeLetter'>The customer is not notified yet.</td>
					    </tr>";
					
					?>
                    <tr align="left" class="orangeLetter">
                      <td height="20" colspan="5"> <?php echo 'No Notification has found'; ?> </td>
                    </tr>
                    <?php 
                    }
                    else
                    {
                    ?>  
                    <thead>
						<th width="22%" height="25" class="pad10 bdrBGy"><strong>Date Added </strong></th>
						<th width="25%" height="25" align="center" class="pad10 bdrBGy"><strong>Customer Notified </strong></th>
						<th width="19%" height="25" class="pad10 bdrBGy"><strong>Status</strong></th>
						<th height="25" class="pad10 bdrBGy"><strong>Comments</strong></th>
				    </thead>
                    <?php
						foreach($notifyId as $n)
						{ 
							$notifyDtl = $order->getNotifyDetail($n);
					?>
                    <tr>
                    <td><?php echo $notifyDtl[2]; ?></td>
                    <td>
                    <?php 
                    if($notifyDtl[0] == 1) {echo  "<img src=\"../images/site/check_yes.gif\" width='20' height='20'>";}
                    else {echo "not notified";}
                     ?></td>
                    <td><?php echo $notifyDtl[4]; ?></td>
                    <td><?php echo $notifyDtl[3]; ?></td>
                    </tr>
                  <?php 
                        }
                  }
                  ?>
                  
                  </table>
                  
                </div>
                <!-- eof 1st data column-->
                <div class="cl"></div>
                
                <!-- Form -->
                <div class="webform-area">
                    
                         <form name="formNotify" method="post" action="<?php echo $_SERVER['PHP_SELF']."?action=view&code=".$_GET['code']."&id=".$_GET['id']; ?>">
                        	
                            <label>Status: </label>
                            <select name="orders_status_id" class="textBoxA">
							  <?php $utility->populateDropDown($orderDtl[21], 'orders_status_id', 'orders_status_name', 'orders_status');?>
                            </select>
                            <div class="cl"></div>
                            
                            <label>Notify Customer: </label>
                            <div class="fl padL20">
                      		<input type="checkbox" name="customer_notify" value="1" checked></td>
                        	</div>
                             <div class="cl"></div>
                                
                            <label>Comments: </label>
                            <textarea name="comments" cols="45" rows="5" class="textArBG"></textarea>
                            <div class="cl"></div>
                            
                           / <input name="toName" type="hidden" value="<?php //echo $regDtl[1]." ".$regDtl[2]; ?>" />
					  		<input name="toEmail" type="hidden" value="<?php //echo $regDtl[0]; ?>"/>
					  		<input name="orders_id" type="hidden" value="<?php //echo $orderDtl[0]; ?>"/>
                         
                            <input name="btnNotify" type="submit" class=" buttonYellow" id="btnNotify" value="update"/>
						</form>
                        
                   
                   <?php 
				}//if
			
			  ?>
                     
                </div>
                <div class="cl"></div>
                <!-- eof Form -->
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php require_once('footer.inc.php'); ?>
     
</body>
</html>