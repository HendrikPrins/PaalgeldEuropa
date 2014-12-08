<?php
require('inc/config.php');
beginPage();

if(isset($_GET['cargo'])){
  // alle arrivals met een bepaalde cargo
  $res = $_db->query("SELECT * FROM cargo, paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND cargo.idEur = paalgeldEur.idEur AND cargo = '".$_db->real_escape_string($_GET['cargo'])."'");
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning">Er zijn geen arrivels met cargo '.$_GET['cargo'].' gevonden. Foutmelding: '.$_db->error.'</div>';
  }else{
    echo 'Arrivals met cargo <a href="table_cargoes.php?cargo='.$_GET['cargo'].'">'.$_GET['cargo'].'</a>';
    echo '<table class="table table-hover">';
    echo '<tr><th>arrival id</th><th>date</th><th>captain</th><th>port of origin</th></tr>';
    while($row = $res->fetch_assoc()){
	  $captain = str_replace(' ', '_', $row['fullNameCaptain']);
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td>'.$row['date'].'</td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
    }
    echo '</table>';
  }
}else{
  // tabel met unieke cargo
  $res = $_db->query("SELECT cargo, COUNT(*) AS count FROM cargo GROUP BY cargo ORDER BY count DESC");
  echo '<table class="table table-hover">';
    echo '<tr><th>cargo</th><th>count</th></tr>';
  while($row = $res->fetch_assoc()){
    echo '<tr><td><a href="table_cargoes.php?cargo='.$row['cargo'].'">'.$row['cargo'].'</a></td><td>'.$row['count'].'</td></tr>';
  }
  echo '</table>';
}

endPage();
?>