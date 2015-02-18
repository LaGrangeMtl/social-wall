(function($, ns){
	var updateStatusCallback = function(r){
		var response = r;
		console.table(response)
	}

	// FACEBOOK WAY
	$(document).ready(function(){
		$.ajaxSetup({ cache: true });
		$.getScript('//connect.facebook.net/en_UK/all.js', function(){
			FB.init({
				appId      : '570240956445444',
				xfbml      : true,
				version    : 'v2.2'
			});     
			//$('#loginbutton,#feedbutton').removeAttr('disabled');
			FB.getLoginStatus(updateStatusCallback);
		});
	});

})(jQuery, window.socialwall = window.socialwall || {});