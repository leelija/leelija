<?php
ob_start();
session_start();
?>
<?php 
//session_start();
//include_once('checkSession.php');
require_once("_config/connect.php"); 

require_once("includes/constant.inc.php");
require_once("includes/product.inc.php");

require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php"); 

require_once("classes/order.class.php"); 

require_once("classes/search.class.php");
require_once("classes/pagination.class.php");
require_once("classes/rozelle_order.class.php");

require_once("classes/stock.class.php"); 

require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php"); 
require_once("classes/utilityImage.class.php");
require_once("classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();

$orders		    = new Orders();

$search_obj		= new Search();
$pages			= new Pagination();

$rozelleOrder			= new Rozelleorders();

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
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 100);


//NO OF PRODUCTS
if((isset($_POST['btnSearch'])))
{
$keyword			= $_POST['keyword'];
//echo $keyword;exit;
	$link = '';
	$oids = $rozelleOrder->getRozelleOrderKeyword($keyword);
	//echo $sid;exit;
}
else
{
	$link = '';
	$oids = $rozelleOrder->getAllRozOrd('added_on','DESC');
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$link			= "numResDisplay=".$numResDisplay;

/* pagination*/
$adjacents = 3;

$total_pages = count($oids);
	
/* Setup vars for query. */
$targetpage = $_SERVER['PHP_SELF']."?".$link; 	//your file name  (the name of this file)
$limit = 100; 	
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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> Rozelle Orders Management</title>
<!-- Style -->
<link href="style/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

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
				<?php require_once('menu1.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                 <div id="admin-top">
                	<h1>Rozelle orders</h1>
                    
                     <div id="search-page-back">
                    	<form name="formAdvSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                           
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="search" />
                        </form>
                    </div>
                   <div class="cl"></div>  
                </div>
                
                
                <div class="header-title" style="height:40px;">
					<h2 style="float:left;">[[Total Current Stock:<?php  $stock->CurrentstockSum();?>]]</h2>&nbsp;&nbsp;
					<h2 style="float:left;">[[Total Due Rozelle Order:<?php  $rozelleOrder->DueRozelleOrder();?>]]</h2>
					<h2 style="float:right;">Total Search Order found: <?php echo count($oids);?></h2>
				</div>
                
                <!-- Display Data -->
                <div id="data-column">
                	
                    
                	<table class="single-column" cellpadding="0" cellspacing="0">
                
					<?php 
					if(count($oids) == 0)
					{
					?>
                    <tr align="left" class="orangeLetter">
                      <td height="20" colspan="5">  <?php echo "No Orders Has Been Added So Far."; ?> </td>
                    </tr>
                    <?php 
                    }
                    else
                    {
                    ?>  
                    <thead>
                      <th width="3%" height="25"  align="center">Orders Id</th>
                      <th width="10%" >Design No. </th>
					  <th width="10%" >Book No. </th>
                     <th width="10%" >Party Code</th>
					 <!-- <th width="10%" >BroKar. </th>-->
                     <th width="10%" >Retailer/Hol</th>
                    <!--  <th width="10%" >Orders form</th>-->
                     <!-- <th width="10%" >Order Quantity</th>
                      <th width="7%" >Order Colours </th>-->
					  <th width="17%" > Orders Quantity & Colours Details </th>
					  
					  <th width="7%" >Due Quantity</th>
					  <th width="7%" >Pay Quantity</th>
					  <th width="15%" > Remarks</th>
					 <th width="10%" > order date</th> 
					 <th width="10%" > Target Date</th> 
					  <th width="15%"  align="center"> status</th> 
					 <!-- <th width="5%"  align="center">Assign Job </th> -->
                      <th width="25%" align="center">Action</th>
                   </thead>
					<?php
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                       $oids = array_slice($oids, $start, $limit);     
                        foreach($oids as $x)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							$orderDetail = $rozelleOrder->showRozelleOrders($x);
							//print_r($orderDetail);exit;
							$RozorderDtl = $rozelleOrder->RozordersDtlDisp($orderDetail[0]);
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					  <td align="center"><?php echo $orderDetail[0]; ?></td>
					  <td align="center"><?php echo $orderDetail[1]; ?></td>
					  <td align="center"><?php echo $orderDetail[14]; ?></td>
					   <td align="center"><?php echo $orderDetail[2]; ?></td>
					   <!--<td align="center"><?php //echo $orderDetail[3]; ?></td>-->
					   <td align="center"><?php echo $orderDetail[4]; ?></td>
					   <!-- <td align="center"><?php //echo $orderDetail[5]; ?></td>-->
						<!--<td align="center"><?php //echo $orderDetail[6]; ?></td>
					    <td align="center"><?php //echo $orderDetail[7]; ?></td>-->
						<td align="center">
							[ 
						  
								<a href="#" 
								onClick="MM_openBrWindow('rozelle_order_dtl.php?action=color_dtl&oid=<?php echo $orderDetail[0]; ?>','OrdAssign','scrollbars=yes,width=500,height=400')">
								<?php
								foreach($RozorderDtl as $record)
								{
								 echo $record['colour'];echo "->";echo $record['quantity'];
								}
								 echo ';total->'; $rozelleOrder->RozQuantitySum($orderDetail[0]);	?>					  
								
								
								</a> ]
					    </td>
						<td align="center"><?php $rozelleOrder->RozTotalQuantitySum($orderDetail[0]); ?></td>
						<td align="center">
							
							   <a href="#" 
								onClick="MM_openBrWindow('rozelle_deli_dtl.php?action=delivery_dtl&oid=<?php echo $orderDetail[0]; ?>','OrdAssign','scrollbars=yes,width=500,height=400')">
								<?php $rozelleOrder->RozTotalPayQtySum($orderDetail[0]); ?>
								</a>
							
						</td>
						
						
						<td align="center"><?php echo $orderDetail[8]; ?></td>
						 <td align="center"><?php echo $orderDetail[9]; ?></td>
						  <td align="center"><?php echo $orderDetail[10]; ?></td>
						<?php if($orderDetail[16]=="open")
						{
						?>
							<td align="center" style="color:#87c540;"><?php echo $orderDetail[16]; ?></td>
					 	<?php
						}
						elseif($orderDetail[16]=="cancel"){
						?>
							<td align="center" style="color:red;"><?php echo $orderDetail[16]; ?></td>
						<?php
							}else{
						?>	
							<td align="center" style="color:#9932CC;"><?php echo $orderDetail[16]; ?></td>
					  
						<?php
						 }
						?>
					  
					 
					  <td >
					  
					  [ 
					    <a style="color: red;" href="#" 
					  onClick="MM_openBrWindow('rozelle_deliver.php?action=deliver_ord&oid=<?php echo $orderDetail[0]; ?>','OrdDeliver','scrollbars=yes,width=750,height=600')">
					  Deliver					  </a> ]
					  
					  
				<!--	  [ 
					    <a style="color: red;" href="#" 
					  onClick="MM_openBrWindow('rozelle_order_cancel.php?action=cancel_ord&oid=<?php //echo $orderDetail[0]; ?>','OrdCancel','scrollbars=yes,width=750,height=600')">
					  Cancel					  </a> ]
					  
					  [ 
					    <a style="color: red;" href="#" 
					  onClick="MM_openBrWindow('rozelle_order_delete.php?action=rozelle_ord&oid=<?php //echo $orderDetail[0]; ?>','OrdDelete','scrollbars=yes,width=750,height=600')">
					  Delete					  </a> ]  -->
					 
					 
					  
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
                            <div class="upper-block">Total Order(s): <?php echo count($oids);?></div>
                         <?php echo $pagination ?>
                        </div>
                  	<?php $uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');?>
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
