<?php
require_once('inc/config.php');

    //Initialize variables
    $countryOne = $_GET['countryOne'];
    $countryTwo = $_GET['countryTwo'];
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

    $_loadGoogleMaps = true;
    beginPage('Paalgeld Europa - Places', true, 'Research based on places');
    echo '<table class="table table-hover">';
    echo '<tr><th>Year</th><th>Arrivals</th></tr>';
	// SELECT sum(taxGuilders) AS tax FROM `paalgeldEur`, `ports`, `cargo` WHERE paalgeldEur.idEur = cargo.idEur AND paalgeldEur.portCode = ports.portCode AND countryNow = 'Denmark' AND year(date) = '1742'
    $query = "SELECT ports.portCode COUNT(*) AS arrivalCount,ports.portCode AS pCode, portName FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode";
    if($countryOne != "" && $countryTwo != ""){
      $query .= " AND countryNow = '".$countryOne."' AND countryNow = '".$countryTwo."'";
    }
    /*if($inputStartDate != "" && $inputEndDate != ""){
       $query .= " AND date BETWEEN '".$inputStartDate."' AND '".$inputEndDate."'";
    }elseif($inputStartDate != ""){
       $query .= " AND date > '".$inputStartDate."'";
    }elseif($inputEndDate != ""){
       $query .= " AND date < '".$inputEndDate."'";
    }
    if($departurePlace != ""){
      $query .= " AND ports.portCode = '".$departurePlace."'";
    }
    $query .= " GROUP BY fullNameCaptain";
    include_once('inc/module_map.php');
    makeGoogleMapsQuery("SELECT SUM(arrivalCount) AS portSum, sub.* FROM (".$query.") AS sub GROUP BY pCode", 'portSum', 'pCode');
    $res = $_db->query($query);
    while($row = $res->fetch_array()){
        $captain = str_replace(' ', '_', $row['fullNameCaptain']);
        echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td>'.$row['arrivalCount'].'</td></tr>';
    */
	}
endPage();
?>
