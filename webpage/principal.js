// search by name in global variables
function searchByName(name, data) {
	for (i in data) {
		if (data[i].name == name) {
			return data[i];
		}
	}
	return null;
}

// draw a point in the map
function show_point(name) {
	var point_to_show = searchByName(name, points);
	refresh_markers(map, [point_to_show]);
}

// draw a balade in the map
function show_balade(name) {
	var balade_to_show = searchByName(name, balades);
	refresh_markers(map, balade_to_show.points);
}

// save point and go to editPoint
function go_to_edit_point(name) {
	var point_to_save = searchByName(name, points);
	var pointName = point_to_save.name;
	sessionStorage.setItem("divName", pointName);
	window.location = "edition.html";
}

// save balade and go to editBalade
function go_to_edit_balade(name) {
	var balade_to_save = searchByName(name, balades);
	//TODO: finish this method
}

// draw all points in the map
function show_all_points(name) {
	refresh_markers(map, points);
}

// load points and balades from database
function load_data() {
	// load map without points
	map = setup_map(center = {
				lon: -4.50010299,
				lat: 48.38423089
			}, zoom = 14);

	// create example points
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

	// create example strolls (balades)
	balades = [{
			name: 'balade1',
			points: [points[0], points[1], points[2], points[3]]
		}, {
			name: 'balade2',
			points: [points[0], points[1], points[4], points[5]]
		}, {
			name: 'balade3',
			points: [points[4], points[5], points[2], points[3]]
		}
	]
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

function main() {
	load_data();

	// add points and balades to tables
	add_rows("points_list", points, "show_point", "go_to_edit_point");
	add_rows("balades_list", balades, "show_balade", "go_to_edit_balade");
}