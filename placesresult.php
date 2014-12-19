<?php
require_once('inc/config.php');

//Initialize variables
$countryOne = urldecode($_GET['countryOne']);
$countryTwo = urldecode($_GET['countryTwo']);
$areaOne = $_GET['areaOne'];
$areaTwo = $_GET['areaTwo'];
$portOne = $_GET['portOne'];
$portTwo = $_GET['portTwo'];

$cargo = $_GET['cargo'];
$inputStartDate = $_GET['inputStartDate'];
$inputEndDate = $_GET['inputEndDate'];
		
$total = $countryOne . $countryTwo . $areaOne . $areaTwo . $portOne . $portTwo . $cargo . $inputStartDate . $inputEndDate;

// If all empty
if ($total == ""){
	header("Location: table_ports.php");
}

//$_loadGoogleMaps = true;
beginPage('Paalgeld Europa - Analyse', true, 'Analyse by comparing two places');

if($cargo != ""){
	echo 'Cargo <a href="table_cargoes.php?cargo='.$cargo.'">'.$cargo.'</a>';
}

echo '<table class="table table-hover">';

//Country
if($countryOne != "" && $countryTwo != ""){
    echo '<tr><th>Year</th><th>'.$countryOne.'</th><th>'.$countryTwo.'</th></tr>';
    $query = "SELECT year(date) AS year, sum(case when countryNow = '".$countryOne."' then taxGuilders end)*500 AS one, sum(case when countryNow = '".$countryTwo."' then taxGuilders end)*500 AS two FROM `paalgeldEur`, `ports`, `cargo` WHERE paalgeldEur.idEur = cargo.idEur AND paalgeldEur.portCode = ports.portCode";
}

//Area
if($areaOne != "" && $areaTwo != ""){
    echo '<tr><th>Year</th><th>'.$areaOne.'</th><th>'.$areaTwo.'</th></tr>';
    $query = "SELECT year(date) AS year, sum(case when portAreas.areaCode = '".$areaOne."' then taxGuilders end)*500 AS one, sum(case when portAreas.areaCode = '".$areaTwo."' then taxGuilders end)*500 AS two FROM `paalgeldEur`, `ports`, `cargo`, `portAreas` WHERE paalgeldEur.idEur = cargo.idEur AND paalgeldEur.portCode = ports.portCode AND ports.areaCode = portAreas.areaCode";
	
}

//Port
if($portOne != "" && $portTwo != ""){
    echo '<tr><th>Year</th><th>'.$portOne.'</th><th>'.$portTwo.'</th></tr>';
    $query = "SELECT year(date) AS year, sum(case when portCode = '".$portOne."' then taxGuilders end)*500 AS one, sum(case when portCode = '".$portTwo."' then taxGuilders end)*500 AS two FROM `paalgeldEur`, `cargo` WHERE paalgeldEur.idEur = cargo.idEur";
}
//Cargo
if($cargo != ""){
    $query .= " AND cargo = '".$cargo."'";
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
