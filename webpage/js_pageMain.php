<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script src="lib/jquery.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src='markers.js'></script>

<script type="text/javascript">

// global variables
var map, points, balades, markersVectorLayer;

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
function show_point(name) {
	var point_to_show = search_by_name(name, points);
	refresh_markers(map, markersVectorLayer, [point_to_show]);
}

// draw a balade in the map
function show_balade(name) {
	var balade_to_show = search_by_name(name, balades);
	refresh_markers(map, markersVectorLayer, balade_to_show.points);
}

// draw all points in the map
function show_all_points() {
	refresh_markers(map, markersVectorLayer, points);
}

// dinamically add rows to table
// data must be an iterable object where each entry has an attribute name
function add_rows(table_id, data, onclick_but1, onclick_but_edit) {
	for (i = 0; i < data.length; i++) {
		var new_row = document.createElement('div');
		new_row.className = "btn-group";
		new_row.style = "width:100%";
		<?php if(isset($_SESSION['id_usager'])&&(strcmp($_SESSION['permission'], "admin") == 0)){ ?>
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

		<?php } else { ?>
				var but1 = document.createElement('button');
				but1.style = "width:100%;height: 40px; text-align: left; color: black;";
				but1.className = "btn btn-default";
				but1.innerHTML = data[i].name;
				but1.setAttribute('onclick', onclick_but1 + "('" + data[i].name + "')");
		
				new_row.appendChild(but1);

				table = document.getElementById(table_id);
				table.appendChild(new_row);
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
function onclick_button_edit_point(name) {
	var point_to_save = search_by_name(name, points);
	
	sessionStorage.setItem("pointName", point_to_save.name);
	sessionStorage.setItem("pointLon", point_to_save.lon);
	sessionStorage.setItem("pointLat", point_to_save.lat);
	sessionStorage.setItem("pointId", point_to_save.id);
	sessionStorage.setItem("pointDescription", point_to_save.txt);

	sessionStorage.setItem('pageType', "edition");
	window.location = "pagePoint.php";
}

// save balade and go to editBalade
function onclick_button_edit_balade(name) {
	var balade_to_save = search_by_name(name, balades);
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
			}, zoom = 14);

	add_control_to_map();

	$.ajax({url: "get_points.php", success: function(result){
        points = JSON.parse(result);
        add_rows("points_list", points, "show_point", "onclick_button_edit_point");
        //add_rows("balades_list", points, "show_point", "onclick_button_edit_point");
    }});
	//yourContainer.innerHTML = JSON.stringify(points);
	// add points and balades to tables
	//add_rows("balades_list", balades, "show_balade", "onclick_button_edit_balade");
}

</script>