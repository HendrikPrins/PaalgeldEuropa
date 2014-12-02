<?php
require('inc/config.php');
beginPage();

if(isset($_GET['id'])){
  // een bepaalde arrival met alle cargo
  $res = $_db->query("SELECT * FROM paalgeld_arrivals WHERE id_number = '".$_db->real_escape_string($_GET['id'])."'");
  if($res == null || $res->num_rows == 0){
    echo 'Niets gevonden... div class=alert maken';
  }else{
    // details
    echo '<table class="table">';
    $row = $res->fetch_assoc();
    echo '<tr><td>arrival id</td><td>'.$row['id_number'].'</td></tr>';
    echo '<tr><td>date</td><td>'.$row['date'].'</td></tr>';
    echo '<tr><td>captain</td><td>'.$row['full_name'].'</td></tr>';
    echo '<tr><td>port_of_origin</td><td>'.$row['port_of_origin'].'</td></tr>';
    echo '</table>';

    // de cargoes
    $res2 = $_db->query("SELECT * FROM paalgeld_cargoes WHERE id_number = '".$_db->real_escape_string($_GET['id'])."'");
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
  $res = $_db->query("SELECT * FROM paalgeld_arrivals");
  echo '<table class="table table-hover">';
  echo '<tr><th>arrival id</th><th>date</th><th>captain</th><th>port of origin</th></tr>';
  while($row = $res->fetch_assoc()){
    echo '<tr><td><a href="table_arrivals.php?id='.$row['id_number'].'">'.$row['id_number'].'</a></td><td>'.$row['date'].'</td><td>'.$row['full_name'].'</td><td>'.$row['port_of_origin'].'</td></tr>';
  }
  echo '</table>';
}
endPage();
?>