<?php
require('inc/config.php');
beginPage();

if(isset($_GET['id'])){
  //
  $captain = str_replace('_', ' ', $_db->real_escape_string($_GET['id']));
  $query = "SELECT * FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode AND fullNameCaptain = '".$captain."'";   
  $res = $_db->query($query);
  if($res == null || $res->num_rows == 0){
    echo '<div class="alert alert-warning" role="alert"><strong>Error.</strong> No captain names with name <strong>'.$_GET['id'].'</strong> found. <a class="alert-link" href="#" onclick="history.go(-1)">Go Back</a><br>Error code: '.$_db->error.'</div>';
  }else{
    // details
    download_knop($query);
	echo '<table class="table">';
    $row = $res->fetch_assoc();
	$year = substr($row['date'], 0, -6);	
	$month = substr($row['date'], 5, -3);
	$day = substr($row['date'], 8);
    $captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td>Full name</td><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td></tr>';
    echo '<tr><td>First name</td><td>'.$row['firstNameCaptain'].'</td></tr>';
    echo '<tr><td>Last Name</td><td>'.$row['lastNameCaptain'].'</td></tr>';
    echo '</table>';
// de arrivals
    echo '<b>Arrivals</b>';
    echo '<table class="table table-hover">';
    echo '<tr><th>Arrival id</th><th>Date</th><th>First name</th><th>Last Name</th><th>Departure port</th></tr>';
    echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td>'.$row['firstNameCaptain'].'</td><td>'.$row['lastNameCaptain'].'</td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
    if($res->num_rows > 1){
      while($row = $res->fetch_assoc()){
	    $year = substr($row['date'], 0, -6);	
	    $month = substr($row['date'], 5, -3);
	    $day = substr($row['date'], 8);
        echo '<tr><td><a href="table_arrivals.php?id='.$row['idEur'].'">'.$row['idEur'].'</a></td><td><a href="table_date.php?year='.$year.'">'.$year.'</a>-<a href="table_date.php?month='.$month.'">'.$month.'</a>-<a href="table_date.php?day='.$day.'">'.$day.'</a></td><td>'.$row['firstNameCaptain'].'</td><td>'.$row['lastNameCaptain'].'</td><td><a href="table_ports.php?portCode='.$row['portCode'].'">'.$row['portName'].'</a></td></tr>';
      }
    }
  echo '</table>';
  }
 
}else{
  // Lijst van alle unieke captains
  include_once('inc/module_tablesort.php');
  $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
  $size = 25;
  $offset = $page * $size;
  include_once('inc/module_pagination.php');
  $resCount = $_db->query("SELECT COUNT(DISTINCT fullNameCaptain) AS count FROM paalgeldEur");
  $rowCount = $resCount->fetch_assoc();
  $totalCount = $rowCount['count'];
  $queryBase = "SELECT *, COUNT(fullNameCaptain) AS count FROM paalgeldEur GROUP BY fullNameCaptain";
  $queryBase .= queryOrderPart(array('fullNameCaptain','count'), 'count', 'desc');
  $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
  $res = $_db->query($queryLimited);
  download_knop($queryBase);
  $pagination = pagination($page, $size, $totalCount);
  echo $pagination;
  echo '<table class="table table-hover">';
  echo '<tr><th>'.sortableHead('Captain', 'fullNameCaptain').'</th><th>'.sortableHead('Arrivals', 'count').'</th></tr>';
  while($row = $res->fetch_assoc()){
    $captain = str_replace(' ', '_', $row['fullNameCaptain']);
    echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td>'.$row['count'].'</td></tr>';
  }
  echo '</table>';
  echo $pagination;
}
endPage();
?>

