<?php 
/**
*	This class is going to work with all Sample associated with a Sample details. 
*
*	@author		Safikul Islam
*	@date		May 12, 2015
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/




class Sample
{

	#####################################################################################################
	#
	#										Add To sample_db table
	#
	#####################################################################################################
	
	/**
	*	Add a new Sample records in sample_db table.
	*
	*	@param
	*			
	*			$sample_id			   	    sample identity code
	*			$emp_id						Employee id
	*			$factory_id					Factory Identification no.
	*			$design_no			     	Design identity number
	*			$total_time			   	    Total time
	*			$total_cost					Total cost
	*			$remarks			     	Remarks
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addSampleDb($emp_id,$factory_id,$design_no,$total_time,$total_cost, $remarks,$added_by)
	
	{
		$emp_id			  	   	   	=	mysql_real_escape_string(trim($emp_id));
		$factory_id			  	   	=	mysql_real_escape_string(trim($factory_id));
		$design_no			   		=	mysql_real_escape_string(trim($design_no));
		$total_time			  	   	=	mysql_real_escape_string(trim($total_time));
		$total_cost			   		=	mysql_real_escape_string(trim($total_cost));
		$remarks			       	=	mysql_real_escape_string(trim($remarks));
		$added_by			       	=	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_db
						(emp_id,factory_id,design_no,total_time,total_cost,remarks, added_on,added_by)
							
						VALUES
						('$emp_id','$factory_id','$design_no','$total_time','$total_cost','$remarks',now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sample_id	= mysql_insert_id();
		
		//return primary key
		return $sample_id;

	}//eof
	
	
	
	//Update Sample table
	function UpdateSamDb($sample_id, $total_time,$total_cost,$modified_by)
	{
		$total_time			   	   =	mysql_real_escape_string(trim($total_time));
		$total_cost	        	   =	trim($total_cost);
		$modified_by			   = mysql_real_escape_string(trim($modified_by));

		//update Sample db
		$edit  = "UPDATE sample_db
				SET
				total_time		 	= '$total_time',
				total_cost		 	= '$total_cost',
				modified_by			= '$modified_by',
				modified_on			= now()
				WHERE
				sample_id 			= '$sample_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	
	//Update Sample table designber
	function editSamDb($sample_id, $emp_id,$factory_id,$modified_by)
	{
		$emp_id			   	   		=	mysql_real_escape_string(trim($emp_id));
		$factory_id	        	   	=	trim($factory_id);
		$modified_by			   	= mysql_real_escape_string(trim($modified_by));

		//update Sample db
		$edit  = "UPDATE sample_db
				SET
				emp_id		 		= '$emp_id',
				factory_id		 	= '$factory_id',
				modified_by			= '$modified_by',
				modified_on			= now()
				WHERE
				sample_id 			= '$sample_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	#####################################################################################################
	#
	#										Display  sampe_db data
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Sample DB based upon the primary key
	*
	*	@param
	*			$sid		sample id
	*
	*	@return array				
	*/
	function showSampleDb($sid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_db
				   WHERE sample_id	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->sample_id,		//0
					$result->emp_id,		//1
					$result->factory_id,	//2
					$result->design_no,		//3
					$result->total_time,	//4
					$result->total_cost,	//5
					$result->remarks,		//6
					$result->added_on,		//7
					$result->added_by,		//8
					$result->modified_on,	//9
					$result->modified_by	//10
					
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
	function getAllSampDb($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT sample_id FROM sample_db";
		}
		else
		{
			//statement
			$select	= "SELECT sample_id FROM sample_db
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['sample_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	/**
	*	Display Sample records from sample_db table.
	*
	*	@param
	*			
	*/
	public function getAllSampleDb(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_db order by sample_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	/**
	*	Display Sample records from sample_db table empployee id wise.
	*
	*	@param
	*			
	*/
	public function getAllSampleDbRcd($emp_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_db WHERE emp_id = '$emp_id'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }	
	
	/**
	*	Add a new Sample Details records in sample_db_dtls table.
	*
	*	@param
	*			
	*			$sample_id			   	    sample identity code
	*			$emp_id						Employee id
	*			$designation				Employee Post
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addSampleDtls($sample_id,$emp_id,$designation,$added_by)
	
	{
		$sample_id			  	   	=	mysql_real_escape_string(trim($sample_id));
		$emp_id			  	   		=	mysql_real_escape_string(trim($emp_id));
		$designation			   	=	mysql_real_escape_string(trim($designation));
		$added_by			       	=	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_db_dtls
						(sample_id,emp_id,designation,added_on,added_by)
							
						VALUES
						('$sample_id','$emp_id','$designation',now(),'$added_by')
							
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sample_dtls_id	= mysql_insert_id();
		
		//return primary key
		return $sample_dtls_id;

	}//eof
		
	
	#####################################################################################################
	#
	#										Display  sample_db_dtls data
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a sample_db_dtls based upon the primary key
	*
	*	@param
	*			$sdid		sample details id
	*
	*	@return array				
	*/
	function showSampleDtls($sdid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_db_dtls
				   WHERE sample_dtls_id	= '$sdid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->sample_dtls_id,	//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->designation,		//3
					$result->added_on,		//4
					$result->added_by,		//5
					$result->modified_on,	//6
					$result->modified_by	//7
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Display Sample Details records from sample_db_dtls table.
	*
	*	@param
	*			
	*/
	public function getAllSampDtlsSamId($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_db_dtls where sample_id = '$sid' order by added_on desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	/**
	*	Display Sample Details records from sample_db_dtls table.
	*
	*	@param
	*			
	*/
	public function getAllSampleDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_db_dtls order by added_on desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	

	#####################################################################################################
	#
	#										Add To Sample table
	#
	#####################################################################################################
	
	/**
	*	Add a new Sample in Sample table.
	*
	*	@param
	*			
	*			$sample_id			   	    sample identity code
	*			$design_no					Design identity number
	*			$remarks			     	Remarks
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addSample($design_no,$labour_type, $remarks,$added_by)
	
	{
		$design_no			  	   =	mysql_real_escape_string(trim($design_no));
		$labour_type			   =	mysql_real_escape_string(trim($labour_type));
		$remarks			       =	mysql_real_escape_string(trim($remarks));
		$added_by			       =	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_table
						(design_no,labour_type,remarks, added_on,added_by)
							
						VALUES
						('$design_no','$labour_type','$remarks',now(),'$added_by')
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sample_id	= mysql_insert_id();
		
		//return primary key
		return $sample_id;

	}//eof
		
	
	

	#####################################################################################################
	#
	#										Delete sample from sample  table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a sample permanently
	*
	*	@param
	*			$sid			sample id
	*
	*	@return null
	*/
	function delSample($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM sample_table WHERE sample_id='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Sample details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Sample based upon the primary key
	*
	*	@param
	*			$sid		sample id
	*
	*	@return array				
	*/
	function showSample($sid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_table
				   WHERE sample_id	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->sample_id,					//0
					$result->design_no,							//1
					$result->remarks,					//2
					$result->added_on,		//3
					$result->added_by,		//4
					$result->modified_on,						//5
					$result->modified_by,						//6
					$result->labour_type						//7
					
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
	function getAllSample($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT sample_id FROM sample_table";
		}
		else
		{
			//statement
			$select	= "SELECT sample_id FROM sample_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['sample_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	/*===============================================	Sample colour  ================================================*/
	
	/**
	*	Sample Colour.
	*
	*	@param
	*			
	*			$colour_id			   	    colour identity code
	*			$sample_id			   	    sample identity code
	*			$colour_name				colour name
	*			$remarks			    	 remarks
	*		
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addColour($sample_id,$design_no,$fabric_name,$colour_name,$color_ratio,$color_ratio_value, $remarks,$added_by)
	
	{
		$sample_id			   =	mysql_real_escape_string(trim($sample_id));
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		$fabric_name		   =	mysql_real_escape_string(trim($fabric_name));
		$colour_name		   =	mysql_real_escape_string(trim($colour_name));
		$color_ratio		   =	mysql_real_escape_string(trim($color_ratio));
		$color_ratio_value	   =	mysql_real_escape_string(trim($color_ratio_value));
		$remarks			   =	mysql_real_escape_string(trim($remarks));
		$added_by			   =	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO colour_table
						(sample_id,design_no,fabric_name,colour_name,color_ratio,color_ratio_value,remarks, added_on,added_by)
							
						VALUES
						('$sample_id','$design_no','$fabric_name','$colour_name','$color_ratio','$color_ratio_value','$remarks',now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$colour_id	= mysql_insert_id();
		
		//return primary key
		return $colour_id;

	}//eof
	
/*================================ Display All Colour =============================================================*/	
	
	 
	 public function getAllcolourDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM colour_table where sample_id= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
		
	#####################################################################################################
	#
	#										Delete sample colour from colour  table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a colour permanently
	*
	*	@param
	*			$cid			colour id
	*
	*	@return null
	*/
	function delSampleColour($cid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM colour_table WHERE colour_id='$cid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Colour details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Colour based upon the primary key
	*
	*	@param
	*			$cid		colour id
	*
	*	@return array				
	*/
	function showColour($cid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM colour_table
				   WHERE colour_id	= '$cid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->colour_id,					//0
					$result->sample_id,					//1
					$result->design_no,			//2
					$result->colour_name,	//3			
					$result->remarks,		//4
					$result->added_on,		//5
					$result->added_by,		//6
					$result->modified_on,		//7
					$result->modified_by	//8
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	/*
	*	This funcion will return all the product colour id for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllColour($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT colour_id FROM colour_table";
		}
		else
		{
			//statement
			$select	= "SELECT colour_id FROM colour_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['colour_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										sample Fabric(Dyeing) 
	#
	#####################################################################################################
	/**
	*	Sample Fabric.
	*
	*	@param
	*			
	*			$fabric_id			   	    Fabric identity code
	*			$sample_id			   	    sample identity code
	*			$fabric_name				Fabric name
	*			$fab_amount					Fabric Amount
	*			$remarks			    	 remarks
	*		
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addSamFabric($sample_id,$design_no,$fabric_name,$fab_amount,$rate_per_meter,$labour_rate,$labour_cost,
	$others_cost,$total_cost,$total_time,$remarks,$added_by)
	
	{
		$sample_id			   	=	mysql_real_escape_string(trim($sample_id));
		$design_no			   	=	mysql_real_escape_string(trim($design_no));
		$fabric_name			=	mysql_real_escape_string(trim($fabric_name));
		$fab_amount			   	=	mysql_real_escape_string(trim($fab_amount));
		$rate_per_meter			=	mysql_real_escape_string(trim($rate_per_meter));
		$labour_rate			=	mysql_real_escape_string(trim($labour_rate));
		$labour_cost			=	mysql_real_escape_string(trim($labour_cost));
		$others_cost			=	mysql_real_escape_string(trim($others_cost));
		$total_cost				=	mysql_real_escape_string(trim($total_cost));
		$total_time				=	mysql_real_escape_string(trim($total_time));
		$remarks			   	=	mysql_real_escape_string(trim($remarks));
		$added_by			   	=	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_fabric
						(sample_id,design_no,fabric_name,fab_amount,rate_per_meter,labour_rate,labour_cost,others_cost,total_cost,
						total_time,remarks,added_by, added_on)
							
						VALUES
						('$sample_id','$design_no','$fabric_name','$fab_amount','$rate_per_meter','$labour_rate',
						'$labour_cost','$others_cost','$total_cost','$total_time','$remarks','$added_by',now())
							
						";	
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$fabric_id	= mysql_insert_id();
		
		//return primary key
		return $fabric_id;

	}//eof
	
	// Dyeing Materials Add
	function addSamDyeMaterial($fabric_id,$material_name,$material_amount,$mat_unit,$mat_rate,$mat_cost)
	
	{
		$fabric_id			   	=	mysql_real_escape_string(trim($fabric_id));
		$material_name			   	=	mysql_real_escape_string(trim($material_name));
		$material_amount			=	mysql_real_escape_string(trim($material_amount));
		$mat_unit			   	=	mysql_real_escape_string(trim($mat_unit));
		$mat_rate			=	mysql_real_escape_string(trim($mat_rate));
		$mat_cost			=	mysql_real_escape_string(trim($mat_cost));
		//satement to insert in sample_dye_materials table
		$insert		=   "INSERT INTO sample_dye_materials
						(fabric_id,material_name,material_amount,mat_unit,mat_rate,mat_cost)
							
						VALUES
						('$fabric_id','$material_name','$material_amount','$mat_unit','$mat_rate','$mat_cost')
							
						";
					
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sdm_id	= mysql_insert_id();
		
		//return primary key
		return $sdm_id;

	}//eof
	
	#####################################################################################################
	#
	#										Update sample Fabric Table
	#
	#####################################################################################################
		
	/**
	*	This function will Update a Sample fabric permanently
	*
	*	@param
	*			$fabric_id			fabric id
	*
	*	@return null
	*/
	
	//Update Sample Fabric
	function UpdateSamFabric($fabric_id, $total_cost)
	
	{
		$total_cost	        	   =	trim($total_cost);

		//update Sample db
		$edit  = "UPDATE sample_fabric
				SET
				total_cost		 	= '$total_cost'
				WHERE
				fabric_id 			= '$fabric_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	/**
	*	This function will Update a Sample fabric permanently
	*
	*	@param
	*			$fabric_id			fabric id
	*
	*	@return null
	*/
	
	//Update Sample Fabric Table
	function EditSamFabric($fabric_id, $fabric_name,$fab_amount,$rate_per_meter,$labour_rate,$labour_cost,$others_cost,$total_cost)
	
	{
		$fabric_name	        	   =	trim($fabric_name);
		$fab_amount	        	  	   =	trim($fab_amount);
		$rate_per_meter	        	   =	trim($rate_per_meter);
		$labour_rate	        	   =	trim($labour_rate);
		$labour_cost	        	   =	trim($labour_cost);
		$others_cost	        	   =	trim($others_cost);
		$total_cost	        	   	   =	trim($total_cost);
		//update Sample db
		$edit  = "UPDATE sample_fabric
				SET
				fabric_name		 	= '$fabric_name',
				fab_amount		 	= '$fab_amount',
				rate_per_meter		= '$rate_per_meter',
				labour_rate		 	= '$labour_rate',
				labour_cost		 	= '$labour_cost',
				others_cost		 	= '$others_cost',
				total_cost		 	= '$total_cost'
				WHERE
				fabric_id 			= '$fabric_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	
	
	// Delete sample_fabric
	/**
	*	This function will delete a Sample fabric permanently
	*
	*	@param
	*			$fid			fabric id
	*
	*	@return null
	*/
	function delSamFabric($fid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM sample_fabric WHERE fabric_id='$fid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Sample fabric details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Sample Fabric based upon the primary key
	*
	*	@param
	*			$fid		fabric id
	*
	*	@return array				
	*/
	function showSamFabric($fid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_fabric
				   WHERE fabric_id	= '$fid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->fabric_id,					//0
					$result->sample_id,					//1
					$result->design_no,			//2
					$result->fabric_name,	//3	
					$result->fab_amount,	//4	
					$result->remarks,		//5
					$result->added_on,		//6
					$result->added_by,		//7
					$result->modified_on,		//8
					$result->modified_by,	//9
					$result->rate_per_meter,		//10
					$result->labour_cost,	//11
					$result->labour_rate,		//12
					$result->total_cost,	//13
					$result->total_time,		//14 
					$result->others_cost		//15
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	/*
	*	This funcion will return all the product colour id for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllSamFabric($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT fabric_id FROM sample_fabric";
		}
		else
		{
			//statement
			$select	= "SELECT fabric_id FROM sample_fabric
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['fabric_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	/*================================ Display All Sample fabric =============================================================*/	
	
	 
	 public function getAllfabricDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_fabric where sample_id= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	 public function getAllfabDtl($design){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_fabric where design_no= '$design'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	/*===============================================	Sample Hand  ================================================*/
	
	/**
	*	Sample Colour.
	*
	*	@param
	*			
	*			$hand_id			   	    hand identity code
	*			$sample_id			   	    sample identity code
	*			$sample_time				Sample Time
	*			$material_name				Sample material name
	*			$mat_amount					Material Amount
	*			$remarks			    	 remarks
	*		
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addSamHand($sample_id,$emp_id,$design_no,$sample_particular,$sample_time,$labour_rate,$labour_cost,
	$material_cost,$other_cost,$total_cost,$remarks,$added_by,$work_type)
	
	{
		$sample_id			   		=	mysql_real_escape_string(trim($sample_id));
		$emp_id			   	   		=	mysql_real_escape_string(trim($emp_id));
		
		$design_no			   		=	mysql_real_escape_string(trim($design_no));
		$sample_particular	   		=	mysql_real_escape_string(trim($sample_particular));
		$sample_time			   	=	mysql_real_escape_string(trim($sample_time));
		$labour_rate			   	=	mysql_real_escape_string(trim($labour_rate));
		$labour_cost			   	=	mysql_real_escape_string(trim($labour_cost));
		$material_cost			   	=	mysql_real_escape_string(trim($material_cost));
		$other_cost			   		=	mysql_real_escape_string(trim($other_cost));
		$total_cost			   		=	mysql_real_escape_string(trim($total_cost));
		$remarks			   		=	mysql_real_escape_string(trim($remarks));
		$added_by			   		=	mysql_real_escape_string(trim($added_by));
		$work_type			   		=	mysql_real_escape_string(trim($work_type));
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_hand
						(sample_id,emp_id,design_no,sample_particular,sample_time,labour_rate,labour_cost,
						material_cost,other_cost,total_cost,remarks, added_on,added_by,work_type)
							
						VALUES
						('$sample_id','$emp_id','$design_no','$sample_particular','$sample_time','$labour_rate',
						'$labour_cost','$material_cost','$other_cost','$total_cost','$remarks',now(),'$added_by','$work_type')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$hand_id	= mysql_insert_id();
		
		//return primary key
		return $hand_id;

	}//eof
	
	
	
	
	/**
	*	This function will Update a Sample Hand permanently
	*
	*	@param
	*	$hand_id			Hand id
	*
	*	@return null
	*/
	//Update Sample Hand Table
	function EditSamHand($hand_id, $sample_particular,$sample_time,$labour_rate,$labour_cost,$other_cost,$total_cost,$remarks,
	$work_type)
	
	{
		$sample_particular	        	   	=	trim($sample_particular);
		$sample_time	        	  	   	=	trim($sample_time);
		$labour_rate	        	   		=	trim($labour_rate);
		$labour_rate	        	   		=	trim($labour_rate);
		$labour_cost	        	   		=	trim($labour_cost);
		$other_cost	        	   			=	trim($other_cost);
		$total_cost	        	   	   		=	trim($total_cost);
		$remarks	        	   	   		=	trim($remarks);
		$work_type	        	   	   		=	trim($work_type);
		//update Sample db
		$edit  = "UPDATE sample_hand
				SET
				sample_particular		 	= '$sample_particular',
				sample_time		 			= '$sample_time',
				labour_rate					= '$labour_rate',
				labour_cost		 			= '$labour_cost',
				other_cost		 			= '$other_cost',
				total_cost		 			= '$total_cost',
				remarks		 				= '$remarks',
				work_type		 			= '$work_type'
				WHERE
				hand_id 					= '$hand_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
		
	#####################################################################################################
	#
	#										Delete sample Hand from Sample Hand  table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Sample hand permanently
	*
	*	@param
	*			$hid			hand id
	*
	*	@return null
	*/
	function delSamhand($hid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM sample_hand WHERE hand_id='$hid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Sample Hand details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Sample Hand based upon the primary key
	*
	*	@param
	*			$hid		hand id
	*
	*	@return array				
	*/
	function showSamHand($hid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_hand
				   WHERE hand_id	= '$hid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->hand_id,			//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->design_no,			//3	
					$result->sample_particular,	//4	
					$result->sample_time,		//5	
					$result->labour_rate,		//6
					$result->labour_cost,		//7
					$result->material_cost,		//8
					$result->other_cost,			//9
					$result->total_cost,		//10
					$result->remarks,			//11
					$result->added_on,			//12
					$result->added_by,			//13
					$result->modified_on,		//14
					$result->modified_by,	//15
					$result->work_type	//16
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	// Hand Data Display
	/*
	*  $dno			= Design No
	*  $type		= Work type 
	*  $sparticular  = sample particular	
	*/
	function getAllHandDtlsPartWise($dno,$type, $sparticular)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_hand
				   WHERE design_no= '$dno' AND work_type='$type' AND sample_particular = '$sparticular'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->hand_id,			//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->design_no,			//3	
					$result->sample_particular,	//4	
					$result->sample_time,		//5	
					$result->labour_rate,		//6
					$result->labour_cost,		//7
					$result->material_cost,		//8
					$result->other_cost,		//9
					$result->total_cost,		//10
					$result->remarks,			//11
					$result->added_on,			//12
					$result->added_by,			//13
					$result->modified_on,		//14
					$result->modified_by,	//15
					$result->work_type	//16
					);
		}
		
		//return the data
		return $data;
	}//eof
	
	/*================================ Display All Sample Hand Material =============================================================*/	
	
	 
	 public function getAllHandDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_hand where sample_id= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	 public function getAllHandDtlDisplay($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_hand where design_no= '$design_no'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 // Hand Data Display
	 /*
	*  $dno			= Design No
	*  $type		= Work type 	
	 */
	 public function getAllHandDtlDT($dno,$type){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_hand where design_no= '$dno' AND work_type='$type'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	 
	
	public function getAllManualDisplay($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_manual where design_no= '$design_no'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	public function getAllComputerDisplay($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_computer where design_no= '$design_no'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	public function getAllKaliDisplay($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_kali where design_no= '$design_no'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	public function getAllFinalStichDtlDisplay($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_fstich where design_no= '$design_no'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	
	/*
	*	This funcion will return all the product colour id for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllSamHand($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT hand_id FROM sample_hand";
		}
		else
		{
			//statement
			$select	= "SELECT hand_id FROM sample_hand
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
	
	
	
/************************************************************************************************************************/

/*											sample Manual embroidery section											*/

/************************************************************************************************************************/		
	/**
	*	Sample Manual.
	*
	*	@param
	*			
	*			$manual_id			   	    sample manual identity code
	*			$sample_id			   	    sample identity code
	*			$sample_time				Sample Time
	*			$material_name				Sample material name
	*			$mat_amount					Material Amount
	*			$remarks			    	 remarks
	*		
	*			
	*		
	*			
	*
	*	@return int
	*/
	
	function addSamManual($sample_id,$emp_id,$design_no,$sample_particular,$sample_time,$labour_rate,$labour_cost,
	$material_cost,$other_cost,$total_cost,$remarks,$added_by,$table)
	
	{
		$sample_id			   		=	mysql_real_escape_string(trim($sample_id));
		$emp_id			   	   		=	mysql_real_escape_string(trim($emp_id));
		
		$design_no			   		=	mysql_real_escape_string(trim($design_no));
		$sample_particular	   		=	mysql_real_escape_string(trim($sample_particular));
		$sample_time			   	=	mysql_real_escape_string(trim($sample_time));
		$labour_rate			   	=	mysql_real_escape_string(trim($labour_rate));
		$labour_cost			   	=	mysql_real_escape_string(trim($labour_cost));
		$material_cost			   	=	mysql_real_escape_string(trim($material_cost));
		$other_cost			   		=	mysql_real_escape_string(trim($other_cost));
		$total_cost			   		=	mysql_real_escape_string(trim($total_cost));
		$remarks			   		=	mysql_real_escape_string(trim($remarks));
		$added_by			   		=	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in sample manual table
		$insert		=   "INSERT INTO ".$table."
						(sample_id,emp_id,design_no,sample_particular,sample_time,labour_rate,labour_cost,
						material_cost,other_cost,total_cost,remarks, added_on,added_by)
							
						VALUES
						('$sample_id','$emp_id','$design_no','$sample_particular','$sample_time','$labour_rate',
						'$labour_cost','$material_cost','$other_cost',
						'$total_cost','$remarks',now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		
		//return primary key
		return $id;

	}//eof
	
	
	/**
	*	This function will Update a Sample Manual permanently
	*
	*	@param
	*	
	*	$manual_emb_id			Manual Embroidery id
	*
	*	@return null
	*/
	//Update Sample Embroidery Table
	function EditSamManual($manual_emb_id, $sample_particular,$sample_time,$labour_rate,$labour_cost,$total_cost,$remarks)
	
	{
		$sample_particular	        	   	=	trim($sample_particular);
		$sample_time	        	  	   	=	trim($sample_time);
		$labour_rate	        	   		=	trim($labour_rate);
		$labour_rate	        	   		=	trim($labour_rate);
		$labour_cost	        	   		=	trim($labour_cost);
		$total_cost	        	   	   		=	trim($total_cost);
		$remarks	        	   	   		=	trim($remarks);
		$work_type	        	   	   		=	trim($work_type);
		//update Sample Manual Embroidery db
		$edit  = "UPDATE sample_manual_embrotary
				SET
				sample_particular		 	= '$sample_particular',
				sample_time		 			= '$sample_time',
				labour_rate					= '$labour_rate',
				labour_cost		 			= '$labour_cost',
				total_cost		 			= '$total_cost',
				remarks		 				= '$remarks'
				WHERE
				manual_emb_id 				= '$manual_emb_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	
	
	
	
	
	#####################################################################################################
	#
	#										Delete sample Manual 
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Sample Manual
	*
	*	@param
	*			$smid			Sample Manual id
	*
	*	@return null
	*/
	function delSamManual($smid)
	{
		
		//delete from Sample Manual
		$delete1 = "DELETE FROM sample_manual WHERE manual_id='$smid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Sample Manual details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Sample Manual Aari based upon the primary key
	*
	*	@param
	*			$smid		Sample manual ari id
	*
	*	@return array				
	*/
	function showSamManualari($smid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_manual_aari
				   WHERE manual_arri_id	= '$smid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->manual_arri_id,			//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->design_no,			//3	
					$result->sample_particular,	//4	
					$result->sample_time,		//5	
					$result->labour_rate,		//6
					$result->labour_cost,		//7
					$result->material_cost,		//8
					$result->other_cost,			//9
					$result->total_cost,		//10
					$result->remarks,			//11
					$result->added_on,			//12
					$result->added_by,			//13
					$result->modified_on,		//14
					$result->modified_by	//15
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a sample_manual_embrotary based upon the primary key
	*
	*	@param
	*			$smid		Sample manual emb id
	*
	*	@return array				
	*/
	function showSamManualEmb($smid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_manual_embrotary
				   WHERE manual_emb_id	= '$smid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->manual_emb_id,		//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->design_no,			//3	
					$result->sample_particular,	//4	
					$result->sample_time,		//5	
					$result->labour_rate,		//6
					$result->labour_cost,		//7
					$result->material_cost,		//8
					$result->other_cost,		//9
					$result->total_cost,		//10
					$result->remarks,			//11
					$result->added_on,			//12
					$result->added_by,			//13
					$result->modified_on,		//14
					$result->modified_by	//15
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/*================================ Display All Sample Manual Material =============================================================*/	
	
	 public function getAllManualDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_manual_aari where sample_id= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	 public function getAllManualEmbDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_manual_embrotary where sample_id= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	public function getManualEmbDtl($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_manual_embrotary where design_no= '$design_no'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	
	#####################################################################################################
	#
	#									Sample computer details
	#
	#####################################################################################################	

	/**
	*	Add Sample computer aari.
	*
	*	@param
	*			
	*			$sample_id			   	    sample identity code
	*			$sample_time				Sample Time
	*			$com_design_no				Computer Design Number
	*			$stich_amount				number of stich
	*			$remarks			    	 remarks
	*		
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addSamComputer($sample_id,$emp_id,$design_no,$sample_particular,$sample_time,$other_cost,$com_design_no,$stich_amount,
	$stich_rate,$stich_cost,$material_cost,$total_cost,$remarks,$added_by,$no_of_heads,$table)
	
	{
		$sample_id			   	=	mysql_real_escape_string(trim($sample_id));
		$emp_id			   		=	mysql_real_escape_string(trim($emp_id));
		$design_no			   	=	mysql_real_escape_string(trim($design_no));
		$sample_particular		=	mysql_real_escape_string(trim($sample_particular));
		$sample_time			=	mysql_real_escape_string(trim($sample_time));
		$other_cost			   	=	mysql_real_escape_string(trim($other_cost));
		$com_design_no			=	mysql_real_escape_string(trim($com_design_no));
		$stich_amount			=	mysql_real_escape_string(trim($stich_amount));
		$stich_rate				=	mysql_real_escape_string(trim($stich_rate));
		$stich_cost				=	mysql_real_escape_string(trim($stich_cost));
		$material_cost			=	mysql_real_escape_string(trim($material_cost));
		$total_cost				=	mysql_real_escape_string(trim($total_cost));
		$remarks			   	=	mysql_real_escape_string(trim($remarks));
		$added_by			   	=	mysql_real_escape_string(trim($added_by));
		$no_of_heads			=	mysql_real_escape_string(trim($no_of_heads));
		//satement to insert in sample computer table
		$insert		=   "INSERT INTO ".$table."
						(sample_id,emp_id,design_no,sample_particular,sample_time,other_cost,com_design_no,stich_amount,
						stich_rate,stich_cost,material_cost,total_cost,remarks,added_on,added_by,no_of_heads)
							
						VALUES
						('$sample_id','$emp_id','$design_no','$sample_particular','$sample_time','$other_cost','$com_design_no',
						'$stich_amount','$stich_rate','$stich_cost','$material_cost','$total_cost',
						'$remarks',now(),'$added_by','$no_of_heads')
							
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
	#										Delete sample Computer 
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Sample Computer
	*
	*	@param
	*			$scid			Sample Computer id
	*
	*	@return null
	*/
	function delSamComputer($scid)
	{
		
		//delete from Sample Kali
		$delete1 = "DELETE FROM sample_computer WHERE computer_id='$scid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Sample Computer details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Sample Computer Aari based upon the primary key
	*
	*	@param
	*			$computer_aari_id		Sample Computer Aari Identification number
	*
	*	@return array				
	*/
	function showSamComputerAari($computer_aari_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM scomputer_aari
				   WHERE computer_aari_id	= '$computer_aari_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->computer_aari_id,	//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->design_no,			//3	
					$result->sample_particular,	//4	
					$result->sample_time,		//5	
					$result->other_cost,		//6
					$result->com_design_no,		//7
					$result->stich_amount,		//8
					$result->stich_rate,	//9
					$result->stich_cost,	//10
					$result->material_cost,	//11	
					$result->total_cost,	//12	
					$result->remarks,		//13
					$result->added_on,		//14
					$result->added_by,		//15
					$result->modified_on,	//16
					$result->modified_by	//17
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a Sample Computer Embroidery based upon the primary key
	*
	*	@param
	*			$computer_emb_id		Sample Computer Embroidery Identification number
	*
	*	@return array				
	*/
	function showSamComputerEmb($computer_emb_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM scomputer_embroidery
				   WHERE computer_emb_id	= '$computer_emb_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->computer_emb_id,	//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->design_no,			//3	
					$result->sample_particular,	//4	
					$result->sample_time,		//5	
					$result->other_cost,		//6
					$result->com_design_no,		//7
					$result->stich_amount,		//8
					$result->stich_rate,	//9
					$result->stich_cost,	//10
					$result->material_cost,	//11	
					$result->total_cost,	//12	
					$result->remarks,		//13
					$result->added_on,		//14
					$result->added_by,		//15
					$result->modified_on,	//16
					$result->modified_by,	//17
					$result->no_of_heads	//18
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	function showSamCompEmb($com_design_no)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM scomputer_embroidery
				   WHERE com_design_no	= '$com_design_no'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->computer_emb_id,	//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->design_no,			//3	
					$result->sample_particular,	//4	
					$result->sample_time,		//5	
					$result->other_cost,		//6
					$result->com_design_no,		//7
					$result->stich_amount,		//8
					$result->stich_rate,	//9
					$result->stich_cost,	//10
					$result->material_cost,	//11	
					$result->total_cost,	//12	
					$result->remarks,		//13
					$result->added_on,		//14
					$result->added_by,		//15
					$result->modified_on,	//16
					$result->modified_by,	//17
					$result->no_of_heads	//18
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	#####################################################################################################
	#
	#										Edit sample Computer embroidery 
	#
	#####################################################################################################
		
	
	/**
	*	This function will Update a Sample Computer Embroidery permanently
	*
	*	@param
	*			$computer_emb_id			computer_emb_id 
	*
	*	@return null
	*/
	
	//Update Sample  scomputer_embroidery Table
	function EditSamComEmd($computer_emb_id, $sample_particular,$com_design_no,$stich_amount,$no_of_heads,$other_cost,$total_cost,$remarks)
	
	{
		$sample_particular	        	   	=	trim($sample_particular);
		$com_design_no	        	  	   	=	trim($com_design_no);
		$stich_amount	        	   		=	trim($stich_amount);
		$no_of_heads	        	   		=	trim($no_of_heads);
		$labour_cost	        	   		=	trim($labour_cost);
		$other_cost	        	   			=	trim($other_cost);
		$total_cost	        	   	   		=	trim($total_cost);
		$remarks	        	   	   		=	trim($remarks);
		//update Sample Computer Emb
		$edit  = "UPDATE scomputer_embroidery
				SET
				sample_particular		 	= '$sample_particular',
				com_design_no		 		= '$com_design_no',
				stich_amount				= '$stich_amount',
				no_of_heads		 			= '$no_of_heads',
				other_cost		 			= '$other_cost',
				total_cost		 			= '$total_cost',
				remarks		 				= '$remarks'
				WHERE
				computer_emb_id 			= '$computer_emb_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	
	
	/**
	*	This function will delete a Sample Computer emb id
	*
	*	@param
	*			$seid			computer emb id	
	*
	*	@return null
	*/
	function delSamComputerEmb($seid)
	{
		
		//delete from scomputer_embroidery
		$delete1 = "DELETE FROM scomputer_embroidery WHERE computer_emb_id	='$seid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	/*================================ Display All Sample computer Material =============================================================*/	
	
	 
	public function getAllComputerDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM scomputer_aari where sample_id = '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	public function getAllComputerEmbDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM scomputer_embroidery where sample_id = '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	public function getAllComputerData($did,$table){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." where com_design_no = '$did'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	 
	 public function getAllComData($did,$table){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM ".$table." where design_no = '$did'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 

/*===============================================	Sample Kali Add  ================================================*/
	
	/**
	*	Sample Colour.
	*
	*	@param
	*			
	*			$kali_id			   	    sample Kali identity code
	*			$sample_id			   	    sample identity code
	*			$sample_time				Sample Time
	*			$kali_name					Sample kali name
	*			$no_of_kali					Number of kali
	*			$remarks			    	 remarks
	*		
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addSamKali($sample_id,$design_no,$sample_time,$kali_rate,$kali_name,$no_of_kali, $material_cost,$remarks)
	
	{
		$sample_id			   =	mysql_real_escape_string(trim($sample_id));
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		$sample_time			   =	mysql_real_escape_string(trim($sample_time));
		$kali_rate			   =	mysql_real_escape_string(trim($kali_rate));
		$kali_name			   =	mysql_real_escape_string(trim($kali_name));
		$no_of_kali			   =	mysql_real_escape_string(trim($no_of_kali));
		$material_cost			   =	mysql_real_escape_string(trim($material_cost));
		$remarks			   =	mysql_real_escape_string(trim($remarks));
		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_kali
						(sample_id,design_no,sample_time,kali_rate,kali_name,no_of_kali,material_cost,remarks, added_on)
							
						VALUES
						('$sample_id','$design_no','$sample_time','$kali_rate','$kali_name','$no_of_kali','$material_cost','$remarks',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$Kali_id	= mysql_insert_id();
		
		//return primary key
		return $Kali_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Delete sample Kali 
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Sample Kali
	*
	*	@param
	*			$skid			Sample Kali id
	*
	*	@return null
	*/
	function delSamKali($skid)
	{
		
		//delete from Sample Kali
		$delete1 = "DELETE FROM sample_kali WHERE kali_id='$skid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Sample Kali details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Sample Kali based upon the primary key
	*
	*	@param
	*			$skid		Sample kali id
	*
	*	@return array				
	*/
	function showSamKali($skid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_kali
				   WHERE kali_id	= '$skid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->kali_id,					//0
					$result->sample_id,					//1
					$result->design_no,			//2
					$result->sample_time,	//3	
					$result->kali_rate,	//4	
					$result->material_cost,	//5	
					$result->remarks,		//6
					$result->added_on,		//7
					$result->added_by,		//8
					$result->modified_on,		//9
					$result->modified_by,	//10
					$result->kali_name,	//11
					$result->no_of_kali	//12
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*================================ Display All Sample Manual Material =============================================================*/	
	
	 
	 public function getAllkalilDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_kali where sample_id= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	#####################################################################################################
	#
	#										Sample Final Stiching 
	#
	#####################################################################################################
	
	
	/**
	*	Add Sample Final Stitch.
	*
	*	@param
	*			
	*			$fstich_id			   	    sample Final Stich identity code
	*			$sample_id			   	    sample identity code
	*			$sample_time				Sample Time
	*			$material_name				Sample material name
	*			$mat_amount					Material Amount
	*			$remarks			    	 remarks
	*		
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addSamFstich($sample_id,$emp_id,$design_no,$sample_particular,$sample_time,$labour_cost,
	$material_cost,$others_cost,$total_cost,$remarks,$added_by)
	
	{
		$sample_id			   	=	mysql_real_escape_string(trim($sample_id));
		$emp_id			   		=	mysql_real_escape_string(trim($emp_id));
		$design_no			   	=	mysql_real_escape_string(trim($design_no));
		$sample_particular		=	mysql_real_escape_string(trim($sample_particular));
		$sample_time			=	mysql_real_escape_string(trim($sample_time));
		$labour_cost			=	mysql_real_escape_string(trim($labour_cost));
		$material_cost			=	mysql_real_escape_string(trim($material_cost));
		$others_cost			=	mysql_real_escape_string(trim($others_cost));
		$total_cost				=	mysql_real_escape_string(trim($total_cost));
		$remarks			   	=	mysql_real_escape_string(trim($remarks));
		$added_by			   	=	mysql_real_escape_string(trim($added_by));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_fstich
						(sample_id,emp_id,design_no,sample_particular,sample_time,labour_cost,
						material_cost,others_cost,total_cost,remarks, added_on,added_by)
							
						VALUES
						('$sample_id','$emp_id','$design_no','$sample_particular','$sample_time','$labour_cost',
						'$material_cost','$others_cost','$total_cost','$remarks',now(),'$added_by')
							
						";
					
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$fstich_id	= mysql_insert_id();
		
		//return primary key
		return $fstich_id;

	}//eof
	
	
	 
	 #####################################################################################################
	#
	#										Delete sample Final stich from 
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Sample final stich permanently
	*
	*	@param
	*			$fid			final stich id
	*
	*	@return null
	*/
	function delSamfinalStich($fid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM sample_fstich WHERE fstich_id='$fid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Sample final stich details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Sample final stich based upon the primary key
	*
	*	@param
	*			$fid		final stich id
	*
	*	@return array				
	*/
	function showSamFinalStich($fid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_fstich
				   WHERE fstich_id	= '$fid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->fstich_id,			//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->design_no,			//3	
					$result->sample_particular,	//4	
					$result->sample_time,		//5	
					$result->labour_cost,		//6
					$result->material_cost,		//7
					$result->others_cost,		//8
					$result->total_cost,	//9
					$result->remarks,		//10
					$result->added_on,		//11
					$result->added_by,		//12
					$result->modified_on,	//13
					$result->modified_by	//14
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get the data associated with a Sample final stich based upon the primary key
	*
	*	@param
	*			$design_no		Design No
	*
	*	@return array				
	*/
	function getAllSamFStich($design_no,$sample_particular)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_fstich
				   WHERE design_no	= '$design_no' AND sample_particular = '$sample_particular'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->fstich_id,			//0
					$result->sample_id,			//1
					$result->emp_id,			//2
					$result->design_no,			//3	
					$result->sample_particular,	//4	
					$result->sample_time,		//5	
					$result->labour_cost,		//6
					$result->material_cost,		//7
					$result->others_cost,		//8
					$result->total_cost,	//9
					$result->remarks,		//10
					$result->added_on,		//11
					$result->added_by,		//12
					$result->modified_on,	//13
					$result->modified_by	//14
					
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	/*============================================================================================================= 
								//Display All Sample Final Stich Data
	===============================================================================================================*/	
	 public function getAllFstichDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_fstich where sample_id= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	/*============================================================================================================= 
								//Display All Sample Final Stich Data design no wise
	===============================================================================================================*/	
	 public function getAllFstichParticular($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_fstich where design_no= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	#####################################################################################################
	#
	#										Add sample Material (common function)
	#
	#####################################################################################################
	// Materials Add to all sample material table
	function addSamMaterials($id,$material_name,$material_amount,$mat_unit,$mat_rate,$mat_cost,$table,$tableId)
	
	{
		$id			   				=	mysql_real_escape_string(trim($id));
		$material_name			   	=	mysql_real_escape_string(trim($material_name));
		$material_amount			=	mysql_real_escape_string(trim($material_amount));
		$mat_unit			   		=	mysql_real_escape_string(trim($mat_unit));
		$mat_rate					=	mysql_real_escape_string(trim($mat_rate));
		$mat_cost					=	mysql_real_escape_string(trim($mat_cost));
		//satement to insert in sample_dye_materials table
		$insert		=   "INSERT INTO ".$table."
						($tableId,material_name,material_amount,mat_unit,mat_rate,mat_cost)
							
						VALUES
						('$id','$material_name','$material_amount','$mat_unit','$mat_rate','$mat_cost')
							
						";
					
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sdm_id	= mysql_insert_id();
		
		//return primary key
		return $sdm_id;

	}//eof
	
	#####################################################################################################
	#
	#										Update All sample Material table
	#
	#####################################################################################################
		
	/**
	*	This function will Update all  Sample table fabric permanently
	*
	*	@param
	*			$id			
	*
	*	@return null
	*/
	
	//Update All Sample Table
	function UpdateSampleAllTable($id, $material_cost,$total_cost,$table,$tableId)
	
	{
		$material_cost	           =	trim($material_cost);
		$total_cost	        	   =	trim($total_cost);

		//update Sample db
		$edit  = "UPDATE ".$table."
				SET
				material_cost		= '$material_cost',
				total_cost		 	= '$total_cost'
				WHERE
				".$tableId."		= '$id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	
	
	
	//*****************************************  Factory Details  ****************************************************//
	
	/**
	*	Display Factory records from factory table.
	*
	*	@param
	*			
	*/
	public function getAllFactory(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM factory order by factory_name asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	/**
	*	Get the data associated with a Sample factory based upon the primary key
	*
	*	@param
	*			$fid		factory id
	*
	*	@return array				
	*/
	function showFactory($fid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM factory
				   WHERE factory_id	= '$fid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->factory_id,	//0
					$result->factory_name,	//1
					$result->added_on,		//2
					$result->added_by,		//3
					$result->modified_on,	//4
					$result->modified_by,	//5
					$result->address1,		//6
					$result->address2,		//7
					$result->state,			//8
					$result->post_code,		//9
					$result->cemail,		//10
					$result->cphon			//11
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a Sample factory based upon the primary key
	*
	*	@param
	*			$factory_name		factory name
	*
	*	@return array				
	*/
	function showFactoryNamewiseDtls($factory_name)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM factory
				   WHERE factory_name	= '$factory_name'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->factory_id,	//0
					$result->factory_name,	//1
					$result->added_on,		//2
					$result->added_by,		//3
					$result->modified_on,	//4
					$result->modified_by,	//5
					$result->address1,		//6
					$result->address2,		//7
					$result->state,			//8
					$result->post_code,		//9
					$result->cemail,		//10
					$result->cphon			//11
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	}//eoc