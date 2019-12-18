<?php
require_once("../_config/connect.php"); 
require_once("../classes/customer.class.php");



/*Variable declare*/
$customer			= new Customer();

$in=$_GET['txt'];

$custDtl  = $customer->CustomerDtlsearch($in);



$msg="";
$msg="<select id=s1 size='15'>";
if(strlen($in)>0 and strlen($in) <20 ){
$sql="select user_name, customer_id from customer where user_name like '%$in%'";
foreach ($custDtl as $eachrecord) {
		echo "<div>";
			$msg .="<option value=$eachrecord[customer_id]>$eachrecord[user_name] => $eachrecord[customer_id]</option>";
		echo "</div>";
}
}
$msg .='</select>';
echo $msg;
?>