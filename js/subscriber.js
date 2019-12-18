/**

*	This function will verify the user

*

*	@author		Himadri Shekhar Roy

*	@date		February 09, 2008

*	@version	1.0

*	@copyright	Analyze System

*	@url		http://www.ansysoft.com

*	@email		himadri.s.roy@ansysoft.com

* 

*/



//verify user

/**

*	Make a call to the server

*/

function subscribe()

{

	//Get the field values from the web form 

	var email = document.getElementById("subscriberEmail").value;

	
	
	//build url to connect to the server
	var url= "newsletter_subscriber_res.php?email=" + escape(email);

	//open a conenction to the server
	request.open('GET',url,true);

	

	//set up a function to the server when its done

	request.onreadystatechange = updateSubscribe;



	document.getElementById('subsRes').innerHTML = "";

	"<div class='orangeLetter' style='height:20px; padding-top:10px'>" +

	"<img src='images/icon/loading-arrow.gif' border='0' alt='image loading' />" + 

	"<span style='padding-bottom:5px;'> Loading ... </span></div>";

	

	//send the request

	request.send(null);

	

}//end of calling server */



/**

*	update the page with server response

*/

function updateSubscribe()

{

	if(request.readyState == 4)

	{

		if(request.status == 200)

		{

			var xmlResponse = request.responseText;

			document.getElementById("subsRes").innerHTML = xmlResponse;



		}

		else if(request.status == 404)

		{

			alert("Request page doesn't exist : 404");

		}

		else if(request.status == 403)

		{

			alert("Request page doesn't exist : 403");

		}

		else

		{

			alert("Error: Status Code is " + request.statusText);

		}

	}

}//end of updating page 