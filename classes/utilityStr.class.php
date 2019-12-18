<?php 
/**
*	This utility class format and display text and strings
*
*	UPDATE 26 July, 2010
*	Format string by using formatStringByRepalcingDelm(). This function will replace delimeter by using explode
*	function and concat the string with predefined character or character set.
*
*	UPDATE October 06, 2010
*	
*
*	@author		Himadri Shekhar Roy
*	@date		May 30, 2008
*	@version	1.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/

include_once("utility.class.php");

class StrUtility extends Utility
{
	/**
	*	This function is going to display text with first letter different color or size
	*	depending upon the class
	*
	*	@param
	*		$text		Text to display
	*		$class		Class of the first letter
	*	
	*
	*	@return 	string
	*/
	function formatFL($text, $class)
	{
		$str	= '<span class="'.$class.'">';
		
		//building the string
		$str 	.= substr(stripslashes($text),0,1);
		$str	.= '</span>';
		$str	.= substr(stripslashes($text),1);
		
		//return the string
		return $str;
		  
	}//eof
	
	
	/**
	*	This function is going to display number or money value
	*
	*	@param
	*		$number			Number or numerical values
	*		$numDec			Number after the decimal position
	*		$separator		Separator to seprate the tousands position
	*		$sepStyle		Separator style
	*	
	*	@return 	string
	*/
	function formatNumber($number, $numDec, $separator, $sepStyle)
	{
		//declare var
		$str	= '';
		
		//building the string e.g. number_format($value,2,'.',',')
		$str 	= number_format($number,$numDec,$separator,$sepStyle);
		
		//return the string
		return $str;
		  
	}//eof
	
	
	/**
	*	This function is going to display a default text or message if the original text is empty
	*	which is usable for many application. The Letters Df at the end of the function name 
	*	is the short form of Default.
	*
	*	@param
	*		$text		Text to display
	*		$class		Class of the first letter
	*		$default	Default text to display
	*	
	*	@return 	string
	*/
	function displayTextWithDf($text, $class, $default)
	{
		//declare var
		$str	= '';
		
		if($text == '')
		{
			$str	.= '<span class="'.$class.'">';
			$str 	.= stripslashes($default);
			$str	.= '</span>';
		}
		else
		{
			$str	.= '<span class="'.$class.'">';
			$str 	.= stripslashes($text);
			$str	.= '</span>';
		}
		
		
		//return the string
		return $str;
		  
	}//eof
	
	
	
	/**
	*	This function is going to display a default text or message if the original text is empty
	*	which is usable for many application. The Letters Df at the end of the function name 
	*	is the short form of Default. This function is same as the  displayTextWithDf except it won't 
	*	use any style.
	*
	*	@param
	*		$text		Text to display
	*		$class		Class of the first letter
	*		$default	Default text to display
	*	
	*	@return 	string
	*/
	function displayTextWithDfBasic($text, $default)
	{
		//declare var
		$str	= '';
		
		if($text == '')
		{
			$str 	= stripslashes($default);
		}
		else
		{
			$str 	= stripslashes($text);
		}
		
		
		//return the string
		return $str;
		  
	}//eof
	
	
	
	
	/**
	*	This function is going to display a default text or message if the original text is with 
	*	some particular format like 0.00 for price or 0000-00-00 for date it will print desired
	*	text that user wants to show.
	*
	*	@param
	*		$text		Text to display
	*		$text2		Text 2 field to display. Text and Text2 fields can be same, if it is testing
	*					for the same field.
	*		$isClass	Is span field is required. A boolean with value Y or N.
	*		$class		Class of the first letter
	*		$default	Default text to display	
	*		$txtFormat	The text format that need to replace 
	*	
	*	@return 	string
	*/
	function displayTextWithDf2($text, $text2, $isClass, $class, $default, $txtFormat)
	{
		//declare var
		$str	= '';
		
		if( ($text == '') || ($text2 == $txtFormat) )
		{
			$str	.= '<span class="'.$class.'">';
			$str 	.= stripslashes($default);
			$str	.= '</span>';
		}
		else
		{
			$str	.= '<span class="'.$class.'">';
			$str 	.= stripslashes($text);
			$str	.= '</span>';
		}
		
		
		//return the string
		return $str;
		  
	}//eof
	
	
	
	/**
	*	This function is going to format the plain text
	*
	*	@param
	*		$text		Text to display
	*		$class		Class of the first letter
	*	
	*
	*	@return 	string
	*/
	function formatText($text, $class)
	{
		$str	= '<span class="'.$class.'">';
		
		//building the string
		$str 	.= stripslashes($text);
		$str	.= '</span>';
		
		
		//return the string
		return $str;
		  
	}//eof
	
	/**
	*	This function is going to format the plain text and number, so that if number is more
	*	than one it will add s after the text
	*
	*	@param
	*		$text		Text to display
	*		$class		Class of the first letter
	*	
	*
	*	@return 	string
	*/
	function formatTextNum($num, $text, $class)
	{
		$str	= '<span class="'.$class.'">';
		
		if($num > 1)
		{
			$str .= stripslashes($text)."s";
		}
		else
		{
			$str .= stripslashes($text);
		}
		
		$str	.= '</span>';
		
		//return the string
		return $str;
		  
	}//eof
	
	/**
	*	Get dual specific style 
	*
	*	@param
	*			$catId		Category id
	*
	*	@return array		
	*/
	function getNavStyle($catId)
	{
		$divStyle	= '';
		$linkStyle	= '';
		$navStyle	= array($divStyle, $linkStyle);
		
		if(isset($_GET['catId']) && ((int)$_GET['catId'] == $catId))
		{
			$divStyle	= 'mainMenuAct';
			$linkStyle	= 'mainMenu';
		}
		else
		{
			$divStyle	= 'menuDiv2';
			$linkStyle	= 'mainMenuIn';
		}
		
		//return the values
		return $navStyle;
		
	}//eof
	
	/**
	*	Get website name only
	*
	*	@param
	*			$url	Get full url only
	*
	*	@return	 string
	*/
	function getWebsiteName($url)
	{
		//declare vars
		$webName	= ''; //website name
		$nameArr	= array(); //array of names after exploding
		
		if($url != '')
		{
			$urlVars 	= parse_url($url);
			$hostName	= $urlVars['host'];
			
			//chop the leading and trailing dots(.) from the host name
			//$nameArr	=	explode('.', $hostName);
			
			//see if the name is with www or without www
			if(eregi('^www.',$hostName))
			{
				//get the name
				$webName	=	substr($hostName,4);
			}
			else
			{
				//get the name
				$webName	=	$hostName;
			}	
		}
		
		
		//return the var
		return $webName;
		
	}//eof
	
	
	/**
	*	Get float string depending on the image size. Usable for Content placement.
	*
	*	@param
	*			$path		Path to the image
	*			$img		Image name
	*			$des		Desired size, in pixels
	*			$checkFor	Check for height or width, it is a constant with values WIDTH or HEIGHT
	*			$floatVal	Floating value
	*
	*	@return   String
	*/
	function getFloatStr($path, $image, $des, $checkFor, $floatVal)
	{
		//declare
		$flStr		= '';
		$testFor	= 0;
		
		if( ($image != '') && (file_exists($path.$image)) )
		{
			
			$size	=  @getimagesize($path.$image);
			$width 	=  $size[0];
			$height =  $size[1];
			
			if($checkFor == 'WIDTH')
			{
				$testFor	= $width;
			}
			elseif($checkFor == 'HEIGHT')
			{
				$testFor	= $height;
			}
			else
			{
				$testFor	= $width;
			}
			
			
			if($testFor <= $des)
			{
				$flStr	= $floatVal;
			}
			else
			{
				$flStr	= '';
			}
		}
		else
		{
			$flStr		= '';
		}
		
		//return the value
		return $flStr;
		
	}//eof
	
	
	/**
	*	This function will display disabled field
	*	
	*	@param
	*			$fName		Field name
	*			$fVal		Field value
	*			$aCls		Activated class
	*			$dCls		Deactivated class
	*			
	*	@return string
	*/
	function getDisableStr($fName, $fVal, $aCls, $dCls)
	{
		//declare var
		$str	= '';
		
		//conditions
		if(!isset($_SESSION[$fName]))
		{
			$str	= "disabled='disabled' class='".$dCls."'";
		}
		else if( (isset($_SESSION[$fName])) && ($_SESSION[$fName] != $fVal) )
		{
			$str	= "disabled='disabled'  class='".$dCls."'";
		}
		else  if( (isset($_SESSION[$fName])) && ($_SESSION[$fName] == $fVal) )
		{
			
			$str	= " class='".$aCls."'";
		}
		else
		{
			$str	= "disabled='disabled' class='$dCls'";
		}
		
		//return the value
		return $str;
		
	}//eof
	
	
	
	/**
	*	This function will explode an string based on the supplied argument, and concat the string
	*	with a desirable character or character set. This is usable for passing URL variable or
	*	rename any particular file name. e.g. It is extermely usable if we want to remove empty space from 
	*	string and add plus sign ('+').
	*
	*	@added 	July 26, 2010
	*
	*	@param
	*			$delimiter			Delimiter to be searched in the string
	*			$str				String to be formatted
	*			$charSet			Character set or character that will replace the delimiter
	*
	*	@return string
	*/
	function formatStringByRepalcingDelm($delimiter, $str, $charSet)
	{
		//declare var
		$strArr	= array();
		$strNew	= "";
		
		//explode the string
		$strArr	= explode($delimiter, $str); 
		
		//concat
		if(count($strArr) > 0)
		{
			if(count($strArr) == 1)
			{
				$strNew	= $str;
			}
			else
			{
				$strNew	= $strArr[0];
				
				for($a = 1; $a < count($strArr); $a++)
				{
					$strNew = $strNew."+".$strArr[$a];
				}
			}
			
		}//if
		
		//return the string
		return $strNew;
		
	}//eof
	
	
	
	/**
	*	Get string value corresponding to it's numerical value.
	*	
	*	@param
	*			$id				String value of the id
	*			$idArr			Array of ids
	*			$strArr			Array of string
	*
	*	@return	atring
	*/
	function getIdValueFromArr($id, $idArr, $strArr)
	{
		//var
		$strVal	= '';
		$keyVal	= 0;
		
		if(in_array($id, $idArr))
		{
			//get the key value
			$keyVal	= array_search($id, $idArr);
			
			//get the corresponding value
			$strVal	= $strArr[$keyVal];
		}
		
		//return the value
		return $strVal;
		
	}//eof
	
	
	
	/**
	*	Display preformatted text corresponding to a symbol or symbolic letter. e.g. If it is 
	*	Y, the text will be displaying as Yes.
	*
	*	@param
	*			$symbol		Symbolic letter for the text
	*
	*	@return string
	*/
	function displayPF($symbol)
	{
		//declare var
		$string		= '';
		
		switch($symbol)
		{
			case 'Y':
				$string	= 'Yes';
				break;
			case 'N':
				$string	= 'No';
				break;
			case 'a':
				$string	= 'Active';
				break;
			case 'd':
				$string	= 'Inactive';
				break;
			default:
				$string = '';
				break;
		}
		
		//return the string
		return $string;
		
	}//eof
	
	
	
	/**
	*	This function is going to display text with conditions. The conditions and their values will be 
	*	in separate array. We are using array, because it can be used in many of the of application.
	*
	*	@date	October 06, 2010
	*
	*	@param
	*			$condArr		Array of conditions
	*			$valArr			Array of values
	*			$check			Condition to check or find for
	*			$class			Style to display text
	*			$default		Default text to display
	*	
	*	@return 	string
	*/
	function displayTextWithCond($condArr, $valArr, $check, $class, $default)
	{
		//declare var
		$str		= '';
		$defaultStr = '<span class="'.$class.'">'.stripslashes($default).'</span>';
		
		//check
		if(count($condArr)> 0)
		{
			if(in_array($check, $condArr))
			{
				//get the key position
				$keyPos	= array_search($check, $condArr);
				
				//generate the string
				$str	.= '<span class="'.$class.'">';
				$str 	.= stripslashes($valArr[$keyPos]);
				$str	.= '</span>';
			}
			else
			{
				$str = $defaultStr;
			}
		}
		else
		{
			$str = $defaultStr;
		}
		
		
		//return the string
		return $str; 
		  
	}//eof
	
	
	
	/**
	*	Add www to the page link if not added. Although it won't add www to localhost
	*
	*	@date	October 27, 2010
	*
	*	@param
	*			$pageName			Name of the page
	*			$localHostDir		Directory or path to the file;
	*
	*	@return	string
	*/
	function addWWW($pageName, $localHostDir)
	{
		//declare variables
		$pageStr	= 'http://';
		$www		= 'www.';
		
		$hostName	= $_SERVER['HTTP_HOST'];
		
		//check for local server ip based
		$regEx	= "([1-2]{1}[0-9]{0-2})+\.*";
		
		
		if($hostName == 'localhost')
		{
			$pageStr	.= $hostName.$localHostDir.$pageName;
		}
		else
		{
			if(preg_match("/^www/i", $hostName))
			{
				$pageStr  .= $hostName.$pageName;
			}
			else
			{
				$pageStr  .= $www.$hostName.$pageName;
			}
		}
		
		//return the value
		return $pageStr;
		
	}//eof
	
	
	/**
	*	Generate credit card number for email purpose
	*
	*	@date	November 09, 2011
	*
	*	@param
	*			$cardNum		Cerdit card number
	*
	*	@return string
	*/
	function genCCNumForEmail($cardNum)
	{
		//declare var
		$cardStr	= '';
		
		//reverse the card number
		$cardStr	= strrev(trim($cardNum));
		
		//get the first four char
		$cardStr	= substr($cardStr, 0, 4); 
		
		//again reverse the string
		$cardStr	= strrev($cardStr);
		
		//create the string
		$cardStr	= "xxxx-".$cardStr;
		
		//return the string
		return $cardStr;
		
	}//eof
	
	
	/**
	*	Remove the last character from the string
	*
	*	@param
	*			$strInput		Input string
	*
	*	@return string
	*/
	function removeLastCharFromString($strInput)
	{
		//declare var
		$resStr		= $strInput;
		
		//remove any white space
		$resStr		= trim($strInput);
		
		//get the last character from the string
		$lastChar	= substr($resStr, -1);
		
		//chop it
		$resStr		= rtrim($resStr, $lastChar);
		
		//return the result
		return $resStr;
		
	}//eof
	
	/**
	*	This function will take only one field value and make another field value to either null. This function is required
	*	if we need only one field value out of 2 filed value. SF refers to second field and FF refers to first field.
	*
	*	@param
	*			$field_f			First field value
	*			$field_s			Second field value
	*			$assignVal			Value that has to assign to not accepted field
	*
	*	@return string
	*/
	function setSFValByFF($field_f, $field_s, $assignVal)
	{
		
		//condition
		if($field_f > 0)
		{
			$field_s = '';
		}
		else
		{
			$field_s = $assignVal;
		}
		
		//return second field value
		return $field_s;
		
	}//eof
	
	
	
	
	/**
	*	Generate verification link for registration. This code will be sending to the user email id.
	*
	*	@date	February 26, 2011
	*
	*	@param
	*			$url				Website address
	*			$pageName			Webpage that will verify the code
	*			$length				Length of the key
	*			$name				Name of the user
	*			$email				Email id of the user
	*
	*	@return	array
	*/
	function genEmailVerLink($url, $pageName, $length, $name, $email)
	{
		//declare variables
		$linkStr	= '';
		$actCode	= '';
		$linkArr	= array($linkStr, $actCode);
		
		//generate the code
		$actCode	= $this->randomkeys($length);
		
		//generate the link
		$linkStr	= $url.$pageName."?username=".$name."&email=".$email."&act_code=".$actCode;
		
		//regenerate the link array
		$linkArr	= array($linkStr, $actCode);
		
		//return the value
		return $linkArr;
		
	}//eof
	
	
	
	
	
	
	
	
	
	/**
	*	Display conditional value based on certain mathematical condition(<, >, or == )
	*
	
	function displayValByCondition($checkVal, $thresholdVal, $checkType, $default)
	{
		switch($checkType)
		{
			case ">":
				if()
				{
				}
		}
		if($checkVal )
		{
		}
	}//eof*/
	
}//eoc
?>