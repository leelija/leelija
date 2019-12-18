// JavaScript Document

//check the company name is not empty
function verifyCompany(txtField, txtLabel)
{
	var txtField 	= document.getElementById(txtField).value;
	var txtLabel 	= txtLabel;
	
	var url= "checkEmpty.php?txtField=" + escape(txtField) + '&txtLabel=' + escape(txtLabel);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getEmpty;
	
	document.getElementById('companyVerification').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getEmpty()
{
	
	//alert("ready state= " + request.readyState);
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById('companyVerification').innerHTML = xmlResponse;
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

//check the address 1 is not empty
function verifyAddress(txtField, txtLabel)
{
	var txtField 	= document.getElementById(txtField).value;
	var txtLabel 	= txtLabel;
	var url= "checkEmpty.php?txtField=" + escape(txtField) + '&txtLabel=' + escape(txtLabel);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getAdd1;
	
	document.getElementById('add1Verification').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getAdd1()
{
	
	//alert("ready state= " + request.readyState);
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			document.getElementById('add1Verification').innerHTML = xmlResponse;
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
//////////////////////////////////////////////////////////////////////////////////////////////
//check the postal code
function verifyPIN()
{
	var txtPostCode 	= document.getElementById('txtPostCode').value;
	
	var url= "checkPIN.php?txtPostCode=" + escape(txtPostCode);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getPIN;
	
	document.getElementById('pinVerification').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getPIN()
{
	
	//alert("ready state= " + request.readyState);
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById('pinVerification').innerHTML = xmlResponse;
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
*	Verify pin for australia 
*/
//check the postal code
function verifyPIN2()
{
	var countryId		= document.getElementById('countryId').value;
	var txtPostCode 	= document.getElementById('txtPostCode').value;
	
	var url= "checkPIN2.php?txtPostCode=" + escape(txtPostCode) + "&countryId=" + escape(countryId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getPIN2;
	
	document.getElementById('pinVerification').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getPIN2()
{
	
	//alert("ready state= " + request.readyState);
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById('pinVerification').innerHTML = xmlResponse;
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
//////////////////////////////////////////////////////////////////////////////////////
//check the person or contact name is not empty
function verifyPerson(txtField, txtLabel)
{
	var txtField 	= document.getElementById(txtField).value;
	var txtLabel 	= txtLabel;
	
	var url= "checkEmpty.php?txtField=" + escape(txtField) + '&txtLabel=' + escape(txtLabel);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getPerson;
	
	document.getElementById('personVerification').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getPerson()
{
	
	//alert("ready state= " + request.readyState);
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById('personVerification').innerHTML = xmlResponse;
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
*	Verify First Name 
*/
function verifyFName(txtField, txtLabel)
{
	var txtField 	= document.getElementById(txtField).value;
	var txtLabel 	= txtLabel;
	
	var url= "checkEmpty.php?txtField=" + escape(txtField) + '&txtLabel=' + escape(txtLabel);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getFName;
	
	document.getElementById('fnResult').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getFName()
{
	
	//alert("ready state= " + request.readyState);
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById('fnResult').innerHTML = xmlResponse;
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
*	Verify Last Name 
*/
function verifyLName(txtField, txtLabel)
{
	var txtField 	= document.getElementById(txtField).value;
	var txtLabel 	= txtLabel;
	
	var url= "checkEmpty.php?txtField=" + escape(txtField) + '&txtLabel=' + escape(txtLabel);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getLName;
	
	document.getElementById('lnResult').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getLName()
{
	
	//alert("ready state= " + request.readyState);
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById('lnResult').innerHTML = xmlResponse;
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
*	Job Title
*/
function verifyTitle(txtField, txtLabel)
{
	var txtField 	= document.getElementById(txtField).value;
	var txtLabel 	= txtLabel;
	
	var url= "checkEmpty.php?txtField=" + escape(txtField) + '&txtLabel=' + escape(txtLabel);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getJobTItle;
	
	document.getElementById('checkTitle').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getJobTItle()
{
	
	//alert("ready state= " + request.readyState);
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById('checkTitle').innerHTML = xmlResponse;
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

