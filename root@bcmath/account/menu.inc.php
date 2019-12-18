

<div id="brand-logo">
    <img src="../<?php //echo LOGO_ADMIN_PATH; ?>" width="<?php //echo LOGO_ADMIN_WIDTH; ?>" 
    height="<?php //echo LOGO_ADMIN_HEIGHT; ?>" alt="<?php //echo LOGO_ALT; ?>" />     
</div>



<div class="menu-block">
	<h2 data-toggle="collapse" data-target="#sproducts" style="cursor:pointer"><img src="../images/admin/icon/marketing-tools.png" width="20" height="20" alt="Web Page" />Company Account</h2>
		<ul id="sproducts" class="collapse">
			<li><a href="company.php" title="Sample product">Company Details</a></li>
			<li><a href="company-account.php" title="Sample product">Bank Account Details</a></li>
			<li><a href="comp-transaction.php" title="Sample product">Transaction Details</a></li>
		</ul>
	
	<h2 data-toggle="collapse" data-target="#orders" style="cursor:pointer"><img src="../images/admin/icon/user-management.png" width="20" height="20" alt="User Management" />Supplier Details</h2>
    <ul id="orders" class="collapse">
        <li><a href="supplier-dtls.php" title="Supplier Details">Supplier</a></li>
		<li><a href="supp-acc-dtls.php" title="Supplier Acc Details">Supplier Due Dtls</a></li>
		<li><a href="supplier-bill-entry.php" title="Purchase Bill">Purchase Bill Details</a></li>
		<li><a href="purchase-prm.php" title="Purchase Prm">Purchase PRM Bill</a></li>
		<li><a href="supp-tran-dtls.php" title="Supplier Payment Details">Supplier Payment Details</a></li>
    </ul>
	   
    <h2 data-toggle="collapse" data-target="#prodstat" style="cursor:pointer"><img src="../images/admin/icon/medical-test.png" width="20" height="20" />Vendor Details</h2>
    <ul id="prodstat" class="collapse">
        <li><a href="vendor-dtls.php" title="Vendor Details">Vendor Details </a></li>
		<li><a href="vendor-acc-dtls.php" title="Vendor Account">Account Details</a></li>
		<li><a href="vendor-bill-entry.php" title="Vendor Bill Entry">Bill Details</a></li>
        <li><a href="vendor-tran-dtls.php" title="Vendor Transaction Details">Payment Details</a></li>
		<li><a href="vpayment-advice.php" title="Vendor Payment Advice">Payment Advice</a></li>
    </ul>
	<h2 data-toggle="collapse" data-target="#customer" style="cursor:pointer"><img src="../images/admin/icon/user-management.png" width="20" height="20" alt="Customer Management" />Customer Details</h2>
    <ul id="customer" class="collapse">
        <li><a href="customer.php" title="Supplier Details">Customer Details</a></li>
		<li><a href="buyer-acc-dtls.php" title="Add sales Bill">Customer Account</a></li>
		<li><a href="sales-prm.php" title="Sales PRM">Sales PRM Details</a></li>
		<li><a href="cust-tran-dtls.php" title="Supplier Payment Details">Customer Payment Details</a></li>
    </ul>
    <h2 data-toggle="collapse" data-target="#sellingBill" style="cursor:pointer"><img src="../images/admin/icon/marketing-tools.png" width="20" height="20" alt="Sales Management" />Sales Details</h2>
    <ul id="sellingBill" class="collapse">
		<li><a href="add_sales.php" title="Add sales Bill">Add Sales Bill</a></li>
		<li><a href="view-selling.php" title="Selling Bill">Sales Bill</a></li>
		<li><a href="sales-prm.php" title="Sales PRM">Sales PRM Details</a></li>
    </ul>
	
	<h2 data-toggle="collapse" data-target="#stockDtls" style="cursor:pointer"><img src="../images/admin/icon/marketing-tools.png" width="20" height="20" alt="Stock Management" />Stock Details</h2>
    <ul id="stockDtls" class="collapse">
		<li><a href="selling-rate.php" title="Add sales Bill">Selling Rate</a></li>
    </ul>
	<h2 data-toggle="collapse" data-target="#currier" style="cursor:pointer"><img src="../images/admin/icon/user-management.png" width="20" height="20" alt="Currier Management" />Courier Details</h2>
    <ul id="currier" class="collapse">
        <li><a href="currier.php" title="Currier Details">Courier Details</a></li>
    </ul>
    <h2 data-toggle="collapse" data-target="#admin" style="cursor:pointer"><img src="../images/admin/icon/tools.png" width="20" height="20" alt="Tools" />Setup Tools</h2>
    <ul id="admin" class="collapse">
        <li><a href="../admin/back_up.php" title="Database Backup" >Database Backup</a></li>
       <?php /*?> <li><a href="paypal.php" title="Manage PayPal">Manage PayPal</a></li><?php */?>
    </ul>
    
</div>


