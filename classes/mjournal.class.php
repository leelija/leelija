<?php 
/**
*	This class is going to work with all Journal associated with a Journal details. 
*
*	@author		Safikul Islam
*	@date		Apr 28, 2017
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/


class mJournal
{

	#####################################################################################################
	#
	#										Add New Journal Account
	#
	#####################################################################################################
	
	/**
	*	Add a new Journal Account records in journal_account table.
	*
	*	@param
	*			
	*			$jacc_id			   	    Journal Account identity code
	*			$jacc_name					Journal Account Name
	*			$jacc_desc					Journal Account Description
	*			$balance			     	Balance
	*			$added_by			   	    Added Date			
	*
	*	@return int
	*/
	function addMJournalAcc($jacc_name,$jacc_desc,$balance,$added_by)
	
	{
		$jacc_name			  	   	=	mysql_real_escape_string(trim($jacc_name));
		$jacc_desc			  	   	=	mysql_real_escape_string(trim($jacc_desc));
		$balance			   		=	mysql_real_escape_string(trim($balance));
		$added_by			       	=	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO mjournal_account
						(jacc_name,jacc_desc,balance,added_by, added_on)
						VALUES
						('$jacc_name','$jacc_desc','$balance','$added_by',now())
							
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the Journal Account id
		$jacc_id	= mysql_insert_id();
		
		//return primary key
		return $jacc_id;

	}//eof
	
	
	
	//Update Journal Account table
	function UpdateMJournalAccount($jacc_id, $jacc_name,$jacc_desc,$balance,$modified_by)
	{
		$jacc_id			   	    =	mysql_real_escape_string(trim($jacc_id));
		$jacc_name			  	   	=	mysql_real_escape_string(trim($jacc_name));
		$jacc_desc			  	   	=	mysql_real_escape_string(trim($jacc_desc));
		$balance			   		=	mysql_real_escape_string(trim($balance));
		$modified_by			    =	mysql_real_escape_string(trim($modified_by));

		//update Journal Account
		$edit  = "UPDATE mjournal_account
				SET
				jacc_name		 	= '$jacc_name',
				jacc_desc		 	= '$jacc_desc',
				balance		 		= '$balance',
				modified_by			= '$modified_by',
				modified_on			= now()
				WHERE
				jacc_id 			= '$jacc_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										Display Journal Account data
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Journal Account based upon the primary key
	*
	*	@param
	*			$jacc_id		Journal Account id
	*
	*	@return array				
	*/
	function showMJournalAcc($jacc_id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM mjournal_account
				   WHERE jacc_id	= '$jacc_id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->jacc_id,			//0
					$result->jacc_name,			//1
					$result->jacc_desc,			//2
					$result->balance,			//3
					$result->added_by,			//4
					$result->added_on,			//5
					$result->modified_by,		//6
					$result->modified_on		//7
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Display Journal Account records from journal_account table.
	*
	*	@param
	*			
	*/
	public function getMAllJournalAcc(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM mjournal_account order by jacc_name ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	#####################################################################################################
	#
	#										Add New Journal Book
	#
	#####################################################################################################
	
	/**
	*	Add a new Journal Book records in journal_book table.
	*
	*	@param
	*			
	*			$jb_id			   	    	Journal Book identity No.
	*			$jacc_id					Journal Book identity No.
	*			$payment_type				Payment Type
	*			$pay_amount			     	Payment Amount
	*			$payment_received			Payment Receiver
	*			$prepared_by			    Payment Prepared by
	*			$added_by			   	    Added Date			
	*
	*	@return int
	*/
	function addMJournalBook($jacc_id,$expenses_purpose,$payment_type,$pay_amount,$payment_received,$prepared_by,$status,$added_by,$added_on)
	
	{
		$jacc_id			  	   	=	mysql_real_escape_string(trim($jacc_id));
		$expenses_purpose			=	mysql_real_escape_string(trim($expenses_purpose));
		$payment_type			  	=	mysql_real_escape_string(trim($payment_type));
		$pay_amount			   		=	mysql_real_escape_string(trim($pay_amount));
		$payment_received			=	mysql_real_escape_string(trim($payment_received));
		$prepared_by			   	=	mysql_real_escape_string(trim($prepared_by));
		$status			   			=	mysql_real_escape_string(trim($status));
		$added_by			       	=	mysql_real_escape_string(trim($added_by));
		$added_on			       	=	mysql_real_escape_string(trim($added_on));
		//satement to insert in stock table
		$insert		=   "INSERT INTO mjournal_book
						(jacc_id,expenses_purpose,payment_type,pay_amount,payment_received,prepared_by,status,added_by, added_on)
						VALUES
						('$jacc_id','$expenses_purpose','$payment_type','$pay_amount','$payment_received','$prepared_by','$status','$added_by','$added_on')
							
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the Journal Book id
		$jb_id		= mysql_insert_id();
		
		//return primary key
		return $jb_id;

	}//eof
	
	
	
	//Update Journal Book table
	function UpdateMJournalBook($jb_id,$jacc_id,$payment_type,$pay_amount,$payment_received,$prepared_by,$modified_by)
	{
		$jacc_id			  	   	=	mysql_real_escape_string(trim($jacc_id));
		$payment_type			  	=	mysql_real_escape_string(trim($payment_type));
		$pay_amount			   		=	mysql_real_escape_string(trim($pay_amount));
		$payment_received			=	mysql_real_escape_string(trim($payment_received));
		$prepared_by			   	=	mysql_real_escape_string(trim($prepared_by));
		$modified_by			    =	mysql_real_escape_string(trim($modified_by));

		//update Journal Account
		$edit  = "UPDATE mjournal_book
				SET
				jacc_id		 		= '$jacc_id',
				payment_type		= '$payment_type',
				pay_amount		 	= '$pay_amount',
				payment_received	= '$payment_received',
				prepared_by		 	= '$prepared_by',
				modified_by			= '$modified_by',
				modified_on			= now()
				WHERE
				jb_id 				= '$jb_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	//Update Journal Book table
	function UpdateMjBookPayment($jb_id,$status,$modified_by)
	{
		$status			  	   		=	mysql_real_escape_string(trim($status));
		$modified_by			    =	mysql_real_escape_string(trim($modified_by));

		//update Journal Account
		$edit  = "UPDATE mjournal_book
				SET
				status		 		= '$status',
				modified_by			= '$modified_by',
				modified_on			= now()
				WHERE
				jb_id 				= '$jb_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	#####################################################################################################
	#
	#										Display Journal Book data
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Journal Book based upon the primary key
	*
	*	@param
	*			$jb_id		Journal Book id
	*
	*	@return array				
	*/
	function showMJournalBook($jb_id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM mjournal_book
				   WHERE jb_id	= '$jb_id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->jb_id,				//0
					$result->jacc_id,			//1
					$result->payment_type,		//2
					$result->pay_amount,		//3
					$result->payment_received,	//4
					$result->prepared_by,		//5
					$result->added_by,			//6
					$result->added_on,			//7
					$result->modified_by,		//8
					$result->modified_on,		//9
					$result->expenses_purpose,	//10
					$result->status				//11
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Display Journal Book records from journal_book table.
	*
	*	@param
	*			
	*/
	public function getMAllJournalBook(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM mjournal_book order by jb_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	/*==============================*/
	/* Count daily expenses date wise
	*//*===============================*/
	 public function conMDailyExp($todate,$fromdate){
     $temp_arr = array();
     $res = mysql_query("SELECT sum(pay_amount) AS `count_amount` FROM `mjournal_book` 
	 WHERE added_on between '$todate' and '$fromdate'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_amount'];
     }
     return $temp_arr;  
     } 
	 
	// Display Daily expenses Journal account wise
	 public function getMdailyExpAccwise($todate,$fromdate){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(pay_amount),jacc_id FROM mjournal_book WHERE added_on between '$todate' and '$fromdate'
	 group by jacc_id") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }  

	#####################################################################################################
	#
	#										Add New Assets
	#
	#####################################################################################################
	
	/**
	*	Add a new Assets records in assets table.
	*
	*	@param
	*			
	*			$assets_type			   	Assets identity code
	*			$assets_name				Assets Account Name
	*			$balance			     	Balance
	*			$added_by			   	    Added Date			
	*
	*	@return int
	*/
	function addMAssets($assets_type,$assets_name,$balance,$added_by)
	
	{
		$assets_type			  	   	=	mysql_real_escape_string(trim($assets_type));
		$assets_name			  	   	=	mysql_real_escape_string(trim($assets_name));
		$balance			   			=	mysql_real_escape_string(trim($balance));
		$added_by			       		=	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO massets
						(assets_type,assets_name,balance,added_by, added_on)
						VALUES
						('$assets_type','$assets_name','$balance','$added_by',now())
							
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the Journal Account id
		$assets_id	= mysql_insert_id();
		
		//return primary key
		return $assets_id;

	}//eof
	
	
	
	//Update Assets Account table
	function UpdateMAssets($assets_id, $assets_type,$assets_name,$balance,$modified_by)
	{
		$assets_type			  	   	=	mysql_real_escape_string(trim($assets_type));
		$assets_name			  	   	=	mysql_real_escape_string(trim($assets_name));
		$balance			   			=	mysql_real_escape_string(trim($balance));
		$modified_by			       	=	mysql_real_escape_string(trim($modified_by));

		//update Journal Account
		$edit  = "UPDATE massets
				SET
				assets_type		 	= '$assets_type',
				assets_name		 	= '$assets_name',
				balance		 		= '$balance',
				modified_by			= '$modified_by',
				modified_on			= now()
				WHERE
				assets_id 			= '$assets_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										Display Assets Account data
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Assets Account based upon the primary key
	*
	*	@param
	*			$assets_id		Assets Account id
	*
	*	@return array				
	*/
	function showMAssetsAcc($assets_id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM massets
				   WHERE assets_id	= '$assets_id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->assets_id,			//0
					$result->assets_type,		//1
					$result->assets_name,		//2
					$result->balance,			//3
					$result->added_by,			//4
					$result->added_on,			//5
					$result->modified_by,		//6
					$result->modified_on		//7
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Display Assets Account records from assets table.
	*
	*	@param
	*			
	*/
	public function getMAllAssetsAcc(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM massets order by assets_name ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }

	#####################################################################################################
	#
	#										Add New Assets History
	#
	#####################################################################################################
	
	/**
	*	Add a new Assets Hist records in assets_hist table.
	*
	*	@param
	*			
	*			$assets_id			   	    Assets identity No.
	*			$balance					Balance
	*			$purpose					Assets debit purpose
	*			$assets_source			    Assets Source
	*			$note						Notes
	*			$added_by			   	    Added Date			
	*
	*	@return int
	*/
	function addMAssetsHist($assets_id,$balance,$purpose,$assets_source,$note,$added_by,$added_on)
	
	{
		$assets_id			  	   	=	mysql_real_escape_string(trim($assets_id));
		$balance			  		=	mysql_real_escape_string(trim($balance));
		$purpose			   		=	mysql_real_escape_string(trim($purpose));
		$assets_source				=	mysql_real_escape_string(trim($assets_source));
		$note			   			=	mysql_real_escape_string(trim($note));
		$added_by			       	=	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO massets_hist
						(assets_id,balance,purpose,assets_source,note,added_by, added_on)
						VALUES
						('$assets_id','$balance','$purpose','$assets_source','$note','$added_by','$added_on')
							
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the Journal Book id
		$assets_hist_id		= mysql_insert_id();
		
		//return primary key
		return $assets_hist_id;

	}//eof
	
	 
	
	/**
	*	Display Assets hist records from assets_hist table.
	*
	*	@param
	*			
	*/
	public function getAllMAssetsHist(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM massets_hist order by assets_hist_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
}// eoc		