<?php
require('inc/config.php');
beginPage();

if(isset($_GET['id'])){
  // een bepaalde arrival met alle cargo
  $query = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND idEur = '".$_db->real_escape_string($_GET['id'])."'";
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert">No arrivals with arrival id <strong>'.$_GET['id'].'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>';
  }else{
    // details
    download_knop($query);
    echo '<table class="table">';
    $row = $res->fetch_assoc();
	$year = substr($row['date'], 0, -6);	
	$month = substr($row['date'], 5, -3);
	$day = substr($row['date'], 8);
	$captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td>arrival id</td><td>'.$row['idEur'].'</td></tr>';
    echo '<tr><td>date</td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td></tr>';
    echo '<tr><td>fullNameCaptain</td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td></tr>';
    echo '<tr><td>departurePort</td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
    echo '</table>';

    // de cargoes
    $query = "SELECT * FROM cargo WHERE idEur = '".$_db->real_escape_string($_GET['id'])."'";
    $res2 = $_db->query($query);
    if($res2 != null && $res2->num_rows > 0){
      download_knop($query);
      echo '<b>Cargoes</b>';
      echo '<table class="table table-hover">';
      echo '<tr><th>cargo</th><th>tax</th></tr>';
      while($row2 = $res2->fetch_assoc()){
        echo '<tr><td><a href="table_cargoes.php?cargo='.$row2['cargo'].'">'.$row2['cargo'].'</a></td><td>'.($row2['taxGuilders']*500).'</td></tr>';
      }
      echo '</table>';
    }
  }
}else{
  // Lijst van alle arrivals
  include_once('inc/module_tablesort.php');
  // Een aantal variabelen berekenen voor de pagination
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(*) AS count FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];

  $queryBase = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode";
  $queryBase .= queryOrderPart(array('idEur','date','fullNameCaptain','portName'), 'idEur');
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  download_knop($queryBase);

  $pagination = pagination($page, $size, $totalCount);
  echo $pagination;
  echo '<table class="table table-hover">';
  echo '<tr><th>'.sortableHead('Arrival id', 'idEur').'</th><th>'.sortableHead('Date', 'date').'</th><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Port Of Origin', 'portName').'</th></tr>';
  while($row = $res->fetch_assoc()){
    $year = substr($row['date'], 0, -6);	
	$month = substr($row['date'], 5, -3);
	$day = substr($row['date'], 8);
    $captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
  }
  echo '</table>';
  echo $pagination;
}
endPage();
?>