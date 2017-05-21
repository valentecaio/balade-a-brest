// init map without any marker or layer
function setup_map(center, zoom) {
	map = new OpenLayers.Map("mapdiv");
	map.addLayer(new OpenLayers.Layer.OSM());

	epsg4326 = new OpenLayers.Projection("EPSG:4326");
	projectTo = map.getProjectionObject();

	var lonLat_center = new OpenLayers.LonLat(center.lon, center.lat).transform(epsg4326, projectTo);
	map.setCenter(lonLat_center, zoom);
	
	return map;
}

// remove markers from map and put new ones
function refresh_markers(map, balade) {
	// remove old markers
	if(map.layers[1]){
		map.removeLayer(map.layers[1])
	}
	
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

	//Add a selector control to the vectorLayer with popup functions
	var controls = {
		selector: new OpenLayers.Control.SelectFeature(vectorLayer, {
			onSelect: createPopup,
			onUnselect: destroyPopup
		})
	};

	function createPopup(feature) {
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
}

