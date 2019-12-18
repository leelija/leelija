function getAddColour()
{
//alert("Hi..");
	//var sid	= sid
	var selNum = document.getElementById("selNum").value;
	var url= "add-color.inc.php?selNum=" + escape(selNum);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getColour;
	
	//writing response while verifying
	document.getElementById('showAddColour').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getColour()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showAddColour").innerHTML = xmlResponse;
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