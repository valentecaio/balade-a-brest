// global variables
var map, points, destinations;
destinations = [];

// add points to map (with controller)
function add_markers(map, balade) {
	// add new markers
	var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
	for (i=0; balade && i < balade.length; i++) {
		var marker = new OpenLayers.Feature.Vector(
				new OpenLayers.Geometry.Point(balade[i].lon, balade[i].lat).transform(epsg4326, projectTo), {
				description: balade[i].name
			}, {
				externalGraphic: 'image_marker.png',
				graphicHeight: 30,
				graphicWidth: 30,
				graphicXOffset: -12,
				graphicYOffset: -25
			});
		vectorLayer.addFeatures(marker);
	}
	map.addLayer(vectorLayer);

	/*
	//Add a selector control to the vectorLayer with popup functions
	var controls = {
		selector: new OpenLayers.Control.SelectFeature(vectorLayer, {
			onSelect: addDestination,
			onUnselect: destroyPopup
		})
	};

	function addDestination(feature) {
		center = feature.geometry.getBounds().getCenterLonLat();
		destinations.push({
			lon: center.lon,
			lat: center.lat,
			name: "point3"
		})
		feature.popup = new OpenLayers.Popup.FramedCloud("pop",
				feature.geometry.getBounds().getCenterLonLat(),
				null,
				'<div class="markerContent">' + feature.attributes.description + '</div>',
				null,
				true,
				function () {
				controls['selector'].unselectAll();
			});
		//feature.popup.closeOnMove = true;
		map.addPopup(feature.popup);
	}

	function destroyPopup(feature) {
		feature.popup.destroy();
		feature.popup = null;
	}

	map.addControl(controls['selector']);
	controls['selector'].activate();
	*/
}

function main() {
	points = get_all_points();
	
	// load map without points
	map = setup_map(center = {
				lon: -4.50010299,
				lat: 48.38423089
			}, zoom = 14);
	
	add_markers(map, points);
};
