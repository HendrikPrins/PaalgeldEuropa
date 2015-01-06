<?php
require('inc/config.php');
beginPage('Paalgeld Europa - Complete tables', true, 'The complete date table');

if(isset($_GET['year'])){
  // alle arrivals in bepaalde jaar
  include_once('inc/module_tablesort.php');
  $queryBase = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND year(date) = '".validate($_GET['year'])."'";
  $queryBase .= queryOrderPart(array('idEur','date','fullNameCaptain', 'portName'), 'date', 'asc');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(*) AS count FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND year(date) = '".validate($_GET['year'])."'");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert">No arrivals with year <strong>'.$_GET['year'].'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>'; 
  }else{
	echo 'Arrivals in <a href="table_date.php?year='.$_GET['year'].'">'.$_GET['year'].'</a>';

    download_knop($queryBase);

	echo '<table class="table table-hover">';
    echo '<tr><th>'.sortableHead('Arrival ID', 'idEur').'</th><th>'.sortableHead('Date', 'date').'</th><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Port name', 'portName').'</th></tr>';
    while($row = $res->fetch_assoc()){
	  $year = substr($row['date'], 0, -6);	
	  $month = substr($row['date'], 5, -3);
	  $day = substr($row['date'], 8);
	  $captain = rawurlencode($row['fullNameCaptain']);
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
	}
    echo '</table>';
    $pagination = pagination($page, $size, $totalCount);
    echo $pagination;
  }
}elseif(isset($_GET['month'])){
  // alle arrivals in bepaalde maand
  include_once('inc/module_tablesort.php');
  $queryBase = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND month(date) = '".validate($_GET['month'])."'";
  $queryBase .= queryOrderPart(array('idEur','date','fullNameCaptain', 'portName'), 'date', 'asc');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(*) AS count FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND month(date) = '".validate($_GET['month'])."'");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert">No arrivals with month <strong>'.$_GET['month'].'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>';
  }else{
	$dateObj   = DateTime::createFromFormat('!m', $_GET['month']);
    $monthName = $dateObj->format('F');
	echo 'Arrivals in <a href="table_date.php?month='.$_GET['month'].'">'.$monthName.'</a>&nbsp;(<a href="table_date.php?month='.$_GET['month'].'">'.$_GET['month'].'</a>)';
  
    download_knop($queryBase);
	
	echo '<table class="table table-hover">';
    echo '<tr><th>'.sortableHead('Arrival ID', 'idEur').'</th><th>'.sortableHead('Date', 'date').'</th><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Port name', 'portName').'</th></tr>';
    while($row = $res->fetch_assoc()){
	  $year = substr($row['date'], 0, -6);	
	  $month = substr($row['date'], 5, -3);
	  $day = substr($row['date'], 8);
	  $captain = rawurlencode($row['fullNameCaptain']);
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
	}
    echo '</table>';
    $pagination = pagination($page, $size, $totalCount);
    echo $pagination;
  } 
}elseif(isset($_GET['day'])){
  // alle arrivals op bepaalde dag
  include_once('inc/module_tablesort.php');
  $queryBase = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND day(date) = '".validate($_GET['day'])."'";
  $queryBase .= queryOrderPart(array('idEur','date','fullNameCaptain', 'portName'), 'date', 'asc');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(*) AS count FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND day(date) = '".validate($_GET['day'])."'");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert">No arrivals with day <strong>'.$_GET['day'].'</strong> found. <a class="alert-link" href="index.php">Go back to home</a></div>';
  }else{
	echo 'Arrivals in <a href="table_date.php?day='.$_GET['day'].'">'.$_GET['day'].'</a>';
  
    download_knop($queryBase);
	
	echo '<table class="table table-hover">';
    echo '<tr><th>'.sortableHead('Arrival ID', 'idEur').'</th><th>'.sortableHead('Date', 'date').'</th><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Port name', 'portName').'</th></tr>';
    while($row = $res->fetch_assoc()){
	  $year = substr($row['date'], 0, -6);	
	  $month = substr($row['date'], 5, -3);
	  $day = substr($row['date'], 8);
	  $captain = rawurlencode($row['fullNameCaptain']);
      echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
	}
    echo '</table>';
    $pagination = pagination($page, $size, $totalCount);
    echo $pagination;
  } 
}else{
  echo '<div class="row explan">
              <div class="col-md-12">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title">Explanation</h3>
                  </div>
                  <div class="panel-body">
                    This table gives the possibility to search by year, by month or by the day of a month. Searching by month gives a table with only this particular month in different years, searching by day gives a table with only this particular day in different months. Whether one searches by year, month or day, results in a table with dates of arrivals, captain names and ports. Clicking the name of a captain gives an overview of the cargoes this particular captain shipped, the dates of arrival in Amsterdam and port of departure of every single shipping. Clicking on the name of a port supplies information about the cargoes shipped from this port and the shippings from this port with captain name and arrival date. It also shows a chart with the shippings over time. 
                    </div>
              </div>
              </div>
              </div>';
  $queryYear = "SELECT YEAR(date) AS `year` FROM paalgeldEur GROUP BY year(date)";
  $resYear = $_db->query($queryYear);
  echo '<div class="row">';

  echo '<div class="col-md-6">';
  echo '<table class="table table-hover">';
  echo '<tr><th>Year</th></tr>';
  while($row = $resYear->fetch_assoc()){
    echo '<tr><td><a href="table_date.php?year='.$row['year'].'">'.$row['year'].'</a></td></tr>';
  }
  echo '</table>';
  echo '</div>';

  echo '<div class="col-md-6">';
  echo '<table class="table table-hover">';
  echo '<tr><th>Month</th></tr>';
  for($month = 1;$month <= 12;$month++){
    $dateObj   = DateTime::createFromFormat('!m', $month);
    $monthName = $dateObj->format('F');
    echo '<tr><td><a href="table_date.php?month='.$month.'">'.$monthName.'</a></td></tr>';
  }
  echo '</table>';
  echo '</div>';

  echo '</div>';
  echo '<div class="row">';

  echo '<div class="col-md-6">';
  echo '<table class="table table-hover">';
  echo '<tr><th>Day</th></tr>';
  for($day = 1;$day <= 16;$day++){
    echo '<tr><td><a href="table_date.php?day='.$day.'">'.$day.'</a></td></tr>';
  }
  echo '</table>';
  echo '</div>';
  echo '<div class="col-md-6">';
  echo '<table class="table table-hover">';
  echo '<tr><th>Day</th></tr>';
  for($day = 17;$day <= 31;$day++){
    echo '<tr><td><a href="table_date.php?day='.$day.'">'.$day.'</a></td></tr>';
  }
  echo '</table>';
  echo '</div>';

  echo '</div>';
}
endPage();
?>
