<?php 
/**
*	This class will validate the user login info at the runtime
*
*	@author		Safikul Islam
*	@date   	Nov 08, 2016
*	@version	1.0
*	@copyright	MonienterPrises
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
*/

require_once('encrypt.inc.php');  
require_once('utility.class.php'); 


class Login extends Utility
{
	/*
		THIS FUNCTION WILL VALIDATE THE USER AND RETURN THE 
		$login 		= user input for login name
		$password 	= user input for password
		$dbLogin    = database login column name
		$dbPass     = database password column name
		$table      = table name to query
	*/
	function validate($login, $password, $bdLogin, $dbPass, $table)
	{
		
		$select     = "SELECT * FROM ".$table." WHERE ".$bdLogin." = '$login'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		
		//echo $select." ".mysql_num_rows($query);echo $select ;echo "DB Pass = ".$x_password.", Encrypted pass = ".$dbpass;exit;
		//echo $select.mysql_error();exit;
		
		if(mysql_num_rows($query) > 0)
		{
			//get the password
			$dbpass	    = $result[$dbPass];
			$x_password = md5_decrypt($dbpass,USER_PASS);
			//echo $x_password;exit;
			//check if account is verified
			$accVer		= $result['acc_verified'];
			
			if($accVer == 'Y')
			{
				if($password == $x_password)
				{
					
					$_SESSION[USR_SESS] = $login;
					
					$_SESSION['name']   					= $result['fname']." ".$result['lname'];
					$_SESSION['welcome_name']   			= $result['fname'];
					$_SESSION['userid'] 					= $result['customer_id'];
					$_SESSION['usertypeid'] 				= $result['designation'];
					
					//update customer info
					$update = "UPDATE 	customer_info 
							   SET 		last_logon = now(), no_logon = no_logon + 1 
							   WHERE 	customer_id = '".$_SESSION['userid']."'";
					
					//execute query	   
					mysql_query($update);
					
					$session_id	= session_id();
					
					//determine where to forward user after login
					if(isset($_SESSION['goto']))
					{
						 $goto	= $_SESSION['goto'];
						 $url 	= $goto.".php";
						 
						 //remove session go to
						 $this->delSession('goto');
						 
						 header("Location: ".$url);
					}
					else
					{
					//exit(header("Location: /employee_account.php"));
						header("Location: employee_account.php");
					}
				}
				else
				{
					header("Location: "."login.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
				}
			}
			else
			{
				//account verified
				header("Location: "."login.php"."?action=login&msg=Your account is waiting for verification&typeM=ERROR");
			}
			
		}
		else
		{
			//no user
			header("Location: "."login.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
		}
		
	}//eof
	
	/* ---------------------------------Login for store Manager--------------------------------------*/

	function validate1($login, $password, $bdLogin, $dbPass, $table)
	{
		
		$select     = "SELECT * FROM ".$table." WHERE ".$bdLogin." = '$login'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		
		//echo $select." ".mysql_num_rows($query);echo $select ;echo "DB Pass = ".$x_password.", Encrypted pass = ".$dbpass;exit;
		//echo $select.mysql_error();exit;
		
		if(mysql_num_rows($query) > 0)
		{
			//get the password
			$dbpass	    = $result[$dbPass];
			$x_password = md5_decrypt($dbpass,USER_PASS);
			//echo $x_password;exit;
			//check if account is verified
			$accVer		= $result['acc_verified'];
			
			if($accVer == 'Y')
			{
				if($password == $x_password)
				{
					
					$_SESSION[USR_SESS] = $login;
					
					$_SESSION['name']   					= $result['fname']." ".$result['lname'];
					$_SESSION['welcome_name']   			= $result['fname'];
					$_SESSION['userid'] 					= $result['customer_id'];
					$_SESSION['usertypeid'] 				= $result['designation'];
					
					//update customer info
					$update = "UPDATE 	customer_info 
							   SET 		last_logon = now(), no_logon = no_logon + 1 
							   WHERE 	customer_id = '".$_SESSION['userid']."'";
					
					//execute query	   
					mysql_query($update);
					
					$session_id	= session_id();
					
					//determine where to forward user after login
					if(isset($_SESSION['goto']))
					{
						 $goto	= $_SESSION['goto'];
						 $url 	= $goto.".php";
						 
						 //remove session go to
						 $this->delSession('goto');
						 
						 header("Location: ".$url);
					}
					else
					{
						header("Location: store_manager.php");
					}
				}
				else
				{
					header("Location: "."login.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
				}
			}
			else
			{
				//account verified
				header("Location: "."login.php"."?action=login&msg=Your account is waiting for verification&typeM=ERROR");
			}
			
		}
		else
		{
			//no user
			header("Location: "."login.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
		}
		
	}//eof
	
	
	
	/* ---------------------------------Login for Rozelle --------------------------------------*/

	function validateRozelle($login, $password, $bdLogin, $dbPass, $table)
	{
		
		$select     = "SELECT * FROM ".$table." WHERE ".$bdLogin." = '$login'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		
		//echo $select." ".mysql_num_rows($query);echo $select ;echo "DB Pass = ".$x_password.", Encrypted pass = ".$dbpass;exit;
		//echo $select.mysql_error();exit;
		
		if(mysql_num_rows($query) > 0)
		{
			//get the password
			$dbpass	    = $result[$dbPass];
			$x_password = md5_decrypt($dbpass,USER_PASS);
			//echo $x_password;exit;
			//check if account is verified
			$accVer		= $result['acc_verified'];
			
			if($accVer == 'Y')
			{
				if($password == $x_password)
				{
					
					$_SESSION[USR_SESS] = $login;
					
					$_SESSION['name']   					= $result['fname']." ".$result['lname'];
					$_SESSION['welcome_name']   			= $result['fname'];
					$_SESSION['userid'] 					= $result['customer_id'];
					$_SESSION['usertypeid'] 				= $result['designation'];
					
					//update customer info
					$update = "UPDATE 	customer_info 
							   SET 		last_logon = now(), no_logon = no_logon + 1 
							   WHERE 	customer_id = '".$_SESSION['userid']."'";
					
					//execute query	   
					mysql_query($update);
					
					$session_id	= session_id();
					
					//determine where to forward user after login
					if(isset($_SESSION['goto']))
					{
						 $goto	= $_SESSION['goto'];
						 $url 	= $goto.".php";
						 
						 //remove session go to
						 $this->delSession('goto');
						 
						 header("Location: ".$url);
					}
					else
					{
						header("Location: employee_account.php");
					}
				}
				else
				{
					header("Location: "."login.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
				}
			}
			else
			{
				//account verified
				header("Location: "."login.php"."?action=login&msg=Your account is waiting for verification&typeM=ERROR");
			}
			
		}
		else
		{
			//no user
			header("Location: "."login.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
		}
		
	}//eof
	
	
	
	/* --------------------------------- --------------------------------------------------------
	*
	*								Login for MepDoc
	*
	*----------------------------------------------------------------------------------------------*/
	function validateMepDoc($login, $password, $bdLogin, $dbPass, $table)
	{
		
		$select     = "SELECT * FROM ".$table." WHERE ".$bdLogin." = '$login'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		
		//echo $select." ".mysql_num_rows($query);echo $select ;echo "DB Pass = ".$x_password.", Encrypted pass = ".$dbpass;exit;
		//echo $select.mysql_error();exit;
		
		if(mysql_num_rows($query) > 0)
		{
			//get the password
			$dbpass	    = $result[$dbPass];
			$x_password = md5_decrypt($dbpass,USER_PASS);
			//echo $x_password;exit;
			//check if account is verified
			$accVer		= $result['acc_verified'];
			
			if($accVer == 'Y')
			{
				if($password == $x_password)
				{
					
					$_SESSION[USR_SESS] = $login;
					
					$_SESSION['name']   					= $result['fname']." ".$result['lname'];
					$_SESSION['welcome_name']   			= $result['fname'];
					$_SESSION['userid'] 					= $result['customer_id'];
					$_SESSION['usertypeid'] 				= $result['designation'];
					//update customer info
					$update = "UPDATE 	customer_info 
							   SET 		last_logon = now(), no_logon = no_logon + 1 
							   WHERE 	customer_id = '".$_SESSION['userid']."'";
					
					//execute query	   
					mysql_query($update);
					
					$session_id	= session_id();
					
					//determine where to forward user after login
					if(isset($_SESSION['goto']))
					{
						 $goto	= $_SESSION['goto'];
						 $url 	= $goto.".php";
						 
						 //remove session go to
						 $this->delSession('goto');
						 
						 header("Location: ".$url);
					}
					else
					{
						header("Location: mepdoc.php");
					}
				}
				else
				{
					header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
				}
			}
			else
			{
				//account verified
				header("Location: "."index.php"."?action=login&msg=Your account is waiting for verification&typeM=ERROR");
			}
			
		}
		else
		{
			//no user
			header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
		}
		
	}//eof
	
	/* ---------------------------------Login for HMDA Dyeing Purchase --------------------------------------*/
	function validateHmdadPurch($login, $password, $bdLogin, $dbPass, $table)
	{
		
		$select     = "SELECT * FROM ".$table." WHERE ".$bdLogin." = '$login'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		
		//echo $select." ".mysql_num_rows($query);echo $select ;echo "DB Pass = ".$x_password.", Encrypted pass = ".$dbpass;exit;
		//echo $select.mysql_error();exit;
		
		if(mysql_num_rows($query) > 0)
		{
			//get the password
			$dbpass	    = $result[$dbPass];
			$x_password = md5_decrypt($dbpass,USER_PASS);
			//echo $x_password;exit;
			//check if account is verified
			$accVer		= $result['acc_verified'];
			
			if($accVer == 'Y')
			{
				if($password == $x_password)
				{
					
					$_SESSION[USR_SESS] = $login;
					
					$_SESSION['name']   					= $result['fname']." ".$result['lname'];
					$_SESSION['welcome_name']   			= $result['fname'];
					$_SESSION['userid'] 					= $result['customer_id'];
					$_SESSION['usertypeid'] 				= $result['designation'];
					//update customer info
					$update = "UPDATE 	customer_info 
							   SET 		last_logon = now(), no_logon = no_logon + 1 
							   WHERE 	customer_id = '".$_SESSION['userid']."'";
					
					//execute query	   
					mysql_query($update);
					
					$session_id	= session_id();
					
					//determine where to forward user after login
					if(isset($_SESSION['goto']))
					{
						 $goto	= $_SESSION['goto'];
						 $url 	= $goto.".php";
						 
						 //remove session go to
						 $this->delSession('goto');
						 
						 header("Location: ".$url);
					}
					else
					{
						header("Location: purchase.php");
					}
				}
				else
				{
					header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
				}
			}
			else
			{
				//account verified
				header("Location: "."index.php"."?action=login&msg=Your account is waiting for verification&typeM=ERROR");
			}
			
		}
		else
		{
			//no user
			header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
		}
		
	}//eof
	
	
	
	/* --------------------------------- --------------------------------------------------------
	*
	*								Login for RoZelle production
	*
	*----------------------------------------------------------------------------------------------*/
	function validateRozProduction($login, $password, $bdLogin, $dbPass, $table)
	{
		$select     = "SELECT * FROM ".$table." WHERE ".$bdLogin." = '$login'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		//echo $select." ".mysql_num_rows($query);echo $select ;echo "DB Pass = ".$x_password.", Encrypted pass = ".$dbpass;exit;
		//echo $select.mysql_error();exit;
		
		if(mysql_num_rows($query) > 0)
		{
			//get the password
			$dbpass	    = $result[$dbPass];
			$x_password = md5_decrypt($dbpass,USER_PASS);
			//echo $x_password;exit;
			//check if account is verified
			$accVer		= $result['acc_verified'];
			
			if($accVer == 'Y')
			{
				if($password == $x_password)
				{
					
					$_SESSION[USR_SESS] = $login;
					
					$_SESSION['name']   					= $result['fname']." ".$result['lname'];
					$_SESSION['welcome_name']   			= $result['fname'];
					$_SESSION['userid'] 					= $result['customer_id'];
					$_SESSION['usertypeid'] 				= $result['designation'];
					
					$iCookieTime = time() + 24*60*60*30;
					setcookie("member_name", $login, $iCookieTime, '/');
					$_COOKIE['member_name'] = $login;
					setcookie("member_pass", $password, $iCookieTime, '/');
					$_COOKIE['member_pass'] = $password;
					//update customer info
					$update = "UPDATE 	customer_info 
							   SET 		last_logon = now(), no_logon = no_logon + 1 
							   WHERE 	customer_id = '".$_SESSION['userid']."'";
					
					//execute query	   
					mysql_query($update);
					
					$session_id	= session_id();
					
					//determine where to forward user after login
					if(isset($_SESSION['goto']))
					{
						 $goto	= $_SESSION['goto'];
						 $url 	= $goto.".php";
						 
						 //remove session go to
						 $this->delSession('goto');
						 
						 header("Location: ".$url);
					}
					else
					{
						header("Location: collection.php");
					}
				}
				else
				{
					header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
				}
			}
			else
			{
				//account verified
				header("Location: "."index.php"."?action=login&msg=Your account is waiting for verification&typeM=ERROR");
			}
			
		}
		else
		{
			//no user
			header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
		}
		
	}//eof
	
	
	/* --------------------------------- --------------------------------------------------------
	*
	*								Login for Stock dept.
	*
	*----------------------------------------------------------------------------------------------*/
	function validateStock($login, $password, $bdLogin, $dbPass, $table)
	{
		
		$select     = "SELECT * FROM ".$table." WHERE ".$bdLogin." = '$login'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		
		//echo $select." ".mysql_num_rows($query);echo $select ;echo "DB Pass = ".$x_password.", Encrypted pass = ".$dbpass;exit;
		//echo $select.mysql_error();exit;
		
		if(mysql_num_rows($query) > 0)
		{
			//get the password
			$dbpass	    = $result[$dbPass];
			$x_password = md5_decrypt($dbpass,USER_PASS);
			//echo $x_password;exit;
			//check if account is verified
			$accVer		= $result['acc_verified'];
			
			if($accVer == 'Y')
			{
				if($password == $x_password)
				{
					
					$_SESSION[USR_SESS] = $login;
					
					$_SESSION['name']   					= $result['fname']." ".$result['lname'];
					$_SESSION['welcome_name']   			= $result['fname'];
					$_SESSION['userid'] 					= $result['customer_id'];
					$_SESSION['usertypeid'] 				= $result['designation'];
					//update customer info
					$update = "UPDATE 	customer_info 
							   SET 		last_logon = now(), no_logon = no_logon + 1 
							   WHERE 	customer_id = '".$_SESSION['userid']."'";
					
					//execute query	   
					mysql_query($update);
					
					$session_id	= session_id();
					
					//determine where to forward user after login
					if(isset($_SESSION['goto']))
					{
						 $goto	= $_SESSION['goto'];
						 $url 	= $goto.".php";
						 
						 //remove session go to
						 $this->delSession('goto');
						 
						 header("Location: ".$url);
					}
					else
					{
						header("Location: stock.php");
					}
				}
				else
				{
					header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
				}
			}
			else
			{
				//account verified
				header("Location: "."index.php"."?action=login&msg=Your account is waiting for verification&typeM=ERROR");
			}
			
		}
		else
		{
			//no user
			header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
		}
		
	}//eof
	
	/* --------------------------------- --------------------------------------------------------
	*
	*								Login for Account Dept.
	*
	*----------------------------------------------------------------------------------------------*/
	function validateAccount($login, $password, $bdLogin, $dbPass, $table)
	{
		
		$select     = "SELECT * FROM ".$table." WHERE ".$bdLogin." = '$login'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		
		//echo $select." ".mysql_num_rows($query);echo $select ;echo "DB Pass = ".$x_password.", Encrypted pass = ".$dbpass;exit;
		//echo $select.mysql_error();exit;
		
		if(mysql_num_rows($query) > 0)
		{
			//get the password
			$dbpass	    = $result[$dbPass];
			$x_password = md5_decrypt($dbpass,USER_PASS);
			//echo $x_password;exit;
			//check if account is verified
			$accVer		= $result['acc_verified'];
			
			if($accVer == 'Y')
			{
				if($password == $x_password)
				{
					
					$_SESSION[ACC_SESS] = $login;
					
					$_SESSION['name']   					= $result['fname']." ".$result['lname'];
					$_SESSION['welcome_name']   			= $result['fname'];
					$_SESSION['userid'] 					= $result['customer_id'];
					$_SESSION['usertypeid'] 				= $result['designation'];
					//update customer info
					$update = "UPDATE 	customer_info 
							   SET 		last_logon = now(), no_logon = no_logon + 1 
							   WHERE 	customer_id = '".$_SESSION['userid']."'";
					
					//execute query	   
					mysql_query($update);
					
					$session_id	= session_id();
					
					//determine where to forward user after login
					if(isset($_SESSION['goto']))
					{
						 $goto	= $_SESSION['goto'];
						 $url 	= $goto.".php";
						 
						 //remove session go to
						 $this->delSession('goto');
						 
						 header("Location: ".$url);
					}
					else
					{
						header("Location: dashboard.php");
					}
				}
				else
				{
					header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
				}
			}
			else
			{
				//account verified
				header("Location: "."index.php"."?action=login&msg=Your account is waiting for verification&typeM=ERROR");
			}
			
		}
		else
		{
			//no user
			header("Location: "."index.php"."?action=login&msg=Invalid username or password&typeM=ERROR");
		}
		
	}//eof
	
}//eoc

?>
	
	
