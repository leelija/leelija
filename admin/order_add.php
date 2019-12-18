<?php 
session_start();
//include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/email.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/sample.class.php");
require_once("../classes/unit.class.php"); 
require_once("../classes/employee.class.php"); 

require_once("../classes/customer.class.php");
require_once("../classes/product_status.class.php");

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
$sample			= new Sample();
$employee 		= new Employee();
$customer		= new Customer();
$status			= new Pstatus();
$unit			= new Unit();
$emailObj		= new Email();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################
date_default_timezone_set('Asia/Calcutta'); 
$AddDate 			= date("m/d/Y");// Added Date

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$sid			= $utility->returnGetVar('sid','0');
//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$sampleDtl      = $sample->showSample($sid);
$sampleColorDtl = $sample->showColour($sid);
$empDtls		= $employee->EmployeeDis();	

//add a product
if(isset($_POST['btnAddProd']))
{	
	//$txtOrdNo 	        = $_POST['txtOrdNo'];
	$txtDesignNo	 		= $_POST['txtDesignNo'];
	$txtPartyName	 		= $_POST['txtPartyName'];
	//$txtBrokar	 		= $_POST['txtBrokar'];
	//$txtRetaHol	 	    = $_POST['txtRetaHol'];
	$txtForm	 			= $_POST['txtForm'];
	//$txtQuantity	 		= $_POST['txtQuantity'];
	//$txtColour	 		= $_POST['txtColour'];
	$txtProdDesc	 		= $_POST['txtProdDesc'];
	$OrdersDate	 			= $_POST['OrdersDate'];
	$TargetDate 			= $_POST['TargetDate'];
	$selNum					= $_POST['selNum'];
	$txtEmployeeId	 		= $_POST['txtEmployeeId'];
	$txtFactoryId	 		= $_POST['txtFactoryId'];
	
	//echo $txtEmployeeId;exit;

	 //$product->addProduct($txtParentId,$txtProdName, $txtPageTitle, $txtProdCode, $intQuant, $txtProdPrice, $txtBrief,
		//$txtProdDesc,$txtSeoUrl,$txtCanonical,$txtMetaTag,$txtMetaDesc,$txtMetaKey);
	
	//registering the post session variables
	$sess_arr	= array('txtOrdNo','txtDesignNo', 'txtDesignNo', 'txtBrokar', 'txtRetaHol', 'txtForm', 'txtQuantity',
		'txtColour','txtProdDesc','OrdersDate','TargetDate');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'add_ord';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	
	
	$msg = '';

/*	//category check box array	
	if(isset($_POST['chkCat']))
	{
		foreach($_POST['chkCat'] as $y)
		{
			if($y != '')
			{ 
				$chkCatVal[]	= addslashes($y);
			}
		}
	}
	else
	{
		$chkCatVal   = array();
	}*/

	//field validation
	
/*	if($txtCatName != '')
	{
		$duplicate = $error->duplicateCat($parent_id, $txtCatName,0);
	}*/
	
	if($txtDesignNo=='')
	{
		echo "Design number empty";
	}
	
	elseif($TargetDate=='')
	{
		echo "Target date field empty";
	}
	elseif($OrdersDate=='')
	{
		echo "Fill up order date field";
	}
	elseif($txtEmployeeId=='')
	{
		echo "Employee id field empty";
	}
	else
	{
		
	//add the Orders
	  $orders_id =  $orders->addOrders($txtDesignNo, $txtPartyName, '', '', $txtForm, 0,
		'',$txtProdDesc,$OrdersDate,$TargetDate,$txtFactoryId,$userData[10]);	
		
		
		for($i=0; $i < $selNum; $i++)
			{
				//echo $_POST['txtColourType'][$i];exit;
				//add the orders colour
				$orders->addOrdersDetails($orders_id,$txtDesignNo, $_POST['txtQuantity'][$i],$_POST['txtColourType'][$i]);	
			}
			$countqty = $orders->TotalQuantitySum($orders_id);
			//echo $countqty;exit;
			$qtytotal = implode(" ",$countqty);
			//echo $qtytotal;exit;
			//add the Status table 
			$status->addStatus($orders_id,$txtDesignNo, $txtEmployeeId, $OrdersDate, $TargetDate,$qtytotal, 'Pending',
			'','','','','','','','',$txtProdDesc,$txtFactoryId);	
			
			//$quantity = $orders->TotalQuantitySum($orders_id);
			
			//Mail Forward to all employee
			foreach($empDtls as $eachRecord)
                {
				// order Details
				$orderColourDtl 		= $orders->ordersDtlDisplay($orders_id);
				
				$txtNewsLetterEmail  = $eachRecord['email'];
				$txtCompany			 =  'RFRI';	
				//send email
				$subjectEmail 	= "New Order Generate for Order Id - ".$orders_id." - ". date("d-m-Y");
				$to 			= SITE_ADMIN. "<".$txtNewsLetterEmail.">";
				$from 			= $txtCompany. "<".SITE_EMAIL.">";
				$body = '
					<div style="width: 100%; height:auto; font:normal 13px Georgia, Times, Arial, Verdana, sans-serif;
					color: #000000; bachground-color:#fff;">
					<div style="padding:10px; margin:0px auto;" align="center">
						<img src="'.URL.LOGO_WITH_PATH.'" height="'.LOGO_HEIGHT.'" width="'.LOGO_WIDTH.'" alt="'.LOGO_ALT.'" />
					</div>
					<div style="width: 650px; height:auto; margin:5px auto 10px auto; padding:20px 10px;
						font:normal 12px Helvetica, Arial, Verdana, sans-serif;
						color: #000000; bachground-color:#FCFCFC; -moz-border-radius: 4px; -webkit-border-radius: 4px;
						border:1px solid #eee;">
						<h2 style="font:bold 12px Arial, Verdana, sans-serif;width:650px; height:30px;
						background-color:#DCDCC7; color:#7C6677; text-align:center; line-height:30px;vertical-align:middle; padding:0; margin:0">
						Order No. '.$orders_id.'
						</h2>
									<p>Dear '.$eachRecord['emp_name'].',</p>
									<p>You have received a new Order '.$orders_id.' . Below is the Order detail:</p>
									
									
									<p style="padding:10px">
										Order Id:   '.$orders_id.'<br />
										Design No:   '.$txtDesignNo.'<br />
									</p>
									
									<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
									
									';
									 
									if(count($orderColourDtl) == 0)
									{
								$body		.=  '
									<tr align="left" class="orangeLetter">
									  <td height="20" colspan="5"> Table is empty</td>
									</tr>
									';
									}
									else
									{
									
								$body		.=  '
								
									<thead>
									<tr>
									  <th width="10%" >SL No.</th>
									  <th width="10%" >DESIGN No.</th>
									  <th width="10%" >COLOUR</th>
									  <th width="10%" >QUANTITY</th>
									  
									</tr>  
									</thead>
									<tbody>
									';
										$sl=1;  
										$totalQty 		= 0;
										foreach($orderColourDtl as $eachRecord)
											{
											$bgColor 	 	= $utility->getRowColor($sl);
											
											$totalQty 		+= $eachRecord['quantity'];
									$body		.=  '
										<tr>
											<td align="left">'.$sl.'</td>
											<td align="center">'.$eachRecord['design_no'].'</td>
											<td align="center">'.$eachRecord['colour'].'</td>
											<td align="center">'.$eachRecord['quantity'].'</td>
											
										</tr>
									  ' ;
										$sl++;
											}
											
										}
									$body		.=  '
									</tbody>  
								</table>
								<div class="tBillTitle" style="background:#ddd; height: 30px;">
									<p class="ltotal" style="width:50%; float:left;">Total Quantity</p>
									<p class="rtotal" style="width: 45%; float: right;position: relative;left: 185px;"><b>'.$totalQty.'</b></p>
								</div>
								<b>Target Date '.$TargetDate.'</b>
								<p>Order By <b>'.$userData[10].'</b></p>
								
									<p>
									Regards,<br />
									Employee Service<br />
									'.COMPANY_S.'
									</p>
								</div>
						
						</div>
						';
					
					//send email to All Employee
					$emailObj->sendEmail($to, $subjectEmail, $body, $eachRecord['emp_name'], $txtNewsLetterEmail);
				
				
				}
			
			foreach($empDtls as $eachRow)
                {
				/*
					// ==== Send SMS =======
					$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
					$apisender = "MoniEn";
					$msg = "New Order ".$orders_id." ".$totalQty."Pcs generate Design No ".$txtDesignNo." for more details check your mail box";
					$num = $eachRow['emp_mobile'];    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
					//echo $num;exit;
					$ms = rawurlencode($msg);   //This for encode your message content                 		
							 
					$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
												 
					//echo $url;
					$ch=curl_init($url);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch,CURLOPT_POST,1);
					curl_setopt($ch,CURLOPT_POSTFIELDS,"");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
					$data = curl_exec($ch);
					*/
				}
			
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'latest-order.php', SUPROD001, 'SUCCESS');
	}
	
}//eof add product


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtOrdNo','txtDesignNo', 'txtDesignNo', 'txtBrokar', 'txtRetaHol', 'txtForm', 'txtQuantity',
		'txtColour','txtProdDesc','OrdersDate','TargetDate');
	
/*	//option value variables 
	$optValIds	= $prodAttr->getOptionValId(0);
	$chkOptVal 	= $uNum->createIdArr($optValIds, 'ov');
	
	//merging array
	$allArr		= 	array_merge($sess_arr, $chkOptVal);	
	$utility->delSessArr($allArr);*/
	
	//forward
	header("Location: latest-order.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Add Product</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>

<!--CSS Jquery Calender-->
<link rel="stylesheet" href="../style/jQuery/jquery-ui.css" type="text/css" media="all" />
<!--CSS Jquery Calender-->


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
<script type="text/javascript" src="../js/category.js"></script>
<script type="text/javascript" src="../js/product.js"></script>

<script type="text/javascript" src="../js/sample_product.js"></script>
<script type="text/javascript" src="../js/order_colour.js"></script>
<!-- eof JS Libraries -->

<!--Jquery Calender-->
<script src="../js/jQuery/jquery.min.js" type="text/javascript"></script>
<script src="../js/jQuery/jquery-ui.min.js" type="text/javascript"></script>
<!--Jquery Calender-->  

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
<script type="text/javascript">
function contentTitleCopy()
{

	var x=document.getElementById("txtProdName").value;
	document.getElementById("txtPageTitle").value=x;
}
</script>

</head>

<body>

	
    <!-- Header -->
	<?php require_once('header.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<div id="admin-menu">
				<?php require_once('menu.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                <div id="admin-top">
                	<h1>Orders</h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_ord')) 
					{	
					?>
                   
                        <h2><a name="addUser">Add Orders</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                          
                         <!--   <div class="cl"></div>                      
                    		<label>Orders No <span class="orangeLetter">*</span></label>
                            <input name="txtOrdNo" type="text" class="text_box_large" id="txtOrdNo" 
					           value="<?php //$utility->printSess2('txtOrdNo',''); ?>"
                              size="25" />-->
                            <div class="cl"></div>
                          
                            
                             <label>Design No<span class="orangeLetter">*</span></label>
                            <input name="txtDesignNo" type="text" class="text_box_large" id="txtDesignNo" 
					        value="" size="25" />
                            <div class="cl"></div>
                            
                            <label>Order By(Name)</label>
                            <input name="txtPartyName" type="text" class="text_box_large" id="txtPartyName" 
					        value="<?php $utility->printSess2('txtPartyName',''); ?>" size="25" />
                            <div class="cl"></div>
                            
                       <!--     <label>Brokar <span class="orangeLetter">*</span></label>
                            <input name="txtBrokar" type="text" class="text_box_large" id="txtBrokar" 
					        value="<?php //$utility->printSess2('txtBrokar',''); ?>" size="25" />
                            <div class="cl"></div>
							
                             <label>Reta/Hol<span class="orangeLetter">*</span></label>
                            <input name="txtRetaHol" type="text" class="text_box_large" id="txtRetaHol" 
					        value="<?php //$utility->printSess2('txtRetaHol',''); ?>" size="25" />
                            <div class="cl"></div>
                             -->
							  <label>Form(Address)<span class="orangeLetter"></span></label>
                            <input name="txtForm" type="text" class="text_box_large" id="txtForm" 
					        value="<?php $utility->printSess2('txtForm',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<!-- <label>Quantity<span class="orangeLetter">*</span></label>
                            <input name="txtQuantity" type="text" class="text_box_large" id="txtQuantity" 
					        value="<?php //$utility->printSess2('txtQuantity',''); ?>" size="25" />
                            <div class="cl"></div>-->
							
							<tr>
									<label>Select No. of Colour</label>
									<!--<td align="left" class="menuText">Select No. Type </td>-->
									<td align="left" class="bodyText pad5">
									<?php 
									//gen number array
									$arr_value	= range(1,8);
									$arr_label	= range(1,8);
									?>
									  <select name="selNum" id="selNum" onchange="return getOrderColour();"
									   class="textBoxA">
										<option value="0">--Select--</option>
										<?php 
										if(isset($_SESSION['selNum']))
										{
											$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
										}
										else if(isset($_GET['selNum']))
										{
											$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
										}
										else
										{
											$utility->genDropDown(0, $arr_value, $arr_label);
										}
										?>
									  </select>				    </td>
								  </tr>
								<div class="cl"></div>
								<div id="showOrderColour"></div>
													
							
							
							
							
							<div >
								<label>Order to<span class="orangeLetter">*</span></label>							
								
								<select name="txtEmployeeId" type="text" id="txtEmployeeId" class="text_box_large">
								<?php
								$customerDetails         = $customer->getAllCustomerDtl();
								foreach ($customerDetails as $row){//Array or records stored in $row
								//echo $row[colour_name];
								echo "<option value=$row[customer_id]>$row[user_name]</option>"; 
									
								/* Option values are added by looping through the array */ 
									
								}

								 echo "</select>";//?>
							</div>
							
							<div class="cl"></div>
							<!-- <label>Colour<span class="orangeLetter"></span></label>
                            <input name="txtColour" type="text" class="text_box_large" id="txtColour" 
					        value="<?php //$utility->printSess2('txtColour',''); ?>" size="15" />
                            <div class="cl"></div>-->
							
                            
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
							
							 <label>Orders Date<span class="orangeLetter">*</span></label>
                            <input name="OrdersDate" type="date" class="text_box_large" id="OrdersDate" 
					        value="<?php $utility->printSess2('OrdersDate',''); ?>" size="25" />
                            <div class="cl"></div>
							
							 <label>Target Date<span class="orangeLetter">*</span></label>
                            <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
					        value="<?php $utility->printSess2('TargetDate',''); ?>" size="25" />
                            <div class="cl"></div>
							
							<div >
								<label>Factory Name<span class="orangeLetter">*</span></label>							
									<select name="txtFactoryId" type="text" id="txtFactoryId" class="text_box_large">
										<?php
											$factDetails         = $sample->getAllFactory();
											foreach ($factDetails as $eachrecord){//Array or records stored in $row
											//echo $row[colour_name];
											echo "<option value=$eachrecord[factory_id]>$eachrecord[factory_name]</option>"; 

											/* Option values are added by looping through the array */ 
													
										}

									echo "</select>";//?>
							</div>
							<div class="cl"></div>
                            
                            
<?php /*?>                            <label>Tax</label>
                            <select name="txtTaxId" id="txtTaxId" class="textBoxA">
							  <?php
                              if(isset($_SESSION['txtTaxId']))
                              {
                                $tax->taxDropDown($_SESSION['txtTaxId']);
                              }
                              else
                              {
                                $tax->taxDropDown(0);
                              } 
                              ?>
                            </select>	
                            <div class="cl"></div><?php */?>
                            
                           
                            <div class="cl"></div>
                            
                           <!-- <span class="menuTxt"><a href="#AddDesc" onClick="showAdditionalDesc('divId')"> Add additional Remarks</a></span>
                            <div class="cl"></div>
                            
                            <a name="AddDesc">
                                <div id="divId" class="hideDesc">
                                    <label>Additional Remarks</label>
                                    <textarea  name="txtRemarks" id="txtRemarks">
                                    <?php //$utility->printSess2('txtRemarks',''); ?>
                                    </textarea>
                                </div>
                            </a>-->
                            <div class="cl"></div>
                                                        
                                                                                
                            <input name="btnAddProd" type="submit" class="button-add"  value="add" />
                           
                            <input name="btnCancel" type="submit" class="button-cancel" value="cancel" />
						</form>
                    <?php 
					}
					?>
                    
                </div>
                <div class="cl"></div>
                <!-- eof Form -->
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php// require_once('footer.inc.php'); ?>
     
</body>
</html>
