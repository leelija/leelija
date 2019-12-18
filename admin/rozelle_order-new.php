<?php
ob_start();
session_start();
?>
<?php 
//session_start();
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
require_once("../classes/rozelle_order.class.php");

require_once("../classes/stock.class.php"); 
require_once("../classes/adv_search.class.php");


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
$advSearch		= new AdvSearch();


$rozelleOrder			= new Rozelleorders();
$stock			= new Stock();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$keyword		= $utility->returnGetVar('keyword','');
$type			= $utility->returnGetVar('type','');
$mode			= $utility->returnGetVar('mode','');
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 100);


$rOrdersDtls 	= $rozelleOrder->RozordersShow();

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

<!--   multi filter -->
<script src='../js/multifilter.js'></script>
<script src="../js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="../js/jquery.dataTables.yadcf.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
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
                   <div class="cl"></div>
				</div>
                <!-- Options -->
                <div id="options-area">
                <!--	<div class="add-new-option">
                    	<a href="<?php echo "product_order_add.php"."?action=add_ord"; ?>">
                            Add New orders
                        </a> 
                    </div>-->
					<br><br>
					Rozelle Orders: <a href="roz_ord_download.php">Download</a>
					Rozelle Orders Details: <a href="roz_orddtl_download.php">Download</a>
					Rozelle Deliver Details: <a href="rozelle_deli_download.php">Download</a>
					<div class="cl"></div>
					<?php //echo ';total Order Quantity->'; $rozelleOrder->RozQuantitySum($orderDetail[0]);	?>
                </div>
                <!-- eof Options -->
                <div class="header-title" style="height:20px;">
					<h2 style="float:left;">[[Total Current Stock:<?php  $stock->CurrentstockSum();?>]]</h2>&nbsp;&nbsp;
					<h2 style="float:left;">[[Total Due Rozelle Order:<?php  $rozelleOrder->DueRozelleOrder();?>]]</h2>
				</div>
                 <div class="padT30"><!-- --> </div> 
				 <br><br>
				<div id="PrintForm"> 
                <!-- Display Data -->
                <div id="data-column">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0">
                
					<?php 
					if(count($rOrdersDtls) == 0)
					{
					?>
                    <tr align="left" class="orangeLetter">
                      <td height="20" colspan="5">  <?php echo "No Orders Has Been Added So Far."; ?> </td>
                    </tr>
                    <?php 
                    }
                    else
                    {
                    ?>  
                    <thead>
                      <th width="3%" height="25"  align="center">Orders Id</th>
                      <th width="10%" >Design No. </th>
					  <th width="10%" >Book No. </th>
                     <th width="10%" >Party Name</th>
					  <th width="10%" >BroKar. </th>
                     <th width="10%" >Retailer/Hol</th>
                      <th width="10%" >Orders form</th>
                     <!-- <th width="10%" >Order Quantity</th>
                      <th width="7%" >Order Colours </th>-->
					  <th width="17%" > Orders Quantity & Colours Details </th>
					  
					  <th width="7%" >Due Quantity</th>
					  <th width="7%" >Pay Quantity</th>
					  <th width="15%" > Remarks</th>
					 <th width="10%" > order date</th> 
					 <th width="10%" > Target Date</th> 
					  <th width="15%"  align="center"> status</th> 
					 <!-- <th width="5%"  align="center">Assign Job </th> -->
                      <th width="25%" align="center">Action</th>  
                   </thead>
					<?php
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                    //   $oids = array_slice($oids, $start, $limit);     
                        foreach($rOrdersDtls as $eachRecord)
                            {
							//$x = $pageArray[$pageNumber][$j];
							//$orderDetail = $rozelleOrder->showRozelleOrders($x);
							//print_r($orderDetail);exit;
							$RozorderDtl = $rozelleOrder->RozordersDtlDisp($eachRecord['orders_id']);
							
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					  <td align="center"><?php echo $eachRecord['orders_id']; ?></td>
					  <td align="center"><?php echo $eachRecord['design_no']; ?></td>
					  <td align="center"><?php echo $eachRecord['book_no']; ?></td>
					   <td align="center"><?php echo $eachRecord['party_name']; ?></td>
					   <td align="center"><?php echo $eachRecord['brokar']; ?></td>
					   <td align="center"><?php echo $eachRecord['retahol']; ?></td>
					    <td align="center"><?php echo $eachRecord['form']; ?></td>
						<!--<td align="center"><?php //echo $orderDetail[6]; ?></td>
					    <td align="center"><?php //echo $orderDetail[7]; ?></td>-->
						<td align="center">
							[ 
						  
								<a href="#" 
								onClick="MM_openBrWindow('rozelle_order_dtl.php?action=color_dtl&oid=<?php echo $eachRecord['orders_id']; ?>','OrdAssign','scrollbars=yes,width=500,height=400')">
								<?php
								foreach($RozorderDtl as $record)
								{
								 echo $record['colour'];echo "->";echo $record['quantity'];
								}
								 echo ';total->'; $rozelleOrder->RozQuantitySum($eachRecord['orders_id']);	?>					  
								
								
								</a> ]
					    </td>
						<td align="center"><?php $rozelleOrder->RozTotalQuantitySum($eachRecord['orders_id']); ?></td>
						<td align="center">
							
							   <a href="#" 
								onClick="MM_openBrWindow('rozelle_deli_dtl.php?action=delivery_dtl&oid=<?php echo $eachRecord['orders_id']; ?>','OrdAssign','scrollbars=yes,width=500,height=400')">
								<?php $rozelleOrder->RozTotalPayQtySum($eachRecord['orders_id']); ?>
								</a>
							
						</td>
						
						<td align="center">
							<a href="#" 
								onClick="MM_openBrWindow('roz_deli_remark_edit.php?action=delivery_edit&oid=<?php echo $eachRecord['orders_id']; ?>','OrdAssign','scrollbars=yes,width=700,height=600')">
								<?php echo $eachRecord['remark']; ?>|edit|
							</a>
						</td>
						 <td align="center"><?php echo $eachRecord['order_date']; ?></td>
						  <td align="center"><?php echo $eachRecord['target_date']; ?></td>
						<?php if($eachRecord['status']=="open")
						{
						?>
							<td align="center" style="color:#87c540;"><?php echo $eachRecord['status']; ?></td>
					 	<?php
						}
						elseif($eachRecord['status']=="cancel"){
						?>
							<td align="center" style="color:red;"><?php echo $eachRecord['status']; ?></td>
						<?php
							}else{
						?>	
							<td align="center" style="color:#9932CC;"><?php echo $eachRecord['status']; ?></td>
					  
						<?php
						 }
						?>
					  
					 
					  <td >
					  
				<!--	  [ 
					    <p style="color: red;" 
					  onClick="MM_openBrWindow('rozelle_deliver.php?action=deliver_ord&oid=<?php echo $eachRecord['orders_id']; ?>','OrdDeliver','scrollbars=yes,width=750,height=600')">
					  Deliver					  </p> ]
					  
					-->
					[ 
					    <p style="color: red;" 
					  onClick="MM_openBrWindow('rozelle_order_deliver.php?action=deliver_ord&oid=<?php echo $eachRecord['orders_id']; ?>','OrdDeliver','scrollbars=yes,width=750,height=600')">
					  Deliver					  </p> ]
					  [ 
					    <p style="color: red;" 
					  onClick="MM_openBrWindow('rozelle_order_cancel.php?action=cancel_ord&oid=<?php echo $eachRecord['orders_id']; ?>','OrdCancel','scrollbars=yes,width=750,height=600')">
					  Cancel					  </p> ]
					  
					  [ 
			<!--		    <a style="color: red;" href="#" 
					  onClick="MM_openBrWindow('rozelle_order_delete.php?action=rozelle_ord&oid=<?php echo $eachRecord['orders_id']; ?>','OrdDelete','scrollbars=yes,width=750,height=600')">
					  Delete					  </a> ]   -->
					 
					 
					  
                      					  </td>
				    </tr>
                  <?php 
                       
                        }
                  }
                  ?>
                  
                  </table>
                  
                  <div class="first-column">
                 
                    	<!-- Bottom Pagination-->
                    <!--    <div class="pagination-bottom">
                            <div class="upper-block">Total Order(s): <?php //echo count($oids);?></div>
                         <?php echo $pagination ?>
                        </div>-->
                  	<?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                  </div>
                </div>
                <!-- eof Display Data -->
                </div>
                <div class="cl"></div>
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
	
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.12.0.min.js"></script>

-->	
<script>
  $(function () {
    $("#example").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>	
		
     
</body>
</html>
                                                                                                    