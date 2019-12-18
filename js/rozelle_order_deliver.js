function rozelleOrder(oid)
{
  //alert("1 Hi..");
	var oid	= oid
	var txtColour   = document.getElementById("txtColour").value;
	var txtQuantity = document.getElementById("txtQuantity").value;
	//alert(txtColour);
	var url= "roz_ord_deli.php?oid=" + escape(oid)+ "&txtColour=" + escape(txtColour) + "&txtQuantity=" + escape(txtQuantity);
	//alert(url);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDeliOrder;
	
	//writing response while verifying
/*	document.getElementById('showRozelleDeliver').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	*/
	//send the request
	request.send(null);
}

function getDeliOrder()
{
//	alert("here..");
	if(request.readyState == 4)
	{
		//alert("2 hi");
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			document.getElementById("showRozOrd").innerHTML = xmlResponse;
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

