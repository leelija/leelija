/**
*	This function will display number of subcategory section
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
function getNumDesc()
{
	var selNum = document.getElementById("selNum").value;
	alert(selNum);
	var url= "static_desc.php?selNum=" + escape(selNum);
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



function getNumDesc2()
{
	var selNum = document.getElementById("selDescNum").value;
	var url= "static_desc.php?selNum=" + escape(selNum);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescRes2;
	
	//writing response while verifying
	document.getElementById('showDescMsg').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	//<img src='../images/icon/green_flower.gif' border='0' alt='image loading' />
	
	//send the request
	request.send(null);
}

function getDescRes2()
{
	
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("showAddDescMsg").innerHTML = xmlResponse;
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
*	Java Script function to work with categories and sub categories and title for creating a SEO friendly URL.
*
*	@author     	Mousumi Dey
*	@date   	 	October 10, 2011
*	@version 		2.0
*	@copyright 		Analyze System
*	@email			mousumi.dey@ansysoft.com
*/



function makeContentSEOURL()
{
	var txtParentId = document.getElementById("cat_id").value;
	var txtTitle = document.getElementById("txtTitle").value; 

	var url= "static_content_url.php?txtTitle=" + escape(txtTitle)  + "&txtParentId=" + escape(txtParentId);
	
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showContentSEOURL;

	//send the request
	request.send(null);
}


function showContentSEOURL()
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





/**
*	Deletion the file upload .
*
*	@author     	Mousumi Dey
*	@date   	 	August, 2012
*	@version 		2.0
*	@copyright 		Analyze System
*	@email			mousumi.dey@ansysoft.com
*/
function deleteFile()
{
	//alert("here");
	<!--var parDoc = window.parent.document;-->
	var txtUploadFile = document.getElementById("txtUploadFile").value;
	var parent_div = document.getElementById("parent_div").innerHTML;
	//alert(parent_div);
	
	var url= "delete_file.php?parent_div=" + escape(parent_div) + "&txtUploadFile=" + escape(txtUploadFile);
	//alert(url);
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = getDeleteFile;

	//send the request
	request.send(null);
}


function getDeleteFile()
{

	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("parent_div").innerHTML = xmlResponse;
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
*	Show the listed files in the pop up of a static content.
*
*	@author     	Manoj Acharya
*	@date   	 	December, 2014
*	@version 		2.0
*	@copyright 		Analyze System
*	@email			developer@ansysoft.com
*/
function showStaticFile(staticId)
{
	var staticId = staticId;
	//alert(parent_div);
	
	var url= "static_file_show.php?static_id=" + escape(staticId);
	//alert(url);
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = getStaticFile;

	//send the request
	request.send(null);
}


function getStaticFile()
{

	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("show-manage-file").innerHTML = xmlResponse;
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

function editFile(downId)
{
	var downId = downId;
	//alert(parent_div);
	
	var url= "static_file_edit.php?id=" + escape(downId);
	//alert(url);
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showFile;

	//send the request
	request.send(null);
}

function showFile()
{

	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("edit-file").innerHTML = xmlResponse;
			$("#editfile-form").on('submit',(function(e) {
				e.preventDefault();
				$.ajax({
					url: "static_file_edit2.php",   	// Url to which the request is send
					type: "POST",      				// Type of request to be send, called as method
					data:  new FormData(this), 		// Data sent to server, a set of key/value pairs representing form fields and values 
					contentType: false,       		// The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
					cache: false,					// To unable request pages to be cached
					processData:false,  			// To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
					success: function(data)  		// A function to be called if request succeeds
					{
						if(data == 'Title is empty')
						{
							document.getElementById("file-error").innerHTML = data;
						}
						else
						{
							document.getElementById("show-manage-file").innerHTML = data;
							document.getElementById("edit-file").innerHTML = '';
						}
					}	        
			   });
			}));
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




	
function editStaticFile(downId)
{
		//var input = document.getElementById("txtUploadFile");
		//alert(input);
      	//formdata = false;
		//alert($("#editfile-form").serialize());
		//e.preventDefault();
		//alert(downId)
		$.ajax({
        	url: "static_file_edit2.php",   // Url to which the request is send
			type: "POST",      				// Type of request to be send, called as method
			data:  new FormData(this),		// Data sent to server, a set of key/value pairs representing form fields and values 
			contentType: false,       		// The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
    	    cache: false,					// To unable request pages to be cached
			processData:false,  			// To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data)  		// A function to be called if request succeeds
		    {
				alert(data);		
		    }	        
	   });

	
	/*var filearray = new Array();
    var file = $("#txtUploadFile")[0].files[0];
	if(file != 'undefined')
	{
		filearray["filename"] = file.name;
		filearray["filesize"] = file.size;
		filearray["fileType"] = file.type;
		filearray["fileTemp"] = file.tmp_name;
		filearray["fileError"] = file.error;
		var fileName		= file.name;
	}
	else
	{
		var fileName		= '';
	}*/
	//var fileName		= '';
	
	/*var url= "static_file_edit2.php?id=" + escape(downId)+"&title=" + escape(title)+"&intSort=" + escape(intSort)
	+"&pagePos=" + escape(pagePos)+"&status=" + escape(status)+"&linkAlign=" + escape(linkAlign)+"&fileName=" + escape(fileName);
	//alert(url);
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showEditFile;

	//send the request
	request.send(null);*/
}

function showEditFile()
{

	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			var output		= xmlResponse.split("~");
			if(output[0] == "sucess")
			{
				document.getElementById("edit-file").innerHTML = "File updated sucessfully";
				document.getElementById("show-manage-file").innerHTML = output[1];
			}
			else
			{
				document.getElementById("file-error").innerHTML = xmlResponse;
			}
			//
			
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

function deleteFile2(downId)
{
	var downId = downId;
	//alert(parent_div);
	
	var url= "static_file_delete.php?id=" + escape(downId);
	//alert(url);
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showFile2;

	//send the request
	request.send(null);
}

function showFile2()
{

	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			
			document.getElementById("edit-file").innerHTML = xmlResponse;
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



function deleteFile3(downId)
{
	var downId = downId;
	//alert(parent_div);
	
	var url= "static_file_delete2.php?id=" + escape(downId);
	//alert(url);
	request.open('GET',url,true);

	//set up a function to the server when its done
	request.onreadystatechange = showFile3;

	//send the request
	request.send(null);
}

function showFile3()
{
	if(request.readyState == 4)
	{

		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			/*document.getElementById("file-del-sucess").innerHTML = 'File deleted sucessfully';*/
			document.getElementById("delete-file-form").innerHTML = '';
			document.getElementById("show-manage-file").innerHTML = xmlResponse;
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

