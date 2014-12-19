<?php
require_once('inc/config.php');

//Initialize variables
$cargoOne = urldecode($_GET['cargoOne']);
$cargoTwo = urldecode($_GET['cargoTwo']);
$country = $_GET['country'];
$area = $_GET['area'];
$port = $_GET['port'];

$inputStartDate = $_GET['inputStartDate'];
$inputEndDate = $_GET['inputEndDate'];
	
$total = $cargoOne . $cargoTwo . $country . $area . $port . $inputStartDate . $inputEndDate;

// If all empty
if ($total == ""){
	header("Location: table_cargoes.php");
}

//$_loadGoogleMaps = true;
beginPage('Paalgeld Europa - Analyse', true, 'Analyse by comparing two cargoes');

if($country != ""){
	echo 'Country: '.$country.'';
}

if($area != ""){
	echo 'Area: '.$area.'';
}

if($port != ""){
	echo 'Port: '.$port.'';
}

echo '<table class="table table-hover">';


//Cargo
if($cargoOne != "" && $cargoTwo != ""){
    echo '<tr><th>Year</th><th>'.$cargoOne.'</th><th>'.$cargoTwo.'</th></tr>';
    $query = "SELECT year(date) AS year, sum(case when cargo = '".$cargoOne."' then taxGuilders end)*500 AS one, sum(case when cargo = '".$cargoTwo."' then taxGuilders end)*500 AS two FROM `paalgeldEur`, `ports`, `cargo`, `portAreas` WHERE paalgeldEur.idEur = cargo.idEur AND paalgeldEur.portCode = ports.portCode AND ports.areaCode = portAreas.areaCode";
}

//Country
if($country != ""){
    $query .= " AND ports.countryNow = '".$country."'";
}

//Area
if($area != ""){
    $query .= " AND portAreas.areaCode = '".$area."'";
}

//Port
if($port != ""){
    $query .= " AND ports.portCode = '".$port."'";
}


//Period
if($inputStartDate != "" && $inputEndDate != ""){
	$query .= " AND year(date) BETWEEN '".$inputStartDate."' AND '".$inputEndDate."'";
}elseif($inputStartDate != ""){
	$query .= " AND year(date) > '".$inputStartDate."'";
}elseif($inputEndDate != ""){
	$query .= " AND year(date) < '".$inputEndDate."'";
}


$query .= " GROUP BY year(date)";
$res = $_db->query($query);

if ($res == null or $res->num_rows == 0){
	echo "<div class='alert alert-danger' role='alert'>No results found. Try again.</div>";
}else{
	while($row = $res->fetch_assoc()){
		echo '<tr><td><a href="table_date.php?year='.$row['year'].'">'.$row['year'].'</a></td><td>'.$row['one'].'</td><td>'.$row['two'].'</td></tr>';
	}
}


endPage();
?>
