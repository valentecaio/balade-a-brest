
var map, markers, point_clicked;

points = [{
		lon: -4.5250042190,
		lat: 48.382436270,
		name: "point1"
	}, {
		lon: -4.5210042190,
		lat: 48.386435270,
		name: "point2"
	}, {
		lon: -4.5015042190,
		lat: 48.394435270,
		name: "point3"
	}, {
		lon: -4.5116742190,
		lat: 48.39236270,
		name: "point4"
	}, {
		lon: -4.5010042190,
		lat: 48.392435270,
		name: "point5"
	}, {
		lon: -4.5210042190,
		lat: 48.382435270,
		name: "point6"
	}
]
var zoom = 14;
var curpos = new Array();

var tanguy_tower = [48.383410, -4.496798]

var fromProjection = new OpenLayers.Projection("EPSG:4326"); // Transform from WGS 1984
var toProjection = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection

var cntrposition = new OpenLayers.LonLat(tanguy_tower[1], tanguy_tower[0]).transform(fromProjection, toProjection);
var vectorLayer = new OpenLayers.Layer.Vector("Overlay");

for (i = 0; points && i < points.length; i++) {
	var marker = new OpenLayers.Feature.Vector(
			new OpenLayers.Geometry.Point(points[i].lon, points[i].lat).transform(fromProjection, toProjection), {
			description: points[i].lat
		}, {
			externalGraphic: 'image_marker.png',
			graphicHeight: 30,
			graphicWidth: 30,
			graphicXOffset: -12,
			graphicYOffset: -25
		});
	vectorLayer.addFeatures(marker);
}

function main() {
	map = new OpenLayers.Map("Map");
	markers = new OpenLayers.Layer.Markers("Markers");

	var mapnik = new OpenLayers.Layer.OSM("MAP");

	map.addLayers([mapnik, markers]);
	map.setCenter(cntrposition, zoom);
	map.addLayer(vectorLayer);

	var click = new OpenLayers.Control.Click();
	map.addControl(click);
	click.activate();
};
