function getOrderColour()
{
//alert("Hi..");
	//var sid	= sid
	var selNum = document.getElementById("selNum").value;
	var url= "sample_colour_order.php?selNum=" + escape(selNum);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = geOrderColour;
	
	//writing response while verifying
	document.getElementById('showOrderColour').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function geOrderColour()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showOrderColour").innerHTML = xmlResponse;
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



/*---------------------------------------------------- Sample Final Stich ----------------------------------------------------- */

function getSampleFinalStich()
{
//alert("Hi..");
	var selNum = document.getElementById("selNum").value;
	var url= "sample_finalst_field.php?selNum=" + escape(selNum);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescAddFieldFin;
	
	//writing response while verifying
	document.getElementById('showSampleFinalStich').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescAddFieldFin()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showSampleFinalStich").innerHTML = xmlResponse;
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
