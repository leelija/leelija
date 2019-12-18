<?php 
	/**
	*	Constants defined for new user registration
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
	
	//first name & last name
	define('ERREG000', ' Name or contact person field is empty');
	define('ERREG001', ' First Name is empty');
	define('ERREG002', ' Surname is empty');
	define('ERREG013', ' Select your category');
	
	//contact + address
	define('ERREG003', ' Phone number is empty');
	define('ERREG014', ' Phone number already exits');
	define('ERREG004', ' Address is empty');	
	define('ERREG005', ' Invalid email id');
	define('ERREG006', ' Email already exists');
	define('ERREG007', ' Organization or business name is empty');
	define('ERREG008', ' Designation can not be left empty');
	define('ERREG009', ' Suburb or City or Town is empty');
	define('ERREG010', ' District is empty');
	define('ERREG011', ' State is empty');
	define('ERREG012', ' Town is empty');
	
	
	//bank account related
	define('ERREG101', ' UTR or CIS is not valid');
	define('ERREG102', ' Bank name is empty');
	define('ERREG103', ' Account number is empty'); 
	define('ERREG104', ' NI number is empty.');
	define('ERREG105', ' Sort code is empty.');
	
	
	//user agreement
	define('ERREG201', ' Please check the user agreement');
	
	
	//success message
	define('SUREG001', ' New user registration is successful');
	define('SUREG002', ' Success !!! Your registration is forwarded to our account section. We are verifying your access. Once verified you will be able to login.');
	define('SUREG003', ' Success !!! Your request to become a part of our business has been submitted. Our marketing team will get back to you soon.');
	
?>