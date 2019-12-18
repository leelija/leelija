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
function verifyUser()
{
	var txtUsername = document.getElementById("txtUsername").value;
	var url= "checkUser.php?txtUsername=" + escape(txtUsername);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getUsernameRes;
	
	//writing response while verifying
	document.getElementById('userMsg').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	//<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />
	
	//send the request
	request.send(null);
}

function getUsernameRes()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("userMsg").innerHTML = xmlResponse;
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
*	Verify member id
*/
function verifyMemberId()
{
	var txtMemberId = document.getElementById("txtMemberId").value;
	var url= "checkMemberId.php?txtMemberId=" + escape(txtMemberId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getMemberIdRes;
	
	//writing response while verifying
	document.getElementById('memResult').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	//<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />
	
	//send the request
	request.send(null);
}

function getMemberIdRes()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("memResult").innerHTML = xmlResponse;
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

//verify Password length
function passLength()
{
	var txtPassword = document.getElementById("txtPassword").value;
	var url= "customer_pass_check.php?txtPassword=" + escape(txtPassword);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = passLenRes;
	
	document.getElementById('passLen').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function passLenRes()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("passLen").innerHTML = xmlResponse;
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


//verify Password length
function passRegisLength()
{
	var txtRegisPassword = document.getElementById("txtRegisPassword").value;
	var url= "customer_pass_check.php?txtRegisPassword=" + escape(txtRegisPassword);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = passLenRes;
	
	document.getElementById('passLen').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function passLenRes()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("passLen").innerHTML = xmlResponse;
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





//verify Password and confirm password
function passConfirm()
{
	var txtCnfPass = document.getElementById("txtCnfPass").value;
	var txtPassword = document.getElementById("txtPassword").value;
	
	var url= "customer_pass_len.php?txtCnfPass=" + escape(txtCnfPass) + "&txtPassword=" + escape(txtPassword);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = passCnfRes1;
	
	document.getElementById('passCnf').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	
	//send the request
	request.send(null);
}

function passCnfRes1()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("passCnf").innerHTML = xmlResponse;
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



//verify Password and confirm password of registration form
function regisPassConfirm()
{
	var txtRegisConfPass = document.getElementById("txtRegisConfPass").value;
	var txtRegisPassword = document.getElementById("txtRegisPassword").value;
	
	var url= "customer_pass_len.php?txtRegisConfPass=" + escape(txtRegisConfPass) + "&txtRegisPassword=" + escape(txtRegisPassword);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = passCnfRes;
	
	document.getElementById('passCnf').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	
	//send the request
	request.send(null);
}

function passCnfRes()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("passCnf").innerHTML = xmlResponse;
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





/*	Generate customer verification code */

//Generate code
function genVerCodeForCus(cusId)
{ 
	var cusId = cusId;
	
	var chkAcc = document.getElementById("chkAcc").value;
	var url= "customer_verify_code.php?chkAcc=" + escape(chkAcc) + "&amp;cusId=" + escape(cusId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = genVerCodeRes;
	
	document.getElementById('verficationNo').value= "Generating...";
	/*"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";*/
	
	//<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />
	//send the request
	request.send(null);
}

function genVerCodeRes()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			document.getElementById("verficationNo").value = xmlResponse;
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
