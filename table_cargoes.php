<?php
require('inc/config.php');
beginPage();

if(isset($_GET['cargo'])){
  include_once('inc/module_tablesort.php');
  $queryBase = "SELECT * FROM cargo, paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND cargo.idEur = paalgeldEur.idEur AND cargo = '".$_db->real_escape_string($_GET['cargo'])."'";
  $queryBase .= queryOrderPart(array('paalgeldEur.idEur','date','fullNameCaptain','portName'), 'paalgeldEur.idEur');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(*) AS count FROM cargo, paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND cargo.idEur = paalgeldEur.idEur AND cargo = '".$_db->real_escape_string($_GET['cargo'])."'");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  $pagination = pagination($page, $size, $totalCount);
  echo 'Arrivals met cargo <a href="table_cargoes.php?cargo='.$_GET['cargo'].'">'.$_GET['cargo'].'</a><br>';
  echo $pagination;
  // alle arrivals met een bepaalde cargo
  //$query = "SELECT * FROM cargo, paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND cargo.idEur = paalgeldEur.idEur AND cargo = '".$_db->real_escape_string($_GET['cargo'])."'";
  $res = $_db->query($queryLimited);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning">Er zijn geen arrivels met cargo '.$_GET['cargo'].' gevonden. Foutmelding: '.$_db->error.'</div>';
  }else{
    download_knop($queryBase);

    echo '<table class="table table-hover">';
    echo '<tr><th>'.sortableHead('Arrival id', 'paalgeldEur.idEur').'</th><th>'.sortableHead('Date', 'date').'</th><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Port Of Origin', 'portName').'</th></tr>';
    while($row = $res->fetch_assoc()){
	    $captain = str_replace(' ', '_', $row['fullNameCaptain']);
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td>'.$row['date'].'</td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
    }
    echo '</table>';
  }
}else{
  // tabel met unieke cargo
  include_once('inc/module_tablesort.php');
  $queryBase = "SELECT cargo, COUNT(*) AS count FROM cargo GROUP BY cargo";
  $queryBase .= queryOrderPart(array('cargo','count'), 'count');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(DISTINCT cargo) AS count FROM cargo");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  download_knop($queryBase);
  $pagination = pagination($page, $size, $totalCount);
  echo $pagination;
  echo '<table class="table table-hover">';
  echo '<tr><th>'.sortableHead('Cargo', 'cargo').'</th><th>'.sortableHead('Count', 'count').'</th></tr>';
  while($row = $res->fetch_assoc()){
    echo '<tr><td><a href="table_cargoes.php?cargo='.$row['cargo'].'">'.$row['cargo'].'</a></td><td>'.$row['count'].'</td></tr>';
  }
  echo '</table>';
  echo $pagination;
}

endPage();
?>