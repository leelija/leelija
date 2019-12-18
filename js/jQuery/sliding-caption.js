/**
*	jQuery library for sliding caption.
*/


$(document).ready(function() {
	
	//Execute the slideShow, set 3 seconds for each images
	slideShow(4000);

});

function slideShow(speed) {


	//append a LI item to the UL list for displaying caption
	$('ul.ansysoft').append('<li id="ansysoft-caption" class="caption"><div class="ansysoft-caption-container"><h3></h3><p></p></div></li>');

	//Set the opacity of all images to 0
	$('ul.ansysoft li').css({opacity: 0.0});
	
	//Get the first image and display it (set it to full opacity)
	$('ul.ansysoft li:first').css({opacity: 1.0}).addClass('show');
	
	//Get the caption of the first image from REL attribute and display it
	$('#ansysoft-caption h3').html($('ul.ansysoft li.show').find('img').attr('title'));
	$('#ansysoft-caption p').html($('ul.ansysoft li.show').find('img').attr('alt'));
		
	//Display the caption
	$('#ansysoft-caption').css({opacity: 0.7, bottom:0});
	
	//Call the gallery function to run the slideshow	
	var timer = setInterval('gallery()',speed);
	
	//pause the slideshow on mouse over
	$('ul.ansysoft').hover(
		function () {
			clearInterval(timer);	
		}, 	
		function () {
			timer = setInterval('gallery()',speed);			
		}
	);
	
	

	
}

function gallery() {


	//if no IMGs have the show class, grab the first image
	var current = ($('ul.ansysoft li.show')?  $('ul.ansysoft li.show') : $('#ul.ansysoft li:first'));
	
	//trying to avoid speed issue
	//if(current.queue('fx').length == 0) {	
	
		//Get next image, if it reached the end of the slideshow, rotate it back to the first image
		var next = ((current.next().length) ? ((current.next().attr('id') == 'ansysoft-caption')? $('ul.ansysoft li:first') :current.next()) : $('ul.ansysoft li:first'));
			
		//Get next image caption
		var title = next.find('img').attr('title');	
		var desc = next.find('img').attr('alt');	
	
		//Set the fade in effect for the next image, show class has higher z-index
		 next.css({opacity: 0.7}).addClass('show').animate({opacity: 2.0}, 4000);
		
		//Hide the caption first, and then set and display the caption
		$('#ansysoft-caption').slideToggle(1000, function () { 
			$('#ansysoft-caption h3').html(title); 
			$('#ansysoft-caption p').html(desc); 
			$('#ansysoft-caption').slideToggle(1000); 
		});		
	
		//Hide the current image
		current.animate({opacity: 0.0}, 1000).removeClass('show');

	//} 
	
}