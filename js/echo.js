(function($) {
	$(document).ready(function() {

		// record prayed for request
		$('form.echo-prayed').submit( function( event ) {

			var $form = $(this);
			var formData = $form.serialize();
			var prayer_id = $form.attr('data-prayer-id');

			// post the form
			$.post('#', formData, function(data) {
				// update the prayer count
				var count = parseInt( $('span.echo-prayer-count.prayer-' + prayer_id).text(), 10 );				
				// update visual display
				$('span.echo-prayer-count.prayer-' + prayer_id).text(count+1);
				
				// store this click in local storage to prevent abuse
				var items = localStorage.getItem('echo');

				// localStorage echo-prayers key doesn't exist
				if (items == null) {
					items = { prayers: [ prayer_id ] };
				}
				else {
					items = localStorage.getItem('echo');
					items = JSON.parse(items);

					if (items.prayers.indexOf(prayer_id) < 0) {						
						items.prayers.push(prayer_id);
					}
				}
				data = JSON.stringify(items);
				localStorage.setItem( 'echo', data );

				//console.log(localStorage);				
				//localStorage.clear();
			}, 'html');

			event.preventDefault();
		});

	});
})(jQuery);