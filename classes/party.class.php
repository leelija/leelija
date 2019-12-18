<?php 
/**
*	This class is going to work with all party associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		July 13, 2015
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/

class Party 
{

	#####################################################################################################
	#
	#										Add Party
	#
	#####################################################################################################
	
	/**
	*	Add a new party in party table.
	*
	*	@param
	*			$party_id			    party identification number	
	*			$party_name				Party name
	*			$party_address			Party Address
	*			$party_city				Party City
	*			$party_phone			    Party phone number
	*			$brokar				    Brokar
	*			$reta_hol			    
	*			
	*	@return int
	*/
	function addParty($party_name,$party_address, $party_city, $party_phone,$party_email, $brokar, $reta_hol,$added_by)
	
	{
		//$orders_id			   	=	mysql_real_escape_string(trim($orders_id));
		$party_name			   		= mysql_real_escape_string(trim($party_name));
		$party_address			   	=	mysql_real_escape_string(trim($party_address));
		$party_city		  			=	mysql_real_escape_string(trim($party_city));
		$party_phone			 	=	mysql_real_escape_string(trim($party_phone));
		$party_email			 	=	mysql_real_escape_string(trim($party_email));
		$brokar			   			=	mysql_real_escape_string(trim($brokar));
		$reta_hol		     		=	mysql_real_escape_string(trim($reta_hol));
		$added_by		     		=	mysql_real_escape_string(trim($added_by));
		//satement to insert in party table
		$insert		=   "INSERT INTO party
						(party_name,party_address, party_city, party_phone,party_email, brokar, reta_hol,added_on,added_by)
							
						VALUES
						('$party_name','$party_address', '$party_city', '$party_phone','$party_email', '$brokar',
						'$reta_hol', now(),'$added_by')
							
						";
					
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$party_id	= mysql_insert_id();
		
		//return primary key
		return $orders_id;

	}//eof
		
	
	/*
	*	This funcion will return all the party id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllParty($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT party_id FROM party";
		}
		else
		{
			//statement
			$select	= "SELECT party_id FROM party
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['party_id'];
		}
		//return the data
		return $data;
		
	}//eof
	
	#####################################################################################################
	#
	#										Edit party
	#
	#####################################################################################################
	
	/**
	*	This function edit orders
	*
	*	@param
	*			$orders_id			    orders_id	
	*			$design_no				Design no of  products
	*			$party_name			    Party name
	*			$brokar					Brokar
	*			$retahol				Reta Hol
	*			$form				    Order Address
	*			$quantity			    Number of products
	*			$colour     		    Orders products colour
	*			$remark					Remark
	*			$order_date				order date
	*			$target_date		    Target Date
	*		
	*			
	*	@return null
	*/
	function editParty($party_id,$party_name, $company,$party_address, $party_phone, $gst_no, $payment_due, $modified_by)
	{
		$party_id			   	= mysql_real_escape_string(trim($party_id));
		$party_name			   	= mysql_real_escape_string(trim($party_name));
		$company			   	= mysql_real_escape_string(trim($company));
		$party_address			= mysql_real_escape_string(trim($party_address));
		$party_phone		  	= mysql_real_escape_string(trim($party_phone));
		$gst_no			 		= mysql_real_escape_string(trim($gst_no));
		$payment_due			= mysql_real_escape_string(trim($payment_due));
		$modified_by		    = mysql_real_escape_string(trim($modified_by));
		
		//update product description
		$edit  = "UPDATE party
				SET
				party_name		 	= '$party_name',
				company		 		= '$company',
				party_address		= '$party_address',
				party_phone			= '$party_phone',
				gst_no 				= '$gst_no',
				payment_due			= '$payment_due',
				modified_on			= now(),
				modified_by			= '$modified_by'
				WHERE
				party_id 			= '$party_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	
	/**
	*	update party payment amount in party table.
	*
	*	@param
	*			$party_id			Id of the party
	*			$payment_due		Payment due from party
	*			$payment_complete	Payment complete from party
	*
	*	@return int
	*/
	function updatePartyPayment($party_id,$payment_due,$payment_complete)
	{	
		$party_id			   	=	mysql_real_escape_string(trim($party_id));
		$payment_due			=	mysql_real_escape_string(trim($payment_due));
		$payment_complete		=	mysql_real_escape_string(trim($payment_complete));
		//update product description
		$edit  = "UPDATE party
				SET
				payment_due				= '$payment_due',
				payment_complete		= '$payment_complete'
				WHERE
				party_id 				= '$party_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	
	
	
	
	
	#####################################################################################################
	#
	#										Delete ORDERS
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a party permanently
	*
	*	@param
	*			$pid			party_id
	*
	*	@return null
	*/
	function delParty($pid)
	{
		
		//delete from party
		$delete1 = "DELETE FROM party WHERE party_id='$pid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
		

	
	/**
	*	Get the data associated with a party based upon the primary key
	*
	*	@param
	*			$pid		party id
	*
	*	@return array				
	*/
	function showParty($pid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM party
				   WHERE party_id	= '$pid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->party_id,					//0
					$result->party_name,				//1
					$result->party_address,				//2
					$result->party_city,				//3
					$result->party_phone,				//4
					$result->brokar,					//5
					$result->reta_hol,					//6
					$result->added_on,					//7
					$result->added_by,					//8
					$result->modified_on,				//9
					$result->modified_by,				//10
					$result->party_email,				//11
					$result->payment_due,				//12
					$result->payment_complete,			//13
					$result->company,					//14
					$result->gst_no						//15
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	 public function partyDetails($pid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM party where party_id='$pid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	public function partyDtl(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM party order by party_id ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	//display party details balance desc wise
	public function partyBalanceDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM party order by payment_due DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	#####################################################################################################
	#
	#										Add Customer Bill entry Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Customer Bill Entry Records in company table.
	*
	*	@param
	*			$cbe_id					Customer bill entry id
	*			$pid					customer Id
	*			$bill_no				Customer Bill no
	*			$balance				Customer Billing balance
	*			$sgst_rate				State GST rate
	*			$sgst					Total State GST
	*			$cgst_rate				Central GST Rate
	*			$cgst					Total Central GST
	*			$igst_rate				Integrated GST Rate 
	*			$igst					Total Integrated GST
	*			$net_balance			Total Billing Balance
	*			$notes					Customer Notes
	*			
	*	@return int
	*/
	function addCustBillEnt($pid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,$net_balance,
	$notes,$added_by)
	{
		$pid			=   mysql_real_escape_string(trim($pid));
		$bill_no		=	mysql_real_escape_string(trim($bill_no));
		$billing_name	=	mysql_real_escape_string(trim($billing_name));
		$balance		=	mysql_real_escape_string(trim($balance));
		$sgst_rate		=	mysql_real_escape_string(trim($sgst_rate));
		$sgst			=	mysql_real_escape_string(trim($sgst));
		$cgst_rate		=	mysql_real_escape_string(trim($cgst_rate));
		$cgst			=	mysql_real_escape_string(trim($cgst));
		$igst_rate		=	mysql_real_escape_string(trim($igst_rate));
		$igst			=	mysql_real_escape_string(trim($igst));
		$net_balance	=	mysql_real_escape_string(trim($net_balance));
		$notes			=	mysql_real_escape_string(trim($notes));
		$added_by		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in company account table
		$insert		=   "INSERT INTO customer_bill_entry
						(pid,bill_no,billing_name, balance, sgst_rate,sgst, cgst_rate,cgst,igst_rate,igst,net_balance,notes,added_by,added_on)
						VALUES
						('$pid','$bill_no','$billing_name', '$balance', '$sgst_rate','$sgst', '$cgst_rate', '$cgst','$igst_rate',
						'$igst','$net_balance','$notes','$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$cbe_id	= mysql_insert_id();
		
		//return primary key
		return $cbe_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Customer Billing Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Customer Billing Records
	*	
	*	@param	
	*			$cbe_id			Customer Billing unique identity
	*			
	*/
function UpdateCustBillEnt($cbe_id,$pid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,$net_balance,
	$notes,$modified_by)
	{
		$cbe_id			=   mysql_real_escape_string(trim($cbe_id));
		$pid			=   mysql_real_escape_string(trim($pid));
		$bill_no		=	mysql_real_escape_string(trim($bill_no));
		$billing_name	=	mysql_real_escape_string(trim($billing_name));
		$balance		=	mysql_real_escape_string(trim($balance));
		$sgst_rate		=	mysql_real_escape_string(trim($sgst_rate));
		$sgst			=	mysql_real_escape_string(trim($sgst));
		$cgst_rate		=	mysql_real_escape_string(trim($cgst_rate));
		$cgst			=	mysql_real_escape_string(trim($cgst));
		$igst_rate		=	mysql_real_escape_string(trim($igst_rate));
		$igst			=	mysql_real_escape_string(trim($igst));
		$net_balance	=	mysql_real_escape_string(trim($net_balance));
		$notes			=	mysql_real_escape_string(trim($notes));
		$modified_by	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE customer_bill_entry 
					SET 
					pid    					= '$pid' ,
					bill_no    				= '$bill_no' ,	
					billing_name    		= '$billing_name' ,
					balance    				= '$balance' ,
					sgst_rate    			= '$sgst_rate' ,
					sgst    				= '$sgst',
					cgst_rate    			= '$cgst_rate' ,
					cgst    				= '$cgst' ,
					igst_rate    			= '$igst_rate' ,	
					igst    				= '$igst' ,
					net_balance    			= '$net_balance' ,
					notes    				= '$notes',
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE cbe_id				= '$cbe_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Customer Billing Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Customer Billing Records permanently
	*
	*	@param
	*			$cbe_id			Customer Billing Id
	*
	*	@return null
	*/
	function delCustomerBill($cbe_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM customer_bill_entry WHERE cbe_id = '$cbe_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Customer Billing Records
	#
	#####################################################################################################
	
	/*
	*	This function will return all the Customer Billing Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllCustomerBillEnt($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT cbe_id FROM customer_bill_entry";
		}
		else
		{
			//statement
			$select	= "SELECT cbe_id FROM customer_bill_entry
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['cbe_id'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Customer Billing based upon the primary key
	*
	*	@param
	*			$cbe_id		Customer Bill Entry id
	*
	*	@return array				
	*/
	function showCustomerBillEnt($cbe_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM customer_bill_entry
				   WHERE cbe_id	= '$cbe_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->cbe_id,		//0
					$result->pid,			//1
					$result->bill_no,		//2
					$result->balance,		//3
					$result->sgst_rate,		//4
					$result->sgst,			//5
					$result->cgst_rate,		//6
					$result->cgst,			//7
					$result->igst_rate,		//8
					$result->igst,			//9
					$result->net_balance,	//10
					$result->notes,			//11
					$result->added_by,		//12
					$result->added_on,		//13
					$result->modified_by,	//14
					$result->modified_on,	//15
					$result->billing_name	//16
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	// Display customer bill all data in a array
	 public function getCustomerBillData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM customer_bill_entry order by added_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	#####################################################################################################
	#
	#										Add Party Transaction Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Party Transaction Records in Party Transaction table.
	*
	*	@param
	*			$stran_id				Party Transaction id
	*			$sid					Party Id
	*			$payment_type			Party Payment type
	*			$cheque_no				Party Cheque no
	*			$cheque_issue_from		Issue bank 
	*			$balance				Party Payment Balance
	*			$stran_notes			Party Transaction
	*			
	*	@return int
	*/
	function addPartyTran($pid,$payment_type, $cheque_no,$cheque_issue_from,$balance, $stran_notes,$added_by)
	{
		$pid					=   mysql_real_escape_string(trim($pid));
		$payment_type			=	mysql_real_escape_string(trim($payment_type));
		$cheque_no				=	mysql_real_escape_string(trim($cheque_no));
		$cheque_issue_from		=	mysql_real_escape_string(trim($cheque_issue_from));
		$balance				=	mysql_real_escape_string(trim($balance));
		$stran_notes			=	mysql_real_escape_string(trim($stran_notes));
		$added_by		   		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in Party Transaction table
		$insert		=   "INSERT INTO party_transaction
						(pid,payment_type, cheque_no, cheque_issue_from,balance, stran_notes,added_by,added_on)
						VALUES
						('$pid','$payment_type', '$cheque_no', '$cheque_issue_from','$balance', '$stran_notes', 
						'$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$ptran_id	= mysql_insert_id();
		
		//return primary key
		return $ptran_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Party Transaction Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Party Records
	*	
	*	@param	
	*			$ptran_id			Party Transaction unique identity
	*			
	*/
function updateSupplierTran($ptran_id,$pid,$payment_type, $cheque_no,$cheque_issue_from,$balance, $stran_notes,$modified_by)
	{
		$pid					=   mysql_real_escape_string(trim($pid));
		$payment_type			=	mysql_real_escape_string(trim($payment_type));
		$cheque_no				=	mysql_real_escape_string(trim($cheque_no));
		$cheque_issue_from		=	mysql_real_escape_string(trim($cheque_issue_from));
		$balance				=	mysql_real_escape_string(trim($balance));
		$stran_notes			=	mysql_real_escape_string(trim($stran_notes));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE party_transaction 
					SET 
					pid    					= '$pid' ,
					payment_type    		= '$payment_type' ,	
					cheque_no    			= '$cheque_no' ,
					cheque_issue_from    	= '$cheque_issue_from' ,
					balance    				= '$balance',
					stran_notes    			= '$stran_notes' ,
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE ptran_id			= '$ptran_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Party Transaction Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Party Records permanently
	*
	*	@param
	*			$ptran_id			Party Transaction id
	*
	*	@return null
	*/
	function delPartyTran($stran_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM party_transaction WHERE ptran_id = '$ptran_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Party Transaction Records
	#
	#####################################################################################################
	
	/*
	*	This funcion will return all the Party Transaction Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPartyTran($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT ptran_id FROM party_transaction";
		}
		else
		{
			//statement
			$select	= "SELECT ptran_id FROM party_transaction
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['ptran_id'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Supplier Transaction based upon the primary key
	*
	*	@param
	*			$stran_id		Supplier Transaction id
	*
	*	@return array				
	*/
	function showPartyTran($ptran_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM party_transaction
				   WHERE ptran_id	= '$ptran_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->ptran_id,				//0
					$result->pid,					//1
					$result->payment_type,			//2
					$result->cheque_no,				//3
					$result->cheque_issue_from,		//4
					$result->balance,				//5
					$result->stran_notes,			//6
					$result->added_by,				//7
					$result->added_on,				//8
					$result->modified_by,			//9
					$result->modified_on			//10
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	// Display Party Transaction all data in a array
	 public function getCustTranData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM party_transaction order by added_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	

/*####################################################################################################################*/
	
	/*                           party details  search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search Rozelle orders keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getPartyKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT party_id FROM party ";
		}
		else
		{
			$sql = "SELECT party_id
					FROM   party
					WHERE (party_id LIKE '%$keyword%' OR
						   party_name LIKE '%$keyword%' OR
						   party_address LIKE '%$keyword%' OR
						   party_city LIKE '%$keyword%' OR
						   party_phone LIKE '%$keyword%' OR
						   brokar LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' OR
						    reta_hol LIKE '%$keyword%' 
							
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->party_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof

	
	 #####################################################################################################
	#
	#										Add Sales prm Bill Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new PRM Bill Records in company table.
	*
	*	@param
	*			$id						Sales prm bill id
	*			$pid					customer Id
	*			$bill_no				Customer Bill no
	*			$balance				Customer Billing balance
	*			$sgst_rate				State GST rate
	*			$sgst					Total State GST
	*			$cgst_rate				Central GST Rate
	*			$cgst					Total Central GST
	*			$igst_rate				Integrated GST Rate 
	*			$igst					Total Integrated GST
	*			$net_balance			Total Billing Balance
	*			$notes					Customer Notes
	*			
	*	@return int
	*/
	function addSalesPrmBill($pid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,$net_balance,
	$notes,$added_by)
	{
		$pid			=   mysql_real_escape_string(trim($pid));
		$bill_no		=	mysql_real_escape_string(trim($bill_no));
		$billing_name	=	mysql_real_escape_string(trim($billing_name));
		$balance		=	mysql_real_escape_string(trim($balance));
		$sgst_rate		=	mysql_real_escape_string(trim($sgst_rate));
		$sgst			=	mysql_real_escape_string(trim($sgst));
		$cgst_rate		=	mysql_real_escape_string(trim($cgst_rate));
		$cgst			=	mysql_real_escape_string(trim($cgst));
		$igst_rate		=	mysql_real_escape_string(trim($igst_rate));
		$igst			=	mysql_real_escape_string(trim($igst));
		$net_balance	=	mysql_real_escape_string(trim($net_balance));
		$notes			=	mysql_real_escape_string(trim($notes));
		$added_by		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in prm bill table
		$insert		=   "INSERT INTO sales_prm
						(pid,bill_no,billing_name, balance, sgst_rate,sgst, cgst_rate,cgst,igst_rate,igst,net_balance,notes,added_by,added_on)
						VALUES
						('$pid','$bill_no','$billing_name', '$balance', '$sgst_rate','$sgst', '$cgst_rate', '$cgst','$igst_rate',
						'$igst','$net_balance','$notes','$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		
		//return primary key
		return $id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Sales prm Billing Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit prm Billing Records
	*	
	*	@param	
	*			$id			Sales prm Billing unique identity
	*			
	*/
function UpdateSalesPrmBill($id,$pid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,$net_balance,
	$notes,$modified_by)
	{
		$id				=   mysql_real_escape_string(trim($id));
		$pid			=   mysql_real_escape_string(trim($pid));
		$bill_no		=	mysql_real_escape_string(trim($bill_no));
		$billing_name	=	mysql_real_escape_string(trim($billing_name));
		$balance		=	mysql_real_escape_string(trim($balance));
		$sgst_rate		=	mysql_real_escape_string(trim($sgst_rate));
		$sgst			=	mysql_real_escape_string(trim($sgst));
		$cgst_rate		=	mysql_real_escape_string(trim($cgst_rate));
		$cgst			=	mysql_real_escape_string(trim($cgst));
		$igst_rate		=	mysql_real_escape_string(trim($igst_rate));
		$igst			=	mysql_real_escape_string(trim($igst));
		$net_balance	=	mysql_real_escape_string(trim($net_balance));
		$notes			=	mysql_real_escape_string(trim($notes));
		$modified_by	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE sales_prm 
					SET 
					pid    					= '$pid' ,
					bill_no    				= '$bill_no' ,	
					billing_name    		= '$billing_name' ,
					balance    				= '$balance' ,
					sgst_rate    			= '$sgst_rate' ,
					sgst    				= '$sgst',
					cgst_rate    			= '$cgst_rate' ,
					cgst    				= '$cgst' ,
					igst_rate    			= '$igst_rate' ,	
					igst    				= '$igst' ,
					net_balance    			= '$net_balance' ,
					notes    				= '$notes',
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE id				= '$id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Sales prm Billing Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a prm Billing Records permanently
	*
	*	@param
	*			$id			prm Billing Id
	*
	*	@return null
	*/
	function delSalesPrmBill($id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM sales_prm WHERE id = '$id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Prm Billing Records
	#
	#####################################################################################################
	
	/*
	*	This function will return all the Prm Billing Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllSalesPrmBill($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT id FROM sales_prm";
		}
		else
		{
			//statement
			$select	= "SELECT id FROM sales_prm
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['id'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Customer Billing based upon the primary key
	*
	*	@param
	*			$cbe_id		Customer Bill Entry id
	*
	*	@return array				
	*/
	function showSalesPrmBill($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sales_prm
				   WHERE id	= '$id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,		//0
					$result->pid,			//1
					$result->bill_no,		//2
					$result->balance,		//3
					$result->sgst_rate,		//4
					$result->sgst,			//5
					$result->cgst_rate,		//6
					$result->cgst,			//7
					$result->igst_rate,		//8
					$result->igst,			//9
					$result->net_balance,	//10
					$result->notes,			//11
					$result->added_by,		//12
					$result->added_on,		//13
					$result->modified_by,	//14
					$result->modified_on,	//15
					$result->billing_name	//16
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	// Display customer bill all data in a array
	 public function getSalesPrmBillData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sales_prm order by added_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
}//eoc	 