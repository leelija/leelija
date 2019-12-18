<?php 
/**
*	This class is going to work with all Sample associated with a Sample details. 
*
*	@author		Safikul Islam
*	@date		May 12, 2015
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/




class AlterParticular
{

	#####################################################################################################
	#										Add Alter particular
	#										
	#
	#####################################################################################################
	
	
	//			Add Alter particular
	
	/**
	*	Dye rate.
	*
	*	@param
	*			
	*			$order_id			   		Order Id
	*			$design_no			   	    Design number
	*			$labour_id					labour_id
	*			$particular					particular
	*			$alter_cause			    Reason
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addAlterpart($pp_id,$order_id,$design_no,$labour_id,$particular,$quantity,$pay_per_piece,$total_pay,$labour,
	$alter_cause,$payment_status)
	{
		$pp_id				   =	mysql_real_escape_string(trim($pp_id));
		$order_id			   =	mysql_real_escape_string(trim($order_id));
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		$labour_id			   =	mysql_real_escape_string(trim($labour_id));
		$particular			   =	mysql_real_escape_string(trim($particular));
		$quantity			   =	mysql_real_escape_string(trim($quantity));
		$pay_per_piece		   =	mysql_real_escape_string(trim($pay_per_piece));
		$total_pay			   =	mysql_real_escape_string(trim($total_pay));
		$labour			  	   =	mysql_real_escape_string(trim($labour));
		$alter_cause		   =	mysql_real_escape_string(trim($alter_cause));
		$payment_status		   =	mysql_real_escape_string(trim($payment_status));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO alter_particular
						(pp_id,order_id,design_no,labour_id,particular,quantity,pay_per_piece,total_pay,labour,alter_cause,
						payment_status,added_on)
							
						VALUES
						('$pp_id','$order_id','$design_no','$labour_id','$particular','$quantity','$pay_per_piece','$total_pay'
						,'$labour','$alter_cause','$payment_status',now())
							
						";
					
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$alt_id	= mysql_insert_id();
		
		//return primary key
		return $alt_id;

	}//eof
	
	
	// update alter particular table
	function UpdatealterPerticular($alt_id ,$quantity)
	{
		$alt_id				 	=	mysql_real_escape_string(trim($alt_id));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
			$sql				= "UPDATE alter_particular SET
			quantity		 	=  '$quantity'
			WHERE
			    alt_id	 		=  '$alt_id'
				";
		//execute query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		//test if it is running well
		if($query)
		{
			$data	= 'SU';
		}
		else
		{
			$data	= 'ER'.mysql_error();
		}
		
		
		//return data
		return $data;	
	}
	
	// Alter payment update
	function updateAltPayStatus($labour_id)
	{
		$labour_id			   =	mysql_real_escape_string(trim($labour_id));
		//statement
		$sql	= "UPDATE alter_particular SET
				payment_status					=   'paid',
				modified_on						=   now()
				WHERE
			    labour_id			      			 =  '$labour_id' AND payment_status = 'unpaid'
				";
				
		//execute query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		//test if it is running well
		if($query)
		{
			$data	= 'SU';
		}
		else
		{
			$data	= 'ER'.mysql_error();
		}
		//return data
		return $data;
		
	}//eof
		
	#####################################################################################################
	#
	#										Delete Alter Particular
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete alter particular permanently
	*
	*	@param
	*			$alt_id			alter  id
	*
	*	@return null
	*/
	function delAltParticular($alt_id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM alter_particular WHERE alt_id ='$alt_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Alter particular details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Alter particular based upon the primary key
	*
	*	@param
	*			$alt_id		alter id
	*
	*	@return array				
	*/
	function showAlterParticular($alt_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM alter_particular
				   WHERE alt_id	= '$alt_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->alt_id,			//0
					$result->order_id,			//1
					$result->design_no,			//2
					$result->labour_id,			//3	
					$result->particular,		//4
					$result->alter_cause,		//5
					$result->added_on,			//6
					$result->quantity,			//7
					$result->pp_id,				//8
					$result->labour,			//9
					$result->pay_per_piece,		//10
					$result->total_pay,			//11
					$result->payment_status		//12
					);
		}
	
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the dyeing rate id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAltParticularId($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT alt_id FROM alter_particular";
		}
		else
		{
			//statement
			$select	= "SELECT alt_id FROM alter_particular
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['alt_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	public function showAltPartData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM alter_particular order by alt_id desc ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Display the Alter records particular work wise
	public function showAlterReceipt($lid){
    $temp_arr = array();
    $res = mysql_query("SELECT * FROM alter_particular where payment_status = 'unpaid' AND labour_id = '$lid'") or die(mysql_error());        
    $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	
}