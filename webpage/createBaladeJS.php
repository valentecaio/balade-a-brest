<?php?>
<script type="text/javascript">
// global variables
var map, markersVectorLayer, points, destinations;
destinations = [];

// remove repeated values from an array
// found at https://stackoverflow.com/questions/1584370/how-to-merge-two-arrays-in-javascript-and-de-duplicate-items
function arrayUnique(array) {
	var a = array.concat();
	for (var i = 0; i < a.length; ++i) {
		for (var j = i + 1; j < a.length; ++j) {
			if (a[i] === a[j])
				a.splice(j--, 1);
		}
	}

	return a;
}

function refresh_balades_table() {
	// get table reference
	table = document.getElementById('points_list');
	
	// delete table rows
	while (table.firstChild) {
		table.removeChild(table.firstChild);
	}

	for (i=0; destinations && i < destinations.length; i++) {
		// create new row
		var new_row = document.createElement('div');
		new_row.className = "btn-group";
		new_row.style = "width:100%";

		var but1 = document.createElement('button');
		but1.style = "width:90%;height: 40px; text-align: left; color: black;";
		but1.className = "btn btn-default";
		but1.innerHTML = destinations[i].name + ' (' + destinations[i].lon + ', ' + destinations[i].lat + ')';

		new_row.appendChild(but1);
		
		// add new row to table
		table.appendChild(new_row);
	}
}

// add points to map (with controller)
function setup_click_listener() {
	//Add a selector control to the vectorLayer with popup functions
	var controls = {
		selector: new OpenLayers.Control.SelectFeature(markersVectorLayer, {
			onSelect: addDestination
		})
	};

	function addDestination(feature) {
		// get clicked point and add to destinations
		var clicked_point = feature.attributes.point;
		console.log(clicked_point)
		destinations.push(clicked_point);

		// remove destination if already chosen before this event
		destinations = arrayUnique(destinations);

		refresh_balades_table();
	}

	map.addControl(controls['selector']);
	controls['selector'].activate();
}

function main() {
	points = get_all_points();

	// load map without points
	map,
	markersVectorLayer = setup_map(
			center = {
				lon: -4.50010299,
				lat: 48.38423089
			}, zoom = 14);

	// plot all points on map
	refresh_markers(map, markersVectorLayer, points);

	// add click listener to markers
	setup_click_listener();
}
</script>