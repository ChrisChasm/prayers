/*
 Echo Prayer Map
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

	});
})(jQuery);