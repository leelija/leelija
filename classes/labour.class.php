<?php 
/**
*	This class is going to work with all Labour associated with a labour details. 
*
*	@author		Safikul Islam
*	@date		Apr 30, 2015
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/




class Labour
{

	#####################################################################################################
	#
	#										Add To labour_table table
	#
	#####################################################################################################
	
	/**
	*	Add a new labour in labour table.
	*
	*	@param
	*			
	*			$labour_id			   	    labour identity code
	*			$labour_name				labour name
	*			$address			     	labour address
	*			$mobile				        mobile number
	*			$total_earn					total earn of labour
	*			$paid_amount				paid amount
	*			
	
	*	@return int
	*/
	function addLabour($final_stich_id, $labour_name,$stich_master, $address,$mobile, $total_earn, $paid_amount,$advance,$factory_id)
	
	{
		$final_stich_id			   	=	mysql_real_escape_string(trim($final_stich_id));
		$labour_name	        	=	trim($labour_name);
		$stich_master			   	= 	mysql_real_escape_string(trim($stich_master));
		$address			   		= 	mysql_real_escape_string(trim($address));
		$mobile			    		=	mysql_real_escape_string(trim($mobile));
		$total_earn		       		=	mysql_real_escape_string(trim($total_earn));
		$paid_amount		       	=	mysql_real_escape_string(trim($paid_amount));
		$advance		       		=	mysql_real_escape_string(trim($advance));
		$factory_id		       		=	mysql_real_escape_string(trim($factory_id));
		//satement to insert in stock table
		$insert		=   "INSERT INTO labour_table
						(final_stich_id,labour_name,stich_master, address, mobile, total_earn, paid_amount, advance,
						factory_id, added_on)
							
						VALUES
						('$final_stich_id','$labour_name','$stich_master', '$address', '$mobile', '$total_earn', 
						'$paid_amount','$advance', '$factory_id', now())
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$labour_id	= mysql_insert_id();
		
		//return primary key
		return $labour_id;

	}//eof
		

	
	#####################################################################################################
	#
	#										Edit labour  table
	#
	#####################################################################################################
	
	
	/**
	*	edit labour in labour table.
	*
	*	@param
	*			
	*			$labour_id			   	    labour identity code
	*			$labour_name				labour name
	*			$address			     	labour address
	*			$mobile				        mobile number
	*			$total_earn					total earn of labour
	*			$paid_amount				paid amount
	*			
	*	@return int
	*/
	function editLabour($labour_id,$final_stich_id,$labour_name,$stich_master, $address,$mobile, $total_earn, $paid_amount,$advance,
	$food_amount,$no_of_food,$prev_advance)
	
	{
		$final_stich_id			   	=	mysql_real_escape_string(trim($final_stich_id));
		$labour_name	        	=	trim($labour_name);
		$stich_master			   	= mysql_real_escape_string(trim($stich_master));
		$address			   		= mysql_real_escape_string(trim($address));
		$mobile			    		=	mysql_real_escape_string(trim($mobile));
		$total_earn		       		=	mysql_real_escape_string(trim($total_earn));
		$paid_amount		       	=	mysql_real_escape_string(trim($paid_amount));
		$advance		       		=	mysql_real_escape_string(trim($advance));
		$food_amount		       	=	mysql_real_escape_string(trim($food_amount));
		$no_of_food		       		=	mysql_real_escape_string(trim($no_of_food));
		$prev_advance		       	=	mysql_real_escape_string(trim($prev_advance));
		//update stock description
		$edit  = "UPDATE labour_table
				SET
				labour_name		 	= '$labour_name',
				final_stich_id		= '$final_stich_id',
				stich_master		= '$stich_master',
				address				= '$address',
				mobile				= '$mobile',
				total_earn 			= '$total_earn',
				paid_amount 		= '$paid_amount',
				advance 			= '$advance',
				food_amount 		= '$food_amount',
				no_of_food 			= '$no_of_food',
				prev_advance 		= '$prev_advance',
				modified_on			= now()
				WHERE
				labour_id 			= '$labour_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	function editLabouracount($labour_id,$labour_name,$stich_master, $address,$mobile,$total_earn,$advance)
	{
		$labour_name	    = trim($labour_name);
		$stich_master		= mysql_real_escape_string(trim($stich_master));
		$address			= mysql_real_escape_string(trim($address));
		$mobile			    = mysql_real_escape_string(trim($mobile));
		$total_earn			= mysql_real_escape_string(trim($total_earn));
		$advance			= mysql_real_escape_string(trim($advance));
		
		//update stock description
		$edit  = "UPDATE labour_table
				SET
				labour_name		 	= '$labour_name',
				stich_master		= '$stich_master',
				address				= '$address',
				mobile				= '$mobile',
				total_earn			= '$total_earn',
				advance				= '$advance',
				modified_on			= now()
				WHERE
				labour_id 			= '$labour_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	function labourAdvance($labour_id,$advance)
	{
		$advance		= mysql_real_escape_string(trim($advance));
		//update stock description
		$edit  = "UPDATE labour_table
				SET
				advance		 	= '$advance',
				modified_on			= now()
				WHERE
				labour_id 			= '$labour_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	// Labour Meal Charge Update
	function updateLabourFood($labour_id,$food_amount,$no_of_food, $food_rate)
	{
		$food_amount		= mysql_real_escape_string(trim($food_amount));
		$no_of_food			= mysql_real_escape_string(trim($no_of_food));
		$food_rate			= mysql_real_escape_string(trim($food_rate));
		
		//update stock description
		$edit  = "UPDATE labour_table
				SET
				food_amount		 	= '$food_amount',
				no_of_food			= '$no_of_food',
				food_rate			= '$food_rate'
				WHERE
				labour_id 			= '$labour_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	#####################################################################################################
	#
	#										Labour Advance table
	#
	#####################################################################################################
		
	/**
	*	labour adv book.
	*
	*	@param
	*			$labour_id			   	    labour identity code
	*			$adv_amount					Advance Amount
	*			$adv_by						added by
	*			$adv_date					added date
	*	@return int
	*/
	function addLabourAdv($labour_id, $adv_amount, $adv_by, $adv_date)
	{
		$labour_id			   	= mysql_real_escape_string(trim($labour_id));
		$adv_amount		   		= mysql_real_escape_string(trim($adv_amount));
		$adv_by					= mysql_real_escape_string(trim($adv_by));
		$adv_date		       	= mysql_real_escape_string(trim($adv_date));

		//satement to insert in labour adv. table
		$insert		=   "INSERT INTO labour_adv_dtls
						(labour_id,adv_amount, adv_by, adv_date)
						VALUES
						('$labour_id','$adv_amount', '$adv_by', now())
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
	*	Get the data associated with a Labour Advance  based upon the primary key
	*
	*	@param
	*			$id		Labour advance id
	*
	*	@return array				
	*/
	function showLabourAdvDtls($id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM labour_adv_dtls
				   WHERE id	= '$id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,						//0
					$result->labour_id,					//1
					$result->adv_amount,				//2
					$result->adv_by,					//3
					$result->adv_date					//4
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	//Display labour Advance
	 public function getLabourAdv(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM labour_adv_dtls order by adv_date DESC") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	/*===============================================	Labour food book  ================================================*/
	
	/**
	*	labour food book.
	*
	*	@param
	*			$labour_id			   	    labour identity code
	*			$no_of_meal					no of meal
	*			$per_meal_rate			    rate/meal
	*			$total_meal_charge			total meal charge
	*			$added_by					added by
	*			$added_on					added date
	*	@return int
	*/
	function addLabourFood($labour_id, $no_of_meal, $per_meal_rate, $total_meal_charge, $added_by)
	{
		$labour_id			   	= mysql_real_escape_string(trim($labour_id));
		$no_of_meal		   		= mysql_real_escape_string(trim($no_of_meal));
		$per_meal_rate			= mysql_real_escape_string(trim($per_meal_rate));
		$total_meal_charge		= mysql_real_escape_string(trim($total_meal_charge));
		$added_by		       	= mysql_real_escape_string(trim($added_by));

		//satement to insert in stock table
		$insert		=   "INSERT INTO labour_food_book
						(labour_id,no_of_meal, per_meal_rate, total_meal_charge, added_by, added_on)
						VALUES
						('$labour_id','$no_of_meal', '$per_meal_rate', '$total_meal_charge', '$added_by',  
							now())
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$fb_id	= mysql_insert_id();
		
		//return primary key
		return $fb_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Delete labour from labour  table
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a labour permanently
	*
	*	@param
	*			$lid			labour id
	*
	*	@return null
	*/
	function delLabour($lid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM labour_table WHERE labour_id='$lid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	
	#####################################################################################################
	#
	#										Display  Labour details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Labour based upon the primary key
	*
	*	@param
	*			$lid		labour id
	*
	*	@return array				
	*/
	function showLabour($lid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM labour_table
				   WHERE labour_id	= '$lid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->labour_id,					//0
					$result->labour_name,				//1
					$result->address,					//2
					$result->mobile,					//3
					$result->total_earn,				//4
					$result->paid_amount,				//5
					$result->added_on,					//6
					$result->added_by,					//7
					$result->modified_on,				//8
					$result->modified_by,				//9
					$result->advance,					//10
					$result->final_stich_id,			//11
					$result->stich_master,				//12
					$result->prev_advance,				//13
					$result->food_amount,				//14
					$result->no_of_food,				//15
					$result->food_rate,					//16
					$result->factory_id					//17
					);
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
	function getAllLabour($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT labour_id FROM labour_table";
		}
		else
		{
			//statement
			$select	= "SELECT labour_id FROM labour_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['labour_id'];
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
	function getAllLabourFwise($orderby, $orderbyType,$factory_id)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT labour_id FROM labour_table WHERE factory_id = '$factory_id'";
		}
		else
		{
			//statement
			$select	= "SELECT labour_id FROM labour_table WHERE factory_id = '$factory_id'
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['labour_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/*-------------------------------------------------Select Labour Details---------------------------------------*/
	
	/* Display all data */
	/*
		$pid= orders_id 
	*/
	
	 public function LabourDtlsearch($in){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM labour_table where labour_name like '%$in%'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	 public function LabourDtlDisplay(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM labour_table order by labour_name") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	 public function LabourDtlDisplayFwise($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM labour_table WHERE factory_id = '$factory_id' order by labour_name") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	/*===============================================	Labour Payment  ================================================*/
	
	/**
	*	labour payment.
	*
	*	@param
	*			$labour_id			   	    labour identity code
	*			$labour_name				labour name
	*			$payment_type			     payment_type
	*			$pay_amount				     pay_amount
	*			$payment_by					payment_by
	*			$added_on					added date
	*	@return int
	*/
	function addLabourPayment($labour_id, $labour_name, $payment_type, $pay_amount, $payment_by)
	{
		$labour_id			   = mysql_real_escape_string(trim($labour_id));
		$labour_name	       = trim($labour_name);
		$payment_type		   = mysql_real_escape_string(trim($payment_type));
		$pay_amount			   = mysql_real_escape_string(trim($pay_amount));
		$payment_by		       = mysql_real_escape_string(trim($payment_by));
		

		//satement to insert in stock table
		$insert		=   "INSERT INTO payment_table
						(labour_id,labour_name, payment_type, pay_amount, payment_by, added_on)
							
						VALUES
						('$labour_id','$labour_name', '$payment_type', '$pay_amount', '$payment_by',  
							now())
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$labour_id	= mysql_insert_id();
		
		//return primary key
		return $payment_id;

	}//eof
	
	
	#####################################################################################################
	#
	#										Display  Labour payment details
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a Labour payment  based upon the primary key
	*
	*	@param
	*			$pid		payment id
	*
	*	@return array				
	*/
	function showLabourPayment($pid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM payment_table
				   WHERE payment_id	= '$pid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->payment_id,					//0
					$result->labour_id,					//1
					$result->labour_name,							//2
					$result->payment_type,					//3
					$result->pay_amount,		//4
					$result->payment_by	,	//5
					$result->added_on		//6
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	/*
	*	This funcion will return all the product payment id for admin
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllLabourpayment($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT payment_id FROM payment_table";
		}
		else
		{
			//statement
			$select	= "SELECT payment_id FROM payment_table
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['payment_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	
	
}// eoc