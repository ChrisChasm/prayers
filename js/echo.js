(function($) {

	// record prayed for request
	$('span[data-prayer-click]').click(function() {
		var post_id = $(this).attr('data-prayer-click');
		console.log(post_id);

		return false;
	});
	
})(jQuery);