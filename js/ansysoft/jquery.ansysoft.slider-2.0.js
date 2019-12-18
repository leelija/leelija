// JavaScript Document


/**  Slider Banner**/

// when the DOM is ready
$(document).ready(function()
{
	/*****************You can control height,width,and speed of the slider from here*******************************/
	
	var	sliderWidth=		531;
	var	sliderHeight=		168;
	var	speed=				8000;
	var	fadeOutInterval=	1000;
	var	fadeInInterval=		2000;
	var imgWidth=			531;
	var imgHeight=			168;
	var sliding=			'True';
	var loading=			'False';
	 
	$('.sp').first().addClass('active');
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
	});*/

	
	var ss_timer = setInterval(function(){ image_next() },speed);
	
	
	
	/*Function for next image*/
	function image_next()
	
	{
	    <!-- This section is not completed -->
		/*$('#slider-wrapper').mouseover(function(){
			image_pause();
		});	
		function image_pause(){
		$('.active').fadeIn();
		$('.activeHeading').fadeIn();
		$('.activeDesc').fadeIn();
		clearInterval(ss_timer);		
		}
		$('#slider-wrapper').mouseleave(function(){
		image_next();
		});*/
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
	
	function image_next_button()
	{
	//declaring variables																									   
		var a	=	$(".active");
		var b	=	$(".activeHeading");
		var c	=	$('.activeDesc');
		
		//
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
		}
		/*else take the next image by calling  the next function and add active class to it*/ 
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
		/*fade out the divs and only fadein the image of Active class*/
		$('.Hd').fadeOut();
		$('.sp').fadeOut();
		$('.desc').fadeOut();
		$('.active').fadeIn();
		$('.activeDesc').fadeIn();
		$('.activeHeading').fadeIn();
		
		
	}//eof image_next()
	function image_prev_button()
	{
	/*first change the class of thr active image as oldActive*/
																												   
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
		}
	/*else take the previous image by calling  the prev function and add active class to it */
		else
		{
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
			var imgId	=	id.slice(-1);
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
		});//eof('.unselect').on('click') function
		
		
		
		$('.select').on('click', function()
		{
			$('.select').removeClass('select').addClass('unselect');
			var id		= 	$(this).attr('id');
			var imgId	=	id.slice(-1);
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




