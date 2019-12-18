<?php 
/**
*	This class is going to work with all Meals amount calculate associated . 
*
*	@author		Safikul Islam
*	@date		April 20, 2016
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/




class Meals
{

	#####################################################################################################
	#										Add  to meals table
	#										
	#
	#####################################################################################################
	
	
	//			Add interlock_mst value
	
	/**
	*	interlock_mst.
	*
	*	@param
	*			
	*			$meals_id			   		meals identification number
	*			$no_of_meals			   	number of meals 
	*			$meals_rate			   	    meals rate
	*			$total_amount			   	total amount
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addMeals($no_of_meals,$meals_rate,$total_amount,$labour_id,$added_by)
	
	{
		$no_of_meals			   	=	mysql_real_escape_string(trim($no_of_meals));
		$meals_rate			   		=	mysql_real_escape_string(trim($meals_rate));
		$total_amount			   	=	mysql_real_escape_string(trim($total_amount));
		$labour_id			   		=	mysql_real_escape_string(trim($labour_id));
		$added_by			   		=	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO meals
						(no_of_meals,meals_rate,total_amount,labour_id,added_by, added_on)
							
						VALUES
						('$no_of_meals','$meals_rate','$total_amount','$labour_id','$added_by',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$meals_id	= mysql_insert_id();
		
		//return primary key
		return $meals_id;

	}//eof
	
	
	
		
	#####################################################################################################
	#
	#										Delete Meals
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete meals table row value permanently
	*
	*	@param
	*			$meals_id			meals  id
	*
	*	@return null
	*/
	function delMeals($meals_id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM meals WHERE meals_id ='$meals_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  meals details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a meals based upon the primary key
	*
	*	@param
	*			$meals_id		meals id
	*
	*	@return array				
	*/
	function showMeals($meals_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM meals
				   WHERE meals_id	= '$meals_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->meals_id,			//0
					$result->no_of_meals,		//1
					$result->meals_rate,			//2
					$result->total_amount,			//3
					$result->labour_id,			//4
					$result->added_by,		//5
					$result->added_on,		//6
					$result->modified_by,		//7
					$result->modified_on,		//8
					);
		}
	
		//return the data
		return $data;
		
	}//eof
	
	public function getMeals(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM meals order by added_on DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	/*
	*	This funcion will return all the meals id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllMealsId($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT meals_id FROM meals";
		}
		else
		{
			//statement
			$select	= "SELECT meals_id FROM meals
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['meals_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	
}