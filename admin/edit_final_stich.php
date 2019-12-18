<?php
ob_start();
session_start();
include_once('checkSession.php');
include_once('../_config/connect.php');


require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");
require_once("../classes/sample.class.php");

require_once("../classes/status_cat.class.php");
require_once("../classes/customer.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/rate.class.php"); 
require_once("../classes/labour.class.php"); 

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
$stock			= new Stock();
$sample			= new Sample();

$statuscat		= new StatusCat();

$customer		= new Customer();
$prodStatus		= new Pstatus();
$rate		    = new Rate();
$labour		    = new Labour();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$final_stich_id			= $utility->returnGetVar('fsid','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//echo $customerDtl[2];exit;
$FinalStichDtl = $statuscat->showProductFinalStich($final_stich_id);
//$designNo == $FinalStichDtl[3];

$finalstichDesNo 	= $rate->showStichRateDesNo($FinalStichDtl[3]);

$_SESSION['final_stich_id']	=	$final_stich_id;
//echo $_SESSION['final_stich_id'];exit;
if(isset($_POST['btnEditOrd']))
{	
	$final_stich_id		=$_POST['final_stich_id'];
	$txtEmpId 	        = $_POST['txtEmpId'];
	
	$txtBillNo			=$_POST['txtBillNo'];
	$txtParticular 	    = $_POST['txtParticular'];
	$txtCompAmount		=$_POST['txtCompAmount'];
	
	$txtAmount 	        = $_POST['txtAmount'];
	$OrderDate			= $_POST['OrderDate'];
	$TargetDate 	    = $_POST['TargetDate'];
	
/*		$sess_arr	= array('txtAmount','OrderDate','TargetDate');
	$utility->addPostSessArr($sess_arr);
*/
	
	//defining error variables
/*	$action		= 'edit_finalStich';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $final_stich_id;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	
	$msg = '';
*/

if($txtAmount == '')
	{
		echo "Amount field empty";
	}
	elseif($txtCompAmount != 0){
		echo "See carefully something WRONG by you.. ";
	}
	else
	{
		//echo $final_stich_id;exit;
		$statuscat->editFinalStichDtl($final_stich_id,$txtEmpId,$txtBillNo,$txtParticular,$txtAmount,$txtCompAmount,$OrderDate,$TargetDate);	  
	  
	  
	  // $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
		
		
		//deleting the sessions
	//	$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Edit has been successfully complete", 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - EDIT final stiching status</title>

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



<!--Ajax search  Labour name-->
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
	var url="labour_search.php";
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
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'edit_finalStich') )
        {
             
            $FinalStichDetails 		= $statuscat->showProductFinalStich($final_stich_id);
			$customerDtls         	= $customer->getCustomerData($FinalStichDetails[5]);
        ?>
		
<h3><a name="editStock">Edit Final stiching status</a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=edit_finalStich&final_stich_id=<?php echo $final_stich_id; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Edit Final stiching status</a></h2>
		 <h2>->Order Id <?php echo $FinalStichDetails[2];?>&nbsp;->Design No. <?php echo $FinalStichDetails[3];?></h2>
                        <span>Please  <span class="required"></span>fill the following field.<br></span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
				<!--<label>Particulars Name</label>
				<input name="txtParticular" id="txtParticular" type="text" class="text-field" 
				value="<?php //echo $FinalStichDetails[18];?>" />
				-->
							
							<div >
								<label>Employee Name<span class="orangeLetter">*</span></label>							
								<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
								<option value="<?php echo $FinalStichDetails[5]; ?>"><?php echo $customerDtls[2]; ?></option>
								<?php
								/*	$customerDetails         = $customer->getAllCustomerDtlPipeline(15);
									foreach ($customerDetails as $row){//Array or records stored in $row
									//echo $row[colour_name];
									echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

									// Option values are added by looping through the array 
													
									}
								*/
									echo "</select>";//?>
							</div>
							
							 <div class="cl"></div>
							 
						<!--	<label>Particular<span class="orangeLetter">*</span></label>  -->
                            <input name="final_stich_id" type="text" class="text_box_large" id="txtParticular" 
					         value="<?php echo $final_stich_id;?>" size="25" style="display:none;"/>
                            <div class="cl"></div>   
							
                          
							<label>Bill No</label>
							<input name="txtBillNo" id="txtBillNo" type="text" class="text-field" 
							value="<?php echo $FinalStichDetails[17]; ?>" />
							<div class="cl"></div>
							
							
							<div >
							<label>Particular<span class="orangeLetter">*</span></label>							
							
							<select name="txtParticular" type="text" id="txtParticular" class="text_box_large">
							<option value="<?php echo $FinalStichDetails[19];?>"><?php echo $FinalStichDetails[19];?></option>
							<?php
							$fStichSampleDtls	= $sample->getAllFinalStichDtlDisplay($FinalStichDetails[3]);
							foreach ($fStichSampleDtls as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[sample_particular]>$row[sample_particular]</option>"; 

							/* Option values are added by looping through the array */ 
								
							}

							 echo "</select>";//?>
							 </div>
							<div class="cl"></div>
							
							
							
							
							

						  <div class="cl"></div>
							
							<label>left Quantity(in pieces)<span class="orangeLetter">*</span></label>
                            <input name="txtAmount" type="text" class="text_box_large" id="txtAmount" 
					         value="<?php echo $FinalStichDetails[7];?>" size="25" />
                            <div class="cl"></div>
							
							<label>Complete Quantity(in pieces)<span class="orangeLetter">*</span></label>
                            <input name="txtCompAmount" type="text" class="text_box_large" id="txtCompAmount" 
					         value="<?php echo $FinalStichDetails[15];?>" size="25" />
                            <div class="cl"></div>
							
							<label>Order Date<span class="orangeLetter">*</span></label>
							  <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" value="<?php echo $FinalStichDetails[9];?>"
								size="25"  />
							  <div class="cl"></div>
												
							  <label>Target Date<span class="orangeLetter">*</span></label>
							  <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" value="<?php echo $FinalStichDetails[10];?>"
							  size="25"  />
							  <div class="cl"></div>
							
							
						<!--	<label>Labour Id<span class="orangeLetter">*</span></label>
                            <input name="txtEmpid" type="text" onkeyup="ajaxFunction(this.value);" class="text_box_large" id="txtEmpid" 
					         size="15" /><div id="displayDiv"></div>
							 
                            <div class="cl"></div>-->
							
							
						<!--	<label>Employee Name<span class="orangeLetter">*</span></label>
                            <input name="txtEmpName" type="text" class="text_box_large" id="txtEmpName" 
					         size="25" />
                            <div class="cl"></div>-->
							
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="Update" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>