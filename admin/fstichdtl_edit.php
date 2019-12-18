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

$final_stich_id				= $utility->returnGetVar('final_stich_id','0');
$finalstichdtl_id			= $utility->returnGetVar('finalstichdtl_id','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//echo $customerDtl[2];exit;
$FinalStichDtl = $statuscat->showProductFinalStich($final_stich_id);
//$designNo == $FinalStichDtl[3];

$finalstichDesNo 	= $rate->showStichRateDesNo($FinalStichDtl[3]);

$FinaldtlDetails 	= $statuscat->showProductFinalStichDtl($finalstichdtl_id);// final stich dtl call

$fStichSampleDtls	= $sample->getAllFinalStichDtlDisplay($FinalStichDtl[3]);

$fstitchPrevrate 	= $rate->showStitchPartRateDtl($FinaldtlDetails[4]);

//$_SESSION['qty']	=	$finalstichdtl_id;
//echo $FinaldtlDetails[5];
if(isset($_POST['btnEditOrd']))
{	
	$txtAmount 	        = $_POST['txtAmount'];
	$txtEmpid 	        = $_POST['txtEmpid'];
	$txtParticular 	    = $_POST['txtParticular'];//Parts of Product
	
	$labourDtl = $labour->showLabour($txtEmpid);//Labour Details call
	
	//echo $finalstichdtl_id;exit;
	
	
	$finalstichrate 	= $rate->showStitchPartRateDtl($txtParticular);
	
	$workprice = $txtAmount * $finalstichrate[2];	
		
		
		
		$sess_arr	= array('txtAmount','txtProdDesc');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'update_fsdtl';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	
	$msg = '';

$FinaldtlDetails 	= $statuscat->showProductFinalStichDtl($finalstichdtl_id);// final stich dtl call
	//$completeTotal		= $FinalStichDtl[15]+$txtAmount;
	
if($txtAmount == '' )
	{
		
		$error->showErrorTA($action, $id, $id_var, $url, "Quantity empty", $typeM, $anchor);
	}
	elseif($FinaldtlDetails[5] < $txtAmount) {
		$error->showErrorTA($action, $id, $id_var, $url, "Quantity larger than previous transaction", $typeM, $anchor);

		}
	
	else
	{
		//echo $FinaldtlDetails[5] ;exit;
		if($FinaldtlDetails[5] == $txtAmount)
			{
				$leftAmount			= $FinalStichDtl[7];
				$completeTotal		= $FinalStichDtl[15];//echo $completeTotal;echo"hi1";exit;
			//	$totalearn 			= $labourDtl[4];
			}
			else{
				$Difquantity		= $FinaldtlDetails[5] - $txtAmount;
				$leftAmount			= $FinalStichDtl[7];
				$completeTotal		= $FinalStichDtl[15] - $Difquantity;
				
				$difearn			= $FinaldtlDetails[6] - $workprice; 
			//	$totalearn 			= $labourDtl[4] - $difearn;
			    //echo $Difquantity;echo"hi3";exit;
			}
			
			//echo $leftAmount;echo $completeTotal;exit;
				$prevPartCost		= $fstitchPrevrate[2] * $FinaldtlDetails[5];
				$currPartCost		= $workprice;
				$totalearn 			= ($labourDtl[4] - $prevPartCost) + $currPartCost;
	
		//Edit Final Stich table
		$statuscat->editFinalStich($final_stich_id,$FinalStichDtl[1],$FinalStichDtl[2],$FinalStichDtl[3],$FinalStichDtl[4],$FinalStichDtl[5],$FinalStichDtl[6],
		$leftAmount,$FinalStichDtl[8],$FinalStichDtl[9],$FinalStichDtl[10],'Admin',$completeTotal,$FinalStichDtl[16]);	
		//  editFinalStich($mid,$status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$quantity,
		//$remarks,$order_date,$target_date, $modified_by,$complete,$final_result)
		$statuscat->editFStitchParticular($final_stich_id,$txtParticular);
		
		$prodStatusDtl	=$prodStatus->showProductStat($FinalStichDtl[1]);
	   
		/*   $prodStatus->editStatus($FinalStichDtl[1],$prodStatusDtl[1],$prodStatusDtl[2], $prodStatusDtl[19],$prodStatusDtl[3],
		$prodStatusDtl[4], $prodStatusDtl[5],$prodStatusDtl[6],$prodStatusDtl[7],$prodStatusDtl[8],$prodStatusDtl[18],
		$prodStatusDtl[9],$txtStatus,$prodStatusDtl[11],$prodStatusDtl[12],$prodStatusDtl[13],$prodStatusDtl[20]);
		*/ 
	   $statuscat->editFinStichDtl($finalstichdtl_id,$txtEmpid,$labourDtl[1],$txtParticular,$txtAmount,$workprice);
	 
		if($FinaldtlDetails[8] == $txtEmpid){
		$labour->editLabour($txtEmpid,$final_stich_id,$labourDtl[1],$labourDtl[12],$labourDtl[2],$labourDtl[3],$totalearn,$labourDtl[5],$labourDtl[10]);
		}else{
			$labourDtlpres 		= $labour->showLabour($txtEmpid);//Labour Details call
			$labourDtlprev  	= $labour->showLabour($FinaldtlDetails[8]);//Labour Details call
			$totalearnpres      = $labourDtlpres[4] + $workprice;
			$totalearnprev      = $labourDtlprev[4] - $prevPartCost;
			//echo "Error";exit;
			$labour->editLabour($labourDtlprev[0],$final_stich_id,$labourDtlprev[1],$labourDtlprev[12],$labourDtlprev[2],$labourDtlprev[3],$totalearnprev,$labourDtlprev[5],$labourDtlprev[10]);
			$labour->editLabour($txtEmpid,$final_stich_id,$labourDtlpres[1],$labourDtlpres[12],$labourDtlpres[2],$labourDtlpres[3],$totalearnpres,$labourDtlpres[5],$labourDtlpres[10]);
		}
	  
		// Packing Pending edit
		$Difquantity		=   $FinaldtlDetails[5] - $txtAmount ;
		$packingpendreco 	=	$statuscat->showPckpndbyCondition($FinalStichDtl[2],$FinaldtlDetails[8],$FinaldtlDetails[4]);
		
		$ppquantity 		= $txtAmount - $packingpendreco[16];
		
		//$ppqty				= 	$packingpendreco[7] - $Difquantity;
		//$Tamount 			= $txtAmount - $packingpendreco[16];
		$statuscat->editPendingPacking($FinalStichDtl[2],$txtEmpid,$txtParticular,$ppquantity,$FinaldtlDetails[8],$FinaldtlDetails[4]);

	
	  // $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], ' edit has been successful', 'SUCCESS');
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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'update_fsdtl') )
        {
             
            $FinalStichDetails  = $statuscat->showProductFinalStich($final_stich_id);
			$FinaldtlDetails 	= $statuscat->showProductFinalStichDtl($finalstichdtl_id);
			
        ?>
		
<h3><a name="editStock"></a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=update_fsdtl&final_stich_id=<?php echo $final_stich_id; ?>&finalstichdtl_id=<?php echo $finalstichdtl_id; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Edit Final stiching status</a></h2>
		 <h2>->Order Id <?php echo $FinalStichDetails[2];?>&nbsp;->Design No. <?php echo $FinalStichDetails[3];?></h2>
                        <span>Please  <span class="required"></span>fill the following field.<br></span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                   
		
							<!--<label>Particular<span class="orangeLetter">*</span></label>
                            <input name="txtParticular" type="text" class="text_box_large" id="txtParticular" 
					         value="<?php echo $FinalStichDetails[18];?>" size="25" readonly/>
                            -->
							<div >
								<label>Particular Name<span class="orangeLetter">*</span></label>							
									<select name="txtParticular" type="text" id="txtParticular" class="text_box_large">
									<option value="<?php echo $FinaldtlDetails[4];?>"><?php echo $FinaldtlDetails[4];?></option>
									<?php
									//	$stitchRateDtls        = $rate->getStitchPartRateDtls();
										foreach ($fStichSampleDtls as $row){//Array or records stored in $row
										//echo $row[colour_name];
									?>	
										<option value="<?php echo $row['sample_particular'];?>"><?php echo $row['sample_particular'];?></option> 
									<?php
									/* Option values are added by looping through the array */ 
														
									}

									echo "</select>";//?>
							</div>
							
							
							
							<div class="cl"></div>
							<label>Quantity(in pieces)<span class="orangeLetter">*</span></label>
                            <input name="txtAmount" type="text" class="text_box_large" id="txtAmount" 
					         value="<?php echo $FinaldtlDetails[5];?>" size="25" />
                            <div class="cl"></div>
							
							
							<div class="cl"></div>
							<div >
							<label>Labour Name<span class="orangeLetter">*</span></label>							
							
							<select name="txtEmpid" type="text" id="txtEmpid" class="text_box_large">
							<option value="<?php echo $FinaldtlDetails[8];?>"><?php echo $FinaldtlDetails[3];?></option>
							<?php
							$labourDetails         = $labour->LabourDtlDisplay();
							foreach ($labourDetails as $row){//Array or records stored in $row
							//echo $row[colour_name];
							echo "<option value=$row[labour_id]>$row[labour_name]</option>"; 

							/* Option values are added by looping through the array */ 
								
							}

							 echo "</select>";//?>
							 </div>
							<div class="cl"></div>
							
						
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="edit" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>