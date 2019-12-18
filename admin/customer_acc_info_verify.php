<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php");
require_once("../includes/user.inc.php");
require_once("../includes/registration.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../classes/customer.class.php"); 
//require_once("../classes/contact.class.php");

 
require_once("../classes/utility.class.php");
require_once("../classes/utilityMesg.class.php");
require_once("../classes/utilityAuth.class.php");
require_once("../classes/utilityStr.class.php");
require_once("../classes/error.class.php"); 


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$utility		= new Utility();
$customer		= new Customer();
//$cont2			= new Contact();

$uMesg 			= new MesgUtility();
$uAuth 			= new AuthUtility();
$uStr 			= new StrUtility();

////////////////////////////////////////////////////////////////////////////////////////

$typeM			= $utility->returnGetVar('typeM','');
$cus_id			= $utility->returnGetVar('cus_id','');


//customer detail
$customerDtl	= $customer->getCustomerData($cus_id);


//edit account
if(isset($_POST['btnSubmit']))
{
	//post vars
	$verficationNo	= $_POST['verficationNo'];
	
	
	//status var
	$chkAcc			= $utility->returnPostVar('chkAcc', 'N');  
	$user			= $_SESSION['MadkjhdOGADM_session2011_00'];
	
	//defining error variables
	$action		= 'edit_user';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $_GET['cus_id'];
	$id_var		= 'cus_id';
	$typeM		= 'ERROR'; 
	$aname		= 'editVerStatus';
	
	
	
//validation
if( $verficationNo == '' )
{
	$error->showErrorTA($action, $id, $id_var, $url, ERUVERF004, $typeM, $aname);
}
else if( $chkAcc == 'N' )
{
	$error->showErrorTA($action, $id, $id_var, $url, ERUVERF005, $typeM, $aname);
}
else
{
	//edit verification no
	$customer->updateVerNo($cus_id, $verficationNo);
	
	//edit verification status
	$customer->updateVerStatus($cus_id, $chkAcc, $user);
	
	//update access time
	$uAuth->updateAccessTime('customer_id', $cus_id, 'customer_info');
	
	/*  Start of Mail functionality to be added in the server */	
	$subject = "Account Verified";
	$to 	 = $customerDtl[5]." ".$customerDtl[6]. "<".$customerDtl[2].">";//Himadri <himadri.s.roy@ansysoft.com>
	$from 	 = "Mad Dog <customerservice@check-kit.ca>";
	
	// now we encode it and split it into acceptable length lines
	$body = '
				<div style="width: 100%; height:auto; font:normal 13px Georgia, Times, Arial, Verdana, sans-serif;
							color: #000000; bachground-color:#fff;">
					<div style="padding:10px; margin:0px auto;" align="center">
						<img src="'.URL.LOGO_WITH_PATH.'" height="'.LOGO_HEIGHT.'" width="'.LOGO_WIDTH.'" 
						 alt="'.LOGO_ALT.'" />
					</div>
					
					<div style="width: 650px; height:auto; margin:0px auto 10px auto; padding:20px 10px;
								font:normal 12px Helvetica, Arial, Verdana, sans-serif;
								color: #000000; bachground-color:#FCFCFC; -moz-border-radius: 4px; -webkit-border-radius: 4px;
								border:1px solid #eee;">

						<h2 style="font:bold 12px Arial, Verdana, sans-serif;width:650px; height:30px;
								   background-color:#DCDCC7; color:#7C6677; text-align:center; line-height:30px;
								   vertical-align:middle; padding:0; margin:0">
							Account Verified
						</h2>
						
						<p>Dear '.$customerDtl[5].',</p>
						<p>Your account information has been verified by the administrator. </p>
						<p>Below is the new verification detail:</p>
						
						<p style="padding:10px">
							Verification No: '.$verficationNo.'<br />
							Fully Verified: '.$uStr->displayPF($chkAcc).'
						</p>
						
						<p>
						Regards,<br />
						Customer Service<br />
						'.COMPANY_S.'</p>
					</div>
			
			</div>
			';
	/* End of body part */
	
	//headers
	$headers = "From: ".$from."\n";
	$headers .= "Return-Path: <customerservice@check-kit.ca>\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1";
	
	//send mail
	@mail($to, $subject, $body, $headers);
	
	//forwarding		
	$uMesg->showSuccessT('success', $id, $id_var, $_SERVER['PHP_SELF'], SUUVERF002.'&verficationNo='.$verficationNo, 'SUCCESS');

	
}//else

}//edit
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo COMPANY_S; ?> - Verify Account</title>

<!-- Include CSS-->
<link href="../style/style.css" rel="stylesheet" type="text/css">
<!-- End Include CSS-->

<!-- Javascript Libraries -->
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/user.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script language="javascript" type="text/javascript" src="../js/registration.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
		
	 

<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {color: #333333}
.style3 {color: #666666}
.style4 {color: #000000}
-->
</style>
</head>
<body>			
<table class="tblBrd" align="center" width="100%">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
			
	<?php 
	//edit user
	if(isset($_GET['action']) && ($_GET['action'] == 'edit_user'))
	{
	?>
	<tr>
	  <td height="25" align='left' bgcolor="#EEEEEE">
		  <h3>Verify Account - <?php echo " ".$customerDtl[5]." ".$customerDtl[6]; ?></h3>
	  </td>
	</tr>
	<tr>
	  <td>
	  <div class="menuText">
	  <form action="<?php echo $_SERVER['PHP_SELF']."?cus_id=".$cus_id;?>" method="post" 
	  name="formRegister" id="formRegister">
		
		<table width="545" border="0" class="blackLarge2">
		  <tr class="textlight">
			<td colspan="4" class="textdark pad5">
				<?php 
                if( ($customerDtl[16] == '') || ($customerDtl[35] == 'N')  )
                {
                    $clsStyle	= "erBlock";
                }
                else
                {
                    $clsStyle	= "suBlock";
                }
                
                ?>			
                <div class="<?php echo $clsStyle; ?>">
				
				<div class="padR20 padT5 bld">
				<?php 
					echo $customer->renderVerifyStr($cus_id, ERUVERF001, SUUVERF001);
				?>
				</div>
				
				<!-- Verification Numbers -->
				<div class="padT20 padB20">
				
					<!-- Account Verification-->
					<div class="pad5 fl w15">
                    
					<input name="chkAcc" type="checkbox" value="Y" id="chkAcc" onclick="genVerCodeForCus(<?php echo $cus_id ?>)"
					<?php echo $utility->checkString($customerDtl[35],"Y"); ?> />   
					
					</div>
					
					<div class="pad5 fl w200">
					Account Verified
					</div>
					
					<div class="cl"></div>
                    
					<div class="padB10">
						PLEASE REVIEW THE DETAIL
					</div>
					
					<!-- Verification Number -->
					<div class="pad5 fl w200">
						VERIFICATION NO.					
					</div>
					<div class="pad5 fl w200">
						<input name="verficationNo" type="text" id="verficationNo"
						class="text_box_large h25" value="<?php echo $customerDtl[16];?>" />
					</div>
					
					<div class="cl"></div>
					
					
					
				
				</div>
				
				
								
			</div>				
			<!-- End Block -->
			
			</td>
		</tr>
		  
	    <tr>
			<td colspan="4" class="pad10"> 
				
				<div class="fl w75">				
				<input name="btnSubmit" type="submit" class="buttonYellow" id="btnSubmit" 
				value="Submit"  />				
				</div>
				<div class="fl w75 padL10">
				<input name="btnCancel" type="submit" class="buttonYellow"  
				value="Cancel" onClick="window.close()"  />
				</div>
				<div class="cl"></div>
							
			</td>
		  </tr>
		</table>
	</form>
	<!-- END OF REGISTRATION FORM -->
	</div>
	  </td>
	</tr>
	<?php 
	}//test for check action type
	?>
</table>
</body>
</html>