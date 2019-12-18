/**
*	This function will add product 
*	according to user into the wish list column 
*
*	@author		Mousumi Dey
*	@date		November 21, 2012
*	@version	1.0
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		mousumi.dey@ansysoft.com
* 
*/

function userWishList(x,userId)
{
	//alert("here");
	//product id 
	var x = x ;
	
	var userId = userId ;
	//alert (x);
	var url= "add-wish-list.php?x=" + escape(x) + "&userId=" + escape(userId);
	//alert(url);
	//var url= "add-wish-list.php";
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showWish;

	//send the request
	request.send(null);
}

function showWish()
{
	if(request.readyState == 4)
	{
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			document.getElementById("wish_result").innerHtml;
			//alert("here");
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

function getNumDesc()
{
	var selNum = document.getElementById("selNum").value;
	var url= "package_product.php?selNum=" + escape(selNum);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescRes;
	
	//writing response while verifying
	document.getElementById('showDescMsg').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
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
}//eof

function getProdList(i)
{
	var txtParentId = document.getElementById("txtParentId-"+i).value;
	//alert(txtParentId);
	var url= "product_list.php?txtParentId=" + escape(txtParentId);
	request.open('GET',url,true);
	//alert(i);
	//set up a function to the server when its done
	request.onreadystatechange = function getProducts(){
		if(request.readyState == 4)
		{
	
			if(request.status == 200)
			{
				var xmlResponse = request.responseText;
	
				document.getElementById("showProductMsg-"+i).innerHTML = xmlResponse;
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

	
	//send the request
	request.send(null);
}

function countDirectoryLike(dirId)
{
	//alert (upId);
	var url= "directory-like.php?dirId=" + escape(dirId);
	
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showLike;

	//send the request
	request.send(null);
}


function showLike()
{
	

	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			
			var xmlResponse = request.responseText;
			
			document.getElementById("like-result").innerHTML = xmlResponse;
			
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



/**
*	Java Script function to work with categories and sub categories and title for creating a SEO friendly URL.
*
*	@author     	Mousumi Dey
*	@date   	 	october 17, 2012
*	@version 		2.0
*	@copyright 		Analyze System
*	@email			mousumi.dey@ansysoft.com
*/



function showCatProd(sVal, eVal, cId, URL)
{
	
	var sVal		= sVal; 
	var eVal		= eVal; 
	var cId			= cId;
	var URL			= URL;
	//alert(cId);
	var url= URL+"cat_view.php?startPrice=" + escape(sVal) + "&endPrice=" + escape(eVal)+ "&catId=" + escape(cId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = showProd;

	//send the request
	request.send(null);
}


function showProd()
{

	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			//document.getElementById("showProd").value = xmlResponse;
			document.getElementById('showProd').innerHTML = xmlResponse;
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

function addToWishlist(userId, prodId, URL)
{
	//alert("here");
	//product id 
	var userId = userId ;
	var prodId = prodId ;
	var URL 	= URL ;

	//alert (x);
	var url= URL+"add-wish-list.php?prodId=" + escape(prodId) + "&userId=" + escape(userId);
	//alert(url);
	//var url= "add-wish-list.php";
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showWish;

	//send the request
	request.send(null);
}

function makeProdSeoUrl()
{
	var txtProdName 	= document.getElementById("txtProdName").value; 
	var txtParentId		= document.getElementById("txtParentId").value;
	
	var url= "product_seo_url.php?txtProdName=" + escape(txtProdName) + "&txtParentId=" + escape(txtParentId);
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showProdSEOURL;

	//send the request
	request.send(null);
}


function showProdSEOURL()
{

	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			document.getElementById("txtSeoUrl").value = xmlResponse;
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

//get product list
function showProduct()
{
	var catId	= document.getElementById("txtParentId").value;
	
	//alert(document.getElementById('cat-'+catId).className);
	var url		= "prod_list.php?catId=" + escape(catId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getProducts;
	
	//send the request
	request.send(null);
}

function getProducts()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("detail").innerHTML = xmlResponse;
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

function genFirmDetail()
{
	var numFirming	= document.getElementById("numFirming").value;
	
	
	//alert(document.getElementById('cat-'+catId).className);
	var url		= "firm_detail.php?numFirming=" + escape(numFirming);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getFirmDetail;
	
	//send the request
	request.send(null);
}

function getFirmDetail()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("firm-detail").innerHTML = xmlResponse;
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

function loadPopupBox(pid) 
{	
// To Load the Popupbox
		var pid	= pid
		
		var url		= "manage_firm.php?pid=" + escape(pid);
		request.open('GET',url,true);
		
		//set up a function to the server when its done
		request.onreadystatechange = getFirm2;
		
		//send the request
		request.send(null);
		var $window 	= $(window);
		var popHeight	= $window.scrollTop();
		popHeight		= popHeight + 150;
		$("#popUp").css("top", popHeight);
		$("#popUp").fadeIn("slow");
		/*$("body > div:not(#popUp)").unbind("click");*/		
	}

function getFirm2()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("manage-firm").innerHTML = xmlResponse;
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

function delProdToCus(pToCusId, pid) 
{	
// To Load the Popupbox
		var pid			= pid
		var pToCusId	= pToCusId
		
		var url		= "del_cusProd.php?pToCusId="+ escape(pToCusId)+"&pid=" + escape(pid);
		request.open('GET',url,true);
		
		//set up a function to the server when its done
		request.onreadystatechange = getFirm2;
		
		//send the request
		request.send(null);
		$("#popUp").fadeIn("slow");
		/*$("body > div:not(#popUp)").unbind("click");*/ 		
	}

function getFirm()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("popUp").innerHTML = xmlResponse;
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

//show product dropdown when select a category

function showProductDropdown(txtCatId)
{
	document.getElementById("prod-dropdown").innerHTML = '';
	var txtCatId = document.getElementById("txtCatId").value;
	
	var url= "show-product.php?txtCatId=" + escape(txtCatId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = productDropdown;
	
	//send the request
	request.send(null);
}

function showProductDropdown2(txtCatId)
{
	document.getElementById("prod-dropdown").innerHTML = '';
	var txtCatId = txtCatId;
	
	var url= "show-product.php?txtCatId=" + escape(txtCatId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = productDropdown;
	
	//send the request
	request.send(null);
}

function productDropdown()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("prod-dropdown").innerHTML = xmlResponse;
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
			//alert("Error: Status Code is " + request.statusText);
		}
	}
}


/** For product pick **/
function takeProduct(prodId,prodName,divId)
{
	
	$("#"+divId).fadeOut("slow");
	
	//alert(prodId);
	var url= "product-pick.php?prodId=" + escape(prodId)+"&prodName=" + escape(prodName);
	
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = productPick;
	
	//send the request
	request.send(null);
	
}
function productPick()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			document.getElementById("pickProdName").innerHTML = xmlResponse;
			var output		= xmlResponse.split("~");
			if(output[1] != '')
			{
				document.getElementById("txtCatId").value = output[1];
			}
			$("#txtCatId").removeProp("disabled");
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

/*----------------------------------product status--------------------------------------------------- */
function getProductStat(Design)
{
//alert(Design);
	var Design			= Design;
	var txtStatus = document.getElementById("txtStatus").value;
	//alert(txtStatus);
	var url= "package_product_status.php?txtStatus=" + escape(txtStatus) + "&Design=" + escape(Design);
	request.open('GET',url,true);  
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescPStat;
	
	//writing response while verifying
	document.getElementById('showResponse').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescPStat()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showResponse").innerHTML = xmlResponse;
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


/*----------------------------------------------------FabricType  (Dyeing)---------------------------------------------- */

function getFabricType(designNo)
{
//alert(designNo);
	var selNum = document.getElementById("selNum").value;
	var url= "type_field.php?selNum=" + escape(selNum) + "&designNo=" + escape(designNo);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescAddField;
	
	//writing response while verifying
	document.getElementById('showFabricType').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescAddField()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showFabricType").innerHTML = xmlResponse;
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


/*----------------------------------------------------Hand Manual---------------------------------------------- */

function getHandManual()
{
alert("Hi..");
	var selNum = document.getElementById("selNum").value;
	var url= "package_hand.php?selNum=" + escape(selNum);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescHandManual;
	
	//writing response while verifying
	document.getElementById('showHandManual').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescHandManual()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showHandManual").innerHTML = xmlResponse;
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



/*========================================================Colour types==========================================*/

function getColourType()
{
//alert("Hi..");
	var selNum = document.getElementById("selNum").value;
	var url= "sample_colour_type.php?selNum=" + escape(selNum);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescAddFieldColour;
	
	//writing response while verifying
	document.getElementById('showColourType').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}

function getDescAddFieldColour()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showColourType").innerHTML = xmlResponse;
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