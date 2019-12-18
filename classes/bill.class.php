<?php 
/**
*	This class is going to work with all stock associated with a bill. 
*
*	@author		Safikul Islam
*	@date		Jan 13, 2017
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/



class Bill 
{
	
	#####################################################################################################
	#
	#										 Bill Voucher 
	#
	#####################################################################################################
	
	/**
	*	Add a new bill in bill_table table.
	*
	*	@param
	*			
	*			$bill_id			    Bill Identification number	
	*			
	*			
	*
	*	@return int
	*/
	function addBill($bill_for,$tquantity,$qrate,$tamount,$billing_name,$added_on, $added_by,$payment_status,$table)
	
	{
		$bill_for			   	=	mysql_real_escape_string(trim($bill_for));
		$added_on			   	=	mysql_real_escape_string(trim($added_on));
		$added_by			   	=   mysql_real_escape_string(trim($added_by));
		$payment_status			=   mysql_real_escape_string(trim($payment_status));
		$tquantity			   	=	mysql_real_escape_string(trim($tquantity));
		$qrate			   		=   mysql_real_escape_string(trim($qrate));
		$tamount				=   mysql_real_escape_string(trim($tamount));
		$billing_name			=   mysql_real_escape_string(trim($billing_name));
		$modified_on			=   mysql_real_escape_string(trim($added_on));
		$modified_by			=   mysql_real_escape_string(trim($added_by));
		//satement to insert in stock table
		$insert		=   "INSERT INTO ".$table."
						(bill_for,tquantity,qrate,tamount,billing_name,added_on, added_by,payment_status,modified_on,modified_by)
							
						VALUES
						('$bill_for','$tquantity','$qrate','$tamount','$billing_name','$added_on', '$added_by','$payment_status','$modified_on','$modified_by')
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$bill_id	= mysql_insert_id();
		
		//return primary key
		return $bill_id;

	}//eof
	
	/* Display all RFRI Pipe Line bill book data */
	/*
	*/
	 public function showRFRIBill($table){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." order by bill_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	/* Display all Pipe Line bill book data */
	/*
	*/
	 public function getAllBill($todate,$fromdate,$table){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." WHERE added_on between '$todate' and '$fromdate' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	 
	 
	 /**
	*	Get the data associated with a Bill based upon the primary key
	*
	*	@param
	*			$bid		bill id
	*			$table		Table number	
	*	@return array				
	*/
	function allRFRIBillTable($bid,$table)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM ".$table."
				   WHERE bill_id	= '$bid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->bill_id,	//0
					$result->added_on,	//1
					$result->added_by,		//2
					$result->modified_on,	//3
					$result->modified_by,	//4
					$result->bill_for,		//5
					$result->payment_status,//6
					$result->tquantity,		//7
					$result->qrate,			//8
					$result->tamount, 		//9
					$result->billing_name 	//10
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	 
	/**
	*	This function will Update all  Bill table permanently
	*
	*	@param
	*			$bid			
	*	@return null
	*/
	
	//Update All Bill Table
	function UpdateBillTable($bid, $payment_status,$table)
	
	{
		$bid	           			=	trim($bid);
		$payment_status	           	=	trim($payment_status);
		$table	        	   		=	trim($table);

		//update Sample db
		$edit  = "UPDATE ".$table."
				SET
				payment_status		= '$payment_status'
				WHERE
				bill_id				= '$bid'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	 
	 
	/**
	*	This function will Update all  Bill table permanently
	*
	*	@param
	*			$bid			
	*	@return null
	*/
	
	//Update All Bill Table
	function UpdateAllBill($bid, $tquantity,$qrate,$tamount,$table)
	
	{
		$bid	           			=	trim($bid);
		$tquantity	           		=	trim($tquantity);
		$qrate	           			=	trim($qrate);
		$tamount	        	   	=	trim($tamount);
		$table	        	   		=	trim($table);

		//update Sample db
		$edit  = "UPDATE ".$table."
				SET
				tquantity		= '$tquantity',
				qrate			= '$qrate',
				tamount			= '$tamount'
				WHERE
				bill_id				= '$bid'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof 
	 
	 
	/**
	*	This function will Update Billing name permanently
	*
	*	@param
	*			$bid 	= Bill id			
	*	@return null
	*/
	
	//Update Billing Name
	function UpdateBillName($bid, $bill_for,$table)
	{
		$bid	           			=	trim($bid);
		$bill_for	           		=	trim($bill_for);
		$table	        	   		=	trim($table);

		//update Sample db
		$edit  = "UPDATE ".$table."
				SET
				bill_for			= '$bill_for'
				WHERE
				bill_id				= '$bid'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof 
	 
	 
	#####################################################################################################
	#
	#										 Sample Fabric bill 
	#
	#####################################################################################################
	

	/**
	*	Add a new Sample Fabric bill in sample fabric bill table.
	*
	*	@param
	*			
	*			$bill_id			    Sample fabric Bill Identification number	
	*			
	*			
	*
	*	@return int
	*/
	function addSampleFabBill($emp_name,$bill_for,$tamount,$pay_status,$order_date,$target_date,$remarks,$added_by)
	
	{
		$emp_name			   	=	mysql_real_escape_string(trim($emp_name));
		$bill_for			   	=	mysql_real_escape_string(trim($bill_for));
		$tamount			   	=   mysql_real_escape_string(trim($tamount));
		$pay_status				=   mysql_real_escape_string(trim($pay_status));
		
		$order_date			   	=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$remarks			   	=   mysql_real_escape_string(trim($remarks));
		$added_by				=   mysql_real_escape_string(trim($added_by));
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_fabric_bill
						(emp_name,bill_for, tamount,pay_status,order_date,target_date,remarks,added_by,added_on)
							
						VALUES
						('$emp_name','$bill_for', '$tamount','$pay_status','$order_date','$target_date','$remarks',
						'$added_by',now())
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$bill_id	= mysql_insert_id();
		
		//return primary key
		return $bill_id;

	}//eof
	
	
	
	/**
	*	Add a new Sample Fabric bill Dtls in sample fabric bill dtls table.
	*
	*	@param
	*			
	*			$bill_dtls_id			    Sample fabric Bill Dtls Identification number	
	*			
	*			
	*
	*	@return int
	*/
	function addSampleFabBillDtls($bill_id,$fabric,$fcolour,$fab_quantity,$frate,$total_amount)
	
	{
		$bill_id			   	=	mysql_real_escape_string(trim($bill_id));
		$fabric			   		=	mysql_real_escape_string(trim($fabric));
		$fcolour			   	=   mysql_real_escape_string(trim($fcolour));
		$fab_quantity			=   mysql_real_escape_string(trim($fab_quantity));
		
		$frate			   		=	mysql_real_escape_string(trim($frate));
		$total_amount			=	mysql_real_escape_string(trim($total_amount));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO samp_fab_bill_dtls
						(bill_id,fabric, fcolour,fab_quantity,frate,total_amount)
							
						VALUES
						('$bill_id','$fabric', '$fcolour','$fab_quantity','$frate','$total_amount')
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$bill_dtls_id	= mysql_insert_id();
		
		//return primary key
		return $bill_dtls_id;

	}//eof
	
	
	/*=======          Update Sample Fabric Bill Details ========*/
	/*
	*  $bid 			= bill id
	*/
	function updateSampleFbBill($bid,$tamount)
	
	{
		//echo $quantity;exit;	
		$tamount			   	=	mysql_real_escape_string(trim($tamount));
		
		//update product description
		$edit  = "UPDATE sample_fabric_bill
				SET
				tamount				= '$tamount'
				WHERE
				bill_id 			= '$bid'			
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	/*=============Same bill amount count=================*/
	 public function TotalSampFabAmount($bid){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( total_amount) AS `count_total_amount` FROM `samp_fab_bill_dtls` where bill_id ='$bid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_total_amount'];
     }
     return $temp_arr;  
     }
	
	
	
	/**
	*	Get the data associated with a Sample fabric Bill based upon the primary key
	*
	*	@param
	*			$bid		bill id
	*	@return array				
	*/
	function allSampleFabBill($bid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_fabric_bill
				   WHERE bill_id	= '$bid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->bill_id,	//0
					$result->emp_name,	//1
					$result->bill_for,	//2
					$result->tamount,	//3
					$result->pay_status,	//4
					$result->order_date,//5
					$result->target_date,//6
					$result->remarks,	//7
					$result->added_by,		//8
					$result->added_on,		//9
					$result->modified_on,	//10
					$result->modified_by	//11
			
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/* Display Sample fabric bill data */
	/*
	*/
	 public function showSampFabBill(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_fabric_bill order by bill_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	/* Display Sample fabric bill Details data */
	/*
	*/
	 public function showSampFabBillDtl($bid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM samp_fab_bill_dtls where bill_id = '$bid' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	
	#####################################################################################################
	#
	#										 Sample billing
	#
	#####################################################################################################
	

	/**
	*	Add a new Sample billing in sample billing table.
	*
	*	@param
	*			
	*			$bill_id			    Sample Billing Identification number	
	*			
	*			
	*
	*	@return int
	*/
	function addSampleBilling($emp_name,$bill_for,$bill_purpose,$tamount,$pay_status,$order_date,$target_date,$remarks,$added_by)
	
	{
		$emp_name			   	=	mysql_real_escape_string(trim($emp_name));
		$bill_for			   	=	mysql_real_escape_string(trim($bill_for));
		$bill_purpose			=	mysql_real_escape_string(trim($bill_purpose));
		$tamount			   	=   mysql_real_escape_string(trim($tamount));
		$pay_status				=   mysql_real_escape_string(trim($pay_status));
		
		$order_date			   	=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$remarks			   	=   mysql_real_escape_string(trim($remarks));
		$added_by				=   mysql_real_escape_string(trim($added_by));
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_billing
						(emp_name,bill_for,bill_purpose, tamount,pay_status,order_date,target_date,remarks,added_by,added_on)
							
						VALUES
						('$emp_name','$bill_for','$bill_purpose', '$tamount','$pay_status','$order_date','$target_date','$remarks',
						'$added_by',now())
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$bill_id	= mysql_insert_id();
		
		//return primary key
		return $bill_id;

	}//eof
	
	
	
	/**
	*	Add a new Sample billing Dtls in sample billing dtls table.
	*
	*	@param
	*			
	*			$bill_dtls_id			    Sample Billing Dtls Identification number	
	*	
	*	@return int
	*/
	function addSampleBillingDtls($bill_id,$particular,$part_quantity,$prate,$total_amount)
	
	{
		$bill_id			   	=	mysql_real_escape_string(trim($bill_id));
		$particular			   	=	mysql_real_escape_string(trim($particular));
		$part_quantity			=   mysql_real_escape_string(trim($part_quantity));
		$prate					=   mysql_real_escape_string(trim($prate));
		
		$total_amount			=	mysql_real_escape_string(trim($total_amount));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_billing_dtls
						(bill_id,particular, part_quantity,prate,total_amount)
							
						VALUES
						('$bill_id','$particular', '$part_quantity','$prate','$total_amount')
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$bill_dtls_id	= mysql_insert_id();
		
		//return primary key
		return $bill_dtls_id;

	}//eof
	
	
	/*=======          Update Sample Billing Details ========*/
	/*
	*  $bid 			= bill id
	*/
	function updateSampleBilling($bid,$tamount)
	
	{
		//echo $quantity;exit;	
		$tamount			   	=	mysql_real_escape_string(trim($tamount));
		
		//update Sample billing
		$edit  = "UPDATE sample_billing
				SET
				tamount				= '$tamount'
				WHERE
				bill_id 			= '$bid'			
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	/*=============Same billing amount count =================*/
	 public function TotalSampleBillAmount($bid){
     $temp_arr = array();
     $res = mysql_query("SELECT sum(total_amount) AS `count_total_amount` FROM `sample_billing_dtls` where bill_id ='$bid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_total_amount'];
     }
     return $temp_arr;  
     }
	
	
	
	/**
	*	Get the data associated with a Sample Billing based upon the primary key
	*
	*	@param
	*			$bid		bill id
	*	@return array				
	*/
	function allSampleBilling($bid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_billing
				   WHERE bill_id	= '$bid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->bill_id,	//0
					$result->emp_name,	//1
					$result->bill_for,	//2
					$result->bill_purpose,	//3
					$result->tamount,	//4
					$result->pay_status,	//5
					$result->order_date,//6
					$result->target_date,//7
					$result->remarks,	//8
					$result->added_by,		//9
					$result->added_on,		//10
					$result->modified_on,	//11
					$result->modified_by	//12
			
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/* Display Sample billing data */
	/*
	*/
	 public function showSampleBilling(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_billing order by bill_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
	/* Display others billing data */
	/*
	*/
	 public function showOthersBilling(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM mep_others_billing order by bill_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	  
	 
	/* Display Sample billing Details data */
	/*
	*/
	 public function showSampleBillingDtl($bid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_billing_dtls where bill_id = '$bid' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	 

	#####################################################################################################
	#
	#										 Bill Material
	#
	#####################################################################################################
	
	/**
	*	Add a new bill material in bill material table.
	*
	*	@param
	*			
	*			$bill_id			    Bill Identification number	
	*			
	*			
	*
	*	@return int
	*/
	function addBillMat($bill_id,$material_name,$mat_unit,$mamount,$mrate,$total_amount, $added_by,$table)
	
	{
		$bill_id			   	=	mysql_real_escape_string(trim($bill_id));
		$material_name			=	mysql_real_escape_string(trim($material_name));
		$mat_unit				=	mysql_real_escape_string(trim($mat_unit));
		$mamount			   	=	mysql_real_escape_string(trim($mamount));
		$mrate			   		=   mysql_real_escape_string(trim($mrate));
		$total_amount			=   mysql_real_escape_string(trim($total_amount));
		$added_by			   	=   mysql_real_escape_string(trim($added_by));
		$added_on			   	=	mysql_real_escape_string(trim($added_on));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO ".$table."
						(bill_id,material_name,mat_unit,mamount,mrate,total_amount,added_by,added_on)
							
						VALUES
						('$bill_id','$material_name','$mat_unit','$mamount','$mrate','$total_amount','$added_by',now())
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$bm_id	= mysql_insert_id();
		
		//return primary key
		return $bm_id;

	}//eof

	/* Display all bill material data */
	/*
	*/
	 public function showBillMat($bid,$table){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." where bill_id ='$bid' order by bill_id asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 #####################################################################################################
	#
	#										 Others billing
	#
	#####################################################################################################
	

	/**
	*	Add a new others billing in other billing table.
	*
	*	@param
	*			
	*			$bill_id			    others Billing Identification number	
	*			
	*			
	*
	*	@return int
	*/
	function addOtherBilling($emp_name,$bill_for,$bill_purpose,$tamount,$pay_status,$order_date,$target_date,$remarks,$added_by)
	
	{
		$emp_name			   	=	mysql_real_escape_string(trim($emp_name));
		$bill_for			   	=	mysql_real_escape_string(trim($bill_for));
		$bill_purpose			=	mysql_real_escape_string(trim($bill_purpose));
		$tamount			   	=   mysql_real_escape_string(trim($tamount));
		$pay_status				=   mysql_real_escape_string(trim($pay_status));
		
		$order_date			   	=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$remarks			   	=   mysql_real_escape_string(trim($remarks));
		$added_by				=   mysql_real_escape_string(trim($added_by));
		//satement to insert in stock table
		$insert		=   "INSERT INTO mep_others_billing
						(emp_name,bill_for,bill_purpose, tamount,pay_status,order_date,target_date,remarks,added_by,added_on)
							
						VALUES
						('$emp_name','$bill_for','$bill_purpose', '$tamount','$pay_status','$order_date','$target_date','$remarks',
						'$added_by',now())
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$bill_id	= mysql_insert_id();
		
		//return primary key
		return $bill_id;

	}//eof
	
	/**
	*	Add a new Other billing Dtls in Other billing dtls table.
	*
	*	@param
	*			
	*			$bill_dtls_id			    Other Billing Dtls Identification number	
	*	
	*	@return int
	*/
	function addOtherBillingDtls($bill_id,$particular,$part_quantity,$prate,$total_amount)
	
	{
		$bill_id			   	=	mysql_real_escape_string(trim($bill_id));
		$particular			   	=	mysql_real_escape_string(trim($particular));
		$part_quantity			=   mysql_real_escape_string(trim($part_quantity));
		$prate					=   mysql_real_escape_string(trim($prate));
		$total_amount			=	mysql_real_escape_string(trim($total_amount));
		//satement to insert in stock table
		$insert		=   "INSERT INTO mep_others_billing_dtls
						(bill_id,particular, part_quantity,prate,total_amount)
							
						VALUES
						('$bill_id','$particular', '$part_quantity','$prate','$total_amount')
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$bill_dtls_id	= mysql_insert_id();
		
		//return primary key
		return $bill_dtls_id;

	}//eof
	
	 
	/**
	*	Get the data associated with a Other Billing based upon the primary key
	*
	*	@param
	*			$bid		bill id
	*	@return array				
	*/
	function allOtherBilling($bid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM mep_others_billing
				   WHERE bill_id	= '$bid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->bill_id,	//0
					$result->emp_name,	//1
					$result->bill_for,	//2
					$result->bill_purpose,	//3
					$result->tamount,	//4
					$result->pay_status,	//5
					$result->order_date,//6
					$result->target_date,//7
					$result->remarks,	//8
					$result->added_by,		//9
					$result->added_on,		//10
					$result->modified_on,	//11
					$result->modified_by	//12
			
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/*=======          Update Other Billing Details ========*/
	/*
	*  $bid 			= bill id
	*/
	function updateOtherBilling($bid,$tamount)
	{
		//echo $quantity;exit;	
		$tamount			   	=	mysql_real_escape_string(trim($tamount));
		
		//update Sample billing
		$edit  = "UPDATE mep_others_billing
				SET
				tamount				= '$tamount'
				WHERE
				bill_id 			= '$bid'			
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	/* Display other billing Details data */
	/*
	*/
	 public function showOtherBillingDtl($bid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM mep_others_billing_dtls where bill_id = '$bid' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	
}//eoc	
?>	 