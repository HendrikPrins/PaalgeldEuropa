<?php
require_once('inc/config.php');

    //Initialize variables
    $inputName = $_GET['inputName'];
    $inputStartDate = $_GET['inputStartDate'];
    $inputEndDate = $_GET['inputEndDate'];
    $departurePlace = $_GET['departurePlace'];
    $total = $inputName . $inputStartDate . $inputEndDate . $inputPlate . $departurePlace;
    
    // If all empty
    if ($total == ""){
        header("Location: table_captains.php");
    }

    $_loadGoogleMaps = true;
    beginPage('Paalgeld Europa - Names', true, 'Research based on names');
    echo '<table class="table table-hover">';
    echo '<tr><th>Captain</th><th>Arrivals</th></tr>';
    $query = "SELECT fullNameCaptain, COUNT(*) AS arrivalCount, lat, lng, ports.portCode AS pCode, portName FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode";
    if($inputName != ""){
      $query .= " AND fullNameCaptain like '$inputName'";
    }
    if($inputStartDate != "" && $inputEndDate != ""){
       $query .= " AND year(date) BETWEEN '".$inputStartDate."' AND '".$inputEndDate."'";
    }elseif($inputStartDate != ""){
       $query .= " AND year(date) > '".$inputStartDate."'";
    }elseif($inputEndDate != ""){
       $query .= " AND year(date) < '".$inputEndDate."'";
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
    }
endPage();
?>
