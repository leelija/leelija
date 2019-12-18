<?php 
/**
*	This class is going to work with all product orders associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Jan 11, 2017
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/

class Productorders 
{

	#####################################################################################################
	#
	#										Add Product Orders
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
	function addProductOrders($design_no,$book_no, $party_name,$brokar, $retahol, $form, $quantity, $colour, $payment_qty,
	$priority,$status, $remark,$factory_id,$order_date, $target_date)
	
	{
		//$orders_id			   	=	mysql_real_escape_string(trim($orders_id));
		$design_no	        		=	trim($design_no);
		$book_no			   		= mysql_real_escape_string(trim($book_no));
		$party_name			   		= mysql_real_escape_string(trim($party_name));
		$brokar			   			=	mysql_real_escape_string(trim($brokar));
		$retahol		  			=	mysql_real_escape_string(trim($retahol));
		$form			 			=	mysql_real_escape_string(trim($form));
		$quantity			   		=	mysql_real_escape_string(trim($quantity));
		$colour		     			=	mysql_real_escape_string(trim($colour));
		$payment_qty		     	=	mysql_real_escape_string(trim($payment_qty));
		
		$priority		     		=	mysql_real_escape_string(trim($priority));
		$status		     			=	mysql_real_escape_string(trim($status));
		$remark		   				=	mysql_real_escape_string(trim($remark));
		$factory_id		   			=	mysql_real_escape_string(trim($factory_id));
		$order_date					=	mysql_real_escape_string(trim($order_date));
		$target_date				=	mysql_real_escape_string(trim($target_date));

		//satement to insert in product orders table
		$insert		=   "INSERT INTO product_orders
						(design_no,book_no, party_name, brokar, retahol, form,quantity,colour,payment_qty,
						priority,status,remark,factory_id,order_date,target_date,added_on)
							
						VALUES
						('$design_no','$book_no', '$party_name', '$brokar', '$retahol','$form', 
						'$quantity','$colour','$payment_qty','$priority','$status','$remark','$factory_id','$order_date','$target_date', now())
							
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
	
	function addProdOrderDtl($orders_id,$design_no,$book_no,$party_code,$quantity,$due_quantity,$pay_quantity, $colour
	,$factory_id,$order_date,$target_date,$priority,$remark)
	{
		$orders_id			   	=	mysql_real_escape_string(trim($orders_id));
		$design_no	        	=	trim($design_no);
		$book_no			   	=	mysql_real_escape_string(trim($book_no));
		$party_code			   	=	mysql_real_escape_string(trim($party_code));
		$quantity			   	=	mysql_real_escape_string(trim($quantity));
		$due_quantity			=	mysql_real_escape_string(trim($due_quantity));
		$pay_quantity			=	mysql_real_escape_string(trim($pay_quantity));
		$colour		     		=	mysql_real_escape_string(trim($colour));	
		$factory_id		     	=	mysql_real_escape_string(trim($factory_id));
		$order_date			   	=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$priority		     	=	mysql_real_escape_string(trim($priority));
		$remark		   			=	mysql_real_escape_string(trim($remark));	
		//satement to insert in orders table
		$insert		=   "INSERT INTO product_order_dtl
						(orders_id,design_no,book_no,party_code,quantity,due_quantity,pay_quantity,colour,factory_id,order_date,target_date,priority,remark)
							
						VALUES
						('$orders_id','$design_no','$book_no','$party_code','$quantity','$due_quantity','$pay_quantity',
						'$colour','$factory_id','$order_date','$target_date','$priority','$remark')
							
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
		$orders_id			   	=	mysql_real_escape_string(trim($orders_id));
		$design_no	        	=	trim($design_no);
		$book_no			   	= mysql_real_escape_string(trim($book_no));
		$party_name			   	= mysql_real_escape_string(trim($party_name));
		$brokar			   		=	mysql_real_escape_string(trim($brokar));
		$retahol		  		=	mysql_real_escape_string(trim($retahol));
		$form			 		=	mysql_real_escape_string(trim($form));
		$quantity			   	=	mysql_real_escape_string(trim($quantity));
		$colour		     		=	mysql_real_escape_string(trim($colour));
		$payment_qty		     =	mysql_real_escape_string(trim($payment_qty));
		$remark		   			=	mysql_real_escape_string(trim($remark));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));

		//update product description
		$edit  = "UPDATE rozelle_orders
				SET
				design_no		 		= '$design_no',
				book_no		 			= '$book_no',
				party_name				= '$party_name',
				brokar					= '$brokar',
				retahol 				= '$retahol',
				form			    	= '$form',
				quantity				= '$quantity',
				colour					= '$colour',
				payment_qty				= '$payment_qty',
				remark					= '$remark',
				order_date				= '$order_date',
				target_date				= '$target_date'
				WHERE
				orders_id 				= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	// update Product orders
	function UpdateProdOrders($orders_id, $status)
	{
		$orders_id			   	   = mysql_real_escape_string(trim($orders_id));
		$status			  		   = mysql_real_escape_string(trim($status));
		//update product description
		$edit  = "UPDATE product_orders
				SET
				status		 		= '$status',
				modified_on			= now()
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	// Add Product orders Rate
	function addProdOrdersRate($orders_id, $pprice)
	{
		$orders_id			   	   = mysql_real_escape_string(trim($orders_id));
		$pprice			  		   = mysql_real_escape_string(trim($pprice));
		//update product description
		$edit  = "UPDATE product_orders
				SET
				pprice		 		= '$pprice',
				modified_on			= now()
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	// update product orders details
	function UpdateProdOrdersDtls($porder_dtl_id, $due_quantity,$pay_quantity)
	{
		$porder_dtl_id			   	   	=	mysql_real_escape_string(trim($porder_dtl_id));
		$due_quantity	        	   	=	trim($due_quantity);
		$pay_quantity			   		=   mysql_real_escape_string(trim($pay_quantity));
		//update product order details
		$edit  = "UPDATE product_order_dtl
				SET
				due_quantity		 		= '$due_quantity',
				pay_quantity				= '$pay_quantity'
				WHERE
				porder_dtl_id 				= '$porder_dtl_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	
	
	
	// update rozelle orders deails for order cancel
	function UpdateProdOrderDetails($orders_id,$status)
	{
		$orders_id			   	   	=	mysql_real_escape_string(trim($orders_id));
		$status			   	   		=	mysql_real_escape_string(trim($status));
		//update product description
		$edit  = "UPDATE product_order_dtl
				SET
				due_quantity		 		= 0,
				status		 				= '$status'
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	// update rozelle orders remark 
	function UpdateProdOrderRemarks($orders_id,$remark)
	{
		$remark			   	   =	mysql_real_escape_string(trim($remark));
		//update product description
		$edit  = "UPDATE product_orders
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
	
	#####################################################################################################
	#
	#										Product ORDERS Display
	#
	#####################################################################################################
			

	/*
	*	This funcion will return all the orders id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllProdOrds($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT orders_id FROM product_orders";
		}
		else
		{
			//statement
			$select	= "SELECT orders_id FROM product_orders
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
	function showProdOrders($oid)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM product_orders
				   WHERE orders_id	= '$oid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->orders_id,					//0
					$result->design_no,					//1
					$result->party_name,				//2
					$result->brokar,					//3
					$result->retahol,					//4
					$result->form,						//5
					$result->quantity,					//6
					$result->colour,					//7
					$result->remark,					//8
					$result->order_date,				//9
					$result->target_date,				//10
					$result->added_on,					//11
					$result->modified_on,				//12
					$result->payment_qty,				//13
					$result->book_no,					//14
					$result->priority,					//15
					$result->status						//16
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	 public function ProdordersShow(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_orders order by orders_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }
	//last two month order show 
	 public function ProdordersShowLastTwoMonth(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_orders Where order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()order by orders_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }
	  public function getProOrdBookWise($design_no,$book_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_orders where design_no = '$design_no' AND book_no = '$book_no' order by orders_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }
	 //Order show party wise
	 public function getPartyWise($party_name){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_orders where party_name = '$party_name' order by orders_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	
	//Factory wise order details
	public function getFacWiseOrdDtls($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_orders where factory_id = '$factory_id'
	 AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }
	
	
	#####################################################################################################
	#
	#										Update Order details
	#
	#####################################################################################################
	
	//Update order colour Details
	function UpdateOrdeColor($porder_dtl_id,$colour,$quantity,$due_quantity)
	{
		$colour			   	   =	mysql_real_escape_string(trim($colour));
		$quantity			   =	mysql_real_escape_string(trim($quantity));
		$due_quantity		   =	mysql_real_escape_string(trim($due_quantity));
		//update product description
		$edit  = "UPDATE product_order_dtl
				SET
				colour		 		= '$colour',
				quantity		 	= '$quantity',
				due_quantity		= '$due_quantity'
				WHERE
				porder_dtl_id 		= '$porder_dtl_id'
				";	
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	
	//Update order colour Details
	function UpdateOrdeColorCancel($porder_dtl_id,$quantity,$due_quantity)
	{
		$quantity			   	   =	mysql_real_escape_string(trim($quantity));
		$due_quantity			   =	mysql_real_escape_string(trim($due_quantity));
		//update product description
		$edit  = "UPDATE product_order_dtl
				SET
				quantity		 		= '$quantity',
				due_quantity		 	= '$due_quantity'
				WHERE
				porder_dtl_id 		= '$porder_dtl_id'
				";	
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										Display Order details
	#
	#####################################################################################################
	
	/**
	*	Get the data associated with a Product order details based upon the primary key
	*
	*	@param
	*			$porder_dtl_id		Order Details
	*
	*	@return array				
	*/
	function getAllOrderDtls($porder_dtl_id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM product_order_dtl
				   WHERE porder_dtl_id	= '$porder_dtl_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->porder_dtl_id,		//0
					$result->orders_id,			//1
					$result->book_no,			//2
					$result->party_code,		//3
					$result->design_no,			//4
					$result->quantity,			//5
					$result->due_quantity,		//6
					$result->pay_quantity,		//7
					$result->colour,			//8
					$result->order_date,		//9
					$result->target_date,		//10
					$result->priority,			//11
					$result->remark				//12
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	/**
	*	Get the data associated with a Product order details based upon the primary key
	*
	*	@param
	*			$oid		orders id
	*			$colour		Product colour
	*
	*	@return array				
	*/
	function showProdOrdDetlColorWise($oid,$colour)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM product_order_dtl
				   WHERE orders_id	= '$oid' AND colour = '$colour'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->porder_dtl_id,		//0
					$result->orders_id,			//1
					$result->book_no,			//2
					$result->party_code,		//3
					$result->design_no,			//4
					$result->quantity,			//5
					$result->due_quantity,		//6
					$result->pay_quantity,		//7
					$result->colour,			//8
					$result->order_date,		//9
					$result->target_date,		//10
					$result->priority,			//11
					$result->remark				//12
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	// Display Due Order Details
	 public function getDueOrd($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_order_dtl where design_no = '$design_no' AND due_quantity != '0'
	 AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() order by order_date desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }
	// Book No. Status Check
	 public function getBookNoStatus($book_no){
	 $temp_arr = array();
     $res = mysql_query("SELECT due_quantity , pay_quantity , party_code, design_no, colour FROM product_order_dtl where book_no = '$book_no' AND status != 'cancel'
	 ORDER BY factory_id ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    //echo $res.mysql_error();exit;
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }   
	 
	// Display Due Order Details group by Design No
	 public function getDueOrdDesignWise($party_code){
	 $temp_arr = array();
     $res = mysql_query("SELECT SUM(due_quantity) ,design_no, book_no, order_date FROM product_order_dtl where party_code = '$party_code' AND due_quantity != '0' AND status != 'cancel'
	 group by design_no ORDER BY book_no ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    //echo $res.mysql_error();exit;
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }  
	 
	 //Party wise Due order count
	public function countPartyDueOrd($party_code,$factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( due_quantity ) AS `due_quantity` FROM `product_order_dtl` where party_code ='$party_code'
	 AND status != 'cancel' AND factory_id ='$factory_id' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['due_quantity'];
     }
     return $temp_arr;  
     } 
	 
	// Display Due Order Details group by colour
	 public function getDueOrdColourWise($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(due_quantity),colour FROM product_order_dtl where design_no = '$design_no' 
	 AND due_quantity != '0' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() group by colour") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	 
	 //last two moth Due order display 
	public function lTwoDueMothOrd($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( due_quantity ) AS `due_quantity` FROM `product_order_dtl` where design_no ='$design_no'
	 AND status != 'cancel' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['due_quantity'];
     }
     return $temp_arr;  
     } 
	 
	 //last two moth Due order display 
	public function dMonthsDueOrd($design_no,$months){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( due_quantity ) AS `due_quantity` FROM `product_order_dtl` where design_no ='$design_no'
	 AND status != 'cancel' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL '$months' MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['due_quantity'];
     }
     return $temp_arr;  
     } 
	//last two moth order display 
	public function lTwoMothOrd($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `quantity` FROM `product_order_dtl` where design_no ='$design_no'
	 AND status != 'cancel' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['quantity'];
     }
     return $temp_arr;  
     } 
	
	//Last Two Month top Order product
	public function getTwoMOnthDwOrder($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(due_quantity),design_no FROM product_order_dtl 
	 WHERE design_no ='$design_no'
	 AND status != 'cancel' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() group by design_no 
	 order by SUM(due_quantity) ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	
	//last two moth order display 
	public function dMothsOrd($design_no,$months){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `quantity` FROM `product_order_dtl` where design_no ='$design_no'
	 AND status != 'cancel' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL '$months' MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['quantity'];
     }
     return $temp_arr;  
     } 
	
	//Total order display 
	public function tltMothOrd($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `quantity` FROM `product_order_dtl` where design_no ='$design_no'
	 AND status != 'cancel' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['quantity'];
     }
     return $temp_arr;  
     } 
	
	// Order Details
	 public function ProdordersDtlDisp($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_order_dtl where orders_id='$oid'") or die(mysql_error());        
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
	 public function ProdTotalQuantitySum($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( due_quantity ) AS `count_quantity` FROM `product_order_dtl` where orders_id ='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     }
	 
	/*==============================*/
	/* Total due Design Count
	*//*===============================*/
	 public function dueOrdCount($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( due_quantity ) AS `count_quantity` FROM `product_order_dtl` 
	 where design_no ='$design_no' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() ORDER BY order_date ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     } 
	 /*=============Same Design count quantity wise=================*/
	 public function ProdQuantitySum($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `count_quantity` FROM `product_order_dtl` where orders_id ='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     }
	 
	//Last Two Month top Order product
	public function getTwoMOnthOrder(){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(due_quantity),design_no FROM product_order_dtl 
	 WHERE order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() group by design_no 
	 order by SUM(due_quantity) DESC limit 100") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	 //Last Two Month top Order product Factory wise
	public function getTwoMOnthOrderFact($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(quantity),design_no FROM product_order_dtl 
	 WHERE factory_id = '$factory_id' AND status != 'cancel' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() group by design_no 
	 order by SUM(quantity) DESC limit 100") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	 
	 //top Order product Factory wise
	public function getDMonthOrderFact($factory_id, $months){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(quantity),design_no FROM product_order_dtl 
	 WHERE factory_id = '$factory_id' AND status != 'cancel' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL '$months' MONTH) AND NOW() group by design_no 
	 order by SUM(quantity) DESC limit 100") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	 /*=============Same Design count pay quantity wise=================*/
	 public function ProdTotalPayQtySum($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( pay_quantity ) AS `count_quantity` FROM `product_order_dtl` where orders_id ='$oid'") or die(mysql_error());        
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
/*############################################################     Product Order Deliver Details  ################################*/

function addProdOrderDeliver($orders_id,$book_no,$design_no,$party_name,$form,$quantity, $colour,$description,$added_by)
	
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
		//satement to insert in orders deliver table
		$insert		=   "INSERT INTO product_ord_deliver
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
		
 	 public function prodOrdDeliverDtl($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_ord_deliver where orders_id='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	

/*####################################################################################################################*/
	
	/*                           Products orders  search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search Product orders keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProdOrdsKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT orders_id FROM product_orders ";
		}
		else
		{
			$sql = "SELECT orders_id
					FROM   product_orders
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

	
	/*==============================================Products order cancel==============================================*/
	
		function addProdOrderCancel($orders_id,$design_no,$reason,$comment)
	
	{
		$orders_id			   	=	mysql_real_escape_string(trim($orders_id));
		$design_no	        	=	trim($design_no);
		$reason			   		=	mysql_real_escape_string(trim($reason));
		$comment			   	=	mysql_real_escape_string(trim($comment));	
		//satement to insert in orders cancel table
		$insert		=   "INSERT INTO product_order_cancel
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