
<?php
ob_start();
session_start();
?>
<?php 
//session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/customer.class.php"); 

require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 

require_once("../classes/order.class.php"); 
require_once("../classes/stock.class.php"); 
require_once("../classes/party.class.php");

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/product_status.class.php");
require_once("../classes/adv_search.class.php");
require_once("../classes/photo_gallery.class.php");
require_once("../classes/sample.class.php"); 


require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$customer 		= new Customer();
$dateUtil      	= new DateUtil();
$error 			= new Error();

$orders		    = new Orders();
$prodStatus			= new Pstatus();
$advSearch		= new AdvSearch();
$stock			= new Stock();
$party			= new Party();

$search_obj		= new Search();
$pages			= new Pagination();
$photogallery	= new PhotoGAllery();
$sample			= new Sample();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$sgid			= $utility->returnGetVar('sgid','0');

//echo $_SESSION[USR_SESS];exit;
//customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);
//echo $sgid;exit;



//add a party
if(isset($_POST['CustomerAddBtn']))
{	
	
	$txtPartyName	 	= $_POST['txtPartyName'];
	$txtAddress	 		= $_POST['txtAddress'];
	$txtCity 	        = $_POST['txtCity'];
	$txtPhone	 		= $_POST['txtPhone'];
	$txtEmail			= $_POST['txtEmail'];
	$txtBrokar	 		= $_POST['txtBrokar'];
	$txtRetaHol	 	    = $_POST['txtRetaHol'];
	
	 //$product->addProduct($txtParentId,$txtProdName, $txtPageTitle, $txtProdCode, $intQuant, $txtProdPrice, $txtBrief,
		//$txtProdDesc,$txtSeoUrl,$txtCanonical,$txtMetaTag,$txtMetaDesc,$txtMetaKey);
	
	//registering the post session variables
	$sess_arr	= array('txtPartyName','txtAddress', 'txtCity', 'txtPhone', 'txtRetaHol', 'txtBrokar');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'add_party';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	
	
	$msg = '';
	
	$invalidEmail 	= $error->invalidEmail($txtEmail);
	
	if($txtPartyName=='')
	{
		echo "Party name empty";
	}
	elseif( ($txtEmail == '') ||(preg_match("/^ER/i",$invalidEmail)) )		
	{
		$error->showErrorTA($action, $id, $id_var, $url, "<p style='color: red;'>Invalid Email Id</p>", $typeM, $anchor);
	}
	else
	{
		
	//add the Party
	 $party->addParty($txtPartyName, $txtAddress, $txtCity, $txtPhone,$txtEmail,$txtBrokar,$txtRetaHol,$userData[2]);	
		
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'add-customer.php', 'Customer has been successfully added', 'SUCCESS');
	}
	
}//eof add party


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$sess_arr	= array('txtPartyName','txtAddress', 'txtCity', 'txtPhone', 'txtRetaHol', 'txtBrokar');
	
	//forward
	header("Location: collection.php");
}



?>


<!DOCTYPE html>
<html>
<head>
<title>Moni Enterprises Party Add</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Custom Theme files -->
<!--theme-style-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Fashion Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--fonts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
<!--//fonts-->
</head>
<body> 
	<!--header-->
		<?php require_once('header.inc.php'); ?>
	<!--content-->
	 <div class="content">
			<div class="container">
				<div class="contact">
				<div class="contact-in">
				<h3>Customer Add</h3>
				<div class=" col-md-9 contact-left">
					<!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
					    <div>
							<span>Customer Name</span>
						    <input name="txtPartyName" id="txtPartyName" type="text" class="textbox" required>
						</div>
						<div>
							<span>Customer Address</span>
						    <input name="txtAddress" id="txtAddress" type="text" class="txtAddress" required>
						</div>
						<div>
							<span>Customer City</span>
						    <input name="txtCity" id="txtCity" type="text" class="textbox" required>
						</div>
						<div>
							<span>Customer Phone</span>
						    <input name="txtPhone" id="txtPhone" type="text" class="textbox" required>
						</div>
						<div>
							<span>Customer Email</span>
						    <input name="txtEmail" type="text" class="textbox" required>
						</div>
						<div>
							<span>Brokar</span>
						    <input name="txtBrokar" id="txtBrokar" type="text" class="textbox">
						</div>
						<div>
							<span>Reta/Hol</span>
						    <input name="txtRetaHol" id="txtRetaHol" type="text" class="textbox">
						</div>
						
						<div>
						   	<span><input type="submit" name="CustomerAddBtn" value="Add Customer"></span>
						</div>
					</form>
				</div>

					<div class=" col-md-3 contact-right">
				     	
				    </div>
					  <div class="clearfix"></div>
				</div>
				
			    <div class="map">
				
				</div>
      		</div>
		    </div>
	</div>
	<!---->

	<!---->
	<div class="footer">
		<div class="container">
				<div class="footer-class">
				<div class="class-footer">
					<ul>
						<li ><a href="collection.php" class="scroll">HOME </a><label>|</label></li>
						<li><a href="" class="scroll">MEN</a><label>|</label></li>
						<li><a href="" class="scroll">WOMEN</a><label>|</label></li>
						<li><a href="" class="scroll">COLLECTION</a><label>|</label></li>
						<li><a href="" class="scroll">STORE PRODUCTS</a><label>|</label></li>
						<li><a href="" class="scroll">LATEST  PRODUCT</a></li>
					</ul>
				</div>	 
				<div class="footer-left">
				
				</div> 
				<div class="clearfix"> </div>
			 	</div>
		 </div>
	</div>
</body>
</html>