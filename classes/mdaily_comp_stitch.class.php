<?php 
/**
*	This class is going to work with all Daily Stitch associated with category. 
*
*	@author		Safikul Islam
*	@date		Oct 24, 2017
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/


class MDailyStitch
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
	function addmDailyStitch($emp_id,$operator,$comp_no,$computer_type,$shift,$no_of_stitch,$amount,$offer,$approved_by,$order_id,$design_no,
	$note,$addedDate,$added_by,$approved)
	{
		$emp_id			   	=	mysql_real_escape_string(trim($emp_id));
		$operator			=	mysql_real_escape_string(trim($operator));
		$comp_no	        =	trim($comp_no);
		$computer_type		=	mysql_real_escape_string(trim($computer_type));
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
		//satement to insert in daily_comp_stitch table
		$insert		=   "INSERT INTO mdaily_comp_stitch
						(emp_id,operator,comp_no,computer_type,shift,no_of_stitch,amount,offer,approved_by,order_id,design_no,note,added_by,
						added_on,approved)
							
						VALUES
						('$emp_id','$operator','$comp_no','$computer_type','$shift','$no_of_stitch','$amount','$offer','$approved_by',
						'$order_id','$design_no','$note','$added_by','$addedDate','$approved')
							
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
	function mStitchApproved($dcs_id, $approved_by,$approved)
	
	{
		$dcs_id			   	   	=	mysql_real_escape_string(trim($dcs_id));
		$approved_by	        =	trim($approved_by);
		$approved				= mysql_real_escape_string(trim($approved));

		//update payment
		$edit  = "UPDATE mdaily_comp_stitch
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
	
	
	//Update Stitch Data
	function updatemDailyStitch($dcs_id,$emp_id,$operator,$comp_no,$computer_type,$shift,$no_of_stitch,$amount,$offer,$approved_by,$order_id,$design_no,
	$note,$added_on,$modified_by,$approved)
	{
		$emp_id			   	=	mysql_real_escape_string(trim($emp_id));
		$operator			=	mysql_real_escape_string(trim($operator));
		$comp_no	        =	trim($comp_no);
		$computer_type		=	mysql_real_escape_string(trim($computer_type));
		$shift				=	mysql_real_escape_string(trim($shift));
		$no_of_stitch		=	mysql_real_escape_string(trim($no_of_stitch));
		$amount		     	=	mysql_real_escape_string(trim($amount));
		$offer		     	=	mysql_real_escape_string(trim($offer));
		$approved_by		=	mysql_real_escape_string(trim($approved_by));
		$order_id		    =	mysql_real_escape_string(trim($order_id));	
		$design_no			=	mysql_real_escape_string(trim($design_no));
		$note				=	mysql_real_escape_string(trim($note));
		$modified_by		=	mysql_real_escape_string(trim($modified_by));
		$added_on		    =	mysql_real_escape_string(trim($added_on));
		$approved		    =	mysql_real_escape_string(trim($approved));
		//update payment
		$edit  = "UPDATE mdaily_comp_stitch
				SET
				emp_id		 			= '$emp_id',
				operator				= '$operator',
				comp_no		 			= '$comp_no',
				computer_type			= '$computer_type',
				shift		 			= '$shift',
				no_of_stitch			= '$no_of_stitch',
				amount		 			= '$amount',
				offer		 			= '$offer',
				approved_by				= '$approved_by',
				order_id		 		= '$order_id',
				design_no				= '$design_no',
				note		 			= '$note',
				modified_by				= '$modified_by',
				added_on		 		= '$added_on',
				approved				= '$approved',
				modified_on				= now()
				WHERE
				dcs_id 					= '$dcs_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	#####################################################################################################
	#
	#										Delete mdaily_comp_stitch Records
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
	function delmDailyCompStitch($dcs_id)
	{
		//delete from mdaily_comp_stitch
		$delete1 = "DELETE FROM mdaily_comp_stitch WHERE dcs_id='$dcs_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display mdaily_comp_stitch Records
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
	function showmDailyStitch($dcs_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM mdaily_comp_stitch
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
					$result->computer_type,	//11
					$result->order_id,		//12
					$result->design_no,		//13
					$result->note,			//14
					$result->operator,		//15
					$result->offer			//16

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	// Display Daily Stitch all data in a array
	 public function getmDailyStitch(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM mdaily_comp_stitch WHERE added_on BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() order by dcs_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	// Display today  Stitch all data in a array
	 public function getmTodatStitch(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM mdaily_comp_stitch order by dcs_id desc limit 30") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
}//eoc

?>	