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

require_once("../classes/report.class.php");


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

$orders		    = new Orders();

$search_obj		= new Search();
$pages			= new Pagination();

$report			= new Report();

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



$txtDesignNo			= $_GET['txtDesignNo'];
$txtFromDate			= $_GET['txtFromDate'];
$txtToDate				= $_GET['txtToDate'];
//echo $txtDesignNo;

$rozDueDetails	= $report->showRozDueOrd($txtDesignNo);
$curentstock	= $report->showCurrentStock($txtDesignNo);
?>
	<br><br><br>
		<h2 style="float:left;">Total Current Stock:
			<a href="#" >
				<?php  $report->CurtstockSum($txtDesignNo);?>
			</a>
		</h2><br><br>
			<h2>Current stock Details</h2>
				<table class="single-column" cellpadding="0" cellspacing="0">
                
					<?php 
					if(count($curentstock) == 0)
					{
					?>
                    <tr align="left" class="orangeLetter">
                      <td height="20" colspan="5">  <?php echo "Current Stock Not Available"; ?> </td>
                    </tr>
                    <?php 
                    }
                    else
                    {
                    ?>  
                    <thead>
                      <th width="10%" >Design No. </th>
                      <th width="10%" >Current Stock</th>
                      <th width="10%" >Colour</th>
                   </thead>
					<?php
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                       foreach( $curentstock as $eachrecord ){
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                    <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					  
						<td align="center"><?php echo $eachrecord ['design_no']; ?></td>
						<td align="center"><?php echo $eachrecord ['quantity']; ?></td>
						<td align="center"><?php echo $eachrecord ['colour']; ?></td>
					 	
                      
					 					  
				    </tr>
                  <?php 
                       
                        }
                  }
                  ?>
                  
				</table>
		<br>	
		<h2 style="float:left;">Total Due Rozelle Order:
			<a href="#" >
				<?php  $report->DueRozOrder($txtDesignNo);?>
			</a>
		</h2><br><br>	
		<h2>Due Rozelle Order Details</h2>	
		
		<table class="single-column" cellpadding="0" cellspacing="0">
                
					<?php 
					if(count($rozDueDetails) == 0)
					{
					?>
                    <tr align="left" class="orangeLetter">
                      <td height="20" colspan="5">  <?php echo "Due Not Available"; ?> </td>
                    </tr>
                    <?php 
                    }
                    else
                    {
                    ?>  
                    <thead>
                      <th width="10%" >Order Id </th>
                      <th width="10%" >Book No</th>
                      <th width="10%" >Party Code </th>
					  <th width="10%" >Design No. </th>
                      <th width="10%" >Order Quantity</th>
                      <th width="10%" >Due Quantity</th>
					  <th width="10%" >Pay Quantity </th>
                      <th width="10%" >Colour</th>
                      <th width="10%" >Order Date </th>
					  <th width="10%" >Target Date  </th>
                   </thead>
					<?php
                        
                       $k = $pages->getPageSerialNum($numResDisplay);
                       foreach( $rozDueDetails as $eachrecords ){
							$bgColor 	= $utility->getRowColor($k);	
                    ?>
                    <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					  
						<td align="center"><?php echo $eachrecords ['orders_id']; ?></td>
							<td align="center"><?php echo $eachrecords ['book_no']; ?></td>
							<td align="center"><?php echo $eachrecords ['party_code']; ?></td>
							<td align="center"><?php echo $eachrecords ['design_no']; ?></td>
							<td align="center"><?php echo $eachrecords ['quantity']; ?></td>
							<td align="center"><?php echo $eachrecords ['due_quantity']; ?></td>
							<td align="center"><?php echo $eachrecords ['pay_quantity']; ?></td>
							<td align="center"><?php echo $eachrecords['colour']; ?></td>
							<td align="center"><?php echo $eachrecords ['order_date']; ?></td>
							<td align="center"><?php echo $eachrecords ['target_date']; ?></td>
					 	
                      
					 					  
				    </tr>
                  <?php 
                       
                        }
                  }
                  ?>
                  
				</table>
				
	<br><br>
<h2> Pipe line status</h2>
					