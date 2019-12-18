function RegiSubmit()
{
	
// this function used for passed html form value without page refresh 
	var txtEmail = document.getElementById("txtEmail").value;
	//alert(txtEmail);
	var txtPassword	 = document.getElementById("txtPassword").value;
	var txtCnfPass 	  = document.getElementById("txtCnfPass").value;
	var txtFName	    = document.getElementById("txtFName").value;
	var txtLName	    = document.getElementById("txtLName").value;
	var txtOrg 		  = document.getElementById("txtOrg").value;
	var txtAdd1 		 = document.getElementById("txtAdd1").value;
	var txtAdd2 		 = document.getElementById("txtAdd2").value;
	var txtState 		= document.getElementById("txtState").value;
	var countryId 	   = document.getElementById("countryId").value;
	var txtTown 		 = document.getElementById("txtTown").value;
	var txtPostCode 	 = document.getElementById("txtPostCode").value;
	var txtMobile 	   = document.getElementById("txtMobile").value;
	
	var productId 	   = document.getElementById("productId").value;
	var total 	   = document.getElementById("total").value;

	
	//alert(total);
	var url= "payment_type.php?txtEmail=" + escape(txtEmail)+"&txtPassword="+ escape(txtPassword)+"&txtCnfPass="+ escape(txtCnfPass)+"&txtFName="+ escape(txtFName)
	+"&txtLName="+ escape(txtLName)+"&txtOrg="+ escape(txtOrg)+"&txtAdd1="+ escape(txtAdd1)
	+"&txtAdd2="+ escape(txtAdd2)+"&txtState="+ escape(txtState)+"&countryId="+ escape(countryId)
	+"&txtTown="+ escape(txtTown)+"&txtPostCode="+ escape(txtPostCode)+"&txtMobile="+ escape(txtMobile)
	+"&productId="+ escape(productId)+"&total="+ escape(total);
	
	request.open('GET',url,true);
	//alert(url);
	//set up a function to the server when its done
	request.onreadystatechange = getRegistrationSubmit;
	//writing response while verifying
/*	document.getElementById('showDescMsg').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request*/
	request.send(null);
}



function getRegistrationSubmit()
{
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			//document.getElementById('Errormsg').style.display = "block";
			//document.getElementById("Errormsg").innerHTML = xmlResponse;
			//document.getElementById("left-col").innerHTML = xmlResponse;
			var output = xmlResponse.split("~");
			//alert(output[1]);
			if(output[1] != '')
			{
				document.getElementById("CustomerRegiForm").innerHTML = output[0];
				document.getElementById('BuyReport').style.display = "block";
				//document.getElementById("left-col").innerHTML = output[1];
			
			}
			if(output[1] != '')
			{
				document.getElementById("Errormsg").innerHTML = output[0];

			}
			//if(output[0] = '')
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



function calc() {
	 // For calculation two fields
    var textValue1 = document.getElementById('pricecall').value;
    var textValue2 = document.getElementById('noshare').value;

    document.getElementById('totalsprice').value = textValue1 * textValue2;
}