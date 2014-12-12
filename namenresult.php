<?php
require_once('inc/config.php');

    //Initialize variables
    $inputName = $_POST['inputName'];
    $inputStartDate = $_POST['inputStartDate'];
    $inputEndDate = $_POST['inputEndDate'];
    $departurePlace = $_POST['departurePlace'];
    $total = $inputName . $inputStartDate . $inputEndDate . $inputPlate . $departurePlace;
    
    // If all empty
    if ($total == ""){
        header("Location: table_captains.php");
    }
        
    beginPage('Paalgeld Europa - Names', true, 'Research based on names');
    
    // If only name input
    if ($inputStartDate = "" && $inputEndDate = "" && $departurePlace = ""){
        echo '<table class="table table-hover">';
        echo '<tr><th>'.sortableHead('Captain', 'fullNameCaptain').'</th></tr>';
        $query = "SELECT distinct(fullNameCaptain) FROM paalgeldEur WHERE fullNameCaptain like '$inputName';";
        $res = $_db->query($query);
          while($row = $res->fetch_array()){
              echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td></tr>';
      }
    }

    // If only date input
    if ($inputName = "" && $departurePlace = ""){
        echo '<table class="table table-hover">';
        echo '<tr><th>Captain</th></tr>';
        $query = "SELECT distinct(fullNameCaptain) FROM paalgeldEur WHERE date between '$inputStartDate' and '$inputEndDate';";
        $res = $_db->query($query);
          while($row = $res->fetch_array()){
              echo '<tr><td><a href="table_captains.php?id='.$captain.'">'.$row['fullNameCaptain'].'</a></td></tr>';
      }
    }
    
    


    

endPage();
?>
