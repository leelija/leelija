<?php 
session_start();
//include_once('checkSession.php');
include_once('_config/connect.php');

require_once("includes/constant.inc.php");
//require_once("includes/order.inc.php");

require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php"); 
 
require_once("classes/error.class.php"); 
require_once("classes/customer.class.php");
require_once("classes/countries.class.php");
require_once("classes/order.class.php");
require_once("classes/search.class.php");
require_once("classes/pagination.class.php");

require_once("classes/product_status.class.php");
require_once("classes/status_cat.class.php");
require_once("classes/alter_particular.class.php");
require_once("classes/kalicut_mst.class.php");
require_once("classes/interlock.class.php");
require_once("classes/issue_products.class.php");


require_once("classes/labour.class.php");
require_once("classes/adv_search.class.php");


require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php"); 
require_once("classes/utilityImage.class.php");
require_once("classes/utilityNum.class.php");


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$client		    = new Customer();
$country		= new Countries();
$order			= new Orders();
$search_obj		= new Search();
$pages			= new Pagination();

$status			= new Pstatus();
$statusCat		= new StatusCat();
$interlock		= new InterlockMst();
$issueProducts	= new IssueProducts();
$labour			= new Labour();

$advSearch			= new AdvSearch();
$alterParticular	= new AlterParticular();
$kalicutmst			= new KaliCutMst();

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
//$noOfOrd		= array();
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 50);

$userId			= $utility->returnSess('userid', 0);

$IssueProdData	= $issueProducts->getIssueProductsData();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Issue Products Maintenance</title>

<!-- Style -->
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<link href="style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="style/bootstrap/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">




<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/utility.js"></script>
<script type="text/javascript" src="js/advertiser.js"></script>
<script type="text/javascript" src="js/location.js"></script>
<script type="text/javascript" src="js/checkEmpty.js"></script>
<script type="text/javascript" src="js/email.js"></script>
<script type="text/javascript" src="js/static.js"></script>
<!-- eof JS Libraries -->

<!--   multi filter -->
<script src='js/multifilter.js'></script>
<script src="js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="js/jquery.dataTables.yadcf.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

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
		{column_number : 10,  filter_type: "range_date", filter_container_id: "filterDate"}
	
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
	<?php require_once('header-test.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<div id="admin-menu">
				<?php require_once('menu.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                <br><br>
				<div id="options-area">
					<h1>Sample/Ordari</h1>
                	<div class="add-new-option">
                    	<a href="<?php echo "issue_products_add.php"."?action=add_issue_products"; ?>">
                            Add New Record
                        </a> 
                    </div>
                </div>
             <!-- search by date-->  
				<div class="row">
					<!--Date filter-->
				<div class="section-text1">
					<p>
						<div id="external_filter_container_wrapper">
							<div id="filterDate"></div>
						</div>
						<div class='container1'>
							<div class='filters'>
								<div class='clearfix'></div>
							</div>
						</div>
									
					</p>
				</div>
				</div>
			  <!-- Row -->
			
               <div id="PrintForm" style="position:relative; bottom: 150px;"><!--Start Print-->
                <!-- Display Data -->
                <div id="data-column" >
                	
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0">
                
                        <!-- display option -->
                        <?php 
						if(count($IssueProdData) == 0)
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
                          <th width="5%" >order Id </th>
                          <th width="10%"  >Design No</th>
						  <th width="10%"  >Bill No</th>
						  <th width="10%"  >Master Name</th>
						  <th width="10%"  >Labour</th>
						   <th width="10%"  >Issue Type</th>
						  <th width="10%"  >Particular</th>
						  <th width="10%"  >Quantity</th>
						  <th width="10%"  >rate</th>
						  <th width="10%"  >total Amount</th> 
                          <th width="13%"  >Added on</th>
                         <!-- <th width="34%"  align="center">Action</th> -->
                        </thead>
                       <?php 
							
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                      // $sid = array_slice($sid, $start, $limit);     
                        foreach($IssueProdData as $eachRecord)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							//$interlockDtl = $interlock->showInterlock($x);
							
							$labourDtl = $labour->showLabour($eachRecord['labour_id']);
							
							$customerDetail = $client->getCustomerData($eachRecord['master_id']);
							$date=date_create($eachRecord['added_on']);
							
							
							
							//print_r($prodDetail);exit;
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
						<tr align="left"<?php $utility->printRowColor($bgColor);?>>
						<td align="center"><?php echo $eachRecord['order_id']; ?></td>
						<td align="center"><?php echo $eachRecord['design_no']; ?></td> 
						<td align="center"><?php echo $eachRecord['bill_no']; ?></td> 
						<td align="center"><?php echo $customerDetail[5]; ?></td>
						<td align="center"><?php echo $labourDtl[1]; ?></td>
						<td align="center"><?php echo $eachRecord['issue_type']; ?></td>
						<td align="center"><?php echo $eachRecord['particular']; ?></td>
						<td align="center"><?php echo $eachRecord['prod_quantity']; ?></td>
						<td align="center"><?php echo $eachRecord['rate']; ?></td>
					   <td align="center"><?php echo $eachRecord['total_cost']; ?></td>
					   <td align="center"><?php echo date_format($date,"d/m/Y"); ?></td>
					  
					   
					
                          <!-- <td><?php //if($cusDetail[1] == '0000-00-00 00:00:00') {echo 'no login';} else {echo $cusDetail[4];} ?></td> -->
                        <!--  <td  align="center">
                          
								[ 
								<a href="#" onClick="MM_openBrWindow('alter_particular_update.php?action=update_altpart&dhmckfip=<?php //echo $AlterDetail[0]; ?>','AdminDelete','scrollbars=yes,width=700,height=600')">
									Repair			  </a> ] 
								
								
						  
                          </td>  -->
				     </tr>
                      <?php 
                            }
                      }
                      ?>
					</table>
                     <a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>     
                   
                </div>
                <!-- eof Display Data -->
              </div><!--end Print-->  
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
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>	
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