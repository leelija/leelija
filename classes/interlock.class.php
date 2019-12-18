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




class InterlockMst
{

	#####################################################################################################
	#										Add  to interlock_mst
	#										
	#
	#####################################################################################################
	
	
	//			Add interlock_mst value
	
	/**
	*	interlock_mst.
	*
	*	@param
	*			
	*			$interlock_id			   		Interlock Id
	*			$order_id			   		Order Id
	*			$design_no			   	    Design number
	*			$bill_no			   	    Bill number
	*			$labour_id					labour_id
	*			$inte_quantity			    number of Interlock quantity
	*			$rate						Interlock rate
	*			$total_cost			    	Total cost
	*		
	*	@return int
	*/
	function addInterlock($order_id,$design_no,$master_id,$labour_id,$interlock_rate_id,$inte_quantity,$rate,$total_cost,$payment_status)
	
	{
		$order_id			   =	mysql_real_escape_string(trim($order_id));
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		$master_id			   =	mysql_real_escape_string(trim($master_id));
		$labour_id			   =	mysql_real_escape_string(trim($labour_id));
		$interlock_rate_id	   =	mysql_real_escape_string(trim($interlock_rate_id));
		$inte_quantity		   =	mysql_real_escape_string(trim($inte_quantity));
		$rate		   		   =	mysql_real_escape_string(trim($rate));
		$total_cost			   =	mysql_real_escape_string(trim($total_cost));
		$payment_status		   =	mysql_real_escape_string(trim($payment_status));
		//satement to insert in stock table
		$insert		=   "INSERT INTO interlock_mst
						(order_id,design_no,master_id,labour_id,interlock_rate_id,inte_quantity,rate,total_cost,payment_status, added_on)
							
						VALUES
						('$order_id','$design_no','$master_id','$labour_id','$interlock_rate_id','$inte_quantity','$rate','$total_cost',
						'$payment_status',now())
							
						";
					
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$interlock_id	= mysql_insert_id();
		
		//return primary key
		return $interlock_id;

	}//eof
	
	
	// Interlock payment update
	function updateIntlockPayStatus($labour_id)
	{
		$labour_id			   =	mysql_real_escape_string(trim($labour_id));
		//statement
		$sql	= "UPDATE interlock_mst SET
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
	#										Delete Interlock
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete interlock_mst row value permanently
	*
	*	@param
	*			$interlock_id			Interlock  id
	*
	*	@return null
	*/
	function delInterlock($interlock_id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM interlock_mst WHERE interlock_id ='$interlock_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Interlock details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Interlock based upon the primary key
	*
	*	@param
	*			$interlock_id		Interlock id
	*
	*	@return array				
	*/
	function showInterlock($interlock_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM interlock_mst
				   WHERE interlock_id	= '$interlock_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->interlock_id,			//0
					$result->order_id,				//1
					$result->design_no,				//2
					$result->master_id,				//3
					$result->labour_id,				//4
					$result->interlock_rate_id,		//5
					$result->inte_quantity,			//6
					$result->rate,					//7
					$result->total_cost,			//8
					$result->added_by,				//9
					$result->added_on,				//10
					$result->modified_by,			//11
					$result->modified_on			//12
					);
		}
	
		//return the data
		return $data;
		
	}//eof
	
	public function getIntlockData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM interlock_mst order by interlock_id Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	public function getInterlock(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM interlock_mst order by type_of_interlock ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Display the Interlock records  
	public function showInterlockReceipt($lid){
    $temp_arr = array();
    $res = mysql_query("SELECT * FROM interlock_mst where payment_status = 'unpaid' AND labour_id = '$lid'") or die(mysql_error());        
    $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	/*
	*	This funcion will return all the Interlock id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllInterlockId($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT interlock_id FROM interlock_mst";
		}
		else
		{
			//statement
			$select	= "SELECT interlock_id FROM interlock_mst
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['interlock_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	
}