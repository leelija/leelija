<?php 
/**
*	This class is going to work with all fabric stock associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Feb 10, 2015
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.waintechnology.com
*	@email		safikulislamwb@gmail.com
* 
*/




class Fabstock 
{

	#####################################################################################################
	#
	#										Add To fab_stock table
	#
	#####################################################################################################
	
	/**
	*	Add a fabric to fab_stock  table.
	*
	*	@param
	*			
	*			$stock_id			    stock_id	
	*			$design_no				Design no of  products
	*			$stock			     	stock 
	*			$product_in				product_in
	*			$sales					sales product
	*			$goods_return			return goods
	*			$remarks					Remark
	*			$date     		    	date
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addStock($stock_id,$design_no, $stock,$product_in, $sales, $goods_return,$remarks,$date, $added_by)
	
	{
		$stock_id			   =	mysql_real_escape_string(trim($stock_id));
		$design_no	        =	trim($design_no);
		$stock			   = mysql_real_escape_string(trim($stock));
		$product_in			   =	mysql_real_escape_string(trim($product_in));
		$sales		       =	mysql_real_escape_string(trim($sales));
		$goods_return			 =	mysql_real_escape_string(trim($goods_return));
		$remarks		   =	mysql_real_escape_string(trim($remarks));
		$date			=	mysql_real_escape_string(trim($date));
		$added_by			=	mysql_real_escape_string(trim($added_by));



		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO stock
						(stock_id, design_no, stock, product_in, sales, goods_return,remarks,date,added_on, added_by)
							
						VALUES
						('$stock_id', '$design_no', '$stock', '$product_in', '$sales','$goods_return', 
							'$remarks','$date',now(), '$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$product_id	= mysql_insert_id();
		
		//return primary key
		return $orders_id;

	}//eof
		
	
	

	
	
	#####################################################################################################
	#
	#										Edit Stock
	#
	#####################################################################################################
	
	
	/**
	*	This function edit stock
	*
	*	@param
	*			$stock_id			    stock_id	
	*			$design_no				Design no of  products
	*			$stock			     	stock 
	*			$product_in				product_in
	*			$sales					sales product
	*			$goods_return			return goods
	*			$remarks					Remark
	*			$date     		    	date
	*			
	*		
	*			
	*	@return null
	*/
	function editStock($stock_id,$design_no, $stock,$product_in, $sales, $goods_return,$remarks,$date, $modified_by)
	
	{
		$stock_id			   =	mysql_real_escape_string(trim($stock_id));
		$design_no	        =	trim($design_no);
		$stock			   = mysql_real_escape_string(trim($stock));
		$product_in			   =	mysql_real_escape_string(trim($product_in));
		$sales		       =	mysql_real_escape_string(trim($sales));
		$goods_return			 =	mysql_real_escape_string(trim($goods_return));
		$remarks		   =	mysql_real_escape_string(trim($remarks));
		$date			=	mysql_real_escape_string(trim($date));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));


		//update stock description
		$edit  = "UPDATE stock
				SET
				design_no		 		= '$design_no',
				stock			        = '$stock',
				product_in				= '$product_in',
				sales 					= '$sales',
				goods_return		    = '$goods_return',
				remarks				= '$remarks',
				date				= '$date',
				modified_by			= '$modified_by'
				WHERE
				stock_id 			= '$stock_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	
	#####################################################################################################
	#
	#										Delete Stock
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a order permanently
	*
	*	@param
	*			$sid			sid
	*
	*	@return null
	*/
	function delStock($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM stock WHERE stock_id='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Stock products details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a stock based upon the primary key
	*
	*	@param
	*			$sid		stock id
	*
	*	@return array				
	*/
	function showStock($sid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stock
				   WHERE stock_id	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->stock_id,					//0
					$result->design_no,							//1
					$result->stock,					//2
					$result->product_in,						//3
					$result->sales,				//4
					$result->goods_return,					//5
					$result->remarks,						//6
					$result->date,				//7
					$result->added_on,					//8
					$result->added_by,						//9
					$result->modified_on,						//10
					$result->modified_by						//11
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/* Display all data */
	/*
		$pid= orders_id 
	*/
	
	 public function stockDisplay($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock where stock_id='$sid' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	
	
	
	
	
	
}
?>