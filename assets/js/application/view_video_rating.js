	$(document).ready(function () {			

		//initialize the star rating

		var video_rating = $('#video_rating').val();
		var already_rate = $('#already_rate').val();
		var rating_hash = $('#rating_hash').val();
		var read_only = true;

		if(already_rate=='Y')
		{
			read_only = true;
		}
		else
		{
			read_only = false;
		}			

		$('#star').raty(
		{
		   half:  true,
		   readOnly: read_only,
		   start: video_rating,
		   click: function(score, evt) {
				rateAjax(score);			
			}
		});

		function rateAjax(score)
		{
				var video_id = $("#video_id").val();

				$.ajax({
					type: "POST",
					async : false,
					url: config.base_url + 'video/submit_video_rate/',
					dataType: 'json',
					data : {
						score : score,
						video_id : video_id,
						rating_hash : rating_hash				
					},
					success : function(data) {
						if(data=='success')
						{							
							
						}
						else if(data=='error')
						{
							
						}
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
					}
				});
		}

		$("#redeem_video").click(function() {

			var already_subscribe = $("#already_subscribe").val();

			if(already_subscribe=='Y')
			{
				var answ = confirm('You already subscribe to the channel. You sure want to redeem this video?');

				if(answ)
				{
					redeemAjax();
				}
				else
				{
					return false;
				}
			}
			else
			{
				redeemAjax();
			}

		});

		function redeemAjax()
		{
			var vid = $("#vid").val();
			var user_id = $("#user_id").val();
			var page =  $("#page").val();
			var vid_hash =  $("#vid_hash").val();
			var payment_ref = 0;

			$.ajax({
				type: "POST",
				async : false,
				url: config.base_url + 'payment/ajax_redeem_video/',
				dataType: 'text',
				data : {
					user_id : user_id,
					vid : vid,			
					page : page,			
					vid_hash : vid_hash,			
					payment_ref : payment_ref			
				},
				success : function(data) {
					if(data=='0')
					{							
						alert('Error. Please try again.');	
					}
					else if(data=='1')
					{
						alert('You have successfully redeem the vide.');
						location.reload();		
					}
					else if(data=='2')
					{
						alert('Error. You dont have enough balance.');		
					}
					else if(data=='3')
					{
						alert('Error. You already purchase this video.');		
					}
					else if(data=='4')
					{
						alert('Error. Please login first.');		
					}
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
				}
			});
		}

		$(".fave_video").click(function() {

			faveAjax();			
		});

		function faveAjax()
		{
			var vid = $("#vid").val();			

			$.ajax({
				type: "POST",
				async : false,
				url: config.base_url + 'video/ajax_add_video_to_fav/',
				dataType: 'text',
				data : {					
					vid : vid			
				},
				success : function(data) {
					if(data=='0')
					{							
								
					}
					else if(data=='1')
					{
						$(".fave_video").hide();
						$("#love_video").show();				
					}					
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
				}
			});
		}


	});				
