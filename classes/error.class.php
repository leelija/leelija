<?php 
/**
*	This is a generic error handling class, offer seamless integration with many other application
*	wherever required. 	
*
*	UPDATE March 30, 2011
*	Added function that will check whether http is being present in a url or not.
*
*
*	@author		Himadri Shekhar Roy
*	@date		November 26, 2006
*	@update		August 16, 2008
*	@version	2.0
*	@copyright	Analyze System Software Pvt. Ltd.
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/
include_once("utility.class.php");

class Error extends	Utility
{

	##########################################################################################
	#
	#								Verifying fields
	#
	##########################################################################################

	/**
	*	This function will print the error message
	*	
	*	@param
	*			$id 	Message Id
	*/
	function printError($id)
	{
		return stripslashes($id);
	}//eof
	
	/**
	*	This function will check whether the username is already in use or not
	*
	*	@param
	*			$id 			User name or id
	*			$fieldName		Column Name
	*			$tableName 		Table to make query
	*
	*	@return string
	*/
	function duplicateUser($id, $fieldName, $tableName)
	{
		
		$select = "SELECT * FROM ".$tableName." WHERE  ".$fieldName." = '$id'";
		$query  = mysql_query($select);
		
	
		$num    = mysql_num_rows($query);
		
		
		$msg = '';
		if($num > 0 )
		{
			$msg = 'ER001';
		}
	
		//return
		return $msg;
	}//eof
	
	
	/**
	*	This function will check whether the phone number is already in use or not
	*
	*	@param
	*			$id 			User name or id
	*			$fieldName		Column Name
	*			$tableName 		Table to make query
	*
	*	@return string
	*/
	function duplicatePhoneNo($id, $fieldName, $tableName)
	{
		
		$select = "SELECT * FROM ".$tableName." WHERE  ".$fieldName." = '$id'";
		$query  = mysql_query($select);
		//echo $select.mysql_error();
	
		$num    = mysql_num_rows($query);
		
		
		$msg = '';
		if($num > 0 )
		{
			$msg = 'ER001';
		}
	
		//return
		return $msg;
	}//eof
	
	/**
	*	This function will check the valid email ids
	*
	*	@param
	*			$email 	   User email
	*
	*	@return string	
	*/
	function invalidEmail($email)
	{
		$msg	= '';
		
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i", $email))
		{
			$msg = "ER002";
		}
		else
		{
			$msg = "SU";
		}
		
		return $msg;
	}//eof
	
	/**
	*	This function will check the validity of the username
	*	
	*	@param
	*			$user	User name
	*	
	*	@return string
	*/
	function checkUsername($user)
	{
		//declare var
		$user	= trim($user);
		$msg	= '';
		
		if(!preg_match('/^[A-Za-z0-9_]*$/',$user))
		{
			$msg	= 'ERU102';
		}
		
		//return the value
		return $msg;
	}
	
	/**
	*	This function will check if a parent has same child name.
	*
	*	@param
	*			$parent_id 	  Parent id of a category
	*			$cat_name	  Name of teh category to be added
	*			$cat_id		  Category id is required when user wants to edit the category, 
	*					  	  put zero(0) if you wants to add a new category
	*			$table		  Table name of the category
	*
	*	@return string
	*/
	function duplicateCat($parent_id, $cat_name, $cat_id, $table)
	{
		if($cat_id == (int)0)
		{
			$select = "SELECT * FROM ".$table." WHERE  parent_id = '$parent_id' 
						AND categories_name = '$cat_name'";
		}
		else
		{
			$select = "SELECT * FROM  ".$table." 
					WHERE  parent_id 	= '$parent_id' 
					AND categories_name = '$cat_name'
					AND categories_id	<> '$cat_id'";
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
	
	
	function duplicateDefaultCat($parent_id, $cat_name, $cat_id, $table)
	{
		if($cat_id == (int)0)
		{
			$select = "SELECT * FROM ".$table." WHERE  parent_id = '$parent_id' 
						AND default_title = '$cat_name'";
		}
		else
		{
			$select = "SELECT * FROM  ".$table." 
					WHERE  parent_id 	= '$parent_id' 
					AND default_title = '$cat_name'
					AND default_categories_id	<> '$cat_id'";
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
	
	/**
	*	This function will check if the category is root or not before deletion.
	*
	*	@param
	*			$cat_id		Category id
	*
	*	@return string
	*/
	function checkRoot($cat_id)
	{
		$select = "SELECT parent_id FROM categories WHERE categories_id='$cat_id'";
		$query  = mysql_query($select);
		$result = mysql_fetch_array($query);
		$parent_id = (int)$result['parent_id'];
		$msg = '';
		if($parent_id == 0)
		{
			$msg = 'ER005';
		}
		return $msg;
	}//eof
	
	/**
	*	This function will check if the category has any products, content or item
	*
	*	@param
	*			$cat_id		Category id
	*
	*	@return string
	*/
	function checkCatAds($cat_id, $table)
	{
		$select = "SELECT * FROM ".$table." WHERE categories_id='$cat_id'";
		$query  = mysql_query($select);
		
		$num    = mysql_num_rows($query);
		
		$msg = '';
		if($num > 0)
		{
			$msg = 'ER006';
		}
		return $msg;
	}//eof

	/**
	*	Check if a category has any subcategory or not
	*
	*	@param
	*			$id		Category id
	*			$table	Categories table name
	*
	*	@return string
	*/
	function checkChild($id, $table)
	{
		$select = "SELECT * FROM ".$table." WHERE parent_id='$id'";
		$query  = mysql_query($select);
		$num    = mysql_num_rows($query);
		$msg = '';
		if($num > 0)
		{
			$msg = 'ER007';
		}
		return $msg;
	}//eof
	
	
	/*
	this function will check whether this is the category has product or not
	variable:
	catid		= category id
	*/
	function checkCatProduct($cat_id)
	{
		$select = "SELECT * FROM products_to_categories WHERE categories_id='$cat_id'";
		$query  = mysql_query($select);
		$num    = mysql_num_rows($query);
		
		$msg = '';
		if($num > 0)
		{
			$msg = 'ER006';
		}
		return $msg;
	}//end of check cat product
	
	
	
	/**
	*	This will check the price entered by the user is valid or not
	*
	*	@param
	*			$price		Price entered by the user
	*
	*	@return string
	*/
	function checkPrice($price)
	{
		if(!preg_match('/^0|[1-9][0-9]*|[1-9][0-9]*[.][0-9]{1,2}$/',$price))
		{
			return 'ER008';
		}
		
	}//eof
	
	/**
	*	This function will check the value entered by the user contain only numeric values or not	
	*	
	*	@param
	*			$value		Value entered by the user
	*
	*	@return string
	*/
	function checkInt($value)
	{
		 if(!preg_match('/^0*|[1-9][0-9]*$/',$value))
		{
			return 'ER009';
		}
	}//eof
	
	/**
	*	This function will check the value entered by the user contain only numeric values or not	
	*	
	*	@param
	*			$value		Value entered by the user
	*
	*	@return string
	*/
	function checkNumeric($value)
	{
		//declare var
		$resStr	= '';
		
		if(!preg_match('/^0*|[1-9][0-9]*$/',$value))
		{
			$resStr	= 'ER009';
		}
		else
		{
			$resStr	=  'SU001';
		}
		
		//return result
		return $resStr;
		
	}//eof
	
	/**
	*	This function will check if a field is empty 
	*
	*	@param
	*			$field		Name of the field
	*			$label		Label of the field
	*
	*/
	 function checkEmpty($field, $label)
	 {
	 	if($field == '')
		{
			return  ER010;
		}
	 }//eof
	 
	 /**
	 *	Check the birth date. This function is usable while restricting age limit for certain
	 *	website. Currently we are checking for 5 years.
	 *
	 *	@param
	 *			$bday	 	Birthday entered by the user
	 *
	 *	@return string
	 */
	 function checkBday($bday)
	 {
	 	$day1   = (int)substr($bday,8,2);
		$month1 = (int)substr($bday,6,2);
		$year1  = (int)substr($bday,0,4);
		
		$bday_string = mktime(0,0,0,$month1,$day1,$year1);
		
		
	 	$today	= date("Y-m-d");
		$day2   = (int)substr($today,8,2);
		$month2 = (int)substr($today,6,2);
		$year2  = (int)substr($today,0,4);
		
		$today_string = mktime(0,0,0,$month2,$day2,$year2);
		$diff_year	= $year2 - $year1 ;
		if($diff_year < 5)
		{
			return 'ER011';
		}
	 }//eof
	
	/**
	*	Duplicate child check
	*/
	function duplicateChild($parent_id, $parent_column, $cat_id, $cat_column, $table)
	{
		
		$select = 	"SELECT * FROM ".$table."
					WHERE  ".$parent_column." 	= '$parent_id' 
					AND    ".$cat_column." 		= '$cat_id'
					";
		
		$query  = mysql_query($select);
		$num    = mysql_num_rows($query);
		$msg = '';
		if($num > 0 )
		{
			$msg = 'ER004';
		}
		return $msg;
	}//end of function
	
	/**
	*	Duplicate category
	*/
	function checkSingleCat($cat_name, $cat_column, $table)
	{
		
		$select = 	"SELECT * FROM ".$table."
					WHERE  ".$cat_column." 	= '$cat_name' 
					";
		
		$query  = mysql_query($select);
		$num    = mysql_num_rows($query);
		$msg = '';
		if($num > 0 )
		{
			$msg = 'ER201';
		}
		return $msg;
	}//end of function
	
	/**
	*	This function will check if there is any duplicate entry in the table or not
	*
	*	@param
	*			$id 	  	Unique identity or field value associated with the table
	*			$id_column  Column name to check the entry
	*			$table		Name of the table to check duplicate entry
	*
	*	@return string
	*/
	/*function duplicateEntry($id, $id_column, $table, $edit, $key_id, $key_column)
	{
		//declare var
		$msg = '';
		
		//check the conditions and set the conditional statement
		if($edit == 'NO')
		{
			$select = "SELECT * FROM ".$table." WHERE  ".$id_column." = '$id'";
		}
		elseif($edit == 'YES')
		{
			$select = "SELECT * FROM ".$table." WHERE  ".$id_column." = '$id' 
					   AND ".$key_column."	<> '$key_id'";
		}
		
		//execute query
		$query  = mysql_query($select);
		
		//echo $select; exit;
		//get number of rows
		$num    = mysql_num_rows($query);
		
		//set the message string to error if it already exists
		if($num > 0 )
		{
			$msg = 'ER020';
		}
		
		//return the message
		return $msg;
		
	}//eof*/
	
	
	/**	
	*	This function will check if there is any duplicate entry in the table or not based 
	*	on one more factor
	*
	*	@param
	*			$id 	  	Unique identity or field value associated with the table
	*			$id_column  Column name to check the entry
	*			$table		Name of the table to check duplicate entry
	*
	*	@return string
	*/
	function duplicateEntry2($id, $id_column, $table, $key_id, $key_column)
	{
		$select = "SELECT * FROM ".$table." WHERE  ".$id_column." = '$id' 
				   AND ".$key_column."	= '$key_id'";

		
		$query  = mysql_query($select);
		$num    = mysql_num_rows($query);
		$msg = '';
		if($num > 0 )
		{
			$msg = 'ER020';
		}
		return $msg;
	}//eof
	
	
	/**
	*	Check status
	*
	*	@param	
	*			$stat_col  	Status column name
	*			$key_id	  	Unique identity or field value associated with the table
	*			$key_col    Primary key column name
	*			$table		Name of the table
	*
	*	@return char
	*/
	function checkStatus($stat_col, $key_id, $key_col, $table)
	{
		$select = "SELECT ".$stat_col." FROM ".$table." WHERE  ".$key_col." = ".$key_id."";
		$query  = mysql_query($select);
		$num    = mysql_num_rows($query);
		
		$data 	= '';
		if($num > 0 )
		{
			$result	= mysql_fetch_array($query);
			$data	= $result[$stat_col];
		}
		return $data;
	}//eof
	
		/**
	*	Check Australia Postal Number
	*/
	function checkAusPIN($value)
	{
		$msg	= '';
		if(strlen($value) != 4)
		{
			$msg	= "<span class='orangeLetter'>".ER401."</span>";
		}
		else
		{
			if(!preg_match('/^[0-9]*$/',$value))
			{
				$msg	= "<span class='orangeLetter'>".ER402."</span>";
			}
			else
			{
				$msg	= "<span class='greenLetter'>".SU."</span>";
			}
		}
		
		//return the values
		return $msg;
	}//eof
	
	/**
	*	Check Australia Postal Number
	*/
	function checkAusPIN2($value)
	{
		$msg	= '';
		if(strlen($value) != 4)
		{
			$msg	= "ER401";
		}
		else
		{
			if(!preg_match('/^[0-9]*$/',$value))
			{
				$msg	= "ER402";
			}
			else
			{
				$msg	= "SU";
			}
		}
		
		//return the values
		return $msg;
	}//eof
	
	
	/**
	*	Check URL if it has http in the begining. Usable for providing a link to the system
	*	
	*	@param
	*			$url		URL to check and display
	*
	*	@return string
	*/
	function checkHttpInURL($url)
	{
		//message
		$msg	= 'ER';
		
		if(!preg_match('/^http/i', $url))
		{
			$msg	= 'ER';
		}
		else
		{
			$msg	= 'SU';
		}
		
		//return the message
		return $msg;
		
	}//eof
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////
	//
	//								Show Message Part
	//
	///////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	/**
	*	This function will work as a part of the redirection, if any error occurs while 
	*	adding or editing any data.
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$id				The primary key if required
	*			$id_var			Variable name, associated with the id
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*
	*	@return NULL
	*/
	function showError($action, $id, $id_var, $url, $msg)
	{
		//echo "Location: ".$url."?action=".$action."&".$id_var."=".$id."&msg=".$msg; exit;
		
		if($id == 0)
		{
			header("Location: ".$url."?action=".$action."&msg=".$msg);
		}
		else
		{
			
			header("Location: ".$url."?action=".$action."&".$id_var."=".$id."&msg=".$msg);
		}
	}//eof
	
	/**
	*	This function will work as a part of the redirection, if any error occurs while 
	*	adding or editing any data. This is an advanced version of the previous function.
	*	In the end of the function name T stands for type, where type refers to ERROR or 
	*	NORMAL or SUCCESS.
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$id				The primary key if required
	*			$id_var			Variable name, associated with the id
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*			$typeM			Type of message
	*
	*	@return NULL
	*/
	function showErrorT($action, $id, $id_var, $url, $msg, $typeM)
	{
		//echo "Location: ".$url."?action=".$action."&".$id_var."=".$id."&msg=".$msg; exit;
		
		if($id == 0)
		{
			header("Location: ".$url."?action=".$action."&typeM=".$typeM."&msg=".$msg);
		}
		else
		{
			
			header("Location: ".$url."?action=".$action."&typeM=".$typeM."&".$id_var."=".$id."&msg=".$msg);
		}
	}//eof
	

	/**
	*	This function will work as a part of the redirection, if any error occurs while 
	*	adding or editing any data. This is an advanced version of the previous function.
	*	In the end of the function name T stands for type, where type refers to ERROR or 
	*	NORMAL or SUCCESS and A refers to anchor for internal linking.
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$id				The primary key if required
	*			$id_var			Variable name, associated with the id
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*			$typeM			Type of message
	*			$name			Anchor name to show
	*
	*	@return NULL
	*/
	function showErrorTA($action, $id, $id_var, $url, $msg, $typeM, $name)
	{
		//echo "Location: ".$url."?action=".$action."&".$id_var."=".$id."&msg=".$msg; exit;
		
		if($id == 0)
		{
			header("Location: ".$url."?action=".$action."&typeM=".$typeM."&msg=".$msg."#".$name);
			exit;
		}
		else
		{
			header("Location: ".$url."?action=".$action."&typeM=".$typeM."&".$id_var."=".$id."&msg=".$msg."#".$name);
			exit;
		}
	}//eof
	
	/**
	*	This function will work as a part of the redirection, if any error occurs while 
	*	adding or editing any data.
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$id				The primary key if required
	*			$id_var			Variable name, associated with the id
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*			$name			Anchor name to show
	*
	*	@return NULL
	*/
	function showError2($action, $id, $id_var, $url, $msg, $name)
	{
		
		if($id == 0)
		{
			header("Location: ".$url."?action=".$action."&msg=".$msg."#".$name);
		}
		else
		{
			
			header("Location: ".$url."?action=".$action."&".$id_var."=".$id."&msg=".$msg."#".$name);
		}
	}//eof
	
	/**
	*	Advanced version of showing error as compare to the other two functions
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$id				The primary key if required
	*			$id_var			Variable name, associated with the id
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*			$name			Anchor name to show
	*			$link			Other url variables to include if required
	*
	*	@return NULL
	*/
	function showError3($action, $id, $id_var, $url, $msg, $name, $link)
	{
		//echo "Location: ".$url."?action=".$action."&".$id_var."=".$id."&msg=".$msg; exit;
		
		if($id == 0)
		{
			header("Location: ".$url."?action=".$action."&".$link."&msg=".$msg."#".$name);
		}
		else
		{
			
			header("Location: ".$url."?action=".$action."&".$link."&".$id_var."=".$id."&msg=".$msg."#".$name);
		}
	}//eof
	
	
	
	/**
	*	This function will work as a part of the redirection. This function will use
	*	array of variables. This is a higher version of first release.
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$arr_id			Array of id
	*			$arr_var		Array of variables
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*
	*	@return NULL
	*/
	function showErrorArr($action, $arr_id, $arr_var, $url, $msg)
	{
		$str	= '';
		
		//creating the string
		foreach($arr_id as $k)
		{
			$str .= "&".$arr_var[$k]."=".$k;
		}
		
		header("Location: ".$url."?action=".$action.$str."&msg=".$msg);
		
	}//eof
	
	/**
	*	Advanced version of showing error as compare to the other functions. This function
	*	will accept all the URL variables
	*
	*	@param
	*			$url_var		URL variables to use
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*			$name			Anchor name to show
	*
	*	@return NULL
	*/
	function showErrorURL($url_var, $url, $msg, $name)
	{
		header("Location: ".$url."?".$url_var."&msg=".$msg."#".$name);
	}//eof
	

	
	/**
	*	This function will work as a part of the redirection. This function will use
	*	array of variables. This is a higher version of first release.
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$arr_id			Array of id
	*			$arr_var		Array of variables
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*			$typeM			Type of message
	*
	*	@return NULL
	*/
	function showErrorArrT($action, $arr_id, $arr_var, $url, $msg, $typeM)
	{
		$str	= '';
		
		//creating the string
		for($k=0; $k < count($arr_id); $k++)
		{
			
			$str .= "&".$arr_var[$k]."=".$arr_id[$k];
		}
		
		header("Location: ".$url."?action=".$action."&typeM=".$typeM.$str."&msg=".$msg);
		
	}//eof
	
	/**
	*	This function will work as a part of the redirection. This function will use
	*	array of variables. This also includes internal anchoring.
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$arr_id			Array of id
	*			$arr_var		Array of variables
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*			$linkName		Anchor name to show
	*			$typeM			Type of message
	*
	*	@return NULL
	*/
	function showErrorArrTL($action, $arr_id, $arr_var, $url, $msg, $typeM, $linkName)
	{
		$str	= '';
		
		//creating the string
		for($k=0; $k < count($arr_id); $k++)
		{
			
			$str .= "&".$arr_var[$k]."=".$arr_id[$k];
		}
		
		header("Location: ".$url."?action=".$action."&typeM=".$typeM.$str."&msg=".$msg."#".$linkName);
		
	}//eof
}
?>