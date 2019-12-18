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

require_once("../classes/order.class.php"); 
require_once("../classes/stock.class.php");

require_once("../classes/sample.class.php"); 
require_once("../classes/plan.class.php"); 



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

$orders		    = new Orders();

$search_obj		= new Search();
$pages			= new Pagination();

$stock			= new Stock();
$plan			= new Plan();


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
	$noOfOrd = $plan->getPlanSerch($keyword);
	//echo $sid;exit;
}
else
{
	if(isset($_GET['plan_id']) && isset($_GET['status']))
	{
		$plan_id	= $_GET['plan_id'];
		//echo $user_id ; exit;
		$status		= $_GET['status'];
	}
	else
	{
		$plan_id	= 'all';
		$status		= 'all';
	}

	//NO OF ORDER
	$link = '';
	$noOfOrd	= $plan->getPlanCode($plan_id, $status);
	
	///$link = '';
	//$pid = $plan->getAllPlan('added_on','DESC');
}
/*	GET ALL PRODUCT*/
//print_r($pids);exit;

$total = count($noOfOrd);
$pageArray = array_chunk($noOfOrd, 20);


$newPage = array();
$name = "Page";
$numPages = ceil($total/20);

if(isset($_GET['mypage']))
{
 $myPage = $_GET['mypage'];
}
else
{
	$myPage = 'Array0';
}
//echo "MyPage = ".$myPage;

$arrayNum = explode("Array",$myPage);
//echo $arrayNum ; exit;

$pageNumber = (int)$arrayNum[1];
//echo $pageNumber ; exit;
//echo "Page Number = ".$pageNumber."<br>"; 

if($total == 0)
{
	$total = (int)$total;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> -  Plan Management</title>
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
                	<h1>Plan Details</h1>
                    
                     <div id="search-page-back">
                    	<form name="formAdvSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                           
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="search" />
                        </form>
                    </div>
                   <div class="cl"></div> 
                </div>
                
				
			  <div class="menuText padB10">
			    <span>
                <img src="images/arrows.gif">
			    View Plan :&nbsp;&nbsp;&nbsp;&nbsp; 
                   <a href="<?php echo $_SERVER['PHP_SELF']."?plan_id=all&status=all"; ?>">All </a>&nbsp;&nbsp;|&nbsp;&nbsp;
                   <a href="<?php echo $_SERVER['PHP_SELF']."?plan_id=all&status=Dyeing"; ?>">Dyeing </a>&nbsp;&nbsp;|&nbsp;&nbsp;
                   <a href="<?php echo $_SERVER['PHP_SELF']."?plan_id=all&status=Hand"; ?>">Hand </a>&nbsp;&nbsp;|&nbsp;&nbsp;
                   <a href="<?php echo $_SERVER['PHP_SELF']."?plan_id=all&status=Manual"; ?>">Manual </a>&nbsp;&nbsp;|&nbsp;&nbsp;
                   <a href="<?php echo $_SERVER['PHP_SELF']."?plan_id=all&status=Computer"; ?>">Computer </a>&nbsp;&nbsp;|&nbsp;&nbsp;
				    <a href="<?php echo $_SERVER['PHP_SELF']."?plan_id=all&status=Kali Cutting"; ?>">Kali Cutting </a>&nbsp;&nbsp;|&nbsp;&nbsp;
                   <a href="<?php echo $_SERVER['PHP_SELF']."?plan_id=all&status=Final Stiching"; ?>">Final Stiching </a>&nbsp;&nbsp;|&nbsp;&nbsp;
                   <a href="<?php echo $_SERVER['PHP_SELF']."?plan_id=all&status=Iron"; ?>">Iron </a>			   
                </span>			  
               </div>
				
                <!-- Options -->
              <!--  <div id="options-area">
                	<div class="add-new-option">
                    	<a href="<?php //echo "plan_add.php"."?action=add_plan"; ?>">
                            Add New Plan
                        </a> 
                    </div>
                </div>-->
                <!-- eof Options -->
             <!-- <h2>Total Current Stock:<?php  //$stock->CurrentstockSum();?></h2>-->
                
                <!-- Display Data -->
                <div id="data-column">
                	
                    
                	<table class="single-column" cellpadding="0" cellspacing="0">
                
					<?php 
					if(count($noOfOrd) == 0)
					{
					?>
                    <tr align="left" class="orangeLetter">
                      <td height="20" colspan="5">  <?php echo "No Plan Has Been Added So Far."; ?> </td>
                    </tr>
                    <?php 
                    }
                    else
                    {
                    ?>  
                    <thead>
                      <th width="3%" height="25"  align="center">plan Id</th>
                     <th width="10%" >Order Id. </th>
					 <th width="10%" >Design No. </th>
					  <th width="10%" >Quantity</th>
                      <th width="10%" >Status</th>
					  <th width="10%" >Employee Id</th>
                      <th width="10%" >Start Date</th>
                      <th width="10%" >End Date</th>
					  <th width="10%" >Issue Date </th>
					  <th width="10%" >Remarks </th>
                      <th width="15%" align="center">Action</th>
                   </thead>
					<?php
                        $i = 1;
                      // $k = $pages->getPageSerialNum($numResDisplay);
                       //$pid = array_slice($pid, $start, $limit);     
                        foreach($pageArray[$pageNumber] as $j => $value)
                            {
							$k = $pageArray[$pageNumber][$j];
							$planDetail = $plan->getShowPlan($k, '');
							//$planDetail = $plan->showPlan($x);
							//print_r($prodDetail);exit;
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="center"<?php $utility->printRowColor($bgColor);?>>
					  <td align="center"><?php echo $planDetail[0]; ?></td>
					  <td align="center" ><?php echo $planDetail[1]; ?></td>
					  <td align="center" ><?php echo $planDetail[2]; ?></td>
					   <td align="center"><?php echo $planDetail[3]; ?></td>
					   <td align="center"><?php echo $planDetail[4]; ?></td>
					  <td align="center" ><?php echo $planDetail[5]; ?></td>
					  <td align="center" ><?php echo $planDetail[6]; ?></td>
					   <td align="center"><?php echo $planDetail[7]; ?></td>
					   <td align="center"><?php echo $planDetail[8]; ?></td>
					   <td align="center"><?php echo $planDetail[9]; ?></td>
					   <td align="center">
					   
					   [ 
					    <a href="#" 
						  onClick="MM_openBrWindow('plan_edit.php?action=update_plan&pid=<?php echo $planDetail[0]; ?>','editPlan','scrollbars=yes,width=750,height=600')">
						  edit					  </a> ]
						[ 
					    <a href="#" 
						  onClick="MM_openBrWindow('plan_update.php?action=update_plan&pid=<?php echo $planDetail[0]; ?>','editPlan','scrollbars=yes,width=750,height=600')">
						  issue	date				  </a> ]
						 
						   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('delete_plan.php?action=delete_plan&pid=<?php echo $planDetail[0]; ?>','deletePlan','scrollbars=yes,width=200,height=250')">
						  Delete				  </a> ]
						
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
                            <div class="upper-block">Total Plan(s): <?php echo count($noOfOrd);?></div>
                         <?php //echo $pagination ?>
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
