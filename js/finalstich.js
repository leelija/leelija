function getFinalStichUp(final_stich_id)
{
//alert(final_stich_id);
	var selNum = document.getElementById("selNum").value;
	var url= "finalstich_field.php?selNum=" + escape(selNum) + "&final_stich_id=" + escape(final_stich_id);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescFinalField;
	
	//writing response while verifying
	document.getElementById('showFinalStichUp').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescFinalField()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showFinalStichUp").innerHTML = xmlResponse;
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
