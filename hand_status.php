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
$advSearch		= new AdvSearch();


$prodStatus			= new Pstatus();
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
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 100);

$usersId			= $utility->returnSess('userid', 0);
if($usersId == 579){
	$userId = 537;
}else{
	$userId			= $utility->returnSess('userid', 0);
}

// search function
if((isset($_POST['btnSearch'])))
{
$keyword			= $_POST['keyword'];
$type			    = $_POST['type'];
//echo $keyword;exit;
	if($_POST['type'] ==""){
		$link = '';
		$sid = $search_obj->getHandPipelinestore($keyword,$userId);
		//echo $sid;exit;
	}
	else{
		$link = '';
		$sid = $advSearch->getCommonSearch($keyword,$type,$userId,'hand_id','hand_table');
		
	}		
}
elseif(isset($_GET['ord_id'])){
	$keyword	 	= $_GET['ord_id'];
	$link = '';
	$sid = $search_obj->getHandPipelinestore($keyword,$userId);
}
else
{
	$link = '';
	//$sid	= $status->getAllPstatus($user_id, $status);
	$sid = $statusCat->getAllHand('added_on','DESC',$userId);
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$link			= "numResDisplay=".$numResDisplay;

/* pagination*/
$adjacents = 3;

$total_pages = count($sid);
	
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Product Status</title>

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
                	<h1>Hand Status</h1>
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
					<a href="file_download.inc.php?table=hand_table">Download(1)</a>
					<a href="hand-status-download.php">View & Download</a>
                </div>
                <!-- eof Download option -->
               
                <!-- Display Data -->
                <div id="data-column">
                	
                	<table class="single-column" cellpadding="0" cellspacing="0">
                
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
                          <th width="5%" >order Id </th>
                          <th width="10%"  >Design No</th>
						  <th width="5%" >Quantity </th>
						  <th width="10%"  >employeeId</th>
						  <th width="10%"  >HandWorker</th>
						  <th width="5%" >Bill NO</th>
                          <th width="13%"  >Order Date </th>
                          <th width="10%" >Target Date</th>
						  <th width="10%" >Submit Date</th>
						  <th width="10%" >R.day</th>
						  <th width="10%" >Work</th>
						  <th width="10%" >Colour</th>
						  <th width="18%"  >Hand(left)</th>
                          <th width="18%"  >Hand(complete)</th>
						  <th width="18%"  >Remarks</th>
						  <th width="18%"  >Status</th>
                          <th width="34%"  align="center">Action</th>
                        </thead>
                       <?php 
							$k = $pages->getPageSerialNum($numResDisplay);
							$sid = array_slice($sid, $start, $limit);     
                        foreach($sid as $x)
                            {
							//$x = $pageArray[$pageNumber][$j];
							$statusCatDetail 	= $statusCat->showProductHand($x);
							$customerDetail 	= $client->getCustomerData($statusCatDetail[5]);
							
							$ordDtls 		= $order->showOrders($statusCatDetail[2]);
							// update factory
							$prodStatus->updatePipeLine($statusCatDetail[2],$ordDtls[14],'hand_table');
							
							//print_r($prodDetail);exit;
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
						<td align="center">
							<a href="#" onClick="MM_openBrWindow('status_details.php?action=status_details&oid=<?php echo $statusCatDetail[2]; ?>','AdminDelete','scrollbars=yes,width=500,height=400')">
							<?php echo $statusCatDetail[2]; ?>	 </a> 
						</td>
						<td align="center"><?php echo $statusCatDetail[3]; ?></td>
						<td align="center">
                          <a href="#" onClick="MM_openBrWindow('status_details.php?action=status_details&oid=<?php echo $statusCatDetail[2]; ?>','AdminDelete','scrollbars=yes,width=500,height=400')">
                          <?php	$order->TotalQuantitySum($statusCatDetail[2]);	?>	 </a> 
						</td>
						
					    <td align="center"><?php echo $statusCatDetail[4]; ?></td>
					    <td align="center">
						  <a href="#" onClick="MM_openBrWindow('emp_details.php?action=emp_details&emp_id=<?php echo $statusCatDetail[5]; ?>','AdminDelete','scrollbars=yes,width=500,height=400')">
						  <?php echo $customerDetail[5]; ?>	 </a> 
						</td>
					   
						<td align="center">
							<p href="#" onClick="MM_openBrWindow('hbill-change.php?action=bill_details&id=<?php echo $statusCatDetail[0]; ?>','AdminDelete','scrollbars=yes,width=500,height=400')">
							 <?php echo $statusCatDetail[17]; ?>
							</p> 
						</td>
						
						<!--   <td align="center"><?php //echo $statusCatDetail[18]; ?></td>   -->
						<td align="center"><?php echo $statusCatDetail[9]; ?></td>
						<td align="center"><?php echo $statusCatDetail[10]; ?></td>
						<td align="center"><?php echo $statusCatDetail[13]; ?></td>
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
						   <td align="center" style="color:red;"><?php echo $diff->format("%R%a days"); ?></td>
						   <?php
							}
							else{
						   ?>
						   <td align="center" style="color:blue;"><?php echo $diff->format("%R%a days"); ?></td>
						   <?php
								}
							} else{	
						   ?>
						   <td align="center" style="color:#34a853;"><?php echo $diffordtarget->format("%R%a days"); ?></td>
						   <?php
						   }
						   ?>
						<td align="center"><?php echo $statusCatDetail[19]; ?></td>	   
					   	<td align="center"><?php echo $statusCatDetail[18]; ?></td>			  
						<td align="center"><?php echo $statusCatDetail[7]; ?></td>
						<td align="center"><?php echo $statusCatDetail[15]; ?></td>
						<td align="center"><?php echo $statusCatDetail[8]; ?></td>
					   
					    <?php 
					   if($statusCatDetail[7] == 0)
						{
							$statusCat->editHandstatus($statusCatDetail[0],'Complete');
					   ?>
					   <td align="center"><?php echo $statusCatDetail[16]; ?></td>
					   <?php
						  }
						  else{
								if($statusCatDetail[15]==0)
								{
									if($diff->format("%R%a days")>=0)
									{
										$statusCat->editHandstatus($statusCatDetail[0],'Running');
									}	
									else{
										$statusCat->editHandstatus($statusCatDetail[0],'Incomplete');
									}
								}
								else{
									$statusCat->editHandstatus($statusCatDetail[0],'Running');
								}
						?>
						<td align="center"><?php echo $statusCatDetail[16]; ?></td>
					   <?php
						  }
						?>  
					   
                          <!-- <td><?php //if($cusDetail[1] == '0000-00-00 00:00:00') {echo 'no login';} else {echo $cusDetail[4];} ?></td> -->
                          <td  align="center">
                          
                         [ 
                          <a href="#" onClick="MM_openBrWindow('hand_update.php?action=update_hand&dhmckfip=<?php echo $statusCatDetail[0]; ?>','AdminDelete','scrollbars=yes,width=700,height=600')">
                          Update Hand				  </a> ]
						  
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
                            <div class="upper-block">Total Report: <?php echo count($sid);?></div>
                            <div class="lower-block"><?php //$pages->getPage($numPages, $link, $pageNumber, $pageArray);?>
                             <?php echo $pagination ?>
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
   

	<script>
		$("#btnExport").click(function (e) {
		//alert("hi...");
		window.open('data:application/vnd.ms-excel,' + $('#data-column').html());
		e.preventDefault();
		});
	</script> 
</body>
</html>