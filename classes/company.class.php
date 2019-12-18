<?php 
/**
*	This class is going to work with all company associated. 
*
*	@author		Safikul Islam
*	@date		oct 16, 2017
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/

class Company
{

	#####################################################################################################
	#
	#										Add Company Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Company Account Records in company table.
	*
	*	@param
	*			$comp_id				Company id
	*			$account_name			Company Account Name
	*			$bank					Bank name
	*			$bank_address			Bank Address
	*			$balance				Bank Balance
	*			$in_sgst				SGST In
	*			$in_cgst				CGST In
	*			$out_sgst				SGST Out
	*			$out_cgst     		    CGSt Out
	*		
	*			
	*
	*	@return int
	*/
	function addCompDtls($company_name,$cphone,$cemail, $comp_address,$gstin_no,$pan_no,$balance,$in_sgst, $in_cgst,$in_igst, $out_sgst, $out_cgst,$out_igst,$added_by)
	{
		$company_name			=   mysql_real_escape_string(trim($company_name));
		$cphone			   		=	mysql_real_escape_string(trim($cphone));
		$cemail			   		=	mysql_real_escape_string(trim($cemail));
		$comp_address		  	=	mysql_real_escape_string(trim($comp_address));
		$gstin_no		  		=	mysql_real_escape_string(trim($gstin_no));
		$pan_no		  			=	mysql_real_escape_string(trim($pan_no));
		$balance		  		=	mysql_real_escape_string(trim($balance));
		$in_sgst			 	=	mysql_real_escape_string(trim($in_sgst));
		$in_cgst				=	mysql_real_escape_string(trim($in_cgst));
		$in_igst				=	mysql_real_escape_string(trim($in_igst));
		$out_sgst		     	=	mysql_real_escape_string(trim($out_sgst));
		$out_cgst		   		=	mysql_real_escape_string(trim($out_cgst));
		$out_igst		   		=	mysql_real_escape_string(trim($out_igst));
		$added_by		   		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in company dtls table
		$insert		=   "INSERT INTO company_dtls
						(company_name,cphone,cemail, comp_address,gstin_no,pan_no, balance,in_sgst, in_cgst,in_igst, out_sgst,out_cgst,out_igst,added_by,added_on)
						VALUES
						('$company_name','$cphone','$cemail', '$comp_address','$gstin_no','$pan_no', '$balance','$in_sgst', '$in_cgst','$in_igst','$out_sgst', 
							'$out_cgst','$out_igst','$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$comp_id	= mysql_insert_id();
		
		//return primary key
		return $comp_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update company Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Company Records
	*	
	*	@param	
	*			$comp_id			Company unique identity
	*			
	*/
	function updateCompDtls($comp_id,$company_name,$cphone,$cemail, $comp_address,$balance,$in_sgst, $in_cgst,$in_igst, $out_sgst, 
	$out_cgst,$out_igst,$modified_by)
	{
		$company_name			=   mysql_real_escape_string(trim($company_name));
		$cphone			   		=	mysql_real_escape_string(trim($cphone));
		$cemail			   		=	mysql_real_escape_string(trim($cemail));
		$comp_address		  	=	mysql_real_escape_string(trim($comp_address));
		$balance		  		=	mysql_real_escape_string(trim($balance));
		$in_sgst			 	=	mysql_real_escape_string(trim($in_sgst));
		$in_cgst				=	mysql_real_escape_string(trim($in_cgst));
		$in_igst				=	mysql_real_escape_string(trim($in_igst));
		$out_sgst		     	=	mysql_real_escape_string(trim($out_sgst));
		$out_cgst		   		=	mysql_real_escape_string(trim($out_cgst));
		$out_igst		   		=	mysql_real_escape_string(trim($out_igst));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE company_dtls 
					SET 
					company_name    	= '$company_name' ,
					cphone    			= '$cphone' ,
					cemail    			= '$cemail' ,
					comp_address    	= '$comp_address' ,
					balance    			= '$balance' ,
					in_sgst    			= '$in_sgst',
					in_cgst    			= '$in_cgst' ,
					in_igst    			= '$in_igst' ,
					out_sgst    		= '$out_sgst' ,	
					out_cgst    		= '$out_cgst' ,
					out_igst    		= '$out_igst' ,
					modified_by    		= '$modified_by' ,
					modified_on    		= now()
					WHERE comp_id		= '$comp_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Company Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Company Records permanently
	*
	*	@param
	*			$comp_id			Company id
	*
	*	@return null
	*/
	function delCompDtls($comp_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM company_dtls WHERE comp_id = '$comp_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Company Records
	#
	#####################################################################################################
	
	
	/**
	*	Get the data associated with a Company  based upon the primary key
	*
	*	@param
	*			$comp_id		Company id
	*
	*	@return array				
	*/
	function showCompDtls($comp_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM company_dtls
				   WHERE comp_id	= '$comp_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->comp_id,			//0
					$result->company_name,		//1
					$result->cphone,			//2
					$result->comp_address,		//3
					$result->balance,			//4
					$result->in_sgst,			//5
					$result->in_cgst,			//6
					$result->in_igst,			//7
					$result->out_sgst,			//8
					$result->out_cgst,			//9
					$result->out_igst,			//10
					$result->added_by,			//11
					$result->added_on,			//12
					$result->modified_by,		//13
					$result->modified_on,		//14
					$result->gstin_no,			//15
					$result->pan_no,			//16
					$result->cemail				//17
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	// Display company details all data in a array
	 public function getCompDtlsData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM company_dtls order by company_name Asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	#####################################################################################################
	#
	#										Add Company Account Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Company Account Records in company table.
	*
	*	@param
	*			$ca_id					Company account id
	*			$account_name			Company Account Name
	*			$bank					Bank name
	*			$bank_address			Bank Address
	*			$balance				Bank Balance
	*			$in_sgst				SGST In
	*			$in_cgst				CGST In
	*			$out_sgst				SGST Out
	*			$out_cgst     		    CGSt Out
	*		
	*			
	*
	*	@return int
	*/
	function addCompAcc($account_name,$bank, $bank_address,$gstin_no,$pan_no,$balance,$in_sgst, $in_cgst,$in_igst, $out_sgst, $out_cgst,$out_igst,$added_by)
	{
		$account_name			= mysql_real_escape_string(trim($account_name));
		$bank			   		=	mysql_real_escape_string(trim($bank));
		$bank_address		  	=	mysql_real_escape_string(trim($bank_address));
		$gstin_no		  		=	mysql_real_escape_string(trim($gstin_no));
		$pan_no		  			=	mysql_real_escape_string(trim($pan_no));
		$balance		  		=	mysql_real_escape_string(trim($balance));
		$in_sgst			 	=	mysql_real_escape_string(trim($in_sgst));
		$in_cgst				=	mysql_real_escape_string(trim($in_cgst));
		$in_igst				=	mysql_real_escape_string(trim($in_igst));
		$out_sgst		     	=	mysql_real_escape_string(trim($out_sgst));
		$out_cgst		   		=	mysql_real_escape_string(trim($out_cgst));
		$out_igst		   		=	mysql_real_escape_string(trim($out_igst));
		$added_by		   		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in company account table
		$insert		=   "INSERT INTO company_account
						(account_name,bank, bank_address,gstin_no,pan_no, balance,in_sgst, in_cgst,in_igst, out_sgst,out_cgst,out_igst,added_by,added_on)
						VALUES
						('$account_name','$bank', '$bank_address','$gstin_no','$pan_no', '$balance','$in_sgst', '$in_cgst','$in_igst','$out_sgst', 
							'$out_cgst','$out_igst','$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$emp_id	= mysql_insert_id();
		
		//return primary key
		return $emp_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update company account Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Company account Records
	*	
	*	@param	
	*			$ca_id			Company Account unique identity
	*			
	*/
	function updateCompAcc($ca_id,$account_name,$bank, $bank_address,$balance,$in_sgst, $in_cgst,$in_igst, $out_sgst, 
	$out_cgst,$out_igst,$modified_by)
	{
		$account_name			=   mysql_real_escape_string(trim($account_name));
		$bank			   		=	mysql_real_escape_string(trim($bank));
		$bank_address		  	=	mysql_real_escape_string(trim($bank_address));
		$balance		  		=	mysql_real_escape_string(trim($balance));
		$in_sgst			 	=	mysql_real_escape_string(trim($in_sgst));
		$in_cgst				=	mysql_real_escape_string(trim($in_cgst));
		$in_igst				=	mysql_real_escape_string(trim($in_igst));
		$out_sgst		     	=	mysql_real_escape_string(trim($out_sgst));
		$out_cgst		   		=	mysql_real_escape_string(trim($out_cgst));
		$out_igst		   		=	mysql_real_escape_string(trim($out_igst));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE company_account 
					SET 
					account_name    	= '$account_name' ,
					bank    			= '$bank' ,	
					bank_address    	= '$bank_address' ,
					balance    			= '$balance' ,
					in_sgst    			= '$in_sgst',
					in_cgst    			= '$in_cgst' ,
					in_igst    			= '$in_igst' ,
					out_sgst    		= '$out_sgst' ,	
					out_cgst    		= '$out_cgst' ,
					out_igst    		= '$out_igst' ,
					modified_by    		= '$modified_by' ,
					modified_on    		= now()
					WHERE ca_id			= '$ca_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Company Account Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Company Account Records permanently
	*
	*	@param
	*			$ca_id			Company Account id
	*
	*	@return null
	*/
	function delCompAcc($ca_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM company_account WHERE ca_id = '$ca_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Company Account Records
	#
	#####################################################################################################
	
	/*
	*	This funcion will return all the Company Account Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllCompAcc($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT ca_id FROM company_account";
		}
		else
		{
			//statement
			$select	= "SELECT ca_id FROM company_account
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['ca_id'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Company Account based upon the primary key
	*
	*	@param
	*			$ca_id		Company Account id
	*
	*	@return array				
	*/
	function showCompAcc($ca_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM company_account
				   WHERE ca_id	= '$ca_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->ca_id,				//0
					$result->account_name,		//1
					$result->bank,				//2
					$result->bank_address,		//3
					$result->balance,			//4
					$result->in_sgst,			//5
					$result->in_cgst,			//6
					$result->in_igst,			//7
					$result->out_sgst,			//8
					$result->out_cgst,			//9
					$result->out_igst,			//10
					$result->added_by,			//11
					$result->added_on,			//12
					$result->modified_by,		//13
					$result->modified_on,		//14
					$result->gstin_no,			//15
					$result->pan_no				//16
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	// Display company account all data in a array
	 public function getCompAccData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM company_account order by account_name Asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	#####################################################################################################
	#
	#										Add Company Transaction Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Company Transaction Records in Company Transaction table.
	*
	*	@param
	*			$ctran_id				Company Transaction id
	*			$tran_type				Transaction Type
	*			$payment_type			Company Payment type
	*			$cheque_no				Company Cheque no
	*			$account_id				Account id
	*			$balance				Company Payment Balance
	*			$notes					Company Transaction
	*			
	*	@return int
	*/
	function addCompTran($tran_type,$payment_type, $cheque_no,$account_id,$source_or_purpose,$balance,$cr_dr,$account_balance, $notes,$added_by)
	{
		$tran_type				=   mysql_real_escape_string(trim($tran_type));
		$payment_type			=	mysql_real_escape_string(trim($payment_type));
		$cheque_no				=	mysql_real_escape_string(trim($cheque_no));
		$account_id				=	mysql_real_escape_string(trim($account_id));
		$source_or_purpose		=	mysql_real_escape_string(trim($source_or_purpose));
		$balance				=	mysql_real_escape_string(trim($balance));
		$cr_dr					=	mysql_real_escape_string(trim($cr_dr));
		$account_balance		=	mysql_real_escape_string(trim($account_balance));
		$notes					=	mysql_real_escape_string(trim($notes));
		$added_by		   		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in Supplier Transaction table
		$insert		=   "INSERT INTO comp_transaction
						(tran_type,payment_type, cheque_no, account_id,source_or_purpose,balance,cr_dr,account_balance, notes,added_by,added_on)
						VALUES
						('$tran_type','$payment_type', '$cheque_no', '$account_id','$source_or_purpose','$balance','$cr_dr', 
						'$account_balance','$notes', '$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$ctran_id	= mysql_insert_id();
		
		//return primary key
		return $ctran_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Company Transaction Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Company Records
	*	
	*	@param	
	*			$ctran_id			Company Transaction unique identity
	*			
	*/
function updateCompTran($ctran_id,$tran_type,$payment_type, $cheque_no,$account_id,$source_or_purpose,$balance,$cr_dr,$account_balance, $notes,$modified_by)
	{
		$tran_type				=   mysql_real_escape_string(trim($tran_type));
		$payment_type			=	mysql_real_escape_string(trim($payment_type));
		$cheque_no				=	mysql_real_escape_string(trim($cheque_no));
		$account_id				=	mysql_real_escape_string(trim($account_id));
		$source_or_purpose		=	mysql_real_escape_string(trim($source_or_purpose));
		$balance				=	mysql_real_escape_string(trim($balance));
		$cr_dr					=	mysql_real_escape_string(trim($cr_dr));
		$account_balance		=	mysql_real_escape_string(trim($account_balance));
		$vtran_notes			=	mysql_real_escape_string(trim($vtran_notes));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE vendor_transaction 
					SET 
					tran_type    			= '$tran_type' ,
					payment_type    		= '$payment_type' ,	
					cheque_no    			= '$cheque_no' ,
					account_id    			= '$account_id' ,
					source_or_purpose    	= '$source_or_purpose' ,
					balance    				= '$balance',
					cr_dr    				= '$cr_dr',
					account_balance    		= '$account_balance' ,
					notes    				= '$notes' ,
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE ctran_id			= '$ctran_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete Company Transaction Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Company Records permanently
	*
	*	@param
	*			$ctran_id			Company Transaction id
	*
	*	@return null
	*/
	function delCompTran($ctran_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM vendor_transaction WHERE ctran_id = '$ctran_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Company Transaction Records
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
	function getAllCompTran($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT ctran_id FROM comp_transaction";
		}
		else
		{
			//statement
			$select	= "SELECT ctran_id FROM comp_transaction
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['ctran_id'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Company Transaction based upon the primary key
	*
	*	@param
	*			$ctran_id		Vendor Transaction id
	*
	*	@return array				
	*/
	function showCompTran($ctran_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM comp_transaction
				   WHERE ctran_id	= '$ctran_id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->ctran_id,				//0
					$result->tran_type,				//1
					$result->payment_type,			//2
					$result->cheque_no,				//3
					$result->account_id,			//4
					$result->balance,				//5
					$result->notes,					//6
					$result->added_by,				//7
					$result->added_on,				//8
					$result->modified_by,			//9
					$result->modified_on,			//10
					$result->source_or_purpose,		//11
					$result->cr_dr,					//12
					$result->account_balance		//13
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	// Display company Transaction all data in a array
	 public function getCompTranData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM comp_transaction order by added_on Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	 
}//eoc	 