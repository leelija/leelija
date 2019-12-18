function PersonalList(meetingId)
{
	//alert(meetingId);

	//var showImage	 = document.getElementById("showImage").value;
	//alert(showImage);
	/*$(".add-icon").click(function(){
		var id = $(this).attr('id');
		var idIndex = id.slice(10);
		//alert(idIndex);
		//$("#refine-search-sec-"+idIndex).css({
		//	display: 'block'
		//});
		
		$("#hideImage-"+idIndex).css({
			display: 'none'
		});
		$("#showImage-"+idIndex).css({
			display: 'block'
		});
	});*/
//alert(meetID);
	//document.getElementById('popup-div').style.display = "block";
	var url= "personal_meeting_list.php?meetingId=" + escape(meetingId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescResPersonal;
	
	//writing response while verifying
/*	document.getElementById('showDescMsg').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request*/
request.send(null);
}


function getDescResPersonal()
{
	//alert("HERE");
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			//alert(xmlResponse);
			// value passed to the reco-table
			document.getElementById('AddRemoveMessage').style.display = "block";
			/*var output = xmlResponse.split("~");
			if(output[1] != '')
			{
				document.getElementById("AddRemoveMessage").innerHTML = output[0];
				document.getElementById("Add_Rem").innerHTML = output[1];
				

				//alert(output[4]);

			 }*/

			document.getElementById("AddRemoveMessage").innerHTML = xmlResponse;
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




function PersonalListDelete(meetingId)
{
	//alert(meetingId);
	

/*$(".close-icon").click(function(){
		var id = $(this).attr('id');
		var idIndex = id.slice(10);
		//alert(idIndex);
		//$("#refine-search-sec-"+idIndex).css({
		//	display: 'none'
		//});
		$("#hideImage-"+idIndex).css({
			display: 'block'
		});
		$("#showImage-"+idIndex).css({
			display: 'none'
		});
	});
	*/
//alert(meetID);
	//document.getElementById('popup-div').style.display = "block";
	var url= "update_personal_list1.php?meetingId=" + escape(meetingId);
	request.open('GET',url,true);
	
	//set up a function to the server when its done
	request.onreadystatechange = getDescResDelete;
	
	//writing response while verifying
/*	document.getElementById('showDescMsg').innerHTML=
	"<span class='orangeLetter padT10'>" +
	"" + 
	"<span class='padB5'> Loading ... </span></span>";
	
	//send the request*/
request.send(null);
}


function getDescResDelete()
{
	//alert("HERE");
	if(request.readyState == 4)
	{
		
		if(request.status == 200)
		{
			var xmlResponse = request.responseText;
			var txt = "The meeting has been Removed.";
			//alert(xmlResponse);
			// value passed to the reco-table
			document.getElementById('AddRemoveMessage').style.display = "block";

			document.getElementById("AddRemoveMessage").innerHTML = txt;
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