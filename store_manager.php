<?php 
ob_start();
session_start();

//include_once('checkSession.php');
require_once("_config/connect.php"); 

require_once("includes/constant.inc.php");
require_once("includes/user.inc.php");
require_once('classes/encrypt.inc.php');

require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php");  
require_once("classes/customer.class.php"); 
require_once("classes/location.class.php"); 
include_once("classes/countries.class.php");
//require_once("../classes/subscriber.class.php");
require_once("classes/pagination.class.php");
require_once("classes/search.class.php");

require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php"); 
require_once("classes/utilityImage.class.php");
require_once("classes/utilityNum.class.php");
require_once("classes/utilityStr.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$customer		= new Customer();
$lc		 		= new Location();
$country		= new Countries();
//$subscribe		= new EmailSubscriber();
$pages			= new Pagination();
$search_obj		= new Search();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();
$uStr 			= new StrUtility();

###############################################################################################

//declare vars
$typeM		= $utility->returnGetVar('typeM','');
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 10);

$userId			= $utility->returnSess('userid', 0);
if($userId==0)
{
header("Location: index.php");
}

$cusDetail 	= $customer->getCustomerData($userId);
$CustomerTypeDtl=$customer->getCustomerTypeData($cusDetail[0]);
if($CustomerTypeDtl[1] != "store_manager")
{
header("Location: index.php");
}
$cusDetail[5]
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Client Profile</title>

<!-- Style -->
<link rel="stylesheet" type="text/css" href="style/admin/admin.css" />
<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/utility.js"></script>
<script type="text/javascript" src="js/advertiser.js"></script>
<script type="text/javascript" src="js/location.js"></script>
<script type="text/javascript" src="js/checkEmpty.js"></script>
<script type="text/javascript" src="js/email.js"></script>
<!-- eof JS Libraries -->

</head>

<body>
	<!-- Header -->
	<?php require_once('header.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<div id="admin-menu">
				<?php require_once('menu1.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                <!-- Admin Top -->
                <div id="admin-top">
                	<h1>My Profile</h1>
                    
                    <!-- Search -->
                    <div id="search-page-back">
                    	<form name="formAdvSearch" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input name="keyword" type="text" class="search-text" id="keyword" placeholder="Keyword.." results="5"
                          	value="<?php $utility->printGet('keyword');?>" />
                            <div class="search-option">
                           		<div id="dropdown-page-options">
                            		<a href="javascript:void(0)" onClick="showHideDiv('dropdown-page-back', '');">
                                    	Options<img src="../images/admin/icon/search-arrow.png" width="5" height="5" alt="search" />
                                    </a>
                                    <div id="dropdown-page-back" style="display:none">
                                        <p class="required">
                                          Note: if you do not use any keyword, you would be able to display listing according to
                                          the selected criteria.
                                        </p>
                                        
                                        <label>First Name</label>
										<input name="txtFName" type="search" class="text_box_large" id="txtFName" placeholder="First Name.."  
                                        results="5" value="<?php $utility->printGet('txtFName');?>">
                                        <div class="cl"></div>  
                                        
                                        <label>Last Name</label>
										<input name="txtLName" type="search" class="text_box_large" id="txtLName" placeholder="Last Name.."  
                                        results="5" value="<?php $utility->printGet('txtLName');?>">
                                        <div class="cl"></div>       
                                        
                                        <label>Address</label>
										<input name="loc" type="search" class="text_box_large" id="loc" placeholder="Address.."  results="5"
                                        value="<?php $utility->printGet('loc');?>">
                                        <div class="cl"></div>         
										
										<label>Select Status</label>
										<?php 
                                           $arr_value	= array('a','d','');
                                           $arr_label	= array('active','inactive',' Status ');
                                        ?>
                                        <select class="textBoxA" name="selStatus" id="selStatus">
                                            <?php 
                                                if(isset($_GET['selStatus']))
                                                {
                                                    $utility->genDropDown($_GET['selStatus'], $arr_value, $arr_label);
                                                }
                                                else
                                                {
                                                    $utility->genDropDown('', $arr_value, $arr_label);
                                                }
                                            ?>
                                          </select>		  
                                          <div class="cl"></div>
                                          
                                          <label>Result Per Page</label>      
                                          <?php echo  $utility->dispResPerPage($numResDisplay, '');?>	
                                		  <div class="cl"></div>
                                          
                            		</div>
                                </div>
                            </div>
                            <input type="submit" class="search-button" name="btnSearch" id="btnSearch" value="Search" />
                        </form>
                    </div>
                    <!-- eof Search -->
                    <div class="cl"></div>
                </div>
                <!-- eof Admin Top -->
                
                <!-- Options -->
                <div id="options-area">
                	
                	<!--<div class="add-new-option">
                    	<a href="<?php //echo "client_add.php?action=add_client"; ?>">Add New Client </a>
                    </div>-->
                </div>
                <!-- eof Options -->
                
                
                <!-- Display Data -->
                <div id="data-column">
                
                    <!-- First Column-->
                	<div class="first-column">
                    	<?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                        <!-- Data -->
                        <table cellpadding="0" cellspacing="0">
                        <?php 
                        if(count($userId) == 0)
                        {
                        ?>
                        <tr>
                          <td height="20" colspan="4"> <?php echo ERU100; ?></td>
                         </tr>
                        <?php 
                        }
                        else
                        {
                        ?>  
                         
                        <thead>
                          <th width="9%">No.</th>
                          <th width="28%">Name</th>
                          <th width="21%">Verified</th>
                          <th width="16%">Added On</th>
                          <th width="22%">Action</th>
                        </thead>
                        
                            <tr <?php //$utility->printRowColor($bgColor);?>>
                              <td><?php echo $cusDetail[38] ?></td>
                              <td>
                                <?php echo $cusDetail[5]." ".$cusDetail[6]; ?> </td>
                              <td>
                                <a href="javascript:void(0)" 
                                 onClick="MM_openBrWindow('customer_acc_info_verify.php?action=edit_user&cus_id=<?php echo $userId; ?>','ContractorEdit','scrollbars=yes,width=600,height=450')">
                                <?php 
                                    echo $customer->renderVerifyStr($userId, ERUVERF003, $cusDetail[16]);
                                ?>
                                </a>
                              </td>
                              <td><?php echo $dateUtil->printDate($cusDetail[22]); ?></td>
                              <td>
                              [ 
                              <a href="<?php echo $_SERVER['PHP_SELF']. "?"."action=view&cus_id=".$userId.$link  ?>">
                              view</a> ]
                              
                             
                                 
        
                              
                              <br />
                              
                              </td>
                           </tr>
                      <?php 
                            }
                      
                      ?>
                      </table>
                	
                    	<!-- Bottom Pagination-->
                      <!--  <div class="pagination-bottom">

                            <div class="upper-block">Total  Client: <?php //echo count($noOfCus);?></div>
                            <?php //echo $pagination ?>
                        </div>-->
                        
                    </div>
                    
                    <!-- Gap-->
                    <div class="column-gap">&nbsp;</div>
                    
                    <!-- Second Column -->
                    <div class="second-column">
                    	
                        
                        
                        <!-- Detail Block -->
                        
                        <?php 
						  if(isset($_GET['action']) && ($_GET['action'] == 'view'))
						  {
							if(isset($_GET['cus_id']) && ($_GET['cus_id'] > 0))
							{
								$noEntry = $utility->getNoOfEntry($_GET['cus_id'], 'customer_id', 'customer');
								$cus_id	= $_GET['cus_id'];
								
								if($noEntry > 0)
								{
									$cus_id	= $_GET['cus_id'];
									$cusDtl 	= $customer->getCustomerData($cus_id);
									
									$CustomerTypeDtl=$customer->getCustomerTypeData($cusDtl[0]);
						 ?>
                         	<div class="detail-block">
                        		<h4> 
								<?php 
									echo $utility->imgDisplayR('../images/user/', $cusDtl[9], 100, 100, 0, 'greyBorder', $cusDtl[3], '');
								?>
								<?php echo $cusDtl[5]." ".$cusDtl[6]; ?>
                                </h4>
                                
                                <h5>General View</h5>
                                <p><label>Created on</label> <?php echo $dateUtil->printDate($cusDtl[22]); ?> </p>
                               <!-- <p><label>Modified on</label> <?php //echo $dateUtil->printDate($cusDtl[23]); ?> </p>-->
                                <p><label>Customer Post:</label> <?php echo $CustomerTypeDtl[1]; ?> </p>
                              <!--  <p><label>Sort Order</label> <?php //echo $cusDtl[15]; ?> </p>
                                <p><label>News Letter</label> <?php //echo $utility->getStatusMesg($customer->checkEmailStat($cusDtl[8])); ?> </p>
                                -->
                                
                                <h5>Personal</h5>
                                <p><label>First Name</label> <?php echo $cusDtl[5]; ?> </p>
                                <p><label>Last Name</label> <?php echo $cusDtl[6]; ?> </p>
                                <p><label>Email</label> <?php echo $cusDtl[3]; ?> </p>
                                <p><label>Current Password</label> <?php echo md5_decrypt($cusDtl[4],USER_PASS); ?> </p>
                                <p><label>Change Password</label> 
                                <a href="javascript:void(0)" onClick="MM_openBrWindow('customer_pass_edit.php?action=edit_pass&user_id=<?php echo $cus_id; ?>','EditAdvertiserPass','width=450,height=250')">
				    			Edit Password 
                                </a>
                                 </p>
                                
                                
                                <?php 
									//$CustomerTypeDtl=$customer->getCustomerTypeData($cusDtl[0]);
								?>
                                
                               <!-- <h5>Professional Info</h5>
                                <p><label>Organization:</label> <?php //echo $cusDtl[12]; ?> </p>
                                <p><label>Profession:</label> <?php //echo $CustomerTypeDtl[1]; ?> </p>
                                
                                -->
                                
                                <h5>Address Info</h5>
                                <p><label>Address</label> <?php echo $cusDtl[24]; ?> </p>
                                <p><label>Phone</label> <?php echo $cusDtl[31]; ?> </p>
                                <p><label>Mobile</label> <?php echo $cusDtl[34]; ?> </p>
                                <p><label>Fax</label> <?php echo $cusDtl[33]; ?> </p>
                                <p><label>Town/City</label> <?php echo $cusDtl[27]; ?> </p>
                                <p><label>Province</label> <?php echo $cusDtl[28]; ?> </p>
                                <p><label>Country</label> 
									<?php 
										$countryDtl= $country->showCountry($cusDtl[30]);
										echo $countryDtl[0];
									?> 
                                </p>
                                <p><label>Postal Code</label> <?php echo $cusDtl[29]; ?> </p>


                            </div>
                         <?php 
								}
							}
						  }
						 ?>
                        
                        <!-- eof Detail Block -->
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
