// search by name in global variables
function search_by_name(name, data) {
	for (i in data) {
		if (data[i].name == name) {
			return data[i];
		}
	}
	return null;
}

// simulate loading points from database
function get_all_points() {
	// create example points
	var points = [{
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
	
	return points;
}

// simulates loading balades from database
function get_all_balades() {
	// create example strolls (balades)
	var balades = [{
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
	return balades;
}
