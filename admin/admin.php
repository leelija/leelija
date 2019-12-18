<?php 
session_start();
include_once('checkSession.php');
include_once('../_config/connect.php');

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
 
require_once("../classes/error.class.php"); 
require_once("../classes/customer.class.php");
require_once("../classes/pagination.class.php");


require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$client		    = new Customer();
//$cat			= new Cat();
//$search_obj		= new Search();
$page			= new Pagination();
$customer		= new Customer();
$page			= new Pagination();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

#########################################################################################################################



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Admin Control Panel</title>
    
<link rel="stylesheet" type="text/css" href="../style/admin/admin.css" />

<script type="text/javascript" src="../js/jQuery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../js/jquery-1.10.1.js"></script>
<script type="text/javascript" src="../js/jQuery/jquery.min.js"></script>
<script type="text/javascript" src="../js/jQuery/jquery.slimscroll.js"></script>
<script type="text/javascript" src="../js/jQuery/jquery.slimscroll.min.js"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function()
 {
	$('.option-block').hover(function()
	{
		
		var id		= $(this).attr('id');
		var dId		= id+"-dropdown";
		/*$("#"+dId).slideDown();*/
		$("#"+dId).css({display:'block'});
		
	},function()
	{
		var id		= $(this).attr('id');
		var dId		= id+"-dropdown";
		/*$("#"+dId).slideUp();*/
		$("#"+dId).css({display:'none'});
	});
 });
</script>




<script type="text/javascript">
function startTime()
{
	var today=new Date();
	d=today.toString('dddd, MMMM ,yyyy');
	//document.getElementById('server-date').innerHTML= d;
	t=setTimeout('startTime()',500);
}

function checkTime(i)
{
	if (i<10)
  	{
  		i="0" + i;
 	}
	return i;
}
</script>

</head>

<body onload="startTime()">
<script src="../js/highcharts.js"></script>	
    <!-- Header -->
	<?php require_once('header.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<!-- Left content-->
        	<div id="left-content">
            <!--	<div id="logo">
                	<img src="../<?php echo LOGO_ADMIN_PATH; ?>" width="<?php echo LOGO_ADMIN_WIDTH; ?>" 
   					 height="<?php echo LOGO_ADMIN_HEIGHT; ?>" alt="<?php ; ?>" />
                </div>-->
                <!-- Statistics-->
                <div id="statistics">
                    <div id="hits">
                    </div>
                    <div id="user" class="marT20">
                    </div>
                    <div id="org" class="marT20">
                    </div>
                </div>
                <!-- eof Statistics-->
            </div>
            <!-- eof Left content-->
            
            <!-- Main section-->
            <div id="main-section">
            	<h1>Welcome to <?php echo COMPANY_S; ?> Admin Dashboard</h1>
                <div class="cl"></div>
                <div class="option">
               
                    <div id="static" class="option-block">
                    	<div id="static-dropdown" class="option-dropdown">
                        	<ul>
                                <li><a href="order.php" title="Static Categories">Product Orders</a></li>
                                <li><a href="stock_product.php" title="Web Pages">Product Stock </a></li>
								<li><a href="stock_prod_details.php" title="Product Status">Stock Products Details</a></li>
								<li><a href="stock_prodin_show.php" title="Web Pages">Product In </a></li>
								<li><a href="product_saleshow.php" title="Product Status">Sales Product</a></li>
                            </ul>
                        </div>
                    	<img src="../images/admin/icon/order.jpg" width="99.9%" >
                        <div class="option-title">Products Order</div>
                    </div>
                    
                    <div id="marketing" class="option-block">
                    	<div id="marketing-dropdown" class="option-dropdown">
                        	<ul>
                                <li><a href="fabric.php" title="Email Group">Fabric</a></li>
                                <li><a href="show_fabric_in.php" title="Send Email">Fabric In </a></li>
                                <li><a href="show_fabric_out.php" title="E-mail Export">Fabric Out </a></li>
                                
                            </ul>
                        </div>
                    	<img src="../images/admin/icon/product.jpg" width="99.9%" >
                        <div class="option-title">Fabric IN/OUT </div>
                    </div>
                    <div id="setup" class="option-block">
                    	<div id="setup-dropdown" class="option-dropdown">
                        	<ul>
                            	<li><a href="admin_user.php" title="Admin Users" >Admin Users</a></li>
                                <li><a href="back_up.php" title="Database Backup" >Database Backup</a></li>
                            </ul>
                        </div>
                    	<img src="../images/admin/icon/set-up.jpg" width="99.9%" >
                        <div class="option-title">Setup Tools</div>
                    </div>
					
					
					
                    <div id="account" class="option-block">
                    	<div id="account-dropdown" class="option-dropdown">
                        	<ul>
                            	<li><a href="stich_rate.php" title="Admin Users" >Stich Rate</a></li>
                                <li><a href="labour.php" title="Database Backup" >Labour Account</a></li>
                            </ul>
                        </div>
                    	<img src="../images/admin/icon/set-up.jpg" width="99.9%" >
                        <div class="option-title">Account</div>
                    </div>
					
					
					
					
					
					
					
                    
                    <div class="cl"></div>
                </div>
                <div class="miscellaneous">
                	
					
					
                </div>
                
            </div>
            <!-- eof Main section-->
            <div class="cl"></div>
		
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
</body>
</html>