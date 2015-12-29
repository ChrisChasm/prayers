(function($) {

	// record prayed for request
	$('form.echo-prayed').submit( function( event ) {

		var $form = $(this);
		var formData = $form.serialize();
		var prayer_id = $form.attr('data-prayer-id');

		// post the form
		$.post('#', formData, function(data) {
			// update the prayer count
			var count = parseInt( $('span.echo-prayer-count.prayer-' + prayer_id).text(), 10 );
			
			$('span.echo-prayer-count.prayer-' + prayer_id).text(count+1);

		}, 'html');

		event.preventDefault();
	});
	
})(jQuery);