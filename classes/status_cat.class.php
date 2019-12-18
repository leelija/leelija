<?php 
/**
*	This class is going to work with all stock associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		March 6, 2015
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/




class StatusCat 
{

	#####################################################################################################
	#
	#										Add To Dyeing table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to dyeing product in dyeing table.
	*
	*	@param
	*			
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function addStasCat($status_id,$order_id, $design_no,$store_managerId, $employeeId, $bill_no, $status, 
	$fabric_type,$quantity,$colour,$remarks,$order_date,$target_date,$complete,$final_result, $added_by,$no_of_colour,
	$per_fb_quantity,$fab_cat,$factory_id)
	
	{
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	=   mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$bill_no		       	=	mysql_real_escape_string(trim($bill_no));
		$status			 		=	mysql_real_escape_string(trim($status));
		$fabric_type		    =	mysql_real_escape_string(trim($fabric_type));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		$colour			 		=	mysql_real_escape_string(trim($colour));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$complete				=	mysql_real_escape_string(trim($complete));
		$final_result			=	mysql_real_escape_string(trim($final_result));
		
		$added_by				=	mysql_real_escape_string(trim($added_by));
		$no_of_colour			=	mysql_real_escape_string(trim($no_of_colour));
		$per_fb_quantity		=	mysql_real_escape_string(trim($per_fb_quantity));
		$fab_cat				=	mysql_real_escape_string(trim($fab_cat));
		$factory_id				=	mysql_real_escape_string(trim($factory_id));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO dyeing_table
						(status_id, order_id, design_no, store_managerId, employeeId, bill_no, status,fabric_type,quantity,
						colour,remarks,order_date,target_date,complete,final_result,added_on, added_by,no_of_colour,
						per_fb_quantity,fab_cat,factory_id)
						VALUES
						('$status_id', '$order_id', '$design_no', '$store_managerId', '$employeeId','$bill_no','$status','$fabric_type','$quantity', 
							'$colour','$remarks','$order_date','$target_date','$complete','$final_result',now(), '$added_by','$no_of_colour',
							'$per_fb_quantity','$fab_cat','$factory_id')
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$dyeing_id	= mysql_insert_id();
		
		//return primary key
		return $dyeing_id;

	}//eof
	
/*-----------------------------Dyeing Details add in dyeing_details table---------------------------------------------*/
	
	
	
	

/*-----------------------------Edit Dyeing------------------------------------------------------------*/

/**
	*	Edit  dyeing product in dyeing table.
	*
	*	@param
	*			
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function editDyeing($mid,$status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$quantity,$remarks,$order_date,$target_date, $modified_by,
	 $complete,$final_result,$bill_no,$fabric_type)
	
	{
	
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	= mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$status			 		=	mysql_real_escape_string(trim($status));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));
	    $complete				=	mysql_real_escape_string(trim($complete));
		$final_result			=	mysql_real_escape_string(trim($final_result));
		$bill_no				=	mysql_real_escape_string(trim($bill_no));
		$fabric_type			=	mysql_real_escape_string(trim($fabric_type));
		
		//statement
		$sql	= "UPDATE dyeing_table SET
				status_id						    	=  '$status_id',			
				order_id				            	=	'$order_id',	
				design_no						    	=  '$design_no',			
				store_managerId				            =	'$store_managerId',	
				employeeId						    	=  '$employeeId',			
				status				             		=	'$status',	
				quantity						     	=  '$quantity',			
				remarks				            	 	=	'$remarks',	
				order_date						    	=  '$order_date',
				target_date						    	=  '$target_date',
				modified_by						    	=  '$modified_by',
				modified_on							 	=   now(),
				complete							 	=   '$complete',
				final_result							=   '$final_result',
				bill_no							 		=   '$bill_no',
				fabric_type								=   '$fabric_type'
				WHERE
			    dyeing_id			      			 =  '$mid'
				";
				 
				 
			
		//execute query
		$query	= mysql_query($sql);
		
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
		
	}//eof
	
	
	
	function editDyeingstatus($dyeing_id,$status)
	{
		$status			 	=	mysql_real_escape_string(trim($status));
		$sql				= "UPDATE dyeing_table SET
			final_result	=  '$status'
			WHERE
			    dyeing_id	 =  '$dyeing_id'
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
	
	
	
	
#####################################################################################################
	#
	#										Display  Dyeing  details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$mid		Dyeing id
	*
	*	@return array				
	*/
	function showProductStatCat($mid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM dyeing_table
				   WHERE dyeing_id	= '$mid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->dyeing_id,				//0
					$result->status_id,				//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,		//4
					$result->employeeId,			//5
					$result->status,				//6
					$result->quantity,				//7
					$result->remarks,				//8
					$result->order_date,			//9
					$result->target_date,			//10
					$result->added_on,				//11
					$result->added_by,				//12
					$result->modified_on,			//13
					$result->modified_by,			//14
					$result->complete,				//15
					$result->final_result,			//16
					$result->bill_no,				//17
					$result->fabric_type,			//18
					$result->colour,				//19
					$result->no_of_colour,			//20
					$result->per_fb_quantity,		//21
					$result->fab_cat				//22
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	// display fabric amount fabric type wise
	 public function getAllFabricAmount($bill_no,$fabric_type){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM dyeing_table where bill_no = '$bill_no' AND fabric_type = '$fabric_type' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	 
	 
	 // display fabric amount fabric cat wise
	 public function getAllDyAmount($bill_no,$fab_cat){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM dyeing_table where bill_no = '$bill_no' AND fab_cat = '$fab_cat' 
	 group by order_id") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	
	/* Display all Pipe Line status table data */
	/*	$table		= table name
	/*	$bid  		= Bill Id
	*/
	 public function disPlTableDtls($bid,$table){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." where bill_no='$bid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
	 //echo $res.mysql_error();exit;
     return $temp_arr;  
     }
	
	/* Display all Pipe Line status table data */
	/*	$oid  		= order Id
	*/
	 public function disPipeLineStat($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM dyeing_table where order_id='$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	// Date wise PipeLine Report 
	public function getPLineDailyRpt($factory_id,$todate,$table,$dateField){
     //echo $design_no;exit;
	 $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." where factory_id ='$factory_id' AND
	 ".$dateField." ='$todate' group by order_id") or die(mysql_error());
	 //echo $res.mysql_error();exit;
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	
	// Date wise PipeLine Report 
	public function getPLineRunnRpt($factory_id,$table,$dateField){
     //echo $design_no;exit;
	 $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." where factory_id ='$factory_id' AND
	 ".$dateField." !='Complete' group by order_id") or die(mysql_error());
	 //echo $res.mysql_error();exit;
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	
	// Date wise Hand Report 
	public function getHandDailyRpt($factory_id,$todate,$table,$dateField,$workType){
     //echo $design_no;exit;
	 $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." where factory_id ='$factory_id' AND work_type = '$workType' AND
	 ".$dateField." ='$todate' group by order_id") or die(mysql_error());
	 //echo $res.mysql_error();exit;
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	
	// Date wise Hand Report 
	public function getHandRunnRpt($factory_id,$table,$dateField,$workType){
     //echo $design_no;exit;
	 $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." where factory_id ='$factory_id' AND work_type = '$workType' AND
	 ".$dateField." !='Complete' group by order_id") or die(mysql_error());
	 //echo $res.mysql_error();exit;
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	
	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$sid		stock id
	*
	*	@return array				
	*/
	function showProductStatCat1($sid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM dyeing_table
				   WHERE status_id	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->dyeing_id,		//	0
					$result->status_id,		//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,			//4
					$result->employeeId,	//5
					$result->status,	//6
					$result->quantity,		//7
					$result->remarks,		//8
					$result->order_date,//9
					$result->target_date,	//10
					$result->added_on,		//11
					$result->added_by,	//12
					$result->modified_on,	//13
					$result->modified_by,	//14
					$result->complete,	//15
					$result->final_result	//16

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	

	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllDyeing($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT dyeing_id FROM dyeing_table where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT dyeing_id FROM dyeing_table where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['dyeing_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllDyeingForDWN($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT dyeing_id FROM dyeing_table where store_managerId='$eid' AND quantity != 0";
		}
		else
		{
			//statement
			$select	= "SELECT dyeing_id FROM dyeing_table where store_managerId='$eid' AND quantity != 0
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['dyeing_id'];
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
	function getAllDyeingAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT dyeing_id FROM dyeing_table";
		}
		else
		{
			//statement
			$select	= "SELECT dyeing_id FROM dyeing_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['dyeing_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	

#####################################################################################################
	#
	#										Add To Hand table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to hand_table in hand table.
	*
	*	@param
	*			$dhmckfip				product manufacture Id
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function addStasHand($status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$bill_no,
	$colour,$quantity,$material_name,$material_amount,$material_cost,$work_time,$labour_cost,$others_cost,$remarks,
	$order_date,$target_date,$work_type,$perticular)
	
	{
		//$dhmckfip			   	=	mysql_real_escape_string(trim($dhmckfip));
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	= mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$status			 		=	mysql_real_escape_string(trim($status));
		$bill_no			   	=	mysql_real_escape_string(trim($bill_no));
		$colour		    		=	mysql_real_escape_string(trim($colour));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		
		$material_name			=	mysql_real_escape_string(trim($material_name));
		$material_amount		=	mysql_real_escape_string(trim($material_amount));
		$material_cost			=	mysql_real_escape_string(trim($material_cost));
		$work_time			   	=	mysql_real_escape_string(trim($work_time));
		$labour_cost		    =	mysql_real_escape_string(trim($labour_cost));
		$others_cost			=	mysql_real_escape_string(trim($others_cost));
		
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$work_type				=	mysql_real_escape_string(trim($work_type));
		$perticular				=	mysql_real_escape_string(trim($perticular));

		//satement to insert in stock table
		$insert		=   "INSERT INTO hand_table
						(status_id, order_id, design_no, store_managerId, employeeId, status,bill_no,colour,quantity,
						material_name,material_amount,material_cost,work_time,labour_cost,others_cost,remarks,order_date,
						target_date,added_on,work_type,perticular)
						VALUES
						('$status_id', '$order_id', '$design_no', '$store_managerId', '$employeeId','$status','$bill_no','$colour','$quantity', 
							'$material_name','$material_amount','$material_cost','$work_time','$labour_cost','$others_cost',
							'$remarks','$order_date','$target_date',now(),'$work_type','$perticular')
							
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$hand_id	= mysql_insert_id();
		//return primary key
		return $hand_id;

	}//eof


	/*-----------------------------Edit Hand------------------------------------------------------------*/

/**
	*	Edit  Hand product in dyeing table.
	*
	*	@param
	*			
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function editHand($mid,$status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$quantity,$remarks,
	$order_date,$target_date, $modified_by,$complete,$final_result,$bill_no,$colour)
	
	{
	
		$status_id			   		=	mysql_real_escape_string(trim($status_id));
		$order_id	        		=	trim($order_id);
		$design_no			   		= mysql_real_escape_string(trim($design_no));
		$store_managerId			=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       		=	mysql_real_escape_string(trim($employeeId));
		$status			 			=	mysql_real_escape_string(trim($status));
		$quantity			 		=	mysql_real_escape_string(trim($quantity));
		$remarks		   			=	mysql_real_escape_string(trim($remarks));
		$order_date					=	mysql_real_escape_string(trim($order_date));
		$target_date				=	mysql_real_escape_string(trim($target_date));
		$modified_by				=	mysql_real_escape_string(trim($modified_by));
	    $complete					=	mysql_real_escape_string(trim($complete));
		$final_result				=	mysql_real_escape_string(trim($final_result));
		$bill_no					=	mysql_real_escape_string(trim($bill_no));
		$colour						=	mysql_real_escape_string(trim($colour));
		//statement
		$sql	= "UPDATE hand_table SET
				status_id						    		 	=  '$status_id',			
				order_id				            	 		=	'$order_id',	
				design_no						    	 		=  '$design_no',			
				store_managerId				            	 	=	'$store_managerId',	
				employeeId						    	 		=  '$employeeId',			
				status				             				=	'$status',	
				quantity						     			=  '$quantity',			
				remarks				            	 			=	'$remarks',	
				order_date						    		 	=  '$order_date',
				target_date						    		 	=  '$target_date',
				modified_by						    		 	=  '$modified_by',
				modified_on							 		 	=   now(),
				complete							 		 	=   '$complete',
				final_result							 		=   '$final_result',
				bill_no							 		 		=   '$bill_no',
				colour							 		 		=   '$colour'
				WHERE
			    hand_id			      			 =  '$mid'
				";
				 
				 
			
		//echo $sql.mysql_error();exit;	
		//execute query
		$query	= mysql_query($sql);
		
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
		
	}//eof
	
	
	function editHandstatus($hand_id,$status)
	{
		$status			 =	mysql_real_escape_string(trim($status));
		$sql	= "UPDATE hand_table SET
			final_result		 =  '$status'
			WHERE
			    hand_id	 =  '$hand_id'
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
	
	
	
#####################################################################################################
	#
	#										Display  Hand  details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$mid		hand_id 
	*
	*	@return array				
	*/
	function showProductHand($mid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM hand_table
				   WHERE hand_id	= '$mid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->hand_id,			//0
					$result->status_id,			//1
					$result->order_id,			//2
					$result->design_no,			//3
					$result->store_managerId,	//4
					$result->employeeId,		//5
					$result->status,			//6
					$result->quantity,			//7
					$result->remarks,			//8
					$result->order_date,		//9
					$result->target_date,		//10
					$result->added_on,			//11
					$result->added_by,			//12
					$result->modified_on,		//13
					$result->modified_by,		//14
					$result->complete,			//15
					$result->final_result,		//16
					$result->bill_no,			//17
					$result->colour,			//18
					$result->work_type			//19
					);
		}
		//return the data
		return $data;
	}//eof
	
	
	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllHand($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT hand_id FROM hand_table where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT hand_id FROM hand_table where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['hand_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getNotComAllHand($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT hand_id FROM hand_table where store_managerId='$eid' AND final_result != 'Complete'";
		}
		else
		{
			//statement
			$select	= "SELECT hand_id FROM hand_table where store_managerId='$eid' AND final_result != 'Complete'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['hand_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the product hand_id for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllHandAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT hand_id FROM hand_table";
		}
		else
		{
			//statement
			$select	= "SELECT hand_id FROM hand_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['hand_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	// Hand Details Display order id wise
	/*	
	*	oid 	= 			Order Id
	*/	
	 public function handDtlDisplay($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM hand_table where order_id 	= '$oid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Hand Details Display bill no wise and order id group
	/*	
	*	bid 	= 			Bill no
	*/	
	 public function disHandStatOrdWise($bid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM hand_table where bill_no  = '$bid' group by order_id") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	 // Hand Details Display Order id AND work type wise
	/*	
	*	order_id 	= 			Order Id 
	*/	
	 public function disHandStatOrdWorkWise($order_id,$work_type){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM hand_table where order_id  = '$order_id' AND work_type = '$work_type'") or die(mysql_error());        
     $count=mysql_num_rows($res);
   // echo $res.mysql_error();exit;
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	#####################################################################################################
	#
	#										Add To Manual table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to hand_table in hand table.
	*
	*	@param
	*			$dhmckfip				product manufacture Id
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	
	
	function addStasManual($status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$bill_no,
	$colour,$quantity,$material_name,$material_amount,$material_cost,$work_time,$labour_cost,$others_cost,$remarks,$order_date,$target_date)
	
	{
		//$dhmckfip			   	=	mysql_real_escape_string(trim($dhmckfip));
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	= mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$status			 		=	mysql_real_escape_string(trim($status));
		$bill_no			   	=	mysql_real_escape_string(trim($bill_no));
		$colour		       		=	mysql_real_escape_string(trim($colour));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		
		$material_name			=	mysql_real_escape_string(trim($material_name));
		$material_amount		=	mysql_real_escape_string(trim($material_amount));
		$material_cost			=	mysql_real_escape_string(trim($material_cost));
		$work_time			   	=	mysql_real_escape_string(trim($work_time));
		$labour_cost		    =	mysql_real_escape_string(trim($labour_cost));
		$others_cost			=	mysql_real_escape_string(trim($others_cost));
		
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		//$added_by				=	mysql_real_escape_string(trim($added_by));



		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO manual_table
						(status_id, order_id, design_no, store_managerId, employeeId, status,bill_no,colour,quantity,
						material_name,material_amount,material_cost,work_time,labour_cost,others_cost,remarks,order_date,target_date,added_on)
							
						VALUES
						('$status_id', '$order_id', '$design_no', '$store_managerId', '$employeeId','$status','$bill_no','$colour','$quantity', 
							'$material_name','$material_amount','$material_cost','$work_time','$labour_cost','$others_cost',
							'$remarks','$order_date','$target_date',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$manual_id	= mysql_insert_id();
		
		//return primary key
		return $manual_id;

	}//eof

	
	
	

	
	
	/*-----------------------------Edit Manual------------------------------------------------------------*/

/**
	*	Edit  Manual product in dyeing table.
	*
	*	@param
	*			
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function editManual($mid,$status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$quantity,$remarks,$order_date,$target_date, $modified_by,
	 $complete,$final_result,$bill_no,$colour)
	
	{
	
		$status_id			   		=	mysql_real_escape_string(trim($status_id));
		$order_id	        		=	trim($order_id);
		$design_no			   		= mysql_real_escape_string(trim($design_no));
		$store_managerId			=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       		=	mysql_real_escape_string(trim($employeeId));
		$status			 			=	mysql_real_escape_string(trim($status));
		$quantity			 		=	mysql_real_escape_string(trim($quantity));
		$remarks		   			=	mysql_real_escape_string(trim($remarks));
		$order_date					=	mysql_real_escape_string(trim($order_date));
		$target_date				=	mysql_real_escape_string(trim($target_date));
		$modified_by				=	mysql_real_escape_string(trim($modified_by));
	    $complete					=	mysql_real_escape_string(trim($complete));
		$final_result				=	mysql_real_escape_string(trim($final_result));
		$bill_no					=	mysql_real_escape_string(trim($bill_no));
		$colour						=	mysql_real_escape_string(trim($colour));
		//statement
		$sql	= "UPDATE manual_table SET
				status_id						    	=  '$status_id',			
				order_id				            	=	'$order_id',	
				design_no						    	=  '$design_no',			
				store_managerId				            =	'$store_managerId',	
				employeeId						    	=  '$employeeId',			
				status				             		=	'$status',	
				quantity						     	=  '$quantity',			
				remarks				            	 	=	'$remarks',	
				order_date						    		 =  '$order_date',
				target_date						    		 =  '$target_date',
				modified_by						    		 =  '$modified_by',
				modified_on							 		 =   now(),
				complete							 		 =   '$complete',
				final_result							 		 =   '$final_result',
				bill_no							 		 =   '$bill_no',
				colour							 		 =   '$colour'
				WHERE
			    manual_id			      			 =  '$mid'
				";
				 
				 
			
		//execute query
		$query	= mysql_query($sql);
		
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
		
	}//eof
	
	
	function editManualstatus($manual_id,$status)
	{
		$status			 =	mysql_real_escape_string(trim($status));
		$sql	= "UPDATE manual_table SET
			final_result		 =  '$status'
			WHERE
			    manual_id	 =  '$manual_id'
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
	
	
	
	#####################################################################################################
	#
	#										Display  Manual  details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$mid		dhmckfip id
	*
	*	@return array				
	*/
	function showProductManual($mid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM manual_table
				   WHERE manual_id	= '$mid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->manual_id,		//	0
					$result->status_id,		//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,			//4
					$result->employeeId,	//5
					$result->status,	//6
					$result->quantity,		//7
					$result->remarks,		//8
					$result->order_date,//9
					$result->target_date,	//10
					$result->added_on,		//11
					$result->added_by,	//12
					$result->modified_on,	//13
					$result->modified_by,	//14
					$result->complete,	//15
					$result->final_result,	//16
					$result->bill_no,	//17
					$result->colour	//18

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	

	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllManual($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT manual_id FROM manual_table where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT manual_id FROM manual_table where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['manual_id'];
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
	function getAllManualAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT manual_id FROM manual_table";
		}
		else
		{
			//statement
			$select	= "SELECT manual_id FROM manual_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['manual_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	#####################################################################################################
	#
	#										Add To Computer table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to hand_table in hand table.
	*
	*	@param
	*			$dhmckfip				product manufacture Id
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	
	function addStasComputer($status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,
	$bill_no,$colour,$computer_design_no,$quantity,$total_stich,$stich_rate,$labour_cost,$others_cost,$work_time,$comp_type,
	$marea,$remarks,$order_date,$target_date, $added_by,$no_head_or_line,$no_of_colour,$unit,$additional)
	
	{
		//$dhmckfip			   	=	mysql_real_escape_string(trim($dhmckfip));
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	= mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$status			 		=	mysql_real_escape_string(trim($status));
		$bill_no			   	= mysql_real_escape_string(trim($bill_no));
		$colour			   		=	mysql_real_escape_string(trim($colour));
		$computer_design_no		=	mysql_real_escape_string(trim($computer_design_no));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		$total_stich			=	mysql_real_escape_string(trim($total_stich));
		$stich_rate			   	= mysql_real_escape_string(trim($stich_rate));
		$labour_cost			=	mysql_real_escape_string(trim($labour_cost));
		$others_cost		    =	mysql_real_escape_string(trim($others_cost));
		$work_time			 	=	mysql_real_escape_string(trim($work_time));
		$comp_type			 	=	mysql_real_escape_string(trim($comp_type));
		$marea			 		=	mysql_real_escape_string(trim($marea));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		$no_head_or_line		=	mysql_real_escape_string(trim($no_head_or_line));
		$no_of_colour			=	mysql_real_escape_string(trim($no_of_colour));
		$unit					=	mysql_real_escape_string(trim($unit));
		$additional			 	=	mysql_real_escape_string(trim($additional));
		//echo $computer_design_no;exit;
		//satement to insert in stock table
		$insert		=   "INSERT INTO computer_table
						(status_id, order_id, design_no, store_managerId, employeeId, status,bill_no,colour,
						computer_design_no,quantity,total_stich,stich_rate,labour_cost,others_cost,work_time,comp_type,
						marea,remarks,order_date,target_date,added_on, added_by,no_head_or_line,no_of_colour,unit,additional)
							
						VALUES
						('$status_id', '$order_id', '$design_no', '$store_managerId', '$employeeId','$status','$bill_no',
						'$colour','$computer_design_no','$quantity','$total_stich','$stich_rate','$labour_cost','$others_cost','$work_time','$comp_type',
							'$marea','$remarks','$order_date','$target_date',now(), '$added_by','$no_head_or_line','$no_of_colour','$unit','$additional')
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$computer_id	= mysql_insert_id();
		
		//return primary key
		return $computer_id;

	}//eof
	
	
	/*-----------------------------Edit Computer------------------------------------------------------------*/

/**
	*	Edit  Computer product in dyeing table.
	*
	*	@param
	*			
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function editComputer($mid,$status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$quantity,$remarks,$order_date,$target_date, $modified_by,
	 $complete,$final_result,$bill_no,$colour,$computer_design_no)
	
	{
	
		$status_id			   		=	mysql_real_escape_string(trim($status_id));
		$order_id	        		=	trim($order_id);
		$design_no			   		= mysql_real_escape_string(trim($design_no));
		$store_managerId			=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       		=	mysql_real_escape_string(trim($employeeId));
		$status			 			=	mysql_real_escape_string(trim($status));
		$quantity			 		=	mysql_real_escape_string(trim($quantity));
		$remarks		   			=	mysql_real_escape_string(trim($remarks));
		$order_date					=	mysql_real_escape_string(trim($order_date));
		$target_date				=	mysql_real_escape_string(trim($target_date));
		$modified_by				=	mysql_real_escape_string(trim($modified_by));
	    $complete					=	mysql_real_escape_string(trim($complete));
		$final_result				=	mysql_real_escape_string(trim($final_result));
		$bill_no					=	mysql_real_escape_string(trim($bill_no));
	    $colour						=	mysql_real_escape_string(trim($colour));
		$computer_design_no			=	mysql_real_escape_string(trim($computer_design_no));
		//statement
		$sql	= "UPDATE computer_table SET
				status_id						    	=  '$status_id',			
				order_id				            	=	'$order_id',	
				design_no						    	=  '$design_no',			
				store_managerId				            =	'$store_managerId',	
				employeeId						    	=  '$employeeId',			
				status				             		=	'$status',	
				quantity						     	=  '$quantity',			
				remarks				            	 	=	'$remarks',	
				order_date						    	=  '$order_date',
				target_date						    	=  '$target_date',
				modified_by						    	=  '$modified_by',
				modified_on							 	=   now(),
				complete							 	=   '$complete',
				final_result							=   '$final_result',
				bill_no							 		=   '$bill_no',
				colour							 		=   '$colour',
				computer_design_no						=   '$computer_design_no'
				WHERE
			    computer_id			      			 =  '$mid'
				";
				 
				 
		//echo $sql.mysql_error();exit;	
		//execute query
		$query	= mysql_query($sql);
		
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
		
	}//eof
	

	function editComputerstatus($computer_id,$status)
	{
		$status			 =	mysql_real_escape_string(trim($status));
		$sql	= "UPDATE computer_table SET
			final_result		 =  '$status'
			WHERE
			    computer_id	 =  '$computer_id'
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
	
	// Computer Display bill no. wise
	/*	
	*	bid 	= 			Bill No.
	*/	
	 public function disCompStatBillWise($bid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM computer_table where bill_no = '$bid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 // Display computer status bill no. wise
	 public function getcomStatBillWorkType($billNo,$comp_type){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM computer_table where bill_no = '$billNo' 
	 AND comp_type = '$comp_type'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	 // Display computer status bill no. wise and employee wise
	 public function getcomStatBillEmpWise($billNo,$comp_type){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM computer_table where bill_no = '$billNo' 
	 AND comp_type = '$comp_type' GROUP BY employeeId") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	 
	 // Display computer status bill no. wise
	 public function getcomStatBillWorkInHouse($billNo,$comp_type,$employeeId){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM computer_table where bill_no = '$billNo' 
	 AND comp_type = '$comp_type' AND employeeId ='$employeeId'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	
	// Computer Display bill no. order wise
	/*	
	*	bid 	= 			Bill No.
	*/	
	 public function disCompStatOrdWise($bid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM computer_table where bill_no = '$bid' group by order_id ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	 public function GetCompData($oid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM computer_table where order_id='$oid' GROUP BY  final_result") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	public function GetCompDataDwise($design_no){
	//echo $design_no;exit;
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM computer_table where design_no='$design_no' AND quantity != '0.00'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
	// echo $res.mysql_error();exit;
     return $temp_arr;  
     }
	
	// Billing Name wise Stitch due list
	 public function GetCompDueBillinNameWise($employeeId,$factory_id){
	//echo $employeeId;exit;
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM computer_table where employeeId='$employeeId' AND factory_id ='$factory_id' AND quantity != '0.00'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
	// echo $res.mysql_error();exit;
     return $temp_arr;  
     }
	 
	/* Display Computer table All data */
	/*
	*/
	 public function getAllCompDatadwise($employeeId,$factory_id,$todate,$fromdate){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM computer_table WHERE employeeId='$employeeId' AND factory_id ='$factory_id' AND
	 added_on between '$todate' and '$fromdate' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }  
	 
	  
	 
	#####################################################################################################
	#
	#										Display  Computer  details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$mid		dhmckfip id
	*
	*	@return array				
	*/
	function showProductComputer($mid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM computer_table
				   WHERE computer_id	= '$mid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->computer_id,			//0
					$result->status_id,				//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,		//4
					$result->employeeId,			//5
					$result->status,				//6
					$result->quantity,				//7
					$result->remarks,				//8
					$result->order_date,			//9
					$result->target_date,			//10
					$result->added_on,				//11
					$result->added_by,				//12
					$result->modified_on,			//13
					$result->modified_by,			//14
					$result->complete,				//15
					$result->final_result,			//16
					$result->bill_no,				//17
					$result->colour,				//18
					$result->computer_design_no,	//19
					$result->comp_type,				//20
					$result->additional,			//21
					$result->marea,					//22
					$result->stich_rate				//23
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllComputer($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT computer_id FROM computer_table where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT computer_id FROM computer_table where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['computer_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllComputerComp($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT computer_id FROM computer_table where store_managerId='$eid' AND quantity !='0.00'";
		}
		else
		{
			//statement
			$select	= "SELECT computer_id FROM computer_table where store_managerId='$eid' AND quantity !='0.00'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['computer_id'];
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
	function getAllComputerAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT computer_id FROM computer_table";
		}
		else
		{
			//statement
			$select	= "SELECT computer_id FROM computer_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['computer_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	#####################################################################################################
	#
	#										Add To KaliCut table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to hand_table in hand table.
	*
	*	@param
	*			$dhmckfip				product manufacture Id
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function addStasKaliCut($status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$bill_no,$particulars,$quantity,$remarks,$order_date,$target_date, $added_by)
	
	{
		//$dhmckfip			   =	mysql_real_escape_string(trim($dhmckfip));
		$status_id			   =	mysql_real_escape_string(trim($status_id));
		$order_id	        =	trim($order_id);
		$design_no			   = mysql_real_escape_string(trim($design_no));
		$store_managerId			   =	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       =	mysql_real_escape_string(trim($employeeId));
		$status			 =	mysql_real_escape_string(trim($status));
		$bill_no			   =	mysql_real_escape_string(trim($bill_no));
		$particulars		       =	mysql_real_escape_string(trim($particulars));
		$quantity			 =	mysql_real_escape_string(trim($quantity));
		$remarks		   =	mysql_real_escape_string(trim($remarks));
		$order_date			=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$added_by			=	mysql_real_escape_string(trim($added_by));



		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO kalicut_table
						(status_id, order_id, design_no, store_managerId, employeeId, status,
						bill_no,particulars,quantity,remarks,order_date,target_date,added_on, added_by)
							
						VALUES
						('$status_id', '$order_id', '$design_no', '$store_managerId', '$employeeId','$status','$bill_no','$particulars','$quantity', 
							'$remarks','$order_date','$target_date',now(), '$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$kalicut_id	= mysql_insert_id();
		
		//return primary key
		return $kalicut_id;

	}//eof
	
	
	/*-----------------------------Edit Kalicut------------------------------------------------------------*/

/**
	*	Edit  Kalicut status  in kalicut_table table.
	*
	*	@param
	*			
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function editKalicut($mid,$status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$quantity,$remarks,$order_date,$target_date, $modified_by,
	 $complete,$final_result)
	
	{
	
		$status_id			   =	mysql_real_escape_string(trim($status_id));
		$order_id	        =	trim($order_id);
		$design_no			   = mysql_real_escape_string(trim($design_no));
		$store_managerId			   =	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       =	mysql_real_escape_string(trim($employeeId));
		$status			 =	mysql_real_escape_string(trim($status));
		$quantity			 =	mysql_real_escape_string(trim($quantity));
		$remarks		   =	mysql_real_escape_string(trim($remarks));
		$order_date			=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));
	    $complete			=	mysql_real_escape_string(trim($complete));
		$final_result			=	mysql_real_escape_string(trim($final_result));
		//statement
		$sql	= "UPDATE kalicut_table SET
				status_id						    		 =  '$status_id',			
				order_id				            	 =	'$order_id',	
				design_no						    	 =  '$design_no',			
				store_managerId				            	 =	'$store_managerId',	
				employeeId						    	 =  '$employeeId',			
				status				             =	'$status',	
				quantity						     =  '$quantity',			
				remarks				            	 =	'$remarks',	
				order_date						    		 =  '$order_date',
				target_date						    		 =  '$target_date',
				modified_by						    		 =  '$modified_by',
				modified_on							 		 =   now(),
				complete							 		 =   '$complete',
				final_result							 		 =   '$final_result'
				WHERE
			    kalicut_id			      			 =  '$mid'
				";
				 
				 
			
		//execute query
		$query	= mysql_query($sql);
		
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
		
	}//eof
	
	
	function editKalistatus($kalicut_id,$status)
	{
		$status			 =	mysql_real_escape_string(trim($status));
		$sql	= "UPDATE kalicut_table SET
			final_result		 =  '$status'
			WHERE
			    kalicut_id	 =  '$kalicut_id'
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
	
	
	#####################################################################################################
	#
	#										Display  KaliCut  details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$mid		dhmckfip id
	*
	*	@return array				
	*/
	function showProductKaliCut($mid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM kalicut_table
				   WHERE kalicut_id	= '$mid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->kalicut_id,		//	0
					$result->status_id,		//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,			//4
					$result->employeeId,	//5
					$result->status,	//6
					$result->quantity,		//7
					$result->remarks,		//8
					$result->order_date,//9
					$result->target_date,	//10
					$result->added_on,		//11
					$result->added_by,	//12
					$result->modified_on,	//13
					$result->modified_by,	//14
					$result->complete,	//15
					$result->final_result,	//16
					$result->bill_no,	//17
					$result->particulars	//18
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	

	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllKaliCut($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT kalicut_id FROM kalicut_table where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT kalicut_id FROM kalicut_table where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['kalicut_id'];
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
	function getAllKaliCutAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT kalicut_id FROM kalicut_table";
		}
		else
		{
			//statement
			$select	= "SELECT kalicut_id FROM kalicut_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['kalicut_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	#####################################################################################################
	#
	#										Add To Final Stiching table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to hand_table in hand table.
	*
	*	@param
	*			$dhmckfip				product manufacture Id
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function addStasFinal($status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$bill_no,
	$colour,$quantity,$particular,$material_name,$material_amount,$others_cost,$remarks,$order_date,$target_date, $added_by)
	
	{
		//$dhmckfip			   	=	mysql_real_escape_string(trim($dhmckfip));
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	= mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$status			 		=	mysql_real_escape_string(trim($status));
		$bill_no		       	=	mysql_real_escape_string(trim($bill_no));
		$colour					=	mysql_real_escape_string(trim($colour));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		$particular			 	=	mysql_real_escape_string(trim($particular));
		$material_name		    =	mysql_real_escape_string(trim($material_name));
		$material_amount		=	'0.0';
		$others_cost			=	'0.0';
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		$modified_on			=	mysql_real_escape_string(trim($order_date));
		$modified_by				=	mysql_real_escape_string(trim($added_by));
		$complete				=	'';
		$final_result				=	'';
		$factory_id				= 0;
		//echo $particular_name; exit;
		//satement to insert in stock table
		$insert		=   "INSERT INTO final_stich
						(status_id, order_id, design_no, store_managerId, employeeId, status,bill_no,colour,
						quantity,particular,material_name,material_amount,others_cost,remarks,order_date,target_date,complete,added_on, added_by,modified_on,modified_by,final_result,factory_id)
							
						VALUES
						('$status_id', '$order_id', '$design_no', '$store_managerId', '$employeeId','$status','$bill_no',
						'$colour','$quantity','$particular','$material_name', '$material_amount','$others_cost',
							'$remarks','$order_date','$target_date','$complete',now(), '$added_by','$modified_on','$modified_by','$final_result','$factory_id')
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$final_stich_id	= mysql_insert_id();
		
		//return primary key
		return $final_stich_id;

	}//eof
	
	
	// add final stich bill no.
	
	function addFinalStichBill($final_stich_id,$bill_no)
	
	{
		//$dhmckfip			   =	mysql_real_escape_string(trim($dhmckfip));
		$final_stich_id			   =	mysql_real_escape_string(trim($final_stich_id));
		$bill_no			       = mysql_real_escape_string(trim($bill_no));
		
		//echo $particular_name; exit;

		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO final_stich_bill
						(final_stich_id, bill_no, added_on)
							
						VALUES
						('$final_stich_id', '$bill_no',now())
							
						";
					
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$id	= mysql_insert_id();
		
		//return primary key
		return $id;

	}//eof
	
	
	/*-----------------------------Edit final_stich------------------------------------------------------------*/

/**
	*	Edit  final_stich status  in final_stich table.
	*
	*	@param
	*			
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function editFinalStich($mid,$status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$quantity,
	$remarks,$order_date,$target_date, $modified_by,$complete,$final_result)
	{
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	= 	mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$status			 		=	mysql_real_escape_string(trim($status));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));
	    $complete				=	mysql_real_escape_string(trim($complete));
		$final_result			=	mysql_real_escape_string(trim($final_result));
		//statement
		$sql	= "UPDATE final_stich SET
				status_id						    	=  '$status_id',			
				order_id				            	=	'$order_id',	
				design_no						    	=  '$design_no',			
				store_managerId				            =	'$store_managerId',	
				employeeId						    	=  '$employeeId',			
				status				             		=	'$status',	
				quantity						     	=  '$quantity',			
				remarks				            	 	=	'$remarks',	
				order_date						    	=  '$order_date',
				target_date						    	=  '$target_date',
				modified_by						    	=  '$modified_by',
				modified_on							 	=   now(),
				complete							 	=   '$complete',
				final_result							=   '$final_result'
				WHERE
			    final_stich_id			      			 =  '$mid'
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
		
	}//eof
	
	function editFinalStichDtl($mid,$employeeId,$bill_no,$particular,$quantity,$complete,$order_date,$target_date)
	{
		$employeeId		      	 	=	mysql_real_escape_string(trim($employeeId));
		$quantity			 		=	mysql_real_escape_string(trim($quantity));
		$order_date					=	mysql_real_escape_string(trim($order_date));
		$target_date				=	mysql_real_escape_string(trim($target_date));
		$bill_no		       		=	mysql_real_escape_string(trim($bill_no));
		$particular					=	mysql_real_escape_string(trim($particular));
		$complete					=	mysql_real_escape_string(trim($complete));
		//statement
		$sql	= "UPDATE final_stich SET
				employeeId						    	 		=  '$employeeId',			
				quantity						     			=  '$quantity',			
				order_date						    		 	=  '$order_date',
				target_date						    		 	=  '$target_date',
				bill_no						     				=  '$bill_no',			
				particular						    		 	=  '$particular',
				complete						    			=  '$complete',
				modified_on							 		 	=   now()
				WHERE
			    final_stich_id			      			 =  '$mid'
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
		
	}//eof
	

	
	function editFinalstichstatus($final_stich_id,$status)
	{
		$status			 =	mysql_real_escape_string(trim($status));
		$sql	= "UPDATE final_stich SET
			final_result		 =  '$status'
			WHERE
			    final_stich_id	 =  '$final_stich_id'
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
	
	// Stitch colour change
	function editFStitchColor($final_stich_id,$colour)
	{
		$colour			 =	mysql_real_escape_string(trim($colour));
		$sql			 = "UPDATE final_stich SET
			colour		 =  '$colour'
			WHERE
			    final_stich_id	 =  '$final_stich_id'
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
	
	// Stitch Particular change
	function editFStitchParticular($final_stich_id,$particular)
	{
		$particular			 	=	mysql_real_escape_string(trim($particular));
		$sql			 		= "UPDATE final_stich SET
			particular		 	=  '$particular'
			WHERE
			    final_stich_id	 =  '$final_stich_id'
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
	#####################################################################################################
	#
	#										Display  Final Stiching  details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$mid		dhmckfip id
	*
	*	@return array				
	*/
	function showProductFinalStich($mid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM final_stich
				   WHERE final_stich_id	= '$mid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->final_stich_id,		//0
					$result->status_id,				//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,		//4
					$result->employeeId,			//5
					$result->status,				//6
					$result->quantity,				//7
					$result->remarks,				//8
					$result->order_date,			//9
					$result->target_date,			//10
					$result->added_on,				//11
					$result->added_by,				//12
					$result->modified_on,			//13
					$result->modified_by,			//14
					$result->complete,				//15
					$result->final_result,			//16
					$result->bill_no,				//17
					$result->colour,				//18
					$result->particular				//19


					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	function showPStatusPrStatusId($pstatusid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM final_stich
				   WHERE status_id	= '$pstatusid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->final_stich_id,		//	0
					$result->status_id,		//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,			//4
					$result->employeeId,	//5
					$result->status,	//6
					$result->quantity,		//7
					$result->remarks,		//8
					$result->order_date,//9
					$result->target_date,	//10
					$result->added_on,		//11
					$result->added_by,	//12
					$result->modified_on,	//13
					$result->modified_by,	//14
					$result->complete,	//15
					$result->final_result,	//16
					$result->bill_no,	//17
					$result->colour	//18

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$mid		dhmckfip id
	*
	*	@return array				
	*/
	function showProdFStichNotComp($mid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM final_stich
				   WHERE final_stich_id	= '$mid' AND final_result !='Complete'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->final_stich_id,		//0
					$result->status_id,				//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,		//4
					$result->employeeId,			//5
					$result->status,				//6
					$result->quantity,				//7
					$result->remarks,				//8
					$result->order_date,			//9
					$result->target_date,			//10
					$result->added_on,				//11
					$result->added_by,				//12
					$result->modified_on,			//13
					$result->modified_by,			//14
					$result->complete,				//15
					$result->final_result,			//16
					$result->bill_no,				//17
					$result->colour,				//18
					$result->particular				//19


					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	// All Final Stitching Data
	public function GetallpLineData($order_id,$table){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." where order_id='$order_id'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// All Running Stitching Data
	public function getDueStitchPrd($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM final_stich where factory_id ='$factory_id' AND final_result !='Complete' order by added_on DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllFinalStich($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT final_stich_id FROM final_stich where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT final_stich_id FROM final_stich where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['final_stich_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllFinalStichDWN($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT final_stich_id FROM final_stich where store_managerId='$eid' AND final_result !='Complete'";
		}
		else
		{
			//statement
			$select	= "SELECT final_stich_id FROM final_stich where store_managerId='$eid' AND final_result !='Complete'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['final_stich_id'];
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
	function getAllFinalStichAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT final_stich_id FROM final_stich";
		}
		else
		{
			//statement
			$select	= "SELECT final_stich_id FROM final_stich
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['final_stich_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	// display final stich bill
	function showFinalStichBill($final_stich_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM final_stich_bill
				   WHERE final_stich_id	= '$final_stich_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,		//	0
					$result->final_stich_id,		//1
					$result->bill_no,				//2
					$result->added_on				//3
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	 public function GetFinalStichBill($final_sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM final_stich_bill where final_stich_id='$final_sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
/*-----------------------------------Final stich details-------------------------------------------------*/
function addFinalStichDtl($final_stich_id,$design_no,$emp_id,$emp_name,$particular,$amount,$work_price,$p_status,$added_on)
	
	{
		$final_stich_id			   =	mysql_real_escape_string(trim($final_stich_id));
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		$emp_id			   =	mysql_real_escape_string(trim($emp_id));
		$emp_name			   =	mysql_real_escape_string(trim($emp_name));
		$particular			   =	mysql_real_escape_string(trim($particular));
		$amount	        =	trim($amount);
		$work_price	        =	trim($work_price);
		$p_status			   =	mysql_real_escape_string(trim($p_status));
		//satement to insert in stock table
		$insert		=   "INSERT INTO final_stich_details
						(final_stich_id,design_no,emp_id,emp_name,particular, amount,work_price,p_status,added_on)
							
						VALUES
						('$final_stich_id','$design_no','$emp_id','$emp_name','$particular', '$amount','$work_price','$p_status',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$final_stich_dtlid	= mysql_insert_id();
		
		//return primary key
		return $final_stich_dtlid;

	}//eof

	
/*-----------------------------------Final stich details edit-------------------------------------------------*/
function editFinalStichPayStatus($emp_id)
	
	{
		//$final_stich_id			   =	mysql_real_escape_string(trim($final_stich_id));
		//$design_no			   =	mysql_real_escape_string(trim($design_no));
		$emp_id			   =	mysql_real_escape_string(trim($emp_id));
		//$emp_name			   =	mysql_real_escape_string(trim($emp_name));
		//$particular			   =	mysql_real_escape_string(trim($particular));
		//$amount	        =	trim($amount);
		//$work_price	        =	trim($work_price);
		//$p_status			   =	mysql_real_escape_string(trim($p_status));
		//statement
		$sql	= "UPDATE final_stich_details SET
				p_status							 		 =   'paid',
				modified_on							 		 =   now()
				WHERE
			    emp_id			      			 =  '$emp_id' AND p_status = 'unpaid'
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
		
	}//eof

	
	function editFinStichDtl($final_stich_dtlid,$emp_id,$emp_name,$particular,$amount,$work_price)
	
	{
		$final_stich_dtlid			   =	mysql_real_escape_string(trim($final_stich_dtlid));
		$emp_id			  			   =	mysql_real_escape_string(trim($emp_id));
		$emp_name					   =	mysql_real_escape_string(trim($emp_name));
		$particular			  		   =	mysql_real_escape_string(trim($particular));
		$amount			  			   =	mysql_real_escape_string(trim($amount));
		$work_price	       			   =	trim($work_price);
		//$work_price	        =	trim($work_price);
		//$p_status			   =	mysql_real_escape_string(trim($p_status));
		//statement
		$sql	= "UPDATE final_stich_details SET
				emp_id							 		 	 =  '$emp_id',
				emp_name							 		 =  '$emp_name',
				particular							 		 =  '$particular',
				amount							 			 =  '$amount',
				work_price							 		 =  '$work_price',
				modified_on							 		 =   now()
				WHERE
			    final_stich_dtlid			      			 =  '$final_stich_dtlid' 
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
		
	}//eof
	
	
	
	
	
	

	/**
	*	Get the data associated with a final stich details based upon the primary key
	*
	*	@param
	*			$fsdid		final_stichdtl id
	*
	*	@return array				
	*/
	function showProductFinalStichDtl($fsdid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM final_stich_details
				   WHERE final_stich_dtlid	= '$fsdid' ";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->final_stich_dtlid,		//	0
					$result->final_stich_id,		//1
					$result->design_no,				//2
					$result->emp_name,			//3
					$result->particular,	//4
					$result->amount,	//5
					$result->work_price,		//6
					$result->added_on,		//7
					$result->emp_id,			//8
					$result->p_status			//9
					);
		}
		
		//return the data
		return $data;
		
	}//eof
		
	
// Display the records  
   public function showFinalStichReceipt($lid){
   
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM final_stich_details where p_status = 'unpaid' AND emp_id = '$lid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
     
	 public function GetFinalStichDtl($final_sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM final_stich_details where final_stich_id='$final_sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Final Stitch in display design no wise
	// $design_no 		= Design No
	public function getStitchDtlsDesignWise($design_no,$todate,$fromdate){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM final_stich_details where design_no ='$design_no' AND
	 added_on between '$todate' and '$fromdate'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllFinalStichdtl($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT final_stich_dtlid FROM final_stich_details where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT final_stich_dtlid FROM final_stich_details where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);
		
		//echo $query.mysql_error();exit;
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['final_stich_dtlid'];
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
	function getAllFinalStichDtlAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT final_stich_dtlid FROM final_stich_details";
		}
		else
		{
			//statement
			$select	= "SELECT final_stich_dtlid FROM final_stich_details
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['final_stich_dtlid'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
/**
	*	This function will delete a product in permanently
	*
	*	@param
	*			$sid			product in id
	*
	*	@return null
	*/
	function delFinalStichingDtl($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM final_stich_details WHERE final_stich_dtlid='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		//echo $query1.mysql_error();exit;
	}//eof

	
	
	#####################################################################################################
	#
	#										Add To Iron table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to hand_table in hand table.
	*
	*	@param
	*			$dhmckfip				product manufacture Id
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function addStasIron($status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$bill_no,$quantity,$remarks,$order_date,$target_date, $added_by)
	
	{
		//$dhmckfip			   =	mysql_real_escape_string(trim($dhmckfip));
		$status_id			   =	mysql_real_escape_string(trim($status_id));
		$order_id	        =	trim($order_id);
		$design_no			   = mysql_real_escape_string(trim($design_no));
		$store_managerId			   =	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       =	mysql_real_escape_string(trim($employeeId));
		$status			 =	mysql_real_escape_string(trim($status));
		$quantity			 =	mysql_real_escape_string(trim($quantity));
		$remarks		   =	mysql_real_escape_string(trim($remarks));
		$order_date			=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$added_by			=	mysql_real_escape_string(trim($added_by));



		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO iron_table
						(status_id, order_id, design_no, store_managerId, employeeId, status,bill_no,quantity,remarks,order_date,target_date,added_on, added_by)
							
						VALUES
						('$status_id', '$order_id', '$design_no', '$store_managerId', '$employeeId','$status','$bill_no','$quantity', 
							'$remarks','$order_date','$target_date',now(), '$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$iron_id	= mysql_insert_id();
		
		//return primary key
		return $iron_id;

	}//eof
	
	
	/*-----------------------------Edit iron_table------------------------------------------------------------*/

/**
	*	Edit  iron_table status  in iron_table table.
	*
	*	@param
	*			
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function editIron($mid,$status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$quantity,$remarks,$order_date,$target_date, $modified_by,
	 $complete,$final_result)
	
	{
	
		$status_id			   =	mysql_real_escape_string(trim($status_id));
		$order_id	        =	trim($order_id);
		$design_no			   = mysql_real_escape_string(trim($design_no));
		$store_managerId			   =	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       =	mysql_real_escape_string(trim($employeeId));
		$status			 =	mysql_real_escape_string(trim($status));
		$quantity			 =	mysql_real_escape_string(trim($quantity));
		$remarks		   =	mysql_real_escape_string(trim($remarks));
		$order_date			=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));
	    $complete			=	mysql_real_escape_string(trim($complete));
		$final_result			=	mysql_real_escape_string(trim($final_result));
		//statement
		$sql	= "UPDATE iron_table SET
				status_id						    		 =  '$status_id',			
				order_id				            	 =	'$order_id',	
				design_no						    	 =  '$design_no',			
				store_managerId				            	 =	'$store_managerId',	
				employeeId						    	 =  '$employeeId',			
				status				             =	'$status',	
				quantity						     =  '$quantity',			
				remarks				            	 =	'$remarks',	
				order_date						    		 =  '$order_date',
				target_date						    		 =  '$target_date',
				modified_by						    		 =  '$modified_by',
				modified_on							 		 =   now(),
				complete							 		 =   '$complete',
				final_result							 		 =   '$final_result'
				WHERE
			    iron_id			      			 =  '$mid'
				";
				 
				 
			
		//execute query
		$query	= mysql_query($sql);
		
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
		
	}//eof
	
	
	function editIronstatus($iron_id,$status)
	{
		$status			 =	mysql_real_escape_string(trim($status));
		$sql	= "UPDATE iron_table SET
			final_result		 =  '$status'
			WHERE
			    iron_id	 =  '$iron_id'
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
	
	
	

	#####################################################################################################
	#
	#										Display  Final iron   details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$mid		dhmckfip id
	*
	*	@return array				
	*/
	function showProductIron($mid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM iron_table
				   WHERE iron_id	= '$mid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->iron_id,		//	0
					$result->status_id,		//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,			//4
					$result->employeeId,	//5
					$result->status,	//6
					$result->quantity,		//7
					$result->remarks,		//8
					$result->order_date,//9
					$result->target_date,	//10
					$result->added_on,		//11
					$result->added_by,	//12
					$result->modified_on,	//13
					$result->modified_by,	//14
					$result->complete,	//15
					$result->final_result,	//16
					$result->bill_no	//17

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	

	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllIron($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT iron_id FROM iron_table where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT iron_id FROM iron_table where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['iron_id'];
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
	function getAllIronAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT iron_id FROM iron_table";
		}
		else
		{
			//statement
			$select	= "SELECT iron_id FROM iron_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['iron_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	#####################################################################################################
	#
	#										Add To packing pending table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to hand_table in hand table.
	*
	*	@param
	*			$pp_id				packing pending Id
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$submit_date     		    	date
	*		
	*			
	*
	*	@return int
	*/
	function addPackingPending($status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$bill_no,$particular,$quantity,$final_result)
	
	{
		//$dhmckfip			   	=	mysql_real_escape_string(trim($dhmckfip));
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	= 	mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$status			 		=	mysql_real_escape_string(trim($status));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		$particular				=	mysql_real_escape_string(trim($particular));
		$final_result			=	mysql_real_escape_string(trim($final_result));



		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO packing_pending
						(status_id, order_id, design_no, store_managerId, employeeId, status,bill_no,particular,quantity,submit_date,added_on, added_by,final_result)
							
						VALUES
						('$status_id', '$order_id', '$design_no', '$store_managerId', '$employeeId','$status','$bill_no','$particular','$quantity', 
							now(),now(), '$added_by','$final_result')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$pp_id	= mysql_insert_id();
		
		//return primary key
		return $pp_id;

	}//eof
	
	
	/*
	*	This funcion will return all the  pp_id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPackingPending($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT pp_id FROM packing_pending where store_managerId='$eid'";
		}
		else
		{
			//statement
			$select	= "SELECT pp_id FROM packing_pending where store_managerId='$eid'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['pp_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										Display  Packing Pending   details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$pp_id		Packing Pending id
	*
	*	@return array				
	*/
	function showPackingPending($pp_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM packing_pending
				   WHERE pp_id	= '$pp_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->pp_id,		//	0
					$result->status_id,		//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,			//4
					$result->employeeId,	//5
					$result->status,	//6
					$result->quantity,		//7
					$result->submit_date,//8
					$result->added_on,		//9
					$result->added_by,	//10
					$result->modified_on,	//11
					$result->modified_by,	//12
					$result->particular,	//13
					$result->final_result,	//14
					$result->bill_no,	//15
					$result->comquantity,	//16
					$result->alterquantity	//17

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	/*
		* $ordid  	=	order id
		* $txtEmpid	= 	employee id
		* 
	
	*/
	function showPckpndbyCondition($ordid,$txtEmpid,$txtParticular)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM packing_pending
				   WHERE order_id	= '$ordid' AND employeeId	= '$txtEmpid' AND particular ='$txtParticular'";
				   
		//execute query
		$query	= mysql_query($select);	
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->pp_id,		//	0
					$result->status_id,		//1
					$result->order_id,				//2
					$result->design_no,				//3
					$result->store_managerId,			//4
					$result->employeeId,	//5
					$result->status,	//6
					$result->quantity,		//7
					$result->submit_date,//8
					$result->added_on,		//9
					$result->added_by,	//10
					$result->modified_on,	//11
					$result->modified_by,	//12
					$result->particular,	//13
					$result->final_result,	//14
					$result->bill_no,	//15
					$result->comquantity,	//16
					$result->alterquantity	//17

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										Add To Packing table
	#
	#####################################################################################################
	
	/**
	*	Add a new design to hand_table in hand table.
	*
	*	@param
	*			$dhmckfip				product manufacture Id
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function addStasPacking($status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$bill_no,$quantity,$remarks,$order_date,$target_date, $added_by)
	
	{
		//$dhmckfip			   	=	mysql_real_escape_string(trim($dhmckfip));
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	= 	mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$status			 		=	mysql_real_escape_string(trim($status));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$added_by				=	mysql_real_escape_string(trim($added_by));



		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO packing_table
						(status_id, order_id, design_no, store_managerId, employeeId, status,bill_no,quantity,remarks,order_date,target_date,added_on, added_by)
							
						VALUES
						('$status_id', '$order_id', '$design_no', '$store_managerId', '$employeeId','$status','$bill_no','$quantity', 
							'$remarks','$order_date','$target_date',now(), '$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the status id
		$packing_id	= mysql_insert_id();
		
		//return primary key
		return $packing_id;

	}//eof
	
	/*-----------------------------Edit packing_table------------------------------------------------------------*/

/**
	*	Edit  packing status  in packing_table .
	*
	*	@param
	*			
	*			$status_id			    status_id	
	*			$order_id			    order_id	
	*			$design_no				Design no of  products
	*			$store_managerId			    Store manager
	*			$employeeId				employee code
	*			$status					product status
	*			$quantity				number of product
	*			$remarks					Remark
	*			$order_date     		    	date
	*			$target_date     		 product submission date
	*		
	*			
	*
	*	@return int
	*/
	function editPacking($mid,$status_id,$order_id, $design_no,$store_managerId, $employeeId, $status,$quantity,$remarks,$order_date,$target_date, $modified_by,
	 $complete,$final_result)
	
	{
	
		$status_id			   	=	mysql_real_escape_string(trim($status_id));
		$order_id	        	=	trim($order_id);
		$design_no			   	= mysql_real_escape_string(trim($design_no));
		$store_managerId		=	mysql_real_escape_string(trim($store_managerId));
		$employeeId		       	=	mysql_real_escape_string(trim($employeeId));
		$status			 		=	mysql_real_escape_string(trim($status));
		$quantity			 	=	mysql_real_escape_string(trim($quantity));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$order_date				=	mysql_real_escape_string(trim($order_date));
		$target_date			=	mysql_real_escape_string(trim($target_date));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));
	    $complete				=	mysql_real_escape_string(trim($complete));
		$final_result			=	mysql_real_escape_string(trim($final_result));
		//statement
		$sql	= "UPDATE packing_table SET
				status_id						    		 =  '$status_id',			
				order_id				            	 =	'$order_id',	
				design_no						    	 =  '$design_no',			
				store_managerId				            	 =	'$store_managerId',	
				employeeId						    	 =  '$employeeId',			
				status				             =	'$status',	
				quantity						     =  '$quantity',			
				remarks				            	 =	'$remarks',	
				order_date						    		 =  '$order_date',
				target_date						    		 =  '$target_date',
				modified_by						    		 =  '$modified_by',
				modified_on							 		 =   now(),
				complete							 		 =   '$complete',
				final_result							 		 =   '$final_result'
				WHERE
			    packing_id			      			 =  '$mid'
				";
				 
				 
			
		//execute query
		$query	= mysql_query($sql);
		
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
		
	}//eof

	
	function editPackingstatus($packing_id,$status)
	{
		$status			 =	mysql_real_escape_string(trim($status));
		$sql	= "UPDATE packing_table SET
			final_result		 =  '$status'
			WHERE
			    packing_id	 =  '$packing_id'
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
	
	
	// Update Packing Quantity of packing table.
	function updatePackingQuan($order_id,$no_of_particular)
	{
		$status			 =	mysql_real_escape_string(trim($status));
		$sql	= "UPDATE packing_table SET
			no_of_particular	 =  '$no_of_particular'
			WHERE
			    order_id	 =  '$order_id'
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
	
	// Update Packing Quantity of packing table.
	function updatePackingPendingStatus($quantity,$final_result)
	{
		$final_result			 =	mysql_real_escape_string(trim($final_result));
		$sql	= "UPDATE packing_pending SET
			final_result	 =  '$final_result'
			WHERE
			    quantity	 =  0
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
	
	// Update Final stitching  table.
	function updateFSstatus($complete,$final_result)
	{
		$final_result			 =	mysql_real_escape_string(trim($final_result));
		$sql	= "UPDATE final_stich SET
			final_result	 =  '$final_result'
			WHERE
			    complete	 =  '$complete'
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
	
	

	#####################################################################################################
	#
	#										Display  packing   details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a product Status based upon the primary key
	*
	*	@param
	*			$mid		dhmckfip id
	*
	*	@return array				
	*/
	function showProductPaking($mid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM packing_table
				   WHERE packing_id	= '$mid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->packing_id,		//	0
					$result->status_id,			//1
					$result->order_id,			//2
					$result->design_no,			//3
					$result->store_managerId,	//4
					$result->employeeId,		//5
					$result->status,			//6
					$result->quantity,			//7
					$result->remarks,			//8
					$result->order_date,		//9
					$result->target_date,		//10
					$result->added_on,			//11
					$result->added_by,			//12
					$result->modified_on,		//13
					$result->modified_by,		//14
					$result->complete,			//15
					$result->final_result,		//16
					$result->bill_no,			//17
					$result->no_of_particular,	//18
					$result->add_to_stock	//19
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	function showProductPakingbyord($mid)
	{
		//echo $mid;exit;
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM packing_table
				   WHERE order_id	= '$mid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->packing_id,		//0
					$result->status_id,			//1
					$result->order_id,			//2
					$result->design_no,			//3
					$result->store_managerId,	//4
					$result->employeeId,		//5
					$result->status,			//6
					$result->quantity,			//7
					$result->remarks,			//8
					$result->order_date,		//9
					$result->target_date,		//10
					$result->added_on,			//11
					$result->added_by,			//12
					$result->modified_on,		//13
					$result->modified_by,		//14
					$result->complete,			//15
					$result->final_result,		//16
					$result->bill_no,			//17
					$result->no_of_particular	//18
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the  dhmckfip
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPaking($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT packing_id FROM packing_table where store_managerId='$eid' AND order_date > '2016-06-01'";
		}
		else
		{
			//statement
			$select	= "SELECT packing_id FROM packing_table where store_managerId='$eid' AND order_date > '2016-06-01'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['packing_id'];
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
	function getAllPakingAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT packing_id FROM packing_table";
		}
		else
		{
			//statement
			$select	= "SELECT packing_id FROM packing_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['packing_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/* Display all packing data */
	/*
	*/
	 public function getPackProdDtls($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM packing_table where factory_id='$factory_id' AND order_date > '2016-06-01'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	/* Display all packing data */
	/*
	*/
	 public function disPacking($ordid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM packing_table where order_id='$ordid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	/* 
		* Display all packing pending  data 
	/*
		* where $ordid , empid and particular match
		*	$ordid 		= order id
		*	$empid 		= employe id
		*	$particular = particular
	*/
	 public function cntPackingData($ordid ,$empid,$particular){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM packing_pending where order_id='$ordid' AND employeeId='$empid' AND particular='$particular'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	// update packing pending table
	function editPendingPacking($ordid ,$empid,$particular,$quantity,$prvEmpId,$prvPart)
	{
		$ordid				 =	mysql_real_escape_string(trim($ordid));
		$empid				 =	mysql_real_escape_string(trim($empid));
		$particular			 =	mysql_real_escape_string(trim($particular));
		$quantity			 =	mysql_real_escape_string(trim($quantity));
		$prvEmpId			 =	mysql_real_escape_string(trim($prvEmpId));
		$prvPart			 =	mysql_real_escape_string(trim($prvPart));
		
		$sql	= "UPDATE packing_pending SET
			quantity		 =  '$quantity',
			employeeId		 =  '$empid',
			particular		 =  '$particular'
			WHERE
			    order_id	 =  '$ordid' AND employeeId	 =  '$prvEmpId' AND particular	 =  '$prvPart'
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
	
	
	// update packing pending table
	function UpdatePpending($ordid ,$empid,$particular,$quantity)
	{
		$ordid				 =	mysql_real_escape_string(trim($ordid));
		$empid				 =	mysql_real_escape_string(trim($empid));
		$particular			 =	mysql_real_escape_string(trim($particular));
		$quantity			 =	mysql_real_escape_string(trim($quantity));
		
		$sql	= "UPDATE packing_pending SET
			quantity		 =  '$quantity',
			employeeId		 =  '$empid',
			particular		 =  '$particular'
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
	
	
	/**
	*	This function will Update packing Table Status permanently
	*
	*	@param
	*			$order_id 	= Order id			
	*	@return null
	*/
	//Update Billing Name
	function UpdatePLineST($order_id, $final_result,$table)
	{
		$order_id	           		=	trim($order_id);
		$final_result	           	=	trim($final_result);
		$table	        	   		=	trim($table);

		//update Sample db
		$edit  = "UPDATE ".$table."
				SET
				final_result			= '$final_result'
				WHERE
				order_id				= '$order_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof 
	
	
	/**
	*	This function will delete a pending packing permanently
	*
	*	@param
	*			$ppid			pending packing id
	*
	*	@return null
	*/
	function delPendingPacking($ppid)
	{
		
		
		
		//delete from product
		$delete1 = "DELETE FROM packing_pending WHERE pp_id='$ppid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		//echo $query1.mysql_error();exit;
	}//eof

	/**
	*	This function will Update Billing name permanently
	*
	*	@param
	*			$bid 	= Bill id			
	*	@return null
	*/
	//Update Billing Name
	function UpdatePBillingName($bid, $employeeId,$table)
	{
		$bid	           			=	trim($bid);
		$employeeId	           		=	trim($employeeId);
		$table	        	   		=	trim($table);

		//update Sample db
		$edit  = "UPDATE ".$table."
				SET
				employeeId			= '$employeeId'
				WHERE
				bill_no				= '$bid'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof 
	
	
	/**
	*	This function will Update Status Design no permanently
	*
	*	@param
	*			$order_id 	= Order id			
	*	@return null
	*/
	//Update Design no Name
	function editStatusDesign($order_id, $design_no,$table)
	{
		$order_id	           		=	trim($order_id);
		$design_no	           		=	trim($design_no);
		$table	        	   		=	trim($table);
		//update Sample db
		$edit  = "UPDATE ".$table."
				SET
				design_no			= '$design_no'
				WHERE
				order_id				= '$order_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof 
	
	 
}//eoc
		
?>		