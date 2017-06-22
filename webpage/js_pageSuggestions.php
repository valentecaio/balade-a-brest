<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script src="lib/jquery.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src='markers.js'></script>

<script type="text/javascript">

// global variables
var points, balades;

// search by name in global variables
function search_by_name(name, data) {
	for (i in data) {
		if (data[i].name == name) {
			return data[i];
		}
	}
	return null;
}

// dinamically add rows to table
// data must be an iterable object where each entry has an attribute name
function add_rows(table_id, data, onclick_button_approve_point) {
	for (i = 0; i < data.length; i++) {
		var new_row = document.createElement('div');
		new_row.className = "btn-group";
		new_row.style = "width:100%";
		var but1 = document.createElement('button');
		but1.style = "width:100%;height: 40px; text-align: left; color: black;";
		but1.className = "btn btn-default";
		but1.innerHTML = data[i].name;
		but1.setAttribute('onclick', onclick_button_approve_point + "('" + data[i].name + "')");

		new_row.appendChild(but1);

		table = document.getElementById(table_id);
		table.appendChild(new_row);
	}
}

// onclick functions

function onclick_button_approve_point(name) {
	var point_to_save = search_by_name(name, points);
	
	sessionStorage.setItem("pointName", point_to_save.name);
	sessionStorage.setItem("pointLon", point_to_save.lon);
	sessionStorage.setItem("pointLat", point_to_save.lat);
	sessionStorage.setItem("pointId", point_to_save.id);
	sessionStorage.setItem("pointDescription", point_to_save.txt);

	sessionStorage.setItem('pageType', "approval");
	window.location = "pagePoint.php";
}

function main() {

	$.ajax({url: "query_read_points?status=1", success: function(result){
        points = JSON.parse(result);
        add_rows("list_points", points, "onclick_button_approve_point");
        //add_rows("balades_list", points, "show_point", "onclick_button_edit_point");
    }});
}

</script>