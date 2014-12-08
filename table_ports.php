<?php
require('inc/config.php');
beginPage();

if(isset($_GET['area'])){
  // alle ports in bepaalde area
  $query = "SELECT * FROM ports, portAreas WHERE ports.areaCode = portAreas.areaCode AND portAreas.area = '".$_db->real_escape_string($_GET['area'])."'";
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning">Er zijn geen arrivals met Area code '.$_GET['area'].' gevonden.</div>';
  }else{
	echo 'Ports in <a href="table_ports.php?area='.$_GET['area'].'">'.$_GET['area'].'</a>';
  download_knop($query);
    echo '<table class="table table-hover">';
    echo '<tr><th>Port code</th><th>Port</th><th>Area</th><th>Country now</th></tr>';
    while($row = $res->fetch_assoc()){
      echo '<tr><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portCode'].'</a></td><td>'.$row['portName'].'</td><td><a href="table_ports.php?area='.$row['area'].'">'.$row['area'].'</a></td><td>'.$row['countriesNow'].'</td></tr>';
    }
    echo '</table>';
  }
}elseif(isset($_GET['portCode'])){
  $query = "SELECT *, Count(paalgeldEur.idEur) AS arrivals, (SELECT GROUP_CONCAT(cargo SEPARATOR ', ') AS cargoString FROM (SELECT cargo FROM cargo, paalgeldEur AS pe WHERE pe.portCode = '".$_db->real_escape_string($_GET['portCode'])."' AND pe.idEur = cargo.idEur GROUP BY cargo) AS sub) AS cargoString FROM ports, portAreas, paalgeldEur WHERE ports.areaCode = portAreas.areaCode AND ports.portCode = paalgeldEur.portCode AND ports.portCode = '".$_db->real_escape_string($_GET['portCode'])."'";
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
     echo '<div class="alert alert-warning">error '.$_db->error.'.</div>';
  }else{
    // details
    download_knop($query);
    echo '<table class="table">';
    $row = $res->fetch_assoc();
	echo '<tr><td>Port code</td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portCode'].'</a></td></tr>';
	echo '<tr><td>Port</td><td>'.$row['portName'].'</td></tr>';
	echo '<tr><td>Area</td><td><a href="table_ports.php?area='.$row['area'].'">'.$row['area'].'</a></td></tr>';
	echo '<tr><td>Country now</td><td>'.$row['countriesNow'].'</td></tr>';
	echo '<tr><td>Arrivals</td><td>'.$row['arrivals'].'</td></tr>';
	echo '<tr><td>Cargoes</td><td>'.$row['cargoString'].'</td></tr>';
	echo '</table>';


	// arrivals
  $query = "SELECT *, (SELECT COUNT(*) FROM cargo WHERE paalgeldEur.idEur = cargo.idEur) AS cargoCount FROM ports, paalgeldEur WHERE ports.portCode = paalgeldEur.portCode AND ports.portCode = '".$_db->real_escape_string($_GET['portCode'])."'";
	$res2 = $_db->query($query);
	if($res2 != null && $res2->num_rows > 0){
    download_knop($query);
	  echo '<b>Arrivals</b>';
	  echo '<table class="table table-hover">';
	  echo '<tr><th>arrival id</th><th>date</th><th>captain</th><th>cargo count</th></tr>';
	  while($row2 = $res2->fetch_assoc()){
	    $captain = str_replace(' ', '_', $row2['fullNameCaptain']);
	    echo '<tr><td><a href="table_arrivals.php?id='.$row2['idEur'].'">'.$row2['idEur'].'</a></td><td>'.$row2['date'].'</td><td><a href="table_captains.php?id='.$captain.'">'.$row2['fullNameCaptain'].'</a></td><td>'.$row2['cargoCount'].'</td></tr>';
	  }
	    echo '</table>';
	}

  }

}else{
  // tabel met alle ports
  $query = "SELECT * FROM ports, portAreas WHERE ports.areaCode = portAreas.areaCode ORDER BY portName";
  $res = $_db->query($query);
  if($res == null){
    echo 'DB Error: '.$_db->error;
  }
  download_knop($query);
  echo '<table class="table table-hover">';
  echo '<tr><th>Port code</th><th>Port</th><th>Area</th><th>Country now</th></tr>';
  while($row = $res->fetch_assoc()){
    echo '<tr><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portCode'].'</a></td><td>'.$row['portName'].'</td><td><a href="table_ports.php?area='.$row['area'].'">'.$row['area'].'</a></td><td>'.$row['countriesNow'].'</td></tr>';
  }
  echo '</table>';
}

endPage();
?>

