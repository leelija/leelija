$(document).ready(function()
{
	$("#showcase").awShowcase(
	{
	});
	
	$("#most-popular").awShowcase(
	{
		content_width:			638,
		content_height:			221,
		interval:				10000,
		arrows:					true,
		auto:					false,
		transition:				'hslide' /* hslide / vslide / fade */
	});
	
	$("#new-arrivals").awShowcase(
	{
		content_width:			638,
		content_height:			221,
		interval:				10000,
		arrows:					true,
		auto:					false,
		transition:				'hslide' /* hslide / vslide / fade */
	});
	
	$("#close-outs").awShowcase(
	{
		content_width:			638,
		content_height:			221,
		interval:				10000,
		arrows:					true,
		auto:					false,
		transition:				'hslide' /* hslide / vslide / fade */
	});
});