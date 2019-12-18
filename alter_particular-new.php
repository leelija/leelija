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

$labour		= new Labour();

$advSearch		= new AdvSearch();
$alterParticular	= new AlterParticular();


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


$AltPartDetail 	= $alterParticular->showAltPartData();



?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title><?php echo COMPANY_S; ?> - Alter particular</title>

<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  
  <!--  CustomStyle -->
	<link href="style/admin/style.css" rel="stylesheet" type="text/css">
	<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
	</link>
	
	
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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
<!-- Filter Libraries -->
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
     $('#example').dataTable()
		  .columnFilter({ 	sPlaceHolder: "head:before",
					aoColumns: [ 	{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
								
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
            	
               
				<div id="options-area">
                	<div class="add-new-option">
                    	<a href="<?php echo "alter_particular_add.php"."?action=add_altpart"; ?>">
                            Add Alter Products
                        </a> 
                    </div>
                </div>
				
              <div class="padT30"><!-- --> </div> 
               <div id="PrintForm">
                <!-- Display Data -->
                <div id="data-column">
                	
                	<table id="example" class="table table-bordered table-striped" >
             
                        <thead>
							<tr>
							  <th>order Id </th>
							  <th >Design No</th>
							  <th >Complete By</th>
							  <th>Particular</th>
							  <th>Quantity</th>
							  <th>Cost/Piece</th>
							  <th>Total Cost</th>
							  <th>Alter Reason</th>
							  <th>Added on</th>
							</tr>  
                        </thead>
						
						<tbody>
						   <?php 
								if(count($AltPartDetail) !=0){
								$sl = 1;
								foreach($AltPartDetail as $eachRecord)
									{   
								
								
										$labourDtl = $labour->showLabour($eachRecord['labour_id']);
										//print_r($prodDetail);exit;
										//$bgColor 	= $utility->getRowColor($sl);	
							?>
									<tr>
										<td><?php echo $eachRecord['order_id'];?></td>
										<td><?php echo $eachRecord['design_no'];?></td>
										<td ><?php echo $labourDtl[1]; ?></td>
										<td><?php echo $eachRecord['particular'];?></td>
										<td><?php echo $eachRecord['quantity'];?></td>
										<td><?php echo $eachRecord['pay_per_piece'];?></td>
										<td><?php echo $eachRecord['total_pay'];?></td>
										<td><?php echo $eachRecord['alter_cause'];?></td>
										<td><?php echo $eachRecord['added_on'];?></td>
					 
									</tr>
								  <?php 
										$sl++;
										}
									}
								  
								  else{
								  
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

	
	<script src="plugins/datatables/jquery.dataTables.min.js"></script> 
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>	
	<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	-->	
	<script src="bootstrap/js/bootstrap-editable.js" type="text/javascript"></script> 

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
