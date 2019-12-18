
<?php

include_once("init.php");
$q = strtolower($_GET["q"]);
if (!$q) return;
$db->query("SELECT * FROM buyer_details");
  while ($line = $db->fetchNextObject()) {
  
  	if (strpos(strtolower($line->company ), $q) !== false) {
		echo "$line->company\n";
	
 }
 }
?>