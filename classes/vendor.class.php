<?php 
/**
*	This class is going to work with all vendor associated. 
*
*	@author		Safikul Islam
*	@date		oct 18, 2017
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/

class Vendor
{

	#####################################################################################################
	#
	#										Add Vendor Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Vendor Records in vendor table.
	*
	*	@param
	*			$vid					Vendor id
	*			$vendor_name			Vendor Name
	*			$vcompany				Vendor Company
	*			$vendor_address			Vendor Address
	*			$vendor_contact			Vendor Contact
	*			$vendor_gst				Vendor GST
	*			$vbalance				Vendor Balance
	*			
	*	@return int
	*/
	function addVendor($vendor_name,$ven_type,$vcompany, $vendor_address,$vendor_contact,$vendor_gst, $vbalance,$tds,$added_by)
	{
		$vendor_name			=   mysql_real_escape_string(trim($vendor_name));
		$ven_type				=   mysql_real_escape_string(trim($ven_type));
		$vcompany			   	=	mysql_real_escape_string(trim($vcompany));
		$vendor_address			=	mysql_real_escape_string(trim($vendor_address));
		$vendor_contact			=	mysql_real_escape_string(trim($vendor_contact));
		$vendor_gst				=	mysql_real_escape_string(trim($vendor_gst));
		$vbalance				=	mysql_real_escape_string(trim($vbalance));
		$tds					=	mysql_real_escape_string(trim($tds));
		$added_by		   		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in company account table
		$insert		=   "INSERT INTO vendor_dtls
						(vendor_name,ven_type,vcompany, vendor_address, vendor_contact,vendor_gst, vbalance,tds,added_by,added_on)
						VALUES
						('$vendor_name','$ven_type','$vcompany', '$vendor_address', '$vendor_contact','$vendor_gst', '$vbalance','$tds', 
						'$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$vid	= mysql_insert_id();
		
		//return primary key
		return $vid;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Vendor Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Vendor Records
	*	
	*	@param	
	*			$vid			Vendor unique identity
	*			
	*/
function updateVendor($vid,$vendor_name,$vcompany, $vendor_address,$vendor_contact,$vendor_gst, $vbalance,$tds,$modified_by)
	{
		$vendor_name			=   mysql_real_escape_string(trim($vendor_name));
		$vcompany			   	=	mysql_real_escape_string(trim($vcompany));
		$vendor_address			=	mysql_real_escape_string(trim($vendor_address));
		$vendor_contact			=	mysql_real_escape_string(trim($vendor_contact));
		$vendor_gst				=	mysql_real_escape_string(trim($vendor_gst));
		$vbalance				=	mysql_real_escape_string(trim($vbalance));
		$tds					=	mysql_real_escape_string(trim($tds));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE vendor_dtls 
					SET 
					vendor_name    			= '$vendor_name' ,
					vcompany    			= '$vcompany' ,	
					vendor_address    		= '$vendor_address' ,
					vendor_contact    		= '$vendor_contact' ,
					vendor_gst    			= '$vendor_gst',
					vbalance    			= '$vbalance' ,
					tds    					= '$tds' ,
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE vid				= '$vid'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Vendor Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Vendor Records permanently
	*
	*	@param
	*			$vid			Vendor id
	*
	*	@return null
	*/
	function delVendor($vid)
	{
		//delete from Employee
		$delete1 = "DELETE FROM vendor_dtls WHERE vid = '$vid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Vendor Records
	#
	#####################################################################################################
	
	/*
	*	This funcion will return all the Vendor Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllVendor($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT vid FROM vendor_dtls";
		}
		else
		{
			//statement
			$select	= "SELECT vid FROM vendor_dtls
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['vid'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Vendor based upon the primary key
	*
	*	@param
	*			$vid		Vendor id
	*
	*	@return array				
	*/
	function showVendor($vid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM vendor_dtls
				   WHERE vid	= '$vid'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->vid,					//0
					$result->vendor_name,			//1
					$result->vcompany,				//2
					$result->vendor_address,		//3
					$result->vendor_contact,		//4
					$result->vendor_gst,			//5
					$result->vbalance,				//6
					$result->added_by,				//7
					$result->added_on,				//8
					$result->modified_by,			//9
					$result->modified_on,			//10
					$result->tds					//11
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	// Display Vendor all data in a array
	 public function getVendorData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vendor_dtls order by vendor_name Asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	// Display Vendor all data in a array
	 public function getVendorBlncData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vendor_dtls order by vbalance DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	// Display Vendor all data in a array
	 public function getVendorBlncDtls($vid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vendor_dtls where vid ='$vid' AND payment_status = 'unpaid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	//Display vendor type wise
	public function getVenTypeWise($ven_type){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vendor_dtls where ven_type = '$ven_type' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	#####################################################################################################
	#
	#										Vendor Categories
	#
	#####################################################################################################
	/**
	*	Get the data associated with a Vendor cat based upon the primary key
	*
	*	@param
	*			$id		Vendor categories id
	*
	*	@return array				
	*/
	function showVendorType($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM vendor_cat
				   WHERE id	= '$id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,			//0
					$result->ven_type,		//1
					$result->added_by,		//2
					$result->added_on		//3
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	// Display Vendor Categories all data in a array
	 public function getVendorCatData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vendor_cat order by ven_type Asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	#####################################################################################################
	#
	#										Add Vendor Acc Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Vendor Acc Records in company table.
	*
	*	@param
	*			$id						Vendor Acc id
	*			$vid					Vendor Id
	*			$comp_acc				Company Acc
	*			$balance				Vendor Balance
	*	@return int
	*/
	function addVenAcc($vid,$comp_acc, $balance)
	{
		$vid					=   mysql_real_escape_string(trim($vid));
		$comp_acc			   	=	mysql_real_escape_string(trim($comp_acc));
		$balance				=	mysql_real_escape_string(trim($balance));
		//statement to insert in company account table
		$insert		=   "INSERT INTO vendor_acc_dtls
						(vid,comp_acc, balance)
						VALUES
						('$vid','$comp_acc', '$balance')
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
	#										Update Vendor Acc Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Vendor Records
	*	
	*	@param	
	*			$id			Vendor Acc unique identity
	*			
	*/
function UpdateVenAcc($id,$vid,$comp_acc, $balance)
	{
		$id				=   mysql_real_escape_string(trim($id));
		$vid			=	mysql_real_escape_string(trim($vid));
		$comp_acc		=	mysql_real_escape_string(trim($comp_acc));
		$balance		=	mysql_real_escape_string(trim($balance));
		//statement
		$sql	 = "UPDATE supplier_acc_dtls 
					SET 
					vid    				= '$vid' ,
					comp_acc    		= '$comp_acc' ,	
					balance    			= '$balance' 
					WHERE id			= '$id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	// Update Vendor acc Balance
	function UpdateVenAccBlnc($vid,$comp_acc, $balance)
	{
		$vid			=	mysql_real_escape_string(trim($vid));
		$comp_acc		=	mysql_real_escape_string(trim($comp_acc));
		$balance		=	mysql_real_escape_string(trim($balance));
		//statement
		$sql	 = "UPDATE vendor_acc_dtls 
					SET 	
					balance    			= '$balance' 
					WHERE vid			= '$vid' AND comp_acc = '$comp_acc'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	#####################################################################################################
	#
	#										Delete Vendor Acc Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Vendor Acc Records permanently
	*
	*	@param
	*			$id			Vendor Acc id
	*
	*	@return null
	*/
	function delVenAcc($id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM vendor_acc_dtls WHERE id = '$id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Vendor Acc Records
	#
	#####################################################################################################
	
	/**
	*	Get the data associated with a Vendor Acc Dtls based upon the primary key
	*
	*	@param
	*			$id		Vendor Acc id
	*
	*	@return array				
	*/
	function showVenAcc($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM vendor_acc_dtls
				   WHERE id	= '$id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,					//0
					$result->vid,					//1
					$result->comp_acc,				//2
					$result->balance				//3
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	//Supplier Acc dtls supplier and comp acc wise
	function showVenAccCompWise($vid,$comp_acc)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM vendor_acc_dtls
				   WHERE vid	= '$vid' AND comp_acc	= '$comp_acc'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,					//0
					$result->vid,					//1
					$result->comp_acc,				//2
					$result->balance				//3
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	// Display Vendor account Dtls all data in a array
	 public function getVenAccData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vendor_acc_dtls order by comp_acc Asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	#####################################################################################################
	#
	#										Add Vendor Bill entry Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Vendor Bill Entry Records in company table.
	*
	*	@param
	*			$vbe_id					Vendor bill entry id
	*			$vid					Vendor Id
	*			$bill_no				Vendor Bill no
	*			$balance				Vendor Billing balance
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
	function addVendorBillEnt($vid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,
	$tds_rate,$tds,$net_balance,$notes,$payment_status,$added_by)
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
		$tds_rate		=	mysql_real_escape_string(trim($tds_rate));
		$tds			=	mysql_real_escape_string(trim($tds));
		$net_balance	=	mysql_real_escape_string(trim($net_balance));
		$notes			=	mysql_real_escape_string(trim($notes));
		$payment_status	=	mysql_real_escape_string(trim($payment_status));
		$added_by		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in company account table
		$insert		=   "INSERT INTO vendor_bill_entry
						(vid,bill_no,billing_name, balance, sgst_rate,sgst, cgst_rate,cgst,igst_rate,igst,
						tds_rate,tds,net_balance,notes,payment_status,added_by,added_on)
						VALUES
						('$vid','$bill_no','$billing_name', '$balance', '$sgst_rate','$sgst', '$cgst_rate', '$cgst','$igst_rate',
						'$igst','$tds_rate','$tds','$net_balance','$notes','$payment_status','$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$vbe_id	= mysql_insert_id();
		
		//return primary key
		return $vbe_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Vendor Billing Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Vendor Billing Records
	*	
	*	@param	
	*			$vbe_id			Vendor Billing unique identity
	*			
	*/
function UpdateVendorBillEnt($vbe_id,$vid,$bill_no,$billing_name, $balance,$sgst_rate,$sgst, $cgst_rate,$cgst,$igst_rate,$igst,$net_balance,
	$notes,$modified_by)
	{
		$vbe_id			=   mysql_real_escape_string(trim($vbe_id));
		$vid			=   mysql_real_escape_string(trim($vid));
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
		$sql	 = "UPDATE vendor_bill_entry 
					SET 
					vid    					= '$vid' ,
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
					WHERE vbe_id				= '$vbe_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	function editVendBill($vbe_id,$payment_status,$modified_by)
	{
		$payment_status			=   mysql_real_escape_string(trim($payment_status));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE vendor_bill_entry 
					SET 
					payment_status    		= '$payment_status' ,
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE vbe_id			= '$vbe_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Vendor Billing Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Vendor Billing Records permanently
	*
	*	@param
	*			$vbe_id			Vendor Billing Id
	*
	*	@return null
	*/
	function delSupplierBill($vbe_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM vendor_bill_entry WHERE vbe_id = '$vbe_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Vendor Billing Records
	#
	#####################################################################################################
	
	/*
	*	This function will return all the Vendor Billing Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllVendorBillEnt($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT vbe_id FROM vendor_bill_entry";
		}
		else
		{
			//statement
			$select	= "SELECT vbe_id FROM vendor_bill_entry
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['vbe_id'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Vendor Billing based upon the primary key
	*
	*	@param
	*			$vbe_id		Vendor Bill Entry id
	*
	*	@return array				
	*/
	function showVendorBillEnt($vbe_id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM vendor_bill_entry
				   WHERE vbe_id	= '$vbe_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->vbe_id,		//0
					$result->vid,			//1
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
					$result->billing_name,	//16
					$result->tds_rate,		//17
					$result->tds			//18
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	// Display company account all data in a array
	 public function getVendorBillData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vendor_bill_entry order by added_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	 //Display Vendor bill date wise
	public function getVenBillDtls($vid,$todate, $fromdate){
     //echo $design_no;exit;
	 $temp_arr = array();
     $res = mysql_query("SELECT SUM(net_balance) FROM vendor_bill_entry where vid = '$vid' and added_on between '$todate' and '$fromdate'") or die(mysql_error());
	 //echo $res.mysql_error();exit;
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }  
	
	#####################################################################################################
	#
	#										Add Vendor Transaction Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Vendor Transaction Records in Vendor Transaction table.
	*
	*	@param
	*			$stran_id				Vendor Transaction id
	*			$sid					Vendor Id
	*			$payment_type			Vendor Payment type
	*			$cheque_no				Vendor Cheque no
	*			$cheque_issue_from		Issue bank 
	*			$balance				Vendor Payment Balance
	*			$vtran_notes			Vendor Transaction
	*			
	*	@return int
	*/
	function addVendorTran($vid,$payment_type, $cheque_no,$cheque_issue_from,$balance, $vtran_notes,$added_by)
	{
		$vid					=   mysql_real_escape_string(trim($vid));
		$payment_type			=	mysql_real_escape_string(trim($payment_type));
		$cheque_no				=	mysql_real_escape_string(trim($cheque_no));
		$cheque_issue_from		=	mysql_real_escape_string(trim($cheque_issue_from));
		$balance				=	mysql_real_escape_string(trim($balance));
		$vtran_notes			=	mysql_real_escape_string(trim($vtran_notes));
		$added_by		   		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in Supplier Transaction table
		$insert		=   "INSERT INTO vendor_transaction
						(vid,payment_type, cheque_no, cheque_issue_from,balance, vtran_notes,added_by,added_on)
						VALUES
						('$vid','$payment_type', '$cheque_no', '$cheque_issue_from','$balance', '$vtran_notes', 
						'$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$vtran_id	= mysql_insert_id();
		
		//return primary key
		return $vtran_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Vendor Transaction Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Vendor Records
	*	
	*	@param	
	*			$vtran_id			Vendor Transaction unique identity
	*			
	*/
function updateVendorTran($vtran_id,$vid,$payment_type, $cheque_no,$cheque_issue_from,$balance, $vtran_notes,$modified_by)
	{
		$vid					=   mysql_real_escape_string(trim($vid));
		$payment_type			=	mysql_real_escape_string(trim($payment_type));
		$cheque_no				=	mysql_real_escape_string(trim($cheque_no));
		$cheque_issue_from		=	mysql_real_escape_string(trim($cheque_issue_from));
		$balance				=	mysql_real_escape_string(trim($balance));
		$vtran_notes			=	mysql_real_escape_string(trim($vtran_notes));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE vendor_transaction 
					SET 
					vid    					= '$vid' ,
					payment_type    		= '$payment_type' ,	
					cheque_no    			= '$cheque_no' ,
					cheque_issue_from    	= '$cheque_issue_from' ,
					balance    				= '$balance',
					vtran_notes    			= '$vtran_notes' ,
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE vtran_id			= '$vtran_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	
	#####################################################################################################
	#
	#										Delete Vendor Transaction Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Vendor Records permanently
	*
	*	@param
	*			$vtran_id			Vendor Transaction id
	*
	*	@return null
	*/
	function delVendorTran($vtran_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM vendor_transaction WHERE vtran_id = '$vtran_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Vendor Transaction Records
	#
	#####################################################################################################
	
	/*
	*	This funcion will return all the Vendor Transaction Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllVendorTran($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT vtran_id FROM vendor_transaction";
		}
		else
		{
			//statement
			$select	= "SELECT vtran_id FROM vendor_transaction
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['vtran_id'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Vendor Transaction based upon the primary key
	*
	*	@param
	*			$vtran_id		Vendor Transaction id
	*
	*	@return array				
	*/
	function showVendorTran($vtran_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM vendor_transaction
				   WHERE vtran_id	= '$vtran_id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->vtran_id,				//0
					$result->vid,					//1
					$result->payment_type,			//2
					$result->cheque_no,				//3
					$result->cheque_issue_from,		//4
					$result->balance,				//5
					$result->vtran_notes,			//6
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
	 public function getVendorTranData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vendor_transaction order by added_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	#####################################################################################################
	#
	#									Vendor	Payment Advice
	#
	#####################################################################################################
	
	/**
	*	Add a new Payment Advice Records in Payment Advice table.
	*
	*	@param
	*			$id						Payment advice id
	*			$vid					Vendor Id
	*			$pamount				Payment Amount
	*			$payment_by				Payment By
	*	@return int
	*/
	function addVenPayAdvice($vid,$pamount, $payment_by)
	{
		$vid					=   mysql_real_escape_string(trim($vid));
		$pamount			   	=	mysql_real_escape_string(trim($pamount));
		$payment_by				=	mysql_real_escape_string(trim($payment_by));
		//statement to insert in company account table
		$insert		=   "INSERT INTO vpayment_advice
						(vid,pamount, payment_by)
						VALUES
						('$vid','$pamount', '$payment_by')
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		//return primary key
		return $id;
	}//eof
	
	//Display Vendor Payment advice
	function showVenPAdvice($id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM vpayment_advice
				   WHERE id	= '$id' ";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,					//0
					$result->vid,					//1
					$result->pamount,				//2
					$result->payment_by	,			//3
					$result->payment_on				//4
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	// Display Vendor Payment Advice all data in a array
	 public function getVenPAdviceData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vpayment_advice order by payment_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	 #####################################################################################################
	#
	#									Vendor	Payment Advice Details
	#
	#####################################################################################################
	
	/**
	*	Add a new Payment Advice Records in Payment Advice Details table.
	*
	*	@param
	*			$id						Payment advice id
	*			$vpd_id					Vendor Payment advice Id
	*			$vbe_id					Vendor Bill entry Id
	*			$pamount				Payment Amount
	*	@return int
	*/
	function addVenPayAdviceDtls($vpd_id,$vbe_id, $pamount)
	{
		$vpd_id					=   mysql_real_escape_string(trim($vpd_id));
		$vbe_id			   		=	mysql_real_escape_string(trim($vbe_id));
		$pamount				=	mysql_real_escape_string(trim($pamount));
		//statement to insert in company account table
		$insert		=   "INSERT INTO vpay_advice_dtls
						(vpd_id,vbe_id, pamount)
						VALUES
						('$vpd_id','$vbe_id', '$pamount')
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		//return primary key
		return $id;
	}//eof
	
	//Display Vendor Payment advice Details
	function showVenPAdviceDtls($id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM vpay_advice_dtls
				   WHERE id	= '$id' ";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,					//0
					$result->vpd_id,				//1
					$result->vbe_id,				//2
					$result->pamount				//3
					);
		}
		//return the data
		return $data;
	}//eof
	
	// Display Vendor Payment Advice all data in a array
	 public function getVenPAdviceDtlData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM vpay_advice_dtls") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
}//eoc	 