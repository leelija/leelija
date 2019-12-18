<?php 
/**
*	Register a new user, edit or update registration information.
*
*	UPDATE	September 10, 2010
*	Customer type has been added to the system.
*
*
*	UPDATE	September 23, 2010
*	Customer verification has been added.
*
*
*	@author		Safikul Islam
*	@date		December 1, 2016
*	@update		September 23, 2010
*	@version	2.0
*	
* 
*/

include_once('encrypt.inc.php'); 
include_once('utility.class.php');


class Customer extends Utility
{
	/**
	*	Register a new Customer.
	*	
	*	@update	September 10, 2010
	*
	*
	*	@param
	*			$user_name			User Name
	*			$email				Customers Email
	*			$password			Access password, require later
	*			$fname				First name of the client
	*			$lname				last name of the client
	*			$gender				Gender of the client
	*			$dob				Date of birth of the client
	*			$status				Status of the login which determine whether a clinets account is active or inactive
	*			$brief				Brief introducttion of the client
	*			$description		Description of the client
	*			$organization		Organization associated with the client
	*			$featured			Whether featured client or not
	*			$sort_order			Sorting order
	*			$profession			Profession of the customer or client 
	*			$cus_type			Type of customer e.g. vendor 
	*			$discount_offered	Discount offered to this client
	*
	*	@return int  $dob, 
	*/
	function addCustomer($cus_type, $member_id, $user_name, $email, $password, $fname, $lname, $gender, $status, 
					     $brief, $description, $organization, $featured, $profession, $sort_order, $verification_no, 
						 $acc_verified, $discount_offered,$workas,$added_by)		  
	{
		//declare var
		$id	= 0;
		
		//get the values
		$email 				= trim($email);
		$password 			= trim($password);
		$fname 				= addslashes(trim($fname));
		$lname 				= addslashes(trim($lname));
		$user_name			= trim($user_name);
		$brief 				= addslashes(trim($brief));
		$description		= addslashes(trim($description));
		$organization		= addslashes(trim($organization));
		$sort_order			= (int)$sort_order;
		$profession			= addslashes(trim($profession));
		$cus_type			= (int)$cus_type;
		$discount_offered	= doubleval($discount_offered);
		$verified_by		= $_SESSION['USERfresh_2013AGRI_SESS2013'];
		$verification_no	= addslashes(trim($verification_no));
		$workas				= addslashes(trim($workas));
		$added_by			= addslashes(trim($added_by));
		//Inserting in customer table
		$x_password = md5_encrypt($password,USER_PASS);
		
		//get all email id to check if it is registered or not
		$select = "SELECT * FROM customer WHERE email = '$email'";
		
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;	
		if(mysql_num_rows($query) > 0)
		{
			header("Location: ".$_SERVER['PHP_SELF']."?action=add_client&message=Email already exists&typeM=ERROR#addCustomer");
		}
		else
		{
			//statement	dob, '$dob',
			$sql	 = 	 "INSERT INTO customer 
						 (customer_type_id, member_id, user_name, email, password, fname, lname, gender,  status, 
						 brief, description, organization, featured, profession, sort_order, verification_no, 
						 acc_verified, verified_by, verified_on, discount_offered,workas,added_by)
						 VALUES
						 ('$cus_type','$member_id', '$user_name', '$email', '$x_password', '$fname', '$lname', '$gender', '$status', 
						 '$brief', '$description', '$organization', '$featured', '$profession','$sort_order', '$verification_no', 
						 '$acc_verified', '$verified_by', now(), '$discount_offered','$workas','$added_by')";
						 
			//execute query
			$query	= 	mysql_query($sql);
			
			//get the primary key
			$id		= 	mysql_insert_id();
						
			//inserting into customer info table
			$sql2	=   "INSERT INTO customer_info 
						 (last_logon, no_logon, added_on, customer_id)
						 VALUES
						 (now(), 1, now(), '$id')";
			$query2		= mysql_query($sql2);
		
		}
		
		//return id
		return $id;
		
	}//eof
	
	
	
		
###########################################################################################################################
#
#									Customer Address
#
###########################################################################################################################	
	
	
	
	/**
	*	Add a customer address
	*	
	*	@param
	*			$address1			Advertiser id
	*			$address2			Address 1
	*			$address3			Address 2
	*			$town				Address 3
	*			$province			Town id
	*			$postal_code		Province id
	*			$countries_id		Postal Code
	*			$phone1				Phone 1
	*			$phone2				Phone 2
	*			$fax        		Fax
	*			$mobile				Mobile phone number
	*
	*	@return string
	*/
	function addCusAddress($customer_id, $address1, $address2, $address3, $town, $county, $province, $postal_code, $countries_id, 
							$phone1, $phone2, $fax, $mobile)
	{
		$customer_id	= addslashes(trim($customer_id)); 
		$address1		= addslashes(trim($address1));  
		$town			= addslashes(trim($town)); 
		$province		= addslashes(trim($province)); 
		$postal_code	= addslashes(trim($postal_code));
		$phone1			= addslashes(trim($phone1)); 
		$fax			= addslashes(trim($fax)); 
		
		$sql 	= "INSERT INTO customer_address
				  (customer_id, address1, address2, address3, town_id, county_id, province_id, postal_code, countries_id, phone1, phone2, fax, mobile)
				  VALUES
				  ($customer_id, '$address1','$address2', '$address3', '$town', '$county', '$province', '$postal_code', '$countries_id', '$phone1', 
				  '$phone2', '$fax', '$mobile')";
		
	
		//execute query		  
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = 'SU101';
		}
		return $result;
	}//eof
	
	
	
/**
	*	This function edit customer address table
	*
	*	@update November 22, 2011
	*
	*	@author	Mousumi Dey
	*	
	*	@param
	*			$id						Primary key associated with the particular customer
	*			$address1				1st address of the customer
	*			$address2			 	2nd Address of the customer
	*			$address3				3rd Address of the customer
	*			$town					Town of the customer	
	*			$province			 	Province of the customer
	*			$lname			 		lname  of the customer
	*			$postal_code			Postal Code of the customer
	*			$countries_id			Countries id of the customer
	*			$phone1					1st ph no. of the customer
	*			$phone2			        2nd phone no. of the customer
	*			$fax					Fax no of the customer	
	*			$mobile			 		Mobile no. of the customer
	*
	*	@return null
	*/
	
	function updateCusAddress($id, $address1, $address2, $address3, $town, $province, $postal_code, $countries_id, 
							$phone1, $phone2, $fax, $mobile)
	{
		
		//add security
		$address1				= addslashes(trim($address1)); 
		$address2				= addslashes(trim($address2));
		$address3				= addslashes(trim($address3));
		$town					= addslashes(trim($town));
		$province				= addslashes(trim($province)); 
		$postal_code			= addslashes(trim($postal_code));
		$phone1					= addslashes(trim($phone1));
		$phone2					= addslashes(trim($phone2));
		$fax					= addslashes(trim($fax));
		$mobile					= addslashes(trim($mobile));
		//$countries_id			= int($countries_id);
		
		//statement
		$sql	= " UPDATE customer_address 		
					SET
					address1							 =  '$address1',															
        			address2							 =	'$address2',																
					address3							 =	'$address3',
					town				             	 =	'$town',
					province							 =	'$province',																
					postal_code				          	 =	'$postal_code',					
					countries_id					     =  '$countries_id',	
					phone1								 =  '$phone1',															
        			phone2								 =	'$phone2',
					fax				           		 	 =	'$fax',
					mobile								 =	'$mobile'															
					WHERE
			    	customer_id			    			 =  $id
					";
				 
				// echo $sql.mysql_error();exit;
			
		//execute query
		$query	= mysql_query($sql);
	
	}//eof
	
	
	
	
	
	/**
	*	Edit registration information
	*	
	*	@param
	*			$user_id			Customer id or primary key
	*			$email				Email address
	*			$fname				First name of the client
	*			$lname				last name of the client
	*			$brief				Brief introducttion of the client
	*			$description		Description of the client
	*			$organization		Organization associated with the client
	*			$member_id			Unique member id
	*			$cus_type			Type of customer e.g. vendor 
	*			$ver_no				Verification no
	*
	*	@return	null
	*/
	function editCustomer($user_id, $type_id, $fname, $lname, $gender, $dob, $status, 
						 $brief, $description, $organization, $featured, 
					    $profession, $sort_order, $acc_verified, $discount_offered)
	{
		//get the vars
		
		$fname 			= addslashes(trim($fname));
		$lname 			= addslashes(trim($lname));
		$brief 			= addslashes(trim($brief));
		$description	= addslashes(trim($description));
		$organization	= addslashes(trim($organization));
		$sort_order		= addslashes(trim($sort_order));
		$profession		= addslashes(trim($profession));
		$type_id		= (int)$type_id;
		$discount_offered	= doubleval($discount_offered);
		
		
		//statement
		$sql	 = 		"UPDATE customer 
						SET
						customer_type_id	= '$type_id',
						fname 				= '$fname',
						lname 				= '$lname',
						gender 				= '$gender',
						dob					= '$dob',
						status 				= '$status',
						brief 				= '$brief',
						description			= '$description',
						organization		= '$organization',
						featured			= '$featured',
						profession			= '$profession',
						sort_order			= '$sort_order',
						acc_verified		= '$acc_verified',
						discount_offered	= '$discount_offered'
						WHERE 
						customer_id 		= $user_id
						";
			
		//execute query			
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		
	}//eof
	
	
	/**
	*	Edit registration information
	*	
	*	@param
	*			$user_id			Customer id or primary key
	*			$email				Email address
	*			$fname				First name of the client
	*			$lname				last name of the client
	*			$brief				Brief introducttion of the client
	*			$description		Description of the client
	*			$organization		Organization associated with the client
	*			$member_id			Unique member id
	*			$cus_type			Type of customer e.g. vendor 
	*			$email				Email id
	*
	*	@return	null
	*/
	function editCustomerWithEmail($user_id, $type_id, $fname, $lname, $gender, $dob, $status, 
						 $brief, $description, $organization, $featured, 
					    $profession, $sort_order, $acc_verified, $discount_offered, $email)
	{
		//get the vars
		
		$fname 			= addslashes(trim($fname));
		$lname 			= addslashes(trim($lname));
		$brief 			= addslashes(trim($brief));
		$description	= addslashes(trim($description));
		$organization	= addslashes(trim($organization));
		$sort_order		= addslashes(trim($sort_order));
		$profession		= addslashes(trim($profession));
		$type_id		= (int)$type_id;
		$discount_offered	= doubleval($discount_offered);
		
		
		//statement
		$sql	 = 		"UPDATE customer 
						SET
						customer_type_id	= '$type_id',
						fname 				= '$fname',
						lname 				= '$lname',
						gender 				= '$gender',
						dob					= '$dob',
						status 				= '$status',
						brief 				= '$brief',
						description			= '$description',
						organization		= '$organization',
						featured			= '$featured',
						profession			= '$profession',
						sort_order			= '$sort_order',
						acc_verified		= '$acc_verified',
						discount_offered	= '$discount_offered',
						email				= '$email'
						WHERE 
						customer_id 		= $user_id
						";
			
		//execute query			
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		
	}//eof	
	
	
	
	/**
	*	Update the date time, whenever the any data is updated.
	*
	*	@param
	*			$cus_id		Customer id
	*
	*	@return string
	*/
	function updateDate($cus_id)
	{
		//declare var
		$result = '';
		
		//statement
		$sql	= "UPDATE 	customer_info 
				  SET 		modified_on  = now()
				  WHERE 	customer_id  = '$cus_id'";
				  
		//execute query		  
		$query	= mysql_query($sql);
		
		//make the query
		if(!$query)
		{
			$result = "ER102";
		}
		else
		{
			$result = "SU102";
		}
		
		//return the result
		return $result;
		
	}//eof
	
	
	
	/**
	*	Update a customer address
	*	
	*	@param
	*			$cus_id		Customer id
	*			$add1		Address 1
	*			$add2		Address 2
	*			$add3		Address 3
	*			$t_id		Town id
	*			$c_id		County id
	*			$p_id		Province id
	*			$p_code		Postal Code
	*			$ph1		Phone 1
	*			$ph2		Phone 2
	*			$ph3		Phone 3
	*			$fax		Fax
	*			$mobile		Mobile phone number
	*			$country	Country's Id
	*
	*	@return string
	*/
	
	function updateCustomerAddr($cus_id, $add1, $add2, $add3, $t_id, $c_id, $p_id, $p_code, 
						  $ph1, $ph2, $fax, $mobile, $country)
	{
		$add1		= addslashes(trim($add1));
		$add2		= addslashes(trim($add2)); 
		$add3		= addslashes(trim($add3)); 
		$t_id		= addslashes(trim($t_id)); 
		$p_id		= addslashes(trim($p_id)); 
		$p_code		= addslashes(trim($p_code)); 
		$ph1		= addslashes(trim($ph1)); 
		$ph2		= addslashes(trim($ph2)); 
		$fax		= addslashes(trim($fax)); 
		$mobile		= addslashes(trim($mobile));
		$country	= (int)$country;
		
		//update directory address
		$sql	= "UPDATE customer_address SET
				  address1 			='$add1',
				  address2 			='$add2',
				  address3 			='$add3',
				  town_id		 	='$t_id',
				  county_id			='$c_id',				
				  province_id	 	='$p_id',
				  postal_code 		='$p_code',
				  phone1 			='$ph1',
				  phone2 			='$ph2',
				  fax 				='$fax',
				  mobile 			='$mobile',
				  countries_id 		='$country'
				  WHERE 
				  customer_id 	= '$cus_id'
				  ";
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		$result = '';
		if(!$query)
		{
			$result = "ER102";
		}
		else
		{
			$result = "SU102";
		}
		
		//return the result
		return $result;
		
	}//eof
	
	
	
	/**
	*	Delete a client from the database
	*
	*	@param 
	*			$id				Customer's id
	*			$path			Path to the images
	*
	*	@return string
	*/
	function deleteCustomer($id, $path)
	{
		//delete the image first
		$this->deleteFile($id, 'customer_id' , $path, 'image', 'customer');
		
		//delete from customer or client's information
		$sql	= "DELETE FROM customer_info WHERE customer_id='$id'";
		$query	= mysql_query($sql);
		
		//delete from client's address
		$sql	= "DELETE FROM customer_address WHERE customer_id='$id'";
		$query	= mysql_query($sql);
		
		
		//delete from client
		$sql	= "DELETE FROM customer WHERE customer_id='$id'";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = "ER103";
		}
		else
		{
			$result = "SU103";
		}
		
		//return the result
		return $result;
		
	}//eof
	
	
	/*/**
	*	Retrieve all customer id 
	*
	*	@return array
	*/
	function getAllCustomerId()
	{
		//Declare array
		$data	= array();
		
		//
		$sql	= "SELECT 		C.customer_id 
				   FROM 		customer C, customer_info CI
				   WHERE		C.customer_id = CI.customer_id
				   ORDER BY 	CI.added_on 
				   DESC";
		
		//execute query
		$query	= mysql_query($sql);
		
		//fetch the data
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_id;
			}
		}
		
		//return data
		return $data;
		
	}//eof
	
	/*/**
	*	Retrieve all customer id by product
	*
	*	@return array
	*/
	function getCusIdByProd($prodId)
	{
		//Declare array
		$data	= array();
		
		//
		$sql	=  "SELECT DISTINCT customer_id
					FROM product_to_customer 
					WHERE product_id = '$prodId'";
		
		//execute query
		$query	= mysql_query($sql);
		
		//fetch the data
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_id;
			}
		}
		
		//return data
		return $data;
		
	}//eof
	
	
	/**
	*	Returns the list of client
	*
	*	@param
	*			$num		Number of client to find. If it is set to ALL, it will search for
	*						all the registered client
	*			$ordBy		Order by clause
	*			$ordType	Order by type, either ascending or descending
	*
	*	@return array
	*/
	
	function getAllCustomer($num, $ordBy, $ordType)
	{
		//declare vars
		$data		= array();
	
		//generate the statement
		if($num == 'ALL')
		{
			$select		= "SELECT 	CI.customer_id AS CUSID 
						   FROM 	customer_info CI, customer C, customer_address CA 
						   WHERE 	CI.customer_id = C.customer_id
						   AND		CI.customer_id = CA.customer_id
						   ORDER BY ".$ordBy." ".$ordType;
		}
		else if($num > 0)
		{
			$select		= "SELECT CI.customer_id AS CUSID FROM customer_info CI ORDER BY ".$ordBy." ".$ordType." LIMIT $num";
		}
		else
		{
			$select		= "SELECT CI.customer_id AS CUSID  FROM customer_info CI ORDER BY ".$ordBy." ".$ordType;
		}
		
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch the values
		while($result	= 	mysql_fetch_object($query))
		{
			$data[]		= $result->CUSID;
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/** 
	*	Returns the list of client by type id
	*
	*	@param
	*			$typeId		 customer type id
	*
	*	@return array
	*/
	
	function getCustomerByTypeId($typeId)
	{
		//declare vars
		$data		= array();
	
		//generate the statement
		$select		= "SELECT 	customer_id  
					   FROM 	customer
					   WHERE 	customer_type_id = $typeId";
		
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch the values
		while($result	= 	mysql_fetch_object($query))
		{
			$data[]		= $result->customer_id;
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Show registration data
	*
	*	@param
	*			$customer_id		Customer identity
	*
	*	@return array
	*/
	function getCustomerData($customer_id)
	{
		//declare var
		$data		= array();
		
		//create the statement
		$select		=   "SELECT * 
						 FROM 	customer C, customer_info CI, customer_address CD
						 WHERE 	C.customer_id = CI.customer_id
						 AND	C.customer_id = CD.customer_id 
						 AND 	C.customer_id = '$customer_id'";
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch the rows
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_object($query))
			{
				$data	=	array(
								  $result->customer_type_id,	//0			CUSTOMER/USER
								  $result->member_id,			//1
								  $result->user_name,			//2
								  $result->email,				//3
								  $result->password,			//4
								  $result->fname,				//5
								  $result->lname,				//6
								  $result->gender,				//7
								  $result->status,				//8
								  $result->image,				//9
								  $result->brief ,			    //10
								  $result->description ,		//11
								  $result->organization,		//12 
								  $result->featured,			//13
								  $result->profession,			//14
								  $result->sort_order,			//15
								  $result->verification_no,		//16
								  $result->verified_by,			//17
								  $result->verified_on,			//18 
								  $result->discount_offered,	//19
								  
								  $result->no_logon,			//20		CUST INFO
								  $result->last_logon,			//21
								  $result->added_on,			//22					  
								  $result->modified_on,			//23
								  
								  
								  $result->address1,			//24		ADDRESS
								  $result->address2,			//25
								  $result->address3,			//26
								  $result->town_id,				//27
								  $result->province_id,			//28
								  $result->postal_code,			//29
								  $result->countries_id,		//30
								  $result->phone1,				//31
								  $result->phone2,				//32
								  $result->fax,					//33
								  $result->mobile,				//34
								
								  $result->acc_verified	,		//35
								  $result->county_id,			//36
								  $result->dob,					//37
								  $result->customer_id,					//38
								  $result->workas					//39
								);
			}//while
		}//if
		
		//return the data
		return $data;	
		
	}//	eof
	
	/**
	*	Show registration data
	*
	*	@param
	*			$eid		Email id
	*
	*	@return array
	*/
	function getCustDatabyEmail($eid)
	{
		//declare var
		$data		= array();
		
		//create the statement
		$select		=   "SELECT * 
						 FROM 	customer WHERE 	email = '$eid'";
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch the rows
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_object($query))
			{
				$data	=	array(
								  $result->customer_type_id,	//0			CUSTOMER/USER
								  $result->member_id,			//1
								  $result->user_name,			//2
								  $result->email,				//3
								  $result->password,			//4
								  $result->fname,				//5
								  $result->lname,				//6
								  $result->gender,				//7
								  $result->status,				//8
								  $result->image,				//9
								  $result->brief ,			    //10
								  $result->description ,		//11
								  $result->organization,		//12 
								  $result->featured,			//13
								  $result->profession,			//14
								  $result->sort_order,			//15
								  $result->verification_no,		//16
								  $result->verified_by,			//17
								  $result->verified_on,			//18 
								  $result->discount_offered,	//19
								  $result->workas,				//20
								  $result->factory_id			//21
								 	
								);
			}//while
		}//if
		
		//return the data
		return $data;	
		
	}//	eof
	
	
	 public function getCustData($cust_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM customer where customer_id = $cust_id") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	
	
	
	
	/*===========================Customer Details========================================*/
	 public function getAllCustomerDtl(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM customer where customer_type_id = '7'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
	 
	 
	 
	
	/*===========================Different Customer Details for pipeline========================================*/
	 public function getAllCustomerDtlPipeline($cust_type){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM customer where customer_type_id = $cust_type") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	
	 public function getAllCustomerDetails(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM customer ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	
	/**
	*	Edit the password, depending upon who is editing. Administrator doesn't require to 
	*	verify password again. For a normal user he needs to verify his old password.
	*	
	*	@param
	*			$user_type	Role of the user, administrator or normal
	*			$old_pass	Old password
	*			$new_pass	New password
	*			$cnf_pass	Confirm password
	*			$user_id	User id
	*	
	*	@return NULL
	*/
	function editPassword($old_pass, $new_pass, $cnf_pass, $user_type, $user_id)
	{
		
		//CHECK THE LENGTH OF THE NEW PASSWORD
		if(strlen($new_pass) < 6) 
		{
			$msg = "Password is too short";
			header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=".$msg."&typeM=ERROR");
		}
		else if($new_pass != $cnf_pass)
		{
			$msg = "Password does not match with the confirm password";
			header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=".$msg."&typeM=ERROR");
		}
		else
		{
			
			$select		= "SELECT password FROM customer WHERE customer_id='$user_id'";
			$query      = mysql_query($select);
			$result 	= mysql_fetch_array($query);
			$x_password = '';
			$new_pass	= md5_encrypt($new_pass, USER_PASS);
			
			if(mysql_num_rows($query) > 0)
			{ 
				$dbpass	    = $result['password'];
				$x_password = md5_decrypt($dbpass, USER_PASS);
				
			}
			else
			{
				$msg = "No such user exist";
				header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=".$msg."&typeM=ERROR");
			}
			
			if($user_type == 'USERfresh_2013AGRI_SESS2013')
			{
				if(!isset($_SESSION['USERfresh_2013AGRI_SESS2013']))
				{
					header("Location: index.php");
				}//extra security
				else
				{
					$update	= "UPDATE customer SET password = '$new_pass' WHERE customer_id='$user_id'";
					$query	= mysql_query($update);
					$msg = "Password has changed  successfully";
					header("Location: ".$_SERVER['PHP_SELF']."?action=success&msg=".$msg."&typeM=SUCCESS");
					
				}//else
				
			}//admin user
			else
			{
				//echo "else ".$x_password." ".$old_pass;exit;
				if($x_password != $old_pass)
				{
					//echo $x_password." ".$old_pass;exit;
					$msg = "Old password does not match with the entered value";
					header("Location: ".$_SERVER['PHP_SELF']."?action=edit_pass&msg=".$msg."&typeM=ERROR");
					
				}//else check old password
				elseif(!isset($_SESSION['USERfresh_2013AGRI_SESS2013']))
				{
					$msg = "Logon before change your password";
					header("Location: ".$_SERVER['PHP_SELF']."?action=edit_pass&msg=".$msg."&typeM=ERROR");
					
				}//whether the user is logged on or not
				else

				{
					$update	= "UPDATE customer SET password = '$new_pass' WHERE customer_id='$user_id'";
					$query	= mysql_query($update);
					$msg 	= " Password has been changed successfully";
					
					header("Location: detail.php?fId=".$_SESSION['userid']."&action=success&msg=".$msg."&typeM=SUCCESS");
					
				}//else
				
			}//normal user

			
		}//else
	}//eof
	
	###############################################################################################################
	#
	#										Email Subscription
	#
	###############################################################################################################
	
	/**
	*	Check the status of email subscribed by the user
	*
	*	@param
	*			$email		Email of the customer
	*/
	function checkEmailStat($email)
	{
		$sql	= "SELECT status FROM email_subscriber WHERE email='$email' ";
		$query	= mysql_query($sql);
		//echo $select.mysql_error();exit;
		$data	= 'N';
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_array($query);
			$data	= $result['status'];
		}
		return $data;
	}//eof
	
	/**
	*	Update status
	*/
	function updateSubStat($status, $email)
	{
		//statement
		$sql	= "UPDATE email_subscriber SET status='$status' WHERE email='$email' ";
		$query	= mysql_query($sql);

	}//eof
	
	
	/**
	*	Change the user password. As changing password is done by User, so he doesn't 
	*	need to enter old password
	*	
	*	@param	
	*			$id			User unique identity
	*			$password	User New Password
	*/
	function changeUserPassword($id, $password)
	{
		//$x_password = md5_encrypt($password,USER_PASS);
		$x_password = md5_encrypt($password,USER_PASS);
		$update = "UPDATE customer SET password= '$x_password' WHERE customer_id='$id'";
		$query  = mysql_query($update);
	}//eof
	
	###############################################################################################################
	#
	#										Customer Verification
	#
	###############################################################################################################
	
	
	
	/**
	*	Work with verification status separately
	*
	*	@param
	*			$user_id	Primary key associated with the user
	*			$accV		Account verification
	*			$user		Admin user or the user itself whoever has verified the account
	*			
	*	@return  NULL
	*/
	function updateVerStatus($user_id, $accV, $user)
	{
		//statement
		$sql	= "UPDATE customer C SET
				   C.acc_verified		= '$accV',
				   C.verified_by		= '$user',
				   C.verified_on		= now()	
				   WHERE
				   C.customer_id = '$user_id'
				   ";
				   
		//execute query
		$query	= mysql_query($sql);
		
		
	}//eof
	
	
	/**
	*	Work with verification numbers separately
	*
	*	@param
	*			$user_id		Primary key associated with the customer
	*			$ver_no			Verification number
	*			
	*	@return  NULL
	*/
	function updateVerNo($user_id, $ver_no)
	{
		//statement
		$sql	= "UPDATE customer SET
				   verification_no	= '$ver_no'
				   WHERE
				   customer_id = '$user_id'
				   ";
				   
		//execute query
		$query	= mysql_query($sql);
		
	}//eof
	
	
	
	/**
	*	Render account verification, to display if an account is fully verified.
	*
	*	@param
	*			$user_id		Primary key associated with the customer
	*			$erTxt			Error text message
	*			$suTxt			Success text message
	*
	*	@return	 string
	*/
	function renderVerifyStr($user_id, $erTxt, $suTxt)
	{
		//declare var
		$conStr	= '';
		
		//get the customer detail
		$cusDtl	= $this->getCustomerData($user_id);
	
		if( ($cusDtl[15] == '') || ($cusDtl[35] == 'N') )
		{
			$conStr	=  "<span class='orangeLetter'>".$erTxt."</span>";
		}
		else
		{
			$conStr	=  "<span class='blackLarge padT5'>".$suTxt."</span>";
		}
		
		//return the string
		return $conStr;
		
	}//eof
	
	
	/**
	*	Get the list of customer waiting for verification during a time span
	*
	*	@param
	*			$startDate		Start date when registration began
	*			$endDate		End date when registration ends
	*
	*	@return	string
	*/
	function getListOfUnverifiedcustomer($startDate, $endDate)
	{
		//declare vars
		$cIds		= array();
		$contList	= '';
		
		//list of customer 
		$cIds		= $this->getcustomerBySEDate($startDate, $endDate);
		
		if(count($cIds) > 0)
		{
			//start listing
			$contList  .= "<ul>";
			
			foreach($cIds as $z)
			{
				//get the contrator detail
				$cusDtl	= $this->showRegInfo($z);
				
				$contList  .= "<li>".$cusDtl[0]." ".$cusDtl[1]."</li>";
			}
			
			//end listing
			$contList  .= "</ul>";
			
		}//if
		
		
		//return the string
		return $contList;
		
	}//eof
	
	
	
	/**
	* 	Password retrive by the email id
	*
	*	@param
	*			$email		Customer email 
	*
	*	@return string
	*/
	function getPasswordName($email)
	{
		//declare vars
		$data  = array();
		
		//statement
		$sql = "SELECT password, fname FROM customer WHERE email='$email'";
		
		//execute query
		$query = mysql_query($sql);
		
		//check and fetch data
		if(mysql_num_rows($query) > 0)
		{
			//result
			$result = mysql_fetch_array($query);
			
			//hold in array
			$data   = array($result['password'], $result['fname']);
		}
		
		//return data
		return $data;
		
	}//end of getting password
	
	
	/**
	*	Update for reference
	*	
	*	@date October 30, 2010
	*
	*	@param
	*			$cusId			Customer Id
	*			$refId			Reference or parent id, if parent id is zero, that refers to admin
	*			$refWeb			Reference website
	*
	*	@return null
	*/
	function updateReferece($cusId, $refId, $refWeb)
	{
		//statement
		$sql	= "UPDATE customer SET
				   parent_id = '$refId',
				   referred_website = '$refWeb'
				   WHERE 
				   customer_id = '$cusId'
				   ";
				   
		//execute query
		$query	= mysql_query($sql);
		
	}//eof
	
	
	/**
	*	Get referral detail
	*
	*	@param
	*			$parent_id			Parent id or referral id
	*
	*	@return string
	*/
	function getReferralDetail($parent_id)
	{
		//declare var
		$refStr	= '';
		$cusDtl	= array();
		
		//get the name
		if( (int)$parent_id <= 0)
		{
			$refStr	= 'Administrator';
		}
		else
		{
			//get customer detail
			$cusDtl	= $this->getCustomerData($parent_id);
			
			//get the email
			$refStr	= $cusDtl[1];
			
		}
		
		//return the string
		return $refStr;
		
	}//eof
	
	
	
	/**
	*	Add to membership policy
	*
	*	@param
	*			$cus_id				Customer Id
	*			$packId				Package Id
	*			$ordId				Orders id
	*			$memType			Membership type
	*			$amtPaid			Amount paid
	*			$startDate			Date of starting membership
	*			$expDate			Date of expiry
	*
	*	@return	int
	*/
	function joinMembershipProg($cus_id, $packId, $ordId, $memType, $amtPaid, $startDate, $expDate)
	{
		//declare var
		$data	= 0;
		
		//check if that order id is already in the database
		$omId   = $this->getMembershipId('ORD', $ordId);
		
		if(count($omId) > 0)
		{
			//statemnet
			$sql	= "UPDATE customer_membership SET
					   package_id 		= '$packId',
					   membership_type	= '$memType',
					   amount_paid		= '$amtPaid',
					   start_date		= '$startDate',
					   end_date			= '$expDate'
					   WHERE 
					   orders_id = '$ordId'
					  ";
		}
		else
		{
			//statemnet
			$sql	= "INSERT INTO customer_membership
					   (customer_id, package_id, orders_id, membership_type, amount_paid, start_date, end_date) 
					   VALUES
					   ('$cus_id', '$packId', '$ordId', '$memType', '$amtPaid', '$startDate', '$expDate')
					  ";
		}
				  
		//execute query
		$query	= mysql_query($sql);
		
	}//eof
	
	
	/**
	*	Get all membership id
	*
	*	@param
	*			$type			Type or search criterion
	*			$id				Foreign key value used against search
	*
	*	@return array
	*/
	function getMembershipId($type, $id)
	{
		//declare vars
		$data	= array();
		
		//statement
		switch ($type)
		{
			case 'CUS':
				$sql	= "SELECT * FROM customer_membership WHERE customer_id = $id ORDER BY orders_id DESC";
				break;
				
			case 'PACK':
				$sql	= "SELECT * FROM customer_membership WHERE package_id = $id";
				break;
				
			case 'MEMTYPE':
				$sql	= "SELECT * FROM customer_membership WHERE membership_type = $id";
				break;
				
			case 'ORD':
				$sql	= "SELECT * FROM customer_membership WHERE orders_id = $id";
				break;
				
			case 'CUSLATEST':
				$sql	= "SELECT * FROM customer_membership WHERE  customer_id = $id ORDER BY orders_id DESC LIMIT 1";
				break;
				
				
			default:
				$sql	= "SELECT * FROM customer_membership";
				break;
			
		}//switch
		
		//execute statement
		$query	= mysql_query($sql);
		
		//check and put in array
		if(count($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_membership_id;
			}
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/**
	*	Return the order membership detail, associated with an order id
	*
	*	@date	October 17, 2010
	*
	*	@param
	*			$id			Customer membership id
	*
	*	@return	array
	*/
	function getMembershipDetail($id)
	{
		//declare vars
		$data	= array();
		
		//statement
		$sql	= "SELECT 	* 
				   FROM 	customer_membership
				   WHERE  	customer_membership.customer_membership_id = '$id'";
					
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
	
	
	/**
	*	Check the membership type, whether new or renew
	*
	*	@param
	*			$cusId			Customer id
	*
	*	@return char
	*/
	function getMembershipType($cusId)
	{
		//declare var
		$res	= '';
		
		//check if any record exist
		$cmIds	= $this->getMembershipId('CUS', $cusId);
		
		if(count($cmIds) > 0)
		{
			$res	= 'renew';
		}
		else
		{
			$res	= 'new';
		}
		
		//return the result
		return $res;
		
	}//eof
	
	
	/**
	*	Get verified customer dropdown
	*
	*	@param
	*			$selected			If the user is already selected
	*
	*	@return null
	*/
	function getActiveUserList($selected)
	{
		//declare var
		$today		= date("Y-m-d");
		
		//statement
		$select		= "SELECT   C.customer_id, C.email, C.fname, C.lname 
					   FROM 	customer C, customer_membership CM
					   WHERE 	C.customer_id = CM.customer_id
					   AND		CM.end_date >= $today
					  ";
					  
		//execute query
		$query		= mysql_query($select);
		
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_object($query))
			{
				$data_id	= $result->customer_id;
				
				if($data_id == $selected)
				{
					$select_string = 'selected';
				}
				else
				{
					$select_string = '';
				}
				
				echo "<option value='".$data_id."' class='menuText' ".$select_string.">".
				$result->email."</option>";
				
			}
		}//if
		
	}//eof
	
	
	
	/**
	*	Get the latest active member's order id
	*
	*	@param
	*			$cusId			Customer Id
	*
	*	@return int
	*/
	function getActiveOrderIdByUser($cusId)
	{
		//declare var
		$data		= 0;
		
		//statement
		$sql	= "SELECT * FROM customer_membership WHERE customer_id = $cusId ORDER BY orders_id DESC LIMIT 1";
		
		//execute query
		$query	= mysql_query($sql);
		
		if(mysql_num_rows($query) > 0)
		{
			//fetch the result set
			$result	= mysql_fetch_object($query);
			
			//hold the data
			$data	= $result->orders_id;			
		}
		
		//return id
		return $data;
					  
	}//eof
		
	
	/**
	*	Get verified customer dropdown
	*
	*
	*	@return null
	*/
	function getActiveMembersId()
	{
		//declare var
		$data		= array();
		$today		= date("Y-m-d");
		
		//statement
		$select		= "SELECT   C.customer_id
					   FROM 	customer C, customer_membership CM
					   WHERE 	C.customer_id = CM.customer_id
					   AND		CM.end_date >= $today
					  ";
					  
		//execute query
		$query		= mysql_query($select);
		
		//check
		if(mysql_num_rows($query) > 0)
		{
			//fetch
			while($result = mysql_fetch_object($query))
			{
				$data[]	= $result->customer_id;
			}
		}
		
		//return result
		return $data;
		
	}//eof
	
	
	/**
	*	Check if a member can post ads or not based whether his membership is active or not
	*
	*	@date	December 16, 2010
	*
	*	@param
	*			$usrId			Current user id
	*
	*	@return char
	*/
	function isActiveMember($usrId)
	{
		//declare vars
		$actUsrIds	= array();
		$resChar	= 'N';
		
		//get the value
		$actUsrIds	= $this->getActiveMembersId();
		
		
		//checking
		if(in_array($usrId, $actUsrIds))
		{
			$resChar	= 'Y';
		}
		else
		{
			$resChar	= 'N';
		}
	
		//return the value
		return $resChar;
		
	}//eof
	
	
	/**
	*	Get customer id by customer email. Usable to search for a client
	*
	*	@date November 12, 2010
	*
	*	@param
	*			$email			User email
	*	@return int
	*/
	function getCustomerIdByEmail($email)
	{
		//declare var
		$data		= 0;
		
		
		//statement
		$select		= "SELECT   C.customer_id
					   FROM 	customer C
					   WHERE 	C.email = '$email'
					  ";
					  
		//execute query
		$query		= mysql_query($select);
		
		//check
		if(mysql_num_rows($query) > 0)
		{
			//fetch
			$result = mysql_fetch_object($query);
			
			//get the data
			$data	= $result->customer_id;
			
		}
		
		//return result
		return $data;
		
	}//eof
	
	
	/**
    *    Generate unique verification code
    *   
    *    @param
    *            $prefix            Prefix to add before the code
    *
    *    @return string
    */
    function generateVerificationCode($prefix)
    {
        //declare vars
        $ordCode        = '';
       
        //get 5 char order key
        $ordKey    = $this->genCusKeys(5);
       
        //get the date and time
        $dateStr    = date("dmY");
       
        //user id
        if(isset($_SESSION['userid']))
        {
            $userId    = $_SESSION['userid'];
        }
        else
        {
            $userId    = 0;
        }
        //formatted id
        $userId    = 10000 + $userId;
       
        //get the previously stored number of order
        $numOrder = $this->getLatestOrderId();
       
        //num order
        $reOrder = 1001 + $numOrder;
       
	   
	   //For verification No
		$ordCode        = $prefix.$dateStr.'-'.$reOrder;
       
        //return code
        return    $ordCode;
       
    }//eof
   
   
   
	
		
	/**
	*	to generate verification number if account is verified
	*
	*	@param
	*			$acc_verified			Whether account is verified or not that will be denoted by Yes as 'Y' and No as 'N'
	*			
	*	@return string
	*/
	function genCusVerificationNum($acc_verified)
	{
		if($acc_verified=='Y')
		{
			//get verification no
			$verificationNo	= $this->generateVerificationCode('V');
		}
		else
		{
			$verificationNo='';
		}
		return $verificationNo;
	}//eof
	
	
	/**
    *    Generate unique verification code for billing profile id
    *   
    *    @param
    *            $prefix            Prefix to add before the code
    *
    *    @return string
    */
    function generateVerificationCodeForBillinPRof($prefix)
    {
        //declare vars
        $ordCode        = '';
       
        //get 5 char order key
        $ordKey    = $this->genCusKeys(5);
       
        //get the date and time
        $dateStr    = date("dmY");
       
        //user id
        if(isset($_GET['cus_id']))
        {
            $cus_id    = $_GET['cus_id'];
        }
        else
        {
            $cus_id    = 0;
        }
        //formatted id
        $cus_id    = 10000 + $cus_id;
       
        //get the previously stored number of order
        $numOrder = $this->getLatestOrderId();
       
        //num order
        $reOrder = 1001 + $numOrder;
       
	   //For verification No
		$ordCode        = $prefix.$dateStr.'-'. $cus_id.$reOrder;
       
        //return code
        return    $ordCode;
       
    }//eof
   
	
	 /**
	 *	Generate order key
	 *	
	 *	@param
	 *			$length		Length of the key
	 */
	 function genCusKeys($length)
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
    *    Get the latest id of order
    */
    function getLatestOrderId()
    {
        //declare vars
        $id        = 0;
       
        //statement
        $sql    = "SELECT MAX(customer_id) AS MOID FROM customer";
       
        //query
        $query    = mysql_query($sql);
       
        //get the result
        $result    = mysql_fetch_object($query);
       
        //assign the value
        $id        = $result->MOID;
       
        //return the result
        return $id;
       
    }//eof
	
	
	############################################################################################################
	#
	#												Customer Billing
	#
	############################################################################################################
	
	
	
	/**
	
	*	Add to the customer_billing table
	*	@update Nov 21, 2011
	*
	*	@param
	*			$customer_id			 			customer_id of the customer table
	*			$billing_name			 			Billing name  of the customer_billing table
	*			$billing_email						Billing email of the customer_billing table
	*			$billing_address					Billing address of the customer_billing table
	*			$billing_city			 			Billing city of the customer_billing table
	*			$billing_province			 		Billing province  of the customer_billing table
	*			$billing_postal_code				Billing postal code of the customer_billing table
	*			$billing_phone						Billing phone of the customer_billing table  
	*			$billing_fax						Billing fax of the customer_billing table
	*	@return int
	*/
	function addCustomerBilling($customer_id, $billing_profile_id,  $default_billing_profile, $billing_name, $billing_email, 
								$billing_address, $billing_city, $billing_province, $billing_country_id, $billing_postal_code,  
								$billing_phone, $billing_mobile, $billing_fax)
	{
	
	   //declare var
		$id = 0;
		
		//add security
		$customer_id			= trim($customer_id); 
		$billing_name			= addslashes(trim($billing_name));
		$billing_email			= addslashes(trim($billing_email)); 
		$billing_address		= addslashes(trim($billing_address));
		$billing_city			= addslashes(trim($billing_city)); 
		$billing_province		= addslashes(trim($billing_province));
		$billing_postal_code	= addslashes(trim($billing_postal_code)); 
		$billing_phone			= addslashes(trim($billing_phone));
		$billing_mobile			= addslashes(trim($billing_mobile));
		$billing_fax			= addslashes(trim($billing_fax));
		$billing_profile_id		= addslashes(trim($billing_profile_id));
		
		//statement
		$sql	= "INSERT INTO customer_billing 
				   (customer_id, billing_profile_id, default_billing_profile, billing_name, billing_email, billing_address, billing_city, 
				    billing_province, billing_country_id, billing_postal_code, billing_phone, billing_mobile, billing_fax, added_on)
				   VALUES
				   ($customer_id, '$billing_profile_id', '$default_billing_profile', '$billing_name', '$billing_email', '$billing_address',
				    '$billing_city', '$billing_province','$billing_country_id', '$billing_postal_code', '$billing_phone', '$billing_mobile',
					'$billing_fax', now())";
				
		//execute query
		$query	= mysql_query($sql); 
		
		
	
		//get the primary key
		if($query)
		{
			$id	= mysql_insert_id();
		}
		
		//return primary key
		return $id;
		
	}//eof
	
	
	
	
	/**
	*	This function edit customer_billing
	*
	*	@update Nov 21, 2011
	*	
	*	@param
	*			$id									Primary key associated with the particular customer billing
	*			$customer_id			 			customer_id of the customer table
	*			$billing_name			 			Billing name  of the customer_billing table
	*			$billing_email						Billing email of the customer_billing table
	*			$billing_address					Billing address of the customer_billing table
	*			$billing_city			 			Billing city of the customer_billing table
	*			$billing_province			 		Billing province  of the customer_billing table
	*			$billing_postal_code				Billing postal code of the customer_billing table
	*			$billing_phone						Billing phone of the customer_billing table  
	*			$billing_fax						Billing fax of the customer_billing table	
	*	@return null
	*/
	
	function updateCustomerBilling($id, $customer_id, $billing_name, $billing_email, $billing_address, $billing_city, $billing_province,	
								   $billing_postal_code, $billing_phone, $billing_fax)
	{
	
		//declare var
		$data			= '';
	
		//add security
		$customer_id			= trim($customer_id); 
		$billing_name			= addslashes(trim($billing_name));
		$billing_email			= addslashes(trim($billing_email)); 
		$billing_address		= addslashes(trim($billing_address));
		$billing_city			= addslashes(trim($billing_city)); 
		$billing_province		= addslashes(trim($billing_province));
		$billing_postal_code	= addslashes(trim($billing_postal_code)); 
		$billing_phone			= addslashes(trim($billing_phone));
		$billing_fax			= addslashes(trim($billing_fax));
		
	
		//statement
		$sql	= "UPDATE customer_billing SET
				customer_id						    		 =  '$customer_id',			
				billing_name				            	 =	'$billing_name',	
				billing_email						    	 =  '$billing_email',			
				billing_address				            	 =	'$billing_address',	
				billing_city						    	 =  '$billing_city',			
				billing_province				             =	'$billing_province',	
				billing_postal_code						     =  '$billing_postal_code',			
				billing_phone				            	 =	'$billing_phone',	
				billing_fax						    		 =  '$billing_fax',							
				modified_on							 		 =   now()					
				WHERE
			    customer_billing_id			      			 =  '$id'
				";
				 
				 
			
		//execute query
		$query	= mysql_query($sql);
		
		//test if it is running well
		if($query)
		{
			$data	= 'SU';
		}
		else
		{
			$data	= 'ER'.mysql_error();
		}
		
		
		//return data
		return $data;
		
	}//eof
	
	
	
	
	/**
	*	Delete from the customer_billing table
	*
	*	@param
	*			$id			customer_billing Id	
	
	*	 		@return string
	*/
	
	function deleteCustomerBilling($id)
	{
		//declare var
		$result	= '';
	
		//statement
		$sql	= "DELETE FROM customer_billing WHERE customer_billing_id = $id ";
				   
		//execute query
		$query	= mysql_query($sql);
		
		//test if it is running well
		if(!$query)
		{
			$result	= 'ER'.mysql_error();
		}
		else
		{
			$result	= 'SU'; 
		}
		
		//return data
		return $result;
		
	}//eof
	
	
	/**
	*	Retrieve all customer billing id 
	*
	*	@return array
	*/
	function getAllCustomerBillingId()
	{
		//Declare array
		$data	= array();
		
		//
		$sql	= "SELECT 		customer_billing_id 
				   FROM 		customer_billing 
				   ORDER BY 	added_on 
				   DESC";
		
		//execute query
		$query	= mysql_query($sql);
		
		//fetch the data
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_billing_id;
			}
		}
		
		//return data
		return $data;
		
	}//eof
	
	
	
	/**
	*	Retrive  from the customer billing table
	*
	*	@param
	*			$id			customer billing id or primary key
	*			
	*	@return array
	*/
	function getCustomerBillingData($id)
	{
		//declare
		$data	= array();
		
		//statement
		$sql	= "SELECT 	*
				   FROM 	customer_billing
				   WHERE 	customer_billing_id= '$id'";
				   
		//execute query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_object($query);
			$data = array(
						 $result->customer_id,			  	//0
						 $result->billing_profile_id,		//1
						 $result->default_billing_profile,	//2
						 $result->billing_name,				//3
						 $result->billing_email,			//4
						 $result->billing_address,			//5
						 $result->billing_city,			  	//6
						 $result->billing_province,			//7
						 $result->billing_postal_code,		//8
						 $result->billing_phone,			//9
						 $result->billing_fax,				//10
						 $result->added_on,					//11
						 $result->modified_on        		//12
						 );
		
		}
		
	  	//return the data
	  	return $data;
	}//eof	
	
	
	/**
	*	Delete a client from the database
	*
	*	@param 
	*			$id				Customer's id
	*			$path			Path to the images
	*
	*	@return string
	*/
	function deleteCustomerAllTab($id, $path)
	{
		//delete the image first
		$this->deleteFile($id, 'customer_id' , $path, 'image', 'customer');
		
		//delete from customer or client's information
		$sql	= "DELETE FROM customer_info WHERE customer_id='$id'";
		$query	= mysql_query($sql);
		
		//delete from client's address
		$sql	= "DELETE FROM customer_address WHERE customer_id='$id'";
		$query	= mysql_query($sql);
		
		
		//delete from client
		$sql	= "DELETE FROM customer WHERE customer_id='$id'";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = "ER103";
		}
		else
		{
			$result = "SU103";
		}
		
		//return the result
		return $result;
		
	}//eof
	
	
	
	/**
	*	Add client's address
	*	
	*	@param
	*			$cus_id			Customer's id
	*			$add1			Address 1
	*			$add2			Address 2
	*			$add3			Address 3 
	*			$t_id			Town id
	*			$p_id			Province id
	*			$p_code			Postal Code
	*			$ph1			Phone 1
	*			$ph2			Phone 2
	*			$fax			Fax
	*			$mobile			Mobile phone number
	*			$country		Countries Id
	*
	*			Date 19th November , 2012 .
	*			@author Mousumi Dey
	*
	*	@return string
	*/
	function addCusAdd($cus_id, $add1, $add2, $add3, $t_id, $p_id, $p_code, $ph1, 
						$ph2, $fax, $mobile,$country)
	{
		//declare var
		$result = '';
		
		//get the values
		$add1		= addslashes(trim($add1));
		$add2		= addslashes(trim($add2)); 
		$add3		= addslashes(trim($add3)); 
		$t_id		= addslashes(trim($t_id)); 
		$p_id		= addslashes(trim($p_id)); 
		$p_code		= addslashes(trim($p_code)); 
		$ph1		= addslashes(trim($ph1)); 
		$ph2		= addslashes(trim($ph2)); 
		$fax		= addslashes(trim($fax)); 
		$mobile		= addslashes(trim($mobile));
		//$country	= (int)$country;
		
		//statement
		$sql 	= "INSERT INTO customer_address
				  (customer_id, address1, address2, address3, town, 
				  province, postal_code, phone1, phone2, 
				  fax, mobile, countries_id)
				  VALUES
				  ($cus_id, '$add1','$add2','$add3','$t_id',
				  '$p_id','$p_code','$ph1','$ph2',
				  '$fax','$mobile', '$country')";
		
		//execute query
		$query	= mysql_query($sql);
		
		
		
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = 'SU101';
		}
		return $result;
		
	}//eof
	
	
	/**
	*	Register a new Customer.
	*	
	*	@update	September 10, 2010
	*
	*
	*	@param
	*			$user_name			User Name
	*			$email				Customers Email
	*			$password			Access password, require later
	*			$fname				First name of the client
	*			$lname				last name of the client
	*			$gender				Gender of the client
	*			$dob				Date of birth of the client
	*			$status				Status of the login which determine whether a clinets account is active or inactive
	*			$brief				Brief introducttion of the client
	*			$description		Description of the client
	*			$organization		Organization associated with the client
	*			$featured			Whether featured client or not
	*			$sort_order			Sorting order
	*			$profession			Profession of the customer or client 
	*			$cus_type			Type of customer e.g. vendor 
	*			$discount_offered	Discount offered to this client
	*
	*	@return int
	*/
	function addRegisterCustomer($member_id, $user_name, $email, $password, $fname, $lname, $gender,  $status, 
					     $brief, $description, $organization, $featured, $profession, $sort_order, $cus_type, $discount_offered)		  
	{
		//echo "here";exit;
		//declare var
		$id	= 0;
		
		//get the values
		$email 			= trim($email);
		$password 		= trim($password);
		$fname 			= addslashes(trim($fname));
		$lname 			= addslashes(trim($lname));
		$user_name		= trim($user_name);
		$brief 			= addslashes(trim($brief));
		$description	= addslashes(trim($description));
		$organization	= addslashes(trim($organization));
		$sort_order		= (int)$sort_order;
		$profession		= addslashes(trim($profession));
		$cus_type		= (int)$cus_type;
		$discount_offered	= doubleval($discount_offered);
		
		//Inserting in customer table
		$x_password = md5_encrypt($password,USER_PASS);
		
		//get all email id to check if it is registered or not
		$select = "SELECT * FROM customer WHERE email = '$email'";
		
		//execute query
		$query	= mysql_query($select);
		
		if(mysql_num_rows($query) > 0)
		{
			header("Location: ".$_SERVER['PHP_SELF']."?action=add_client&message=Email already exists&typeM=ERROR#addCustomer");
		}
		else
		{
			//statement
			$sql	 = 	 "INSERT INTO customer 
						 (member_id, user_name, email, password, fname, lname, gender,  status, 
						 brief, description, organization, featured, profession, sort_order, customer_type, discount_offered)
						 VALUES
						 ('$member_id', '$user_name', '$email', '$x_password', '$fname', '$lname', '$gender',  '$status', 
						 '$brief', '$description', '$organization', '$featured', '$profession','$sort_order', '$cus_type', '$discount_offered')";
						 
			//execute query
			$query	= 	mysql_query($sql);
			
			//echo $sql.mysql_error();exit;
			
			//get the primary key
			$id		= 	mysql_insert_id();
			
			
			//inserting into customer info table
			$sql2	=   "INSERT INTO customer_info 
							(last_logon, no_logon, added_on, customer_id)
							VALUES
							(now(), 1, now(), '$id')";
			$query2		= mysql_query($sql2);
		
		}
		
		
		//return id
		return $id;
		
	}//eof
	
	
	
	
	
	
	/**
	*	Add a product as a wish list
	*
	*	@param
	*			$pid		Product Id
	*			$uid		user id 
	*			November 21 , 2012
	*
	*			Mousumi Dey
	*
	*	@return	null
	*/
	function addWishList($uid, $pid)
	{
		$insert1	= "INSERT INTO customer_basket
						(customer_id , wish_list)
						VALUES
						('$uid','$pid')
						";
		$query1		= mysql_query($insert1);
		//echo $insert1.mysql_error();exit;
	}//eof
	
	
	/**
	*	This function will return all the product according to wishlist
	*
	*	@param
	*			$cusId			User Id
	*
	*	@return array
	*	
	*	@date  22nd November , 2012
	*	@author  Mousumi Dey
	*/
	function getAllProductInWishList($cusId)
	{
		//declare vars
		$data	= array();
		
		//statement
		$select = "SELECT basket_id FROM customer_basket WHERE customer_id='$cusId' AND wish_list!=0 ORDER BY basket_id ";
		
		//execute statement
		$query  = mysql_query($select);
		
		//echo $select.mysql_error();exit;
		
		while($result = mysql_fetch_array($query))
		{
			//hold the data
			$data[]	= $result['basket_id'];
			
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	/**
	*	Show registration data
	*
	*	@param
	*			$customer_id		Customer identity
	*
	*	@return array
	*/
	function getCustomerBasketData($basket)
	{
		//declare var
		$data		= array();
		
		//create the statement
		$select		=   "SELECT * 
						 FROM 	customer_basket
						 WHERE 	basket_id = '$basket'";
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		//fetch the rows
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_object($query))
			{
				$data	=	array(
								  $result->customer_id,		//0			CUSTOMER/USER
								  $result->product_id,		//1
								  $result->quantity,		//2
								  $result->basket_added,	//3
								  $result->final_price,		//4
								  $result->address_id,		//5
								  $result->giftbox,			//6
								  $result->wish_list		//7
								);
			}//while
		}//if
		
		//return the data
		return $data;	
		
	}//	eof
	
	
	/**
	*	Popultae the dropdown list same as pervious function except the dropdown is based upon a 
	*	foreign key value
	*
	*	@param
	*			$selected		If there is any selected value, it will be shown as selected, otherwise put zero(0).
	*			$id				Column name of the primary key
	*			$populate		Column name of the data to be displayed
	*			$table			The table contains the data
	*
	*	@return NULL
	*/
	function populateCusDropDown($selected, $id, $populate1, $populate2, $table)
	{
		$select		= "SELECT * FROM ".$table." ORDER BY ".$populate1."";
		$query		= mysql_query($select);
		
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_array($query))
			{
				$data_id	= $result[$id];
				if($data_id == $selected)
				{
					$select_string = 'selected';
				}
				else
				{
					$select_string = '';
				}
				
				echo "<option value='".$data_id."' class='menuText' ".$select_string.">".
				$result[$populate1]." ".$result[$populate2]."</option>";
				
			}
		}	
	}//eof
	
	
	######################################################################################################################
	#
	#													Customer Banner 
	#
	######################################################################################################################


	/* 
	*	Add a new banner image. Once a image has added the old one will be automatically deleted.
	*
	*	@param	$name	Name or caption of the photo
	*	@param	$desc	Additinal description if required later, not for this version
	*	
	*	@return int
	*/
	function addCustomerBanner($customer_id, $banner_title, $description,  $banner_url, $open_in, $status, $sort_order)
	{
		//add security
		$banner_title 		= mysql_real_escape_string(trim($banner_title));
		$description 		= nl2br(mysql_real_escape_string(trim($description)));
		
		
		//insert and make the photo active
		$insert  = "INSERT INTO customer_banner 
					(customer_id, banner_title, description, banner_url, open_in,  status, sort_order, added_on)
					VALUES
					('$customer_id','$banner_title','$description', '$banner_url', '$open_in', '$status', '$sort_order', now())
					";
		//execute the query 			
		$query   = mysql_query($insert);
		
		//echo $insert.mysql_error(); exit;
		
		$id      = mysql_insert_id();
		
		//return id
		return $id;
	}//eof
	
	/* 
	*	Edit a front image
	*	
	*	@param	$id		Id of teh image
	*	@param	$name	Name or caption of the photo
	*	@param	$desc	Additinal description if required later, not for this version
	*/
	function editCustomerBanner($id, $banner_title, $description, $banner_url, $open_in, $sort_order, $status)
	{
		//add security
		$banner_title 		= mysql_real_escape_string(trim($banner_title));
		$description 		= nl2br(mysql_real_escape_string(trim($description)));
		
		//update
		$update  = "UPDATE customer_banner 
					SET
					banner_title 			= '$banner_title',
					description				= '$description',
					banner_url				= '$banner_url',
					open_in					= '$open_in',
					sort_order				= '$sort_order',
					modified_on				=  now(),
					status					= '$status'
					WHERE 
					customer_banner_id	    = '$id'
					";
		
		//execute the query			
		$query   = mysql_query($update);
		
		//echo $update.mysql_error();exit;
		
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	/**
	*	Delete an customer banner
	*
	*	$id				Customer Banner Id 
	*	$customer_id		Customer banner Id
	*	$path			path of the image
	*/
	function deleteCustomerBanner($bid, $path)
	{
		//delete the image first
		$this->deleteFile($bid, 'customer_banner_id' , $path, 'photo', 'customer_banner');
		$delete = "DELETE FROM customer_banner WHERE customer_banner_id='$bid'";
		$query  = mysql_query($delete);
		if(!query)
		{
			return mysql_error();
		}
	}//eof
	
	
	/**
	*	This function will delete a file from the server and update the
	*	file field, set it to blank
	*
	*	@param
	*			$id				Primary key associated with the table
	*			$column_id		Primary key column name
	*			$path			Path to the file or location of the file
	*			$column_file	Column name of the file
	*			$table			Name of the file
	*			$customer_id	Customer Id column name
	*			$sid			Customer Id Value
	*
	*	@return NULL
	*/
	function deleteCusBannerImg($id, $column_id ,$path, $column_file, $table, $customer_id, $sid)
	{
		//get the file name before deleting
		$select = "SELECT ".$column_file." FROM ".$table." WHERE ".$column_id."='".$id."' AND ".$customer_id."='".$sid."'";
		
		$query  = mysql_query($select);
		
		$result = mysql_fetch_array($query);
		
		if(mysql_num_rows($query) > 0)
		{
			$fileName = $result[$column_file];
			@unlink($path.$fileName); 
		}
		
		//set the column value
		$sql = "UPDATE ".$table." SET ".$column_file."= '' WHERE ".$column_id."='".$id."'";
		mysql_query($sql);
		
		//echo $select." <br />".$sql;exit;
	}//eof
	
	
	
	/**
	*	Retrieve all photo id
	*	@param	$id		photo id
	*	@return array
	*/
	function getCustomerBannerId($customer_id)
	{
		$sql	= "SELECT customer_banner_id FROM customer_banner WHERE customer_id = '$customer_id' ORDER BY added_on DESC";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_banner_id;
			}
		}
		return $data;
	}//eof
	
	/* 
	*	Edit a front image
	*	
	*	@param	$banner_id		Id of teh image
	*	@param	$default_id		Default banner id
	*	@param	$desc	Additinal description if required later, not for this version
	*/
	function setDefaultBanner($banner_id, $default_id)
	{
		
		//update
		$update  = "UPDATE customer_banner 
					SET
					default_banner_id 		= '$default_id',
					photo					= ''
					WHERE 
					customer_banner_id	    = '$banner_id'
					";
		
		//execute the query			
		$query   = mysql_query($update);
		
		//echo $update.mysql_error();exit;
		
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	
	
	/**
	*	Retrieve all customer banner data
	*
	*	@return array
	*	@param	$id		id of the front image
	*/
	function getCustomerBanner($id)
	{
		//create the statement
		$sql	= "SELECT * FROM customer_banner WHERE customer_banner_id= '$id'";
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_object($query);
			$data = array(
							 $result->banner_title,			//0
							 $result->description,			//1
							 $result->photo,				//2
							 $result->status,				//3
							 $result->added_on,				//4
							 $result->modified_on,			//5
							 
							 $result->sort_order,			//6 Added On: September 22, 2011
							 $result->customer_id,			//7 Added on : August 10, 2012
							 $result->banner_url,			//8
							 $result->open_in,				//9
							 $result->default_banner_id				//10
						 );
		}
		return $data;
	}//eof
	
	
	
	/**
	*	Retrieve all front image data
	*
	*	@return array
	*	@param	$id		id of the front image
	*/
	function getCustomerBannerData($id,$customer_id)
	{
		//create the statement
		$sql	= "SELECT * FROM customer_banner
				   WHERE
				   customer_id	= '$customer_id'
				   AND
				   customer_banner_id= '$id'";
		
		//execute the query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_object($query);
			$data = array(
							 $result->banner_title,			//0
							 $result->description,			//1
							 $result->photo,				//2
							 $result->status,				//3
							 $result->added_on,				//4
							 $result->modified_on,			//5
							 
							 $result->sort_order,			//6 Added On: September 22, 2011
							 $result->customer_id,			//7 Added on : August 10, 2012
							 $result->banner_url,			//8
							 $result->open_in,				//9
							 $result->default_banner_id				//10
						 );
		}
		return $data;
	}//eof
	
	
	
	
	
	/**
	*	Get Active ID
	*/
	function getCusBannerActiveId($ban_id)
	{
		$data	= array();
		
		//statement
		$sql 	= "SELECT customer_banner_id FROM customer_banner WHERE customer_banner_id= '$ban_id' AND status='a' ORDER BY  added_on DESC";
		$query 	= mysql_query($sql);
		
		//check for the rows
		if(mysql_num_rows($query) > 0)
		{
			while($row  = mysql_fetch_object($query))
			{
				$data[]  = $row->customer_banner_id;
			}
		}
		
		//return the value
		return $data;
	}//eof
	
	
	####################################################################################################################
	#
	#													Customer Type
	#	
	####################################################################################################################
	
	/**
	*	Create a new category. Note that the category image will be uoloaded by a separate function
	*	which will be using as a utility.
	*
	*	@update	July 21, 2010
	*
	*	@param
	*			$parentId			Parent id
	*			$catName			Category name
	*			$url				Customized url name for the website
	*			$txtBrief			Brief of the category or the tag line of the category
	*			$pageTitle			Title of the page description or text, can be same as the category name
	*			$txtDesc			Description of the category
	*			$sort_order			Sorting order
	*			$table				Name of the table
	*
	*	@return int
	*/
	function addCustomerType($parentId, $cus_type, $code, $remarks)
	{
		//get the var
		$code 		= mysql_real_escape_string($code);
		$remarks	= mysql_real_escape_string($remarks);
		
		//statement
		$insert  = "INSERT INTO customer_type 
					(parent_id, cus_type, cus_type_code, remarks, added_on)
					VALUES
					('$parentId', '$cus_type', '$code', '$remarks', now())";
			
		//execute query		
		$query   = mysql_query($insert);
		//echo $insert.mysql_error(); exit;
		//get teh primary key
		$id      = mysql_insert_id();
		
		//return the key value
		return $id;
		
	}//eof
	
	/**
	*	Edit existing category. Note: the category image will be uoloaded by a separate function
	*	which will be using as a utility.
	*
	*	@update	July 20, 2010
	*
	*	@param
	*			$parentId			Parent id
	*			$catName			Category name
	*			$url				Customized url name for the website
	*			$catId				Category id
	*			$txtBrief			Brief of the category or the tag line of the category
	*			$pageTitle			Title of the page description or text, can be same as the category name
	*			$txtDesc			Description of the category
	*			$sort_order			Sorting order
	*			$table				Name of the table
	*
	*	@return int
	*/
	function editCustomerType($typeId, $parentId, $cus_type, $code, $remarks)
	{
		//get the var
		//get the var
		$code 		= mysql_real_escape_string($code);
		$remarks	= mysql_real_escape_string($remarks);
		
		//statement
		$update  = "UPDATE customer_type
					SET
					parent_id 			= '$parentId',
					cus_type			= '$cus_type',
					cus_type_code		= '$code',
					remarks				= '$remarks',
					modified_on			=  now()
					WHERE 
					customer_type_id	= '$typeId'
					";
					
		//execute query	
		$query   = mysql_query($update);
		
		//echo $update.mysql_error(); exit;
		//echo $update.mysql_error(); exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	/**
	*	This function will delete a file from the server and update the
	*	file field, set it to blank
	*
	*	@param
	*			$id				Primary key associated with the table
	*			$column_id		Primary key column name
	*			$path			Path to the file or location of the file
	*			$column_file	Column name of the file
	*			$table			Name of the file
	*			$customer_id	Customer Id column name
	*			$sid			Customer Id Value
	*
	*	@return NULL
	*/
	function deleteCustomerType($id)
	{
		$delete = "DELETE FROM customer_type WHERE customer_type_id='$id'";
		$query  = mysql_query($delete);
		//echo $query.mysql_error();exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	
	
	/**
	*	Retrieve all customer type id
	*	@param	$id		customer type id
	*	@return array
	*/
	function getAllCustomerTypeId()
	{
		$sql	= "SELECT customer_type_id FROM customer_type";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_type_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all customer type id
	*	@param	$id		customer type id
	*	@return array
	*/
	function getAllParentCustomerTypeId()
	{
		$sql	= "SELECT customer_type_id FROM customer_type WHERE parent_id = 0";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_type_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all customer type id
	*	@param	$id		customer type id
	*	@return array
	*/
	function getChildCustomerTypeId($parent_id)
	{
		$sql	= "SELECT customer_type_id FROM customer_type WHERE parent_id = '$parent_id'";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_type_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Get CustomerType data associated with its key.
	*
	*	@return array
	*/
	function getCustomerTypeData($cus_type_id)
	{
		$data	= array();
		
		$select = "SELECT * FROM customer_type WHERE customer_type_id='$cus_type_id'";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->parent_id,				//0
					$result->cus_type,				//1
					$result->cus_type_code,			//2
					$result->remarks,				//3
					$result->added_on,				//4
					$result->modified_on,			//5
					$result->images					//6
					);
		}
		
		//return the value
		return $data;
	}//eof
	
	
	/**
	*	Get CustomerType data associated with its key.
	*
	*	@return array
	*/
	function getCustomerData1()
	{
		$data	= array();
		
		$select = "SELECT * FROM customer_type";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->parent_id,				//0
					$result->cus_type,				//1
					$result->cus_type_code,			//2
					$result->remarks,				//3
					$result->added_on,				//4
					$result->modified_on,			//5
					$result->images					//6
					);
		}
		
		//return the value
		return $data;
	}//eof
	
	
	
	/**
	*	Populate a dropdown list of category, if there is any selected category, it seletec it first.
	*	This function retrieve the data in recursive manner.
	*
	*	The another version of this function is availble in Utility class. The selection part works when
	*	a user already selected a field.
	*
	*	@param
	*			$id			Parent id of the category
	*			$level		Depth of the category
	*			$selected	Selected category by user, if not any then it will produce the normal list
	*			$type		Type decides whether the list will produce to add a category or to edit
	*						an existing category. The only constant is EDIT.
	*			$cat_id		Applicable for editing purpose. For editing it won't display its name in the 
	*						parent section so that the user won't add the child as it's parent
	*			$table		Name of the table
	*
	*	@return NULL
	*/
	
	
	function customerTypeDropDown($id,$level,$selected,$type,$cat_id, $table)
	{
		if($type == 'edit')
		{
			$select = "SELECT * FROM ".$table." WHERE parent_id='$id' AND customer_type_id 
			<> $cat_id ORDER BY cus_type ";
		}
		else
		{
			$select = "SELECT * FROM ".$table." WHERE parent_id= $id ORDER BY cus_type ";
		}
		
		$query  = mysql_query($select);
		
		//echo $select.mysql_error();exit;
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['customer_type_id'];
			$parent_id 	= $result['parent_id'];
			if($selected == $new_cat_id)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			if($parent_id == 0)
			{
				echo "<option style='font-weight:bold' value='".$new_cat_id."' class='menuText' ".$select_string.">".
				str_repeat("&nbsp;&nbsp;&nbsp;",$level)." ".$result['cus_type'].
				"</option>";
			}
			else
			{
				echo "<option value='".$new_cat_id."' class='menuText' ".$select_string.">".
				str_repeat("&nbsp;&nbsp;&nbsp;",$level)." ".$result['cus_type'].
				"</option>";
			}
			
			$this->customerTypeDropDown($new_cat_id,$level+1,$selected,$type,$cat_id, $table);
		}
	}//eof
	
	function duplicateCustomerType($parent_id, $type_name, $type_id, $table)
	{
		if($type_id == (int)0)
		{
			$select = "SELECT * FROM ".$table." WHERE  parent_id = '$parent_id' 
						AND cus_type = '$type_name'";
		}
		else
		{
			$select = "SELECT * FROM  ".$table." 
					WHERE  parent_id 	= '$parent_id' 
					AND cus_type = '$type_name'
					AND customer_type_id	<> '$type_id'";
		}
		
		$query  = mysql_query($select);
		$msg = '';
		if(mysql_num_rows($query) == 1 )
		{
			$msg = 'ER004';
		}
		else
		{
			$msg = 'SU004';
		}
		
		return $msg;
	}//eof
	
	##########################################################################################################################
	#
	#													Customer Friend
	#
	##########################################################################################################################
	
	function addCustomerFriend($cusId, $friendId, $remarks)
	{
		//get the var
		$remarks	= mysql_real_escape_string($remarks);
		
		//statement
		$insert  = "INSERT INTO customer_friend 
					(customer_id, friend_id, remarks, added_on)
					VALUES
					('$cusId', '$friendId', '$remarks', now())";
			
		//execute query		
		$query   = mysql_query($insert);
		//echo $insert.mysql_error(); exit;
		//get teh primary key
		$id      = mysql_insert_id();
		
		//return the key value
		return $id;
		
	}//eof
	
	/**
	*	Edit existing category. Note: the category image will be uoloaded by a separate function
	*	which will be using as a utility.
	*
	*	@update	July 20, 2010
	*
	*	@param
	*			$parentId			Parent id
	*			$catName			Category name
	*			$url				Customized url name for the website
	*			$catId				Category id
	*			$txtBrief			Brief of the category or the tag line of the category
	*			$pageTitle			Title of the page description or text, can be same as the category name
	*			$txtDesc			Description of the category
	*			$sort_order			Sorting order
	*			$table				Name of the table
	*
	*	@return int
	*/
	function editCustomerFriend($cusFrndId, $cusId, $friendId, $remarks)
	{
		//get the var
		//get the var
		$remarks	= mysql_real_escape_string($remarks);
		
		//statement
		$update  = "UPDATE customer_friend
					SET
					customer_id 		= '$cusId',
					friend_id			= '$friendId',
					remarks				= '$remarks',
					modified_on			=  now()
					WHERE 
					customer_friend_id	= '$cusFrndId'
					";
					
		//execute query	
		$query   = mysql_query($update);
		
		//echo $update.mysql_error(); exit;
		//echo $update.mysql_error(); exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	/**
	*	This function will delete a file from the server and update the
	*	file field, set it to blank
	*
	*	@param
	*			$id				Primary key associated with the table
	*			$column_id		Primary key column name
	*			$path			Path to the file or location of the file
	*			$column_file	Column name of the file
	*			$table			Name of the file
	*			$customer_id	Customer Id column name
	*			$sid			Customer Id Value
	*
	*	@return NULL
	*/
	function deleteCustomerFriend($id)
	{
		$delete = "DELETE FROM customer_friend WHERE customer_friend_id='$id'";
		$query  = mysql_query($delete);
		//echo $query.mysql_error();exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	
	function acceptFriendRequest($cusFriendId)
	{
		
		//statement
		$update  = "UPDATE customer_friend
					SET
					is_accepted 		= 'Y',
					date_accepted		=  now()
					WHERE 
					customer_friend_id	= '$cusFriendId'
					";
					
		//execute query	
		$query   = mysql_query($update);
		
		//echo $update.mysql_error(); exit;
		//echo $update.mysql_error(); exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	
	/**
	*	Retrieve all customer type id
	*	@param	$id		customer type id
	*	@return array
	*/
	function getAllCustomerFriendId()
	{
		$sql	= "SELECT customer_friend_id FROM customer_friend";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_friend_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all customer type id
	*	@param	$id		customer type id
	*	@return array
	*/
	function getCusFrndIdByCusFrnd($cusId, $frndId)
	{
		$sql	= "SELECT customer_friend_id 
				   FROM customer_friend 
				   WHERE customer_id = '$cusId'
				   AND friend_id = '$frndId'";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_friend_id;
			}
		}
		return $data;
	}//eof
	
	
	function getAllFriendId($cusId)
	{
		$data	= array();
		$data2	= array();
		
		$sql1	= "SELECT friend_id 
				   FROM customer_friend
				   WHERE customer_id = '$cusId'";
				   
		//execute the query
		$query1	= mysql_query($sql1);
		
		if(mysql_num_rows($query1) > 0)
		{
			while($result = mysql_fetch_object($query1))
			{
				$data[] = $result->friend_id;
			}
		}
		
		$sql2	= "SELECT customer_id 
				   FROM customer_friend
				   WHERE friend_id = '$cusId'";
				   
		//execute the query
		$query2	= mysql_query($sql2);
		
		if(mysql_num_rows($query2) > 0)
		{
			while($result = mysql_fetch_object($query2))
			{
				$data2[] = $result->customer_id;
			}
		}
		
		$data		= array_merge($data, $data2);
		
		return $data;
	}//eof

	
	/**
	*	Get CustomerType data associated with its key.
	*
	*	@return array
	*/
	function getCustomerFriendData($cus_frnd_id)
	{
		$data	= array();
		
		$select = "SELECT * FROM customer_friend WHERE customer_friend_id='$cus_frnd_id'";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->customer_id,				//0
					$result->friend_id,					//1
					$result->remarks,					//2
					$result->is_accepted,				//3
					$result->date_accepted,				//4
					$result->added_on,					//5
					$result->modified_on				//6
					);
		}
		
		//return the value
		return $data;
	}//eof


	##########################################################################################################################
	#
	#													Customer Privacy
	#
	##########################################################################################################################
	/**
	*	Add customer privacy.
	*	@param
	*			$privacy			Column name of the privacy (e.g - phone, address, im_img etc)
	*			$table				Name of the  table
	*			$remarks			Remarks
	*
	*	@return int
	*/
	function addCustomerPrivacy($privacy, $table, $remarks)
	{
		//get the var
		$remarks	= mysql_real_escape_string($remarks);
		
		//statement
		$insert  = "INSERT INTO customer_privacy 
					(privacy_for, table_name, remarks, added_on)
					VALUES
					('$privacy', '$table', '$remarks', now())";
			
		//execute query		
		$query   = mysql_query($insert);
		//echo $insert.mysql_error(); exit;
		//get teh primary key
		$id      = mysql_insert_id();
		
		//return the key value
		return $id;
		
	}//eof
	
	/**
	*	Edit existing customer privacy.
	*	@param
	*			$cusPrivId			Customer privacy id
	*			$privacy			Column name of the privacy (e.g - phone, address, im_img etc)
	*			$table				Name of the  table
	*			$remarks			Remarks
	*
	*	@return null
	*/
	function editCustomerPrivacy($cusPrivId, $privacy, $table, $remarks)
	{
		//get the var
		//get the var
		$remarks	= mysql_real_escape_string($remarks);
		
		//statement
		$update  = "UPDATE customer_privacy
					SET
					privacy_for 		= '$privacy',
					table_name			= '$table',
					remarks				= '$remarks',
					modified_on			=  now()
					WHERE 
					customer_privacy_id	= '$cusPrivId'
					";
					
		//execute query	
		$query   = mysql_query($update);
		
		//echo $update.mysql_error(); exit;
		//echo $update.mysql_error(); exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	/**
	*	This function will delete a file from the server and update the
	*	file field, set it to blank
	*
	*	@param
	*			$id				Primary key associated with the table
	*
	*	@return NULL
	*/
	function deleteCustomerPrivacy($id)
	{
		$delete = "DELETE FROM customer_privacy WHERE customer_privacy_id='$id'";
		$query  = mysql_query($delete);
		//echo $query.mysql_error();exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	
	/**
	*	Retrieve all customer type id
	*	@param	$id		customer type id
	*	@return array
	*/
	function getAllCustomerPrivacyId()
	{
		$sql	= "SELECT customer_privacy_id FROM customer_privacy";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_privacy_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all customer type id
	*	@param	$id		customer type id
	*	@return array
	*/
	function getCustomerPrivacyIdByCName($col, $table)
	{
		$sql	= "SELECT customer_privacy_id 
				   FROM customer_privacy
				   WHERE privacy_for = '$col'
				   AND table_name = '$table'";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_privacy_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Get Customer Privacy data associated with its key.
	*
	*	@return array
	*/
	function getCustomerPrivacyData($cus_priv_id)
	{
		$data	= array();
		
		$select = "SELECT * FROM customer_privacy WHERE customer_privacy_id='$cus_priv_id'";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->privacy_for,				//0
					$result->table_name,				//1
					$result->remarks,					//2
					$result->added_on,					//3
					$result->modified_on				//4
					);
		}
		
		//return the value
		return $data;
	}//eof
	
	
	##########################################################################################################################
	#
	#													Customer To Privacy
	#
	##########################################################################################################################
	/**
	*	Add customer privacy.
	*	@param
	*			$cus_priv_id		Customer privacy id
	*			$cus_id				Id of the customer 
	*			$ref_id				Privacy reference id
	*			$priv_type			Privacy type
	*
	*	@return int
	*/
	function addCustomerToPrivacy($cus_priv_id, $cus_id, $ref_id, $priv_type)
	{		
		//statement
		$insert  = "INSERT INTO customer_to_privacy 
					(customer_privacy_id, customer_id, privacy_ref_id, privacy_type, added_on)
					VALUES
					('$cus_priv_id', '$cus_id', '$ref_id', '$priv_type', now())";
			
		//execute query		
		$query   = mysql_query($insert);
		//echo $insert.mysql_error(); exit;
		//get teh primary key
		$id      = mysql_insert_id();
		
		//return the key value
		return $id;
		
	}//eof
	
	/**
	*	Edit existing customer privacy.
	*	@param
	*			$cusToPrivId		Customer to privacy id
	*			$cus_priv_id		Customer privacy id
	*			$cus_id				Id of the customer 
	*			$ref_id				Privacy reference id
	*			$priv_type			Privacy type
	*
	*	@return null
	*/
	function editCustomerToPrivacy($cusToPrivId, $cus_priv_id, $cus_id, $ref_id, $priv_type)
	{
		
		//statement
		$update  = "UPDATE customer_to_privacy
					SET
					customer_privacy_id 		= '$cus_priv_id',
					customer_id					= '$cus_id',
					privacy_ref_id				= '$ref_id',
					privacy_type				= '$priv_type',
					modified_on					=  now()
					WHERE 
					customer_to_privacy_id		= '$cusToPrivId'
					";
					
		//execute query	
		$query   = mysql_query($update);
		
		//echo $update.mysql_error(); exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	/**
	*	This function will delete a file from the server and update the
	*	file field, set it to blank
	*
	*	@param
	*			$id				Primary key associated with the table
	*
	*	@return NULL
	*/
	function deleteCustomerToPrivacy($id)
	{
		$delete = "DELETE FROM customer_to_privacy WHERE customer_to_privacy_id='$id'";
		$query  = mysql_query($delete);
		//echo $query.mysql_error();exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	
	/**
	*	Retrieve all customer type id
	*	@param	$id		customer type id
	*	@return array
	*/
	function getAllCustomerToPrivacyId()
	{
		$sql	= "SELECT customer_to_privacy_id FROM customer_to_privacy";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_to_privacy_id;
			}
		}
		return $data;
	}//eof
	
	function getCusToPrivacyIdByCus($cus_privecy_id, $cus_id)
	{
		$sql	= "SELECT customer_to_privacy_id 
				   FROM customer_to_privacy
				   WHERE customer_privacy_id = '$cus_privecy_id'
				   AND customer_id = '$cus_id'";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_to_privacy_id;
			}
		}
		return $data;
	}//eof
	
	function getCusToPrivacyIdByRef($cus_privecy_id, $cus_id, $refIf)
	{
		$sql	= "SELECT customer_to_privacy_id 
				   FROM customer_to_privacy
				   WHERE customer_privacy_id = '$cus_privecy_id'
				   AND customer_id = '$cus_id'
				   AND privacy_ref_id = '$refIf'";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_to_privacy_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Get Customer Privacy data associated with its key.
	*
	*	@return array
	*/
	function getCustomerToPrivacyData($cus_to_priv_id)
	{
		$data	= array();
		
		$select = "SELECT * FROM customer_to_privacy WHERE customer_to_privacy_id='$cus_to_priv_id'";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->customer_privacy_id,				//0
					$result->customer_id,						//1
					$result->privacy_ref_id,					//2
					$result->privacy_type,						//3
					$result->added_on,							//4
					$result->modified_on						//5
					);
		}
		
		//return the value
		return $data;
	}//eof
	
	
	##########################################################################################################################
	#
	#													Customer Preference
	#
	##########################################################################################################################
	/**
	*	Add customer preference.
	*	@param
	*			$cusId				Id of the customer
	*			$def_val_id			Id of tht default value for the preference table
	*			$display_def		Whether default value will display or not, it may be Y(yes) or N(no)
	*			$status				Status of the customer preference
	*
	*	@return int
	*/
	function addCustomerPreference($cusId, $def_val_id, $display_def, $status)
	{		
		//statement
		$insert  = "INSERT INTO customer_preference 
					(customer_id, default_value_id, display_default, status, added_on)
					VALUES
					('$cusId', '$def_val_id', '$display_def', '$status', now())";
			
		//execute query		
		$query   = mysql_query($insert);
		//echo $insert.mysql_error(); exit;
		//get teh primary key
		$id      = mysql_insert_id();
		
		//return the key value
		return $id;
		
	}//eof
	
	/**
	*	Edit existing customer Preference.
	*	@param
	*			$cusPrefId			Customer preference id
	*			$cusId				Id of the customer
	*			$def_val_id			Id of tht default value for the preference table
	*			$display_def		Whether default value will display or not, it may be Y(yes) or N(no)
	*			$status				Status of the customer preference
	*
	*	@return null
	*/
	function editCustomerPreference($cusPrefId, $cusId, $def_val_id, $display_def, $status)
	{
		//get the var
		//get the var
		//$remarks	= mysql_real_escape_string($remarks);
		
		//statement
		$update  = "UPDATE customer_preference
					SET
					customer_id 			= '$cusId',
					default_value_id		= '$def_val_id',
					display_default			= '$display_def',
					status					= '$status',
					modified_on				=  now()
					WHERE 
					customer_preference_id	= '$cusPrefId'
					";
					
		//execute query	
		$query   = mysql_query($update);
		//echo $update.mysql_error(); exit;

		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	/**
	*	This function will delete customer preference
	*
	*	@param
	*			$id				Customer preference id
	*
	*	@return NULL
	*/
	function deleteCustomerPreference($id)
	{
		$delete = "DELETE FROM customer_preference WHERE customer_preference_id='$id'";
		$query  = mysql_query($delete);
		//echo $query.mysql_error();exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	
	/**
	*	Retrieve all customer Preference id
	*	@return array
	*/
	function getAllCustomerPreferenceId()
	{
		$sql	= "SELECT customer_preference_id FROM customer_preference";
		
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_preference_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all customer preference id
	*			$cusId				Id of the customer
	*			$def_val_id			Id of tht default value for the preference table
	*
	*	@return array
	*/
	function getCusPrefIdByCusDef($cusId, $def_val_id)
	{
		$sql	= "SELECT customer_preference_id 
				   FROM customer_preference
				   WHERE customer_id = '$cusId'
				   AND default_value_id = '$def_val_id'";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_preference_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Get Customer preference data associated with its key.
	*
	*	@return array
	*/
	function getCustomerPreferenceData($cus_pref_id)
	{
		$data	= array();
		
		$select = "SELECT * FROM customer_preference WHERE customer_preference_id='$cus_pref_id'";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->customer_id,				//0
					$result->default_value_id,			//1
					$result->display_default,			//2
					$result->status,					//3
					$result->added_on,					//4
					$result->modified_on				//5
					);
		}
		
		//return the value
		return $data;
	}//eof
	
	
	/**
	*	Retrieve all active Preference id by default category id
	*	@return array
	*/
	function getActivePreferenceIdByDefaultCat($def_cat_id, $cusId)
	{
		$sql	= "SELECT *
				   FROM customer_preference CP, default_value DV
				   WHERE CP.default_value_id = DV.default_value_id
				   AND CP.status = 'a'
				   AND DV.default_categories_id = '$def_cat_id'
				   AND CP.customer_id = '$cusId'";
		
		//execute the query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_preference_id;
			}
		}
		return $data;
	}//eof
	
	function getPreferenceIdByDefaultCat($def_cat_id, $cusId)
	{
		$sql	= "SELECT *
				   FROM customer_preference CP, default_value DV
				   WHERE CP.default_value_id = DV.default_value_id
				   AND DV.default_categories_id = '$def_cat_id'
				   AND CP.customer_id = '$cusId'";
		
		//execute the query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->customer_preference_id;
			}
		}
		return $data;
	}//eof
	
	/** 
	*	Returns the list of client by type id
	*
	*	@param
	*			$month		 month of joining
	*			$year		 year of joining
	*
	*	@return array
	*/
	
	function getCustomerByMonthYear($month, $year)
	{
		//declare vars
		$data		= array();
	
		//generate the statement
		$select		= "SELECT customer_id 
					   FROM customer_info 
					   WHERE MONTH(added_on) = '$month' 
					   AND YEAR(added_on) = '$year'";
		
		
		//execute query
		$query		= mysql_query($select);
		
		//fetch the values
		while($result	= 	mysql_fetch_object($query))
		{
			$data[]		= $result->customer_id;
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*-------------------------------------------------Select Customer Details---------------------------------------*/
	
	/* Display all data */
	/*
		$pid= orders_id 
	*/
	
	 public function CustomerDtlsearch($in){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM customer where user_name like '%$in%'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	/**
	*	========================Search employee=========================================
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getEmployeeSearch($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT customer_id FROM customer";
		}
		else
		{
			$sql = "SELECT customer_id
					FROM   customer
					WHERE (customer_id LIKE '%$keyword%' OR
						   fname LIKE '%$keyword%%' OR
						   verification_no LIKE '%$keyword%%' OR
						   workas LIKE '%$keyword%%');";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
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
	
	
		
}//eoc
?>