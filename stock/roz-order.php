<?php
ob_start();
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");
require_once("../classes/adminLogin.class.php");
require_once("../classes/customer.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/product_stock.class.php"); 
require_once("../classes/product_order.class.php");
require_once("../classes/adv_search.class.php");

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders		    = new Orders();
$search_obj		= new Search();
$pages			= new Pagination();
$productOrder	= new Productorders();
$productStock	= new ProductStock();
$customer 		= new Customer();
$advSearch		= new AdvSearch();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
//$txtDesign		= $utility->returnGetVar('txtDesign','');
$type			= $utility->returnGetVar('type','');
$mode			= $utility->returnGetVar('mode','');
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 100);

if((isset($_POST['btnShowDtls'])))
	{
		$designNo					= $_POST['txtDesign'];
		$txtBookNo					= $_POST['txtBookNo'];
		$txtPartyCode				= $_POST['txtPartyCode'];
		$_SESSION['$txtDesign']  	=  $designNo;  
		$_SESSION['$txtBookNo']  	=  $_POST['txtBookNo'];
		$_SESSION['$txtPartyCode']  =  $_POST['txtPartyCode'];
    }


/* eof pagination*/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> Rozelle Orders Management</title>
<!-- Style -->
<link href="../style/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->
<!-- DataTables -->
  
<link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../style/bootstrap/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
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
                	<h1>Rozelle orders</h1>
					<div id="search-page-back">
                    </div>
                </div>
                 <div class="row"><!---row start -->
					<div class="col-lg-12">
					<!--Report form start-->   
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
						<div class="row"><!---row start -->
						
							<div class="col-lg-12">
								<div class="col-lg-2">
									<div class="form-group">
										<label>Design No.</label>
										<input type="text" id="txtDesign" name="txtDesign" class="form-control"
										value="<?php if((isset($_SESSION['txtDesign']))){ echo $_SESSION['txtDesign'];}else{} ?>" >
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
									
										<label>Book No.</label>
										<input type="text" id="txtBookNo" name="txtBookNo" class="form-control"
										value="<?php if((isset($_SESSION['$txtBookNo']))){echo $_SESSION['$txtBookNo'];};?>" >
									</div>
								</div>
								<div class="col-lg-1">
								OR
								</div>
								<div class="col-lg-2">
									<div class="form-group">
									
										<label>Party Code.</label>
										<input type="text" id="txtPartyCode" name="txtPartyCode" class="form-control"
										value="<?php if((isset($_SESSION['$txtPartyCode']))){echo $_SESSION['$txtPartyCode'];};?>" >
									</div>
								</div>
								<div class="col-lg-1">
									<label></label><br><br><br>
									<input  class="btn btn-primary" name="btnShowDtls" type='submit' value="Show details"  />
								</div>
							</div>
						</div><!---row end -->	
						
					</form>		
					<!--Report form end-->
					</div>
                </div><!---row end -->
                
				<!-- Options --><br><br><br><br>
                <div id="options-area">
                	Total Current Stock:<?php  $productStock->CurrentProdstockSum();?><br>
					Rozelle Orders: <a href="download_excel.php?table=product_orders">Download</a>
					Rozelle Orders Details(last 2 month): <a href="roz_orddtl_download.php">Download</a>
					Rozelle Orders Details(all): <a href="roz_orddtl_alldownload.php">Download</a>
					
					Rozelle Deliver Details: <a href="rozelle_deli_download.php">Download</a>
                </div>
                <!-- eof Options -->
                
                <!-- Display Data -->
                <div id="data-column">
                	
                    
                	<table class="single-column" cellpadding="0" cellspacing="0">
                
					<?php 
					if((isset($_SESSION['$txtDesign']) AND isset($_SESSION['$txtBookNo']) OR isset($_SESSION['$txtPartyCode'])))
					{
						$designNo					= $_SESSION['$txtDesign'];
						$txtBookNo					= $_SESSION['$txtBookNo'];
						$txtPartyCode				= $_SESSION['$txtPartyCode'];
						$_SESSION['$txtDesign']  	=  $designNo;  
						$_SESSION['$txtBookNo']  	=  $txtBookNo;
						$_SESSION['$txtPartyCode']  =  $txtPartyCode;
                    ?>  
                    <thead>
						<th width="3%" height="25"  align="center">Orders Id</th>
						<th width="10%" >Design No. </th>
						<th width="10%" >Book No. </th>
						<th width="10%" >Party Name</th>
						<th width="10%" >BroKar. </th>
						<th width="10%" >Retailer/Hol</th>
						<th width="10%" >Orders form</th>
						<th width="17%" > Orders Quantity & Colours Details </th>
						<th width="7%" >Due Quantity</th>
						<th width="7%" >Pay Quantity</th>
						<th width="15%" > Remarks</th>
						<th width="10%" > order date</th> 
						<th width="10%" > Target Date</th> 
						<th width="15%"  align="center"> status</th> 
                      <th width="25%" align="center">Action</th>
                   </thead>
					<?php
						if($txtPartyCode != ''){
							$orderDetail 	= $productOrder->getPartyWise($txtPartyCode);
						}else{
							$orderDetail 	= $productOrder->getProOrdBookWise($designNo,$txtBookNo);
						}
                        $k 				= $pages->getPageSerialNum($numResDisplay);
                        foreach($orderDetail as $eachRow)
                            {
							$RozorderDtl 	= $productOrder->ProdordersDtlDisp($eachRow['orders_id']);
							$bgColor 		= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
						<td align="center"><?php echo $eachRow['orders_id']; ?></td>
						<td align="center"><?php echo $eachRow['design_no']; ?></td>
						<td align="center"><?php echo $eachRow['book_no']; ?></td>
						<td align="center"><?php echo $eachRow['party_name']; ?></td>
						<td align="center"><?php echo $eachRow['brokar']; ?></td>
						<td align="center"><?php echo $eachRow['retahol']; ?></td>
						<td align="center"><?php echo $eachRow['form']; ?></td>
						<td align="center">
						<?php
							foreach($RozorderDtl as $record)
								{
						?>	
								<p href="#" 
								 onClick="MM_openBrWindow('order-color-edit.php?action=color_dtl&odtid=<?php echo $record['porder_dtl_id']; ?>','OrdAssign','scrollbars=yes,width=600,height=500')">
								 <?php echo $record['colour'];echo "->";echo $record['quantity'];?>
								</p> 
								<?php
								
								}
								 echo ';total->'; $productOrder->ProdQuantitySum($eachRow['orders_id']);	?>					  
					    </td>
						
						<td align="center"><?php $productOrder->ProdTotalQuantitySum($eachRow['orders_id']); ?></td>
						<td align="center">
							
							   <p href="#" 
								onClick="MM_openBrWindow('rozelle_deli_dtl.php?action=delivery_dtl&oid=<?php echo $eachRow['orders_id']; ?>','OrdAssign','scrollbars=yes,width=500,height=400')">
								<?php $productOrder->ProdTotalPayQtySum($eachRow['orders_id']); ?>
								</p>
						</td>
						
						
						<td align="center"><?php echo $eachRow['remark']; ?></td>
						<td align="center"><?php echo $eachRow['order_date']; ?></td>
						<td align="center"><?php echo $eachRow['target_date']; ?></td>
						<?php if($eachRow['status']=="open")
						{
						?>
							<td align="center" style="color:#87c540;"><?php echo $eachRow['status']; ?></td>
					 	<?php
						}
						elseif($eachRow['status']=="cancel"){
						?>
							<td align="center" style="color:red;"><?php echo $eachRow['status']; ?></td>
						<?php
							}else{
						?>	
							<td align="center" style="color:#9932CC;"><?php echo $eachRow['status']; ?></td>
					  
						<?php
						 }
						?>
						<td >
							[ 
								<p style="color: red;" 
							  onClick="MM_openBrWindow('rozelle_order_deliver.php?action=deliver_ord&oid=<?php echo $eachRow['orders_id']; ?>','OrdDeliver','scrollbars=yes,width=750,height=600')">
							  Deliver					  </p> ]
							  [ 
								<p style="color: red;" 
							  onClick="MM_openBrWindow('rozelle_order_cancel.php?action=cancel_ord&oid=<?php echo $eachRow['orders_id']; ?>','canceOrder','scrollbars=yes,width=750,height=600')">
							  Cancel					  </p> ]
							  
							  [ 
						</td>
				    </tr>
                  <?php 
                       
                        }
                  }
                  ?>
                  
                  </table>
                  
                  <div class="first-column">
                 
                    	<!-- Bottom Pagination-->
                        <div class="pagination-bottom">
                            <div class="upper-block">Total Order(s): <?php //echo count($oids);?></div>
                         <?php //echo $pagination ?>
                        </div>
                  	<?php $uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');?>
                  </div>
                </div>
                <!-- eof Display Data -->
                
                <div class="cl"></div>
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
     
</body>
</html>
