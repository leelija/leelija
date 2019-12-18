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

require_once("../classes/employee.class.php"); 
require_once("../classes/stock.class.php"); 
require_once("../classes/sample.class.php"); 


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

$employee		= new Employee();
$search_obj		= new Search();
$pages			= new Pagination();

$stock			= new Stock();
$sample			= new Sample();


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
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 10);
$userId			= $utility->returnSess('userid', 0);

//NO OF PRODUCTS
if((isset($_POST['btnSearch'])))
{
$keyword			= $_POST['keyword'];
//echo $keyword;exit;
	$link = '';
	$sid = $search_obj->getSampleProduct($keyword);
	//echo $sid;exit;
}
elseif(isset($_GET['sid'])){
	$keyword	 	= $_GET['sid'];
	$link = '';
	$sid = $search_obj->getSampleProduct($keyword);
}

else
{
	$link = '';
	$sid = $sample->getAllSampDb('sample_id','DESC');
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$link			= "numResDisplay=".$numResDisplay;

/* pagination*/
$adjacents = 3;

$total_pages = count($sid);
	
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

/* eof pagination*/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> -  sample Management</title>
<!-- Style -->
<link href="../style/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../style/bootstrap/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">


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
                	<h1>Products Sample Details</h1>
                    
                     <div id="search-page-back">
                    	<form name="formAdvSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                           
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="search" />
                        </form>
                    </div>
                   <div class="cl"></div> 
                </div>
                
                <!-- Options -->
                <div id="options-area">
                	<!--<div class="add-new-option">
                    	<a href="<?php echo "sample_add.php"."?action=add_sample"; ?>">
                            Add New Sample
                        </a> 
                    </div>-->
                </div>
                <!-- eof Options -->
             <!-- <h2>Total Current Stock:<?php  //$stock->CurrentstockSum();?></h2>-->
                
                <!-- Display Data -->
                <div id="data-column">
                	
                    
                	<table class="single-column" cellpadding="0" cellspacing="0">
                
					<?php 
					if(count($sid) == 0)
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
                    <thead>
                      <th width="3%" height="25"  align="center">Sample Id</th>
					  <th width="10%" >Designer</th>
                      <th width="10%" >Design No. </th>
					  <th width="10%" >Colour</th>
                      <th width="10%" >Dyeing</th>
                      <th width="10%" >Hand</th>
					  <th width="10%" >M.Arri</th>
					  <th width="10%" >M.Embroidery</th>
                      <th width="10%" >C.Aari</th>
					  <th width="10%" >C.Embroidery</th>
					  <th width="10%" > Kali Cutting</th>
					 <th width="10%" > Final Stiching</th> 
                      <th width="15%" align="center">Action</th>
                   </thead>
					<?php
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                       $sid = array_slice($sid, $start, $limit);     
                        foreach($sid as $x)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							$sampleDetail 			= $sample->showSampleDb($x);
							$sampleDtlDetail 		= $sample->showSampleDtls($sampleDetail[0]);
							$empdata 				= $employee->showEmployee($sampleDetail[1]);
							//print_r($prodDetail);exit;
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					  <td align="left"><?php echo $sampleDetail[0]; ?></td>
					  <td align="center" ><?php echo $empdata[2]; ?></td>
					  <td align="center" ><?php echo $sampleDetail[3]; ?></td>
					   <td align="center">
						[ 
					    <a href="#" 
						  onClick="MM_openBrWindow('add_colours.php?action=add_colour&sid=<?php echo $sampleDetail[0]; ?>','addColour','scrollbars=yes,width=750,height=600')">
						  Add					  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('colour_view.php?action=view_colour&sid=<?php echo $sampleDetail[0]; ?>','viewsColour','scrollbars=yes,width=850,height=600')">
						  Views					  </a> ]
						
						</td>
						<td align="center">
							[ 
					    <a href="#" 
						  onClick="MM_openBrWindow('sample_dyeing_add.php?action=add_dyeing&sid=<?php echo $sampleDetail[0]; ?>','addColour','scrollbars=yes,width=850,height=600')">
						  Add					  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('sample_dyeing_view.php?action=view_dyeing&sid=<?php echo $sampleDetail[0]; ?>','viewsColour','scrollbars=yes,width=800,height=600')">
						  Views					  </a> ]
						
						</td>
						<td align="center">
								[ 
					    <a href="#" 
						  onClick="MM_openBrWindow('sample_hand_add.php?action=add_hand&sid=<?php echo $sampleDetail[0]; ?>','addColour','scrollbars=yes,width=750,height=600')">
						  Add					  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('sample_hand_view.php?action=view_hand&sid=<?php echo $sampleDetail[0]; ?>','viewsColour','scrollbars=yes,width=750,height=600')">
						  Views					  </a> ]
						
						
						</td>
					    <td align="center">
								[ 
					    <a href="#" 
						  onClick="MM_openBrWindow('sample_manual_add.php?action=add_manual&sid=<?php echo $sampleDetail[0]; ?>','addColour','scrollbars=yes,width=750,height=600')">
						  Add					  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('sample_manual_view.php?action=edit_manual&sid=<?php echo $sampleDetail[0]; ?>','viewsColour','scrollbars=yes,width=750,height=600')">
						  Views					  </a> ]
						
						
						</td>
						<td align="center">
								[ 
					    <a href="#" 
						  onClick="MM_openBrWindow('sample_manual_emb_add.php?action=add_manual&sid=<?php echo $sampleDetail[0]; ?>','addColour','scrollbars=yes,width=750,height=600')">
						  Add					  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('sm_emb_view.php?action=edit_manual&sid=<?php echo $sampleDetail[0]; ?>','viewsColour','scrollbars=yes,width=750,height=600')">
						  Views					  </a> ]
						
						
						</td>
						<td align="center">
							[ 
							<a href="#" 
						  onClick="MM_openBrWindow('sample_computer_add.php?action=add_computer&sid=<?php echo $sampleDetail[0]; ?>','addColour','scrollbars=yes,width=750,height=600')">
						  Add					  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('sample_computer_view.php?action=view_computer&sid=<?php echo $sampleDetail[0]; ?>','viewsColour','scrollbars=yes,width=750,height=600')">
						  Views					  </a> ]	
						</td>
						<td align="center">
							[ 
							<a href="#" 
						  onClick="MM_openBrWindow('sc_emb_add.php?action=add_computer&sid=<?php echo $sampleDetail[0]; ?>','addColour','scrollbars=yes,width=750,height=600')">
						  Add					  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('sc_emb_view.php?action=view_computer&sid=<?php echo $sampleDetail[0]; ?>','viewsColour','scrollbars=yes,width=750,height=600')">
						  Views					  </a> ]	
						</td>
						
						 <td align="center">
						 
							[ 
					    <a href="#" 
						  onClick="MM_openBrWindow('sample_kali_add.php?action=add_kali&sid=<?php echo $sampleDetail[0]; ?>','addColour','scrollbars=yes,width=750,height=600')">
						  Add					  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('sample_kali_view.php?action=view_kali&sid=<?php echo $sampleDetail[0]; ?>','viewsColour','scrollbars=yes,width=750,height=600')">
						  Views					  </a> ]
						 
						 
						 </td>
						 
						 <td align="center">
						 
							[ 
					    <a href="#" 
						  onClick="MM_openBrWindow('sample_final_stich_add.php?action=add_fstich&sid=<?php echo $sampleDetail[0]; ?>','addColour','scrollbars=yes,width=750,height=600')">
						  Add					  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('sample_final_stich_view.php?action=view_fstich&sid=<?php echo $sampleDetail[0]; ?>','viewsColour','scrollbars=yes,width=750,height=600')">
						  Views					  </a> ]
						 
						 
						 </td>
						 
						
					 
					  <td >
					  
					  [
					 <a style="color:red;" href="order_add.php?action=add_ord&sid= <?php echo $sampleDetail[0]; ?>" >
					  Order					  </a> ]			  					   					  
					   [
					 <a href="#" 
					  onClick="MM_openBrWindow('stock_edit.php?action=edit_sid&sid=<?php echo $x; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
					  edit					  </a> ]
					 
					  [ 
					  <a href="#" onClick="MM_openBrWindow('sample_delete.php?action=del_sample&sid=<?php echo $x; ?>','samDelete','scrollbars=yes,width=400,height=350')">
					  delete					  </a> ]<br>
                      
					 					  </td>		
                      
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
                            <div class="upper-block">Total sample Product(s): <?php echo count($sid);?></div>
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
