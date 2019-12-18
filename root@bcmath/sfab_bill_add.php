<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("_config/connect.php"); 
require_once("includes/constant.inc.php");
require_once("includes/product.inc.php");
require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php"); 
require_once("classes/status_cat.class.php");
require_once("classes/order.class.php"); 
require_once("classes/product_stock.class.php"); 
require_once("classes/bill.class.php");
require_once("classes/customer.class.php");
require_once("classes/search.class.php");
require_once("classes/pagination.class.php");
require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php"); 
require_once("classes/utilityImage.class.php");
require_once("classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();

$orders		    = new Orders();
$statCat		= new StatusCat();
$search_obj		= new Search();
$pages			= new Pagination();
$customer		= new Customer();

$productStock	= new ProductStock();
$bill 			= new Bill();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$keyword		= $utility->returnGetVar('keyword','');
$type			= $utility->returnGetVar('type','');
$mode			= $utility->returnGetVar('mode','');
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 100);

//customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);


$samFabBilldata = $bill->showSampFabBill();

//add a product
if(isset($_POST['btnAddProd']))
{	
	$txtDesigner	 		= $_POST['txtDesigner'];
	$txtDyerName	 		= $_POST['txtDyerName'];
	
	$txtProdDesc	 		= $_POST['txtProdDesc'];
	$OrdersDate	 			= $_POST['OrdersDate'];
	$TargetDate 			= $_POST['TargetDate'];
	$selNum					= $_POST['selNum'];
	
	//registering the post session variables
	$sess_arr	= array('txtDesigner','txtDyerName', 'txtDesignNo','txtProdDesc','OrdersDate','TargetDate');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'add_fbill';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	
	
	$msg = '';
	
	if($txtDesigner=='')
	{
		echo "Designer Name empty";
	}
	
	elseif($TargetDate=='')
	{
		echo "Target date field empty";
	}
	elseif($OrdersDate=='')
	{
		echo "Fill up order date field";
	}
	elseif($txtDyerName=='')
	{
		echo "Dyer Name field empty";
	}
	else
	{
		
	//add the Sample Fabric bill
	  $bill_id =  $bill->addSampleFabBill($txtDesigner, $txtDyerName, '', '',$OrdersDate,$TargetDate,$txtProdDesc,$userData[2]);	
		
		for($i=0; $i < $selNum; $i++)
			{
				$tAmount 	= $_POST['txtRate'][$i] * $_POST['txtQuantity'][$i];
				//add the bill details
				$bill->addSampleFabBillDtls($bill_id,$_POST['txtFabricName'][$i],$_POST['txtColourType'][$i],
				$_POST['txtQuantity'][$i],$_POST['txtRate'][$i],$tAmount);	
				
				
				$samFabBillDtls 	= $bill->allSampleFabBill($bill_id);
				$TotalAmount 		= $samFabBillDtls[3] + $tAmount;
				$bill->updateSampleFbBill($bill_id,$TotalAmount);
			}
			
				
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'sample_fab_bill.php', "Bill has been successfully added", 'SUCCESS');
	}
	
}//eof add sample fabric bill


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtDesigner','txtDyerName', 'txtDesignNo','txtProdDesc','OrdersDate','TargetDate');
	
	//forward
	header("Location: sample_fab_bill.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Sample Fabric Bill Details</title>

<!-- Style -->
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- DataTables -->
  
<link href="style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="style/bootstrap/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

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
<script type="text/javascript" src="js/samp_fab_bill.js"></script>

<!--   multi filter -->
<script src='js/multifilter.js'></script>
<script src="js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="js/jquery.dataTables.yadcf.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<!-- eof JS Libraries -->

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
                	<h1>Sample Bill Add</h1>
                </div>
                
                <!-- Form -->
                <div class="webform-area">
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_fbill')) 
					{	
					?>
                   
                        <h2><a name="addUser">Add New Record</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                         
                            <div class="cl"></div>
                         
                            <label>Designer Name<span class="orangeLetter">*</span></label>
                            <input name="txtDesigner" type="text" class="text_box_large" id="txtDesigner" 
					        value="" size="25" />
                            <div class="cl"></div>
                            
                            <label>Dyer Name</label>
                            <input name="txtDyerName" type="text" class="text_box_large" id="txtDyerName" 
					        value="<?php $utility->printSess2('txtDyerName',''); ?>" size="25" />
                            <div class="cl"></div>
                            
							<tr>
								<label>Select No. of Fabric</label>
									<!--<td align="left" class="menuText">Select No. Type </td>-->
									<td align="left" class="bodyText pad5">
									<?php 
									//gen number array
									$arr_value	= range(1,48);
									$arr_label	= range(1,48);
									?>
									  <select name="selNum" id="selNum" onchange="return getSampFbBill();"
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
								<div id="showSampFabBill"></div>
							
							<div class="cl"></div>
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
							<div class="cl"></div>
							 <label>Orders Date<span class="orangeLetter">*</span></label>
                            <input name="OrdersDate" type="date" class="text_box_large" id="OrdersDate" 
					        value="<?php $utility->printSess2('OrdersDate',''); ?>" size="25" />
                            <div class="cl"></div>
							
							 <label>Target Date<span class="orangeLetter">*</span></label>
                            <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
					        value="<?php $utility->printSess2('TargetDate',''); ?>" size="25" />
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
