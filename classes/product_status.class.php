<?php 
/**
*	This class is going to work with all stock associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Feb 10, 2015
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.waintechnology.com
*	@email		safikulislamwb@gmail.com
* 
*/




class Pstatus 
{

	#####################################################################################################
	#
	#										Add data into to Status Table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to stock in stock table.
	*
	*	@param
	*			
	*			$order_id			    order id	
	*			$design_no				Design no of  products
	*			$employee_id			employee id 
	*			$order_date				order date
	*			$target_date			target date
	*			$quantity				product quantity
	*			$dyeing					
	*			$hand     		    	hand
	*			$manual     		    product manual
	*			$computer    		    product computer
	*			$kcutting    		    kcutting
	*			$fstiching    		    final stiching
	*			$iron    		    	product iron
	*			$packing    		    product packing
	*			$status   		    	product status
	*			$remark   		    	remark for product 
	*		
	*			
	*
	*	@return int
	*/
	function addStatus($order_id,$design_no, $employee_id,$order_date, $target_date, $qty,$dyeing,$hand,$manual,$computer,$kcutting,
	$fstiching,$iron,$packing,$status,$remark,$factory_id)
	
	{
	//echo $quantity;exit;
		$order_id			   	=	mysql_real_escape_string(trim($order_id));
		$design_no	        	=	trim($design_no);
		$employee_id			= mysql_real_escape_string(trim($employee_id));
		$order_date			   	=	mysql_real_escape_string(trim($order_date));
		$target_date		    =	mysql_real_escape_string(trim($target_date));
		$quantity			 	=	mysql_real_escape_string(trim($qty));
		$dyeing		   			=	mysql_real_escape_string(trim($dyeing));
		$hand			   		=	mysql_real_escape_string(trim($hand));
		$manual		       		=	mysql_real_escape_string(trim($manual));
		$computer			 	=	mysql_real_escape_string(trim($computer));
		$kcutting		   		=	mysql_real_escape_string(trim($kcutting));
		$fstiching				=	mysql_real_escape_string(trim($fstiching));
		$iron					=	mysql_real_escape_string(trim($iron));
		$packing		   		=	mysql_real_escape_string(trim($packing));
		$status					=	mysql_real_escape_string(trim($status));
		$remark					=	mysql_real_escape_string(trim($remark));
		$factory_id					=	mysql_real_escape_string(trim($factory_id));
		//echo $quantity;exit;
		//satement to insert in stock table
		$insert		=   "INSERT INTO status_table
						(order_id, design_no, employee_id, order_date, target_date, quantity,dyeing,hand,
						manual, computer, kcutting, fstiching,iron,packing,status,remark,factory_id,added_on)
							
						VALUES
						('$order_id', '$design_no', '$employee_id', '$order_date', '$target_date','$quantity',
							'$dyeing', '$hand', '$manual','$computer', 
							'$kcutting','$fstiching',	
							'$iron','$packing','$status','$remark','$factory_id',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$status_id	= mysql_insert_id();
		
		//return primary key
		return $status_id;

	}//eof
		
	
	

	
	
	#####################################################################################################
	#
	#										Edit Status table
	#
	#####################################################################################################
	
	
	/**
	*	This function edit stock
	*
	*	@param
	*			$order_id			    order id	
	*			$design_no				Design no of  products
	*			$employee_id			employee id 
	*			$order_date				order date
	*			$target_date			target date
	*			$quantity				product quantity
	*			$dyeing					
	*			$hand     		    	hand
	*			$manual     		    product manual
	*			$computer    		    product computer
	*			$kcutting    		    kcutting
	*			$fstiching    		    final stiching
	*			$iron    		    	product iron
	*			$packing    		    product packing
	*			$status   		    	product status
	*			$remark   		    	remark for product 
	*		
	*			
	*		
	*			
	*	@return null
	*/
	function editStatus($status_id,$order_id,$design_no, $employee_id,$order_date, $target_date, $quantity,$dyeing,$hand,$manual,$computer,$kcutting,
	$fstiching,$iron,$packing,$status,$remark)
	
	{
	    $status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id			   	=	mysql_real_escape_string(trim($order_id));
		$design_no	        	=	trim($design_no);
		$employee_id			=   mysql_real_escape_string(trim($employee_id));
		$order_date			   	=	mysql_real_escape_string(trim($order_date));
		$target_date		    =	mysql_real_escape_string(trim($target_date));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		$dyeing		   			=	mysql_real_escape_string(trim($dyeing));
		$hand			   		=	mysql_real_escape_string(trim($hand));
		$manual		       		=	mysql_real_escape_string(trim($manual));
		$computer			 	=	mysql_real_escape_string(trim($computer));
		$kcutting		   		=	mysql_real_escape_string(trim($kcutting));
		$fstiching				=	mysql_real_escape_string(trim($fstiching));
		$iron					=	mysql_real_escape_string(trim($iron));
		$packing		   		=	mysql_real_escape_string(trim($packing));
		$status					=	mysql_real_escape_string(trim($status));
		$remark					=	mysql_real_escape_string(trim($remark));


		//update status_table description
		$edit  = "UPDATE status_table
				SET
				order_id		 	= '$order_id',
				design_no			= '$design_no',
				employee_id			= '$employee_id',
				order_date 			= '$order_date',
				target_date		    = '$target_date',
				quantity			= '$quantity',
				dyeing				= '$dyeing',
				hand		 		= '$hand',
				manual			    = '$manual',
				computer			= '$computer',
				kcutting 			= '$kcutting',
				fstiching		    = '$fstiching',
				iron				= '$iron',
				packing				= '$packing',
				status				= '$status',
				remark				= '$remark',
				modified_on			= now()
				WHERE
				status_id 			= '$status_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	function updateAriStat($status_id,$ari)
	{
		$status_id			  	   	=	mysql_real_escape_string(trim($status_id));
		$ari	       		   		=	mysql_real_escape_string(trim($ari));
		
		//update status_table description
		$edit  = "UPDATE status_table
				SET
				ari			        = '$ari'
				WHERE
				status_id 			= '$status_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	
	function editStatusDesign($order_id,$design_no, $employee_id,$order_date,$target_date)
	{
		$order_id			  	   =	mysql_real_escape_string(trim($order_id));
		$design_no	       		   =	mysql_real_escape_string(trim($design_no));
		$employee_id			   =    mysql_real_escape_string(trim($employee_id));
		$order_date	       		   =	mysql_real_escape_string(trim($order_date));
		$target_date			   =    mysql_real_escape_string(trim($target_date));
		//update status_table description
		$edit  = "UPDATE status_table
				SET
				design_no			= '$design_no',
				employee_id			= '$employee_id',
				order_date			= '$order_date',
				target_date			= '$target_date',
				modified_on			= now()
				WHERE
				order_id 			= '$order_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	
	function updateStatQuantity($status_id,$quantity)
	{
		$status_id			  	   =	mysql_real_escape_string(trim($status_id));
		$quantity	       		   =	mysql_real_escape_string(trim($quantity));
		
		//update status_table description
		$edit  = "UPDATE status_table
				SET
				quantity			        = '$quantity'
				WHERE
				status_id 			= '$status_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	function cancelStatus($order_id)
	{
		$order_id			  	   =	mysql_real_escape_string(trim($order_id));
		//update status_table description
		$edit  = "UPDATE status_table
				SET
				status			        = 'Cancel',
				modified_on				= now()
				WHERE
				order_id 			= '$order_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	function updatePipeLineStat($order_id,$dyeing)
	{
		$order_id			  	   	=	mysql_real_escape_string(trim($order_id));
		$dyeing	       		   		=	mysql_real_escape_string(trim($dyeing));
		
		//update status_table description
		$edit  = "UPDATE status_table
				SET
				dyeing				= '$dyeing'
				WHERE
				order_id 			= '$order_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	
	function updatePipeLine($order_id,$factory_id,$table)
	{
		$order_id			  	   	=	mysql_real_escape_string(trim($order_id));
		$factory_id	       		   	=	mysql_real_escape_string(trim($factory_id));
		
		//update status_table description
		$edit  = "UPDATE $table
				SET
				factory_id				= '$factory_id'
				WHERE
				order_id 				= '$order_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	
	// Status Table status update
	function updateStableSt($order_id,$fstiching,$field)
	{
		$order_id			  	   =	mysql_real_escape_string(trim($order_id));
		//update status_table description
		$edit  = "UPDATE status_table
				SET
				".$field."			= '$fstiching'
				WHERE
				order_id 			= '$order_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	#####################################################################################################
	#
	#										Delete Status table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a order permanently
	*
	*	@param
	*			$sid			status id
	*
	*	@return null
	*/
	function delStatusTable($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM status_table WHERE status_id='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Stock products details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$sid		stock id
	*
	*	@return array				
	*/
	function showProductStat($sid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM status_table
				   WHERE status_id	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->status_id,					//0
					$result->order_id,					//1
					$result->design_no,					//2
					$result->order_date,				//3
					$result->target_date,				//4
					$result->quantity,					//5
					$result->dyeing,					//6
					$result->hand,						//7
					$result->manual,					//8
					$result->kcutting,					//9
					$result->fstiching,					//10
					$result->iron,						//11
					$result->packing,					//12
					$result->status,					//13
					$result->added_on,					//14
					$result->added_by,					//15
					$result->modified_on,				//16
					$result->modified_by,				//17
					$result->computer,					//18
					$result->employee_id,				//19
					$result->remark,					//20
					$result->ari						//21

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$sid		stock id
	*
	*	@return array				
	*/
	function showProductStatord($order_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM status_table
				   WHERE order_id	= '$order_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->status_id,					//0
					$result->order_id,							//1
					$result->design_no,					//2
					$result->order_date,						//3
					$result->target_date,				//4
					$result->quantity,					//5
					$result->dyeing,		//6
					$result->hand,				//7
					$result->manual,		//8
					$result->kcutting,				//9
					$result->fstiching,				//10
					$result->iron,				//11
					$result->packing,		//12
					$result->status,	//13
					$result->added_on,					//14
					$result->added_by,						//15
					$result->modified_on,						//16
					$result->modified_by,						//17
					$result->computer,						//18
					$result->employee_id,						//19
					$result->remark						//20

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/* Display all status table data design no. wise*/
	/*
		$dno = Design no
	*/
	 public function statusAllData($dno){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM status_table where design_no ='$dno' AND packing !='complete' AND status !='Cancel'
	 order by status_id DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	
	 
	 
	/*
	*	This funcion will return all the product status id where employee_id=login employee id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPstatus($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT status_id FROM status_table where employee_id='$eid' AND packing != 'complete' AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW()";
		}
		else
		{
			//statement
			$select	= "SELECT status_id FROM status_table where employee_id='$eid' AND packing != 'complete' AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW()
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['status_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	

/*
	*	This funcion will return all the product status id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPstatusA($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT status_id FROM status_table";
		}
		else
		{
			//statement
			$select	= "SELECT status_id FROM status_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['status_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
}
?>