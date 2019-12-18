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
$customer			= new Customer();
$status			= new Pstatus();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$userId			= $utility->returnSess('userid', 0);
$typeM			= $utility->returnGetVar('typeM','');
$oid			= $utility->returnGetVar('oid','0');
$ordDetail = $orders->showOrders($oid);

if(isset($_POST['btnAddJob']))
{	
	$txtOrderId 	        = $_POST['txtOrderId'];
	$txtDesignNo	 		= $_POST['txtDesignNo'];
	$txtEmployeeId	 		= $_POST['txtEmployeeId'];
	$txtOrderDate	 		= $_POST['txtOrderDate'];
	$txtTargetDate	 	    = $_POST['txtTargetDate'];
	$txtQuantity	 		= $_POST['txtQuantity'];
	$txtDesc	 			= $_POST['txtDesc'];
	
	

	 //$product->addProduct($txtParentId,$txtProdName, $txtPageTitle, $txtProdCode, $intQuant, $txtProdPrice, $txtBrief,
		//$txtProdDesc,$txtSeoUrl,$txtCanonical,$txtMetaTag,$txtMetaDesc,$txtMetaKey);
	
	//registering the post session variables
	$sess_arr	= array('txtOrderId','txtDesignNo', 'txtEmployeeId', 'txtOrderDate', 'txtTargetDate', 'txtQuantity', 'txtDesc');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'assign_job';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addJob';
	$typeM		= 'ERROR';
	
	
	$msg = '';

	
	if($txtOrderId == '')
	{
		echo "Please fill the order Id field";
	}
	elseif($txtDesignNo=='')
	{
		echo "Please fill the Design NO field";
	}
	elseif($txtEmployeeId=='')
	{
		echo "Please fill the Employee Id field";
	}
	elseif($txtOrderDate=='')
	{
		echo "Please fill the Order date field";
	}
	elseif($txtTargetDate=='')
	{
		echo "Please fill the Target Date field";
	}
	elseif($txtQuantity=='')
	{
		echo "Please fill the quantity field";
	}
	/*elseif($txtQuantity>$ordDetail[6])
	{
		echo "Number of order quantity less than assign job quantity";
	}*/
	
	else
	{
		
	//add the Status table 
	    $status->addStatus($txtOrderId,$txtDesignNo, $txtEmployeeId, $txtOrderDate, $txtTargetDate, $txtQuantity, '',
		'','','','','','','','',$txtDesc);	
		
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], SUPROD001, 'SUCCESS');
	}
	$utility->delSessArr($sess_arr);
	
}//eof add product
		
	



?>

<title><?php echo COMPANY_S; ?> -  - Assign Job</title>

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

<!--Ajax search  employee name-->
<script type="text/javascript">
function ajaxFunction(str)
{
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    try
      {
      httpxml=new ActiveXObject("Microsoft.XMLHTTP");
      }
    catch (e)
      {
      alert("Your browser does not support AJAX!");
      return false;
      }
    }
  }
function stateChanged() 
    {
    if(httpxml.readyState==4)
      {
document.getElementById("displayDiv").innerHTML=httpxml.responseText;
document.getElementById("msg").style.display='none';

      }
    }
	var url="employee_search.php";
url=url+"?txt="+str;
url=url+"&sid="+Math.random();
httpxml.onreadystatechange=stateChanged;
httpxml.open("GET",url,true);
httpxml.send(null);
//document.getElementById("msg").innerHTML="Please Wait ...";
document.getElementById("msg").style.display='inline';

  }
</script>


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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'assi_job') )
        {
             
            $ordDetail = $orders->showOrders($oid);
        ?>
		
<h3><a name="editProd">Assign Job</a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=assi_job&oid=<?php echo $oid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Assign Job</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
                          
                            <div class="cl"></div>                      
                    		<label>Orders Id <span class="orangeLetter">*</span></label>
                            <input name="txtOrderId" type="text" class="text_box_large" id="txtOrderId" 
					           value="<?php echo $ordDetail[0] ?>"
                              size="25" />
                            <div class="cl"></div>
                          
                            
                             <label>Design No</label>
                            <input name="txtDesignNo" type="text" class="text_box_large" id="txtDesignNo" 
					         value="<?php echo $ordDetail[1] ?>" size="25" />
                            <div class="cl"></div>
                           
						
						
						<!--<label>Employee Id<span class="orangeLetter">*</span></label>
                            <input name="txtEmployeeId" type="text" onkeyup="ajaxFunction(this.value);" class="text_box_large" id="txtEmployeeId" 
					         size="15" />
							 
							 <div class="cl"></div>
							 <div id="displayDiv"></div>-->
							 
							 
							 <div >
							<label>Employee Name<span class="orangeLetter">*</span></label>							
							
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
                        
                        <label>Order Date<span class="orangeLetter">*</span></label>
                        <input name="txtOrderDate" type="date" class="text_box_large" id="txtOrderDate"
                        value="<?php echo $ordDetail[9];?>" size="30" />
                        <div class="cl"></div>
                                           
                        
                        <label>Target Date<span class="orangeLetter">*</span></label>
                        <input name="txtTargetDate" type="date" class="text_box_large" id="txtTargetDate"
                        value="<?php echo $ordDetail[10] ?>" size="30" />
                        <div class="cl"></div>
                        
                        <label>quantity<span class="orangeLetter">*</span></label>
                        <input name="txtQuantity" type="text" class="text_box_large" id="txtQuantity"
                        value="<?php  $orders->TotalQuantitySum($oid);?>" size="30" />
                        <div class="cl"></div>					 
                        
                        
                        
                        <div class="cl"></div>
                        
                        
						
						
						
                       
                       
					 <label>Remarks</label>
                        
                        <textarea name="txtDesc" type="text" class="text_box_large" id="txtDesc" 
                        value="" size="25"><?php $utility->printSess('txtDesc');?> </textarea>
                        
                        <div class="cl"></div>                   
                        
                        
                        
                <input name="btnAddJob"  id="btnAddJob" type="submit" class="button-add" value="create" />
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
