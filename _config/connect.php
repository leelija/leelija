<?php
//database connection parameter
$url		= "localhost";							  //localhost						//
$user		= "root"; 							//admin 		
$password	= "Gold@2018";						  //			
$db		= "moni_enterprises";					//
 //echo "hi";exit;
//localhost connection
$link = mysql_connect($url, $user, $password) or die("<h3> Sorry!!! Unable to connect</h3>");
mysql_select_db($db) or die("<h3>Sorry!!! Couldn't select the database</h3>");
?>
