<?php
	include("lib/db.class.php");
    $db = new DB("moni_enterprises", "localhost", "root", "Gold@2018");  
	// Open the base (construct the object):
	//$db = new DB($config['database'], $config['host'], $config['username'], $config['password']);
	
	# Note that filters and validators are separate rule sets and method calls. There is a good reason for this. 
/*
	require "lib/gump.class.php";
	
	$gump = new GUMP(); 
	
	
	// Messages Settings
	$POSNIC = array();
	$POSNIC['username'] = $_SESSION['username'];
	$POSNIC['usertype'] = $_SESSION['usertype'];
	$POSNIC['msg'] 		= '';
	if(isset($_REQUEST['msg']) && isset($_REQUEST['type']) ) {
					
					if($_REQUEST['type'] == "error")
						$POSNIC['msg'] = "<div class='error-box round'>".$_REQUEST['msg']."</div>";
					else if($_REQUEST['type'] == "warning")
						$POSNIC['msg'] = "<div class='warning-box round'>".$_REQUEST['msg']."</div>"; 
					else if($_REQUEST['type'] == "confirmation")
						$POSNIC['msg'] = "<div class='confirmation-box round'>".$_REQUEST['msg']."</div>"; 
					else if($_REQUEST['type'] == "infomation")
						$POSNIC['msg'] = "<div class='information-box round'>".$_REQUEST['msg']."</div>"; 
	}*/
?>