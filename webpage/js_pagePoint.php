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

	add_buttons();
}

</script>