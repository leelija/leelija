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
//$noOfOrd		= array();
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 500);

$userId			= $utility->returnSess('userid', 0);

	
//NO OF PRODUCTS
if((isset($_POST['btnSearch'])))
{
$keyword			= $_POST['keyword'];
//echo $keyword;exit;
	$link = '';
	$sid = $search_obj->getLabourCredit($keyword);
	//echo $sid;exit;
}else
{
	$link = '';
	//$sid	= $status->getAllPstatus($user_id, $status);
	$sid = $statusCat->getAllFinalStichDtlAll('final_stich_dtlid','DESC');
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$link			= "numResDisplay=".$numResDisplay;

/* pagination*/
$adjacents = 3;

$total_pages = count($sid);
	
/* Setup vars for query. */
$targetpage = $_SERVER['PHP_SELF']."?".$link; 	//your file name  (the name of this file)
$limit = 500; 	
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - final_stich Details</title>

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
                	<h1>Final Stiching Details</h1>
                    <a href="../file_download.inc.php?table=final_stich_details">Download</a>
                     <div id="search-page-back">
                    	<form name="formAdvSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                           
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="search" />
                        </form>
                    </div>
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
						if(count($sid) == 0)
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
						  <th width="7%" >Orders Id </th>  
                          <th width="5%" >Design No. </th>
						<!--  <th width="10%"  >Employee Id</th>  -->
                          <th width="10%"  >Employee Name</th>
						  <th width="10%"  >Particulars</th>
						  <th width="10%">Quantity</th>
                          <th width="13%">Work Price(RS.) </th>
						<th width="13%"  >Paid status </th>  
						  <th width="18%" >Date</th>
                          <th width="18%">Action</th>
                        </thead>
                       <?php 
							
						$sl=1;	
						$k = $pages->getPageSerialNum($numResDisplay);
						$sid = array_slice($sid, $start, $limit);     
                        foreach($sid as $x)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							$finalStichDetail = $statusCat->showProductFinalStichDtl($x);
							//print_r($prodDetail);exit;
							$finalstichdtl = $statusCat->showProductFinalStich($finalStichDetail[1]);
							$date=date_create($finalStichDetail[7]);
							
							//$customerDetail = $client->getCustomerData($finalStichDetail[8]);
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					  <td align="left"><?php echo $sl; ?></td>
					  
					   <td align="center"><?php echo $finalstichdtl[2]; ?></td> 
					   
					   <td align="center"><?php echo $finalStichDetail[2]; ?></td>
					<!--   <td align="center"><?php echo $finalStichDetail[8]; ?></td>  -->
					   <td align="center"><?php echo $finalStichDetail[3]; ?></td>
					   <td align="center"><?php echo $finalStichDetail[4]; ?></td>
					   <td align="center"><?php echo $finalStichDetail[5]; ?></td>
					   <td align="center"><?php echo $finalStichDetail[6]; ?></td>
					  <td align="center"><?php echo $finalStichDetail[9]; ?></td> 
					   <td align="center"><?php echo date_format($date,"d/m/Y"); ?></td>
					  
					<td >
					  [ 
					    <a href="#" 
					  onClick="MM_openBrWindow('stich_rate_edit.php?action=stich_rate&rid=<?php echo $finalStichDetail[0]; ?>','editStichRate','scrollbars=yes,width=750,height=600')">
					  Edit					  </a> ]
					  
					  
					 
					  [ 
					  <a href="#" onClick="MM_openBrWindow('final_stiching_details_del.php?action=del_finalStich&sid=<?php echo $finalStichDetail[0]; ?>','DeleteStichRate','scrollbars=yes,width=400,height=350')">
					  Delete					  </a> ]<br>
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
                            <div class="upper-block">Total Report: <?php echo count($sid);?></div>
                            <div class="lower-block"><?php //$pages->getPage($numPages, $link, $pageNumber, $pageArray);?>
                            </div>
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