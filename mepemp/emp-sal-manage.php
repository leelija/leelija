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

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$pbid			= $utility->returnGetVar('pbid','0');

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$empPayBook		= $employee->showEmpBookData($pbid);

if(isset($_POST['btnAddPayment']))
{	
	$txtDuty 	        = $_POST['txtDuty'];
	$txtAdMonth	 		= $_POST['txtAdMonth'];
	$txtSampleDesc		= $_POST['txtSampleDesc'];
	//registering the post session variables
	$sess_arr	= array('txtDuty', 'txtAdMonth');
	$utility->addPostSessArr($sess_arr);
	//defining error variables
	$action		= 'Show_pid';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $pbid;
	$id_var		= 'pbid';
	$anchor		= 'AddPayment';
	$typeM		= 'ERROR';
	
	
	$msg = '';



	if($txtAdMonth=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Month day field is Empty", $typeM, $anchor);
	}
	elseif($txtDuty=='')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Adjustment Duty field is empty", $typeM, $anchor);
	}
	else
	{
				//$txtSampleDesc 	= "Adjustment Amount";
				//employee details
				$employeeDtls 	= $employee->showEmployee($empPayBook[1]);
				//employee post details
				$empTypeDtl		= $employee->getEmpTypeData($employeeDtls[1]);
				
				$empSal			= $employeeDtls[29];
				$adjAmount 		= ($empSal / $txtAdMonth) * $txtDuty;
				
				$tDuty 			= $empPayBook[2] + $txtDuty;
				//$tDuty 			= $txtDuty;
				
				$salary			= $empPayBook[5] + $adjAmount;	
				//$salary			= $adjAmount;
				
				$lastPayment	= $empPayBook[9];
				$advAmount		= $empPayBook[4];
				$dueAmount		= $empPayBook[3];
				$payAble 		= $empPayBook[8] + $adjAmount;
			/*	if($empPayBook[8] < 0){
					$advAmount		= -($empPayBook[8]);
				}else{
					$advAmount		= 0;
				}
				*/
				//Update Payment book
				 $employee->UpdateEmpPayBook($pbid,$tDuty, $dueAmount,$advAmount,$salary,$payAble,$lastPayment,$userData[10]);
				//Add Payment book details
				$employee->addDutySalary($pbid,$txtDuty,$adjAmount,'',$txtSampleDesc,$userData[10]);
				
				//Transaction details
				$employee->addEmpTran($empPayBook[1],$txtSampleDesc,$adjAmount,$empPayBook[8],$payAble,$userData[10]);
				
				// ==== Send SMS =======
					$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
					$apisender = "MoniEn";
					$msgs =" ".$employeeDtls[2]." - ".$empTypeDtl[2].",Total Duty. ".$txtDuty." , Salary. ".$salary." ,Payable ".$payAble." ";
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
				
				
				
				
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], "Duty Adjustment has been successfully complete", 'SUCCESS');
	}
	$utility->delSessArr($sess_arr);
}





?>

<title><?php echo COMPANY_S; ?> - - Employee Duty Adjustment</title>

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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'Show_pid') )
        {
             
            $empPayBookDtls	 = $employee->showEmpBookData($pbid);
        ?>
		
<h3><a name="editProd"></a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=Show_pid&pbid=<?php echo $pbid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Employee Duty Salary</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            <div class="cl"></div>
							<!--<select name="type" id="type" class="textBoxA">
								<option value="add">Add</option>
								<option value="orders_id">Order Id</option>
                            </select>-->
							<div class="cl"></div>
                            <label>Add Extra Duty<span class="orangeLetter">*</span></label>
                            <input name="txtDuty" type="text" class="text_box_large" id="txtDuty" 
					         size="25" />
                            <div class="cl"></div>
							 <div >
								<label>Adjustment Month Total Day<span class="orangeLetter">*</span></label>							
								<select name="txtAdMonth" class="form-control input-lg" id="txtAdMonth" required>
									<option value="30">30</option>
									<option value="31">31</option>
									<option value="29">29</option>
									<option value="28">28</option>
								</select>
							</div>
                            <div class="cl"></div>
							
							<label>Purpose <span class="orangeLetter">*</span></label>
                            <input name="txtSampleDesc" type="text" class="text_box_large" id="txtSampleDesc" 
					         size="25" />
                            <div class="cl"></div>
							<!--
							<label>Remarks</label>
                            <textarea  name="txtSampleDesc" id="txtSampleDesc">
							<?php //$utility->printSess2('txtSampleDesc',''); ?>
                            </textarea>
                            -->                                     
                <input name="btnAddPayment" type="submit" class="button-add"  value="Add" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
