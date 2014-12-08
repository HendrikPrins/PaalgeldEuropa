<?php
require('inc/config.php');
beginPage();

if(isset($_GET['id'])){
  //
  $captain = str_replace('_', ' ', $_db->real_escape_string($_GET['id']));
  $query = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND fullNameCaptain = '".$captain."'";   
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
    echo 'Niets gevonden... div class=alert maken';
  }else{
    // details
  download_knop($query);
	echo '<table class="table">';
  $row = $res->fetch_assoc();
  $captain = str_replace(' ', '_', $row['fullNameCaptain']);
  echo '<tr><td>Full name</td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td></tr>';
  echo '<tr><td>First name</td><td>'.$row['firstNameCaptain'].'</td></tr>';
  echo '<tr><td>Last Name</td><td>'.$row['lastNameCaptain'].'</td></tr>';
  echo '</table>';
// de arrivals
  echo '<b>Arrivals</b>';
  echo '<table class="table table-hover">';
  echo '<tr><th>Arrival id</th><th>Date</th><th>First name</th><th>Last Name</th><th>Departure port</th></tr>';
  echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td>'.$row['date'].'</td><td>'.$row['firstNameCaptain'].'</td><td>'.$row['lastNameCaptain'].'</td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
  if($res->num_rows > 1){
    while($row = $res->fetch_assoc()){
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td>'.$row['date'].'</td><td>'.$row['firstNameCaptain'].'</td><td>'.$row['lastNameCaptain'].'</td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
    }
  }
  echo '</table>';
  }
 
}else{
  // Lijst van alle unieke captains
  $query = "SELECT *,COUNT(fullNameCaptain) AS count FROM paalgeldEur GROUP BY fullNameCaptain ORDER BY count DESC";
  $res = $_db->query($query);
  download_knop($query);
  echo '<table class="table table-hover">';
  echo '<tr><th>captain</th><th>arrivals</th></tr>';
  while($row = $res->fetch_assoc()){
    $captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td>'.$row['count'].'</td></tr>';
  }
  echo '</table>';
}
endPage();
?>

