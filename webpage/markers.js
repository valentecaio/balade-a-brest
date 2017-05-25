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
