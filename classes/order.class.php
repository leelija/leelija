<?php 
/**
*	This class is going to work with all orders associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Feb 10, 2015
*	@version	1.0
*	@copyright	MIS
*	@url		http://monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/




class Orders 
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
	function addOrders($design_no, $party_name,$brokar, $retahol, $form, $quantity, $colour,$remark,$order_date, 
	$target_date,$factory_id,$added_by)
	
	{
		//$orders_id			=	mysql_real_escape_string(trim($orders_id));
		$design_no	        	=	trim($design_no);
		$party_name			   	= mysql_real_escape_string(trim($party_name));
		$brokar			   		=	mysql_real_escape_string(trim($brokar));
		$retahol		  		=	mysql_real_escape_string(trim($retahol));
		$form			 		=	mysql_real_escape_string(trim($form));
		$quantity			   	=	mysql_real_escape_string(trim($quantity));
		$colour		     		=	mysql_real_escape_string(trim($colour));
		$remark		   			=	mysql_real_escape_string(trim($remark));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$factory_id				=	mysql_real_escape_string(trim($factory_id));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		//satement to insert in orders table
		$insert		=   "INSERT INTO orders
						(design_no, party_name, brokar, retahol, form,quantity,colour,remark,order_date,target_date,factory_id,
						added_on,added_by)
							
						VALUES
						('$design_no', '$party_name', '$brokar', '$retahol','$form', 
							'$quantity','$colour','$remark','$order_date','$target_date','$factory_id', now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$orders_id	= mysql_insert_id();
		
		//return primary key
		return $orders_id;

	}//eof
		
	function addOrdersDetails($orders_id,$design_no,$quantity, $colour)
	
	{
		$orders_id		=	mysql_real_escape_string(trim($orders_id));
		$design_no	    =	trim($design_no);
		$quantity		=	mysql_real_escape_string(trim($quantity));
		$colour		    =	mysql_real_escape_string(trim($colour));	
		//satement to insert in orders table
		$insert		=   "INSERT INTO orders_details
						(orders_id,design_no,quantity,colour)
							
						VALUES
						('$orders_id','$design_no','$quantity','$colour')
							
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$order_dtl_id	= mysql_insert_id();
		
		//return primary key
		return $order_dtl_id;

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
	function addOrderImg($orders_id, $design_no, $image)
	{
		$orders_id		=	mysql_real_escape_string(trim($orders_id));
		$design_no		=	mysql_real_escape_string(trim($design_no));
		$image			=	mysql_real_escape_string(trim($image));
	
		//satement to insert in product table
		$insert		=   "INSERT INTO order_image
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
	function editOrders($orders_id,$design_no, $party_name, $form,$remark, $order_date, $target_date,$modified_by)
	
	{
		$orders_id			   	=	mysql_real_escape_string(trim($orders_id));
		$design_no	        	=	trim($design_no);
		$party_name			   	=   mysql_real_escape_string(trim($party_name));
		$form			 		=	mysql_real_escape_string(trim($form));
		$remark					=	mysql_real_escape_string(trim($remark));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));
		//update product description
		$edit  = "UPDATE orders
				SET
				design_no		 	= '$design_no',
				party_name			= '$party_name',
				form			    = '$form',
				remark				= '$remark',
				order_date			= '$order_date',
				target_date			= '$target_date',
				modified_by			= '$modified_by',
				modified_on			= now()
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	/*=======quantity field edit in table orders========*/
	function editOrdersquantity($orders_id,$quantity)
	
	{
		//echo $quantity;exit;	
		$orders_id			   =	mysql_real_escape_string(trim($orders_id));
		$quantity			   =	mysql_real_escape_string(trim($quantity));
		
		//update product description
		$edit  = "UPDATE orders
				SET
				quantity				= '$quantity'
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	// edit order submit date
	function editOrderSubmit($order_id)
	
	{
		//echo $order_id;exit;	
		$order_id			   =	mysql_real_escape_string(trim($order_id));
		
		//update order submit date
		$edit  = "UPDATE orders
				SET
				submit_date				= now()
				WHERE
				orders_id 			= '$order_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	// edit order submit date
	function editOrderSubmitmod($order_id,$subdate)
	
	{
		//echo $order_id;exit;	
		$order_id			   =	mysql_real_escape_string(trim($order_id));
		$subdate			   =	mysql_real_escape_string(trim($subdate));
		//update order submit date
		$edit  = "UPDATE orders
				SET
				submit_date				= '$subdate'
				WHERE
				orders_id 			= '$order_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	

	/*=======Orders Details Edit========*/
	
	function editOrdersDtl($order_dtl_id,$quantity,$colour)
	
	{
		//echo $quantity;exit;	
		$quantity			   =	mysql_real_escape_string(trim($quantity));
		$colour			   	   =	mysql_real_escape_string(trim($colour));
		
		//update product description
		$edit  = "UPDATE orders_details
				SET
				quantity				= '$quantity',
				colour				    = '$colour'
				WHERE
				order_dtl_id 			= '$order_dtl_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	/*=======Orders Details Edit 11.10.15  ========*/
	function editOrdersDetails($orders_id,$design_no)
	{
		//echo $quantity;exit;	
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		
		//update product description
		$edit  = "UPDATE orders_details
				SET
				design_no				= '$design_no'
				WHERE
				orders_id 			= '$orders_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	/*=======          Update Orders Details ========*/
	/*
	*  Update date 20.01.2017
	*/
	function updateOrdDtls($orders_id,$colour, $ready_quantity,$field)
	
	{
		//echo $quantity;exit;	
		$orders_id			   	=	mysql_real_escape_string(trim($orders_id));
		$colour			   		=	mysql_real_escape_string(trim($colour));
		$ready_quantity			=	mysql_real_escape_string(trim($ready_quantity));
		$field					=	mysql_real_escape_string(trim($field));
		//update product description
		$edit  = "UPDATE orders_details
				SET
				".$field."			= '$ready_quantity'
				WHERE
				orders_id 			= '$orders_id' AND
				colour 				= '$colour'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	// Cancel Order
	function cancelOrder($orders_id,$remark,$cancel_by)
	{
		//echo $quantity;exit;	
		$orders_id			   	=	mysql_real_escape_string(trim($orders_id));
		$remark			   		=	mysql_real_escape_string(trim($remark));
		$cancel_by			   	=	mysql_real_escape_string(trim($cancel_by));
		//update product description
		$edit  = "UPDATE orders
				SET
				remark						= '$remark',
				order_status				= 'Cancel',
				cancel_by					= '$cancel_by',
				cancel_date					= now()
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
	function delOrd($oid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM orders WHERE orders_id='$oid'";
		
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
	function getAllOrd($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT orders_id FROM orders Where added_on BETWEEN DATE_SUB(NOW(), INTERVAL 6 MONTH) AND NOW()order by orders_id desc";
		}
		else
		{
			//statement
			$select	= "SELECT orders_id FROM orders Where added_on BETWEEN DATE_SUB(NOW(), INTERVAL 6 MONTH) AND NOW()
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
	
	/*
	*	This funcion will return all the orders id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllLSTOrd($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT orders_id FROM orders limit 10";
		}
		else
		{
			//statement
			$select	= "SELECT orders_id FROM orders
					   ORDER BY ".$orderby." ".$orderbyType." limit 10";
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
	function showOrders($oid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM orders
				   WHERE orders_id	= '$oid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->orders_id,			//0
					$result->design_no,			//1
					$result->party_name,		//2
					$result->brokar,			//3
					$result->retahol,			//4
					$result->form,				//5
					$result->quantity,			//6
					$result->colour,			//7
					$result->remark,			//8
					$result->order_date,		//9
					$result->target_date,		//10
					$result->added_on,			//11
					$result->modified_on,		//12
					$result->submit_date,		//13
					$result->factory_id,		//14
					$result->order_status,		//15
					$result->cancel_by,			//16
					$result->cancel_date		//17
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
/*Order Details*/
	function showOrdersDetails($oid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM orders_details
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
					$result->quantity,					//2
					$result->colour,					//3
					$result->order_dtl_id,				//4
					$result->ready_quantity	,			//5
					$result->hand_rquantity,		//6
					$result->manual_rquantity,		//7
					$result->comp_rquantity,		//8
					$result->kali_rquantity,		//9
					$result->fs_rquantity,			//10
					$result->iron_rquantity	,		//11
					$result->packing_rquantity		//12
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	
	/*Order Details*/
	function getOrdersDetails($oid_dtl_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM orders_details
				   WHERE order_dtl_id	= '$oid_dtl_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->orders_id,					//0
					$result->design_no,					//1
					$result->quantity,					//2
					$result->colour,					//3
					$result->order_dtl_id,				//4
					$result->ready_quantity	,			//5
					$result->hand_rquantity,		//6
					$result->manual_rquantity,		//7
					$result->comp_rquantity,		//8
					$result->kali_rquantity,		//9
					$result->fs_rquantity,			//10
					$result->iron_rquantity	,		//11
					$result->packing_rquantity		//12
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	 // Order Details Display
	/*	
	*	$oid 	= 			Order Id
	*   $color	= 			product color	
	*/	
	function ordDtlsShow($oid,$color)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM orders_details
				   WHERE orders_id	= '$oid' AND colour = '$color'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->orders_id,					//0
					$result->design_no,					//1
					$result->quantity,					//2
					$result->colour,					//3
					$result->order_dtl_id,				//4
					$result->ready_quantity	,			//5
					$result->hand_rquantity,		//6
					$result->manual_rquantity,		//7
					$result->comp_rquantity,		//8
					$result->kali_rquantity,		//9
					$result->fs_rquantity,			//10
					$result->iron_rquantity	,		//11
					$result->packing_rquantity		//12
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	// Order display factory wise
	/*	
	*	factory_id 	= Factory Id
	*/	
	 public function getOrdFactWise($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM orders where factory_id='$factory_id' AND submit_date = '0000-00-00'
	 AND order_status != 'Cancel'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Daily Order Report display factory wise
	/*	
	*	factory_id 	= Factory Id
	*/	
	 public function getOrdFactDailyRpt($factory_id,$todate){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM orders where factory_id='$factory_id' AND added_on = '$todate'
	 AND order_status != 'Cancel'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	// Order Details Display order id wise
	/*	
	*	oid 	= 			Order Id
	*/	
	 public function ordersDtlDisplay($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM orders_details where orders_id='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	// count total PipeLine Quantity order orderIdwise
	 public function getOrderQuantitycount($orders_id){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(quantity),SUM(ready_quantity) FROM orders_details where orders_id = '$orders_id' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }  
	 
	 
	 
	 /**
	*	This function will delete a order Details permanently
	*
	*	@param
	*			$odtlid			orders details id
	*
	*	@return null
	*/
	function delOrdDetails($odtlid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM orders_details WHERE order_dtl_id='$odtlid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	 
	
	/*=============Same Design count=================*/
	 public function TotalQuantitySum($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `count_quantity` FROM `orders_details` where orders_id ='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     }
	
	// Same design quantity count
	 public function getSameDes($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(quantity)FROM orders_details where orders_id = '$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
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
	 
	
	
	
	
	
	
	/**
	* Added on 15 th december 2014 
	*	Get the data associated with a product based upon the categories id
	*
	*	@param
	*			$cat_id		Categories id
	*
	*	@return array				
	*/
	
	
	 public function showProductDisplay($cat_id){
     $temp_arr = array();
     $res = mysql_query("SELECT `product_image`.`image`,`product`.`title`,`product`.`seo_url`,`product`.`ruppes`, 
	 				`product`.`product_id`,`product`.`description`
					FROM product,product_image
				   WHERE `product`.`product_id`=`product_image`.`product_id`
				   AND
				    categories_id	= '$cat_id'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	

	/**
	*	Generating product dropdowns
	*
	*	@param
	*			$pid	parent category id
	*
	*	@return null
	*/
	function genProductList($pid)
	{
		//statement
		$select		= "SELECT 		* 
					   FROM 		products P, products_to_categories PC
					   WHERE 		P.product_id = PC.product_id AND
					   				PC.categories_id='$pid' ";
		
		//execute query
		$query		= mysql_query($select);
		
				
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_array($query))
			{
				$prod_id		= $result['product_id'];
				$prod_name		= $result['product_name'];
				
				echo '<div class="">
						<input name="chkProd[]"type="checkbox" id="chkProd" value="'.$prod_id.'" class="checkbox">

                        <div class="fl w300">'.$prod_name.'</div>
					  </div>
					  <div class="cl"></div>
					  ';
			}
		}

		
	}//eof
		
	/*
	*	This funcion will return all the product id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllProdIdByCatId($catId)
	{
		//declare var
		$data	= array();
		
		//statement
		$select	= "SELECT product_id FROM product
				   WHERE categories_id = '$catId'
				   ORDER BY added_on ASC";
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Format the currency display depending on the currency type
	*
	*	@param
	*			$value			Value of the money or final price
	*			$position		Left or right side the currency symbol need to be placed
	*			$type			Type of currency is being used in the transaction
	*
	*	@return currency
	*/
	function priceFormat($value)
	{
		//declare vars
		$format		= '';
		
		//statement
		$select = "SELECT * FROM currencies WHERE primary_curr='Y'";
		
		//execute query
		$query	= mysql_query($select);
		
		//get the result set
		$result	= mysql_fetch_array($query);
		
		//get the values
		$postion		=  $result['position_pref'];
		$type			=  $result['title'];
		$symbol_left 	=  $result['symbol_left'];
		$symbol_right 	=  $result['symbol_right'];
		
		//format the string
		if($postion == 'left')
		{
			$format = $symbol_left."".number_format($value,2,'.','');
		}
		else
		{
			$format = number_format($value,2,'.','')."".$symbol_left;
		}
		
		//return formatted currency
		return $format;
		
	}//eof


	
	/**
	*	Retrive all primary key based of any criteria or foreign key value
	*	
	*	@param 	
	*			$column			Name of the column holding the id
	*			$condColName	Name of the conditional column of foreign key
	*			$condColVal		Conditional column or foreign key velue
	*			$table			Name of the table
	*			$order			Order by column
	*
	*	@return decimal
	*	
	*/
	function getAllPidIdByOrderId($column, $condColName, $condColVal, $table, $order)
	{
		//declare var
		$data	= array();
		
		//statement
		$sql	= "SELECT ".$column." 
				   FROM   ".$table." 
				   WHERE  ".$condColName." = ".$condColVal."
				   ORDER BY ".$order."";
		
		//execute query
		$query	= mysql_query($sql);
		
		//echo $sql.mysql_error();exit;
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result[$column];
			}
		}
		
		return $data;
	}//eof
	
	
	
	
/*
	*	This funcion will return total product id
	*	
	*	@param
	*			$caiId		category id
	*			
	*
	*	@return array
	*/
	function getTotalProdIdByCatId($catId)
	{
		//declare var
		$data	= array();
		
		//statement
		$select	= "SELECT count(product_id) FROM `product` WHERE categories_id='$catId'";
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof	
	
	

	#####################################################################################################
	#
	#									 Orders Image 
	#
	#####################################################################################################
	
	
	/**
	*	Add extra product image
	*	Added On: Sep 18, 2013
	*
	*	@param
	*			$oid		order Id
	*			$title		Image title
	*			$default	default image or not
	*
	*	@return	null
	*/
	function addOrdImage($oid, $image, $default)
	{
		
		$insert1	= "INSERT INTO  order_image
						(orders_id, image, is_default, added_on)
						VALUES
						('$oid','$image','$default', now())
						";
		$query1		= mysql_query($insert1);
		//echo $insert1.mysql_error();exit;
		//get the product image id
		$oid	= mysql_insert_id();
		return $oid;
		
	}//eof
	
	/**
	*	Edit extra product image
	*	Added On: Sep 18, 2013
	*
	*	@param
	*			$pImgId     product Image Id
	*			$pid		Product Id
	*			$title		Image title
	*			$default	default image or not
	*
	*	@return	null
	*/
	function editProdImage($pImgId,$pid, $title, $default)
	{
		//statement
		
		$edit  = "UPDATE product_image
				SET
				product_id 	= '$pid',
				title 		= '$title',
				is_default	= '$default',
				modified_on = now()
				WHERE
				product_image_id = '$pImgId'
				";
				
		//execute statement
		$query = mysql_query($edit);
	}
	
	
	
	/**
	*	Delete Product Image.
	*	Added On: Sep 18, 2013
	*	@param 
	*			$pImgId		product Image Id
	*
	*	@return string
	*/
	function deleteProdImg($pImgId)
	{	
		//delete from review
		$sql	= "DELETE FROM product_image WHERE product_image_id='$pImgId'";
		//execute statement
		$query	= mysql_query($sql);
		
		
	}//eof
	
	
	/**
	*	Get All the product image id
	*
	*	Added On: Sep 18, 2013
	*
	*
	*
	*	@return	int
	*/
	function getProdImgId()
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_image_id  FROM product_image";
		
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_image_id '];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/**
	*	Get  product image id by Product Id
	*
	*	Added On: Sep 18, 2013
	*
	*	@param 
	*			$pId		product Id
	*
	*
	*
	*	@return	int
	*/
	function getProdImgIdByPid($pid)
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_image_id  FROM product_image where product_id=$pid";
		
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_image_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get the data associated with a product Image
	*
	*	Added On: Sep 18, 2013
	*	@param
	*			$pImgId		product Image Id
	*
	*	@return array				
	*/
	function showOrdImg($oImgId)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM order_image
				   WHERE order_image_id = '$oImgId'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();
		
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->order_image_id,			//0
					$result->orders_id,					//1
					$result->image,					//2
					$result->is_default,			//3
					$result->sort_order,			//4				
					$result->added_on,				//5
					$result->modified_on,			//6				
					$result->thumb_image			//7			//added on 22 Nov 2013
					
					);
		}
		
		//return the data
		return $data;
		
		
	}//eof
	


	/*
	*	This funcion will return all the product id
	*	
	*	@param
	*			$pId		Product id
	*
	*	@return array
	*/
	function getDefaultOrdImg($oId)
	{
		//declare var
		$data	= array();
		
		//statement
		$select	= "SELECT order_image_id FROM order_image
				   WHERE orders_id = '$oId'
				   AND is_default = 'Y'
				   ORDER BY order_image_id DESC";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['order_image_id'];
		}
		
		//return the data
		if(count($data) > 0)
		{
			return $data[0];
		}
		else
		{
			return 0;
		}
		
	}//eof
	
	#####################################################################################################
	#
	#										Product to customer
	#
	#####################################################################################################
	
	/**
	*	Add a data in product to customer table.
	*
	*	@param
	*			$pid				Product id
	*			$cid				Customer id
	*
	*	@return int
	*/
	
	function addProdToCust($pid, $cid)
	{
		$pid				=	mysql_real_escape_string(trim($pid));
		$cid				=	mysql_real_escape_string(trim($cid));
		
		//satement to insert in product table
		$insert		=   "INSERT INTO product_to_customer
						(product_id, customer_id, added_on)						 
						VALUES
						('$pid', '$cid', now())
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product to customer  id
		$product_to_customer_id	= mysql_insert_id();
		
		//return primary key
		return $product_to_customer_id;

	}//eof

	/**
	*	This function edit product to customer
	*
	*	@param
	*			$ptocid				Product to customer id
	*			$pid				Product id
	*			$cid				Customer id
	*
	*	@return null
	*/
	function editProdToCust($ptocid, $pid, $cid)
	{
	
		//update product to product to customer
		$edit  = "UPDATE product_to_customer
				SET
				product_id				= '$pid',
				customer_id		 		= '$cid',
				modified_on				=  now()
				
				WHERE
				product_to_customer_id 	= '$ptocid'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
		
	
	/**
	*	This function will delete data from product to customer
	*
	*	@param
	*			$ptocid			Product to customer id
	*
	*	@return null
	*/
	function delProdToCust($ptocid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM product_to_customer  WHERE product_to_customer_id='$ptocid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	
	/**
	*	Get  product to cus id
	*
	*	@return	array
	*/
	function getProdToCusId()
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_id  FROM product_to_customer";
		
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get  product to cus id by customer Id
	*
	*	@param		$cusID
	*
	*	@return	array
	*/
	function getProdToCusIdByCus($cusId)
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_id  
					   FROM product_to_customer
					   WHERE customer_id = '$cusId'";
		
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
		/**
	*	Get  product to cus id by customer Id
	*
	*	@param		$cusID
	*
	*	@return	array
	*/
	function getProdIdByCus($cusId)
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT DISTINCT product_id
					   FROM product_to_customer
					   WHERE customer_id = '$cusId'";
		
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get  product to cus id by customer Id and product id
	*
	*	@param		$cusID, $prodId
	*
	*	@return	array
	*/
	function getProdToCusIdByCusProd($cusId, $pid)
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_id  
					   FROM product_to_customer
					   WHERE customer_id = '$cusId'
					   AND product_id = $pid";
		
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a product to customer based upon the primary key
	*
	*	@param
	*			$ptocid			Product to customer id
	*
	*	@return array				
	*/
	function showProdToCust($ptocid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM product_to_customer 
				   WHERE product_to_customer_id	= $ptocid";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->product_id,						//0
					$result->customer_id,						//1				
					$result->added_on,							//2
					$result->modified_on						//3

					);
		}
		
		//return the data
		return $data;
		
	}//eof

	#####################################################################################################
	#
	#										Product to customer detail
	#
	#####################################################################################################
	
	/**
	*	Add a data in product to customer table.
	*
	*	@param
	*			$pid				Product id
	*			$cid				Customer id
	*			$sid				season id
	*			$fStartDate			Farming start date
	*			$fEndDate			Farming end date
	*			$fyear				Farming year
	*			$fyield				Farming yield
	*			$yuid				Yield unit id
	*			$typeId				Type id can be inorganic or organic
	*
	*	@return int
	*/
	
	function addProdToCustDtl($pid, $cid, $sid, $fStartDate, $fEndDate, $fyear, $fyield, $yuid, $typeId)
	{
		$pid				=	mysql_real_escape_string(trim($pid));
		$cid				=	mysql_real_escape_string(trim($cid));
		$sid				=	mysql_real_escape_string(trim($sid));
		$fStartDate			=	mysql_real_escape_string(trim($fStartDate));
		$fEndDate			=	mysql_real_escape_string(trim($fEndDate));
		$fyear				=	mysql_real_escape_string(trim($fyear));
		$fyield				=	mysql_real_escape_string(trim($fyield));
		$yuid				=	mysql_real_escape_string(trim($yuid));		
		
		//satement to insert in product table
		$insert		=   "INSERT INTO product_to_customer_detail
						(product_id, customer_id, season_id, farming_start_date, farming_end_date, farming_year, farming_yield, 
						yield_unit_id, product_type_id, added_on)						 
						VALUES
						('$pid', '$cid', '$sid', '$fStartDate', '$fEndDate', '$fyear', '$fyield', '$yuid', '$typeId', now())
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product to customer  id
		$product_to_customer_id	= mysql_insert_id();
		
		//return primary key
		return $product_to_customer_id;

	}//eof

	/**
	*	This function edit product to customer
	*
	*	@param
	*			$ptocid				Product to customer id
	*			$pid				Product id
	*			$cid				Customer id
	*			$sid				season id
	*			$fStartDate			Farming start date
	*			$fEndDate			Farming end date
	*			$fyear				Farming year
	*			$fyield				Farming yield
	*			$yuid				Yield unit id
	*			$typeId				Type id can be inorganic or organic
	*
	*	@return null
	*/
	function editProdToCustDtl($ptocid, $pid, $cid, $sid, $fStartDate, $fEndDate, $fyear, $fyield, $yuid, $typeId)
	{
	
		//update product to product to customer
		$edit  = "UPDATE product_to_customer_detail
				SET
				product_id				= '$pid',
				customer_id		 		= '$cid',
				season_id				= '$sid',
				farming_start_date		= '$fStartDate',
				farming_end_date 		= '$fEndDate',
				farming_year			= '$fyear',
				farming_yield			= '$fyield',
				yield_unit_id			= '$yuid',
				product_type_id			= '$typeId',
				modified_on				=  now()
				
				WHERE
				product_to_customer_detail_id 	= '$ptocid'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
		
	
	/**
	*	This function will delete data from product to customer
	*
	*	@param
	*			$ptocid			Product to customer id
	*
	*	@return null
	*/
	function delProdToCustDtl($ptocid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM product_to_customer_detail  WHERE product_to_customer_detail_id='$ptocid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	
	/**
	*	Get  product to cus id
	*
	*	@return	array
	*/
	function getProdToCusDtlId()
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_detail_id  FROM product_to_customer_detail";
		
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_detail_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get  product to cus id by customer Id and product id
	*
	*	@param		$cusID, $prodId
	*
	*	@return	array
	*/
	function getProdToCusDtlIdByCusProd($cusId, $pid)
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_detail_id  
					   FROM product_to_customer_detail
					   WHERE customer_id = '$cusId'
					   AND product_id = $pid";
		
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_detail_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a product to customer based upon the primary key
	*
	*	@param
	*			$ptocid			Product to customer id
	*
	*	@return array				
	*/
	function showProdToCustDtl($ptocid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM product_to_customer_detail 
				   WHERE product_to_customer_detail_id	= $ptocid";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->product_id,						//0
					$result->customer_id,						//1
					$result->season_id,							//2
					$result->farming_start_date,				//3
					$result->farming_end_date,					//4
					$result->farming_year,						//5
					$result->farming_yield,						//6
					$result->yield_unit_id,						//7					
					$result->added_on,							//8
					$result->modified_on,						//9
					$result->product_type_id					//10

					);
		}
		
		//return the data
		return $data;
		
	}//eof



	#####################################################################################################
	#
	#										Product to customer info
	#
	#####################################################################################################
	
	/**
	*	Add a data in product to customer info table.
	*
	*	@param
	*			$pCusId				Product to customer id
	*			$cusId				Customer id
	*			$desc				Description
	*			$visible			To whom Visible
	*
	*	@return int
	*/
	
	function addProdToCustInfo($pCusId, $cusId, $desc, $visible)
	{
		$desc				=	mysql_real_escape_string(trim($desc));	
		
		//satement to insert in product table
		$insert		=   "INSERT INTO product_to_customer_info
						(product_to_customer_id, customer_id, product_description, visible_to, added_on)						 
						VALUES
						('$pCusId', '$cusId', '$desc', '$visible', now())
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product to customer  id
		$product_to_customer_info_id	= mysql_insert_id();
		
		//return primary key
		return $product_to_customer_info_id;

	}//eof

	/**
	*	This function edit product to customer
	*
	*	@param
	*			$infoId				Product to customer info id
	*			$cusId				Customer id
	*			$pCusId				Product to customer id
	*			$desc				Description
	*			$visible			To whom Visible
	*
	*	@return null
	*/
	function editProdToCustInfo($infoId, $pCusId, $cusId, $desc, $visible)
	{
	
		//update product to product to customer
		$edit  = "UPDATE product_to_customer_info
				SET
				product_to_customer_id			= '$pid',
				customer_id						= '$cusId',
				product_description		 		= '$cid',
				visible_to						= '$sid'
				modified_on						=  now()
				
				WHERE
				product_to_customer_info_id 	= '$infoId'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
		
	
	/**
	*	This function will delete data from product to customer
	*
	*	@param
	*			$id			Product to customer info id
	*
	*	@return null
	*/
	function delProdToCustInfo($id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM product_to_customer_info  WHERE product_to_customer_info_id='$id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	
	/**
	*	Get  product to cus id
	*
	*	@return	array
	*/
	function getProdToCusInfoId()
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_info_id  FROM product_to_customer_info";
		
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_info_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get  product to cus id by customer Id and product id
	*
	*	@param		pCid			product to customer id
	*
	*	@return	array
	*/
	function getProdToCusInfoIdBypCId($pcId)
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_info_id  
					   FROM product_to_customer_info
					   WHERE product_to_customer_id = '$pcId'";
		
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_info_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get  product to cus info id by customer Id
	*
	*	@param		cusId			customer id
	*
	*	@return	array
	*/
	function getProdToCusInfoIdByCusId($cusId)
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_info_id  
					   FROM product_to_customer_info
					   WHERE customer_id = '$cusId'
					   ORDER BY added_on DESC";
		
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_info_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a product to customer based upon the primary key
	*
	*	@param
	*			$ptocid			Product to customer id
	*
	*	@return array				
	*/
	function showProdToCustInfoDtl($ptocid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM product_to_customer_info 
				   WHERE product_to_customer_info_id	= $ptocid";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->product_to_customer_id,			//0
					$result->product_image,						//1
					$result->product_description,				//2
					$result->visible_to,						//3
					$result->num_click,							//4
					$result->added_on,							//5
					$result->modified_on,						//6
					$result->customer_id,						//7
					$result->num_like							//8
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										Product to customer image
	#
	#####################################################################################################
	
	/**
	*	Add a data in product to customer info table.
	*
	*	@param
	*			$pCusId				Product to customer id
	*			$cusId				Customer id
	*			$desc				Description
	*			$visible			To whom Visible
	*
	*	@return int
	*/
	
	function addProdToCustImage($pCusInfoId, $image, $thumb_image, $sort_order)
	{
		//$desc				=	mysql_real_escape_string(trim($desc));	
		
		//satement to insert in product table
		$insert		=   "INSERT INTO product_to_customer_image
						(product_to_customer_info_id, image, thumb_image, sort_order, added_on)						 
						VALUES
						('$pCusInfoId', '$image', '$thumb_image', '$sort_order', now())
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product to customer  id
		$product_to_customer_image_id	= mysql_insert_id();
		
		//return primary key
		return $product_to_customer_image_id;

	}//eof

	/**
	*	Get  product to cus id
	*
	*	@return	array
	*/
	function getProdToCusImageId()
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_image_id  FROM product_to_customer_image";
		
				   
		//execute query
		$query	= mysql_query($select);
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_image_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get  product to cus id by customer Id and product id
	*
	*	@param		pCid			product to customer id
	*
	*	@return	array
	*/
	function getProdToCusImageIdBypCInfoId($pcInfoId)
	{
		//declare var
		$data	= array();
		
		//statement
		
			$select	= "SELECT product_to_customer_image_id  
					   FROM product_to_customer_image
					   WHERE product_to_customer_info_id = '$pcInfoId'";
		
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_to_customer_image_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
		
	/**
	*	Get the data associated with a product to customer based upon the primary key
	*
	*	@param
	*			$ptocid			Product to customer id
	*
	*	@return array				
	*/
	function showProdToCustImageDtl($ptocid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM product_to_customer_image 
				   WHERE product_to_customer_image_id	= $ptocid";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->product_to_customer_info_id,			//0
					$result->image,									//1
					$result->thumb_image,							//2
					$result->sort_order,						//3
					$result->added_on,							//4
					$result->modified_on						//5
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
}
?>