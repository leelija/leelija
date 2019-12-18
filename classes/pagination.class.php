<?php 
/**
*	This is an extention of generic utility class. This class paginate the result set. 	
*
*	@author		Himadri Shekhar Roy
*	@date		February 07, 2008
*	@version	1.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com 
* 
*/
include_once("utility.class.php");

class Pagination extends Utility
{
	/**
	*	Return the serial number in pagination field
	*
	*	@param
	*			$num	Number to multiply. This depends upon the number of fields you want to 
	*					show in a page.
	*	
	*	@return int
	*/
	function getSerialNum($num)
	{
		$i = 1;
		if(isset($_GET['mypage']) &&(strpos($_GET['mypage'], "Array") !== false))
		{
			$numVals = explode("Array",$_GET['mypage']);
			
			if((int)$numVals[1] == 0)
			{
				$i = 1;
			}
			else
			{
				$val = (int)$numVals[1]*$num;
				$i   = $val + 1;
			}
		}
		else
		{
			$i = 1;
		}
		return $i;
	}//eof
	
	
	/**
	*	Return the serial number in pagination field
	*
	*	@param
	*			$num	Number to multiply. This depends upon the number of fields you want to 
	*					show in a page.
	*	
	*	@return int
	*/
	function getPageSerialNum($num)
	{
		$i = 1;
		if(isset($_GET['page']) &&($_GET['page'] > 0))
		{
			$i = ($_GET['page'] -1) * $num;
			$i = $i + 1;
		}
		else
		{
			$i = 1;
		}
		return $i;
	}//eof

	
	
	
	/**
	*	Useful while adding new item in a pagination environment where you need to show same
	*	page data after refreshing the page.
	*	
	*/
	function getLink()
	{
		$link = '';
		if(isset($_GET['mypage']) &&(strpos($_GET['mypage'], "Array") !== false))
		{
			$link	 = "&mypage=".$_GET['mypage'];
		}
		else
		{
			$link	 = "&mypage=Array"."0";
		}
		
		return $link;
	}//eof
	

	/**
	*	Generate the pagination according to the supplied variables
	*	
	*	@param
	*			$numPages		Number of pages
	*			$link			Link includes query string variables
	*			$pageNumber		Number of current page	
	*			$pageArray		Array of pages	
	*
	*	@return null 
	*/
	function getPage($numPages, $link, $pageNumber, $pageArray)
    {
		if($numPages >1)
		{
			echo "<strong>Go to Page: &nbsp;&nbsp;</strong>";
		}
		if(isset($_GET['mypage']))
		{
	 		$num = explode("Array",$_GET['mypage']);
	 	}
		else
		{
			$num = 1;
		}
	 	$currPage = (int)$num[1];
	
	 	//previous page
	 	if($numPages >1)
		{
	       //this is the first page - there is no previous page
		   if ($pageNumber == 0)
		   { 
        		echo "<< Previous&nbsp;&nbsp;";
			} 
   		 	else
			{            
				//if not the first page, link to the previous page 
       			 echo "<< <a href=\"".$_SERVER['PHP_SELF']."?"."mypage=Array" . ($pageNumber - 1) .
				       $link. "\">Previous</a>&nbsp;&nbsp;";  
			} 
	     }
	   
		//other pages
		foreach($pageArray as $i => $value)
		{
	
			if($numPages >1)
			{
				if($currPage == $i)
				{
					echo "<span class='blackSmall'><b>".++$i."</b></span>&nbsp;";
				}
				else
				{
					/*echo "<a href='".$_SERVER['PHP_SELF']."?"."mypage=".$pageArray[$i].$i.$link."'> "
					      .++$i.
						  "</a>&nbsp;&nbsp;";*/
					
				}
			}
		}
		
		//nex page
		if($numPages >1)
		{
			if ($pageNumber == ($numPages - 1))
			{ 
				//if this is the last page - there is no next page 
				echo "Next >>";
			}
			else 
			{   
				//if not the last page, link to the next page
				echo "<a href=\"".$_SERVER['PHP_SELF']."?"."mypage=Array" . ($pageNumber + 1) .
				$link. "\">Next</a> >>";
			}  
		}
    }//eof
	
	
	
	/**
	*	Get current page
	*
	*	@return int
	*/
	function getCurrentPage()
	{
		//my page
		if(isset($_GET['mypage']))
		{
	 		$num = explode("Array",$_GET['mypage']);
	 	}
		else
		{
			$num = 1; //array("Array",1);
		}
		
		//get the current page
	 	$currPage = (int)$num[1];
		
		//return the value
		return $currPage;
		
	}//eof
	
	
	
	/**
	*	Generate the pagination according to the  paameters. This is an advance version of
	*	of the previous one. More formatted.
	*	
	*	@param
	*			$numPages		Number of pages
	*			$link			Link includes query string variables
	*			$pageNumber		Number of current page	
	*			$pageArray		Array of pages	
	*
	*	@return null 
	*/
	function getPage2($numPages, $link, $pageNumber, $pageArray)
    {
				
		//get current page
		$currPage = $this->getCurrentPage();
		
		//get the page array
		$pageArray = $this->getPages($numPages, $link, $pageNumber, $pageArray);//
		//print_r($pageArray);
		
	 	//previous page
	 	$this->getPreviousPage($numPages, $link, $pageNumber, $pageArray);
	   
	   	//get current min and max number
		/*$manxMinArr = $this->getCurrMinMax($numPages);
		if($numPages > 10)
		{
			$minNum		= $manxMinArr[0] - 1;//
		}
		else
		{
			$minNum		= $manxMinArr[0];
		}
		
		if($minNum == 0)
		{
			$minNum		= 1;
		}
		$maxNum		= $manxMinArr[1];
		*/
		//echo $numPages." ".$minNum. " " .$maxNum;
	   
		//other pages 
		foreach($pageArray as $i)//($i = $minNum ; $i <= $maxNum ; $i++) => $value
		{
			/*echo "Min = ".$minNum.", i = ".$i.", Max = ".$maxNum."</br>";*/
	
			if($numPages >1)
			{
				if($currPage == $i)
				{
					echo "<div class=\"actPg bld fl\">".++$i."</div>";
				}
				else
				{ 
					echo "<div class=\"inactPg fl\">
					<a 
					href='".$_SERVER['PHP_SELF']."?"."mypage="."Array".$i.$link."' class=\"greyLnk\" > "
						  .++$i.
						  "</a></div>";
				}
				
			}//if num page 1
		}
		
		//next page
		$this->getNextPage($numPages, $link, $pageNumber, $pageArray);
		
    }//eof
	
	
	
	/**
	*	Get previous page
	*/
	function getPreviousPage($numPages, $link, $pageNumber, $pageArray)
	{
		//get current page
		$currPage = $this->getCurrentPage();
		
		//previous page
		if($numPages >1)
		{
	       //this is the first page - there is no previous page
		   echo '<div class="butPagArea fl ">';
		   echo		'<div class="butPag bld">';
		   
		    if ($pageNumber == 0)
		    { 
        		echo "Previous";
			} 
   		 	else
			{            
				//if not the first page, link to the previous page 
       			 echo "<a href=\"".$_SERVER['PHP_SELF']."?"."mypage=Array" . ($pageNumber - 1) .
				       $link. "\"  class=\"greyLnk\">Previous</a>&nbsp;&nbsp;";  
			} 
			
			echo	'</div>';
			echo '</div>';
	     }
		
	}//eof
	
	
	
	/**
	*	Get next page highlights
	*/
	function getNextPage($numPages, $link, $pageNumber, $pageArray)
	{
		//get current page
		$currPage = $this->getCurrentPage();
		
		//get the page array
		$pageArray = $this->getPages($numPages, $link, $pageNumber, $pageArray);//
		
		//next page
		if($numPages >1)
		{
		
			echo '<div class="butPagArea fl ">';
		   	echo	'<div class="butPag bld">';
			if ($pageNumber == ($numPages - 1))
			{ 
				//if this is the last page - there is no next page 
				echo "Next";
			}
			else 
			{   
				//if not the last page, link to the next page
				echo "<a href=\"".$_SERVER['PHP_SELF']."?"."mypage=Array" . ($pageNumber + 1) .
				$link. "\"  class=\"greyLnk\">Next</a>";
			}  
			echo	'</div>';
			echo '</div>';
		}
		
	}//eof
	
	/**
	*	Get array to display
	*/
	function getPages($numPages, $link, $pageNumber, $pageArray)
	{
		//define new page array
		$newArr	= array();
		
		//get current page
		$currPage = $this->getCurrentPage();
		
		//get minimum and max mum numbers
		$minMaxArr	= $this->getCurrMinMax($numPages);
		$arrStart	= $minMaxArr[0];
		$arrEnd		= $minMaxArr[1];
		
		//generate the array
		for($i = $arrStart; $i < $arrEnd; $i++)
		{
			$newArr[] = $i;
		}//for
					
		//return the value
		return $newArr;
	
	}//eof
	
	
	/**
	*	Get Current current Maximum number of page
	*
	*/
	function getCurrMinMax($numPages)
	{
		//declare variables
		$minMaxArr	= array();
		
		//get current page
		$currPage 	= $this->getCurrentPage();
		$numPgLen	= strlen($currPage);
		
		//get the rest of the  numbers string
		$restNum	= substr($currPage, 0, ($numPgLen - 1));
		
		//get the last digit
		$lastDig	= substr($currPage, ($numPgLen - 1));
		
		//previous number
		$arrStart	= ($restNum."1");
		
		//determine the array start
		if($arrStart == 1)
		{
			$arrStart 	= 0;
		}
		elseif($arrStart > 10)
		{
			$arrStart 	= 10;
		}
		else
		{
			$arrStart	= $arrStart;
		}
		
		
		//get the end number
		$arrEnd		= (int)($arrStart + 10);
		
		//determine the end of array
		if($numPages <= $arrEnd)
		{
			$arrEnd	= $numPages;// - 1
		}
		else
		{
			$arrEnd	= $arrEnd;
		}
		
		//echo "Rest Num = ".(int)$restNum." Start = ".$arrStart." End = ".$arrEnd. " Num = ".$numPages	;
		//minimum and maximum numbers for the current number
		$minMaxArr	= array($arrStart, $arrEnd);
		
		//return the value
		return	$minMaxArr;
		
	}//eof
	
	
	/**
	*	Get previous and next navigation link. This function is not going to show many pages are there. It will only display
	*	the number of pages. This is useful for blog.
	*
	*	@date	August 31, 2011
	*
	*	@param
	*			$numPages		Number of pages
	*			$link			Link includes query string variables
	*			$pageNumber		Number of current page	
	*			$pageArray		Array of pages	
	*
	*	@return null 
	*/
	function getPrevAndNextOnly($numPages, $link, $pageNumber, $pageArray)
	{
		//get current page
		$currPage = $this->getCurrentPage();
		
		//previous page
		if($numPages >1)
		{
	       //this is the first page - there is no previous page
		   echo '<div class="direction fl">';
		   
		    if ($pageNumber == 0)
		    { 
        		echo "&laquo; Older Posts";
			} 
   		 	else
			{            
				//if not the first page, link to the previous page 
       			 echo "<a href=\"".$_SERVER['PHP_SELF']."?"."mypage=Array" . ($pageNumber - 1) .
				       $link. "\"  class=\"\">&laquo; Older Posts</a>&nbsp;&nbsp;";  
			} 
			
			echo '</div>';
	     }
		 
		 //next page
		if($numPages >1)
		{
		
			echo '<div class="direction fr">';
			if ($pageNumber == ($numPages - 1))
			{ 
				//if this is the last page - there is no next page 
				echo "Newer Posts &raquo;";
			}
			else 
			{   
				//if not the last page, link to the next page
				echo "<a href=\"".$_SERVER['PHP_SELF']."?"."mypage=Array" . ($pageNumber + 1) .
				$link. "\"  class=\"\">Newer Posts &raquo;</a>";
			}  
			echo '</div>';
		}
		
	}//eof
	
}
?>