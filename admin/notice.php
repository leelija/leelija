<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php");

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/category.class.php"); 

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/news.class.php");
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$category		= new Cat();
$search_obj		= new Search();
$page			= new Pagination();
$news 			= new News();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();
///////////////////////////////////////////////////////////////////////////////////////// 

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$keyword		= $utility->returnGetVar('keyword','');
$type			= $utility->returnGetVar('type','');
$mode			= $utility->returnGetVar('mode','');

$numResDisplay = 0;

if(isset($_GET['numResDisplay']))
{
	$numResDisplay = (int)$_GET['numResDisplay'];
}
else
{
	$numResDisplay = 10;
}

if((isset($_GET['btnSearch'])) &&($_GET['btnSearch'] == 'search'))
{
	//keyword
	if(isset($_GET['keyword']))
	{
		$keyword = $_GET['keyword'];
	}
	else{ $keyword = '';}
	
	//status
	if(isset($_GET['status']) && ($_GET['status'] != ''))
	{
		$status 		= $_GET['status'];
	}
	else
	{ 
		$status 		= 'ALL';
	}//location
	
	//category
	if(isset($_GET['txtParentId']) && ((int)$_GET['txtParentId'] > 0))
	{
		$txtParentId = (int)$_GET['txtParentId'];
	}
	else
	{
		$txtParentId = 0;
	}//category
	
	
	$mode = '';
	$type = '';
	$numResDisp = '&numResDisplay='.$numResDisplay;
	$catLink 	= "&txtParentId=".$txtParentId;
	$statLink	= "&status=".$status;
	$link 		= "&btnSearch=search&keyword=".$_GET['keyword']."&mode=&type=".$type.$statLink.$catLink.$numResDisp;
	
	//search dir
	$noOfNews = $search_obj->searchNews($keyword, $txtParentId, $status);
}
else
{
	$link = '';
	$noOfNews	= $news->getNewsId(0, '');
}
/*START PAGINATION*/


$total = count($noOfNews);
$pageArray = array_chunk($noOfNews, $numResDisplay);


$newPage = array();
$name = "Page";
$numPages = ceil($total/$numResDisplay);

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

$pageNumber = (int)$arrayNum[1];
//echo "Page Number = ".$pageNumber."<br />";

if($total == 0)
{
	$total = (int)$total;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?>-  -News Management</title>
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
                	<h1>Notice</h1>
                    
                    <div id="search-page-back">
                    	<form name="formSampleSearch" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                            
                            <div class="search-option">
                            
                            </div>
                            <input name="mode" type="hidden" value="product">
                            <input name="type" type="hidden" value="name">
                            <input name="btnSearch" type="submit" class="search-button" id="btnSearch" value="search">
                        </form>
                    </div>
                   <div class="cl"></div> 
                </div>
                
                <!-- Options -->
                <div id="options-area">
                	<div class="add-new-option">
                    	<a href="<?php echo "notice_add.php"."?action=add_feed"; ?>">
                            Add Notice
                        </a> 
                    </div>
                </div>
                <!-- eof Options -->
                
                
                <!-- Display Data -->
                <div id="data-column">
                	
                    
                	<table class="single-column" cellpadding="0" cellspacing="0">
                
					<?php 
					if(count($noOfNews) == 0)
					{
					?>
                    <tr align="left" class="orangeLetter">
                      <td height="20" colspan="5">  <?php echo "No notice has been added so far"; ?> </td>
                    </tr>
                    <?php 
                    }
                    else
                    {
                    ?>  
                    <thead>
                      <th width="3%" height="25"  align="center">#</th>
                      <th width="19%" >Title </th>
                      <th width="16%" >Category</th>
                      <th width="33%" >Summary</th>
                      <th width="7%"  align="center"> Status</th> 
                      <th width="7%" >Added On </th>
                      <th width="15%" align="center">Action</th>
                   </thead>
					<?php
                        
                       $k = $page->getSerialNum(20);
                             
                        foreach($pageArray[$pageNumber] as $j => $value)
                            {
							$x = $pageArray[$pageNumber][$j];
							
							$newsDtl	= $news->getNews($x);
							//print_r($newsDtl);exit;
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					  <td align="left"><?php echo $k++; ?></td>
					  <td><?php echo $newsDtl[0]; ?></td>
					  <td><?php echo $newsDtl[7]; ?></td>
					  <td><?php echo $newsDtl[1]; ?></td>					    
					  <td><?php   ?></td>
					  <td><?php echo $dateUtil->printDate($newsDtl[6]); ?></td>
					  <td >
					  [ 
					    <a href="#" 
					  onClick="MM_openBrWindow('notice_edit.php?action=edit_news&news_id=<?php echo $x; ?>','NewsEdit','scrollbars=yes,width=750,height=600')">
					  edit					  </a> ]
					 
					  [ 
					  <a href="#" onClick="MM_openBrWindow('notice_delete.php?action=del_news&news_id=<?php echo $x; ?>','NewsDelete','scrollbars=yes,width=400,height=350')">
					  delete					  </a> ]					  </td>
				    </tr>
                  <?php 
                       
                        }
                  }
                  ?>
                  
                  </table>
                  
                  <div class="first-column">
                 
                    	<!-- Bottom Pagination-->
                        <div class="pagination-bottom">
                            <div class="upper-block">Total News(es): <?php echo count($noOfNews);?></div>
                            <div class="lower-block"><?php $page->getPage($numPages, $link, $pageNumber, $pageArray);?>
                            </div>
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
    
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
     
</body>
</html>
