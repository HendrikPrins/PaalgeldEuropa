<?php
require('inc/config.php');
$_loadGoogleCharts = true;
$_loadGoogleMaps = true;
beginPage('Paalgeld Europa - Complete tables', true, 'The complete ports table');

if(isset($_GET['area'])){
  // alle ports in bepaalde area
  $query = "SELECT * FROM ports, portAreas WHERE ports.areaCode = portAreas.areaCode AND portAreas.area = '".$_db->real_escape_string($_GET['area'])."' AND ports.arrivalCount > 0";
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert">No ports with area code <strong>'.$_GET['area'].'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>';
  }else{
	echo 'Ports in <a href="table_ports.php?area='.$_GET['area'].'">'.$_GET['area'].'</a>';
  download_knop($query);
    echo '<table class="table table-hover">';
    echo '<tr><th>Port code</th><th>Port</th><th>Area</th><th>Country now</th></tr>';
    while($row = $res->fetch_assoc()){
      echo '<tr><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portCode'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td><td><a href="table_ports.php?area='.$row['area'].'">'.$row['area'].'</a></td><td>'.$row['countriesNow'].'</td></tr>';
    }
    echo '</table>';
  }
}elseif(isset($_GET['portCode'])){
  $query = "SELECT *, Count(paalgeldEur.idEur) AS arrivals, (SELECT GROUP_CONCAT(cargo SEPARATOR ', ') AS cargoString FROM (SELECT cargo FROM cargo, paalgeldEur AS pe WHERE pe.portCode = '".$_db->real_escape_string($_GET['portCode'])."' AND pe.idEur = cargo.idEur GROUP BY cargo) AS sub) AS cargoString FROM ports, portAreas, paalgeldEur WHERE ports.areaCode = portAreas.areaCode AND ports.portCode = paalgeldEur.portCode AND ports.portCode = '".$_db->real_escape_string($_GET['portCode'])."'";
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
     echo '<div class="alert alert-warning">error '.$_db->error.'.</div>';
  }else{
    // details
    download_knop($query);
    echo '<table class="table">';
    $row = $res->fetch_assoc();
    echo '<tr><td>Port code</td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portCode'].'</a></td></tr>';
    echo '<tr><td>Port</td><td>'.$row['portName'].'</td></tr>';
    echo '<tr><td>Area</td><td><a href="table_ports.php?area='.$row['area'].'">'.$row['area'].'</a></td></tr>';
    echo '<tr><td>Country now</td><td>'.$row['countriesNow'].'</td></tr>';
    echo '<tr><td>Arrivals</td><td>'.$row['arrivals'].'</td></tr>';
    echo '<tr><td>Cargoes</td><td>'.$row['cargoString'].'</td></tr>';
    echo '</table>';
    // Activity chart
    $activityChart = array(array('Year', 'Arrivals'));
    $resActivity = $_db->query("SELECT YEAR(date) AS `year`, COUNT(*) AS arrivalCount FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND ports.portCode = '".$_db->real_escape_string($_GET['portCode'])."' GROUP BY `year` ORDER BY `year` ASC");
    while($rowActivity = $resActivity->fetch_assoc()){
        $activityChart[] = array($rowActivity['year']*1, $rowActivity['arrivalCount']*1);
    }
    $activityChart = json_encode($activityChart);
    ?>
    <script type="text/javascript">
    // Laad de visualization API
    google.load("visualization", "1", {packages:["corechart"]});
    // Teken als het is geladen
    google.setOnLoadCallback(drawCharts);
    function drawCharts(){
      // Zet de data om naar een DataTable
      var data = new google.visualization.arrayToDataTable(<?php echo $activityChart ?>);
      // Maak een LineChart
      var chart = new google.visualization.LineChart(document.getElementById('activityChart'));
      // Teken de chart met de data en bepaalde opties
      chart.draw(data, {pointSize: 5, title: 'Activity for <?php echo $row['portName']; ?>', hAxis: {title: 'Year', format:'#'},
          vAxis: {title: 'Arrivals'}});
    }
    </script>
    <!-- De div waar de chart in komt -->
    <div class="row">
    <?php
    include_once("inc/module_map.php");
    makeGoogleMapsQuery("SELECT arrivalCount, portCode, lat, lng, portName FROM ports where portCode='".$_GET['portCode']."'", 'arrivalCount', 'Departures');
    ?>
        <div id="activityChart" class="col-md-6" style="height:400px;"></div>
    </div>
    <?php


    // arrivals
    include_once('inc/module_tablesort.php');
    include_once('inc/module_pagination.php');
    $resCount = $_db->query("SELECT COUNT(*) AS count FROM paalgeldEur WHERE portCode = '".$_db->real_escape_string($_GET['portCode'])."'");
    $rowCount = $resCount->fetch_assoc();
    $totalCount = $rowCount['count'];
    if($totalCount > 0){
      $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
      $size = 25;
      $offset = $page * $size;
      $queryBase = "SELECT *, (SELECT COUNT(*) FROM cargo WHERE paalgeldEur.idEur = cargo.idEur) AS cargoCount FROM paalgeldEur WHERE paalgeldEur.portCode = '".$_db->real_escape_string($_GET['portCode'])."'";
      $queryBase .= queryOrderPart(array('idEur','date','fullNameCaptain','cargoCount'), 'idEur');
      $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
      $res2 = $_db->query($queryLimited);
      if($res2 == null){
        echo 'db error '.$_db->error;
      }else{
        download_knop($queryBase);
        echo '<b>Arrivals</b>';
        $pagination = pagination($page, $size, $totalCount);
        echo $pagination;
        echo '<table class="table table-hover">';
        echo '<tr><th>'.sortableHead('Arrival id', 'idEur').'</th><th>'.sortableHead('Date', 'date').'</th><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Cargo Count', 'cargoCount').'</th></tr>';
        while($row2 = $res2->fetch_assoc()){
		  $year = substr($row['date'], 0, -6);	
		  $month = substr($row['date'], 5, -3);
	      $day = substr($row['date'], 8);
          $captain = str_replace(' ', '_', $row2['fullNameCaptain']);
          echo '<tr><td><a href="table_arrivals.php?id='.$row2['idEur'].'">'.$row2['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td><a href="table_captains.php?id='.$captain.'">'.$row2['fullNameCaptain'].'</a></td><td>'.$row2['cargoCount'].'</td></tr>';
        }
        echo '</table>';
        echo $pagination;
      }
    }

    }

}else{
  // tabel met alle ports
  include_once('inc/module_tablesort.php');
  $queryBase = "SELECT * FROM ports, portAreas WHERE ports.areaCode = portAreas.areaCode AND ports.arrivalCount > 0";
  $queryBase .= queryOrderPart(array('portCode','portName', 'area', 'countriesNow'), 'portName');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(*) AS count FROM ports, portAreas WHERE ports.areaCode = portAreas.areaCode AND ports.arrivalCount > 0");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  download_knop($queryBase);

  $pagination = pagination($page, $size, $totalCount);
  echo $pagination;
  echo '<table class="table table-hover">';
  echo '<tr><th>'.sortableHead('Port Code', 'portCode').'</th><th>'.sortableHead('Port', 'portName').'</th><th>'.sortableHead('Area', 'area').'</th><th>'.sortableHead('Country now', 'countriesNow').'</th></tr>';
  while($row = $res->fetch_assoc()){
    echo '<tr><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portCode'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td><td><a href="table_ports.php?area='.$row['area'].'">'.$row['area'].'</a></td><td>'.$row['countriesNow'].'</td></tr>';
  }
  echo '</table>';
  echo $pagination;
}

endPage();
?>

