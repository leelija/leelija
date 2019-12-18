<?php 
/**
*	This class is going to work with all Supplier associated. 
*
*	@author		Safikul Islam
*	@date		oct 16, 2017
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/

class Supplier
{

	#####################################################################################################
	#
	#										Add Supplier Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Supplier Records in company table.
	*
	*	@param
	*			$sid					Supplier id
	*			$supplier_name			Supplier Name
	*			$scompany				Supplier Company
	*			$supplier_address		Supplier Address
	*			$supplier_contact		Supplier Contact
	*			$supplier_gst			Supplier GST
	*			$sbalance				Supplier Balance
	*			
	*	@return int
	*/
	function addSupplier($supplier_name,$scompany, $supplier_address,$supplier_contact,$supplier_gst, $sbalance,$added_by)
	{
		$supplier_name			=   mysql_real_escape_string(trim($supplier_name));
		$scompany			   	=	mysql_real_escape_string(trim($scompany));
		$supplier_address		=	mysql_real_escape_string(trim($supplier_address));
		$supplier_contact		=	mysql_real_escape_string(trim($supplier_contact));
		$supplier_gst			=	mysql_real_escape_string(trim($supplier_gst));
		$sbalance				=	mysql_real_escape_string(trim($sbalance));
		$added_by		   		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in company account table
		$insert		=   "INSERT INTO supplier_dtls
						(supplier_name,scompany, supplier_address, supplier_contact,supplier_gst, sbalance,added_by,added_on)
						VALUES
						('$supplier_name','$scompany', '$supplier_address', '$supplier_contact','$supplier_gst', '$sbalance', 
						'$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sid	= mysql_insert_id();
		
		//return primary key
		return $sid;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Supplier Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Supplier Records
	*	
	*	@param	
	*			$sid			Supplier unique identity
	*			
	*/
function UpdateSupplier($sid,$supplier_name,$scompany, $supplier_address,$supplier_contact,$supplier_gst, $sbalance,$modified_by)
	{
		$supplier_name			=   mysql_real_escape_string(trim($supplier_name));
		$scompany			   	=	mysql_real_escape_string(trim($scompany));
		$supplier_address		=	mysql_real_escape_string(trim($supplier_address));
		$supplier_contact		=	mysql_real_escape_string(trim($supplier_contact));
		$supplier_gst			=	mysql_real_escape_string(trim($supplier_gst));
		$sbalance				=	mysql_real_escape_string(trim($sbalance));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE supplier_dtls 
					SET 
					supplier_name    		= '$supplier_name' ,
					scompany    			= '$scompany' ,	
					supplier_address    	= '$supplier_address' ,
					supplier_contact    	= '$supplier_contact' ,
					supplier_gst    		= '$supplier_gst',
					sbalance    			= '$sbalance' ,
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE sid				= '$sid'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Supplier Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Supplier Records permanently
	*
	*	@param
	*			$sid			Supplier id
	*
	*	@return null
	*/
	function delSupplier($sid)
	{
		//delete from Employee
		$delete1 = "DELETE FROM supplier_dtls WHERE sid = '$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Supplier Records
	#
	#####################################################################################################
	
	/*
	*	This funcion will return all the Supplier Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllSupplier($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT sid FROM supplier_dtls";
		}
		else
		{
			//statement
			$select	= "SELECT sid FROM supplier_dtls
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['sid'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Supplier based upon the primary key
	*
	*	@param
	*			$sid		Supplier id
	*
	*	@return array				
	*/
	function showSupplier($sid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM supplier_dtls
				   WHERE sid	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->sid,					//0
					$result->supplier_name,			//1
					$result->scompany,				//2
					$result->supplier_address,		//3
					$result->supplier_contact,		//4
					$result->supplier_gst,			//5
					$result->sbalance,				//6
					$result->added_by,				//7
					$result->added_on,				//8
					$result->modified_by,			//9
					$result->modified_on			//10
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	// Display company account all data in a array
	 public function getSupplierData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM supplier_dtls order by supplier_name Asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	// Display company account all data in a array
	 public function getSupplierBlncData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM supplier_dtls order by sbalance DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	
	#####################################################################################################
	#
	#										Add Supplier Acc Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Supplier Acc Records in company table.
	*
	*	@param
	*			$id						Supplier Acc id
	*			$sid					Supplier Id
	*			$comp_acc				Company Acc
	*			$balance				Supplier Balance
	*	@return int
	*/
	function addSupplierAcc($sid,$comp_acc, $balance)
	{
		$sid					=   mysql_real_escape_string(trim($sid));
		$comp_acc			   	=	mysql_real_escape_string(trim($comp_acc));
		$balance				=	mysql_real_escape_string(trim($balance));
		//statement to insert in company account table
		$insert		=   "INSERT INTO supplier_acc_dtls
						(sid,comp_acc, balance)
						VALUES
						('$sid','$comp_acc', '$balance')
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
	#										Update Supplier Acc Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Supplier Records
	*	
	*	@param	
	*			$id			Supplier Acc unique identity
	*			
	*/
function UpdateSuppAcc($id,$sid,$comp_acc, $balance)
	{
		$id			=   mysql_real_escape_string(trim($id));
		$sid			   	=	mysql_real_escape_string(trim($sid));
		$comp_acc		=	mysql_real_escape_string(trim($comp_acc));
		$balance		=	mysql_real_escape_string(trim($balance));
		//statement
		$sql	 = "UPDATE supplier_acc_dtls 
					SET 
					sid    				= '$sid' ,
					comp_acc    		= '$comp_acc' ,	
					balance    			= '$balance' 
					WHERE id			= '$id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	// Update Supplier acc Balance
	function UpdateSuppAccBlnc($sid,$comp_acc, $balance)
	{
		$sid			=	mysql_real_escape_string(trim($sid));
		$comp_acc		=	mysql_real_escape_string(trim($comp_acc));
		$balance		=	mysql_real_escape_string(trim($balance));
		//statement
		$sql	 = "UPDATE supplier_acc_dtls 
					SET 	
					balance    			= '$balance' 
					WHERE sid			= '$sid' AND comp_acc = '$comp_acc'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	#####################################################################################################
	#
	#										Delete Supplier Acc Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Supplier Acc Records permanently
	*
	*	@param
	*			$id			Supplier Acc id
	*
	*	@return null
	*/
	function delSuppAcc($id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM supplier_acc_dtls WHERE id = '$id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Supplier Acc Records
	#
	#####################################################################################################
	
	/**
	*	Get the data associated with a Supplier Acc Dtls based upon the primary key
	*
	*	@param
	*			$id		Supplier Acc id
	*
	*	@return array				
	*/
	function showSuppAcc($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM supplier_acc_dtls
				   WHERE id	= '$id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,					//0
					$result->sid,					//1
					$result->comp_acc,				//2
					$result->balance				//3
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	//Supplier Acc dtls supplier and comp acc wise
	function showSuppAccCompWise($sid,$comp_acc)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM supplier_acc_dtls
				   WHERE sid	= '$sid' AND comp_acc	= '$comp_acc'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,					//0
					$result->sid,					//1
					$result->comp_acc,				//2
					$result->balance				//3
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	// Display company account Dtls all data in a array
	 public function getSuppAccData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM supplier_acc_dtls order by comp_acc Asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	#####################################################################################################
	#
	#										Add Supplier Bill entry Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Supplier Supplier Bill Entry Records in company table.
	*
	*	@param
	*			$sbe_id					Supplier bill entry id
	*			$sid					Supplier Id
	*			$bill_no				Supplier Bill no
	*			$balance				Supplier Billing balance
	*			$sgst_rate				State GST rate
	*			$sgst					Total State GST
	*			$cgst_rate				Central GST Rate
	*			$cgst					Total Central GST
	*			$igst_rate				Integrated GST Rate 
	*			$igst					Total Integrated GST
	*			$net_balance			Total Billing Balance
	*			$notes					Supplier Notes
	*			
	*	@return int
	*/
	function addSuppBillEnt($sid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,$net_balance,
	$notes,$added_by)
	{
		$sid			=   mysql_real_escape_string(trim($sid));
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
		$insert		=   "INSERT INTO supplier_bill_entry
						(sid,bill_no,billing_name, balance, sgst_rate,sgst, cgst_rate,cgst,igst_rate,igst,net_balance,notes,added_by,added_on)
						VALUES
						('$sid','$bill_no','$billing_name', '$balance', '$sgst_rate','$sgst', '$cgst_rate', '$cgst','$igst_rate',
						'$igst','$net_balance','$notes','$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sbe_id	= mysql_insert_id();
		
		//return primary key
		return $sbe_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Supplier Billing Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Supplier Billing Records
	*	
	*	@param	
	*			$sbe_id			Supplier Billing unique identity
	*			
	*/
function UpdateSuppBillEnt($sbe_id,$sid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,$net_balance,
	$notes,$modified_by)
	{
		$sbe_id			=   mysql_real_escape_string(trim($sbe_id));
		$sid			=   mysql_real_escape_string(trim($sid));
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
		$sql	 = "UPDATE supplier_bill_entry 
					SET 
					sid    					= '$sid' ,
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
					WHERE sbe_id				= '$sbe_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Supplier Billing Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Supplier Billing Records permanently
	*
	*	@param
	*			$sbe_id			Supplier Billing Id
	*
	*	@return null
	*/
	function delSupplierBill($sbe_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM supplier_bill_entry WHERE sbe_id = '$sbe_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Supplier Billing Records
	#
	#####################################################################################################
	
	/*
	*	This function will return all the Supplier Billing Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllSupplierBillEnt($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT sbe_id FROM supplier_bill_entry";
		}
		else
		{
			//statement
			$select	= "SELECT sbe_id FROM supplier_bill_entry
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['sbe_id'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Supplier Billing based upon the primary key
	*
	*	@param
	*			$sbe_id		Supplier Bill Entry id
	*
	*	@return array				
	*/
	function showSupplierBillEnt($sbe_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM supplier_bill_entry
				   WHERE sbe_id	= '$sbe_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->sbe_id,		//0
					$result->sid,			//1
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
					$result->payment_by,	//14
					$result->payment_on,	//15
					$result->billing_name	//16
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	// Display company account all data in a array
	 public function getSupplierBillData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM supplier_bill_entry order by added_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	//Display Purchase bill date wise
		
	public function getPurchBillDtls($todate, $fromdate){
     //echo $design_no;exit;
	 $temp_arr = array();
     $res = mysql_query("SELECT SUM(net_balance) FROM supplier_bill_entry where added_on between '$todate' and '$fromdate'") or die(mysql_error());
	 //echo $res.mysql_error();exit;
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }  
	 
	function editSuppBill($sbe_id,$payment_status,$payment_by)
	{
		$payment_status			=   mysql_real_escape_string(trim($payment_status));
		$payment_by		   		=	mysql_real_escape_string(trim($payment_by));
		//statement
		$sql	 = "UPDATE supplier_bill_entry 
					SET 
					payment_status    		= '$payment_status' ,
					payment_by    			= '$payment_by' ,
					payment_on    			= now()
					WHERE sbe_id			= '$sbe_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof 
	
	#####################################################################################################
	#
	#										Add Supplier Transaction Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Supplier Transaction Records in Supplier Transaction table.
	*
	*	@param
	*			$stran_id				Supplier Transaction id
	*			$sid					Supplier Id
	*			$payment_type			Supplier Payment type
	*			$cheque_no				Supplier Cheque no
	*			$cheque_issue_from		Issue bank 
	*			$balance				Supplier Payment Balance
	*			$stran_notes			Supplier Transaction
	*			
	*	@return int
	*/
	function addSupplierTran($sid,$payment_type, $cheque_no,$cheque_issue_from,$balance, $stran_notes,$added_by)
	{
		$sid					=   mysql_real_escape_string(trim($sid));
		$payment_type			=	mysql_real_escape_string(trim($payment_type));
		$cheque_no				=	mysql_real_escape_string(trim($cheque_no));
		$cheque_issue_from		=	mysql_real_escape_string(trim($cheque_issue_from));
		$balance				=	mysql_real_escape_string(trim($balance));
		$stran_notes			=	mysql_real_escape_string(trim($stran_notes));
		$added_by		   		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in Supplier Transaction table
		$insert		=   "INSERT INTO supplier_transaction
						(sid,payment_type, cheque_no, cheque_issue_from,balance, stran_notes,added_by,added_on)
						VALUES
						('$sid','$payment_type', '$cheque_no', '$cheque_issue_from','$balance', '$stran_notes', 
						'$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$stran_id	= mysql_insert_id();
		
		//return primary key
		return $stran_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Supplier Transaction Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Supplier Records
	*	
	*	@param	
	*			$stran_id			Supplier Transaction unique identity
	*			
	*/
function updateSupplierTran($stran_id,$sid,$payment_type, $cheque_no,$cheque_issue_from,$balance, $stran_notes,$modified_by)
	{
		$sid					=   mysql_real_escape_string(trim($sid));
		$payment_type			=	mysql_real_escape_string(trim($payment_type));
		$cheque_no				=	mysql_real_escape_string(trim($cheque_no));
		$cheque_issue_from		=	mysql_real_escape_string(trim($cheque_issue_from));
		$balance				=	mysql_real_escape_string(trim($balance));
		$stran_notes			=	mysql_real_escape_string(trim($stran_notes));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE supplier_transaction 
					SET 
					sid    					= '$sid' ,
					payment_type    		= '$payment_type' ,	
					cheque_no    			= '$cheque_no' ,
					cheque_issue_from    	= '$cheque_issue_from' ,
					balance    				= '$balance',
					stran_notes    			= '$stran_notes' ,
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE stran_id			= '$stran_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Supplier Transaction Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Supplier Records permanently
	*
	*	@param
	*			$stran_id			Supplier Transaction id
	*
	*	@return null
	*/
	function delSupplierTran($stran_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM supplier_transaction WHERE stran_id = '$stran_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Supplier Transaction Records
	#
	#####################################################################################################
	
	/*
	*	This funcion will return all the Supplier Transaction Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllSupplierTran($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT stran_id FROM supplier_transaction";
		}
		else
		{
			//statement
			$select	= "SELECT stran_id FROM supplier_transaction
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['stran_id'];
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
	function showSupplierTran($stran_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM supplier_transaction
				   WHERE stran_id	= '$stran_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->stran_id,				//0
					$result->sid,					//1
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
	
	
	// Display company account all data in a array
	 public function getSupplierTranData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM supplier_transaction order by added_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	 #####################################################################################################
	#
	#										Add Purchase prm Bill Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new PRM Bill Records in company table.
	*
	*	@param
	*			$id						Purchase prm bill id
	*			$sid					Supplier Id
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
	function addPurchPrmBill($sid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,$net_balance,
	$notes,$added_by)
	{
		$sid			=   mysql_real_escape_string(trim($sid));
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
		$insert		=   "INSERT INTO purchase_prm
						(sid,bill_no,billing_name, balance, sgst_rate,sgst, cgst_rate,cgst,igst_rate,igst,net_balance,notes,added_by,added_on)
						VALUES
						('$sid','$bill_no','$billing_name', '$balance', '$sgst_rate','$sgst', '$cgst_rate', '$cgst','$igst_rate',
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
	#										Update Purchase prm Billing Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit prm Billing Records
	*	
	*	@param	
	*			$id		 Purchase prm Billing unique identity
	*			
	*/
function UpdatePurchPrmBill($id,$sid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,$net_balance,
	$notes,$modified_by)
	{
		$id				=   mysql_real_escape_string(trim($id));
		$sid			=   mysql_real_escape_string(trim($sid));
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
		$sql	 = "UPDATE purchase_prm 
					SET 
					sid    					= '$sid' ,
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
	#										Delete Purchase prm Billing Records
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
	function delPurchPrmBill($id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM purchase_prm WHERE id = '$id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Purchase Prm Billing Records
	#
	#####################################################################################################
	
	/*
	*	This function will return all the Purchase Prm Billing Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPurchPrmBill($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT id FROM purchase_prm";
		}
		else
		{
			//statement
			$select	= "SELECT id FROM purchase_prm
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
	*	Get the data associated with a Purchase prm Billing based upon the primary key
	*
	*	@param
	*			$id		Purchase Prm Bill Entry id
	*
	*	@return array				
	*/
	function showPurchPrmBill($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM purchase_prm
				   WHERE id	= '$id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,		//0
					$result->sid,			//1
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
	
	// Display Purchase prm bill all data in a array
	 public function getPurchPrmBillData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM purchase_prm order by added_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	
}//eoc	 