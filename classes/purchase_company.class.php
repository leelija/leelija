<?php 
/**
*	This class is going to work with all party associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Jan 07, 2017
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/




class PurchaseCompany
{

	#####################################################################################################
	#
	#										Add Purchase Company
	#
	#####################################################################################################
	
	/**
	*	Add a new company in purchase_company table.
	*
	*	@param
	*			$company_name			Purchase Company name
	*			$address				Company Address
	*			$city					Company City
	*			$cphone			    	Company phone number
	*			$cemail				    Company Email
	*						    
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addPurchaseComp($company_name,$address, $city, $cphone,$cemail,$added_by)
	
	{
		//$orders_id			   	=	mysql_real_escape_string(trim($orders_id));
		$company_name			   	= mysql_real_escape_string(trim($company_name));
		$address			   		=	mysql_real_escape_string(trim($address));
		$city		  				=	mysql_real_escape_string(trim($city));
		$cphone			 			=	mysql_real_escape_string(trim($cphone));
		$cemail			 			=	mysql_real_escape_string(trim($cemail));
		$added_by		     		=	mysql_real_escape_string(trim($added_by));
		//satement to insert in purchase_company table
		$insert		=   "INSERT INTO purchase_company
						(company_name,address, city, cphone,cemail,added_on,added_by)
							
						VALUES
						('$company_name','$address', '$city', '$cphone','$cemail', now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$company_id	= mysql_insert_id();
		
		//return primary key
		return $company_id;

	}//eof
		
	
	/*
	*	This funcion will return all the purchase company id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPcompany($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT company_id FROM purchase_company";
		}
		else
		{
			//statement
			$select	= "SELECT company_id FROM purchase_company
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['company_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	
	#####################################################################################################
	#
	#										Delete Purchase Company
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a PurchaseCompany permanently
	*
	*	@param
	*			$pcid			Purchase Company Id
	*
	*	@return null
	*/
	function delPcompany($pcid)
	{
		
		//delete from purchase_company
		$delete1 = "DELETE FROM purchase_company WHERE company_id	='$pcid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
		

	
	/**
	*	Get the data associated with a purchase_company based upon the primary key
	*
	*	@param
	*			$pcid		Purchase Company Id
	*
	*	@return array				
	*/
	function showPCompany($pcid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM purchase_company
				   WHERE company_id	= '$pcid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->company_id,					//0
					$result->company_name,					//1
					$result->address,						//2
					$result->city,							//3
					$result->cphone,						//4
					$result->cemail,						//5
					$result->added_on,						//6
					$result->added_by,						//7
					$result->modified_on,					//8
					$result->modified_by					//9
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	 public function getPcompanyDtls($company_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM purchase_company where company_id ='$company_id'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	//Display All Purchase company
	 public function showPcompanyDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM purchase_company order by company_name ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
/*####################################################################################################################*/
	
	/*                           Purchase details  search                                                         */
	
	/*####################################################################################################################*/
	/**
	*	Search Purchase Company keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getPcompanyKeyword($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT company_id FROM purchase_company ";
		}
		else
		{
			$sql = "SELECT company_id
					FROM   purchase_company
					WHERE (company_id LIKE '%$keyword%' OR
						   company_name LIKE '%$keyword%' OR
						   address LIKE '%$keyword%' OR
						   city LIKE '%$keyword%' OR
						   cphone LIKE '%$keyword%' OR
						   cemail LIKE '%$keyword%' OR
						   added_on LIKE '%$keyword%'
							
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->company_id;
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