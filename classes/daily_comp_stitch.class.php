<?php 
/**
*	This class is going to work with all Daily Stitch associated with category. 
*
*	@author		Safikul Islam
*	@date		April 10, 2017
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/


class DailyStitch
{

	#####################################################################################################
	#
	#										Add Daily Stitch Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Daily Stitch Records in daily_comp_stitch table.
	*
	*	@param
	*			$dcs_id					Daily Stitch Identification no.
	*			$emp_id					Employee Id
	*			$comp_no				Computer No
	*			$shift			    	Shift Day or Night
	*			$no_of_stitch			No Of Stitch
	*			$amount					Stitch costing
	*			
	*
	*	@return int
	*/
	
	// Add Daily Stitch
	function addDailyStitch($emp_id,$operator,$comp_no,$shift,$no_of_stitch,$amount,$offer,$approved_by,$order_id,$design_no,
	$note,$addedDate,$added_by,$approved)
	{
		$emp_id			   	=	mysql_real_escape_string(trim($emp_id));
		$operator			=	mysql_real_escape_string(trim($operator));
		$comp_no	        =	trim($comp_no);
		$shift				=	mysql_real_escape_string(trim($shift));
		$no_of_stitch		=	mysql_real_escape_string(trim($no_of_stitch));
		$amount		     	=	mysql_real_escape_string(trim($amount));
		$offer		     	=	mysql_real_escape_string(trim($offer));
		$approved_by		=	mysql_real_escape_string(trim($approved_by));
		$order_id		    =	mysql_real_escape_string(trim($order_id));	
		$design_no			=	mysql_real_escape_string(trim($design_no));
		$note				=	mysql_real_escape_string(trim($note));
		$added_by		    =	mysql_real_escape_string(trim($added_by));
		$addedDate		    =	mysql_real_escape_string(trim($addedDate));
		$approved		    =	mysql_real_escape_string(trim($approved));
		$modified_by		=	mysql_real_escape_string(trim($added_by));
		$modified_on		=	mysql_real_escape_string(trim($addedDate));
		//satement to insert in daily_comp_stitch table
		$insert		=   "INSERT INTO daily_comp_stitch		
						(emp_id,operator,comp_no,shift,no_of_stitch,amount,offer,approved_by,order_id,design_no,note,added_by,
						added_on,approved,modified_by,modified_on)
							
						VALUES
						('$emp_id','$operator','$comp_no','$shift','$no_of_stitch','$amount','$offer','$approved_by',
						'$order_id','$design_no','$note','$added_by','$addedDate','$approved','$modified_by','$modified_on')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$dcs_id	= mysql_insert_id();
		
		//return primary key
		return $dcs_id;

	}//eof	
		
	
	#####################################################################################################
	#
	#										Approved Stitch Data
	#
	#####################################################################################################
		
	
	//Stitch Data Approved
	function StitchApproved($dcs_id, $approved_by,$approved)
	
	{
		$dcs_id			   	   	=	mysql_real_escape_string(trim($dcs_id));
		$approved_by	        =	trim($approved_by);
		$approved				= mysql_real_escape_string(trim($approved));

		//update payment
		$edit  = "UPDATE daily_comp_stitch
				SET
				approved_by		 		= '$approved_by',
				approved				= '$approved',
				modified_on				= now()
				WHERE
				dcs_id 					= '$dcs_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	//Offer Add
	function StitchOffer($dcs_id, $offer,$modified_by)
	{
		$dcs_id			   	   	=	mysql_real_escape_string(trim($dcs_id));
		$offer	        		=	mysql_real_escape_string(trim($offer));
		$modified_by			= mysql_real_escape_string(trim($modified_by));
		//update payment
		$edit  = "UPDATE daily_comp_stitch
				SET
				offer		 			= '$offer',
				modified_by				= '$modified_by',
				modified_on				= now()
				WHERE
				dcs_id 					= '$dcs_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	//Update Stitch Data
	function editStitchData($dcs_id,$emp_id,$operator, $added_on,$modified_by)
	{
		$dcs_id			   	   	=	mysql_real_escape_string(trim($dcs_id));
		$emp_id			   	   	=	mysql_real_escape_string(trim($emp_id));
		$operator	        	=	mysql_real_escape_string(trim($operator));
		$added_on	        	=	mysql_real_escape_string(trim($added_on));
		$modified_by			= mysql_real_escape_string(trim($modified_by));
		//update payment
		$edit  = "UPDATE daily_comp_stitch
				SET
				emp_id		 				= '$emp_id',
				operator					= '$operator',
				added_on		 			= '$added_on',
				modified_by					= '$modified_by',
				modified_on					= now()
				WHERE
				dcs_id 						= '$dcs_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	#####################################################################################################
	#
	#										Delete daily_comp_stitch Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Stitch Records permanently
	*
	*	@param
	*			$dcs_id			Daily Stitch id
	*
	*	@return null
	*/
	function delDailyCompStitch($dcs_id)
	{
		//delete from daily_comp_stitch
		$delete1 = "DELETE FROM daily_comp_stitch WHERE dcs_id='$dcs_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display daily_comp_stitch Records
	#
	#####################################################################################################
	/**
	*	Get the data associated with a Daily Computer Stitch based upon the primary key
	*
	*	@param
	*			$dcs_id		Daily stitch id
	*
	*	@return array				
	*/
	function showDailyStitch($dcs_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM daily_comp_stitch
				   WHERE dcs_id	= '$dcs_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->dcs_id,		//0
					$result->emp_id,		//1
					$result->comp_no,		//2
					$result->shift,			//3
					$result->no_of_stitch,	//4
					$result->amount,		//5
					$result->approved_by,	//6
					$result->added_by,		//7
					$result->added_on,		//8
					$result->modified_by,	//9
					$result->modified_on,	//10
					$result->offer,			//11
					$result->operator		//12

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	// Display Daily Stitch all data in a array
	 public function getDailyStitch(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM daily_comp_stitch order by dcs_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	// Display today  Stitch all data in a array
	 public function getTodatStitch(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM daily_comp_stitch order by dcs_id desc limit 10") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	#####################################################################################################
	#
	#										Add Daily Stitch Details Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Daily Stitch Details Records in daily_comp_stitch table.
	*
	*	@param
	*			$dcs_id					Daily Stitch Identification no.
	*			$stitch					No of Stitch
	*			$no_of_head				No of head
	*			$offer			    	Offer Amount
	*	@return int
	*/
	
	// Add Daily Stitch
	function addDailyStitchDtls($dcs_id,$order_id,$design_no,$stitch,$no_of_head,$offer)
	{
		$dcs_id		    	=	mysql_real_escape_string(trim($dcs_id));
		$order_id		    =	mysql_real_escape_string(trim($order_id));	
		$design_no			=	mysql_real_escape_string(trim($design_no));
		$stitch				=	mysql_real_escape_string(trim($stitch));
		$no_of_head		    =	mysql_real_escape_string(trim($no_of_head));
		$offer		    =	mysql_real_escape_string(trim($offer));
		//satement to insert in daily_comp_stitch_dtls table
		$insert		=   "INSERT INTO daily_comp_stitch_dtls
						(dcs_id,order_id,design_no,stitch,no_of_head,offer)
						VALUES
						('$dcs_id','$order_id','$design_no','$stitch','$no_of_head','$offer')
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
	#										Display daily_comp_stitch Details Records
	#
	#####################################################################################################
	/**
	*	Get the data associated with a Daily Computer Stitch details based upon the primary key
	*
	*	@param
	*			$id		Daily stitch details id
	*
	*	@return array				
	*/
	function showDailyStitchDtls($id)
	{
		//declare vars
		$data = array();
		//statement
		$select = "SELECT * FROM daily_comp_stitch_dtls
				   WHERE id	= '$id'";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->id,			//0
					$result->dcs_id,		//1
					$result->order_id,		//2
					$result->design_no,		//3
					$result->stitch,		//4
					$result->no_of_head,	//5
					$result->offer			//6
					);
		}
		//return the data
		return $data;
	}//eof
		
	// Display Daily Stitch Details all data in a array
	 public function getDailyStitchDtls(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM daily_comp_stitch_dtls order by id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	// Get Operator Offer amount datewise
	 public function getStOfferSum($todate,$fromdate){
     $temp_arr = array();
     $res = mysql_query("SELECT emp_id, operator,SUM(offer) FROM daily_comp_stitch where added_on between '$todate' and '$fromdate'
	 group by emp_id") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }   
	 
	 
}//eoc

?>	