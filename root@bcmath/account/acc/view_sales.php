<?php
session_start();
include_once('checkSession.php');
require_once("../../_config/connect.php"); 
require_once("../../includes/constant.inc.php");
require_once("../../includes/product.inc.php");
require_once("../../classes/adminLogin.class.php"); 
require_once("../../classes/date.class.php");  
require_once("../../classes/error.class.php"); 
require_once("../../classes/order.class.php"); 
require_once("../../classes/search.class.php");
require_once("../../classes/pagination.class.php");
require_once("../../classes/sample.class.php");
require_once("../../classes/employee.class.php");
require_once("../../classes/company.class.php");
 require_once("../../classes/vendor.class.php"); 
require_once("../../classes/customer.class.php");
require_once("../../classes/supplier.class.php"); 
require_once("../../classes/party.class.php"); 
require_once("../../classes/invoice.class.php"); 

require_once("../../classes/product_status.class.php");
require_once("../../classes/utility.class.php"); 
require_once("../../classes/utilityMesg.class.php"); 
require_once("../../classes/utilityImage.class.php");
require_once("../../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$sample			= new Sample();
$company		= new Company();
$vendor			= new Vendor();
$customer		= new Customer();
$status			= new Pstatus();
$employee		= new Employee();
$supplier		= new Supplier();
$party			= new Party();
$invoice		= new Invoice();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

//$sid			= $utility->returnGetVar('sid','0');

//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[ACC_SESS]);
$invoiceDtls	=  $invoice->getInvoiceData();
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title> Sales Bill</title>
	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Optimize for mobile devices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!-- jQuery & JS files -->
	<?php include_once("tpl/common_js.php"); ?>
	<script src="js/script.js"></script> 
	<script  src="dist/js/jquery.ui.draggable.js"></script>
	<script src="dist/js/jquery.alerts.js"></script>
	<link rel="stylesheet"  href="dist/js/jquery.alerts.css" >
        
    <script LANGUAGE="JavaScript">
		function confirmSubmit(id,table,dreturn)
			{ 	     
				jConfirm('You Want Delete This Sales Details', 'Confirmation Dialog', function (r) {
				   if(r){ 
					   console.log();
						$.ajax({
					url: "delete.php",
					data: { id: id, table:table,return:dreturn},
					success: function(data) {
						window.location ='view_sales.php';
						
								jAlert('Sales Is Deleted', 'POSNIC');
					}
				});
					}
					return r;
				});
			}

		function confirmDeleteSubmit()
		{
		   var flag=0;
		  var field=document.forms.deletefiles;
		for (i = 0; i < field.length; i++){
			if(field[i].checked ==true){
				flag=flag+1;
				
			}
			
		}
		if (flag <1) {
		  jAlert('You must check one and only one checkbox', 'POSNIC');
		return false;
		}else{
		 jConfirm('You Want Delete Sales', 'Confirmation Dialog', function (r) {
				   if(r){ 
			
		document.deletefiles.submit();}
		else {
			return false ;
		   
		}
		});
		   
		}
		}
		function confirmLimitSubmit()
		{
			if(document.getElementById('search_limit').value!=""){

		document.limit_go.submit();

			}else{
				return false;
			}
		}


		function checkAll()
		{

			var field=document.forms.deletefiles;
		for (i = 0; i < field.length; i++)
			field[i].checked = true ;
		}

		function uncheckAll()
		{
			var field=document.forms.deletefiles;
		for (i = 0; i < field.length; i++)
			field[i].checked = false ;
		}
		// -->
	</script>
	<script>
                    
                    
	/*$.validator.setDefaults({
		submitHandler: function() { alert("submitted!"); }
	});*/
	$(document).ready(function() {
	
		// validate signup form on keyup and submit
		$("#form1").validate({
			rules: {
				name: {
					required: true,
					minlength: 3,
					maxlength: 200
				},
				address: {
					minlength: 3,
					maxlength: 500
				},
				contact1: {
					minlength: 3,
					maxlength: 20
				},
				contact2: {
					minlength: 3,
					maxlength: 20
				}
			},
			messages: {
				name: {
					required: "Please enter a supplier Name",
					minlength: "supplier must consist of at least 3 characters"
				},
				address: {
					minlength: "supplier Address must be at least 3 characters long",
					maxlength: "supplier Address must be at least 3 characters long"
				}
			}
		});
	
	});

	</script>

</head>
<body>

	<!-- TOP BAR -->
	<?php //include_once("tpl/top_bar.php"); ?>
	<!-- end top-bar -->
	
	
	
	<!-- HEADER -->
	<div id="header-with-tabs">
		
		<div class="page-full-width cf">
	
			<ul id="tabs" class="fl">
				<li><a href="dashboard.php" class="dashboard-tab">Dashboard</a></li>
				<li><a href="view_sales.php" class=active-tab sales-tab">Sales</a></li>
				<li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
				<li><a href="view_purchase.php" class=" purchase-tab">Purchase</a></li>
				<li><a href="view_supplier.php" class=" supplier-tab">Supplier</a></li>
				<li><a href="view_product.php" class=" stock-tab">Stocks / Products</a></li>
				<li><a href="view_payments.php" class="payment-tab">Payments / Outstandings</a></li>
				<li><a href="view_report.php" class="report-tab">Reports</a></li>
			</ul> <!-- end tabs -->
			
			<!-- Change this image to your own company's logo -->
			<!-- The logo will automatically be resized to 30px height. -->
			<!--<a href="#" id="company-branding-small" class="fr"><img src="<?php if(isset($_SESSION['logo'])) { echo "upload/".$_SESSION['logo'];}else{ echo "upload/posnic.png"; } ?>" alt="Point of Sale" /></a>
			-->
		</div> <!-- end full-width -->	

	</div> <!-- end header -->
	
	
	
	<!-- MAIN CONTENT -->
	<div id="content">
		
		<div class="page-full-width cf">
			<div class="side-menu fl">
				<h3>Sales</h3>
				<ul>
					<li><a href="add_sales.php">Add Sales</a></li>
					<li><a href="view_sales.php">View Sales</a></li>
					
				</ul>
			</div> <!-- end side-menu -->
			<div class="side-content fr">
				<div class="content-module">
					<div class="content-module-heading cf">
						<h3 class="fl">Sales</h3>
						<span class="fr expand-collapse-text">Click to collapse</span>
						<span class="fr expand-collapse-text initial-expand">Click to expand</span>
					</div> <!-- end content-module-heading -->
					
					<div class="content-module-main cf"><!--start content module-->
						<!-- Options --><br><br>
						<div id="options-area">
							<div class="add-new-option">
								<a href="add-customer-bill.php?action=add_suppBill#addSuppBill" >
								  Add Records				  
								</a>
							</div>
							<a href="../file_download.inc.php?table=supplier_bill_entry">Download</a>
						</div>
							
						<div class="padT30"><!-- --> </div> 
						<div id="PrintForm">
							<!-- Display Data -->
							<div id="data-column" style="position:relative; bottom: 9px;">
								<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
									<!-- display option -->
									<?php 
									if(count($invoiceDtls) == 0)
									{
									?>
									<tr align="left" class="orangeLetter">
									  <td height="20" colspan="5"> <?php echo "Table is empty"; ?></td>
									 </tr>
									<?php 
									}
									else
									{
									?>  
									<thead>
									<tr>
									  <th width="3%" height="25"  align="center">Id</th>
									 <!-- <th width="3%" height="25"  align="center">Stock Id</th> -->
									  <th width="10%">Customer Name</th>
									  <th width="10%" >Bill No</th>
									  <th width="10%" >Billing On</th>
									  <th width="10%" >Balance</th>
									  <th width="10%" >SGST(%)</th>
									  <th width="10%" >SGST(Rs.)</th>
									  <th width="10%" >CGST(%)</th>
									  <th width="10%" >CGST(Rs.)</th>
									  <th width="10%" >IGST(%)</th>
									  <th width="10%" >IGST(Rs.)</th>
									  <th width="15%" >Net Balance</th>
									  <th width="15%" >Notes</th>
									  <th width="15%" >Added By</th>
									  <th width="15%" >Added On</th>
									 <th width="15%" align="center">Action</th>
									</tr>  
									</thead>
									<tbody>
								   <?php 
									$sl=1;
									//$k = $pages->getPageSerialNum($numResDisplay);
									//	$sid = array_slice($sid, $start, $limit);     
									foreach($invoiceDtls as $eachRecord)
										{
										
										$compDetail 				= $company->showCompAcc($eachRecord['billing_name']);
										//$custDtl					= $party->showParty($eachRecord['pid']);
										$bgColor 	= $utility->getRowColor($sl);	
										
								?>
								  <tr align="left"<?php $utility->printRowColor($bgColor);?>>
									<td align="left"><?php echo $sl; ?></td>
								   <td align="center"><a href=""><?php echo $eachRecord['party']; ?></a></td>
								   <td align="center"><?php echo $eachRecord['bill_no']; ?></td>
								   <td align="center"><?php echo $compDetail[1]; ?></td>
								   <td align="center"><?php echo $eachRecord['balance']; ?></td>
								   <td align="center"><?php echo $eachRecord['sgst_rate']; ?></td>
								   <td align="center"><?php echo $eachRecord['sgst']; ?></td>
								   <td><?php echo $eachRecord['cgst_rate']; ?></td>
								   <td align="center"><?php echo $eachRecord['cgst']; ?></td>
								   <td align="center"><?php echo $eachRecord['igst_rate']; ?></td>
								   <td align="center"><?php echo $eachRecord['igst']; ?></td>
								   <td align="center"><?php echo $eachRecord['net_balance']; ?></td>
								   <td align="center"><?php echo $eachRecord['notes']; ?></td>
								   <td align="center"><?php echo $eachRecord['added_by']; ?></td>
								   <td align="center"><?php echo $eachRecord['added_on']; ?></td>
								   <td align="center">
									
									<a href="#.php?action=create_Tran&sbe_id=<?php echo $eachRecord['invoice_id']; ?>" >
										Payment				  
									</a>
								   </td>
								  
									
								 </tr>
								  <?php 
									$sl++;
										}
								  }
								  ?>
								</tbody>  
							  </table>
							   
								<div class="first-column">
							  </div>
							  
							</div>
							<!-- eof Display Data -->
						</div> 
						<div class="cl"></div>
				
					
				
					</div><!--end content module-->
				</div> 
			</div>
		<div id="footer">
		<p> &copy;Copyright 2017 </p>
	
		</div> <!-- end footer -->

</body>
</html>