<?php
ob_start();
session_start();
?>
<?php 
//session_start();
//include_once('checkSession.php');
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
require_once("../classes/sample.class.php"); 
require_once("../classes/photo_gallery.class.php");
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
$sample			= new Sample();
$search_obj		= new Search();
$pages			= new Pagination();
$photogallery	= new PhotoGAllery();
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
	$oids = $orders->getAllLSTOrd('orders_id','DESC');
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



<style>
#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>


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
                	<h1>Order Details</h1>
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
											<option value="orders_id">Order Id</option>
											<option value="design_no">Design No.</option>
											<option value="party_name">Party Name</option>
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
                
                
                <!-- Options -->
                <div id="options-area">
                	<div class="add-new-option">
                    	<a href="<?php echo "order_add.php"."?action=add_ord"; ?>">
                            Add New orders
                        </a> 
                    </div>
					<a href="order-download.php">download</a>
                </div>
                <!-- eof Options -->
                
                
                <!-- Display Data -->
                <div id="data-column">
                	
                <div id="dvData">    
                	<table width="100%" class="single-column" cellpadding="0" cellspacing="0">
                
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
                      <th width="5%" height="25"  align="center">Orders Id</th>
                      <th width="5%" >Design No. </th>
                     <!-- <th width="10%" >Party Name</th>-->
                      <th width="5%" >Orders By</th>
					  <th width="5%" >Order To</th>
                      <!--<th width="10%" >Total Quantity</th>-->
                      <th width="25%" >Quantity & Colours Details </th>
					  <th width="10%" > Factory</th>
					 <th width="5%" > order date</th> 
					 <th width="5%" > Target Date</th> 
					  <th width="5%" > Submit Date</th>
					  <th width="15%"  align="center"> Photo</th> 
					<th width="5%"  align="center">Status </th> 
                      <th width="15%" align="center">Action</th>
                   </thead>
					<?php
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                       $oids = array_slice($oids, $start, $limit);     
                        foreach($oids as $x)
                            {
							//$x = $pageArray[$pageNumber][$j];
							
							$orderDetail 			= $orders->showOrders($x);
							$prodStatDtl 			= $prodStatus->showProductStatord($orderDetail[0]);
							$orderColourDtl 		= $orders->ordersDtlDisplay($orderDetail[0]);
							
							$factoryDtls 			= $sample->showFactory($orderDetail[14]);
							
							$photoGallDtls 			= $photogallery->showSampleGalleryDgn($orderDetail[1]);
							//print_r($prodDetail);exit;
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?> <?php if($orderDetail[15] == 'Cancel'){ ?> style="background-color:red;" 
					<?php }else{}?>>
					  <td align="center"><?php echo $orderDetail[0]; ?></td>
					  <td align="center"><?php echo $orderDetail[1]; ?></td>
					   <td align="center"><?php echo $orderDetail[2]; ?></td>
					   
					    <td align="center"><?php echo $prodStatDtl[19]; ?></td>
						<!--<td><?php// echo $orderDetail[6]; ?></td>-->
						<td align="center">
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
						
						
						  <td align="center"><?php echo $factoryDtls[1]; ?></td>
						  <td align="center"><?php echo $orderDetail[9]; ?></td>
						  <td align="center"><?php echo $orderDetail[10]; ?></td>
						  
						  <td align="center"><?php echo $orderDetail[13]; ?></td>

                      <td align="center">
					 	<?php 
						$imgId		= $orders->getDefaultOrdImg($x);
						
						if(count($photoGallDtls[6]) != 0)
						{
							
							if(($photoGallDtls[6] != '') && ( file_exists("../images/spgallery/thumb/".$photoGallDtls[6])) )
							{
						?>		
							<!--<img id="myImg" src="../images/spgallery/large/<?php echo $photoGallDtls[6];?>" alt="<?php echo $photoGallDtls[6];?>" width="50" height="50">-->
							<div class="column">
								<img src="../images/spgallery/large/<?php echo $photoGallDtls[6];?>" width="50" height="50" onclick="openModal();currentSlide(<?php echo $orderDetail[0]; ?>)" class="hover-shadow cursor">
							</div>
						
						<?php	
							}
						}
						?>
                      </td>
					  
					  <td align="center"><?php echo $orderDetail[15]; ?></td>
					  
					  
				<!--	  <td >  -->
					<!--  [ 
					    <a href="plan.php" style="color:red;">
					  View Plan					  </a> ]   -->
				<!--	  [ 
					  
					    <a href="#" 
					  onClick="MM_openBrWindow('assign_job.php?action=assi_job&oid=<?php echo $x; ?>','OrdAssign','scrollbars=yes,width=750,height=600')">
					  Assign					  </a> ]  -->
					  
				<!--	  </td>  -->
					
					 
					  <td >
					  
				<!--		  [ 
							<a href="plan_add.php?action=add_plan&oid= <?php //echo $orderDetail[0]; ?>" style="color:red;">
						  Make a Plan					  </a> ]      -->
						  [ 
							<a href="#" 
						  onClick="MM_openBrWindow('order_edit.php?action=edit_ord&oid=<?php echo $x; ?>','OrdEdit','scrollbars=yes,width=750,height=600')">
						  edit					  </a> ]
						 
						  [ 
						  <a href="#" onClick="MM_openBrWindow('order_delete.php?action=del_ord&oid=<?php echo $x; ?>','OrdDelete','scrollbars=yes,width=400,height=350')">
						  delete					  </a> ]<br>
						 [ 
						  <a href="#" onClick="MM_openBrWindow('order_add_image.php?action=add_img&oid=<?php echo $x; ?>','AddImg','scrollbars=yes,width=700,height=600')">
						  Add Image					  </a> ]
						  [ 
						  <a style="color:#34a853;" href="#" onClick="MM_openBrWindow('order_colour_add.php?action=Add_ord&oid=<?php echo $orderDetail[0]; ?>','OrdAdd','scrollbars=yes,width=700,height=600')">
						  Add more colour					  </a> ]
						  [ 
						  <a style="color:#34a853;" href="order_sheet.php?orderId=<?php echo $orderDetail[0]; ?>">Order Sheet</a>
						  ]
							
						[ 
						  <a style="color:#34a853;" href="#" onClick="MM_openBrWindow('order_cancel.php?action=Can_ord&oid=<?php echo $orderDetail[0]; ?>','OrdCan','align=right','scrollbars=yes,width=400,height=400')">
						  Cancel					  </a> ]  
					  </td>
				    </tr>
                  <?php 
                       
                        }
                  }
                  ?>
                  
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
	<!-- The Modal -->
	<div id="myModal" class="modal">
	  <span class="close">&times;</span>
	  <img class="modal-content" id="img01">
	  <div id="caption"></div>
	</div>
	<!-- The Modal End-->
	
	
 <script>
	$("#btnExport").click(function (e) {
	//alert("hi...");
	window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
	e.preventDefault();
});
</script>  

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}
</script>	


 
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
     
</body>
</html>
