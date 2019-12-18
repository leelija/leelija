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




class Fabric 
{

	#####################################################################################################
	#
	#										Add Fabric
	#
	#####################################################################################################
	
	/**
	*	Add a new fabric in Fabric table.
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
	*
	*	@return int
	*/
	function addFabric($fabric_name,$fab_type,$fab_unit,$c_stock,$remark,$added_by)
	
	{
		$fabric_name			=	mysql_real_escape_string(trim($fabric_name));
		$fab_type			   	= mysql_real_escape_string(trim($fab_type));
		$fab_unit				=	mysql_real_escape_string(trim($fab_unit));
		$c_stock	        	=	trim($c_stock);
		$remark			   		=	mysql_real_escape_string(trim($remark));
		$added_by			  	=	mysql_real_escape_string(trim($added_by));



		
		
		//satement to insert in orders table
		$insert		=   "INSERT INTO fabric
						(fabric_name,fab_type,fab_unit, c_stock, lastdate, remark, added_on,added_by)
							
						VALUES
						('$fabric_name','$fab_type','$fab_unit', '$c_stock', now(), '$remark', now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$fabric_id	= mysql_insert_id();
		
		//return primary key
		return $fabric_id;

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
	function editFabric($fabric_id,$c_stock, $modified_by )
	
	{
		$modified_by		=	mysql_real_escape_string(trim($modified_by));
		$c_stock	        =	trim($c_stock);
		$fabric_id			= mysql_real_escape_string(trim($fabric_id));

		//update product description
		$edit  = "UPDATE fabric
				SET
				c_stock					= '$c_stock',
				lastdate				= now(),
				modified_on 			= now(),
				modified_by				= '$modified_by'	
				WHERE
				fabric_id 			= '$fabric_id'
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
	function showFabric($fid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM fabric
				   WHERE fabric_id	= '$fid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->fabric_id,					//0
					$result->fabric_name,				//1
					$result->c_stock,						//2
					$result->lastdate,						//3
					$result->remark,						//4
					$result->added_on,						//5
					$result->added_by,						//6
					$result->modified_on,					//7
					$result->modified_by,					//8
					$result->fab_unit,						//9
					$result->fab_type,						//10
					$result->image						//11

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/* Display all fabric data */
	 public function fabricDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM fabric order by fabric_name ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
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
	*	This funcion will return all the orders id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllFabric($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT fabric_id FROM fabric";
		}
		else
		{
			//statement
			$select	= "SELECT fabric_id FROM fabric
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['fabric_id'];
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
	*			$fabric_name 			fabric name
	*			$fabric_in			    
	*
	*	@return int
	*/
	function addfabricIn($fabric_name,$fab_amount, $receive_by,$company_id,$from_w,$price,$totalamount,$bill_no,$remark,$added_by,
	$payment_status)
	
	{
		$fabric_name		=	mysql_real_escape_string(trim($fabric_name));
		$fab_amount	        =	trim($fab_amount);
		$receive_by			=   mysql_real_escape_string(trim($receive_by));
		$company_id			=	mysql_real_escape_string(trim($company_id));
		$from_w	        	=	mysql_real_escape_string(trim($from_w));
		$price			   	= 	mysql_real_escape_string(trim($price));
		$totalamount	    =	trim($totalamount);
		$bill_no			= 	mysql_real_escape_string(trim($bill_no));
		$remark				= 	mysql_real_escape_string(trim($remark));
		$added_by			= 	mysql_real_escape_string(trim($added_by));
		$payment_status		= 	mysql_real_escape_string(trim($payment_status));
		//satement to insert in orders table
		$insert		=   "INSERT INTO fabric_in
						(fabric_name, fab_amount, receive_by, company_id, from_w, price, totalamount,bill_no, remark, added_on,
						added_by,payment_status)
							
						VALUES
						('$fabric_name', '$fab_amount', '$receive_by', '$company_id', '$from_w', '$price', '$totalamount',
						'$bill_no', '$remark',now(), '$added_by','$payment_status')
							
						";
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$fabric_in_id	= mysql_insert_id();
		
		//return primary key
		return $fabric_in_id;

	}//eof
			
	
	
	/**
	*	Get the data associated with a fabricIn based upon the primary key
	*
	*	@param
	*			$fid		Fabric id
	*
	*	@return array				
	*/
	function showFabricIn($fid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM fabric_in
				   WHERE fabric_in_id	= '$fid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->fabric_in_id,		//0
					$result->fabric_name,		//1
					$result->fab_amount,		//2
					$result->receive_by,		//3
					$result->company_id,		//4
					$result->from_w,			//5
					$result->price,				//6
					$result->totalamount,		//7
					$result->remark,			//8
					$result->added_on,			//9
					$result->added_by,			//10
					$result->modified_on,		//11
					$result->modified_by,		//12
					$result->bill_no,		//13
					$result->image		//14

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/*
	*	This funcion will return all the fabric_in id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllFabricIn($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT fabric_in_id FROM fabric_in";
		}
		else
		{
			//statement
			$select	= "SELECT fabric_in_id FROM fabric_in
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['fabric_in_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
		/* Display all Material In data */
	 public function matInDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM fabric_in order by added_on DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	/*
	* 	$fabric_in_id		= Fabric In Id
	*			
	*	@return null
	*/
	function PayBillStatus($fabric_in_id,$modified_by, $payment_status )
	
	{
		$modified_by		=	mysql_real_escape_string(trim($modified_by));
		$payment_status		=	mysql_real_escape_string(trim($payment_status));
		$fabric_in_id		= mysql_real_escape_string(trim($fabric_in_id));

		//update product description
		$edit  = "UPDATE fabric_in
				SET
				modified_on				= now(),
				modified_by 			= '$modified_by',
				payment_status			= '$payment_status'	
				WHERE
				fabric_in_id 			= '$fabric_in_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
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
	*			$
	*			$fabric_out			    
	*
	*	@return int
	*/
	function addfabricOut($fabric_id,$bill_no,$design_no,$fab_amount,$purpose,$receive_by,$remark,$added_by)
	{
		$fabric_id			=	mysql_real_escape_string(trim($fabric_id));
		$bill_no			=	mysql_real_escape_string(trim($bill_no));
		$design_no			=	mysql_real_escape_string(trim($design_no));
		$fab_amount	        =	trim($fab_amount);
		
		$purpose			= mysql_real_escape_string(trim($purpose));
		$receive_by			= mysql_real_escape_string(trim($receive_by));
		$remark	    		=	trim($remark);
		$added_by			= mysql_real_escape_string(trim($added_by));
			
		//satement to insert in orders table
		$insert		=   "INSERT INTO fabric_out
						(fabric_id,bill_no,design_no, fab_amount,purpose, receive_by, remark,added_on,added_by)
							
						VALUES
						('$fabric_id','$bill_no','$design_no', '$fab_amount','$purpose', '$receive_by','$remark',now(),'$added_by')
							
						";
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$fabric_out_id	= mysql_insert_id();
		
		//return primary key
		return $fabric_out_id;

	}//eof
			
	/**
	*	Get the data associated with a fabric out  based upon the primary key
	*
	*	@param
	*			$fid		fabric_out_id
	*
	*	@return array				
	*/
	function showFabricOut($fid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM fabric_out
				   WHERE fabric_out_id	= '$fid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->fabric_out_id,	//0
					$result->fabric_id,		//1
					$result->bill_no,		//2
					$result->design_no,		//3
					$result->fab_amount,	//4
					$result->purpose,		//5
					$result->receive_by,	//6
					$result->remark,		//7
					$result->added_on,		//8
					$result->added_by,		//9
					$result->modified_on,		//10
					$result->modified_by		//11

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/*
	*	This funcion will return all the fabric_out id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllFabricOut($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT fabric_out_id FROM fabric_out";
		}
		else
		{
			//statement
			$select	= "SELECT fabric_out_id FROM fabric_out
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['fabric_out_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/* Display all Material out data */
	 public function matOutDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM fabric_out order by added_on DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	
}//eoc
?>