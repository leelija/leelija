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
require_once("../classes/sample.class.php"); 

require_once("../classes/order.class.php"); 
require_once("../classes/product_stock.class.php"); 
require_once("../classes/product_order.class.php");

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
$sample			= new Sample();

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

//Customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);

$orderDetail	= $productOrder->ProdordersShowLastTwoMonth();


/* eof pagination*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Rozelle Order Maintenance</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- DataTables -->
  
<link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../style/bootstrap/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

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


<script type='text/javascript'>
    //<![CDATA[
      $(document).ready(function() {
        $('.filter').multifilter()
      })
    //]]>
  </script>
  
 <script>
$(document).ready(function(){
  $('#example').dataTable().yadcf([
		{column_number : 8,  filter_type: "range_date", filter_container_id: "filterDate"}
	
		]);
});
</script>	 
  
  
<script>
 $(document).ready(function(){
     $('#example').dataTable()
		  .columnFilter({ 	sPlaceHolder: "head:before",
					aoColumns: [ 	{ type: "text" },
				    	 		{ type: "text" },
                                { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
								//{ type: "date-range" }
								
						]

		});
}); 


</script>

  
  


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
                	<h1>Rozelle Order Management</h1>
                 <!--   
                    <div id="search-page-back">
                    	<form name="formAdvSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                           
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="search" />
                        </form>
                    </div>
				-->	
                   <div class="cl"></div> 
                </div>
                
                <!-- Options --><br><br><br><br>
                <div id="options-area">
                	Total Current Stock:<?php  $productStock->CurrentProdstockSum();?><br>
					Rozelle Orders: <a href="download_excel.php?table=product_orders">Download</a>
					Rozelle Orders Details(last 2 month): <a href="roz_orddtl_download.php">Download</a>
					Rozelle Orders Details(all): <a href="roz_orddtl_alldownload.php">Download</a>
					
					Rozelle Deliver Details: <a href="rozelle_deli_download.php">Download</a>
                </div>
                <!-- eof Options -->
				
				<div class="header-title" style="height:20px;">
					
				</div>
				<br><br>			
              <div class="padT30"><!-- --> </div> 
               <div id="PrintForm">

                <!-- Display Data -->
                <div id="data-column" style="position:relative; bottom: 90px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						if(count($orderDetail) == 0)
						{
						?>
                        <tr align="left" class="orangeLetter">
                          <td height="20" colspan="5"> <?php echo "Table is empty"; ?></td>
                         </tr>
                        <?php 
                        }
                        else
                        {
                        ?>  
                        <thead>
						<tr>
							<th width="3%" height="25"  align="center">Sl No</th>
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
							<th width="5%"  align="center">Factory</th>
							<th width="15%"  align="center"> status</th> 
							<th width="25%" align="center">Action</th>  
						</tr>  
                        </thead>
						<tbody>
                       <?php 
                        $sl=1;
	                       
                        foreach($orderDetail as $eachRecord)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							//$stockDetail = $stock->showStock($x);
							//print_r($prodDetail);exit;
							$orderDate			= date_create($eachRecord['order_date']);
							$targetDate			= date_create($eachRecord['target_date']);
							
							$RozorderDtl 		= $productOrder->ProdordersDtlDisp($eachRecord['orders_id']);
							//factory details
							$factoryDtls 		= $sample->showFactory($eachRecord['factory_id']);
							
							$bgColor 			= $utility->getRowColor($sl);	
							
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
						<td align="center"><?php echo $sl; ?></td>
						<td align="center"><a href=""><?php echo $eachRecord['design_no']; ?></a></td>
						<td align="center"><?php echo $eachRecord['book_no']; ?></td>
						<td align="center"><?php echo $eachRecord['party_name']; ?></td>
						<td align="center"><?php echo $eachRecord['brokar']; ?></td>
						<td align="center"><?php echo $eachRecord['retahol']; ?></td>
						<td align="center"><?php echo $eachRecord['form']; ?></td>
						<td align="center">
						<?php
							foreach($RozorderDtl as $record)
								{
						?>	
								<p href="#" 
								 onClick="MM_openBrWindow('order-color-edit.php?action=color_dtl&odtid=<?php echo $record['porder_dtl_id']; ?>','OrdAssign','scrollbars=yes,width=400,height=300')">
								 <?php echo $record['colour'];echo "->";echo $record['quantity'];?>
								</p> 
								<?php
								
								}
								 echo ';total->'; $productOrder->ProdQuantitySum($eachRecord['orders_id']);	?>					  
					    </td>
						<td align="center"><?php $productOrder->ProdTotalQuantitySum($eachRecord['orders_id']); ?></td>
						<td align="center">
							
							   <p href="#" 
								onClick="MM_openBrWindow('rozelle_deli_dtl.php?action=delivery_dtl&oid=<?php echo $eachRecord['orders_id']; ?>','OrdAssign','scrollbars=yes,width=600,height=500')">
								<?php $productOrder->ProdTotalPayQtySum($eachRecord['orders_id']); ?>
								</p>
							
						</td>
						<td align="center">
							<a href="#" 
								onClick="MM_openBrWindow('roz_deli_remark_edit.php?action=delivery_edit&oid=<?php echo $eachRecord['orders_id']; ?>','OrdAssign','scrollbars=yes,width=700,height=600')">
								<?php echo $eachRecord['remark']; ?>|edit|
							</a>
						</td>
						<td align="center"><?php echo date_format($orderDate,"m/d/Y"); ?></td>
						<td align="center"><?php echo date_format($targetDate,"m/d/Y"); ?></td>
						<td align="center"><?php echo $factoryDtls[1]; ?></td>
						
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
							
							  <p href="#" style="color: red;" 
							  onClick="MM_openBrWindow('rozelle_order_deliver.php?action=deliver_ord&oid=<?php echo $eachRecord['orders_id']; ?>','OrdDeliver','scrollbars=yes,width=750,height=600')">
							  Deliver					  </p> 
							  
							  <p style="color: red;" 
							  onClick="MM_openBrWindow('rozelle_order_cancel.php?action=cancel_ord&oid=<?php echo $eachRecord['orders_id']; ?>','canceOrder','scrollbars=yes,width=750,height=600')">
							  Cancel					  </p> 
							  
							  <p style="color: red;" 
							  onClick="MM_openBrWindow('order_product_rate.php?action=rate_ord&oid=<?php echo $eachRecord['orders_id']; ?>','canceOrder','scrollbars=yes,width=750,height=600')">
							  Add Rate					  </p> 
						</td>
						
				     </tr>
                      <?php 
						$sl++;
                            }
                      }
                      ?>
					</tbody>  
                  </table>
                     
					<a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>
		

					 
                    <div class="first-column">
                 
                    	<!-- Bottom Pagination-->
                     <!--   <div class="pagination-bottom">
                            <div class="upper-block">Total Report: <?php echo count($sid);?></div>
                            <div class="lower-block"><?php //$pages->getPage($numPages, $link, $pageNumber, $pageArray);?>
                            </div>
							<?php //echo $pagination ?>
                        </div>  -->
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
	
	<!--Used for print-->
	<script type="text/javascript">     
        function PrintDiv() {    
           var PrintForm = document.getElementById('PrintForm');
           var popupWin = window.open('', '_blank', 'width=800,height=800');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + PrintForm.innerHTML + '</html>');
           popupWin.document.close();
                }
    </script>

	<!--end print process-->

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