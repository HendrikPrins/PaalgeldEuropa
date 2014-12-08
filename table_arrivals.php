<?php
require('inc/config.php');
beginPage();

if(isset($_GET['id'])){
  // een bepaalde arrival met alle cargo
  $query = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND idEur = '".$_db->real_escape_string($_GET['id'])."'";
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
    echo 'Niets gevonden... div class=alert maken';
  }else{
    // details
    download_knop($query);
    echo '<table class="table">';
    $row = $res->fetch_assoc();
	$captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td>arrival id</td><td>'.$row['idEur'].'</td></tr>';
    echo '<tr><td>date</td><td>'.$row['date'].'</td></tr>';
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
        echo '<tr><td><a href="table_cargoes.php?cargo='.$row2['cargo'].'">'.$row2['cargo'].'</a></td><td>'.$row2['taxGuilders'].'</td></tr>';
      }
      echo '</table>';
    }
  }
}else{
  // Lijst van alle arrivals
  $page = isset($_GET['page']) ? $_GET['page']*1 : 0;
  $length = 25;
  $query = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode LIMIT ".($length*$page).", ".$length;
  $res = $_db->query($query);
  download_knop($query);

  echo '  <nav>';
  echo '  <ul class="pagination">';
  echo '    <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
  echo '    <li><a href="#">4</a></li>';
  echo '    <li><a href="#">5</a></li>';
  echo '    <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
  echo '  </ul>';
  echo '</nav>';
  echo '<table class="table table-hover">';
  echo '<tr><th>arrival id</th><th>date</th><th>captain</th><th>port of origin</th></tr>';
  while($row = $res->fetch_assoc()){
    $captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td>'.$row['date'].'</td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
  }
  echo '</table>';
}
endPage();
?>
