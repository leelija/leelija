<?php 
include_once('encrypt.inc.php'); 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
THIS CLASS REGISTER A NEW USER

AUTHOR 		: HIMADRI
DATE   		: JULY 03, 2006
VERSION		: 1.0
COPYRIGHT	: ANALYZE SYSTEM
EMAIL		: HIMADRI.S.ROY@ANSYSOFT.COM
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

class Registration
{
	/*
		THIS FUNCTION WILL REGISTER A NEW USER TO THE SYSTEM. THE PROCESS WILL CHECK IF BEFORE REGISTRATION THE USER
		HAS SELECTED ANY PRODUCT TO SHOP OR NOT, IF SO, IT WILL AUTOMATICALLY PUT ALL THE PRODUCT TO THE CUSTOMER BASKET
		AFTER THE SUCCESSFUL REGISTRATION. AFTER THE REGISTRATION PROCESS AN EMAIL WILL BE SENDING TO THE CUSTOMER
		REGARDING HIS REGISTRATION.
		
		IT RETURNS CUSTOMER_ID AFTER THE REGISTRATION, AND AUTOMATICALLY LOG ON THE USER TO THE SYSTEM
		
		VARIABLES USED:
		
	*/
	function registerUser($email, $password, $fname, $lname, $gender, $dob,$company_name,$address1,
	$address2,$phone,$city,$state,$postal_code,$countries_id, $newsletter, $fax )
	{
		$email 			= trim($email);
		$password 		= trim($password);
		$fname 			= trim($fname);
		$lname 			= trim($lname);
		$company_name 	= trim($company_name);
		$address1		= trim($address1);
		$address2		= trim($address2);
		$phone 			= trim($phone);
		$city 			= trim($city);
		$state 			= trim($state);
		$postal_code 	= trim($postal_code);
		$countries_id	= trim($countries_id);
		$fax 			= trim($fax);
		
		//INSERTING INTO CUSTOMERS TABLE
		$x_password = md5_encrypt($password,'Admin Confidential Area');
		$insert = 		"INSERT INTO customers 
						(email, password, fname, lname,gender)
						VALUES
						('$email', '$x_password', '$fname', '$lname','$gender')";
		$query	= mysql_query($insert);
		$id		= mysql_insert_id();
		
		//INSERTING INTO CUSTOMER_DESCRIPTION TABLE
		$insert1	=	"INSERT INTO customer_description
						(customer_id, dob, company_name, address1, 
						address2,  phone, city, state, countries_id, 
						newsletter, fax)
						VALUES
						('$id', '$dob', '$company_name', '$address1', 
						'$address2','$phone', '$city', '$state', '$countries_id', 
						'$newsletter', '$fax')";
		$query1		= mysql_query($insert1);
		
		//INSERTING INTO CUSTOMER_INFO TABLE
		$insert2	=   "INSERT INTO customer_info 
						(last_logon, no_logon, account_created, customer_id)
						VALUES
						(now(), 1, now(), '$id')";
		$query2		= mysql_query($insert2);
		
		//Inserting data into email subscriber table
		$insert3	=   "INSERT INTO email_subscriber 
						(customer_id, email, fname, lname, added_on, status)
						VALUES
						('$id', '$email', '$fname', '$lname',now(),'$newsletter')";
		$query3		= mysql_query($insert3);
		
		return $id;
		
	}//	END OF NEW CUSTOMER REGISTRATION
	
	/*
		EDIT REGISTRATION INFORMATION
	*/
	function editRegInfo($user_id, $fname, $lname, $gender, 
						$dob,$company_name,$address1,
						$address2,$phone,$city,$state,$postal_code,
						$countries_id, $newsletter, $fax)
	{
		$update = 		"UPDATE customers 
						SET
						fname = '$fname',
						lname = '$lname',
						gender = '$gender'
						WHERE 
						customer_id = '$user_id'
						";
		$query	= mysql_query($update);
		
		//INSERTING INTO CUSTOMER_DESCRIPTION TABLE
		$update1	=	"UPDATE customer_description
						SET
						dob 			='$dob', 
						company_name	='$company_name', 
						address1		='$address1', 
						address2		='$address2',  
						phone			='$phone', 
						city			='$city', 
						state			='$state',
						postal_code		='$postal_code', 
						countries_id	='$countries_id', 
						newsletter		='$newsletter', 
						fax				='$fax'
						WHERE
						customer_id = '$user_id'
						";
		$query1		= mysql_query($update1);
	}//END OF EDITING REGISTRATION INFO
	
	
	/*
		SHOW RAGISTRATION DATA
		VARIABLE:
		CUSID			:	ID OF THE CUSTOMER
	*/
	function showRegInfo($customer_id)
	{
		$select		= "SELECT * FROM 
						customers C, customer_info CI, customer_description CD
						WHERE 
						C.customer_id =CI.customer_id
						AND	C.customer_id =CD.customer_id 
						AND C.customer_id ='$customer_id'";
		
		$query		= mysql_query($select);
		$data		= array();
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_array($query))
			{
				$data	=	array(
								  $result['email'],					//0
								  $result['fname'],					//1
								  $result['lname'],					//2
								  $result['gender'],				//3
								  $result['last_logon'],			//4
								  $result['no_logon'],				//5
								  $result['account_created'],		//6
								  $result['last_modified'],			//7
								  $result['dob'],					//8
								  $result['company_name'],			//9
								  $result['address1'],				//10
								  $result['address2'],				//11
								  $result['mobile'],				//12
								  $result['phone'],					//13
								  $result['city'],					//14
								  $result['state'],					//15
								  $result['postal_code'],			//16
								  $result['countries_id'],			//17
								  $result['newsletter'],			//18
								  $result['fax']					//19
								  							  
								);
			}//END OF WHILE
		}	//END OF IF
		
		return $data;	
		
	}//	END OF SHOW SHIPPING
	
	/*
		EDIT PASSWORD, DEPENDS ON USER TYPE. IF USER IS THE SUPER ADMIN, S/HE DOESN'T NEED TO ENTER OLD PASSWORD.
		IF THE USER IS THE NORMAL USER HE NEEDS TO PUT HIS OWN PASSWORD FOR VARIFICATION
		VARIABLE:
		USERTYPE		:	ROLE OF THE USER, USER WITH NORMAL OR ADMIN PRIVILEGES
		OLDPASS			:	OLD PASSWORD
		NEWPASS			:	NEW PASSWORD
		USERID			:	USER LOGIN ID
		CNFPASS			:	CONFIRM PASSWORD
	*/
	function editPassword($old_pass, $new_pass, $cnf_pass, $user_type, $user_id)
	{
		
		//CHECK THE LENGTH OF THE NEW PASSWORD
		if(strlen($new_pass) < 6)
		{
			header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=Error: password is too short");
		}
		else if($new_pass != $cnf_pass)
		{
			header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=Error: password doesn't match with the confirm password");
		}
		else
		{
			
			$select		= "SELECT password FROM customers WHERE customer_id='$user_id'";
			$query      = mysql_query($select);
			$result 	= mysql_fetch_array($query);
			$x_password = '';
			$new_pass	= md5_encrypt($new_pass,'Admin Confidential Area');
			
			if(mysql_num_rows($query) > 0)
			{
				$dbpass	    = $result['password'];
				$x_password = md5_decrypt($dbpass,'Admin Confidential Area');
			}
			else
			{
				header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=Error: no such user exist");
			}
			
			if($user_type == 'admin')
			{
				if(!isset($_SESSION['admin']))
				{
					header("Location: index.php");
				}//NEED TO PUT EXTRA SECURITY
				else
				{
					$update	= "UPDATE customers SET password = '$new_pass' WHERE customer_id='$user_id'";
					$query	= mysql_query($update);
					header("Location: ".$_SERVER['PHP_SELF']."?action=success&msg= password has changed successfully");
				}//else change password
			}//IF USER TYPE ADMIN
			else
			{
				//echo "else ".$x_password." ".$old_pass;exit;
				if($x_password != $old_pass)
				{
					//echo $x_password." ".$old_pass;exit;
					header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=Error: old password doesn't match with the entered value");
				}//ELSE CHECK OLD PASSWORD
				elseif(!isset($_SESSION['userid']))
				{
					header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=edit_pass&msg=Error: logon before change your password");
				}//whether the user is logged on or not
				else
				{
					$update	= "UPDATE customers SET password = '$new_pass' WHERE customer_id='$user_id'";
					$query	= mysql_query($update);
					header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id."&action=success&msg= password has changed successfully");
				}//ELSE CHANGE PASSWORD BY THE USER
				
			}//user is the normal user
			
		}//END OF ELSE
	}//END OF EDITING REGISTRATION INFO
	
	
}
?>