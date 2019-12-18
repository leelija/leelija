// JavaScript Document


/**  Slider Banner**/
function changePosition(){
	$('.like').css({
		top: -30
	});
}
// when the DOM is ready
$(document).ready(function()
{
	

	
	/*****************You can control height,width,and speed of the slider from here*******************************/
	
	/*var	sliderWidth=		800;
	var	sliderHeight=		550;
	var	speed=				5000;*/
	var	fadeOutInterval=	2000;
	var	fadeInInterval=		1000;
	/*var imgWidth=			800;
	var imgHeight=			550;*/
	var sliding=			'True';
	var loading=			'False';
	 
	//$('.sp').first().addClass('active');
	$('.Hd').first().addClass('activeHeading');
	$('.desc').first().addClass('activeDesc');
	/*Hide the other images*/
	$('.sp').hide(); 
	$('.Hd').hide();   
	$('.desc').hide();  
	/*Show only the image of active class*/
	$('.active').show();
	$('.activeHeading').show();
	$('.activeDesc').show();
	
	
	
	
/*	set the width & height of the slider-wrapper same as the image*/
	
	/*$('#slider-wrapper').css({
		width: function() {
			return imgWidth;
		}, 
		height: function() {
			return imgHeight;
		}, 
		position:'absolute',           
		overflow: 'hidden'
	});//eof of $(#slider-wrapper).css

	$('#frame').css({
		width: function() {
			return sliderWidth;
		}, 
		height: function() {
			return sliderHeight;
		},
	});
	$('.sp img').css({
		width: function() {
			return imgWidth;
		}, 
		height: function() {
			return imgHeight;
		}		
	});

	
	var ss_timer = setInterval(function(){ image_next() },speed);
	
	
	
	function image_next()
	
	{
	    <!-- This section is not completed -->
		
		<!-- eof not completed section -->
																												 
		var a = $(".active");
		var b=$(".activeHeading");
		var c=$('.activeDesc');
		a.removeClass('active').addClass('oldActive');
		b.removeClass('activeHeading').addClass('oldActiveHeading');
		c.removeClass('activeDesc').addClass('oldActiveDesc');
		$('.select').removeClass('select').addClass('old');
		
	//	if this oldactive image is the last image of the frame then add the active class to the first image of the frame 
		
		if ( $('.oldActive').is(':last-child'))
		 {
			$('.Hd').first().addClass('activeHeading');
			$('#coin-Ul li').first().addClass('select');
			$('.sp').first().addClass('active');
			$('.desc').first().addClass('activeDesc');
	
		}
	//else take the next image by calling  the next function and add active class to it 
		else
		{
			$('.oldActiveHeading').next().addClass('activeHeading');
			$('.old').next().addClass('select');
			$('.oldActive').next().addClass('active');
			$('.oldActiveDesc').next().addClass('activeDesc');
	
		}
		$('.oldActiveHeading').removeClass('oldActiveHeading');	
		$('.old').removeClass('old').addClass('unselect');
		$('.oldActive').removeClass('oldActive');
		$('.oldActiveDesc').removeClass('oldActiveDesc');
		//fade out the divs and only fadein the image of Active class
		$('.Hd').fadeOut(fadeOutInterval);
		$('.sp').fadeOut(fadeOutInterval);
		$('.desc').fadeOut(fadeOutInterval);
		$('.active').fadeIn(fadeInInterval);
		$('.activeDesc').fadeIn(fadeInInterval);
		$('.activeHeading').fadeIn(fadeInInterval);
	
	}//eof image_next()
	*/
	
	function image_next_button()
	{
		//declaring variables																									   
		var a			=	$(".active");
		var b			=	$(".activeHeading");
		var c			=	$('.activeDesc');

		a.removeClass('active').addClass('oldActive');
		b.removeClass('activeHeading').addClass('oldActiveHeading');
		c.removeClass('activeDesc').addClass('oldActiveDesc');
		$('.select').removeClass('select').addClass('old');
		
		/*if this oldactive image is the last image of the frame then add the active class to the first image of the frame */ 
		if ( $('.oldActive').is(':last-child')) 
		{
			$('.Hd').first().addClass('activeHeading');
			$('#coin-Ul li').first().addClass('select');
			$('.sp').first().addClass('active');
			$('.desc').first().addClass('activeDesc');
			<!-- .image-index section-->
			$('#coin-Ul').css({
				left: 400
			});
			<!-- eof .image-index section-->
		}
		/*else take the next image by calling  the next function and add active class to it*/ 
		else
		{
			<!-- eof .image-index section-->
			var element = document.getElementById('coin-Ul');
    		var style = window.getComputedStyle(element);
			var prevLeft 	= 	style.getPropertyValue('left');
			var prevLeft	=	prevLeft.slice(0,-2);
			var leftNow		=	parseInt(prevLeft)-80;
			$('#coin-Ul').css({
				left: leftNow
			});
			<!-- .image-index section-->
			
			$('.oldActiveHeading').next().addClass('activeHeading');
			$('.old').next().addClass('select');
			$('.oldActive').next().addClass('active');
			$('.oldActiveDesc').next().addClass('activeDesc');
		
		}
		
		$('.oldActiveHeading').removeClass('oldActiveHeading');	
		$('.old').removeClass('old').addClass('unselect');
		$('.oldActive').removeClass('oldActive');
		$('.oldActiveDesc').removeClass('oldActiveDesc');
		/*fade out the divs and only fadein the image of Active class*/
		$('.Hd').fadeOut();
		$('.sp').fadeOut();
		$('.desc').fadeOut();
		$('.active').fadeIn();
		$('.activeDesc').fadeIn();
		$('.activeHeading').fadeIn();
		var id			= $('.active').attr('id');
		var imgId		= document.getElementById(id).value;

		showComment(imgId);
		
		/* set image in the middle of the gallery*/
		var sliceId		= id.slice(4,id.length);
		var largeImgId	= 'image-id'+sliceId;
		
		$('#'+largeImgId).css('margin', '0px');
		
		var imgWidtht	= $('#'+largeImgId).outerWidth(true);
		var imgHeight	= $('#'+largeImgId).outerHeight(true);
		//alert(imgWidtht);
		var marginLeft	= (800-imgWidtht)/2;
		var marginTop	= (600-imgHeight)/2;;
		$('#'+largeImgId).css('margin-left', marginLeft+'px');
		$('#'+largeImgId).css('margin-top', marginTop+'px');
		/* eof set image in the middle of the gallery*/
		
	}//eof image_next()
	
	function image_prev_button()
	{
	/*first change the class of thr active image as oldActive*/
		var count = $("#coin-Ul li").length;																							   
		var a = $(".active");			
		var b=$(".activeHeading");
		var c=$('.activeDesc');
			
		a.removeClass('active').addClass('oldActive');
		b.removeClass('activeHeading').addClass('oldActiveHeading');
		c.removeClass('activeDesc').addClass('oldActiveDesc');
		$('.select').removeClass('select').addClass('old');
		
		/*if this oldactive image is the first image of the frame then add the active class to the last image of the frame  */
		if ( $('.oldActive').is(':first-child')) 
		{
				$('.Hd').last().addClass('activeHeading');		
				$('#coin-Ul li').last().addClass('select');
				$('.sp').last().addClass('active');		
				$('.desc').last().addClass('activeDesc');
				<!-- .image-index section-->
				$('#coin-Ul').css({
					left: 400-((count-1) * 80)
				});
				<!-- eof .image-index section-->
		}
	/*else take the previous image by calling  the prev function and add active class to it */
		else
		{
			<!-- .image-index section-->
			var element 	=	document.getElementById('coin-Ul');
    		var style 		= 	window.getComputedStyle(element);
			var prevLeft 	= 	style.getPropertyValue('left');
			var prevLeft	=	prevLeft.slice(0,-2);
			var leftNow		=	parseInt(prevLeft) + 80;
			$('#coin-Ul').css({
				left: leftNow
			});
			<!-- eof .image-index section-->
			$('.oldActiveHeading').prev().addClass('activeHeading');
			$('.old').prev().addClass('select');
			$('.oldActive').prev().addClass('active');
			$('.oldActiveDesc').prev().addClass('activeDesc');
	
		}
		$('.oldActiveHeading').removeClass('oldActiveHeading');	
		$('.old').removeClass('old').addClass('unselect');
		$('.oldActiveDesc').removeClass('oldActiveDesc');
		$('.oldActive').removeClass('oldActive');
		
	/*	fade out the divs and only fadein the image of Active class*/
		$('.Hd').fadeOut();
		$('.sp').fadeOut();
		$('.desc').fadeOut();
		$('.active').fadeIn();
		$('.activeDesc').fadeIn();
		$('.activeHeading').fadeIn();
		
		var id			= $('.active').attr('id');
		var imgId		= document.getElementById(id).value;
		showComment(imgId);
		
		/* set image in the middle of the gallery*/
		var sliceId		= id.slice(4,id.length);
		var largeImgId	= 'image-id'+sliceId;
		$('#'+largeImgId).css('margin', '0px');
		
		var imgWidtht	= $('#'+largeImgId).outerWidth(true);
		var imgHeight	= $('#'+largeImgId).outerHeight(true);
		
		var marginLeft	= (800-imgWidtht)/2;
		var marginTop	= (600-imgHeight)/2;;

		$('#'+largeImgId).css('margin-left', marginLeft+'px');
		$('#'+largeImgId).css('margin-top', marginTop+'px');
		/* eof set image in the middle of the gallery*/
		
		
	}//eof image_prev()
	
	$('#right-Arrow').on('click', function(){               
	   // clearInterval(ss_timer);
		image_next_button();

	});
	$('#left-Arrow').on('click', function(){               
	   // clearInterval(ss_timer);
		image_prev_button();
	});	
}); //ready

<!--Click on the Coin slider and change the image-->
$(document).ready(function()
 {
		$('.unselect').on('click', function()
		{
			$('.select').removeClass('select').addClass('unselect');
			var id		= 	$(this).attr('id');
			var imgId	=	id.slice(4);
			var	imageId	=   document.getElementById('img-'+imgId).value;
			showComment(imageId);
			<!-- .image-index moving -->
			
			$('#coin-Ul').css({
				left: 400-((imgId-1) * 80)
			});
			<!-- eof .image-index moving -->
			$('#'+id).addClass('select');	
			$('.active').fadeOut();
			$('.activeDesc').fadeOut();
			$('.activeHeading').fadeOut();
			$('.active').removeClass('active');
			$('.activeDesc').removeClass('activeDesc');
			$('.activeHeading').removeClass('activeHeading');
			$('#img-'+imgId).addClass('active');
			$('#description-'+imgId).addClass('activeDesc');
			$('#heading-'+imgId).addClass('activeHeading');
			$('.active').fadeIn();
			$('.activeDesc').fadeIn();
			$('.activeHeading').fadeIn();	
			
			/* set image in the middle of the gallery*/
			//var sliceId		= id.slice(4,id.length);
			var largeImgId	= 'image-id'+imgId;
			$('#'+largeImgId).css('margin', '0px');
			
			var imgWidtht	= $('#'+largeImgId).outerWidth(true);
			var imgHeight	= $('#'+largeImgId).outerHeight(true);
			
			var marginLeft	= (800-imgWidtht)/2;
			var marginTop	= (600-imgHeight)/2;;
	
			$('#'+largeImgId).css('margin-left', marginLeft+'px');
			$('#'+largeImgId).css('margin-top', marginTop+'px');
			/* eof set image in the middle of the gallery*/
			
		});//eof('.unselect').on('click') function
		
		
		
		$('.select').on('click', function()
		{
			$('.select').removeClass('select').addClass('unselect');
			var id		= 	$(this).attr('id');
			var imgId	=	id.slice(-1);
			<!-- .image-index moving -->
			
			$('#coin-Ul').css({
				left: 400-((imgId-1) * 80)
			});
			<!-- eof .image-index moving -->
			$('#'+id).addClass('select');	
			$('.active').fadeOut();
			$('.activeDesc').fadeOut();
			$('.activeHeading').fadeOut();
			$('.active').removeClass('active');
			$('.activeDesc').removeClass('activeDesc');
			$('.activeHeading').removeClass('activeHeading');
			$('#img-'+imgId).addClass('active');
			$('#description-'+imgId).addClass('activeDesc');
			$('#heading-'+imgId).addClass('activeHeading');
			$('.active').fadeIn();
			$('.activeDesc').fadeIn();
			$('.activeHeading').fadeIn();	
		});//eof('.select').on('click') function
	
	
});

/***********This is for displaying Arrows while mouseover**************/
$(document).ready(function()
 {
	$('#banner').hover (function()
	{
		$('#left-Arrow').css({
			display:'block'
		});
		$('#right-Arrow').css({
			display:'block'
		});
		
	},function(){
		$('#left-Arrow').css({
			display:'none'
		});
		$('#right-Arrow').css({
			display:'none'
		});

	});
});


/* Show comment in photo gallery section*/

/*function showComment(imgId)
{
	alert("HERE");
	var url= "show-comment.php?imgId=" + escape(imgId);
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
			alert("Error: Status Code is " + request.statusText);
		}
	}
}
*/


	function imageNumbering(arrowDir,coin){
	var count 					= $("#coin-Ul li").length;
	var activeImageId			= $('.active').attr('id');	
	var idnumber				= activeImageId.slice(4);
	
	if(arrowDir=='right')
	{
			if(idnumber == count)
			{	
				idnumber					= 1;
			}
			else
			{
				idnumber					= parseInt(idnumber) + 1;
			}
	}
	else if(arrowDir=='first'){
		idnumber					= 1;
	}
	else if(coin.slice(0,4) == 'coin')
	{
		
		idnumber					= coin.slice(4);
	}
	else
	{
		
			if(idnumber == 1)
			{	
				idnumber					= count;
			}
			else
			{
				idnumber					= parseInt(idnumber) - 1;
			}
	}

	var url= "image-numbering.php?count="+count+"&idnumber="+idnumber;
	request.open('GET',url,true); 
	
	//send the request
	
	request.onreadystatechange = getImageNumbering;
	request.send(null);
	}
	function getImageNumbering()
	{
		
		
		if(request.readyState == 4)
		{
			if(request.status == 200)
			{
				var xmlResponse = request.responseText;//.split("|")
				//var obj = document.getElementById('txtCountyId');
				document.getElementById("imageNumbering").innerHTML = xmlResponse;
				
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
 

