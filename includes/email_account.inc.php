<?php 
	
	/**
	*	Constants defined for email
	*
	*	@author		Himadri Shekhar Roy
	*	@date		September 04, 2010
	*	@version	1.0
	*	@copyright	Analyze System
	*	@url		http://www.ansysoft.com
	*	@email		himadri.s.roy@ansysoft.com
	* 
	*/
	
	include_once("constant.inc.php");

	//Constant for Email
	define('ACC_EMAIL',		'accounts@garudasb.org');  
	define('ADMIN_EMAIL',	'admin@garudasb.org');
	define('CAREER_EMAIL',	'career@garudasb.org');
	define('HR_EMAIL',		'hr@garudasb.org');
	define('INFO_EMAIL',	'info@garudasb.org');
	define('JOB_EMAIL',		'jobs@garudasb.org');
	define('SUPPORT_EMAIL',	'support@garudasb.org');
	
	//define users
	define('ACC',			'Accountant');
	define('ADMIN',			'Administrator');
	define('CAREER',		'Human Resource');
	define('HR',			'Human Resource');
	define('INFO',			'Information'.' '.COMPANY_S);
	define('JOB',			'Human Resource');
	define('SUPPORT',		'Customer Support');
	define('COMPANY',		'Your Spiritual Revolution');
	
	//define email from or to
	define('EMAIL_FROM_TO_ACC', 	ACC." <".ACC_EMAIL.">");
	define('EMAIL_FROM_TO_ADMIN', 	ADMIN." <".ADMIN_EMAIL.">");
	define('EMAIL_FROM_TO_CAREER', 	CAREER." <".CAREER_EMAIL.">");
	define('EMAIL_FROM_TO_HR', 		HR." <".HR_EMAIL.">");
	define('EMAIL_FROM_TO_INFO', 	INFO." <".INFO_EMAIL.">");
	define('EMAIL_FROM_TO_JOB', 	JOB." <".JOB_EMAIL.">");
	define('EMAIL_FROM_TO_SUPPORT', SUPPORT." <".SUPPORT_EMAIL.">");
	
	
	
?>