
<?php 
include_once('../classes/adminLogin.class.php'); 
include_once("../classes/utility.class.php"); 
require_once("../classes/customer.class.php"); 


//instantiate class
$numLogin 		= new adminLogin(); 
$utility		= new Utility();
$customer 		= new Customer();

//Customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);

?>
<link rel="stylesheet" type="text/css" href="../style/admin/admin.css"/>



    <div id="body-top">
    	<!-- Left -->
    	<div id="top-left">
        	<a href="../" target="_blank"><?php echo COMPANY_H; ?></a>
            <a href="admin.php"><?php echo COMPANY_A; ?></a>
        </div>
        
        <!-- Right -->
        <div id="top-right">
        	<div id="dropdown-options" title="Click Here to View Options">
            	<a href="javascript:void(0)">
            		<img src="../images/admin/icon/lock.png" width="30" height="30" alt="waintechnology" border="0" />
                </a>
                <div id="dropdown-back">
               		
                    <div class="logout">
                    	I am done with my work. <a href="logout.php" title="logout">Logout</a>
                    </div>
                </div>
            </div>
        	<div class="divider"></div>
			<?php 
            if(($userData[9] != '') && ( file_exists("../images/admin/user/".$userData[9])) )
            {
                echo '<div id="admin-image">';
                echo $utility->imageDisplay2('../images/admin/user/', $userData[9], 30, 30, 0, '', $userData[0]);	
                echo '</div>';	   
            }
            ?>
            
        	<div id="welcome">
            	Welcome, <?php echo $userData[2]; ?>
            </div>
            <div class="cl"></div>
        </div>
    </div>
    
    <div id="header">
    	
    </div>