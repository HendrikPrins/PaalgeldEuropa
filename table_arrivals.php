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
  $offset = $page * $length;
  $queryBase = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode";
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$length;
  $resCount = $_db->query("SELECT COUNT(*) AS count FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode");
  $res = $_db->query($queryLimited);
  download_knop($queryBase);
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];


  $pageLink = $_SERVER['PHP_SELF'];
  $get = $_GET;
  echo '<nav>';
  echo $length.' / '.$totalCount.'<br>';
  echo '  <ul class="pagination">';
  // Terug knop
  if($offset > 0){
    $get['page'] = $page-1;
    echo '    <li><a href="'.$pageLink.'?'.http_build_query($get).'"><span aria-hidden="true">&laquo;</span><span class="sr-only">Vorige</span></a></li>';
  }else{
    echo '    <li class="disabled"><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Vorige</span></a></li>';
  }
  // twee terug
  if($page > 1){
    $get['page'] = $page-2;
    echo '    <li><a href="'.$pageLink.'?'.http_build_query($get).'">'.$get['page'].'</a></li>';
  }
  // een terug
  if($page > 0){
    $get['page'] = $page-1;
    echo '    <li><a href="'.$pageLink.'?'.http_build_query($get).'">'.$get['page'].'</a></li>';
  }
  // huidige
  echo '    <li class="active"><a href="#">'.$page.'</a></li>';
  if($offset+$length*2 < $totalCount){
    $get['page'] = $page+1;
    echo '    <li><a href="'.$pageLink.'?'.http_build_query($get).'">'.$get['page'].'</a></li>';
    $get['page'] = $page+2;
    echo '    <li><a href="'.$pageLink.'?'.http_build_query($get).'">'.$get['page'].'</a></li>';
    // Geen knop een terug, dus ruimte voor extra vooruit
    if($page - 1 < 0){
      $get['page'] = $page+3;
      echo '    <li><a href="'.$pageLink.'?'.http_build_query($get).'">'.$get['page'].'</a></li>';
    }
    // Geen knop twee terug, dus ruimte voor extra vooruit
    if($page - 2 < 0){
      $get['page'] = $page+4;
      echo '    <li><a href="'.$pageLink.'?'.http_build_query($get).'">'.$get['page'].'</a></li>';
    }
  }
  // Volgende knop
  if($offset+$length < $totalCount){
    $get['page'] = $page+1;
    echo '    <li><a href="'.$pageLink.'?'.http_build_query($get).'"><span aria-hidden="true">&raquo;</span><span class="sr-only">Volgende</span></a></li>';
  }else{
    echo '    <li class="disabled"><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Volgende</span></a></li>';
  }
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
