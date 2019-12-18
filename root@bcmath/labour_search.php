<?php
require_once("_config/connect.php"); 
require_once("classes/labour.class.php");



/*Variable declare*/
$labour			= new Labour();

$in=$_GET['txt'];

$labourDtl  = $labour->LabourDtlsearch($in);



$msg="";
$msg="<select id=s1 size='15'>";
if(strlen($in)>0 and strlen($in) <20 ){
$sql="select labour_name, labour_id from labour_table where labour_name like '%$in%'";
foreach ($labourDtl as $eachrecord) {
		echo "<div>";
			$msg .="<option value=$eachrecord[labour_id]>$eachrecord[labour_name] => $eachrecord[labour_id]</option>";
		echo "</div>";
}
}
$msg .='</select>';
echo $msg;
?>