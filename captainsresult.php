<?php
require_once('inc/config.php');

    //Initialize variables
    $inputName = validate($_GET['inputName']);
    $exact = validate($_GET['exact']);
    $inputStartDate = validate($_GET['inputStartDate']);
    $inputEndDate = validate($_GET['inputEndDate']);
    $departurePlace = validate($_GET['departurePlace']);
    $total = $inputName . $inputStartDate . $inputEndDate . $inputPlate . $departurePlace;
    
    // If all empty
    if ($total == ""){
        header("Location: table_captains.php");
    }

    $_loadGoogleMaps = true;
    beginPage('Paalgeld Europa - Search', true, 'Search through the database finding Names');
    
    echo '<p><a class="btn btn-default" href="captains.php" role="button">&laquo; Back</a></p>';

    $query = "SELECT fullNameCaptain, COUNT(*) AS arrivalCount, lat, lng, ports.portCode AS pCode, portName FROM paalgeldEur, ports WHERE paalgeldEur.portCode = ports.portCode";
    if($inputName != "" && $exact != "yes"){
      $query .= " AND fullNameCaptain like '%'.'$inputName'.'%'";
    }
    if($inputName != "" && $exact == "yes"){
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
    include_once('inc/module_pagination.php');

    $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
    $size = 25;
    $offset = $page * $size;
    $resCount = $_db->query($query);
    $totalCount = $resCount->num_rows;
    $pagination = pagination($page, $size, $totalCount);
    $queryBase = $query;
    $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
    $res = $_db->query($queryLimited);

    if ($res == null or $res->num_rows == 0){
        echo "<div class='alert alert-danger' role='alert'>No results found. Try again.</div>";
    }
    else {
        echo '<div class="row">';
        makeGoogleMapsQuery("SELECT SUM(arrivalCount) AS portSum, sub.* FROM (".$query.") AS sub GROUP BY pCode", 'portSum', 'Departures');
        echo '</div>';
        echo $pagination;
        echo '<table class="table table-hover">';
        echo '<tr><th>Captain</th><th>Arrivals</th></tr>';
        while($row = $res->fetch_array()){
            $captain = str_replace(' ', '_', $row['fullNameCaptain']);
            echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td>'.$row['arrivalCount'].'</td></tr>';
        }
        echo '</table>';
        echo $pagination;
        download_knop($queryBase);
    }
endPage();
?>