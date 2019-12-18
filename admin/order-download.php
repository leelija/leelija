<?php
ob_start();
session_start();
?>
<?php 
//session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 

require_once("../classes/order.class.php"); 

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/adv_search.class.php");


require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();

$orders		    = new Orders();
$prodStatus			= new Pstatus();
$advSearch		= new AdvSearch();

$search_obj		= new Search();
$pages			= new Pagination();


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
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 100000);


//NO OF PRODUCTS
if((isset($_POST['btnSearch'])))
{

$keyword			= $_POST['keyword'];
$type			    = $_POST['type'];
//echo $keyword;exit;
	if($_POST['type'] ==""){
		$link = '';
		$oids = $search_obj->getOrdersProduct($keyword);
		//echo $sid;exit;
	}
	else{
		$link = '';
		$oids = $advSearch->getCommonSearchAdmin($keyword,$type,'orders_id','orders');
		
	}		
	
}
else
{
	$link = '';
	$oids = $orders->getAllOrd('orders_id','DESC');
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$link			= "numResDisplay=".$numResDisplay;

/* pagination*/
$adjacents = 3;

$total_pages = count($oids);
	
/* Setup vars for query. */
$targetpage = $_SERVER['PHP_SELF']."?".$link; 	//your file name  (the name of this file)
$limit = 100000; 	
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
<title><?php echo COMPANY_S; ?> -  - Orders Management</title>
<!-- Style -->
<link href="../style/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
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
                	
                   <div class="cl"></div>
				</div>
                
                
                <!-- Options -->
                <div id="options-area">
                	<div class="add-new-option">
                    	<input type="button" class="btn bg-orange margin" id="btnExport" value="Download" />
                    </div>
					
                </div>
                <!-- eof Options -->
                
                
                <!-- Display Data -->
                <div id="data-column">
                	
                <div id="dvData">    
                	<table >
                
					<?php 
					if(count($oids) == 0)
					{
					?>
                    <tr align="left" class="orangeLetter">
                      <td height="20" colspan="5">  <?php echo ERSPAN.ERPROD002.ENDSPAN; ?> </td>
                    </tr>
                    <?php 
                    }
                    else
                    {
                    ?>  
                    <thead width="100%">
                      <th>Orders Id</th>
                      <th>Design No. </th>
                     <!-- <th width="10%" >Party Name</th>-->
                      <th>Orders By</th>
					  <th>Order To</th>
                      <!--<th width="10%" >Total Quantity</th>-->
                      <th>Quantity & Colours Details </th>
					  <th > Remarks</th>
					  <th> order date</th> 
					  <th> Target Date</th> 
					  <th> Submit Date</th>
					 
                   </thead>
				   <tbody >
					<?php
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                       $oids = array_slice($oids, $start, $limit);     
                        foreach($oids as $x)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							$orderDetail = $orders->showOrders($x);
							$prodStatDtl =$prodStatus->showProductStatord($orderDetail[0]);
							$orderColourDtl = $orders->ordersDtlDisplay($orderDetail[0]);
							//print_r($prodDetail);exit;
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr >
					  <td ><?php echo $orderDetail[0]; ?></td>
					  <td><?php echo $orderDetail[1]; ?></td>
					   <td><?php echo $orderDetail[2]; ?></td>
					   
					    <td><?php echo $prodStatDtl[19]; ?></td>
						<!--<td><?php// echo $orderDetail[6]; ?></td>-->
						<td>
							[ 
								<a href="#" 
								onClick="MM_openBrWindow('order_color_dtl.php?action=color_dtl&oid=<?php echo $orderDetail[0]; ?>','OrdAssign','scrollbars=yes,width=500,height=400')">
								<?php	
								 foreach($orderColourDtl as $record)
								{
								 echo $record['colour'];echo "->";echo $record['quantity'];
								}
								 echo ';total->'; $orders->TotalQuantitySum($orderDetail[0]);	?>				  </a> ]
					    </td>
						
						
						  <td><?php echo $orderDetail[8]; ?></td>
						  <td><?php echo $orderDetail[9]; ?></td>
						  <td><?php echo $orderDetail[10]; ?></td>
						  
						  <td><?php echo $orderDetail[13]; ?></td>

					  
					  
					  
					 
					
				    </tr>
                  <?php 
                       
                        }
                  }
                  ?>
                 <tbody > 
                  </table>
                </div>  
                  <div class="first-column">
                 
                    	<!-- Bottom Pagination-->
                        <div class="pagination-bottom">
                            <div class="upper-block">Total Order(s): <?php echo count($oids);?></div>
                         <?php echo $pagination ?>
                        </div>
                  	<?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
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
 <script>
	$("#btnExport").click(function (e) {
	//alert("hi...");
	window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
	e.preventDefault();
});
</script>   
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
     
</body>
</html>
