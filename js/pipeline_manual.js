/*----------------------------------------------------Manual pipeline---------------------------------------------- */

function getManualType(designNo)
{
//alert(designNo);
	var selNum = document.getElementById("selNum").value;
	var url= "type_manual_field.php?selNum=" + escape(selNum) + "&designNo=" + escape(designNo);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescAddFieldManual;
	
	//writing response while verifying
	document.getElementById('showManulType').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescAddFieldManual()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showManulType").innerHTML = xmlResponse;
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


/*----------------------------------------------------Computer pipeline---------------------------------------------- */

function getComputerType(designNo)
{
//alert(designNo);
	var selNum = document.getElementById("selNum").value;
	var url= "type_computer_field.php?selNum=" + escape(selNum) + "&designNo=" + escape(designNo);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescAddFieldComputer;
	
	//writing response while verifying
	document.getElementById('showComputerType').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescAddFieldComputer()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showComputerType").innerHTML = xmlResponse;
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


/*----------------------------------------------------Final Stiching pipeline---------------------------------------------- */

function getFinalStichingType(designNo)
{
//alert(designNo);
	var selNum = document.getElementById("selNum").value;
	var url= "type_finalsthich_field.php?selNum=" + escape(selNum) + "&designNo=" + escape(designNo);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescAddFieldFinalStich;
	
	//writing response while verifying
	document.getElementById('showFinalStichingType').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescAddFieldFinalStich()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showFinalStichingType").innerHTML = xmlResponse;
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


