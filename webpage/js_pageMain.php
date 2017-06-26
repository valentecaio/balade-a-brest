<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script src="lib/jquery.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src='markers.js'></script>

<script type="text/javascript">

// global variables
var map, points, balades, markersVectorLayer, zoom=14;

// search by name in global variables
function search_by_name(name, data) {
	for (i in data) {
		if (data[i].name == name) {
			return data[i];
		}
	}
	return null;
}

// draw a point in the map
function show_point(id) {
	var clicked_row = document.getElementById("row_" + id);
	var point = clicked_row.delegate;
	
	refresh_markers(map, markersVectorLayer, [point]);

	console.log(point);
	
	// recenter map
	center_map(map, point, zoom);
}

// draw a balade in the map
function show_balade(id) {
	var clicked_row = document.getElementById("row_" + id);
	var balade = clicked_row.delegate;
	
	console.log(balade);
	refresh_markers(map, markersVectorLayer, balade.points);
}

// draw all points in the map
function show_all_points() {
	refresh_markers(map, markersVectorLayer, points);
}

// dinamically add rows to table
// data must be an iterable object where each entry has an attribute name
function add_rows(table_id, data, onclick_but_name, onclick_but_edit) {
	for (i = 0; i < data.length; i++) {
		// create row for this data
		var new_row = document.createElement('div');
		new_row.className = "btn-group";
		new_row.style = "width:100%";
		
		// add data itself as delegate of this row, to use it in onclick functions
		new_row.delegate = data[i];
		new_row.id = "row_" + data[i].id;
		
		// append data name to row
		var but_name = document.createElement('button');
		but_name.style = "width: 100%; height: 40px; text-align: left; color: black;";
		but_name.className = "btn btn-default";
		but_name.innerHTML = data[i].name;
		but_name.setAttribute('onclick', onclick_but_name + "('" + data[i].id + "')");

		// append row on the table
		new_row.appendChild(but_name);
		table = document.getElementById(table_id);
		table.appendChild(new_row);
		
		// if user is admin, also add edit button to this row
		<?php if(isset($_SESSION['id_usager'])&&(strcmp($_SESSION['permission'], "admin") == 0)){ ?>
				but_name.style = "width: 90%; height: 40px; text-align: left; color: black;";
		
				var but_edit = document.createElement('button');
				but_edit.style = "width: 10%; height: 40px;";
				but_edit.className = "btn btn-default";
				but_edit.setAttribute('onclick', onclick_but_edit + "('" + data[i].id + "')");
				new_row.appendChild(but_edit);
				
				var icon = document.createElement('span');
				icon.className = "glyphicon glyphicon-wrench";
				icon.style = "color: black";
				but_edit.appendChild(icon);
		<?php } ?>
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

// onclick functions

function onclick_button_add_point(){
	sessionStorage.setItem('pageType', "creation");
	window.location = "pagePoint.php";
}

function onclick_button_add_balade(){
	sessionStorage.setItem('pageType', "creation");
	window.location = "pageBalade.php";
}

// save point and go to editPoint
function onclick_button_edit_point(id) {
	var clicked_row = document.getElementById("row_" + id);
	var point_to_save = clicked_row.delegate;
	
	sessionStorage.setItem("pointName", point_to_save.name);
	sessionStorage.setItem("pointLon", point_to_save.lon);
	sessionStorage.setItem("pointLat", point_to_save.lat);
	sessionStorage.setItem("pointId", point_to_save.id);
	sessionStorage.setItem("pointDescription", point_to_save.txt);

	sessionStorage.setItem('pageType', "edition");
	window.location = "pagePoint.php";
}

// save balade and go to editBalade
function onclick_button_edit_balade(id) {
	var clicked_row = document.getElementById("row_" + id);
	var balade_to_save = clicked_row.delegate;
	//TODO: finish this method

	sessionStorage.setItem('pageType', "edition");
	window.location = "pageBalade.php";
}

function main() {
	// load map without points
	map,
	markersVectorLayer = setup_map(
			center = {
				lon: -4.50010299,
				lat: 48.38423089
			}, zoom = zoom);

	add_control_to_map();

	// add points and balades to tables
	$.ajax({url: "query_read_points.php", success: function(result){
        points = JSON.parse(result);
        add_rows("points_list", points, "show_point", "onclick_button_edit_point");
    }});
	$.ajax({url: "query_read_balades.php", success: function(result){
        balades = JSON.parse(result);
		add_rows("balades_list", balades, "show_balade", "onclick_button_edit_balade");
    }});
}

</script>