function productReport()
{

	var txtDesignNo 	= document.getElementById("txtDesignNo").value;
	var txtFromDate 	= document.getElementById("txtFromDate").value;
	var txtToDate	 	= document.getElementById("txtToDate").value;
	//alert(txtFromDate);
	var url= "product_report.inc.php?txtDesignNo=" + escape(txtDesignNo) + "&txtFromDate=" + escape(txtFromDate)+ "&txtToDate=" + escape(txtToDate);
	request.open('GET',url,true);  
	
	//set up a function to the server when its done
	request.onreadystatechange = getProductReport;
	
	//writing response while verifying
/*	document.getElementById('showProductReport').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
*/	
	//send the request
	request.send(null);
}

function getProductReport()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			document.getElementById("showProductReport").innerHTML = xmlResponse;
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
