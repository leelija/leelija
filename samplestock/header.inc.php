<?php
include_once('../classes/adminLogin.class.php'); 
include_once("../classes/utility.class.php"); 
require_once("../classes/customer.class.php"); 
//instantiate class
$numLogin 		= new adminLogin(); 
$utility		= new Utility();
$customer		= new Customer();

//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);
//echo $userData[2];exit;
?>

<div class="header">
		<div class="header-top">
			<div class="container">
				<div class="header-grid">
					<ul>
						<li  ><a href="all-collection.php" class="scroll" target="null">All Collection</a></li>
						<li  ><a href="collection.php" class="scroll">MEP </a></li>
						<li  ><a href="hmda-collection.php" class="scroll">HMDA</a></li>
						<li><a href="top-order.php" class="scroll">TOP ORDER</a></li>
						<li><a href="highest-stock.php" class="scroll">HIGHEST STOCK</a></li>
						<li><a href="mep-computer.php" class="scroll">MEP COMPUTER</a></li>
						<?php
						//	if($userData[2] == 'Safikul'){
						?>	
							<li><a target="null" href="report.php" class="scroll">Report</a></li>
							<li><a target="null" href="account.php" class="scroll">Account</a></li>
						<?php	
					//	}
						?>
						<li><a href="sales-report.php" class="scroll">SALES REPORT</a></li>
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

<script src="js/jquery-compat-3.0.0-alpha1.js"></script>	
<script>
/*$(function() {
    // Focus on load
    $('.search-text').focus();
    // Force focus
    $('.search-text').focusout(function(){
        $('.search-text').focus();
    });
    // Ajax Stuff
    $('.search-text').change(function() {
        $.ajax({
            async: true,
            cache: false,
            type: 'post',
            url: '/echo/html/',
            data: {
                html: '<p>This is your object successfully loaded here.</p>'
            },
            dataType: 'html',
            beforeSend: function() {
               // window.alert('Scanning code');
            },
            success: function(data) {
                window.alert('Success');
                $('.objectWrapper').append(data);
            },
            // Focus
            complete: function() {
                $('.search-text').val('').focus();
            }
        });
    });
});
*/
</script>