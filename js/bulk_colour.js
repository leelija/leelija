/*====================================== Rozelle Bulk Order Colour======================================*/

function getRozBulkColour()
{
//alert("Hi..");
	//var sid	= sid
	var selNum1 = document.getElementById("selNum1").value;
	var url= "bulk_colour_field.php?selNum1=" + escape(selNum1);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = geOrderBulkColour;
	
	//writing response while verifying
	document.getElementById('showRozelleBulkColour').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function geOrderBulkColour()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showRozelleBulkColour").innerHTML = xmlResponse;
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