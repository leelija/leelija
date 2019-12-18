<?php 
/**
*	This utility class works with the roles, authorization and authentication of users or
*	applications.
*
*	UPDATE September 24, 2010
*	The method named checkSimplePageAccess() has been added to check page access based on 
*	session variables only.
*
*
*	@author		Himadri Shekhar Roy
*	@date		November 02, 2008
*	@version	1.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/

include_once("utility.class.php");

class AuthUtility extends Utility
{
	/**
	*	Check whether an user can perform a certain work or not.
	*
	*	@param
	*			$sessVar	Session variable to verify
	*			$column		Column name
	*			$table		Table name
	*			$pageName	Name of the page to forward
	*
	*	@return array
	*/
	function checkUserInRole($sessVar, $column, $table, $pageName)
	{
		//get all ids
		$uIds	= $this->getAllId($column, $table);
		
		//check session and forward
		if( !isset($_SESSION[$sessVar]) || (!in_array($_SESSION[$sessVar], $uIds)) )
		{
			header("Location: ". $pageName);
		}
		
	}//eof
	
	/**
	*	Check if any user has access to particular data
	*	
	*	@param
	*			$id				Identity/value of the object
	*			$column_id		Column name, which contain the object
	*			$is_user		Determine whether the value has to check directly or needs to 
	*							check it's association as well, with another value. It can 
	*							either YES or NO.
	*			$userid			Value of the associated id
	*			$user_column	Name of the associated key
	*			$table			Table name	
	*/
	function checkAccess($id, $column_id , $is_user , $userid, $user_column, $table)
	{
		$msg	= '';
		
		//get the message
		$msg = $this->noItemFound($id,$column_id,$is_user,$userid,$user_column,$table);
		
		if($msg == 'NOT_FOUND')
		{
			header("Location: error-401.php");
		}
		
	}//eof
	
	
	/**
	*	Update the date time, whenever the customer access is updated.
	*
	*	@param
	*			$keyName			Name of the primary key column
	*			$keyVal				Value of the primary key, that has to update
	*			$table				Name of the table
	*
	*	@return	string
	*/
	function updateAccessTime($keyName, $keyVal, $table)
	{
		//declare var
		$result	= '';
		
		//statement
		$sql	= "UPDATE ".$table." SET
				  modified_on 	= now()
				  WHERE 
				  ".$keyName."  = '".$keyVal."'
				  ";
				  
		//execute query
		$query	= mysql_query($sql);
		
		//get the result upon executing query
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
	*	User will be forwarded to certain page if the session exists or do not exists 
	*	depending upon the conditions. Like to escape visiting last page or advance page
	*	without going through proper process.
	*
	*	@param
	*			$typeCheck		Check whether session exists or do not exists. It is a 
	*							constant with two values, either YES or NO
	*			$sessName		Name of the session variable
	*			$sessVal		Value of the session variable
	*			$pageName		Name of the page to forward
	*
	*	@return null
	*/
	function  checkPageAccess($typeCheck, $sessName, $sessVal, $pageName)
	{
		if($typeCheck == 'Y')
		{
			if( (isset($_SESSION[$sessName])) || ($_SESSION[$sessName] == $sessVal) )
			{
				header("Location: ".$pageName);
			}
		}
		else
		{
			if( (!isset($_SESSION[$sessName])) || ($_SESSION[$sessName] != $sessVal) )
			{
				header("Location: ".$pageName);
			}
		}
		
	}//eof
	
	
	
	/**
	*	User will be forwarded to certain page if the session exists or do not exists 
	*	depending upon the conditions. This a simpler method than the ealier version.
	*
	*	@date	September 24, 2010
	*
	*	@param
	*			$typeCheck		Check whether session exists or do not exists. It is a 
	*							constant with two values, either YES or NO
	*			$sessName		Name of the session variable
	*			$pageName		Name of the page to forward
	*
	*	@return null
	*/
	function  checkSimplePageAccess($typeCheck, $sessName, $pageName)
	{
		if($typeCheck == 'Y')
		{
			if(isset($_SESSION[$sessName]))
			{
				header("Location: ".$pageName);
			}
		}
		else
		{
			if(!isset($_SESSION[$sessName]))
			{
				header("Location: ".$pageName);
			}
		}
		
	}//eof
	
	
	
	/**
	*	User will be forwarded to a predefined page, if there is any mismatch between the key value passed as variable
	*	and the key value in the database. Also it would check if that variable exists or not. It would check for variable 
	*	passed to another page either by GET, POST or SESSION.
	*
	*	@date	June 06, 2010
	*
	*	@param
	*			$varType		Variable type, defined as constant, e.g. SESSION, GET or POST
	*			$varName		Name of the variable
	*			$keyArrVal		Check the existance of the variable value within the array of keys 
	*			$pageName		Name of the page to forward
	*
	*	@return null
	*	
	*/
	function checkPageAccessByVar($varType, $varName, $keyArrVal, $pageName)
	{
		
		switch ($varType)
		{
			case 'GET':
				if(!isset($_GET[$varName]))
				{
					header("Location: ".$pageName);
				}
				else if( (isset($_GET[$varName])) && (!in_array($_GET[$varName], $keyArrVal)) )
				{
					header("Location: ".$pageName);
				}
				break;
			case 'POST':
				if(!isset($_POST[$varName]))
				{
					header("Location: ".$pageName);
				}
				else if( (isset($_POST[$varName])) && (!in_array($_POST[$varName], $keyArrVal)) )
				{
					header("Location: ".$pageName);
				}
				break;
			case 'SESSION':
				if(!isset($_SESSION[$varName]))
				{
					header("Location: ".$pageName);
				}
				else if( (isset($_SESSION[$varName])) && (!in_array($_SESSION[$varName], $keyArrVal)) )
				{
					header("Location: ".$pageName);
				}
				break;
			default:
				break;
		}//switch
		
	}//eof
	
}//eoc
?>