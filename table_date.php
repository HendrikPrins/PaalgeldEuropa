<?php
require('inc/config.php');
beginPage('Paalgeld Europa - Complete tables', true, 'The complete date table');

if(isset($_GET['year'])){
  // alle arrivals in bepaalde jaar
  $query = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND year(date) = '".$_db->real_escape_string($_GET['year'])."'";
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert">No arrivals with year <strong>'.$_GET['year'].'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>'; 
  }else{
	echo 'Arrivals in <a href="table_date.php?year='.$_GET['year'].'">'.$_GET['year'].'</a>';

    download_knop($query);
    
	echo '<table class="table table-hover">';
    echo '<tr><th>idEur</th><th>Date</th><th>Captain</th><th>portCode</th></tr>';
    while($row = $res->fetch_assoc()){
	  $year = substr($row['date'], 0, -6);	
	  $month = substr($row['date'], 5, -3);
	  $day = substr($row['date'], 8);
	  $captain = str_replace(' ', '_', $row['fullNameCaptain']);
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
	}
    echo '</table>';
  }
}elseif(isset($_GET['month'])){
  // alle arrivals in bepaalde maand
  $query = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND month(date) = '".$_db->real_escape_string($_GET['month'])."'";
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert">No arrivals with month <strong>'.$_GET['month'].'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>';
  }else{
	$dateObj   = DateTime::createFromFormat('!m', $_GET['month']);
    $monthName = $dateObj->format('F');
	echo 'Arrivals in <a href="table_date.php?month='.$_GET['month'].'">'.$monthName.'</a>&nbsp;(<a href="table_date.php?month='.$_GET['month'].'">'.$_GET['month'].'</a>)';
  
    download_knop($query);
	
	echo '<table class="table table-hover">';
    echo '<tr><th>idEur</th><th>Date</th><th>Captain</th><th>portCode</th></tr>';
    while($row = $res->fetch_assoc()){
	  $year = substr($row['date'], 0, -6);	
	  $month = substr($row['date'], 5, -3);
	  $day = substr($row['date'], 8);
	  $captain = str_replace(' ', '_', $row['fullNameCaptain']);
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
	}
    echo '</table>';
  } 
}elseif(isset($_GET['day'])){
  // alle arrivals op bepaalde dag
  $query = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND day(date) = '".$_db->real_escape_string($_GET['day'])."'";
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert">No arrivals with day <strong>'.$_GET['day'].'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>';
  }else{
	echo 'Arrivals in <a href="table_date.php?day='.$_GET['day'].'">'.$_GET['day'].'</a>';
  
    download_knop($query);
	
	echo '<table class="table table-hover">';
    echo '<tr><th>idEur</th><th>Date</th><th>Captain</th><th>portCode</th></tr>';
    while($row = $res->fetch_assoc()){
	  $year = substr($row['date'], 0, -6);	
	  $month = substr($row['date'], 5, -3);
	  $day = substr($row['date'], 8);
	  $captain = str_replace(' ', '_', $row['fullNameCaptain']);
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
	}
    echo '</table>';
  } 
}else{ 
  echo '<div class="row">';
  echo '<div class="col-md-3">';
  echo '<table class="table table-hover">';


  echo '<tr><th>Year</th></tr>';
  $query1 = "SELECT * FROM paalgeldEur GROUP BY year(date)";
  $query2 = "SELECT * FROM paalgeldEur GROUP BY month(date)";
  $query3 = "SELECT * FROM paalgeldEur GROUP BY day(date)";
  $res1 = $_db->query($query1);
  $res2 = $_db->query($query2);
  $res3 = $_db->query($query3);
  $days = array();
  $months = array();
  $years = array();
  while($row1 = $res1->fetch_assoc()){
    $years[] = substr($row1['date'], 0, -6);
  }
  while($row2 = $res2->fetch_assoc()){
    $month = substr($row2['date'], 5, -3);
    $dateObj   = DateTime::createFromFormat('!m', $month);
    $monthName = $dateObj->format('F');
    $months[] = array("number" => $month, "name" => $monthName);
  }
  while($row3 = $res3->fetch_assoc()){
	  $days[] = substr($row3['date'], 8);
  }
  for($i = 0;$i < max(array(count($years), count($months), count($days)));$i++){
    echo '<tr>';
    echo '<td>'.($i < count($years) ? '<a href="table_date.php?year='.$years[$i].'">'.$years[$i].'</a>' : '').'</td>';
    echo '</tr>';
  }
  echo '</table>';
  echo '</div>';
  echo '<div class="col-md-3">';
  echo '<table class="table table-hover">';
  echo '<tr><th>Month</th></tr>';
  $query1 = "SELECT * FROM paalgeldEur GROUP BY year(date)";
  $query2 = "SELECT * FROM paalgeldEur GROUP BY month(date)";
  $query3 = "SELECT * FROM paalgeldEur GROUP BY day(date)";
  $res1 = $_db->query($query1);
  $res2 = $_db->query($query2);
  $res3 = $_db->query($query3);
  $days = array();
  $months = array();
  $years = array();
  while($row1 = $res1->fetch_assoc()){
    $years[] = substr($row1['date'], 0, -6);
  }
  while($row2 = $res2->fetch_assoc()){
    $month = substr($row2['date'], 5, -3);
    $dateObj   = DateTime::createFromFormat('!m', $month);
    $monthName = $dateObj->format('F');
    $months[] = array("number" => $month, "name" => $monthName);
  }
  while($row3 = $res3->fetch_assoc()){
	  $days[] = substr($row3['date'], 8);
  }
  for($i = 0;$i < max(array(count($years), count($months), count($days)));$i++){
    echo '<tr>';
    echo '<td>'.($i < count($months) ? '<a href="table_date.php?month='.$months[$i]["number"].'">'.$months[$i]["name"].'</a>' : '').'</td>';
    echo '</tr>';
  }
  echo '</table>';
  echo '</div>';
  echo '<div class="col-md-3">';
  echo '<table class="table table-hover">';
  echo '<tr><th>Day</th></tr>';
  $query1 = "SELECT * FROM paalgeldEur GROUP BY year(date)";
  $query2 = "SELECT * FROM paalgeldEur GROUP BY month(date)";
  $query3 = "SELECT * FROM paalgeldEur GROUP BY day(date)";
  $res1 = $_db->query($query1);
  $res2 = $_db->query($query2);
  $res3 = $_db->query($query3);
  $days = array();
  $months = array();
  $years = array();
  while($row1 = $res1->fetch_assoc()){
    $years[] = substr($row1['date'], 0, -6);
  }
  while($row2 = $res2->fetch_assoc()){
    $month = substr($row2['date'], 5, -3);
    $dateObj   = DateTime::createFromFormat('!m', $month);
    $monthName = $dateObj->format('F');
    $months[] = array("number" => $month, "name" => $monthName);
  }
  while($row3 = $res3->fetch_assoc()){
	  $days[] = substr($row3['date'], 8);
  }
  for($i = 0;$i < max(array(count($years), count($months), count($days)));$i++){
    echo '<tr>';
    echo '<td>'.($i < count($days) ? '<a href="table_date.php?day='.$days[$i].'">'.$days[$i].'</a>' : '').'</td>';
    echo '</tr>';
  }
  echo '</table>';
  echo '</div>';
  echo '</div>';
}
endPage();
?>
