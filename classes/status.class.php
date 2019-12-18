<?php
/**
*	Usable for display, edit, delete order from the admin control panel.
*
*	Added on  feb 25, 2015
*	Added function to retrieve list of product status
*
*	
*
*
*	@author 		Safikul Islam
*	@date   		feb , 25,2015
*	@version		1.0
*	@copyright		Wain Technology
*	@email			safikulislamwb@gmail.com
*/

include_once("customer.class.php"); 

class Status extends Customer
{
	 /**
	 *	Generate order key
	 *	
	 *	@param
	 *			$length		Length of the key
	 *
	 *	@return string
	 */
	 function orderKeys($length)
     {
		 $key = '';
		 $pattern = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		 for($i=0;$i<$length;$i++)
		 {
		    $key .= $pattern{rand(0,35)};
		 }
     	 return $key;
    }//eof
	
	
	
	
	/**
	*	Get the latest id of order
	*/
	function getLatestOrderId()
	{
		//declare vars
		$id		= 0;
		
		//statement
		$sql	= "SELECT MAX(orders_id) AS MOID FROM orders";
		
		//query
		$query	= mysql_query($sql);
		
		//get the result
		$result	= mysql_fetch_object($query);
		
		//assign the value
		$id		= $result->MOID;
		
		//return the result
		return $id;
		
	}//eof
	
	
	
	/**
	*	Generate unique order code
	*	
	*	@param
	*			$prefix			Prefix to add before the code
	*
	*	@return string
	*/
	function generateOrderCode($prefix, $userId)
	{
		//declare vars
		$ordCode		= '';
		
		//get 5 char order key
		$ordKey	= $this->orderKeys(5);
		
		//get the date and time
		$dateStr	= date("dmY");
		
		//user id
		if(isset($_SESSION['userid']))
		{
			$userId	= $_SESSION['userid'];
		}
		else
		{
			$userId	= $userId;
		}
		//formatted id
		$userId	= 10000 + $userId;
		
		//get the previously stored number of order
		$numOrder = $this->getLatestOrderId();
		
		//num order
		$reOrder = 1001 + $numOrder;
		
		//generate the code
		$ordCode		= $prefix.'-'.$userId.'-'.$dateStr.$ordKey.'-'.$reOrder;
		
		//return code
		return	$ordCode;
		
	}//eof
	

	
	/**
	*	Assign package
	*	
	*	@param
	*			$packId		Package id
	*			$cusId		Customer id
	*			$packType   Type of package, either new or renew
	*
	*	@return int
	*/
	function assignPack($packId,$cusId, $packType)
	{
		$sql	= "INSERT INTO orders(package_id, customer_id, package_type, subscribe_date) 
				   VALUES ('$packId','$cusId', '$packType', now())";
		$query	= mysql_query($sql);
		
		$id		= mysql_insert_id();
		
		//return id
		return $id;
	}//eof
	


	/**
	*	Add order
	*
	*	@param
	*			$package_id		Package id
	*			$customer_id	Customer id
	*			$customer_name	Customer name
	*			$address1		Address 1
	*			$address2		Address 2
	*			$town_id		Town id
	*			$county_id		County id
	*			$province_id	Province id
	*			$postcode		Post code
	*			$phone			Phone number
	*			$country_code	Country code
	*			$pay_amount		Pay amount
	*			$shipping		shipping rate
	*			$package_type	Package type
	*			$payment_method	Payment method
	*	@return null
	*/
	function addOrder($orders_id, $oder_code, $package_id,$payment_method, $customer_name, $address1, $address2,  
					  $town_id, $county_id, $province_id, $postcode, $phone,
					  $country_code, $pay_amount, $shipping,$email) 				  
	{
		
		//inserting order values
		$sql 	= "UPDATE orders
				   SET
				   orders_code 		='$oder_code', 
				   customer_name	='$customer_name',
				   address1			='$address1', 
				   address2			='$address2', 
				   town_id			='$town_id', 
				   county_id		='$county_id', 
				   province_id		='$province_id',
				   postcode			='$postcode', 
				   phone			='$phone', 
				   country_code		='$country_code', 
				   pay_amount		='$pay_amount', 
				   shipping			='$shipping',
				   email			='$email',
				   payment_method	='$payment_method'
				   WHERE 
				   orders_id = '$orders_id'
				  ";
		$query	= mysql_query($sql);
		$ordId  = '$orders_id';
		
	}//eof
	
	
	
	
	
	/**
	*	Add to cusorders details
	*
	*	@date	October 09, 2012
	*
	*	@param
	*			$userid, $productId, $sid, $prodPrice
	*/
	function AddOrderDetails($orders_id,$orders_products_id,$customer_id, $product_options,$product_options_values,$price,$sessionId)
	{
		//define var
		$detailsId	= 0;
		
		//put the product in cart table
		$sql	= "INSERT INTO orders_details(orders_id, orders_products_id,customer_id, product_options, product_options_values,price,sessionId) 
				   VALUES ('$orders_id','$orders_products_id','$customer_id', '$product_options', '$product_options_values','$price','$sessionId')";
		
		//execute query
		$result 	= mysql_query($sql);

		//get the primary key
		$detailsId	= mysql_insert_id();
		
		//return the id
		return $detailsId;
		
	}//eof
	
	
	
	/*
	*	update order details
	*
	*/
	function UpdateOrderDetails($orders_id,$customer_id,$sessionId)				  
	{
		/*echo $orders_id;
		exit;*/
		//inserting order values
		$sql 	= "UPDATE orders_details
				   SET
				   orders_id 		='$orders_id' 
				  
				   WHERE 
				   customer_id = '$customer_id' AND sessionId='$sessionId'
				  ";
		$query	= mysql_query($sql);
		$ordId  = '$customer_id';
		
	}//eof
	
	
	
	
	/**
	*	Update order after making payment and
	*/
	function completeOrder($orders_id, $ipn, $ip_address, $end_date, $package_status, $orders_status_id)
	{
		$sql 	= "UPDATE orders
				   SET
				   pay_date			=  now(), 
				   ipn				= '$ipn', 
				   ip_address		= '$ip_address',
				   package_end_date = '$end_date', 
				   package_status	= '$package_status',
				   orders_status_id	= '$orders_status_id'
				   WHERE 
				   orders_id = '$orders_id'
				  ";
		$query	= mysql_query($sql);
		
	}//eof
	
	
	/**
	*	display order code, depending on the user, and status of the order
	*	variable:
	*	userid			:	user identity
	*	status			:	status code for the order
	*/
	function getOrderCode($user_id, $status)
	{
		if(($user_id == 'all') &&($status == 'all'))
		{
			$sql	= "SELECT * FROM orders";
		}
		elseif(($user_id == 'all') &&((int)$status > 0))
		{
			$sql	= "SELECT * FROM orders WHERE orders_status_id = '$status'";
		}
		elseif(((int)$user_id > 0) &&((int)$status > 0))
		{
			$sql	= "SELECT * FROM orders WHERE orders_status_id = '$status' AND customer_id='$user_id'";
		}
		elseif(((int)$user_id > 0) &&($status == 'all'))
		{
			$sql	= "SELECT * FROM orders WHERE customer_id='$user_id'";
		}
		else
		{
			$sql	= "SELECT * FROM orders";
		}
		
		$query	= mysql_query($sql);
		$data	= array();
		
		while($result = mysql_fetch_array($query))
		{
			$data[]	= $result['orders_code'];
		}
		return $data;
		
	}//eof
	
	
	
	/**
	*	Get the detail of an order either against its id or its code. User needs to pass either of 
	*	this variable, if code is passed then put id as zero(0) otherwise put code value
	*			
	*	@param
	*			$code	Code of the transaction
	*			$id		Primary key of the transaction
	*	
	*	@return array	
	*/
	function getOrderData($code, $id) 
	{
		if($code != '' && $id == 0)
		{
			$sql	= "SELECT * FROM orders, orders_status 
						WHERE  orders_code = '$code' 
						AND orders.orders_status_id = orders_status.orders_status_id
						";
		}
		elseif($code == '' && $id > 0)
		{
			$sql	= "SELECT * FROM orders, orders_status 
					   WHERE  orders_id = '$id'
					   AND orders.orders_status_id = orders_status.orders_status_id
					   ";
		}
		else
		{
			$sql	= "SELECT * FROM orders, orders_status 
						WHERE  orders_code = '$code' 
						AND orders.orders_status_id = orders_status.orders_status_id
						";
		}
		
		$query	= mysql_query($sql);
		$data	= array();
		//echo $sql;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_array($query);
			
			$data	= array(
						$result['orders_id'],					//0
						$result['customer_id'],					//1
						$result['orders_code'],					//2
						$result['package_id'],					//3
						$result['customer_name'],				//4
						$result['address1'],					//5
						$result['address2'],					//6
						$result['town_id'],						//7
						$result['county_id'],					//8
						$result['province_id'],					//9
						$result['postcode'],					//10
						$result['phone'],						//11
						$result['country_code'],				//12
						$result['pay_amount'],					//13
						$result['tax_rate'],					//14
						$result['package_type'],				//15
						$result['subscribe_date'],				//16
						$result['pay_date'],					//17
						$result['ipn'],							//18
						$result['ip_address'],					//19
						$result['package_end_date'],			//20 
						$result['package_status'],				//21
						$result['orders_status_id'],			//22
						$result['orders_status_name'],			//23
						$result['payment_method'],				//24
						$result['payment_method']				//25
						
						
						);//END OF ARRAY
			
			return $data;
		}
	}//eof
	
	
	/**
	*	Get the detail of an order either against its id or its code. User needs to pass either of 
	*	this variable, if code is passed then put id as zero(0) otherwise put code value
	*			
	*	@param
	*			$code	Code of the transaction
	*			$id		Primary key of the transaction
	*	
	*	@return array	
	*/
	function getOrderDetail($code, $id) 
	{
		if($code != '' && $id == 0)
		{
			$sql	= "SELECT * FROM orders, orders_status 
						WHERE  orders_code = '$code' 
						AND orders.orders_status_id = orders_status.orders_status_id
						";
		}
		elseif($code == '' && $id > 0)
		{
			$sql	= "SELECT * FROM orders, orders_status 
					   WHERE  orders_id = '$id'
					   AND orders.orders_status_id = orders_status.orders_status_id
					   ";
		}
		else
		{
			$sql	= "SELECT * FROM orders, orders_status 
						WHERE  orders_code = '$code' 
						AND orders.orders_status_id = orders_status.orders_status_id
						";
		}
		
		$query	= mysql_query($sql);
		$data	= array();
		//echo $sql;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_array($query);
			
			$data	= array(
						$result['orders_id'],					//0
						$result['customer_id'],					//1
						$result['orders_code'],					//2
						$result['package_id'],					//3
						$result['customer_name'],				//4
						$result['address1'],					//5
						$result['address2'],					//6
						$result['town_id'],						//7
						$result['county_id'],					//8
						$result['province_id'],					//9
						$result['postcode'],					//10
						$result['phone'],						//11
						$result['country_code'],				//12
						$result['pay_amount'],					//13
						$result['shipping'],					//14
						$result['package_type'],				//15
						$result['subscribe_date'],				//16
						$result['pay_date'],					//17
						$result['ipn'],							//18
						$result['ip_address'],					//19
						$result['package_end_date'],			//20 
						$result['package_status'],				//21
						$result['orders_status_id'],			//22
						$result['orders_status_name'],			//23
						$result['payment_method'],				//24
						$result['email'],			//25
						
						);//END OF ARRAY
			
			return $data;
		}
	}//eof
	
	
	
	
	/**
	*	Get the detail of an order either against its id or its code. User needs to pass either of 
	*	this variable, if code is passed then put id as zero(0) otherwise put code value
	*			
	*	@param
	*			$code	Code of the transaction
	*			$id		Primary key of the transaction
	*	
	*	@return array	
	*/
	function getOrderDisplay($id) 
	{
		
			$sql	= "SELECT * FROM orders
						WHERE  orders_id = '$id' 
						";
		
				
		$query	= mysql_query($sql);
		$data	= array();
		//echo $sql;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_array($query);
			
			$data	= array(
						$result['orders_id'],					//0
						$result['customer_id'],					//1
						$result['orders_code'],					//2
						$result['package_id'],					//3
						$result['customer_name'],				//4
						$result['address1'],					//5
						$result['address2'],					//6
						$result['town_id'],						//7
						$result['county_id'],					//8
						$result['province_id'],					//9
						$result['postcode'],					//10
						$result['phone'],						//11
						$result['country_code'],				//12
						$result['pay_amount'],					//13
						$result['shipping'],					//14
						$result['package_type'],				//15
						$result['subscribe_date'],				//16
						$result['pay_date'],					//17
						$result['ipn'],							//18
						$result['ip_address'],					//19
						$result['package_end_date'],			//20 
						$result['package_status'],				//21
						$result['orders_status_id'],			//22
						//$result['orders_status_name'],			//
						$result['payment_method']				//23
						
						);//END OF ARRAY
			
			return $data;
		}
	}//eof
	
	
/**
	*	Return the order products detail, associated with an order id
	*
	*	@date	january 20, 2015
	*
	*	@param
	*			$id			Order id
	*
	*	@return	array
	*/
	function getOrdProductDetail($id)
	{
		//declare vars
		$data	= array();
		
		//statement
		$sql	= "SELECT 	* 
				   FROM 	orders_details
				   WHERE  	orders_id = '$id'";
					
		//execute query
		$query	= mysql_query($sql);
		
		//get the resultset
		$result = mysql_fetch_object($query);
		
		//check and hold in array
		if(mysql_num_rows($query))
		{
			//hold data in array
			$data	= array(
						$result->orders_details_id,			//0
						$result->orders_id,					//1
						$result->orders_products_id,				//2
						$result->customer_id,					//3
						$result->product_options,			//4
						$result->product_options_values, 			//5
						$result->price,	    				//6
						$result->sessionId	    		//7

						);
		}
		
		//return the array
		return $data;
		
	}//eof
	
		
	/**
	*	Display all data of orders_details
	*
	*	@param
	*			$id  = orders_id
	*	@return $id
	*/
	
	  public function getOrdProductDisplay($id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM orders_details WHERE orders_id='$id'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	/*function getOrdProductDisplay($id)
	{
		
		$sql = "SELECT * FROM orders_details WHERE orders_id='$id'";
		$query = mysql_query($sql);
		
		$data = '';
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_array($query);
			$data 	= $result['orders_id'];
		}
		
		//return 
		return $data;
		
	}//eof*/
	
	
	
	/**
	*	Return the order membership detail, associated with an order id
	*
	*	@date	October 17, 2010
	*
	*	@param
	*			$id			Order id
	*
	*	@return	array
	*/
	function getOrdMemberDetail($id)
	{
		//declare vars
		$data	= array();
		
		//statement
		$sql	= "SELECT 	* 
				   FROM 	customer_membership
				   WHERE  	customer_membership.orders_id = '$id'";
					
		//execute query
		$query	= mysql_query($sql);
		
		//get the resultset
		$result = mysql_fetch_object($query);
		
		//check and hold in array
		if(mysql_num_rows($query))
		{
			//hold data in array
			$data	= array(
						$result->customer_id,			//0
						$result->package_id,			//1
						$result->orders_id,				//2
						$result->membership_type,		//3
						$result->amount_paid,			//4
						$result->start_date, 			//5
						$result->end_date	    		//6
						);
		}
		
		//return the array
		return $data;
		
	}//eof
	
	
	
	
	
	/*
		GET THE CUSTOMER NOTIFICATIONS ID
		VARIABLE:
		ORDERID			:	ORDER ID
	*/
	function getNotifyId($order_id)
	{
		$select = "SELECT * FROM orders_comments WHERE orders_id='$order_id'";
		$query	= mysql_query($select);
		$data 	= array();
		while($result = mysql_fetch_array($query))
		{
			$data[]		= $result['orders_comments_id'];
		}
		return $data;
	}//END OF GETTING NOTIFY DATA
	
	/*	
		RETURN NOTIFY DETAIL
		VARIBALE:
		ID			:	NOTIFY ID
	*/
	function getNotifyDetail($id)
	{
		$select = "SELECT * FROM orders_comments, orders_status
				  WHERE
				  orders_comments.orders_status_id = orders_status.orders_status_id
				  AND orders_comments_id='$id'";
		$query	= mysql_query($select);
		
		$data 	= array();
		$result = mysql_fetch_array($query);
		$data	= array(
						$result['customer_notify'],			//0
						$result['orders_status_id'],		//1
						$result['date_commented'],			//2
						$result['comments'],				//3
						$result['orders_status_name']		//4
						);
		return $data;
	}//END OF GETTING DATA
	
	/*
		INSERT INTO NOTIFY TABLE
		VARIABLE:
		
	*/
	function insertNotify($orders_id, $customer_notify, $orders_status_id, $comments)
	{
		//update order table
		$update	= "UPDATE orders SET orders_status_id='$orders_status_id' WHERE orders_id='$orders_id'";
		mysql_query($update);
		
		$insert ="INSERT INTO orders_comments
				(orders_id, customer_notify,orders_status_id,date_commented,comments) 
				 VALUES
				('$orders_id','$customer_notify','$orders_status_id',now(),'$comments')";
		mysql_query($insert);
	}
	
	/**
	*	Delete the order, along with the all other associated entry in the database will be deleting
	*	
	*	@param
	*			$orderId			Orders id
	*/
	function deleteOrder($orderId)
	{
		//delete from membership
		$deleteOrderMem	= "DELETE FROM customer_membership WHERE orders_id = '$orderId'";
		mysql_query($deleteOrderMem);
		
		///delete from comments
		$deleteComments	= "DELETE FROM orders_comments WHERE orders_id = '$orderId'";
		mysql_query($deleteComments);
		
		//delete from orders
		$delCusOrder = "DELETE FROM orders WHERE orders_id = '$orderId'";
		mysql_query($delCusOrder);
		
	}//eof
	
	/**
	*	Update order status and make it active
	*
	*	@return NULL
	*/
	function updateOrder($orders_id, $newStat)
	{
		$update = "UPDATE orders SET orders_status_id='$newStat' WHERE orders_id='$orders_id'";
		$query	= mysql_query($update);
	}//update order
	
	
	/**
	*	Order name by order status
	*
	*	@param
	*			$orders_status_id		Primary key associated with the order status
	*	@return string
	*/
	function getOrdStatName($orders_status_id)
	{
		$sql = "SELECT orders_status_name FROM orders_status WHERE orders_status_id='$orders_status_id'";
		$query = mysql_query($sql);
		$data = '';
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_array($query);
			$data 	= $result['orders_status_name'];
		}
		
		//return 
		return $data;
		
	}//eof
		
	
	
	/**
	*	Get all order status id
	*
	*	@date	September 28, 2010
	*
	*	@return string
	*/
	function getOrdStatIds()
	{
		//declare vars
		$data = array();
		
		//statement
		$sql = "SELECT orders_status_id FROM orders_status ORDER BY sort_order";
		
		//execute query
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[]	= $result->orders_status_id;
			}
		}
		
		//return 
		return $data;
		
	}//eof
	
	
	
	
	/**
	*	Get all order product attribute id based on order products id
	*
	*	@date	October 18, 2010
	*
	*	@param
	*			$id			Order products id
	*
	*	@return string
	*/
	function getAllOrdProdAttrIds($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$sql = "SELECT 		orders_products_attributes_id 
				FROM 		orders_products_attributes 
				WHERE		orders_products_id	= $id
				ORDER BY 	added_on";
		
		//execute query
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[]	= $result->orders_products_attributes_id;
			}
		}
		
		//return 
		return $data;
		
	}//eof
	
	
		
	/**
	*	Return the order product attribute detail, associated with an order product id
	*
	*	@date	October 17, 2010
	*	
	*	@param
	*			$id			Order product attribute id
	*
	*	@return	array
	*/
	function getOrdProdAttrDetail($id)
	{
		//declare vars
		$data	= array();
		
		//statement
		$sql	= "SELECT 	* 
				   FROM 	orders_products_attributes
				   WHERE  	orders_products_attributes_id = '$id'";
					
		//execute query
		$query	= mysql_query($sql);
		
		//get the resultset
		$result = mysql_fetch_object($query);
		
		//check and hold in array
		if(mysql_num_rows($query))
		{
			//hold data in array
			$data	= array(
						$result->orders_id,						//0
						$result->orders_products_id,			//1
						$result->product_option_id,				//2
						$result->product_option_value_id,		//3
						$result->options_values_price,			//4
						$result->price_prefix, 					//5
						$result->product_option_name,	    	//6
						$result->product_option_value_name,		//7
						$result->added_on,						//8
						$result->modified_on					//9
						);
		}
		
		//return the array
		return $data;
		
	}//eof
	
	
	
	
	
	/**
	*	Render order product attribute or option value in ordered way for the order detail
	*
	*	@param
	*			$id				Order Product identity
	*			$dispStyle		Style of the select box
	*
	*	@return NULL
	*/
	function showOrdProdAttDtl($id, $dispStyle)
	{
		//declare var
		$attrStr	= '';
		
		//get the order product attribute ids
		$allIds		= $this->getAllOrdProdAttrIds($id);
		
		//check and display
		if(count($allIds) > 0)
		{
			
			foreach($allIds as $q)
			{
				//order product attribute detail
				$opAttrDtl 	= $this->getOrdProdAttrDetail($q);
					
				//left part
				$attrStr .= "<div class='w125 padR10 fl'><strong>".$opAttrDtl[6].":</strong></div>";
				
				$attrStr .= "<div class='fl ".$dispStyle."'>".$opAttrDtl[7]."</div>";
					  
				$attrStr .= "<div class='cl'><!-- --></div>";
			}
		}
		
		//return the string
		return $attrStr;
		
	}//eof
	
	
	/*
	*	Get order id  by customer id
	*	Variable:
	*
	*	$cus_id:	Id of the customer
	*	update on 2.04.2015
	*/
	
	function getOrdersIdsByCusId($cus_id)
	{
		$data = array();
		//statement
		$select = "SELECT orders_id from orders WHERE customer_id='$cus_id'";
		
		//execute the query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		
		while($result = mysql_fetch_array($query))
		{
			$data[]		= $result['orders_id'];
		}
		//return data
		return $data;
	}//eof
	
	
	
	
}//eoc
?>