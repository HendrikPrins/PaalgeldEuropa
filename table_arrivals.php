<?php
require('inc/config.php');
beginPage();

if(isset($_GET['id'])){
  // een bepaalde arrival met alle cargo
  $res = $_db->query("SELECT * FROM paalgeldEur, ports WHERE paalgeldeur.portCode = ports.portCode AND idEur = '".$_db->real_escape_string($_GET['id'])."'");
  if($res == null || $res->num_rows == 0){
    echo 'Niets gevonden... div class=alert maken';
  }else{
    // details
    echo '<table class="table">';
    $row = $res->fetch_assoc();
	$captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td>arrival id</td><td>'.$row['idEur'].'</td></tr>';
    echo '<tr><td>date</td><td>'.$row['date'].'</td></tr>';
    echo '<tr><td>fullNameCaptain</td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td></tr>';
    echo '<tr><td>departurePort</td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
    echo '</table>';

    // de cargoes
    $res2 = $_db->query("SELECT * FROM cargo WHERE idEur = '".$_db->real_escape_string($_GET['id'])."'");
    if($res2 != null && $res2->num_rows > 0){
      echo '<b>Cargoes</b>';
      echo '<table class="table table-hover">';
      echo '<tr><th>cargo</th><th>quantity</th></tr>';
      while($row2 = $res2->fetch_assoc()){
        echo '<tr><td><a href="table_cargoes.php?cargo='.$row2['cargo'].'">'.$row2['cargo'].'</a></td><td>'.$row2['quantity'].'</td></tr>';
      }
      echo '</table>';
    }
  }
}else{
  // Lijst van alle arrivals
  $res = $_db->query("SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode");
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