<?php 
/**
*	This utility class work with render and displaying message.
*
*	@author		Himadri Shekhar Roy
*	@date		August 18, 2008
*	@version	1.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/

include_once("utility.class.php");

class MesgUtility extends Utility
{
	
	/**
	*	Display different types of images depending on the message to display
	*
	*	@param
	*			$type	Type of image to display
	*			$path	Path to the image
	*			$img	Name of the image
	*
	*	@return string
	*/
	function dispMesgImg($type, $path, $img)
	{
		//declare var
		$data	= '';
		
		switch($type)
		{
			case 'NORMAL':
				$data	= $this->imgDisplayR($path, $img, 15, 15, 0, 'padR10', '', '');
				break;
				
			case 'SUCCESS':
				$data	= $this->imgDisplayR($path, $img, 15, 15, 0, 'padR10', '', '');
				break;
				
			case 'ERROR':
				$data	= $this->imgDisplayR($path, $img, 15, 15, 0, 'padR10', '', '');
				break;
				
			case 'ALERT':
				$data	= $this->imgDisplayR($path, $img, 15, 15, 0, 'padR10', '', '');
				break;
				
			default:
				$data	= $this->imgDisplayR($path, $img, 15, 15, 0, 'padR10', '', '');
				break;
			
		}//switch
		
		//return the result
		return $data;
	}//eof
	
	
	/**
	*	Display Empty message
	*
	*	@param
	*			$field		The field name to display
	*
	*	@return string
	*/
	function showEmptyMesg($field)
	{
		//build the message
		$data	= $field. ' is empty';
		
		//return
		return $data;
	}//eof
	
	/**
	*	Render message with type
	*
	*	@param
	*			$typeM		Type of message
	*			$mesg		Message to display
	*			$path	Path to the image
	*			$img	Name of the image
	*
	*	@return string
	*/
	function renderMessage($typeM, $mesg, $path, $style)
	{
		//declare var
		$img	= '';
		$class	= '';
		$msg	= '';
		$path1	= $path;
		
		$cross  = $this->imgDisplayR($path1, 'close-button.png', '10', '10', 0, 'fr1', '', '');
		
		switch($typeM)
		{
			
			case 'ERROR':
			
				$img	=  $this->imgDisplayR($path, 'error.gif', 15, 15, 0, 'marR10', '', '');			
				$class	= 'erBlock '.$style;
				break;
			case 'SUCCESS':
				$img	=  $this->imgDisplayR($path, 'success.gif', 15, 15, 0, 'marR10', '', '');
				$class	= 'suBlock '.$style;
				break;
			case 'INFO':
				$img	=  $this->imgDisplayR($path, '', 15, 15, 0, 'marR10', '', '');
				$class	= 'info-block '.$style;
				break;
			default:
				$img	=  $this->imgDisplayR($path, 'error.gif', 15, 15, 0, 'marR10', '', '');
				$class	= 'erBlock '.$style;
				break;
		}//switch
		$id 	= 'msg';
		//building block
		$msg	.= "<div id='".$id."' class='".$class."'  style='width:96%'>";
		$msg	.= $img.$mesg.$cross;		
		$msg	.= "</div>";
		
		//return the message
		return $msg;
		
	}//eof
	
	
	/**
	*	Render message with type, an advance version of earlier method
	*
	*	@param
	*			$typeM		Type of message
	*			$mesg		Message to display
	*			$path		Path to the image
	*			$img		Name of the image
	*			$erBlock	Style for error block
	*			$suBlock	Style for sucess block
	*
	*	@return string
	*/
	function renderMessageS($typeM, $mesg, $path, $style, $erBlock, $suBlock)
	{
		//declare var
		$img	= '';
		$class	= '';
		$msg	= '';
		
		switch($typeM)
		{
			case 'ERROR':
				$img	=  $this->imgDisplayR($path, 'error.gif', 15, 15, 0, 'padR10', '', '');
				$class	= $erBlock.' '.$style;
				break;
			case 'SUCCESS':
				$img	=  $this->imgDisplayR($path, 'success.gif', 15, 15, 0, 'padR10', '', '');
				$class	= $suBlock.' '.$style;
				break;
			default:
				$img	=  $this->imgDisplayR($path, 'error.gif', 15, 15, 0, 'padR10', '', '');
				$class	= $erBlock.' '.$style;
				break;
		}//switch
		
		//building block
		$msg	.= "<div class='".$class."'>
						<span class='noOpecity'>";
		$msg	.= 			$img.$mesg;
		$msg	.= "	</span>
					</div>";
		
		//return the message
		return $msg;
		
	}//eof
	
	
	/**
	*	Display message with type
	*
	*	@param
	*			$typeM		Type of message
	*			$mesg		Message to display
	*			$path	Path to the image
	*			$img	Name of the image
	*
	*	@return string
	*/
	function dispMessage($typeM, $path, $style)
	{
		if(isset($_GET['msg']))
		{
			echo $this->renderMessage($typeM, $_GET['msg'], $path, 'blackLarge');
		}
	}//eof
	
	
	/**
	*	Display message with type, an advance version of earlier method. All the style 
	*	will be displaying on the fly.
	*
	*	@param
	*			$typeM		Type of message
	*			$mesg		Message to display
	*			$path		Path to the image
	*			$erBlock	Style for error block
	*			$suBlock	Style for sucess block
	*
	*	@return string
	*/
	function dispMessageS($typeM, $path, $style, $erBlock, $suBlock)
	{
		if(isset($_GET['msg']))
		{
			echo $this->renderMessageS($typeM, $_GET['msg'], $path, 
									   'blackLarge', $erBlock, $suBlock);
		}
	}//eof
	
	
	
	/**
	*	Display message with type, an advance version of earlier method. All the style 
	*	will be displaying on the fly. The message needs to pass as a parameter.
	*
	*	@param
	*			$typeM		Type of message
	*			$mesg		Message to display
	*			$path		Path to the image
	*			$erBlock	Style for error block
	*			$suBlock	Style for sucess block
	*
	*	@return string
	*/
	function dispMesgWithMesgVal($mesg, $typeM, $path, $style, $erBlock, $suBlock)
	{
		echo $this->renderMessageS($typeM, $mesg, $path, 'blackLarge', $erBlock, $suBlock);
	}//eof
	
	
	
	
	
	/**
	*	Display message with type
	*
	*	@param
	*			$typeM		Type of message
	*			$mesg		Message to display
	*			$path	Path to the image
	*			$img	Name of the image
	*
	*	@return string
	*/
	function dispMesgWithClose($typeM, $path, $style)
	{
		$this->dispMessage($typeM, '../images/icon/', 'blackLarge');
		echo	"<input name=\"Button\" type=\"button\" class=\"button-cancel\" 
				 onClick=\"opener.location.reload();self.close()\" value=\"Close\">";
	}//eof
	
	
	/**
	*	Display status message
	*	
	*	@param
	*			$type		Type of message
	*			
	*	@return string
	*/
	function showStatusImg($path, $type)
	{
		//declare var
		$img	= '';
		
		//swich
		switch($type)
		{
			case 'a':
				$img	=  $this->imgDisplayR($path, 'active-status.gif', 15, 15, 0, '', 'active', '');
				break;
			case 'd':
				$img	=  $this->imgDisplayR($path, 'inactive-status.gif', 15, 15, 0, '', 'inactive', '');
				break;
			default:
				$img	=  $this->imgDisplayR($path, 'no-status.gif', 15, 15, 0, '', 'none', '');
				break;
		}//switch
		
		//return result
		return $img;
	}//eof
	
	/**
	*	Display  Yes or No mesg for the original post or copied post
	*	
	*	@param
	*			$type		Type of message
	*			
	*	@return string
	*/
	function showOriginalImg($path, $type)
	{
		//declare var
		$img	= '';
		
		//swich
		switch($type)
		{
			case 'Y':
				$img	=  $this->imgDisplayR($path, 'active-status.gif', 15, 15, 0, '', 'Yes', '');
				break;
			case 'N':
				$img	=  $this->imgDisplayR($path, 'inactive-status.gif', 15, 15, 0, '', 'No', '');
				break;
			default:
				$img	=  $this->imgDisplayR($path, 'no-status.gif', 15, 15, 0, '', 'none', '');
				break;
		}//switch
		
		//return result
		return $img;
	}//eof
	
	
	/**
	*	Display  Yes or No mesg for the abused post
	*	
	*	@param
	*			$type		Type of message
	*			
	*	@return string
	*/
	function showAbusedImg($path, $type)
	{
		//declare var
		$img	= '';
		
		//swich
		switch($type)
		{
			case 'N':
				$img	=  $this->imgDisplayR($path, 'active-status.gif', 15, 15, 0, '', 'Not Abused', '');
				break;
			case 'Y':
				$img	=  $this->imgDisplayR($path, 'inactive-status.gif', 15, 15, 0, '', 'Abused', '');
				break;
			default:
				$img	=  $this->imgDisplayR($path, 'no-status.gif', 15, 15, 0, '', 'Not Known', '');
				break;
		}//switch
		
		//return result
		return $img;
	}//eof
	
	/**
	*	Display  Yes or No mesg for the entry in first page. FP in function name stands for
	*	First Page
	*	
	*	@param
	*			$type		Type of message
	*			
	*	@return string
	*/
	function showFPImg($path, $type)
	{
		//declare var
		$img	= '';
		
		//swich
		switch($type)
		{
			case 'Y':
				$img	=  $this->imgDisplayR($path, 'active-status.gif', 15, 15, 0, '', 'Not Abused', '');
				break;
			case 'N':
				$img	=  $this->imgDisplayR($path, 'inactive-status.gif', 15, 15, 0, '', 'Abused', '');
				break;
			default:
				$img	=  $this->imgDisplayR($path, 'no-status.gif', 15, 15, 0, '', 'Not Known', '');
				break;
		}//switch
		
		//return result
		return $img;
	}//eof
	
	/**
	*	This function will forward to the success page with associated type
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$id				The primary key if required
	*			$id_var			Variable name, associated with the id
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*			$typeM			Type of message
	*
	*	@return NULL
	*/
	function showSuccessT($action, $id, $id_var, $url, $msg, $typeM)
	{
		if($id == 0)
		{
			header("Location: ".$url."?action=".$action."&typeM=".$typeM."&msg=".$msg);
		}
		else
		{
			header("Location: ".$url."?action=".$action."&typeM=".$typeM."&".$id_var."=".$id."&msg=".$msg);
		}
	}//eof
	
	/**
	*	This function will work as a part of the redirection. This function will use
	*	array of variables. This is a higher version of previous release.
	*
	*	@param
	*			$action			Action of the form, e.g. add_customer or edit_password
	*			$arr_id			Array of id
	*			$arr_var		Array of variables
	*			$url			URL or web address to forward to, generally it is 
	*							$_SERVER['PHP_SELF']
	*			$msg			Message id/code or messages to display
	*			$typeM			Type of message
	*
	*	@return NULL
	*/
	function showSuccessArrT($action, $arr_id, $arr_var, $url, $msg, $typeM)
	{
		$str	= '';
		
		//creating the string
		for($k=0; $k < count($arr_id); $k++)
		{
			
			$str .= "&".$arr_var[$k]."=".$arr_id[$k];
		}
		
		header("Location: ".$url."?action=".$action."&typeM=".$typeM.$str."&msg=".$msg);
		
	}//eof
	
	
	/**
	*	Display message back for two different class depending on the value of integer
	*
	*	@param
	*			$intVal		Value of the integer
	*			$class1		Name of the class which will be displayed on top
	*			$class2		Name of the class which will be displayed below
	*
	*	@return	string
	*/
	function getStyleCls($intVal, $class1, $class2)
	{
		$class	= $class1;
		
		if( ($intVal % 2 ) != 0 )
		{
			$class	= $class1;
		}
		else
		{
			$class	= $class2;
		}
		
		//return the class
		return $class;
		
	}//eof
	
	
	/**
	*	Display the close button
	*
	*	@return null
	*/
	function showCloseButton2()
	{
		$str	= "";
		
		if( (isset($_GET['action'])) && ($_GET['action'] == 'success') )
		{

			$str = " <div align='center' class='pad10'>
						  <input name=\"Button\" type=\"button\" class=\"button-cancel\" 
						  onClick=\"opener.location.reload();self.close()\" value=\"Close\">
					 </div>
					  ";
		}
					
		//string function
		return $str;
	}//eof
	
	
	/**
	*	Display the close button
	*
	*	@return null
	*/
	function showCloseButton3()
	{
		$str	= "";
		if( (isset($_GET['action'])) && ($_GET['action'] == 'success') )
		{
			$str = " <div align='center' class='pad10'>
						  <input name=\"Button\" type=\"button\" class=\"button-cancel\" 
						  onClick=\"self.close()\" value=\"Close\">
					 </div>
					  ";
		}
					
		//string function
		return $str;
	}//eof
	
	
	/**
	*	Display message with conditions using if else loop. This function applicable wherever some default message needs to show.
	*	For example, if the product is out of stock, then it should show the message, and if not then, In stock has to be displayed.
	*
	*	@date	April 09, 2010
	*
	*	@param
	*			$cond			Conditions that has to check
	*			$value			Value of the condition
	*			$suMesg			Success message if the criterion satisfied
	*			$erMesg			Error message if criterion does not satisfied
	*			$suStyle		If the condition is verified and return success
	*			$erStyle		If the condition does not satisfy it's criterion
	*
	*	@return	string
	*/
	function showMesgByCondition($cond, $value, $suMesg, $erMesg, $suStyle, $erStyle)
	{
		//declare var
		$strMesg	= "";
		
		if($cond == $value)
		{
			$strMesg	= "<div class='".$suStyle."'>".$suMesg."</div>";
		}
		else
		{
			$strMesg	= "<div class='".$erStyle."'>".$erMesg."</div>";
		}
		
		//return
		return $strMesg;
	}//eof
	
	/**
	*	Render message with type, an advance version of earlier method that has option whether to display image or not.
	*
	*	@date	February 28, 2011
	*
	*	@param
	*			$typeM		Type of message
	*			$mesg		Message to display
	*			$path		Path to the image
	*			$img		Name of the image
	*			$erBlock	Style for error block
	*			$suBlock	Style for sucess block
	*			$dispIcon	A boolean value to determine whether to display image/icon along with the message or not.
	*
	*	@return string
	*/
	function renderMessageWithOption($typeM, $mesg, $path, $style, $erBlock, $suBlock, $dispIcon)
	{
		//declare var
		$img	= '';
		$class	= '';
		$msg	= '';
		
		switch($typeM)
		{
			case 'ERROR':
				$img	=  $this->imgDisplayR($path, 'error.gif', 15, 15, 0, 'padR10', '', '');
				$class	= $erBlock.' '.$style;
				break;
			case 'SUCCESS':
				$img	=  $this->imgDisplayR($path, 'success.gif', 15, 15, 0, 'padR10', '', '');
				$class	= $suBlock.' '.$style;
				break;
			default:
				$img	=  $this->imgDisplayR($path, 'error.gif', 15, 15, 0, 'padR10', '', '');
				$class	= $erBlock.' '.$style;
				break;
		}//switch
		
		//building block
		$msg	.= "<div class='".$class."'>
						<span class='noOpecity'>";
		if($dispIcon == 'YES')
		{
			$msg	.= 			$img.$mesg;
		}
		else
		{
			$msg	.= 			$mesg;
		}
		$msg	.= "	</span>
					</div>";
		
		//return the message
		return $msg;
		
	}//eof
	
	/**
	*	Display message with type, an advance version of earlier method. All the style 
	*	will be displaying on the fly. The message needs to pass as a parameter.
	*
	*	@param
	*			$typeM		Type of message
	*			$mesg		Message to display
	*			$path		Path to the image
	*			$erBlock	Style for error block
	*			$suBlock	Style for sucess block
	*			$dispIcon	A boolean value to determine whether to display image/icon along with the message or not.
	*
	*	@return string
	*/
	function dispMesgWithOption($typeM, $path, $style, $erBlock, $suBlock, $dispIcon)
	{
		if(isset($_GET['msg']))
		{
			echo $this->renderMessageWithOption($typeM, $_GET['msg'], $path, $style, $erBlock, $suBlock, $dispIcon);
		}
	}//eof
	
	/**
	*	Display notification message with cross button
	*
	*	@author		Ranjan Kumar Basak
	*	@date		October 03, 2013
	*	@param
	*			
	*	$mesg		Message to display
	*			
	*
	*	@return string
	*/
	function dispMesgWithCross($mesg, $style)
	{	
	
		$path1	= 'images/icon/';
		$class	= '';
		$msg1	= '';
		$cross  = $this->imgDisplayR($path1, 'close-button.png', '10', '10', 0, 'fr1', '', '');
		$id 	= 'msg';
		//building block
		$msg1	.= "<div id='".$id."' class='".$style."'>";
		$msg1	.= $mesg.$cross;		
		$msg1	.= "</div>";	
		return $msg1;
	}//eof
	
	
}//eoc
?>