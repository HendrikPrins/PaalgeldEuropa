<?php
require('inc/config.php');
$_loadGoogleMaps = true;
$_loadGoogleCharts = true;
beginPage('Paalgeld Europa - Complete tables', true, 'The complete cargoes table');

if(isset($_GET['cargo'])){
  include_once('inc/module_tablesort.php');
  $cargo = str_replace('_', ' ', $_db->real_escape_string($_GET['cargo']));
  $queryBase = "SELECT * FROM cargo, paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND cargo.idEur = paalgeldEur.idEur AND cargo = '".$cargo."'";
  $queryBase .= queryOrderPart(array('paalgeldEur.idEur','date','fullNameCaptain','portName'), 'date');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(*) AS count FROM cargo, paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND cargo.idEur = paalgeldEur.idEur AND cargo = '".$_db->real_escape_string($_GET['cargo'])."'");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  $pagination = pagination($page, $size, $totalCount);
  echo 'Arrivals met cargo <a href="table_cargoes.php?cargo='.$_GET['cargo'].'">'.$cargo.'</a><br>';
  // alle arrivals met een bepaalde cargo
  //$query = "SELECT * FROM cargo, paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND cargo.idEur = paalgeldEur.idEur AND cargo = '".$_db->real_escape_string($_GET['cargo'])."'";
  $res = $_db->query($queryLimited);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert">No arrivals with cargo <strong>'.$cargo.'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>';
  }else{
    include_once('inc/module_map.php');
    echo '<div class="row">';
    makeGoogleMapsQuery("SELECT COUNT(*) AS cargoCount, lat, lng, portName, ports.portCode AS pCode FROM ports, paalgeldEur, cargo WHERE paalgeldEur.idEur = cargo.idEur AND paalgeldEur.portCode = ports.portCode AND cargo.cargo = '".$_db->real_escape_string($cargo)."' GROUP BY ports.portCode", 'cargoCount', $cargo);
    // Activity chart
    $activityChart = array(array('Year', 'Arrivals'));
    $resActivity = $_db->query("SELECT YEAR(date) AS `year`, COUNT(*) AS arrivalCount FROM paalgeldEur, cargo WHERE paalgeldEur.idEur = cargo.idEur AND cargo.cargo = '".$_db->real_escape_string($cargo)."' GROUP BY `year` ORDER BY `year` ASC");
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
      chart.draw(data, {pointSize: 5, title: 'Activity for <?php echo $_GET['cargo']; ?>', hAxis: {title: 'Year', format:'#'},
          vAxis: {title: 'Arrivals'}});
    }
    </script>
    <!-- De div waar de chart in komt -->
    <div id="activityChart" class="col-md-6" style="height:400px;"></div>
    <?php
    echo '</div>';
    echo $pagination;
    download_knop($queryBase);
    echo '<table class="table table-hover">';
    echo '<tr><th>'.sortableHead('Arrival id', 'paalgeldEur.idEur').'</th><th>'.sortableHead('Date', 'date').'</th><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Port Of Origin', 'portName').'</th></tr>';
    while($row = $res->fetch_assoc()){
      $year = substr($row['date'], 0, -6);	
	  $month = substr($row['date'], 5, -3);
	  $day = substr($row['date'], 8);
	  $captain = str_replace(' ', '_', $row['fullNameCaptain']);
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
    }
    echo '</table>';
  }
}else{
  // tabel met unieke cargo
  include_once('inc/module_tablesort.php');
  $queryBase = "SELECT cargo, COUNT(*) AS count FROM cargo GROUP BY cargo";
  $queryBase .= queryOrderPart(array('cargo','count'), 'count', 'desc');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(DISTINCT cargo) AS count FROM cargo");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  download_knop($queryBase);
  $pagination = pagination($page, $size, $totalCount);
  echo $pagination;
  echo '<table class="table table-hover">';
  echo '<tr><th>'.sortableHead('Cargo', 'cargo').'</th><th>'.sortableHead('Count', 'count').'</th></tr>';
  while($row = $res->fetch_assoc()){
    $cargo = str_replace(' ', '_', $row['cargo']);
    echo '<tr><td><a href="table_cargoes.php?cargo='.$cargo.'">'.$row['cargo'].'</a></td><td>'.$row['count'].'</td></tr>';
  }
  echo '</table>';
  echo $pagination;
}

endPage();
?>