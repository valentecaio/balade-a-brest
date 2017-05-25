// global variables
var map, markersVectorLayer, points, destinations;
destinations = [];

// remove repeated values from an array
// found at https://stackoverflow.com/questions/1584370/how-to-merge-two-arrays-in-javascript-and-de-duplicate-items
function arrayUnique(array) {
    var a = array.concat();
    for(var i=0; i<a.length; ++i) {
        for(var j=i+1; j<a.length; ++j) {
            if(a[i] === a[j])
                a.splice(j--, 1);
        }
    }

    return a;
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
};
