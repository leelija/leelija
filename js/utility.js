/**
*	Utility functions will include in this library.
*
*	@author     	Himadri Shekhar Roy
*	@date   	 	March 06, 2008
*	@version 		2.0
*	@copyright 		Analyze System
*	@email			himadri.s.roy@ansysoft.com
*/


//to open browser
function MM_openBrWindow(theURL,winName,features) 
{ 
  window.open(theURL,winName,features);
}//eof

/**
*	This function will write message on the page on clicked on an input field
*	
*	@param
*			id			Div, table or span id
*			mesg		Message to display
*			tMsg		Type of the messsage
*			pathImg		Path to the image
*			alrtImg		Alert Image
*			normImg		Normal Image
*			errImg		Error message image to display
*			sucImg		Success message image to display
*			
*/
function writeMessage(id, mesg, tMsg, pathImg, errImg, sucImage, alrtImg, normImg)
{
	//declare variables
	var	id		=	id;
	var mesg	=	mesg;
	
	
	if(tMsg == 'NORMAL')
	{
		document.getElementById(id).innerHTML = "<img src='"+pathImg+normImg+"' height='15' width='15'  alt='' class='padR10' /><label class='marB5 blackLarge'>" + mesg + "</label>";
	}
	else if(tMsg == 'SUCCESS')
	{
		document.getElementById(id).innerHTML = "<img src='"+pathImg+sucImage+"' height='15' width='15'  alt='' class='padR10' /><label class='marB5 blackLarge'>" + mesg + "</label>";
	}
	else if(tMsg == 'ERROR')
	{
		document.getElementById(id).innerHTML = "<img src='"+pathImg+errImg+"' height='15' width='15'  alt='' class='padR10' /><label class='marB5 blackLarge'>" + mesg + "</label>";
	}
	else if(tMsg == 'ALERT')
	{
		document.getElementById(id).innerHTML = "<img src='"+pathImg+alrtImg+"' height='15' width='15'  alt='' class='padR10' /><label class='marB5 blackLarge'>" + mesg + "</label>";
	}
	
}//eof





/**
*	This function will write message on the page on mouse out from an input field
*/
function writeMesgOff(id)
{
	document.getElementById(id).innerHTML = '';
}

/**
*	Download CV
*/
function downloadCV(id)
{
	var downloadId = id;
	var url= "job_res_save.php?downloadId=" + escape(id);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getCV;
	
	document.getElementById('downloadRes').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request
	request.send(null);
}
function getCV()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;//.split("|")
			//var obj = document.getElementById('txtCountyId');
			document.getElementById("downloadRes").innerHTML = xmlResponse;
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

//eof

/**
*	Show hide div
*/

function closeDiv(divId)
{
	$("#"+divId).fadeOut("slow");
	
}

function closeProdDiv(divId)
{
	$("#"+divId).fadeOut("slow");
	$("#txtCatId").removeProp("disabled");
}

function showHideDiv(divId, txtId) 
{
	var divId	= divId;
	var txtId	= txtId;
	
	if (document.getElementById(divId).style.display == 'none') 
	{
		document.getElementById(divId).style.display = 'block';
		document.getElementById(txtId).innerHTML = 'Close';
	}
	else 
	{
		document.getElementById(divId).style.display = 'none';
		document.getElementById(txtId).innerHTML = 'Choose Language';
	}
}

function showAdditionalDesc(divId) 
{
	var divId	= divId;
	clsName		= document.getElementById(divId).className;
	if (clsName == 'hideDesc') 
	{
		document.getElementById(divId).className = 'showDesc';
	}
	else 
	{
		document.getElementById(divId).className = 'hideDesc';
	}
}


function displayMedia()
{
	
	var noOfMedia 		= document.getElementById("noOfMedia").value;

	var url			= "media.php?noOfMedia=" + escape(noOfMedia);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getMedia;
	
	document.getElementById('dispMedia').innerHTML="";
	
	//send the request
	request.send(null);
}
function getMedia()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("dispMedia").innerHTML = xmlResponse;
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

function delImage()
{
	
	
	var imgId 		= document.getElementById('imgId').value;
	var url			= "del_img.php?imgId=" + escape(imgId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getImg;
	
	//send the request
	request.send(null);
}
function getImg()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("show-img2").innerHTML = xmlResponse;
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
	location.reload(); 
}

/**
*	This function will show a layer on click and hide the same layer if the user click again.
*/
function showHideLayers(fieldId, hideCls, showCls, catArr) {
	fieldId 	= fieldId;
	clsName 	= document.getElementById(fieldId).className;
	
	//get the immediate parent id
	parentId	= document.getElementById(fieldId).parentNode.id;
	
	//get the parent ul
	parentULId	= document.getElementById(parentId).parentNode.id; 
	
	var temp 	= new Array();
    temp 		= catArr.split('~');
	
	for(i=0;i<temp.length;i++)
	{
		clsName1	= document.getElementById('cat-'+temp[i]).className
		//alert('clsName1='+clsName1);
		if(clsName1 == showCls )
		{
			document.getElementById('cat-'+temp[i]).className = hideCls;
			
			parentNId	= document.getElementById('cat-'+temp[i]).parentNode.id;
			parentNULId	= document.getElementById(parentNId).parentNode.id;
			document.getElementById(parentNULId).className = 'item-category';
			
			/*layerProp	= document.getElementById(parentULId).className;
			alert(layerProp + "/n/n/n/n " + parentULId);
			
			if(document.getElementById(parentULId).className == "item-category")
			{
				document.getElementById(parentULId).className = 'item-category-close';
			}*/
		
		}
	}
	
	
	if(clsName == hideCls)
	{
		document.getElementById(fieldId).className = showCls;
		document.getElementById(parentULId).className = "item-category-open";
	}
	else
	{
		document.getElementById(fieldId).className = hideCls;
		
	}

}


/**
*	Show hide div
*	
*	@param
*			divId		Id of the div to show the content
*			clickId		The text or icon to click 
*			sIcon
*			hIcon
*			
*/

function showHideDivWithIcon(divId, clickId, sIcon, hIcon) 
{
	var divId	= divId;
	var txtId	= txtId;
	
	if (document.getElementById(divId).style.display == 'none') 
	{
		document.getElementById(divId).style.display = 'block';
		document.getElementById(clickId).innerHTML = "<img src='../images/admin/icon/hide_icon.png' width='20' height='20' alt='HIDE' />";
		
	}
	else 
	{
		document.getElementById(divId).style.display = 'none';
		document.getElementById(clickId).innerHTML = "<img src='../images/admin/icon/show_icon.png' width='20' height='20' alt='SHOW' />";
	}
}



/**
*	Show the first div and hide the second one 
*/

function showHideTwoDiv(fDivId, sDivId) 
{
	
	
	if (document.getElementById(fDivId).style.display == 'none') 
	{
		document.getElementById(fDivId).style.display = 'block';
		document.getElementById(sDivId).style.display = 'none';
	}
}

/**
*	Make value checked
*/
function makeRadioValueChecked(divId)
{
	document.getElementById(divId).checked = 'checked';
}


/**
*	This function will enable another form field, once clicked on this field
*	
*	@param
*			fieldW		Field to be worked on 
*	
*	@return	boolean
*/
function enableField(fieldW)
{
	var	fieldW = fieldW;
	if(document.getElementById(fieldW).disabled == true)
	{
		document.getElementById(fieldW).disabled = false;
		document.getElementById(fieldW).style.backgroundColor  = "#EEF4FB";
	}
}//eof

/**
*	This function will enable another form field, once clicked different field like checkbox, radio button etc.
*	
*	@param
*			fieldW		Field to be worked on 
*	
*	@return	boolean
*/
function enableFieldByClick(fieldC, fieldE, enCls)
{
	var	fieldW 	= fieldW;
	var	fieldE 	= fieldE;
	var	enCls 	= enCls;
	
	if(document.getElementById(fieldE).disabled == true)
	{
		document.getElementById(fieldE).disabled = false;
		document.getElementById(fieldE).className	= enCls;
	}
}//eof


/**
*	This function will disable another form field, once clicked different field like checkbox, radio button etc.
*	
*	@param
*			fieldW		Field to be worked on 
*	
*	@return	boolean
*/
function disableFieldByClick(fieldC, fieldE, disCls)
{
	var	fieldW 	= fieldW;
	var	fieldE 	= fieldE;
	var	enCls 	= enCls;
	
	if(document.getElementById(fieldE).disabled == false)
	{
		document.getElementById(fieldE).disabled = true;
		document.getElementById(fieldE).className	= disCls;
	}
}//eof



/**
*	This function will disable another form field, once clicked on this field
*	
*	@param
*			fieldW		Field to be worked on 
*	
*	@return	boolean
*/
function disableField(fieldW)
{
	var	fieldW = fieldW;
	
	if(document.getElementById(fieldW).disabled == false)
	{
		document.getElementById(fieldW).disabled = true;
		document.getElementById(fieldW).style.backgroundColor  = "#E4E4E4";
	}
	
}//eof

/**
*	This function will show div
*	
*	@param
*			divId		Div to be worked on 
*	
*	@return	boolean
*/
function showDiv(divId)
{
	var	divId = divId;
	if(document.getElementById(divId).style.display == 'none')
	{
		document.getElementById(divId).style.display = 'block';
	}
}//eof

/**
*	This function will hide div
*	
*	@param
*			divId		Div to be worked on 
*	
*	@return	boolean
*/
function hideDiv(divId)
{
	var	divId = divId;
	if(document.getElementById(divId).style.display == 'block')
	{
		document.getElementById(divId).style.display = 'none';
	}
}//eof


/**
*	This function will allow text area to take maximum length allowed by admin. Below is the
*	example of how to use this function. Source: Dynamic drive.
*
*	e.g.	<textarea maxlength="40" onkeyup="return isMaxLength(this)"></textarea>
*	
*	@param
*			obj		Object fixed for max length
*	
*	@return	null
*/
function isMaxLength(obj)
{
	var mlength	=	obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : "" ;
	
	if (obj.getAttribute && obj.value.length>mlength)
	{
		obj.value=	obj.value.substring(0,mlength) ;
	}
}//eof


/**
*	Download CV
*/
function regSess(pageName)
{
	var pageName = pageName;
	var url= "reg_sess.php?regSessVar=" + escape(pageName);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getRegSess;
	
	document.getElementById('showSess').innerHTML="";
	
	//send the request
	request.send(null);
}
function getRegSess()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showSess").innerHTML = xmlResponse;
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
*	Get background color for the currently selected box in ajax driven image gallery.
*
*	@param
*			pId			Place id
*			newColor	New color to display
*			oldColor	Return to old color
*
*	@return null
*/
function getBackColor(pId, newColor, oldColor)
{
	var pId			= pId;
	var newColor	= newColor;
	var divId		= "breadCrumb_" + pId;
	
	for(i=1; i<=5; i++)
	{
		var divId		= "breadCrumb_" + i;
		document.getElementById(divId).style.backgroundColor	= oldColor;
		
		if(pId == i)
		{
			document.getElementById(divId).style.backgroundColor	= newColor;
		}
	}
	
}//eof


/**
*	Allow user to type only numerical values in the text field
*
*	@param
*			evt		Name of the event
*
*	@return boolean
*/

function intOnly(myfield, e, dec)
{
	var key;
	var keychar;
	 
	if (window.event)
	   key = window.event.keyCode;
	else if (e)
	   key = e.which;
	else
	   return true;
	keychar = String.fromCharCode(key);
	 
	// control keys
	if ((key==null) || (key==0) || (key==8) || 
		(key==9) || (key==13) || (key==27) )
	   return true;
	 
	// numbers
	else if ((("0123456789").indexOf(keychar) > -1))
	   return true;
	else if (((".").indexOf(keychar) > -1)){
	   if (myfield.value.indexOf(".") >-1){
		   return false;
	   }else 
	   return true;
	   }
	 
	else
	   return false;
}


/* Clear the default text on click or on focus*/
function setFieldValue(fieldName, checkValue, setValue)
{
	//declare var
	var fieldName	= fieldName;
	
	if( document.getElementById(fieldName).value == checkValue)
	{
		document.getElementById(fieldName).value 		= setValue;
	}
	
}

/* Clear the default text on click or on focus*/
function setFieldValue2(checkValue, setValue)
{
	//declare var
	var fieldName	= fieldName;
		
	if( document.formContact.txtContMesg.innerHTML == checkValue)
	{
		document.formContact.txtContMesg.innerHTML = setValue;
	}
	
}


function addComment(currImgId)
{
	var	imgId		= currImgId;
	var txtComment	= document.getElementById('txtComment').value;
	document.getElementById('txtComment').value = '';
	var url			= "show-comment.php?imgId=" + escape(imgId)+"&txtComment="+ escape(txtComment);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getComment;
	
	//document.getElementById('showSess').innerHTML="";
	
	//send the request
	request.send(null);
	
}
/* Show comment in photo gallery section*/

function showComment(imgId)
{
	var url= "show-comment.php?imgId=" + escape(imgId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getComment;
	
	//document.getElementById('showSess').innerHTML="";
	
	//send the request
	request.send(null);
}

function deleteComment(imgId, commentId)
{
	var url= "show-comment.php?imgId=" + escape(imgId)+"&commentId="+escape(commentId);
	request.open('GET',url,true);
	//set up a function to the server when its done
	request.onreadystatechange = getComment;
	
	//document.getElementById('showSess').innerHTML="";
	
	//send the request
	request.send(null);
}

function getComment()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("show-comment").innerHTML = xmlResponse;
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



<!--

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->




function makeProdSeoUrl()
{
	var txtProdName 	= document.getElementById("txtProdName").value; 
	var txtParentId		= document.getElementById("chkCat").value;
	
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


function makeArticleSEOURL()
{
	//var txtParentId = document.getElementById("cat_id").value;
	var txtTitle = document.getElementById("txtTitle").value; 

	var url= "static_article_url.php?txtTitle=" + escape(txtTitle);
	
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showArticleSEOURL;

	//send the request
	request.send(null);
}


function showArticleSEOURL()
{

	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;

			document.getElementById("txtSEOURL").value = xmlResponse;
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


function checkLogin()
{
	var txtLogin 	= document.getElementById("txtLogin").value;
	var txtPass 	= document.getElementById("txtPass").value; 
	//window.location.replace("login.php");
	//alert(txtLogin);
	var url= "check-login.php?txtLogin=" + escape(txtLogin)+"&txtPass=" + escape(txtPass);
	
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showLogin;

	//send the request
	request.send(null);
}


function showLogin()
{
	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			var responseArr	= xmlResponse.split("?");
			if(responseArr[0] == 'detail.php')
			{
				document.getElementById("login-msg").innerHTML = '<div id="msg" class="suBlock blackLarge" style="width:96%"><span class="orangeLetter"></span> Login sucessful!! Redirecting...<img src="images/icon/close-button.png" class="fr1" alt="" onclick="fadeInfoBlock()" border="0" height="10" width="10"></div>';
				window.location.replace(xmlResponse);
				$("#login-msg").fadeIn("slow");
			}
			else
			{
				document.getElementById("login-msg").innerHTML = '<div id="msg" class="erBlock blackLarge" style="width:96%"><span class="orangeLetter"></span>invalid login or password<img src="images/icon/close-button.png" class="fr1" alt="" onclick="fadeInfoBlock()" border="0" height="10" width="10"></div>';
				$("#login-msg").fadeIn("slow");
			}
			//document.getElementById("").value = xmlResponse;
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


function checkLogin2()
{
	var txtLogin 	= document.getElementById("txtLogin2").value;
	var txtPass 	= document.getElementById("txtPass2").value; 
	//window.location.replace("login.php");
	
	var url= "check-login.php?txtLogin=" + escape(txtLogin)+"&txtPass=" + escape(txtPass);
	
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showLogin2;

	//send the request
	request.send(null);
}


function showLogin2()
{
	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			var responseArr	= xmlResponse.split("?");
			if(responseArr[0] == 'detail.php')
			{
				//$("#login-new").fadeOut("slow");
				document.getElementById('login-new').innerHTML="";
				document.getElementById("login-msg2").innerHTML = '<div id="msg" class="suBlock blackLarge" style="width:96%"><span class="orangeLetter"></span> Login sucessful!! Redirecting...<img src="images/icon/close-button.png" class="fr1" alt="" onclick="fadeInfoBlock()" border="0" height="10" width="10"></div>';
				window.location.replace(xmlResponse);
				
				$("#login-msg2").fadeIn("slow");
			}
			else
			{
				document.getElementById("login-msg2").innerHTML = '<div id="msg" class="erBlock blackLarge" style="width:96%"><span class="orangeLetter"></span>invalid login or password<img src="images/icon/close-button.png" class="fr1" alt="" onclick="fadeInfoBlock()" border="0" height="10" width="10"></div>';
				$("#login-msg2").fadeIn("slow");
			}
			//document.getElementById("").value = xmlResponse;
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


function addNewsletter()
{
	var newsletterEmail 	= document.getElementById("newsletterEmail").value;
	//window.location.replace("login.php");
	
	var url= "newsletter-sub.php?newsletterEmail=" + escape(newsletterEmail);
	
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showNewsletter;

	//send the request
	request.send(null);
}

function showNewsletter()
{

	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;

			document.getElementById("newsletterEmail").value = xmlResponse;
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


function fadeOutPopup(popupId)
{
	var	popupId = popupId;
	$("#"+popupId).fadeOut("slow");
}


/**
*    comment
*/
function contentTitleCopy()
{
	var x=document.getElementById("txtTitle").value;
	document.getElementById("txtPageTitle").value=x;
}

function contentTitleCopy2()
{
	var x=document.getElementById("txtProdName").value;
	document.getElementById("txtPageTitle").value=x;
}

function fadeInfoBlock()
{
	$("#msg").fadeOut("slow");
}


/* Tool Tip 
*	Added On: February 8, 2012
*
*
*/

var cX = 0; var cY = 0; var rX = 0; var rY = 0;
function UpdateCursorPosition(e){ cX = e.pageX; cY = e.pageY;}
function UpdateCursorPositionDocAll(e){ cX = event.clientX; cY = event.clientY;}
if(document.all) { document.onmousemove = UpdateCursorPositionDocAll; }
else { document.onmousemove = UpdateCursorPosition; }
function AssignPosition(d) {
if(self.pageYOffset) {
rX = self.pageXOffset;
rY = self.pageYOffset;
}
else if(document.documentElement && document.documentElement.scrollTop) {
rX = document.documentElement.scrollLeft;
rY = document.documentElement.scrollTop;
}
else if(document.body) {
rX = document.body.scrollLeft;
rY = document.body.scrollTop;
}
if(document.all) {
cX += rX;
cY += rY;
}
d.style.left = (cX+10) + "px";
d.style.top = (cY-10) + "px";
}
function HideText(d) {
if(d.length < 1) { return; }
document.getElementById(d).style.display = "none";
}
function ShowText(d) {
if(d.length < 1) { return; }
var dd = document.getElementById(d);
AssignPosition(dd);
dd.style.display = "block";
}
function ReverseContentDisplay(d) {
if(d.length < 1) { return; }
var dd = document.getElementById(d);
AssignPosition(dd);
if(dd.style.display == "none") { dd.style.display = "block"; }
else { dd.style.display = "none"; }
}

