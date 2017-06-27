<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script src="lib/jquery.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src="markers.js"></script>
<script src='database_simulator.js'></script>

<script type="text/javascript">

// global variables
var map, markersVectorLayer, points, destination_markers, zoom=16;
destination_markers = [];

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

function delete_confirmation(index) {
	// get points table
	table = document.getElementById('points_list');
	// get point in the table
	chosen_marker = table.childNodes[index].destination;
	// remove point
	onClickMarker(chosen_marker);
}

function refresh_balades_table() {
	// get table reference
	table = document.getElementById('points_list');
	
	// delete table rows
	while (table.firstChild) {
		table.removeChild(table.firstChild);
	}

	for (i=0; destination_markers && i < destination_markers.length; i++) {
		var point = destination_markers[i].attributes.point;
		
		// create new row
		var new_row = document.createElement('div');
		new_row.className = "btn-group";
		new_row.style = "width:100%";
		
		// add point as an attribute in this new row
		new_row.destination = destination_markers[i];

		// create button with point name
		var but1 = document.createElement('button');
		but1.style = "width:90%;height: 40px; text-align: left; color: black;";
		but1.className = "btn btn-default";
		but1.innerHTML = point.name + ' (' + point.lon + ', ' + point.lat + ')';
		new_row.appendChild(but1);

		// create delete button for this point
		var but_edit = document.createElement('button');
		but_edit.style = "width:10%;height: 40px;";
		but_edit.className = "btn btn-default";
		but_edit.setAttribute('onclick', "delete_confirmation" + "('" + i + "')");
		new_row.appendChild(but_edit);
		
		// add trash icon to delete button
		var span = document.createElement('span');
		span.className = "glyphicon glyphicon-trash";
		span.style = "color: black";
		but_edit.appendChild(span);
		
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

	map.addControl(controls['selector']);
	controls['selector'].activate();
}

function onClickMarker(feature) {
	// select or unselect marker
	set_marker_selected(markersVectorLayer, feature, !feature.attributes.selected);

	if(feature.attributes.selected) {
		// get clicked marker and add to destination_markers
		destination_markers.push(feature);
	} else {
		// remove clicked marker from destination_markers
		destination_markers.remove(destination_markers.indexOf(feature));
	}

	// refresh balades table and marker color
	refresh_balades_table();
	
	// refresh JSON form with new destination_markers
	dest_points = [];
	for (i=0; destination_markers && i < destination_markers.length; i++) {
		dest_points.push(destination_markers[i].attributes.point);
	}
	document.getElementById("form_list").value = JSON.stringify(dest_points);
}

function onClickSendButton(action) {
	document.getElementById("form_balade").setAttribute('action', action);
}

function add_buttons(){
	var pageType = sessionStorage.getItem('pageType');
	var send_button = document.getElementById("send_button");
	if(pageType == 'creation') {
		document.getElementById("delete_button").style.display = 'none';
		send_button.innerHTML = 'Envoyer';
		send_button.setAttribute('onclick', "onClickSendButton('query_insert_balade.php')");
	} else if(pageType == 'approval'){
		send_button.innerHTML = 'Approuver';
		send_button.setAttribute('onclick', "onClickSendButton('query_approve_balade.php')");
	} else if(pageType == 'edition'){
		send_button.innerHTML = 'Envoyer';
		send_button.setAttribute('onclick', "onClickSendButton('query_edition_balade.php')");
	}
}

function setPointClicked(name="", theme="", id="", descript=""){
	// set point
	balade = {
		name: name,
		theme: theme,
		id: id,
		txt: descript
	};
	
	// add point data to form boxes
	document.getElementById("form_id").value = id;
	document.getElementById("form_name").value = name;
	document.getElementById("form_theme").value = theme;
	document.getElementById("form_comment").value = descript;
}

function main() {
	// load map without points
	map,
	markersVectorLayer = setup_map(
			center = {
				lon: -4.496798,
				lat: 48.38423089
			}, zoom = zoom);
			
	// load points from database
	$.ajax({url: "query_read_points.php", success: function(result){
        points = JSON.parse(result);

		// plot all points on map
        refresh_markers(map, markersVectorLayer, points);
    }});


    	// load data according to page function
	var pageType = sessionStorage.getItem('pageType');
	if(pageType == 'edition' || pageType == 'approval') {
		// load point data
		var baladeName = sessionStorage.getItem('baladeName');
		var baladeTheme = sessionStorage.getItem('baladeTheme');
		var baladeId = sessionStorage.getItem('baladeId');
		var baladeDescription = sessionStorage.getItem('baladeDescription');
		
		// set point data
		setPointClicked(baladeName, baladeTheme, baladeId, baladeDescription);

	} else if(pageType == 'creation') {
		// init global variable to avoid losing clicked points
		setPointClicked(null, null);
	}

	// add click listener to markers
	setup_click_listener();
	
	add_buttons();
}

</script>