<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/user.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php");  
require_once("../classes/customer.class.php"); 
require_once("../classes/location.class.php"); 
include_once("../classes/countries.class.php");
require_once("../classes/subscriber.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/search.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$customer			= new Customer();
$lc		 		= new Location();
$country		= new Countries();
$subscribe		= new EmailSubscriber();
$page			= new Pagination();
$search_obj		= new Search();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

###############################################################################################

//declare vars
$typeM		= $utility->returnGetVar('typeM','');
$cus_id		= (int)$utility->returnGetVar('cus_id',0);


$cusDetail = $customer->getCustomerData($cus_id);

if(isset($_POST['btnEditCus']))
{
	//GET THE POST DATA
	//personal
	$txtEmail			= 	$_POST['txtEmail'];
	$txtUserName		= 	$_POST['txtUserName'];
	$txtFName			= 	$_POST['txtFName'];
	$txtLName			= 	$_POST['txtLName'];
	$txtOrg				= 	$_POST['txtOrg'];
	$txtDesc			= 	$_POST['txtDesc'];
	$txtProf			= 	$_POST['txtProf'];
	$txtGST				= 	$_POST['txtGST'];
	$txtLNum			= 	$_POST['txtLNum'];
	$selRetailerType	= 	$_POST['selRetailerType'];
	
	
	//address
	$txtAdd1			= 	$_POST['txtAdd1'];
	$txtAdd2			= 	$_POST['txtAdd2'];
	$txtTown			= 	$_POST['txtTown'];
	$txtProvince		= 	$_POST['txtProvince'];
	$txtPostCode		= 	$_POST['txtPostCode'];
	$txtTelephone		= 	$_POST['txtTelephone'];
	$txtFax				= 	$_POST['txtFax'];
	$txtMobile			= 	$_POST['txtMobile'];
	
	
	
	//misc
	
	$intOrder			= 	$_POST['intOrder'];
	
	$selCusType			= 	$_POST['selCusType'];
	
	$txtDisOff			= 	$_POST['txtDisOff'];
	
	//defining error variables
	$action		= 'edit_user';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $cus_id;
	$id_var		= 'cus_id';
	$anchor		= 'editCustomer';
	$typeM		= 'ERROR';
	
	//error check
	//check for duplicate val
	$duplicateId 	= $error->duplicateEntry($txtEmail, "email", "customer", "YES", $cus_id, "customer_id");
	$invalidEmail 	= $error->invalidEmail($txtEmail);
	
	
	//CHECK FIELD VALIDATION 
	if(preg_match("/^ER/",$invalidEmail))
	{
		$error->showErrorTA($action, $id, $id_var, $url, ER002, $typeM, $anchor);
	}
	elseif(preg_match("/^ER/",$duplicateId))
	{
		$error->showErrorTA($action, $id, $id_var, $url, ER001, $typeM, $anchor);
	}
	elseif($txtFName == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ER003, $typeM, $anchor);
	}
	elseif($txtLName == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ER004, $typeM, $anchor);
	}
	elseif($txtAdd1 == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ER521, $typeM, $anchor);
	}
	elseif($txtTown == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, ER529, $typeM, $anchor);
	}
	else
	{		
		
		$accVerifyNum=$customer->renderVerifyStr($cus_id, ERUVERF003, $cusDetail[16]);
		
		if($accVerifyNum=='')
		{
			$txtAccVerify='N';
		}
		else
		{
			$txtAccVerify='Y';
		}
		//edit the customer
	
		$customer->updateCustomer($cus_id, $selCusType, $txtUserName, $txtEmail, $txtFName, $txtLName, $txtGST, $txtLNum, 
							$selRetailerType, $txtAccVerify, $txtDesc, $txtOrg,$txtProf, $intOrder, $txtDisOff);
					
		//edit the address
		$customer->updateCusAddress($cus_id, $txtAdd1, $txtAdd2, '', $txtTown, $txtProvince, $txtPostCode, '38',
								 $txtTelephone,'', '', $txtMobile);
								 
								
								 		
		//update to the mass email system
		if(isset($_POST['checkNews']) && ($_POST['checkNews'] == 'yes'))
		{
			//news letter
			$customer->updateSubStat('a', $cusDetail[1]);
		}
		else
		{
			$customer->updateSubStat('d', $cusDetail[1]);
		}//if else
		
		
		//update admin image field		
		if(isset($_POST['delImg']) && ($_POST['delImg'] == 1))
		{
			$utility->deleteFile($cus_id, 'customer_id' ,'../images/user/', 'image', 'customer');
		}
		
		
		//uploading images
		if($_FILES['fileImage']['name'] != '')
		{
			//delete the image
			$utility->deleteFile($cus_id, 'customer_id' ,'../images/user/', 'image', 'customer');
		
			//rename the file
			$newName = $utility->getNewName4($_FILES['fileImage'], '',$cus_id);
			
			//upload and crop the file
			$uImg->imgCropResize($_FILES['fileImage'], '', $newName, '../images/user/', 200, 200, 
						         $cus_id,'image', 'customer_id', 'customer');
		}
		
		//update time
		$customer->updateDate($_GET['cus_id']);
		
		//forward
		$uMesg->showSuccessT('success', $cus_id, 'cus_id', $_SERVER['PHP_SELF'], SUU003, 'SUCCESS');
		
	}//end of else

}//eof

?>

<title><?php echo COMPANY_S; ?> - Edit Customer Info</title>

<!-- Style -->
<link href="../style/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112">
</script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<!-- eof JS Libraries -->

<table class="tblBrd" align="center" width="98%">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
    
    <?php 
    if(isset($_GET['action']) && ($_GET['action'] == 'edit_user'))
    {
    ?>
    <tr>
      <td height="25" align='left' bgcolor="#EEEEEE"><h3>Edit Customer</h3></td>
    </tr>
    <tr>
      <td>
      <div title="regsitration">
        <form name="formCustomerUpd"  id="formCustomerUpd" method="post" enctype="multipart/form-data"
        action="<?php echo $_SERVER['PHP_SELF']."?cus_id=".$cus_id;?>"> 
        
            <!-- personal detail -->
            <div class="padB20">
                <!--heading -->
                <div class="bdrB h25 w100P bld backLBlue"> 
                    <h4 class="padT5 padL5">Personal Detail </h4>
                </div>
                <div class="cl padB10"></div>
                <!--eof heading -->
                
                 
                 <!-- Customer Type-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="selCusType">
                            <span  class="menuText">Customer Type</span>
                            <span class="orangeLetter">*</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <?php 
                    $arr_value = array('1','2');
                    $arr_label = array('Retailer','Grower');
                    ?>
                      <select name="selCusType" id="selCusType" class="textBoxA">
                        <?php 
                           $utility->genDropDown($cusDetail[0], $arr_value, $arr_label); 
                        ?>
                      </select>
                    </div>
                    <div class="cl"></div>
                </div>
                            
                <!-- Retailer Type-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="selRetailerType">
                            <span  class="menuText">Retailer Type</span>
                            <span class="orangeLetter">*</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <?php 
                    $arr_value = array('1','2','3');
                    $arr_label = array('Head Shop','Hydro','Compassion');
                    ?>
                      <select name="selRetailerType" id="selRetailerType" class="textBoxA">
                        <?php 
                           $utility->genDropDown($cusDetail[8], $arr_value, $arr_label); 
                        ?>
                      </select>
                    </div>
                    <div class="cl"></div>
                </div>
                
                
                <!-- Contact Email-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtEmail">
                            <span  class="menuText">Contact Email</span>
                            <span class="orangeLetter">*</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtEmail" type="text" class="text_box_large" id="txtEmail" size="25" 
                    onBlur="verifyCus()" title="email"
                    value="<?php echo $cusDetail[2]; ?>" />
                    <span id='cusVerify'></span>
                    </div>
                    <div class="cl"></div>
                </div>
                
                 <!-- User name -->
                <div class="pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtUserName">
                            <span  class="menuText">User Name:</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtUserName" type="text" class="text_box_large" id="txtUserName" size="40"                                 
                    value="<?php echo $cusDetail[1]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                
               <!-- First Name-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtFName">
                            <span  class="menuText">First Name</span>
                            <span class="orangeLetter">*</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtFName" type="text" class="text_box_large" id="txtFName" size="40" 
                    onBlur="verifyFName('txtFName', 'First Name')" title="first name"
                    value="<?php echo $cusDetail[4];; ?>" />
                    <span id='fnResult'></span>
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- Last Name-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtLName">
                            <span  class="menuText">Last Name</span>
                            <span class="orangeLetter">*</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtLName" type="text" class="text_box_large" id="txtLName" size="40" 
                    onBlur="verifyLName('txtLName', 'Last Name')" title="last name"
                    value="<?php echo $cusDetail[5]; ?>" />
                    <span id='lnResult'></span>
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- Organization -->
                <div class="pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtOrg">
                            <span  class="menuText">Organization</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtOrg" type="text" class="text_box_large" id="txtOrg" size="40"                                 
                    value="<?php echo $cusDetail[13]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                
                <!-- Profession -->
                <div class="pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtProf">
                            <span  class="menuText">Profession</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtProf" type="text" class="text_box_large" id="txtProf" size="40"                                 
                    value="<?php echo $cusDetail[14]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- GST -->
                <div class="pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtGST">
                            <span  class="menuText">GST number</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtGST" type="text" class="text_box_large" id="txtGST" size="40"                                 
                    value="<?php echo $cusDetail[6]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- License -->
                <div class="pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtLNum">
                            <span  class="menuText">License Number</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtLNum" type="text" class="text_box_large" id="txtLNum" size="40"                                 
                    value="<?php echo $cusDetail[7]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
               
                <!-- Image-->
                <div class=" pad5 w100P">
                    <div class="w125 fl">
                        <label for="fileImage">
                            <span  class="menuText">Image</span>
                            <span class="orangeLetter">*</span>
                        </label>
                    </div>
                    <div class="fl padL20 blackLarge">
                    <input name="fileImage" type="file" class="text_box_large" id="fileImage" 
                    title="image" /><br />
                    200 Pixels &times; 200 Pixels in height by width <br />
					<?php 
					if( ($cusDetail[11] != '' ) && (file_exists("../images/user/".$cusDetail[11])) )
					{
						echo "<input name=\"delImg\" type=\"checkbox\" value=\"1\"> 
						<span class='blackLarge'>Delete this image</span>"; 
					}
					?>
                    </div>
                    <div class="padR20 fr padT3">
                         <?php 
							if(($cusDetail[11] != '') && ( file_exists("../images/user/".$cusDetail[11])) )
							{
								echo $utility->imageDisplay2('../images/user/', $cusDetail[11], 50, 50, 0, 'greyBorder', $cusDetail[4]);			   
							}
						 ?>
                    </div>
                    <div class="cl"></div>
                </div>
                
                              
                <!-- Description -->
                <div class="pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtDesc">
                            <span  class="menuText">Description</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <textarea name="txtDesc"  id="txtDesc" cols="30" rows="4"><?php echo $cusDetail[12]; ?></textarea>
                    <script language="JavaScript">
                      generate_wysiwyg('txtDesc');
                    </script>
                    </div>
                    <div class="cl"></div>
                </div>
                
                
                
            </div>
            <!--eof personal detail -->
            
        
            
            
            <!-- address -->
            <div class="padB20">
                <!--heading -->
                <div class="bdrB h25 w100P bld backLBlue"> 
                    <h4 class="padT5 padL5">Address + Contact </h4>
                </div>
                <div class="cl padB10"></div>
                <!--eof heading -->
                
                <!-- Address 1-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtAdd1">
                            <span  class="menuText">Address 1</span>
                            <span class="orangeLetter">*</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtAdd1" type="text" class="text_box_large" id="txtAdd1" size="40" 
                    onBlur="verifyAddress('txtAdd1', 'Address 1')" title="address 1"
                    value="<?php echo $cusDetail[24];; ?>" />
                    <span id='add1Verification'></span>
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- Address 2-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtAdd2">
                            <span  class="menuText">Address 2</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtAdd2" type="text" class="text_box_large" id="txtAdd2" size="40" 
                    title="address 2" value="<?php echo $cusDetail[25];; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- City /Suburb -->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtTown">
                            <span  class="menuText">Town</span>
                            <span class="orangeLetter">*</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtTown" type="text" class="text_box_large" id="txtTown" size="25" 
                    title="city/town/suburb" value="<?php echo $cusDetail[27]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                
                <!-- State-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtProvince">
                            <span  class="menuText">Province</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtProvince" type="text" class="text_box_large" id="txtProvince" size="25" 
                    title="state" value="<?php echo $cusDetail[28]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- Country-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtCountry">
                            <span  class="menuText">Country</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    Canada
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- Post Code-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtPostCode">
                        <span  class="menuText">Post Code</span></label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtPostCode" type="text" class="text_box_large" id="txtPostCode"
                     size="10" title="post code" maxlength="10" value="<?php echo $cusDetail[29]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- Phone Number-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtTelephone">
                        <span  class="menuText">Phone Number</span></label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtTelephone" type="text" class="text_box_large" 
                    id="txtTelephone" size="25" title="phone number" 
                    value="<?php echo $cusDetail[31]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                <!-- Mobile Number-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtMobile">
                            <span  class="menuText">Mobile</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtMobile" type="text" class="text_box_large" 
                    id="txtMobile" size="25" title="fax" 
                    value="<?php echo $cusDetail[34]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                 <!-- Fax -->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtFax">
                        <span  class="menuText">Fax</span></label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtFax" type="text" class="text_box_large" 
                    id="txtFax" size="25" title="phone number" 
                    value="<?php echo $cusDetail[33]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtDisOff">
                            <span  class="menuText">Discount Offered</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="txtDisOff" type="text" class="text_box_large" 
                    id="txtDisOff" size="25" title="discount offered" 
                    value="<?php echo $cusDetail[19]; ?>" />
                    </div>
                    <div class="cl"></div>
                </div>
                
            </div>
            <!--eof address -->
            
            
            <!-- miscellaneous detail -->
            <div class="padB20">
                <!--heading -->
                <div class="bdrB h25 w100P bld backLBlue"> 
                    <h4 class="padT5 padL5">Miscellaneous </h4>
                </div>
                <div class="cl padB10"></div>
                <!--eof heading -->
                
                <!-- Sorting Order-->
                <div class="h25 pad5 w100P">
                    <div class="w125 fl">
                        <label for="txtMobile">
                            <span  class="menuText">Sort Order</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="intOrder" type="text" class="text_box_large" id="intOrder"
                     value="<?php echo $cusDetail[15]; ?>" maxlength="3"  
                     onKeyPress="return intOnly(this, event)" />
                    </div>
                    <div class="padL20 fl padT3 blackLarge">
                        Order or clients to be displayed in the front page.
                    </div>
                    <div class="cl"></div>
                </div>
                
                
                <!-- News Letter-->
                <div class="h40 pad5 w100P">
                    <div class="w125 fl">
                        <label for="checkNews">
                            <span  class="menuText">News Letter</span>
                        </label>
                    </div>
                    <div class="fl padL20">
                    <input name="checkNews" id="checkNews" type="checkbox" class="" value="yes" 
					<?php 
                    $newsRes = $customer->checkEmailStat($cusDetail[2]); 
                    echo $utility->checkString($newsRes,'a');
                    ?> />
                    <span class="blackLarge">If Customer wants to receive News Letter</span>
                    </div>
                    <div class="cl"></div>
                </div>
                
                                
            </div>
            <!--eof miscellaneous detail -->
              
            <div class="padB20">
              <div class="fl w75">
              <input name="btnEditCus" type="submit" class="buttonYellow" id="btnEditCus" value="edit" />
              </div>
              <div class="w20 fl">&nbsp;<!----></div>
              <div class="fl">
              <input name="btnCancel" type="submit" class="buttonYellow" id="btnCancel" value="cancel" onClick="self.close()"  /> 
              </div>
           </div>
        </form>
        <!-- END OF REGISTRATION FORM -->
        </div>
      </td>
    </tr>
    <?php 
    }//test for check action type
    ?>
</table>