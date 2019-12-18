function getCompRoundType()
{
	//alert('hi..');
	var selNum = document.getElementById("selNum").value;
	var url= "dstitch-details.php?selNum=" + escape(selNum);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getDescRes;
	
	//writing response while verifying
	document.getElementById('showCompRoundType').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescRes()
{
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showCompRoundType").innerHTML = xmlResponse;
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