<?php 
ob_start();
session_start();
//include_once('checkSession.php');
include_once('../_config/connect.php');
require_once("../includes/constant.inc.php");
//require_once("includes/order.inc.php");
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../classes/error.class.php"); 
require_once("../classes/customer.class.php");
require_once("../classes/countries.class.php");
require_once("../classes/order.class.php");
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/status_cat.class.php");
require_once("../classes/labour.class.php"); 

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");


/* INSTANTIATING ../classes */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$client		    = new Customer();
$country		= new Countries();
$order			= new Orders();
$search_obj		= new Search();
$pages			= new Pagination();
$labour		    = new Labour();
$status			= new Pstatus();
$statusCat		= new StatusCat();

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
$userId			= $utility->returnSess('userid', 0);

//Labour Details
$labourAdvDtls	= $labour->getLabourAdv();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Labour Adv. Details</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->
<link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../style/bootstrap/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">


<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../openwysiwyg/wysiwyg.js"></script> 
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

<!--   multi filter -->
<script src="../js/multifilter.js"></script>
<script src="../js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="../js/jquery.dataTables.yadcf.js"></script>
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
		{column_number : 7,  filter_type: "range_date", filter_container_id: "filterDate"}
	
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
	<?php require_once('header-org.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<div id="admin-menu">
				<?php require_once('menu.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                <div id="admin-top">
                	<h1>Labour Advance Details</h1>
                    <a href="../file_download.inc.php?table=labour_adv_dtls">Download</a>
                     
                   <div class="cl"></div> 
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
               
              <div class="padT30"><!-- --> </div> 
               <div id="PrintForm" style="position:relative; bottom: 250px;">
                <!-- Display Data -->
                <div id="data-column">
                	
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0">
                
                        <!-- display option -->
                        <?php 
						if(count($labourAdvDtls) == 0)
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
						  <th width="7%" >SL NO.</th>
						  <th width="15%" >Labour Name</th>  
                          <th width="20%" >Advance Amount </th>
                          <th width="10%">Adv. By</th>
						  <th width="10%">Adv. Date</th>
                          <th width="5%">Action</th>
                        </thead>
                       <?php 
							
						$sl=1;	   
                        foreach($labourAdvDtls as $eachRecord)
                            {
								$labourDtl		= $labour->showLabour($eachRecord['labour_id']); 
								$date=date_create($eachRecord['adv_date']);
							
							//$customerDetail = $client->getCustomerData($finalStichDetail[8]);
							$bgColor 	= $utility->getRowColor($sl);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					   <td align="left"><?php echo $sl; ?></td>
					   <td align="center"><?php echo $labourDtl[1]; ?></td> 
					   
					   <td align="center"><?php echo $eachRecord['adv_amount']; ?></td>
					   <td align="center"><?php echo $eachRecord['adv_by']; ?></td>
					   <td align="center"><?php echo date_format($date,"d/m/Y"); ?></td>
					  
					<td >
					   <p onClick="MM_openBrWindow('labour-adv-voucher.php?action=adv-voucher&id=<?php echo $eachRecord['id']; ?>','AdminDelete','scrollbars=yes,width=1000,height=800')">
							View
						</p>
					</td>
                         
				     </tr>
                      <?php 
							$sl++;
                            }
							
                      }
                      ?>
                  </table>
                     <a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>     
                    <div class="first-column">
                    	<!-- Bottom Pagination-->
                        <div class="pagination-bottom">
                            
                        </div>
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