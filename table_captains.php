<?php
require('inc/config.php');
$_loadGoogleMaps = true;
beginPage();

if(isset($_GET['id'])){
  $captain = str_replace('_', ' ', $_db->real_escape_string($_GET['id']));
  $resDetail = $_db->query("SELECT * FROM paalgeldEur WHERE fullNameCaptain = '".$captain."' LIMIT 1");
  if($resDetail == null || $resDetail->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert"><strong>Error.</strong> No captain names with name <strong>'.$_GET['id'].'</strong> found. <a class="alert-link" href="#" onclick="history.go(-1)">Go Back</a><br>Error code: '.$_db->error.'</div>';
  }else{
    // details
	echo '<table class="table">';
    $rowDetail = $resDetail->fetch_assoc();
    $captain = str_replace(' ', '_', $rowDetail['fullNameCaptain']);
    echo '<tr><td>Full name</td><td><a href="table_captains.php?id='.$captain.'">'.$rowDetail['fullNameCaptain'].'</a></td></tr>';
    echo '<tr><td>First name</td><td>'.$rowDetail['firstNameCaptain'].'</td></tr>';
    echo '<tr><td>Last Name</td><td>'.$rowDetail['lastNameCaptain'].'</td></tr>';
    echo '</table>';

    $query = "SELECT idEur, date, fullNameCaptain, firstNameCaptain, lastNameCaptain, portName, ports.portCode AS pCode, lat, lng FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND fullNameCaptain = '".$rowDetail['fullNameCaptain']."'";
    include_once('inc/module_map.php');
    // In de kaart willen we alleen unieke ports, dus nog een group by pCode en tellen
    makeGoogleMapsQuery("SELECT COUNT(*) AS portCount, sub.* FROM (".$query.") AS sub GROUP BY pCode", 'portCount', 'pCode');
    // de arrivals
    download_knop($query);
    echo '<b>Arrivals</b>';
    echo '<table class="table table-hover">';
    echo '<tr><th>Arrival id</th><th>Date</th><th>Full name</th><th>Departure port</th></tr>';
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
  echo '<tr><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Arrivals', 'count').'</th></tr>';
  while($row = $res->fetch_assoc()){
    $captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td>'.$row['count'].'</td></tr>';
  }
  echo '</table>';
  echo $pagination;
}
endPage();
?>

