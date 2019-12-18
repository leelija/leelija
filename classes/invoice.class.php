<?php 
/**
*	This class is going to work with all Labour associated with a labour details. 
*
*	@author		Safikul Islam
*	@date		Nov 30, 2017
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/


class Invoice
{	
	
	
	#####################################################################################################
	#
	#										Add Sales invoice
	#
	#####################################################################################################
	
	/**
	*	Add a new Sales invoice Records in invoice table.
	*
	*	@param
	*			$invoice_id				Customer bill entry id
	*			$party					customer Id
	*			$bill_no				Customer Bill no
	*			$balance				Invoice balance
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
	function addInvoice($party,$bill_no,$billing_name, $balance,$discount,$discount_amount,$sgst_rate,$sgst, 
	$cgst_rate,$cgst,$igst_rate,$igst,$tax_amount,$tax_desc,$net_balance,$notes,$billing_date,$added_by)
	{
		$party			=   mysql_real_escape_string(trim($party));
		$bill_no		=	mysql_real_escape_string(trim($bill_no));
		$billing_name	=	mysql_real_escape_string(trim($billing_name));
		$balance		=	mysql_real_escape_string(trim($balance));
		$discount		=	mysql_real_escape_string(trim($discount));
		$discount_amount=	mysql_real_escape_string(trim($discount_amount));
		$sgst_rate		=	mysql_real_escape_string(trim($sgst_rate));
		$sgst			=	mysql_real_escape_string(trim($sgst));
		$cgst_rate		=	mysql_real_escape_string(trim($cgst_rate));
		$cgst			=	mysql_real_escape_string(trim($cgst));
		$igst_rate		=	mysql_real_escape_string(trim($igst_rate));
		$igst			=	mysql_real_escape_string(trim($igst));
		$tax_amount		=	mysql_real_escape_string(trim($tax_amount));
		$tax_desc		=	mysql_real_escape_string(trim($tax_desc));
		$net_balance	=	mysql_real_escape_string(trim($net_balance));
		$notes			=	mysql_real_escape_string(trim($notes));
		$billing_date	=	mysql_real_escape_string(trim($billing_date));
		$added_by		=	mysql_real_escape_string(trim($added_by));
		//statement to insert in company account table
		$insert		=   "INSERT INTO invoice
						(party,bill_no,billing_name, balance,discount,discount_amount, sgst_rate,sgst, cgst_rate,cgst,
						igst_rate,igst,tax_amount,tax_desc,net_balance,notes,billing_date,added_by,added_on)
						VALUES
						('$party','$bill_no','$billing_name', '$balance','$discount','$discount_amount', '$sgst_rate','$sgst', '$cgst_rate', '$cgst','$igst_rate',
						'$igst','$tax_amount','$tax_desc','$net_balance','$notes','$billing_date','$added_by', now())
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$invoice_id	= mysql_insert_id();
		
		//return primary key
		return $invoice_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Update Sales Invoice Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Invoice Records
	*	
	*	@param	
	*			$invoice_id			Invoice unique identity
	*			
	*/
function UpdateInvoice($invoice_id,$party,$bill_no,$billing_name, $balance,$discount,$discount_amount,$sgst_rate,$sgst, 
	$cgst_rate,$cgst,$igst_rate,$igst,$tax_amount,$tax_desc,$net_balance,$notes,$billing_date,$modified_by)
	{
		$invoice_id		=   mysql_real_escape_string(trim($invoice_id));
		$party			=   mysql_real_escape_string(trim($party));
		$bill_no		=	mysql_real_escape_string(trim($bill_no));
		$billing_name	=	mysql_real_escape_string(trim($billing_name));
		$balance		=	mysql_real_escape_string(trim($balance));
		$discount		=	mysql_real_escape_string(trim($discount));
		$discount_amount=	mysql_real_escape_string(trim($discount_amount));
		$sgst_rate		=	mysql_real_escape_string(trim($sgst_rate));
		$sgst			=	mysql_real_escape_string(trim($sgst));
		$cgst_rate		=	mysql_real_escape_string(trim($cgst_rate));
		$cgst			=	mysql_real_escape_string(trim($cgst));
		$igst_rate		=	mysql_real_escape_string(trim($igst_rate));
		$igst			=	mysql_real_escape_string(trim($igst));
		$tax_amount		=	mysql_real_escape_string(trim($tax_amount));
		$tax_desc		=	mysql_real_escape_string(trim($tax_desc));
		$net_balance	=	mysql_real_escape_string(trim($net_balance));
		$notes			=	mysql_real_escape_string(trim($notes));
		$billing_date	=	mysql_real_escape_string(trim($billing_date));
		$modified_by	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE invoice 
					SET 
					party    				= '$party' ,
					bill_no    				= '$bill_no' ,	
					billing_name    		= '$billing_name' ,
					balance    				= '$balance' ,
					discount    			= '$discount' ,
					discount_amount    		= '$discount_amount',
					sgst_rate    			= '$sgst_rate' ,
					sgst    				= '$sgst',
					cgst_rate    			= '$cgst_rate' ,
					cgst    				= '$cgst' ,
					igst_rate    			= '$igst_rate' ,	
					igst    				= '$igst' ,
					tax_amount    			= '$tax_amount' ,
					tax_desc    			= '$tax_desc',
					net_balance    			= '$net_balance' ,
					notes    				= '$notes',
					billing_date    		= '$billing_date',
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE invoice_id				= '$invoice_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	/**
	*	Edit Invoice Records
	*	
	*	@param	
	*			$invoice_id			Invoice unique identity
	*			
	*/
function UpdateInvcCour($invoice_id,$no_of_parcels,$Carrier_id,$currier_charge,$modified_by)
	{
		$invoice_id				=   mysql_real_escape_string(trim($invoice_id));
		$no_of_parcels			=   mysql_real_escape_string(trim($no_of_parcels));
		$Carrier_id				=	mysql_real_escape_string(trim($Carrier_id));
		$currier_charge			=	mysql_real_escape_string(trim($currier_charge));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE invoice 
					SET 
					no_of_parcels    		= '$no_of_parcels' ,
					Carrier_id    			= '$Carrier_id' ,	
					currier_charge    		= '$currier_charge' ,
					modified_on    			= now()
					WHERE invoice_id		= '$invoice_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	/**
	*	Edit Invoice Records
	*	
	*	@param	
	*			$invoice_id			Invoice unique identity
	*			
	*/
function UpdateInvcStat($invoice_id,$status,$modified_by)
	{
		$invoice_id				=   mysql_real_escape_string(trim($invoice_id));
		$status					=   mysql_real_escape_string(trim($status));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE invoice 
					SET 
					status    				= '$status' ,
					modified_by    			= '$modified_by' ,	
					modified_on    			= now()
					WHERE invoice_id		= '$invoice_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	#####################################################################################################
	#
	#										Delete Invoice Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Invoice Records permanently
	*
	*	@param
	*			$invoice_id			Invoice Id
	*
	*	@return null
	*/
	function delInvoiceBill($invoice_id)
	{
		//delete from Employee
		$delete1 = "DELETE FROM invoice WHERE invoice_id = '$invoice_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Invoice Records
	#
	#####################################################################################################
	
	/*
	*	This function will return all the Invoice Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllInvoice($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT invoice_id FROM invoice";
		}
		else
		{
			//statement
			$select	= "SELECT invoice_id FROM invoice
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['invoice_id'];
		}
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Invoice based upon the primary key
	*
	*	@param
	*			$invoice_id		Customer Bill Entry id
	*
	*	@return array				
	*/
	function showInvoice($invoice_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM invoice
				   WHERE invoice_id	= '$invoice_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->invoice_id,	//0
					$result->party,			//1
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
					$result->discount,		//17
					$result->discount_amount,//18
					$result->tax_amount,	//19
					$result->tax_desc,		//20
					$result->billing_date,	//21
					$result->no_of_parcels,	//22
					$result->Carrier_id,	//23
					$result->currier_charge	//24
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	// Display Invoice all data in a array
	 public function getInvoiceData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM invoice order by invoice_id Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 // Display Max Invoice Id in a array
	 public function getMaxId(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM invoice order by invoice_id desc limit 1") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	//Display Invoice bill date wise
	public function getInvBillDtls($todate, $fromdate){
     //echo $design_no;exit;
	 $temp_arr = array();
     $res = mysql_query("SELECT SUM(net_balance) FROM invoice where added_on between '$todate' and '$fromdate'") or die(mysql_error());
	 //echo $res.mysql_error();exit;
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }   
	 
	#####################################################################################################
	#
	#										Add Sales invoice Details
	#
	#####################################################################################################
	 
	 
	/**
	*	Sales invoice details.
	*
	*	@param
	*			$invoice_id			   	Invoice Id
	*			$item					Item
	*			$quantity			    Quantity
	*			$rate					Rate
	*			$tamount				Total Amount
	*	@return int
	*/
	function addInvoiceDtls($invoice_id, $item, $quantity, $rate, $tamount)
	{
		$invoice_id			   	= mysql_real_escape_string(trim($invoice_id));
		$item		   			= mysql_real_escape_string(trim($item));
		$quantity				= mysql_real_escape_string(trim($quantity));
		$rate					= mysql_real_escape_string(trim($rate));
		$tamount		       	= mysql_real_escape_string(trim($tamount));

		//satement to insert in stock table
		$insert		=   "INSERT INTO invoice_details
						(invoice_id,item, quantity, rate, tamount, added_on)
						VALUES
						('$invoice_id','$item', '$quantity', '$rate', '$tamount',now())
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		
		//return primary key
		return $id;

	}//eof 
	 
	 
	// Display Invoice details all data in a array
	 public function getInvoiceDtlsData($invd){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM invoice_details where invoice_id ='$invd' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	 
}//eoc

?>	 