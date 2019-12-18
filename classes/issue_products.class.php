<?php 
/**
*	This class is going to work with all Sample associated with a Sample details. 
*
*	@author		Safikul Islam
*	@date		August 12, 2016
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/




class IssueProducts
{

	#####################################################################################################
	#										Add  to Issue Products Table
	#										
	#
	#####################################################################################################
	
	
	//			Add Issue Products Table value
	
	/**
	*	Issue Products Table.
	*
	*	@param
	*			
	*			$issue_products_id			issue products identification number
	*			$order_id			   		Order Id
	*			$design_no			   	    Design number
	*			$bill_no			   	    Bill number
	*			$master_id					Master identification number
	*			$labour_id					labour_id
	*			$issue_type					Type of Issue
	*			$particular					Products Particular
	*			$prod_quantity			    number of Particular quantity
	*			$rate						Interlock rate
	*			$total_cost			    	Total cost
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addIssueProducts($order_id,$design_no,$bill_no,$master_id,$labour_id,$issue_type,$particular,
	$prod_quantity,$rate,$total_cost,$added_by)
	
	{
		$order_id			   =	mysql_real_escape_string(trim($order_id));
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		$bill_no			   =	mysql_real_escape_string(trim($bill_no));
		$master_id			   =	mysql_real_escape_string(trim($master_id));
		$labour_id			   =	mysql_real_escape_string(trim($labour_id));
		$issue_type		   	   =	mysql_real_escape_string(trim($issue_type));
		$particular		   	   =	mysql_real_escape_string(trim($particular));
		$prod_quantity		   =	mysql_real_escape_string(trim($prod_quantity));
		$rate		   		   =	mysql_real_escape_string(trim($rate));
		$total_cost			   =	mysql_real_escape_string(trim($total_cost));
		$added_by			   =	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO issue_products
						(order_id,design_no,bill_no,master_id,labour_id,issue_type,particular,prod_quantity,rate,total_cost,added_by, added_on)
							
						VALUES
						('$order_id','$design_no','$bill_no','$master_id','$labour_id','$issue_type','$particular','$prod_quantity','$rate','$total_cost','$added_by',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$issue_products_id	= mysql_insert_id();
		
		//return primary key
		return $issue_products_id;

	}//eof
	

	#####################################################################################################
	#
	#										Display  Issue Products details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Issue Products based upon the primary key
	*
	*	@param
	*			$issue_products_id		Issue Products id
	*
	*	@return array				
	*/
	function showIssueProducts($issue_products_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM issue_products
				   WHERE issue_products_id	= '$issue_products_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->issue_products_id,			//0
					$result->order_id,		//1
					$result->design_no,			//2
					$result->master_id,			//3
					$result->labour_id,	//4
					$result->issue_type,		//5
					$result->particular,		//6
					$result->rate,		//7
					$result->total_cost,		//8
					$result->added_by,		//9
					$result->added_on,		//10
					$result->modified_by,		//11
					$result->modified_on,		//12
					$result->prod_quantity		//13
					);
		}
	
		//return the data
		return $data;
		
	}//eof
	
	public function getIssueProductsData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM issue_products order by issue_products_id Desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	/*
	*	This funcion will return all the Interlock id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllIssueProdId($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT issue_products_id FROM issue_products";
		}
		else
		{
			//statement
			$select	= "SELECT issue_products_id FROM issue_products
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['issue_products_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
#####################################################################################################
	#
	#										Delete Issue Products Table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete Issue Products Table row value permanently
	*
	*	@param
	*			$issue_products_id			Issue Products  id
	*
	*	@return null
	*/
	function delIssueProducts($issue_products_id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM issue_products WHERE issue_products_id ='$issue_products_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	

	
	
	
}