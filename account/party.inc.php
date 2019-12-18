
<?php

include_once("init.php");
$q = strtolower($_GET["q"]);
if (!$q) return;
$db->query("SELECT * FROM party");
  while ($line = $db->fetchNextObject()) {
  
  	if (strpos(strtolower($line->party_name ), $q) !== false) {
		echo "$line->party_name \n";
	
 }
 }
?>