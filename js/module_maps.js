var portOfOrigin = {};

function initialize(table) {
	for (i in table) {
		var geoTag =  new google.maps.LatLng(table[i][3], table[i][4]);
		portOfOrigin[table[i][2]] = {
		  cargo: table[i][0],
		  waarde: table[i][1],
		  title: table[i][2],
		  center: geoTag
		};
	}
	// Create the map.
	var lat = 52.373055;
	var lng = 4.899722;
	var amsterdam = new google.maps.LatLng(lat,lng);
	var mapOptions = {
	  zoom: 4,
	  center: amsterdam,
	  mapTypeId: google.maps.MapTypeId.TERRAIN };
	var map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);

	// Construct the circle for each value in origin.
	// The area of the circle is based on the portOfOrigin[port].waarde,
	//   presently sqrt of waarde * 20,000 is used to scale circles.
	for (var port in portOfOrigin) {
	  var waardeOptions = {
		strokeColor: '#FF0000',
		strokeOpacity: 0.8,
		strokeWeight: 0.5,
		fillColor: '#FF0000',
		fillOpacity: 0.35,
		map: map,
		center: portOfOrigin[port].center,
		title: portOfOrigin[port].title,
		radius: Math.sqrt(portOfOrigin[port].waarde) * 20000
	  };
	  // Add the "waarde" circle for this port to the map.
	  waardeCircle = new google.maps.Circle(waardeOptions);
	}

	var myMarker = "http://siegfried.webhosting.rug.nl/~shipping/paalgeld_weu/img/info.png";
	var markerAmsterdam = "http://siegfried.webhosting.rug.nl/~shipping/paalgeld_weu/img/info-2.png";
	for (var port in portOfOrigin) {
	  // Construct a line from Amsterdam to the port of origin.
	  var track = [amsterdam,portOfOrigin[port].center];
	  var showTrack = new google.maps.Polyline({
		  path: track,
		  strokeColor: '#0000FF',
		  strokeOpacity: 0.8,
		  strokeWeight: 1
	  });
	  showTrack.setMap(map);

	  // Construct an info marker for each port of origin.
	  var customMarker = new google.maps.Marker({
		position: portOfOrigin[port].center,
		map: map,
		icon: myMarker,
		title:
		  (portOfOrigin[port].title).concat(', ',
		  portOfOrigin[port].cargo,', ',
		  portOfOrigin[port].waarde)
	  });
	}

	// Create an info marker for Amsterdam.
	var customMarker = new google.maps.Marker({
	  position: amsterdam,
	  map: map,
	  icon: markerAmsterdam,
	  title: 'Amsterdam'.concat(', Port of Arrival')
	});
}