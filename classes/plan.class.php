<?php 
/**
*	This class is going to work with all Plan associated with a Plan details. 
*
*	@author		Safikul Islam
*	@date		May 24, 2015
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/




class Plan
{

	#####################################################################################################
	#
	#										Add To Plan table
	#
	#####################################################################################################
	
	/**
	*	Add a new Plan in Plan table.
	*
	*	@param
	*			
	*			$plan_id			   	    plan identity code
	*			$order_id			   	    Order Id
	*			$design_no					Design identity number
	*			$quantity					number of pieces order
	*			$status			     		status
	*			$emp_id			   	    	Employee Id
	*			$st_date					Start Date
	*			$end_date					end Date
	*			$remarks			     	Remarks
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addPlan($order_id,$design_no,$quantity,$status,$emp_id,$st_date,$end_date,$isue_date, $remarks,$added_by)
	
	{
		$order_id			  	   =	mysql_real_escape_string(trim($order_id));
		$design_no			  	   =	mysql_real_escape_string(trim($design_no));
		$quantity			  	   =	mysql_real_escape_string(trim($quantity));
		$status			     	   =	mysql_real_escape_string(trim($status));
		$emp_id			           =	mysql_real_escape_string(trim($emp_id));
		$st_date			  	   =	mysql_real_escape_string(trim($st_date));
		$end_date			       =	mysql_real_escape_string(trim($end_date));
		$isue_date			       =	mysql_real_escape_string(trim($isue_date));
		$remarks			       =	mysql_real_escape_string(trim($remarks));
		$added_by			       =	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO plan_table
						(order_id,design_no,quantity,status,emp_id,st_date,end_date,isue_date,remarks, added_on,added_by)
							
						VALUES
						('$order_id','$design_no','$quantity','$status','$emp_id','$st_date','$end_date','$isue_date','$remarks',now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sample_id	= mysql_insert_id();
		
		//return primary key
		return $plan_id;

	}//eof
		
	
	

	#####################################################################################################
	#
	#										Delete plan from plan  table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a plan permanently
	*
	*	@param
	*			$pid			plan id
	*
	*	@return null
	*/
	function delPlan($pid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM plan_table WHERE plan_id='$pid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	
	/*=============================update Plan==========================================*/
	
	function updatePlan($plan_id,$isue_date)
	
	{
		$isue_date			   =	mysql_real_escape_string(trim($isue_date));
		//update stock description
		$edit  = "UPDATE plan_table
				SET
				isue_date		 	= '$isue_date',
				modified_on			= now()
				WHERE
				plan_id 			= '$plan_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	function updatePlanfoDye($order_id,$isue_date)
	
	{
		$isue_date			   =	mysql_real_escape_string(trim($isue_date));
		//update stock description
		$edit  = "UPDATE plan_table
				SET
				isue_date		 	= '$isue_date',
				modified_on			= now()
				WHERE
				order_id 			= '$order_id' AND status ='Dyeing'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	function updatePlanforHand($order_id,$isue_date)
	
	{
		$isue_date			   =	mysql_real_escape_string(trim($isue_date));
		//update stock description
		$edit  = "UPDATE plan_table
				SET
				isue_date		 	= '$isue_date',
				modified_on			= now()
				WHERE
				order_id 			= '$order_id' AND status ='Hand'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
		function updatePlanforManual($order_id,$isue_date)
	
		{
		$isue_date			   =	mysql_real_escape_string(trim($isue_date));
		//update stock description
		$edit  = "UPDATE plan_table
				SET
				isue_date		 	= '$isue_date',
				modified_on			= now()
				WHERE
				order_id 			= '$order_id' AND status ='Manual'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	function updatePlanforComputer($order_id,$isue_date)
	
		{
		$isue_date			   =	mysql_real_escape_string(trim($isue_date));
		//update stock description
		$edit  = "UPDATE plan_table
				SET
				isue_date		 	= '$isue_date',
				modified_on			= now()
				WHERE
				order_id 			= '$order_id' AND status ='Computer'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	/*======================================== update plan =====================================*/
	
	
	
		function editPlan($plan_id,$design_no,$quantity,$emp_id,$st_date,$end_date,$modified_on)
	
	{
		$design_no			  	   =	mysql_real_escape_string(trim($design_no));
		$quantity			  	   =	mysql_real_escape_string(trim($quantity));
		$emp_id			           =	mysql_real_escape_string(trim($emp_id));
		$st_date			  	   =	mysql_real_escape_string(trim($st_date));
		$end_date			       =	mysql_real_escape_string(trim($end_date));
		$modified_on			       =	mysql_real_escape_string(trim($modified_on));
		
		//update stock description
		$edit  = "UPDATE plan_table
				SET
				design_no		 	= '$design_no',
				quantity		 	= '$quantity',
				emp_id		 	= '$emp_id',
				st_date		 	= '$st_date',
				end_date		 	= '$end_date',
				modified_on			= now()
				WHERE
				plan_id 			= '$plan_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	
	
	#####################################################################################################
	#
	#										Display  plan details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Pln based upon the primary key
	*
	*	@param
	*			$pid		Plan id
	*
	*	@return array				
	*/
	function showPlan($pid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM plan_table
				   WHERE plan_id	= '$pid' ORDER BY plan_id ASC";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->plan_id,					//0
					$result->order_id,					//1
					$result->design_no,		//2
					$result->quantity,			//3
					$result->status,		//4
					$result->emp_id,		//5
					$result->st_date,		//6
					$result->end_date,			//7
					$result->isue_date,			//8
					$result->remarks,	//9
					$result->added_on,		//10
					$result->added_by,		//11
					$result->modified_on,	//12
					$result->modified_by		//13
					
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/**
	*	Get the detail of a plan either against its id or its code. User needs to pass either of 
	*	this variable, if code is passed then put id  otherwise put code value
	*			
	*	@param
	*			$pid	Plan id
	*			$status		status
	*	
	*	@return array	
	*/
	
	function getShowPlan($pid,$status)
	{
		if($pid != '' && $status == '')
		{
			$sql	= "SELECT * FROM plan_table
						WHERE  plan_id = '$pid' 
						";
		}
		elseif($pid == '' && $status != '')
		{
			$sql	= "SELECT * FROM plan_table
					   WHERE  status = '$status'
					   ";
		}
		else
		{
			$sql	= "SELECT * FROM plan_table
						WHERE  plan_id = '$pid' 
						AND status= '$status'
						";
		}
		//declare vars
		$data = array();
		//execute query
		$query	= mysql_query($sql);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->plan_id,					//0
					$result->order_id,					//1
					$result->design_no,		//2
					$result->quantity,			//3
					$result->status,		//4
					$result->emp_id,		//5
					$result->st_date,		//6
					$result->end_date,			//7
					$result->isue_date,			//8
					$result->remarks,	//9
					$result->added_on,		//10
					$result->added_by,		//11
					$result->modified_on,	//12
					$result->modified_by		//13
					
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	/**
	*	display plan code, depending on the plan, and status of the plan
	*	variable:
	*	plan id			:	plan identity
	*	status			:	status code for the plan
	*/
	function getPlanCode($plan_id, $status)
	{
		if(($plan_id == 'all') &&($status == 'all'))
		{
			$sql	= "SELECT * FROM plan_table";
		}
		elseif(($plan_id == 'all') &&($status != 'all'))
		{
			$sql	= "SELECT * FROM plan_table WHERE status = '$status'";
		}
		elseif(((int)$plan_id > 0) &&($status != 'all'))
		{
			$sql	= "SELECT * FROM plan_table WHERE status = '$status' AND plan_id='$plan_id'";
		}
		elseif(((int)$plan_id > 0) &&($status == 'all'))
		{
			$sql	= "SELECT * FROM plan_table WHERE plan_id='$plan_id'";
		}
		else
		{
			$sql	= "SELECT * FROM plan_table";
		}
		
		$query	= mysql_query($sql);
		$data	= array();
		
		while($result = mysql_fetch_array($query))
		{
			$data[]	= $result['plan_id'];
		}
		return $data;
		
	}//eof
	
	
	
	
	
	function showPlanDtl($oid,$status)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM plan_table
				   WHERE order_id	= '$oid' AND status	='$status'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->plan_id,					//0
					$result->order_id,					//1
					$result->design_no,		//2
					$result->quantity,			//3
					$result->status,		//4
					$result->emp_id,		//5
					$result->st_date,		//6
					$result->end_date,		//7
					$result->isue_date,			//8
					$result->remarks,	//9
					$result->added_on,		//10
					$result->added_by,		//11
					$result->modified_on,	//12
					$result->modified_by		//13
					
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/*Plan data display for Hand*/
	function showPlanHand($oid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM plan_table
				   WHERE order_id	= '$oid' AND status	='Hand'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->plan_id,					//0
					$result->order_id,					//1
					$result->design_no,		//2
					$result->quantity,			//3
					$result->status,		//4
					$result->emp_id,		//5
					$result->st_date,		//6
					$result->end_date,		//7
					$result->isue_date,			//8
					$result->remarks,	//9
					$result->added_on,		//10
					$result->added_by,		//11
					$result->modified_on,	//12
					$result->modified_by		//13
					
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/*Plan data display for Manual*/
	function showPlanManual($oid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM plan_table
				   WHERE order_id	= '$oid' AND status	='Manual'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->plan_id,					//0
					$result->order_id,					//1
					$result->design_no,		//2
					$result->quantity,			//3
					$result->status,		//4
					$result->emp_id,		//5
					$result->st_date,		//6
					$result->end_date,		//7
					$result->isue_date,			//8
					$result->remarks,	//9
					$result->added_on,		//10
					$result->added_by,		//11
					$result->modified_on,	//12
					$result->modified_by		//13
					
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/*Plan data display for Computer*/
	function showPlanComputer($oid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM plan_table
				   WHERE order_id	= '$oid' AND status	='Computer'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->plan_id,					//0
					$result->order_id,					//1
					$result->design_no,		//2
					$result->quantity,			//3
					$result->status,		//4
					$result->emp_id,		//5
					$result->st_date,		//6
					$result->end_date,		//7
					$result->isue_date,			//8
					$result->remarks,	//9
					$result->added_on,		//10
					$result->added_by,		//11
					$result->modified_on,	//12
					$result->modified_by		//13
					
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*Plan data display for Kali Cutting*/
	function showPlanKali($oid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM plan_table
				   WHERE order_id	= '$oid' AND status	='Kali Cutting'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->plan_id,					//0
					$result->order_id,					//1
					$result->design_no,		//2
					$result->quantity,			//3
					$result->status,		//4
					$result->emp_id,		//5
					$result->st_date,		//6
					$result->end_date,		//7
					$result->isue_date,			//8
					$result->remarks,	//9
					$result->added_on,		//10
					$result->added_by,		//11
					$result->modified_on,	//12
					$result->modified_by		//13
					
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/*Plan data display for Kali Cutting*/
	function showPlanFinalStich($oid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM plan_table
				   WHERE order_id	= '$oid' AND status	='Final Stiching'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->plan_id,					//0
					$result->order_id,					//1
					$result->design_no,		//2
					$result->quantity,			//3
					$result->status,		//4
					$result->emp_id,		//5
					$result->st_date,		//6
					$result->end_date,		//7
					$result->isue_date,			//8
					$result->remarks,	//9
					$result->added_on,		//10
					$result->added_by,		//11
					$result->modified_on,	//12
					$result->modified_by		//13
					
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the product sample id for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPlan($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT plan_id FROM plan_table";
		}
		else
		{
			//statement
			$select	= "SELECT plan_id FROM plan_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['plan_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
/*####################################################################################################################*/
	
	/*                          plan details search                                                        */
	
	/*####################################################################################################################*/
	/**
	*	Plan product  keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getPlanSerch($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		//echo $keyword;exit;
		if($keyword =='')
		{
			$sql =  "SELECT plan_id FROM plan_table ";
		}
		else
		
		{
			$sql = "SELECT plan_id
					FROM   plan_table
					WHERE (
						   plan_id LIKE '%$keyword%' OR
						   design_no LIKE '%$keyword%' OR
						   order_id LIKE '%$keyword%' OR
						   status LIKE '%$keyword%' OR
						   emp_id LIKE '%$keyword%' OR
						   st_date LIKE '%$keyword%' OR
						   end_date LIKE '%$keyword%' OR
						   isue_date LIKE '%$keyword%'
						  
						  ) ;";		
		}
		
		
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->plan_id;
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