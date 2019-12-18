<?php 
/**
*	This utility class uses cURL library to create custom curl function.
*
*	@author		Himadri Shekhar Roy
*	@date		March 30, 2011
*	@version	1.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/

include_once("utility.class.php");

class CurlUtility extends Utility
{
	
	/**
	*	Check if a url provided by user is correct or not. We will using it to see if video or audio song reffered by the 
	*	user is correct or not. This function can be use any place, wherever you need to check the existance of the URL.
	*
	*	@param
	*			$url		URL or link of the website or product or any media file. 
	*
	*	@return	int			
	*/
	function validateURL($url)
	{
		//declare var
		$info		= array();
		$httpCode	= 0;
		$urlRes		= 'NOT_FOUND';
		
		//initialize the curl
		$ch = curl_init();
	
		//set curl options
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		
		$result = curl_exec($ch);

		//get the curl info
		$info   	= curl_getinfo($ch);
		
		
		//get the http status code
		$httpCode	=  $info["http_code"];
		
		//close curl
		curl_close($ch);
		
		
		if($httpCode == '200')
		{
			$urlRes	= 'FOUND';
		}
		else
		{
			$urlRes		= 'NOT_FOUND';
		}
		
		
		//return the result
		return $urlRes;
		
	}//eof
	
}//eoc
?>