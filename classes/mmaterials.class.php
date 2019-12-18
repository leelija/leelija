<?php 
/**
*	This class is going to work with all mmaterials associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Apr 24, 2018
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/

class Mmaterials 
{

	#####################################################################################################
	#
	#										Add Materials	
	#
	#####################################################################################################
	
	/**
	*	Add a new materials in materials table.
	*
	*	@param
	*			$id			    		Materials id	
	*			$materials_name 		mmaterials name
	*			$c_stock			    Current Stock
	*			$lastdate				Last update
	*			$remark					Remark
	
	*	@return int
	*/
	function addMmaterials($materials_name,$mat_colors,$mat_type,$mat_unit,$c_stock,$remark,$added_by)
	{
		$materials_name			=	mysql_real_escape_string(trim($materials_name));
		$mat_colors				=	mysql_real_escape_string(trim($mat_colors));
		$mat_type			   	=   mysql_real_escape_string(trim($mat_type));
		$mat_unit				=	mysql_real_escape_string(trim($mat_unit));
		$c_stock	        	=	trim($c_stock);
		$remark			   		=	mysql_real_escape_string(trim($remark));
		$added_by			  	=	mysql_real_escape_string(trim($added_by));
		//satement to insert in mmaterials table
		$insert		=   "INSERT INTO mmaterials
						(materials_name,mat_colors,mat_type,mat_unit, c_stock, lastdate, remark, added_on,added_by)
						VALUES
						('$materials_name','$mat_colors','$mat_type','$mat_unit', '$c_stock', now(), '$remark', now(),'$added_by')
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
	#										Edit mmaterials
	#
	#####################################################################################################
	/**
	*	This function edit mmaterials
	*
	*	@param
	*			$id			    		Materials id	
	*			$materials_name 		mmaterials name
	*			$c_stock			    Current Stock
	*			$lastdate				Last update
	*			$remark					Remark
	*	@return null
	*/
	function editMmaterials($id,$c_stock, $modified_by )
	
	{
		$modified_by		=	mysql_real_escape_string(trim($modified_by));
		$c_stock	        =	trim($c_stock);
		$id					= 	mysql_real_escape_string(trim($id));

		//update Materials description
		$edit  = "UPDATE mmaterials
				SET
				c_stock					= '$c_stock',
				lastdate				= now(),
				modified_on 			= now(),
				modified_by				= '$modified_by'	
				WHERE
				id 						= '$id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
	}//eof

	
	#####################################################################################################
	#
	#										Delete mmaterials
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a mmaterials permanently
	*
	*	@param
	*			$id			mmaterials id
	*
	*	@return null
	*/
	function delMmaterials($id)
	{
		//delete from product
		$delete1 = "DELETE FROM mmaterials WHERE id='$id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	
	/**
	*	Get the data associated with a mmaterials based upon the primary key
	*
	*	@param
	*			$id		mmaterials id
	*	@return array				
	*/
	function showMmaterials($id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM mmaterials
				   WHERE id	= '$id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,							//0
					$result->materials_name,				//1
					$result->mat_colors,					//2
					$result->mat_type,						//3
					$result->mat_unit,						//4
					$result->c_stock,						//5
					$result->lastdate,						//6
					$result->remark,						//7
					$result->added_on,						//8
					$result->added_by,						//9
					$result->modified_on,					//10
					$result->modified_by,					//11
					$result->image							//12
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/* Display all mmaterials data */
	 public function MmaterialDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM mmaterials order by materials_name ASC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	
	/*
	*	This funcion will return all the id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllMmaterials($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT id FROM mmaterials";
		}
		else
		{
			//statement
			$select	= "SELECT id FROM mmaterials
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
	
	
#####################################################################################################
	#
	#										 mmaterials In
	#
	#####################################################################################################
	
	/**
	*	Add a new mmaterials in mmaterials_in table.
	*
	*	@param
	*			
	*			$materials_name 			mmaterials name
	*			$mmaterials_in			    
	*
	*	@return int
	*/
	function addMmaterialsIn($mat_id,$mat_amount, $price,$gst,$totalamount,$company_id,$bill_no,$remark,$checked_by,$added_by,
	$payment_status)
	{
		$mat_id				=	mysql_real_escape_string(trim($mat_id));
		$mat_amount	        =	trim($mat_amount);
		$price				=   mysql_real_escape_string(trim($price));
		$gst				=	mysql_real_escape_string(trim($gst));
		$totalamount	    =	mysql_real_escape_string(trim($totalamount));
		$company_id			= 	mysql_real_escape_string(trim($company_id));
		$bill_no			= 	mysql_real_escape_string(trim($bill_no));
		$remark				= 	mysql_real_escape_string(trim($remark));
		$checked_by			= 	mysql_real_escape_string(trim($checked_by));
		$added_by			= 	mysql_real_escape_string(trim($added_by));
		$payment_status		= 	mysql_real_escape_string(trim($payment_status));
		//satement to insert in orders table
		$insert		=   "INSERT INTO mmaterials_in
						(mat_id, mat_amount, price, gst, totalamount, company_id, bill_no,remark,checked_by, added_on,
						added_by,payment_status)
						VALUES
						('$mat_id', '$mat_amount', '$price', '$gst', '$totalamount', '$company_id', '$bill_no',
						 '$remark','$checked_by',now(), '$added_by','$payment_status')
							
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
	*	Get the data associated with a MaterialsIn based upon the primary key
	*
	*	@param
	*			$id		mmaterials In id
	*
	*	@return array				
	*/
	function showMmaterialsIn($id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM mmaterials_in
				   WHERE id	= '$id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,				//0
					$result->mat_id,			//1
					$result->mat_amount,		//2
					$result->price,				//3
					$result->gst,				//4
					$result->totalamount,		//5
					$result->company_id,		//6
					$result->bill_no,			//7
					$result->remark,			//8
					$result->added_on,			//9
					$result->added_by,			//10
					$result->modified_on,		//11
					$result->modified_by,		//12
					$result->image,				//13
					$result->checked_by,		//14
					$result->payment_status		//15
					);
		}
		//return the data
		return $data;
	}//eof
	
	
	
	/*
	*	This funcion will return all the mmaterials_in id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllMmaterialsIn($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT id FROM mmaterials_in";
		}
		else
		{
			//statement
			$select	= "SELECT id FROM mmaterials_in
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
	
		/* Display all Material In data */
	 public function MmaterialsInDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM mmaterials_in order by added_on DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	/*
	* 	$id		= mmaterials In Id
	*			
	*	@return null
	*/
	function MmaterialsBillStatus($id,$modified_by, $payment_status )
	
	{
		$modified_by		=	mysql_real_escape_string(trim($modified_by));
		$payment_status		=	mysql_real_escape_string(trim($payment_status));
		$id					= mysql_real_escape_string(trim($id));

		//update product description
		$edit  = "UPDATE mmaterials_in
				SET
				modified_on				= now(),
				modified_by 			= '$modified_by',
				payment_status			= '$payment_status'	
				WHERE
				id 						= '$id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	
	
	
	#####################################################################################################
	#
	#										mmaterials Out
	#
	#####################################################################################################
	
	/**
	*	 mmaterials Out in mmaterials_out table.
	*
	*	@param
	*			
	*			$
	*			$mmaterials_out			    
	*
	*	@return int
	*/
	function addMmaterialsOut($mat_id,$bill_no,$design_no,$mat_amount,$purpose,$receive_by,$remark,$added_by)
	{
		$mat_id				=	mysql_real_escape_string(trim($mat_id));
		$bill_no			=	mysql_real_escape_string(trim($bill_no));
		$design_no			=	mysql_real_escape_string(trim($design_no));
		$mat_amount	        =	trim($mat_amount);
		$purpose			= mysql_real_escape_string(trim($purpose));
		$receive_by			= mysql_real_escape_string(trim($receive_by));
		$remark	    		=	trim($remark);
		$added_by			= mysql_real_escape_string(trim($added_by));
			
		//satement to insert in orders table
		$insert		=   "INSERT INTO mmaterials_out
						(mat_id,bill_no,design_no, mat_amount,purpose, receive_by, remark,added_on,added_by)
						VALUES
						('$mat_id','$bill_no','$design_no', '$mat_amount','$purpose', '$receive_by','$remark',now(),'$added_by')
							
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
	*	Get the data associated with a mmaterials out  based upon the primary key
	*
	*	@param
	*			$id		Material out id
	*
	*	@return array				
	*/
	function showMmaterialsOut($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM mmaterials_out
				   WHERE id	= '$id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,			//0
					$result->mat_id,		//1
					$result->bill_no,		//2
					$result->design_no,		//3
					$result->mat_amount,	//4
					$result->purpose,		//5
					$result->receive_by,	//6
					$result->remark,		//7
					$result->added_on,		//8
					$result->added_by,		//9
					$result->modified_on,	//10
					$result->modified_by	//11

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/*
	*	This funcion will return all the mmaterials_out id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllMmaterialsOut($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT id FROM mmaterials_out";
		}
		else
		{
			//statement
			$select	= "SELECT id FROM mmaterials_out
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
	
	/* Display all Material out data */
	 public function MmaterialsOutDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM mmaterials_out order by added_on DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	
}//eoc
?>