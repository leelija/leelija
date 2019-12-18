function loginForm()
{
	
// this function used for passed html form value without page refresh 
	var product_id = document.getElementById("product_id").value;
	var productId = [];

        productId.push(product_id);
	var total = document.getElementById("total").value;
	//alert(productId);
	var txtEmail = document.getElementById("txtEmail").value;


	
	var url= "customer_register.php?txtEmail=" + escape(txtEmail)+"&productId="+escape(productId)
	+"&total="+escape(total);
	
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getTextEmail;
	
	//writing response while verifying
/*	document.getElementById('showDescMsg').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request*/
	request.send(null);
}



function getTextEmail()
{
	//alert("HERE");
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			var output = xmlResponse.split("~");
			if(output[1] == '')
			{
				document.getElementById("msg").innerHTML = output[0];
				//document.getElementById("form-login").innerHTML = output[1];
			
			}
			else{
				document.getElementById("msg").innerHTML = output[0];
				document.getElementById("form-login").innerHTML = output[1];
			
				
			}
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
