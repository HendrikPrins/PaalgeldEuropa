<?php
require('inc/config.php');
beginPage('Paalgeld Europa - Complete tables', true, 'The complete arrivals table');

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
    echo '<tr><td>Arrival id</td><td>'.$row['idEur'].'</td></tr>';
    echo '<tr><td>Date</td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td></tr>';
    echo '<tr><td>Full name captain</td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td></tr>';
    echo '<tr><td>Port of departure</td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
    echo '</table>';

    // de cargoes
    $query = "SELECT * FROM cargo WHERE idEur = '".$_db->real_escape_string($_GET['id'])."'";
    $res2 = $_db->query($query);
    if($res2 != null && $res2->num_rows > 0){
      download_knop($query);
      echo '<b>Cargoes</b>';
      echo '<table class="table table-hover">';
      echo '<tr><th>Cargo</th><th>Value</th></tr>';
      while($row2 = $res2->fetch_assoc()){
        $cargo = str_replace(' ', '_', $row2['cargo']);
        echo '<tr><td><a href="table_cargoes.php?cargo='.$cargo.'">'.$row2['cargo'].'</a></td><td>'.($row2['taxGuilders']*500).'</td></tr>';
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
    echo '<br><div class="row explan"><div class="col-md-12"><div class="panel panel-primary">
  <div class="panel-heading"><h3 class="panel-title">Explanation</h3></div><div class="panel-body">This table shows the dates of arrival in combination of the name of the captain and the port of origin.
Clicking the name of a captain gives an overview of the cargoes this particular captain shipped, the dates of arrival in Amsterdam and port of departure of every single shipping. Clicking on the name of a port supplies information about the cargoes shipped from this port and the shippings from this port with captain name and arrival date. It also shows a chart with the shippings over time.
  </div>
  </div>
  </div>
  </div>';

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