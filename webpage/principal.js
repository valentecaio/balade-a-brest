// global variables
var map, points, balades, markersVectorLayer;

// draw a point in the map
function show_point(name) {
	var point_to_show = searchByName(name, points);
	refresh_markers(map, markersVectorLayer, [point_to_show]);
}

// draw a balade in the map
function show_balade(name) {
	var balade_to_show = searchByName(name, balades);
	refresh_markers(map, markersVectorLayer, balade_to_show.points);
}

// save point and go to editPoint
function go_to_edit_point(name) {
	var point_to_save = searchByName(name, points);
	var pointName = point_to_save.name;
	var pointLat = point_to_save.lat;
	var pointLon = point_to_save.lon;
	sessionStorage.setItem("divName", pointName);
	//sessionStorage.setItem("divLat", pointLat);
	//sessionStorage.setItem("divLon", pointLon);
	window.location = "edition.html";
}

// save balade and go to editBalade
function go_to_edit_balade(name) {
	var balade_to_save = searchByName(name, balades);
	//TODO: finish this method
}

// draw all points in the map
function show_all_points() {
	refresh_markers(map, markersVectorLayer, points);
}

// dinamically add rows to table
// data must be an iterable object where each entry has a attribute name
function add_rows(table_id, data, onclick_but1, onclick_but_edit) {
	for (i = 0; i < data.length; i++) {
		var new_row = document.createElement('div');
		new_row.className = "btn-group";
		new_row.style = "width:100%";

		var but1 = document.createElement('button');
		but1.style = "width:90%;height: 40px; text-align: left; color: black;";
		but1.className = "btn btn-default";
		but1.innerHTML = data[i].name;
		but1.setAttribute('onclick', onclick_but1 + "('" + data[i].name + "')");

		var but_edit = document.createElement('button');
		but_edit.style = "width:10%;height: 40px;";
		but_edit.className = "btn btn-default";
		but_edit.setAttribute('onclick', onclick_but_edit + "('" + data[i].name + "')");
		//but_edit.setAttribute('data-toggle', 'modal');
		//but_edit.setAttribute('data-target', '#modalEdition');


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

// add popup to markers
function add_control_to_map() {
	//Add a selector control to the vectorLayer with popup functions
	var controls = {
		selector: new OpenLayers.Control.SelectFeature(markersVectorLayer, {
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

function main() {
	points = get_all_points();
	balades = get_all_balades();

	// load map without points
	map,
	markersVectorLayer = setup_map(
			center = {
				lon: -4.50010299,
				lat: 48.38423089
			}, zoom = 14);

	add_control_to_map();

	// add points and balades to tables
	add_rows("points_list", points, "show_point", "go_to_edit_point");
	add_rows("balades_list", balades, "show_balade", "go_to_edit_balade");
}
