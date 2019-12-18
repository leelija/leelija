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




class Ratechart
{

	#####################################################################################################
	#										Dye Rate chart
	#										
	#
	#####################################################################################################
	
	
	//			Add Dye rate
	
	/**
	*	Dye rate.
	*
	*	@param
	*			
	*			$drate_chart_id			   	dye rate id
	*			$design_no			   	    Design number
	*			$worker_type				Worker type
	*			$fabric_name				Fabric Name
	*			$fabric_amount			    Fabric Amount
	*			$rate						rate per meter fabric
	*			$labour_cost				Labour cost
	*			$total_cost			    	Total cost
	*			$work_time					work time
	*		
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addDyeRate($worker_type,$fabric_name,$rate,$work_time,$remarks)
	
	{
		$worker_type			   =	mysql_real_escape_string(trim($worker_type));
		$fabric_name			   =	mysql_real_escape_string(trim($fabric_name));
	//	$fabric_amount			   =	mysql_real_escape_string(trim($fabric_amount));
		$rate			   			=	mysql_real_escape_string(trim($rate));
	//	$labour_cost			   =	mysql_real_escape_string(trim($labour_cost));
		
	//	$total_cost			   			=	mysql_real_escape_string(trim($total_cost));
		$work_time			   =	mysql_real_escape_string(trim($work_time));
		$remarks			   =	mysql_real_escape_string(trim($remarks));
		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO dye_rate_chart
						(worker_type,fabric_name,rate,work_time,remarks, added_on)
							
						VALUES
						('$worker_type','$fabric_name','$rate','$work_time','$remarks',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$drate_chart_id	= mysql_insert_id();
		
		//return primary key
		return $drate_chart_id;

	}//eof
		
	#####################################################################################################
	#
	#										Delete Dye rate 
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a dye rate permanently
	*
	*	@param
	*			$drate_id			dye rate id
	*
	*	@return null
	*/
	function delDyeRate($drate_id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM dye_rate_chart WHERE drate_chart_id ='$drate_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  dye rate details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a dye rate based upon the primary key
	*
	*	@param
	*			$drateid		dye rate id
	*
	*	@return array				
	*/
	function showDyeRate($drateid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM dye_rate_chart
				   WHERE drate_chart_id	= '$drateid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->drate_chart_id,	//0
					$result->worker_type,		//1
					$result->fabric_name,		//2
					$result->rate,				//3
					$result->work_time,			//4
					$result->remarks,			//5
					$result->added_on,			//6
					$result->added_by,			//7
					$result->modified_on,		//8
					$result->modified_by	//9
					
					);
		}
	
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a dye rate based upon worker_type and 
	*
	*	@param
	*			$wtype		worker_type
	*			$fname      fabric_name
	*	@return array				
	*/
	function showDyeWFDtls($wtype,$fname)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM dye_rate_chart
				   WHERE worker_type	= '$wtype' AND fabric_name	= '$fname'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->drate_chart_id,	//0
					$result->worker_type,		//1
					$result->fabric_name,		//2
					$result->rate,				//3
					$result->work_time,			//4
					$result->remarks,			//5
					$result->added_on,			//6
					$result->added_by,			//7
					$result->modified_on,		//8
					$result->modified_by	//9
					
					);
		}
	
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the dyeing rate id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllDyeingRateId($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT drate_chart_id FROM dye_rate_chart";
		}
		else
		{
			//statement
			$select	= "SELECT drate_chart_id FROM dye_rate_chart
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['drate_chart_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	// Display Dye rate chart all Data fabric name group wise
	public function dyeRateData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM dye_rate_chart group by fabric_name") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	/*=============================================== Hand rate add ================================================*/
	
	/**
	*	Sample Colour.
	*
	*	@param
	*			
	*			$id			   				hand rate id
	*			$design_no			   	    Design number
	*			$worker_type				Worker type
	*			$particular_name			Particular Name
	*			$rate						rate per meter fabric
	*			$other_cost					Other cost
	*			$work_time					work time
	*		
	*		
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addHandRate($design_no,$worker_type,$particular_name,$rate,$other_cost,$work_time)
	
	{
		$design_no			  	   =	mysql_real_escape_string(trim($design_no));
		$worker_type			   =	mysql_real_escape_string(trim($worker_type));
		$particular_name			   =	mysql_real_escape_string(trim($particular_name));
	//	$fabric_amount			   =	mysql_real_escape_string(trim($fabric_amount));
		$rate			   			=	mysql_real_escape_string(trim($rate));
		$other_cost			   		=	mysql_real_escape_string(trim($other_cost));
		
	//	$total_cost			   			=	mysql_real_escape_string(trim($total_cost));
		$work_time			   =	mysql_real_escape_string(trim($work_time));
	//	$remarks			   =	mysql_real_escape_string(trim($remarks));
		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO hand_rate_chart
						(design_no,worker_type,particular_name,rate,other_cost,work_time, added_on)
							
						VALUES
						('$design_no','$worker_type','$particular_name','$rate','$other_cost','$work_time',now())
							
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
	#										Delete Hand rate from  Hand  rate table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a hand rate permanently
	*
	*	@param
	*			$id			hand rate id
	*
	*	@return null
	*/
	function delHandrate($id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM hand_rate_chart WHERE id='$id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display Hand rate details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Hand rate based upon the primary key
	*
	*	@param
	*			$id		hand rate id
	*
	*	@return array				
	*/
	function showHandRate($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM hand_rate_chart
				   WHERE id	= '$id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,					//0
					$result->design_no,			//1
					$result->worker_type,	//2	
					$result->particular_name,	//3
					$result->rate,	//4
					$result->other_cost,		//5
					$result->work_time,		//6
					$result->added_by,		//7
					$result->modified_on,		//8
					$result->modified_by	//9
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	/*
	*	This funcion will return all the hand rate id for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllHandRate($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT id FROM hand_rate_chart";
		}
		else
		{
			//statement
			$select	= "SELECT id FROM hand_rate_chart
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	


/*===============================================	Sample Manual Add  ================================================*/
	
	/**
	*	Sample Colour.
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
	
	function addSamManual($sample_id,$design_no,$sample_particular,$sample_time,$labour_cost,$material_name,$mat_amount, $material_cost,$other_cost,$remarks)
	
	{
		$sample_id			   =	mysql_real_escape_string(trim($sample_id));
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		$sample_particular	   =	mysql_real_escape_string(trim($sample_particular));
		$sample_time			   =	mysql_real_escape_string(trim($sample_time));
		$labour_cost			   =	mysql_real_escape_string(trim($labour_cost));
		$material_name			   =	mysql_real_escape_string(trim($material_name));
		$mat_amount			   =	mysql_real_escape_string(trim($mat_amount));
		$material_cost			   =	mysql_real_escape_string(trim($material_cost));
		$other_cost			   =	mysql_real_escape_string(trim($other_cost));
		$remarks			   =	mysql_real_escape_string(trim($remarks));
		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_manual
						(sample_id,design_no,sample_particular,sample_time,labour_cost,material_name,mat_amount,material_cost,other_cost,remarks, added_on)
							
						VALUES
						('$sample_id','$design_no','$sample_particular','$sample_time','$labour_cost','$material_name','$mat_amount','$material_cost','$other_cost','$remarks',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$manual_id	= mysql_insert_id();
		
		//return primary key
		return $manual_id;

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
	*	Get the data associated with a Sample Manual based upon the primary key
	*
	*	@param
	*			$smid		Sample manual id
	*
	*	@return array				
	*/
	function showSamManual($smid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_manual
				   WHERE manual_id	= '$smid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->manual_id,					//0
					$result->sample_id,					//1
					$result->design_no,			//2
					$result->sample_time,	//3	
					$result->material_name,	//4	
					$result->mat_amount,	//5	
					$result->remarks,		//6
					$result->added_on,		//7
					$result->added_by,		//8
					$result->modified_on,		//9
					$result->modified_by,	//10
					$result->sample_particular,	//11
					$result->other_cost	//12
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/*================================ Display All Sample Manual Material =============================================================*/	
	
	 
	 public function getAllManualDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_manual where sample_id= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	/*===============================================	Sample Computer Add  ================================================*/
	
	/**
	*	Sample Colour.
	*
	*	@param
	*			
	*			$computer_id			   	    sample computer identity code
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
	function addSamComputer($sample_id,$design_no,$sample_particular,$sample_time,$other_cost,$com_design_no,$stich_amount, $material_cost,$remarks)
	
	{
		$sample_id			   =	mysql_real_escape_string(trim($sample_id));
		$design_no			   =	mysql_real_escape_string(trim($design_no));
		$sample_particular		   =	mysql_real_escape_string(trim($sample_particular));
		$sample_time			   =	mysql_real_escape_string(trim($sample_time));
		$other_cost			   =	mysql_real_escape_string(trim($other_cost));
		$com_design_no			   =	mysql_real_escape_string(trim($com_design_no));
		$stich_amount			   =	mysql_real_escape_string(trim($stich_amount));
		$material_cost			   =	mysql_real_escape_string(trim($material_cost));
		$remarks			   =	mysql_real_escape_string(trim($remarks));
		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_computer
						(sample_id,design_no,sample_particular,sample_time,other_cost,com_design_no,stich_amount,material_cost,remarks, added_on)
							
						VALUES
						('$sample_id','$design_no','$sample_particular','$sample_time','$other_cost','$com_design_no','$stich_amount','$material_cost','$remarks',now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$computer_id	= mysql_insert_id();
		
		//return primary key
		return $computer_id;

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
	*	Get the data associated with a Sample Computer based upon the primary key
	*
	*	@param
	*			$scid		Sample Computer id
	*
	*	@return array				
	*/
	function showSamComputer($scid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_computer
				   WHERE computer_id	= '$scid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->computer_id,					//0
					$result->sample_id,					//1
					$result->design_no,			//2
					$result->sample_time,	//3	
					$result->sample_particular,	//4	
					$result->material_cost,	//5	
					$result->remarks,		//6
					$result->added_on,		//7
					$result->added_by,		//8
					$result->modified_on,		//9
					$result->modified_by,	//10
					$result->stich_amount,	//11
					$result->com_design_no	//12
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/*================================ Display All Sample computer Material =============================================================*/	
	
	 
	public function getAllComputerDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_computer where sample_id= '$sid'") or die(mysql_error());        
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
	
	/*===============================================	Sample Final Stiching Add  ================================================*/
	
	/**
	*	Sample Colour.
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
	function addSamFstich($sample_id,$design_no,$sample_particular,$sample_time,$labour_cost,$material_name,$mat_amount, $material_cost,$others_cost,$remarks)
	
	{
		$sample_id			   	=	mysql_real_escape_string(trim($sample_id));
		$design_no			   	=	mysql_real_escape_string(trim($design_no));
		$sample_particular		=	mysql_real_escape_string(trim($sample_particular));
		$sample_time			=	mysql_real_escape_string(trim($sample_time));
		$labour_cost			=	mysql_real_escape_string(trim($labour_cost));
		$material_name			=	mysql_real_escape_string(trim($material_name));
		$mat_amount			   	=	mysql_real_escape_string(trim($mat_amount));
		$material_cost			=	mysql_real_escape_string(trim($material_cost));
		$others_cost			=	mysql_real_escape_string(trim($others_cost));
		$remarks			   	=	mysql_real_escape_string(trim($remarks));
		//satement to insert in stock table
		$insert		=   "INSERT INTO sample_fstich
						(sample_id,design_no,sample_particular,sample_time,labour_cost,material_name,mat_amount,material_cost,others_cost,remarks, added_on)
							
						VALUES
						('$sample_id','$design_no','$sample_particular','$sample_time','$labour_cost','$material_name','$mat_amount','$material_cost','$others_cost','$remarks',now())
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$fstich_id	= mysql_insert_id();
		
		//return primary key
		return $fstich_id;

	}//eof
	
	
	/*================================ Display All Sample Final Stich Material =============================================================*/	
	
	 
	 public function getAllFstichDtl($sid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_fstich where sample_id= '$sid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
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
					$result->fstich_id,					//0
					$result->sample_id,					//1
					$result->design_no,			//2
					$result->sample_time,	//3	
					$result->material_name,	//4	
					$result->mat_amount,	//5	
					$result->remarks,		//6
					$result->added_on,		//7
					$result->added_by,		//8
					$result->modified_on,		//9
					$result->modified_by,	//10
					$result->sample_particular,	//11
					$result->others_cost	//12
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/*==================================================================================================================*/
													/*	Production Rate  */
	/********************************************************************************************************************/
	/**
	*	Production Rate Add.
	*
	*	@param
	*			
	*			$design_no			   	    Design No
	*			$factory_id			   	    Factory identification no.
	*			$fab_cost					fabrics cos
	*			$dye_cost					Dyeing cost
	*			$comp_cost					Computer stitch cost
	*			$hand_hlight_cost			hand highlight cost
	*			$handp_cost			   	    PureHand cost
	*			$manual_cost			   	Manual cost
	*			$cutting_cost				Cutting cost
	*			$fstitch_cost				Final Stitching cost
	*			$iron_cost					Iron cost
	*			$packing_cost			    Packing cost
	*	@return int
	*/
	function addProductionRate($design_no,$factory_id,$fab_cost,$dye_cost,$comp_cost,$hand_hlight_cost, $handp_cost,$handper,$handtotal,$manual_cost,
	$cutting_cost,$fstitch_cost,$iron_cost,$packing_cost,$photo_cost,$design_cost,$additional,$total_cost,$percentage,
	$net_cost,$remarks,$added_by)
	{
		$design_no			=	mysql_real_escape_string(trim($design_no));
		$factory_id			=	mysql_real_escape_string(trim($factory_id));
		$fab_cost			=	mysql_real_escape_string(trim($fab_cost));
		$dye_cost			=	mysql_real_escape_string(trim($dye_cost));
		$comp_cost			=	mysql_real_escape_string(trim($comp_cost));
		$hand_hlight_cost	=	mysql_real_escape_string(trim($hand_hlight_cost));
		$handp_cost			=	mysql_real_escape_string(trim($handp_cost));
		$handper			=	mysql_real_escape_string(trim($handper));
		$handtotal			=	mysql_real_escape_string(trim($handtotal));
		$manual_cost		=	mysql_real_escape_string(trim($manual_cost));
		$cutting_cost		=	mysql_real_escape_string(trim($cutting_cost));
		$fstitch_cost		=	mysql_real_escape_string(trim($fstitch_cost));
		$iron_cost			=	mysql_real_escape_string(trim($iron_cost));
		$packing_cost		=	mysql_real_escape_string(trim($packing_cost));
		$photo_cost			=	mysql_real_escape_string(trim($photo_cost));
		$design_cost		=	mysql_real_escape_string(trim($design_cost));
		$additional			=	mysql_real_escape_string(trim($additional));
		$total_cost			=	mysql_real_escape_string(trim($total_cost));
		$percentage			=	mysql_real_escape_string(trim($percentage));
		$net_cost			=	mysql_real_escape_string(trim($net_cost));
		$added_by			=	mysql_real_escape_string(trim($added_by));
		$remarks			=	mysql_real_escape_string(trim($remarks));
		//satement to insert in product rate table
		$insert		=   "INSERT INTO product_rate
						(design_no,factory_id,fab_cost,dye_cost,comp_cost,hand_hlight_cost,handp_cost,handper,handtotal,manual_cost,
						cutting_cost,fstitch_cost,iron_cost,packing_cost,photo_cost,design_cost,additional,total_cost,
						percentage,net_cost,remarks,added_by, added_on)
						VALUES
						('$design_no','$factory_id','$fab_cost','$dye_cost','$comp_cost','$hand_hlight_cost','$handp_cost',
						'$handper','$handtotal','$manual_cost','$cutting_cost','$fstitch_cost','$iron_cost','$packing_cost','$photo_cost',
						'$design_cost','$additional','$total_cost','$percentage','$net_cost','$remarks','$added_by',now())
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		//return primary key
		return $id;

	}//eof
	
	/*==================================================================================================================*/
													/*	Production Rate edit  */
	/********************************************************************************************************************/
	/**
	*	Production Rate edit.
	*
	*	@param
	*			
	*			$design_no			   	    Design No
	*			$factory_id			   	    Factory identification no.
	*			$fab_cost					fabrics cos
	*			$dye_cost					Dyeing cost
	*			$comp_cost					Computer stitch cost
	*			$hand_hlight_cost			hand highlight cost
	*			$handp_cost			   	    PureHand cost
	*			$manual_cost			   	Manual cost
	*			$cutting_cost				Cutting cost
	*			$fstitch_cost				Final Stitching cost
	*			$iron_cost					Iron cost
	*			$packing_cost			    Packing cost
	*	@return int
	*/
	function editProdRate($id,$design_no,$factory_id,$fab_cost,$dye_cost,$comp_cost,$hand_hlight_cost, $handp_cost,$manual_cost,
	$cutting_cost,$fstitch_cost,$iron_cost,$packing_cost,$photo_cost,$design_cost,$additional,$total_cost,$percentage,
	$net_cost,$added_by,$remarks)
	{
		$design_no			=	mysql_real_escape_string(trim($design_no));
		$factory_id			=	mysql_real_escape_string(trim($factory_id));
		$fab_cost			=	mysql_real_escape_string(trim($fab_cost));
		$dye_cost			=	mysql_real_escape_string(trim($dye_cost));
		$comp_cost			=	mysql_real_escape_string(trim($comp_cost));
		$hand_hlight_cost	=	mysql_real_escape_string(trim($hand_hlight_cost));
		$handp_cost			=	mysql_real_escape_string(trim($handp_cost));
		$manual_cost		=	mysql_real_escape_string(trim($manual_cost));
		$cutting_cost		=	mysql_real_escape_string(trim($cutting_cost));
		$fstitch_cost		=	mysql_real_escape_string(trim($fstitch_cost));
		$iron_cost			=	mysql_real_escape_string(trim($iron_cost));
		$packing_cost		=	mysql_real_escape_string(trim($packing_cost));
		$photo_cost			=	mysql_real_escape_string(trim($photo_cost));
		$design_cost		=	mysql_real_escape_string(trim($design_cost));
		$additional			=	mysql_real_escape_string(trim($additional));
		$total_cost			=	mysql_real_escape_string(trim($total_cost));
		$percentage			=	mysql_real_escape_string(trim($percentage));
		$net_cost			=	mysql_real_escape_string(trim($net_cost));
		$added_by			=	mysql_real_escape_string(trim($added_by));
		$remarks			=	mysql_real_escape_string(trim($remarks));
		//update stock description
		$edit  = "UPDATE product_rate
				SET
				design_no		 	= '$design_no',
				factory_id			= '$factory_id',
				fab_cost			= '$fab_cost',
				dye_cost			= '$dye_cost',
				comp_cost			= '$comp_cost',
				hand_hlight_cost 	= '$hand_hlight_cost',
				handp_cost 			= '$handp_cost',
				manual_cost 		= '$manual_cost',
				cutting_cost 		= '$cutting_cost',
				fstitch_cost 		= '$fstitch_cost',
				iron_cost 			= '$iron_cost',
				packing_cost		= '$packing_cost',
				photo_cost			= '$photo_cost',
				design_cost 		= '$design_cost',
				additional 			= '$additional',
				total_cost 			= '$total_cost',
				percentage 			= '$percentage',
				net_cost 			= '$net_cost',
				remarks 			= '$remarks',
				modified_by 		= '$modified_by',
				modified_on			= now()
				WHERE
				id 					= '$id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	// edit fabric amount on production rate table
	function editProdRateFabAmount($id,$fab_cost)
	{
		$fab_cost			  	=	mysql_real_escape_string(trim($fab_cost));
		//update Production fabric rate description
		$edit  = "UPDATE product_rate
				SET
				fab_cost		= '$fab_cost'
				WHERE
				id 					= '$id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof

	#####################################################################################################
	#
	#										Display  production rate details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a production rate based upon the primary key
	*
	*	@param
	*			$id		Production rate id
	*
	*	@return array				
	*/
	function showProductionRate($id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM product_rate
				   WHERE id	= '$id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,				//0
					$result->design_no,			//1
					$result->factory_id,		//2
					$result->fab_cost,			//3	
					$result->dye_cost,			//4	
					$result->comp_cost,			//5	
					$result->hand_hlight_cost,	//6
					$result->handp_cost,		//7
					$result->manual_cost,		//8
					$result->cutting_cost,		//9
					$result->fstitch_cost,		//10
					$result->iron_cost,			//11
					$result->packing_cost,		//12
					$result->photo_cost,		//13	
					$result->design_cost,		//14
					$result->additional,		//15
					$result->total_cost,		//16
					$result->percentage,		//17
					$result->net_cost,			//18
					$result->remarks,			//19
					$result->added_by,			//20
					$result->added_on,			//21
					$result->modified_by,		//22
					$result->modified_on,		//23
					$result->handper,			//24
					$result->handtotal			//25
					);
		}
		//return the data
		return $data;
	}//eof
	
	// show all production rate data
	public function getAllProdRate(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_rate ORDER BY id DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	/*=============================================== =============================================================*/
										/*Production fabrics rate add*/
	/*==============================================================================================================*/
	/**
	*	production fabrics details.
	*	@param
	*			$id			   				production fabric rate id
	*			$prod_rate_id			   	production rate id
	*			$fabric_name				Fabric Name
	*			$fab_rate					Fabric Rate
	*			$fab_amount					Fabric Amount
	*			$fab_cost					Fabric Cost
	*	@return int
	*/
	function addProdFabRate($prod_rate_id,$fabric_name,$fab_rate,$fab_amount,$fab_cost)
	{
		$prod_rate_id			  	=	mysql_real_escape_string(trim($prod_rate_id));
		$fabric_name			   	=	mysql_real_escape_string(trim($fabric_name));
		$fab_rate					=	mysql_real_escape_string(trim($fab_rate));
		$fab_amount			   		=	mysql_real_escape_string(trim($fab_amount));
		$fab_cost			   		=	mysql_real_escape_string(trim($fab_cost));
		//satement to insert in production fabric rate table
		$insert		=   "INSERT INTO product_fabric_rate
						(prod_rate_id,fabric_name,fab_rate,fab_amount,fab_cost)
						VALUES
						('$prod_rate_id','$fabric_name','$fab_rate','$fab_amount','$fab_cost')
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		//return primary key
		return $id;

	}//eof
	
	/*==================================================================================================================*/
										/*	Production fabric Rate edit  */
	/********************************************************************************************************************/
	/**
	*	production fabrics rate details.
	*	@param
	*			$id			   				production fabric rate id
	*			$prod_rate_id			   	production rate id
	*			$fabric_name				Fabric Name
	*			$fab_rate					Fabric Rate
	*			$fab_amount					Fabric Amount
	*			$fab_cost					Fabric Cost
	*	@return int
	*/
	function editProdFabRate($id,$prod_rate_id,$fabric_name,$fab_rate,$fab_amount,$fab_cost)
	{
		$prod_rate_id			  	=	mysql_real_escape_string(trim($prod_rate_id));
		$fabric_name			   	=	mysql_real_escape_string(trim($fabric_name));
		$fab_rate					=	mysql_real_escape_string(trim($fab_rate));
		$fab_amount			   		=	mysql_real_escape_string(trim($fab_amount));
		$fab_cost			   		=	mysql_real_escape_string(trim($fab_cost));
		//update Production fabric rate description
		$edit  = "UPDATE product_fabric_rate
				SET
				prod_rate_id		= '$prod_rate_id',
				fabric_name			= '$fabric_name',
				fab_rate			= '$fab_rate',
				fab_amount			= '$fab_amount',
				fab_cost			= '$fab_cost'
				WHERE
				id 					= '$id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof
	
	#####################################################################################################
	#
	#										Display  production fabrics rate details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a production rate based upon the primary key
	*
	*	@param
	*			$id		Production fabric rate id
	*
	*	@return array				
	*/
	function showProductionFabRate($id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM product_fabric_rate
				   WHERE id	= '$id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,				//0
					$result->prod_rate_id,		//1
					$result->fabric_name,		//2
					$result->fab_rate,			//3	
					$result->fab_amount,		//4	
					$result->fab_cost			//5	
					);
		}
		//return the data
		return $data;
	}//eof
	
	// show all production fabric rate data
	public function getAllProdFabRate(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_fabric_rate ORDER BY id DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	// show all production fabric rate data
	public function showProdFabRate($prod_rate_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_fabric_rate where prod_rate_id = '$prod_rate_id' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	 
	 
	 
	}//eoc