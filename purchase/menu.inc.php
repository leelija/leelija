<?php
require_once("../classes/customer.class.php");
$customer		= new Customer();

$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);
?>

<div id="brand-logo">
   <!-- <img src="../<?php //echo LOGO_ADMIN_PATH; ?>" width="<?php //echo LOGO_ADMIN_WIDTH; ?>" 
    height="<?php //echo LOGO_ADMIN_HEIGHT; ?>" alt="<?php //echo LOGO_ALT; ?>" />  -->   
</div>
<?php
if($userData[21] == 2){
?>
<div class="menu-block">
	<h2 data-toggle="collapse" data-target="#mac" style="cursor:pointer"><img src="../images/admin/icon/user-management.png" width="20" height="20" alt="User Management" />Profile</h2>
    <ul id="mac" class="collapse">
        <li><a href="employee_account.php" title="Employee">My Profile</a></li>
    </ul>
	
	<h2 data-toggle="collapse" data-target="#account" style="cursor:pointer"><img src="../images/admin/icon/marketing-tools.png" width="20" height="20" alt="Web Page" />HMDA Account</h2>
    <ul id="account" class="collapse">
        <?php /*?><li><a href="email.php" title="Send Email">Google Analytics</a></li><?php */?>
		 <li><a href="assets.php" title="Assets">Company Assets</a></li>
		 <li><a href="assets-hist.php" title="Assets Hist">Assets Hist.</a></li>
         <li><a href="journal-account.php" title="Journal Account">Journal Account</a></li>
		 <li><a href="daily-expenses.php" title="Daily Expenses">Daily Expenses</a></li>
		 <li><a href="dexpenses.php" title="Daily Expenses">Last Expenses</a></li>
    </ul>
	
	<h2 data-toggle="collapse" data-target="#sproducts" style="cursor:pointer"><img src="../images/admin/icon/web-page.png" width="20" height="20" alt="Web Page" />Purchase Cost</h2>
    <ul id="sproducts" class="collapse">
		<li><a href="purchase.php" title="Sample Product Details">Purchase</a></li>
       <!-- <li><a href="plan.php" title="Plan Management">Plan Management</a></li>    -->
    </ul>
	
	<h2 data-toggle="collapse" data-target="#fabric" style="cursor:pointer"><img src="../images/admin/icon/rawmaterial.jpg" width="20" height="20" alt="Raw Materials" /> Raw Materials</h2>
    <ul id="fabric" class="collapse">
        <?php /*?><li><a href="email.php" title="Send Email">Google Analytics</a></li><?php */?>
        <li><a href="fabric.php" title="Product Status">Materials</a></li>
		<li><a href="material-in.php" title="Product Status">Materials In Details</a></li>
		<li><a href="material_out.php" title="Product Status">Materials Out Details</a></li>
		<li><a href="purchase-company.php" title="Purchase Company">Purchase Company</a></li>
    </ul>
</div>
<?php
}
elseif($userData[21] == 1){
?>
<div class="menu-block">
	<h2 data-toggle="collapse" data-target="#mac" style="cursor:pointer"><img src="../images/admin/icon/user-management.png" width="20" height="20" alt="User Management" />Profile</h2>
    <ul id="mac" class="collapse">
        <li><a href="employee_account.php" title="Employee">My Profile</a></li>
    </ul>
	
	<h2 data-toggle="collapse" data-target="#maccount" style="cursor:pointer"><img src="../images/admin/icon/marketing-tools.png" width="20" height="20" alt="Web Page" />MONIEMP Account</h2>
    <ul id="maccount" class="collapse">
        <?php /*?><li><a href="email.php" title="Send Email">Google Analytics</a></li><?php */?>
		 <li><a href="massets.php" title="Assets">Company Assets</a></li>
		 <li><a href="massets-hist.php" title="Assets Hist">Assets Hist.</a></li>
         <li><a href="mjournal-account.php" title="Journal Account">Journal Account</a></li>
		 <li><a href="mdaily-expenses.php" title="Daily Expenses">Daily Expenses</a></li>
    </ul>
	
	<h2 data-toggle="collapse" data-target="#mMaterials" style="cursor:pointer"><img src="../images/admin/icon/web-page.png" width="20" height="20" alt="Raw Materials" /> MEP Row Materials</h2>
    <ul id="mMaterials" class="collapse">
        <?php /*?><li><a href="email.php" title="Send Email">Google Analytics</a></li><?php */?>
        <li><a href="mmaterials.php" title="Matrials/Fabrics">Materials/Fabrics</a></li>
		<li><a href="mmaterials-in-dtls.php" title="Materials In Details">Materials In Details</a></li>
		<li><a href="mmaterials-out-dtls.php" title="Materials Out Details">Materials Out Details</a></li>
		<li><a href="purchase-company.php" title="Purchase Company">Purchase Company</a></li>
    </ul>
</div>
<?php
}else{}
?>