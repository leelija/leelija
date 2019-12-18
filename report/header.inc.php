<?php
include_once('../classes/adminLogin.class.php'); 
include_once("../classes/utility.class.php"); 
require_once("../classes/customer.class.php"); 

//instantiate class
$numLogin 		= new adminLogin(); 
$utility		= new Utility();
$customer		= new Customer();


//User detail
//$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);
//echo $userData[2];exit;
?>

<div class="header">
		<div class="header-top">
			<div class="container">
				<div class="header-grid">
					<ul>
						<li  ><a href="index.php">Dashboard</a></li>
						<li  ><a href="daily-exp.php" class="scroll">Daily Expenses</a></li>
						<li  ><a href="hmda-collection.php" class="scroll">Gallery</a></li>
						<li><a href="top-order.php" class="scroll">Top Order</a></li>
						<li><a href="highest-stock.php" class="scroll">Highest Stock</a></li>
						<li><a href="comp-report.php" class="scroll">Comp Report</a></li>
						<li><a href="report.php" class="scroll">Monthly Report </a></li>
						<li><a href="sales-report.php" class="scroll">Sales Report</a></li>
						<li><a href="net-report.php" class="scroll">RPT</a></li>
						<!--<li><a href="#" class="scroll">Notification</a></li>-->	
						<li><a href="logout.php" class="scroll">LogOut</a></li>	
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<!--<div class="container">-->
			<div class="header-bottom-bottom">
				
				<div class="search">
					<form name="formAdvSearch" method="POST" action="gproducts-details.php">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Search" results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                           
						    
						    <input name="type" type="hidden" value="" />
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="" />
                    </form>
				</div>
				<div class="clearfix"> </div>
			</div>
		<!--</div>-->
	</div>
	
