<?php
require('inc/config.php');
beginPage();

if(isset($_GET['cargo'])){
  // alle arrivals met een bepaalde cargo
  $res = $_db->query("SELECT * FROM cargo, paalgeldEur WHERE cargo.idEur = paalgeldEur.idEur AND cargo = '".$_db->real_escape_string($_GET['cargo'])."'");
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning">Er zijn geen arrivels met cargo '.$_GET['cargo'].' gevonden.</div>';
  }else{
    echo 'Arrivals met cargo <a href="table_cargoes.php?cargo='.$_GET['cargo'].'">'.$_GET['cargo'].'</a>';
    echo '<table class="table table-hover">';
    echo '<tr><th>arrival id</th><th>date</th><th>captain</th><th>port of origin</th></tr>';
    while($row = $res->fetch_assoc()){
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td>'.$row['date'].'</td><td>'.$row['fullNameCaptain'].'</td><td>'.$row['departurePort'].'</td></tr>';
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