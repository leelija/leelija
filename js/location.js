// JavaScript Document

function getProvinceList()
{

	var txtCountriesId = document.getElementById("txtCountriesId").value;

	//alert(escape(txtProvinceId))
	var url= "province_list.php?txtCountriesId=" + escape(txtCountriesId);
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
			var xmlResponse = request.responseText;
			
			document.getElementById("provinceId").innerHTML = xmlResponse;
			document.getElementById("countyId").innerHTML 	= '';
			document.getElementById("townId").innerHTML 	= '';
			document.getElementById("txtProvinceId").value	= 0;
			document.getElementById("txtCountyId").value	= 0;
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



function getProvinceListCounty()
{

	var txtCountriesId = document.getElementById("txtCountriesId").value;

	//alert(escape(txtProvinceId))
	var url= "province_list.php?txtCountriesId=" + escape(txtCountriesId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getProvinceCounty;
	
	//send the request
	request.send(null);
}

function getProvinceList3(txtCountriesId)
{
	var txtCountriesId = txtCountriesId;
	//alert(escape(txtProvinceId))
	var url= "province_list2.php?txtCountriesId=" + escape(txtCountriesId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getProvince3;
	
	//send the request
	request.send(null);
}

function getProvince3()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("dropdownList-2").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		/*else
		{
			alert("Error: Status Code is " + request.statusText);
		}*/
	}
}//eof


function getProvinceCounty()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			/*if(xmlResponse == "<label>Town/Village</label><select name='txtTownId' id='txtTownId' class='text-field' onChange='getAltTown()'><option value='0'>-- Select One --</option><option value='20'>Dhaka</option>	<option value='0'>-- Add Town --</option></select><div class='cl'></div>")
			{
				xmlResponse = '';
			}*/

			
			document.getElementById("provinceId").innerHTML = xmlResponse;
			document.getElementById("countyId").innerHTML 	= '';
			document.getElementById("townId").innerHTML 	= '';
			document.getElementById("txtProvinceId").value	= 0;
			document.getElementById("txtCountyId").value	= 0;
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


function getProvinceList2()
{

	var txtCountriesId = document.getElementById("txtCountriesId").value;
	//alert(txtCountriesId);

	//alert(escape(txtProvinceId))
	var url= "province_list.php?txtCountriesId=" + escape(txtCountriesId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getProvince2;
	
	//send the request
	request.send(null);
}


function getProvince2()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			document.getElementById("provinceId").innerHTML = xmlResponse;
			document.getElementById("countyId").innerHTML 	= '';
			document.getElementById("townId").innerHTML 	= '';
			document.getElementById("txtProvinceId").value	= 0;
			document.getElementById("txtCountyId").value	= 0;
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


//get county list
function getCountyList()
{
	var txtCountriesId = document.getElementById("txtCountriesId").value;
	var txtProvinceId = document.getElementById("txtProvinceId").value;
	
	//alert(escape(txtProvinceId))
	var url= "county_list.php?txtProvinceId=" + escape(txtProvinceId)+"&txtCountriesId=" + escape(txtCountriesId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getCounties;
	
	//send the request
	request.send(null);
}

//get county list
function getCountyListByProvince()
{
	var txtCountriesId = document.getElementById("txtCountriesId").value;
	var txtProvinceId = document.getElementById("txtProvinceId").value;
	
	//alert(escape(txtProvinceId))
	var url= "county_list.php?txtProvinceId=" + escape(txtProvinceId)+"&txtCountriesId=" + escape(txtCountriesId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getCounties3;
	
	//send the request
	request.send(null);
}

function getCountyList2(txtProvinceId)
{
	var txtProvinceId = txtProvinceId;
	//alert(escape(txtProvinceId))
	var url= "county_list2.php?txtProvinceId=" + escape(txtProvinceId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getCounties2;
	
	//send the request
	request.send(null);
}

function getCounties()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("countyId").innerHTML = xmlResponse;
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

function getCounties2()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("dropdownList-2").innerHTML = xmlResponse;
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		/*else
		{
			alert("Error: Status Code is " + request.statusText);
		}*/
	}
}//eof

function getCounties3()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("countyId").innerHTML = xmlResponse;
			document.getElementById("townId").innerHTML 	= '';
		}
		else if(request.status == 404)
		{
			alert("Request page doesn't exist");
		}
		else if(request.status == 403)
		{
			alert("Request page doesn't exist");
		}
		/*else
		{
			alert("Error: Status Code is " + request.statusText);
		}*/
	}
}//eof

//get town list
function getTownList()
{
	//var txtProvinceId = document.getElementById("txtProvinceId").value;
	var txtCountyId = document.getElementById("txtCountyId").value;
	//alert(txtCountyId);
	var url= "town_option.php?txtCountyId=" + escape(txtCountyId);
	request.open('GET',url,true);
	//set up a function to the server when its done alert("I am");
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
//get alternate town if required
function getAltTown()
{
	var txtTownId = document.getElementById("txtTownId").value;
	
	var url= "town_alt.php?txtTownId=" + escape(txtTownId);
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
			var xmlResponse = request.responseText;
			
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

//check alternate town if already exist under the parent county
function verifyTown()
{
	var txtAltTown 		= document.getElementById("txtAltTown").value;
	var txtProvinceId   = document.getElementById("txtProvinceId").value;
	
	var url= "town_check.php?txtAltTown=" + escape(txtAltTown) + "&txtProvinceId=" + escape(txtProvinceId);
	
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = townVerified;
	
	//send the request
	request.send(null);
}

function townVerified()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("verifyTownName").innerHTML = xmlResponse;
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
function getTownListSearch()
{
	var txtProvinceId = document.getElementById("txtProvinceId").value;
	var url= "town_option_search.php?txtProvinceId=" + escape(txtProvinceId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done alert("I am");
	request.onreadystatechange = getTownSearch;
	
	//send the request
	request.send(null);
}

function getTownSearch()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("txtTownId").innerHTML = xmlResponse;
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