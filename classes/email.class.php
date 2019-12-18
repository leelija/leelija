<?php 
	
	/**
	*	This class send email
	*
	*	@author 		: Himadri Shekhar Roy
	*	@date   		: December 29, 2006
	*	@version		: 1.0
	*	@copyright		: Analyze System
	*	@email			: himadri.s.roy@ansysoft.com
	*/
	
	
	ini_set("include_path", 'http://www.xefarm.com/classes/class.phpmailer.php');
	require_once('encrypt.inc.php');
	require_once("class.phpmailer.php");
	require_once("class.smtp.php");

	
	
	//	Defining constant to be used to send receive email	
	define("SITE_URL_ADDR", 			'www.xefarm.com');
	define("SITE_URL_FULL", 			'http://www.xefarm.com/');
	define("SITE_NAME_S", 				'Xe Farm');
	
	define('TOEMAIL', 					'blackbox@ansysoft.com');
	define('TONAME',					SITE_NAME_S);
	
	define('FROMEMAIL', 				'info@'.SITE_URL_ADDR);
	define('FROMNAME',   				SITE_NAME_S);
	define('CONTACT_EMAIL',				'<a href="mailto:'.TOEMAIL.'">'.TOEMAIL.'</a>');
	
	
	
	//define
	define('WEBSITE',					'<a href="'.SITE_URL_FULL.'" target="_blank">'.SITE_URL_FULL.'</a>');
	define('SITENAME',					SITE_URL_ADDR);
	define('COMPANY_NAME',				SITE_URL_ADDR);
	define('SITEROOT',					SITE_URL_FULL.'/');
	
	define('IMAGEPATH',					SITEROOT."images/email/");
	define('CSS_PATH',					SITEROOT."style/style.css");
	
	define('SUBJECT_PASS',				'Forget Password');
	define('SUBJECT_REG',				'New User Registration');
	define('SUBJECT_CONTACT',			'New Registration');
	define('SUBJECT_TELL_FRIEND',		'Mail from Your Firend');
	
	define('SUBJECT_NEW_ORDER',			'New Order');
	define('SUBJECT_COMPLETE_ORDER',	'Your Order');
	define('SUBJECT_INCOMPLETE_ORDER',	'Incomplete Order');
	define('SUBJECT_ORDER_STATUS',		'Your Order Status');
	
	define('SUBJECT_NEW_EVENT',			'New Event');
	define('SUBJECT_COMPLETE_EVENT',	'Your Event');
	define('SUBJECT_INCOMPLETE_EVENT',	'Incomplete Event');
	define('SUBJECT_EVENT_STATUS',		'Your Event Status');
	
	##############################################################################################
	
	

class Email 
{
	
	##############################################################################################
	#
	#									Sending Mass Email
	#
	##############################################################################################
	
	
	/**
	*	Send mail, this function is going to send email
	*
	*	@date March 12, 2012
	*
	*	@return	NULL
	*/
	function sendEmail($to, $subject, $body, $from_name, $from_email)
	{
		//generate the from address
		$from	= $from_name."<".$from_email.">";
		
		$headers  = "From: ".$from."\n";
		$headers .= "Return-Path: <".$from_email.">\n";
		$headers .= "MIME-Version: 1.0" . "\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1"."\r\n";
		//echo $to."<br/>".$subject."<br/>".$body."<br/>";exit;				
		@mail($to,$subject,$body, $headers);
	}
	
	
	/**
	*	This function will send the news letter to all the user who has subscribed the news letter
	*   @return NULL
	*/
	function sendNewsLetter($email_list, $subject, $message)
	{
		$getLimit = explode("-",$email_list);
		$limitLower = (int)$getLimit[0];
		$limitUpper = (int)$getLimit[1];
		$sql   = "SELECT * FROM email_subscriber WHERE status = 'Y' limit $limitLower, $limitUpper ";
		$query = mysql_query($sql);
		
		# MAIL FROM
		//$from = stripslashes($this->getAutoResName())."<".stripslashes($this->getAutoResEmail()).">";
		# END OF MAIL FROM
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= $message;
		$htmlBody .= $this->bodyFooter();
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$this->getAutoResEmail().">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		
		while($result = mysql_fetch_array($query))
		{
			$full_name = $result["fname"] . " ". $result["lname"];
			$to_mail   = $result["email"];
			# MAIL TO
			$to = stripslashes($full_name)."<".stripslashes($to_mail).">";
			# END OF MAIL TO
			
			echo $to_mail."<br />".$to. "<br />".$from."<br />".$headers."<br />". $htmlBody;
			//sending email
			$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

			
		}
	}
	//End of sending news letter
	
	
	/**
	*	Send Email for registration
	*
	*
	*	@return NULL
	*/
	
	function regEmail($email,$name)
	{
		$defaultSub = SUBJECT_REG;
		$defaultMesg = "
					   <p class='blackLarge'>Thank you for registering with us.<br />
							Please standby for your account to be approved, you will be notified by email.<br />
							If you don't receive a confirmation email, please contact us.
					   </p>
					   ";                            
		
		//get the subject and detail of message
		$autoResDtl	= $this->getAutoresByCode($defaultSub, $defaultMesg, 'NEW_REGISTRATION');
		
		//get subject and message
		$subject	= $autoResDtl[0];
		$mesg		= $autoResDtl[1];
		
		
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$name.",
					  ".$mesg."
					 " ;
					
		
		
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		//$from = stripslashes($this->getAutoResName())."<".stripslashes($this->getAutoResEmail()).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes($name)."<".stripslashes($email).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$this->getAutoResEmail().">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		//echo $to."<br/>".$subject."</br/>".$htmlBody."<br/>".$this->getAutoResName()."<br/>".$this->getAutoResEmail();exit;
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

		
	}//eof
	
	/**
	*	Send Email for registration
	*	@return NULL
	*/
	function regEmailDeactive($email,$name, $cusId)
	{
		$subject = SUBJECT_REG;
		$session = session_id();
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$name.",
					<p class='blackLarge'>You have successfully registered with us, 
					but your account is not verified yet. Please contact
					our support team if you find any difficulty to verify your account.</p>
					<p>
						Please click on the below link to verify your account.<br />
						<a href=\"".SITEROOT."verify_acc.php?type=free&id=".$cusId."&email=".$email."\" 
						target=\"_blank\">
						http://www.corsanepaladventure.com/sess_id=".$session."</a>
					</p>
					" ;
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		//$from = stripslashes($this->getAutoResName())."<".stripslashes($this->getAutoResEmail()).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes($name)."<".stripslashes($email).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$this->getAutoResEmail().">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

	}//end of sending mail for registration
	
	
	/**
	*	Send Email for tell a friend
	*	
	*/
	
	function toFriendEmail($toEmail,$toName, $fromMail, $fromName)
	{
		$subject = SUBJECT_TELL_FRIEND;
		$nameArr = explode(" ",$toName);
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$nameArr[0].",
					<p class='blackLarge'>
					 I have visited ".COMPANY_NAME." website. It's really nice to browse through
					 this site. I hope you will like this site very much.<br />
					 <br /> 
					<em>Your friend ".$fromName." has invited you to visit ".WEBSITE.".
					 Have a good day with corsanepaladventure.com.</em></p>
					" ;
					
					
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		//$from = stripslashes($fromName)."<".stripslashes($fromMail).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes($toName)."<".stripslashes($toEmail).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$fromMail.">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
				//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

	}//end of sending mail to a friend
	
	/**
	*	Send Email to guest for the event
	*	
	*/
	
	function eventNotify($toEmail,$toName, $fromMail, $fromName, $subject,$message)
	{
		$subject = $subject;
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$toName.",
					<p class='blackLarge'>
					 ".$message."
					</p>
					" ;
					/*$mesg ,Below is the messages from your friend:
					<p>".$mesg."</p> */
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		//$from = stripslashes($fromName)."<".stripslashes($fromMail).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes($toName)."<".stripslashes($toEmail).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$fromMail.">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

	}//end of sending mail to a friend
	
	
	
	/*
	*	Send Email for forget password
	*	
	*/
	
	function forgetPasswordEmail($toEmail, $toName, $password)
	{
		$defaultSub = SUBJECT_PASS;
		$defaultMesg = "
					   <p class='blackLarge'>
					   		For the future use save this this email. <br /><br />
							If you have any problem regarding your login, please contact
							our support team.
					   </p>
					   ";
		
		//get the subject and detail of message
		$autoResDtl	= $this->getAutoresByCode($defaultSub, $defaultMesg, 'FORGET_PASS');
		
		//get subject and message
		$subject	= $autoResDtl[0];
		$mesg		= $autoResDtl[1];
	
		
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$toName.",
						<p class='blackLarge'> Below is your account information.<br /><br />  
					 	login id: ".$toEmail."<br />
					 	password: ".$password."<br /><br />
					 	</p>
					   ".$mesg ;
		$htmlBody .= $this->bodyFooter();
		
		
		# MAIL TO
		$to = stripslashes($toName)."<".stripslashes($toEmail).">";
		# END OF MAIL TO
		
		//echo $htmlBody;exit;
		//echo $this->getAutoResName()."<br/>";
		//echo $this->getAutoResEmail();exit;
		//sending email
		//echo $to."<br/>".$subject."<br/>".$htmlBody."<br/>".$this->getAutoResName()."<br/>".$this->getAutoResEmail();exit;
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

	}//end of sending mail forget password
	
	
	/**
	*	Send Email for contact us
	*	
	*/
	
	function contactUsEmail($fromName, $fromMail,$mesg, $subject)
	{
		$subject = $subject;
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "<p class='blackLarge'>".$mesg."</p>" ;
					
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		//$from = stripslashes($fromName)."<".stripslashes($fromMail).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes(TONAME)."<".stripslashes(TOEMAIL).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$fromMail.">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

	}//end of sending mail forget password
	
	
	
	/**
	*	Send Email for contact client, when user wants to contact client
	*	
	*/
	
	function contactClientEmail($fromName, $fromMail,$mesg, $subject, $toName, $toEmail)
	{
		$subject = $subject;
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "<p class='blackLarge'>".$mesg."</p>" ;
					
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		//$from = stripslashes($fromName)."<".stripslashes($fromMail).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes($toName)."<".stripslashes($toEmail).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$fromMail.">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());
	}//end of sending mail forget password
	
	########################################################################################################################
	#
	#								Mail from admin to the customer for different purposes
	#
	########################################################################################################################
	
	/**
	*	Send Email to customer
	*	
	*/
	
	function cusEmail($email,$name,$subject,$mesg)
	{
		$subject = $subject;
		 //get autores detail
        $autoresId    = $this->getActiveAutoResId();
		$setUp        = $this->getAutoResponderSetupData($autoresId);
		
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "<p class='blackLarge'>".addslashes(trim($mesg))."</p>" ;
					
		$htmlBody .= $this->bodyFooter();
		
		# MAIL TO
		$to = stripslashes($name)."<".stripslashes($email).">";
		# END OF MAIL TO
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());
		
		
	}//end of sending mail to customer
	
	
	/**
	*	Send Email for registration
	*	
	*/
	
	function cusNotifyOrdStat($email,$name,$subject,$mesg)
	{
		
		$subject = $subject;
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "<p class='blackLarge'>".$mesg."</p>" ;
					
		$htmlBody .= $this->bodyFooter();
		
		
		# MAIL TO
		$to = stripslashes($name)."<".stripslashes($email).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());
		
	}//end of sending mail to customer
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	//	Mail for order and order payment
	//
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Send Email for placing order
	*	
	*/
	
	function newOrder($email,$name,$order_no)
	{
		
		$subject = SUBJECT_NEW_ORDER;
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$name.",
					<p class='blackLarge'>
					Thanking you for placing ads with corsanepaladventure.com.
					Your order number is: <em>".$order_no."</em>.
					We are processing your order. 
					<br /><br />
					If your order includes banner ads, it will take 
					24-48 hours to validate the banner image. 
					After the approval from the administrator your 
					banner will be displayed.
					</p>" ;
		$htmlBody .= $this->bodyFooter();
		
		
		# MAIL TO
		$to = stripslashes($name)."<".stripslashes($email).">";
		# END OF MAIL TO
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());
		
	}//end of sending mail for incomplete order
	
	
	/**
	*	Send Email for incomplete order
	*	
	*/
	
	function incompleteOrder($email,$name,$order_no)
	{
		
		$defaultSub = SUBJECT_INCOMPLETE_ORDER;
		$defaultMesg = "
					   <p class='blackLarge'>You are receiving this mail, as your payment for 
						the order 
						is incomplete. Please ignore this mail if you paid. In case you haven't paid,
						you can make a payment through this order number after log in into your account.
					   </p>
					   ";
		
		//get the subject and detail of message
		$autoResDtl	= $this->getAutoresByCode($defaultSub, $defaultMesg, 'NEW_REGISTRATION');
		
		//get subject and message
		$subject	= $autoResDtl[0];
		$mesg		= $autoResDtl[1];
		
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$name.",
					<p class='blackLarge'>
					Your Order Number is: <em>".$order_no."</em> </p>
					
					".$mesg ;
		$htmlBody .= $this->bodyFooter();
		
		
		# MAIL TO
		$to = stripslashes($name)."<".stripslashes($email).">";
		# END OF MAIL TO
		
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());
	}//end of sending mail for incomplete order
	
	
	/**
	*	Send Email for payment confirmation
	*	
	*/
	
	function completeOrder($email,$name,$order_no)
	{
		
		$subject = SUBJECT_COMPLETE_ORDER;
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$name.",
					<p class='blackLarge'>
					Thanking you for your payment for
					the order <em>".$order_no."</em>.
					We are processing your order. If your order includes banner ads, it will take 
					24-48 hours to validate the banner image. After the approval from the administrator your 
					banner will be displayed.
					</p>" ;
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		//$from = stripslashes($this->getAutoResName())."<".stripslashes($this->getAutoResEmail()).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes($name)."<".stripslashes($email).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$this->getAutoResEmail().">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

	}//end of sending mail for incomplete order
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	//	Mail for add event and paid event
	//
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Send Email for incomplete event after adding event
	*	
	*/
	
	function incompleteEvent($email,$name,$event_name)
	{
		
		$subject = SUBJECT_INCOMPLETE_EVENT;
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$name.",
					<p class='blackLarge'>
					You are receiving this mail, as your payment for 
					the event <em>".$event_name."</em> 
					is incomplete. Please ignore this mail if you paid. In case you haven't paid,
					you can make a payment after log in into your account.
					</p>" ;
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		//$from = stripslashes($this->getAutoResName())."<".stripslashes($this->getAutoResEmail()).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes($name)."<".stripslashes($email).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$this->getAutoResEmail().">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

	}//end of sending mail for incomplete order
	
	
	/**
	*	Send Email for payment confirmation
	*	
	*/ 
	
	function completeEvent($email,$name,$event_name)
	{
		
		$subject = SUBJECT_COMPLETE_EVENT;
		
		$htmlBody = $this->bodyHeader();
		$htmlBody .= "Dear ".$name.",
					<p class='blackLarge'>
					Thanking you for your payment for
					the event <em>".$event_name."</em>.
					You will be able to notify your guest for this event from your account.
					</p>" ;
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		//$from = stripslashes($this->getAutoResName())."<".stripslashes($this->getAutoResEmail()).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes($name)."<".stripslashes($email).">";
		# END OF MAIL TO
		
		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$this->getAutoResEmail().">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());

	}//end of sending mail for incomplete order
	
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Creating mail body and footer
	*/
	function bodyHeader()
	{
		//creating the body header
		$bodyHead = 
		'
			<div style="width: 100%; height:auto; font:normal 13px Georgia, Times, Arial, Verdana, sans-serif;
						color: #000000; bachground-color:#fff;">
				<div style="padding:10px; margin:0px auto;" align="center">
					<img src="http://www.xefarm.com/images/site/logo.png" height="'.LOGO_HEIGHT.'" width="'.LOGO_WIDTH.'" 
					 alt="'.LOGO_ALT.'" />
				</div>
				
				<div style="width: 650px; height:auto; margin:5px auto 10px auto; padding:20px 10px;
							font:normal 12px Helvetica, Arial, Verdana, sans-serif;
							color: #000000; bachground-color:#FCFCFC; -moz-border-radius: 4px; -webkit-border-radius: 4px;
							border:1px solid #eee;">';
				
		//return the body header
		return $bodyHead;
		
	}//end of creating body header
	
	function bodyFooter()
	{
		//create the email body footer
		$bodyFoot = 
		'
				<p>	
					'.$this->getAutoResFooter().'			
				</p>
			</div>
		</div>
		';
		
		//return the body footer
		return $bodyFoot;
		
	}//end of creating footer
	
	
	#####################################################################################################################
	#
	#										Get Autoresponder
	#
	#####################################################################################################################
	
	
	/**
	* 	Add Email Autoresponder Setup
	*	
	*	@param
	*			$email_from			email from
	*			$footer				Footer
	*			
	*	@return	int
	*/
	function addAutoResponderSetup($name, $email_from, $footer, $status)
	{
		//declare var
		$result	= 0;
		
		//add security
		$footer	= trim(mysql_real_escape_string($footer));
		
		//statement
		$sql 	= "INSERT INTO email_autores_setup
				  (name,email_from, footer, status, added_on)
				  VALUES
				  ('$name', '$email_from', '$footer', '$status', now())";
				  
		//execute query		  
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		//get the primary key
		$result = mysql_insert_id();
		
		//return the result
		return $result;
		
	}//eof

	
	
	
	/**
	*	Update 	Autoresponder setup
	*	
	*	@param
	*			$id					Primary key of the email_autores_setup
	*			$email_from			email from
	*			$footer				footer
	*
	*	@return string
	*/
	function updateAutoResponderSetup( $id, $name, $email_from, $footer, $status)
	{
		//add security
		$footer	= trim(mysql_real_escape_string($footer));
		
		
		$sql	= "UPDATE email_autores_setup SET
				   name			= '$name',
				   email_from	= '$email_from',
				   footer		= '$footer',
				   status		= '$status',
				   modified_on 	=  now()
				   WHERE 
				   email_autores_setup_id 	= '$id'
				  ";
		$query	= mysql_query($sql);
		 
		$result = '';
		if(!$query)
		{
			$result = "ER102";
		}
		else
		{
			$result = "SU102";
		}
		
		//return the result
		return $result;
		
	}//eof
	
	
	
	
	/**
	*	Delete a Autoresponder from the database
	*
	*	@param 
	*			$id			Primary key of the email_autoresponder
	*
	*	@return string
	*/
	function deleteAutoResponderSetup($id)
	{
		//declare var
		$result = '';
		
		//delete from navigation
		$sql	= "DELETE FROM email_autores_setup WHERE email_autores_setup_id='$id'";
		
		//execute the query
		$query	= mysql_query($sql);
		
		
		if(!$query)
		{
			$result = "ER103";
		}
		else
		{
			$result = "SU103";
		}
		
		//return the result
		return $result;
		
	}//eof
	
	
	/**
	*	Retrieve all Autoresponder id 
	*
	*	@return array
	*/
	function getAutoResponderSetupId()
	{
		//declare var
		$data	= array();
		
		//statement
		$sql	= "SELECT 	email_autores_setup_id 
				   FROM 	email_autores_setup 
				   ORDER BY added_on DESC";
		
		//execute query
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->email_autores_setup_id;
			}
		}
		
		
		//return the array
		return $data;
		
	}//eof
	
	
	
	/**
	*	Retrieve all Auto Responder data
	*
	*	@param	
	*			$id		Primary key of the email_autoresponder
	*
	*	@return array
	*/
	function getAutoResponderSetupData($id)
	{
		//declare var
		$data	= array();
		
		//create the statement
		$sql	= "SELECT * FROM email_autores_setup WHERE email_autores_setup_id= '$id' ";
		
		//execute query
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query) > 0)
		{
			//fetch the data
			$result = mysql_fetch_object($query);
			
			//add data to array
			$data = array(
						 $result->email_from,	//0
						 $result->footer,		//1
						 $result->added_on,		//2
						 $result->modified_on,	//3
						 $result->status,		//4
						 $result->name			//5
						 );
		}
		
		//return the array
		return $data;
		
	}//eof
	
	
		
	/**
    *    Get Autoresponder id
    */
    function getActiveAutoResId()
    {
		//declare var
        $data    = 0;
       
        //statement
        $sql     = "SELECT * FROM email_autores_setup WHERE status = 'a'";
       
        //execute query
        $query     = mysql_query($sql);
       
        if(mysql_num_rows($query) > 0)
        {
			//fetch data
            $result    = mysql_fetch_object($query);
           
		   	//get the result
            $data    = $result->email_autores_setup_id;
        }
		
		//return the result
		return $data;
		
    }//eof
	
	
	/**
	*	Get latest active autoresponder setup detail
	*
	*	@return array
	*/
	function getLAASDtl()
	{
		//declare var
        $name        	= '';
		$email		 	= '';
		$footer			= '';
        $autoresId     	= 0;
        $autoResDtl    	= array();
		$actAutoResDtl  = array($name, $email, $footer);
       
        //get autores detail
        $autoresId    = $this->getActiveAutoResId();
       
        //autores setup dtl
        $autoResDtl    = $this->getAutoResponderSetupData($autoresId);
		
		if(count($autoResDtl) > 0)
		{
			//create the active autores
			$actAutoResDtl = array($autoResDtl[5], $autoResDtl[0], $autoResDtl[1]);
		}
		
		//return the autores dtl
		return $actAutoResDtl;
		
	}//eof
   
   
    /**
    *    Get Name
    *
    *    @return string   
    */
    function getAutoResName()
    {
        //declare var
        $name    = '';
        
        //get autores dtl
        $laDtl   = $this->getLAASDtl();
		$name	 = $laDtl[0];
       
        //return the value
        return $name;
		
    }//eof
   
    
    /**
    *    Get footer
    *
    *    @return string   
    */
    function getAutoResEmail()
    {
        //declare var
        $email   = '';
       
        //get autores dtl
		$laDtl   = $this->getLAASDtl();
        $email   = $laDtl[1];
       
        //return the value
        return $email;
		
    }//eof

	
   
    /**
    *    Get footer
    *
    *    @return string   
    */
    function getAutoResFooter()
    {
        //declare var
        $footer    = '';
       
        //get autores dtl
		$laDtl     = $this->getLAASDtl();
        $footer    = $laDtl[2].
					'	</div>
			
					</div>';
       
        //return the value
        return $footer;
		
    }//eof
	
	
	
	
	##############################################################################################################
	#
	#										Auto Responder Email
	#
	##############################################################################################################

	
	
	/**
	* 	Add Autoresponder Email
	*	
	*	@param
	*			$email_subject		Subject of the email
	*			$constant_code		Autoresponder code
	*			$message			Message
	*			$send_option		Options are imadiately or later
	*			$send_date			email send date
	*			$status				Status active or inactive
	*			
	*	@return	int
	*/
	function addAutoRespoder($email_send_to, $email_subject, $email_autoresponder_type_id, $message, $send_option, $send_date, $status )
	{
		//add security
		$message			= mysql_real_escape_string(trim($message));
		
		//statement
		$sql 	= "INSERT INTO email_autoresponder
				  (email_send_to, email_subject, email_autoresponder_type_id, message, send_option, send_date, status, added_on)
				  VALUES
				  ('$email_send_to', '$email_subject', '$email_autoresponder_type_id','$message', '$send_option', 
				   '$send_date','$status', now())";
			//echo $sql.mysql_error();exit;	  
		//execute query		  
		$query	= mysql_query($sql);
		
		//get the primary key
		$result = mysql_insert_id();
		
		//return the result
		return $result;
		
	}//eof
	
	
	
	/**
	*	Update 	Autoresponder email
	*	
	*	@param
	*			$id					Primary key of the email_autoresponder
	*			$email_subject		Subject of the email
	*			$message			Message of the email
	*			$send_option		send options are imidiately or later
	*			$send_date			email send date
	*
	*	@return string
	*/
	function updateAutoRespoder( $id, $email_send_to, $email_subject, $email_autoresponder_type_id, $message, $send_option, $send_date, $status)
	{
		//add security
		$message			= mysql_real_escape_string(trim($message));
		
		$sql	= "UPDATE email_autoresponder SET
				   email_send_to	= '$email_send_to',
				   email_subject	= '$email_subject',
				   email_autoresponder_type_id	= '$email_autoresponder_type_id',
				   message			= '$message',
				   send_option		= '$send_option',
				   send_date		= '$send_date',
				   status			= '$status',
				   modified_on 		=  now()
				   WHERE 
				   email_autoresponder_id 	= '$id'
				  ";
		$query	= mysql_query($sql);
		 
		$result = '';
		if(!$query)
		{
			$result = "ER102";
		}
		else
		{
			$result = "SU102";
		}
		
		//return the result
		return $result;
		
	}//eof
	
	
	
	
	/**
	*	Delete a Autoresponder from the database
	*
	*	@param 
	*			$id			Primary key of the email_autoresponder
	*
	*	@return string
	*/
	function deleteAutoResponder($id)
	{
		
		//delete from navigation
		$sql	= "DELETE FROM email_autoresponder WHERE email_autoresponder_id='$id'";
		//execute the query
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = "ER103";
		}
		else
		{
			$result = "SU103";
		}
		
		//return the result
		return $result;
		
	}//eof
	
	
	/**
	*	Retrieve all Autoresponder id 
	*
	*	@return array
	*/
	function getAutoResponderId()
	{
		
		//declare var
		$data	= array();
		
		//statement
		$sql	= "SELECT email_autoresponder_id FROM email_autoresponder ORDER BY added_on";
		
		//execute query
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->email_autoresponder_id;
			}
		}
		
		//return the array
		return $data;
		
	}//eof
	
	
	
	/**
	*	Retrieve all Auto Responder data
	*
	*	@param	
	*			$id		Primary key of the email_autoresponder
	*
	*	@return array
	*/
	function getAutoResponderData($id)
	{
		//declare var
		$data	= array();
		
		//create the statement
		$sql	= "SELECT * FROM email_autoresponder WHERE email_autoresponder_id= '$id' ";
		
		//execute query
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_object($query);
			$data = array(
						 $result->email_send_to,				//0
						 $result->email_subject,				//1
						 $result->email_autoresponder_type_id,	//2
						 $result->message,						//3
						 $result->send_option,					//4
						 $result->send_date,					//5
						 $result->status,						//6
						 $result->added_on,						//7
						 $result->modified_on					//8
						 );
		}
		
		//return the array
		return $data;
		
	}//eof
	
	/**
	*	Get latest auto responder detail
	*
	*	@param
	*			$defaultSub				Default subject of the auto responder
	*			$defaultMesg			Default message of the autoresponder
	*			
	*	@return array
	*/
	function getLatestAutoresponder($defaultSub, $defaultMesg)
	{
		//decalre var
		$resArr		= array($defaultSub, $defaultMesg);
		$resIds		= array();
		$resData 	= array();
		$resId		= 0;
		
		//get all ids
		$resIds	= $this->getAutoResponderId();
		
		if(count($resIds) > 0)
		{
			//get the latest one
			$resId	= $resIds[0];
			
			//get the responder detail
			$resData	= $this->getAutoResponderData($resId);
			
			//build the responder array
			$resArr		= array($resData[1], $resData[2]);
		}
		
		
		//return the message
		return $resArr;
		
	}//eof
	
	/*
	*
	*	get autoresponder list 
	*
	*/
	
	function getAutoresponderList($autoResId, $type)
	{
		//declare vars
		$data	= array();
		$data1	= array();
		$data2	= array();
		
		if($type == 'all')
		{
			//statement
			$select = "SELECT * FROM email_autoresponder WHERE email_autoresponder_type_id='$autoResId' ORDER BY added_on ASC";
			//echo $select.mysql_error();exit;
			//execute statement
			$query  = mysql_query($select);
			
			while($result = mysql_fetch_array($query))
			{
				//get the autoresponder ids
				$data1[]	=  $result['email_autoresponder_type_id'];
				$autoResId		=  $result['email_autoresponder_type_id'];
				
				//staement to get products
				$select2 = "SELECT email_autoresponder_id FROM email_autoresponder 
						   WHERE email_autoresponder_type_id='".$result['email_autoresponder_type_id']."'
						   ORDER BY added_on ASC";
						   
				
				//execute statement
				$query2  = mysql_query($select2);
				
				//get the results
				while($result2 = mysql_fetch_array($query2))
				{
					//get the product ids
					$autoResponId = $result2['email_autoresponder_id'];
					
					//hold in array
					$data[] = $autoResponId;
				}
				
				//call the function again
				$this->getAutoresponderList($result['email_autoresponder_type_id'], 'all');
			}
		}
		else
		{
			//get the product
			$autoresponds = $this->getAutoresByTypeId($autoResId);
			
			
			//get the values in variable 
			$data	  = $autoresponds;
		}
		
		
		//return the values
		return $data;
		
	}//eof


	###################################################################################################################
	#
	#
	#
	###################################################################################################################
	
	/**
	* 	Add Autoresponder Type
	*	
	*	@param
	*			$title					Title of the autoresponder type
	*			$constant_code			Constant code of aaaaautoresponder type
	*			$description			Description
	*			
	*	@return	int
	*/
	function addAutoRespoderType($title, $constant_code, $description, $status )
	{
		//add security
		$description			= mysql_real_escape_string(trim($description));
		
		//statement
		$sql 	= "INSERT INTO email_autoresonder_type
				  (title, constant_code, description, status, added_on)
				  VALUES
				  ('$title', '$constant_code','$description', '$status', now())";
			//echo $sql.mysql_error();exit;	  
		//execute query		  
		$query	= mysql_query($sql);
		
		//get the primary key
		$result = mysql_insert_id();
		
		//return the result
		return $result;
		
	}//eof
	
	
	
	/**
	*	Update 	Autoresponder Type
	*	
	*	@param
	*			$id					Primary key of the email_autoresonder_type table
	*			$title				Title of the email autoresponder type
	*			$constant_code		Constant code 
	*			$description		Description
	*
	*	@return string
	*/
	function updateAutoRespoderType( $id, $title, $constant_code, $description, $status)
	{
		$description			= mysql_real_escape_string(trim($description));
		
		//create the statement
		$sql	= "UPDATE email_autoresonder_type SET
				   title			= '$title',
				   constant_code	= '$constant_code',
				   description		= '$description',
				   status			= '$status',
				   modified_on 		=  now()
				   WHERE 
				   email_autoresponder_type_id 	= '$id'
				  ";
				  
		//execute the query			  
		$query	= mysql_query($sql);
		 
		$result = '';
		if(!$query)
		{
			$result = "ER102";
		}
		else
		{
			$result = "SU102";
		}
		
		//return the result
		return $result;
		
	}//eof
	
	
	
	
	/**
	*	Delete a Autoresponder type from the database
	*
	*	@param 
	*			$id			Primary key of the email_autoresonder_type
	*
	*	@return string
	*/
	function deleteAutoResponderType($id)
	{
		
		//delete from email_autoresonder_type table
		$sql	= "DELETE FROM email_autoresonder_type WHERE email_autoresponder_type_id='$id'";
		
		//execute the query
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = "ER103";
		}
		else
		{
			$result = "SU103";
		}
		
		//return the result
		return $result;
		
	}//eof
	


	/**
	*	Returns the autoresponder ids belongs to a category
	*
	*	@param
	*			$catId		Category id
	*
	*	@return	array
	*/
	function getAutoresByTypeId($autoResId)
	{
		//initialize vars
		$data	= array();
		
		//statement
		$select = "SELECT 	* 
				   FROM 	email_autoresponder 
				   WHERE 	email_autoresponder_type_id='$autoResId'
				   ORDER BY status ASC, added_on DESC ";
		
		//execute statement
		$query  = mysql_query($select);
		
		//check if products are there
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['email_autoresponder_id'];
			}
		}
		
		//return the data
		return $data;
	}//eof
	

	
	
	/**
	*	Retrieve all Autoresponder type id 
	*
	*	@return array
	*/
	function getAutoResponderTypeId()
	{
		
		//declare var
		$data	= array();
		
		//statement
		$sql	= "SELECT email_autoresponder_type_id FROM email_autoresonder_type ORDER BY added_on";
		
		//execute query
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->email_autoresponder_type_id;
			}
		}
		
		
		//return the array
		return $data;
		
	}//eof
	
	
	
	
	
	/**
	*	Retrieve all autoresponder type id by code
	*
	*	@param
	*			$autoresCode			Autoresponder constant code
	*
	*	@return int
	*/
	function getAutoresTypeIdByCode($autoresCode)
	{
		
		//declare var
		$data	= 0;
		
		//statement
		$sql	= "SELECT 	email_autoresponder_type_id 
				   FROM 	email_autoresonder_type 
				   WHERE	constant_code = '$autoresCode'
				   ORDER BY added_on";
		 
		//execute query
		$query	= mysql_query($sql);
		
		
		if(mysql_num_rows($query) > 0)
		{
			//fetch the row
			$result = mysql_fetch_object($query);
			
			//get the data
			$data = $result->email_autoresponder_type_id;
			
		}
		
		//return the id val
		return $data;
		
	}//eof
	
	
	
	
	
	/**
	*	Retrieve all Auto Responder type data
	*
	*	@param	
	*			$id		Primary key of the email_autoresonder_type
	*
	*	@return array
	*/
	function getAutoResponderTypeData($id)
	{
		//create the statement
		$sql	= "SELECT * FROM email_autoresonder_type WHERE email_autoresponder_type_id= '$id' ";
		
		//execute the query
		$query	= mysql_query($sql);
		
		//declare the array
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_object($query);
			$data = array(
						 $result->title,			//0
						 $result->constant_code,	//1
						 $result->description,		//2
						 $result->status,			//3
						 $result->added_on,			//4
						 $result->modified_on		//5
						 );
		}
		
		//return the array
		return $data;
		
	}//eof
	
	
	
	/**
	*	Get  Autoresponder subject and detail by autoresponder code
	*
	*	@param
	*			$res_code				Autoresponder code
	*			
	*	@return	array		
	*/
	function getAutoresByCode($defaultSub, $defaultMesg, $res_code)
	{
		//declare var
		$subject	= '';
		$detail		= '';
		$autoResDtl	= array($subject, $detail);
		
		
		//get autoresponder id
		$aId	= $this->getAutoresTypeIdByCode($res_code);
		
		if($aId > 0)
		{
			//get the autoresponder id
			$autoresIds	= $this->getAutoresByTypeId($aId);
			
			if(count($autoresIds) > 0)
			{
				//get the single id
				$autoResId	= $autoresIds[0];		
				
				//get the detail
				$autoResDtl	= $this->getAutoResponderData($autoResId);
				
				//get the autores detail
				$autoResDtl	= array($autoResDtl[1], $dautoResDtl[3]);
			}
			else
			{
				$autoResDtl	= array($defaultSub, $defaultMesg);
			}
			
		}
		else
		{
			$autoResDtl	= array($defaultSub, $defaultMesg);
		}
		
		//return the autores detail
		return $autoResDtl;
		
	}//end of email


	/**
	*	Send Email for contact farmer, when a businessman wants to contact him
	*	
	*/
	
	function contactFarmerEmail($fromName, $fromMail,$mesg, $subject, $toName, $toEmail)
	{
		
		$htmlBody = $this->bodyHeader();
		
		$htmlBody .= "Dear <em>".$toName."</em>,
					<p class='blackLarge'>
					You are receiving this mail, as you are a customer of our site. 
					You have an contact from <em>".$fromName."</em> .Below is the full message. <br/><br/>";
		$htmlBody .= "<p class='blackLarge'>".$mesg."</p>" ;
					
		$htmlBody .= $this->bodyFooter();
		
		# MAIL FROM
		$from = stripslashes($fromName)."<".stripslashes($fromMail).">";
		# END OF MAIL FROM
		
		# MAIL TO
		$to = stripslashes($toName)."<".stripslashes($toEmail).">";
		# END OF MAIL TO

		#FROM HEADER DECLARATION
		//$headers = "From: ".$from."\n";
		//$headers .= "Return-Path: <".$fromMail.">\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1";
		
		//sending email
		$this->sendEmail($to, $subject, $htmlBody, $this->getAutoResName(), $this->getAutoResEmail());
	}
	
}//end of class	
?>