// global variables
var map, markers, point_clicked;

function main() {
	// load map without points
	map = setup_map(center = {
				lon: -4.496798,
				lat: 48.38423089
			}, zoom = 16);

	markers = new OpenLayers.Layer.Markers("Markers");
	map.addLayer(markers);

	OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {
			defaultHandlerOptions: {
				'single': true,
				'double': false,
				'pixelTolerance': 0,
				'stopSingle': false,
				'stopDouble': false
			},

			initialize: function (options) {
				this.handlerOptions = OpenLayers.Util.extend({}, this.defaultHandlerOptions);
				OpenLayers.Control.prototype.initialize.apply(
					this, arguments);
				this.handler = new OpenLayers.Handler.Click(
						this, {
						'click': this.trigger
					}, this.handlerOptions);
			},

			trigger: function (e) {
				var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
				var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection

				// get point values
				var lonlat = map.getLonLatFromPixel(e.xy);
				point_clicked = new OpenLayers.LonLat(lonlat.lon, lonlat.lat).transform(toProjection, fromProjection);

				// remove old markers
				if (map.layers[1]) {
					map.layers[1].clearMarkers();
				}

				// add marker to map
				var new_position = new OpenLayers.LonLat(point_clicked.lon, point_clicked.lat).transform(fromProjection, toProjection);
				markers.addMarker(new OpenLayers.Marker(new_position));

				// add point data to form boxes
				document.getElementById("form_latitude").value = point_clicked.lat;
				document.getElementById("form_longitude").value = point_clicked.lon;
			}

		});

	var click = new OpenLayers.Control.Click();
	map.addControl(click);
	click.activate();
}
