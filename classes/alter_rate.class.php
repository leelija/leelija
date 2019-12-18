<?php 
/**
*	This class is going to work with all rate associated with a particular Design. 
*
*	@author		Safikul Islam
*	@date		Apr 30, 2015
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/




class AlterRate
{

	#####################################################################################################
	#
	#										Add To Alter rate table
	#
	#####################################################################################################
	
	/**
	*	Add a new rate in alter rate table.
	*
	*	@param
	*			
	*			$arate_id			   	    alter rate id	
	*			$design_no					Design no of  products
	*			$particulars			    Particular of product
	*			$particular_rate			particular rate of product
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addAlterRate($design_no, $particulars,$particular_rate)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        		    =	trim($design_no);
		$particulars			   		= mysql_real_escape_string(trim($particulars));
		$particular_rate			    =	mysql_real_escape_string(trim($particular_rate));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO alter_rate
						(design_no, particulars, particular_rate, added_on)
							
						VALUES
						('$design_no', '$particulars', '$particular_rate',  
							now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$arate_id	= mysql_insert_id();
		
		//return primary key
		return $arate_id;

	}//eof
		
	
	

	
	
	#####################################################################################################
	#
	#										Edit Alter rate table
	#
	#####################################################################################################
	
	
	/**
	*	Edit a new rate from alter rate table.
	*
	*	@param
	*			
	*			$arate_id			   	    alter rate id	
	*			$design_no					Design no of  products
	*			$suit_rate			     	suit rate of product
	*			$dupatta_rate				dupatta rate of product
	*			$ghagra_rate				cost to make of hgagra
	*			$blause_rate				cost to make blause
	*			$total_rate					total cost to make a product
	*			
	*		
	*			
	*
	*	@return int
	*/
	function editAlterRate($design_no, $suit_rate,$dupatta_rate, $ghagra_rate, $blause_rate,  $total_rate)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        		=	trim($design_no);
		$suit_rate			   		= mysql_real_escape_string(trim($suit_rate));
		$dupatta_rate			    =	mysql_real_escape_string(trim($dupatta_rate));
		$ghagra_rate		       =	mysql_real_escape_string(trim($ghagra_rate));
		$blause_rate		       =	mysql_real_escape_string(trim($blause_rate));
		$total_rate			 =	mysql_real_escape_string(trim($total_rate));
		
		//update stock description
		$edit  = "UPDATE alter_rate
				SET
				design_no		 	= '$design_no',
				suit_rate			= '$suit_rate',
				dupatta_rate		= '$dupatta_rate',
				ghagra_rate 		= '$ghagra_rate',
				blause_rate 		= '$blause_rate',
				total_rate		    = '$total_rate',
				modified_on			= now()
				WHERE
				rate_id 			= '$rate_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	
	#####################################################################################################
	#
	#										Delete alter rate table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a alter rate permanently
	*
	*	@param
	*			$rid			rate id
	*
	*	@return null
	*/
	function delAlterRate($arid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM alter_rate WHERE arate_id='$arid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Alter Rate details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Alter Rate based upon the primary key
	*
	*	@param
	*			$arid		alter rate id
	*
	*	@return array				
	*/
	function showAlterRate($arid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM alter_rate
				   WHERE arate_id	= '$arid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->arate_id,					//0
					$result->design_no,							//1
					$result->particulars,					//2
					$result->particular_rate,		//3
					$result->added_on,		//4
					$result->added_by,						//5
					$result->modified_on,						//6
					$result->modified_by						//7
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	 public function getAlterRateDisplay($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM alter_rate where design_no='$design_no'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	/**
	*	Get the data associated with a Alter Rate based upon the Design Number
	*
	*	@param
	*			$dno		Design number
	*
	*	@return array				
	*/
	function showAlterRateDesNo($dno)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM alter_rate
				   WHERE design_no	= '$dno'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->arate_id,					//0
					$result->design_no,							//1
					$result->particulars,					//2
					$result->particular_rate,		//3
					$result->added_on,		//4
					$result->added_by,						//5
					$result->modified_on,						//6
					$result->modified_by						//7
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get the data associated with a stich Rate based upon the particular
	*
	*	@param
	*			$particular		particular 
	*
	*	@return array				
	*/
	function showAlterRatePartiwise($particular,$design_no)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM alter_rate
				   WHERE particulars	= '$particular' AND design_no = '$design_no'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->arate_id,					//0
					$result->design_no,							//1
					$result->particulars,					//2
					$result->particular_rate,		//3
					$result->added_on,		//4
					$result->added_by,						//5
					$result->modified_on,						//6
					$result->modified_by						//7
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the  rate id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllIAlterRate($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT arate_id FROM alter_rate where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT rate_id FROM stich_rate where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['arate_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the product dhmckfip for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllAlterRateAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT arate_id FROM alter_rate";
		}
		else
		{
			//statement
			$select	= "SELECT arate_id FROM alter_rate
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['arate_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
}// eoc