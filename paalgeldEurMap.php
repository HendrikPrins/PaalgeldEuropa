<!DOCTYPE html>
<html>
  <head>
  
    <!-- Temporary style commands for display purposes -->
    <link href="paalgeldStyle.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHmhz1TT9nJ1RH0OlptIxXDiu8THJ7vWI">
    </script>
    <?php
		  // start query (for now via click on button)
		  if (isset($_POST["query"]) && $_POST["query"] == 1) {
			// Set query attributes
			$title = 'year(date)';
			$selection = 'cargo';
			$value = 'sum(taxGuilders)';
			// Set limitation of query result
			$limitations = '
			  year(date) = "1787" and
			  cargo = "hout"
			  group by portName';

			// Assemble full query command
			$query = 'SELECT '.
			  $title.', '.
			  $selection.', '.
			  $value.',
			  portName,
			  lat,
			  lng
			  FROM paalgeld
			  WHERE '.$limitations;

			// Get query result and store in variable
			$geoQuery = geoQuery($query);
			}

		  // retrieval from mySQL
		  function geoQuery($query) {
			$con = mysqli_connect('localhost',
						  'f111433','mi3ahch3ei','f111433');
			if (!$con) {
			  die('Could not connect to MySQL: ' . mysqli_error());
			  }
			echo 'Connection to paalgeld OK <br>';
			echo 'Your SQL-query is: <br>';
			echo $query;
			$result = mysqli_query($con,$query);
			// create return array
			$i = 0;
			while($row = mysqli_fetch_array($result)) {
			  $titleA[$i] = $row['year(date)'];
			  $selectionA[$i] = $row['cargo'];
			  $valueA[$i] = $row['sum(taxGuilders)'];
			  $portNameA[$i] = $row['portName'];
			  $latA[$i] = $row['lat'];
			  $lngA[$i] = $row['lng'];
			  $queryList[$i] = array($titleA[$i],$selectionA[$i],$valueA[$i],
				$portNameA[$i],$latA[$i],$lngA[$i]);
			  $i++;
			}
			mysqli_close($con);
  			return $queryList;
			}
		?>
        
        <?php
		  echo '<p>';
          echo 'Display the first 5 arrays in $geoQuery array:<br>';
          echo 'Query result is: <br><br>';
      if(isset($geoQuery)){
        $arrlength = count($geoQuery);
        for($i=0; $i < $arrlength; $i++) {
            echo $geoQuery[$i][0].',   ';
            echo $geoQuery[$i][1].',   ';
            echo $geoQuery[$i][2].',   ';
            echo $geoQuery[$i][3].',   ';
            echo $geoQuery[$i][4].',   ';
            echo $geoQuery[$i][5].'<br>';
            }
		  }
		  echo '</p>';
        ?>

        
    <script type="text/javascript">
	  // Define the position of Amsterdam.
	  var lat = 52.373055;
	  var lng = 4.899722;
	  var amsterdam = new google.maps.LatLng(lat,lng);
	  
	  // Import the table/array that holds the query results.
	  //var table = \<\?//=json_encode($geoQuery); \?\>;

//	  /*
	  // voorbeeld array
    <?php
      if(isset($geoQuery)){
        $ports = array();
        $arrlength = count($geoQuery);
        for($i=0; $i < $arrlength; $i++) {
          $ports[]= '['.$geoQuery[$i][0].', "'.
						$geoQuery[$i][1].'", '.
						$geoQuery[$i][2].', "'.
						$geoQuery[$i][3].'", '.
						$geoQuery[$i][4].', '.
						$geoQuery[$i][5].']';
						}
        echo 'var table = Array('.implode(',', $ports).');';
      }
     ?>
//	  */

	  // Define a port object for each port in the table/array
	  var portOfOrigin = {};	  
	  for (i in table) {
		var geoTag =  new google.maps.LatLng(table[i][4], table[i][5]);
		portOfOrigin[table[i][3]] = {
			cargo: table[i][1],
			waarde: table[i][2],
			title: table[i][3],
			center: geoTag };
	  }
	  
	  function initialize() {
		// Create the map.
		var mapOptions = {
		  zoom: 4,
		  center: amsterdam,
		  mapTypeId: google.maps.MapTypeId.TERRAIN };
		var map = new google.maps.Map(document.getElementById('map-canvas'),
			mapOptions);
	  
		// Construct the circle for each value in origin.
		// The area of the circle is based on the portOfOrigin[port].waarde.
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
		  // Add the "waarde"circle for this port to the map.
		  waardeCircle = new google.maps.Circle(waardeOptions);
		}

		// Construct a line from Amsterdam to the port of origin.
		var myMarker = "http://siegfried.webhosting.rug.nl/~shipping/paalgeld_weu/img/info.png";
		for (var port in portOfOrigin) {
		  var track = [amsterdam,portOfOrigin[port].center];
		  var showTrack = new google.maps.Polyline({
			  path: track,
			  //geodesic: true,
			  //title: 'trackExample',
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
		  icon: myMarker,
		  title: 'Amsterdam'.concat(', Port of Arrival')
		  });
//	  }
	  
	  // Load the page.
     google.maps.event.addDomListener(window, 'load', initialize);
}
    </script>
    
  </head>
  <body>

      <p>
        <form  method="post" enctype="multipart/form-data"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <input type="hidden" value="1" name="query">
          <input type='submit' name='' value='GetQuery'>
        </form>
      </p>  








        <div id="map-canvas">
        <button type='button' onclick='initialize();'>Map</button>
        </div>


  </body>
</html>