function addmarkers(balade) {
	return function () {
		map = new OpenLayers.Map("mapdiv");
		map.addLayer(new OpenLayers.Layer.OSM());

		epsg4326 = new OpenLayers.Projection("EPSG:4326");
		projectTo = map.getProjectionObject();
		
		var lonLat_center = new OpenLayers.LonLat(-4.50010299, 48.38423089).transform(epsg4326, projectTo);
		var zoom = 14;
		map.setCenter(lonLat_center, zoom);

		var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
		for(i=0; balade && i<balade.length; i++) {
			var marker = new OpenLayers.Feature.Vector(
					new OpenLayers.Geometry.Point(balade[i][0], balade[i][1]).transform(epsg4326, projectTo), {
					description: balade[i][2]
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
		  selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
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
}
