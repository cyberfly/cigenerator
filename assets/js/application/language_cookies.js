	$(document).ready(function () {			

		$('#lang').live('change',function(){
		 	var language = $(this).val();
		 	createCookie('lang',language,1);
		 	location.reload(true);
		});

		function createCookie(name,value,days)
		{
			if (days) 
			{
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = "; expires="+date.toGMTString();
			}			
			else var expires = "";

			document.cookie = name+"="+value+expires+"; path=/";
		}

		$(".redirect_page").click(function() {

			redirectAjax();

		});

		function redirectAjax()
		{
			var redirect_page = config.current_page;
				
			$.ajax({
				type: "POST",
				async : false,
				url: config.base_url + 'home/ajax_redirect_page/',
				dataType: 'text',
				data : {
					redirect_page : redirect_page			
				},
				success : function(data) {	
					window.location = config.base_url + 'home/sign_in/';					
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
				}
			}); 
		}			

	});				
