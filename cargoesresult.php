<?php
require_once('inc/config.php');
$_loadGoogleCharts = true;

//Initialize variables
$cargoOne = validate(urldecode($_GET['cargoOne']));
$cargoTwo = validate(urldecode($_GET['cargoTwo']));
$country = validate($_GET['country']);
$area = validate($_GET['area']);
$port = validate($_GET['port']);

$inputStartDate = validate($_GET['inputStartDate']);
$inputEndDate = validate($_GET['inputEndDate']);
	
$total = $cargoOne . $cargoTwo . $country . $area . $port . $inputStartDate . $inputEndDate;

// If all empty
if ($total == ""){
	header("Location: table_cargoes.php");
}

//$_loadGoogleMaps = true;
beginPage('Paalgeld Europa - Analyse', true, 'Analyse by comparing two cargoes');

if($country != ""){
	echo 'Country: '.$country.'';
}

if($area != ""){
	echo 'Area: '.$area.'';
}

if($port != ""){
	echo 'Port: '.$port.'';
}



//Cargo
if($cargoOne != "" && $cargoTwo != ""){
    $query = "SELECT year(date) AS year, sum(case when cargo = '".$cargoOne."' then taxGuilders end)*500 AS one, sum(case when cargo = '".$cargoTwo."' then taxGuilders end)*500 AS two FROM `paalgeldEur`, `ports`, `cargo`, `portAreas` WHERE paalgeldEur.idEur = cargo.idEur AND paalgeldEur.portCode = ports.portCode AND ports.areaCode = portAreas.areaCode";
}

//Country
if($country != ""){
    $query .= " AND ports.countryNow = '".$country."'";
}

//Area
if($area != ""){
    $query .= " AND portAreas.areaCode = '".$area."'";
}

//Port
if($port != ""){
    $query .= " AND ports.portCode = '".$port."'";
}


//Period
if($inputStartDate != "" && $inputEndDate != ""){
	$query .= " AND year(date) BETWEEN '".$inputStartDate."' AND '".$inputEndDate."'";
}elseif($inputStartDate != ""){
	$query .= " AND year(date) > '".$inputStartDate."'";
}elseif($inputEndDate != ""){
	$query .= " AND year(date) < '".$inputEndDate."'";
}


$query .= " GROUP BY year(date)";
$res = $_db->query($query);

if ($res == null or $res->num_rows == 0){
	echo "<div class='alert alert-danger' role='alert'>No results found. Try again.</div>";
}else{
  $data = array();
  $chartData = array(array('Year', $cargoOne, $cargoTwo));
	while($row = $res->fetch_assoc()){
    $chartData[] = array($row['year']*1, $row['one']*1, $row['two']*1);
    $data[] = $row;
	}
  $chartData = json_encode($chartData);
  ?>
  <script type="text/javascript">
  // Laad de visualization API
  google.load("visualization", "1", {packages:["corechart"]});
  // Teken als het is geladen
  google.setOnLoadCallback(drawCharts);
  function drawCharts(){
    // Zet de data om naar een DataTable
    var data = new google.visualization.arrayToDataTable(<?php echo $chartData ?>);
    // Maak een LineChart
    var chart = new google.visualization.LineChart(document.getElementById('chart'));
    // Teken de chart met de data en bepaalde opties
    chart.draw(data, {pointSize: 5, title: 'Result', hAxis: {title: 'Year', format:'#'},
        vAxis: {title: 'Value'}});
  }
  </script>
  <div id="chart" class="col-md-9" style="height:500px;"></div>
  <?php
  echo '<table class="table table-hover">';
  echo '<tr><th>Year</th><th>'.$cargoOne.'</th><th>'.$cargoTwo.'</th></tr>';
  foreach($data as $row){
    echo '<tr><td><a href="table_date.php?year='.$row['year'].'">'.$row['year'].'</a></td><td>'.(isset($row['one']) && $row['one'] >= 0 ? $row['one']*1 : 0).'</td><td>'.(isset($row['two']) && $row['two'] >= 0 ? $row['two']*1 : 0).'</td></tr>';
  }
  echo '</table>';
}

endPage();
?>
