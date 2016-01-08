/*
 Prayer Map
 */
(function($) {
	$(document).ready(function() {


		var map = new ol.Map({
			layers: [
				new ol.layer.Tile({
					source: new ol.source.OSM()
				})
			],
			target: 'map',
			controls: ol.control.defaults({
				attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
					collapsible: false
				})
			}),
			view: new ol.View({
				center: [0, 0],
				zoom: 2
			})
		});

		$.getJSON( '/wp-json/prayers/v1/prayers', function( data ) {
			console.log(data);
		});

		document.getElementById('zoom-out').onclick = function() {
        	var view = map.getView();
        	var zoom = view.getZoom();
        	view.setZoom(zoom - 1);
      	};

      	document.getElementById('zoom-in').onclick = function() {
       		var view = map.getView();
        	var zoom = view.getZoom();
        	view.setZoom(zoom + 1);
      	};

	});
})(jQuery);