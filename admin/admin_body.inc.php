<?php 
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/static.class.php");
include_once("../classes/customer.class.php");


require_once("../classes/date.class.php");
include_once("../classes/hits.class.php"); 

require_once("../classes/utility.class.php");
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityCurl.class.php");
require_once("../classes/utilityNum.class.php"); 
require_once("../classes/utilityStr.class.php"); 

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();

$stat			= new StaticContent();
$customer		= new Customer();

$dateUtil      	= new DateUtil();
$hits 			= new Hits();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uCurl 			= new CurlUtility();
$uNum 			= new NumUtility();
$uStr 			= new StrUtility();


##################################################################################################################

$statIds 	= $utility->getAllId('static_id', 'static');

//top 3
$staticTop5 = $uNum->getTopMost($statIds, 5);

?>
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">

<div id="dashboard-main">

	<div id="welcome">
    	<h1>Welcome to <?php echo COMPANY_S; ?> Admin Dashboard</h1>
        <div id="server-date"><?php  echo date("F d, Y");?></div>
        <div class="cl"></div>
    </div>
    
    <!-- Left -->
    <div id="dashboard-left">
    	<div class="block-element">
        
            <!-- Manage Content -->
            <div id="manage-content">
            	<div class="content-left">
                	<h2>Quick Access</h2>
                    <ul>
                    	<li>
                        	<a href="static.php?action=add_static#addStatic" title="static.php?action=add_static#addStatic">
                            Just Remember to Add a Page</a>
                            </li>
                    	<li><a href="order_add.php?action=add_order#addOrder" title="Add an Order">Add an Order</a></li>
                        <li>
                        	<a href="social_site.php?action=add_social_site#addSocialSite" title="Display My Social Networking">
                        		Display My Social Networking
                            </a>
                        </li> 
                        <li><a href="navigation.php" title="Manage <?php echo COMPANY_S; ?> Header Link">Manage <?php echo COMPANY_S; ?> Header Link</a></li>
                        <li><a href="email_export.php" title="Download All Newsletter Subscriber">Download All Newsletter Subscriber</a></li>
                    </ul>
                    
                </div>
                <div class="content-right">
                    <h2>Recently Added Webpages</h2>
                    <?php 
					if(count($staticTop5) > 0)
				 	{
					?>
					<ul>
					<?php 
						foreach($staticTop5 as $s)
						{
							$staticDtl 	= $stat->getStaticData($s);
							//echo $staticDtl[14] ; exit;
					?>
                    	<li>
                        	<a href="../content.php?seo_url=<?php echo $staticDtl[14]; ?>" target="_blank">
                           	 <?php echo $staticDtl[1]; ?>
                            </a>
                        </li>
                    <?php 
						}
					?>	
                    </ul>
                    <?php 
					}
					else
					{
						echo "No Content!!!";
					}
					?>
                    
                </div>
                <div class="cl"></div>
            </div>
            
        </div>
    </div>
    <!-- eof Left -->
    
    <!-- Right -->
    <div id="dashboard-right">
    	<div class="block-element">
        	
            <!-- Statistics -->
            <div id="view-statistics">asa
            <br /><br />
            </div>
            
        </div>
    </div>
    <!-- eof Right -->
    
    <div class="cl"></div>
    
</div>