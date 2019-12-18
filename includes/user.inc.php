<?php 
	/**
	*	Constants defined for Advertiser and Administrator and Other users.
	*
	*	@author		Himadri Shekhar Roy
	*	@date		March 10, 2008
	*	@update		September 24, 2009
	*	@version	1.0
	*	@copyright	Analyze System
	*	@url		http://www.ansysoft.com
	*	@email		himadri.s.roy@ansysoft.com
	* 
	*/
	
	/**
	*	Generic message for registration 
	*/
	
	//normal alert message - 2
	define('ERU000', ' No user found');
	define('ERU001', ' Will be used to identify you on this site');
	define('ERU002', ' Will be used to correspond with you');
	define('ERU003', ' Minimum 6 Characaters Long');
	
	define('ERU100', ' No client found');
	
	//first name & last name
	define('ERU004', ' Your first name');
	define('ERU005', ' Your last name');
	define('ERU006', ' Your business or organization');
	
	
	define('ERU108', ' First name is empty.');
	define('ERU109', ' Last name is empty.');
	
	// Pijush : 21-11-2011
	define('ERU120', ' GST No  is empty.');
	define('ERU121', ' Licence No  is empty.');
	define('ERU122', ' Company Name  is empty.');
	define('ERU123', ' Address is empty.');
	define('ERU124', ' Town is empty.');
	define('ERU125', ' Province is not selected.');
	define('ERU126', ' Postal Code is empty.');
	define('ERU127', ' Phone No is empty.');
	define('ERU128', ' Retailer Type is not selected.');
	define('ERU129', ' Account Verified has not been selected.');
	define('ERU130', ' Province is not selected.');
	define('ERU131', ' No country has been selected.');
	define('ERU132', ' Mobile no is empty.');
	define('ERU133', ' Mobile no already in use.');
	define('ERU134', ' Email already in use.');
	
	//error message
	define('ERU101', ' Username: no space and have only a-z, 0-9 and underscore ( _ )');
	define('ERU102', ' Username already in use. Try another name.');
	define('ERU103', ' Invalid username.');
	define('ERU104', ' Username should be minimum 4 characters long.');
	define('ERU110', ' No user is selected.');
	define('ERU111', ' Please select I agree box after reading the Terms and Conditions.');
	define('ERU112', ' The user you are looking for, can not be found.');
	
	define('ERU113', ' Invalid email address');
	define('ERU114', ' The member id is already in use');
	
	define('ERU115', ' Designation is not selected ');
	define('ERU116', ' The member id is empty');
	define('ERU118', ' Please select customer type');
	define('ERU119', ' Please select an image');
	
	//password error
	define('ERU105', ' Password is short.'); 
	define('ERU106', ' Password is not verified.');
	define('ERU107', ' Passwords do not match.');
	define('ERU117', ' Password is short, it should be minimum 6 character long.');
	
	
	define('ERUVERF003', 'Not Verified.');
	
	//login error
	define('ERU200', ' Invalid username or password.'); 
	
	//success message
	define('SUU001', ' New user registration is successful');
	define('SUU002', ' User has been deleted from the system');
	define('SUU003', ' User information edited successfully');
	define('SUU004', ' Thanking you for your registration. ');
					  
	define('SUU005', ' You have changed your email address. A mail has sent to your new email address.	');
					   
	define('SUU006', ' Your password has been changed. A mail has sent to your email address regarding the new changes.');
	define('SUU007', ' Your information has been edited successfully');
	define('SUU008', ' Client has been added to the system');
	define('SUU009', ' Image successfully uploaded');		
	
	#######################################################################################
	
	/**
	*	Admin related alert, error and success messages
	*/			
	define('ERADM001', ' There is no administrator found');
	define('ERADM002', ' Username contain empty spaces or it is very short');
	define('ERADM003', ' None of the advertiser is selected');
	
	define('SUADM001', ' New administrative user has been created.');
	define('SUADM002', ' Administrative user information has been updated');
	define('SUADM003', ' Administrative user has been deleted.');
	define('SUADM004', ' Administrative user password has been changed.');
	
	
	#######################################################################################
	
	
	/**
	*	Constant for Advertiser
	*/
	define('ERA001', ' There is no such advertiser available');
	define('ERA002', ' None of the advertiser found');
	define('ERA003', ' None of the advertiser is selected');
	
	define('SUA001', ' New advertiser registration is successful');
	define('SUA002', ' advertiser is deleted');
	define('SUA003', ' advertiser information edited successfully');
	
	
	
	
	#################################################################################################
	
	
	
	/**
	*	Constant for Customer
	*/
	
	define('ERCUS001', ' Customer is in event entry table');
	

	
	
	################################################################################################
	
	
	/*
	*
	*		Customer Account Verification
	*
	*/
	
	
	// for error
	define('ERUVERF001', ' Account is not verified yet');
	define('ERUVERF004', ' Account verification code is empty');
	define('ERUVERF005', ' Select the checkbox below if you have provided the verfication code');

	// for success
	define('SUUVERF001', ' Account is verified');
	define('SUUVERF002', ' Account is fully verified with Verification No. ');
	
	
	/**
	*	Constant for Event Organizer
	*/
	
	define('EREVEORG000', ' No event organizer has been added yet');
	
	define('SUEVEORG002', ' Event organizer has been added');
	
	define('SUEVEORG001', ' Event organizer has been deleted');
	
	
	
	
?>