function getRmatOut()
{
	var txtPurpose 		= document.getElementById("txtPurpose").value;
	//alert(txtPurpose);
	var url= "raw-mat-out.inc.php?txtPurpose=" + escape(txtPurpose);
	request.open('GET',url,true);  
	
	//set up a function to the server when its done
	request.onreadystatechange = getRMatStat;
	
	//writing response while verifying
	document.getElementById('showRmaterialOut').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getRMatStat()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showRmaterialOut").innerHTML = xmlResponse;
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
