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

class Search extends Customer
{
	/**
	*	Search by location. Which can be use in any other search.
	*	
	*	@param
	*			$pId		Province id
	*			$cId		County id
	*			$tId		Town id
	*			$id			Id to search
	*			$table		Table to perform search
	*
	*	@return array
	*/
	function getByLocation($pId, $cId, $tId, $id, $table)
	{
		$pId = mysql_real_escape_string((int)$pId);
		$cId = mysql_real_escape_string((int)$cId);
		$tId = mysql_real_escape_string((int)$tId);
		
		if($tId > 0)
		{
			$sql	= "SELECT ".$id." FROM ".$table." WHERE town_id = '$tId'";
		}
		elseif($cId > 0)
		{
			$sql	= "SELECT ".$id." FROM ".$table." WHERE county_id = '$pId'";
		}
		elseif($pId > 0)
		{
			$sql	= "SELECT ".$id." FROM ".$table." WHERE province_id = '$pId'";
		}
		else
		{
			$sql	= "SELECT ".$id." FROM ".$table."";
		}
		
		 $query = mysql_query($sql);
		 $data = array();
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
	
	/**
	*	Search by location. Which can be use in any other search.
	*	
	*	@param
	*			$pId		Province id
	*			$cId		County id
	*			$tId		Town id
	*			$id			Id to search
	*			$table		Table to perform search
	*
	*	@return array
	*/
	function getByLocation2($countryId, $pId, $cId, $tId, $id, $table)
	{
		$countryId = mysql_real_escape_string((int)$countryId);
		$pId = mysql_real_escape_string((int)$pId);
		$cId = mysql_real_escape_string((int)$cId);
		$tId = mysql_real_escape_string((int)$tId);
		$data = array();

		
		if($countryId > 0)
		{
			if($pId > 0)
			{
				if($cId > 0)
				{
					if($tId > 0)
					{
						$sql	= "SELECT ".$id." 
								   FROM ".$table." 
								   WHERE countries_id = '$countryId'
								   AND province_id = '$pId'
								   AND county_id	= '$cId'
								   AND town_id	= '$tId'";
					}
					else
					{
						$sql	= "SELECT ".$id." 
								   FROM ".$table." 
								   WHERE countries_id = '$countryId'
								   AND province_id = '$pId'
								   AND county_id	= '$cId'";
					}
				}
				else
				{
					$sql	= "SELECT ".$id." FROM ".$table." WHERE countries_id = '$countryId' AND  province_id = '$pId'";
				}
				
			}
			else
			{
				$sql	= "SELECT ".$id." FROM ".$table." WHERE countries_id = '$countryId'";
			}
		}
		
		
		else
		{
			$sql	= "SELECT ".$id." FROM ".$table."";
		}
		
		$query = mysql_query($sql);
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
	
	/**
	*	Search by country. Which can be use in any other search.
	*	
	*	@param
	*			$cId		Country id
	*			$id			Id to search
	*			$table		Table to perform search
	*
	*	@return array
	*/
	function getByCountry($cId, $id, $table)
	{
		$cId = mysql_real_escape_string((int)$cId);
				
		if($cId > 0)
		{
			$sql	= "SELECT ".$id." FROM ".$table." WHERE countries_id = '$cId'";
		}
		else
		{
			$sql	= "SELECT ".$id." FROM ".$table."";
		}
		
		 $query = mysql_query($sql);
		 $data = array();
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
	
	
	

	##################################################################################################################
	#
	#      									Search Testimonial or Guest Rating
	#
	##################################################################################################################
	
	/**
	*	Search guest rating or customer testimonial. We need to perform full text search.
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getTestimonialByKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT guest_id FROM guest";
		}
		else
		{
			$sql =  "SELECT guest_id,
					MATCH(name, designation, email, address, comments, person_img)
  					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  guest
					WHERE 
					MATCH(name, designation, email, address, comments, person_img)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->guest_id;
			
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
	
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////
	//
	//      		************* Customer Search ***********************
	//
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	
	/**
	*	Search the Customer
	*
	*	@param
	*			$keyword	Keyword to search
	*			$loc		Location
	*			$status		Status
	*
	*	@return array
	*/
	function searchCus($keyword, $status,$loc)//  $cId,
	{
		$statRes	= $this->getCusStatus($status);
		$locRes		= $this->getCusLoc($loc);
		$keyRes		= $this->getCusKeyword($keyword);
		
		
		
		$final  	= array_intersect($statRes, $locRes, $keyRes);
		
		//$gender, $occ_id, 
		//echo count($statRes)."<br>".count($genRes)."<br>".count($occRes)."<br>".count($cntRes).
			 //"<br>".count($locRes)."<br>".count($keyRes)."<br>".count($final)."<br>";
		return $final;
	}//eof
	
	
	/**
	*	Search Customer by key word only
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getCusKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT customer_id FROM customer";
		}
		else
		{
			$sql =  "SELECT customer_id,
					MATCH( member_id, user_name, email, fname, lname, image, brief, description, organization, profession,
						   verification_no,  verified_by )
					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  customer
					WHERE 
					MATCH( member_id, user_name, email, fname, lname, image, brief, description, organization, profession,
						   verification_no,  verified_by)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->customer_id;
			
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
	*	Search Customer by location only
	*
	*	@param
	*			$loc	Location to search
	*
	*	@return array
	*/
	function getCusLoc($loc)
	{
		$loc 	= mysql_real_escape_string($loc);
		
		if($loc == '')
		{
			$sql =  "SELECT customer_id FROM customer_address";
		}
		else
		{
			$sql =  "SELECT customer_id,
					MATCH( address1, address2, address3, town, province, postal_code, phone1, phone2,
						   fax, mobile)
					AGAINST ('$loc' IN BOOLEAN MODE) AS score FROM  customer_address
					WHERE 
					MATCH(address1, address2, address3, town, province, postal_code, phone1, phone2,
						  fax, mobile)
					AGAINST ('$loc' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->customer_id;
			
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
	*	Get Customer by status only
	*
	*	@return array
	*/
	function getCusStatus($status)
	{
		 if($status != '')
		 {
		 	$sql =  "SELECT customer_id FROM customer WHERE status='$status'";
		 }
		 else
		 {
		 	$sql =  "SELECT customer_id FROM customer";
		 }
		 $query = mysql_query($sql);
		 $data = array();
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->customer_id;
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
	*	Get Customer by gender
	*
	*	@return array
	*/
	function getCusGender($gender)
	{
		 if($gender != '')
		 {
		 	$sql =  "SELECT customer_id FROM customer WHERE gender='$gender'";
		 }
		 else
		 {
		 	$sql =  "SELECT customer_id FROM customer";
		 }
		 $query = mysql_query($sql);
		 $data = array();
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->customer_id;
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
	*	Get Customer by occupation
	*
	*	@param
	*			$occ_id		Occupation Id
	*	@return array
	*/
	function getCusOcc($occ_id)
	{
		 if($occ_id > 0)
		 {
		 	$sql =  "SELECT customer_id FROM customer WHERE occ_id='$occ_id'";
		 }
		 else
		 {
		 	$sql =  "SELECT customer_id FROM customer";
		 }
		 $query = mysql_query($sql);
		 $data = array();
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->customer_id;
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
	
	
	##################################################################################################################
	#
	#      									Search Contact 
	#
	##################################################################################################################
	
	/**
	*	Search contact from the users.
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function searchContact($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT contact_id FROM contact";
		}
		else
		{
			$sql =  "SELECT contact_id,
					MATCH(name, designaton, company, address, postal_code, city,state, country, phone, fax, email, remarks)
  					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  contact
					WHERE 
					MATCH(name, designaton, company, address, postal_code, city,state, country, phone, fax, email, remarks)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->contact_id;
			
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
	
	##################################################################################################################
	#
	#      									Search Order
	#
	##################################################################################################################

	
	
	/*
		SEARCH PRODUCT
	*/
	function searchOrder($mode, $keyword, $type)
	{
		
		$keyword = mysql_real_escape_string($keyword);
		//echo "in search";
		switch ($type) {
		case 'name' :
			$sql =  "SELECT orders_code,
               		MATCH(orders_code,delivery_name,delivery_address1,delivery_address2,delivery_city,
    				delivery_postcode,delivery_phone,delivery_state,billing_name,billing_address1,
   					billing_address2, billing_city,billing_postcode,billing_phone, billing_state)
               		AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  orders
               		WHERE 
			   		MATCH(orders_code,delivery_name,delivery_address1,delivery_address2,delivery_city,
    				delivery_postcode,delivery_phone,delivery_state,billing_name,billing_address1,
   					billing_address2, billing_city,billing_postcode,billing_phone, billing_state)
				    AGAINST ('$keyword' IN BOOLEAN MODE) 
				    ORDER BY score DESC"; 
			break;	
		case 'product' :
			$sql =  "SELECT *
					FROM  orders, product_description , orders_products
               		WHERE 
					orders.orders_id = orders_products.orders_id
					AND  orders_products.product_id = product_description.product_id
					AND ((product_description.product_name like '%$keyword%') OR (product_description.product_description like '%$keyword%'))
				    ORDER BY product_description.product_name;"; 
			break;
			/*
			MATCH(orders_code,delivery_name,delivery_address1,delivery_address2,delivery_city,
    				delivery_postcode,delivery_phone,delivery_state,billing_name,billing_address1,
   					billing_address2, billing_city,billing_postcode,billing_phone, billing_state,product_name,
   					product_description)
               		AGAINST ('$keyword' IN BOOLEAN MODE) AS score 
			MATCH(orders_code,delivery_name,delivery_address1,delivery_address2,delivery_city,
    				delivery_postcode,delivery_phone,delivery_state,billing_name,billing_address1,
   					billing_address2, billing_city,billing_postcode,billing_phone, billing_state,product_name,
   					product_description)
				    AGAINST ('$keyword' IN BOOLEAN MODE)
			*/
		case 'customer' :
			$sql =  "SELECT orders_code,
               		MATCH(orders_code,delivery_name,delivery_address1,delivery_address2,delivery_city,
    				delivery_postcode,delivery_phone,delivery_state,billing_name,billing_address1,
   					billing_address2, billing_city,billing_postcode,billing_phone, billing_state)
               		AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  orders, customer
               		WHERE 
			   		MATCH(orders_code,delivery_name,delivery_address1,delivery_address2,delivery_city,
    				delivery_postcode,delivery_phone,delivery_state,billing_name,billing_address1,
   					billing_address2, billing_city,billing_postcode,billing_phone, billing_state)
				    AGAINST ('$keyword' IN BOOLEAN MODE)
					AND  orders.customer_id = customer.customer_id
				    ORDER BY score DESC"; 
			break;
		default :
			$sql =  "SELECT orders_code,
               		MATCH(orders_code,delivery_name,delivery_address1,delivery_address2,delivery_city,
    				delivery_postcode,delivery_phone,delivery_state,billing_name,billing_address1,
   					billing_address2, billing_city,billing_postcode,billing_phone, billing_state)
               		AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  orders
               		WHERE 
			   		MATCH(orders_code,delivery_name,delivery_address1,delivery_address2,delivery_city,
    				delivery_postcode,delivery_phone,delivery_state,billing_name,billing_address1,
   					billing_address2, billing_city,billing_postcode,billing_phone, billing_state)
				    AGAINST ('$keyword' IN BOOLEAN MODE) 
				    ORDER BY score DESC"; 
		}//end of switch		
		
		 $query = mysql_query($sql);
		 $data = array();
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->orders_code;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//END OF SEARCHING DATA BY ORDER
	
	
	
	/**
	*	Search orders from the orders.
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getOrderKeyword($keyword)
	{
		//declare vars
		 $data  = array();
		 
		//put security
		$keyword = mysql_real_escape_string($keyword);
		
		//create the statement
		if($keyword == '')
		{
			$sql =  "SELECT orders_id FROM orders";
		}
		else
		{
			$sql =  "SELECT orders_id,
					MATCH(orders_code,trxn_id,email,billing_name,billing_email, billing_address_1, billing_postal_code,billing_city,
					billing_province,billing_phone,shipping_name, shipping_email,shpping_address_1,shpping_city, shpping_province, shpping_phone)
  					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  orders
					WHERE 
					MATCH(orders_code,trxn_id,email,billing_name,billing_email, billing_address_1, billing_postal_code,billing_city,
					billing_province,billing_phone,shipping_name, shipping_email,shpping_address_1,shpping_city, shpping_province, shpping_phone)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		//execute query
		$query = mysql_query($sql);
		 
		 
		 //echo $sql;exit;
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

	
	
	
	/**
	*	Get Order by Payment Id
	*
	*	@param
	*			$pmId				Payment method id
	*
	*	@return array
	*/
	function getPaymentOrder($pmId)
	{
		//add security
		$pmId = mysql_real_escape_string($pmId);
		
		 if($pmId != '')
		 {
		 	$sql =  "SELECT orders_id FROM orders WHERE payment_method_id= '$pmId' ";
		 }
		 else
		 {
		 	$sql =  "SELECT orders_id FROM orders";
		 }
		
		 $query = mysql_query($sql);
		 $data = array();
		 
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

	
	
	
		
		/**
	*	Get Order by Payment Id
	*
	*	@return array
	*/
	function getCCName($creditCardType)
	{
		$sql =  "SELECT orders_id FROM orders";
		/* if($creditCardType != '')
		 {
		 	$sql =  "SELECT orders_id FROM orders WHERE cc_name='$creditCardType'";
		 }
		 else
		 {
		 	$sql =  "SELECT orders_id FROM orders";
		 }*/
		 $query = mysql_query($sql);
		 $data = array();
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

	
	
			/**
	*	Get Order by Payment Id
	*
	*	@return array
	*/
	function getOrderByStatus($selOrderStatus)
	{
		 if($selOrderStatus != 0)
		 {
		 	$sql =  "SELECT orders_id FROM orders WHERE orders_status_id =$selOrderStatus";
		 }
		 else
		 {
		 	$sql =  "SELECT orders_id FROM orders";
		 }
		 $query = mysql_query($sql);
		 $data = array();
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

	
	###############################################################################################################
	#
	#						Search for Shipping Quotation
	#
	###############################################################################################################
	
	/**
	*	Search the Shipping Quotation
	*
	*	@param
	*			$keyword	Keyword to search
	*			$loc		Location
	*			$status		Status
	*
	*	@return array
	*/
	function searchQuote($keyword, $status,$quotation_code)//  $cId,
	{
		$statRes		= $this->getQuoteStatus($status);
		$quoteRes		= $this->getQuoteCode($quotation_code);
		$keyRes			= $this->getQuotKeyword($keyword);
		
		
		
		$final  	= array_intersect($statRes, $quoteRes, $keyRes);
		
		//$gender, $occ_id, 
		//echo count($statRes)."<br>".count($genRes)."<br>".count($occRes)."<br>".count($cntRes).
			 //"<br>".count($locRes)."<br>".count($keyRes)."<br>".count($final)."<br>";
		return $final;
	}//eof
	
	
	/**
	*	Search the Shipping Quotation
	*
	*	@param
	*			$keyword	Keyword to search
	*			$loc		Location
	*			$status		Status
	*
	*	@return array
	*/
	function searchQuoteCode($quotation_code)//  $cId,
	{
		$quoteRes		= $this->getQuoteCode($quotation_code);
		$final  	= array_intersect($quoteRes);
		return $final;
	}//eof
	
	
	/**
	*	Get Shipping Quotation by status only
	*
	*	@return array
	*/
	function getQuoteStatus($status)
	{
		 if($status != '')
		 {
		 	$sql =  "SELECT shipping_quotation_id FROM shipping_quotation WHERE status='$status'";
		 }
		 else
		 {
		 	$sql =  "SELECT shipping_quotation_id FROM shipping_quotation";
		 }
		 $query = mysql_query($sql);
		 $data = array();
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->shipping_quotation_id;
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
	*	Search Quotation by location only
	*
	*	@param
	*			$loc	Location to search
	*
	*	@return array
	*/
	function getQuoteLoc($loc)
	{
		$loc 	= mysql_real_escape_string($loc);
		
		if($loc == '')
		{
			$sql =  "SELECT shipping_quotation_address_id FROM shipping_quotation_address";
		}
		else
		{
			$sql =  "SELECT shipping_quotation_address_id,
					MATCH( origin_port, origin_addrress1, origin_addrress2, origin_addrress3, origin_town, origin_province, destination_port, destination_address1, destination_address2, destination_address3, destination_town, destination_province, destination_phone1, destination_mobile, origin_phone1, origin_mobile  )
					AGAINST ('$loc' IN BOOLEAN MODE) AS score FROM  shipping_quotation_address
					WHERE 
					MATCH(origin_port, origin_addrress1, origin_addrress2, origin_addrress3, origin_town, origin_province, destination_port, destination_address1, destination_address2, destination_address3, destination_town, destination_province, destination_phone1, destination_mobile, origin_phone1, origin_mobile)
					AGAINST ('$loc' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->shipping_quotation_address_id;
			
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
	*	Get Shipping by status only
	*
	*	@return array
	*/
	function getQuoteCode($quotation_code)
	{
		 if($quotation_code != '')
		 {
		 	$sql =  "SELECT shipping_quotation_id FROM shipping_quotation WHERE quotation_code='$quotation_code'";
		 }
		 else
		 {
		 	$sql =  "SELECT shipping_quotation_id FROM shipping_quotation";
		 }
		 $query = mysql_query($sql);
		 $data = array();
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->shipping_quotation_id;
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
	*	Search Customer by key word only
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getQuotKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT shipping_quotation_id FROM shipping_quotation";
		}
		else
		{
			$sql =  "SELECT shipping_quotation_id,
					MATCH( categories_id, shipping_container_size_id, full_name, email, phone, enquiry_desc, 
					goods_type, pickup_require,quotation_code)
					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  shipping_quotation
					WHERE 
					MATCH( categories_id, shipping_container_size_id, full_name, email, phone, enquiry_desc, 
					goods_type, pickup_require,quotation_code)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->shipping_quotation_id;
			
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
	
	
	######################################################################################################################
	#
	#									Shipping Search
	#
	######################################################################################################################
	
	
	/**
	*	Search the Shipping
	*
	*	@param
	*			$keyword	Keyword to search
	*			$loc		Location
	*			$status		Status
	*
	*	@return array
	*/
	function searchShipping($keyword, $shipping_code)
	{
		$codeRes	= $this->getShippingCode($shipping_code);
		//$locRes		= $this->getShippingLoc($loc);
		$keyRes		= $this->getShipKeyword($keyword);
		
		
		
		$final  	= array_intersect($codeRes, $keyRes);
		
		//$gender, $occ_id, 
		//echo count($statRes)."<br>".count($genRes)."<br>".count($occRes)."<br>".count($cntRes).
			 //"<br>".count($locRes)."<br>".count($keyRes)."<br>".count($final)."<br>";
		return $final;
	}//eof
	
	
	/**
	*	Get Shipping by status only
	*
	*	@return array
	*/
	function getShippingCode($shipping_code)
	{
		 if($shipping_code != '')
		 {
		 	$sql =  "SELECT shipping_id FROM shipping WHERE shipping_code='$shipping_code'";
		 }
		 else
		 {
		 	$sql =  "SELECT shipping_id FROM shipping";
		 }
		 $query = mysql_query($sql);
		 $data = array();
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->shipping_id;
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
	*	Search by location only
	*
	*	@param
	*			$loc	Location to search
	*
	*	@return array
	*/
	function getShippingLoc($loc)
	{
		$loc 	= mysql_real_escape_string($loc);
		
		if($loc == '')
		{
			$sql =  "SELECT shipping_address_id FROM shipping_address";
		}
		else
		{
			$sql =  "SELECT shipping_address_id,
					MATCH( origin_port, origin_addrress1, origin_addrress2, origin_addrress3, origin_town, origin_province, destination_port, destination_address1, destination_address2, destination_address3, destination_town, destination_province, destination_phone1, destination_mobile, origin_phone1, origin_mobile , origin_postal_code, destination_postal_code )
					AGAINST ('$loc' IN BOOLEAN MODE) AS score FROM  shipping_address
					WHERE 
					MATCH(origin_port, origin_addrress1, origin_addrress2, origin_addrress3, origin_town, origin_province, destination_port, destination_address1, destination_address2, destination_address3, destination_town, destination_province, destination_phone1, destination_mobile, origin_phone1, origin_mobile, origin_postal_code, destination_postal_code)
					AGAINST ('$loc' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->shipping_address_id;
			
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
	*	Search shipping by key word only
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getShipKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT shipping_id FROM shipping";
		}
		else
		{
			$sql =  "SELECT shipping_id,
					MATCH( categories_id, container, shipping_booking, bill_lading_number, full_name, email, phone, shipping_code)
					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  shipping
					WHERE 
					MATCH( categories_id, container, shipping_booking, bill_lading_number, full_name, email, phone, shipping_code)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->shipping_id;
			
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
	*	Search shipping by key word only
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getShippingKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT shipping_id FROM shipping";
		}
		else
		{
			$sql =  "SELECT shipping_id,
					MATCH(container, shipping_booking, bill_lading_number, full_name, email, phone, shipping_code)
					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  shipping
					WHERE 
					MATCH(container, shipping_booking, bill_lading_number, full_name, email, phone, shipping_code)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 //echo $sql.mysql_error();exit;
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->shipping_id;
			
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
	*	Search the Shipping
	*
	*	@param
	*			$keyword	Keyword to search
	*			$loc		Location
	*			$status		Status
	*
	*	@return array
	*/
	function searchShippingByKey($keyword)
	{
		//$codeRes	= $this->getShippingCode($shipping_code);
		//$locRes		= $this->getShippingLoc($loc);
		$keyRes		= $this->getShippingKeyword($keyword);
		
		//$final  	= array_intersect($keyRes);
		
		//$gender, $occ_id, 
		//echo count($statRes)."<br>".count($genRes)."<br>".count($occRes)."<br>".count($cntRes).
			 //"<br>".count($locRes)."<br>".count($keyRes)."<br>".count($final)."<br>";
		return $keyRes;
	}//eof
	
	
	
	/**
	*	Search product keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProductKeyword1($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT product_id FROM product";
		}
		else
		{
			$sql =  "SELECT product_id,
					MATCH(title, page_title, description, brief)
					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  product
					WHERE 
					MATCH(title, page_title, description, brief)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->product_id;
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
	*	Search thread keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getThreadKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT thread_id FROM thread";
		}
		else
		{
			$sql = "SELECT thread_id
					FROM   thread
					WHERE (thread_name LIKE '%$keyword%' OR
						   lastdate LIKE '%$keyword%%' );";	
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->thread_id;
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
	*	========================Search dyeing pipeline=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProductKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT dyeing_id FROM dyeing_table";
		}
		else
		{
			$sql = "SELECT dyeing_id
					FROM   dyeing_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						   bill_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	
	function getProductKeywordstore($keyword,$userId)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT dyeing_id FROM dyeing_table where store_managerId='$userId'";
		}
		else
		{
			$sql = "SELECT dyeing_id
					FROM   dyeing_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						   bill_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%') AND store_managerId='$userId';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	*	Search product status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProductTableKeyword($keyword,$userid)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT status_id FROM status_table where employee_id ='$userid'";
		}
		else
		{
			$sql = "SELECT status_id
					FROM   status_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employee_id LIKE '%$keyword%' OR
						   dyeing LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   hand LIKE '%$keyword%' OR
						   manual LIKE '%$keyword%' OR
						   computer LIKE '%$keyword%' OR
						   kcutting LIKE '%$keyword%' OR
						   fstiching LIKE '%$keyword%' OR
						   iron LIKE '%$keyword%' OR
						   packing LIKE '%$keyword%' OR
						   status LIKE '%$keyword%' OR
						   target_date LIKE '%$keyword%' OR
						   order_date LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%%') AND employee_id ='$userid';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	*	Search product status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProdTableKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT status_id FROM status_table";
		}
		else
		{
			$sql = "SELECT status_id
					FROM   status_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employee_id LIKE '%$keyword%%' OR
						   dyeing LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						   hand LIKE '%$keyword%' OR
						   manual LIKE '%$keyword%%' OR
						   computer LIKE '%$keyword%%' OR
						   kcutting LIKE '%$keyword%%' OR
						   fstiching LIKE '%$keyword%%' OR
						   iron LIKE '%$keyword%%' OR
						   packing LIKE '%$keyword%%' OR
						   status LIKE '%$keyword%%' OR
						   target_date LIKE '%$keyword%%' OR
						   order_date LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	
	
	
/////////////////////////////////////////////////////////////////////////////////////////////
	//
	//      		************* Product Search ***********************
	//
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	
	/**
	*	Search the Product
	*
	*	@param
	*			$keyword			Keyword to search
	*			$categories_id		Category id
	*			
	*
	*	@return array
	*/
	function searchProdByCatAndKey($keyword, $catId)
	{
		//declare var
		$final	= array();
		
		//get result by keyword
		$keyRes		= $this->searchProd($keyword);
		
		
		//get key result category
		$catRes		= $this->getAllProdIdByCat($catId);
	
		//print_r($catRes);exit;
		if( ($catId == 0) && ($keyword == '') )
		{
			$final	= array();
		}
		else if( ($catId != 0) && ($keyword == '') )
		{
			$final  = $catRes;
		}
		else if( ($catId == 0) && ($keyword != '') )
		{
			$final 	= $keyRes;
		}
		else
		{
			$final	= array_intersect($keyRes, $catRes);
		}
	
		//return the final result
		return $final;
	}//eof
	
	
		
	/**
	*	Search a product by keyword
	*
	*	@date September 1, 2010
	*
	*	@param
	*			$keyword		Search keyword
	*
	*	@return array
	*/
	function searchProd($keyword)
	{
		
		//declare var
		$data = array();
		$keyword = mysql_real_escape_string($keyword);
		
		//statement
		$sql =  "SELECT product_id,
				 MATCH(product_name, product_code, product_description, product_tags, meta_description)
				 AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  product_description
				 WHERE 
				 MATCH(product_name, product_code, product_description, product_tags, meta_description)
				 AGAINST ('$keyword' IN BOOLEAN MODE) 
				 ORDER BY score DESC"; 
			
		
		
		//execute query
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query) <= 0)
		{
			//write a new statement
			$sql =  "SELECT 	product_id
					 FROM 		product_description
					 WHERE		product_name LIKE '%$keyword%'
					 OR			product_code LIKE '%$keyword%'
					 OR			product_description LIKE '%$keyword%'
					 OR			product_tags LIKE '%$keyword%'
					 OR			meta_description LIKE '%$keyword%'
					 ";
			
			//query
			$query = mysql_query($sql);
			
		}
				 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->product_id;
		 }
		 
		  //echo $sql;
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
		 
		 
	}//END OF SEARCHING DATA BY PRODUCT
	
	
	
		
	/**
	*	Search products id by category id
	*
	*	@param	
	*			$catId		Category id
	*
	*	@return array
	*/
	
/*	function getAllProdIdByCat($catId)
	{
		$catId = mysql_real_escape_string((int)$catId);
		$parentCat 	= array($catId);
		$childIds  	= $this->getProdChildCat(NULL, $catId, $recursive = true);
		$allCat	   	= array_merge($parentCat,$childIds );
		//echo "Cat Res = ";print_r($allCat);echo "<br /><br />";
		$data	   	= array();
		foreach ($allCat as $k)
		{
			$select = " SELECT 	DISTINCT P.product_id AS PID
						FROM 	products P, 
								products_to_categories PC,
								categories C
						WHERE 	PC.categories_id  = C.categories_id  
						AND 	C.categories_id ='$k'";
						
			$query  = mysql_query($select);
			
			if(mysql_num_rows($query) > 0)
			{
				while($result = mysql_fetch_array($query))
				{	
					$data[] = $result['PID'];
				}
			}
		}
		
		return $data;
	}*/
	
	
	
	/**
	*	Search products id by category id
	*
	*	@param	
	*			$catId		Category id
	*
	*	@return array
	*/
	
	function getAllProdIdByCat($catId)
	{
		$data = array();
		
		$select = " SELECT product_id
					FROM products_to_categories 
					WHERE categories_id	= '$catId'";
					
		$query  = mysql_query($select);
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{	
				$data[] = $result->product_id;
			}
		}
	
		return $data;
	}
	
	
	
	/**
	*	Get All category and sub category
	*/
	function getProdChildCat($categories, $id, $recursive = true)
	{
		if ($categories == NULL) {
			$categories = $this->getProdCategories();
		}
		$id_arr = array($id);
		$n     = count($categories);
		$child = array();
		for ($i = 0; $i < $n; $i++) {
			$catId    = $categories[$i]['categories_id'];
			$parentId = $categories[$i]['parent_id'];
			if ($parentId == $id) {
				$child[] = $catId;
				if ($recursive) {
					$child   = array_merge($child, $this->getProdChildCat($categories, $catId));
				}	
			}
		}
		
		return $child;
	}
	
	function getProdCategories()
	{
		$sql = "SELECT   categories_id, parent_id
				FROM     categories
				ORDER BY categories_id, parent_id ";
		$result = mysql_query($sql);
		
		$cat = array();
		while ($row = mysql_fetch_array($result)) {
			$cat[] = $row;
		}
		
		return $cat;
	}
	
	/**
	*	Search all farmer by key word only
	*
	*	@param
	*			$keyword	Keyword to search getUserKeyword
	*
	*	@return array
	*/
	function getFarmerKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT customer_id FROM customer WHERE customer_type_id = 1 OR customer_type_id = 7 OR customer_type_id = 8";
		}
		else
		{
			$sql =  "SELECT customer_id,
					MATCH(fname, lname, image, brief, description, organization)
					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  customer
					WHERE 
					MATCH(fname, lname, image, brief, description, organization)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					AND customer_type_id = 1 OR customer_type_id = 7 OR customer_type_id = 8
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 //echo $sql.mysql_error();exit;
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->customer_id;
			
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
	*	Search all user by key word only
	*
	*	@param
	*			$keyword	Keyword to search 
	*
	*	@return array
	*/
	function getUserKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT customer_id FROM customer";
		}
		else
		{
			$sql =  "SELECT customer_id,
					MATCH(fname, lname, image, brief, description, organization)
					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  customer
					WHERE 
					MATCH(fname, lname, image, brief, description, organization)
					AGAINST ('$keyword' IN BOOLEAN MODE)
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 //echo $sql.mysql_error();exit;
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->customer_id;
			
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
	*	Search all buyer by key word only
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getBuyerKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT customer_id FROM customer WHERE customer_type_id = 2";
		}
		else
		{
			$sql =  "SELECT customer_id,
					MATCH( member_id, user_name, email, fname, lname, image, brief, description, organization, profession,
						   verification_no,  verified_by )
					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  customer
					WHERE 
					MATCH( member_id, user_name, email, fname, lname, image, brief, description, organization, profession,
						   verification_no,  verified_by)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					AND customer_type_id = 2
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 //echo $sql.mysql_error();exit;
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->customer_id;
			
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
	*	Search the farmer
	*
	*	@param
	*			$keyword	Keyword to search
	*			$pId		Province id
	*			$tId		Town id
	*			$cId		County id
	*
	*	@return array
	*/
	function searchFarmer($keyword, $countryId, $pId, $cId, $tId, $prodId, $prodTypeId)
	{
		$keyRes		= $this->getFarmerKeyword($keyword);
		$locRes		= $this->getByLocation2($countryId, $pId, $cId, $tId, 'customer_id', 'customer_address');
		$actvRes	= $this->getAllCustomerId();
		
		if($prodId > 0)
		{
			$prodRes	= $this->getCusIdByProd($prodId);
		}
		else
		{
			$prodRes	= $this->getAllCustomerId();
		}
		
		if($prodTypeId > 0)
		{
			if($prodId > 0)
			{
				$sql =  "SELECT DISTINCT customer_id
						 FROM product_to_customer_detail
						 WHERE product_type_id = '$prodTypeId'
						 AND product_id	= '$prodId' ";
			}
			else
			{
				$sql =  "SELECT DISTINCT customer_id
						 FROM product_to_customer_detail
						 WHERE product_type_id = '$prodTypeId'";
			}
			
				$query = mysql_query($sql);
				//echo $sql.mysql_error();exit;
				$typeRes  		= array();
				
				while($result 	= mysql_fetch_object($query))
				{
					$typeRes[] 	= $result->customer_id;
				} 
			
		}
		
		else
		{
			$typeRes	= $this->getAllCustomerId();
		}
		

		$final  = array_intersect($keyRes, $locRes, $actvRes, $prodRes, $typeRes);
		
		return $final;
	}
	
	
	/**
	*	Search the farmer
	*
	*	@param
	*			$keyword	Keyword to search
	*			$pId		Province id
	*			$tId		Town id
	*			$cId		County id
	*
	*	@return array
	*/
	function searchUser($keyword, $countryId, $pId, $cId, $tId, $prodId, $prodTypeId, $cusTypeId)
	{
		$keyRes		= $this->getUserKeyword($keyword);
		$locRes		= $this->getByLocation2($countryId, $pId, $cId, $tId, 'customer_id', 'customer_address');
		$actvRes	= $this->getAllCustomerId();
		
		if($cusTypeId == 0)
		{
			$cusTypeRes			= $this->getAllCustomerId();
		}
		else
		{
			$cusTypeRes			= $this->getCustomerByTypeId($cusTypeId);
		}
		
		if($prodId > 0)
		{
			$prodRes	= $this->getCusIdByProd($prodId);
		}
		else
		{
			$prodRes	= $this->getAllCustomerId();
		}
		
		if($prodTypeId > 0)
		{
			if($prodId > 0)
			{
				$sql =  "SELECT DISTINCT customer_id
						 FROM product_to_customer_detail
						 WHERE product_type_id = '$prodTypeId'
						 AND product_id	= '$prodId' ";
			}
			else
			{
				$sql =  "SELECT DISTINCT customer_id
						 FROM product_to_customer_detail
						 WHERE product_type_id = '$prodTypeId'";
			}
			
				$query = mysql_query($sql);
				//echo $sql.mysql_error();exit;
				$typeRes  		= array();
				
				while($result 	= mysql_fetch_object($query))
				{
					$typeRes[] 	= $result->customer_id;
				} 
			
		}
		
		else
		{
			$typeRes	= $this->getAllCustomerId();
		}
		
		//print_r($cusTypeRes);exit;
		

		$final  = array_intersect($keyRes, $locRes, $actvRes, $prodRes, $typeRes, $cusTypeRes);
		
		return $final;
	}
	
	/**
	*	Search the buyer
	*
	*	@param
	*			$keyword	Keyword to search
	*			$pId		Province id
	*			$tId		Town id
	*			$cId		County id
	*
	*	@return array
	*/
	function searchBuyer($keyword, $countryId, $pId, $cId, $tId)
	{
		$keyRes		= $this->getBuyerKeyword($keyword);
		$locRes		= $this->getByLocation2($countryId, $pId, $cId, $tId, 'customer_id', 'customer_address');
		$actvRes	= $this->getAllCustomerId();
				

		$final  = array_intersect($keyRes, $locRes, $actvRes);
		
		return $final;
	}
	

	/**
	*	Search News by key word only
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function searchNews($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT news_id FROM news";
		}
		else
		{
			$sql =  "SELECT news_id,
					MATCH( title, summary)
					AGAINST ('$keyword' IN BOOLEAN MODE) AS score FROM  news
					WHERE 
					MATCH( title, summary)
					AGAINST ('$keyword' IN BOOLEAN MODE) 
					ORDER BY score DESC"; 
		}
		
		 $query = mysql_query($sql);
		 $data  = array();
		 
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->news_id;
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
	
	/*####################################################################################################################*/
	
	/*                          stock product search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search product status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getStockKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT stock_id FROM stock ";
		}
		else
		{
			$sql = "SELECT stock_id
					FROM   stock
					WHERE (stock_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   stock LIKE '%$keyword%' OR
						   product_in LIKE '%$keyword%' OR
						   sales LIKE '%$keyword%' OR
						   net_sales LIKE '%$keyword%' OR
						   goods_return LIKE '%$keyword%' OR
						   add_date LIKE '%$keyword%' 
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->stock_id;
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
	
	
	/*####################################################################################################################*/
	
	/*                          stock product colour                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search product colour status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProductColourKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT pcolour_id FROM product_color ";
		}
		else
		{
			$sql = "SELECT pcolour_id
					FROM   product_color
					WHERE (pcolour_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   pcolour LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' 
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->pcolour_id;
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
	*	Search product colour status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getColourMstKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT colour_id FROM colour_mst ";
		}
		else
		{
			$sql = "SELECT colour_id
					FROM   colour_mst
					WHERE (colour_id LIKE '%$keyword%' OR
						   colour_name LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' 
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->colour_id;
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
	
	/*####################################################################################################################*/
	
	/*                           product Sales search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search product status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSalesProdKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT sales_id FROM product_sales ";
		}
		else
		{
			$sql = "SELECT sales_id
					FROM   product_sales
					WHERE (sales_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   sale_colour LIKE '%$keyword%' OR
						   company LIKE '%$keyword%' OR
						   address LIKE '%$keyword%' OR
						   contact_no LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%'
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->sales_id;
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
	
	/*####################################################################################################################*/
	
	/*                          stock product Details search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search product status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getStockDtlKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT stock_dtl_id FROM stock_details ";
		}
		else
		{
			$sql = "SELECT stock_dtl_id
					FROM   stock_details
					WHERE (stock_dtl_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   colour LIKE '%$keyword%' OR
						   quantity LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->stock_dtl_id;
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
	
	
	
	/*####################################################################################################################*/
	
	/*                          Goods return  search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search product status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getGoodsReturnKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT greturn_id FROM goods_return ";
		}
		else
		{
			$sql = "SELECT greturn_id
					FROM   goods_return
					WHERE (greturn_id LIKE '%$keyword%' OR
						   grcolour LIKE '%$keyword%' OR
						   party_code LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->greturn_id;
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
	
	
	/*####################################################################################################################*/
	
	/*                          Product in  search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search product status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProductInKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT product_in_id FROM product_in ";
		}
		else
		{
			$sql = "SELECT product_in_id
					FROM   product_in
					WHERE (product_in_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   colour LIKE '%$keyword%' OR
						   bil_no LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->product_in_id;
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
	
	/*####################################################################################################################*/
	
	/*                          stich rate search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search Stich Rate keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getStichRateKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT rate_id FROM stich_rate ";
		}
		else
		{
			$sql = "SELECT rate_id
					FROM   stich_rate
					WHERE (rate_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   particulars LIKE '%$keyword%' OR
						   particular_rate LIKE '%$keyword%' 
						    
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->rate_id;
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
	*	Search Stitch Particular Rate keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getStitchPartRateKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT rate_id FROM stich_particular_rate ";
		}
		else
		{
			$sql = "SELECT rate_id
					FROM   stich_particular_rate
					WHERE (rate_id LIKE '%$keyword%' OR
						   particulars LIKE '%$keyword%' OR
						   particular_rate LIKE '%$keyword%' 
						    
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->rate_id;
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
	/*####################################################################################################################*/
	
	/*                          Labour details search                                                        */
	
	/*####################################################################################################################*/
	/**
	*	Search labour credit  keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getLabourCredit($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		//echo $keyword;exit;
		if($keyword =='')
		{
			$sql =  "SELECT final_stich_dtlid FROM final_stich_details ";
		}
		else
		
		{
			$sql = "SELECT final_stich_dtlid
					FROM   final_stich_details
					WHERE (
						   design_no LIKE '%$keyword%' OR
						   emp_id LIKE '%$keyword%' OR
						   emp_name LIKE '%$keyword%' OR
						   particular LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		
		
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->final_stich_dtlid;
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
	*	Search labour account details  keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getLabourDtl($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		//echo $keyword;exit;
		if($keyword =='')
		{
			$sql =  "SELECT labour_id FROM labour_table ";
		}
		else
		{
			$sql = "SELECT labour_id
					FROM   labour_table
					WHERE (
						   labour_id LIKE '%$keyword%' OR
						   labour_name LIKE '%$keyword%' OR
						   address LIKE '%$keyword%' OR
						   mobile LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->labour_id;
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
	*	Search labour payment account details  keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getLabourPayDtl($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		//echo $keyword;exit;
		if($keyword =='')
		{
			$sql =  "SELECT payment_id FROM payment_table ";
		}
		else
		{//echo $keyword;exit;
			$sql = "SELECT payment_id
					FROM   payment_table
					WHERE (
						   payment_id LIKE '%$keyword%' OR
						   labour_id LIKE '%$keyword%' OR
						   labour_name LIKE '%$keyword%' OR
						   payment_type LIKE '%$keyword%' OR
						   pay_amount LIKE '%$keyword%' OR
						   payment_by LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->payment_id;
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
	
	/*####################################################################################################################*/
	
	/*                          sample products details search                                                        */
	
	/*####################################################################################################################*/
	/**
	*	Search sample product  keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSampleProduct($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		//echo $keyword;exit;
		if($keyword =='')
		{
			$sql =  "SELECT sample_id FROM sample_db ";
		}
		else
		
		{
			$sql = "SELECT sample_id
					FROM   sample_db
					WHERE (
						   sample_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   emp_id LIKE '%$keyword%' OR
						   factory_id LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		
		
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->sample_id;
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
	
	/*####################################################################################################################*/
	
	/*                          Order details search                                                        */
	
	/*####################################################################################################################*/
	/**
	*	Search order  keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getOrdersProduct($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		//echo $keyword;exit;
		if($keyword =='')
		{
			$sql =  "SELECT orders_id FROM orders ";
		}
		else
		
		{
			$sql = "SELECT orders_id
					FROM   orders
					WHERE (
						   orders_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   party_name LIKE '%$keyword%' OR
						   brokar LIKE '%$keyword%' OR
						   retahol LIKE '%$keyword%' OR
						   form LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' 
						  
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
	
	
	
	
	/**
	*	========================Search hand pipeline=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getHandPipeline($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT hand_id FROM hand_table";
		}
		else
		{
			$sql = "SELECT hand_id
					FROM   hand_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						  status_id LIKE '%$keyword%%' OR
						  bill_no LIKE '%$keyword%%' OR
						  particulars LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->hand_id;
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
	
	
	function getHandPipelinestore($keyword,$userId)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT hand_id FROM hand_table where store_managerId='$userId'";
		}
		else
		{
			$sql = "SELECT hand_id
					FROM   hand_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						  status_id LIKE '%$keyword%%' OR
						  bill_no LIKE '%$keyword%%' OR
						  colour LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%') AND store_managerId='$userId';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->hand_id;
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
	*	========================Search manual pipeline=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getManualPipeline($keyword,$userId)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT manual_id FROM manual_table where store_managerId='$userId'";
		}
		else
		{
			$sql = "SELECT manual_id
					FROM   manual_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						  status_id LIKE '%$keyword%%' OR
						  bill_no LIKE '%$keyword%%' OR
						  colour LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%') AND store_managerId='$userId';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	*	========================Search computer pipeline=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getComputerPipeline($keyword,$userId)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT computer_id FROM computer_table where store_managerId='$userId'";
		}
		else
		{
			$sql = "SELECT computer_id
					FROM   computer_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
							order_date LIKE '%$keyword%%' OR
							target_date LIKE '%$keyword%%' OR
							status_id LIKE '%$keyword%%' OR
							bill_no LIKE '%$keyword%%' OR
							colour LIKE '%$keyword%%' OR
							added_on LIKE '%$keyword%%') AND store_managerId='$userId';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	*	========================Search finalstiching pipeline=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getFinalstichPipeline($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT final_stich_id FROM final_stich";
		}
		else
		{
			$sql = "SELECT final_stich_id
					FROM   final_stich
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						  status_id LIKE '%$keyword%%' OR
						  bill_no LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	
	
	
	
	function getFinalstichPipelinestore($keyword,$userid)
	{
		$keyword = mysql_real_escape_string($keyword);
		//echo $userid;exit;
		
		if($keyword == '')
		{
			$sql =  "SELECT final_stich_id FROM final_stich where store_managerId ='$userid'";
		}
		else
		{
			$sql = "SELECT final_stich_id
					FROM   final_stich
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						  status_id LIKE '%$keyword%%' OR
						  bill_no LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%') AND store_managerId ='$userid';";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	
	
	
	
	
	
	
	/**
	*	========================Search Kalicut pipeline=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProductKeywordKali($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT kalicut_id FROM kalicut_table";
		}
		else
		{
			$sql = "SELECT kalicut_id
					FROM   kalicut_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						   bill_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	*	========================Search iron pipeline=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProductKeywordiron($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT iron_id FROM iron_table";
		}
		else
		{
			$sql = "SELECT iron_id
					FROM   iron_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						   bill_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->iron_id;
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
	*	========================Search Kalicut pipeline=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getProductKeywordpack($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT packing_id FROM packing_table";
		}
		else
		{
			$sql = "SELECT packing_id
					FROM   packing_table
					WHERE (order_id LIKE '%$keyword%' OR
						   employeeId LIKE '%$keyword%%' OR
						   final_result LIKE '%$keyword%%' OR
						   design_no LIKE '%$keyword%%' OR
						   bill_no LIKE '%$keyword%%' OR
						  order_date LIKE '%$keyword%%' OR
						  target_date LIKE '%$keyword%%' OR
						   added_on LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->packing_id;
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
	*	========================Search for all=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSearchForAll($keyword,$type,$fromdt,$todt)
	{
		$keyword = mysql_real_escape_string($keyword);
		$type = mysql_real_escape_string($type);
		//echo $type;exit;
		if($keyword == '')
		{
			$sql =  "SELECT hand_id FROM hand_table";
		}
		else
		{
			$sql = "SELECT hand_id
					FROM   hand_table
					WHERE (".$type." LIKE '%$keyword%%' OR order_date BETWEEN '$fromdt' AND '$todt');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		// echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->hand_id;
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
	
	
	/*####################################################################################################################*/
	
	/*                          Fabric Details search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search Fabric status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getFabricDtlKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT fabric_id FROM fabric ";
		}
		else
		{
			$sql = "SELECT fabric_id
					FROM   fabric
					WHERE (fabric_id LIKE '%$keyword%' OR
						   fabric_name LIKE '%$keyword%' OR
						   fab_unit LIKE '%$keyword%' OR
						   fab_type LIKE '%$keyword%' OR
						   c_stock LIKE '%$keyword%' OR
						   lastdate LIKE '%$keyword%' OR
						   remark LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' OR
						   added_by LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->fabric_id;
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
	*	Search Fabric In  keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getFabricInKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT fabric_in_id FROM fabric_in ";
		}
		else
		{
			$sql = "SELECT fabric_in_id
					FROM   fabric_in
					WHERE (fabric_in_id LIKE '%$keyword%' OR
						   fabric_name LIKE '%$keyword%' OR
						   fab_amount LIKE '%$keyword%' OR
						   receive_by LIKE '%$keyword%' OR
						   company LIKE '%$keyword%' OR
						   bill_no LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' OR
						   added_by LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->fabric_in_id;
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
	*	Search Materials Out status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getMatOutKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT fabric_out_id FROM fabric_out ";
		}
		else
		{
			$sql = "SELECT fabric_out_id
					FROM   fabric_out
					WHERE (fabric_out_id LIKE '%$keyword%' OR
						   fabric_id LIKE '%$keyword%' OR
						   bill_no LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   fab_amount LIKE '%$keyword%' OR
						   purpose LIKE '%$keyword%' OR
						   receive_by LIKE '%$keyword%' OR
						   remark LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' OR
						   added_by LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->fabric_out_id;
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
	
	
	/*####################################################################################################################*/
	
	/*                          Sample photo gallery Details search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search sample photos gallery status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getSpGalleryKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT sample_gallery_id FROM sample_gallery ";
		}
		else
		{
			$sql = "SELECT sample_gallery_id
					FROM   sample_gallery
					WHERE (sample_gallery_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   title LIKE '%$keyword%' OR
						   dcolor LIKE '%$keyword%' OR
						   pprices LIKE '%$keyword%' OR
						   pstatus LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%' OR
						   added_by LIKE '%$keyword%' 
						  
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->sample_gallery_id;
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
?>             