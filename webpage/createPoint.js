// global variables
var map, markersVectorLayer, point_clicked;

// add click listener to map
function setup_click_listener() {
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
				// get point values
				var fromProjection = new OpenLayers.Projection("EPSG:4326"); // Transform from WGS 1984
				var toProjection = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
				var lonlat = map.getLonLatFromPixel(e.xy);
				point_clicked = new OpenLayers.LonLat(lonlat.lon, lonlat.lat).transform(toProjection, fromProjection);

				// add point data to form boxes
				document.getElementById("form_latitude").value = point_clicked.lat;
				document.getElementById("form_longitude").value = point_clicked.lon;

				// change markers on map
				refresh_markers(map, markersVectorLayer, [point_clicked])
			}
		});

	var click = new OpenLayers.Control.Click();
	map.addControl(click);
	click.activate();
}

function main() {
	// load map without points
	map,
	markersVectorLayer = setup_map(
			center = {
				lon: -4.496798,
				lat: 48.38423089
			}, zoom = 16);
	
	setup_click_listener();
}
