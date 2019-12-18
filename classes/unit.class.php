<?php 
/**
*	This class is going to work with all Unit associated. 
*
*	@author		Safikul Islam
*	@date		Dec 26, 2016
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.waintechnology.com
*	@email		safikulislamwb@gmail.com
* 
*/




class Unit 
{


	#####################################################################################################
	#
	#										add colour
	#
	#####################################################################################################
	
	/**
	*	Add a new colour to colour mst table.
	*
	*	@param
	*			
	*			$colour_id			    colour identification number	
	*			$colour_name			colour name 
	*			$date     		    	date
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addMColour($colour_name,$added_by)
	
	{
		$colour_name			   	= mysql_real_escape_string(trim($colour_name));
		$added_by	        		=	trim($added_by);
		
		//satement to insert in colour_mst table
		$insert		=   "INSERT INTO colour_mst
						(colour_name,added_on, added_by)
							
						VALUES
						('$colour_name', now(), '$added_by')
							
						";
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$colour_id	= mysql_insert_id();
		
		//return primary key
		return $colour_id;

	}//eof
	
	
	/*
	*	This funcion will return all the colour id return
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllMstColour($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT colour_id FROM colour_mst";
		}
		else
		{
			//statement
			$select	= "SELECT colour_id FROM colour_mst
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['colour_id'];
		}
		
		//echo $select.mysql_error();exit;
		//return the data
		return $data;
		
	}//eof
	
	
	
		
	/**
	*	Get the data associated with a colour based upon the primary key
	*
	*	@param
	*			$colour_id		colour id
	*
	*	@return array				
	*/
	function showMstColour($colour_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM colour_mst
				   WHERE colour_id	= '$colour_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->colour_id,					//0
					$result->colour_name,				//1
					$result->added_on,					//3
					$result->added_by				//4

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/* Display all colour data */
	/*
	*/
	 public function MstColourDisplay(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM colour_mst order by colour_name ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
		
/**
	*	This function will delete a colour in permanently
	*
	*	@param
	*			$cid			colour id
	*
	*	@return null
	*/
	function delColorMstDtl($cid)
	{
		//delete from colour
		$delete1 = "DELETE FROM colour_mst WHERE colour_id='$cid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		//echo $query1.mysql_error();exit;
	}//eof
	
	
	#####################################################################################################
	#
	#									Design Categories Name	
	#
	#####################################################################################################
	
	/**
	*	Add a new design categories to design_categories table.
	*
	*	@param
	*			
	*			$cat_id			    	Design Categories identification number	
	*			$categories_name		Design Categories name 
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addDesCat($categories_name,$added_by)
	
	{
		$categories_name			   	= mysql_real_escape_string(trim($categories_name));
		$added_by	        		=	trim($added_by);
		
		//satement to insert in design_categories table
		$insert		=   "INSERT INTO design_categories
						(categories_name,added_on, added_by)
							
						VALUES
						('$categories_name', now(), '$added_by')
							
						";
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$cat_id	= mysql_insert_id();
		
		//return primary key
		return $cat_id;

	}//eof
	
	
	/*
	*	This funcion will return all the Categories Id return
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllDesCategories($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT cat_id FROM design_categories";
		}
		else
		{
			//statement
			$select	= "SELECT cat_id FROM design_categories
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['cat_id'];
		}
		
		//echo $select.mysql_error();exit;
		//return the data
		return $data;
		
	}//eof
	
	
	
		
	/**
	*	Get the data associated with a Design Categories based upon the primary key
	*
	*	@param
	*			$cat_id		Categories id
	*
	*	@return array				
	*/
	function showDesCategories($cat_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM design_categories
				   WHERE cat_id	= '$cat_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->cat_id,					//0
					$result->categories_name,				//1
					$result->added_on,					//3
					$result->added_by				//4

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/* Display all colour data */
	/*
	*/
	 public function MstDesCatDisplay(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM design_categories") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
}//eoc

?>	