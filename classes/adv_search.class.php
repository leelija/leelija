<?php 
/**
*	Search the database according to the criteria provided by the user.
*	Note: We are using full text search mixed with normal search. If any result is not returned
*	by the full text search, we will use normal search in such cases.
*
*	@author     	Safikul Islam
*	@date   	 	December 21, 2015
*	@update			January  01, 2015
*	@version 		3.0
*	@email			safikulislamwb@gmail.com
*/

require_once("customer.class.php");

class AdvSearch extends Customer
{
/**
	*	========================Search for Product Status =========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSearchProdStatusSort($keyword,$type)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT status_id FROM status_table";
		}
		else
		{
			$sql = "SELECT status_id
					FROM   status_table
					WHERE (".$type." LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->status_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	function getSortProdStatusByManeger($keyword,$type,$userid)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT status_id FROM status_table where employee_id ='$userid'";
		}
		else
		{
			$sql = "SELECT status_id
					FROM   status_table
					WHERE (".$type." LIKE '%$keyword%%') AND employee_id ='$userid';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->status_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
/**
	*	========================Search for Dyeing =========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSearchdyeSort($keyword,$type)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT dyeing_id FROM dyeing_table";
		}
		else
		{
			$sql = "SELECT dyeing_id
					FROM   dyeing_table
					WHERE (".$type." LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->dyeing_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	/**
	*	========================Search for Manual =========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSearchManuSort($keyword,$type)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT manual_id FROM manual_table";
		}
		else
		{
			$sql = "SELECT manual_id
					FROM   manual_table
					WHERE (".$type." LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->manual_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	/**
	*	========================Search for Computer =========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSearchCompSort($keyword,$type)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT computer_id FROM computer_table";
		}
		else
		{
			$sql = "SELECT computer_id
					FROM   computer_table
					WHERE (".$type." LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->computer_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	/**
	*	========================Search for Kalicut =========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSearchKaliSort($keyword,$type)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT kalicut_id FROM kalicut_table";
		}
		else
		{
			$sql = "SELECT kalicut_id
					FROM   kalicut_table
					WHERE (".$type." LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->kalicut_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	
	/**
	*	========================Search for final stich =========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSearchFstichSort($keyword,$type)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT final_stich_id FROM final_stich";
		}
		else
		{
			$sql = "SELECT final_stich_id
					FROM   final_stich
					WHERE (".$type." LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->final_stich_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	/* ======================Search for products pending===============================*/
	
	/**
	*	Search product status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProductPendindKey($keyword,$userid)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT pp_id FROM packing_pending where store_managerId ='$userid'";
		}
		else
		{
			$sql = "SELECT pp_id
					FROM   packing_pending
					WHERE (order_id LIKE '%$keyword%' OR
						   store_managerId LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   bill_no LIKE '%$keyword%' OR
						   particular LIKE '%$keyword%' OR
						   final_result LIKE '%$keyword%' OR
						   
						   added_on LIKE '%$keyword%%') AND store_managerId ='$userid';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->pp_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
/**	
	*	========================Search for Rozlle Order =========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getRozelOrdAdvsearch($keyword,$type)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT orders_id FROM rozelle_orders";
		}
		else
		{
			$sql = "SELECT orders_id
					FROM   rozelle_orders
					WHERE (".$type." LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->orders_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	
	///////////////////////////////////////////// Common search function user wise /////////////////////////////
	
	function getCommonSearch($keyword,$type,$userid,$id,$table)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		$id = mysql_real_escape_string($id);
		$table = mysql_real_escape_string($table);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT ".$id." FROM ".$table." where store_managerId ='$userid'";
		}
		else
		{
			$sql = "SELECT ".$id."
					FROM   ".$table."
					WHERE (".$type." LIKE '%$keyword%%') AND store_managerId ='$userid';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		//echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->$id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	///////////////////////////////////////////// Common search function for admin /////////////////////////////
	
	function getCommonSearchAdmin($keyword,$type,$id,$table)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		$id = mysql_real_escape_string($id);
		$table = mysql_real_escape_string($table);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT ".$id." FROM ".$table." ";
		}
		else
		{
			$sql = "SELECT ".$id."
					FROM   ".$table."
					WHERE ".$type." LIKE '%$keyword%%' ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->$id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	//Advance All search
	function getAllAdvSearch($keyword,$design_no,$book_no,$id,$table)
	{
		$keyword 	= mysql_real_escape_string($keyword);
		$design_no 	= mysql_real_escape_string($design_no);
		$book_no 	= mysql_real_escape_string($book_no);
		$id 		= mysql_real_escape_string($id);
		$table 		= mysql_real_escape_string($table);
		//echo $type;exit;
		if($keyword != '')
		{
			$sql =  "SELECT ".$id." FROM ".$table." ";
		}
		else
		{
			$sql = "SELECT ".$id."
					FROM   ".$table."
					WHERE design_no LIKE '%$design_no%%' AND  book_no LIKE '%$book_no%%';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->$id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	
	
	
}//eoc	