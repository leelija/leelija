<?php 
include_once("duration.class.php");
/**
*	This class customize the feature of event calendar. Print date in various format
*
*	Update October 24, 2011
*	genListOfMonth has been added to the system to display list month. This will display a dropdown
*	list of month based on the supplied parameter, like January, Jan etc.	
*
*	UPDATE March 05, 2010 New functions have been added to the system to generate the 
*	dropdown list of months and year. The months can be generated either on every year or
*	within a span or years. 
*
*	@author		Himadri Shekhar Roy
*	@date		July 03, 2006
*	@update		September 12, 2008; June 01, 2009; March 05, 2010
*	@version	2.2
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/
 
class DateUtil extends GeneraicDuration
{
	//declare var
	public $monthFormat;
	
	/**
	*	Calculate the end date from the start date, date format in Y-m-d
	*	@return date
	*/
	function getEventEndDate($startDate, $duration, $type)
	{
		$startDate = $this->changeDateFormat($startDate);
		$endDate   = $this->getEndDate($startDate, $duration, $type);
		return $endDate;
	}//end of getting date
	
	/**
	*	Change date format, if the date is in Y-m-d format the function will return date as Ymd and if it is in Ymd format
	*	the function automatically format it to Y-m-d depending upon the length of the date
	*   @return date
	*/
	function changeDateFormat($date)
	{
		if(strlen($date) == 10)
		{
			$day   = substr($date,8,2);
			$month = substr($date,5,2);
			$year  = substr($date,0,4);
			$date  = $year.$month.$day;
		}
		elseif(strlen($date) == 8)
		{
			$day   = substr($date,6,2);
			$month = substr($date,4,2);
			$year  = substr($date,0,4);
			$date  = $year."-".$month."-".$day;
		}
		else
		{
			$date = $date;
		}
		
		//return date
		return $date;
		
	}//end of chage date format
	
	/**
	*	Change day and month format, if they are less than 10. It's applicable to produce the date format as YYYY-mm-dd
	*	@return string
	*/
	function changeDayMonth($number)
	{
		$number = (int)$number;
		if($number <10)
		{
			$number = '0'.$number;
		}
		else
		{
			$number = $number;
		}
		return $number;
	}//end of function
	
	
	
	/* THIS FUNCTION WILL PRINT DATE WITH THE PARTICULAR FORMAT JUL 3, 2006*/
	function printDate($date)
	{
		$day   = (int)substr($date,8,2);
		$month = (int)substr($date,5,2);
		$year  = (int)substr($date,0,4);
		
		$date_string = mktime(0,0,0,$month,$day,$year);
		$date = date("M d, Y",$date_string);
		return $date;
		
	}//END OF PRINTING DATE
	
	 /* This function will return Date format like Monday June 12, 2006
		$date : is the only parameter
	 */
	  function printDate2($date)
	  {
	  	
	 	$day   = (int)substr($date,8,2);
		$month = (int)substr($date,5,2);
		$year  = (int)substr($date,0,4);
		$date_string = mktime(0,0,0,$month,$day,$year);
		$dateFormat = date("l, F j, Y",$date_string);
		return $dateFormat;
	  }
	  
	 /**
	 * This function will return Date format like Monday Jun 12, 2006
	 * $date : is the only parameter
	 */
	  function printDate3($date)
	  {
	  	
	 	$day   = (int)substr($date,8,2);
		$month = (int)substr($date,5,2);
		$year  = (int)substr($date,0,4);
		$date_string = mktime(0,0,0,$month,$day,$year);
		$dateFormat = date("D, M j, y",$date_string);
		return $dateFormat;
	  }
	  
	 /**
	 * This function will return Date format like June 12, 2006
	 * $date : is the only parameter
	 */
	  function printDate4($date)
	  {
	  	
	 	$day   = (int)substr($date,8,2);
		$month = (int)substr($date,5,2);
		$year  = (int)substr($date,0,4);
		$date_string = mktime(0,0,0,$month,$day,$year);
		$dateFormat = date("F j, Y",$date_string);
		return $dateFormat;
	  }
	 
	 
	 
	 /**
	 *	This function will return Date format like January, 2010
	 *	
	 *	@date 	March 5, 2010
	 *	@param	
	 *			$date		Date to be formatted
	 *
	 *	@return string
	 */
	  function printDate5($date)
	  {
	 	$day   = (int)substr($date,8,2);
		$month = (int)substr($date,5,2);
		$year  = (int)substr($date,0,4);
		$date_string = mktime(0,0,0,$month,$day,$year);
		$dateFormat = date("F, Y",$date_string);
		
		//return the value
		return $dateFormat;
	  }
	 
	 
	  
	/* This function will return you the month name */
	function getMonthName($intMonth)
	{
		$monthName = '';
		$intMonth = (int)$intMonth;
		if($intMonth == '1' || $intMonth == '01')
		{
			$monthName = 'January';
		}
		else if($intMonth == '2' || $intMonth == '02')
		{
			$monthName = 'February';
		}
		else if($intMonth == '3' || $intMonth == '03')
		{
			$monthName = 'March';
		}
		else if($intMonth == '4' || $intMonth == '04')
		{
			$monthName = 'April';
		}
		else if($intMonth == '5' || $intMonth == '05')
		{
			$monthName = 'May';
		}
		else if($intMonth == '6' || $intMonth == '06')
		{
			$monthName = 'June';
		}
		else if($intMonth == '7' || $intMonth == '07')
		{
			$monthName = 'July';
		}
		else if($intMonth == '8' || $intMonth == '08')
		{
			$monthName = 'August';
		}
		else if($intMonth == '9' || $intMonth == '09')
		{
			$monthName = 'Sepember';
		}
		else if($intMonth == '10')
		{
			$monthName = 'October';
		}
		else if($intMonth == '11')
		{
			$monthName = 'November';
		}
		else if($intMonth == '12')
		{
			$monthName = 'December';
		}
		return $monthName;
	}
	
	/* This function will return next month */
	function getNextMonth($date)
	{
		$year = (int)substr($date,0,4);
		$month =(int) substr($date,4,2);
		$day = (int)substr($date,6,2);
		//$month = (int)$month;
		if( $month < 12 )
		{	
			$next_year = $year;
			$next_month = $month+1;
			$next_date = $next_month."-".$year;
		}
		else
		{
			$next_year = $year+1;
			$next_month = 1;
			$next_date = "1-".$next_year;			
		}
		/* Converting nex month into 2 digit month format, i.e. replacing 1 to 01 and so on*/
		if($next_month <10)
		{
			$next_month = '0'.$next_month;
		}
		$next_month_arr = array($next_year,$next_month,$next_date);
		return $next_month_arr;
	}//End if returning next month
	
	/* Return Previous Month */
	function getPreviousMonth($date)
	{
		$year = (int)substr($date,0,4);
		$month =(int) substr($date,4,2);
		$day = (int)substr($date,6,2);
		
		if( $month > 1 )
		{
			$previous_year = $year;
			$previous_month = $month-1;
			//$next_month    = $month+1;
			$previous_date = $previous_month."-".$year;
		}
		else
		{
			$previous_year = $year-1;
			$previous_month = 12;
			$previous_date = "12-".$previous_year;
		}
		/* Converting nex month into 2 digit month format, i.e. replacing 1 to 01 and so on*/
		if($previous_month <10)
		{
			$previous_month = '0'.$previous_month;
		}
		$prev_month_arr = array($previous_year,$previous_month,$previous_date);
		return $prev_month_arr;
	}//End of returning previous month
	
	/* This function will return a start day  of a specific month: 
		$date : is the only parameter
	 */
	 function getStartDate($date)
	 {
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		$date_string = mktime(0,0,0,$month,1,$year);
		$day_start = date("w",$date_string);  
		
		return $day_start;
	 }
	 /* This function will return whether a date is weekend or not 
		$date : is the only parameter
	 */
	 function getDayType($date)
	 {
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		$date_string = mktime(0,0,0,$month,$day,$year);
		$dayType = date("w",$date_string);
	
		return $dayType;
	 }
	 /* This function will return total days of a specific month: 
		$date : is the only parameter
	 */
	 function getTotalDaysInMonth($date)
	 {
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		$date_string = mktime(0,0,0,$month,1,$year);
	 	$total_days_in_month = date("t",$date_string);
		
		return $total_days_in_month;
	 }
	 /* This function will return Date format like Monday June 12, 2006
		$date : is the only parameter
	 */
	  function getFormattedDate($date)
	  {
	  	
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		$date_string = mktime(0,0,0,$month,$day,$year);
		$dateFormat = date("l, F j, Y",$date_string);
		return $dateFormat;
	  }
	  /* This function will return Previous Day
		$date : is the only parameter
	 */
	  function getPreviousDay($date)
	  {
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		$date_string = mktime(0,0,0,$month,$day - 1,$year);
		$date = date("Ymd",$date_string);
		return $date;
	  }
	   /* This function will return Next Day
		$date : is the only parameter
	 */
	  function getNextDay($date)
	  {
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		$date_string = mktime(0,0,0,$month,$day + 1,$year);
		$date = date("Ymd",$date_string);
		return $date;
	  }
	  /* This function will return Previous Week
		$date : is the only parameter
	 */
	  function getPreviousWeek($date)
	  {
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		$date_string = mktime(0,0,0,$month,$day - 7,$year);
		$date = date("Ymd",$date_string);
		return $date;
	  }
	  /* This function will return Next Week
		$date : is the only parameter
	 */
	  function getNextWeek($date)
	  {
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		$date_string = mktime(0,0,0,$month,$day + 7,$year);
		$date = date("Ymd",$date_string);
		return $date;
	  }
	  
	  
	 /*  This function will populate the list of months from 12 months back to 12 months advance*/
	 function getListMonth()
	 {
	 	
		$date 	= date("Ymd");
		$year 	= (int)date("Y");//(int)substr($date,0,4)
		$month 	= (int)date("m");//(int)substr($date,4,2)
		$day 	= 1;//substr($date,6,2)(int)date("d")
		
		$start_month = $month - 12;
		$end_month = $month + 12;
		
		
		for($i=0; $i< 25; $i++ )
		{
			$monthVal = mktime(0,0,0,$start_month, $day, $year);
			$monthVal2 = mktime(0,0,0,$start_month, (int)date("d"), $year);
			$start_month++;
			if(date("Ymd",$monthVal2) == $date) 
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
			echo "<option value=\"".date("Ymd",$monthVal)."\" ".$selected.">".date("M Y", $monthVal).
			"</option>";
		}
		
	 }//end of list end month
	 
	 
	 /**
	 *	 This function will populate the list of months as per the user choice
	 */
	 function getListMonth2()
	 {
	 	
		$select = "SELECT * FROM eventcal_year_option WHERE user_type='2'";
		$query = mysql_query($select);
		$result = mysql_fetch_array($query);
		$start_year = $result['start_year'];
		$end_year = $result['end_year'];
		
		
		$date 	= date("Ymd");
		$year 	= (int)date("Y");//(int)substr($date,0,4)
		$month 	= (int)date("m");//(int)substr($date,4,2)
		$day 	= 1;//substr($date,6,2)(int)date("d")
		
		$start_month = $month - 12;
		$end_month = $month + 12;
		
		
		for($i=0; $i< 25; $i++ )
		{
			$monthVal = mktime(0,0,0,$start_month, $day, $year);
			$monthVal2 = mktime(0,0,0,$start_month, (int)date("d"), $year);
			$start_month++;
			if(date("Ymd",$monthVal2) == $date) 
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
			echo "<option value=\"".date("Ymd",$monthVal)."\" ".$selected.">".date("M Y", $monthVal).
			"</option>";
		}
		
	 }//end of list end month
	 
	 function getMonthDropDown()
	 {
		$months = array();
		for ($i = 12; $i >00; $i--) {
		$timestamp = mktime(0, 0, 0, date('n') - $i, 1);
		$months[date('n', $timestamp)] = date('F', $timestamp);
		}
		
		echo '<select name="select_month"  class="textAr" id="select_month">';
		
		foreach ($months as $num => $name) {
		echo '<option value="'.$num.'">'.$name.'</option>';
		}
		
		echo ' </select>';
	 }
	 
	 
	 /* Print Small Size month */
	function printSmallMonth($date)
	{		
		$year = (int)substr($date,0,4);
		$month = (int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		
		$month_name = $this->getMonthName($month);
		$date_string = mktime(0,0,0,$month,1,$year); 
		$day_start = date("w",$date_string); 
		
		$total_days_in_month = $this->getTotalDaysInMonth($date);
		//FFCC00 FFCC00 A382FF D5C6FF
		$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
		echo "<table width='175' style='border: 1px solid #E0D5FF; padding:2px;' cellspacing='0'>
				<tr bgcolor=\"#F2E8FF\">
					<td colspan=7 align='center' class=\"darkBlueFont\" height='20'><b>".$month_name.", ".$year."</b></td>
				</tr>
				<tr class=\"purpleHeadingSmaller\" bgcolor=\"#F2E8FF\">
				 <td width='25' height='20px;' bgcolor='' style='border-bottom:1px solid #D5C6FF'>".$days[0]."</td>
				 <td width='25' style='border-bottom:1px solid #E0D5FF'>".$days[1]."</td>
				 <td width='25' style='border-bottom:1px solid #E0D5FF'>".$days[2]."</td>
				 <td width='25' style='border-bottom:1px solid #E0D5FF'>".$days[3]."</td>
				 <td width='25' style='border-bottom:1px solid #E0D5FF'>".$days[4]."</td>
				 <td width='25' style='border-bottom:1px solid #E0D5FF'>".$days[5]."</td>
				 <td width='25' style='border-bottom:1px solid #E0D5FF'>".$days[6]."</td>
				</tr>
				<tr>
				";
				  $current_position = $day_start; 
				  
				  /* Generating Empty Cells before the month begin */
				  for ($i=0; $i < $day_start; $i++)
				  {
				  	echo "<td class='emptyCell' style='padding:3px;'>&nbsp</td>";
				  }
				  if($month <10){$month = '0'.$month;}else{$month = $month;}
				  /* Loop through all other days in a month */
				  for ($i = 1; $i <= $total_days_in_month; $i++)
				  {
				  	/* Deciding class to height light the day of any month */
					$current_position ++;
					/* Formatting date field*/
					if($i<10)
					{
						$j= '0'.$i;
					}
					else
					{
						$j=$i;
					}
					
					
					
					
					
					$createDate= $year.$month.$j;
					$dateType = $this->getDayType($createDate);
					/* Style sheet  */
					/* if($i == (int)$day)
					{
						$class = 'todaysDate';
					}
					else
					{ */
						if($dateType == 0)
						{
							$class = 'weekEnd';
						}
						else
						{
							$class = 'purpleHeadingSmaller';
						}
					/* }
					 */
					/* Printing Dates echo <div class='bigMonthDate'> </div>*/
					echo "<td valign='top' height='20' width='25' bgcolor='#FFFFFF' style='padding:3px;' align='center' 
					class=\"" . $class . "\">
					
					<a href=\""."day.php"."?"."date=".$year.$month.$j."\">" . $i . "</a>
					
					</td>";
					if( $current_position == 7 )
					{
						echo "</tr><tr>\n";
						$current_position = 0;
					}
				  }
				  
				  /* End Day and then print empty cells after the end day if there are any echo*/
				  $end_day = 7-$current_position;
				  if($end_day == 7)
				  {
				  	echo '';
				  }
				  else
				  {
					  for( $i = 0 ; $i < $end_day ; $i++ )
					  {
						 echo "<td class='emptyCell' style='padding:3px;'>&nbsp;</td>\n";
					  }
				  }
				echo " </tr></table>";

	}
	
	/* This function will populate the year listing for Admin*/
	function getListYearAdmin()
	{
		$select = "SELECT * FROM eventcal_year_option WHERE user_type='admin'";
		$query = mysql_query($select);
		$result = mysql_fetch_array($query);
		$start_year = $result['start_year'];
		$end_year = $result['end_year'];
		
		$selectStr = '';
		
		for($i = $start_year; $i <= $end_year; $i++)
		{
			//this will select the current year in drop down list
			if($i == date("Y"))
			{
				$selectStr = 'selected';
			}
			else
			{
				$selectStr = '';
			}
		
			$date = $i.date('m').date('d');
			echo "<option value=\"".$date."\" ".$selectStr.">".$i."</option>";
		}
		
	}
	/* This function will populate the year listing for User*/
	function getListYearUser()
	{
		$select = "SELECT * FROM eventcal_year_option WHERE user_type='2'";
		$query = mysql_query($select);
		$result = mysql_fetch_array($query);
		$start_year = $result['start_year'];
		$end_year = $result['end_year'];
		
		$selectStr = '';
		
		for($i = $start_year; $i <= $end_year; $i++)
		{
			//this will select the current year in drop down list
			if($i == date("Y"))
			{
				$selectStr = 'selected';
			}
			else
			{
				$selectStr = '';
			}
			$date = $i.date('m').date('d');
			echo "<option value=\"".$date."\" ".$selectStr.">".$i."</option>";
		}
	}
	/* This function will print Year*/
	function printYearUser($date)
	{
		$year = (int)substr($date,0,4);
		$month =(int) substr($date,4,2);
		$day = (int)substr($date,6,2);
		$dateSequence = array();
		for($i = 1; $i<= 12; $i++ )
		{
			$month = $i;
			if($month < 10)
			{
				$month = '0'.$month;
			}
			$date = $year.$month.$day;
			//echo $month." <br />";
			$dateSequence[] = $date;
			//echo $date;
			//echo "<span style='width=250'>".$this->printSmallMonth($date)."</span>";
		}
		return $dateSequence;
	}
	/* Get Next Year */
	
	function getNextYear($date)
	{
		$year = (int)substr($date,0,4);
		$month =(int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		
		$nextYear = $year + 1;
		return $nextYear.$month.$day;
	}
	
	/* Get Next Year */
	
	function getPreviousYear($date)
	{
		$year = (int)substr($date,0,4);
		$month =(int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		
		$prevYear = $year - 1;
		return $prevYear.$month.$day;
	}
	/* Get Start day and end day of a week */
	function getWeekDays($date)
	{
		$year = (int)substr($date,0,4);
		$month =(int)substr($date,4,2);
		$day = (int)substr($date,6,2);
		$date_str = mktime(0,0,0,$month,$day,$year);
		$week_str = date("W",$date_str);
		$start_week = mktime(0,0,0,1,$day + ($week_str) * 7 ,$year);
		$week_start_day = date("M d", $start_week);
		return $week_start_day;
	}
	
	/* Date: June 15, 2006
	This fuction will print the date footer: usable for month, and year selection. */
	function printDateFooter()
	{
		echo "<table width='100%' style='border-top: 1px solid #A382FF'>
		  <tr>
			  <td class=\"purpleHeadingSmall\" width='33%' style='padding-top:10px;'>
			    <form action=\"month.php\" method=\"get\">
				 <span>Select by Month or Year&nbsp;&nbsp;&nbsp;</span>
				 <span class=\"orangeLetter\">
				 <select name=\"date\">
				";
				$this->getListMonth();
				
			echo	"
				 </select>
				 </span>
				 <span><input name=\"btnOK\" type=\"submit\" class=\"button-add\" value=\"OK\">
				 </span>
				 </form>
			  </td>
			  
			   <td class=\"purpleHeadingSmall\" width='33%' style='padding-top:10px;'>
			    <form action=\"year.php\" method=\"get\">
				 <span><!-- Select by Year -->&nbsp;&nbsp;&nbsp;</span>
				 <span class=\"orangeLetter\">
				 <select name=\"date\">
				";
				$this->getListYearUser();
				
		echo		"
				 </select>
				 </span>
				 <span style='padding-bottom:10px;'><input name=\"btnOK\" type=\"submit\" class=\"button-add\" value=\"OK\">
				 </span>
				 </form>
			  </td>
		  </tr>
		  
		  </table>";
	}
	/* Date: June 15, 2006
	This fuction will print the date footer: usable for year selection. */
	function printYearFooter()
	{
		echo "<table width='100%' style='border-top: 1px solid #A382FF'>
		  <tr> 
			  <td class=\"purpleHeadingSmall\" width='33%' style='padding-top:10px;'>
			    <form action=\"year.php\" method=\"get\">
				 <span>Select by Year&nbsp;&nbsp;&nbsp;</span>
				 <span class=\"orangeLetter\">
				 <select name=\"date\">
				";
				$this->getListYearUser();
				
		echo		"
				 </select>
				 </span>
				 <span style='padding-bottom:10px;'><input name=\"btnOK\" type=\"submit\" class=\"button-add\" value=\"OK\">
				 </span>
				 </form>
			  </td>
		  </tr>
		  </table>";
	}
	////////////////////////////////
	/**
	*	Create a formatted date
	*	@return string
	*/
	function formatNormal($date)
	{
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,5,2);
		$day = (int)substr($date,8,2);
		$date_string = mktime(0,0,0,$month,$day,$year);
		$dateFormat = date("l, F j, Y",$date_string);
		return $dateFormat;
	}//end of date format
	
	/**
	*	Populate a dropdown list years starting from a start year till the end year
	*	@return string
	*/
	function listTillCurrYear($startYear, $selected)
	{
		$endYear		= (int)date("Y");
		$diff			= $endYear - $startYear;
		$select_string 	= '';
		
		for($i=0; $i<= $diff; $i++)
		{
			$year = $startYear + $i;
			if($selected == $year)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string 	= '';
			}
			echo "<option value=\"".$year."\" ".$select_string.">".$year."</option>";
		}
	}//end of populating list
	
	/**
	*	Populate a dropdown list of month
	*	@return NULL
	*/
	function listOfMonth($selected)
	{
		for($i=1; $i<= 12; $i++)
		{
			if($i < 10)
			{
				$j = '0'.$i;
			}
			else
			{
				$j = $i;
			}
			if($selected == $j)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string 	= '';
			}
			echo "<option value=\"".$j."\" ".$select_string.">".$this->getMonthName($j)."</option>";
		}
	}//end of populating list
	
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	//
	// Additional functions required to generate report, as well as can be used in other purposes
	//
	///////////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Get till current month if report required for the current year, otherwise return all months for the older year
	*	@return array
	*/
	function getMonthsArray($year)
	{
		$start_month = '1';
		$end_month	 = '';
		$month_val	 = '';
		$data		 = array();
		if($year = date("Y"))
		{
			$end_month = (int)date("m");
		}
		else
		{
			$end_month	 = '12';
		}
		for($i = $start_month; $i <= $end_month; $i++  )
		{
			if($i < 10)
			{
				$month_val = '0'.$i;
			}
			else
			{
				$month_val = $i;
			}
			//creating month array
			$data[] = $month_val;
		}
		return $data;
		
	}//end of month array
	
	/**
	*	Get the Start date and end date of a month
	*	@return array
	*/
	function getStartEndDate($month, $year)
	{
		//total number of days
		$date_string = mktime(0,0,0,$month,1,$year);
		$total_days_in_month = date("t",$date_string);
		$start_date	= $year.$month.'01';
		$end_date	= $year.$month.$total_days_in_month;
		$date	= array($start_date, $end_date);
		return $date; 
	}//end of function
	
	/**
	*	Generate the months along with checkbox in array
	*	@return NULL
	*/
	function generateMonthCheckbox()
	{
		$lineBreak = '';
		
		for($i=1; $i<= 12; $i++)
		{
			if($i < 10)
			{
				$j = '0'.$i;
			}
			else
			{
				$j = $i;
			}
			if($i % 2 == 0)
			{
				$lineBreak = '<br />';
			}
			else
			{
				$lineBreak = '';
			}
			echo "<div style='width:100px; float:left'><input name=\"month[]\" type=\"checkbox\" value=\"".$j."\" > "
			.$this->getMonthName($j)."</div>".$lineBreak
			;
		}
	}
	
	/**
	*	Generate dropdown list for duration type
	*/
	function genDurationList($selected)
	{
		$duration	= array('Day','Week','Month','Year');
		$select_string = '';
		foreach($duration as $k)
		{
			if($selected == $k)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			echo "<option value='".$k."' ".$select_string.">".$k."</option>";
		}
	}//eof
	
	////////////////////////////////////////////////////////////////////////////////////////
	//
	//				*********			Event YEar Options		*********
	//
	/////////////////////////////////////////////////////////////////////////////////////////
	function genStartYear($selected)
	{
		$start	=	date('Y')-5;
		$end  	= 	date('Y')+5;
		echo "<select name='startYear' id='startYear' onChange='getEndYear()'>";
		for($i= $start; $i<= $end; $i++)
		{
			if($i == $selected)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			echo "<option value='".$i."' class='menuText' ".$select_string.">".
			$i."</option>";
		}
		echo "</select>";
	}//eof
	
	function genEndYear($start)
	{
		$start = $start + 1;
		$end   = $start	+ 5;
		echo "<select name='endYear' id='endYear'>";
		for($i= $start; $i<= $end; $i++)
		{			
			echo "<option value='".$i."' class='menuText'>".$i."</option>";
		}
		echo "</select>";
	}//eof
	
	//////////////////////////////////////////////////////////////////////////////////////////////
	/**
	*	Print modified date with time
	*
	*	@param
	*			$date		Date to print
	*
	*	@return string
	*/
	function printModDate($date)
	{
		$str	= '';
		
		if($date == '0000-00-00 00:00:00')
		{
			$str	= 'not modified';
		}
		elseif($date == '0000-00-00')
		{
			$str	= 'not modified';
		}
		else
		{
			$str	= $this->printDate($date);
		}
		
		//retun the value
		return $str;
	}//eof
	
	/**
	*	Print a month ahead
	*
	*	@return date
	*/
	function printMonthAhead()
	{
		$time	= mktime(0,0,0,(int)date('m')+1,(int)date('d'),(int)date('Y'));
		$date	= date("Y-m-d",$time);
		
		//return teh value
		return $date;
	}
	
	/**
	*	Print next date after certain number of days from any given date
	*
	*	@param
	*			$date		Given date
	*			$numDays	Number of days
	*
	*	@return date
	*/
	function printNextDate($date, $numDays)
	{
		$new_day = date("Y-m-d");
		
		$year 	= (int)substr($date,0,4);
		$month 	= (int)substr($date,5,2);
		$day 	= (int)substr($date,8,2);
		
		//time stamp
		$date_string = mktime(0,0,0,$month,$day+$numDays,$year);
		
		$new_day	 = date("Y-m-d",$date_string);
		
		//return the value
		return $new_day;
		
	}//eof
	
	
	
	/**
	*	Update date of any table
	*	@date	September 12, 2008
	*
	*	@param 
	*			$idCol		Primary Key column name
	*			$idVal		Primary Key value
	*			$dtCol		Date field or column name
	*			$dtVal		Date value
	*			$table		Name of the table
	*			$isDT		Id date and time both wanted or not, Contstant value of YES or NO
	*						It is not used at this moment, as it is kept for future use.
	*			
	*	@return date
	*/
	function editDate($idCol, $idVal, $dtCol, $dtVal, $table)
	{
		//define var
		$date	= date("Y-m-d H:i:s");
		$sql	= '';
		
		//sql condition
		if($dtVal == '')
		{
			//statement
			$sql = "UPDATE ".$table." SET ".$dtCol."= now() WHERE ".$idCol."='$idVal' ";
		}
		else
		{
			//initialize date
			$date	= $dtVal;
			
			//statement
			$sql = "UPDATE ".$table." SET ".$dtCol."= '$dtVal' WHERE ".$idCol."='$idVal' ";
		}
		
		//execute query
		$query	= mysql_query($sql);
		
		
		//return the value
		return $date;
		
	}//eof
	
	
	/**
	*	Check date format and validate the date against a given string
	*	@date June 01, 2009
	*
	*	@param
	*			$dateStr	Date string to validate
	*
	*	@return 	String
	*/
	function checkDate($dateStr)
	{
		//security
		$dateStr	= trim(addslashes($dateStr));
		$result		= '';
		
		if(preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $dateStr, $dtArr))
		{
			if(checkdate($dtArr[2], $dtArr[3], $dtArr[1]))
			{
				$result		= 'SU';
			}
			else
			{
				$result		= 'ER';
			}
		}
		else
		{
			$result		= 'ER';
		}
		
		//return result
		return $result;
	
	}//eof
	
	
	#####################################################################################################
	#
	#									Month And Year Dropdown for Version 2.2
	#
	#####################################################################################################
	
	/**
	*	Generate a drop down list of years starting from a predefined year and ending on the 
	*	predefined year as specified by the user.
	*
	*	@date	March 6, 2010
	*
	*	@param	
	*			$startY			Starting year
	*			$endY			Ending year
	*
	*	@return array 
	*/
	function genYearArr($startY, $endY)
	{
		//declae var
		$yearStr	= '';
		$yearArr	= array();
		
		//start bulding the array
		if($startY >= $endY)
		{
			$yearArr[]	= $endY;
		}
		else
		{
			for($y= $startY; $y <= $endY; $y++)
			{
				$yearArr[]	= $y;
			}
		}
		
		//return the year array
		return $yearArr;
		
	}//eof
	
	
	/**
	*	Generate the dropdown list of the year with ajax function enabled
	*
	*	@date	March 6, 2010
	*
	*	@param	
	*			$selected		If the year is already selected
	*			$startY			Starting year
	*			$endY			Ending year
	*
	*	@return array 
	*/
	function genYearDropdown($selected, $startY, $endY)
	{
		//declare vars
		$selectStr	= '';
		
		//get the list
		$yearArr	= $this->genYearArr($startY, $endY);
		
		//reverse the elements so that latest year will come on top of the list
		$yearArr	= array_reverse($yearArr);
		
		if(count($yearArr) > 0)
		{
			foreach($yearArr as $yrKey => $yrVal)
			{
				if($selected == $yrVal)
				{
					$selectStr	= "selected";
				}
				else
				{
					$selectStr	= "";
				}
				
				//display output
				echo "<option value='".$yrVal."' ".$selectStr.">".$yrVal."</option>";
			}
		}//if
		
	}//eof
	
	
	/**
	*	Generate a month array by year depending upon a year selected
	*	
	*	@param
	*			$year			The year to generate the relevant months
	*
	*	@return string	
	*/
	function genMonthByYearArr($year)
	{
		//declare var
		$monthArr	= array();
		
		//convert the year in interger value
		if( ($year == '') || (!preg_match("/^([0-9]{4})/", $year)) )
		{
			$year	= (int)date("Y");
		}
		else
		{
			$year	= $year;
		}
		
		
		for($m= 1; $m <=12; $m++)
		{
			//month
			$mon		= $this->changeDayMonth($m);	
			$monthArr[]	= $year."-".$mon."-"."01";
		}
		
		//return the month array
		return $monthArr;
		
	}//eof
	
	
	
	/**
	*	Generate a month list by year depending upon a year selected
	*	
	*	@param
	*			$year			The year to generate the relevant months
	*			$selected		If any row has already been selected
	*
	*	@return string	
	*/
	function genMonthByYearList($selected,  $year)
	{
		//declare var
		$select_string 	= '';
		
		//get the list of month
		$monthArr	= $this->genMonthByYearArr($year);
		
		//reverse the array
		$monthArr	= array_reverse($monthArr);
		
		foreach($monthArr as $maKey=>$maVal)
		{
			if($selected == $maVal)
			{
				$selectStr	= "selected";
			}
			else
			{
				$selectStr	= "";
			}
			
			//get months and year
			$dateStr	= $this->printDate5($maVal);
			
			//display output
			echo "<option value='".$maVal."' ".$selectStr.">".$dateStr."</option>";
		}
		
	}//eof
	
	
	
	/**
	*	Generate a list of months along with the date and year in array, starting from a predefined month 
	*	at runtime till  end of another month and year
	*	
	*	@date	March 05, 2010
	*	@param
	*			$startYM			Starting month and year
	*			$endYM				End month and year
	*	
	*	@return	string
	*/
	function genMonYearArr($startYM, $endYM)
	{
		//declare var
		$select_string 	= '';
		$monYrArr		= array();
		
		//get the starting day, month and year
		$sY 	= (int)substr($startYM,0,4);
		$sM 	= (int)substr($startYM,5,2);
		$sD 	= (int)substr($startYM,8,2);
		
		//end month
		$eY 	= (int)substr($endYM,0,4);
		$eM 	= (int)substr($endYM,5,2);
		$eD		= (int)substr($endYM,8,2);
		
		
		//get the list of year
		if($sY >= $eY)
		{
			//if current and starting year are the same
			if($sM >= $eM)
			{
				$mon		= $this->changeDayMonth($eM);
				$monYrArr[]	= $eY."-".$mon."-"."01";
			}
			else
			{
				for($m = $sM; $m <= $eM; $m++ )
				{
					$mon		= $this->changeDayMonth($m);
					$monYrArr[]	= $sY."-".$mon."-"."01";
				}
			}//else
			
		}
		else
		{
			//calculate for the first year
			for($m = $sM; $m <= 12; $m++ )
			{
				$mon		= $this->changeDayMonth($m);
				$monYrArr[]	= $sY."-".$mon."-"."01";
				
			}//for
			
			
			//claculate for the next years
			//if year difference is 1
			if( ($eY - $sY) == 1 )
			{
				//calculate for the next  year
				for($m = 1; $m <= $eM; $m++ )
				{
					$mon		= $this->changeDayMonth($m);
					$monYrArr[]	= $eY."-".$mon."-"."01";
				}//for	
				
			}//if
			else
			{
				//for all the years get 12 months
				for($y = $sY + 1; $y <= $eY - 1; $y++ )
				{
					//get months
					for($m = 1; $m <= 12; $m++)
					{
						$mon		= $this->changeDayMonth($m);
						$monYrArr[]	= $y."-".$mon."-"."01";
					}
				}//for 12 months
				
				
				//for the last year get rest of the months
				for($m = 1; $m <= $eM; $m++ )
				{
					$mon		= $this->changeDayMonth($m);
					$monYrArr[]	= $eY."-".$mon."-"."01";
				}//for
				
			}//else diff more than 1 year
			
			
			
		}//else end year more than starting year
		
		
		//return the array value
		return $monYrArr;
		
	}//eof
	
	
	/**
	*	Generate a dropdown list of months along with the year, starting from a predefined month 
	*	at runtime till  end of another month and year
	*	
	*	@date	March 05, 2010
	*	@param
	*			$selected			If any value is already selected
	*			$startYM			Starting month and year
	*			$endYM				End month and year
	*	
	*	@return	string
	*/
	function genMonYearDropdown($selected, $startYM, $endYM)
	{
		//declare vars
		$selectStr	= "";
		
		//get array of months
		$monthsArr	= $this->genMonYearArr($startYM, $endYM);
		
		//reverse the array in order to get the current month on the top of the list
		$monthsArr	= array_reverse($monthsArr);
		
		if(count($monthsArr) > 0)
		{
			foreach($monthsArr as $maKey=>$maVal)
			{
				if($selected == $maVal)
				{
					$selectStr	= "selected";
				}
				else
				{
					$selectStr	= "";
				}
				
				//get months and year
				$dateStr	= $this->printDate5($maVal);
				
				//display output
				echo "<option value='".$maVal."' ".$selectStr.">".$dateStr."</option>";
			}
			
		}//if
		
	}//eof
	
	
	
	
	/**
	*	Generate dropdown list of dates
	*	
	*	@date	May 27, 2011
	*
	*	@param
	*			$selected		If want to show any selected value
	*			$arr_value		Array of values
	*			$arr_label		Array of labels corresponding to it's values
	*
	*	@return NULL
	*/
	function genDateList($selected)
	{
		$monthArr	= array();
		$currMonth	= date('M');
		$dayArr		= array(1, 15);
		$strDate	= '';
		$monthName	= '';
		$yearVal	= '';
		$sel_str 	= '';
				
		//generate the month, date and year array
		for($k=0; $k< 12; $k++)
		{
			$timeStamp	= mktime(0,0,0,date('n')+$k, date('j'), date('Y'));
			$monthName	= date("M", $timeStamp);
			$yearVal	= date("Y", $timeStamp);
			foreach($dayArr as $x)
			{
				$strDate 	= $monthName." ".$x." ".$yearVal;
				$monthArr[]	= $strDate;
			}
		}
		
		//print the output
		for($m=0; $m< count($monthArr); $m++)
		{
			if($selected == $monthArr[$m])
			{
				$sel_str = 'selected';
			}
			else
			{
				$sel_str = '';
			}
			echo "<option value='".$monthArr[$m]."' ".$sel_str.">".$monthArr[$m]."</option>";
		};
		
	}//eof
	
	
	
	/**
	*	Generate dropdown list of dates with month and year only
	*	
	*	@date	May 27, 2011
	*
	*	@param
	*			$selected		If want to show any selected value
	*			$arr_value		Array of values
	*			$arr_label		Array of labels corresponding to it's values
	*
	*	@return NULL
	*/ 
	function genDateListWithMonthAndYear($selected)
	{
		$monthArr	= array();
		$valArr		= array();
		$currMonth	= date('M');
		$dayArr		= array(1);
		$strDate	= '';
		$monthName	= '';
		$monthVal	= '';
		$yearVal	= '';
		$sel_str 	= '';
				
		//generate the month, date and year array
		for($k=0; $k< 12; $k++)
		{
			$timeStamp	= mktime(0,0,0,date('n')+$k, date('j'), date('Y'));
			$monthName	= date("M", $timeStamp);
			$monthVal	= date("m", $timeStamp);
			$yearVal	= date("Y", $timeStamp);
			foreach($dayArr as $x)
			{
				$strDate 	= $monthName." ".$yearVal;//." ".$x
				$monthArr[]	= $strDate;
				$valArr	 []	= $yearVal."-".$monthVal."-"."01";
			}
		}
		
		//print the output
		for($m=0; $m< count($monthArr); $m++)
		{
			if($selected == $valArr[$m])
			{
				$sel_str = 'selected';
			}
			else
			{
				$sel_str = '';
			}
			echo "<option value='".$valArr[$m]."' ".$sel_str.">".$monthArr[$m]."</option>";
		};
		
	}//eof
	
	
	
	#####################################################################################################
	#
	#									Month And Year Dropdown for Version 2.3
	#
	#####################################################################################################
	
	
	
	
	/**
	*	Change date format to default value if the date field is empty. D in the function name implies Date
	*
	*	@date	July 02, 2011
	*
	*	@param
	*			$dateVal		Value of the date that has to enter
	*			$timeVal		Value of the time
	*
	*	@return date
	*/
	function getDateTimeValueByDT($dateVal, $timeVal)
	{
		//declare var
		$dateStr	= "";
		
		if($dateVal == "")
		{
			$dateStr = "0000-00-00 00:00:00";
		}
		else
		{
			$dateStr = $dateVal." ".$timeVal;
		}
		
		//return the val
		return $dateStr;
		
	}//eof
	
	
	
	
	/**
	*	Change date format to default value if the date field is null. DT in the function name implies Date and Time
	*
	*	@date	July 02, 2011
	*
	*	@param
	*			$dateVal		Value of the date that has to enter
	*
	*	@return date
	*/
	function getDateValueByD($dateVal)
	{
		//declare var
		$dateStr	= "";
		
		if($dateVal == "")
		{
			$dateStr = "0000-00-00";
		}
		else
		{
			$dateStr = $dateVal;
		}
		
		//return the val
		return $dateStr;
		
	}//eof
	
	
	/**
	*	Print empty date with time and alternate text. This will print out according to a 
	*	prespecified date format.
	*
	*	@date	July 02, 2011
	*
	*	@param
	*			$date		Date to print
	*			$altText	Alternate text to print
	*			$dfId		Date format id
	*
	*	@return string
	*/
	function printEmptyDateWithText($date, $altText, $dfId)
	{
		//declare var
		$str	= '';
		
		if($date == '')
		{
			$str	= $altText;
		}
		else if($date == '0000-00-00 00:00:00')
		{
			$str	= $altText;
		}
		else if($date == '0000-00-00')
		{
			$str	= $altText;
		}
		else
		{
			//start displaying with format 
			switch($dfId)
			{
				case 1:
					$str	= $this->printDate($date);
					break;
					
				case 2:
					$str	= $this->printDate2($date);
					break;
					
				case 3:
					$str	= $this->printDate3($date);
					break;
					
				case 4:
					$str	= $this->printDate4($date);
					break;
					
				case 5:
					$str	= $this->printDate5($date);
					break;
					
				default:
					$str	= $this->printDate($date);
					break;
				
			}
			
		}
		
		//retun the value
		return $str;
	}//eof
	
	#####################################################################################################
	#
	#									Month And Year Dropdown for Version 2.3
	#
	#####################################################################################################
	
	
	/**
	*	Populate a dropdown list of month. It will generate a stand alone list for PayPal credit card process.
	*	Month format presents the values of the month that has to display. e.g. F, m, M and n
	*
	*	@date	October 24, 2011	
	*
	*	@param
	*			$selected		If any month is already selected
	*			$monthFormat	Format of the month that has to display
	*
	*	@return string
	*/
	function genListOfMonth($selected, $monthFormat)
	{
		//declare var
		$listStr	= '';
		
		//create the string
		for($i=1; $i<= 12; $i++)
		{
			if($i < 10)
			{
				$j  = '0'.$i;
			}
			else
			{
				$j	= $i;
			}
		
			if($selected == $j)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string 	= '';
			}
			
			$timeStamp	= mktime(0, 0, 0, $i, 1, date("Y"));
			$monthName	= date($monthFormat, $timeStamp);
			
			$listStr	.=  "<option value=\"".$j."\" ".$select_string.">".$monthName."</option>";
		}
		
		//return the string
		return $listStr;
		
	}//eof
	
	
	
	/**
	*	Generate the dropdown list of the year for creadit card processing
	*
	*	@date	March 6, 2010
	*
	*	@param	
	*			$selected		If the year is already selected
	*			$startY			Starting year
	*			$endY			Ending year
	*
	*	@return array 
	*/
	function genListOfYear($selected, $startY, $endY)
	{
		//declare vars
		$selectStr	= '';
		$yearStr	= '';
		
		//get the list
		$yearArr	= $this->genYearArr($startY, $endY);
		
		
		//generate the list
		if(count($yearArr) > 0)
		{
			foreach($yearArr as $yrKey => $yrVal)
			{
				if($selected == $yrVal)
				{
					$selectStr	= "selected";
				}
				else
				{
					$selectStr	= "";
				}
				
				//display output
				$yearStr 	.= "<option value='".$yrVal."' ".$selectStr.">".$yrVal."</option>";
			}
		}//if
		
		//return the list of year
		return $yearStr;
		
	}//eof
	
	
	   /**
	 * 	This function will return Date format like 12 Dec, 2010
	 *
	 *	@Update	November 02, 2011
	 *
	 *	@param
	 *			$dateTime		Date and time that has to format
	 * 
	 *	@return	date
	 */
	  function printDate7($date)
	  {
	  	
	 	$day   = (int)substr($date,8,2);
		$month = (int)substr($date,5,2);
		$year  = (int)substr($date,0,4);
		
		$hour  = (int)substr($date, 11, 2);	
		$min   = (int)substr($date, 13, 2);	
		$sec   = (int)substr($date, 15, 2);	
		
		$date_string = mktime($hour, $min, $sec, $month,$day,$year);
		
		$dateFormat = date("g a, d M, Y",$date_string);
		
		//return the date
		return $dateFormat;
		
	  }//eof
	  
	
	
	/**
	*	This function will return Date format like Monday June 12, 2006
	*
	*	@date	November 28, 2011
	*
	*	@param
	*			$date			Date string to be formatted	
	*
	*	@return string
	*/
	function getFormattedDateNew($date)
	{
	  	//get the parameter
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,5,2);
		$day = (int)substr($date,8,2);
		
		//date string
		$date_string = mktime(0,0,0,$month,$day,$year);
		
		//format the date
		$dateFormat = date("l, F j, Y",$date_string);
		
		//return
		return $dateFormat;
	}//eof
	
	
	 /**
	 * 	This function will return Date format like 12 Dec, 2010 9:00 am
	 *
	 *	@Update	March 02, 2012
	 *
	 *	@param
	 *			$dateTime		Date and time that has to format
	 * 
	 *	@return	date
	 */
	  function printDate8($date)
	  {
	  	
	 	$day   = (int)substr($date,8,2);
		$month = (int)substr($date,5,2);
		$year  = (int)substr($date,0,4);
		
		$hour  = (int)substr($date, 11, 2);	
		$min   = (int)substr($date, 14, 2);	
		$sec   = (int)substr($date, 17, 2);	
		
		$date_string = mktime($hour, $min, $sec, $month,$day,$year);
		
		$dateFormat = date(" d F Y g:i a",$date_string);
		
		//return the date
		return $dateFormat;
		
	  }//eof
	  
	  
	  
	  /**
	  *		This function is going to convert from AM, PM to time format
	  *
	  *		@param
	  *			$timeType		This can be either AM or PM
	  *			$hr				Hour in integer format
	  *			$min			Minute in integer format
	  *
	  *		@return string
	  */
	  function convertAMPMTime($timeType, $hr, $min)
	  {
		  //declare var
		  $timeStr	= '00:00:00';
		  
		  if($timeType == 'am')
		  {
			  $timeStr	= $hr.":".$min.":00";
		  }
		  else
		  {
			  $hr	= $hr + 12;
			  $timeStr = $hr.":".$min.":00";
		  }
		  
		  //return the formatted string
		  return $timeStr;
		  
	  }//eof
	  
	   /**
	  *		This function is going to convert from time format to AM, PM
	  *
	  *		@param
	  *			$date			Time format
	  *
	  *		@return string
	  */
	  function convertTimeToAMPM($date)
	  {
		  //declare var
		  $hour  = (int)substr($date, 11, 2);	
		  $min   = (int)substr($date, 14, 2);	
		  $sec   = (int)substr($date, 17, 2);
		  
		  $timeStr	= '00:00:00';
		  $amPm		= '';
		  $data	= array( $timeStr, $amPm );
		 
		  $timeStr	= '00:00:00';
		  
		  if(($hour == '00') && ($min == '00') )
		  { 
			  $amPm		= "am";
			  
			  $timeStr	= $hour.":".$min.":00";
		  }
		  else if(($hour == 12) && ($min == '00') )
		  {
			  $amPm		= "pm";
			  
			  $timeStr = $hour.":".$min.":00";
		  }
		  else if( ($hour >= 12) && ($hour <= 23) )
		  {
			  $hour	= $hour - 12;
			  
			  $amPm		= "pm";
			  
			  $timeStr = $hour.":".$min.":00";
		  }
		  else if( ($hour < 12) && ($hour >= '00') )
		  {
			  
			  $amPm		= "am";
			  
			  $timeStr = $hour.":".$min.":00";
		  }
		
		  //get result
		  $data	= array( $timeStr, $amPm );
		  
		  //return the result
		  return $data;
		  
	  }//eof
	
	/**
	*	Get the formatted date values separately in array, usable for calendars
	*
	*	@date November 09, 2010
	*
	*	@param
	*			$date			Date string to be formatted	
	*
	*	@return array
	*/
	function getDateForCalendar($date)
	{
		//declare var
		$dateVal = array();
		$dateData = array();
		
		//date data in array
		$dateData = $this->getDateInArray($date);
		
		//date string
		$date_string = mktime(0,0,0,$dateData[1],$dateData[2],$dateData[0]);
		
		//formatted month
		$monthFormat = date("M",$date_string);
		
		//formatted date
		$dayFormat = date("d",$date_string);
		
		//formatted date
		$yearFormat = date("y",$date_string);
		
		//rearrange up the elements in Year, Month, Day
		$dateVal = array($yearFormat, $monthFormat, $dayFormat);
		
		//return the value
		return $dateVal;
		
	}//eof

	/**
	*	Get the date data in an array
	*
	*	@date November 09, 2010
	*
	*	@param
	*			$date			Date string to be formatted	
	*
	*	@return array
	*/
	function getDateInArray($date)
	{
		//declare var
		$dateArr = array();
		
		//get the parameter
	 	$year = (int)substr($date,0,4);
		$month = (int)substr($date,5,2);
		$day = (int)substr($date,8,2);
		
		$dateArr = array($year, $month, $day);
		
		//return the array
		return $dateArr;
		
	}//eof
	
	
}//eof
?>