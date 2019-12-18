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
require_once("../classes/product_stock.class.php"); 
require_once("../classes/roz-stock.class.php"); 
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

$productStock	= new ProductStock();
$rozStock		= new RozStock();


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

$stockProdDetail= $productStock->stockProdDetailsDisplay();
$sStock			= $rozStock->RozStockShow();
$sids 			= $rozStock->getAllRStock('stock_id', 'DESC');
//echo count($sids);exit;

$total 			= (int)count($sids);
//Stock Update
if(isset($_POST['btnUpdate']))
{
	$newStock = array();
	
	foreach($sids as $k)
	{
		
		$newStock[$k] = $_POST['newStock'.$k];
		
		//echo $newStock[$k]."<br>";
		if($newStock[$k] != '')
		{
			$utility->updateField($k, 'stock_id', (int)$newStock[$k], 'quantity', 'roz_stock','YES','modified_on');
		}
	}
	
	header("Location:".$_SERVER['PHP_SELF']."?msg=Product Stock is updated");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Stock Products</title>

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
		{column_number : 4,  filter_type: "range_date", filter_container_id: "filterDate"}
	
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
                	<h1>Stock Products Details</h1>
                   <div class="cl"></div> 
				   
                </div>
                
                <!-- Options --><br><br><br><br>
                <div id="options-area">
					<div class="add-new-option">
						<a href="#" 
							  onClick="MM_openBrWindow('add-roz-stock.php?action=add_prod','stocAdd','scrollbars=yes,width=750,height=600')">
							  Add New Design					  
						</a>
					</div>	
					<a href="../file_download.inc.php?table=roz_stock">Download</a>
                </div>
				<p style="font-size:20px;">Total Current Stock:<?php  $rozStock->CurrentRozStockSum();?></p><br>			
              <div class="padT30"><!-- --> </div> 
               <div id="PrintForm">

                <!-- Display Data -->
                <div id="data-column" style="position:relative; bottom: 9px;">
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						if(count($sids) == 0)
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
						  <th width="3%" height="25"  align="center">SL No.</th>
						  <th width="10%" >Design No. </th>
						  <th width="10%" >Quantity(Pcs.)</th>
						  <th width="10%" >Shop Name</th>
						  <th width="10%" >New Stock</th>
						  <th width="5%" >Action</th>
						</tr>  
                        </thead>
						<tbody>
                       <?php 
						$k = $pages->getSerialNum(20);
						//	$sid = array_slice($sid, $start, $limit);     
                        foreach($sids as $x)
                            {
								$stockDetail 	= $rozStock->showRozStock($x);
								$bgColor 	 	= $utility->getRowColor($k);
						?>
						<tr align="left"<?php $utility->printRowColor($bgColor);?>>
							<td align="left"><?php echo $k++; ?></td>
							<td align="center"><?php echo $stockDetail[1]; ?></td>
							<td align="center"><?php echo $stockDetail[4]; ?></td>
							<td align="center"><?php echo $stockDetail[9]; ?></td>
							<!--<td><?php //echo $dateUtil->printDate($eachRecord['added_on']); ?></td>-->
							<td>
								<input name="newStock<?php echo $x; ?>" type="text" class="text_box_large" id="newPrice" size="10" maxlength="12"></td>
							</td>
							<td>
							
							<p href="#" 
								onClick="MM_openBrWindow('shop_prod_in.php?action=InProd&sid=<?php echo $stockDetail[0]; ?>','stockIn','scrollbars=yes,width=750,height=600')">
								 In					  </p> 
								||
								<p href="#" 
								onClick="MM_openBrWindow('shop_prod_out.php?action=OutProd&sid=<?php echo $stockDetail[0]; ?>','stockOut','scrollbars=yes,width=750,height=600')">
								Out					  </p> 
							</td>
					  	
				     </tr>
                      <?php 
						
                            }//end of foreach
                      }//end else
                      ?>
					</tbody>  
                  </table>
                   
					<input name="btnUpdate" type="submit" class="button-add" id="btnUpdate" value="update">
				   	<input name="btnCancel" type="submit" class="button-cancel" value="cancel">
                </form>
				   
                    <div class="first-column">
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