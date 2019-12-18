<?php 
/**
*	This class is going to work with all Currier associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		July 13, 2015
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/

class Currier 
{

	#####################################################################################################
	#
	#										Add Currier
	#
	#####################################################################################################
	
	/**
	*	Add a new currier_details in currier_details table.
	*
	*	@param
	*			$id			    		Currier identification number	
	*			$name					Currier name
	*			$address				Currier Address
	*			$city					Currier City
	*			$cphone					Currier phone number
	*			
	*	@return int
	*/
	function addCurrier($name,$cemail,$cphone, $gstin_no, $pan_no,$address, $city, $balance,$added_by)
	
	{
		$name			   		= mysql_real_escape_string(trim($name));
		$cemail			   		= mysql_real_escape_string(trim($cemail));
		$cphone			   		=	mysql_real_escape_string(trim($cphone));
		$gstin_no		  		=	mysql_real_escape_string(trim($gstin_no));
		$pan_no			 		=	mysql_real_escape_string(trim($pan_no));
		$address			 	=	mysql_real_escape_string(trim($address));
		$city			   		=	mysql_real_escape_string(trim($city));
		$balance		     	=	mysql_real_escape_string(trim($balance));
		$gst_no		     		=	mysql_real_escape_string(trim($gst_no));
		$added_by		     	=	mysql_real_escape_string(trim($added_by));
		//satement to insert in currier_details table
		$insert		=   "INSERT INTO currier_details
						(name,cemail,cphone, gstin_no, pan_no,address, city, balance,added_on,added_by)
							
						VALUES
						('$name','$cemail','$cphone', '$gstin_no', '$pan_no','$address', '$city',
						'$balance', now(),'$added_by')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		
		//return primary key
		return $id;

	}//eof
		
	
	
	#####################################################################################################
	#
	#										Edit currier_details
	#
	#####################################################################################################
	
	/**
	*	This function edit orders
	*
	*	@param
	*			$id			    		Currier identification number	
	*			$name					Currier name
	*			$address				Currier Address
	*			$city					Currier City
	*			$cphone					Currier phone number
	*		
	*	@return null
	*/
	function editCurrier($id,$name, $cemail,$cphone, $pan_no, $gst_no, $balance, $modified_by)
	{
		$id			   		= mysql_real_escape_string(trim($id));
		$name			   	= mysql_real_escape_string(trim($name));
		$cemail			   	= mysql_real_escape_string(trim($cemail));
		$cphone				= mysql_real_escape_string(trim($cphone));
		$pan_no		  		= mysql_real_escape_string(trim($pan_no));
		$gst_no			 	= mysql_real_escape_string(trim($gst_no));
		$balance			= mysql_real_escape_string(trim($balance));
		$modified_by		= mysql_real_escape_string(trim($modified_by));
		
		//update Buyer details
		$edit  = "UPDATE currier_details
				SET
				name		 		= '$name',
				cemail		 		= '$cemail',
				cphone				= '$cphone',
				pan_no				= '$pan_no',
				gst_no 				= '$gst_no',
				balance				= '$balance',
				modified_on			= now(),
				modified_by			= '$modified_by'
				WHERE
				id 					= '$id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	
	/**
	*	update currier_details payment amount in currier_details table.
	*
	*	@param
	*			$id					Id of the currier_details
	*			$balance			Payment due from currier_details
	*
	*	@return int
	*/
	function updateCurrierPayment($id,$balance)
	{	
		$id			   			=	mysql_real_escape_string(trim($id));
		$balance				=	mysql_real_escape_string(trim($balance));
		//update product description
		$edit  = "UPDATE currier_details
				SET
				balance					= '$balance'
				WHERE
				id 						= '$id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	
	
	
	
	
	#####################################################################################################
	#
	#										Delete Currier data
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a currier_details permanently
	*
	*	@param
	*			$id			Currier Id
	*
	*	@return null
	*/
	function delCurrier($id)
	{
		
		//delete from currier_details
		$delete1 = "DELETE FROM currier_details WHERE id='$id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
		

	
	/**
	*	Get the data associated with a currier_details based upon the primary key
	*
	*	@param
	*			$id		currier_details id
	*
	*	@return array				
	*/
	function showCurrier($id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM currier_details
				   WHERE id	= '$id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,						//0
					$result->name,						//1
					$result->cemail,					//2
					$result->cphone,					//3
					$result->gstin_no,					//4
					$result->pan_no,					//5
					$result->address,					//6
					$result->city,						//7
					$result->balance,					//8
					$result->added_by,					//9
					$result->added_on,					//10
					$result->modified_by,				//11
					$result->modified_on				//12
					);
		}
		//return the data
		return $data;
	}//eof
	
	
	public function getCurrier(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM currier_details order by name asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	
	 
}//eoc	 