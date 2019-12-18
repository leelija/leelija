<?php 
/**
*	This class is going to work with all HMDA Live Stock associated with a Design No. 
*
*	@author		Safikul Islam
*	@date		July 27, 2017
*	@version	1.0
*	@copyright	MIS
*	@url		http://monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/




class LiveStock 
{

	#####################################################################################################
	#
	#										Add Products
	#
	#####################################################################################################
	
	/**
	*	Add a new Product in hmda_stock table.
	*
	*	@param
	*			$stock_id			    orders_id	
	*			$design_no				Design no of  products
	*			$box_name			    Party name
	*			$box_no					Brokar
	*			$quantity				Reta Hol
	*	@return int
	*/
	function addLiveStock($design_no,$box_name, $box_no, $quantity,$added_by)
	{
		$design_no			   	=	mysql_real_escape_string(trim($design_no));
		$box_name		  		=	mysql_real_escape_string(trim($box_name));
		$box_no			 		=	mysql_real_escape_string(trim($box_no));
		$quantity			   	=	mysql_real_escape_string(trim($quantity));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		//satement to insert in hmda_stock table
		$insert		=   "INSERT INTO hmda_stock
						(design_no, box_name, box_no, quantity,added_on,added_by)
							
						VALUES
						('$design_no', '$box_name', '$box_no','$quantity', now(),'$added_by')
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$stock_id	= mysql_insert_id();
		
		//return primary key
		return $stock_id;

	}//eof
	
	#####################################################################################################
	#
	#										HMDA Stock Display
	#
	#####################################################################################################
			

	/*
	*	This funcion will return all the stock id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllStock($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT stock_id FROM hmda_stock";
		}
		else
		{
			//statement
			$select	= "SELECT stock_id FROM hmda_stock
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['stock_id'];
		}
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get the data associated with a HMDA stock based upon the primary key
	*
	*	@param
	*			$sid		stock id
	*
	*	@return array				
	*/
	function showLiveStock($sid)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM hmda_stock
				   WHERE stock_id	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->stock_id,					//0
					$result->design_no,					//1
					$result->box_name,					//2
					$result->box_no,					//3
					$result->quantity,					//4
					$result->added_by,					//5
					$result->added_on,					//6
					$result->modified_by,				//7
					$result->modified_on				//8
					);
		}
		
		//return the data
		return $data;
	}//eof
	
	//*
	/*
	* Display Live Stock
	*/
	public function LiveStockShow(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM hmda_stock order by stock_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
        $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	 /* sum of current products stock all data */
	/*
	*/
	 public function CurrentLiveStockSum(){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `count_quantity` FROM `hmda_stock` ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     } 
	
	
}//eof	
?>