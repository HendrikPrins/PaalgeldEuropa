<?php
require_once('inc/config.php');
$_loadGoogleCharts = true;

//Initialize variables
$countryOne = validate(urldecode($_GET['countryOne']));
$countryTwo = validate(urldecode($_GET['countryTwo']));
$areaOne = validate($_GET['areaOne']);
$areaTwo = validate($_GET['areaTwo']);
$portOne = validate($_GET['portOne']);
$portTwo = validate($_GET['portTwo']);

$cargo = validate($_GET['cargo']);
$inputStartDate = validate($_GET['inputStartDate']);
$inputEndDate = validate($_GET['inputEndDate']);
		
$total = $countryOne . $countryTwo . $areaOne . $areaTwo . $portOne . $portTwo . $cargo . $inputStartDate . $inputEndDate;

// If all empty
if ($total == ""){
	header("Location: table_ports.php");
}

//$_loadGoogleMaps = true;
beginPage('Paalgeld Europa - Analyse', true, 'Analyse by comparing two places');


if($cargo != ""){
	echo '<div class="row">Cargo <a href="table_cargoes.php?cargo='.$cargo.'">'.$cargo.'</a></div>';
}


//Country
if($countryOne != "" && $countryTwo != ""){
    $one = $countryOne;
    $two = $countryTwo;
    $query = "SELECT year(date) AS year, sum(case when countryNow = '".$countryOne."' then taxGuilders end)*500 AS one, sum(case when countryNow = '".$countryTwo."' then taxGuilders end)*500 AS two FROM `paalgeldEur`, `ports`, `cargo` WHERE paalgeldEur.idEur = cargo.idEur AND paalgeldEur.portCode = ports.portCode";
}

//Area
if($areaOne != "" && $areaTwo != ""){
    $one = $areaOne;
    $two = $areaTwo;
    $query = "SELECT year(date) AS year, sum(case when portAreas.areaCode = '".$areaOne."' then taxGuilders end)*500 AS one, sum(case when portAreas.areaCode = '".$areaTwo."' then taxGuilders end)*500 AS two FROM `paalgeldEur`, `ports`, `cargo`, `portAreas` WHERE paalgeldEur.idEur = cargo.idEur AND paalgeldEur.portCode = ports.portCode AND ports.areaCode = portAreas.areaCode";
	  $resNames = $_db->query("SELECT (SELECT area FROM portAreas WHERE areaCode = '".$areaOne."') AS nameOne, (SELECT area FROM portAreas WHERE areaCode = '".$areaTwo."') AS nameTwo");
    $names = $resNames->fetch_assoc();
    $one = $names['nameOne'];
    $two = $names['nameTwo'];
}

//Port
if($portOne != "" && $portTwo != ""){
    $query = "SELECT year(date) AS year, sum(case when portCode = '".$portOne."' then taxGuilders end)*500 AS one, sum(case when portCode = '".$portTwo."' then taxGuilders end)*500 AS two FROM `paalgeldEur`, `cargo` WHERE paalgeldEur.idEur = cargo.idEur";
    $resNames = $_db->query("SELECT (SELECT portName FROM ports WHERE portCode = '".$portOne."') AS nameOne, (SELECT portName FROM ports WHERE portCode = '".$portTwo."') AS nameTwo");
    $names = $resNames->fetch_assoc();
    $one = $names['nameOne'];
    $two = $names['nameTwo'];
}
//Cargo
if($cargo != ""){
    $query .= " AND cargo = '".$cargo."'";
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
  $chartData = array(array('Year', $one, $two));
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
	echo '<tr><th>Year</th><th>'.$one.'</th><th>'.$two.'</th></tr>';
	foreach($data as $row){
		echo '<tr><td><a href="table_date.php?year='.$row['year'].'">'.$row['year'].'</a></td><td>'.(isset($row['one']) && $row['one'] >= 0 ? $row['one']*1 : '-').'</td><td>'.(isset($row['two']) && $row['two'] >= 0 ? $row['two']*1 : '-').'</td></tr>';
	}
  echo '</table>';
}


endPage();
?>
