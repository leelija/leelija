<?php 
/**
*	This class is going to work with all orders associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Feb 10, 2015
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/




class Rozelleorders 
{

	#####################################################################################################
	#
	#										Add Orders
	#
	#####################################################################################################
	
	/**
	*	Add a new orders in orders table.
	*
	*	@param
	*			$orders_id			    orders_id	
	*			$design_no				Design no of  products
	*			$party_name			    Party name
	*			$brokar					Brokar
	*			$retahol				Reta Hol
	*			$form				    Order Address
	*			$quantity			    Number of products
	*			$colour     		    Orders products colour
	*			$remark					Remark
	*			$order_date				order date
	*			$target_date		    Target Date
	*		
	*			
	*
	*	@return int
	*/
	function addRozzeleOrders($design_no,$book_no, $party_name,$brokar, $retahol, $form, $quantity, $colour, $payment_qty,$priority,$status, $remark,$order_date, $target_date)
	
	{
		//$orders_id			   =	mysql_real_escape_string(trim($orders_id));
		$design_no	        =	trim($design_no);
		$book_no			   = mysql_real_escape_string(trim($book_no));
		$party_name			   = mysql_real_escape_string(trim($party_name));
		$brokar			   =	mysql_real_escape_string(trim($brokar));
		$retahol		  =	mysql_real_escape_string(trim($retahol));
		$form			 =	mysql_real_escape_string(trim($form));
		$quantity			   =	mysql_real_escape_string(trim($quantity));
		$colour		     =	mysql_real_escape_string(trim($colour));
		$payment_qty		     =	mysql_real_escape_string(trim($payment_qty));
		
		$priority		     =	mysql_real_escape_string(trim($priority));
		$status		     =	mysql_real_escape_string(trim($status));
		
		$remark		   =	mysql_real_escape_string(trim($remark));
		$order_date			=	mysql_real_escape_string(trim($order_date));
		$target_date	=	mysql_real_escape_string(trim($target_date));



		
		
		//satement to insert in orders table
		$insert		=   "INSERT INTO rozelle_orders
						(design_no,book_no, party_name, brokar, retahol, form,quantity,colour,payment_qty,
						priority,status,remark,order_date,target_date,added_on)
							
						VALUES
						('$design_no','$book_no', '$party_name', '$brokar', '$retahol','$form', 
							'$quantity','$colour','$payment_qty','$priority','$status','$remark','$order_date','$target_date', now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$orders_id	= mysql_insert_id();
		
		//return primary key
		return $orders_id;

	}//eof
		
	
	/**
	*	Add a new orders in order_image table.
	*
	*	@param
	*			$product_id			Id of the product
	*			$title				Title of the image
	*			$image				image file name
	*
	*	@return int
	*/
	function addOrderImgRozelle($orders_id, $design_no, $image)
	{
		$orders_id		=	mysql_real_escape_string(trim($orders_id));
		$design_no			=	mysql_real_escape_string(trim($design_no));
		$image			=	mysql_real_escape_string(trim($image));
	
		
		//satement to insert in product table
		$insert		=   "INSERT INTO rozelle_order_image
						(orders_id, design_no, image, added_on)
						VALUES
						('$orders_id', '$design_no', '$image', now())
						";
						
		//execute quary
		$query		= mysql_query($insert);

		//get the product id
		$product_image_id	= mysql_insert_id();
		
		//return primary key
		return $order_image_id;

	}//eof
	

	
	
	function addRozOrderDtl($orders_id,$design_no,$book_no,$party_code,$quantity,$due_quantity,$pay_quantity, $colour
	,$order_date,$target_date,$priority,$remark)
	
	{
		$orders_id			   =	mysql_real_escape_string(trim($orders_id));
		$design_no	        =	trim($design_no);
		$book_no			   =	mysql_real_escape_string(trim($book_no));
		$party_code			   =	mysql_real_escape_string(trim($party_code));
		$quantity			   =	mysql_real_escape_string(trim($quantity));
		$due_quantity			   =	mysql_real_escape_string(trim($due_quantity));
		$pay_quantity			   =	mysql_real_escape_string(trim($pay_quantity));
		$colour		     =	mysql_real_escape_string(trim($colour));	
		
		$order_date			   =	mysql_real_escape_string(trim($order_date));
		$target_date			   =	mysql_real_escape_string(trim($target_date));
		$priority		     =	mysql_real_escape_string(trim($priority));
		$remark		   =	mysql_real_escape_string(trim($remark));	
		//satement to insert in orders table
		$insert		=   "INSERT INTO rozelle_order_dtl
						(orders_id,design_no,book_no,party_code,quantity,due_quantity,pay_quantity,colour,order_date,target_date,priority,remark)
							
						VALUES
						('$orders_id','$design_no','$book_no','$party_code','$quantity','$due_quantity','$pay_quantity',
						'$colour','$order_date','$target_date','$priority','$remark')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$rorder_dtl_id	= mysql_insert_id();
		
		//return primary key
		return $rorder_dtl_id;

	}//eof	
		
	
	#####################################################################################################
	#
	#										Edit Orders
	#
	#####################################################################################################
	
	
	/**
	*	This function edit orders
	*
	*	@param
	*			$orders_id			    orders_id	
	*			$design_no				Design no of  products
	*			$party_name			    Party name
	*			$brokar					Brokar
	*			$retahol				Reta Hol
	*			$form				    Order Address
	*			$quantity			    Number of products
	*			$colour     		    Orders products colour
	*			$remark					Remark
	*			$order_date				order date
	*			$target_date		    Target Date
	*		
	*			
	*	@return null
	*/
	function editRozelleOrders($orders_id,$design_no, $party_name,$brokar, $retahol, $form, $quantity, $colour,$payment_qty,$remark,$order_date, $target_date)
	
	{
		$orders_id			   =	mysql_real_escape_string(trim($orders_id));
		$design_no	        =	trim($design_no);
		$book_no			   = mysql_real_escape_string(trim($book_no));
		$party_name			   = mysql_real_escape_string(trim($party_name));
		$brokar			   =	mysql_real_escape_string(trim($brokar));
		$retahol		  =	mysql_real_escape_string(trim($retahol));
		$form			 =	mysql_real_escape_string(trim($form));
		$quantity			   =	mysql_real_escape_string(trim($quantity));
		$colour		     =	mysql_real_escape_string(trim($colour));
		$payment_qty		     =	mysql_real_escape_string(trim($payment_qty));
		$remark		   =	mysql_real_escape_string(trim($remark));
		$order_date			=	mysql_real_escape_string(trim($order_date));
		$target_date	=	mysql_real_escape_string(trim($target_date));

		//update product description
		$edit  = "UPDATE rozelle_orders
				SET
				design_no		 		= '$design_no',
				book_no		 		= '$book_no',
				party_name			= '$party_name',
				brokar				= '$brokar',
				retahol 				= '$retahol',
				form			    = '$form',
				quantity				= '$quantity',
				colour				= '$colour',
				payment_qty				= '$payment_qty',
				remark			= '$remark',
				order_date			= '$order_date',
				target_date			= '$target_date'
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	// update rozelle orders
	function UpdateRozOrders($orders_id, $status)
	
	{
		$orders_id			   	   =	mysql_real_escape_string(trim($orders_id));
		$status			  		   = mysql_real_escape_string(trim($status));
		

		//update product description
		$edit  = "UPDATE rozelle_orders
				SET
				status		 		= '$status',
				modified_on			= now()
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	// update rozelle orders deails
	function UpdateRozelleOrders($rorder_dtl_id, $due_quantity,$pay_quantity)
	
	{
		$rorder_dtl_id			   	   =	mysql_real_escape_string(trim($rorder_dtl_id));
		$due_quantity	        	   =	trim($due_quantity);
		$pay_quantity			   = mysql_real_escape_string(trim($pay_quantity));
		

		//update product description
		$edit  = "UPDATE rozelle_order_dtl
				SET
				due_quantity		 		= '$due_quantity',
				pay_quantity			= '$pay_quantity'
				WHERE
				rorder_dtl_id 			= '$rorder_dtl_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	// update rozelle orders deails for order cancel
	function UpdateRozOrderDetails($orders_id)
	
	{
		$orders_id			   	   =	mysql_real_escape_string(trim($orders_id));
		

		//update product description
		$edit  = "UPDATE rozelle_order_dtl
				SET
				due_quantity		 		= 0
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	// update rozelle orders remark 
	function UpdateRozOrderRemarks($orders_id,$remark)
	
	{
		$remark			   	   =	mysql_real_escape_string(trim($remark));
		

		//update product description
		$edit  = "UPDATE rozelle_orders
				SET
				remark		 		= '$remark'
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										Delete ORDERS
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a order permanently
	*
	*	@param
	*			$oid			orders_id
	*
	*	@return null
	*/
	function delRozOrd($oid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM rozelle_orders WHERE orders_id='$oid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	function delRozOrdDetaills($oid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM rozelle_order_dtl WHERE orders_id='$oid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
		

	/*
	*	This funcion will return all the orders id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllRozOrd($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT orders_id FROM rozelle_orders";
		}
		else
		{
			//statement
			$select	= "SELECT orders_id FROM rozelle_orders
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['orders_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a orders based upon the primary key
	*
	*	@param
	*			$oid		orders id
	*
	*	@return array				
	*/
	function showRozelleOrders($oid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM rozelle_orders
				   WHERE orders_id	= '$oid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->orders_id,					//0
					$result->design_no,							//1
					$result->party_name,					//2
					$result->brokar,						//3
					$result->retahol,				//4
					$result->form,					//5
					$result->quantity,		//6
					$result->colour,				//7
					$result->remark,					//8
					$result->order_date,						//9
					$result->target_date,						//10
					$result->added_on,						//11
					$result->modified_on,					//12
					$result->payment_qty,					//13
					$result->book_no,					//14
					$result->priority,					//15
					$result->status					//16
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	 public function RozordersShow(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM rozelle_orders") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }
	
	
	
	
	
	 public function RozordersDtlDisp($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM rozelle_order_dtl where orders_id='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }
	 
	
	
	public function RozDeliverDtl(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM rozelle_order_dtl ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
	// echo $res.mysql_error();exit;
     return $temp_arr;  
     }
	
	
	
	/*=============Same Design count quantity wise=================*/
	 public function RozTotalQuantitySum($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( due_quantity ) AS `count_quantity` FROM `rozelle_order_dtl` where orders_id ='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     }
	 
	 
	 /*=============Same Design count quantity wise=================*/
	 public function RozQuantitySum($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `count_quantity` FROM `rozelle_order_dtl` where orders_id ='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     }
	 
	 
	 
	 
	 /*=============Same Design count pay quantity wise=================*/
	 public function RozTotalPayQtySum($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( pay_quantity ) AS `count_quantity` FROM `rozelle_order_dtl` where orders_id ='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     }
	
	
	/* Display all data */
	/*
		$pid= orders_id 
	*/
	
	 public function RozordersDisplay($pid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM rozelle_orders where orders_id='$oid' LIMIT 1") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
/*############################################################   Rozelle  Deliver Details  ################################*/

function addRozOrderDeliver($orders_id,$book_no,$design_no,$party_name,$form,$quantity, $colour,$description,$added_by)
	
	{
		$orders_id			 =	mysql_real_escape_string(trim($orders_id));
		$book_no	         =	trim($book_no);
		$design_no			 =	mysql_real_escape_string(trim($design_no));
		$party_name		     =	mysql_real_escape_string(trim($party_name));
		$form		     	 =	mysql_real_escape_string(trim($form));
		$quantity			 =	mysql_real_escape_string(trim($quantity));
		$colour		     	 =	mysql_real_escape_string(trim($colour));
		$description		 =	mysql_real_escape_string(trim($description));
		$added_by		     =	mysql_real_escape_string(trim($added_by));	
		//satement to insert in orders table
		$insert		=   "INSERT INTO rozelle_ord_deliver
						(orders_id,book_no,design_no,party_name,form,quantity,colour,description,added_on,added_by)
							
						VALUES
						('$orders_id','$book_no','$design_no','$party_name','$form','$quantity','$colour','$description',now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$deliver_id	= mysql_insert_id();
		
		//return primary key
		return $deliver_id;

	}//eof	
		
 	 public function RozordersDeliverDtl($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM rozelle_ord_deliver where orders_id='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	

/*####################################################################################################################*/
	
	/*                           Rozelle orders  search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search Rozelle orders keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getRozelleOrderKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT orders_id FROM rozelle_orders ";
		}
		else
		{
			$sql = "SELECT orders_id
					FROM   rozelle_orders
					WHERE (orders_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   party_name LIKE '%$keyword%' OR
						   book_no LIKE '%$keyword%' OR
						   brokar LIKE '%$keyword%' OR
						   retahol LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' OR
						    form LIKE '%$keyword%' OR
							status LIKE '%$keyword%' OR
						   order_date LIKE '%$keyword%' OR
						   target_date LIKE '%$keyword%'
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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

	
	/*==============================================Rozelle order cancel==============================================*/
	
		function addRozOrderCancel($orders_id,$design_no,$reason,$comment)
	
	{
		$orders_id			   =	mysql_real_escape_string(trim($orders_id));
		$design_no	        =	trim($design_no);
		$reason			   =	mysql_real_escape_string(trim($reason));
		$comment			   =	mysql_real_escape_string(trim($comment));	
		//satement to insert in orders cancel table
		$insert		=   "INSERT INTO roz_order_cancel
						(orders_id,design_no,reason,comment,added_on)
							
						VALUES
						('$orders_id','$design_no','$reason','$comment',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$cancel_id	= mysql_insert_id();
		
		//return primary key
		return $cancel_id;

	}//eof	
	
	
 /* sum of Due Rozelle order        */
	/*
		
	*/
	
	 public function DueRozelleOrder(){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( due_quantity ) AS `count_due` FROM `rozelle_order_dtl` where order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()
	 ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_due'];
     }
     return $temp_arr;  
     }
	
	 
	 
}//eoc	 