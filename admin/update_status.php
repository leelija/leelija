<?php 
ob_start();
session_start();
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");

require_once("../classes/fabric.class.php");
require_once("../classes/customer.class.php");

require_once("../classes/product_status.class.php");
require_once("../classes/status_cat.class.php");

require_once("../classes/sample.class.php");
require_once("../classes/plan.class.php");

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

$fabric			= new Fabric();
$customer			= new Customer();
//$status			= new Pstatus();
$prodStatus			= new Pstatus();

$statCat			= new StatusCat();

$sample			= new Sample();
$plan			= new Plan();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$psid			= $utility->returnGetVar('psid','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//echo $customerDtl[2];exit;
//   $fabricDtl=$fabric->showFabric($fid);
$prodstatDtl	= $prodStatus->showProductStat($psid);

$statCatDtl		=$statCat->showProductStatCat1($psid); 
//echo count($statCatDtl);exit;

if(isset($_POST['btnEditOrd']))
{	
	$txtEmpId 	        = $_POST['txtEmpId'];
	$txtStatus 	        = $_POST['txtStatus'];
	$txtQuantity 	        = $_POST['txtQuantity'];
	$txtProdDesc 	        = $_POST['txtProdDesc'];
	$OrderDate 	        = $_POST['OrderDate'];
	$TargetDate 	        = $_POST['TargetDate'];
	$txtBillNo 	            = $_POST['txtBillNo'];		//Bill no
	$txtFabricType 	        = $_POST['txtFabricType']; // Fabric Type Or Particulars
	$txtDesignNo			= $_POST['txtDesignNo']; //Computer Design no.
	$txtNoOfStich			= $_POST['txtNoOfStich'];
	$txtTime			    = $_POST['txtTime'];
	  
	$selNum			= $_POST['selNum'];
	
// Calculate current stock
//$current_stock= $txtAmount+$fabricDtl[2];
	
	//registering the post session variables
	
		$sess_arr	= array('txtEmpId','txtStatus','txtQuantity','txtProdDesc','OrderDate','TargetDate');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'update_status';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'updateStatus';
	$typeM		= 'ERROR';
	
	
	$msg = '';


if($txtEmpId == '')
	{
		echo "Employee Id field empty";
	}
	elseif($OrderDate == '')
	{
		echo "Select Order Date";
	}
	elseif($TargetDate == '')
	{
		echo "Select Target Date";
	}
	/*elseif($txtQuantity > $prodstatDtl[5])
	{
		echo "Total job less than assign job";
	}*/
	
	
	else
	{
		if($txtStatus=='Dyeing')
		{
			
		  
	
			//add the additional images
			for($i=0; $i < $selNum; $i++)
			{
			/*	if(isset($_POST['radioIsDefault']))
				{
					$isDefault		= $_POST['radioIsDefault'];
				}
				else
				{
					$isDefault		= 'Y';
				}*/
				
				
					
					//add orders image
				//	$ordImgId	= $orders->addOrdImage($psid,$prodstatDtl[1],$prodstatDtl[2], $_POST['txtProductType'][$i], $_POST['txtFabricAmount'][$i]);
					
			//add the dyeing table
		   $statCat->addStasCat($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtBillNo,
		   $txtStatus,$_POST['txtProductType'][$i],$_POST['txtFabricAmount'][$i],$txtProdDesc,$OrderDate,$TargetDate);	
		  // $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
		  	
				
			}//for
				  
		  $plan->updatePlanfoDye($prodstatDtl[1],$OrderDate);	
		  
		  //Update status table		
		$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
	   $prodstatDtl[4], $prodstatDtl[5],'Running',$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
	   $prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
		  
		  
		}
		elseif($txtStatus=='Hand' AND count($statCatDtl)!='')
		{
			for($i=0; $i < $selNum; $i++)
			{
			$statCat->addStasHand($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
			$_POST['txtProductType'][$i],$_POST['txtFabricAmount'][$i],$_POST['txtMaterialName'][$i],$_POST['txtMatamount'][$i],
			'','','','',$txtProdDesc,$OrderDate,$TargetDate);
			}
			//Update Plan
				$plan->updatePlanforHand($prodstatDtl[1],$OrderDate);	
		//Update status table		
		$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
	   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],'Running',$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
	   $prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
				
				
		}
		elseif($txtStatus=='Manual' AND count($statCatDtl)!='')
		{
			for($i=0; $i < $selNum; $i++)
			{
			$statCat->addStasManual($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
			$_POST['txtProductType'][$i],$_POST['txtFabricAmount'][$i],$_POST['txtMaterialName'][$i],$_POST['txtMatamount'][$i],
			'','','','',$txtProdDesc,$OrderDate,$TargetDate);
			
			
			}
			//Update Plan
				$plan->updatePlanforManual($prodstatDtl[1],$OrderDate);
				
				//Update status table		
				$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
			   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],'Running',$prodstatDtl[18],$prodstatDtl[9],
			   $prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
			
		}
		
		elseif($txtStatus=='Computer' AND count($statCatDtl)!='')
		{
			for($i=0; $i < $selNum; $i++)
			{
			$statCat->addStasComputer($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
			$_POST['txtProductType'][$i],$_POST['txtDesignNo'][$i],$_POST['txtFabricAmount'][$i],$txtNoOfStich,'','','',$txtTime,
			$txtProdDesc,$OrderDate,$TargetDate);
			
			}
			//Update Plan
				$plan->updatePlanforComputer($prodstatDtl[1],$OrderDate);
				//Update status table		
				$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
			   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],'Running',$prodstatDtl[9],
			   $prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
			
		}
		
		elseif($txtStatus=='Kali Cutting' AND count($statCatDtl)!='')
		{
			for($i=0; $i < $selNum; $i++)
			{
			$statCat->addStasKaliCut($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
			$_POST['txtProductType'][$i],$_POST['txtFabricAmount'][$i],$txtProdDesc,$OrderDate,$TargetDate);
			}
			
			//Update status table		
				$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
			   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],'Running',
			   $prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
			
			
		}
		
		elseif($txtStatus=='Final Stiching' AND count($statCatDtl)!='')
		{
			for($i=0; $i < $selNum; $i++)
			{
			$statCat->addStasFinal($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
			$_POST['txtProductType'][$i],$_POST['txtFabricAmount'][$i],$_POST['txtMaterialName'][$i],$_POST['txtMatamount'][$i],
			'',$txtProdDesc,$OrderDate,$TargetDate);
			
			}
			
			//Update status table		
				$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
			   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],
			   $prodstatDtl[9],'Running',$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
		
		}
		
		elseif($txtStatus=='Iron' AND count($statCatDtl)!='')
		{
			$statCat->addStasIron($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,$txtQuantity,$txtProdDesc,$OrderDate,$TargetDate);
			//Update status table		
				$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
			   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],
			   $prodstatDtl[9],$prodstatDtl[10],'Running',$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
		
		}
		
		elseif($txtStatus=='Packing' AND count($statCatDtl)!='')
		{
			$statCat->addStasPacking($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,$txtQuantity,$txtProdDesc,$OrderDate,$TargetDate);
		}
		else
		{
			echo "Dyeing Can't complete";
			echo '<input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />';
			exit;
		}
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], SUPROD001, 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - Job Assign</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
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
<script type="text/javascript" src="../js/pipeline.js"></script>
<script type="text/javascript" src="../js/pipeline_manual.js"></script>
<script type="text/javascript" src="../js/pipeline_kali.js"></script>
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
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'update_status') )
        {
             
            $statusDetails = $prodStatus->showProductStat($psid);
			
			
        ?>
		
<h3><a name="editStock">Job Assign</a></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=update_status&psid=<?php echo $psid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Job Assign</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            
							
						
							
                           
							 
                            <div class="cl"></div>
							
							
                            
							<div >
                                    <label>Status <span class="orangeLetter">*</span></label>
                                    
                                    <select name="txtStatus" type="text" id="txtStatus" class="text_box_large" onchange="return getProductStat(<?php echo $prodstatDtl[1]; ?>); ">
                                    <option value="0">------ Select an option ------</option>
                                    <option value="Dyeing" >Dyeing</option>
                                    <option value="Hand" >Hand</option>
                                    <option value="Manual" >Manual</option>
                                    <option value="Computer" >Computer</option>
                                    <option value="Kali Cutting" >Kali Cutting</option>
                                    <option value="Final Stiching" >Final Stiching</option>
                                    <option value="Iron" >Iron</option>
                                    <option value="Packing" >Packing</option>
                                    
                                    </select>
                            </div>
                            <div class="cl"></div>
                            <div id="showResponse"></div>
                           <div class="cl"></div>
						   
							<!--<label>Quantity<span class="orangeLetter">*</span></label>
                            <input name="txtQuantity" type="text" class="text_box_large" id="txtQuantity" 
					         size="25" />
                            <div class="cl"></div>
                            <h2>Note: Unit of Dyeing and Computer is meter</h2>-->
                            
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
							
							
							
							
                            
                            
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
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="asign" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
