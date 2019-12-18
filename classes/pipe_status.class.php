
<?php 
/**
*	This class is going to work with all stock associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		March 6, 2015
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.waintechnology.com
*	@email		safikulislamwb@gmail.com
* 
*/




class Pipestatus 
{


// update packing pending table
	function Updatependintbl($ordid ,$empid,$particular,$quantity,$compquantity)
	{
		$ordid				 =	mysql_real_escape_string(trim($ordid));
		$empid				 =	mysql_real_escape_string(trim($empid));
		$particular			 =	mysql_real_escape_string(trim($particular));
		$quantity			 =	mysql_real_escape_string(trim($quantity));
		$compquantity			 =	mysql_real_escape_string(trim($compquantity));
		$sql	= "UPDATE packing_pending SET
			quantity		 =  '$quantity',
			comquantity		 =  '$compquantity',
			modified_on		 =  now()
			WHERE
			    order_id	 =  '$ordid' AND employeeId	 =  '$empid' AND particular	 =  '$particular'
				";
				 
				 
			
		//execute query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
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
	}
	

// update packing pending table for alter
	function Updatependintblbyalter($ordid ,$empid,$particular,$quantity,$alterquantity)
	{
		$ordid				 =	mysql_real_escape_string(trim($ordid));
		$empid				 =	mysql_real_escape_string(trim($empid));
		$particular			 =	mysql_real_escape_string(trim($particular));
		$quantity			 =	mysql_real_escape_string(trim($quantity));
		$alterquantity			 =	mysql_real_escape_string(trim($alterquantity));
		$sql	= "UPDATE packing_pending SET
			quantity		 =  '$quantity',
			alterquantity		 =  '$alterquantity',
			modified_on		 =  now()
			WHERE
			    order_id	 =  '$ordid' AND employeeId	 =  '$empid' AND particular	 =  '$particular'
				";
				 
				 
			
		//execute query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
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
	}
	
	// update packing pending table when  alter table  update
	function EditPackinPend($pp_id ,$comquantity,$alterquantity)
	{
		$pp_id						 =	mysql_real_escape_string(trim($pp_id));
		$comquantity				 =	mysql_real_escape_string(trim($comquantity));
		$alterquantity				 =	mysql_real_escape_string(trim($alterquantity));
		$sql	= "UPDATE packing_pending SET
			comquantity		 	=  '$comquantity',
			alterquantity		 =  '$alterquantity',
			modified_on		 =  now()
			WHERE
			    pp_id	 =  '$pp_id'
				";
		//execute query
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
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
	}

	
	


} // end class	