<?php 
/**
*	This class is going to work with all Fabric associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Feb 10, 2015
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.waintechnology.com
*	@email		safikulislamwb@gmail.com
* 
*/




class Thread 
{

	#####################################################################################################
	#
	#										Add Thread
	#
	#####################################################################################################
	
	/**
	*	Add a new thread in thread table.
	*
	*	@param
	*			$thread_id			    thread_id	
	*			$thread_name 			thread name
	*			$c_stock			    Current Stock
	*			$lastdate				Last update
	*			
	*			$remark					Remark
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addThread($thread_name,$c_stock, $lastdate,$remark)
	
	{
		$thread_name		=	mysql_real_escape_string(trim($thread_name));
		$c_stock	        =	trim($c_stock);
		$lastdate			   = mysql_real_escape_string(trim($lastdate));
		$remark			   =	mysql_real_escape_string(trim($remark));
		$added_by			   =	mysql_real_escape_string(trim($added_by));



		
		
		//satement to insert in orders table
		$insert		=   "INSERT INTO thread
						(thread_name, c_stock, lastdate, remark, added_on,added_by)
							
						VALUES
						('$thread_name', '$c_stock', '$lastdate', '$remark', now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$thread_id	= mysql_insert_id();
		
		//return primary key
		return $thread_id;

	}//eof
		
	
	
	

	
	
	#####################################################################################################
	#
	#										Edit Fabric
	#
	#####################################################################################################
	
	
	/**
	*	This function edit Fabric
	*
	*	@param
	*			$fabric_id			    fabric_id	
	*			$fabric_name 			fabric name
	*			$c_stock			    Current Stock
	*			$lastdate				Last update
	*			
	*			$remark					Remark
	*			
	*		
	*			
	*	@return null
	*/
	function editThread($thread_id, $thread_name,$c_stock, $lastdate,$remark)
	
	{
		$thread_name		=	mysql_real_escape_string(trim($thread_name));
		$c_stock	        =	trim($c_stock);
		$lastdate			   = mysql_real_escape_string(trim($lastdate));
		$remark			   =	mysql_real_escape_string(trim($remark));

		//update product description
		$edit  = "UPDATE thread
				SET
				thread_name		 		= '$thread_name',
				c_stock			= '$c_stock',
				lastdate				= '$lastdate',
				remark 				= '$remark'				
				WHERE
				thread_id 			= '$thread_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	
	#####################################################################################################
	#
	#										Delete Fabric
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a fabric permanently
	*
	*	@param
	*			$fid			fabric id
	*
	*	@return null
	*/
	function delFabric($fid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM fabric WHERE fabric_id='$fid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
		

	
	
	/**
	*	Get the data associated with a fabric based upon the primary key
	*
	*	@param
	*			$fid		Fabric id
	*
	*	@return array				
	*/
	function showThread($tid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM thread
				   WHERE thread_id	= '$tid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->thread_id,					//0
					$result->thread_name,							//1
					$result->c_stock,						//2
					$result->lastdate,						//3
					$result->remark,				//4
					$result->added_on,						//5
					$result->added_by,						//6
					$result->modified_on,						//7
					$result->modified_by					//8
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/* Display all data */
	/*
		$pid= orders_id 
	*/
	
	 public function ordersDisplay($pid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM orders where orders_id='$oid' LIMIT 1") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	
	
	
	
	
	/*
	*	This funcion will return all the thread id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllThread($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT thread_id FROM thread";
		}
		else
		{
			//statement
			$select	= "SELECT thread_id FROM thread
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['thread_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
#####################################################################################################
	#
	#										 Fabric In
	#
	#####################################################################################################
	
	/**
	*	Add a new fabric in fabric_in table.
	*
	*	@param
	*			
	*			$thread_name 			fabric name
	*			$fabric_in			    
	*
	*	@return int
	*/
	function addThreadIn($thread_name,$thr_amount, $cus_name,$company,$from_w,$price,$totalamount,$remark)
	
	{
		$thread_name		=	mysql_real_escape_string(trim($thread_name));
		$thr_amount	        =	trim($thr_amount);
		$cus_name			   = mysql_real_escape_string(trim($cus_name));
		$company		=	mysql_real_escape_string(trim($company));
		$from_w	        =	mysql_real_escape_string(trim($from_w));
		$price			   = mysql_real_escape_string(trim($price));
		$totalamount	        =	trim($totalamount);
		$remark			   = mysql_real_escape_string(trim($remark));
			
		//satement to insert in orders table
		$insert		=   "INSERT INTO thread_in
						(thread_name, thr_amount, cus_name, company, from_w, price, totalamount, remark, added_on)
							
						VALUES
						('$thread_name', '$thr_amount', '$cus_name', '$company', '$from_w', '$price', '$totalamount', '$remark',now())
							
						";
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$thread_in_id	= mysql_insert_id();
		
		//return primary key
		return $thread_in_id;

	}//eof
			
	
	
	/**
	*	Get the data associated with a threadIn based upon the primary key
	*
	*	@param
	*			$tid		thread id
	*
	*	@return array				
	*/
	function showThreadIn($tid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM thread_in
				   WHERE thread_in_id	= '$tid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->thread_in_id,					//0
					$result->thread_name,							//1
					$result->thr_amount,						//2
					$result->cus_name,						//3
					$result->company,		//4
					$result->from_w,			//5
					$result->price,				//6
					$result->totalamount,			//7
					$result->remark,		//8
					$result->added_on,		//9
					$result->added_by,		//10
					$result->modified_on,		//11
					$result->modified_by		//12
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/*
	*	This funcion will return all the thread_in id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllThreadIn($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT thread_in_id FROM thread_in";
		}
		else
		{
			//statement
			$select	= "SELECT thread_in_id FROM thread_in
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['thread_in_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	#####################################################################################################
	#
	#										Fabric Out
	#
	#####################################################################################################
	
	/**
	*	 fabric Out in fabric_out table.
	*
	*	@param
	*			
	*			$thread_name 			thread name
	*			$fabric_out			    
	*
	*	@return int
	*/
	function addThreadOut($order_id,$thread_name,$thr_amount,$company,$price,$totalamount,$cus_id, $cus_name,$remark,$added_by)
	{
		$order_id			=	mysql_real_escape_string(trim($order_id));
		$thread_name		=	mysql_real_escape_string(trim($thread_name));
		$thr_amount	        =	trim($thr_amount);
		$company		=	mysql_real_escape_string(trim($company));
		$price			   = mysql_real_escape_string(trim($price));
		$totalamount	        =	trim($totalamount);
		$cus_id			   = mysql_real_escape_string(trim($cus_id));
		$cus_name			   = mysql_real_escape_string(trim($cus_name));
		$remark			   = mysql_real_escape_string(trim($remark));
		$added_by			   = mysql_real_escape_string(trim($added_by));
			
		//satement to insert in orders table
		$insert		=   "INSERT INTO thread_out
						(order_id,thread_name, thr_amount, company, price, totalamount,cus_id,cus_name, remark, added_on,added_by)
							
						VALUES
						('$order_id','$thread_name', '$thr_amount', '$company','$price', '$totalamount','$cus_id','$cus_name', '$remark',now(),'$added_by')
							
						";
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$thread_out_id	= mysql_insert_id();
		
		//return primary key
		return $thread_out_id;

	}//eof
			
	/**
	*	Get the data associated with a thread out  based upon the primary key
	*
	*	@param
	*			$tid		thraed_out_id
	*
	*	@return array				
	*/
	function showThreadout($tid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM thread_out
				   WHERE thread_out_id	= '$tid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->thread_out_id,					//0
					$result->thread_name,	//1
					$result->thr_amount,		//2
					$result->company,		//3
					$result->price,			//4
					$result->totalamount,		//5
					$result->cus_id,		//6
					$result->cus_name,			//7
					$result->remark,		//8
					$result->added_on,		//9
					$result->added_by,		//10
					$result->modified_on,		//11
					$result->modified_by,		//12
					$result->order_id		//13

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/*
	*	This funcion will return all the thread_out id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllThreadOut($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT thread_out_id FROM thread_out";
		}
		else
		{
			//statement
			$select	= "SELECT thread_out_id FROM thread_out
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['thread_out_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
}//eoc
?>