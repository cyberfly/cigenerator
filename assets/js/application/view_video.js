	$(document).ready(function () {		

		//load the ios flowplayer
		
		flowplayer("player", config.base_url + 'assets/swf/flowplayer-3.2.9.swf').ipad();

		//initialize the star rating

		$('#star').raty(
		{
		   half:  true,
		   start: 5
		});

	});				
