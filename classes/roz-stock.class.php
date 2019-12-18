<?php 
/**
*	This class is going to work with all HMDA Live Stock associated with a Design No. 
*
*	@author		Safikul Islam
*	@date		May 17, 2018
*	@version	1.0
*	@copyright	MIS
*	@url		http://monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/




class RozStock 
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
	function addRozStock($design_no,$box_name, $box_no, $quantity,$shop,$added_by)
	{
		$design_no			   	=	mysql_real_escape_string(trim($design_no));
		$box_name		  		=	mysql_real_escape_string(trim($box_name));
		$box_no			 		=	mysql_real_escape_string(trim($box_no));
		$quantity			   	=	mysql_real_escape_string(trim($quantity));
		$shop			   		=	mysql_real_escape_string(trim($shop));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		//satement to insert in roz_stock table
		$insert		=   "INSERT INTO roz_stock
						(design_no, box_name, box_no, quantity,shop,added_on,added_by)
							
						VALUES
						('$design_no', '$box_name', '$box_no','$quantity','$shop', now(),'$added_by')
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$stock_id	= mysql_insert_id();
		
		//return primary key
		return $stock_id;

	}//eof
	
	// Product stock edit
	function editShopProd($stock_id,$quantity,$modified_by)
	{
		$quantity				=   mysql_real_escape_string(trim($quantity));
		$modified_by		   	=	mysql_real_escape_string(trim($modified_by));
		//statement
		$sql	 = "UPDATE roz_stock 
					SET 
					quantity    			= '$quantity' ,
					modified_by    			= '$modified_by' ,
					modified_on    			= now()
					WHERE stock_id			= '$stock_id'";
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	#####################################################################################################
	#
	#										Stock Display
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
	function getAllRStock($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT stock_id FROM roz_stock";
		}
		else
		{
			//statement
			$select	= "SELECT stock_id FROM roz_stock
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
	function showRozStock($sid)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM roz_stock
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
					$result->modified_on,				//8
					$result->shop						//9
					);
		}
		
		//return the data
		return $data;
	}//eof
	
	//*
	/*
	* Display Live Stock
	*/
	public function RozStockShow(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM roz_stock order by stock_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
        $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	 /* sum of current products stock all data */
	/*
	*/
	 public function CurrentRozStockSum(){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `count_quantity` FROM `roz_stock` ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     } 
	
	#####################################################################################################
	#
	#										shop products in
	#
	#####################################################################################################
	
	/**
	*	Add a new Product in hmda_stock table.
	*
	*	@param
	*			$id			    		Shop product in id
	*			$design_no				Design no of  products
	*			$inqty			    	In Quantity
	*	@return int
	*/
	function addShopProdIn($design_no,$inqty,$added_by)
	{
		$design_no			   	=	mysql_real_escape_string(trim($design_no));
		$inqty		  			=	mysql_real_escape_string(trim($inqty));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		//satement to insert in roz_stock_in table
		$insert		=   "INSERT INTO roz_stock_in
						(design_no, inqty,added_by, added_on)
							
						VALUES
						('$design_no', '$inqty','$added_by',now())
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		
		//return primary key
		return $id;
	}//eof
	
	//*
	/*
	* Display Shop products in
	*/
	public function ShoProdsInShow(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM roz_stock_in order by id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
        $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	#####################################################################################################
	#
	#										shop products Out
	#
	#####################################################################################################
	
	/**
	*	Add a new Product Out in stock product out table.
	*
	*	@param
	*			$id			    		Stock product out id	
	*			$design_no				Design no of  products
	*			$outqty			    	Out Quantity
	*	@return int
	*/
	function addShopProdOut($design_no,$outqty,$added_by)
	{
		$design_no			   	=	mysql_real_escape_string(trim($design_no));
		$outqty		  			=	mysql_real_escape_string(trim($outqty));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		//satement to insert in roz_stock_out table
		$insert		=   "INSERT INTO roz_stock_out
						(design_no, outqty,added_by, added_on)
							
						VALUES
						('$design_no', '$outqty','$added_by',now())
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		
		//return primary key
		return $id;
	}//eof
	
	//*
	/*
	* Display Shop products in
	*/
	public function ShoProdsOutShow(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM roz_stock_out order by id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
        $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	
}//eoc	
?>