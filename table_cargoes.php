<?php
require('inc/config.php');
beginPage();

if(isset($_GET['cargo'])){
  // alle arrivals met een bepaalde cargo
  $res = $_db->query("SELECT * FROM paalgeld_cargoes, paalgeld_arrivals WHERE paalgeld_cargoes.id_number = paalgeld_arrivals.id_number AND cargo = '".$_db->real_escape_string($_GET['cargo'])."'");
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning">Er zijn geen arrivels met cargo '.$_GET['cargo'].' gevonden.</div>';
  }else{
    echo 'Arrivals met cargo <a href="table_cargoes.php?cargo='.$_GET['cargo'].'">'.$_GET['cargo'].'</a>';
    echo '<table class="table table-hover">';
    echo '<tr><th>arrival id</th><th>date</th><th>captain</th><th>port of origin</th></tr>';
    while($row = $res->fetch_assoc()){
      echo '<tr><td><a href="table_arrivals.php?id='.$row['id_number'].'">'.$row['id_number'].'</a></td><td>'.$row['date'].'</td><td>'.$row['full_name'].'</td><td>'.$row['port_of_origin'].'</td></tr>';
    }
    echo '</table>';
  }
}else{
  // tabel met unieke cargo
  $res = $_db->query("SELECT cargo, COUNT(*) AS count FROM paalgeld_cargoes GROUP BY cargo ORDER BY count DESC");
  echo '<table class="table table-hover">';
    echo '<tr><th>cargo</th><th>count</th></tr>';
  while($row = $res->fetch_assoc()){
    echo '<tr><td><a href="table_cargoes.php?cargo='.$row['cargo'].'">'.$row['cargo'].'</a></td><td>'.$row['count'].'</td></tr>';
  }
  echo '</table>';
}

endPage();
?>