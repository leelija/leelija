<?php 
/**
*	This class is going to work with all Purchase associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		nov 11, 2016
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/

class Purchase
{

	#####################################################################################################
	#
	#										Add Purchase Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Purchase Records in hmdad_purchase_book table.
	*
	*	@param
	*			$purchase_id			Purchase Identification no.
	*			$slip_name				Slip Name
	*			$slip_no			    Slip Number
	*			$pcompany				Purchase Company
	*			$pcaddress				Purchase Company Address
	*			$mobile				    Mobile No
	*			$purchase_date			Purchase Date
	*			$bill_by     		    M/S
	*			$purchase_by			Purchase By
	*			$total_amount			Total Amount 
	*		
	*			
	*
	*	@return int
	*/
	function addPurchase($slip_name, $slip_no,$pcompany, $pcaddress, $mobile, $purchase_date, $bill_by,$purchase_by,$rphoto,
	$total_amount,$image,$image2,$remark, $added_by)
	
	{
		$slip_name	        	=	trim($slip_name);
		$slip_no			   	= mysql_real_escape_string(trim($slip_no));
		$pcompany			   	=	mysql_real_escape_string(trim($pcompany));
		$pcaddress		  		=	mysql_real_escape_string(trim($pcaddress));
		$mobile			 		=	mysql_real_escape_string(trim($mobile));
		$purchase_date			=	mysql_real_escape_string(trim($purchase_date));
		$bill_by		     	=	mysql_real_escape_string(trim($bill_by));
		$purchase_by		   	=	mysql_real_escape_string(trim($purchase_by));
		$rphoto		   			=	mysql_real_escape_string(trim($rphoto));
		$total_amount			=	mysql_real_escape_string(trim($total_amount));
		$image					=	mysql_real_escape_string(trim($image));
		$image2		   			=	mysql_real_escape_string(trim($image2));
		$remark					=	mysql_real_escape_string(trim($remark));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		//satement to insert in hmdad_purchase_book table
		$insert		=   "INSERT INTO hmdad_purchase_book
						(slip_name, slip_no, pcompany, pcaddress, mobile,purchase_date,bill_by,purchase_by,rphoto,total_amount,
						image,image2,remark,added_by,added_on)
							
						VALUES
						('$slip_name', '$slip_no', '$pcompany', '$pcaddress','$mobile', 
							'$purchase_date','$bill_by','$purchase_by','$rphoto','$total_amount','$image','$image2','$remark','$added_by', now())
							
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$purchase_id	= mysql_insert_id();
		
		//return primary key
		return $purchase_id;

	}//eof
		
	function addPurchaseDtls($purchase_id,$particular,$no_of_particular,$prate, $total_amount)
	{
		$purchase_id			   	=	mysql_real_escape_string(trim($purchase_id));
		$particular	        		=	trim($particular);
		$no_of_particular			=	mysql_real_escape_string(trim($no_of_particular));
		$prate			   			=	mysql_real_escape_string(trim($prate));
		$total_amount		     	=	mysql_real_escape_string(trim($total_amount));	
		//satement to insert in orders table
		$insert		=   "INSERT INTO hmdad_purchbook_dtls
						(purchase_id,particular,no_of_particular,prate,total_amount)
							
						VALUES
						('$purchase_id','$particular','$no_of_particular','$prate','$total_amount')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$purchbook_dtls_id	= mysql_insert_id();
		
		//return primary key
		return $purchbook_dtls_id;

	}//eof	
		
	
	
	#####################################################################################################
	#
	#										Edit Orders
	#
	#####################################################################################################
	
	
	/**
	*	This function edit orders
	*
	*	@param
	*			$purchase_id			    purchase_id	
	*			$design_no				Design no of  products
	*			$party_name			    Party name
	*			$brokar					Brokar
	*			$retahol				Reta Hol
	*			$form				    Order Address
	*			$purchase_date			    Number of products
	*			$bill_by     		    Orders products bill_by
	*			$purchase_by					purchase_by
	*			$total_amount				order date
	*			$target_date		    Target Date
	*		
	*			
	*	@return null
	*/
	function editPurchase($purchase_id,$design_no, $party_name, $form, $total_amount, $target_date)
	
	{
		$purchase_id			   =	mysql_real_escape_string(trim($purchase_id));
		$design_no	        =	trim($design_no);
		$party_name			   = mysql_real_escape_string(trim($party_name));
		$form			 =	mysql_real_escape_string(trim($form));
		$total_amount			=	mysql_real_escape_string(trim($total_amount));
		$target_date	=	mysql_real_escape_string(trim($target_date));

		//update product description
		$edit  = "UPDATE orders
				SET
				design_no		 		= '$design_no',
				party_name			= '$party_name',
				form			    = '$form',
				total_amount			= '$total_amount',
				target_date			= '$target_date'
				WHERE
				purchase_id 			= '$purchase_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	/*=======purchase_date field edit in table orders========*/
	function editprch($purchase_id,$purchase_date)
	
	{
		//echo $purchase_date;exit;	
		$purchase_id			   =	mysql_real_escape_string(trim($purchase_id));
		$purchase_date			   =	mysql_real_escape_string(trim($purchase_date));
		
		//update product description
		$edit  = "UPDATE orders
				SET
				purchase_date				= '$purchase_date'
				WHERE
				purchase_id 			= '$purchase_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	
	#####################################################################################################
	#
	#										Delete Purchase Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Purchase Records permanently
	*
	*	@param
	*			$pid			purchase id
	*
	*	@return null
	*/
	function delPurchase($oid)
	{
		//delete from Purchase
		$delete1 = "DELETE FROM hmdad_purchase_book WHERE purchase_id='$pid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
		

	/*
	*	This funcion will return all the Purchase Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPurchs($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT purchase_id FROM hmdad_purchase_book";
		}
		else
		{
			//statement
			$select	= "SELECT purchase_id FROM hmdad_purchase_book
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['purchase_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a purchase based upon the primary key
	*
	*	@param
	*			$pid		purchase id
	*
	*	@return array				
	*/
	function showPurchase($pid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM hmdad_purchase_book
				   WHERE purchase_id	= '$pid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->purchase_id,					//0
					$result->slip_name,							//1
					$result->slip_no,					//2
					$result->pcompany,						//3
					$result->pcaddress,				//4
					$result->mobile,					//5
					$result->purchase_date,		//6
					$result->bill_by,				//7
					$result->purchase_by,					//8
					$result->total_amount,						//9
					$result->image,						//10
					$result->remark,						//11
					$result->added_by,						//12
					$result->added_on,						//13
					$result->modified_by,						//14
					$result->modified_on,					//15
					$result->rphoto,						//16
					$result->image2					//17

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
/*Order Details*/
	function showPurchaseDtls($pid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM hmdad_purchbook_dtls
				   WHERE purchase_id	= '$pid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->purchase_id,			//0
					$result->particular,			//1
					$result->prate,					//2
					$result->total_amount,			//3
					$result->purchbook_dtls_id,		//4
					$result->no_of_particular		//5

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	 public function PurchaseDispl(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM hmdad_purchase_book order by added_on desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 public function PurchaseDtlsDispl($pid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM hmdad_purchbook_dtls where purchase_id ='$pid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
	
	
}	//eoc