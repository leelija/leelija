<?php
include_once("init.php");
$q = strtolower($_GET["q"]);
if (!$q) return;
$db->query("SELECT * FROM selling_stock ");
  while ($line = $db->fetchNextObject()) {
  
  	if (strpos(strtolower($line->design_no), $q) !== false) {
		echo "$line->design_no";echo "-";echo "$line->design_part\n";
	
 }
 }

?>