/**
*	This function will display number of subcategory section for adding image
*
*	@author		Nafia Hassan Halder
*	@date		February 25, 2012
*	@version	1.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		corporate@ansysoft.com
* 
*/

//
function getNumDesc()
{
	var selNum = document.getElementById("selNum").value;
	var url= "event_image.php?selNum=" + escape(selNum);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescRes;
	
	//writing response while verifying
	document.getElementById('showDescMsg').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	//<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />
	
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
			
			document.getElementById("showDescMsg").innerHTML = xmlResponse;
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
}
