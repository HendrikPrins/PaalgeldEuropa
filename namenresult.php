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
        
    beginPage('Paalgeld Europa - Names', true, 'Research based on names');
    echo '<table class="table table-hover">';
    echo '<tr><th>Captain</th></tr>';
    $query = "SELECT distinct(fullNameCaptain) FROM paalgeldEur WHERE 1";
    if($inputName != ""){
      $query .= " AND fullNameCaptain like '$inputName'";
    }
    if($inputStartDate != "" && $inputEndDate != ""){
       $query .= " AND date BETWEEN '".$inputStartDate."' AND '".$inputEndDate."'";
    }elseif($inputStartDate != ""){
       $query .= " AND date > '".$inputStartDate."'";
    }elseif($inputEndDate != ""){
       $query .= " AND date < '".$inputEndDate."'";
    }
    if($departurePlace != ""){
      $query .= " AND portCode = '".$departurePlace."'";
    }
    echo $query;
    $res = $_db->query($query);
    while($row = $res->fetch_array()){
        $captain = str_replace(' ', '_', $row['fullNameCaptain']);
        echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td></tr>';
    }
endPage();
?>
