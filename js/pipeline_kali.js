/*----------------------------------------------------Kali cutting pipeline---------------------------------------------- */

function getKaliCuttingType(designNo)
{
//alert(designNo);
	var selNum = document.getElementById("selNum").value;
	var url= "kali_type_field.php?selNum=" + escape(selNum) + "&designNo=" + escape(designNo);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescAddFieldKali;
	
	//writing response while verifying
	document.getElementById('showKaliCttingType').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescAddFieldKali()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showKaliCttingType").innerHTML = xmlResponse;
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

