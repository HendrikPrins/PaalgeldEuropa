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
  echo '<table class="table table-hover">';
  echo '<tr><th>Year</th><th>Month</th><th>Day</th></tr>';
  $resDay = $_db->query("SELECT * FROM paalgeldEur GROUP BY day(date)");
  $resMonth = $_db->query("SELECT * FROM paalgeldEur GROUP BY month(date)");
  $resYear = $_db->query("SELECT * FROM paalgeldEur GROUP BY year(date)");
  echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingYear">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseYear" aria-expanded="true" aria-controls="collapseYear">
          Years <span style="font-size:12pt;" class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
        </a>
      </h4>
    </div>
    <div id="collapseYear" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingYear">
      <div class="panel-body">
      jaren
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingMonth">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseMonth" aria-expanded="false" aria-controls="collapseMonth">
          Months <span style="font-size:12pt;" class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
        </a>
      </h4>
    </div>
    <div id="collapseMonth" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingMonth">
      <div class="panel-body">
        maanden...
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingDays">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseDays" aria-expanded="false" aria-controls="collapseDays">
          Days <span style="font-size:12pt;" class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
        </a>
      </h4>
    </div>
    <div id="collapseDays" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDays">
      <div class="panel-body">
      dagen
      </div>
    </div>
  </div>
</div>';

}
endPage();
?>
