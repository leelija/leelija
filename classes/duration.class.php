<?php 

class GeneraicDuration 
{
	function getEndDate($startDate, $duration, $type)
	{
		/* Getting the year month  */
		$year 	= (int)substr($startDate,0,4);
		$month 	= (int)substr($startDate,5,2);
		$day 	= (int)substr($startDate,8,2);
		$endDate = '';
		//echo $startDate." ".$month;exit;
		if($type == 'Month')
		{
			$endDate = mktime(0,0,0,$month + $duration, $day, $year);
			$endDate = date("Y-m-d", $endDate);
		}
		else if($type == 'Week')
		{
			$duration = $duration * 7;
			$endDate = mktime(0,0,0,$month , $day + $duration, $year);
			$endDate = date("Y-m-d", $endDate);
		}
		else if($type == 'Day')
		{
			$endDate = mktime(0,0,0,$month , $day + $duration, $year);
			$endDate = date("Y-m-d", $endDate);
		}
		else if($type == 'Year')
		{
			$endDate = mktime(0,0,0,$month , $day, $year + $duration);
			$endDate = date("Y-m-d", $endDate);
		}
		//echo $month." = ".$month + $duration.$type.$duration;exit;
		return $endDate;
	}
	function getEventCalDuration($packageId)
	{
		$select = "SELECT * FROM eventcal_package WHERE event_package_id='$packageId'";
		$query = mysql_query($select);
		$result = mysql_fetch_array($query);
		if($packageId == '')
		{
			$data = array(1,'Week');
		}
		else
		{
			$data = array($result['event_package_duration'],$result['event_package_duration_type']);
		}
		return $data;
	}
}
?>