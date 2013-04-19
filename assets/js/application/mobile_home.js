
	$(document).ready(function () {

		$('.load_more').live("click",function()
		{
			var last = $("ul#home_video li:last").attr("id");

			var last_video_id = last.split("_");

			var last_video_id = last_video_id[1];

			var page = $("#page").val();

			var num_per_page = 5;
			var offset = 0;

			if($("#num_per_page").length > 0)
			{
				num_per_page = $("#num_per_page").val();
			}

			if($("#offset").length > 0)
			{
				offset = $("#offset").val();
			}

			if(last_video_id)
			{
				$.ajax({
					type: "POST",
					url: config.base_url+"home/mobile_load_more/",
					data:{
						last_video_id : last_video_id,
						page : page,
						offset : offset
					},
					cache: false,
					beforeSend: function() {
				        $.mobile.showPageLoadingMsg();
    				},
    				complete: function() {
				        $.mobile.hidePageLoadingMsg();
    				},
					success: function(html){
						$("ul#home_video").append(html);

						if ($("#end_result").length > 0){
 							$("#load_more").fadeOut();
						}

						//if got offset, we plus to new one

						if($("#offset").length > 0)
						{
							offset = parseFloat(offset) + parseFloat(num_per_page);
							$("#offset").val(offset);
						}
					}
				});
			}
			else
			{
				alert('habis doh');
			}

			return false;
		});

	});
