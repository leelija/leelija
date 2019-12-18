function getRozelleOrder(sid)
{
//alert("Hi..");
	var sid	= sid
	var selNum = document.getElementById("selNum").value;
	var url= "rozelle_order_field.php?selNum=" + escape(selNum)+ "&sid=" + escape(sid);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = geOrderRozelle;
	
	//writing response while verifying
	document.getElementById('showRozelleOrder').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function geOrderRozelle()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showRozelleOrder").innerHTML = xmlResponse;
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


function getRozelleDeliver(oid)
{
//alert("Hi..");
	var oid	= oid
	var selNum = document.getElementById("selNum").value;
	var url= "rozelle_deliver_field.php?selNum=" + escape(selNum)+ "&oid=" + escape(oid);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = geDeliverRozelle;
	
	//writing response while verifying
	document.getElementById('showRozelleDeliver').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function geDeliverRozelle()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showRozelleDeliver").innerHTML = xmlResponse;
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





