<?php 
/**
*	Register a new user, edit or update registration information.
*
*	UPDATE	September 10, 2010
*	Customer type has been added to the system.
*
*
*	UPDATE December 23, 2010
*	Vendor section has been added to the system.
*
*
*	@author		Himadri Shekhar Roy
*	@date		December 1, 2006
*	@update		March 17, 2008
*	@version	2.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/

include_once('encrypt.inc.php'); 
include_once('utility.class.php');


class Client extends Utility
{
	/**
	*	Register a new Client.
	*	
	*	@update	September 10, 2010
	*
	*
	*	@param
	*			$user_name			User Name
	*			$email				Clients Email
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
	*
	*	@return int
	*/
	function addClient($cusTypeId, $member_id, $user_name, $email, $password, $fname, $lname, $gender, $dob, $status, $brief, 
					   $description, $organization, $featured, $profession, $sort_order, $acc_verified, $cus_type)		  
	{
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
		$acc_verified	= addslashes(trim($acc_verified));
		$cus_type		= (int)$cus_type;
		
		//Inserting in customer table
		$x_password = md5_encrypt($password,USER_PASS);
		
		//statement
		$sql	 = 	 "INSERT INTO customer 
					 (customer_type_id, member_id, user_name, email, password, fname, lname, gender, dob, status, 
					 brief, description, organization, featured, profession, sort_order, acc_verified)
					 VALUES
					 ('$cusTypeId', '$member_id', '$user_name', '$email', '$x_password', '$fname', '$lname', '$gender', '$dob', '$status', 
					 '$brief', '$description', '$organization', '$featured', '$profession','$sort_order', '$acc_verified')";
					 
		//execute query
		$query	= 	mysql_query($sql);
		//echo $sql.mysql_error();exit;
		
		//get the primary key
		$id		= 	mysql_insert_id();
		
		
		//inserting into customer info table
		$sql2	=   "INSERT INTO customer_info 
						(last_logon, no_logon, added_on, customer_id)
						VALUES
						(now(), '1', now(), '$id')";
		$query2		= mysql_query($sql2);
		
		//return id
		return $id;
		
	}//eof
	
	
	
	/**
	*	Add client's address
	*	
	*	@param
	*			$cus_id			Client's id
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
	*	@return string
	*/
	function addCusAdd($cus_id, $add1, $add2, $add3, $t_id, $c_id, $p_id,$p_code,$country, $ph1, 
						$ph2, $fax, $mobile)
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
		$country	= addslashes(trim($country));
		
		//statement
		$sql 	= "INSERT INTO customer_address
				  (customer_id, address1, address2, address3, town_id, 
				  county_id, province_id, postal_code,countries_id, phone1, phone2, 
				  fax, mobile )
				  VALUES
				  ('$cus_id', '$add1','$add2','$add3','$t_id',
				   '$c_id', '$p_id','$p_code','$country','$ph1','$ph2',
				  '$fax','$mobile')";
		
		//echo "Query = ".$sql."<br />";
		//execute query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		
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
	*	Edit registration information
	*	
	*	@param
	*			$user_id			Client id or primary key
	*			$email				Email address
	*			$fname				First name of the client
	*			$lname				last name of the client
	*			$brief				Brief introducttion of the client
	*			$description		Description of the client
	*			$organization		Organization associated with the client
	*			$member_id			Unique member id
	*			$cus_type			Type of customer e.g. vendor 
	*
	*	@return	null
	*/
	function editClient($user_id, $email, $fname, $lname, $brief, $description, $organization, $featured, 
					    $profession, $sort_order, $member_id, $cus_type)			
	{
		//get the vars
		$email 			= trim($email);
		$fname 			= addslashes(trim($fname));
		$lname 			= addslashes(trim($lname));
		$brief 			= addslashes(trim($brief));
		$description	= addslashes(trim($description));
		$organization	= addslashes(trim($organization));
		$sort_order		= addslashes(trim($sort_order));
		$profession		= addslashes(trim($profession));
		$member_id		= addslashes(trim($member_id));
		$cus_type		= (int)$cus_type;
		
		//statement
		$update = 		"UPDATE customer 
						SET
						email			= '$email',
						fname 			= '$fname',
						lname 			= '$lname',
						brief 			= '$brief',
						description		= '$description',
						organization	= '$organization',
						featured		= '$featured',
						profession		= '$profession',
						sort_order		= '$sort_order',
						member_id		= '$member_id',
						customer_type	= '$cus_type'
						WHERE 
						customer_id = '$user_id'
						";
			
		//execute query			
		$query	= mysql_query($update);
		
	}//eof
	
	
	
	
	/**
	*	Update the date time, whenever the any data is updated.
	*
	*	@param
	*			$cus_id		Client id
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
	
	function updateClientAddr($cus_id, $add1, $add2, $add3, $t_id, $p_id, $p_code, 
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
				  town	 			='$t_id',				
				  province	 		='$p_id',
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
	*			$id				Client's id
	*			$path			Path to the images
	*
	*	@return string
	*/
	function deleteClient($id, $path)
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
		
		//delete from speed dating
		$sql	= "DELETE FROM dating_member WHERE customer_id='$id'";
		$query	= mysql_query($sql);
		
		//delete from lucky draw winner
		$sql	= "DELETE FROM lucky_draw_winner WHERE customer_id='$id'";
		$query	= mysql_query($sql);
		
		//delete from buyer seller
		$sql	= "DELETE FROM buyer_seller WHERE customer_id='$id'";
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
	
	function getAllClient($num, $ordBy, $ordType)
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
			$select		= "SELECT * FROM customer_info ORDER BY ".$ordBy." ".$ordType." LIMIT $num";
		}
		else
		{
			$select		= "SELECT * FROM customer_info ORDER BY ".$ordBy." ".$ordType." DESC";
		}
		
		//execute query
		$query		= mysql_query($select);
		
		//fetch the values
		while($result	= 	mysql_fetch_object($query))
		{
			$data[]		= $result->CUSID;
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	function getFeaturedClient($num)
	{
		//declare vars
		$data		= array();
	
		//generate the statement
		if( (int)$num > 0)
		{
			$select		= "SELECT 	CI.customer_id AS CUSID 
						   FROM 	customer_info CI, customer C, customer_address CA 
						   WHERE 	CI.customer_id = C.customer_id
						   AND		CI.customer_id = CA.customer_id
						   ORDER BY C.featured DESC, CI.added_on DESC LIMIT $num";
		}
		else
		{
			$select		= "SELECT 	CI.customer_id AS CUSID 
						   FROM 	customer_info CI, customer C, customer_address CA 
						   WHERE 	CI.customer_id = C.customer_id
						   AND		CI.customer_id = CA.customer_id
						  ORDER BY C.featured DESC, CI.added_on DESC";
		}
		
		
		//execute query
		$query		= mysql_query($select);
		
		//fetch the values
		while($result	= 	mysql_fetch_object($query))
		{
			$data[]		= $result->CUSID;
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
	function getClientData($customer_id)
	{
		//declare var
		$data		= array();
		
		//create teh statement
		$select		=   "SELECT * 
						 FROM 	customer C, customer_info CI, customer_address CD
						 WHERE 	C.customer_id = CI.customer_id
						 AND	C.customer_id = CD.customer_id 
						 AND 	C.customer_id = '$customer_id'";
		
		//execute query
		$query		= mysql_query($select);
		
		//fetch the rows
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_object($query))
			{
				$data	=	array(
								  $result->user_name,			//0		CUSTOMER/USER
								  $result->email,				//1
								  $result->password,			//2
								  $result->fname,				//3
								  $result->lname,				//4
								  $result->gender,				//5
								  $result->dob,					//6
								  $result->status,				//7
								  $result->image,				//8
								  $result->brief,				//9
								  $result->description,			//10
								  $result->organization,		//11
								  $result->featured,			//12
								  $result->sort_order,			//13
								  
								  $result->address1,			//14		ADDRESS
								  $result->address2,			//15
								  $result->address3,			//16
								  $result->town_id,				//17
								  $result->province_id,			//18
								  $result->postal_code,			//19
								  $result->phone1,				//20
								  $result->phone2,				//21
								  $result->fax,					//22
								  $result->mobile,				//23
								  $result->countries_id,		//24
								  
								  $result->no_logon,			//25	ADDED LATER
								  $result->last_logon,			//26
								  $result->added_on,			//27					  
								  $result->modified_on,			//28
								  
								  $result->member_id,			//29	Added on Sepetember 4, 2010
								  $result->profession,			//30
								  
								  $result->customer_type_id		//31	Added on Sepetember 10, 2010
								  					  
								);
			}//while
		}//if
		
		//return the data
		return $data;	
		
	}//	eof
	
	/**
	*	Edit the password, depending upon who is editing. Administrator doesn't require to 
	*	verify password again. For a normal user he needs to verify his old password.
	*	
	*	@param
	*			$user_type	Role of teh user, administrator or normal
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
			$msg = "Error: password is too short";
			header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=".$msg);
		}
		else if($new_pass != $cnf_pass)
		{
			$msg = "Error: password doesn't match with the confirm password";
			header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=".$msg);
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
				$msg = "Error: no such user exist";
				header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=".$msg);
			}
			
			if($user_type == 'LANDScape_Portal_2010ADMIN')
			{
				if(!isset($_SESSION['LANDScape_Portal_2010ADMIN']))
				{
					header("Location: index.php");
				}//extra security
				else
				{
					$update	= "UPDATE customer SET password = '$new_pass' WHERE customer_id='$user_id'";
					$query	= mysql_query($update);
					$msg = "password has changed  successfully";
					header("Location: ".$_SERVER['PHP_SELF']."?action=success&msg=".$msg);
				}//else
			}//admin user
			else
			{
				//echo "else ".$x_password." ".$old_pass;exit;
				if($x_password != $old_pass)
				{
					//echo $x_password." ".$old_pass;exit;
					$msg = "Error: old password doesn't match with the entered value";
					header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=".$msg);
				}//ELSE CHECK OLD PASSWORD
				elseif(!isset($_SESSION['userid']))
				{
					$msg = "Error: logon before change your password";
					header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=".$msg);
				}//whether the user is logged on or not
				else
				{
					$update	= "UPDATE customer SET password = '$new_pass' WHERE customer_id='$user_id'";
					$query	= mysql_query($update);
					$msg = " password has changed successfully";
					header("Location: "."user_account.php"."?user_id=".$user_id."&action=success&msg=".$msg."&typeM=SUCCESS");
				}//else
				
			}//normal user

			
		}//else
	}//eof
	
	////////////////////////////////////////////////////////////////////////////////////////
	//
	//					**************	Email Subscription	*******************
	//
	///////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Check the status of email subscribed by the user
	*
	*	@param
	*			$email		Email of teh customer
	*/
	function checkEmailStat($email)
	{
		$sql	= "SELECT status FROM email_subscriber WHERE email='$email' ";
		$query	= mysql_query($sql);
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
		$sql	= "UPDATE email_subscriber SET status='$status' WHERE email='$email' ";
		$query	= mysql_query($sql);
	}
	
	
	
	
	
	
	#################################################################################################################
	#
	#													Vendor - December 23, 2010
	#
	#################################################################################################################
	
	/**
	* 	Add new vendor
	*	
	*	@param	
	*			$cusId			Customer id
	*			$compName		Company name or store name
	*			$compLabel		Company label
	*			$ownership		Ower of the company
	*			$website		Name of the website
	*			$bizType		Business type or type of trade the company does
	*			$members		Members of the company
	*			$discount		Discount offered
	*			$desc			Description of the company
	*			$services		Services offered by the company
	*			$conPer			Person to be contacted
	*			$conTitle		Title or designation of the person
	*			$conAddr		Contact address
	*			
	*
	*	@return	int
	*/
	function addVendor($cusId, $compName, $compLabel, $ownership, $website, $bizType, $members, $discount, $desc, 
					   $services, $conPer, $conTitle, $conAddr)
	{
		//declare vars
		$result = 0;
		
		//added security
		$compName	= addslashes(trim($compName)); 
		$compLabel	= addslashes(trim($compLabel)); 
		$ownership	= addslashes(trim($ownership));
		$website	= addslashes(trim($website));
		$bizType	= addslashes(trim($bizType));
		$members	= addslashes(trim($members));
		$discount	= addslashes(trim($discount));
		$desc		= addslashes(trim($desc));
		$services	= addslashes(trim($services));
		$conPer		= addslashes(trim($conPer));
		$conTitle	= addslashes(trim($conTitle));
		$conAddr	= addslashes(trim($conAddr));
		
		
		//get all customer id
		$cusIds	= $this->getAllId('customer_id', 'vendor');
		
		if(!in_array($cusId, $cusIds))
		{
			//statement
			$sql 	= "INSERT INTO vendor
					  (customer_id, company_name, company_label, ownership, website, business_type, members, discount_offered, description, 
					   services, contact_person, contact_title, contact_address, added_on)
					   VALUES
					  ('$cusId', '$compName', '$compLabel', '$ownership', '$website', '$bizType', '$members', '$discount', '$desc', 
					   '$services', '$conPer', '$conTitle', '$conAddr', now())";
			
			//query
			$query	= mysql_query($sql);
			
			//get the primary key
			$result = mysql_insert_id();
		}
		
		
		//return result
		return $result;
		
	}//eof
	
	
	/**
	*	Update vendor
	*	
	*	@param
	*			$id				Vendor identity	
	*			$cusId			Customer id
	*			$compName		Company name or store name
	*			$compLabel		Company label
	*			$ownership		Ower of the company
	*			$website		Name of the website
	*			$bizType		Business type or type of trade the company does
	*			$members		Members of the company
	*			$discount		Discount offered
	*			$desc			Description of the company
	*			$services		Services offered by the company
	*			$conPer			Person to be contacted
	*			$conTitle		Title or designation of the person
	*			$conAddr		Contact address
	*
	*
	*	@return string
	*/
	function updateVendor($id, $cusId, $compName, $compLabel, $ownership, $website, $bizType, $members, $discount, $desc, 
					      $services, $conPer, $conTitle, $conAddr)
	{
	
		//added security
		$compName	= addslashes(trim($compName)); 
		$compLabel	= addslashes(trim($compLabel)); 
		$ownership	= addslashes(trim($ownership));
		$website	= addslashes(trim($website));
		$bizType	= addslashes(trim($bizType));
		$members	= addslashes(trim($members));
		$discount	= addslashes(trim($discount));
		$desc		= addslashes(trim($desc));
		$services	= addslashes(trim($services));
		$conPer		= addslashes(trim($conPer));
		$conTitle	= addslashes(trim($conTitle));
		$conAddr	= nl2br(addslashes(trim($conAddr)));
		
		
		//statement
		$sql	= "UPDATE vendor SET
				  customer_id 		='$cusId',
				  company_name 		='$compName',
				  company_label 	='$compLabel',
				  ownership 		='$ownership',
				  website 			='$website',
				  business_type 	='$bizType',
				  members 			='$members',
				  discount_offered 	='$discount',
				  description 		='$desc',
				  services 			='$services',
				  contact_person 	='$conPer',
				  contact_title 	='$conTitle',
				  contact_address	= '$conAddr',
				  modified_on 		= now()
				  WHERE 
				  vendor_id 			= '$id'
				  ";
		
		//execute query
		$query	= mysql_query($sql);
		
		
	}//eof
	
	
	
	/**
	*	Delete a vendor from the database along with it's donor as well.
	*
	*	@param 
	*			$id				Vendor id
	*			$path			Path to vendor information like brochure etc.
	*
	*	@return string
	*/
	function deleteVendor($id, $path)
	{
		
		//get vendor detail
		$vendorDtl	= $this->getVendorData($id);
		
		//emap, brochure, catalogue
		$emap		= $vendorDtl[13];
		$brochure	= $vendorDtl[14];
		$catalogue	= $vendorDtl[15];
		
		//deleting emap
		if( ($emap != '') &&  (file_exists($path.$emap)) )
		{
			@unlink($path.$emap);
		}
		
		//deleting brochure
		if( ($brochure != '') &&  (file_exists($path.$brochure)) )
		{
			@unlink($path.$brochure);
		}
		
		//deleting catalogue
		if( ($catalogue != '') &&  (file_exists($path.$catalogue)) )
		{
			@unlink($path.$catalogue);
		}
		
		//deleting from vendor
		$sql	= "DELETE FROM vendor WHERE vendor_id='$id'";
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
	*	Retrieve all vendor id
	*
	*	@return array
	*/
	function getVendorId()
	{
		$sql	= "SELECT vendor_id FROM vendor ORDER BY sort_order ASC, added_on DESC";
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->vendor_id;
			}
		}
		
		//return data
		return $data;
		
	}//eof
	
	
	/**
	*	Retrieve all vendor data
	*	
	*	@param	
	*			$id		Identity of the vendor
	*
	*	@return array
	*/
	function getVendorData($id)
	{
		//declare var
		$data	= array();
	
		//create the statement
		$sql	= "SELECT * FROM vendor WHERE vendor_id= '$id'";
		
		//execute query
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query)> 0)
		{
			$result = mysql_fetch_object($query);
			$data = array(
						 $result->customer_id,				//0
						 $result->company_name,				//1
						 $result->company_label,			//2
						 $result->ownership,				//3
						 $result->website,					//4
						 $result->business_type,			//5
						 $result->members,					//6
						 $result->discount_offered,			//7
						 $result->description,				//8
						 $result->services,					//9
						 $result->contact_person,			//10
						 $result->contact_title,			//11
						 $result->contact_address,			//12
						 $result->emap,						//13
						 $result->brochure,					//14
						 $result->catalogue,				//15
						 $result->added_on,					//16
						 $result->modified_on				//17
						 );
		}
		
		//return data
		return $data;
		
	}//eof
	
	
	
	
	####################################################################################################
	#
	#									Buyer and Seller
	#
	####################################################################################################
	
	
	/**
	*	Add buyer seller
	*	
	*	@param
	*			$cus_type				Customer type
	*			$customer_id			Customer identity
	*			$level					Level
	*			$sort_order				Sorting order
	*
	*	@return int
	*/
	function addBuyerSeller($cus_type, $customer_id, $level, $sort_order)
	{
		//declare var
		$result = 0;
		
		//statement
		$sql 	= "INSERT INTO buyer_seller
				  (cus_type, customer_id, level, sort_order, added_on)
				  VALUES
				  ('$cus_type', '$customer_id', '$level', '$sort_order', now())
				  ";
				  
		//execute query
		$query	= mysql_query($sql);
		
		//get the id
		$result = mysql_insert_id();
		
		//return the value
		return $result;
		
	}//eof
	
	
	
	
	/**
	*	Update buyer seller
	*	
	*	@param
	*			$buyer_seller_id			Lucky draw id
	*			$customer_id				Customer identity
	*			$level						Level
	*			$sort_order					Sorting order
	*
	*	@return int
	*/
	function updateBuyerSeller($buyer_seller_id, $cus_type, $customer_id, $level, $sort_order)
	{
		//statements
		$sql 	= "UPDATE buyer_seller
				  SET
				  cus_type			= '$cus_type',
				  customer_id 		= '$customer_id',
				  level		 		= '$level',
				  sort_order 		= '$sort_order',
				  modified_on		= now()
				  WHERE
				  buyer_seller_id = '$buyer_seller_id'
				  ";
				  
		//execute query
		$query	= mysql_query($sql);
		
	}//eof
	
	
	
	/**
	*	Delete buyer seller
	*	
	*	@param	
	*			$id			Lucky draw winner id
	*			
	*	@return int
	*/
	function deleteBuyerSeller($id)
	{
		//declare vars
		$result = '';
		
		//statement
		$sql 	= "DELETE FROM buyer_seller WHERE buyer_seller_id = '$id' ";
		
		//query
		$query	= mysql_query($sql);
		
		//declare
		$result = mysql_insert_id();
		
		//return
		return $result;
		
	}//eof
	
	
	
	/**
	*	Retrieve all buyer seller id
	*	
	*	@param
	*			$typeId			Customer type id.
	*
	*	@return array
	*/
	function getBuyerSellerId($typeId)
	{
		//declare var
		$data	= array();
		$sql	= '';
		
		
		//building the statement
		if($typeId	== '')
		{
			$sql	= "SELECT buyer_seller_id FROM buyer_seller ORDER BY added_on, sort_order ";
		}
		else
		{
			$sql	= "SELECT buyer_seller_id FROM buyer_seller WHERE cus_type = '$typeId'  ORDER BY sort_order ";
		}
				  
		//execute query
		$query	= mysql_query($sql);
		
		//result
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->buyer_seller_id;
			}
		}
		
		//return 
		return $data;
		
	}//eof
	
	
	
	/**
	*	Retrieve buyer seller data
	*
	*	@param	
	*			$id		Lucky draw winner id
	*
	*	@return array
	*	
	*/
	function getBuyerSellerData($id)
	{
		//declare var
		$data	= array();
		
		//create the statement
		$sql	= "SELECT 	* 
				   FROM 	buyer_seller
				   WHERE 	buyer_seller_id = $id
				   ";
		
		//execute query
		$query	= mysql_query($sql);
		
		//fetch data
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_object($query);
			
			//get array
			$data = array(
						 $result->cus_type,				//0
						 $result->customer_id,			//1
						 $result->level,				//2
						 $result->sort_order,			//3
						 $result->added_on,				//4
						 $result->modified_on			//5
						 );
		}
		
		//return data
		return $data;
		
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
		
	
	
	
	
	
	
	
}//eoc
?>