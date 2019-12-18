<?php
ob_start();
session_start();
?>
<?php 
//session_start();
require_once("_config/connect.php"); 
require_once("includes/constant.inc.php");
require_once("includes/product.inc.php");
require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php"); 
require_once("classes/order.class.php"); 
require_once("classes/search.class.php");
require_once("classes/pagination.class.php");
require_once("classes/stock.class.php");
require_once("classes/status_cat.class.php");
require_once("classes/customer.class.php");
require_once("classes/product_status.class.php");
require_once("classes/rate.class.php"); 
require_once("classes/labour.class.php"); 
require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php"); 
require_once("classes/utilityImage.class.php");
require_once("classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$stock			= new Stock();

$statuscat			= new StatusCat();

$customer			= new Customer();
$prodStatus			= new Pstatus();
$rate		    = new Rate();
$labour		    = new Labour();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$final_stich_id			= $utility->returnGetVar('final_stich_id','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//echo $customerDtl[2];exit;
$FinalStichDtl = $statuscat->showProductFinalStich($final_stich_id);
//$designNo == $FinalStichDtl[3];

$finalstichDesNo 	= $rate->showStichRateDesNo($FinalStichDtl[3]);


if(isset($_POST['btnEditOrd']))
{	
//	$txtAmount 	        = $_POST['txtAmount'];
//	$txtStatus			= $_POST['txtStatus'];
	$txtProdDesc 	        = $_POST['txtProdDesc'];
/*	$txtEmpid 	        = $_POST['txtEmpid'];
	$txtParticular 	        = $_POST['txtParticular'];//Parts of Product
	
	$labourDtl = $labour->showLabour($txtEmpid);//Labour Details call
	
	//echo $txtStatus;exit;
	$leftAmount			= $FinalStichDtl[7]-$txtAmount;
	$completeTotal		= $FinalStichDtl[15]+$txtAmount;
	
	$finalstichrate 	= $rate->showStichRatePartiwise($txtParticular,$FinalStichDtl[3]);
	
	$workprice = $txtAmount * $finalstichrate[3];
		
	*/	
	$selNum			= $_POST['selNum'];
	
		$sess_arr	= array('txtProdDesc');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'update_fstich';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'infabric';
	$typeM		= 'ERROR';
	
	
	$msg = '';
	if($FinalStichDtl[7] == 0)
	{
		$error->showErrorTA($action, $id, $id_var, $url, " Already all quantity assign ", $typeM, '');
	}
	else{

		for($i=0; $i < $selNum; $i++)
			{
			
			$txtAmount 	        = $_POST['txtAmount'][$i];
			$txtStatus			= $_POST['txtStatus'][$i];
			$txtEmpid 	        = $_POST['txtEmpid'][$i];
			$txtParticular 	    = $_POST['txtParticular'][$i];//Parts of Product
			
			$labourDtl 			= $labour->showLabour($txtEmpid);//Labour Details call
			
			//echo $txtParticular;exit;
			$FinalStichDtl 		= $statuscat->showProductFinalStich($final_stich_id);
			
			//$leftAmount			= $FinalStichDtl[7]-$txtAmount;
			$leftAmount			= $FinalStichDtl[7];
			$completeTotal		= $FinalStichDtl[15]+$txtAmount;
			
			$leftParticular		= $leftAmount - $txtAmount;
			
			//$finalstichrate 	= $rate->showStichRatePartiwise($txtParticular,$FinalStichDtl[3]);
			$stitchRateDtls 	= $rate->showStitchPartRateDtl($txtParticular);
			
			//echo $stitchRateDtls[2];exit;
			$workprice = $txtAmount * $stitchRateDtls[2];
			
			if($txtAmount == '')
				{
					echo "Amount field empty";exit;
				}
				elseif($txtStatus == '')
				{
					echo "Chose one option";exit;
				}
				else
					{
					if($leftAmount >= $completeTotal){
					
					//Edit Final Stich table
				   $statuscat->editFinalStich($final_stich_id,$FinalStichDtl[1],$FinalStichDtl[2],$FinalStichDtl[3],$FinalStichDtl[4],$FinalStichDtl[5],$FinalStichDtl[6],
				   $leftAmount,$FinalStichDtl[8],$FinalStichDtl[9],$FinalStichDtl[10],$customerDtl[16],$completeTotal,$txtStatus);	
				   
				   $prodStatusDtl	=$prodStatus->showProductStat($FinalStichDtl[1]);
				   
				   $prodStatus->editStatus($FinalStichDtl[1],$prodStatusDtl[1],$prodStatusDtl[2], $prodStatusDtl[19],$prodStatusDtl[3],
				   $prodStatusDtl[4], $prodStatusDtl[5],$prodStatusDtl[6],$prodStatusDtl[7],$prodStatusDtl[8],$prodStatusDtl[18],
				   $prodStatusDtl[9],$txtStatus,$prodStatusDtl[11],$prodStatusDtl[12],$prodStatusDtl[13],$prodStatusDtl[20]);
				 
				   // Add into Final stiching details
				   $statuscat->addFinalStichDtl($final_stich_id,$FinalStichDtl[3],$txtEmpid,$labourDtl[1],$stitchRateDtls[1],$txtAmount,$workprice,'unpaid');
				 
				   // update submit date into order table
					$orders->editOrderSubmit($FinalStichDtl[2]);
					
					$totalearn = $labourDtl[4] + $workprice;
					// Update Labour Table
					$labour->editLabour($txtEmpid,$final_stich_id,$labourDtl[1],$labourDtl[12],$labourDtl[2],$labourDtl[3],$totalearn,$labourDtl[5],$labourDtl[10]);
				  
				  
					$cntPackingPnd	= $statuscat->cntPackingData($FinalStichDtl[2],$txtEmpid,$stitchRateDtls[1]);
					if(count($cntPackingPnd) == 0){
						//Data  Add into packing pending table
						$statuscat->addPackingPending($FinalStichDtl[1],$FinalStichDtl[2],$FinalStichDtl[3],$FinalStichDtl[4],$txtEmpid,'packing_pending',$FinalStichDtl[17],$stitchRateDtls[1],$txtAmount,'pending');
					//echo "1 St";exit;
					}else {
							$packingpendreco 	=	$statuscat->showPckpndbyCondition($FinalStichDtl[2],$txtEmpid,$stitchRateDtls[1]);
							$quantity			= 	$packingpendreco[7] + $txtAmount;
							$statuscat->UpdatePpending($FinalStichDtl[2],$txtEmpid,$stitchRateDtls[1],$quantity);
							
							//echo "2 nd";exit;
						}
					
					
					
					
				$packingDtl	= $statuscat->disPacking($FinalStichDtl[2]);
				if(count($packingDtl) == 0){
					//Add data into Packing table 
					 $statuscat->addStasPacking($FinalStichDtl[1],$FinalStichDtl[2],$FinalStichDtl[3],$FinalStichDtl[4],'','Packing',$FinalStichDtl[17],0,'',$FinalStichDtl[9],$FinalStichDtl[10]);
					}
				}
				
				else{ echo"Error! You Put Maximum Particulars";exit;}
				}	
			} 
				
					
					
	  
	  // $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], SUPROD001, 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - EDIT final stiching status</title>

<!-- Style -->
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/utility.js"></script>
<script type="text/javascript" src="js/advertiser.js"></script>
<script type="text/javascript" src="js/location.js"></script>
<script type="text/javascript" src="js/checkEmpty.js"></script>
<script type="text/javascript" src="js/email.js"></script>
<script type="text/javascript" src="js/static.js"></script>
<script type="text/javascript" src="js/product.js"></script>
<script type="text/javascript" src="js/finalstich.js"></script>

<!-- eof JS Libraries -->

<!-- TinyMCE --> 
 <script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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
        if( (isset($_GET['action'])) && ($_GET['action'] == 'update_fstich') )
        {
             
            $FinalStichDetails = $statuscat->showProductFinalStich($final_stich_id);
        ?>
		
		<h3><a name="editStock"></a></h3>
    
        <form action="<?php $_SERVER['PHP_SELF']?>?action=update_fstich&final_stich_id=<?php echo $final_stich_id; ?>" method="post" enctype="multipart/form-data">
         
		 
		<h2><a name="addUser">Update Final stiching status</a></h2>
		<h2>->Order Id <?php echo $FinalStichDetails[2];?>&nbsp;->Design No. <?php echo $FinalStichDetails[3];?></h2>
        <span>Please  <span class="required"></span>fill the following field.<br></span>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
				<tr>
					<label>Select No. Labour</label>
					<!--<td align="left" class="menuText">Select No. Type </td>-->
					<td align="left" class="bodyText pad5">
					<?php 
						//gen number array
						$arr_value	= range(1,18);
						$arr_label	= range(1,18);
					?>
					<select name="selNum" id="selNum" onchange="return getFinalStichUp(<?php echo $final_stich_id; ?>);"
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
								  </select>				    
					</td>
				</tr>
				<div class="cl"></div>
				<div id="showFinalStichUp"></div>
									
		
				<label>Remarks</label>
                <textarea  name="txtProdDesc" id="txtProdDesc">
					<?php $utility->printSess2('txtProdDesc',''); ?>
                </textarea>
                <div class="cl"></div>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="Update" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>