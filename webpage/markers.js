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

// dinamically add rows to table
// data must be an iterable object where each entry has a attribute name
function add_rows(table_id, data, onclick_function) {
	for (i = 0; i < data.length; i++) {
		var new_row = document.createElement('div');
		new_row.className = "btn-group";
		new_row.style = "width:100%";

		var but1 = document.createElement('button');
		but1.style = "width:90%;height: 40px; text-align: left; color: black;";
		but1.className = "btn btn-default";
		but1.innerHTML = data[i].name;
		but1.setAttribute('onclick', onclick_function + "('" + data[i].name + "')");

		var but_edit = document.createElement('button');
		but_edit.style = "width:10%;height: 40px;";
		but_edit.className = "btn btn-default";

		var span = document.createElement('span');
		span.className = "glyphicon glyphicon-wrench";
		span.style = "color: black";

		but_edit.appendChild(span);
		new_row.appendChild(but1);
		new_row.appendChild(but_edit);

		table = document.getElementById(table_id);
		table.appendChild(new_row);
	}
}
