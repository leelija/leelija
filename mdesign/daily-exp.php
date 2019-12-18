<?php 
//session_start();
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/product_stock.class.php"); 
require_once("../classes/product_order.class.php");
require_once("../classes/journal.class.php"); 

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/adv_search.class.php");
require_once("../classes/photo_gallery.class.php");
require_once("../classes/sample.class.php"); 
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders		    = new Orders();
$prodStatus		= new Pstatus();
$advSearch		= new AdvSearch();
$productStock	= new ProductStock();
$productOrder	= new Productorders();
$journal		= new Journal();

$search_obj		= new Search();
$pages			= new Pagination();
$photogallery	= new PhotoGAllery();
$sample			= new Sample();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();


// Display Journal Book details
$journalBook	= $journal->getAllJournalBook();

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daily Expenses</title>
	<!-- Included Bootstrap CSS Files -->
	<link rel="stylesheet" href="./js/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="./js/bootstrap/css/bootstrap-responsive.min.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Css -->	
	<link rel="stylesheet" href="css/style.css" />
	<link href="css/cust.css" rel="stylesheet" type="text/css" media="all" />
	<!--<link href="../samplestock/css/style.css" rel="stylesheet" type="text/css" media="all" />	-->
	<link href="../samplestock/css/modal.css" rel="stylesheet" type="text/css" media="all" />	
	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>      
	<script src="../js/ajax.js" type="text/javascript"></script> 
	<script src='../js/multifilter.js'></script>
	<script src="../js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
	<script src="../js/jquery.dataTables.yadcf.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
	
	
	
<style type="text/css">   
 .w3_whatsapp_btn {
    background-image: url('icon.png');
    border: 1px solid rgba(0, 0, 0, 0.1);
    display: inline-block !important;
    position: relative;
    font-family: Arial,sans-serif;
    letter-spacing: .4px;
    cursor: pointer;
    font-weight: 400;
    text-transform: none;
    color: #fff;
    border-radius: 2px;
    background-color: #5cbe4a;
    background-repeat: no-repeat;
    line-height: 1.2;
    text-decoration: none;
    text-align: left;
}

.w3_whatsapp_btn_small {
    font-size: 12px;
    background-size: 16px;
    background-position: 5px 2px;
    padding: 3px 6px 3px 25px;
}

.w3_whatsapp_btn_medium {
    font-size: 16px;
    background-size: 20px;
    background-position: 4px 2px;
    padding: 4px 6px 4px 30px;
}

.w3_whatsapp_btn_large {
    font-size: 16px;
    background-size: 20px;
    background-position: 5px 5px;
    padding: 8px 6px 8px 30px;
    color: #fff;
}   

a.whatsapp { color: #fff;}
    
</style>
		
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
     $('#examplew').dataTable()
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
	<?php require_once('header.inc.php'); ?>
	<div class="main">
	 	<div class="content">	
			<div class="features" id="features"><!--Features Content start-->
                <div class="wrap"> <!--Wrap start-->                            	
					<h2>Daily Expenses<span>Details</span></h2>
                 	<h4></h4>
					<div class="features_grids"><!--Start Feature grids-->
						<div class="section group"><!--Start section group-->
							<div id="boardsTable">
								<table id="examplew" class="table table-bordered table-striped">
								<thead>
									<tr >
									 <th>Sl. No.</th>
									  <th >Name</th>
									  <th >Purpose</th>
									  <th>Amount(Rs.)</th>
									  <th>Date</th>
									</tr>
								</thead>
								
								<tbody>
								<?php
									if(count($journalBook) !=0){
									$sl = 1;
										foreach($journalBook as $eachRecord)
											{
											//	$date=date_create($eachRecord['updated_on']);
											//	$moddate 	= date_format($date,"m/d/Y");
								?>
										<tr align="left">
											<td><?php echo $sl;?></td>
											<td style="width: 100px;"><?php echo $eachRecord['payment_received'];?></td> 
											<td><?php echo $eachRecord['expenses_purpose'];?></td>
											<td><?php echo $eachRecord['pay_amount'];?></td>
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
								
								<tfoot>
								   <tr>
									<th>Sl. No.</th>
									  <th >Name</th>
									  <th >Purpose</th>
									  <th>Amount(Rs.)</th>
									  <th>Date</th>
									</tr>	
								</tfoot>
							  </table>
							</div>  
							
							
					    </div><!--end section group-->
					</div><!--end features grid-->
				</div><!--Wrap End-->
			</div><!--Features Content end-->
           	     
          
     	</div><!--end content-->
  	</div>	<!--End main-->
		
	
		
	<div id="socials-bar">
	</div>
	
	
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#examplew").DataTable();
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
<script src="../bootstrap/js/bootstrap-editable.js" type="text/javascript"></script> 

	
	<script src="../js/jquery-1.10.0.min.js"></script>
	<script src="../js/bootstrap/js/bootstrap.min.js"></script>
	<script src="../js/script.js"></script>
</body>
</html>