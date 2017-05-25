// init map without any marker or layer
function setup_map(center, zoom) {
	var fromProjection = new OpenLayers.Projection("EPSG:4326");
	var toProjection = new OpenLayers.Projection("EPSG:900913");

	map = new OpenLayers.Map("mapdiv");
	map.addLayer(new OpenLayers.Layer.OSM());

	var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
	map.addLayer(vectorLayer);

	var lonLat_center = new OpenLayers.LonLat(center.lon, center.lat).transform(fromProjection, toProjection);
	map.setCenter(lonLat_center, zoom);

	return map,
	vectorLayer;
}

function add_marker(map, vectorLayer, location) {
	var fromProjection = new OpenLayers.Projection("EPSG:4326");
	var toProjection = new OpenLayers.Projection("EPSG:900913");

	var marker = new OpenLayers.Feature.Vector(
			new OpenLayers.Geometry.Point(location.lon, location.lat).transform(fromProjection, toProjection), {
			description: location.name,
			point: location
		}, {
			externalGraphic: 'image_marker.png',
			graphicHeight: 30,
			graphicWidth: 30,
			graphicXOffset: -12,
			graphicYOffset: -25
		});
	vectorLayer.addFeatures(marker);
}

// remove markers from map and put new ones
function refresh_markers(map, markersVectorLayer, balade) {
	// remove old markers
	markersVectorLayer.destroyFeatures();

	// add new markers
	for (i = 0; balade && i < balade.length; i++) {
		add_marker(map, markersVectorLayer, balade[i]);
	}
}