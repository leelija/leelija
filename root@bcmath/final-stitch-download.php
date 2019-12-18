<?php 
ob_start();
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
require_once("classes/adv_search.class.php");

require_once("classes/product_status.class.php");
require_once("classes/status_cat.class.php");


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
$advSearch		= new AdvSearch();

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
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 1000000);

$userId			= $utility->returnSess('userid', 0);

// search function
if((isset($_POST['btnSearch'])))
{
$keyword			= $_POST['keyword'];
$type			    = $_POST['type'];
//echo $keyword;exit;
	if($_POST['type'] ==""){
		$link = '';
		$sid = $search_obj->getFinalstichPipelinestore($keyword,$userId);
		//echo $sid;exit;
	}
	else{
		$link = '';
		$sid = $advSearch->getCommonSearch($keyword,$type,$userId,'final_stich_id','final_stich');
		
	}		
}


elseif(isset($_GET['ord_id'])){
	$keyword	 	= $_GET['ord_id'];
	$link = '';
	$sid = $search_obj->getFinalstichPipelinestore($keyword,$userId	);
}
else
{
	$link = '';
	//$sid	= $status->getAllPstatus($user_id, $status);
	$sid = $statusCat->getAllFinalStichDWN('added_on','DESC',$userId);
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$link			= "numResDisplay=".$numResDisplay;

/* pagination*/
$adjacents = 3;

$total_pages = count($sid);
	
/* Setup vars for query. */
$targetpage = $_SERVER['PHP_SELF']."?".$link; 	//your file name  (the name of this file)
$limit = 1000000; 	
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
<title><?php echo COMPANY_S; ?> - final_stich Status</title>

<!-- Style -->
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

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
                	<h1>Final stich Status</h1>
                
                
					<div id="search-page-back">
                    	<form name="formAdvSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                           
						     <div class="search-option">
                           		<div id="dropdown-page-options">
                            		<a href="javascript:void(0)" onClick="showHideDiv('dropdown-page-back', '');">
                                    	Options<img src="../images/admin/icon/search-arrow.png" width="5" height="5" alt="search" />
                                    </a>
                                    <div id="dropdown-page-back" style="display:none">
                                        <p class="required">
                                          Note: if you would be able to display listing according to
                                          the selected criteria.
                                        </p>
                                        
                                        <label>Match By</label>
										
                                       <select name="type" id="type" class="textBoxA">
											<option value="">Select any one</option>
											<option value="order_id">Order Id</option>
											<option value="design_no">Design No.</option>
											<option value="employeeId">Employee Id</option>
											<option value="bill_no">Bill No.</option>
											<option value="final_result">Status</option>
											<option value="order_date">Order Date</option>
											<option value="target_date">Target Date</option>
											
                                       </select>
                                       <div class="cl"></div>  
                                        
                            		</div>
                                </div>
                            </div>
						    <input name="mode" type="hidden" value="" />
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="search" />
                        </form>
                    </div>
                   <div class="cl"></div>
				</div>
                
                
            
               
              <div class="padT30"><!-- --> </div> 
			  
			  <!-- Download option -->
                <div id="options-area">
					<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Download to Excel">
                </div>
                <!-- eof Download option -->
               
                <!-- Display Data -->
                <div id="data-column">
                	
                	<table id="testTable">

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
						<!--  <th width="7%" >Final Stich Id</th>
						  <th width="7%" >Status Id </th>   -->
                          <th>order Id </th>
                          <th>Design No</th>
						  <th>Quantity</th>
						  <th>Master Name</th>
						  <th>Bill No.</th>
                          <th>Order Date </th>
                          <th>Target Date</th>
						  <td >Submit Date</th>
						  <th>R.day</th>
						  <th>Colour</th>
						  <th>Quantity</th>
                          <th>Particular(complete)</th>
						  <th>Remarks</th>
						  <th>Status</th>
                        </thead>
                       <?php 
							
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                       $sid = array_slice($sid, $start, $limit);     
                        foreach($sid as $x)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							$statusCatDetail = $statusCat->showProductFinalStich($x);
							$customerDetail = $client->getCustomerData($statusCatDetail[5]);
							//print_r($prodDetail);exit;
							
							// display final stich bill
							$finalStichBillDtl	= $statusCat->GetFinalStichBill($statusCatDetail[0]);
							
							$workCompDtl		= $statusCat->GetFinalStichDtl($statusCatDetail[0]);
							
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
				<!--	  <td align="left"><?php //echo $statusCatDetail[0]; ?></td>
					  <td align="center"><?php //echo $statusCatDetail[1]; ?></td>  -->
					   <td><a href=""><?php echo $statusCatDetail[2]; ?></a></td>
					   <td><?php echo $statusCatDetail[3]; ?></td>
					   <td>
                          <a href="#" onClick="MM_openBrWindow('status_details.php?action=status_details&oid=<?php echo $statusCatDetail[2]; ?>','AdminDelete','scrollbars=yes,width=500,height=400')">
                          <?php	$order->TotalQuantitySum($statusCatDetail[2]);	?>	 </a> 
					    </td>
					   <td><?php echo $customerDetail[5]; ?></td>
					   <td><?php echo $statusCatDetail[17];echo'<br>'; 
							foreach($finalStichBillDtl as $record)
                            {
								echo $record["bill_no"];echo ",";
							
							}
					   
					   
					   ?>
					   
					   </td>
					   
					   <td><?php echo $statusCatDetail[9]; ?></td>
					   <td><?php echo $statusCatDetail[10]; ?></td>
					   <td><?php echo $statusCatDetail[13]; ?></td>
					  <?php
					    $datemodif	=	date_create($statusCatDetail[13]);
					    $date1		=	date_create($statusCatDetail[10]);
						$date2		=	date_create(date("Y-m-d"));
						$diff=date_diff($date2,$date1);
						
						$diffordtarget=date_diff($datemodif,$date1);
						
						if($statusCatDetail[7]>0)
							{
							if($diff->format("%R%a days")>='+3 days')
							{
						   ?>
						   <td><?php echo $diff->format("%R%a days"); ?></td>
						   <?php
							}
							else{
						   ?>
						   <td><?php echo $diff->format("%R%a days"); ?></td>
						   <?php
								}
							} else{	
						   ?>
						   <td><?php echo $diffordtarget->format("%R%a days"); ?></td>
						   <?php
						   }
						   ?>		  
					    <td><?php echo $statusCatDetail[18]; ?></td>
						<td><?php echo $statusCatDetail[7]; ?></td>
					  
					   <td>
                          <a href="" onClick="MM_openBrWindow('final_stich_complete.php?action=final_stichcomp&final_sid=<?php echo $statusCatDetail[0]; ?>','AdminDelete','scrollbars=yes,width=500,height=400')">
                          <?php	 echo $statusCatDetail[15]; 
						  
						  ?>	 
						  </a>
						  
					   </td>
					  
					   <td><?php echo $statusCatDetail[8]; ?></td>
					   
					   <td><?php echo $statusCatDetail[16]; ?></td>
					   
				     </tr>
                      <?php 
                            }
                      }
                      ?>
                  </table>
                          
                    <div class="first-column">
                 
                    	<!-- Bottom Pagination-->
                        <div class="pagination-bottom">
                            <div class="upper-block">Total Report: <?php echo count($sid);?></div>
                            <div class="lower-block"><?php //$pages->getPage($numPages, $link, $pageNumber, $pageArray);?>
                            </div>
							<?php echo $pagination ?>
                        </div>
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
     <!-- Download to excel-->
	<script type="text/javascript">
		var tableToExcel = (function() {
		  var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		  return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		  }
		})()
	</script>
</body>
</html>