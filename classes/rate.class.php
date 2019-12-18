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




class Rate
{

	#####################################################################################################
	#
	#										Add To Stich rate table
	#
	#####################################################################################################
	
	/**
	*	Add a new rate in stich rate table.
	*
	*	@param
	*			
	*			$rate_id			   	    rate_id	
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
	function addStichRate($design_no, $particulars,$particular_rate)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        		    =	trim($design_no);
		$particulars			   		= mysql_real_escape_string(trim($particulars));
		$particular_rate			    =	mysql_real_escape_string(trim($particular_rate));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO stich_rate
						(design_no, particulars, particular_rate, added_on)
							
						VALUES
						('$design_no', '$particulars', '$particular_rate',  
							now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$rate_id	= mysql_insert_id();
		
		//return primary key
		return $rate_id;

	}//eof
		
	
	

	
	
	#####################################################################################################
	#
	#										Edit Stich rate table
	#
	#####################################################################################################
	
	
	/**
	*	Edit a new rate from stich rate table.
	*
	*	@param
	*			
	*			$rate_id			   	    rate_id	
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
	function editStichRate($design_no, $suit_rate,$dupatta_rate, $ghagra_rate, $blause_rate,  $total_rate)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        		=	trim($design_no);
		$suit_rate			   		= mysql_real_escape_string(trim($suit_rate));
		$dupatta_rate			    =	mysql_real_escape_string(trim($dupatta_rate));
		$ghagra_rate		       =	mysql_real_escape_string(trim($ghagra_rate));
		$blause_rate		       =	mysql_real_escape_string(trim($blause_rate));
		$total_rate			 =	mysql_real_escape_string(trim($total_rate));
		
		//update stock description
		$edit  = "UPDATE stich_rate
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
	#										Delete Stich rate table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a stich rate permanently
	*
	*	@param
	*			$rid			rate id
	*
	*	@return null
	*/
	function delStichRate($rid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM stich_rate WHERE rate_id='$rid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Stich Rate details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a stich Rate based upon the primary key
	*
	*	@param
	*			$rid		rate id
	*
	*	@return array				
	*/
	function showStichRate($rid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stich_rate
				   WHERE rate_id	= '$rid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->rate_id,					//0
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
	
	 public function getStichRateDisplay($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stich_rate where design_no='$design_no'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	// rate group by
	public function getParticularGroup(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stich_rate group by particulars") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	/**
	*	Get the data associated with a stich Rate based upon the Design Number
	*
	*	@param
	*			$dno		Design number
	*
	*	@return array				
	*/
	function showStichRateDesNo($dno)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stich_rate
				   WHERE design_no	= '$dno'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->rate_id,					//0
					$result->design_no,					//1
					$result->particulars,				//2
					$result->particular_rate,			//3
					$result->added_on,					//4
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
	function showStichRatePartiwise($particular,$design_no)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stich_rate
				   WHERE particulars	= '$particular' AND design_no = '$design_no'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->rate_id,					//0
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
	function getAllIStichRate($orderby, $orderbyType,$eid)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT rate_id FROM stich_rate where store_managerId='$eid'";
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
			$data[]	= $result['rate_id'];
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
	function getAllStichRateAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT rate_id FROM stich_rate";
		}
		else
		{
			//statement
			$select	= "SELECT rate_id FROM stich_rate
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['rate_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										Add To Kali rate 
	#
	#####################################################################################################
	
	/**
	*	Add a new rate in stich rate table.
	*
	*	@param
	*			
	*			$kali_rate_id			   	Kali rate identification no
	*			$kali_name					Kali name
	*			$kali_type			    	kali type
	*			$rate						Kali rate
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addKaliRate($kali_name, $kali_type,$rate)
	
	{
		$kali_name	        		    =	trim($kali_name);
		$kali_type			   			= mysql_real_escape_string(trim($kali_type));
		$rate			    			=	mysql_real_escape_string(trim($rate));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO kali_rate
						(kali_name, kali_type, rate, added_on)
							
						VALUES
						('$kali_name', '$kali_type', '$rate',  
							now())
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$kali_rate_id	= mysql_insert_id();
		
		//return primary key
		return $kali_rate_id;

	}//eof
		
	
	/**
	*	Get the data associated with a Kali Rate based upon the primary key
	*
	*	@param
	*			$kali_rate_id		kali rate id
	*
	*	@return array				
	*/
	function showKaliRate($kali_rate_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM kali_rate
				   WHERE kali_rate_id	= '$kali_rate_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->kali_rate_id,					//0
					$result->kali_name,							//1
					$result->kali_type,					//2
					$result->rate,		//3
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
	*	This funcion will return all the product kali_rate_id for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllKaliRateAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT kali_rate_id FROM kali_rate";
		}
		else
		{
			//statement
			$select	= "SELECT kali_rate_id FROM kali_rate
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['kali_rate_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	public function getKaliRateDisp(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM kali_rate order by kali_name") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	/**
	*	This function will delete a kali  rate permanently
	*
	*	@param
	*			$krid			kali rate id
	*
	*	@return null
	*/
	function delKaliRate($krid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM kali_rate WHERE kali_rate_id='$krid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	 
	 
	 #####################################################################################################
	#
	#										Add To Interlock rate 
	#
	#####################################################################################################
	
	/**
	*	Add a new rate in interlock rate table.
	*
	*	@param
	*			$interlock_rate_id			Interlock rate identification no
	*			$particular					Particular Name
	*			$rate						Interlock rate
	
	*	@return int
	*/
	function addInterlockRate($particular, $rate)
	
	{
		$particular			   			= mysql_real_escape_string(trim($particular));
		$rate			    			= mysql_real_escape_string(trim($rate));
		//satement to insert in stock table
		$insert		=   "INSERT INTO interlock_rate
						(particular, rate, added_on)
						VALUES
						('$particular', '$rate', now())
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$interlock_rate_id	= mysql_insert_id();
		//return primary key
		return $interlock_rate_id;

	}//eof
		
	
	/**
	*	Get the data associated with a Interlock Rate based upon the primary key
	*
	*	@param
	*			$interlock_rate_id		Interlock rate id
	*
	*	@return array				
	*/
	function showInterlockRate($interlock_rate_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM interlock_rate
				   WHERE interlock_rate_id	= '$interlock_rate_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->interlock_rate_id,			//0
					$result->particular,				//1
					$result->rate,						//2
					$result->added_on,					//3
					$result->added_by,					//4
					$result->modified_on,				//5
					$result->modified_by				//6
					
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	/*
	*	This funcion will return all the product interlock_rate_id for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllInterlockAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT interlock_rate_id FROM interlock_rate";
		}
		else
		{
			//statement
			$select	= "SELECT interlock_rate_id FROM interlock_rate
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['interlock_rate_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	public function getInterlockRateDisp(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM interlock_rate order by particular") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	/**
	*	This function will delete a Interlock  rate permanently
	*
	*	@param
	*			$irid			Interlock rate id
	*
	*	@return null
	*/
	function delInterlockRate($irid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM interlock_rate WHERE interlock_rate_id='$irid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	 
	 
	 
	#####################################################################################################
	#
	#										Add To Stitch Particular rate table
	#
	#####################################################################################################
	
	/**
	*	Add a new rate in stich rate table.
	*
	*	@param
	*			
	*			$rate_id			   	    rate_id	
	*			$particulars			    Particular of product
	*			$particular_rate			particular rate of product
	*			
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addStitchPartRate($particulars,$particular_rate,$added_by)
	
	{
		
		$particulars			   		=  mysql_real_escape_string(trim($particulars));
		$particular_rate			    =	mysql_real_escape_string(trim($particular_rate));
		$added_by			   			=	mysql_real_escape_string(trim($added_by));
		//satement to insert in stock table
		$insert		=   "INSERT INTO stich_particular_rate
						(particulars, particular_rate, added_on,added_by)
							
						VALUES
						('$particulars', '$particular_rate',  
							now(),'$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$rate_id	= mysql_insert_id();
		
		//return primary key
		return $rate_id;

	}//eof
	
	
	/**
	*	Get the data associated with a stich Rate based upon the primary key
	*
	*	@param
	*			$rid		rate id
	*
	*	@return array				
	*/
	function showStitchPartRate($rid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stich_particular_rate
				   WHERE rate_id	= '$rid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->rate_id,					//0
					$result->particulars,				//1
					$result->particular_rate,		//2
					$result->added_on,				//3
					$result->added_by,				//4
					$result->modified_on,			//5
					$result->modified_by			//6
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
		
	 /**
	*	Get the data associated with a stich Rate based upon the unique key
	*
	*	@param
	*			$pname		Particular Name 
	*
	*	@return array				
	*/
	function showStitchPartRateDtl($pname)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stich_particular_rate
				   WHERE particulars	= '$pname'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->rate_id,					//0
					$result->particulars,				//1
					$result->particular_rate,		//2
					$result->added_on,				//3
					$result->added_by,				//4
					$result->modified_on,			//5
					$result->modified_by			//6
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	This function will delete a Interlock  rate permanently
	*
	*	@param
	*			$irid			Interlock rate id
	*
	*	@return null
	*/
	function delStParticRate($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM stich_particular_rate WHERE rate_id='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	
	 /*
	*	This funcion will return all the rate id from stich_particular_rate
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllStichPartRateAll($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT rate_id FROM stich_particular_rate";
		}
		else
		{
			//statement
			$select	= "SELECT rate_id FROM stich_particular_rate
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['rate_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	// Display Particular Stitch Rate
	 public function getStitchPartRateDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stich_particular_rate order by particulars ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
	
	#####################################################################################################
	#
	#										Add To Selling rate table
	#
	#####################################################################################################
	
	/**
	*	Add a new rate in Selling rate table.
	*
	*	@param
	*			
	*			$id			   	    		rate_id	
	*			$design_no					Design no of  products
	*			$design_part			    Particular of product
	*			$sprice						Selling Rate
	*	@return int
	*/
	function addSellingRate($design_no, $design_part,$sprice,$unit,$added_by)
	
	{
		$design_no	       	=	trim($design_no);
		$design_part		= 	mysql_real_escape_string(trim($design_part));
		$sprice			    =	mysql_real_escape_string(trim($sprice));
		$unit			    =	mysql_real_escape_string(trim($unit));
		$added_by			=	mysql_real_escape_string(trim($added_by));
		//satement to insert in selling_stock table
		$insert		=   "INSERT INTO selling_stock
						(design_no, design_part, sprice,unit,added_by, added_on)
							
						VALUES
						('$design_no', '$design_part', '$sprice', '$unit','$added_by', 
							now())
							
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
	#										Edit Selling rate table
	#
	#####################################################################################################
	/**
	*	Edit a new rate from Selling rate table.
	*
	*	@param
	*			
	*			$id			   	    		rate_id	
	*			$design_no					Design no of  products
	*			$design_part			    Particular of product
	*			$sprice						Selling Rate
	*	@return int
	*/
	function editSellingRate($id,$design_no, $design_part,$sprice,$unit,$modified_by)
	
	{
		$design_no	       	=	trim($design_no);
		$design_part		= 	mysql_real_escape_string(trim($design_part));
		$sprice			    =	mysql_real_escape_string(trim($sprice));
		$unit			    =	mysql_real_escape_string(trim($unit));
		$modified_by		=	mysql_real_escape_string(trim($modified_by));
		//update stock description
		$edit  = "UPDATE selling_stock
				SET
				design_no		 	= '$design_no',
				design_part			= '$design_part',
				sprice				= '$sprice',
				unit 				= '$unit',
				modified_by		    = '$modified_by',
				modified_on			= now()
				WHERE
				id 					= '$id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	
	#####################################################################################################
	#
	#										Delete Selling rate table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Selling rate permanently
	*
	*	@param
	*			$id			rate id
	*
	*	@return null
	*/
	function delSellingRate($id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM selling_stock WHERE id='$id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Selling Rate details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Selling Rate based upon the primary key
	*
	*	@param
	*			$id		Selling rate id
	*
	*	@return array				
	*/
	function showSellingRate($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM selling_stock
				   WHERE id	= '$id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,					//0
					$result->design_no,				//1
					$result->design_part,			//2
					$result->sprice,				//3
					$result->unit,					//4
					$result->added_on,				//5
					$result->added_by,				//6
					$result->modified_on,			//7
					$result->modified_by			//8
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get the data associated with a Selling Rate based upon the primary key
	*
	*	@param
	*			$design_no		Design No
	*			$design_part	Design PArt
	*	@return array				
	*/
	function showSRate($design_no,$design_part)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM selling_stock
				   WHERE design_no	= '$design_no' AND design_part	= '$design_part'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,					//0
					$result->design_no,				//1
					$result->design_part,			//2
					$result->sprice,				//3
					$result->unit,					//4
					$result->added_on,				//5
					$result->added_by,				//6
					$result->modified_on,			//7
					$result->modified_by			//8
					

					);
		}
		//return the data
		return $data;
	}//eof
	
	 public function getSellingRate(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM selling_stock order by added_on asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
}// eoc