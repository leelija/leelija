<?php 
//include_once("../_config/connect.php");
//include_once("category.class.php");

/*
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
THIS CLASS CONTAINS ALL THE COUNTRY INFORMATION

AUTHOR 		: HIMADRI
DATE   		: JULY 03, 2006
VERSION		: 1.0
COPYRIGHT	: ANALYZE SYSTEM
EMAIL		: HIMADRI.S.ROY@ANSYSOFT.COM
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

class Countries
{
	/*
		ADD NEW COUNTRY
		VARIABLE:
		NAME			:	NAME OF THE COUNTRY
		CODE2			:	2 CHARACTERS PRESENTATION OF COUNTRY
		CODE3			:	3 CHARACTERS PRESENTATION OF COUNTRY
	*/
	function addCountry($countries_name, $countries_iso_code_2, $countries_iso_code_3)
	{
		$countries_name 		= trim($countries_name);
		$countries_iso_code_2 	= trim($countries_iso_code_2);
		$countries_iso_code_3	= trim($countries_iso_code_3);
		$insert	= "INSERT INTO countries
						(countries_name,countries_iso_code_2,countries_iso_code_3)
						VALUES
						('$countries_name','$countries_iso_code_2', '$countries_iso_code_3')
						";
		$query		= mysql_query($insert);
	}//	END OF ADD COUNTRY
	/*
		EDIT EXISITING TAX 
		VARIABLE:
		COUNTRYID		:	ID OF THE COUNTRY
		NAME			:	NAME OF THE COUNTRY
		CODE2			:	2 CHARACTERS PRESENTATION OF COUNTRY
		CODE3			:	3 CHARACTERS PRESENTATION OF COUNTRY
	*/
	function editCountry($countryId, $countries_name, $countries_iso_code_2, $countries_iso_code_3)
	{
		$countries_name 		= trim($countries_name);
		$countries_iso_code_2 	= trim($countries_iso_code_2);
		$countries_iso_code_3	= trim($countries_iso_code_3);
		$update 	=   "UPDATE countries
						SET
						countries_name 			=	'$countries_name',
						countries_iso_code_2	=	'$countries_iso_code_2',
						countries_iso_code_3	=	'$countries_iso_code_3'
						WHERE 
						countries_id			= '$countryId'
						";
		$query		= mysql_query($update);
	}//	END OF EDIT COUNTRY
	
	/*
		DELETE COUNTRY FROM THE SYSTEM
		VARIABLE:
		COUNTRYID		:	ID OF THE COUNTRY
	*/
	function deleteCountry($countryId)
	{
		$delete	= "DELETE FROM countries WHERE countries_id	= '$countryId'";
		$query		= mysql_query($delete);
	}//	END OF DELETE COUNTRY
	
	/*
		SHOW DATA RELATED TO COUNTRY
		VARIABLE:
		COUNTRYID		:	ID OF THE COUNTRY
	*/
	function showCountry($countryId)
	{
		$select		= "SELECT * FROM countries WHERE countries_id='$countryId'";
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		$data		= array();
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_array($query))
			{
				$data	=	array(
								  $result['countries_name'],		//0
								  $result['countries_iso_code_2'],	//1
								  $result['countries_iso_code_3']	//2 
								);
			}
		}	
		return $data;	
	}//	END OF SHOW TAX
	
	/*
		POPULATE THE DROPDOWN LIST OF COUNTRY
		VARIABLE:
		COUNTRYID		:	ID OF THE COUNTRY
	*/
	function countryDropDown($countryId)
	{
		$select		= "SELECT * FROM countries";
		$query		= mysql_query($select);
		
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_array($query))
			{
				$country_id	= $result['countries_id'];
				if($countryId == $country_id)
				{
					$select_string = 'selected';
				}
				else
				{
					$select_string = '';
				}
				
				echo "<option value='".$country_id."' class='menuText' ".$select_string.">".
				$result['countries_name'].
				"</option>";
			}
		}	
		
	}//	END OF POPULATE DROPDOWN LIST
	
	
}
?>