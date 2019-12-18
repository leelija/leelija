<?php 
/**
*	This utility class handles number and array related functions, extends the properties of 
*	Utility class.
*
*	@author		Himadri Shekhar Roy
*	@date		May 30, 2008
*	@version	1.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/

include_once("utility.class.php");

class NumUtility extends Utility
{
	/**
	*	This function generate an array for most popular section.
	*
	*	@param
	*			$arr	Array to slice
	*			$num	Number of results wan to display
	*
	*	@return array
	*/
	function getTopMost($arr, $num)
	{
		$newArr	= array();
		
		if($num == 'ALL')
		{
			$newArr =	$arr;
		}
		else
		{
			$num	= (int)$num;
			if(count($arr) > $num)
			{
				$newArr	= array_slice($arr,0,$num);
			}
			else
			{
				$newArr =	$arr;
			}
			
		}
		
		//return
		return $newArr;
		
	}//eof
	
	/**
	*	Create id array
	*	
	*	@param
	*			$idArr		Array of Ids
	*			$prefix		Prefix to add before the array
	*
	*	@return array
	*/
	function createIdArr($idArr, $prefix)
	{
		$newArr	= array();
		
		if(count($idArr) > 0)
		{
			foreach($idArr as $p)
			{
				$newArr[] = $prefix.$p;
			}
		}
		
		//return the array
		return $newArr;
	}//eof
	
	/**
	*	Remove prefix from the array
	*	
	*	@param
	*			$idArr		Array of Ids
	*			$prefix		Prefix to add before the array
	*
	*	@return array
	*/
	function removeIdPrefix($idArr, $prefix)
	{
		$newArr	= array();
		$newEl	= '';
		$pefLen = strlen($prefix);
		
		if(count($idArr) > 0)
		{
			foreach($idArr as $p)
			{
				$newEl	  = substr($p, $pefLen);
				$newArr[] = $newEl;
			}
		}
		
		//return the array
		return $newArr;
	}//eof
	
	///////////////////////////////////////////////////////////////////////////////////
	//
	//							Primary Key + Foreign Key
	//
	///////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Get all ids based on foreign key
	*
	*	@param
	*			$fk1		Foreign key - 1
	*			$pkCol		Primary key column name
	*			$fk1Col		Foreign key column name 
	*			$table		Table name
	*/
	function getPrimByFk($fk1, $pkCol, $fk1Col, $table)
	{
		//intialize variable
		$pkIds	= array();
		
		//statement
		$sql	= "SELECT ".$pkCol." FROM ".$table. 
				  " WHERE ".$fk1Col."='".$fk1."' ";
				    
		
		$query	= mysql_query($sql);
		
		if(mysql_num_rows($query) > 0)
		{	
			while($result = mysql_fetch_object($query))
			{
				$pkIds[]	= $result->$pkCol;
			}
		}
		
		//return
		return $pkIds;
		
	}//eof
	
	/**
	*	Get all ids based on two foreign key
	*
	*	@param
	*			$fk1		Foreign key - 1
	*			$fk2		Foreign key - 2
	*			$pkCol		Primary key column name
	*			$fk1Col		Foreign key column name
	*			$fk2Col		Foreign key column name 
	*			$table		Table name
	*/
	function getPrimKey($fk1, $fk2, $pkCol, $fk1Col, $fk2Col, $table)
	{
		//intialize variable
		$pkId	= 0;
		
		//statement
		$sql	= "SELECT ".$pkCol." FROM ".$table. 
				  " WHERE ".$fk1Col."='".$fk1."' 
				    AND ".$fk2Col."='".$fk2."'";
		
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query) > 0)
		{	
			while($result = mysql_fetch_object($query))
			{
				$pkId	= $result->$pkCol;
			}
		}
		
		//return
		return $pkId;
		
	}//eof
	
	
	
	/**
	*	Get all ids based on two foreign key. This is an advanced version where
	*	one of the key is an array.
	*
	*	@param
	*			$fk1		Foreign key - 1
	*			$fk2Arr		Array of Foreign key - 2
	*			$pkCol		Primary key column name
	*			$fk1Col		Foreign key column name
	*			$fk2Col		Foreign key column name 
	*			$table		Table name
	*/
	function getPrimKeyArr($fk1, $fk2Arr, $pkCol, $fk1Col, $fk2Col, $table)
	{
		//intialize variable
		$pkIds	= array();
		
		foreach($fk2Arr as $k)
		{
			$pkIds[] = $this->getPrimKey($fk1, $k, $pkCol, $fk1Col, $fk2Col, $table);
		}
		
		//return
		return $pkIds;
		
	}//eof
	
	/**
	*	Get last id of an array
	*
	*	@param		
	*			$arrIds			Input array
	*
	*	@retun int		
	*/
	function getLastIdofArr($arrIds)
	{
		//declare var
		$lastId	= 0;
		
		if(count($arrIds) > 0)
		{
			//reverse the array
			$revArr	= array_reverse($arrIds);
			
			$lastId	= $revArr[0];
		}
		
		//return the value
		return $lastId;
		
	}//eof
	
	
	/**
	*	This function will only update any number. Usable for vote count, like the number
	*	of green.
	*	
	*
	*	@param
	*			$keyVal			Value of the key to update
	*			$keyCol			Name of the primary key column
	*			$updCol       	Name of the column to update
	*			$numVal			The updated number to set
	*			$table			Name of the table to update
	*
	*	@return int
	*/
	function updateNum($keyVal, $keyCol, $updCol, $numVal, $table)
	{
		//statement
		$sql	=  "UPDATE ".$table." SET ".$updCol."= '$numVal' WHERE ".$keyCol." = '$keyVal' ";
		
		//query
		$query	= mysql_query($sql);
		
		//return the value
		return $numVal;
		
	}//eof
	
	
	
	/**
	*	Generate sort order number higher than the number of rows. It would be easier for the
	*	admin user while adding product or image or any other item to the database which will be 
	*	displaying according o the sort number.
	*
	*	@param
	*			$isFkReq		Determine if the foreign key is required. It has a boolean value
	*							viz. Y for yes and N for no. 
	*			$fkId			Foreign key id. If the sort order requires sorting associated with a
	*							foreign key value. e. g. If sorting require to display item 
	*							within a category.
	*			$fkCol			Column name of the foreign key.
	*			$stepNum		Step to higher
	*			$table			Name of the table to count number of rows
	*
	*	@return 	int
	*/
	function genSortOrderNum($isKeyReq, $fkId, $fkCol, $stepNum, $table)
	{
		//declare vars
		$num	= 0;
		
		//statement
		if($isKeyReq == 'N')
		{
			$sql	= "SELECT * FROM $table ";
		}
		else
		{
			$sql	= "SELECT * FROM $table WHERE $fkCol = '$fkId'";
		}
		
		
		//execute query
		$query	= mysql_query($sql);
		
		//get the number of rows
		$num	= mysql_num_rows($query);
		
		//add the step number
		$num	+= $stepNum;
		
		//return the result
		return $num;
		
	}//eof
	
	
}
?>