<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script src="lib/jquery.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src="markers.js"></script>

<script type="text/javascript">

// global variables
var map, markersVectorLayer, point;

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
	document.getElementById("form_name").value = name;
	document.getElementById("form_latitude").value = lat;
	document.getElementById("form_longitude").value = lon;
	document.getElementById("form_comment").value = descript;
	
	// change markers on map
	refresh_markers(map, markersVectorLayer, [point])
}

function main() {
	// load map without any point
	map,
	markersVectorLayer = setup_map(
			center = {
				lon: -4.496798,
				lat: 48.38423089
			}, zoom = 16);
	
	setup_click_listener();
	
	// load data according to page function
	var pageType = sessionStorage.getItem('pageType');
	if(pageType == 'edition' || pageType == 'approval') {
		console.log("edition or approval page");

		// load point data
		var pointName = sessionStorage.getItem('pointName');
		var pointLat = sessionStorage.getItem('pointLat');
		var pointLon = sessionStorage.getItem('pointLon');
		var pointId = sessionStorage.getItem('pointId');
		var pointDescript = sessionStorage.getItem('pointDescription');
		
		// set point data
		setPointClicked(pointLon, pointLat, pointName, pointId, pointDescript);
	} else if(pageType == 'creation') {
		console.log("creation page");
		
		// init global variable to avoid losing clicked points
		setPointClicked(null, null);
	}
}

</script>