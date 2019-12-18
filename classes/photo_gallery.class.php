<?php 
/**
*	This class is going to work with all PhotoGAllery . 
*
*	@author		Safikul Islam
*	@date		Feb 10, 2015
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.rjfashion.in
*	@email		safikulislamwb@gmail.com
* 
*/




class PhotoGAllery 
{



/**
	*	Add image
	*	Added On: oct, 2016
	*
	*	@param
	*			$design_no		Design no
	*			$title		Image title
	*			$default	default image or not
	*
	*	@return	null
	*/
	function addPhotoGallery($design_no, $image, $default)
	{
		//echo $design_no;exit;
		$insert1	= "INSERT INTO  photo_gallery
						(design_no, image, is_default, added_on)
						VALUES
						('$design_no','$image','$default', now())
						";
		$query1		= mysql_query($insert1);
		//echo $insert1.mysql_error();exit;
		//get the product image id
		$photo_gallery_id	= mysql_insert_id();
		return $photo_gallery_id;
		
	}//eof
	

/*
	*	This funcion will return all the phot gallery id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllPhotoGl($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT photo_gallery_id FROM photo_gallery";
		}
		else
		{
			//statement
			$select	= "SELECT photo_gallery_id FROM photo_gallery
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['photo_gallery_id'];
		}
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a Photo GAllery based upon the primary key
	*
	*	@param
	*			$pgid		Photo gallery id
	*
	*	@return array				
	*/
	function showPhotoGallery($pgid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM photo_gallery
				   WHERE photo_gallery_id	= '$pgid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->photo_gallery_id,					//0
					$result->design_no,							//1
					$result->title,					//2
					$result->image,						//3
					$result->thumb_image,				//4
					$result->is_default,					//5
					$result->added_on,		//6
					$result->modified_on				//7
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof	
/**
	*	Get the data associated with a Photo GAllery based upon the design no
	*
	*	@param
	*			$pgid		Photo gallery id
	*
	*	@return array				
	*/
	function showPhotoGalleryDgn($design_no)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM photo_gallery
				   WHERE design_no	= '$design_no'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->photo_gallery_id,					//0
					$result->design_no,							//1
					$result->title,					//2
					$result->image,						//3
					$result->thumb_image,				//4
					$result->is_default,					//5
					$result->added_on,		//6
					$result->modified_on				//7
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof	
		
	
	####################################################################################################################
	#
	#													Sample Photos gallery
	#	
	####################################################################################################################
	 
/**
	*	Add Sample image
	*	Added On: Dec, 2016
	*
	*	@param
	*			$design_no		Design no
	*			$title			Title 
	*			$pprices		Products Prices 
	*			$pstatus		Products Status
	*			$default		default image or not
	*
	*	@return	null
	*/
	function addSampleGallery($factory_id,$design_no,$title,$dcolor, $pprices, $pstatus, $image, $default,$added_by)
	{
		$factory_id			   	   = mysql_real_escape_string(trim($factory_id));
		$design_no			   	   = mysql_real_escape_string(trim($design_no));
		$title			   		   = mysql_real_escape_string(trim($title));
		$dcolor			   	   	   = mysql_real_escape_string(trim($dcolor));
		$pprices			   	   = mysql_real_escape_string(trim($pprices));
		$pstatus		   		   = mysql_real_escape_string(trim($pstatus));
		$image			   		   = mysql_real_escape_string(trim($image));
		$default		   		   = mysql_real_escape_string(trim($default));
		$added_by			   	   = mysql_real_escape_string(trim($added_by));
		//echo $design_no;exit;
		$insert1	= "INSERT INTO  sample_gallery
						(factory_id,design_no, title, dcolor, pprices, pstatus, image, is_default, added_on, added_by)
						VALUES
						('$factory_id','$design_no','$title','$dcolor','$pprices','$pstatus','$image','$default', now(), '$added_by')
						";
		$query1		= mysql_query($insert1);
		//echo $insert1.mysql_error();exit;
		//get the product image id
		$sample_gallery_id	= mysql_insert_id();
		return $sample_gallery_id;
		
	}//eof
	
	
	//Update Sample Gallery
	function UpdateSampleGaqllery($sample_gallery_id,$factory_id,$design_no,$title,$dcolor, $pprices, $pstatus,$modified_by)
	{
		$factory_id			   	   = mysql_real_escape_string(trim($factory_id));
		$design_no			   	   = mysql_real_escape_string(trim($design_no));
		$title			   		   = mysql_real_escape_string(trim($title));
		$dcolor			   	   	   = mysql_real_escape_string(trim($dcolor));
		$pprices			   	   = mysql_real_escape_string(trim($pprices));
		$pstatus		   		   = mysql_real_escape_string(trim($pstatus));
		$modified_by			   = mysql_real_escape_string(trim($modified_by));
		//update Sample db
		$edit  = "UPDATE sample_gallery
				SET
				factory_id		 		= '$factory_id',
				design_no		 		= '$design_no',
				title					= '$title',
				dcolor					= '$dcolor',
				pprices					= '$pprices',
				pstatus					= '$pstatus',
				modified_by				= '$modified_by',
				modified_on				= now()
				WHERE
				sample_gallery_id 				= '$sample_gallery_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	

/*
	*	This funcion will return all the sample gallery id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllSampeGl($orderby, $orderbyType,$factory_id,$factory2_id)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT sample_gallery_id FROM sample_gallery WHERE factory_id = '$factory_id' OR factory_id = '$factory2_id'";
		}
		else
		{
			//statement
			$select	= "SELECT sample_gallery_id FROM sample_gallery WHERE factory_id = '$factory_id' OR factory_id = '$factory2_id'
					   ORDER BY ".$orderby." ".$orderbyType." limit 140";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['sample_gallery_id'];
		}
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	// Display Sample Photo Gallery all factory wise.
	 public function sPhotoAllDataFwise($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_gallery WHERE factory_id = '$factory_id' 
	 order by sample_gallery_id desc LIMIT 100 ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Display Sample Photo Gallery all factory wise.
	 public function sampPhotoAllData($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_gallery WHERE factory_id = '$factory_id' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	// Display Sample Photo Gallery all data in a array
	 public function sPhotoAllData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_gallery order by sample_gallery_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
	// Display Up Coming Sample all data in a array
	 public function sUpcomingData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_gallery where pstatus = 'Up Coming' order by sample_gallery_id desc
	 limit 5") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	 
	// Display Sample Photo latest data in a array
	 public function sPhotoLatestData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_gallery order by sample_gallery_id desc limit 5") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	
	// Display Sample Photo Gallery all data design wise
	 public function sPhotoAllDesiData($dno){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sample_gallery where design_no = '$dno' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	/**
	*	Get the data associated with a Photo GAllery based upon the primary key
	*
	*	@param
	*			$spgid		sample Photo gallery id
	*
	*	@return array				
	*/
	function showSamplePGallery($spgid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_gallery
				   WHERE sample_gallery_id	= '$spgid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->sample_gallery_id,		//0
					$result->factory_id,			//1
					$result->design_no,				//2
					$result->title,					//3
					$result->pprices,				//4
					$result->pstatus,				//5
					$result->image,					//6
					$result->thumb_image,			//7
					$result->is_default,			//8
					$result->added_on,				//9
					$result->added_by,				//10
					$result->modified_on,			//11
					$result->modified_by,			//12
					$result->dcolor					//13
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof	
/**
	*	Get the data associated with a Photo GAllery based upon the design no
	*
	*	@param
	*			$pgid		Photo gallery id
	*
	*	@return array				
	*/
	function showSampleGalleryDgn($design_no)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM sample_gallery
				   WHERE design_no	= '$design_no'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->sample_gallery_id,		//0
					$result->factory_id,			//1
					$result->design_no,				//2
					$result->title,					//3
					$result->pprices,				//4
					$result->pstatus,				//5
					$result->image,					//6
					$result->thumb_image,			//7
					$result->is_default,			//8
					$result->added_on,				//9
					$result->added_by,				//10
					$result->modified_on,			//11
					$result->modified_by,			//12
					$result->dcolor					//13
					
					);
		}
		
		//return the data
		return $data;
		
	}//eof	
		
	####################################################################################################################
	#
	#													Sample Photos gallery Details
	#	
	####################################################################################################################
	 
	/*	Add Sample photo gallery details
	*	Added On: dec, 2016
	*
	*	@param
	*			$sample_gallery_id		Sample gallery id
	*			
	*
	*	@return	null
	*/
	function addSphotoGallery($sample_gallery_id, $images)
	{
		//echo $sample_gallery_id;exit;
		$insert1	= "INSERT INTO  sgallery_details
						(sample_gallery_id, images)
						VALUES
						('$sample_gallery_id','$images')
						";
		$query1		= mysql_query($insert1);
		//echo $insert1.mysql_error();exit;
		//get the product image id
		$sgallery_dtl_id		= mysql_insert_id();
		return $sgallery_dtl_id;
		
	}//eof
	
	// Display Sample Photo Gallery Details all data in a array
	 public function sPhotoDtlsAllData($sample_gallery_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM sgallery_details where sample_gallery_id = '$sample_gallery_id' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
}	