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

    $page = isset($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page']*1 : 0;
    $size = 25;
    $offset = $page * $size;
    $pagination = pagination($page, $size, $totalCount);
    echo $pagination;
    $queryBase = "SELECT SUM(arrivalCount) AS portSum, sub.* FROM (".$query.") AS sub GROUP BY pCode";
    $queryLimited = $queryBase." LIMIT ".$offset.", ".$size;
    $res = $_db->query($queryLimited);

    if ($res == null or $res->num_rows == 0){
        echo "<div class='alert alert-danger' role='alert'>No results found. Try again.</div>";
    }
    else {
        makeGoogleMapsQuery($queryBase, 'portSum', 'pCode');

        echo '<table class="table table-hover">';
        echo '<tr><th>Captain</th><th>Arrivals</th></tr>';
        while($row = $res->fetch_array()){
            $captain = str_replace(' ', '_', $row['fullNameCaptain']);
            echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td><td>'.$row['arrivalCount'].'</td></tr>';
        }
        echo '</table>';
        echo $pagination;
    }
endPage();
?>