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
						<li  ><a href="index.php" class="scroll">Design Status</a></li>
						<li  ><a href="due-order.php" class="scroll">Due Order</a></li>
						<li><a href="bookno-status.php" class="scroll">Book No. Status</a></li>
						<li><a href="upcomming-production.php" class="scroll">Up Comming Prod.</a></li>
						<li><a href="incomplete-prod.php" class="scroll">Incomplete Prod.</a></li>
						<li><a href="gr-dtls.php" class="scroll">GR Details</a></li>
						<li><a href="logout.php" class="scroll">LogOut</a></li>
					</ul>
				</div>
				
				<div class="clearfix"> </div>
			</div>
		</div>
		
	</div>
	
