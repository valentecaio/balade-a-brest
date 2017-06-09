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

// Array Remove - By John Resig (MIT Licensed)
// found at https://stackoverflow.com/questions/500606/deleting-array-elements-in-javascript-delete-vs-splice
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};

function delete_confirmation(id) {
	table = document.getElementById('points_list');
	table.removeChild(table.childNodes[id]);
	destinations.splice( id, 1 );
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

		var but_edit = document.createElement('button');
		but_edit.style = "width:10%;height: 40px;";
		but_edit.className = "btn btn-default";
		but_edit.id = i;
		//but_edit.setAttribute('data-toggle' , "modal");
		//but_edit.setAttribute('data-target' , "#deleteConfirmation");
		but_edit.setAttribute('onclick', "delete_confirmation" + "('" + but_edit.id + "')");
		
		var span = document.createElement('span');
		span.className = "glyphicon glyphicon-trash";
		span.style = "color: black";
		
		but_edit.appendChild(span);
		new_row.appendChild(but1);
		new_row.appendChild(but_edit);

		// add new row to table
		table.appendChild(new_row);
	}
}

// add points to map (with controller)
function setup_click_listener() {
	//Add a selector control to the vectorLayer with popup functions
	var controls = {
		selector: new OpenLayers.Control.SelectFeature(markersVectorLayer, {
			onSelect: onClickMarker
		})
	};

	function onClickMarker(feature) {
		// change selected status
		feature.attributes.selected = !feature.attributes.selected;
		
		if(feature.attributes.selected) {
			// get clicked point and add to destinations
			destinations.push(feature.attributes.point);
		} else {
			// remove clicked point from destinations
			destinations.remove(destinations.indexOf(feature.attributes.point));			
		}
	
		// refresh balades table and marker color
		refresh_balades_table();
		change_color(markersVectorLayer, feature);
	}

	map.addControl(controls['selector']);
	controls['selector'].activate();
}

function main() {
	//points = get_all_points();

	// load map without points
	map,
	markersVectorLayer = setup_map(
			center = {
				lon: -4.50010299,
				lat: 48.38423089
			}, zoom = 14);
	$.ajax({url: "get_points.php", success: function(result){
        points = JSON.parse(result);
        // plot all points on map
        refresh_markers(map, markersVectorLayer, points);
        console.log(points);
        //add_rows("points_list", points, "show_point", "go_to_edit_point");
    }});
	// plot all points on map
	//refresh_markers(map, markersVectorLayer, points);

	// add click listener to markers
	setup_click_listener();
}