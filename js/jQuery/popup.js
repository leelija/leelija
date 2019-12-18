$(document).ready(function()
{
	$(".popup-link").click(function()
	{
		
		var X=$(this).attr('id');
		if(X==1)
		{
			$(".heading-link").hide();
			$(this).attr('id', '0');
			
			$(".pop-body").hide();
			$(this).attr('id', '0');	
		}
		else
		{

			$(".heading-link").show();
			$(this).attr('id', '1');
			
			$(".pop-body").show();
			$(this).attr('id', '1');
		}
	
	});

	//Mouseup textarea false
	$(".heading-link").mouseup(function()
	{
		return false
	});
	
	$(".pop-body").mouseup(function()
	{
		return false
	});
	
	$(".popup-link").mouseup(function()
	{
		return false
	});


	//Textarea without editing.
	$(document).mouseup(function()
	{
		$(".heading-link").hide();
		$(".pop-body").hide();
		$(".popup-link").attr('id', '');
	});
	
});


$(document).ready(function()
{
	$(".popup-country1").click(function()
	{
		var X=$(this).attr('id');

		if(X==1)
		{
			$(".address1").hide();
			$(this).attr('id', '0');	
		}
		else
		{
			$(".address1").show();
			$(this).attr('id', '1');
		}
	
	});

	//Mouseup textarea false
	$(".address1").mouseup(function()
	{
		return false
	});
	
	$(".popup-country1").mouseup(function()
	{
		return false
	});


	//Textarea without editing.
	$(document).mouseup(function()
	{
		$(".address1").hide();
		$(".popup-country1").attr('id', '');
	});
	
});

$(document).ready(function()
{
	$(".popup-country2").click(function()
	{
		var X=$(this).attr('id');

		if(X==1)
		{
			$(".address2").hide();
			$(this).attr('id', '0');	
		}
		else
		{
			$(".address2").show();
			$(this).attr('id', '1');

		}
	
	});

	//Mouseup textarea false
	$(".address2").mouseup(function()
	{
		return false
	});
	
	$(".popup-country2").mouseup(function()
	{
		return false
	});


	//Textarea without editing.
	$(document).mouseup(function()
	{
		$(".address2").hide();
		$(".popup-country2").attr('id', '');
	});
	
});

$(document).ready(function()
{
	$(".popup-country3").click(function()
	{
		var X=$(this).attr('id');

		if(X==1)
		{
			$(".address3").hide();
			$(this).attr('id', '0');	
		}
		else
		{
			$(".address3").show();
			$(this).attr('id', '1');
		}
	
	});

	//Mouseup textarea false
	$(".address3").mouseup(function()
	{
		return false
	});
	
	$(".popup-country3").mouseup(function()
	{
		return false
	});


	//Textarea without editing.
	$(document).mouseup(function()
	{
		$(".address3").hide();
		$(".popup-country3").attr('id', '');
	});
	
});

$(document).ready(function()
{
	
	$(".popup-country4").click(function()
	{
		var X=$(this).attr('id');

		if(X==1)
		{
			$(".address4").hide();
			$(this).attr('id', '0');	
		}
		else
		{
			$(".address4").show();
			$(this).attr('id', '1');
		}
	
	});

	//Mouseup textarea false
	$(".address4").mouseup(function()
	{
		return false
	});
	
	$(".popup-country4").mouseup(function()
	{
		return false
	});


	//Textarea without editing.
	$(document).mouseup(function()
	{
		$(".address4").hide();
		$(".popup-country4").attr('id', '');
	});
	
});

// for directory bookmark
$(document).ready(function()
{
	$(".popup-bookmark").click(function()
	{
		var X=$(this).attr('id');
		if(X==1)
		{
			$(".bookmark").hide();
			$(this).attr('id', '0');
				
		}
		else
		{

			$(".bookmark").show();
			$(this).attr('id', '1');
		}
	
	});

	//Mouseup textarea false
	$(".bookmark").mouseup(function()
	{
		return false
	});
	
	$(".popup-bookmark").mouseup(function()
	{
		return false
	});


	//Textarea without editing.
	$(document).mouseup(function()
	{
		$(".bookmark").hide();
		$(".popup-bookmark").attr('id', '');
	});
	
});