<?php 
//include_once("../_config/connect.php");
//include_once("category.class.php");

/*
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
THIS CLASS CONTAINS ALL THE NOTIFICATION INFORMATION


*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

class Notification
{
	/*
	 	Add new Notification
	 
	 	Variable:
	 	title		: heading of the notification
	 	message		: content of the notification
	   
	 */
	 
	 function addNotification($title, $mesg)
	 {
		 //add security
		 $title		= trim($title);
		 $mesg		= trim($mesg);
		 
		 //statement
		 $sql		= "INSERT into notification
		 			   (title, message, added_on)
		 			   VALUES
					   ('$title', '$mesg', now())";
					   
		//execute quary
		$query		= mysql_query($sql);
		
		//get the primary key
		$result = mysql_insert_id();
		
		//return the result
		return $result;
		
	 }//eof
	 
	/*
	 	Update Notification
	 
	 	Variable:
		id			: notification id
	 	title		: heading of the notification
	 	message		: content of the notification
	   
	   @return  int
	 */

	 function updateNotification($id, $title, $mesg)
	 {
		 //add security
		 $title		= trim($title);
		 $mesg		= trim($mesg);
		 
		 //statement
		 $sql		= "UPDATE notification
					   SET
					   title	 		= '$title',
					   message			= '$mesg'
					   WHERE 
					   notification_id	= '$id'";
					   
		//execute quary
		$query		= mysql_query($sql);
		
		
	 }//eof
	 
	 /*
	 
	 	Delete Notification
		variable			
		id				: notification id
	 
	 */
	 
	 function deleteNotification($id)
	 {
		 //statement
		 $sql		= "DELETE FROM notification WHERE notification_id='$id'";
		 
		 //execute quary
		 $query		= mysql_query($sql);
	 }
	 
	
	/*
		get all notification ids 
	*/
	function getNotificationIds()
	{
		
		//statement
		$sql					= "SELECT notification_id 
								   FROM notification
								   ORDER BY added_on DESC";
		
		//execute quary
		$query 					= mysql_query($sql);
		
		$notificationIds		= array();
		
		while($result 			= mysql_fetch_array($query))
		{
			$notificationIds[]	= $result['notification_id'];
			
		}
		return $notificationIds;
		
	}
	 
	 
	
	/**
	*	Retrieve notification data
	*	
	*	@param	
	*			$id		Id of the notification
	*
	*	@return array
	*/
	function getNotificationData($id)
	{
		//declare var
		$data	= array();
		
		//create the statement
		$sql	= "SELECT * FROM notification
				   WHERE notification_id = $id
				   ";
		
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			$data = array(
						 $result->notification_id,		//0
						 $result->title,				//1
						 $result->message,				//2
						 $result->added_on,				//3
						 $result->notified_on			//4
						 );
		}
		
		//return data
		return $data;
		
	}//eof
	 
###########################################################################################################################
#
#                   							NOTIFICATION RECIPIENT
#
###########################################################################################################################

	/*
	 	Add new Notification Recipient
	 
	 	Variable:
	 	notification_id		: heading of the notification
	 	customer_id			: content of the notification
		
	    @return  int
	 */
	 
	 function addNotificationRecipient($notId, $cusId)
	 {
		 //add security
		 $title		= trim($notId);
		 $mesg		= trim($cusId);
		 
		 //statement
		 $sql		= "INSERT into notification_recipient
		 			   (notification_id, customer_id)
		 			   VALUES
					   ('$notId', '$cusId')";
					   
		//execute quary
		$query		= mysql_query($sql);
		
		//get the primary key
		$result = mysql_insert_id();
		
		//return the result
		return $result;
		
	 }//eof
	 
	/*
	 	Update Notification
	 
	 	Variable:
		id			: notification id
	 	title		: heading of the notification
	 	message		: content of the notification
	   
	 */

	 function updateNotificationRecipient($id, $notId, $cusId)
	 {
		 //add security
		 $title		= trim($notId);
		 $mesg		= trim($cusId);
		 
		 //statement
		 $sql		= "UPDATE notification_recipient
					   SET
					   notification_id	 		= '$notId',
					   customer_id				= '$cusId',
					   WHERE 
					   notification_id	= '$id'";
					   
		//execute quary
		$query		= mysql_query($sql);
		
	 }//eof
	 
	 /*
	 
	 	Delete Notification
		variable			
		id				: notification id
	 
	 */
	 
	 function deleteNotificationRecipient($id)
	 {
		 //statement
		 $sql		= "DELETE FROM notification_recipient WHERE notification_recipient_id='$id'";
		 
		 //execute quary
		 $query		= mysql_query($sql);
	 }
	 

	/*
		get all notification recipient ids  by notification id
		
		param
		$id			: notification id
		
		@return array
	*/
	function getNotRecipientIdByNotId($id)
	{
		
		//statement
		$sql					= "SELECT notification_recipient_id 
								   FROM notification_recipient
								   WHERE notification_id = '$id'";
		
		//execute quary
		$query 					= mysql_query($sql);
		
		$notRecipientIds		= array();
		
		while($result 			= mysql_fetch_array($query))
		{
			$notRecipientIds[]	= $result['notification_recipient_id'];
			
		}
		return $notRecipientIds;
		
	}
	

	/*
		get all notification ids 
	*/
	function getUserNotIds($cId, $type)
	{
		if($type== 'Unread')
		{
		//statement
		$sql					= "SELECT notification_id FROM notification_recipient
								   WHERE customer_id= '$cId'
								   AND message_read='N'
								   ORDER BY notification_recipient_id DESC";
		}
		elseif($type== 'Read')
		{
		$sql					= "SELECT notification_id FROM notification_recipient
								   WHERE customer_id= '$cId'
								   AND message_read='Y'
								   ORDER BY notification_recipient_id DESC";			
		}
		else
		{
		$sql					= "SELECT notification_id FROM notification_recipient
								   WHERE customer_id= '$cId'
								   ORDER BY notification_recipient_id DESC";				
		}
		
		//execute quary
		$query 					= mysql_query($sql);
		
		$notificationIds		= array();
		
		while($result 			= mysql_fetch_array($query))
		{
			$notificationIds[]	= $result['notification_id'];
			
		}
		return $notificationIds;
		
	}

	/*
		change message read status
		
		variable
		
		$cId		: customer id 
		$notId		: notification id
		$status		: message read status(Y or N)
	*/
	
	
	function changeMsgRead($cId, $notId, $status)
	{
		$sql		= "UPDATE notification_recipient
					   SET
					   message_read	 	= '$status'
					   WHERE 
					   customer_id		= '$cId'
					   AND
					   notification_id	= '$notId'";
					   
		//execute quary
		$query 		= mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}
	
	/**
	*	Retrieve notification recipient data
	*	
	*	@param	
	*			$id		notification recipient id
	*
	*	@return array
	*/
	function getNotRecipientData($id)
	{
		//declare var
		$data	= array();
		
		//create the statement
		$sql	= "SELECT * FROM notification_recipient
				   WHERE notification_recipient_id = $id
				   ";
		
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			$data = array(
						 $result->notification_recipient_id,		//0
						 $result->notification_id,					//1
						 $result->customer_id,						//2
						 $result->message_read,						//3
						 $result->read_on							//4
						 );
		}
		
		//return data
		return $data;
		
	}//eof
	
	/*
		get all notification recipient ids  by notification id and user id
		
		param
		$notId			: notification id
		$cusId			: customer id
		
		@return int
	*/
	function getNotRecByNotIdCusId($notId, $cusId)
	{
		
		//statement
		$sql					= "SELECT notification_recipient_id 
								   FROM notification_recipient
								   WHERE notification_id = '$notId'
								   AND  customer_id='$cusId'";
		
		//execute quary
		$query 					= mysql_query($sql);
		
		
		while($result 			= mysql_fetch_array($query))
		{
			$notRecipientId	= $result['notification_recipient_id'];
			
		}
		return $notRecipientId;
		
	}

	
}
?>