<?php
   /**
	*  This function show vendor wise pending bill .
	*
	*/
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	require_once("../_config/connect.php"); 
	require_once("../classes/vendor.class.php");
   
	if( isset($_GET['id'] )) {
        $vid  		= $_GET['id'];
		// Instantiating class	
	    $vendor		= new Vendor();
		// Caling method 			
		$venBill 	= $vendor->getVendorBlncDtls($vid);
		echo json_encode($venBill);	 
		//print_r( $venBill );    
	}	    	                           
	exit;
?>