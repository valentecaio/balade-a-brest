<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script src="lib/jquery.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src="markers.js"></script>

<script type="text/javascript">

// global variables
var map, markersVectorLayer, point, zoom=16;

// add click listener to map
function setup_click_listener() {
	OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {
			defaultHandlerOptions: {
				'single': true,
				'double': false,
				'pixelTolerance': 0,
				'stopSingle': false,
				'stopDouble': false
			},

			initialize: function (options) {
				this.handlerOptions = OpenLayers.Util.extend({}, this.defaultHandlerOptions);
				OpenLayers.Control.prototype.initialize.apply(
					this, arguments);
				this.handler = new OpenLayers.Handler.Click(
						this, {
						'click': this.trigger
					}, this.handlerOptions);
			},

			trigger: function (e) {
				// get point values
				var lonlat = map.getLonLatFromPixel(e.xy);
				
				// correct lon and lat values
				var fromProjection = new OpenLayers.Projection("EPSG:4326"); // Transform from WGS 1984
				var toProjection = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
				var point_clicked = new OpenLayers.LonLat(lonlat.lon, lonlat.lat).transform(toProjection, fromProjection);
				var lon = point_clicked.lon;
				var lat = point_clicked.lat;
				
				setPointClicked(lon, lat, point.name, point.id, point.txt);
			}
		});

	var click = new OpenLayers.Control.Click();
	map.addControl(click);
	click.activate();
}

function setPointClicked(lon, lat, name="", id="", descript=""){
	// set point
	point = {
		name: name,
		lon: lon,
		lat: lat,
		id: id,
		txt: descript
	};
	
	// add point data to form boxes
	document.getElementById("form_id").value = id;
	document.getElementById("form_name").value = name;
	document.getElementById("form_latitude").value = lat;
	document.getElementById("form_longitude").value = lon;
	document.getElementById("form_comment").value = descript;
	
	// change markers on map
	refresh_markers(map, markersVectorLayer, [point])
}

function onClickSendButton(action) {
	document.getElementById("form_point").setAttribute('action', action);
}

function add_buttons(){
	var pageType = sessionStorage.getItem('pageType');
	var send_button = document.getElementById("send_button");
	if(pageType == 'creation') {
		document.getElementById("delete_button").style.display = 'none';
		send_button.innerHTML = 'Envoyer';
		send_button.setAttribute('onclick', "onClickSendButton('query_insert_point.php')");
	} else if(pageType == 'approval'){
		send_button.innerHTML = 'Approuver';
		send_button.setAttribute('onclick', "onClickSendButton('query_approve_point.php')");
	} else if(pageType == 'edition'){
		send_button.innerHTML = 'Envoyer';
		send_button.setAttribute('onclick', "onClickSendButton('query_edition_point.php')");
	}
}

function add_rows(table_id, data, onclick_but) {
	for (i = 0; i < data.length; i++) {
		// create row for this data
		var new_row = document.createElement('div');
		new_row.className = "btn-group";
		new_row.style = "width:100%";
		
		// add data itself as delegate of this row, to use it in onclick functions
		new_row.delegate = data[i];
		new_row.id = "row_" + data[i].id;
		
		// append data name to row
		var but_name = document.createElement('a');
		but_name.style = "width: 90%; height: 40px; text-align: left; color: black;";
		but_name.className = "btn btn-default";
		but_name.innerHTML = data[i];
		but_name.setAttribute('role', "button");
		but_name.setAttribute('href', "'" + data[i]+ "'");

		// append row on the table
		new_row.appendChild(but_name);
		table = document.getElementById(table_id);
		table.appendChild(new_row);
		
		var but_edit = document.createElement('button');
		but_edit.style = "width: 10%; height: 40px;";
		but_edit.className = "btn btn-default";
		but_edit.setAttribute('onclick', onclick_but + "('" + data[i].id + "')");
		new_row.appendChild(but_edit);
		
		var icon = document.createElement('span');
		icon.className = "glyphicon glyphicon-trash";
		icon.style = "color: black";
		but_edit.appendChild(icon);
	}		
}



function main() {
	// load map without any point
	map,
	markersVectorLayer = setup_map(
			center = {
				lon: -4.496798,
				lat: 48.38423089
			}, zoom = zoom);
	
	setup_click_listener();
	
	// load data according to page function
	var pageType = sessionStorage.getItem('pageType');
	console.log(pageType);
	if(pageType == 'edition' || pageType == 'approval') {
		// load point data
		var pointName = sessionStorage.getItem('pointName');
		var pointLat = sessionStorage.getItem('pointLat');
		var pointLon = sessionStorage.getItem('pointLon');
		var pointId = sessionStorage.getItem('pointId');
		var pointDescript = sessionStorage.getItem('pointDescription');
		
		// set point data
		setPointClicked(pointLon, pointLat, pointName, pointId, pointDescript);
		
		// recenter map
		center_map(map, point, zoom);
	} else if(pageType == 'creation') {
		// init global variable to avoid losing clicked points
		setPointClicked(null, null);
	}

	var media = ["rak_entrée.jpg", "rak_entrée2.png"];

    add_rows("points_list", media, "onclick_button_delete");

	add_buttons();
}

</script>