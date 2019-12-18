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
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
//require_once("../classes/tax.class.php");
require_once("../classes/customer.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/employee.class.php"); 
require_once("../classes/daily_comp_stitch.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
//$tax			= new Tax();
$customer			= new Customer();
$status			= new Pstatus();
$employee		= new Employee();
$dStitch		= new DailyStitch();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$pbid			= $utility->returnGetVar('pbid','0');
date_default_timezone_set('Asia/Calcutta'); 

/*================  Sunday count ================================*/
function total_sundays($nMonth,$year)
	{
		$sundays=0;
		$total_days=cal_days_in_month(CAL_GREGORIAN,$nMonth,$year);
		for($i=1;$i<=$total_days;$i++)
		if(date('N',strtotime($year.'-'.$nMonth.'-'.$i))==7)
		$sundays++;
		return $sundays;
	}


//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);
//Employee Details
$empDtls 		= $employee->EmployeeDis();

if(isset($_POST['btnAddPayment']))
{	
	$txtToDate		= $_POST['txtToDate'];
	$txtFromDate	= $_POST['txtFromDate'];
	
	$empOfferDtls 	= $dStitch->getStOfferSum($txtToDate,$txtFromDate);
	
	$date    		= date("Y-m-d");//current date
	$last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
	$lastDate		= date("Y-m-d",$last_date_find);
	//$lastDate		= '2017-06-10';
	
	//defining error variables
	$action		= 'Show_pid';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $pbid;
	$id_var		= 'pbid';
	$anchor		= 'AddPayment';
	$typeM		= 'ERROR';

	$msg = '';

	//echo $lastDate;exit;

	if($txtToDate == '')
	{
		echo "Select Date..";
	}
	else
	{
		foreach($empOfferDtls as $eachRecord)
            {
				
				$sOffer			= $eachRecord['SUM(offer)'];
				//echo $nMonth;exit;
				$empId	 		= $eachRecord['emp_id'];// Employee Id
				//$aadharNo 		= $eachRecord['adhar_no'];// Aadhar No
				//employee post details
				//$empTypeDtl		= $employee->getEmpTypeData($eachRecord['emp_type_id']);
				
				//Employee Payment Book Details
				$empPayBook		= $employee->showEmpPayBookData($empId);
				//echo $empPayBook[1];exit;
				/*if(count($empPayBook) == 0){
					//add the Payment Records
					$employee->addPaymentBook($empId, '', '','','','','', $sOffer, '',
					'',$userData[10]);
				}*/
				
				$tDuty			= 0;
				//Monthly Salary;
				$salary			= $empPayBook[5];	//Salary current month
				$lastPayment	= $empPayBook[9];//last payment
				
				
				if($empPayBook[8] >= 0){
					$advAmount		= 0;//Advance 
					$dueAmnt 		= $empPayBook[8]; // Employee due amount
					$tdueAmount		= $dueAmnt;// Total due amount
					$payAble 		= ($sOffer + $tdueAmount) - $advAmount;//employee payable balance
					
				}
				else{
					$advAmount		= 0 - $empPayBook[8];//Advance 
					$dueAmnt 		= 0; // Employee due amount
					$tdueAmount		= $dueAmnt;// Total due amount
					$payAble 		= ($sOffer + $tdueAmount) - $advAmount;//employee payable balance
				}
				
				
				//Transaction details
				$employee->addEmpTran($empPayBook[1],"StitchOffer",$salary,$empPayBook[8],$payAble,$userData[10]);
				
				//Update Payment book
				 $employee->UpdateEmpPayBook($empPayBook[0],$tDuty, $tdueAmount,$advAmount,$salary,$payAble,$lastPayment,$userData[10]);
				//employee offer update
				$employee->UpdateEmpOffer($empPayBook[0], $sOffer,$payAble,$userData[10]);
				
				//if($empPayBook[0] != 0){
					//Add Payment book details
					//$employee->addDutySalary($empPayBook[0],$tDuty,$salary,'','',$userData[10]);
					//Add employee offer
					$employee->addEmpOffer($empPayBook[1], $sOffer,'StitchOffer',$userData[10]);
					
					//employee details
					$employeeDtls 	= $employee->showEmployee($empPayBook[1]);
					
					// ==== Send SMS =======
					$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
					$apisender = "MoniEn";
					$msgs =" ".$eachRecord['operator']." -StitchOffer.".$sOffer.",D.Amount. ".$dueAmnt." ,Adv. ".$advAmount." ,Payable ".$payAble." ";
					$number = 9123889878;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
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
					// ==== End Send SMS =======
					
					/*// ==== Send SMS =======
					$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
					$apisender = "MoniEn";
					$msgs =" ".$eachRecord['fname']." - ".$empTypeDtl[2].",Sal. ".$empSalary." ,Duty. ".$tDuty." ,Work Amount. ".$salary.",D.Amount. ".$dueAmnt." ,Adv. ".$advAmount." ,Payable ".$payAble." ";
					$number = 9143398003;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
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
					// ==== End Send SMS =======*/
					$employeePhone = $employeeDtls[3];
					// ==== Send SMS =======
					$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
					$apisender = "MoniEn";
					$msgs =" ".$eachRecord['operator']." - Your ,StitchOffer. ".$sOffer.",D.Amount. ".$dueAmnt." ,Adv. ".$advAmount." ,Payable ".$payAble." ";
					$number = $employeePhone;   // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
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
					// ==== End Send SMS =======
				
				//}
				
			}	
		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], "Offer has been successfully generated", 'SUCCESS');
	
	}
	//$utility->delSessArr($sess_arr);
}





?>

<title><?php echo COMPANY_S; ?> - - Employee Offer</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<script type="text/javascript" src="../js/static.js"></script>
<script type="text/javascript" src="../js/product.js"></script>
<!-- eof JS Libraries -->

<!-- TinyMCE --> 
 <script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
 <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "image,fontsizeselect,forecolor,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,bullist,numlist,|,outdent,indent",
		theme_advanced_buttons2 :
"undo,redo,|,emotions,|,pasteword,code",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		formats : {
			alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'left'},
			aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'center'},
			alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'right'},
			alignfull : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
			bold : {inline : 'span', 'classes' : 'bold'},
			italic : {inline : 'span', 'classes' : 'italic'},
			underline : {inline : 'span', 'classes' : 'underline', exact : true},
			strikethrough : {inline : 'del'}
		},

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->


</head>


	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'Show_Sal') )
        {
             
        ?>

		<h2><a name="addUser">Generate Operator Offer</a></h2>
        <span>Are you Sure generate Operator Offer</span>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                                                     
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
								<label for="txtToDate">To Date<span class="orangeLetter"></span></label>
								<input type="date" name="txtToDate" id="txtToDate" class="form-control input-lg" 
								value="<?php if(isset($_SESSION['txtToDate'])){ echo $_SESSION['txtToDate'];}else{}?>" tabindex="3" >
							</div>
						</div>
						<div class="cl"></div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
								<label for="txtFromDate">From Date<span class="orangeLetter"></span></label>
								<input type="date" name="txtFromDate" id="txtFromDate" class="form-control input-lg" 
								value="<?php if(isset($_SESSION['txtFromDate'])){ echo $_SESSION['txtFromDate'];}else{}?>" tabindex="2" >
							</div>
						</div>
					</div>
				<div class="cl"></div>
				<input name="btnAddPayment" type="submit" class="button-add"  value="YES" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="No" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
