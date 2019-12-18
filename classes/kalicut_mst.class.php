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




class KaliCutMst
{

	#####################################################################################################
	#										Add  to kalicut_mst
	#										
	#
	#####################################################################################################
	
	
	//			Add kalicut_mst value
	
	/**
	*	kalicut_mst.
	*
	*	@param
	*			
	*			$kali_id			   		Kali Id
	*			$order_id			   		Order Id
	*			$design_no			   	    Design number
	*			$bill_no			   	    Bill number
	*			$labour_id					labour_id
	*			$type_of_kali				kali type
	*			$kali_quantity			    number of kali quantity
	*			$rate						kali rate
	*			$total_cost			    	Total cost
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addKaliCutMst($order_id,$design_no,$master_id,$labour_id,$kali_name,$type_of_kali,$kali_quantity,$rate,$total_cost)
	
	{
		$order_id			   =	mysql_real_escape_string(trim($order_id));
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		$master_id			   =	mysql_real_escape_string(trim($master_id));
		$labour_id			   =	mysql_real_escape_string(trim($labour_id));
		$kali_name		   	   =	mysql_real_escape_string(trim($kali_name));
		$type_of_kali		   =	mysql_real_escape_string(trim($type_of_kali));
		$kali_quantity		   =	mysql_real_escape_string(trim($kali_quantity));
		$rate		   		   =	mysql_real_escape_string(trim($rate));
		$total_cost			   =	mysql_real_escape_string(trim($total_cost));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO kalicut_mst
						(order_id,design_no,master_id,labour_id,kali_name,type_of_kali,kali_quantity,rate,total_cost, added_on)
							
						VALUES
						('$order_id','$design_no','$master_id','$labour_id','$kali_name','$type_of_kali','$kali_quantity','$rate','$total_cost',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$kali_id	= mysql_insert_id();
		
		//return primary key
		return $kali_id;

	}//eof
	
	
	
		
	#####################################################################################################
	#
	#										Delete Alter Particular
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete kalicut_mst row value permanently
	*
	*	@param
	*			$kali_id			kali  id
	*
	*	@return null
	*/
	function delKalicutMst($kali_id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM kalicut_mst WHERE kali_id ='$kali_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Kalicut details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a kalicut based upon the primary key
	*
	*	@param
	*			$kali_id		kali id
	*
	*	@return array				
	*/
	function showKaliDtlMst($kali_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM kalicut_mst
				   WHERE kali_id	= '$kali_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->kali_id,			//0
					$result->order_id,		//1
					$result->design_no,			//2
					$result->master_id,			//3
					$result->labour_id,	//4
					$result->type_of_kali,		//5
					$result->kali_quantity,		//6
					$result->rate,		//7
					$result->total_cost,		//8
					$result->added_by,		//9
					$result->added_on,		//10
					$result->modified_by,		//11
					$result->modified_on,		//12
					$result->kali_name		//13
					);
		}
	
		//return the data
		return $data;
		
	}//eof
	
	public function getKaliCutDtl(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM kalicut_mst order by type_of_kali ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	/*
	*	This funcion will return all the Kali id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAltKaliId($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT kali_id FROM kalicut_mst";
		}
		else
		{
			//statement
			$select	= "SELECT kali_id FROM kalicut_mst
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['kali_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	
}