function attendance()
{
//alert("Hi..");
	//var sid	= sid
	var txtAdhar = document.getElementById("txtAdhar").value;
	//alert(txtAdhar);
	var url= "attendance.inc.php?txtAdhar=" + escape(txtAdhar);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getAttendance;
	
	//writing response while verifying
	document.getElementById('aMesg').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Processing ... </span></span>";
	
	//send the request
	request.send(null);
}

function getAttendance()
{
	//alert("Hi....");
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			document.getElementById("txtAdhar").value 	= '';
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			document.getElementById("aMesg").innerHTML = xmlResponse;
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


