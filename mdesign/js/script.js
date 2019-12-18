jQuery(document).ready(function() {
	var pageHeight = $(window).height();
	$('#keep-up-date').css({'margin-top': (pageHeight/2)-(250/2)-100});


	$(window).resize(function() {
		var pageHeight = $(window).height();
		$('#keep-up-date').css({'margin-top': (pageHeight/2)-(250/2)-100});
	});
});