<?php
require('inc/config.php');
$_loadGoogleMaps = true;
$_loadGoogleCharts = true;
beginPage();

if(isset($_GET['id'])){
  $captain = str_replace('_', ' ', $_db->real_escape_string($_GET['id']));
  $resDetail = $_db->query("SELECT *, (SELECT GROUP_CONCAT(cargo SEPARATOR ', ') AS cargoString FROM (SELECT cargo FROM cargo, paalgeldEur AS pe WHERE pe.fullNameCaptain = '".$captain."' AND pe.idEur = cargo.idEur GROUP BY cargo) AS sub) AS cargoString FROM paalgeldEur WHERE fullNameCaptain = '".$captain."' LIMIT 1");
  if($resDetail == null || $resDetail->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert"No captain names with name <strong>'.$_GET['id'].'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>';
  }else{
    // details
	echo '<table class="table">';
    $rowDetail = $resDetail->fetch_assoc();
    $captain = str_replace(' ', '_', $rowDetail['fullNameCaptain']);
    echo '<tr><td>Full name</td><td><a href="table_captains.php?id='.$captain.'">'.$rowDetail['fullNameCaptain'].'</a></td></tr>';
    echo '<tr><td>First name</td><td>'.$rowDetail['firstNameCaptain'].'</td></tr>';
    echo '<tr><td>Last name</td><td>'.$rowDetail['lastNameCaptain'].'</td></tr>';
    echo '<tr><td>Unique cargoes</td><td>'.$rowDetail['cargoString'].'</td></tr>';
    echo '</table>';

    $query = "SELECT idEur, date, fullNameCaptain, firstNameCaptain, lastNameCaptain, portName, ports.portCode AS pCode, lat, lng FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND fullNameCaptain = '".$rowDetail['fullNameCaptain']."'";
    include_once('inc/module_map.php');
    echo '<div class="row">';
    // In de kaart willen we alleen unieke ports, dus nog een group by pCode en tellen
    makeGoogleMapsQuery("SELECT COUNT(*) AS portCount, sub.* FROM (".$query.") AS sub GROUP BY pCode", 'portCount', 'pCode');
    // Activity chart
    $activityChart = array(array('Year', 'Arrivals'));
    $resActivity = $_db->query("SELECT YEAR(date) AS `year`, COUNT(*) AS arrivalCount FROM paalgeldEur WHERE fullNameCaptain = '".$rowDetail['fullNameCaptain']."' GROUP BY `year` ORDER BY `year` ASC");
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
      chart.draw(data, {pointSize: 5, title: 'Activity for <?php echo $rowDetail['fullNameCaptain']; ?>', hAxis: {title: 'Year', format:'#'},
          vAxis: {title: 'Arrivals'}});
    }
    </script>
    <!-- De div waar de chart in komt -->
    <div id="activityChart" class="col-md-6" style="height:400px;"></div>
    <?php
    echo '</div>';
    // de arrivals
    download_knop($query);
    echo '<b>Arrivals</b>';
    echo '<table class="table table-hover">';
    echo '<tr><th>Arrival id</th><th>Date</th><th>Full name</th><th>Port of departure</th></tr>';
    $res = $_db->query($query);
    while($row = $res->fetch_assoc()){
        $year = substr($row['date'], 0, -6);
        $month = substr($row['date'], 5, -3);
        $day = substr($row['date'], 8);
        echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td>'.$row['fullNameCaptain'].'</td><td><a href="table_ports.php?portCode='.$row['pCode'].'">'.$row['portName'].'</a></td></tr>';
    }
    echo '</table>';
  }
 
}else{
  // Lijst van alle unieke captains
  include_once('inc/module_tablesort.php');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(DISTINCT fullNameCaptain) AS count FROM paalgeldEur");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryBase = "SELECT *, COUNT(fullNameCaptain) AS count FROM paalgeldEur GROUP BY fullNameCaptain";
  $queryBase .= queryOrderPart(array('fullNameCaptain','count'), 'count', 'desc');
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  download_knop($queryBase);
  $pagination = pagination($page, $size, $totalCount);
  echo $pagination;
  echo '<table class="table table-hover">';
  echo '<tr><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Amount of shippings', 'count').'</th></tr>';
  while($row = $res->fetch_assoc()){
    $captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td>'.$row['count'].'</td></tr>';
  }
  echo '</table>';
  echo $pagination;
}
endPage();
?>

