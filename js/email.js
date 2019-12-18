/**
*	This function will verify the email address
*
*	@author		Himadri Shekhar Roy
*	@date		February 09, 2008
*	@version	1.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/

//verify job email
function verifyJobEmail()
{
	var txtEmail = document.getElementById("txtJobEmail").value;
	
	var url= "checkEmail.php?txtEmail=" + escape(txtEmail);
	
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getJobEmailRes;
	
	document.getElementById('jobEmailRes').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getJobEmailRes()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("jobEmailRes").innerHTML = xmlResponse;
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

//verify job email
function verifyInvEmail()
{
	var txtEmail = document.getElementById("txtInvEmail").value;
	var url= "checkEmail.php?txtEmail=" + escape(txtEmail);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getInvEmailRes;
	
	document.getElementById('invEmailRes').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getInvEmailRes()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("invEmailRes").innerHTML = xmlResponse;
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

/*	Verify customer Email */
//verify  email
//verify  email

function verifyCus()

{
	

	var txtEmail = document.getElementById("txtEmail").value;
	

	var url= "customer_verify.php?txtEmail=" + escape(txtEmail);
	
	request.open('GET',url,true);

	//set up a function to the server when its done

	request.onreadystatechange = cusVerifyRes;

	

	document.getElementById('cusVerify').innerHTML=

	"<span class='orangeLetter padT10'>" +

	"" + 

	"<span class='padB5'> Loading ... </span></span>";

	

	//<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />

	//send the request

	request.send(null);

}



function cusVerifyRes()

{

	

	if(request.readyState == 4)

	{

		

		if(request.status == 200)

		{

			var xmlResponse = request.responseText;//.split("|")

			document.getElementById("cusVerify").innerHTML = xmlResponse;

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





/*	Verify customer Email for admin */
//verify  email
function verifyCusForAdmin()
{ 
	var txtEmail = document.getElementById("txtEmail").value;
	var url= "customer_verify.php?txtEmail=" + escape(txtEmail);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = cusVerifyRes;
	
	document.getElementById('cusVerify').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />
	//send the request
	request.send(null);
}

function cusVerifyRes()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			document.getElementById("cusVerify").innerHTML = xmlResponse;
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






/*	Verify customer Email on Edit */
//verify  email
function verifyCusEdit(cusId)
{
	var txtEmail = document.getElementById("txtEmail").value;
	var cusId	 = cusId;
	var url= "customer_verify_edit.php?txtEmail=" + escape(txtEmail)+"&cusId="+escape(cusId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = cusVerifyResEdit;
	
	document.getElementById('cusVerify').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />
	//send the request
	request.send(null);
}

function cusVerifyResEdit()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			document.getElementById("cusVerify").innerHTML = xmlResponse;
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


/**
*	Display emial onselct customer id
*/
function getEmailByCusId()
{
	var selCusId = document.getElementById("selCusId").value;
	
	var url= "gen_email.php?selCusId=" + escape(selCusId);
	
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = showEmailDtl;
	
	document.getElementById('txtEmail').value = "Loading ...";
	
	/*"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";*/
	
	//send the request<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />
	request.send(null);
}
function showEmailDtl()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("txtEmail").value = xmlResponse;
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
