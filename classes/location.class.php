<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
*	This class works to manage location which includes province
*	county and town. Every province will have county and every county 
*	will have town.
*	Note: The images related to province, county and town will be uploading and  
*	deleting separately through utility class.
*
*	Update May 22, 2014
*	Added country id to town
*	Added country id to county
*
*
*	@author     	Himadri Shekhar Roy
*	@date   	 	November 20, 2006
*	@version 		1.0
*	@copyright 		Analyze System
*	@email			himadri.s.roy@ansysoft.com
*
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

class Location
{
	/**
	* 	Create a province
	*	
	*	@param	
	*			$name	Province name
	*			$desc	Province description
	*			$code	Province Code
	*
	*	@return string
	*/
	function addProvince($name, $desc, $countryId, $code)
	{
		$name	=	trim(addslashes($name));
		$desc	=	trim(addslashes($desc));
		$code	=	trim(addslashes($code));
		
		$sql 	= "INSERT INTO province
				  (province_name, province_desc, countries_id, code, added_on)
				  VALUES
				  ('$name', '$desc', '$countryId', '$code', now())";
		$query	= mysql_query($sql);
		//echo $sql.mysql_error(); exit ;
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = mysql_insert_id();
		}
		return $result;
	}//eof
	
	/**
	*	Delete a province. Check whether there are county added under this province
	*	@param $id	Province id
	*	@return string
	*/
	function deleteProvince($id)
	{
		$cIds = $this->getCountyId($id);
		
		if(count($cIds) > 0)
		{
			//if counties are exists, don't delete
			$result = "ER103";
		}
		else
		{
			//deleting from province
			$sql	= "DELETE FROM province WHERE province_id='$id'";
			$query	= mysql_query($sql);
			
			$result = '';
			if(!$query)
			{
				$result = "ER103";
			}
			else
			{
				$result = "SU103";
			}
		}
		//return the result
		return $result;
	}//eof
	
	/**
	*	Update province
	*	@return string
	*	@param	
	*			$id		Province id
	*			$name	Province name
	*			$desc	Province description
	*/
	function updateProvince($id, $name, $desc, $code)
	{
		$name   = trim($name);
		$desc   = trim($desc);
		$id   	= trim($id);
		
		$sql	= "UPDATE province SET
				  province_name = '$name',
				  province_desc	= '$desc',
				  province_code	= '$code',
				  modified_on	=  now()
				  WHERE 
				  province_id 	= '$id'
				  ";
		$query	= mysql_query($sql);
	}//eof
	
	/**
	*	Retrieve all province id
	*	@return array
	*/
	function getProvinceId()
	{
		$sql	= "SELECT province_id FROM province ORDER BY province_name";
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['province_id'];
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all province data
	*	@return array
	*	@param	
	*			$id		id of the province
	*
	*/
	function getProvinceData($id)
	{
		//create the statement
		$sql	= "SELECT * FROM province WHERE province_id='$id'";
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			
			$data = array(
						 $result['province_name'],		//0
						 $result['province_desc'],		//1
						 $result['province_image'],		//2
						 $result['added_on'],			//3
						 $result['modified_on'],		//4
						 $result['code']				//5
						 );
						
		} 
		return $data;
	}//eof
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////
	//
	//				********** TOWN ***********
	//
	////////////////////////////////////////////////////////////////////////////////////
	
	/**
	* 	Create a town
	*	@return string
	*	@param
	*			$countryId	Country id	
	*			$pid		Province id
	*			$cid		County id
	*			$name		Town name
	*			$desc		Town description
	*/
	function addTown($countryId, $pid, $cid, $name, $desc)
	{
		$name   = trim($name);
		$desc   = trim($desc);
		$cid   	= trim($cid);
		
		$sql 	= "INSERT INTO town
				  (countries_id, province_id, county_id, town_name, town_desc, added_on)
				  VALUES
				  ('$countryId', '$pid', '$cid','$name', '$desc', now())";
		$query	= mysql_query($sql);
		//echo $sql.mysql_error();exit;
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = mysql_insert_id();
		}
		return $result;
	}//eof
	
	/**
	*	Delete a town.
	*	@param $id	Town id
	*	@return string
	*/
	function deleteTown($id)
	{
		//deleting from town
		$sql	= "DELETE FROM town WHERE town_id='$id'";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = "ER103";
		}
		else
		{
			$result = "SU103";
		}
		
		//return the result
		return $result;
	}//eof
	
	/**
	*	Update Town
	*	@return string
	*	@param	
	*			$tid	Town id
	*			$cid	County id
	*			$name	Town name
	*			$desc	Town description
	*/
	function updateTown($tid, $cid, $pid, $countryId, $name, $desc)
	{
		$name   = trim($name);
		$desc   = trim($desc);
		$tid   	= trim($tid);
		$cid   	= trim($cid);
		
		$sql	= "UPDATE town SET
				  countries_id	= '$countryId',
				  province_id	= '$pid',
				  county_id 	= '$cid',
				  town_name 	= '$name',
				  town_desc		= '$desc',
				  modified_on	=  now()
				  WHERE 
				  town_id	 	= '$tid'
				  ";
		$query	= mysql_query($sql);
	}//eof
	
	/**
	*	Retrieve all town id
	*	@return array
	*	@param
	*			$id		Unique id
	*			$type	Province, County or Town
	*/
	function getTownId($id, $type)
	{
		$id = (int)$id;
		if($type == 'PROVINCE')
		{
			$sql	= "SELECT town_id FROM town T,county C,province P 
					   WHERE P.province_id = C.province_id
					   AND   C.county_id   = T.county_id
					   AND   P.province_id = '$id'
					   ORDER BY P.province_id, C.county_name, T.town_name";
		}
		elseif($type == 'COUNTY')
		{
			$sql	= "SELECT town_id FROM town T,county C,province P 
					   WHERE P.province_id = C.province_id
					   AND C.county_id   = T.county_id
					   AND   C.county_id   = '$id'
					   ORDER BY town_name";
		}
		else
		{
			$sql	= "SELECT town_id FROM town T,county C,province P
					   WHERE P.province_id = C.province_id
					   AND   C.county_id   = T.county_id 
					   ORDER BY P.province_id, C.county_name, T.town_name";
		}
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['town_id'];
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all town id
	*	@return array
	*	@param
	*			$id		Unique id
	*			$type	Province, County or Town
	*/
	function getAllTownId()
	{

		$sql	= "SELECT town_id FROM town";

		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['town_id'];
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all town data and county data
	*	@return array
	*	@param	
	*			$id		id of the county
	*
	*/
	function getTownData($id)
	{
		//create the statement
		$sql	= 	"SELECT 
					T.town_name AS T_NAME, T.town_desc AS T_DESC, 
					T.town_image AS T_IMG, T.added_on AS T_ADD,  T.modified_on AS T_MOD,
					C.county_name AS C_NAME, C.county_desc AS C_DESC, C.county_image AS C_IMG,  
					C.added_on AS C_ADD, C.modified_on AS C_MOD, C.county_id AS C_ID,
					P.province_name AS P_NAME, P.province_desc AS P_DESC, P.province_image AS P_IMG,  
					P.added_on AS P_ADD, P.modified_on AS P_MOD, P.province_id AS P_ID
					FROM province P, county C, town T
				    WHERE 
					T.county_id= C.county_id
					AND P.province_id= C.province_id
					AND T.town_id = '$id'";
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			
			$data = array(
						 
						 $result['T_NAME'],		//0 TOWN FIRST
						 $result['T_DESC'],		//1
						 $result['T_IMG'],		//2
						 $result['T_ADD'],		//3
						 $result['T_MOD'],		//4
						
						 $result['C_ID'],		//5 COUNTY NEXT
						 $result['C_NAME'],		//6 
						 $result['C_DESC'],		//7
						 $result['C_IMG'],		//8
						 $result['C_ADD'],		//9
						 $result['C_MOD'],		//10
						 
						 $result['P_ID'],		//11 COUNTY NEXT
						 $result['P_NAME'],		//12 
						 $result['P_DESC'],		//13
						 $result['P_IMG'],		//14
						 $result['P_ADD'],		//15
						 $result['P_MOD']		//16
						 );
						
		} 
		return $data;
	}//eof
	
	/**
	*	Retrieve all town data and county data
	*	@return array
	*	@param	
	*			$id		id of the county
	*
	*/
	function getTownDataByTownId($id)
	{
		//create the statement
		$sql	= 	"SELECT * 
					 FROM town
					 WHERE  town_id = '$id'";
					 
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			
			$data = array(
						 
						 $result['countries_id'],		//0 TOWN FIRST
						 $result['province_id'],		//1
						 $result['county_id'],			//2
						 $result['town_name'],			//3
						 $result['latitude'],			//4
						
						 $result['longitude'],			//5 
						 $result['town_desc'],			//6 
						 $result['town_image'],			//7
						 $result['added_on'],			//8
						 $result['modified_on']			//9

						 );
						
		} 
		return $data;
	}//eof
	
	/**
	*	Display location as a bread crumb style. BC referes to bread crumb.
	*	
	*	@param
	*			$id		Location id
	*			$type	Location type, town, county or province
	*	
	*	@return string
	*/
	function displayLocBC($id, $isUnderline, $type)
	{
		switch($type)
		{
			case 'TOWN':
				$townDetail = $this->getTownData($id);
				if($isUnderline == 'YES')
				{
					$breadCrumb	= "<u>".$townDetail[12]."</u> > <u>".$townDetail[6]."</u> > "
					.$townDetail[0];
				}
				else
				{
					$breadCrumb	= $townDetail[12]." > ".$townDetail[6]." > ".$townDetail[0];
				}
				break;
			case 'COUNTY':
				$countyDetail = $this->getCountyData($id);
				if($isUnderline == 'YES')
				{
					$breadCrumb	= "<u>".$countyDetail[5]."</u> > <u>".$townDetail[0]."</u> > ";
				}
				else
				{
					$breadCrumb	= $countyDetail[5]." > ".$countyDetail[0];
				}
				break;
			case 'PROVINCE':
				$provinceDetail = $this->getProvinceData($id);
				if($isUnderline == 'YES')
				{
					$breadCrumb	= "<u>".$provinceDetail[0]."</u> > ";
				}
				else
				{
					$breadCrumb	= $provinceDetail[0];
				}
				break;
			
		}//switch
		
		
		return $breadCrumb;
	}//eof
	
	
		/////////////////////////////////////////////////////////////////////////////////////
	//
	//				********** COUNTY ***********
	//
	////////////////////////////////////////////////////////////////////////////////////
	
	/**
	* 	Create a county
	*	@return string
	*	@param	
	*			$pid		Province id
	*			$name	County name
	*			$desc	County description
	*/
	function addCounty($countryId,  $pid, $name, $desc)
	{
		$name   = trim($name);
		$desc   = trim($desc);
		$pid   	= trim($pid);
		
		$sql 	= "INSERT INTO county
				  (countries_id, province_id, county_name, county_desc, added_on)
				  VALUES
				  ('$countryId', '$pid','$name', '$desc', now())";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = mysql_insert_id();
		}
		return $result;
	}//eof
	
	/**
	*	Delete a county. Check whether there are town added under this county
	*	@param $id	County id
	*	@return string
	*/
	function deleteCounty($id)
	{
		$tIds = $this->getTownId($id, 'COUNTY');
		
		if(count($tIds) > 0)
		{
			//if town exists, don't delete
			$result = "ER103";
		}
		else
		{
			//deleting from county
			$sql	= "DELETE FROM county WHERE county_id='$id'";
			$query	= mysql_query($sql);
			
			$result = '';
			if(!$query)
			{
				$result = "ER103";
			}
			else
			{
				$result = "SU103";
			}
		}
		//return the result
		return $result;
	}//eof
	
	/**
	*	Update county
	*	@param	
	*			$cid	County id
	*			$pid	Province id
	*			$name	County name
	*			$desc	County description
	*/
	function updateCounty($cid, $countryId, $pid, $name, $desc)
	{
		$name   = trim($name);
		$desc   = trim($desc);
		$pid   	= trim($pid);
		$cid   	= trim($cid);
		
		$sql	= "UPDATE county SET
				  countries_id	= '$countryId',
				  province_id 	= '$pid',
				  county_name 	= '$name',
				  county_desc	= '$desc',
				  modified_on	=  now()
				  WHERE 
				  county_id 	= '$cid'
				  ";
		$query	= mysql_query($sql);
	}//eof
	
	/**
	*	Retrieve all county id
	*	@return array
	*	@param
	*			$pid	Province id
	*/
	function getCountyId($pid)
	{
		$pid = (int)$pid;
		if($pid == 0)
		{
			$sql	= "SELECT county_id FROM county ORDER BY province_id, county_name";
		}
		else
		{
			$sql	= "SELECT county_id FROM county  
					   WHERE province_id='$pid' 
					   ORDER BY province_id, county_name";
		}
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['county_id'];
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all county data and province data
	*	@return array
	*	@param	
	*			$id		id of the county
	*
	*/
	function getCountyData($id)
	{
		//create the statement
		$sql	= 	"SELECT 
					P.province_name AS P_NAME, P.province_desc AS P_DESC, P.province_id AS P_ID, 
					P.province_image AS P_IMG, P.added_on AS P_ADD,  P.modified_on AS P_MOD,
					C.county_name AS C_NAME, C.county_desc AS C_DESC, C.county_image AS C_IMG,  
					C.added_on AS C_ADD, C.modified_on AS C_MOD  
					FROM county C, province P
				    WHERE 
					P.province_id= C.province_id
					AND C.county_id = '$id'";
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			
			$data = array(
						 $result['C_NAME'],		//0 COUNTY FIRST
						 $result['C_DESC'],		//1
						 $result['C_IMG'],		//2
						 $result['C_ADD'],		//3
						 $result['C_MOD'],		//4
						 
						 $result['P_NAME'],		//5 PROVINCE NEXT
						 $result['P_DESC'],		//6
						 $result['P_IMG'],		//7
						 $result['P_ADD'],		//8
						 $result['P_MOD'],		//9
						 $result['P_ID']		//10
						 );
						
		} 
		return $data;
	}//eof
	
	
		/**
	*	Retrieve all town data and county data
	*	@return array
	*	@param	
	*			$id		id of the county
	*
	*/
	function getCountyDataByCountyId($id)
	{
		//create the statement
		$sql	= 	"SELECT * 
					 FROM county
					 WHERE  county_id = '$id'";
					 
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			
			$data = array(
						 
						 $result['countries_id'],		//0 TOWN FIRST
						 $result['province_id'],		//1
						 $result['county_name'],			//2
						 $result['county_desc'],			//3
						 $result['county_image'],			//4
						 $result['added_on'],			//5
						 $result['modified_on']			//6

						 );
						
		} 
		return $data;
	}//eof
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////
	//
	//				***************		Populating Dropdowns   *******************
	//
	////////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Generating county dropdowns
	*
	*	@date 	November 22, 2006
	*
	*	@param
	*			$cid	Country id
	*
	*	@return null
	*/
	function genProvinceList($cid)
	{
		//statement
		$select		= "SELECT 		* 
					   FROM 		province 
					   WHERE 		countries_id='$cid' 
					   ORDER BY 	province_name";
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		
				
		if(mysql_num_rows($query) > 0)
		{
			
			echo "
				  <label>State</label>
				  <select name='txtProvinceId' id='txtProvinceId' class='text-field' onChange='getCountyList()'>
					<option value='0'>-- Select One --</option>";
			while($result	= 	mysql_fetch_array($query))
			{
				$province_id		= $result['province_id'];
				$province_name		= $result['province_name'];
				
				echo "<option value='".$result['province_id']."'>".
						$result['province_name'].
					 "</option>";
					 
				
			}
			echo "</select>
			<div class='cl'></div>";

		}
		else
		{
			//statement
			$select		= "SELECT 		* 
						   FROM 		county 
						   WHERE 		countries_id='$cid' 
						   ORDER BY 	county_name";
			
			//execute query
			$query		= mysql_query($select);
			if(mysql_num_rows($query) > 0)
			{
				
				echo "
					  <label>District</label>
					  <select name='txtCountyId' id='txtCountyId' class='text-field' onChange='getTownList()'>
						<option value='0'>-- Select One --</option>";
				while($result	= 	mysql_fetch_array($query))
				{
					$province_id		= $result['county_id'];
					$province_name		= $result['county_name'];
					
					echo "<option value='".$result['county_id']."'>".
							$result['county_name'].
						 "</option>";
						 
					
				}
				echo "</select>
				<div class='cl'></div>";
			}
			
			else
			{
				//statement
				$select		= "SELECT 		* 
							   FROM 		town 
							   WHERE 		countries_id='$cid' 
							   ORDER BY 	town_name";
				
				//execute query
				$query		= mysql_query($select);
				if(mysql_num_rows($query) > 0)
				{
					
					echo "
						  <label>Town/Village</label>
						  <select name='txtTownId' id='txtTownId' class='text-field' onChange='getAltTown()'>
							<option value='0'>-- Select One --</option>";
					while($result	= 	mysql_fetch_array($query))
					{
						$province_id		= $result['town_id'];
						$province_name		= $result['town_name'];
						
						echo "<option value='".$result['town_id']."'>".
								$result['town_name'].
							 "</option>";
							 
						
					}
					echo "	<option value='0'>-- Add Town --</option>";
					echo "</select>
					<div class='cl'></div>";
				}
				else
				{
					echo "
						  <label>Town/Village</label>
						  <select name='txtTownId' id='txtTownId' class='text-field' onChange='getAltTown()'>
							<option value='0'>-- Select One --</option>";

					echo "	<option value='0'>-- Add Town --</option>";
					echo "</select>
					<div class='cl'></div>";
				}
			}
		}
		
	}//eof
	
	
	/**
	*	Generating county dropdowns
	*
	*	@date 	November 22, 2006
	*
	*	@param
	*			$cid	Country id
	*
	*	@return null
	*/
	function genProvinceList2($cid)
	{
		//statement
		$select		= "SELECT 		* 
					   FROM 		province 
					   WHERE 		countries_id='$cid' 
					   ORDER BY 	province_name";
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		
				
		if(mysql_num_rows($query) > 0)
		{
			
			echo "<label>State</label>
				  <div class='label-cl'></div>
				  <div class='select-container'>
				  <select name='txtProvinceId' id='txtProvinceId' class='text-field fancy' onChange='getCountyListByProvince()'>
					<option value='0'>-- Select One --</option>";
			while($result	= 	mysql_fetch_array($query))
			{
				$province_id		= $result['province_id'];
				$province_name		= $result['province_name'];
				
				echo "<option value='".$result['province_id']."'>".
						$result['province_name'].
					 "</option>";
					 
				
			}
			echo "</select>
			</div>";
				echo "<div class='cl'></div>";
		}
		else
		{
			//statement
			$select		= "SELECT 		* 
						   FROM 		county 
						   WHERE 		countries_id='$cid' 
						   ORDER BY 	county_name";
			
			//execute query
			$query		= mysql_query($select);
			if(mysql_num_rows($query) > 0)
			{
				
				echo "<label>District</label>
					  <div class='label-cl'></div>
				  	  <div class='select-container'>
					  <select name='txtCountyId' id='txtCountyId' class='text-field fancy' onChange='getTownList()'>
						<option value='0'>-- Select One --</option>";
				while($result	= 	mysql_fetch_array($query))
				{
					$province_id		= $result['county_id'];
					$province_name		= $result['county_name'];
					
					echo "<option value='".$result['county_id']."'>".
							$result['county_name'].
						 "</option>";
						 
					
				}
				echo "</select>
				</div>";
					echo "<div class='cl'></div>";
			}
			
			else
			{
				//statement
				$select		= "SELECT 		* 
							   FROM 		town 
							   WHERE 		countries_id='$cid' 
							   ORDER BY 	town_name";
				
				//execute query
				$query		= mysql_query($select);
				if(mysql_num_rows($query) > 0)
				{
					
					echo "<label>Town/Village</label>
						  <div class='label-cl'></div>
				  			<div class='select-container'>
						  <select name='txtTownId' id='txtTownId' class='text-field fancy' onChange='getAltTown()'>
							<option value='0'>-- Select One --</option>";
					while($result	= 	mysql_fetch_array($query))
					{
						$province_id		= $result['town_id'];
						$province_name		= $result['town_name'];
						
						echo "<option value='".$result['town_id']."'>".
								$result['town_name'].
							 "</option>";
							 
						
					}
					echo "	<option value='0'>-- Add Town --</option>";
					echo "</select>
					</div>";
				}
				else
				{
					echo "<label>Town/Village</label>
						  <div class='label-cl'></div>
				  			<div class='select-container'>
						  <select name='txtTownId' id='txtTownId' class='text-field fancy' onChange='getAltTown()'>
							<option value='0'>-- Select One --</option>";

					echo "	<option value='0'>-- Add Town --</option>";
					echo "</select>
					</div>";
						echo "<div class='cl'></div>";
				}
			}
		}
			
		
		
	}//eof
	
	
	/**
	*	Generating county dropdowns
	*
	*	@date 	November 22, 2006
	*
	*	@param
	*			$cid	Countries id
	*
	*	@return null
	*/
	function genProvinceList3($cid)
	{
		//statement
		$select		= "SELECT 		* 
					   FROM 		province 
					   WHERE 		countries_id='$cid' 
					   ORDER BY 	province_name";
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_array($query))
			{
				$province_id		= $result['province_id'];
				$province_name		= $result['province_name'];
				
				echo "<li value='".$province_id."' class='menuText' id='menuText".$province_id."'>".
				$province_name."</li>";
				
				/*echo "<option value='".$result['county_id']."'>".
						$result['county_name'].
					 "</option>";*/
			}
		}
		
	}//eof
	
	
	/**
	*	Generating county dropdowns
	*	@param
	*			$pid	Province id
	*	@date 	November 22, 2006
	*/
	function genCountyList($pid)
	{
		$select		= "SELECT 		* 
					   FROM 		county 
					   WHERE 		province_id='$pid' 
					   ORDER BY 	county_name";


		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		
				
		if(mysql_num_rows($query) > 0)
		{
			
			echo "
			  <label>District</label>
			  <select name='txtCountyId' id='txtCountyId' class='text-field' onChange='getTownList()'>
				<option value='0'>-- Select One --</option>";
				
			while($result	= 	mysql_fetch_array($query))
			{
				$county_id		= $result['county_id'];
				$county_name	= $result['county_name'];
				
				echo "<option value='".$result['county_id']."'>".
						$result['county_name'].
					 "</option>";
			}
			echo "</select>
			<div class='cl'></div>";
		}
		else
		{
			$select		= "SELECT 		* 
						   FROM 		town 
						   WHERE 		province_id='$pid' 
						   ORDER BY 	town_name";
	
	
			
			//execute query
			$query		= mysql_query($select);
			if(mysql_num_rows($query) > 0)
			{
				
				echo "
					  <label>Town/Village</label>
					  <select name='txtTownId' id='txtTownId' class='text-field' onChange='getAltTown()'>
						<option value='0'>-- Select One --</option>";
				while($result	= 	mysql_fetch_array($query))
				{
					$province_id		= $result['town_id'];
					$province_name		= $result['town_name'];
					
					echo "<option value='".$result['town_id']."'>".
							$result['town_name'].
						 "</option>";
						 
					
				}
				echo "	<option value='0'>-- Add Town --</option>";
				echo "</select>";
					echo "</div>
					<div class='cl'></div>";
			}
			else
			{
				echo "
					  <label>Town/Village</label>
					  <div class='label-cl'></div>
					  <select name='txtTownId' id='txtTownId' class='text-field' onChange='getAltTown()'>
						<option value='0'>-- Select One --</option>";

				echo "	<option value='0'>-- Add Town --</option>";
				echo "</select>
				<div class='cl'></div>";
			}
		}
		
	}//eof
	
	
	
	/**
	*	Generating county dropdowns
	*
	*	@date 	November 22, 2006
	*
	*	@param
	*			$pid	Province id
	*			$cid	Countries id
	*
	*	@return null
	*/
	function genCountyList2($pid, $cid)
	{
		//statement
		if($pid == -1)
		{
			$select		= "SELECT 		* 
						   FROM 		county 
						   WHERE 		countries_id='$cid' 
						   ORDER BY 	county_name";
		}
		else
		{
			$select		= "SELECT 		* 
						   FROM 		county 
						   WHERE 		province_id='$pid' 
						   ORDER BY 	county_name";
		}
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		echo "
			  <select name='countyId' id='countyId' class='text-field' onChange='getTownList()'>
				<option value='0'>-- Select One --</option>";
				
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_array($query))
			{
				$county_id		= $result['county_id'];
				$county_name	= $result['county_name'];
				
				echo "<option value='".$result['county_id']."'>".
						$result['county_name'].
					 "</option>";
			}
		}
		echo "<option value='-1'>NO COUNTY</option>";	
		echo "</select>";
		
	}//eof
	
	
	/**
	*	Generating county dropdowns
	*
	*	@date 	November 22, 2006
	*
	*	@param
	*			$pid	Province id
	*			$cid	Countries id
	*
	*	@return null
	*/
	function genCountyListByProvince($pid)
	{

		$select		= "SELECT 		* 
					   FROM 		county 
					   WHERE 		province_id='$pid' 
					   ORDER BY 	county_name";


		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		
				
		if(mysql_num_rows($query) > 0)
		{
			
			echo "<label>District</label>
			  	<div class='label-cl'></div>
				<div class='select-container'>
			  <select name='txtCountyId' id='txtCountyId' class='text-field fancy' onChange='getTownList()'>
				<option value='0'>-- Select One --</option>";
				
			while($result	= 	mysql_fetch_array($query))
			{
				$county_id		= $result['county_id'];
				$county_name	= $result['county_name'];
				
				echo "<option value='".$result['county_id']."'>".
						$result['county_name'].
					 "</option>";
			}
			echo "</select>
			</div>";
			echo "<div class='cl'></div>";
		}
		else
		{
			$select		= "SELECT 		* 
						   FROM 		town 
						   WHERE 		province_id='$pid' 
						   ORDER BY 	town_name";
	
	
			
			//execute query
			$query		= mysql_query($select);
			if(mysql_num_rows($query) > 0)
			{
				
				echo "<label>Town/Village</label>
					  <div class='label-cl'></div>
					  <div class='select-container'>
					  <select name='txtTownId' id='txtTownId' class='text-field fancy' onChange='getAltTown()'>
						<option value='0'>-- Select One --</option>";
				while($result	= 	mysql_fetch_array($query))
				{
					$province_id		= $result['town_id'];
					$province_name		= $result['town_name'];
					
					echo "<option value='".$result['town_id']."'>".
							$result['town_name'].
						 "</option>";
						 
					
				}
				echo "	<option value='0'>-- Add Town --</option>";
				echo "</select>
				</div>";
					echo "<div class='cl'></div>";
			}
			else
			{
				echo "<label>Town/Village</label>
					  <div class='label-cl'></div>
					  <div class='select-container'>
					  <select name='txtTownId' id='txtTownId' class='text-field fancy' onChange='getAltTown()'>
						<option value='0'>-- Select One --</option>";

				echo "	<option value='0'>-- Add Town --</option>";
				echo "</select>
				</div>";
					echo "<div class='cl'></div>";
			}
		}
			
		
		
	}//eof
	
	
	
	
	/**
	*	Generating county dropdowns
	*
	*	@date 	November 22, 2006
	*
	*	@param
	*			$pid	Province id
	*
	*	@return null
	*/
	function genCountyList3($pid)
	{
		//statement
		$select		= "SELECT 		* 
					   FROM 		county 
					   WHERE 		province_id='$pid' 
					   ORDER BY 	county_name";
		
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_array($query))
			{
				$county_id		= $result['county_id'];
				$county_name	= $result['county_name'];
				
				echo "<li value='".$county_id."' class='menuText' id='menuText".$county_id."'>".
				$county_name."</li>";
				
				/*echo "<option value='".$result['county_id']."'>".
						$result['county_name'].
					 "</option>";*/
			}
		}
			
		echo "</select>";
		
	}//eof
	
	
	
	/**
	*	Generating town dropdowns
	*
	*	@date 	December 4, 2006
	*
	*	@param
	*			$cid	County id
	*			$pid	Province id
	*
	*	@return null
	*/
	function genTownList($cid)
	{
		//statement
		$select		= "SELECT 		* 
					   FROM 		town 
					   WHERE 		county_id='$cid' 
					   ORDER BY 	town_name";

					   
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		
		
				
		if(mysql_num_rows($query) > 0)
		{
			echo "<label>Town / Village</label>
			<div class='label-cl'></div>";
			echo "<select name='txtTownId' id='txtTownId' onChange='getAltTown()' class='text-field'>
				<option value='0'>-- Select One --</option>";//
			while($result	= 	mysql_fetch_array($query))
			{
				$town_id		= $result['town_id'];
				$town_name	= $result['town_name'];
				
				echo "<option value='".$result['town_id']."' class='menuText'>".
						$result['town_name'].
					 "</option>";
				
			}
			echo "	<option value='0'>-- Add Town --</option>";
			echo "</select>";
			echo "<div class='cl'></div>";
		}
		else
		{
			echo "<label>Town / Village</label>
			<div class='label-cl'></div>";
			
			echo "<select name='txtTownId' id='txtTownId' onChange='getAltTown()' class='text-field'>
				<option value='0'>-- Select One --</option>";//

			echo "	<option value='0'>-- Add Town --</option>";
			echo "</select>";
			echo "<div class='cl'></div>";
		}
			
		
	}//eof
	
	
	/**
	*	Generating town dropdowns
	*
	*	@date 	December 4, 2006
	*
	*	@param
	*			$cid	County id
	*			$pid	Province id
	*
	*	@return null
	*/
	function genTownListByCounty($cid)
	{
		//statement
		$select		= "SELECT 		* 
					   FROM 		town 
					   WHERE 		county_id='$cid' 
					   ORDER BY 	town_name";

					   
		//execute query
		$query		= mysql_query($select);
		//echo $select.mysql_error();exit;
		
		
				
		if(mysql_num_rows($query) > 0)
		{
			echo "<label>Town / Village</label>
			<div class='label-cl'></div>
			<div class='select-container'>";
			echo "<select name='txtTownId' id='txtTownId' onChange='getAltTown()' class='text-field fancy'>
				<option value='0'>-- Select One --</option>";//
			while($result	= 	mysql_fetch_array($query))
			{
				$town_id		= $result['town_id'];
				$town_name	= $result['town_name'];
				
				echo "<option value='".$result['town_id']."' class='menuText'>".
						$result['town_name'].
					 "</option>";
				
			}
			echo "	<option value='0'>-- Add Town --</option>";
			echo "</select>
			</div>";
			echo "<div class='cl'></div>";
		}
		else
		{
			echo "<label>Town / Village</label>
			<div class='label-cl'></div>
			<div class='select-container'>";
			echo "<select name='txtTownId' id='txtTownId' onChange='getAltTown()' class='text-field fancy'>
				<option value='0'>-- Select One --</option>";//

			echo "	<option value='0'>-- Add Town --</option>";
			echo "</select>
			</div>";
			echo "<div class='cl'></div>";
		}
		
			
		
	}//eof
	
	/**
	*	Generating town dropdowns 2
	*
	*	@param
	*			$pid		Province id
	*			$class		Style of the Dropdown list
	*
	*	@return null
	*/
	function genTownList2($pid, $class)
	{
		$select		= "SELECT * FROM town WHERE province_id='$pid' ORDER BY town_name";
		$query		= mysql_query($select);
		
		echo "<div style='padding-top: 5px; padding-top: 5px;'>
				<select name='townId' id='townId' class='".$class."'>
				<option value='0'>-- Select One --</option>";
				
		if(mysql_num_rows($query) > 0)
		{
			while($result	= 	mysql_fetch_array($query))
			{
				$town_id	= $result['town_id'];
				$town_name	= $result['town_name'];
				
				echo "<option value='".$result['town_id']."' class='menuText'>".
				$result['town_name']."</option>";
				
			}
		}
		echo "<option value='0'>-- None Found --</option>";
		echo "</select>
				
				</div>";
			
		
	}//eof
	
	
	/**
	*	This function will allow user to add alternate town if none found
	*/
	function getAltTown()
	{
		echo "
				<div class='cl'></div>
				<label for='alternate city'>
					Alternate City/Village <span class='orangeLetter'>*</span>
				</label>			
				<input name='txtAltTown' type='text' class='text-field' id='txtAltTown' 
				size='25' title='alternate city'  style='float:left; ' >
				<span id='verifyTownName'></span>
                <div class='cl'></div>
			
			 ";
	}//eof
	
	/**
	*	This function will allow user to add alternate town if none found
	*/
	function getAltTown3()
	{
		echo "<div style='width:125px; float:left;padding-top:3px; '>Alternate Town</div>
                  <div style='float:left; '>
                    <input name='txtAltTown' type='text' class='text_box_large' id='txtAltTown' 
					size='25' title='alternate city'  style='float:left; ' onChange='verifyTown()'>
					
					<span class='maroonErrorLarge'>*</span>
					<span id='verifyTownName'></span>
                  </div>
			 ";
	}//eof
	
	/**
	*	This function will allow user to add alternate town if none found
	*/
	function getAltTown2()
	{
		echo   "<table width='100%' cellspacing='0' cellpadding='0' border='0'>
				  <tr>
					<td width='21%' align='left'>
					 <div style='text-align:left;'>Alternate Town</div>
					</td>
					<td width='78%'  align='left'>
					<div style='padding-top: 5px; padding-top: 5px;'>
						<input class='text_box_large' type='text' name='txtAltTown'  id='txtAltTown' onBlur='verifyTown()'>
						<span class='maroonErrorLarge'>*</span>
						<span id='verifyTownName'></span>
					</div>
					</td>
				  </tr>
				 </table> ";
	}
	
	/**
	*	This function will check the whether there is any duplicacy in location. The 
	*	check will be done agaist the parent id and child name.
	*
	*	
	*/
	function duplicateLoc($parent_id, $parent_column, $cat_id, $cat_column, $table, $type)
	{
		
		$select =  "SELECT * FROM ".$table."
					WHERE  ".$parent_column." 	= '$parent_id' 
					AND    ".$cat_column." 		= '$cat_id'
					";
		
		$query  = mysql_query($select);
		$num    = mysql_num_rows($query);
		$msg = '';
		if($num > 0 )
		{
			$msg = "<label class='orangeLetter'>Error: The ".$type." already exist </label>";
		}
		else
		{
			$msg = "<label class='greenLetter'> Success !!! </label>";
		}
		return $msg;
	}//eof
	
	/**
	*	This function will allow user to add alternate town if none found
	*/
	function getAltCounty()
	{
		echo "<div class='h25 pad2 w100P'>
				<div class='w125 fl'>
					<label for='alternate district'>
						<span  class='menuText'>Alternate District</span>
						<span class='orangeLetter'>*</span>
					</label>
				</div>
				<div  class='fl padL20'>
					<input name='txtAltCounty' type='text' class='text_box_large' id='txtAltCounty' 
					size='25' title='alternate city'  style='float:left; ' onChange='verifyCounty()'>
					<span id='verifyCountyName'></span>
				</div>
                <div class='cl'></div>
			 </div>
			 ";
	}//eof
	
	
}
?>