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

$labour			= new Labour();

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
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 10);

$userId			= $utility->returnSess('userid', 0);

	
//NO OF PRODUCTS
if((isset($_POST['btnSearch'])))
{
$keyword			= $_POST['keyword'];
//echo $keyword;exit;
	$link = '';
	$lid = $search_obj->getLabourPayDtl($keyword);
	//echo $sid;exit;
}else
{
	$link = '';
	//$sid	= $status->getAllPstatus($user_id, $status);
	$lid = $labour->getAllLabourpayment('added_on','DESC');
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$link			= "numResDisplay=".$numResDisplay;

/* pagination*/
$adjacents = 3;

$total_pages = count($lid);
	
/* Setup vars for query. */
$targetpage = $_SERVER['PHP_SELF']."?".$link; 	//your file name  (the name of this file)
$limit = 10; 	
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
<title><?php echo COMPANY_S; ?> Payment Details</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

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
                	<h1>Payment Details</h1>
                    
                     <div id="search-page-back">
                    	<form name="formAdvSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                           
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="search" />
                        </form>
                    </div>
                   <div class="cl"></div> 
				</div>
                
            
               
              <div class="padT30"><!-- --> </div> 
               
                <!-- Display Data -->
                <div id="data-column">
                	
                	<table class="single-column" cellpadding="0" cellspacing="0">
                
                        <!-- display option -->
                        <?php 
						if(count($lid) == 0)
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
						  <th width="7%" >Payment Id</th>
						  <th width="7%" >Labour Id </th>
                          <th width="5%" >Labour Name </th>
						  <th width="10%"  >Payment Type</th>
                          <th width="10%"  >Payment Amount</th>
						  <th width="10%"  >Payment By</th>
						  <th width="10%"  >Payment Date</th>
                          <th width="13%"  >Action</th>
						  
                        </thead>
                       <?php 
							
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                       $sid = array_slice($lid, $start, $limit);     
                        foreach($lid as $x)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							$PaymentDetail = $labour->showLabourPayment($x);
							//print_r($prodDetail);exit;
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					  <td align="left"><?php echo $PaymentDetail[0]; ?></td>
					  <td align="center"><?php echo $PaymentDetail[1]; ?></td>
					   <td align="center"><?php echo $PaymentDetail[2]; ?></td>
					   <td align="center"><?php echo $PaymentDetail[3]; ?></td>
					   <td align="center"><?php echo $PaymentDetail[4]; ?></td>
					   <td align="center"><?php echo $PaymentDetail[5]; ?></td>
					  <td align="center"><?php echo $PaymentDetail[6]; ?></td>
					  
						 <td >
					  [ 
					    <a href="#" 
					  onClick="MM_openBrWindow('stich_rate_edit.php?action=stich_rate&rid=<?php echo $PaymentDetail[0]; ?>','editStichRate','scrollbars=yes,width=750,height=600')">
					  Edit					  </a> ]
					  
					  
					 
					  [ 
					  <a href="#" onClick="MM_openBrWindow('fabric_delete.php?action=del_stichRate&rid=<?php echo $PaymentDetail[0]; ?>','DeleteStichRate','scrollbars=yes,width=400,height=350')">
					  Delete					  </a> ]<br>
					  [ 
					  <a onclick="PrintDiv();" class="add-icon tooltip" title="Print Payment Details">Print
						</a>]<br>
					  
					 
                      
					 					  </td>
                         
				     </tr>
                      <?php 
                            }
                      }
                      ?>
                  </table>
                          
                    <div class="first-column">
                 
                    	<!-- Bottom Pagination-->
                        <div class="pagination-bottom">
                            <div class="upper-block">Total Report: <?php echo count($lid);?></div>
                            <div class="lower-block"><?php //$pages->getPage($numPages, $link, $pageNumber, $pageArray);?>
                            </div>
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
     
</body>
</html>