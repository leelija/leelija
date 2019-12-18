function AddToCart(product_id)
{
	//alert(product_id);
	//var product_id = document.getElementById("product_id").value;
	
	
	
    //var product_qty = document.getElementById("product_qty").value;
	var return_url = document.getElementById("return_url").value;
	
	//alert(return_url);
	
	var url= "cart_update1.php?product_id=" + escape(product_id)+"&return_url="+ escape(return_url);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = AddCart;
	
	//writing response while verifying
/*	document.getElementById('add_to_cart').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";		*/
	
	//send the request
	request.send(null);
}

function AddCart()
{
	//alert("hi..");
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			document.getElementById("shopping-cart").innerHTML = xmlResponse;
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


// cancel to cart

function CrossToCart(removep)
{
	//alert(removep);
	//var product_id = document.getElementById("product_id").value;

	//var categories_id = document.getElementById("categories_id").value;
	
	//alert(categories_id);
	
	var url= "cart_update2.php?removep=" + escape(removep);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = CrossCart;
	
	//writing response while verifying
/*	document.getElementById('add_to_cart').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";		*/
	
	//send the request
	request.send(null);
}

function CrossCart()
{
	//alert("hi..");
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			alert(xmlResponse);
			document.getElementById("shopping-cart").innerHTML = xmlResponse;
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



/*-------------------------------------------update quantity in shopping cart----------------------------------------------  */

function updateCart(product_id)
{
	//alert(product_id);

    var qty = document.getElementById("qty").value;
	//var return_url = document.getElementById("return_url").value;
	
	//alert(qty);
	
	var url= "cart_items_update.php?product_id=" + escape(product_id)+"&qty="+ escape(qty);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = updateCartshop;
	
	//writing response while verifying
/*	document.getElementById('add_to_cart').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";		*/
	
	//send the request
	request.send(null);
}

function updateCartshop()
{
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			document.getElementById("ShoppingCart").innerHTML = xmlResponse;
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





