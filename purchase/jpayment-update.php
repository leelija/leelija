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

require_once("../classes/purchase.class.php"); 
require_once("../classes/stock.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/customer.class.php"); 
require_once("../classes/journal.class.php"); 

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();

$purchase		= new Purchase();
$search_obj		= new Search();
$pages			= new Pagination();
$customer		= new Customer();
$journal		= new Journal();

$stock			= new Stock();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$jb_id			= $utility->returnGetVar('jb_id','0');
date_default_timezone_set('Asia/Calcutta'); 
//echo date("Y-m-d H:i:s"); // time in India
$attDate 		= date("d-m-Y");// Date
//echo $attDate;exit;
//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);

if(isset($_POST['btnDeleteOrd']))
{	
	//Assets Details
	$assetsDtls 		= $journal->showAssetsAcc(1);
	$jbookDtls	 		= $journal->showJournalBook($jb_id);
	if($jbookDtls[11] == 0){
	
	if($assetsDtls[3] >= $jbookDtls[3])
		{
			//Update Journal Book
			$journal->UpdatejBookPayment($jb_id,1,$userData[2]);
			
			
			//Journal account data
			$jAccDtls 		= $journal->showJournalAcc($jbookDtls[1]);
			$jAccBalance 	= $jAccDtls[3] + $jbookDtls[3];
			
			// Update Journal Account
			$journal->UpdateJournalAccount($jbookDtls[1], $jAccDtls[1],$jAccDtls[2],$jAccBalance,$userData[2]);
			
			//Assets
			$asstBalance 		= $assetsDtls[3] - $jbookDtls[3];
			// Update Assets Account
			$journal->UpdateAssets(1,$assetsDtls[1],$assetsDtls[2],$asstBalance,$userData[2]);
			
		
			// ==== Send SMS =======
			$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
			$apisender = "MoniEn";
			$msgs =" Cash ".$jbookDtls[3]." Payment to ".$jbookDtls[4].", on ".$attDate.", ".$jbookDtls[10]." Purpose. Now Account Balance:".$asstBalance.".";
			$number = 9836664554;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
			//echo $num;exit;
			$mss = rawurlencode($msgs);   //This for encode your message content                 		
			$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$number.'&text='.$mss.'&route=1';
													 
			//echo $url;
			$ch=curl_init($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,"");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
			$data = curl_exec($ch);	
			//end
			
			// ==== Send SMS =======
			/*$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
			$apisender = "MoniEn";
			$msgs =" Cash ".$jbookDtls[3]." Payment to ".$jbookDtls[4].", ".$jbookDtls[10]." Purpose. Now Account Balance:".$asstBalance.".";
			$number = 9830445482;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
			//echo $num;exit;
			$mss = rawurlencode($msgs);   //This for encode your message content                 		
			$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$number.'&text='.$mss.'&route=1';
													 
			//echo $url;
			$ch=curl_init($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,"");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
			$data = curl_exec($ch);	*/
			//end
			// ==== Send SMS =======
		/*	$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
			$apisender = "MoniEn";
			$msgs =" Cash ".$jbookDtls[3]." Payment to ".$jbookDtls[4].", ".$jbookDtls[10]." Purpose. Now Account Balance:".$asstBalance.".";
			$number = 9836199258;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
			//echo $num;exit;
			$mss = rawurlencode($msgs);   //This for encode your message content                 		
			$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$number.'&text='.$mss.'&route=1';
													 
			//echo $url;
			$ch=curl_init($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,"");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
			$data = curl_exec($ch);	
			//end
			*/
		}
	else{
			"Insufficient Balance ";
		}
	}
	else{ echo "Already updated..";}	
	//	echo "hi,,";
	//forward
	$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Payment has been successfully Approved", 'SUCCESS');
	
}
?>

<title><?php echo COMPANY_S; ?> -  Payment Approved </title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<table class="tblBrd" align="center" width="100%">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	//close button
	echo $utility->showCloseButton();
	?>
    
	<?php 
    //delete form
    if( (isset($_GET['action'])) && ($_GET['action'] == 'payment_status') )
    {
        $jbookDtls	 = $journal->showJournalBook($jb_id);
    ?>
    <tr class=''>
	  <td height="25" align='left' bgcolor="#EEEEEE"><h3>Payment Approved for :: <?php echo $jbookDtls[4]; ?></h3></td>
    </tr>
    <tr>
    <td>
      <form action="<?php $_SERVER['PHP_SELF']?>?jb_id=<?php echo $jb_id; ?>" method="post">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="left" class=" blackLarge">
				<div class="marT25 padL10 padR10 padB20">
					Are you sure that you want to approved payment :
					<strong><?php echo $jbookDtls[3]; ?></strong> for <?php echo $jbookDtls[4]; ?>(<?php echo $jbookDtls[10]; ?>)
				
				   
				</div>            
			</td>
          </tr>
          <tr>
            <td height="25" colspan="2" class="menuText padL10">
            
            <input style="color:#444;" name="btnDeleteOrd" type="submit" class="buttonYellow" id="btnDeleteOrd" value="Approved" />
            <input style="color:#444;" name="btnCancel" type="button" class="buttonYellow" id="btnCancel" onClick="self.close()" value="cancel" /></td>
            </tr>
          <tr>
            <td width="105">&nbsp;</td>
            <td width="72%">&nbsp;</td>
          </tr>
        </table>

      </form>
    </td>
    </tr>
    
    <?php 
    }//if
    ?>
</table>