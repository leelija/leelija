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

require_once("../classes/purchase.class.php"); 
require_once("../classes/stock.class.php"); 
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

$purchase		= new Purchase();
$search_obj		= new Search();
$pages			= new Pagination();

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

//admin detail
//$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$purchaseDtls	= $purchase->PurchaseDispl();

$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 20);
$userId			= $utility->returnSess('userid', 0);

//NO OF PRODUCTS
if((isset($_POST['btnSearch'])))
{
$keyword			= $_POST['keyword'];
//echo $keyword;exit;
	$link = '';
	$sid = $search_obj->getStockKeyword($keyword);
	//echo $sid;exit;
}
else
{
	$link = '';
	$sid = $stock->getAllStock('stock_id','DESC');
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$link			= "numResDisplay=".$numResDisplay;

/* pagination*/
$adjacents = 3;

$total_pages = count($sid);
	
/* Setup vars for query. */
$targetpage = $_SERVER['PHP_SELF']."?".$link; 	//your file name  (the name of this file)
$limit = 20; 	
if(isset($_GET['page']))
{							//how many items to show per page
	$page = $_GET['page'];
}
else
{
	$page = 1;
}
//echo $page;exit;
if($page) 
	$start = ($page - 1) * $limit; 			//first item to display on this page
else
	$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
/*	$sql = "SELECT customer_id FROM $tbl_name LIMIT $start, $limit";
	$result = mysql_query($sql);*/
	//echo $sql.mysql_error();exit;
	/* Setup page vars for display. */
					//if no page var is given, default to 1.
$prev = $page - 1;							//previous page is page - 1
$next = $page + 1;							//next page is page + 1
$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
$lpm1 = $lastpage - 1;						//last page minus 1

/* 
	Now we apply our rules and draw the pagination object. 
	We're actually saving the code to a variable in case we want to draw it more than once.
*/
$pagination = "";
//echo $total_pages;exit;
if($lastpage > 1)
{	
	$pagination .= "<div class=\"pagination\">";
	//previous button
	if ($page > 1) 
		$pagination.= "<a href=\"$targetpage&page=$prev\" id='previous-button'>< previous</a>";
	else
		$pagination.= "<span class=\"disabled\">< previous</span>";	
	
	//pages	
	if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
	{	
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
			if ($counter == $page)
				$pagination.= "<span class=\"current\">$counter</span>";
			else
				$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
		}
	}
	elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
	{
		//close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2))		
		{
			for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";				
			}
			$pagination.= "...";
			$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
			$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
		}
		//in middle; hide some front and some back
		elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
		{
			$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
			$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
			$pagination.= "...";
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
			}
			$pagination.= "...";
			$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
			$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
		}
		//close to end; only hide early pages
		else
		{
			$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
			$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
			$pagination.= "...";
			for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
			}
		}
	}
	
	//next button
	if ($page < $counter - 1) 
		$pagination.= "<a href=\"$targetpage&page=$next\" id='next-button'>next ></a>";
	else
		$pagination.= "<span class=\"disabled\" id='next-button-disabled'>next ></span>";
	$pagination.= "</div>\n";		
}

/* eof pagination*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Stock Products Maintenance</title>

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
                	<h1>Purchase Records Maintenance</h1>
                   <div class="cl"></div> 
                </div>
                
                <!-- Options --><br><br><br><br>
                <div id="options-area">
                	<div class="add-new-option">
                    	<a href="<?php echo "precord_add.php"."?action=add_precord"; ?>">
                            Add New Record
                        </a> 
                    </div>
					<a href="#">Download</a>
                </div>
							
              <div class="padT30"><!-- --> </div> 
               <div id="PrintForm">

                <!-- Display Data -->
                <div id="data-column" style="position:relative; bottom: 9px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						if(count($purchaseDtls) == 0)
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
                          <th width="3%" height="25"  align="center">Sl No.</th>
						 <!-- <th width="3%" height="25"  align="center">Stock Id</th> -->
						  <th width="10%" >Slip Name. </th>
						  <th width="10%" >Slip No</th>
						  <th width="10%" >Purchase Company</th>
						  <th width="10%" >Address</th>
						  <th width="10%" >Mobile</th>
						  <th width="7%" >Purchase Date</th>
						  <th width="15%" >Bill By(M/s)</th>
						 <th width="10%" >Receive by</th> 
						 <th width="15%" >Total Amount</th>
						 <th width="10%" >Receiver</th> 
						 <th width="10%" >Slip</th> 
						 <th width="15%" align="center">Added By</th>
						</tr>  
                        </thead>
						<tbody>
                       <?php 
                        $sl=1;
	                    $k = $pages->getPageSerialNum($numResDisplay);
						//	$sid = array_slice($sid, $start, $limit);     
                        foreach($purchaseDtls as $eachRecord)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							//$stockDetail = $stock->showStock($x);
							//print_r($prodDetail);exit;
							$date			= date_create($eachRecord['added_on']);
							$purchasedate	= date_create($eachRecord['purchase_date']);
							
							$bgColor 	= $utility->getRowColor($k);	
							
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
						<td align="left"><?php echo $sl; ?></td>
					   <td align="center"><a href=""><?php echo $eachRecord['slip_name']; ?></a></td>
					   <td align="center"><?php echo $eachRecord['slip_no']; ?></td>
					   <td align="center"><?php echo $eachRecord['pcompany']; ?></td>
					   <td align="center"><?php echo $eachRecord['pcaddress']; ?></td>
					   <td align="center"><?php echo $eachRecord['mobile']; ?></td>
					   <td align="center"><?php echo date_format($purchasedate,"m/d/Y"); ?></td>
					   <td align="center"><?php echo $eachRecord['bill_by']; ?></td>
					   <td align="center"><?php echo $eachRecord['purchase_by']; ?></td>
					   <td align="center">
					   
						<a href="#" 
						    onClick="MM_openBrWindow('purchase_dtls.inc.php?action=show_pid&pid=<?php echo $eachRecord['purchase_id']; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
						    <?php echo $eachRecord['total_amount']; ?>				  
						</a> 
					   
					   </td>
					   
					   
					   <td align="center">
					 	<?php 
							if(($eachRecord['rphoto'] != '') && ( file_exists("images/receiver/".$eachRecord['rphoto'])) )
							{
								echo $utility->imageDisplay2('images/receiver/', $eachRecord['rphoto'], 50, 50, 0, '', $eachRecord['purchase_id']);
	
							}
						?>
                      </td>
					   <td align="center">
					 	<?php 
							if(($eachRecord['image'] != '') && ( file_exists("images/bill-received/".$eachRecord['image'])) )
							{
								echo $utility->imageDisplay2('images/bill-received/', $eachRecord['image'], 50, 50, 0, '', $eachRecord['purchase_id']);
	
							}
						?>
                      </td>
					   <td align="center"><?php echo $eachRecord['added_by'];; ?></td>
					  	
				     </tr>
                      <?php 
						$sl++;
                            }
                      }
                      ?>
					</tbody>  
                  </table>
                   
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