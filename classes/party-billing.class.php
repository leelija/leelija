<?php 
/**
*	This class is going to work with all orders associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Feb 10, 2015
*	@version	1.0
*	@copyright	MIS
*	@url		http://monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/




class PartyBilling 
{

	#####################################################################################################
	#
	#										Add Party Billing
	#
	#####################################################################################################
	
	/**
	*	Add a new party bill in party_billing table.
	*
	*	@param
	*			$porder_id			    Product Order Id	
	*			$prate					Product Rate
	*			$pquantity			    Product Order Quantity
	*			$netquantity			Net sale quantity
	*			$rquantity				Return quantity
	*			$tamount				Total Amount
	*			$pay_status			    Payment Status
	*			$colour     		    Orders products colour
	*			$remark					Remark
	*			$order_date				order date
	*			$target_date		    Target Date
	*		
	*			
	*
	*	@return int
	*/
	function addPartyBill($porder_id, $prate,$pquantity, $netquantity, $rquantity, $tamount, $pay_status,$added_by)
	
	{
		//$orders_id			=	mysql_real_escape_string(trim($orders_id));
		$porder_id			   	=   mysql_real_escape_string(trim($porder_id));
		$prate			   		=	mysql_real_escape_string(trim($prate));
		$pquantity		  		=	mysql_real_escape_string(trim($pquantity));
		$netquantity			=	mysql_real_escape_string(trim($netquantity));
		$rquantity			   	=	mysql_real_escape_string(trim($rquantity));
		$tamount		     	=	mysql_real_escape_string(trim($tamount));
		$pay_status		   		=	mysql_real_escape_string(trim($pay_status));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		//satement to insert in orders table
		$insert		=   "INSERT INTO party_billing
						(porder_id, prate, pquantity, netquantity, rquantity,tamount,pay_status,added_by,added_on)
							
						VALUES
						('$porder_id', '$prate', '$pquantity', '$netquantity','$rquantity', 
							'$tamount','$pay_status','$added_by',now())
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$pbill_id	= mysql_insert_id();
		
		//return primary key
		return $pbill_id;
	}//eof
	
	
	#####################################################################################################
	#
	#										Display Party Billing
	#
	#####################################################################################################
	
	public function showPartyBill($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM party_billing where porder_id = '$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }
	
	
	
}//eoc
?>	