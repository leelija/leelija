
//get province list
function getProvinceList()
{
	
	var txtCountryId = document.getElementById("txtCountryId").value;
	var url= "province_list.php?txtCountryId=" + escape(txtCountryId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getProvince;

	//send the request
	request.send(null);
}

function getProvince()
{
			
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("displayProvince").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		else
		{
			alert("Error: Status Code is " + request.statusText);
		}
	}
}//eof

//get town list
function getTownList()
{
	var provinceId = document.getElementById("provinceId").value;
	var url= "town_option.php?provinceId=" + escape(provinceId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getTown;
	//send the request
	request.send(null);
}

function getTown()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("displayCity").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		else
		{
			alert("Error: Status Code is " + request.statusText);
		}
	}
}

//get alternate town if required
function getAltTown()
{
	var townId = document.getElementById("townId").value;
	
	var url= "town_alt.php?townId=" + escape(townId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = altTown;
	//send the request
	request.send(null);
}

function altTown()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("altTownName").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		else
		{
			alert("Error: Status Code is " + request.statusText);
		}
	}
}


//get province list
function getListOfProvince()
{
	
	var txtCountryId = document.getElementById("txtCountryId").value;
	var url= "prov-city-addr.php?txtCountryId=" + escape(txtCountryId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getListOfProv;

	//send the request
	request.send(null);
}

function getListOfProv()
{
			
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			
			document.getElementById("fieldsProvinceCityAddr").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		else
		{
			alert("Error: Status Code is " + request.statusText);
		}
	}
}//eof


//get town list
function getListOfTown()
{
	var provinceId = document.getElementById("provinceId").value;
	var url= "town-addr.php?provinceId=" + escape(provinceId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getListTown;
	//send the request
	request.send(null);
}

function getListTown()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("fieldsCityAddr").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		else
		{
			alert("Error: Status Code is " + request.statusText);
		}
	}
}

//get town list
function genHiddenAddr()
{
	var townId = document.getElementById("townId").value;
	var url= "hidden-addr.php?townId=" + escape(townId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getAddr;
	//send the request
	request.send(null);
}

function getAddr()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("hiddenAddr").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		else
		{
			alert("Error: Status Code is " + request.statusText);
		}
	}
}


/**
*	Get list of province by country id, using for search purpose in the admin control panel
*
*
*/
//get province list
function getListOfProvinceByCountry()
{
	
	var txtCountryId = document.getElementById("txtCountryId").value;
	var url= "prov-city-addr.php?txtCountryId=" + escape(txtCountryId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getListOfProvByCountry;

	//send the request
	request.send(null);
}

function getListOfProvByCountry()
{
			
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			
			document.getElementById("provinceId").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		else
		{
			alert("Error: Status Code is " + request.status);
		}
	}
}//eof


/**
*	Get town by province
*/
//get town list
function getListOfTown()
{
	var provinceId = document.getElementById("provinceId").value;
	var url= "town-addr.php?provinceId=" + escape(provinceId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getListTown;
	//send the request
	request.send(null);
}

function getListTown()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			document.getElementById("townId").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		else
		{
			alert("Error: Status Code is " + request.statusText);
		}
	}
}
