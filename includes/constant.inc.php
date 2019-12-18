<?php 
	
	//website related
	define('URL', 				"http://rjfashion.in/");	//http://www.freshfarm.in/
	define('URL_LOCAL', 		"http://rjfashion.in/");	//http://xefarm.com/
	define('URL_S', 			"rjfashion.in");
	define('PAGE',				$_SERVER['PHP_SELF']);
	define('ADM_PATH',  		URL.'/admin/');								
	define('LOCALPATH',  		'org/farm/');
	
	define('SITE_EMAIL', 		"safikulislamwb@gmail.com");
	
	define('CURRENCY',			'$');
	define('START_YEAR',		'20145');
	define('END_YEAR',  		date('Y') + 2); 
	define('HOME',				'Home');
		
	//company
	define('COMPANY_S', 		'MoniEnterprises');					//company short name
	define('COMPANY_L', 		'MoniEnterprises');					//company short name
	define('COMPANY_H', 		"Website ".HOME);								//company home
	define('COMPANY_A', 		"Admin ".HOME);									//admin home
	define('BLOG_ADMIN', 		"Blog Admin");									//admin home
	
	//define company logo
	define("LOGO_WITH_PATH",	'images/site/logo.png');						//location of the logo
	define("LOGO_WIDTH",		'100');											//width of the logo
	define("LOGO_HEIGHT",		'100');											//height of the logo 
	define("LOGO_ALT",			'MoniEnterprises');					//alternate text for the logo
	
	//define company logo
	define("LOGO_ADMIN_PATH",	'images/admin/icon/logo-admin.png');			//location of the logo
	define("LOGO_ADMIN_WIDTH",	'70');											//width of the logo
	define("LOGO_ADMIN_HEIGHT",	'70');											//height of the logo 
	
	
	//session constant
	define('ADM_SESS',   		"farm_SESSION_2014ADM_SESS"); 					//admin session var	
	define('USR_SESS',   		"USERfarm_2013AGRI_SESS2014"); 						//user session var	
	define('STAFF_SESS',   		"SESS_foraavictoria2014");							//user session var
	
	
	//display style constant
	define('NRSPAN',  			"<span class='blackLarge'>");					//normal span
	define('ERSPAN',  			"<span class='orangeLetter'>");					//error span start
	define('SUSPAN',  			"<span class='greenLetter'>");					//success span start
	define('ENDSPAN', 			"</span>");										//end of span
	define('ER', 				'Error: ');
	define('SU', 				'Success !!! ');
	
?>